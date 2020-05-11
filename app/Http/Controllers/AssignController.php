<?php

namespace App\Http\Controllers;

use App\GroupDealer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AssignController extends Controller
{
    //
    public function index()
    {
        $query = 'select count(*) FROM "group"';
        $sql = DB::select($query);
        $countgroup = '';
        foreach ($sql as $p){
            $countgroup = $p->count;
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
                            WHERE cl_module.clm_slug = \'assign\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.assign', ['title' => 'Dealer Group', 'countgroup' => $countgroup, 'clapp' => $clapp, 'role_app' => $role_app]);
        }
    }

    public function getListAO(Request $request){
        $query = 'SELECT "dealer".dealer_name, "dealer".dealer_id, "users".* FROM "users"
                  JOIN "dealer" ON "dealer".user_id = "users".user_id';
        $data = DB::select($query);

        return DataTables::of($data)->make(true);
    }

    public function getGroupUser(Request $request){
        $requestData = $request->all();
        $groupID = $requestData['search_param']['groupID'];

        if ($groupID === '' || $groupID === null){
            $groupID = '';
        }

        $query = 'SELECT 
                ROW_NUMBER() OVER (ORDER BY group_id)  sequence_no,
                dealer.*, group_dealer.group_id, dealer.dealer_id
                FROM "group_dealer" JOIN dealer
                ON dealer.dealer_id = group_dealer.dealer_id
                WHERE group_dealer.group_id = \''.$groupID.'\'';

//        $query = 'SELECT
//                ROW_NUMBER() OVER (ORDER BY group_id)  sequence_no,
//                "users".*, group_dealer.group_id, dealer.dealer_id
//                FROM "group_dealer" JOIN dealer
//                ON dealer.dealer_id = group_dealer.dealer_id
//                JOIN users ON users.user_id = dealer.dealer_id
//                WHERE users.user_type = \'D\' AND group_dealer.group_id = \''.$groupID.'\'';
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
                'message' => 'This dealer has registered in this group.',
            ]);
        } else{
            $updatestatus = '0';
            $exUpdate = '';
            try {
                GroupDealer::create([
                    'group_id' => $group_id,
                    'dealer_id' => $user,
                ]);
            } catch (QueryException $ex){
                $updatestatus = '1';
                $exUpdate = $ex->getMessage();
            }

            if ($updatestatus === '1'){
                $status = '01';
                $message = $exUpdate;
            } else {
                $status = '00';
                $message = 'Successfully added user to group.';
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }

    public function deleteUserGroup(){
        $id = $_GET['id'];
        $group_id = $_GET['group_id'];

        if(!$this->_find_user_group($id,$group_id)){
            return response()->json([
                'status' => '03',
                'message' => 'Delete failed, user unregistered in this group.'
            ]);
        }else{
            $updatestatus = '0';
            $exUpdate = '';
            try{
                GroupDealer::where([
                    'group_id'=>$group_id,
                    'dealer_id'=>$id,
                ])->delete();
            } catch (QueryException $ex){
                $updatestatus = '1';
                $exUpdate = $ex->getMessage();
            }

            if ($updatestatus === '1'){
                $status = '03';
                $message = $exUpdate;
            } else {
                $status = '00';
                $message = 'Successfully delete user from group.';
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }

    private function _find_user_group($id,$group_id){
        $match = [
            'group_id'=>$group_id,
            'dealer_id'=>$id,
        ];
        $result = GroupDealer::where($match)->get();
        if($result->count() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function deleteAllUserGroup(){
        $group_id = $_GET['group_id'];

        if(!$this->_find_user_group_all($group_id)){
            return response()->json([
                'status' => '03',
                'message' => 'Delete failed, members in this group is empty.'
            ]);
        }else{
            $updatestatus = '0';
            $exUpdate = '';
            try{
                GroupDealer::where([
                    'group_id'=>$group_id,
                ])->delete();
            } catch (QueryException $ex){
                $updatestatus = '1';
                $exUpdate = $ex->getMessage();
            }

            if ($updatestatus === '1'){
                $status = '03';
                $message = $exUpdate;
            } else {
                $status = '00';
                $message = 'Successfully delete all user from group.';
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }

    private function _find_user_group_all($group_id){
        $match = [
            'group_id'=>$group_id
        ];
        $result = GroupDealer::where($match)->get();
        if($result->count() > 0){
            return true;
        }else{
            return false;
        }
    }
}
