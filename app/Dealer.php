<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $table = "dealer";
    protected $primaryKey = "id";
    protected $fillable =
        [
            'dlrcode',
            'dlrname',
            'user_id',
            'group_id',
        ];
}
