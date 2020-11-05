<?php

namespace App\Http\Controllers;

use App\RoleApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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

    public function dashboardfull()
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
                            WHERE cl_app.cla_routename = \'dashboardfull\' AND cl_permission_app.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $idlogin = Auth::user()->id;
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'dashboardfull\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'dashboardfull\' ');
            $fullscreendashboard=1;
            return view('dashboards-full', compact('clapp', 'role_app', 'roleApp','idlogin','clapps','clmodule','fullscreendashboard'), ['title' => 'Dashboard']);
        }
    }

    public function countUserActivityLogin(){
        //date('Y-m-d')
        $query = DB::connection('pgsql2')->select('SELECT DISTINCT
                    (SELECT COUNT(DISTINCT user_id) cnt_web FROM user_activity WHERE terminal=\'web\' AND activity=\'LOGIN\' 
                    AND status=\'SUCCESS\' AND timestamp::date=\'2020-10-12\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_mobile FROM user_activity WHERE terminal=\'mobile\' AND activity=\'LOGIN\' 
                    AND status=\'SUCCESS\' AND timestamp::date=\'2020-10-12\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_pc FROM user_activity WHERE terminal=\'pc\' AND activity=\'LOGIN\'
                    AND status=\'SUCCESS\' AND timestamp::date=\'2020-10-12\'),
                    (SELECT COUNT(DISTINCT user_id) cnt_web_mobile FROM user_activity WHERE terminal IN (\'web\',\'mobile\')
                    AND activity=\'LOGIN\' AND status=\'SUCCESS\' AND timestamp::date=\'2020-10-12\'),
                    CONCAT (CAST(to_char(now(), \'dd Mon YYYY HH24:MI:ss\') as varchar(4000)),\' WIB\') as now_date,
                    now() as dt
                    FROM user_activity');

        $query2 = DB::connection('pgsql2')->select('SELECT DISTINCT (Select sum(trade_value) sum_web_trade from v_trades WHERE source = \'Web\'),
                    (Select sum(trade_value) sum_mobile_trade from v_trades WHERE source = \'Mobile\'),
                    (Select sum(trade_value) sum_dealer_trade from v_trades WHERE source = \'Dealer\'),
                    (Select sum(trade_value) sum_trade_all from v_trades) FROM v_trades');

        $query3 = DB::connection('pgsql2')->select('SELECT DISTINCT (SELECT SUM(order_value) sum_web_order FROM v_order_all WHERE source = \'Web\'),
                    (SELECT SUM(order_value) sum_mobile_order FROM v_order_all WHERE source = \'Mobile\'),
                    (SELECT SUM(order_value) sum_dealer_order FROM v_order_all WHERE source = \'Dealer\'),
                    (SELECT SUM(order_value) sum_order_all FROM v_order_all) FROM v_order_all');

        $query4 = DB::connection('pgsql2')->select('SELECT DISTINCT (SELECT COUNT(*) cnt_web_order FROM v_order_all WHERE source = \'Web\'),
                    (SELECT COUNT(*) cnt_mobile_order FROM v_order_all WHERE source = \'Mobile\'),
                    (SELECT COUNT(*) cnt_dealer_order FROM v_order_all WHERE source = \'Dealer\') FROM v_order_all');

        $query5 = DB::connection('pgsql2')->select('SELECT COUNT(DISTINCT base_account_no) cnt_trades FROM trades');

        $query6 = DB::connection('pgsql2')->select('SELECT COUNT(DISTINCT base_account_no) cnt_orders FROM v_order_all');

        return response()->json(array_merge(['user_activity' => $query],['sum_trade' => $query2],
            ['sum_order' => $query3],['number_order' => $query4],
            ['trades' => $query5],['orders' => $query6]));
    }

    public function datatopTrade(Request $request){
        $requestData = $request->all();

        $tableType = $requestData['search_param']['tableType'];

        if ($tableType === '1'){
            $data = DB::connection('pgsql2')->select('SELECT a.sales_id AS user_code, b.sales_name AS user_name, 
                                                              SUM(trade_value) AS total_val FROM v_trade_sales a,sales b 
                                                              WHERE a.sales_id=b.sales_id GROUP BY a.sales_id, sales_name ORDER BY total_val DESC LIMIT 10;');
        } else {
            $data = DB::connection('pgsql2')->select('SELECT base_account_no AS user_code, b.custname AS user_name, 
                                                              SUM(trade_value) AS total_val FROM v_trades a, customer b 
                                                              WHERE a.base_account_no=b.custcode GROUP BY base_account_no, custname ORDER BY total_val DESC LIMIT 10;');
        }

        return DataTables::of($data)->make(true);
    }

}
