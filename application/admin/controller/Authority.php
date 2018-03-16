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
			return $this -> fetch();
		}

		/*
		This is addtion of autority.
		 */
		public function authorityadd(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> authorityadd(Request::instance()->param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/index/index';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			return $this -> fetch();
		}

	}