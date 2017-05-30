<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 01/05/2017
 * Time: 9:17 AM
 */

namespace App\Http\Controllers;

use App\Helper\ExcelHelper;
use App\Helper\SmsHelper;
use App\Models\CompanyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DebugController{

    public function index(){
        $content = SmsHelper::getSmsContent();
        $number = SmsHelper::getTargetNumber($content);

        if($number){
            dump($number);
        }else{
            echo 'no found';
        }
    }


    public function show(){
        $string = 'args=18815289976';

        $content = SmsHelper::getSmsContent();
        $mobile = '18815289976';
        SmsHelper::sendSms($mobile,$content);
        //SmsHelper::fetchSms();

        \Log::info('info');
    }

}