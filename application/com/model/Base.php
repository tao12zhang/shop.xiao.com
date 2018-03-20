<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/15
 * Time: 下午5:40
 */
namespace app\com\model;

use \think\Model;
use \think\Db;

/*
 * 公共模块
 * */
class Base extends Model{

    public $msg = "";
    public $status = false;
    public $dbtable="";

    public function __construct()
    {
        parent::__construct();
    }









}