<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 27/05/2017
 * Time: 10:29 AM
 */

namespace App\Http\Controllers;

use App\Helper\CommonHelper;
use App\Helper\ImportHelper;
use App\Models\ServiceProviderModel;

/**
 * 服务商信息接口类
 * Class ApiServiceProviderController
 * @package App\Http\Controllers
 */
class ApiServiceProviderController{

    protected $service_provider;
    function __construct(){
        $this->service_provider = new ServiceProviderModel();
    }

    /**
     * 列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataList(){
        $post = \Request::all();
        $page = $post['page']  ? $post['page'] -1 : 0;
        $listRows = $post['listRows'];

        $max_page = ceil($this->service_provider->count() / $listRows);
        $service_lists = $this->service_provider->skip($page*$listRows)->take($listRows)->orderby('id','desc')->get()->toArray();

        return responseSuccess(['list' => $service_lists,'max_page' => $max_page]);
    }

    /**
     * 添加记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        //todo: 重名验证
        $post = \Request::all();
        $keys = ['name','mobile','priority','province','city','district','street','road'];
        try{
            foreach($keys as $key){
                $this->service_provider->$key = $post[$key];
            }
            $this->service_provider->save();
            $this->service_provider->clearAllCache();
        }catch (\Exception $ex){
            return responseError(CODE_PARAMETER_ERROR,$ex->getMessage());
        }

        return responseSuccess([],'新建成功', \Request::root().'\service');
    }

    /**
     * 编辑页获取信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function editInfo(){
        $id = \Request::get('id');
        if(empty($id)){
            return responseError(CODE_PARAMETER_ERROR,'id缺失');
        }

        $info = $this->service_provider->find($id)->toArray();

        return responseSuccess(['info' => $info]);
    }

    /**
     * 更新记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(){
        $post = \Request::all();
        if(empty($post['id'])){
            return responseError(CODE_PARAMETER_ERROR,'id缺失');
        }

        $this->service_provider = $this->service_provider->find($post['id']);
        foreach($post as $key => $val){
            $this->service_provider->$key = $val;
        }
        $this->service_provider->save();
        $this->service_provider->clearAllCache();

        return responseSuccess([],'修改成功', \Request::root().'\service');
    }

    /**
     * 删除记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $id = \Request::get('id');
        $this->service_provider->destroy($id);
        $this->service_provider->clearAllCache();
        return responseSuccess([],'删除成功');
    }

    /**
     * 数据批量导入
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(){
        $content = \Request::get('content');
        return ImportHelper::importData('service_provider',CommonHelper::convertContent($content));
    }
}