<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 01/05/2017
 * Time: 9:44 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model {

    protected $table = 'company';

    //keys
    const CACHE_COMPANY_LIST = 'companyList';

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    //关联服务商
    public function service(){
        return $this->hasOne('\ServiceProvider',"id","service_id");
    }

    /**
     * 数据列表
     * @param null $fields
     * @return mixed
     */
    public static function dataList($fields = null){
        if($fields && is_array($fields)){
            return self::select($fields)->get()->toArray();
        }else{
            return self::get()->toArray();
        }
    }

    /**
     * 获取cache
     * @return mixed
     */
    public static function cacheCompanyList(){
        $cacheCompany = \Cache::get(self::CACHE_COMPANY_LIST);

        if($cacheCompany){
            return $cacheCompany;
        }else{
            $data = self::dataList(['car_id','license','mobile']);
            \Cache::add(self::CACHE_COMPANY_LIST,$data,60*24);

            return $data;
        }
    }

    /**
     * 清除所有cache
     */
    public static function clearAllCache(){
        \Cache::forget(self::CACHE_COMPANY_LIST);
    }
}