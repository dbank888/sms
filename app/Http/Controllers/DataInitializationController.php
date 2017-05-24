<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/05/2017
 * Time: 9:56 AM
 */

namespace App\Http\Controllers;

use App\Helper\ExcelHelper;
use App\Models\CompanyModel;
use App\Models\ServiceProviderModel;
use Illuminate\Support\Facades\Input;

class DataInitializationController{

    const MODELS = [
        'company' => CompanyModel::class,
        'service_provider' => ServiceProviderModel::class
    ];

    /**
     * get = [
     *      $table 表名
     * ]
     *
     * 数据导入入口
     */
    public function import(){
        $table = Input::get('table');

        //get import content
        $contents = ExcelHelper::import($table);
        if(empty($contents)){
            return responseError(CODE_PARAMETER_ERROR,"无法识别导入内容");
        }

        switch ($table){
            case 'company':
                return $this->importCompany($table,$contents);
                break;
            default:
                return $this->importData($table,$contents);
        }
    }

    /**
     * 通用数据导入
     * @param $table
     * @param $contents
     * @return \Illuminate\Http\JsonResponse
     */
    protected function importData($table,$contents){
        $total = count($contents);
        $error = 0;
        $fields  = \Schema::getColumnListing($table);
        $fields = array_slice($fields,1,-2);

        $class = self::MODELS[$table];

        foreach($contents as $index => $line){
            $model = new $class();
            foreach($fields as $key => $field){
                $model->$field = $line[$key];
            }
            $res = $model->save();
            if(true !== $res){
                $error ++;
                echo '...第'.(++$index + 1).'行数据导入失败';
            }
        }

        return responseSuccess(true,$table."成功导入".($total - $error) ."条数据");
    }

    /**
     * 保险公司数据导入
     * @param $table
     * @param $contents
     * @return \Illuminate\Http\JsonResponse
     */
    protected function importCompany($table = 'company',$contents){
        $class = self::MODELS[$table];

        $total = count($contents);
        $error = 0;
        foreach($contents as $index => $line){
            $model = new $class();
            $model->name = current($line);
            $model->car_id = next($line);
            $model->license = next($line);

            $service = ServiceProviderModel::where(['name' => next($line)])->first();
            if(!$service){
                $exist = ServiceProviderModel::all()->toArray();
                if(!$exist){
                    return responseError(CODE_PARAMETER_ERROR,'请先导入服务商数据');
                }
            }
            $model->service_id = $service ? $service->id : 0;
            $model->mobile = $service ? $service->mobile : "";

            $res = $model->save();
            if(true !== $res){
                $error ++;
                echo '第'.(++$index + 1).'行数据导入失败';
            }
        }
        return responseSuccess(true,$table."成功导入".($total - $error) ."条数据");
    }
}