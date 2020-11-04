<?php
/**
 * Created by PhpStorm.
 * User: Angga-PC
 * Date: 04/11/2020
 * Time: 11.55
 */

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class IDXMonthlyExportReport implements FromView{
    use Exportable;
    public $tgl_awal;
    public $tgl_akhir;

    function __construct($tgl_awal,$tgl_akhir){
        $this ->tgl_awal = $tgl_awal;
        $this ->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        // TODO: Implement view() method.
        $monthlyloginidx = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login_idx
                        WHERE year_month BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'
                        ORDER BY year_month ASC');
        $tgl_awal = $this->tgl_awal;
        $tgl_akhir = $this->tgl_akhir;
        date_default_timezone_set('Asia/Jakarta');

        return view('report.report-monthlyreportidx-xls', compact('monthlyloginidx','tgl_awal','tgl_akhir'));
    }
}
