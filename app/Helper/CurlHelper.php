<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 05/05/2017
 * Time: 9:40 AM
 */

namespace App\Helper;

class CurlHelper{

    private static $retriableErrorCodes = array(
        CURLE_COULDNT_RESOLVE_HOST,
        CURLE_COULDNT_CONNECT,
        CURLE_HTTP_NOT_FOUND,
        CURLE_READ_ERROR,
        CURLE_OPERATION_TIMEOUTED,
        CURLE_HTTP_POST_ERROR,
        CURLE_SSL_CONNECT_ERROR,
    );

    /**
     * Curl post json data
     * @param $data
     * @param $url
     * @return mixed
     */
    public static function postJson($data,$url){
        if(is_array($data)){
            $data = json_encode($data,JSON_UNESCAPED_SLASHES);
        }

        $ch = curl_init();

        $headers =  array('Content-Type: application/json', 'Content-Length: ' . strlen($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return self::execute($ch);
    }

    /**
     * Curl post form data
     * @param $data
     * @param $url
     * @return mixed
     */
    public static function postForm($data,$url){
        if(!is_array($data)){
            $data = array($data);
        }
        $query_str = http_build_query($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
   	    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);

        return self::execute($ch);
    }

    /**
     * Curl execute
     * @param $ch
     * @param int $retries
     * @param bool $closeAfterDone
     * @return mixed
     */
    public static function execute($ch, $retries = 1, $closeAfterDone = true){
        while ($retries--) {
            $res = curl_exec($ch);
            if ($res === false) {

                $curlErrNo = curl_errno($ch);

                if (false === in_array($curlErrNo, self::$retriableErrorCodes, true) || !$retries) {

                    $curlError = curl_error($ch);

                    if ($closeAfterDone) {
                        curl_close($ch);
                    }

                    \Log::Error('Params:'.json_encode(\Request::all()).sprintf('Curl error (code %s): %s', $curlErrNo, $curlError));
                }

                sleep(10);
                continue;
            }

            if ($closeAfterDone) {
                curl_close($ch);
            }

            return $res;
        }
    }
}