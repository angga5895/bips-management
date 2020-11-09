<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketHoliday extends Model
{
    //
    public $timestamps = false;

    protected $table = "market_holiday";
    protected $primaryKey = "rec_date";
    protected $fillable =
        [
            'rec_date',
            'status',
            'description'
        ];
}
