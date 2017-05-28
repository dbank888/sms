<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 27/05/2017
 * Time: 3:57 PM
 */

namespace App\Helper;

use App\Models\CompanyModel;
use App\Models\ServiceProviderModel;

/**
 * 数据导入
 * Class ImportHelper
 * @package App\Helper
 */
class ImportHelper{

    const MODELS = [
        'company' => CompanyModel::class,
        'service_provider' => ServiceProviderModel::class
    ];

    /**
     * 数据导入
     * @param $table
     * @param $contents
     * @return \Illuminate\Http\JsonResponse
     */
    public static function fire($table,$contents){
        switch ($table){
            case 'company':
                return self::importCompany($table,$contents);
                break;
            default:
                return self::importData($table,$contents);
        }
    }

    /**
     * 通用数据导入
     * @param $table
     * @param $contents
     * @return \Illuminate\Http\JsonResponse
     */
    public static function importData($table,$contents){
        $total = count($contents);
        $error = 0;
        $fields  = \Schema::getColumnListing($table);
        $fields = array_slice($fields,1,-2);

        $class = self::MODELS[$table];

        $error_msg = "";
        foreach($contents as $index => $line){
            if(count($line) != count($fields)){
                $error ++;
                $error_msg .= '第'.(++$index).'行数据导入失败<br/>';
            }else{
                $model = new $class();
                foreach($fields as $key => $field){
                    $model->$field = $line[$key];
                }
                $res = $model->save();
                if(true !== $res){
                    $error ++;
                    $error_msg .= '第'.(++$index + 1).'行数据导入失败<br/>';
                }
            }
        }
        $model->clearAllCache();
        return responseSuccess(true,$error_msg.$table."成功导入".($total - $error) ."条数据");
    }

    /**
     * 保险公司数据导入
     * @param $table
     * @param $contents
     * @return \Illuminate\Http\JsonResponse
     */
    public static function importCompany($table = 'company',$contents){
        $class = self::MODELS[$table];

        $total = count($contents);
        $error = 0;
        $error_msg = "";
        foreach($contents as $index => $line){
            if(count($line) != 4){
                $error ++;
                $error_msg .= '第'.(++$index).'行数据导入失败<br/>';
            }else{
                $model = new $class();
                $model->name = current($line);
                $model->car_id = next($line);
                $model->license = next($line);

                $exist = $model->where(['license' => $model->license])
                    ->orWhere(['car_id' => $model->car_id])->first();
                if($exist){
                    $error ++;
                    $error_msg .= '第'.(++$index).'行数据导入失败<br/>';
                }

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
                    $error_msg .= '第'.(++$index).'行数据导入失败<br/>';
                }
            }
        }
        $model->clearAllCache();
        return responseSuccess(true,$error_msg.$table."成功导入".($total - $error) ."条数据");
    }
}