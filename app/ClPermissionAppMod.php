<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClPermissionAppMod extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $table = "cl_permission_app_mod";
    protected $fillable =
        [
            'clp_role_app',
            'clp_app_mod'
        ];
}
