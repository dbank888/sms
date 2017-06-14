<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/05/2017
 * Time: 11:42 AM
 */

namespace {

    use Illuminate\Support\Facades\Input;


    /************  global const *************/
    const ONE_DAY = 86400;  //一天的时间戳


    /** ++++++++++++++++++++++++++++++++++++++++返回值使用说明++++++++++++++++++++++++++++++++++++++++
     *code值说明
     *成功       （200）
     *参数缺失   （400 用msg说明，详见msg说明）
     *参数错误   （400 用msg说明，详见msg说明）
     *参数格式错误（400 用msg说明，详见msg说明）
     *无权限操作  （403）
     *未找到资源  （404）
     *服务器错误  （500)

     *++++++++++++++++++++++++++++++++++++++++++msg说明++++++++++++++++++++++++++++++++++++++++++++
     *msg 参考说明：

     *200类:
     *   success
     *400类（主要是参数类错误）：
     *   参数缺失 miss parameters
     *   参数格式不正确  bad parameters
     *   参数错误  bad request （可以加具体原因，如不满足什么条件）
     *403类：
     *   无权限 no right to call this api
     *404类：
     *   not found
     *500 类
     *   server error
     */

    const
        CODE_SUCCESS            = 200,
        CODE_PARAMETER_ERROR    = 400,
        CODE_PERMISSION_ERROR   = 403,
        CODE_NOT_FOUND          = 404,
        CODE_SYSTEM_ERROR       = 500;

    if (! function_exists('responseSuccess')) {
        /**
         * @param $data
         * @param string $msg
         * @param string $url
         * @return \Illuminate\Http\JsonResponse
         */
        function responseSuccess($data = true, $msg = "", $url = ""){
            if(strlen($msg) > 0){
                return Response::json(['status' => CODE_SUCCESS, 'data' => $data, 'msg' => $msg, 'url' => $url]);
            }else{
                return Response::json(['status' => CODE_SUCCESS, 'data' => $data, 'url' => $url]);
            }
        }
    }

    if (! function_exists('responseError')) {
        /**
         * @param $code
         * @param string $msg
         * @return \Illuminate\Http\JsonResponse
         */
        function responseError($code, $msg = ""){
            errorLog($msg);
            return Response::json(['status' => $code, 'ErrorMsg' => $msg],$code);
        }
    }

    if (! function_exists('accessLog')) {
        /**
         * 访问日志
         * @param $msg
         * @return bool
         */
        function accessLog($msg = ''){
            $info = \Request::ip(). ' call open api function --'.$msg;
            Log::info($info,\Request::all());
            return true;
        }
    }

    if (! function_exists('errorLog')) {
        /**
         * 错误日志
         * @param string $msg 错误信息
         * @return bool
         */
        function errorLog($msg){
            Log::error("Ip:".\Request::ip().",send request:".\Request::fullUrl()." failed, ErrorMsg:".$msg,\Request::all());
            return true;
        }

    }

    if (! function_exists('checkEmpty')) {
        /**
         * 检查参数是否为空
         * @param $request
         * @param $keys
         * @param bool $allowNull
         * @return bool
         * @throws Exception
         */
        function checkEmpty($request,$keys,$allowNull = false){
            $result = checkMissingParam($request,$keys,$allowNull);
            if($result !== true){
                throw new Exception("参数".$result."缺失",CODE_PARAMETER_ERROR);
            }
            return true;
        }
    }

    if (! function_exists('checkMissingParam')) {
        /**
         * 检查传参丢失
         * @param array $arr 原始请求数组
         * @param array|string $keys 必须的键
         * @param bool|false $allowNull 是否允许为空
         * @return bool|string true/丢失的键名
         */
        function checkMissingParam($arr,$keys,$allowNull = false){
            if(!is_array($keys)){
                $keys = explode(',',$keys);
            }
            foreach($keys as $key){
                if($allowNull){
                    if(!isset($arr[$key])){
                        return $key;
                    }
                }elseif(empty($arr[$key])){
                    return $key;
                }
            }
            return true;
        }
    }
}


