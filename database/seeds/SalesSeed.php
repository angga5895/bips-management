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
                'sales_name' => 'GATOT ARGAa',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'dealer_id' => '10095',
                'email' => 'gatot.argakusuma@bahana.co.id',
            ],
            [
                'sales_id' => '000009',
                'sales_name' => 'DIAN PUSPITA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'dealer_id' => '10095',
                'email' => 'dian.puspita@bahana.co.id',
            ],
            [
                'sales_id' => '000011',
                'sales_name' => 'DIRENDRA DICKY',
                'address' => NULL,
                'dealer_id' => '10095',
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'direndra.dicky@bahana.co.id',
            ],

            [
                'sales_id' => '107002',
                'dealer_id' => '10092',
                'sales_name' => 'YOHANNES',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'yohanes@bahana.co.id',
            ],
            [
                'sales_id' => '104001',
                'sales_name' => 'SUWARDI WIDJAJA',
                'dealer_id' => '10092',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'suwardi.widjaya@bahana.co.id',
            ],
            [
                'sales_id' => '020512',
                'dealer_id' => '10092',
                'sales_name' => 'BAGUS WIRAWAN',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'bagus.wirawan@bahana.co.id',
            ],
        ];
        DB::table('sales')->insert($arr);
    }
}