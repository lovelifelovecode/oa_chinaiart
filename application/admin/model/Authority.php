<?php
	namespace app\admin\model;
	use think\Loader;
	/*
	Authority
	 */
	class Authority extends Common{
		protected $insert = ['authority_insert_time'];
		protected $update = ['authority_update_time'];

		protected function setAuthorityInsertTimeAttr($value){
			return time();
		}
		protected function setAuthorityUpdateTimeAttr($value){
			return time();
		}

		protected function getAuthorityInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getAuthorityUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}

		/*
		list about authority
		 */
		public function list(){
			$list = $this::paginate(15);
			return $list;
		}

		/*
		authority add
		 */
		public function add($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['authority_status'] = 1;
			}else{
				$data['authority_status'] = 0;
			}

			$validate = Loader::validate('Authority');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('authority_title',$data['authority_title'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'权限名称已存在'];
			}

			$data['authority_urls'] = explode("\n",$data['authority_urls']);
			$data['authority_urls'] = json_encode($data['authority_urls']);
			
			$result = $this->save($data);
			if($result){
				return ['valid'=>1,'msg'=>'权限添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of authority
		 */
		public function getOneInfo($authority_id){
			$data_old = $this->where('authority_id',$authority_id)->find();
			$data_old['authority_urls'] = implode('',json_decode($data_old['authority_urls']));
			return $data_old;
		}

		/*
		This is update of authority
		 */
		public function edit($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['authority_status'] = 1;
			}else{
				$data['authority_status'] = 0;
			}

			$is_exist = $this->where('authority_title',$data['authority_title'])->whereNotIn('authority_id',$data['authority_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'权限名称已存在'];
			}

			$data['authority_urls'] = explode("\n",$data['authority_urls']);
			$data['authority_urls'] = json_encode($data['authority_urls']);

			$result = $this->save($data,$data['authority_id']);
			if($result){
				return ['valid'=>1,'msg'=>'权限修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of authority
		 */
		public function del($authority_id){
			$res = $this::destroy($authority_id);
			if($res){
				return ['valid'=>1,'msg'=>'权限删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}
	}