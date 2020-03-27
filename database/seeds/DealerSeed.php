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
        DB::table('dealer')->insert([
            'id' => 1,
            'dlrcode' => "SW001",
            'dlrname' => "Dealer 1",
            'user_id' => 1,
            'group_id' => 1,
            ]);
    }
}
