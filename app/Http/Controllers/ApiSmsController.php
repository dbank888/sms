<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 24/05/2017
 * Time: 2:14 PM
 */

namespace App\Http\Controllers;


use App\Models\SmsReceiveModel;

class ApiSmsController{

    public function dataList(){
        $receive_lists = SmsReceiveModel::with('send')->get()->toArray();

        foreach($receive_lists as &$list){
            if($list['send_id'] > 0){
                $list['send_status'] = '已转发';
                $list['send_mobile'] = $list['send']['mobile'];
            }else{
                $list['send_status'] = '未转发';
                $list['send_mobile'] = '';
            }
            unset($list['send']);
        }

        return \Response::json(['data' => $receive_lists],200);
    }
}