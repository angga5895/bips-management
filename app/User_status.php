<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_status extends Model
{
    //
    protected $table = "user_status";

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
}
