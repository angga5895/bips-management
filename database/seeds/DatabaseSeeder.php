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
        $this->call(RoleApp::class);
        $this->call(Group::class);
        $this->call(UserAdmins::class);
        $this->call(UsersSeed::class);

        $this->call(DealerSeed::class);
    }
}
