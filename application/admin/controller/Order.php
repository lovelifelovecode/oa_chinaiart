<?php
	namespace app\admin\controller;
	use think\Request;

	class Order extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\Order();
		}

		/*
		The list is about Order;
		 */
		public function list(){
			$order = (Request::instance()->param('order') == 'asc')?'desc':'asc';
			$column = (Request::instance()->param('column'))?(Request::instance()->param('column')):'order_id';
			if(Request::instance() -> isPost()){
				$list = $this -> db -> search(Request::instance() -> param());
			}else{
				$list = $this -> db -> list($column,$order);
			}
			$this -> assign('list',$list);
			$this -> assign('order',$order);
			return $this -> fetch();
		}

		/*
		addition order.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/order/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$rules  = (new \app\admin\model\Rule())  -> getList();
			$this -> assign('rules',$rules);
			return $this -> fetch();
		}

		/*
		This is update of order
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/order/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$order_id = Request::instance()->param('order_id');
			$data_old = $this->db->getOneInfo($order_id);
			// halt($data_old);
			$this -> assign('data_old',$data_old);

			$rules  = (new \app\admin\model\Rule())  -> getList();
			$this -> assign('rules',$rules);
			
			return $this -> fetch();
		}

		/*
		This is update of order
		 */
		public function view(){
			$order_id = Request::instance()->param('order_id');
			$data_old = $this->db->getOneInfo($order_id);
			// halt($data_old);
			$this -> assign('data_old',$data_old);

			$rules  = (new \app\admin\model\Rule())  -> getList();
			$this -> assign('rules',$rules);
			return $this -> fetch();
		}

		/*
		This is delete of order
		 */
		public function del(){
			$order_id = Request::instance()->param('order_id');
			$res = $this->db->del($order_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/order/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}