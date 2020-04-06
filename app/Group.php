<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "group";
    protected $primaryKey = "group_id";
    public $incrementing = false;
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    protected $fillable =
        [
            'group_id',
            'name',
            'head_name',
            'head_id',
            'created_at',
            'updated_at',
          ];
}
