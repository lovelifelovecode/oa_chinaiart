<?php
	namespace app\admin\model;
	use think\Loader;

	class Commission extends Common{
		protected $insert = ['commission_insert_time'];
		protected $update = ['commission_update_time'];

		protected function setCommissionInsertTimeAttr($value){
			return time();
		}
		protected function setCommissionUpdateTimeAttr($value){
			return time();
		}

		protected function getCommissionInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getCommissionUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}


		protected function getOrderSettimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getOrderCompleteTimeAttr($value){
			if(empty($value)){
				return "";
			}
			return date("Y-m-d H:i:s",$value);
		}
		
		/*
		一个订单提成表可以有多个个人提成,
		个人提成表中，一个个人提成，只能有一个订单提成,
		订单提成表与个人提成表的关系是一对多的关系
		 */
		public function userCommission(){
			return $this -> hasMany('userCommission','order_id','commission_order_id');
		}

		public function list($column,$order){
			$list = $this:: order($column,$order) -> paginate(15);
			$arr = [];
			foreach($list as $key => &$value){
				$value['order_data'] = (new \app\admin\model\Order()) -> where('order_id',$value['commission_order_id'])-> find();

				$value['rule_data'] = (new \app\admin\model\Rule()) -> where('rule_id',$value['order_data']['order_rule_id']) -> find();

				$value['commission_total'] = number_format(($value['order_data']['order_price'] * $value['rule_data']['rule_grade']),2) ;

				$value['percentageArr'] = json_decode($value['commission_percentage'],true);
				$arr = [];
				foreach ($value['percentageArr'] as $key2 => $value2) {
					$key = (new \app\admin\model\User) -> where('user_id',$key2) -> value('user_username');
					$arr[] = [$key,$value2 * 100 . '%' ];
				}
				$value['percentageArr'] = $arr;

			}

			return $list;
		}

		/*
		commission add
		 */
		public function add($data){
			if(array_sum($data['percentage']) > 100){
				return ['valid' => 0 ,'msg' => '设置的百分比有误，加起来不能大于100％'];
			}

			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['commission_status'] = 1;
			}else{
				$data['commission_status'] = 0;
			}
			$validate = Loader::validate('Commission');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('commission_order_id',$data['commission_order_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'提成已存在'];
			}
			
			//将百分整数比转为float型数据
			foreach ($data['percentage'] as $key => &$value) {
				$value = number_format((float)($value/100),2);
			}

			$user_percentage = array_combine($data['commission_user_id'],$data['percentage']);
			$data['commission_percentage'] = json_encode($user_percentage);
			// halt($data);		
			
			$order_info = (new \app\admin\model\Order()) -> where('order_id',$data['commission_order_id']) -> find();
			$data['commission_order_settime'] = strtotime($order_info['order_settime']);
			$data['commission_complete_settime'] = strtotime($order_info['order_complete_time']);
			$data['commission_order_title'] = $order_info['order_title'];
			$data['commission_order_price'] = $order_info['order_price'];


			$result = $this -> allowField(true) -> save($data);
			if($result){


				//保存到个人提成表中
				$commission_id = $this -> commission_id;

				$this  -> userCommission() -> delete();

				$userCommissionArr = [];

				//var_dump打印出来的数据中有地址引用，要去掉它
				$str = '$b = '.var_export($user_percentage,true) .';';
				eval($str);
				foreach ($b as $key => $value) {

					$username = (new \app\admin\model\User()) -> where('user_id',$key) -> value('user_username');
					$userCommissionArr[$key] = ['user_id'=>$key,'username'=>$username,'percentage'=>$value,'operator'=>$data['commission_operator'],'order_title'=>$order_info['order_title'],'order_price'=>$order_info['order_price'],'order_settime'=>$data['commission_order_settime'],'order_complete_time'=>$data['commission_complete_settime']];
				}
				$this -> userCommission()->saveAll($userCommissionArr);
				//保存到个人提成表中



				return ['valid'=>1,'msg'=>'提成添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of commission
		 */
		public function getOneInfo($commission_id){
			$data_old = $this->where('commission_id',$commission_id)->find();
			return $data_old;
		}

		/*
		This is update of commission
		 */
		public function edit($data){
			if(array_sum($data['percentage']) > 100){
				return ['valid' => 0 ,'msg' => '设置的百分比有误，加起来不能大于100％'];
			}
			
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['commission_status'] = 1;
			}else{
				$data['commission_status'] = 0;
			}

			$validate = Loader::validate('Commission');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('commission_order_id',$data['commission_order_id'])->whereNotIn('commission_id',$data['commission_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'提成已存在'];
			}

			
			//将百分整数比转为float型数据
			foreach ($data['percentage'] as $key => &$value) {
				$value = number_format((float)($value/100),4);
			}

			$user_percentage = array_combine($data['commission_user_id'],$data['percentage']);
			$data['commission_percentage'] = json_encode($user_percentage);

			
			$order_info = (new \app\admin\model\Order()) -> where('order_id',$data['commission_order_id']) -> find();
			$data['commission_order_settime'] = strtotime($order_info['order_settime']);
			$data['commission_complete_settime'] = strtotime($order_info['order_complete_time']);
			$data['commission_order_title'] = $order_info['order_title'];
			$data['commission_order_price'] = $order_info['order_price'];

			$result = $this-> allowField(true) -> save($data,$data['commission_id']);
			if($result){
				//保存到个人提成表中
				$commission_id = $data['commission_id'];

				$this  -> userCommission() -> delete();

				$userCommissionArr = [];

				//var_dump打印出来的数据中有地址引用，要去掉它
				$str = '$b = '.var_export($user_percentage,true) .';';
				eval($str);
				foreach ($b as $key => $value) {

					$username = (new \app\admin\model\User()) -> where('user_id',$key) -> value('user_username');
					$userCommissionArr[$key] = ['user_id'=>$key,'username'=>$username,'percentage'=>$value,'operator'=>$data['commission_operator'],'order_title'=>$order_info['order_title'],'order_price'=>$order_info['order_price'],'order_settime'=>$data['commission_order_settime'],'order_complete_time'=>$data['commission_complete_settime']];
				}

				$this -> userCommission()->saveAll($userCommissionArr);
				//保存到个人提成表中			

				return ['valid'=>1,'msg'=>'提成修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of commission
		 */
		public function del($commission_id){
			// $res = $this::destroy($commission_id);
			$result = $this::get($commission_id);
			// halt($result);
			if($result -> delete()){

				//个人提成表中delete
				$this  -> userCommission() -> where('order_id',$result['commission_order_id']) -> delete();

				//保存到个人提成表中
				return ['valid'=>1,'msg'=>'提成删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		search commission info
		 */
		public function search($data){
			$search = '%' . $data['search'] . '%';
			$list = $this:: whereLike('commission_order_title|commission_order_settime|commission_complete_settime|commission_order_price',$search) -> paginate(15);
			$arr = [];
			foreach($list as $key => &$value){
				$value['order_data'] = (new \app\admin\model\Order()) -> where('order_id',$value['commission_order_id'])-> find();

				$value['rule_data'] = (new \app\admin\model\Rule()) -> where('rule_id',$value['order_data']['order_rule_id']) -> find();

				$value['commission_total'] = number_format(($value['order_data']['order_price'] * $value['rule_data']['rule_grade']),2) ;

				$value['percentageArr'] = json_decode($value['commission_percentage'],true);
				$arr = [];
				foreach ($value['percentageArr'] as $key2 => $value2) {
					$key = (new \app\admin\model\User) -> where('user_id',$key2) -> value('user_username');
					$arr[] = [$key,$value2 * 100 . '%' ];
				}
				$value['percentageArr'] = $arr;

			}

			return $list;
		}
	}