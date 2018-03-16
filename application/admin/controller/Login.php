<?php
	namespace app\admin\controller;
	use think\Controller;
	use think\Request;
	use think\Session;

	/*
	This class is about landing.
	 */
	class Login extends Controller{
		protected $db;
		protected function _initialize(){
			parent::_initialize();
			$this -> db = new \app\admin\model\Login();
		}

		/*
		This is about login.
		 */
		public function login(){
			if(Request::instance()->isPost()){
				$res = $this -> db -> login(Request::instance() -> param());
				if($res['valid']){
					$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/index/index';
					Common::alert_success($res['msg'],$obj_url);exit;
				}else{
					Common::alert_fail($res['msg']);exit();
				}
			}
			return $this -> fetch();
		}

		/*
		This is about logout
		 */
		public function logout(){
			Session::delete('user.user_id');
			Session::delete('user.user_username');
			Session::delete('user.session_time');
			$obj_url = Request::instance()->domain().Request::instance()->baseFile().'/login/login';
			Common::alert_success('退出成功',$obj_url);exit;
		}
	}