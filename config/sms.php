<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 12/05/2017
 * Time: 2:14 PM
 */

return array(
    'account'       => env('SMS_ACCOUNT', null),
    'password'      => env('SMS_PASSWORD', null),
    'sign'          => env('SMS_SIGN', 'company'),
    'fetch_type'    => env('SMS_FETCH_TYPE', 'mo'),
    'send_type'     => env('SMS_SEND_TYPE', 'pt'),
    'send_url'      => env('SMS_SEND_TYPE', 'http://web.duanxinwang.cc/asmx/smsservice.aspx'),
);