<?php

namespace App\Http\Controllers;

use App\RoleApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        $roleApp = RoleApp::orderBy('id','ASC')->get();

        $role_app = Auth::user()->role_app;
        $clapp = DB::select('SELECT cl_permission_app.clp_role_app, cl_app.* FROM cl_app 
                                    JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id
                                    JOIN role_app ON cl_permission_app.clp_role_app = role_app.id
                                    WHERE cl_app.cla_shown = 1 
                                    AND cl_permission_app.clp_role_app = '.$role_app.'
                                    ORDER BY cl_app.cla_order;
                            ');

        $permission = DB::select('SELECT count(*) FROM cl_permission_app
                            JOIN cl_app ON cl_permission_app.clp_app = cl_app.cla_id
                            WHERE cl_app.cla_routename = \'dashboard\' AND cl_permission_app.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $idlogin = Auth::user()->id;
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'dashboard\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'dashboard\' ');
            return view('dashboards', compact('clapp', 'role_app', 'roleApp','idlogin','clapps','clmodule'), ['title' => 'Dashboard']);
        }
    }

    public function countUserActivityLogin(){
        $query = DB::connection('pgsql2')->select('SELECT DISTINCT
                    (SELECT COUNT(DISTINCT user_id) cnt_web FROM user_activity WHERE terminal=\'web\' AND activity=\'LOGIN\' 
                    AND status=\'SUCCESS\' AND timestamp::date=\''.date('Y-m-d').'\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_mobile FROM user_activity WHERE terminal=\'mobile\' AND activity=\'LOGIN\' 
                    AND status=\'SUCCESS\' AND timestamp::date=\''.date('Y-m-d').'\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_pc FROM user_activity WHERE terminal=\'pc\' AND activity=\'LOGIN\'
                    AND status=\'SUCCESS\' AND timestamp::date=\''.date('Y-m-d').'\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_web_mobile FROM user_activity WHERE terminal IN (\'web\',\'mobile\')
                    AND activity=\'LOGIN\' AND status=\'SUCCESS\' AND timestamp::date=\''.date('Y-m-d').'\'),
                    CONCAT (CAST(to_char(now(), \'dd Mon YYYY HH24:MI:ss\') as varchar(4000)),\' WIB\') as now_date,
                    now() as dt
                    FROM user_activity');
        return response()->json($query);
    }

}
