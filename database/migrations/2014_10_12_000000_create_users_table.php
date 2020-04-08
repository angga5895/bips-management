<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id',20);
            $table->string('user_name',200)->nullable();
            $table->string('email_address',100)->unique()->nullable();
            $table->string('msidn',20)->nullable();
            $table->string('hash_password',255)->nullable();
            $table->string('status',1)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('last_teriminalid',30)->nullable();
            $table->string('user_type',2)->nullable();
            $table->string('hash_pin',255)->nullable();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
