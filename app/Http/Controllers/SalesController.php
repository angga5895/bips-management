<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\Sales;
use App\Dealer;

use DataTables;

class SalesController extends Controller
{
    public function sales()
    {
        $group_list = Sales::all();
        $dealer_list = Dealer::all();

        $row = 0;
        foreach ($group_list as $p){
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
                            WHERE cl_module.clm_slug = \'sales\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0 || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin/sales',
                [
                    'title' => 'Sales',
                    'group' => $group_list,
//                'newid'=>$this->get_prime(),
                    'countgroup' => $row,
                    'dealer_list' => $dealer_list,
                    'clapp' => $clapp,
                    'role_app' => $role_app,
                ]
            );
        }
    }

    public function salesEdit()
    {
        $id = $_GET['id'];
        $sales = Sales::where('sales_id',$id)->get()[0];
        return response()->json($sales);
    }


    public function updateSales(){
        $id = $_GET['sales_id'];
        $name = $_GET['sales_name'];
        $address = $_GET['address'];
        $phone = $_GET['phone'];
        $mobile = $_GET['mobile_phone'];
        $email = $_GET['email'];
        try {
            $query = Sales::where('sales_id', $id)->update([
                'sales_name' => $name,
                'address' => $address,
                'phone' => $phone,
                'mobilephone' => $mobile,
                'email' => $email,
            ]);
            $status = "00";
            $group = $name;
            $err_msg = null;
        }catch(QueryException $ex){
            $status = "01";
            $group = null;
            $err_msg = $ex->getMessage();
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
        $groupID = (int)$this->get_prime();
        return response()->json([
            'groupID' => $groupID,
        ]);
    }

    function registrasiSales(){
        $id = $_GET['sales_id'];
        $name = $_GET['sales_name'];
        $address = $_GET['address'];
        $phone = $_GET['phone'];
        $mobile = $_GET['mobilephone'];
        $email = $_GET['email'];
        try{
            $query = Sales::create([
                'sales_id' => $id,
                'sales_name' => $name,
                'address' => $address,
                'phone' => $phone,
                'mobilephone' => $mobile,
                'email' => $email,
                'user_id'=> $id,
            ]);
            $status = "00";
            $group = $name;
            $err_msg = null;
        }catch(QueryException $ex){
            $status = '01';
            $group = null;
            $err_msg = $ex->getMessage();
        }

        return response()->json([
            'status' => $status,
            'group' => $group,
            'err_msg' => $err_msg,
        ]);
    }

    public function getSales(Request $request){
        $requestData = $request->all();
        $salesID = $requestData['search_param']['salesID'];

        $where_groupID = "";
        if ($salesID != ""){
            $where_groupID = ' WHERE "lower"(sales_id) LIKE \'%'.strtolower($salesID).'%\'';
        }

        $query = 'SELECT *,sales.sales_id as sls from "sales"
                  '.$where_groupID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }
    public function getSalesName(){
        $id = $_GET['id'];
        $group = Sales::select("sales_name")
            ->where("sales_id",$id)
            ->get();
        return response()->json($group);
    }

    public function getIdSales(){
        $id = $_GET['id'];
        $res = Sales::where('sales_id',$id)->count();
        if($res > 0){
            $status = "01";
        }else{
            $status = "00";
        }
        return response()->json([
            'status' => $status,
        ]);
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
