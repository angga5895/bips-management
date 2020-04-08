<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "user_id";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'user_name',
        'email_address',
        'msidn',
        'hash_password',
        'status',
        'last_login',
        'last_teriminalid',
        'user_type',
        'hash_pin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'hash_password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_login' => 'datetime',
    ];
}
