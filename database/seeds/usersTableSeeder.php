<?php

use Illuminate\Database\Seeder;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => Str::random(10),
            'user_name' => 'admin',
            'email_address' => Str::random(10).'@gmail.com',
            'msidn' => Str::random(10),
            'password' => Hash::make('admin'),
            'status' => '1',
            'last_login' => date("Y-m-d H:i:s"),
            'last_teriminalid' => date("Y-m-d H:i:s"),
        ]);
    }
}
