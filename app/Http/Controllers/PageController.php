<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 24/05/2017
 * Time: 2:01 PM
 */

namespace App\Http\Controllers;


class PageController{

    public function smsList(){

        $data = [
            'csrf_token' => csrf_token(),
            'base_path' => \Request::root()
        ];

        return \Response::view('sms.index',$data);
    }
}
