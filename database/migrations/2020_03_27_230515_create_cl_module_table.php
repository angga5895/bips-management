<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_module', function (Blueprint $table) {
            $table->bigIncrements('clm_id');
            $table->string('clm_name',50)->nullable();
            $table->string('clm_slug',50)->nullable();
            $table->bigInteger('clm_order')->nullable();
            $table->string('clm_routename',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cl_module');
    }
}
