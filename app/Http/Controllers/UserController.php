<?php

namespace App\Http\Controllers;

use App\User;
use App\User_bips;
use App\User_group;
use App\User_status;
use App\User_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

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

        if ($countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user', compact('usertype', 'userstatus', 'countgroup', 'clapp'), ['title' => 'User']);
        }
    }

    public function userEdit($id)
    {
        $usertype = User_type::orderBy('id','ASC')->get();
        $userstatus = User_status::orderBy('id','ASC')->get();
        $userbips = User::where('user_id',$id)->get();

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

        if ($countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.user-edit', compact('usertype', 'userstatus', 'userbips', 'clapp'), ['title' => 'Edit User']);
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
        $username = $_GET['username'];
        $password = $_GET['password'];
        $user_type = $_GET['user_type'];
        $client_id = $_GET['client_id'];
        $user_status = $_GET['user_status'];
        $expire_date = $_GET['expire_date'];
        $group = $_GET['group'];

        $sales_id = '';
        if ($user_type === '1'){
            $sales_id = $_GET['client_id'];
        } else if ($user_type === '3'){
            $query = 'SELECT "customers".slscode FROM "customers"
                        WHERE "customers".custcode = \'' . $_GET['client_id'] . '\'';
            $data = DB::select($query);
            foreach ($data as $p){
                $sales_id = $p->slscode;
            }
        }

        if ($user_type ==='2' || $user_type === '4' || $user_type === '5') {
            $group = null;
        }

        $expire = explode("/", $expire_date);
        $exdate = $expire[2]."-".$expire[1]."-".$expire[0]." 00:00:00";

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $query = User_bips::create([
            'username' => $username,
            'password' => Hash::make($password),
            'user_type' => $user_type,
            'client_id' => $client_id,
            'user_status' => $user_status,
            'expire_date' => $exdate,
            'sales_id' => $sales_id,
            'group' => $group,
        ]);

        if ($query){
            if($group === null){
                $status = "00";
                $user = $username;
            } else {
                $cekgroup = $group;
                $arrgroup = [];

                if ($this->isprime($cekgroup) == true) {
                    array_push($arrgroup, $cekgroup);
                } else {
                    for ($i = 1; $i < $cekgroup; $i++) {
                        if ($cekgroup % $i == 0) {
                            $prime = $this->isprime($i);
                            if ($prime == true) {
                                array_push($arrgroup, $i);
                            }
                        }
                    }
                }

                $isCount = count($arrgroup);
                for ($itr = 0; $itr < $isCount; $itr++) {
                    $sql = User_group::create([
                        'user_id' => $this->getMaxID(),
                        'group_id' => $arrgroup[$itr],
                    ]);
                }

                if ($sql) {
                    $status = "00";
                    $user = $username;
                } else {
                    $status = "01";
                    $user = "";
                }
            }
        } else {
            $status = "01";
            $user = "";
        }

        return response()->json([
            'status' => $status,
            'user' => $user
        ]);
    }

    public function updateUser(){
        $id = $_GET['id'];
        $username = $_GET['username'];
        $user_type = $_GET['user_type'];
        $user_status = $_GET['user_status'];
        $expire_date = $_GET['expire_date'];
        $client_id = $_GET['client_id'];
        $hclient_id = $_GET['hclient_id'];
        $ggroup = $_GET['group'];
        $hgroup = $_GET['hgroup'];
        $sales_id = '';

        if ($client_id !== $hclient_id) {
            if ($user_type === '1') {
                $sales_id = $_GET['client_id'];
            } else if ($user_type === '3') {
                $query = 'SELECT "customers".slscode FROM "customers"
                            WHERE "customers".custcode = \'' . $_GET['client_id'] . '\'';
                $data = DB::select($query);
                foreach ($data as $p) {
                    $sales_id = $p->slscode;
                }
            }
        }

        if ($ggroup === ''){
            $ggroup = null;
        }
        if ($hgroup === ''){
            $hgroup = null;
        }
        if ($sales_id === ''){
            $sales_id = null;
        }

        $group = null;
        if ($user_type === '2'){
            if ($client_id === $hclient_id) {
                $group = $hgroup;
            }
        } else {
            $group = $ggroup;
        }

        $expire = explode("/", $expire_date);
        $exdate = $expire[2]."-".$expire[1]."-".$expire[0]." 00:00:00";

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $query = User_bips::where('id', $id)->update([
            'username' => $username,
            'user_type' => $user_type,
            'user_status' => $user_status,
            'expire_date' => $exdate,
            'group' => $group,
            'client_id' => $client_id,
            'sales_id' => $sales_id,
            'updated_at' => $current_time,
        ]);

        if ($query){
            if ($group === $hgroup){
                $status = "00";
                $user = $username;
                if ($hclient_id !== $client_id){
                    User_group::where('user_id',$id)->delete();
                }
            } else {
                User_group::where('user_id',$id)->delete();
                if ($group === null || $group === ''){
                    $status = "00";
                    $user = $username;
                } else{
                    $cekgroup = $group;
                    $arrgroup = [];

                    if($this->isprime($cekgroup) == true){
                        array_push($arrgroup,$cekgroup);
                    } else{
                        for($i = 1; $i < $cekgroup; $i++){
                            if($cekgroup % $i == 0){
                                $prime = $this->isprime($i);
                                if($prime==true) {
                                    array_push($arrgroup,$i);
                                }
                            }
                        }
                    }

                    $isCount = count($arrgroup);
                    for($itr = 0; $itr<$isCount; $itr++){
                        $sql = User_group::create([
                            'user_id' => $id,
                            'group_id' => $arrgroup[$itr],
                        ]);
                    }

                    if ($sql){
                        $status = "00";
                        $user = $username;
                    } else{
                        $status = "01";
                        $user = "Gagal Insert User Group Baru";
                    }
                }
            }
        } else {
            $status = "01";
            $user = "Gagal Update User";
        }

        return response()->json([
            'status' => $status,
            'user' => $user
        ]);
    }

    public function dataRegistrasi(Request $request){
        $requestData = $request->all();

        $userID = $requestData['search_param']['userID'];
        $where_userID = "";
        if ($userID != ""){
            $where_userID = 'WHERE "users".user_id LIKE "lower"(\'%'.$userID.'%\') OR "users".user_id LIKE "upper"(\'%'.$userID.'%\')';
        }

        $query = 'SELECT "users".*, user_status."name" as userstatus, user_type."name" as usertype from "users"
                  JOIN user_status ON user_status."id" = "users".status
                  JOIN user_type ON user_type."id" = "users".user_type
                  '.$where_userID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function dataClient(Request $request){
        $requestData = $request->all();

        $userType = $requestData['search_param']['userType'];

        if ($userType === "1"){
            $query = 'SELECT * FROM "sales"';
        } else if ($userType === "2"){
            $query = 'SELECT * FROM "dealer"';
        } else if ($userType === "3"){
            $query = 'SELECT sales.groupid, "customers".* FROM "customers"
                      LEFT JOIN "sales" ON "sales".slscode = "customers".slscode';
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

    public function getListAO(Request $request){
        $query = 'SELECT "dealer".dealer_name, "user".* FROM "user"
                  JOIN "dealer" ON "dealer".dealer_id = "user".client_id';
        $data = DB::select($query);

        return DataTables::of($data)->make(true);
    }

    public function addUserGroup(){
        $id = $_GET['id'];
        $group_id = $_GET['group_id'];
        // select
        $user = $id;
        if($this->_find_user_group($id,$group_id)){
            return response()->json([
                'status' => '01',
            ]);
        }else{
            $ug = new User_Group;
            $ug->user_id=$id;
            $ug->group_id = $group_id;
            $ug->save();
            if($ug->save()){
                $dataUser = User_bips::where('id',$id)->get();
                $oldgroup = $dataUser[0]['group'];
                if($oldgroup == 0){
                    $newgroup = $group_id;
                }else{
                    $newgroup = $oldgroup * $group_id;
                }
                
                User_bips::where('id',$id)->update(['group'=>$newgroup]);

                return response()->json([
                    'status' => '00',
                    // 'res' => $dataUser,
                ]);
            }
        }
    }
    public function deleteUserGroup(){
        $id = $_GET['id'];
        $group_id = $_GET['group_id'];
    
        if(!$this->_find_user_group($id,$group_id)){
            return response()->json([
                'status' => '03',
            ]);
        }else{
                $match = [
                    'user_id'=>$id,
                    'group_id'=>$group_id,
                ];
                User_group::where($match)->delete();
                $dataUser = User_bips::where('id',$id)->get();
                $oldgroup = $dataUser[0]['group'];
                $newgroup = $oldgroup / $group_id;
                
                User_bips::where('id',$id)->update(['group'=>$newgroup]);

                return response()->json([
                    'status' => '00',
                    // 'res' => $dataUser,
                ]);
        }
    }
    private function _find_user_group($id,$group_id){
        $match = [
            'user_id'=>$id,
            'group_id'=>$group_id,
        ];
        $result = User_Group::where($match)->get();
            if($result->count() > 0){
                return true;
            }else{
                return false;
            }
        }
}
