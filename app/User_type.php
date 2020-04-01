<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    //
    protected $table = "user_type";

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
}
