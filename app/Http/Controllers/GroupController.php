<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Group;
use DataTables;

class GroupController extends Controller
{
    public function group()
    {
        $group_list = Group::all();

        $query = 'select count(*) FROM "group"';
        $sql = DB::select($query);
        $row = '';
        foreach ($sql as $p){
            $row = $p->count;
        }

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
                            WHERE cl_module.clm_slug = \'group\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'masterdata\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'group\' ');
            return view('user-admin/group',
                [
                    'title' => 'Group',
                    'group' => $group_list,
                    'newid' => $this->get_prime(),
                    'countgroup' => $row,
                    'clapp' => $clapp,
                    'role_app' => $role_app,
                    'clapps' => $clapps,
                    'clmodule' => $clmodule
                ]
            );
        }
    }

    public function groupEdit()
    {
        $id = $_GET['id'];
        $group = Group::where('group_id',$id)->get()[0];
        return response()->json($group);
    }

    public function updateGroup(){
        $id = $_GET['group_id'];
        $name = $_GET['name'];
        $head_id = $_GET['head_id'];
        $head_name = $_GET['head_name'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();

        $updatestatus = '0';
        $exUpdate = '';
        try {

            $query = Group::where('group_id', $id)->update([
                'name' => $name,
                'head_name' => $head_name,
                'head_id' => $head_id,
                'updated_at' => $current_time,
            ]);
            $err_msg = null;
            $group = $name;
            $status = "00";
        }catch (QueryException $ex){
            $updatestatus = '1';
            $err_msg = $ex->getMessage();
            $group = null;
            $status = "01";
        }

        return response()->json([
            'status' => $status,
            'group' => $group,
            'err_msg' => $err_msg,
        ]);
    }

    public function store(Request $request){
        echo "ok";
    }

    public function get_prime(){
        $count = 0;
        if(Group::max("group_id") < 1){
            $num = 0;
        }else{
            $num = Group::max("group_id") + 1;
        }
        if($num == 1){
            $num = 2;
        } 
        while ($count < 1 )  
        {  
        $div_count=0;  
        for ( $i=1; $i<=$num; $i++)  
        {  
        if (($num%$i)==0)  
        {  
        $div_count++;  
        }  
        }  
        if ($div_count<3)  
        {  
        return $num;  
        $count=$count+1;  
        }  
        $num=$num+1;  
        }     
    }

    public function getIdGroup(){
        $id = $_GET['id'];
        $res = Group::where('group_id',$id)->count();
        if($res > 0){
            $status = "01";
        }else{
            $status = "00";
        }
        return response()->json([
            'status' => $status,
        ]);
    }

    function registrasiGroup(){
        $group_name = $_GET['group_name'];
        $group_id = $_GET['group_id'];
        $head_name = $_GET['head_name'];
        $head_id = $_GET['head_id'];
        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        try {
            $query = Group::create([
                'group_id' => $group_id,
                'name' => $group_name,
                'head_id' => $head_id,
                'head_name' => $head_name,
                'created_at' => $current_time,
                'updated_at' => $current_time,
            ]);
            $status = '00';
            $msg = null;
            $group = $group_name;
        }
        catch (QueryException $ex){
            $status = '01';
            $msg = $ex->getMessage();
            $group = "";
        }

        return response()->json([
            'status' => $status,
            'group' => $group,
            'err_msg' => $msg,
        ]);
    }

    public function getGroup(){
        $id = $_GET['id'];
        $group = DB::select('SELECT "group".* FROM "group" WHERE "lower"("group".group_id) = \''.strtolower($id).'\'');
        return response()->json($group);
    }

    public function dataGroup(Request $request){
        $requestData = $request->all();

        $groupID = $requestData['search_param']['groupID'];
        $where_groupID = "";
        if ($groupID != ""){
            $where_groupID = ' WHERE "lower"("group".group_id) LIKE \'%'.strtolower($groupID).'%\'';
        }

        $query = 'SELECT * from "group"
                  '.$where_groupID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

}
