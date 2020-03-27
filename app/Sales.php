<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "sales";
    protected $primaryKey = "id";
    protected $fillable =
        [
            'slscode',
            'slsname',
            'group_id',
            'user_id',
        ];
}
