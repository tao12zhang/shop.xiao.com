<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/19
 * Time: 下午4:51
 */
namespace app\admin\controller;

use app\com\logic\Login;

use think\loader;
use think\Request;


class UsersController extends BaseController
{
    private $LoginLogic = '';
    public function __construct()
    {
        parent::__construct();
        $this->LoginLogic = new Login;
    }

    //登录
    public function login()
    {
        $name = $this->params['name'];
        $passwd = $this->params['passwd'];
        $result = $this->LoginLogic->login($name,$passwd);

        $this->setMsg($this->LoginLogic->msg);
        $this->outputForJson($result);
    }
    //登出
    public function logout()
    {
        //dump($this->status);die;
        dump(request()->param());die;

    }
}