<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerSales extends Model
{
    public $timestamps = false;
    protected $table = "dealer_sales";
    protected $fillable =
        [
            'dealer_id',
            'sales_id',
        ];
}
