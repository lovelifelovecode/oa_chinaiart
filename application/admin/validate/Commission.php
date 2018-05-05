<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* Commission validate
	*/
	class Commission extends Validate
	{
		protected $rule = [
			'commission_order_id' => 'integer|gt:0',
			// 'commission_group_id' => 'integer|gt:0',
			// 'commission_rule_id' => 'integer|gt:0',
		];

		protected $message = [
			'commission_order_id.integer' => '订单名称必须为数字',
			'commission_order_id.gt' => '请选择订单',
			// 'commission_group_id.integer' => '小组名称必须为数字',
			// 'commission_group_id.gt' => '请选择小组',
			// 'commission_rule_id.integer' => '提成规则称必须为数字',
			// 'commission_rule_id.gt' => '请选择提成规则',
		];
	}