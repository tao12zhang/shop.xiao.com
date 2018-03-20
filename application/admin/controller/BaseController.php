<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/13
 * Time: 上午11:54
 */
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

use app\com\logic\Base;

class BaseController extends Controller
{
    protected $params = [];
    protected $status = true;
    protected $msg = '';
    protected $code = '';

    public function __construct()
    {
        parent::__construct();
        $this->params = request()->param();
    }

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

    }

    public function index(){

        return "hello,fengchu";

    }

    public  function setMsg($msg){
        return $this->msg = $msg;
    }

    public function outputForJson($data = null){
        $result = array(
            'success'=>$this->status,
            'code'=>$this->code,
            'msg'=>$this->msg,
            'timestamp'=>getMillisecond(),
            'data'=>!empty($data)?$data:[],
        );
        //access_log(json_encode($result));
        echo json_encode($result);
        exit;

    }

}