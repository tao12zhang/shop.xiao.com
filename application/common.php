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

/*
** 随机字符串生成
** @param int $len 生成的字符串长度
** @return string
*/
function random_string($len = 6) {
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
        'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2',
        '3', '4', '5', '6', '7', '8', '9'
    );

    $charsLen = count($chars) - 1;
    shuffle($chars); // 将数组打乱

    $output = '';
    for($i = 0; $i < $len; $i++){
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

/*
** 后台管理员密码加密方法
** @param string $password 要加密的字符串
** @return string
*/
function manager_password($password, $encrypt) {
    return md5(md5($encrypt . $password));
}