<?php
namespace app\com\validate;

use think\Validate;
use \think\Loader;

/*
** 菜单 模型验证器
*/

class UsersValidate extends Validate {
	
	// 验证规则
	protected $rule = [
			'name' 		=> 'require',
			'nickname' 	=> 'require',
			'passwd' 	=> 'require'
		];
	
	// 返回对应信息
	protected $message = [
			'name.require' 			=> '用户名不能为空',
			'nickname.require' 		=> '昵称不能为空',
			'passwd.require' 		=> '密码不能为空'
		];
	
	// 验证场景
	protected $scene = [
			'add' 	=> ['name', 'nickname', 'passwd'],
			'edit' 	=> ['name', 'nickname']
		];
	
}
