<?php
	namespace app\admin\model;
	use think\Loader;

	class Order extends Common{
		protected $insert = ['order_insert_time'];
		protected $update = ['order_update_time'];

		protected function setOrderInsertTimeAttr($value){
			return time();
		}
		protected function setOrderUpdateTimeAttr($value){
			return time();
		}

		protected function getOrderInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getOrderUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}

		//The complete time
		protected function setOrderSettimeAttr($value){
			return strtotime($value);
		}
		protected function setOrderCompleteTimeAttr($value){
			return strtotime($value);
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
		//The complete time

		public function list($column,$order){
			$list = $this:: order($column,$order) -> paginate(15);
			return $list;
		}

		/*
		order add
		 */
		public function add($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['order_status'] = 1;
			}else{
				$data['order_status'] = 0;
			}

			$data['order_complete'] = (isset($data['order_complete']) && $data['order_complete']=='on')? 1 : 0;
			
			if($data['order_complete'] == 1 && $data['order_complete_time'] == ''){
				return ['valid'=>0,'msg' => '如果已完成，请输入完成时间'];
			}
// halt($data);
			$validate = Loader::validate('Order');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('order_title',$data['order_title'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'订单名称已存在'];
			}
			$result = $this->save($data);
			if($result){
				return ['valid'=>1,'msg'=>'订单添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of order
		 */
		public function getOneInfo($order_id){
			$data_old = $this::get($order_id);
			return $data_old;
		}

		/*
		This is update of order
		 */
		public function edit($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['order_status'] = 1;
			}else{
				$data['order_status'] = 0;
			}

			$data['order_complete'] = (isset($data['order_complete']) && $data['order_complete']=='on')? 1 : 0;
			if($data['order_complete'] == 1 && $data['order_complete_time'] == ''){
				return ['valid'=>0,'msg' => '如果已完成，请输入完成时间'];
			}
// halt($data);
			$validate = Loader::validate('Order');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('order_title',$data['order_title'])->whereNotIn('order_id',$data['order_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'订单名称已存在'];
			}

			$result = $this->save($data,$data['order_id']);
			if($result){
				return ['valid'=>1,'msg'=>'订单修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of order
		 */
		public function del($order_id){
			$res = $this::destroy($order_id);
			if($res){
				return ['valid'=>1,'msg'=>'订单删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get the list where status is 1.
		 */
		public function getList(){
			return $this -> where('order_status',1) -> where('order_complete_time != 0') -> column('order_title','order_id');
		}

		/*
		search commission info
		 */
		public function search($data){
			$search = '%' . $data['search'] . '%';
			$list = $this:: whereLike('order_title|order_price|order_buyer|order_settime|order_complete_time',$search) -> paginate(15);
			return $list;
		}

	}