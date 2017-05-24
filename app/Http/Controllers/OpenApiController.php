<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 12/05/2017
 * Time: 4:25 PM
 */

namespace App\Http\Controllers;

use App\Helper\SmsHelper;
use App\Models\SmsModel;
use App\Models\SmsReceiveModel;
use App\Models\SmsSendModel;
use Illuminate\Support\Facades\Input;

class OpenApiController {

    public function receiveSms(){
        $post = \Request::getContent();

        if(is_array($post)){
            $post = current($post);
        }

        if(empty($post)){
            return responseError(CODE_PARAMETER_ERROR,'短信接收失败');
        }

        $receive_info = explode("#@#",$post);

        $sms_receive = new SmsReceiveModel();
        $sms_receive->mobile = substr($receive_info[0],5);
        $content = $receive_info[1];
        $sms_receive->content = $content;
        $sms_receive->save();

        $target_number = SmsHelper::getTargetNumber($content);

        if($target_number){
            //send sms
            $res = SmsHelper::sendSms($target_number,$content);
            if($res){
                $sms_send = new SmsSendModel();
                $sms_send->mobile = $target_number;
                $sms_send->content = $content;
                $sms_send->save();

                $sms_receive->send_id = $sms_send->id;
                $sms_receive->save();

                return responseSuccess(true,'已成功接收短信，并转发');
            }else{
                return responseError(CODE_PARAMETER_ERROR,'已成功接收短信，转发失败');
            }
        }else{
            return responseSuccess(true,'已成功接收短信，未转发');
        }
    }
}