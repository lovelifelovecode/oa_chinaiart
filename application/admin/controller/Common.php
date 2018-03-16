<?php
	namespace app\admin\controller;
	use think\Controller;
	use think\Request;
	use think\Session;
	/**
	*public file 
	*/
	class Common extends Controller
	{
		public function __construct(Request $request=null){
			parent::__construct($request);

			//执行登录验证
			//$_SESSION['admin']['admin_id'];
			if(!Session::get('user.user_id') || (time()-Session::get('user.session_time'))>3600){
				//如果没有登陆，则跳到登陆页面
				$this->redirect('app/admin/login/login');
			}/*else{
				//判断是否为超级管理员
				$is_admin = (new \app\admin\model\AdminUser())->get(session('user.user_id'));
				if(empty($is_admin['user_is_admin'])){
					$this->authority();
				}

				//记录操作日志
				$this->operationLog();
			}*/
		}


		/**
		 * Test the page prompt for the successful jump.
		 * $msg 待提示的消息
		 * $url 待跳转的链接
		 */
		public static function alert_success($msg='',$url=''){ 
		  echo "<script>alert('$msg');location.href='$url';</script>";
		}
	 
		/**
		 * Test the page prompt of the failed jump.
		 * $msg 待提示的消息
		 */
		public static function alert_fail($msg=''){
		  echo "<script>alert('$msg');history.back();</script>";
		}
	}