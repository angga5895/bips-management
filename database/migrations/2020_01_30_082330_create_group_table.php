<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *  group_id character varying(20) NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    head_id character varying(20),
    head_name character varying(50)
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->string('group_id',20)->nullable(false)->primary();
            $table->string('name',255)->nullable(false);
            $table->string('head_id',20)->nullable(true);
            $table->string('head_name',50)->nullable(true);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group');
    }
}
