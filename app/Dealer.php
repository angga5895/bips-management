<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    public $timestamps = false;
    protected $table = "dealer";
    protected $primaryKey = "dealer_id";
    protected $fillable =
        [
            'dealer_id',
            'dealer_name',
            'address',
            'phone',
            'mobilephone',
            'email',
            'user_id',
        ];
}
