<?php

namespace App\Http\Controllers;

use App\DealerSales;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Dealer;
use App\Sales;
use App\Group;
use DataTables;

class DealerController extends Controller
{
    public function dealer()
    {
        $group_list = Dealer::all();

        $query = 'select count(*) FROM "dealer"';
        $sql = DB::select($query);
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
                            WHERE cl_module.clm_slug = \'dealer\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin/dealer',
                [
                    'title' => 'Dealer',
                    'group' => $group_list,
//                'newid'=>$this->get_prime(),
                    'countgroup' => $row,
                    'clapp' => $clapp,
                    'role_app' => $role_app,
                ]
            );
        }
    }

    public function dealerEdit()
    {
        $id = $_GET['id'];
        $dealer = Dealer::where('dealer_id',$id)->get()[0];
        return response()->json($dealer);
    }

    public function updateDealer(){
        $id = $_GET['dealer_id'];
        $name = $_GET['dealer_name'];
        $address = $_GET['address'];
        $phone = $_GET['phone'];
        $mobile = $_GET['mobile_phone'];
        $email = $_GET['email'];

        try{
            $query = Dealer::where('dealer_id', $id)->update([
                'dealer_name' => $name,
                'address' => $address,
                'phone' => $phone,
                'mobilephone' => $mobile,
                'email' => $email,
            ]);
            $status = "00";
            $group = $name;
            $err_msg = null;
        }catch (QueryException $ex){
            $status = "01";
            $group = "";
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

    function registrasiDealer(){
        $id = $_GET['dealer_id'];
        $name = $_GET['dealer_name'];
        $address = $_GET['address'];
        $phone = $_GET['phone'];
        $mobile = $_GET['mobilephone'];
        $email = $_GET['email'];
        try{
            $query = Dealer::create([
                'dealer_id' => $id,
                'dealer_name' => $name,
                'address' => $address,
                'phone' => $phone,
                'mobilephone' => $mobile,
                'email' => $email,
                'user_id' => $id,
            ]);
            $status = "00";
            $group = $name;
            $err_msg = null;
        }catch (QueryException $ex){
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

    public function getDealer(request $request){
        $requestData = $request->all();
        $dealerID = $requestData['search_param']['dealerId'];

        $where_groupID = "";
        if ($dealerID != ""){
            $where_groupID = ' WHERE "lower"(dealer_id) LIKE \'%'.strtolower($dealerID).'%\'';

        }

        $query = 'SELECT *,dealer.dealer_id as dlr from "dealer"
                  '.$where_groupID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function getIdDealer(){
        $id = $_GET['id'];
        $res = Dealer::where('dealer_id',$id)->count();
        if($res > 0){
            $status = "01";
        }else{
            $status = "00";
        }
        return response()->json([
            'status' => $status,
        ]);
    }
    public function getDealerName(){
        $id = $_GET['id'];
        $group = Dealer::select("dealer_name")
            ->where("dealer_id",$id)
            ->get();
        return response()->json($group);
    }
    public function dealerGetSales(){
        $id = $_GET['id'];
        $type = $_GET['type'];
        if($type == "01"){
            $rowData = DB::select("select *,a.sales_id as sls from sales a
                                        INNER JOIN
                                        (select * from dealer_sales b WHERE b.dealer_id = '$id') c
                                        ON a.sales_id = c.sales_id");
        }elseif($type == "02"){
            $rowData = DB::select("select *,a.sales_id as sls from sales a
                                        WHERE a.sales_id NOT IN
                                        (select sales_id from dealer_sales b WHERE b.dealer_id = '$id')");
        }else{
            $rowData = DB::select("select *,a.sales_id as sls from sales a
                                        LEFT JOIN
                                        (select * from dealer_sales b WHERE b.dealer_id = '$id') c
                                        ON a.sales_id = c.sales_id");
        }
        return DataTables::of($rowData)->make(true);
    }
    public function dealerGetSalesID(request $request){
        $requestData = $request->all();
        $groupID = $requestData['search_param']['dealerID'];

        if ($groupID === '' || $groupID === null){
            $groupID = '';
        }
        $rowData = DB::select("select *,a.sales_id as sls,ROW_NUMBER() OVER (ORDER BY a.sales_id) 
                                      sequence_no from sales a
                                        INNER JOIN
                                        (select * from dealer_sales b WHERE b.dealer_id = '$groupID') c
                                        ON a.sales_id = c.sales_id");
        return DataTables::of($rowData)->make(true);
    }

    public function dealerAssignAdd(){
        $dealer_id = $_GET['dealer_id'];
        $sales_id = $_GET['sales_id'];
        try{
            DB::insert("INSERT INTO dealer_sales values ('$dealer_id','$sales_id')");
            $status = "00";
            $group = null;
            $err_msg = null;
        }catch (QueryException $ex){
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
    public function dealerAssignRemove(){
        $dealer_id = $_GET['dealer_id'];
        $sales_id = $_GET['sales_id'];

        try{
            DealerSales::where([
                'dealer_id' => $dealer_id,
                'sales_id' => $sales_id,
            ])->delete();
            $status = "00";
            $group = null;
            $err_msg = null;
        }catch (QueryException $ex){
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
