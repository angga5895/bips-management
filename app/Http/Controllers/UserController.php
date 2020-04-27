<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\Dealer;
use App\DealerSales;
use App\Sales;
use App\User;
use App\User_bips;
use App\User_group;
use App\User_status;
use App\User_type;
use App\UserAccount;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use Mailjet\Resources;

class UserController extends Controller
{
    //
    public function user()
    {
        $usertype = User_type::orderBy('id','ASC')->get();
        $userstatus = User_status::orderBy('id','ASC')->get();

        $query = 'select count(*) FROM "group"';
        $sql = DB::select($query);
        $countgroup = '';
        foreach ($sql as $p){
            $countgroup = $p->count;
        }

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'user\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user', compact('usertype', 'userstatus', 'countgroup', 'clapp'), ['title' => 'User']);
        }
    }

    public function userEdit($id)
    {
        $usertype = User_type::orderBy('id','ASC')->get();
        $userstatus = User_status::orderBy('id','ASC')->get();
        $userbips = DB::select('SELECT * FROM users WHERE user_id = \''.$id.'\'');

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'user\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user-edit', compact('usertype', 'userstatus', 'userbips', 'clapp'), ['title' => 'Edit User']);
        }
    }

    public function userResetPassword($id)
    {
        $userbips = DB::select('SELECT * FROM users WHERE user_id = \''.$id.'\'');

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'user\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user-reset-password', compact('userbips', 'clapp'), ['title' => 'Reset Password User']);
        }
    }

    public function userResetPIN($id)
    {
        $userbips = DB::select('SELECT * FROM users WHERE user_id = \''.$id.'\'');

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'user\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user-reset-pin', compact('userbips', 'clapp'), ['title' => 'Reset PIN User']);
        }
    }

    public function uniqueUsername(){
        $username = User_bips::select("username")
            ->where("username",$_GET['username'])
            ->get();
        return response()->json($username);
    }

    public function getUsername(){
        $id = $_GET['id'];
        $username = User::select("user_name")
            ->where("user_id",$id)
            ->get();
        return response()->json($username);
    }

    public function getIdUser(){
        $userid = DB::select('SELECT last_value AS new_id FROM user_id_seq WHERE is_called');
        $clientID = 'SW'.rand(100,999);
        $salesID = '80'.rand(100,999);

        $userID = '';
        foreach ($userid as $p){
            $userID = $p->new_id;
        }

        if ($userID === '' || $userID === null){
            $userID = 1;
        } else {
            $userID = (int)$userID + 1;
        }

        return response()->json([
            'userID' => $userID,
            'clientID' => $clientID,
            'salesID' => $salesID,
        ]);
    }

    public function registrasiUser(){
        $user_id = $_GET['user_id'];
        $user_name = $_GET['user_name'];
        $email_address = $_GET['email_address'];
        $msidn = $_GET['msidn'];
        $hash_password = $_GET['hash_password'];
        $hash_pin = $_GET['hash_pin'];
        $user_type = $_GET['user_type'];
        $user_status = $_GET['user_status'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        try {
            $query = User::create([
                'user_id' => $user_id,
                'user_name' => $user_name,
                'email_address' => $email_address,
                'msidn' => $msidn,
                'hash_password' => $hash_password,
                'status' => $user_status,
                'last_login' => $current_time,
                'last_teriminalid' => null,
                'user_type' => $user_type,
                'hash_pin' => $hash_pin,
            ]);

            if ($query) {
                if ($user_type === 'C') {
                    $lowercustcode = DB::select('SELECT custcode FROM "customer" WHERE "lower"(user_id) = \''.strtolower($user_id).'\'');
                    foreach ($lowercustcode as $p){
                        $custcode = $p->custcode;
                    }

                    $countaccount = DB::select('SELECT count(*) FROM account WHERE account_no = \'' . $custcode . '\'');
                    foreach ($countaccount as $p) {
                        $isaccount = $p->count;
                    }

                    $statusaccount = '0';
                    if ($isaccount === 0 || $isaccount === '0') {
                        $sid = Customer::where('custcode', $custcode)->pluck('sid');
                        try {
                            Account::create([
                                'account_no' => $custcode,
                                'account_name' => $user_name,
                                'cif_no' => null,
                                'asset_code' => 'IDR',
                                'balance' => 0,
                                'balance_hold' => null,
                                'equiv_balance' => null,
                                'account_type' => $user_type,
                                'is_base' => 'T',
                                'compliance_id' => substr($sid, 7, 6),
                                'account_status' => $user_status,
                                'locked' => null,
                                'base_account_no' => $custcode,
                            ]);
                        } catch (QueryException $ex) {
                            if (User::where('user_id', $user_id)->delete()) {
                                $status = '01';
                                $user = $user_name;
                                $message = $ex->getMessage();
                            }
                            $statusaccount = '1';
                        }
                    }

                    if ($statusaccount === '0'){
                        $insertuseraccountcust = '0';
                        try{
                            UserAccount::create([
                                'user_id' => $user_id,
                                'account_no' => $custcode,
                                'access_flag' => 'T',
                            ]);
                        } catch (QueryException $exp){
                            if (Account::where('account_no', $custcode)->delete()) {
                                if (User::where('user_id', $user_id)->delete()) {
                                    $status = '01';
                                    $user = $user_name;
                                    $message = $exp->getMessage();

                                    $insertuseraccountcust = '1';
                                }
                            }
                        }

                        if ($insertuseraccountcust === '0'){
                            $insertuseraccountdealer = '0';
                            $exDealer = '';
                            $selectsalesid = DB::select('SELECT sales_id FROM "customer" WHERE custcode = \''.$custcode.'\'');
                            foreach ($selectsalesid as $psalesid){
                                $salesid = $psalesid -> sales_id;
                            }

                            $selectdealer = DB::select('SELECT * FROM dealer_sales WHERE sales_id = \''.$salesid.'\'');
                            foreach ($selectdealer as $psd){
                                $cekDealer = User::where('user_id', $psd->dealer_id)->get();
                                $countDealer = $cekDealer->count();
                                if ($countDealer > 0) {
                                    try {
                                        UserAccount::create([
                                            'user_id' => $psd->dealer_id,
                                            'account_no' => $custcode,
                                            'access_flag' => 'T',
                                        ]);
                                    } catch (QueryException $excep) {
                                        $insertuseraccountdealer = '1';
                                        $exDealer = $excep->getMessage();
                                    }
                                }
                            }

                            if ($insertuseraccountdealer === '1'){
                                if (UserAccount::where('user_id', $user_id)->delete()) {
                                    if (Account::where('account_no', $custcode)->delete()) {
                                        if (User::where('user_id', $user_id)->delete()) {
                                            $status = '01';
                                            $user = $user_name;
                                            $message = $exDealer;
                                        }
                                    }
                                }
                            } else {
                                $status = '00';
                                $user = $user_name;
                                $message = 'Success';
                            }
                        }
                    }
                }

                else if ($user_type === 'D') {
                    $selectdealer =  DB::select('SELECT dealer.* FROM dealer WHERE dealer.user_id = \''.$user_id.'\'');
                    foreach ($selectdealer as $pd){
                        $dealerid = $pd->dealer_id;
                    }

                    $insertuseraccountdealercust = 0;
                    $exDealerCust = '';

                    $selectcust = DB::select('SELECT customer.custcode, dealer_sales.* FROM customer JOIN user_account
                                ON "lower"(user_account.user_id) = "lower"(customer.user_id)
                                JOIN dealer_sales ON dealer_sales.sales_id = customer.sales_id
                                WHERE dealer_sales.dealer_id = \''.$dealerid.'\'');

                    foreach ($selectcust as $pc){
                        try{
                            UserAccount::create([
                                'user_id' => $user_id,
                                'account_no' => $pc->custcode,
                                'access_flag' => 'T',
                            ]);
                        } catch (QueryException $queryEx){
                            if (UserAccount::where('user_id', $user_id)->delete()) {
                                if (User::where('user_id', $user_id)->delete()) {
                                    $insertuseraccountdealercust = '1';
                                    $exDealerCust = $queryEx->getMessage();
                                }
                            }
                        }
                    }

                    if ($insertuseraccountdealercust === '1'){
                        $status = '01';
                        $user = $user_name;
                        $message = $exDealerCust;
                    } else {
                        $status = '00';
                        $user = $user_name;
                        $message = 'Success';
                    }
                }

                else if ($user_type === 'S') {
                    $selectsales = DB::select('SELECT sales.* FROM sales WHERE sales.user_id = \''.$user_id.'\'');
                    foreach ($selectsales as $ps){
                        $sales_id = $ps->sales_id;
                    }

                    $insertuseraccountsalescust = 0;
                    $exSalesCust = '';

                    $selectsalescust = DB::select('SELECT customer.custcode, sales.* FROM customer JOIN user_account
                            ON "lower"(user_account.user_id) = "lower"(customer.user_id)
                            JOIN sales ON sales.sales_id = customer.sales_id
                            WHERE sales.sales_id = \''.$sales_id.'\'');

                    foreach ($selectsalescust as $psc){
                        try{
                            UserAccount::create([
                                'user_id' => $user_id,
                                'account_no' => $psc->custcode,
                                'access_flag' => 'T',
                            ]);
                        } catch (QueryException $querySalesEx){
                            if (UserAccount::where('user_id', $user_id)->delete()) {
                                if (User::where('user_id', $user_id)->delete()) {
                                    $insertuseraccountsalescust = '1';
                                    $exSalesCust = $querySalesEx->getMessage();
                                }
                            }
                        }
                    }

                    if ($insertuseraccountsalescust === '1'){
                        $status = '01';
                        $user = $user_name;
                        $message = $exSalesCust;
                    } else {
                        $status = '00';
                        $user = $user_name;
                        $message = 'Success';
                    }
                }

                else {
                    $status = '00';
                    $user = $user_name;
                    $message = 'Success';
                }
            } else {
                $status = "01";
                $user = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $user = $user_name;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message
        ]);
    }

    public function updateUser(){
        $user_id = $_GET['user_id'];
        $user_name = $_GET['user_name'];
        $email_address = $_GET['email_address'];
        $msidn = $_GET['msidn'];
        $user_status = $_GET['user_status'];

        $updatestatus = '0';
        $exUpdate = '';
        try {
            User::where('user_id', $user_id)->update([
                'user_name' => $user_name,
                'email_address' => $email_address,
                'msidn' => $msidn,
                'status' => $user_status,
            ]);
        } catch (QueryException $ex){
            $updatestatus = '1';
            $exUpdate = $ex->getMessage();
        }

        if ($updatestatus === '1'){
            $status = '01';
            $user = $user_name;
            $message = $exUpdate;
        } else {
            $status = '00';
            $user = $user_name;
            $message = 'Success';
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message
        ]);
    }
    public function dataAccountRegistered(Request $request){
        $requestData = $request->all();

        $userID = $requestData['search_param']['userID'];

        $data = DB::select("select ROW_NUMBER() OVER (ORDER BY acc.account_no) 
                                      sequence_no, acc.* from public.account acc
                                    JOIN
                                    public.user_account uac
                                    ON acc.account_no = uac.account_no 
                                    WHERE uac.user_id = '$userID'");
        return DataTables::of($data)->make(true);
    }


    public function dataRegistrasi(Request $request){
        $requestData = $request->all();

        $userID = $requestData['search_param']['userID'];
        $userType = $requestData['search_param']['userType'];
        $userStatus = $requestData['search_param']['userStatus'];

        $where_userID = "";
        if ($userID != ""){
            $where_userID = ' AND ("users".user_id LIKE "lower"(\'%'.$userID.'%\') OR "users".user_id LIKE "upper"(\'%'.$userID.'%\')) ';
        }

        $where_userType = "";
        if ($userType != ""){
            $where_userType = ' AND "users".user_type = \''.$userType.'\' ';
        }

        $where_userStatus = "";
        if ($userStatus != ""){
            $where_userStatus = ' AND "users".status = \''.$userStatus.'\' ';
        }

        $query = 'SELECT "users".*, user_status."name" as userstatus, user_type."name" as usertype from "users"
                  JOIN user_status ON user_status."id" = "users".status
                  JOIN user_type ON user_type."id" = "users".user_type
                  WHERE users.user_id is NOT NULL
                  '.$where_userType.'
                  '.$where_userStatus.'
                  '.$where_userID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function getDetailUser(){
        $user_id = $_GET['user_id'];
        $selectUser = DB::select('SELECT user_type."name" AS type_name, user_status."name" AS status_name, users.* FROM users
                    JOIN user_type ON user_type."id" = users.user_type
                    JOIN user_status ON user_status."id" = users.status 
                    WHERE users.user_id = \''.$user_id.'\'');

        $user_id = '';
        $user_name = '';
        $email_address = '';
        $msidn = '';
        $status = '';
        $last_login = '';
        $last_teriminalid = '';
        $user_type = '';

        foreach ($selectUser as $p){
            $user_id = $p->user_id;
            $user_name = $p->user_name;
            $email_address = $p->email_address;
            $msidn = $p->msidn;
            $status = $p->status_name;
            $last_login = $p->last_login;
            $last_teriminalid = $p->last_teriminalid;
            $user_type = $p->type_name;
        }

        return response()->json([
            'user_id' => $user_id,
            'user_name' => $user_name,
            'email_address' => $email_address,
            'msidn' => $msidn,
            'status' => $status,
            'last_login' => $last_login,
            'last_teriminalid' => $last_teriminalid,
            'user_type' => $user_type
        ]);
    }

    public function dataClient(Request $request){
        $requestData = $request->all();

        $userType = $requestData['search_param']['userType'];

        if ($userType === "S"){
            $query = 'SELECT "sales".* FROM "sales" LEFT JOIN users
                      ON "lower"(users.user_id) = "lower"("sales".sales_id)
                      WHERE users.user_id is NULL';
        } else if ($userType === "D"){
            $query = 'SELECT "dealer".* FROM "dealer" LEFT JOIN users
                      ON "lower"(users.user_id) = "lower"("dealer".dealer_id)
                      WHERE users.user_id is NULL';
        } else if ($userType === "C"){
            $query = 'SELECT "customer".* FROM "customer" LEFT JOIN users
                      ON "lower"(users.user_id) = "lower"("customer".custcode)
                      WHERE users.user_id is NULL';
        }

        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function isprime($number){
        // 1 is not prime
        if ( $number == 1 ) {
            return false;
        }
        // 2 is the only even prime number
        if ( $number == 2 ) {
            return true;
        }
        // square root algorithm speeds up testing of bigger prime numbers
        $x = sqrt($number);
        $x = floor($x);
        for ( $i = 2 ; $i <= $x ; ++$i ) {
            if ( $number % $i == 0 ) {
                break;
            }
        }

        if( $x == $i-1 ) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxID(){
        $query = 'SELECT MAX("user".id) FROM "user"';
        $sqli = DB::select($query);
        $max = 0;
        foreach ($sqli as $p){
            $max = $p->max;
        }

        return $max;
    }

    public function resetPassword(){

        $userID =$_GET['userID'];
        $rowdata = $this->__getDataUser($userID);



        $newpassword = Hash::make($userID);
        $newpassword = substr($newpassword,8,12);

        try {
            User::where('user_id', $userID)->update([
                'hash_password' => $newpassword,
            ]);


        $name = explode(" ",$rowdata->user_name);
        $name = $name[0];
        $data = [
            'name'=>$name,
            'account'=>$rowdata->email_address,
            'newpassword'=>$newpassword,
        ];
        $body = [
            'FromEmail' => "zaky@vsi.co.id",
            'FromName' => "DX-TRADE",
            'Subject' => "New Password",
            'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
            'Html-part' => view('emailTemplate',$data)->render(),
            'Recipients' => [
                [
                    'Email' => "zakyymuh123@gmail.com"
                ]
            ],
            'Attachments' => [
                [
                    'Content-type' => "image/png",
                    'Filename' => "logo.png",
                    'content' => "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
wUxy3RpmMhRsMfYb+6HWDjbpl3noB5+3FUcl7NZ2kq6CLTXM90Gc/zQOCrZQqGrxcZdI7Mo9Fm3U
MNetYSazxllQsKWmY/8dImHsh6RhRdvkCYVb58Fd2WZGBds1oaCm+d6Pwu1+KNhC+Yu3Jf3c1fdp
H3FuJfXN9Z01jMLt/u3ssN0QCmraHywb+439kDTseIQne+ZPf3Q5ye2a+dKTmarIDXXP9YUk/Tjj
dlcTHAVbqI8v/ee3dpOs6Oee1s6OuoFQ0IBcn4ujEva9xrHDFmN/K8b+3kdec9+KUNBkjS7aJoo5
l3DmoR98Xk8YaFiuz8fHya52gmOHPdRz8dapFm+KOY9bz6hguyEUNCjX56Jwu9f+QMEWY387cr33
kdfcZz1D4zW+aJskR376j3R0I9tJeps/+CUrbn3kensnOJs/+CUmOFDfxdtckqV4kyhJ7kmypEBD
g/O9Hx8kulo+QkTT+4NlY/8o15MsGvtpi1YUbXcc+ek/WkpyZ0vbejWjYs2G256G5/lcRrvrT4rG
E5yt+gATHGjG4m0h7X2TyCuRtCnXF5PcLRKXdUd1Big0vT/oVmP/EWM/tEOrirZJ8syf/qP5qqNr
y0687SRLD/3gl5jI0LZct8h53F0P/eCXLAkDNG7xNpf27bq1w4Y25vp8Rm8SHRGNJ9jMqIgzEAqM
/cZ+aKLWFW13VAWdpTR7h8qZJIsP2VlHS7XwIc3TLWYWHnIcAjTa80Y7b5Yb3tetJ1n8qOIM7c3z
uXiT6GJnk/Q+qohDu8f+pSQnjP3QXK0t2ibJM0evUS+meUcmrGZUrF1zi0PyzHYejXJPRrvsLWag
PQu4XrWAa9JuvM0kSx99zX19LQzJ80ZHoyynvbtutzMq1q64G8DYD03X6qLtjmf+1B91qo6u7gf9
ryZZeuiHvmTg1oan5Pl8tcg50fBfdfTQ5oc8tAELuFov4CzY4NI5Ppd2fpDwnqpf2HIXgLEf2kDR
9iLP/KnHdt72atbZnUmyrEgDV5XnC2nmDpXNjB7amOQAFy/gFlOvYxNWk/Qt2OCqcryT0ZEJbXgg
3fvoa+7b0OpwVWN/r2b9wnqSZWM/PJWi7SU886f+qJdkIeWeG7WZUeGp/9APef0Z9pjjS6l/8Vax
FrjSAm4+o+LtQso8y387o48sLX/0NfetaTHYdY5308yzLVcz2nU30Mqwp7G/V13GfqgpRdsrqHbf
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
AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBCh
LQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACRE
aAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJ
EdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABA
QoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAA
kBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAA
ACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAA
AAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAA
AABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsA
AAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoC
AAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2
AAAAAAAJEdoCAAAAACREaAsAAAAAkBChLQAAAABAQoS2AAAAAAAJEdoCAAAAACREaAsAAAAAkJD/
fwATAfVkZOIzxgAAAABJRU5ErkJggg=="
                ]
            ]
        ];
        $response = Mailjet::post(Resources::$Email, ['body' => $body]);

        if($response->success()){
            $status = "00";
            $msg = null;

        }else{
            $status = "01";
            $msg = $response->getData();
        }
        } catch (QueryException $r){
            $status = '01';
            $msg = $r->getMessage();
        }

        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ]);
    }
    private function __getDataUser($id){
        return DB::select('SELECT * FROM users WHERE user_id = \''.$id.'\'')[0];

    }
}
