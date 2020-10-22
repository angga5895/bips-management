<?php
/**
 * Created by PhpStorm.
 * User: Angga-PC
 * Date: 21/10/2020
 * Time: 20.34
 */

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class MonthlyExportReport implements FromView{
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
        $monthlyreport = DB::connection('pgsql2')->select('SELECT * FROM stat_monthly_login
                    WHERE year_month BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'
                    ORDER BY year_month ASC');
        $tgl_awal = $this->tgl_awal;
        $tgl_akhir = $this->tgl_akhir;
        return view('report.report-monthlyreport', compact('monthlyreport','tgl_awal','tgl_akhir'));
    }
}
