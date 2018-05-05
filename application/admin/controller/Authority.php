<?php
	namespace app\admin\controller;
	use think\Request;

	/**
	* Authority
	*/
	class Authority extends Common
	{
		protected $db;
		public function _initialize(){
			parent::_initialize();
			$this ->db = new \app\admin\model\Authority();
		}

		/*
		This function is about list of authority.
		 */
		public function list(){
			$list = $this->db->list();
			$this->assign('list',$list);
			return $this -> fetch();
		}

		/*
		This is addtion of authority.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/authority/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			return $this -> fetch();
		}

		/*
		This is update of authority
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/authority/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$authority_id = Request::instance()->param('authority_id');
			$data_old = $this->db->getOneInfo($authority_id);
			// halt($data_old);
			$this -> assign('data_old',$data_old);
			return $this -> fetch();
		}

		/*
		This is delete of authority
		 */
		public function del(){
			$authority_id = Request::instance()->param('authority_id');
			$res = $this->db->del($authority_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/authority/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}