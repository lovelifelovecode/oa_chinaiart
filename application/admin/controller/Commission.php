<?php
	namespace app\admin\controller;
	use think\Request;

	/*
	提成规则
	 */
	class Commission extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\Commission();
		}

		/*
		The list is about Commission;
		 */
		public function list(){
			$order = (Request::instance()->param('order') == 'asc')?'desc':'asc';
			$column = (Request::instance()->param('column'))?(Request::instance()->param('column')):'commission_id';
			if(Request::instance() -> isPost()){
				$list = $this -> db -> search(Request::instance() -> param());
			}else{
				$list = $this -> db -> list($column,$order);
			}
			$this -> assign('list',$list);
			$this -> assign('order',$order);
			// halt($list);
			return $this -> fetch();
		}

		/*
		addition commission.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/commission/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$orders = (new \app\admin\model\Order()) -> getList();
			$users = (new \app\admin\model\User()) -> getList();
			$this -> assign('orders',$orders);
			$this -> assign('users',$users);
			return $this -> fetch();
		}

		/*
		This is update of commission
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/commission/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$orders = (new \app\admin\model\Order()) -> getList();
			$users = (new \app\admin\model\User()) -> getList();

			$this -> assign('orders',$orders);
			$this -> assign('users',$users);

			$commission_id = Request::instance()->param('commission_id');
			$data_old = $this->db->getOneInfo($commission_id);
			$data_old['percentages'] = json_decode($data_old['commission_percentage'],TRUE);
			$this -> assign('data_old',$data_old);
// halt($data_old);
			return $this -> fetch();
		}

		/*
		This is delete of commission
		 */
		public function del(){
			$commission_id = Request::instance()->param('commission_id');
			$res = $this->db->del($commission_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/commission/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}