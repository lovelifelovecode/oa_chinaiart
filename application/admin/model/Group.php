<?php
	namespace app\admin\model;
	use think\Loader;

	class Group extends Common{
		protected $insert = ['group_insert_time'];
		protected $update = ['group_update_time'];

		protected function setGroupInsertTimeAttr($value){
			return time();
		}
		protected function setGroupUpdateTimeAttr($value){
			return time();
		}

		protected function getGroupInsertTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}
		protected function getGroupUpdateTimeAttr($value){
			return date("Y-m-d H:i:s",$value);
		}


		public function list(){
			$list = $this::paginate(15);
			return $list;
		}

		/*
		一个小组可以有多个用户，一个用户只能属于一个小组。小组与用户是一对多的关系
		 */	
		public function user(){
			return $this -> belongsToMany('User','UserGroup');
		}

		/*
		group add
		 */
		public function add($data){
			halt($data);
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['group_status'] = 1;
			}else{
				$data['group_status'] = 0;
			}

			$validate = Loader::validate('Group');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('group_name',$data['group_name'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'小组名称已存在'];
			}
			
			$result = $this -> allowField(true) ->save($data);
			$group_id = $this -> group_id;
			$group = $this::get($group_id);
			(isset($data['user_ids'])) ? $group -> user() -> saveAll($data['user_ids']) : 0;
			if($result){
				return ['valid'=>1,'msg'=>'小组添加成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get one data about the id of group
		 */
		public function getOneInfo($group_id){
			$data_old = $this->where('group_id',$group_id)->find();
			return $data_old;
		}


		/*
		user who is selected
		 */
		public function userSelected($group_id){
			$group = $this :: get($group_id);
			$users = $group -> user() -> select();
			$arr = [];
			foreach ($users as $key => $value) {
				$arr[] = $value['user_id'];
			}
			return $arr;
		}

		/*
		This is update of group
		 */
		public function edit($data){
			// halt($data);
			//前端的是否显示开关
			if(isset($data['is_show']) && $data['is_show']=='on'){
				unset($data['is_show']);
				$data['group_status'] = 1;
			}else{
				$data['group_status'] = 0;
			}

			$validate = Loader::validate('Group');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$is_exist = $this->where('group_name',$data['group_name'])->whereNotIn('group_id',$data['group_id'])->find();
			if($is_exist){
				return ['valid'=>0,'msg'=>'小组名称已存在'];
			}

				
			$result = $this -> allowField(true) -> save($data,$data['group_id']);
			if($result){

				//如果小组保存成功，则更新中间表（user_group);>>>>>
				$group = $this::get($data['group_id']);
				if(isset($data['user_ids'])){
					//原来已选择的数据
					$user_selected = $group -> user() -> select();
					$user_old = [];
					foreach ($user_selected as $key => $value) {
						$user_old[] = $value['user_id'];
					}
					//用差集求要删除的数组
					$list_delete = array_diff($user_old,$data['user_ids']);
					if(!empty($list_delete)){
						(new \app\admin\model\UserGroup()) ->where('user_id','in',$list_delete) ->delete();
					}
					//用差集求要添加的数组
					$list_add = array_diff($data['user_ids'], $user_old);
					$group -> user() -> saveAll($list_add);
				}else{
					$group -> user() -> where('group_id',$data['group_id']) -> detach();
				}
				//如果小组保存成功，则更新中间表（user_group);<<<<<

				return ['valid'=>1,'msg'=>'小组修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		This is delete of group
		 */
		public function del($group_id){
			$res = $this::destroy($group_id);
			if($res){
				//如果小组保存成功，则更新中间表（user_group);>>>>>
				(new \app\admin\model\UserGroup()) ->where('group_id',$group_id) ->delete();
				//如果小组保存成功，则更新中间表（user_group);<<<<<

				return ['valid'=>1,'msg'=>'小组删除成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}

		/*
		get the list where status is 1.
		 */
		public function getList(){
			$groups = $this -> where('group_status',1) -> field('group_id,group_name') -> select();//column('group_name','group_id');//
			foreach ($groups as $key => &$value) {
				$group = $this::get($value['group_id']);
				$value['user_list'] = $group->user;
			}
			return $groups;
		}

		/*
		commission模型要跟据group_id查找group_name
		 */
		public function replace($id){
			return $this::where('group_id',$id)->value('group_name');
		}
	}