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

        $newpassword =  substr(md5($userID),rand(0,19),12);

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
            'type'=>'password'
        ];
        $body = [
            'FromEmail' => "zaky@vsi.co.id",
            'FromName' => "DX-TRADE",
            'Subject' => "New Password Reset",
            'Text-part' => "Dear ".$name.", Here is your new account password data account ".
                $rowdata->email_address.": ".$newpassword."",
            'Html-part' => view('emailTemplate',$data)->render(),
            'Recipients' => [
                [
                    'Email' => $rowdata->email_address,
                ]
            ],
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
    public function resetPin(){
        $userID =$_GET['userID'];
        $rowdata = $this->__getDataUser($userID);

        $newpassword =  substr(md5($userID),rand(0,23),6);

        try {
            User::where('user_id', $userID)->update([
                'hash_pin' => $newpassword,
            ]);


            $name = explode(" ",$rowdata->user_name);
            $name = $name[0];
            $data = [
                'name'=>$name,
                'account'=>$rowdata->email_address,
                'newpassword'=>$newpassword,
                'type'=>'pin',
            ];
            $body = [
                'FromEmail' => "zaky@vsi.co.id",
                'FromName' => "DX-TRADE",
                'Subject' => "New Pin Reset",
                'Text-part' => "Dear ".$name.", Here is your new account pin data account ".
                    $rowdata->email_address.": ".$newpassword."",
                'Html-part' => view('emailTemplate',$data)->render(),
                'Recipients' => [
                    [
                        'Email' => $rowdata->email_address,
                    ]
                ],
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
