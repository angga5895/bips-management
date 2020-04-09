<?php

use Illuminate\Database\Seeder;

class SeedClAppMod extends Seeder
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
                'clam_cla_id' => 1,
                'clam_clm_id' => 1,
                'clam_show' => true,
            ],
            [
                'clam_cla_id' => 2,
                'clam_clm_id' => 2,
                'clam_show' => true,
            ],
            [
                'clam_cla_id' => 2,
                'clam_clm_id' => 3,
                'clam_show' => true,
            ],[
                'clam_cla_id' => 2,
                'clam_clm_id' => 4,
                'clam_show' => true,
            ],[
                'clam_cla_id' => 2,
                'clam_clm_id' => 5,
                'clam_show' => true,
            ],[
                'clam_cla_id' => 2,
                'clam_clm_id' => 6,
                'clam_show' => true,
            ],
        ];
        DB::table('cl_app_mod')->insert($arr);
    }
}
