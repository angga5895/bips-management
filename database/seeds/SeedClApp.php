<?php

use Illuminate\Database\Seeder;

class SeedClApp extends Seeder
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
                'cla_name' => 'User Admin',
                'cla_slug' => 'navbar-useradmin',
                'cla_icon' => 'ni ni-single-02 text-yellow',
                'cla_order' => 1,
                'cla_routename' => 'useradmin',
                'cla_module' => true,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'Master Data',
                'cla_slug' => 'navbar-masterdata',
                'cla_icon' => 'ni ni-archive-2 text-light',
                'cla_order' => 2,
                'cla_routename' => 'masterdata',
                'cla_module' => true,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'IT Admin',
                'cla_slug' => 'empty',
                'cla_icon' => 'fa fa-laptop text-orange',
                'cla_order' => 3,
                'cla_routename' => 'itadmin',
                'cla_module' => false,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'Risk Management',
                'cla_slug' => 'empty',
                'cla_icon' => 'fa fa-asterisk text-primary',
                'cla_order' => 4,
                'cla_routename' => 'riskmanagement',
                'cla_module' => false,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'Finance',
                'cla_slug' => 'empty',
                'cla_icon' => 'ni ni-diamond text-danger',
                'cla_order' => 5,
                'cla_routename' => 'finance',
                'cla_module' => false,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'Custodian',
                'cla_slug' => 'empty',
                'cla_icon' => 'ni ni-books text-orange text-gray',
                'cla_order' => 6,
                'cla_routename' => 'custodian',
                'cla_module' => false,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
            [
                'cla_name' => 'Call Center',
                'cla_slug' => 'empty',
                'cla_icon' => 'fab fa-telegram text-success',
                'cla_order' => 7,
                'cla_routename' => 'callcenter',
                'cla_module' => false,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('cl_app')->insert($arr);
    }
}
