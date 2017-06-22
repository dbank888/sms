<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 24/05/2017
 * Time: 2:14 PM
 */

namespace App\Http\Controllers;

use App\Helper\ExcelHelper;
use App\Models\SmsReceiveModel;

class ApiSmsController{

    public function dataList(){
        $post = \Request::all();

        $page = $post['page']  ? $post['page'] -1 : 0;
        $listRows = $post['listRows'];

        $sms = new SmsReceiveModel();

        $max_page = ceil($sms::count() / $listRows);
        $receive_lists = $sms->with('send')
            ->where(function($query) use ($post){
                //condition filter
                1 == $post['send_status'] && $query->where('send_id','>',0);
                -1 == $post['send_status'] && $query->where('send_id','=',0);
                $post['content'] && $query->where('content','like','%'.$post['content'].'%');
            })->skip($page*$listRows)->take($listRows)->orderby('id','desc')->get()->toArray();

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

        \Cache::put('sms_export_list',$receive_lists,2*60);
        return responseSuccess(['list' => $receive_lists,'max_page' => $max_page]);
    }

    /**
     * 列表数据导出
     */
    public function export(){
        $source = \Cache::get('sms_export_list');
        $cellData[] = ['来电号码','内容','转发状态','接收时间','转发号码'];
        foreach($source as $val){
            $cellData[] = [
                $val['mobile'],
                $val['content'],
                $val['send_status'],
                $val['created_at'],
                $val['send_mobile']
            ];
        }

        $content = [
            '短信分发记录' => $cellData
        ];

        ExcelHelper::export($content,'短信分发记录');
    }
}