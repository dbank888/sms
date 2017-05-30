<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/05/2017
 * Time: 10:00 AM
 */

namespace App\Helper;

use Maatwebsite\Excel\Facades\Excel;

class ExcelHelper{

    /**
     * @param string $content
     * @param string $filename
     */
    public static function export($content = "",$filename ="Excel"){
        Excel::create($filename,function($excel) use ($content){
            // Set the title
            $excel->setTitle('title');

            // set align center
            $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Chain the setters
            /*$excel->setCreator('maple.xia')
                ->setCompany('dbappsecurity');*/

            // Call them separately
            /*$excel->setDescription('A demonstration to change the file properties');*/

            foreach($content as $key => $cellData){
                $excel->sheet($key, function($sheet) use ($cellData){
                    $sheet->rows($cellData);
                });
            }
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