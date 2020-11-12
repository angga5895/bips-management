<?php

namespace App\Imports;

use App\StockHaircut;
use Maatwebsite\Excel\Concerns\ToModel;

use Session;

class StockHaircutImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (count($row) === 5) {
            // notifikasi dengan session
            Session::flash('importsuccess','Data stock haircut has been imported!');

            return new StockHaircut([
                'stock_code' => $row[0],
                'haircut' => $row[1],
                'haircut_comite' => $row[2],
                'hc1' => $row[3],
                'hc2' => $row[4]
            ]);
        } else {
            Session::flash('importerror','Data stock haircut not compatible!');
        }
    }
}
