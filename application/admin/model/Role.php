<?php
	namespace app\admin\model;
	use think\Loader;

	class Role extends Common{
		protected $insert = ['role_insert_time'];
		protected $update = ['role_update_time'];

		protected function setRoleInsertTimeAttr($value){
			return time();
		}
		protected function setRoleUpdateTimeAttr($value){
			return time();
		}

		protected function getRoleInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getRoleUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}


		/*
		1个角色可以有多个权限，
		1个权限可以属于多个用户，
		角色与权限是属于多对多对的关系
		 */
	    public function authority()
	    {
	        return $this->belongsToMany('Authority');
	    }

		public function list(){
			$list = $this::paginate(15);
			return $list;
		}

		/*
		role add
		 */
		public function add($data){
			// halt($data);
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['role_status'] = 1;
			}else{
				$data['role_status'] = 0;
			}

			$validate = Loader::validate('Role');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('role_name',$data['role_name'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'角色名称已存在'];
			}
			
			$result = $this -> allowField(true)->save($data);
			if($result){
				//角色权限表新增
				$user = $this::get($this -> role_id);
				if(isset($data['authority_ids'])){
					$user->authority()->saveAll($data['authority_ids']);
				}

				return ['valid'=>1,'msg'=>'角色添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of role
		 */
		public function getOneInfo($role_id){
			$data_old = $this->where('role_id',$role_id)->find();
			return $data_old;
		}

		/*
		This is update of role
		 */
		public function edit($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['role_status'] = 1;
			}else{
				$data['role_status'] = 0;
			}

			$validate = Loader::validate('Role');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('role_name',$data['role_name'])->whereNotIn('role_id',$data['role_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'角色名称已存在'];
			}

			$result = $this -> allowField(true) ->save($data,$data['role_id']);
			if($result){
				if(!isset($data['authority_ids'])){
					(new \app\admin\model\RoleAuthority()) -> where('role_id',$data['role_id']) -> delete();
				}else{
					$authority_ids_old = (new \app\admin\model\RoleAuthority()) -> where('role_id',$data['role_id']) -> column('authority_id');
					$add = array_diff($data['authority_ids'],$authority_ids_old);
					$del = array_diff($authority_ids_old,$data['authority_ids']);

					$role = $this :: get($data['role_id']);
					$role -> authority() -> detach($del);

					//角色权限表新增
					$user = $this::get($this -> role_id);
					$user->authority()->saveAll($add);
				}

				return ['valid'=>1,'msg'=>'角色修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of role
		 */
		public function del($role_id){
			$res = $this::destroy($role_id);
			if($res){
				(new \app\admin\model\RoleAuthority()) -> where('role_id',$role_id) -> delete();
				return ['valid'=>1,'msg'=>'角色删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}
	}