<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer', function (Blueprint $table) {
            $table->String('dealer_id',20)->nullable(false)->primary();
            $table->String('dealer_name',50);
            $table->String('address',50)->nullable();
            $table->String('phone',50)->nullable();
            $table->String('mobilephone',50)->nullable();
            $table->String('email',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealer');
    }
}
