<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class Rule extends Validate
	{
		protected $rule = [
			'rule_name' => 'require',
			'rule_grade' => 'require|float|between:0,50',
		];

		protected $message = [
			'rule_name.require' => '名称不能为空',
			'rule_grade.require' => '百分比不能为空',
			'rule_grade.float' => '百分比只能为数字',
			'rule_grade.between' => '百分比0到50区间内',
		];
	}