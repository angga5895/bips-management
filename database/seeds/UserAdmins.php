<?php

use Illuminate\Database\Seeder;

class UserAdmins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_admins')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role_app' => 1,
            'email_verified' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'remember_token' => '',
        ]);
    }
}
