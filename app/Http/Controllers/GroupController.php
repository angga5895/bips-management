<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $clapp = DB::select(' SELECT cl_app_mod.*, cl_app.*, cl_module.* FROM cl_app
                                LEFT JOIN cl_app_mod ON cl_app.cla_id = cl_app_mod.clam_cla_id
                                LEFT JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                                JOIN cl_permission_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                                ORDER BY cl_app.cla_order;');

        $cl_app = DB::select('SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id ORDER BY cl_app.cla_order;');

        $permission = DB::select('SELECT count(*) FROM cl_permission_app_mod 
                            JOIN cl_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_module.clm_slug = \'group\'');

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin/group',
                [
                    'title' => 'Group',
                    'group' => $group_list,
                    'newid' => $this->get_prime(),
                    'countgroup' => $row,
                    'clapp' => $clapp,
                    'cl_app' => $cl_app
                ]
            );
        }
    }

    public function groupEdit($id)
    {
        $group = Group::where('group_id',$id)->get();
        $query = 'select count(*) FROM "group"';
        $sql = DB::select($query);
        $countgroup = '';
        foreach ($sql as $p){
            $countgroup = $p->count;
        }

        return view('user-admin.group-edit', compact('group','countgroup'), ['title' => 'Edit Group']);
    }

    public function updateGroup(){
        $id = $_GET['group_id'];
        $name = $_GET['name'];

        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $query = Group::where('group_id', $id)->update([
            'name' => $name,
            'updated_at' => $current_time,
        ]);

        if ($query){
            $status = "00";
            $group = $name;
        } else {
            $status = "01";
            $group = "";
        }

        return response()->json([
            'status' => $status,
            'group' => $group
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
        $groupID = (int)$this->get_prime();
        return response()->json([
            'groupID' => $groupID,
        ]);
    }

    function registrasiGroup(){
        $group_name = $_GET['group_name'];
        $group_id = $_GET['group_id'];
        $head_name = $_GET['head_name'];
        $head_id = $_GET['head_id'];
        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $query = Group::create([
            'group_id' => $group_id,
            'name' => $group_name,
            'head_id'=>$head_id,
            'head_name'=>$head_name,
            'created_at' => $current_time,
            'updated_at' => $current_time,
        ]);

        if ($query){
            $status = "00";
            $group = $group_name;
        } else {
            $status = "01";
            $group = "";
        }

        return response()->json([
            'status' => $status,
            'group' => $group
        ]);
    }

    public function getGroup(){
        $id = $_GET['id'];
        $group = Group::select("name")
            ->where("group_id",$id)
            ->get();
        return response()->json($group);
    }

    public function getGroupUser(Request $request){
        $requestData = $request->all();
        $groupID = $requestData['search_param']['groupID'];

        if ($groupID === '' || $groupID === null){
            $groupID = 0;
        }

        $query = 'SELECT 
                    ROW_NUMBER() OVER (ORDER BY group_id)  sequence_no,
                    "view_user_group_dealer".* 
                  FROM "view_user_group_dealer" 
                  WHERE "group_id" ='.$groupID;    
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function dataGroup(Request $request){
        $requestData = $request->all();

        $groupID = $requestData['search_param']['groupID'];
        $where_groupID = "";
        if ($groupID != ""){
            $where_groupID = ' WHERE "group".group_id = '.$groupID;
        }

        $query = 'SELECT * from "group"
                  '.$where_groupID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

}
