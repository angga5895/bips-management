<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDealer extends Model
{
    //
    protected $table = "group_dealer";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable =
        [
            'group_id',
            'dealer_id',
        ];
}
