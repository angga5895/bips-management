<?php

namespace App\Http\Controllers;

use App\Exports\DailyExportReport;
use App\Exports\IDXMonthlyExportReport;
use App\Exports\MonthlyExportReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use PDF;

class ReportController extends Controller
{
    //
    public function dailylogin(){
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
                            WHERE cl_module.clm_slug = \'report/dailylogin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'report\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'report/dailylogin\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $lastmonth = date_format(date_create($bulanlalu),"Y/m/d");
            $thismonth = date_format(date_create($bulanini),"Y/m/d");
            $monththis = date_format(date_create($bulanini),"Y/m");
            $startmonth = date_format(date_create($monththis."/01"),"Y/m/d");

            return view('report.dailylogin', compact('clapp', 'role_app', 'clmodule', 'clapps', 'lastmonth', 'thismonth', 'startmonth'), ['title' => 'Report Daily Login']);
        }
    }

    public function monthlylogin(){
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
                            WHERE cl_module.clm_slug = \'report/monthlylogin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'report\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'report/monthlylogin\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $lastmonth = date_format(date_create($bulanlalu),"Y/m");
            $thismonth = date_format(date_create($bulanini),"Y/m");
            $thismonth1 = date_format(date_create($bulanini),"Y/m");
            $monththis = date_format(date_create($bulanini),"Y");
            $startmonth = date_format(date_create($monththis."/01/01"),"Y/m");
            $startmonth1 = date_format(date_create($monththis."/01/01"),"Y/m");

            return view('report.monthlylogin', compact('clapp', 'role_app', 'clmodule', 'clapps', 'lastmonth', 'thismonth', 'startmonth', 'thismonth1', 'startmonth1'), ['title' => 'Report Monthly Login']);
        }
    }

    public function monthlyloginidx(){
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
                            WHERE cl_module.clm_slug = \'report/idxmonthlylogin\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'report\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'report/idxmonthlylogin\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $lastmonth = date_format(date_create($bulanlalu),"Y/m");
            $thismonth = date_format(date_create($bulanini),"Y/m");
            $monththis = date_format(date_create($bulanini),"Y");
            $startmonth = date_format(date_create($monththis."/01/01"),"Y/m");

            return view('report.monthlyloginidx', compact('clapp', 'role_app', 'clmodule', 'clapps', 'lastmonth', 'thismonth', 'startmonth'), ['title' => 'Report Monthly Login IDX']);
        }
    }

    public function chartDailyLogin(){
        $tgl_awal = $_GET['tgl_awal'];
        $tgl_akhir = $_GET['tgl_akhir'];

        $tdaily = DB::connection('pgsql2')->select('SELECT * FROM stat_daily_login
                        WHERE rec_date BETWEEN \''.$tgl_awal.'\' AND \''.$tgl_akhir.'\'
                        ORDER BY rec_date ASC');
        return response()->json($tdaily);
    }

    public function chartMonthlyLogin(){
        $tgl_awal = str_replace("/","-",$_GET['tgl_awal']);
        $tgl_akhir = str_replace("/","-",$_GET['tgl_akhir']);

        $tmonthly = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login
                        WHERE year_month BETWEEN \''.$tgl_awal.'\' AND \''.$tgl_akhir.'\'
                        ORDER BY year_month ASC');
        return response()->json($tmonthly);
    }

    public function dataDailyLogin(Request $request){
        $requestData = $request->all();

        $tglAwal = $requestData['search_param']['tgl_awal'];
        $tglAkhir = $requestData['search_param']['tgl_akhir'];

        $data = DB::connection('pgsql2')->select('SELECT * FROM stat_daily_login
                        WHERE rec_date BETWEEN \''.$tglAwal.'\' AND \''.$tglAkhir.'\'
                        ORDER BY rec_date ASC');
        return DataTables::of($data)->make(true);
    }

    public function dataMonthlyLogin(Request $request){
        $requestData = $request->all();

        $tglAwal = str_replace("/","-",$requestData['search_param']['tgl_awal']);
        $tglAkhir = str_replace("/","-",$requestData['search_param']['tgl_akhir']);

        $data = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login
                        WHERE year_month BETWEEN \''.$tglAwal.'\' AND \''.$tglAkhir.'\'
                        ORDER BY year_month ASC');
        return DataTables::of($data)->make(true);
    }

    public function dataMonthlyLoginIdx(Request $request){
        $requestData = $request->all();

        $tglAwal = str_replace("/","-",$requestData['search_param']['tgl_awal']);
        $tglAkhir = str_replace("/","-",$requestData['search_param']['tgl_akhir']);

        $data = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login_idx
                        WHERE year_month BETWEEN \''.$tglAwal.'\' AND \''.$tglAkhir.'\'
                        ORDER BY year_month ASC');
        return DataTables::of($data)->make(true);
    }

    public function dailyReport (){
        $tgl_awal = $_GET['tgl_awal'];
        $tgl_akhir = $_GET['tgl_akhir'];

        date_default_timezone_set('Asia/Jakarta');
        $judul = 'Report Daily Login';

        return (new DailyExportReport($tgl_awal,$tgl_akhir))->download($judul.'_'. date('Y-m-d H:i:s').'.xls');
    }

    public function monthlyReport (){
        $tgl_awal = str_replace("/","-",$_GET['tgl_awal']);
        $tgl_akhir = str_replace("/","-",$_GET['tgl_akhir']);

        date_default_timezone_set('Asia/Jakarta');
        $judul = 'Report Monthly Login';

        return (new MonthlyExportReport($tgl_awal,$tgl_akhir))->download($judul.'_'. date('Y-m-d H:i:s').'.xls');
    }

    public function idxmonthlyReport (){
        $tgl_awal = str_replace("/","-",$_GET['tgl_awal']);
        $tgl_akhir = str_replace("/","-",$_GET['tgl_akhir']);

        date_default_timezone_set('Asia/Jakarta');
        $judul = 'Report Monthly Login IDX';

        return (new IDXMonthlyExportReport($tgl_awal,$tgl_akhir))->download($judul.'_'. date('Y-m-d H:i:s').'.xls');
    }

    public function pdfMonthlyLoginIdx(Request $request){
        $tgl_awal = str_replace("/","-",$_GET['tgl_awal']);
        $tgl_akhir = str_replace("/","-",$_GET['tgl_akhir']);
        //$tgl_awal = '2020-01';
        //$tgl_akhir = '2020-11';

        if ($tgl_awal !== $tgl_akhir){
            return view('permission');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $judul = 'Report Monthly Login IDX_' . date('Y-m-d H:i:s') . '.pdf';

            $data = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login_idx
                            WHERE year_month BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'
                            ORDER BY year_month ASC');

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('report.report-monthlyreportidx-pdf', ['monthlyloginidx' => $data], compact('judul'));
            $pdf->setPaper('A4', 'potrait');
            /*return $pdf->stream($judul,array('Attachment'=>false));*/
            return new Response($pdf->output(), 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'filename="' . $judul . '"',
            ));
        }
    }

    public function detailMonthlyLoginIdx(Request $request){
        $tgl_awal = str_replace("/","-",$_GET['tgl_awal']);
        $tgl_akhir = str_replace("/","-",$_GET['tgl_akhir']);

        if ($tgl_awal !== $tgl_akhir){
            return view('permission');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $judul = 'DX TRADE ADMIN - Report Monthly Login IDX_' . date('Y-m-d H:i:s');
            $detail = true;

            $data = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login_idx
                                WHERE year_month BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'
                                ORDER BY year_month ASC');

            return view('report.report-monthlyreportidx-pdf', ['monthlyloginidx' => $data], compact('judul', 'detail'));
        }
    }
}
