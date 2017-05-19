<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 03/05/2017
 * Time: 2:15 PM
 */

namespace App\Helper;

/**
 * 公共方法
 * Class CommonHelper
 * @package App\Helper
 */
class CommonHelper
{
    /**
     * 按权重比例随机取数据
     * @param array $weight 权重  例如array('a'=>10,'b'=>20,'c'=>50)
     * @return int|string
     */
    public static function roll($weight = array()) {
        $roll = rand ( 1, array_sum ( $weight ) );
        $_tmpW = 0;
        $number = 0;
        foreach ( $weight as $k => $v ) {
            $min = $_tmpW;
            $_tmpW += $v;
            $max = $_tmpW;
            if ($roll > $min && $roll <= $max) {
                $number = $k;
                break;
            }
        }
        return $number;
    }

}