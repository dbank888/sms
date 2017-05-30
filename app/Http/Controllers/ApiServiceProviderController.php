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
use App\Models\CompanyModel;
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
        $post = \Request::all();
        $keys = ['name','mobile','priority','province','city','district','street','road'];
        try{
            $exist = $this->service_provider->where(['name' => $post['name']])->first();
            if($exist){
                throw new \Exception('服务商已存在');
            }

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

        $exist = $this->service_provider->where(['name' => $post['name']])
            ->where('id','!=',$post['id'])->first();
        if($exist){
            return responseError(CODE_PARAMETER_ERROR,'服务商已存在');
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

        $data = [
            'service_id' => 0,
            'mobile' => ""
        ];
        CompanyModel::where(['service_id' => $id])->update($data);
        $this->service_provider->clearAllCache();
        CompanyModel::clearAllCache();
        return responseSuccess([],'删除成功');
    }

    /**
     * 数据批量导入
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(){
        $content = \Request::get('content');
        $content_arr = CommonHelper::convertContent($content);

        for ($i=0;$i<count($content_arr);$i++) {
            $exist = $this->service_provider->where(['name' => $content_arr[$i][0]])->first();
            if($exist){
                unset($content_arr[$i]);
            }else{
                for ($j=$i+1;$j<count($content_arr);$j++) {
                    if ($content_arr[$j][0] == $content_arr[$i][0]) {
                        unset($content_arr[$j]);
                    }
                }
            }
        }

        foreach($content_arr as $index =>  $arr){
            $exist = $this->service_provider->where(['name' => $arr[0]])->first();
            if($exist){
                unset($content_arr[$index]);
            }
        }
        if($content_arr){
            return ImportHelper::importData('service_provider',$content_arr);
        }else{
            return responseError(CODE_PARAMETER_ERROR,'导入信息已存在');
        }
    }
}