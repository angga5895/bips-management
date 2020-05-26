<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleApp extends Model
{
    //
    protected $table = "role_app";
    protected $fillable =
        [
            'name',
            'created_at',
            'updated_at'
        ];
}
