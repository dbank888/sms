<?php

namespace App\Http\Middleware;

use Closure;

/**
 * ip白名单
 * Class whiteList
 * @package App\Http\Middleware
 */
class whiteList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $access_ips = \Config::get('whiteList');

        $ip = \Request::server('REMOTE_ADDR');
        $ip_head = substr($ip,0,3);
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);

        //过滤内部ip和网络爬虫
        if (!(in_array($ip, $access_ips) || in_array($ip_head,array('192','10.')) || is_numeric(strpos($ua,'spider')) )){
            return responseError(CODE_PERMISSION_ERROR,"Forbidden");
        }

        return $next($request);
    }
}
