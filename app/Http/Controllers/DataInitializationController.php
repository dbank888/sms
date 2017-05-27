<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/05/2017
 * Time: 9:56 AM
 */

namespace App\Http\Controllers;

use App\Helper\ExcelHelper;
use App\Helper\ImportHelper;

class DataInitializationController{

    /**
     * get = [
     *      $table 表名
     * ]
     *
     * 数据导入入口
     */
    public function import(){
        $table = \Request::get('table');

        //get import content
        $contents = ExcelHelper::import($table);
        if(empty($contents)){
            return responseError(CODE_PARAMETER_ERROR,"无法识别导入内容");
        }

        return ImportHelper::fire($table,$contents);
    }
}