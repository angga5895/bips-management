<?php

use Illuminate\Database\Seeder;

class GroupDealerSeed extends Seeder
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
                'group_id' => 'SPV1',
                'dealer_id' => '10092',
            ],
            [
                'group_id' => 'SPV1',
                'dealer_id' => '10095',
            ],
        ];
        DB::table('group_dealer')->insert($arr);
    }
}
