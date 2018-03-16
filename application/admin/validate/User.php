<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class User extends Validate
	{
		protected $rule = [
			'password_old' => 'require',
			'password_new' => 'require|alphaDash|min:6|different:password_old',//验证某个字段的值是否为字母和数字，下划线_及破折号-
			'password_again' => 'require|confirm:password_new',//
		];

		protected $message = [
			'password_old.require' => '旧密码不能为空',
			'password_new.require' => '新密码不能为空',
			'password_new.alphaDash' => '新密码规则:字母和数字，下划线_及破折号-',
			'password_new.min' => '最小长度为6',
			'password_new.different' => '新密码不能和旧密码一样',
			'password_again.require' => '再次输入密码不能为空',
			'password_again.confirm' => '两次输入的新密码不一致!',
		];
	}