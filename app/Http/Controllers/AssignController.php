<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        if ($countpermission === '0'){
            return view('permission');
        } else {
            return view('user-admin.assign', ['title' => 'Assign Group', 'countgroup' => $countgroup, 'clapp' => $clapp]);
        }
    }
}
