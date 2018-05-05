<?php
	namespace app\admin\controller;
	use think\Request;
	use think\Db;

	class User extends Common{
		protected $db;

		public function _initialize(){
			parent::_initialize();
			$this -> db = new \app\admin\model\User();
		}

		/*
		The list of user info;
		 */
		public function list(){
			$order = (Request::instance()->param('order') == 'asc')?'desc':'asc';
			// $user_id = (Request::instance()->param('user_id'))?(Request::instance()->param('user_id')):null;
			$column = (Request::instance()->param('column'))?(Request::instance()->param('column')):'user_id';
			if(Request::instance() -> isPost()){
				$list = $this -> db -> search(Request::instance() -> param());
			}else{
				$list = $this -> db -> list($column,$order);
			}

			$this -> assign('order',$order);
			$this -> assign('list',$list);
			return $this -> fetch();
		}

		/*
		addtion user info
		 */
		
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/user/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$role_list = (new \app\admin\model\Role()) -> where('role_status',1) -> select();
			$this -> assign('role_list',$role_list);
			return $this -> fetch();
		}

		/*
		edit of user info
		 */
		public function useredit(){

			return $this -> fetch();
		}

		/*
		edit of user password
		 */
		public function passwordEdit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> passwordEdit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/index/index';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}

			// return $this -> fetch();
		}

		/*
		This is update of user
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/user/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$user_id = Request::instance()->param('user_id');
			$data_old = $this->db->getOneInfo($user_id);
			$this -> assign('data_old',$data_old);

			
			$role_list = (new \app\admin\model\Role()) -> where('role_status',1) -> select();
			$this -> assign('role_list',$role_list);

			$selected_old = (new \app\admin\model\UserRole()) -> where('user_id',$user_id) -> column('role_id');
			$this -> assign('selected_old',$selected_old);

			return $this -> fetch();
		}

		/*
		This is delete of user
		 */
		public function del(){
			$user_id = Request::instance()->param('user_id');
			$res = $this->db->del($user_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/user/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}