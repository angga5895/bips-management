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
                'user_id' => 'SW14',
                'account_no' => 'SW14',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW18',
                'account_no' => 'SW18',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW55',
                'account_no' => 'SW55',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW82',
                'account_no' => 'SW82',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW24',
                'account_no' => 'SW24',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW130',
                'account_no' => 'SW130',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW146',
                'account_no' => 'SW146',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW174',
                'account_no' => 'SW174',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW187',
                'account_no' => 'SW187',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW197',
                'account_no' => 'SW197',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW203',
                'account_no' => 'SW203',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW209',
                'account_no' => 'SW209',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW217',
                'account_no' => 'SW217',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW222',
                'account_no' => 'SW222',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW242',
                'account_no' => 'SW242',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW249',
                'account_no' => 'SW249',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW251',
                'account_no' => 'SW251',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW256',
                'account_no' => 'SW256',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW263',
                'account_no' => 'SW263',
                'access_flag' => 'T'
            ],
            [
                'user_id' => 'SW276',
                'account_no' => 'SW276',
                'access_flag' => 'T'
            ],
        ];
        DB::table('user_account')->insert($arr);
    }
}
