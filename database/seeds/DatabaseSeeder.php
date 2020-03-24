<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(usersTableSeeder::class);
        DB::table('role_app')->insert([
            'name' => 'admin',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

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
