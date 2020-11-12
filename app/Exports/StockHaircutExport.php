<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class StockHaircutExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        // TODO: Implement view() method.
        $stockhaircutreport = DB::select('SELECT * FROM stock_haircut ORDER BY stock_code ASC');
        return view('dxtrade-parameter.report-stockhaircut', compact('stockhaircutreport'));
    }
}
