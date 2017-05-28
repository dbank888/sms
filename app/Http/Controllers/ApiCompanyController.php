<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 26/05/2017
 * Time: 9:24 AM
 */

namespace App\Http\Controllers;

use App\Helper\CommonHelper;
use App\Helper\ImportHelper;
use App\Models\CompanyModel;
use App\Models\ServiceProviderModel;

/**
 * 保险公司信息接口类
 * Class ApiCompanyController
 * @package App\Http\Controllers
 */
class ApiCompanyController{

    protected $company;
    function __construct(){
        $this->company = new CompanyModel();
    }

    /**
     * 列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataList(){
        $post = \Request::all();
        $page = $post['page']  ? $post['page'] -1 : 0;
        $listRows = $post['listRows'];

        $max_page = ceil($this->company->count() / $listRows);
        $company_lists = $this->company->with('service')->skip($page*$listRows)->take($listRows)->orderby('id','desc')->get()->toArray();

        return responseSuccess(['list' => $company_lists,'max_page' => $max_page]);
    }

    /**
     * 添加页面配置项
     * @return \Illuminate\Http\JsonResponse
     */
    public function createConf(){
        $services = ServiceProviderModel::pluck('name','id')->toArray();
        $service_conf = [];
        foreach($services as $id => $service){
            $service_conf[] = [
                'key' => $id,
                'value' => $service
            ];
        }
        return responseSuccess(['service' => $service_conf]);
    }

    /**
     * 添加记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        $post = \Request::all();
        $keys = ['name','car_id','license','service_id'];
        try{
            checkEmpty($post,$keys);
            $exist = $this->company->where(['car_id' => $post['car_id']])->first();
            if($exist){
                throw new \Exception('车架号已存在');
            }

            $exist = $this->company->where(['license' => $post['license']])->first();
            if($exist){
                throw new \Exception('车牌号已存在');
            }

            foreach($keys as $key){
                $this->company->$key = $post[$key];
            }
            $this->company->mobile = ServiceProviderModel::where(['id' => $post['service_id']])->first()->mobile;
            $this->company->save();
            $this->company->clearAllCache();

        }catch (\Exception $ex){
            return responseError(CODE_PARAMETER_ERROR,$ex->getMessage());
        }

        return responseSuccess([],'新建成功', \Request::root().'\company');
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

        $info = $this->company->with('service')->find($id);
        $info->server_id = $info->service->id;

        return responseSuccess(['info' => $info->toArray()]);
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

        $exist = $this->company->where(['car_id' => $post['car_id']])
            ->where('id','!=',$post['id'])->first();
        if($exist){
            return responseError(CODE_PARAMETER_ERROR,'车架号已存在');
        }

        $exist = $this->company->where(['license' => $post['license']])
            ->where('id','!=',$post['id'])->first();
        if($exist){
            return responseError(CODE_PARAMETER_ERROR,'车牌号已存在');
        }

        $this->company = $this->company->find($post['id']);
        foreach($post as $key => $val){
            $this->company->$key = $val;
        }
        $this->company->mobile = ServiceProviderModel::where(['id' => $post['service_id']])->first()->mobile;
        $this->company->save();
        $this->company->clearAllCache();

        return responseSuccess([],'修改成功', \Request::root().'\company');
    }

    /**
     * 删除记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $id = \Request::get('id');
        $this->company->destroy($id);
        $this->company->clearAllCache();
        return responseSuccess([],'删除成功');
    }

    /**
     * 数据批量导入
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(){
        $content = \Request::get('content');
        return ImportHelper::importCompany('company',CommonHelper::convertContent($content));
    }
}