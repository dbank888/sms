<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 01/05/2017
 * Time: 9:45 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderModel extends Model{

    protected $table = 'service_provider';

    const CACHE_SERVICE_LIST = 'serviceList';

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
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
    public static function cacheServiceProviderList(){
        $cacheCompany = \Cache::get(self::CACHE_SERVICE_LIST);

        if($cacheCompany){
            return $cacheCompany;
        }else{
            $data = self::dataList();
            \Cache::add(self::CACHE_SERVICE_LIST,$data,60*24);

            return $data;
        }
    }

    /**
     * 清除所有cache
     */
    public static function clearAllCache(){
        \Cache::forget(self::CACHE_SERVICE_LIST);
    }

}