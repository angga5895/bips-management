<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->string('sales_id',20)->nullable(false)->primary();
            $table->string('dealer_id',20)->nullable();
            $table->string('sales_name',50)->nullable();
            $table->String('address',50)->nullable();
            $table->String('phone',50)->nullable();
            $table->String('mobilephone',50)->nullable();
            $table->String('email',50)->nullable();
            $table->string('user_id',20)->nullable(false);
            $table->foreign('dealer_id')->references('dealer_id')->on('dealer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
