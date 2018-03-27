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

    //获取用户列表
    public function getUsersList()
    {
        // 按 id 升序
        $lists = Db::name($this->dbtable)
            ->where(['status' => 1])
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
    public function updateUserInfo($data = [])
    {
        /*if(!isset($data['id'])){
            $this->msg = '无修改主键！';
            return false;
        }
        if(!is_array($data)){
            $this->msg = '数据格式异常！';
            return false;
        }
        //$data['headImage'] = $this->upload_mogu->uploadFile(json_encode($data['headImage']),2);
        $where = ['id'=>$data['id']];
        $data = $this->checkColumn($data,$this->getTableColumn());
        if(empty($data)){
            $this->msg = '无修改数据信息！';
            return false;
        }
        $this -> checkNameAdd($inputs['name']);

        // 产生加密密钥
        $encrypt_salt = md5(random_string(20));

        // 处理生成密码、加密密钥
        $inputs['passwd'] = manager_password($inputs['passwd'], $encrypt_salt);
        $inputs['encrypt_salt'] = $encrypt_salt;

        // 处理时间
        $inputs['time_create'] = time();
        $inputs['time_update'] = time();
        $data['updated'] = getMillisecond();
        $status = $this->db->update($this->dbtable, $data, $where);
        $this->status=$status;
        return $status;*/
    }

    //删除用户
    public function deleteUserInfo($data = [])
    {

    }

    // 验证 是否重复添加
    public function checkNameAdd($name) {
        // 传入为单个元素，则为字符串
        $find = Db::name($this->dbtable)
            -> where(['name' => $name])
            -> find();
        if($find){
            $this->msg = '同样的记录已经存在';
            return false;
        }
        return true;
    }
}