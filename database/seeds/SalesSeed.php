<?php
/**
 * Created by PhpStorm.
 * User: Angga-PC
 * Date: 27/03/2020
 * Time: 17.39
 */
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
                'dealer_id' => '10092',
                'sales_name' => 'GATOT ARGA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'gatot.argakusuma@bahana.co.id',
                'user_id' => '000008',
            ],
            [
                'sales_id' => '000009',
                'dealer_id' => '10095',
                'sales_name' => 'DIAN PUSPITA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'dian.puspita@bahana.co.id',
                'user_id' => '000009',
            ],
        ];
        DB::table('sales')->insert($arr);
    }

}