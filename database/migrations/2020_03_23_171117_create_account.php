<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->string('account_no',20)->nullable(false);
            $table->string('account_name', 50);
            $table->string('cif_no',10);
            $table->string('asset_code',5);
            $table->decimal('balance',16,2);
            $table->decimal('balance_hold',16,2);
            $table->decimal('equiv_balance',16,2);
            $table->string('account_type',1);
            $table->string('is_base',1);
            $table->string('compliance_id',20);
            $table->string('account_status',1);
            $table->string('locked',1);
            $table->string('base_account_no',20);
            $table->primary("account_no");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
