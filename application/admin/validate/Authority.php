<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class Authority extends Validate
	{
		protected $rule = [
			'authority_title' => 'require',
		];

		protected $message = [
			'authority_title.require' => '权限不能为空',
		];
	}