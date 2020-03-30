<?php
/**
 * Created by PhpStorm.
 * User: Angga-PC
 * Date: 27/03/2020
 * Time: 17.39
 */
use Illuminate\Database\Seeder;

class SalesSeed extends Seeder
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
                'sales_id' => '000008',
                'sales_name' => 'GATOT ARGA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'gatot.argakusuma@bahana.co.id',
                'user_id' => '000008',
            ],
            [
                'sales_id' => '000009',
                'sales_name' => 'DIAN PUSPITA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'dian.puspita@bahana.co.id',
                'user_id' => '000009',
            ],
            [
                'sales_id' => '000011',
                'sales_name' => 'DIRENDRA DICKY',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'direndra.dicky@bahana.co.id',
                'user_id' => '000011',
            ],
            [
                'sales_id' => '000020',
                'sales_name' => 'MEILADANTY NOURMA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'Meiladanty@bahana.co.id',
                'user_id' => '000020',
            ],
            [
                'sales_id' => '000030',
                'sales_name' => 'INCA ADITYA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'inca.aditya@bahana.co.id',
                'user_id' => '000030',
            ],
            [
                'sales_id' => '000042',
                'sales_name' => 'ARDY DELFIAN',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'ardy@bahana.co.id',
                'user_id' => '000042',
            ],
            [
                'sales_id' => '000044',
                'sales_name' => 'DIRENDRA DICKY (JAKARTA )',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'direndra.dicky@bahana.co.id',
                'user_id' => '000044',
            ],
            [
                'sales_id' => '000047',
                'sales_name' => 'FIRMANTO ( REMISER )',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'firmianto@gmail.com',
                'user_id' => '000047',
            ],
            [
                'sales_id' => '000052',
                'sales_name' => 'GRACE HARTANTO',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'grace.hartanto@bahana.co.id',
                'user_id' => '000052',
            ],
            [
                'sales_id' => '000114',
                'sales_name' => 'GATOT EKO NUGRAHANTO (GNC)',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'admin@garudanc.com',
                'user_id' => '000114',
            ],
            [
                'sales_id' => '001113',
                'sales_name' => 'DIAH DAMAYANTI (GNC)',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'admin@garudanc.com',
                'user_id' => '001113',
            ],
            [
                'sales_id' => '010511',
                'sales_name' => 'ANDRY LIANTO',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'andry.lianto@bahana.co.id',
                'user_id' => '010511',
            ],
            [
                'sales_id' => '020511',
                'sales_name' => 'SITI RAHMAWATI',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'Siti.rahmawati@bahana.co.id',
                'user_id' => '020511',
            ],
            [
                'sales_id' => '020512',
                'sales_name' => 'BAGUS WIRAWAN',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'bagus.wirawan@bahana.co.id',
                'user_id' => '020512',
            ],
            [
                'sales_id' => '104001',
                'sales_name' => 'SUWARDI WIDJAJA',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'suwardi.widjaya@bahana.co.id',
                'user_id' => '104001',
            ],
            [
                'sales_id' => '107002',
                'sales_name' => 'YOHANNES',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'yohanes@bahana.co.id',
                'user_id' => '107002',
            ],
            [
                'sales_id' => '411002',
                'sales_name' => 'YUWANA WIJAYAWATI',
                'address' => NULL,
                'phone' => NULL,
                'mobilephone' => NULL,
                'email' => 'yuwana@bahana.co.id',
                'user_id' => '411002',
            ]
        ];
        DB::table('sales')->insert($arr);
    }

}