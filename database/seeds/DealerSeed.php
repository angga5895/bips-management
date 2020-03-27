<?php

use Illuminate\Database\Seeder;

class DealerSeed extends Seeder
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
                'dealer_id' => '10092',
                'dealer_name' => 'Rory Jery Hendika',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => NULL,
            ],[
                'dealer_id' => '10095',
                'dealer_name' => 'Aditya Nugraha',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => NULL,
            ],
        ];
        DB::table('dealer')->insert($arr);
    }
}
