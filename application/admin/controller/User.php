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
			$list = Db::name('user')->select();
			$this -> assign('list',$list);
			return $this -> fetch();
		}

		/*
		addtion user info
		 */
		public function useradd(){
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
			return $this -> fetch();
		}
	}