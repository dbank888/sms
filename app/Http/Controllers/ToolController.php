<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 24/05/2017
 * Time: 4:21 PM
 */

namespace App\Http\Controllers;

class ToolController{
    public static function clearAllCache(){
        $exitCode = \Artisan::call('cache:clear');
        echo 'clear All Cache';
    }
}