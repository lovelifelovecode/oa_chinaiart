<?php
	namespace app\admin\controller;
	use think\Request;

	/*
	提成规则
	 */
	class Rule extends Common{
		public $db;
		public function _initialize(){
			parent::_initialize();
			$this->db = new \app\admin\model\Rule();
		}

		/*
		The list is about Rule;
		 */
		public function list(){
			$list = $this -> db -> list();
			$this -> assign('list',$list);
			return $this -> fetch();
		}

		/*
		addition rule.
		 */
		public function add(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> add(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/rule/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			return $this -> fetch();
		}

		/*
		This is update of rule
		 */
		public function edit(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> edit(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/rule/list';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			$rule_id = Request::instance()->param('rule_id');
			$data_old = $this->db->getOneInfo($rule_id);
			$data_old['rule_grade'] *= 100;
			// halt($data_old);
			$this -> assign('data_old',$data_old);
			return $this -> fetch();
		}

		/*
		This is delete of rule
		 */
		public function del(){
			$rule_id = Request::instance()->param('rule_id');
			$res = $this->db->del($rule_id);
			if($res['valid']){
				$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/rule/list';
				Common::alert_success($res['msg'],$obj_url);exit;
			}else{
				Common::alert_fail($res['msg']);exit();
			}
		}
	}