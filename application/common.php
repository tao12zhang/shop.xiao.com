<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if ( ! function_exists('getMillisecond'))
{
    /*返回字符串的毫秒数时间戳
     */
    function getMillisecond()
    {
        $time = explode (" ", microtime () );
        $millisecond =   $time [0] * 1000 < 100?$time [0] * 1000 + 100:$time [0] * 1000;
        $time = $time [1] .$millisecond;
        $time2 = explode ( ".", $time );
        $time = $time2 [0];
        return (int)$time;
    }
}