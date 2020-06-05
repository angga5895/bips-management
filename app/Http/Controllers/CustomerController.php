<?php

namespace App\Http\Controllers;

use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Dealer;
use App\Group;
use App\Customer;
use App\Sales;
use DataTables;

class CustomerController extends Controller
{
    public function customer()
    {
        $group_list = Customer::all();

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
                            WHERE cl_module.clm_slug = \'customer\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin/customer',
                [
                    'title' => 'Customer',
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

        $query = Dealer::where('dealer_id', $id)->update([
            'dealer_name' => $name,
            'address' => $address,
            'phone' => $phone,
            'mobilephone' => $mobile,
            'email' => $email,
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

    function registrasiDealer(){
        $id = $_GET['dealer_id'];
        $name = $_GET['dealer_name'];
        $address = $_GET['address'];
        $phone = $_GET['phone'];
        $mobile = $_GET['mobilephone'];
        $email = $_GET['email'];
        $query = Dealer::create([
            'dealer_id' => $id,
            'dealer_name' => $name,
            'address' => $address,
            'phone' => $phone,
            'mobilephone' => $mobile,
            'email' => $email,
            'user_id' => $id,
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
    public function getCustomer(request $request){
        $requestData = $request->all();
        $customerID = $requestData['search_param']['customerID'];
        $salesID = $requestData['search_param']['salesID'];

        $where_custID = "";
        $where_salesID = "";
        if ($customerID != ""){
            $where_custID = ' AND "lower"(custcode) LIKE \'%'.strtolower($customerID).'%\'';
        }
        if($salesID != ""){
            $where_salesID = ' AND "lower"(c.sales_id) LIKE \'%'.strtolower($salesID).'%\'';
        }

        $query = 'SELECT c.*,s.sales_name, c.custcode as csd FROM public.customer c
                  JOIN
                  sales s ON c.sales_id = s.sales_id WHERE c.custcode IS NOT NULL '.$where_custID.' '.$where_salesID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function getFilterCustomer(request $request){
        $requestData = $request->all();
        $type = $requestData['search_param']['type'];

        if($type == "sales"){
            $query = 'SELECT s.sales_id as code, s.sales_name as name FROM sales s';
        }else {
            $query = 'SELECT  c.custcode as csd, c.custcode as code, c.custname as name FROM public.customer c';
        }
            $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }

    public function getCustomerName(){
        $id = $_GET['id'];
        $type = $_GET['type'];
        if($type == "sales"){
            $group = Sales::select("sales_name as name")
                ->where("sales_id",$id)
                ->get();
        }else{
            $group = Customer::select("custname as name")
                ->where("custcode",$id)
                ->get();
        }
        return response()->json($group);
    }
    public function getCustomerDetail(Request $request){
        $requestData = $request->all();
        $id = $requestData['search_param']['id'];
        $data = Account::where("base_account_no",$id)->get();
        return DataTables::of($data)->make(true);
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
