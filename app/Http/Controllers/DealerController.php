<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dealer;
use App\Group;
use DataTables;

class DealerController extends Controller
{
    public function dealer()
    {
        $group_list = Dealer::all();

        $query = 'select count(*) FROM "dealer"';
        $sql = DB::select($query);
        $row = '';
        foreach ($sql as $p){
            $row = $p->count;
        }

        return view('user-admin/dealer',
            [
                'title' => 'Dealer',
                'group'=>$group_list,
                'newid'=>$this->get_prime(),
                'countgroup' => $row
            ]
        );
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
        $num = Group::max("group_id") + 1;
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
        $name = $_GET['name'];
        $group_id = (int)$this->get_prime();
        $current_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $query = Group::create([
            'group_id' => $group_id,
            'name' => $name,
            'created_at' => $current_time,
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

    public function getDealer(){
        $dealer = Dealer::all();
//        return response()->json($dealer);
        return DataTables::of($dealer)->make(true);

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
