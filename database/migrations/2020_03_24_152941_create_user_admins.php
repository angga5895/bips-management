<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * /
     **/
    public function up()
    {
        Schema::create('user_admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->timestamp('email_verified');
            $table->string('password');
            $table->integer('role_app');
            $table->string('remember_token',100);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('role_app')->references('id')->on('role_app');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_admins');
    }
}
