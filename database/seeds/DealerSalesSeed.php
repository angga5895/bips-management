<?php

use Illuminate\Database\Seeder;

class DealerSalesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arr = [
            [
                'dealer_id' => '10092',
                'sales_id' => '411002',
            ],
            [
                'dealer_id' => '10092',
                'sales_id' => '000011',
            ],
            [
                'dealer_id' => '10092',
                'sales_id' => '000008',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '411002',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '000008',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '000009',
            ],
            [
                'dealer_id' => '10092',
                'sales_id' => '000009',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '000030',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '000011',
            ],
            [
                'dealer_id' => '10095',
                'sales_id' => '000020',
            ],
        ];
        DB::table('dealer_sales')->insert($arr);
    }
}
