<?php

use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
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
                'user_id' => 'SW14',
                'user_name' => "ARIEF WIBOWO",
                'email_address' => "ariefw2014@yahoo.co.id",
                'msidn' => '08562158353',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW18',
                'user_name' => "RADEN FEB SUMANDAR",
                'email_address' => "feb.sumandar@gmail.com",
                'msidn' => '0811947147',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW55',
                'user_name' => "ARIES WIDIYATMOKO",
                'email_address' => "arieswidiyatmoko18@gmail.com",
                'msidn' => '081806235555',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW82',
                'user_name' => "NATAL ARGAWAN PARDEDE",
                'email_address' => "n.argawan@gmail.com",
                'msidn' => '08111988685',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW24',
                'user_name' => "ARIF SOETIONO",
                'email_address' => "a_soetiono@yahoo.com",
                'msidn' => '0818967697',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW130',
                'user_name' => "JONES TJIUNARDI",
                'email_address' => "jones.tjiunardi@gmail.com",
                'msidn' => '0811635525',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW146',
                'user_name' => "JOHAN",
                'email_address' => "johan.muchtaridi@gmail.com",
                'msidn' => '08164811618',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW174',
                'user_name' => "HANDOKO",
                'email_address' => "handoko75@gmail.com",
                'msidn' => '0811987644',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW187',
                'user_name' => "YETTI ROCHMANTIWI USADANINGRUM",
                'email_address' => "lovelyita84@yahoo.com",
                'msidn' => '08161167085',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW197',
                'user_name' => "MOH.REZA",
                'email_address' => "rejabragaja@yahoo.com",
                'msidn' => '08128109407',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW203',
                'user_name' => "AGUNG LEON HARYATMO",
                'email_address' => "agung_leon@yahoo.com",
                'msidn' => '08121051828',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW209',
                'user_name' => "BAYU PARIKESIT",
                'email_address' => "kobarsih@yahoo.com",
                'msidn' => '0811953078',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW217',
                'user_name' => "MAS BAGUS UNGGUL WISESA",
                'email_address' => "bagus.wisesa@yahoo.co.id; bagus.wisesa@bukopin.co.id",
                'msidn' => '08129488720',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW222',
                'user_name' => "IKA PRISHANDANA",
                'email_address' => "ikhapapu@gmail.com",
                'msidn' => '085283121314',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW242',
                'user_name' => "HERLINA",
                'email_address' => "herlinahlm@gmail.com",
                'msidn' => '08176521920',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW249',
                'user_name' => "YUNI LAMPITA GULTOM",
                'email_address' => "itamosesgultom@gmail.com",
                'msidn' => '08161607896',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW251',
                'user_name' => "SONY CHRISTIAN RUNTULALU",
                'email_address' => "runtulalu@yahoo.com",
                'msidn' => '085852749220',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW256',
                'user_name' => "TRINITA SITUMEANG",
                'email_address' => "trinita.situmeang@yahoo.com",
                'msidn' => '08161859574',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW263',
                'user_name' => "GOUW THAY KWIE",
                'email_address' => "thaykwie@yahoo.com",
                'msidn' => '0816649870',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
            [
                'user_id' => 'SW276',
                'user_name' => "ICHWAN ZADELI",
                'email_address' => "delija@cbn.net.id",
                'msidn' => '0811151128',
                'hash_password' => Hash::make('password123'),
                'status' => 'A',
                'last_login' => date("Y-m-d H:i:s"),
                'last_teriminalid' => Null,
                'user_type' => 'C',
                'hash_pin' => Hash::make('123456')
            ],
        ];
        DB::table('users')->insert($arr);
    }
}
