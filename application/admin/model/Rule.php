<?php
	namespace app\admin\model;
	use think\Loader;

	class Rule extends Common{
		protected $insert = ['rule_insert_time'];
		protected $update = ['rule_update_time'];

		protected function setRuleInsertTimeAttr($value){
			return time();
		}
		protected function setRuleUpdateTimeAttr($value){
			return time();
		}

		protected function getRuleInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getRuleUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}

		public function list(){
			$list = $this::paginate(15);
			return $list;
		}

		/*
		rule add
		 */
		public function add($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['rule_status'] = 1;
			}else{
				$data['rule_status'] = 0;
			}

			$validate = Loader::validate('Rule');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('rule_name',$data['rule_name'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'规则名称已存在'];
			}
			
			$data['rule_grade'] *= 0.01;
			$result = $this->save($data);
			if($result){
				return ['valid'=>1,'msg'=>'规则添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of rule
		 */
		public function getOneInfo($rule_id){
			$data_old = $this->where('rule_id',$rule_id)->find();
			return $data_old;
		}

		/*
		This is update of rule
		 */
		public function edit($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['rule_status'] = 1;
			}else{
				$data['rule_status'] = 0;
			}

			$validate = Loader::validate('Rule');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('rule_name',$data['rule_name'])->whereNotIn('rule_id',$data['rule_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'规则名称已存在'];
			}

			$data['rule_grade'] /= 100;
			$result = $this->save($data,$data['rule_id']);
			if($result){
				return ['valid'=>1,'msg'=>'规则修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of rule
		 */
		public function del($rule_id){
			$res = $this::destroy($rule_id);
			if($res){
				return ['valid'=>1,'msg'=>'规则删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get the list where status is 1.
		 */
		public function getList(){
			return $this -> where('rule_status',1) ->  column('rule_name','rule_id');;
		}
	}