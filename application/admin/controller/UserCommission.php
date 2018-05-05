<?php
	namespace app\admin\controller;
	use think\Request;

	/*
	提成规则
	 */
	class UserCommission extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\UserCommission();
		}

		/*
		The list is about Commission;
		 */
		public function list(){
			$order = (Request::instance()->param('order') == 'asc')?'desc':'asc';
			$column = (Request::instance()->param('column'))?(Request::instance()->param('column')):'id';
			if(Request::instance() -> isPost()){
				$res = $this -> db -> search(Request::instance() -> param());
				if($res['valid']){
					$list = $res['list'];
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}else{
				$list = $this -> db -> list($column,$order);
			}
			$this -> assign('list',$list);
			$this -> assign('order',$order);

			$total = 0.0;
			$commission_sum = 0.0;
			$this -> assign('total',$total);
			$this -> assign('commission_sum',$commission_sum);
			return $this -> fetch();
		}

		/*
		addition commission.
		 */
		public function add(){
			halt('操作有误'.__FILE__.':'.__LINE__);
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/commission/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
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
			$commission_id = Request::instance()->param('commission_id');
			$data_old = $this->db->getOneInfo($commission_id);
			// halt($data_old);
			$this -> assign('data_old',$data_old);
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