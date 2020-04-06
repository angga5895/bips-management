<?php

namespace App\Http\Controllers;

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

        $clapp = DB::select(' SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id WHERE cl_app.cla_shown = 1 ORDER BY cl_app.cla_order;');

        $role_app = Auth::user()->role_app;
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
            return view('user-admin.assign', ['title' => 'Assign Group', 'countgroup' => $countgroup, 'clapp' => $clapp]);
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
                "users".*, group_dealer.group_id, dealer.dealer_id
                FROM "group_dealer" JOIN dealer
                ON dealer.dealer_id = group_dealer.dealer_id
                JOIN users ON users.user_id = dealer.dealer_id
                WHERE users.user_type = \'D\' AND group_dealer.group_id = \''.$groupID.'\'';
        $data = DB::select($query);
        return DataTables::of($data)->make(true);
    }
}
