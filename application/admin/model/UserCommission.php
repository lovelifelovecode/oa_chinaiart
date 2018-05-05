<?php
	namespace app\admin\model;
	use think\Loader;

	class UserCommission extends Common{
		protected $insert = ['insert_time'];
		protected $update = ['update_time'];

		protected function setInsertTimeAttr($value){
			return time();
		}
		protected function setUpdateTimeAttr($value){
			return time();
		}

		protected function getInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}

/*		protected function getOrderSettimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getOrderCompleteTimeAttr($value){
			if(empty($value)){
				return "";
			}
			return date("Y-m-d H:i:s",$value);
		}*/

		/*
		一个个人提成表数据对应一个订单表数据。
		一个订单表数据可以对应多个个人提成表数据。
		个人提成表与订单表是一对多的关系
		 */
		public function orders(){
			return $this -> hasMany("Order");
		}

		/*
		一个个人提成表数据对应一个用户。
		一个用户可以对应多个个人提成表数据。
		个人提成表与用户表是一对多的关系
		 */
		public function user(){
			return $this -> hasMany("User","user_id","user_id");
		}

		/*
		一个个人提成表数据对应一个评分等级。
		一个评分等级可以对应多个个人提成表数据。
		个人提成表与评分等级表是一对多的关系
		 */
		public function rule(){
			return $this -> hasMany("Rule","rule_id","rule_id");
		}

		public function list($column,$order){
			$list = $this -> order($column,$order) -> paginate(15);
			foreach ($list as $key => &$value) {
				$value['order_data'] = $this -> orders() -> where('order_id',$value['order_id']) -> find();
				$value['user_data'] = $this -> user() -> where('user_id',$value['user_id']) -> find();
				$value['rule_data'] = (new \app\admin\model\Rule) -> where('rule_id',$value['order_data']['order_rule_id']) -> find();
				$value['user_commission'] = ($value['order_data']['order_price'] * $value['rule_data']['rule_grade'] * $value['percentage']);
			}
			return $list;
		}


		/*
		search commission info
		 */
		public function search($data){
            $search = '%' . $data['search'] . '%';
			if(!empty($data['mindata']) && !empty($data['maxdata'])){
				if(strtotime($data['mindata']) > strtotime($data['maxdata'])){
					return ['valid'=>0,'msg'=>'时间格式错误'];
				}
				$list = $this::where('username','like',$search) ->where('order_settime','>=',strtotime($data['mindata'])) ->where('order_complete_time','<=',strtotime($data['maxdata'])) ->paginate(15);
			}else{
                $list = $this::where('username','like',$search) ->paginate(15);
            }

			foreach ($list as $key => &$value) {
				$value['order_data'] = $this -> orders() -> where('order_id',$value['order_id']) -> find();
				$value['user_data'] = $this -> user() -> where('user_id',$value['user_id']) -> find();
				$value['rule_data'] = (new \app\admin\model\Rule) -> where('rule_id',$value['order_data']['order_rule_id']) -> find();
				$value['user_commission'] = ($value['order_data']['order_price'] * $value['rule_data']['rule_grade'] * $value['percentage']);
			}
			return ['valid'=>1,'list'=>$list];
		}
	}