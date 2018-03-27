<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/16
 * Time: 下午2:06
 */
namespace app\com\logic;

use \think\Model;
use \think\loader;

class BaseLogic extends Model{

    public $status = true;
    public $msg = '';

    public function __construct()
    {
        parent::__construct();
    }

}