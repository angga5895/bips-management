<?php

use Illuminate\Database\Seeder;

class SeedClPermissionAppMod extends Seeder
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
                'clp_app_mod' => 1,
            ],
            [
                'clp_role_app' => 1,
                'clp_app_mod' => 2,
            ],
            [
                'clp_role_app' => 1,
                'clp_app_mod' => 3,
            ],
            [
                'clp_role_app' => 1,
                'clp_app_mod' => 4,
            ],
            [
                'clp_role_app' => 1,
                'clp_app_mod' => 5,
            ],
        ];
        DB::table('cl_permission_app_mod')->insert($arr);
    }
}
