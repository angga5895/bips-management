<?php

use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => 1,
            'user_name' => "usersDealer1",
            'email_address' => "user@gmail.com",
            'msidn' => 1,
            'password' => Hash::make('password'),
            'status' => 1,
            'last_login' => date("Y-m-d H:i:s"),
            'last_teriminalid' => date("Y-m-d H:i:s"),
        ]);
    }
}
