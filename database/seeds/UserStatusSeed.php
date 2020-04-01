<?php

use Illuminate\Database\Seeder;

class UserStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $arr = [
            [
                'id' => 'A',
                'name' => 'Active',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'B',
                'name' => 'Suspend Buy',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'S',
                'name' => 'Suspend Sell',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'T',
                'name' => 'Trade Disabled',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'I',
                'name' => 'Inactive',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'F',
                'name' => 'Block Due To Fraud',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('user_status')->insert($arr);
    }
}
