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
use DataTables;

class CustomerController extends Controller
{
    public function customer()
    {
        $group_list = Customer::all();

        foreach ($group_list as $p){
            $row = $p->count;
        }

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
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
            return view('user-admin/customer',
                [
                    'title' => 'Customer',
                    'group' => $group_list,
//                'newid'=>$this->get_prime(),
                    'countgroup' => $row,
                    'clapp' => $clapp,
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

        $where_groupID = "";
        if ($customerID != ""){
            $where_groupID = ' WHERE "lower"(custcode) LIKE \'%'.strtolower($customerID).'%\'';

        }

        $query = 'SELECT *,customer.custcode as csd from "customer"
                  '.$where_groupID;
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }
    public function getCustomerName(){
        $id = $_GET['id'];
        $group = Customer::select("custname")
            ->where("custcode",$id)
            ->get();
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
