<?php

namespace App\Http\Controllers;

use App\Exports\StockHaircutExport;
use App\Imports\StockHaircutImport;
use App\MarketHoliday;
use App\StockHaircut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

use Session;

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

    public function stockhaircut(){
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
                            WHERE cl_module.clm_slug = \'parameter/stockhaircut\' AND cl_permission_app_mod.clp_role_app = '.$role_app);

        $countpermission = 0;
        foreach ($permission as $p){
            $countpermission = $p->count;
        }

        if ($countpermission === 0  || $countpermission === '0'){
            return view('permission');
        } else {
            $clapps = DB::select('SELECT cl_app.* FROM cl_app WHERE cl_app.cla_routename = \'parameter\' ');
            $clmodule = DB::select('SELECT cl_module.* FROM cl_module WHERE cl_module.clm_slug = \'parameter/stockhaircut\' ');

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

            return view('dxtrade-parameter.stockhaircut', compact('clapp', 'role_app', 'clmodule', 'clapps', 'monththis', 'lastmonth', 'thismonth', 'startmonth'), ['title' => 'Stock Haircut']);
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

    public function dataStockhaircut(Request $request){
        $requestData = $request->all();

        //$tglAwal = $requestData['search_param']['tgl_awal'];
        //$tglAkhir = $requestData['search_param']['tgl_akhir'];

        $stockcode = $requestData['search_param']['stock_code'];;
        $wherestockcode = '';
        if ($stockcode !== ''){
            $wherestockcode = ' AND stock_code LIKE "lower"(\'%'.$stockcode.'%\') OR stock_code LIKE "upper"(\'%'.$stockcode.'%\') ';
        }

        $data = DB::select('SELECT * FROM stock_haircut
                    WHERE stock_code is NOT NULL
                    '.$wherestockcode.'
                    ORDER BY stock_code ASC');
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

    public function checkStockHaircut(){
        $stockcode = $_GET['stockcode'];
        $query = DB::select('SELECT * FROM stock_haircut
                    WHERE stock_code = \''.$stockcode.'\'');

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

    public function registrasiHaircut(){
        $stockcode = $_GET['stockcode'];
        $haircut = $_GET['haircut'];
        $haircutcomite = $_GET['haircutcomite'];
        $hc1 = $_GET['hc1'];
        $hc2 = $_GET['hc2'];

        try {
            $query = StockHaircut::create([
                'stock_code' => $stockcode,
                'haircut' => $haircut,
                'haircut_comite' => $haircutcomite,
                'hc1' => $hc1,
                'hc2' => $hc2
            ]);

            if ($query) {
                $status = '00';
                $stock_code = $stockcode;
                $message = 'Success';
            } else {
                $status = "01";
                $stock_code = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $stock_code = $stockcode;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'stock_code' => $stock_code,
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

    public function updateStockHaircut(){
        $id = $_GET['id'];
        $stockcode = $_GET['stockcode'];
        $haircut = $_GET['haircut'];
        $haircutcomite = $_GET['haircutcomite'];
        $hc1 = $_GET['hc1'];
        $hc2 = $_GET['hc2'];

        try {
            $query = StockHaircut::where('stock_code', $id)->update([
                'stock_code' => $stockcode,
                'haircut' => $haircut,
                'haircut_comite' => $haircutcomite,
                'hc1' => $hc1,
                'hc2' => $hc2
            ]);

            if ($query) {
                $status = '00';
                $stock_code = $stockcode;
                $message = 'Success';
            } else {
                $status = "01";
                $stock_code = "";
                $message = 'Error';
            }
        } catch (QueryException $e){
            $status = '01';
            $stock_code = $stockcode;
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'stock_code' => $stock_code,
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

    public function stockhaircutEdit()
    {
        $id = $_GET['id'];
        $query = DB::select('SELECT * FROM stock_haircut
                    WHERE stock_code = \''.$id.'\'');

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

    public function deleteStockHaircut(){
        $id = $_GET['id'];
        $stockcode = $id;

        try{
            $query = StockHaircut::where('stock_code',$id)->delete();

            if ($query) {
                $status = '00';
                $stock_code = $stockcode;
                $message = 'Success';
            } else {
                $status = "01";
                $stock_code = "";
                $message = 'Error';
            }
        } catch(QueryException $ex){
            $status = "01";
            $stock_code = null;
            $message = $ex->getMessage();
        }

        return response()->json([
            'status' => $status,
            'stock_code' => $stock_code,
            'message' => $message,
        ]);
    }

    public function export_excel_haircut()
    {
        date_default_timezone_set('Asia/Jakarta');
        $judul = 'Stock Haircut';

        return Excel::download(new StockHaircutExport, $judul.'_'. date('Y-m-d H:i:s').'.xls');
    }

    public function import_excel_haircut(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_stockhaircut',$nama_file);

        // Delete all data
        DB::select('DELETE FROM stock_haircut;');

        // import data
        Excel::import(new StockHaircutImport, public_path('/file_stockhaircut/'.$nama_file));

        // alihkan halaman kembali
        return redirect('/parameter/stockhaircut');
    }
}
