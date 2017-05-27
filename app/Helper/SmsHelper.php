<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 03/05/2017
 * Time: 2:21 PM
 */

namespace App\Helper;

use App\Models\CompanyModel;
use App\Models\ServiceProviderModel;

class SmsHelper{

    public static function getSmsContent(){
        return "18815289976#@#[平安保险]出险车辆浙BS7V90，车架号为LSVAM4187C2184840，联系电话为18815289976，现位于浙江宁波市北仑区百丈东路118号附近。#@#";
        //return "[平安保险]出险车辆浙BS7V90，车架号为LSVAM4187C2184840，联系电话为18815289976，现位于浙江宁波市北仑区百丈东路118号附近。";
    }

    public static function fetchSms(){
        $params = array(
            'name'      => \Config::get('sms.account'),       //必填参数。用户账号
            'pwd'       => \Config::get('sms.password'),      //必填参数。（web平台：基本资料中的接口密码）
            'type'      => \Config::get('sms.fetch_type')
        );

        $api_url = 'http://web.duanxinwang.cc/asmx/reportmo.aspx';

        ob_start(); //缓存输出
        $res = CurlHelper::postForm($params,$api_url);
        ob_clean(); // 清除输出

        $res = explode(",",$res);
        $status_code = $res[0];

        pp ($res);
        /*if(0 == $status_code){
            pp ($res);
        }else{
            pp ('errorCode:'.$res[0].' errorMsg:'.$res[1]);
        }*/
    }

    public static function sendSms($mobile,$content){
        header("Content-Type: text/html; charset=UTF-8");

        //params
        $account = \Config::get('sms.account');
        $password = \Config::get('sms.password');
        $sign = \Config::get('sms.sign');
        $type = \Config::get('sms.send_type');
        $api_url = \Config::get('sms.send_url');

        $params = array(
            'name'      => $account,       //必填参数。用户账号
            'pwd'       => $password,      //必填参数。（web平台：基本资料中的接口密码）
            'sign'      => $sign,          //必填参数。用户签名。
            'mobile'    => $mobile,        //必填参数。手机号码。多个以英文逗号隔开
            'content'   => $content,       //必填参数。发送内容（1-500 个汉字）UTF-8编码
            'type'      => $type,          //必填参数。固定值 pt
            'extno'     => '',             //可选参数，扩展码，用户定义扩展码，只能为数字
            'stime'     => '',             //可选参数。发送时间，填写时以填写的时间发送，不填时为当前时间发送 yyyy-mm-dd hh:mm:ss
        );

        ob_start(); //缓存输出
        $res = CurlHelper::postForm($params,$api_url);
        ob_clean(); // 清除输出

        $res = explode(",",$res);
        $status_code = $res[0];
        if(0 == $status_code){
            return true;
        }else{
            \Log::error("sms send failed ,errorCode: {$res[0]}, errorMsg: {$res[1]}");
            return false;
        }
    }

    /**
     * 获取服务商的联系方式
     * @param $content
     * @return bool|int|string
     */
    public static function getTargetNumber($content){
        $companies = CompanyModel::cacheCompanyList();

        $target_phone = false;

        //按车架和车牌匹配
        foreach($companies as $company){
            $match_carId = false !== strpos($content,$company['car_id']);
            $match_license = false !== strpos($content,$company['license']);
            if($match_carId || $match_license){
                $target_phone = $company['mobile'];
                break;
            }
        }

        if(!$target_phone){
            //按地区匹配服务商
            $service_providers = ServiceProviderModel::cacheServiceProviderList();

            foreach ($service_providers as &$provider) {
                $provider['hit'] = 0;
                if (!empty($provider['province']) && false !== strpos($content, $provider['province'])) {
                    $provider['hit'] ++;
                }

                if (!empty($provider['city']) && false !== strpos($content, $provider['city'])) {
                    $provider['hit'] ++;
                }

                if (!empty($provider['district']) && false !== strpos($content, $provider['district'])) {
                    $provider['hit'] ++;
                }

                if (!empty($provider['street']) && false !== strpos($content, $provider['street'])) {
                    $provider['hit'] ++;
                }

                if (!empty($provider['road']) && false !== strpos($content, $provider['road'])) {
                    $provider['hit'] ++;
                }
            }

            $service_providers = StrHelper::getArrayOrder($service_providers,'hit',SORT_DESC);

            $max_hit = $service_providers[0]['hit'];
            if(0 == $max_hit){
                return false;
            }

            $weight = [];
            unset($provider);
            foreach($service_providers as $provider){
                if($max_hit > $provider['hit']){
                    break;
                }

                $weight[$provider['mobile']] = $provider['priority'];
            }

            $target_phone = CommonHelper::roll($weight);
        }

        if(preg_match("/^1[3458]{1}\d{9}$/",$target_phone)){
            return $target_phone;
        }else{
            return false;
        }
    }
}