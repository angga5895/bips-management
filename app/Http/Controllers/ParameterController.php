<?php

namespace App\Http\Controllers;

use App\MarketHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ParameterController extends Controller
{
    public function marketholiday(){
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
                            WHERE cl_module.clm_slug = \'parameter/marketholiday\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'parameter\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'parameter/marketholiday\' ');

            $tgl = DB::select('SELECT (\'now\'::TIMESTAMP - \'1 month\'::INTERVAL) AS bulanlalu, (\'now\'::TIMESTAMP) AS bulanini');

            $bulanini = '';
            $bulanlalu = '';
            foreach ($tgl as $p){
                $bulanini = $p->bulanini;
                $bulanlalu = $p->bulanlalu;
            }

            $yearthis = date_format(date_create($bulanini),"Y");
            $lastmonth = date_format(date_create($bulanlalu),"Y/m/d");
            $thismonth = date_format(date_create($yearthis."/12/31"),"Y/m/d");
            $monththis = date_format(date_create($bulanini),"Y/m/d");
            $startmonth = date_format(date_create($yearthis."/01/01"),"Y/m/d");

            return view('dxtrade-parameter.marketholiday', compact('clapp', 'role_app', 'clmodule', 'clapps', 'monththis', 'lastmonth', 'thismonth', 'startmonth'), ['title' => 'Market Holiday']);
        }
    }

    public function dataMarketholiday(Request $request){
        $requestData = $request->all();

        $tglAwal = $requestData['search_param']['tgl_awal'];
        $tglAkhir = $requestData['search_param']['tgl_akhir'];

        $data = DB::select('SELECT * FROM market_holiday
                    WHERE rec_date BETWEEN \''.$tglAwal.'\' AND \''.$tglAkhir.'\'
                    ORDER BY rec_date ASC');
        return DataTables::of($data)->make(true);
    }

    public function checkDate(){
        $recdate = $_GET['tgl_rec_date'];
        $query = DB::select('SELECT * FROM market_holiday
                    WHERE rec_date = \''.$recdate.'\'');

        $ii = 0;
        foreach ($query as $p){
            $ii++;
        }

        if ($ii > 0){
            $result = [
                'status' => '01'
            ];
        } else {
            $result = [
                'status' => '00'
            ];
        }

        return response()->json($result);
    }

    public function registrasiMarketholiday(){
        $description = $_GET['desc'];
        $rec_date = $_GET['recdate'];
        $status = $_GET['status'];

        try {
            $query = MarketHoliday::create([
                'rec_date' => $rec_date,
                'status' => $status,
                'description' => $description
            ]);

            if ($query) {
                $status = '00';
                $recdate = $rec_date;
                $message = 'Success';
            } else {
                $status = "01";
                $recdate = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $recdate = $rec_date;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'rec_date' => $recdate,
            'message' => $message
        ]);
    }

    public function updateMarketholiday(){
        $id = $_GET['id'];
        $description = $_GET['desc'];
        $rec_date = $_GET['recdate'];
        $status = $_GET['status'];

        try {
            $query = MarketHoliday::where('rec_date', $id)->update([
                'rec_date' => $rec_date,
                'status' => $status,
                'description' => $description
            ]);

            if ($query) {
                $status = '00';
                $recdate = $rec_date;
                $message = 'Success';
            } else {
                $status = "01";
                $recdate = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $recdate = $rec_date;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'rec_date' => $recdate,
            'message' => $message
        ]);
    }

    public function marketholidayEdit()
    {
        $id = $_GET['id'];
        $query = DB::select('SELECT * FROM market_holiday
                    WHERE rec_date = \''.$id.'\'');

        return response()->json($query);
    }

    public function deleteMarketholiday(){
        $id = $_GET['id'];
        $recdate = $id;

        try{
            $query = MarketHoliday::where('rec_date',$id)->delete();

            if ($query) {
                $status = '00';
                $recdates = $recdate;
                $message = 'Success';
            } else {
                $status = "01";
                $recdates = "";
                $message = 'Error';
            }
        } catch(QueryException $ex){
            $status = "01";
            $recdates = null;
            $message = $ex->getMessage();
        }

        return response()->json([
            'status' => $status,
            'rec_date' => $recdates,
            'message' => $message,
        ]);
    }
}
