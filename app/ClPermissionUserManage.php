<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClPermissionUserManage extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $table = "cl_permission_user_manage";
    protected $fillable =
        [
            'clp_role_app',
            'clp_user_manage'
        ];
}
