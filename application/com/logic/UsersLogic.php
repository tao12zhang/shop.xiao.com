<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/23
 * Time: 上午10:39
 */
namespace app\com\logic;

use think\loader;
use think\Session;

use app\com\logic\Base;
use app\com\model\Users;
use app\com\model\Role;
use app\com\model\Roleuser;
use app\com\validate\UsersValidate;


class UsersLogic extends BaseLogic{

    private $usersModel = null;
    private $RoleuserModel = null;
    private $RoleModel = null;

    public function __construct()
    {
        parent::__construct();
        $this->usersModel = new Users;
        $this->RoleuserModel = new Roleuser;
        $this->RoleModel = new Role;
    }

    //用户列表
    public function getUsersList()
    {
        //获评用户列表
        $lists = $this->usersModel->getUsersList();
        // 获取所属角色名称
        foreach($lists as $key => &$val){
            //dump($val);
            $val['rolename'] = '未分配';
            if($val['id'] == 1){
                $val['rolename'] = '超级管理员';
            }else{
                // 获取用户对应的角色id
                $role_id = $this->RoleuserModel-> getUserRoleId($val['id']);
                if($role_id){
                    // 获取角色名称
                    $role_name = $this->RoleModel-> getRoleName($role_id);
                    $val['rolename'] = $role_name;
                }
            }
            $val['time_login'] = $val['time_login'] ? date('Y-m-d H:i:s', $val['time_login']) : '尚未登陆过';
        }

        return $lists;
    }

    //添加管理员用户
    public function addUsersInfo($data)
    {
        //users验证
        $UsersValidate = new UsersValidate;
        $check = $UsersValidate->check($data);
        //验证失败
        if($check == false){
            $this->msg = $UsersValidate->getError();
            return false;
        }
        //验证 name 是否重复添加
        $checkName = $this->usersModel->checkNameAdd($data['name']);
        if($checkName == false){
            $this->msg = $this->usersModel->msg;
            return false;
        }
        //验证角色 id
        $checkRoleId = $this->RoleModel->checkRoleId($data['role_id']);
        if($checkRoleId == false){
            $this->msg = $this->RoleModel->msg;
            return false;
        }
        unset($data['role_id']);
        //保存数据
        $Id = $this->usersModel->addUserInfo($data);
        //dump($result);die;
        //处理角色
        if($Id){
            $roleData = [
                'role_id' 	=> $data['role_id'],
                'uid' 		=> $Id
            ];
        }












    }

    //编辑管理员用户
    public function updateUsersInfo()
    {

    }









}