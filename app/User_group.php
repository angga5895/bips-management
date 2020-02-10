<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    //
    protected $table = 'user_group';
    protected $fillable = [
        'user_id',
        'group_id',
    ];
}
