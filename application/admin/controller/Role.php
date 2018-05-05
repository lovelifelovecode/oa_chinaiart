<?php
	namespace app\admin\controller;
	use think\Request;

	class Role extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\Role();
		}

		/*
		The list is about Role;
		 */
		public function list(){
			$list = $this -> db -> list();
			$this -> assign('list',$list);
			return $this -> fetch();
		}

		/*
		addition role.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/role/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$authority_list = (new \app\admin\model\Authority()) -> where('authority_status',1) -> select();
			$this -> assign('authority_list',$authority_list);
			return $this -> fetch();
		}

		/*
		This is update of role
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/role/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}

			$role_id = Request::instance()->param('role_id');
			$data_old = $this->db->getOneInfo($role_id);
			$this -> assign('data_old',$data_old);

			$authority_list = (new \app\admin\model\Authority()) -> where('authority_status',1) -> select();
			$this -> assign('authority_list',$authority_list);

			$selected_old = (new \app\admin\model\RoleAuthority()) -> where('role_id',$role_id) -> column('authority_id');
			$this -> assign('selected_old',$selected_old);
			
			return $this -> fetch();
		}

		/*
		This is delete of role
		 */
		public function del(){
			$role_id = Request::instance()->param('role_id');
			$res = $this->db->del($role_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/role/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}