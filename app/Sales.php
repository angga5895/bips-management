<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public $timestamps = false;

    protected $table = "sales";
    protected $primaryKey = "sales_id";
    protected $fillable =
        [
            'sales_id',
            'sales_name',
            'address',
            'phone',
            'mobilephone',
            'email',
            'user_id',
        ];
}
