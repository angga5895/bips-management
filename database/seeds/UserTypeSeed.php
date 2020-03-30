<?php

use Illuminate\Database\Seeder;

class UserTypeSeed extends Seeder
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
                'id' => 'C',
                'name' => 'Customer',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'D',
                'name' => 'Dealer',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'S',
                'name' => 'Sales',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'T',
                'name' => 'Super Trader',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('user_type')->insert($arr);
    }
}
