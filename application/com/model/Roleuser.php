<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/22
 * Time: 下午2:08
 */
namespace app\com\model;

use app\com\model\Base;
use \think\Loader;
use \think\Session;
use \think\Db;

class Roleuser extends Base{

    public function __construct()
    {
        $this->dbtable = 'Roleuser';
        parent::__construct();

    }

    // 新增/更新角色用户
    public function addRoleUser($data) {
        $find = Db::table($this->dbtable)
            -> where(array('uid' => $data['uid']))
            -> find();
        if($find){
            // 删除旧数据
            Db::table($this->dbtable)->where(array('id' => $find['id']))->delete();
        }

        Db::table($this->dbtable)->save($data);
    }

    // 获取用户对应的角色id
    public function getUserRoleId($uid) {
        // 一维数组
        $role_id = Db::table($this->dbtable)
            -> where(array('uid' => $uid))
            -> value('role_id');

        if($role_id){
            return $role_id;
        }

        return false;
    }
}