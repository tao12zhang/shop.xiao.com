<?php
/**
 * Created by PhpStorm.
 * User: fengchu2018
 * Date: 18/3/22
 * Time: 下午2:07
 */
namespace app\com\model;

use app\com\model\Base;

use \think\Loader;
use \think\Session;
use \think\Db;

class Role extends Base{

    public function __construct()
    {
        $this->dbtable = 'Role';
        parent::__construct();

    }

    // 获取角色列表
    public function roleLists() {
        // 按 id 升序
        $lists = Db::name($this->dbtable) -> order('id asc') -> select();

        return $lists;
    }

    // 获取单个角色详情
    public function getRoleDetail($id) {
        $lists = Db::name($this->dbtable) -> find($id);

        if($lists){
            return $lists;
        }
        return false;
    }

    // 获取角色名称
    public function getRoleName($id) {
        // 一维数组
        $name = Db::name($this->dbtable) -> where(array('id' => $id)) -> value('name');

        if($name){
            return $name;
        }
        return '未分配';
    }

    // 删除角色
    public function deletes($id) {


    }

    // 编辑状态
    public function editStatus($id) {
        // 不能修改 超级管理员
        if($id == 1){
            return false;
        }

        $lists = Db::name($this->dbtable) -> find($id);

        if($lists){
            $status = $lists['status'] ? 0 : 1;

            $result = $this -> save(array('status' => $status), array('id' => $id));
            if($result){
                return true;
            }
        }
        return false;
    }

    /*
	** 验证角色 ID
	*/
    public function checkRoleId($role_id) {
        if($role_id == 1){
            // 不能使用超级管理员
            $this->msg = '请选择正确的角色';
            return false;
        }
        // 大于 1，验证是否存在、是否启用
        //$where = array('id' => $role_id, 'status' => 1);
        $where = [
            'id' => $role_id, 'status' => 1
        ];
        $find = Db::name($this->dbtable)
            ->where($where)
            ->find();
        if($find){
            return true;
        }
        $this->msg = '请选择正确的角色';
        return false;
    }
}