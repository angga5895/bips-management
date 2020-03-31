<?php

use Illuminate\Database\Seeder;

class SeedClModule extends Seeder
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
                'clm_name' => 'Assign Group',
                'clm_slug' => 'assign',
                'clm_order' => 1,
                'clm_routename' => 'useradmin.assign',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'clm_name' => 'Group',
                'clm_slug' => 'group',
                'clm_order' => 2,
                'clm_routename' => 'useradmin.group',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'clm_name' => 'User Management',
                'clm_slug' => 'user',
                'clm_order' => 3,
                'clm_routename' => 'useradmin.user',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'clm_name' => 'Sales',
                'clm_slug' => 'sales',
                'clm_order' => 1,
                'clm_routename' => 'masterdata.sales',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'clm_name' => 'Dealer',
                'clm_slug' => 'dealer',
                'clm_order' => 2,
                'clm_routename' => 'masterdata.dealer',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],[
                'clm_name' => 'Customer',
                'clm_slug' => 'customer',
                'clm_order' => 3,
                'clm_routename' => 'masterdata.customer',
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('cl_module')->insert($arr);
    }
}
