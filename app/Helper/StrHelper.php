<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 01/05/2017
 * Time: 11:36 PM
 */
namespace App\Helper;

/**
 * 字符操作
 * Class StrHelper
 * @package App\Helper
 */
class StrHelper
{

    /**
     * 获取一个随机的字符串
     */
    public static function getRandomStr($length) {
        $ranStr = "";
        for ($i = 0; $i < $length; $i++) {
            $ranStr .= chr(mt_rand(65, 90));
        }
        return $ranStr;
    }

    /**
     * 获取指定长度的字符串，从字符串的弟0位开始
     * @param $str
     * @param int $length 字符串长度
     * @return string
     */
    public static function getSubStr($str, $length) {
        $ret = "";
        if (!$str) {
            return $ret;
        }
        if (strlen($str) > $length) {
            $ret = mb_substr($str, 0, $length, "utf-8")."...";
        } else {
            $ret = $str;
        }
        return $ret;
    }

    /**
     * 获取随机字符串
     */
    public static function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    /**
     * 通过类型来得到相应密码
     * @param $length
     * @param array $types
     * @return bool|null|string
     */
    public static function getTypeRandChar($length,
                                           $types = array("Cchar","cchar","num","mark"),
                                           $outStr = array("i","I","1","L","l","O","0")){
        $str = null;
        $randChar = array(
            "Cchar"=>"ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            "cchar"=>"abcdefghijklmnopqrstuvwxyz",
            "num"=>"0123456789",
            "mark"=>"~!@#$%^&*()_+<>?{},"
        );
        if(!$types){
            return false;
        }
        $index = 0;
        $strPol = "";
        foreach($types as $type){
            if(isset($randChar[$type])) {
                $index++;
                if ($index == 1) {
                    $strPol = $randChar[$type];
                } else {
                    $strPol = $strPol . $randChar[$type];
                }
            }
        }

        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $strP = $strPol[rand(0,$max)];
            if(!in_array($strP,$outStr)){
                $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
            } else {
                $i--;
            }
        }

        return $str;
    }

    public static function getLengthTypeRandChar($length,$types,$num){
        if($num || $num > 0 || $length || $length > 0){
            $str = array();
            for($i = 0;$i <= $num; $i++){
                $str[] =  self::getTypeRandChar($length,$types);
            }
            return $str;
        }
        return [];
    }
    /**
     * 数组排序
     * @param $arrays
     * @param $sort_key
     * @param int $sort_order
     * @param int $sort_type
     * @return array|bool
     */
    public static function getArrayOrder($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }
}