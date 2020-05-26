<?php

namespace App\Http\Controllers;

use App\RoleApp;
use App\UserAdmin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class PrivilegeController extends Controller
{
    //
    public function useradmin()
    {
        $roleApp = RoleApp::orderBy('id','ASC')->get();

        $role_app = Auth::user()->role_app;
        $clapp = DB::select('SELECT cl_permission_app.clp_role_app, cl_app.* FROM cl_app 
                                    JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id
                                    JOIN role_app ON cl_permission_app.clp_role_app = role_app.id
                                    WHERE cl_app.cla_shown = 1 
                                    AND cl_permission_app.clp_role_app = '.$role_app.'
                                    ORDER BY cl_app.cla_order;
                            ');

        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'useradmin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('privilege-admin.useradmin', compact('clapp', 'role_app', 'roleApp'), ['title' => 'User Admin']);
        }
    }

    public function roleadmin()
    {
        $role_app = Auth::user()->role_app;
        $clapp = DB::select('SELECT cl_permission_app.clp_role_app, cl_app.* FROM cl_app 
                                    JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id
                                    JOIN role_app ON cl_permission_app.clp_role_app = role_app.id
                                    WHERE cl_app.cla_shown = 1 
                                    AND cl_permission_app.clp_role_app = '.$role_app.'
                                    ORDER BY cl_app.cla_order;
                            ');

        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'roleadmin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('privilege-admin.roleadmin', compact('clapp', 'role_app'), ['title' => 'User Admin']);
        }
    }

    public function dataAdmin(Request $request){
        $requestData = $request->all();

        $userID = $requestData['search_param']['userID'];
        $roleApp = $requestData['search_param']['roleApp'];

        $where_userID = "";
        if ($userID != ""){
            $where_userID = ' AND "user_admins".id = \''.$userID.'\' ';
        }

        $where_roleApp = "";
        if ($roleApp != ""){
            $where_roleApp = ' AND "user_admins".role_app = \''.$roleApp.'\' ';
        }

        $query = 'SELECT user_admins.*, role_app.name AS role_name FROM user_admins
                  JOIN role_app ON role_app.id = user_admins.role_app
                  WHERE user_admins.id is NOT NULL
                  '.$where_roleApp.'
                  '.$where_userID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function getUsernameAdmin(){
        $id = $_GET['id'];
        $username = UserAdmin::select("username")
            ->where("id",$id)
            ->get();
        return response()->json($username);
    }

    public function checkUsernameAdmin(){
        $user = $_GET['username'];
        $username = UserAdmin::select("username")
            ->where("username",$user)
            ->get();

        if (count($username) > 0){
            $result = [
              'status' => '01'
            ];
        } else {
            $result = [
                'status' => '00'
            ];
        }

        return response()->json($result);
    }

    public function registrasiUserAdmin(){
        $username = $_GET['username'];
        $password = $_GET['password'];
        $role_app = $_GET['role_app'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        try {
            $query = UserAdmin::create([
                'username' => $username,
                'password' => Hash::make($password),
                'role_app' => $role_app,
                'updated_at' => $current_time,
                'created_at' => $current_time,
                'remember_token' => '',
                'email_verified' => $current_time
            ]);

            if ($query) {
                $status = '00';
                $user = $username;
                $message = 'Success';
            } else {
                $status = "01";
                $user = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $user = $username;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message
        ]);
    }

    public function deleteUseradmin(){
        $id = $_GET['id'];
        $username = UserAdmin::where('id',$id)->get()[0];

        try{
            $query = UserAdmin::where('id',$id)->delete();

            if ($query) {
                $status = '00';
                $user = $username->username;
                $message = 'Success';
            } else {
                $status = "01";
                $user = "";
                $message = 'Error';
            }
        } catch(QueryException $ex){
            $status = "01";
            $user = null;
            $message = $ex->getMessage();
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message,
        ]);
    }

    public function updateUseradmin(){
        $id = $_GET['id'];
        $username = $_GET['username'];
        $password = $_GET['password'];
        $role_app = $_GET['role_app'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        $pass = DB::select('SELECT password FROM user_admins WHERE id=\''.$id.'\' ')[0];
        if ($pass->password !== $password){
            $userpass = Hash::make($password);
        } else {
            $userpass = $pass->password;
        }

        try {
            $query = UserAdmin::where('id', $id)->update([
                'username' => $username,
                'password' => $userpass,
                'role_app' => $role_app,
                'updated_at' => $current_time
            ]);

            if ($query) {
                $status = '00';
                $user = $username;
                $message = 'Success';
            } else {
                $status = "01";
                $user = "";
                $message = 'Error';
            }
        }catch(QueryException $ex){
            $status = "01";
            $user = null;
            $message = $ex->getMessage();
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message,
        ]);
    }

    public function useradminEdit()
    {
        $id = $_GET['id'];
        $user = UserAdmin::select('user_admins.*', 'role_app.name')
            ->join('role_app', 'role_app.id', '=', 'user_admins.role_app')
            ->where('user_admins.id',$id)->get()[0];

        $pass = DB::select('SELECT password FROM user_admins WHERE id=\''.$id.'\' ')[0];
        return response()->json([$user,$pass]);
    }
}
