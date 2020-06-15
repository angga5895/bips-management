<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiskManagementController extends Controller
{
    //
    public function tradelimit(){
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
                            WHERE cl_module.clm_slug = \'tradelimit\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'riskmanagement\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'tradelimit\' ');
            return view('risk-management.tradelimit', compact('clapp', 'role_app', 'clmodule', 'clapps'), ['title' => 'Trade Limit']);
        }
    }

    public function getBECust(){
        $custcode = $_GET['custcode'];

        $json = array(
            'custcode' => strtoupper($custcode),
        );
        $hostBE = '/customer/info';
        $arr = backendCallGET($json,$hostBE);

        if ($arr == '01'){
            $status = '0';
            $data = [];
        } else {
            $status = '1';
            $data = $arr['data'];
        }

        $result = ([
            'status' => $status,
            'data' => $data
        ]);
        return response()->json($result);
    }
}
