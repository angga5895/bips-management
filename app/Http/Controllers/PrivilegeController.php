<?php

namespace App\Http\Controllers;

use App\ClPermissionApp;
use App\ClPermissionAppMod;
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
            $idlogin = Auth::user()->id;
            return view('privilege-admin.useradmin', compact('clapp', 'role_app', 'roleApp','idlogin'), ['title' => 'User Admin']);
        }
    }

    public function roleadmin()
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
                            WHERE cl_module.clm_slug = \'roleadmin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app
                                        ORDER BY cl_app.cla_order;
                            ');
            return view('privilege-admin.roleadmin', compact('clapp', 'role_app', 'roleApp', 'clapps'), ['title' => 'Role Admin']);
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

    public function dataRole(Request $request){
        $requestData = $request->all();

        $userID = $requestData['search_param']['userID'];

        $where_userID = "";
        if ($userID != ""){
            $where_userID = ' AND id = \''.$userID.'\' ';
        }

        $query = 'SELECT * FROM role_app
                  WHERE id is NOT NULL
                  '.$where_userID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function checkNameAdmin(){
        $user = $_GET['name'];
        $username = RoleApp::select("name")
            ->where("name",$user)
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

    public function roleadminEdit()
    {
        $id = $_GET['id'];
        $user = RoleApp::where('id',$id)->get()[0];

        return response()->json([$user]);
    }

    public function registrasiRoleAdmin(){
        $name = $_GET['name'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        try {
            $query = RoleApp::create([
                'name' => $name,
                'updated_at' => $current_time,
                'created_at' => $current_time
            ]);

            if ($query) {
                $status = '00';
                $user = $name;
                $message = 'Success';
            } else {
                $status = "01";
                $user = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $user = $name;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message
        ]);
    }

    public function updateRoleadmin(){
        $id = $_GET['id'];
        $name = $_GET['name'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        try {
            $query = RoleApp::where('id', $id)->update([
                'name' => $name,
                'updated_at' => $current_time
            ]);

            if ($query) {
                $status = '00';
                $user = $name;
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

    public function getRolenameAdmin(){
        $id = $_GET['id'];
        $username = RoleApp::select("name")
            ->where("id",$id)
            ->get();
        return response()->json($username);
    }

    public function checkclApp(){
        $role_app = $_GET['role_app'];

        $clapp = DB::select('SELECT cl_permission_app_mod.clp_role_app, cl_app_mod.*, cl_app.*, cl_module.* FROM cl_app_mod
                                LEFT JOIN cl_app ON cl_app.cla_id = cl_app_mod.clam_cla_id
                                LEFT JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                                LEFT JOIN cl_permission_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                                LEFT JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id
                                LEFT JOIN role_app ON role_app.id = cl_permission_app_mod.clp_role_app
                                WHERE cl_app_mod.clam_show = TRUE
                                AND cl_permission_app_mod.clp_role_app = '.$role_app.'
                                AND cl_permission_app.clp_role_app = '.$role_app.' 
                                ORDER BY cl_app_mod.id;');
        return response()->json($clapp);
    }

    public function updateRoleadminPrivilege(){
        $name = $_GET['name'];
        $role_app = $_GET['role_app'];
        $clapp = $_GET['clapp'];
        $clappmod = $_GET['clappmod'];

        $cl_app = ClPermissionApp::where('clp_role_app',$role_app)->get();
        $cl_app_mod = ClPermissionAppMod::where('clp_role_app',$role_app)->get();

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        if ($clapp === "0" || $clappmod === "0"){
            try {
                if (count($cl_app) > 0){
                    try{
                        $delclapp = ClPermissionApp::where('clp_role_app',$role_app)->delete();

                        if ($delclapp){
                            if (count($cl_app_mod) > 0){
                                try{
                                    $delclappmod = ClPermissionAppMod::where('clp_role_app',$role_app)->delete();

                                    if ($delclappmod){
                                        try{
                                            $q = RoleApp::where('id', $role_app)->update([
                                                'updated_at' => $current_time
                                            ]);

                                            if ($q){
                                                $status = '00';
                                                $user = $name;
                                                $message = 'Success';
                                            } else {
                                                $status = "01";
                                                $user = "";
                                                $message = 'Error';
                                            }
                                        } catch (QueryException $exupd){
                                            $status = "01";
                                            $user = "";
                                            $message = $exupd->getMessage();
                                        }
                                    } else {
                                        $status = "01";
                                        $user = "";
                                        $message = 'Error';
                                    }
                                } catch (QueryException $exclappmod){
                                    $status = "01";
                                    $user = "";
                                    $message = $exclappmod->getMessage();
                                }
                            }
                        } else {
                            $status = "01";
                            $user = "";
                            $message = 'Error';
                        }
                    } catch (QueryException $exclapp){
                        $status = "01";
                        $user = "";
                        $message = $exclapp->getMessage();
                    }
                } else {
                    try{
                        $qqq = RoleApp::where('id', $role_app)->update([
                            'updated_at' => $current_time
                        ]);

                        if ($qqq){
                            $status = '00';
                            $user = $name;
                            $message = 'Success';
                        } else {
                            $status = "01";
                            $user = "";
                            $message = 'Error';
                        }
                    } catch (QueryException $exupddd){
                        $status = "01";
                        $user = "";
                        $message = $exupddd->getMessage();
                    }
                }
            } catch(QueryException $ex){
                $status = "01";
                $user = null;
                $message = $ex->getMessage();
            }
        } else {
            try {
                if (count($cl_app) > 0){
                    try{
                        $delclapp = ClPermissionApp::where('clp_role_app',$role_app)->delete();

                        if ($delclapp){
                            $execclapp = 1;
                        } else {
                            $execclapp = 0;
                        }
                    } catch (QueryException $exclapp){
                        $exclapp->getMessage();
                        $execclapp = 0;
                    }

                    if ($execclapp === 1){
                        foreach ($clapp as $p){
                            $query = ClPermissionApp::create([
                                'clp_role_app' => $role_app,
                                'clp_app' => $p
                            ]);
                        }
                    }
                } else {
                    foreach ($clapp as $p){
                        $query = ClPermissionApp::create([
                            'clp_role_app' => $role_app,
                            'clp_app' => $p
                        ]);
                    }
                }

                if ($query) {
                    if (count($cl_app_mod) > 0){
                        try{
                            $delclappmod = ClPermissionAppMod::where('clp_role_app',$role_app)->delete();

                            if ($delclappmod){
                                $execclappmod = 1;
                            } else {
                                $execclappmod = 0;
                            }
                        } catch (QueryException $exclappmod){
                            $exclappmod->getMessage();
                            $execclappmod = 0;
                        }

                        if ($execclappmod === 1){
                            foreach ($clappmod as $r){
                                $querys = ClPermissionAppMod::create([
                                    'clp_role_app' => $role_app,
                                    'clp_app_mod' => $r
                                ]);
                            }
                        }
                    } else {
                        foreach ($clappmod as $r){
                            $querys = ClPermissionAppMod::create([
                                'clp_role_app' => $role_app,
                                'clp_app_mod' => $r
                            ]);
                        }
                    }

                    if ($querys){
                        try{
                            $qq = RoleApp::where('id', $role_app)->update([
                                'updated_at' => $current_time
                            ]);

                            if ($qq){
                                $status = '00';
                                $user = $name;
                                $message = 'Success';
                            } else {
                                $status = "01";
                                $user = "";
                                $message = 'Error';
                            }
                        } catch (QueryException $exupds){
                            $status = "01";
                            $user = "";
                            $message = $exupds->getMessage();
                        }
                    } else {
                        $status = "01";
                        $user = "";
                        $message = 'Error';
                    }
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
        }

        return response()->json([
            'status' => $status,
            'user' => $user,
            'message' => $message,
        ]);
    }

}