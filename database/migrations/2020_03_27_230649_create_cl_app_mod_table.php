<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClAppModTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_app_mod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('clam_cla_id')->nullable();
            $table->bigInteger('clam_clm_id')->nullable();
            $table->boolean('clam_show')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cl_app_mod');
    }
}
