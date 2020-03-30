<?php

use Illuminate\Database\Seeder;

class SalesSeed extends Seeder
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
                'sales_id' => '000008',
                'sales_name' => 'GATOT ARGA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'gatot.argakusuma@bahana.co.id',
                'user_id' => '000008',
            ],
            [
                'sales_id' => '000009',
                'sales_name' => 'DIAN PUSPITA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'dian.puspita@bahana.co.id',
                'user_id' => '000009',
            ],
            [
                'sales_id' => '000011',
                'sales_name' => 'DIRENDRA DICKY',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'direndra.dicky@bahana.co.id',
                'user_id' => '0000011',
            ],

            [
                'sales_id' => '107002',
                'sales_name' => 'YOHANNES',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'yohanes@bahana.co.id',
                'user_id' => '107002',
            ],
            [
                'sales_id' => '104001',
                'sales_name' => 'SUWARDI WIDJAJA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'suwardi.widjaya@bahana.co.id',
                'user_id' => '104001',
            ],
            [
                'sales_id' => '020512',
                'sales_name' => 'BAGUS WIRAWAN',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'bagus.wirawan@bahana.co.id',
                'user_id' => '020512',
            ],
        ];
        DB::table('sales')->insert($arr);
    }
}