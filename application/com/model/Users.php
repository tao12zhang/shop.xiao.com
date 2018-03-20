<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/15
 * Time: 下午6:04
 */
namespace app\com\model;

use app\com\model\Base;
use \think\Loader;
use \think\Session;
use \think\Db;


class Users extends Base{

    public function __construct()
    {
        $this->dbtable = 'Users';
        parent::__construct();

    }

    //
    public function getUserByName($name)
    {
        $result = Db::name($this->dbtable)
            ->where(['name' => $name])
            ->find();

        return $result;
    }
}