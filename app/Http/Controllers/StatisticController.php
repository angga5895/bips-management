<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    //
    public function tradesummary(){
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
                            WHERE cl_module.clm_slug = \'statistics/tradesummary\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'statistic\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'statistics/tradesummary\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $lastmonth = date_format(date_create($bulanlalu),"Y/m/d");
            $thismonth = date_format(date_create($bulanini),"Y/m/d");
            return view('statistics.tradesummary', compact('clapp', 'role_app', 'clmodule', 'clapps', 'lastmonth', 'thismonth'), ['title' => 'Statistics Trade Summary']);
        }
    }

    public function customersummary(){
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
                            WHERE cl_module.clm_slug = \'statistics/customersummary\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'statistic\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'statistics/customersummary\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $lastmonth = date_format(date_create($bulanlalu),"Y/m/d");
            $thismonth = date_format(date_create($bulanini),"Y/m/d");
            return view('statistics.customersummary', compact('clapp', 'role_app', 'clmodule', 'clapps', 'lastmonth', 'thismonth'), ['title' => 'Statistics Customer Summary']);
        }
    }

    public function chartTradeSummary(){
        $tgl_awal = $_GET['tgl_awal'];
        $tgl_akhir = $_GET['tgl_akhir'];

        $tsummary = DB::connection('pgsql2')->select('SELECT * FROM stat_trade_summary
                        WHERE rec_date BETWEEN \''.$tgl_awal.'\' AND \''.$tgl_akhir.'\'
                        ORDER BY rec_date ASC');
        return response()->json($tsummary);
    }

    public function chartCustomerSummary(){
        $tgl_awal = $_GET['tgl_awal'];
        $tgl_akhir = $_GET['tgl_akhir'];

        $tsummary = DB::connection('pgsql2')->select('SELECT * FROM stat_customer_summary
                        WHERE rec_date BETWEEN \''.$tgl_awal.'\' AND \''.$tgl_akhir.'\'
                        ORDER BY rec_date ASC');
        return response()->json($tsummary);
    }
}
