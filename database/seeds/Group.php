<?php

use Illuminate\Database\Seeder;

class Group extends Seeder
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
                'group_id'=>'SPV1',
                'name'=>'Supervisor 1',
                'head_id'=>Null,
                'head_name'=>Null,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],[
                'group_id'=>'GNC',
                'name'=>'GNC',
                'head_id'=>Null,
                'head_name'=>Null,
                'updated_at'=>date('d-m-Y h:i:s'),
                'created_at'=>date('d-m-Y h:i:s'),
            ],
        ];
        DB::table('group')->insert($arr);
    }
}
