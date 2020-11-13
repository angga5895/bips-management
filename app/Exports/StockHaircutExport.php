<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class StockHaircutExport implements FromView
{
    use Exportable;
    public $stock_code;

    function __construct($stock_code){
        $this->stock_code = $stock_code;
    }

    public function view(): View
    {
        // TODO: Implement view() method.
        $sc = $this->stock_code;
        $where_stock_code = '';
        if ($sc !== ''){
            $where_stock_code = ' WHERE stock_code LIKE \'%'.$sc.'%\' ';
        }

        $stockhaircutreport = DB::select('SELECT * FROM stock_haircut
                    '.$where_stock_code.' 
                    ORDER BY stock_code ASC');
        return view('dxtrade-parameter.report-stockhaircut', compact('stockhaircutreport'));
    }
}
