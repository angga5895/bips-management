<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHaircut extends Model
{
    //
    public $timestamps = false;

    protected $table = "stock_haircut";
    protected $primaryKey = "stock_code";
    protected $fillable =
        [
            'stock_code',
            'haircut',
            'haircut_comite',
            'hc1',
            'hc2'
        ];
}
