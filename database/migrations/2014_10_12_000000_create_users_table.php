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
            $table->string('user_name',20);
            $table->string('email_address',50)->unique();
            $table->string('msidn',20);
            $table->string('password',60);
            $table->string('status',1);
            $table->timestamp('last_login');
            $table->string('last_teriminalid',30);
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
