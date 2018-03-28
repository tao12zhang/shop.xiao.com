<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/15
 * Time: 下午6:04
 */
namespace app\com\model;

use app\com\model\Base;
use app\com\model\Role;
use app\com\model\Roleuser;
use app\com\validate\UsersValidate;

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

    //
    public function getUsersById($id)
    {
        $result = Db::name($this->dbtable)
            ->where(['id' => $id])
            ->value('id');

        return $result;
    }

    //获取用户列表
    public function getUsersList()
    {
        // 按 id 升序
        $lists = Db::name($this->dbtable)
            ->where(['is_deleted' => 0])
            ->order('id', 'asc')
            ->select();
        //dump($lists);die;

        return $lists;
    }

    //添加用户
    public function addUserInfo($data = [])
    {
        if(!is_array($data)){
            $this->msg = '数据格式异常！';
            return false;
        }
        // 产生加密密钥
        $encrypt_salt = md5(random_string(20));
        // 处理生成密码、加密密钥
        $data['passwd'] = manager_password($data['passwd'], $encrypt_salt);
        $data['encrypt_salt'] = $encrypt_salt;
        // 处理时间
        $data['time_create'] = time();
        $data['time_update'] = time();
        $result = Db::name($this->dbtable)->insertGetId($data);
        //$this->status=$status;
        return $result;
    }

    //编辑用户
    public function updateUserInfo($data = [],$id)
    {
        if(!isset($id)){
            $this->msg = '无修改主键！';
            return false;
        }
        if(!is_array($data)){
            $this->msg = '数据格式异常！';
            return false;
        }
        // 处理密码
        if(isset($data['passwd']) && empty($data['passwd'])){
            unset($data['passwd']);
        }
        if(!empty($data['passwd'])){
            // 产生加密密钥
            $encrypt_salt = md5(random_string(20));
            // 处理生成密码、加密密钥
            $data['passwd'] = manager_password($data['passwd'], $encrypt_salt);
            $data['encrypt_salt'] = $encrypt_salt;
        }
        // 处理时间
        $data['time_update'] = time();
        $result = Db::name($this->dbtable)
            ->where(['id' => $id])
            ->update($data);
        //$this->status=$status;
        return $result;
    }

    //删除用户
    public function deleteUsersInfo($id)
    {
        if(empty($id)){
            $this->msg = '无删除主键！';
            return false;
        }
        if($id == 1){
            $this->msg = '超级管理员不能修改！';
            return false;
        }
        $data['is_deleted'] = 1;
        $data['time_update'] = time();
        $status = Db::table($this->dbtable)
            ->where(['id' => $id])
            ->update($data);

        $this->status=$status;

        return $status;
    }

    // 验证 是否重复添加
    public function checkNameAdd($name) {
        // 传入为单个元素，则为字符串
        $find = Db::name($this->dbtable)
            ->where(['name' => $name])
            ->find();
        if($find){
            $this->msg = '该名称已经存在';
            return false;
        }
        return true;
    }

    // 验证是否重复添加
    public function checkNameUpdate($data) {
        $find = Db::name($this->dbtable)
            ->where(['name' => $data['name']])
            ->value('id');

        if($find && $find != $data['id']){
            $this->msg = '该名称已经存在';
            return false;
        }

        return true;
    }


}