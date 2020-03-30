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
                'name' => 'Aktif',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'S',
                'name' => 'Suspend',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
            [
                'id' => 'C',
                'name' => 'Closed',
                'created_at' => date('d-m-Y h:i:s'),
                'updated_at' => date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('user_status')->insert($arr);
    }
}
