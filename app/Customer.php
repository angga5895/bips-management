<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "public.customer";
    protected $primaryKey = "custcode";
    protected $fillable =
        [
            'custstatus',
            'user_password',
        ];
}
