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
            [
                'clp_role_app' => 1,
                'clp_app' => 3,
            ],
            [
                'clp_role_app' => 1,
                'clp_app' => 4,
            ],
            [
                'clp_role_app' => 1,
                'clp_app' => 5,
            ],
            [
                'clp_role_app' => 1,
                'clp_app' => 6,
            ],
            [
                'clp_role_app' => 1,
                'clp_app' => 7,
            ],
        ];
        DB::table('cl_permission_app')->insert($arr);
    }
}
