<?php
	namespace app\admin\controller;
	use think\Request;

	class Group extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\Group();
		}

		/*
		The list is about Group;
		 */
		public function list(){
			$list = $this -> db -> list();
			$this -> assign('list',$list);
			return $this -> fetch();
		}

		/*
		addition group.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/group/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}

			$user_list = (new \app\admin\model\User()) -> getList();
			$this -> assign('user_list',$user_list);
			return $this -> fetch();
		}

		/*
		This is update of group
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/group/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			//old data;
			$group_id = Request::instance()->param('group_id');
			$data_old = $this->db->getOneInfo($group_id);
			$this -> assign('data_old',$data_old);

			//user list.
			$user_list = (new \app\admin\model\User()) -> getList();
			$this -> assign('user_list',$user_list);

			//user who is selected.
			$user_selected = $this -> db -> userSelected($group_id);
			$this -> assign('user_selected',$user_selected);
			return $this -> fetch();
		}

		/*
		This is delete of group
		 */
		public function del(){
			$group_id = Request::instance()->param('group_id');
			$res = $this->db->del($group_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/group/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}