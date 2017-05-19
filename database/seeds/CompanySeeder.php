<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 30/04/2017
 * Time: 10:58 PM
 */

use Illuminate\Database\Seeder;

/**
 * Class CompanySeeder
 * 填充保险公司信息
 *
 * cmd调用:  php artisan db:seed --class=CompanySeeder
 */
class CompanySeeder extends Seeder
{

    public function run()
    {
        //注册client
        $insert = [
            [
                'name' => '平安保险',
                'car_id' => 'LSVAM4187C2184847'
            ]
        ];
        $rs = DB::table('oauth_clients')->insert($insert);

        echo "insert {$rs} rows";
    }
}