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
        //
        $find = Db::table($this->dbtable)
            -> where(['uid' => $data['uid']])
            -> find();
        if($find){
            // 删除旧数据
            Db::table($this->dbtable)
                ->where(['id' => $find['id']])
                ->delete();
        }

        Db::table($this->dbtable)->insert($data);

        return true;
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

    //删除用户角色
    public function deleteRoleUsers($uid){
        // 删除数据
        $find = Db::table($this->dbtable)
            -> where(['uid' => $uid])
            -> find();
        if($find){
            // 删除旧数据
            Db::table($this->dbtable)
                ->where(['id' => $find['id']])
                ->delete();
        }

        return true;
    }






}