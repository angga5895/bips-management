<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "group";
    protected $primaryKey = "group_id";
    protected $fillable =
        [
            'group_id',
            'name',
            'created_at',
            'updated_at',
          ];
}
