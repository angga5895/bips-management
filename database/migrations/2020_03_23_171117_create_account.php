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
            $table->string('account_name', 50)->nullable();
            $table->string('cif_no',10)->nullable();
            $table->string('asset_code',5)->nullable();
            $table->decimal('balance',16,2)->nullable();
            $table->decimal('balance_hold',16,2)->nullable();
            $table->decimal('equiv_balance',16,2)->nullable();
            $table->string('account_type',1)->nullable();
            $table->string('is_base',1)->nullable();
            $table->string('compliance_id',20)->nullable();
            $table->string('account_status',1)->nullable();
            $table->string('locked',1)->nullable();
            $table->string('base_account_no',20)->nullable();
            $table->primary("account_no")->nullable();
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
