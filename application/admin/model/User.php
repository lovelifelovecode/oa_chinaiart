<?php
	namespace app\admin\model;
	use think\Loader;
	use think\Validate;
	/**
	* This class is about user infotation.
	*/
	class User extends Common
	{
		protected $insert = ['user_insert_time'];
		protected $update = ['user_update_time'];

		protected function setUserInsertTimeAttr($value){
			return time();
		}
		protected function setUserUpdateTimeAttr($value){
			return time();
		}

		protected function getUserInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getUserUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}

		/*
		1个用户可以有多个角色，
		1个角色可以有多个用户，
		用户与角色是属于多对多对的关系
		 */
	    public function role()
	    {
	        return $this->belongsToMany('Role');
	    }

		public function list(){
			$list = $this::paginate(15);
			return $list;
		}

		/*
		edit the user password
		 */
		public function passwordEdit($data){
			$validate = Loader::validate('User');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$password_old = $this ->where('user_id',$data['user_id']) -> value('user_password');
			if($password_old != md5(md5('skyuse').md5($data['password_old']))){
				return ['valid'=>0,'msg'=>'旧密码输入有误，请重新输入'];
			}

			$res = $this-> where('user_id',$data['user_id'])->update(['user_password'=>md5(md5('skyuse').md5($data['password_new']))]);
			if($res){
				return ['valid'=>1,'msg'=>'密码修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		user add
		 */
		public function add($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['user_status'] = 1;
			}else{
				$data['user_status'] = 0;
			}

			$validate = new Validate([
			    'user_username'  => 'require',
			],[
				'user_username.require' => '用户名不能为空',
			]);
			if (!$validate->check($data)) {
			    dump($validate->getError());
			}

			$is_exist = $this->where('user_username',$data['user_username'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'用户名称已存在'];
			}
			
			$data['user_password'] = md5(md5('skyuse').md5('skyuse'));
			$result = $this-> allowField(true)->save($data);
			if($result){

				//用户角色表新增
				$user = $this::get($this -> user_id);
				if(isset($data['role_ids'])){
					$user->role()->saveAll($data['role_ids']);
				}

				return ['valid'=>1,'msg'=>'用户添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of user
		 */
		public function getOneInfo($user_id){
			$data_old = $this->where('user_id',$user_id)->find();
			return $data_old;
		}

		/*
		This is update of user
		 */
		public function edit($data){
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['user_status'] = 1;
			}else{
				$data['user_status'] = 0;
			}

			$validate = new Validate([
			    'user_username'  => 'require',
			],[
				'user_username.require' => '用户名不能为空',
			]);
			if (!$validate->check($data)) {
			    dump($validate->getError());
			}

			$is_exist = $this->where('user_username',$data['user_username'])->whereNotIn('user_id',$data['user_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'用户名称已存在'];
			}

			$result = $this -> allowField(true) ->save($data,$data['user_id']);
			if($result){

				if(!isset($data['role_ids'])){
					(new \app\admin\model\UserRole()) -> where('user_id',$data['user_id']) -> delete();
				}else{
					$role_ids_old = (new \app\admin\model\UserRole()) -> where('user_id',$data['user_id']) -> column('role_id');
					$add = array_diff($data['role_ids'],$role_ids_old);
					$del = array_diff($role_ids_old,$data['role_ids']);

					$user = $this :: get($data['user_id']);
					$user -> role() -> detach($del);

					//角色权限表新增
					$user = $this::get($this -> user_id);
					$user->role()->saveAll($add);
				}

				return ['valid'=>1,'msg'=>'用户修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of user
		 */
		public function del($user_id){
			$res = $this::destroy($user_id);
			if($res){
				(new \app\admin\model\UserRole()) -> where('user_id',$user_id) -> delete();
				return ['valid'=>1,'msg'=>'用户删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get the list where status is 1.
		 */
		public function getList(){
			return $this -> where('user_status',1) ->  column('user_username','user_id');;
		}

		/*
		search user info
		 */
		public function search($data){
			$search = '%' . $data['search'] . '%';
			return $this:: whereLike('user_username',$search) -> paginate(15);
		}
	}