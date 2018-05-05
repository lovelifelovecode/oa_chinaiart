<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class Group extends Validate
	{
		protected $rule = [
			'group_name' => 'require',
		];

		protected $message = [
			'group_name.require' => '小组不能为空',
		];
	}