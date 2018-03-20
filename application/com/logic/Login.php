<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/16
 * Time: 下午2:13
 */
namespace app\com\logic;

use think\loader;
use think\Session;

use app\com\model\Users;
use app\com\logic\Base;


class login extends Base{

    private $usersModel = '';
    public function __construct()
    {
        parent::__construct();
        $this->usersModel = new Users;

    }

    //登录
    public function login($name,$password)
    {
        $admin = $this->usersModel->getUserByName(trim($name));
        if($admin){
            if($admin['passwd'] === md5(trim($password))){
                //将登录id和名称存入session
                Session::set('id',$admin['id']);
                Session::set('username',$admin['name']);
                $this->msg = "登录成功";
                return true;
            }else{
                $this->msg = "密码错误";
                return false;
            }
        }else{
            $this->msg = "用户不存在";
            return false;
        }
    }

    //登出
    public function logout()
    {
        session('id', null);
        session('username',null);

        return true;
    }


}
