<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/13
 * Time: 上午11:38
 */
return [
    // 定义admin模块的自动生成
    'admin' => [
        '__dir__'    => ['controller', 'model', 'view'],
        'controller' => ['index','User', 'UserType'],
        'model'      => ['index','User', 'UserType'],
        'view'       => ['index/index', 'index/test'],
    ],
];