<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class Role extends Validate
	{
		protected $rule = [
			'role_name' => 'require',
		];

		protected $message = [
			'role_name.require' => '角色不能为空',
		];
	}