<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/19
 * Time: 下午4:51
 */
namespace app\admin\controller;

use app\com\logic\LoginLogic;
use app\com\logic\UsersLogic;
use app\com\model\Users;

use think\loader;
use think\Request;


class UsersController extends BaseController
{
    private $LoginLogic = null;
    private $UsersLogic = null;
    private $Users = null;

    public function __construct()
    {
        parent::__construct();
        $this->LoginLogic = new LoginLogic;
        $this->UsersLogic = new UsersLogic;
        $this->Users = new Users;
    }

    //登录
    public function login()
    {
        $name = $this->params['name'];
        $passwd = $this->params['passwd'];
        $result = $this->LoginLogic->login($name,$passwd);

        $this->setMsg($this->LoginLogic->msg);
        $this->setStatus($this->LoginLogic->status);
        $this->outputForJson($result);
    }
    //登出
    public function logout()
    {
        $result = $this->LoginLogic->logout();
        //dump($result);die;
        $this->setMsg($this->LoginLogic->msg);
        $this->outputForJson($result);
    }

    //用户列表
    public function getUsersList()
    {
        $result = $this->UsersLogic->getUsersList();
        $this->outputForJson($result);
    }

    //添加用户
    public function addUsersInfo()
    {
        $data = [
            'name' =>'涛哥',
            'nickname' =>'涛哥哥',
            'passwd' =>123456,
            'role_id' =>2,
            'status' =>1,
        ];
        $result = $this->UsersLogic->addUsersInfo($data);
        $this->setMsg($this->UsersLogic->msg);
        $this->outputForJson($result);
    }

    //编辑用户
    public function updateUsersInfo()
    {

    }

    //删除用户
    public function deleteUsersInfo()
    {

    }

}