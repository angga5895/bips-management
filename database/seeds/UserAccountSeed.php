<?php

use Illuminate\Database\Seeder;

class UserAccountSeed extends Seeder
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
                'user_id' => 'sw14',
                'account_no' => 'SW14',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw18',
                'account_no' => 'SW18',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw55',
                'account_no' => 'SW55',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw82',
                'account_no' => 'SW82',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw24',
                'account_no' => 'SW24',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw130',
                'account_no' => 'SW130',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw146',
                'account_no' => 'SW146',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw174',
                'account_no' => 'SW174',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw187',
                'account_no' => 'SW187',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw197',
                'account_no' => 'SW197',
                'access_flag' => 'T'
            ],
            /*[
                'user_id' => 'sw203',
                'account_no' => 'SW203',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw209',
                'account_no' => 'SW209',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw217',
                'account_no' => 'SW217',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw222',
                'account_no' => 'SW222',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw242',
                'account_no' => 'SW242',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw249',
                'account_no' => 'SW249',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw251',
                'account_no' => 'SW251',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw256',
                'account_no' => 'SW256',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw263',
                'account_no' => 'SW263',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'sw276',
                'account_no' => 'SW276',
                'access_flag' => 'T'
            ],*/
        ];
        DB::table('user_account')->insert($arr);
    }
}
