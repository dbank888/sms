<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/05/2017
 * Time: 10:00 AM
 */

namespace App\Helper;

use Maatwebsite\Excel\Facades\Excel;

class ExcelHelper  {

    /**
     * Excel文件导出功能
     */
    public static function export(){
        $cellData = [
            ['no','name','score'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('Score',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /**
     * Excel文件导入功能
     */
    public static function import($table){
        $file =  storage_path('imports') . '/'.$table.'.xlsx';
        if(!file_exists($file)){
            return false;
        }

        $data = Excel::load($file)->toArray();

        return $data;
    }
}