<?php
	namespace app\admin\validate;
	use think\Validate;

	/**
	* passwordEdit validate
	*/
	class Order extends Validate
	{
		protected $rule = [
			'order_title' => 'require',
			'order_price' => 'require|number|gt:1',
			'order_buyer' => 'require',
			'order_settime' => 'require',
		];

		protected $message = [
			'order_title.require' => '名称不能为空',
			'order_price.require' => '价格不能为空',
			'order_price.number' => '价格必须为数字',
			'order_price.gt' => '价格必须大于1',
			'order_buyer.require' => '客户名称不能为空',
			'order_settime.require' => '下单时间不能为空',
		];
	}