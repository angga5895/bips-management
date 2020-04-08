<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_bips extends Model
{
    //
    protected $table = "user";
    protected $fillable =
        [
            'username',
            'password',
            'user_type',
            'client_id',
            'user_status',
            'expire_date',
            'sales_id',
            'group'
        ];
}
