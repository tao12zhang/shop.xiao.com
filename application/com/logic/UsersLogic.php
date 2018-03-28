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
        //dump($checkName);die;
        if($checkName == false){
            $this->msg = $this->usersModel->msg;
            return false;
        }
        $role_id = $data['role_id'];
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
                'role_id' 	=> $role_id,
                'uid' 		=> $Id
            ];
            $result = $this->RoleuserModel->addRoleUser($roleData);
            return true;
        }

        return false;
    }

    //编辑管理员用户
    public function updateUsersInfo($data)
    {
        //判断,超级管理员不能修改
        $id = (int) $data['id'];
        if($id == 1){
            $this->msg = '超级管理员不能修改!';
            return false;
        }
        //判断编辑用户是否存在
        $find = $this->usersModel->getUsersById($id);
        if(!$find){
            $this->msg = '参数错误';
            return false;
        }
        //users验证
        $UsersValidate = new UsersValidate;
        $check = $UsersValidate->scene('edit')->check($data);
        //验证失败
        if($check == false){
            $this->msg = $UsersValidate->getError();
            return false;
        }
        //验证 name 是否重复添加
        $checkName = $this->usersModel->checkNameUpdate($data);
        if($checkName == false){
            $this->msg = $this->usersModel->msg;
            return false;
        }
        $role_id = $data['role_id'];
        //验证角色 id
        $checkRoleId = $this->RoleModel->checkRoleId($data['role_id']);
        if($checkRoleId == false){
            $this->msg = $this->RoleModel->msg;
            return false;
        }
        unset($data['role_id']);
        unset($data['id']);
        //dump($data);die;
        //保存数据
        $updateData = $this->usersModel->updateUserInfo($data,$id);
        //处理角色
        if($updateData){
            $roleData = [
                'role_id' 	=> $role_id,
                'uid' 		=> $id
            ];
            $result = $this->RoleuserModel->addRoleUser($roleData);
            return true;
        }

        $this->msg = '操作失败或没有数据可更新';
        return false;

    }

    //删除管理员
    public function deleteUsersInfo($id)
    {
        $delete = $this->usersModel->deleteUsersInfo($id);
        if($delete == false){
            $this->msg = $this->usersModel->msg;
            return false;
        }
        //删除用户角色
        if($delete){
            $result = $this->RoleuserModel->deleteRoleUsers($id);
        }

        return true;
    }









}