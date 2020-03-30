<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseraccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account', function (Blueprint $table) {
           $table->string('user_id',20)->primary()->nullable(false);
           $table->string('account_no',20);
           $table->string('access_flag',1);
            $table->foreign('account_no')->references('account_no')->on('account')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_account');
    }
}
