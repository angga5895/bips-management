<?php

use Illuminate\Database\Seeder;

class SeedClPermissionApp extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'clp_role_app' => 1,
                'clp_app' => 1,
            ],
            [
                'clp_role_app' => 1,
                'clp_app' => 2,
            ],
        ];
        DB::table('cl_permission_app')->insert($arr);
    }
}
