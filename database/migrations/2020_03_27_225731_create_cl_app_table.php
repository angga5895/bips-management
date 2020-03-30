<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_app', function (Blueprint $table) {
            $table->bigIncrements('cla_id');
            $table->string('cla_name',50)->nullable();
            $table->string('cla_slug',50)->nullable();
            $table->bigInteger('cla_order')->nullable();
            $table->string('cla_icon',50)->nullable();
            $table->string('cla_routename',50)->nullable();
            $table->boolean('cla_module')->nullable();
            $table->bigInteger('cla_shown')->nullable();
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
        Schema::dropIfExists('cl_app');
    }
}
