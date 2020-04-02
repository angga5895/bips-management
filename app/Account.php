<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = "account";
    protected $primaryKey = "account_no";
    public $timestamps = false;
    protected $fillable = [
        'account_no',
        'account_name',
        'cif_no',
        'asset_code',
        'balance',
        'balance_hold',
        'equiv_balance',
        'account_type',
        'is_base',
        'compliance_id',
        'account_status',
        'locked',
        'base_account_no',
    ];
}
