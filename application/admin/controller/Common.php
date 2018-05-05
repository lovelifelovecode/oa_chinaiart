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
			if(!Session::get('user.user_id') || (time()-Session::get('user.session_time'))>1200){
				//如果没有登陆，则跳到登陆页面
				$this->redirect('app/admin/login/login');
			}else{
				Session::set('user.session_time',time());
				//判断是否为超级管理员
				$user_info = (new \app\admin\model\User())->get(session('user.user_id'));
				if(empty($user_info['user_admin'])){
					$this->authority();
				}

				// //记录操作日志
				// $this->operationLog();
			}
		}


		//判断是否有权限
		protected function authority(){
			/**
			 * 判断权限的逻辑是
			 * 取出当前登录用户的所属角色，
			 * 在通过角色 取出 所属 权限关系
			 * 在权限表中取出所有的权限链接
			 * 判断当前访问的链接 是否在 所拥有的权限列表中
			 */
			/**
			 * 具体步骤如下:
			 * 1.通过用户id在用户角色表中查出所属的所有角色
			 * 2.用角色通过角色权限表查出所属的所有权限
			 * 3.用权限通过权限表查出所属的所有权限的url
			 * 4.判断当前的url是否有所属的所有权限的url中
			 */
			//step1.通过用户id在用户角色表中查出所属的所有角色
			$user_id = session('user.user_id');
			$roles = (new \app\admin\model\UserRole())->all(['user_id' => $user_id]);
			if(!$roles){
				$this->redirect('app/admin/login/noAuthority', ['msg' => '您不属于任何角色,所以没有任何权限,请与管理员联系。']);
				exit;
			}

			// 测试有多少个角色
			/*foreach ($roles as $key => $value) {
				dump($value->toArray());
			}
			exit;*/

			//step2.用角色通过角色权限表查出所属的所有权限
			$authoritysArr = [];
			foreach ($roles as $value) {
				$authoritysArr[] = (new \app\admin\model\RoleAuthority())->all(['role_id'=>$value['role_id']]);
			}

			//测试有多少个权限
			// foreach ($authoritysArr as $key => $value) {
			// 	foreach ($value as $key => $king) {
			// 		dump($king->toArray());
			// 	}
			// }
			// exit;

			//合并成权限数组
			$authority_ids = [];
			foreach ($authoritysArr as $value) {
				foreach ($value as $home) {
					$authority_ids[] = $home['authority_id'];
				}
			}
			// halt($authority_ids);
			$authority_ids = array_unique($authority_ids);
			// halt($authority_ids);
			if(empty($authority_ids)){
				$this->redirect('app/admin/login/noAuthority',['msg'=>'您没有任何权限，请与管理员联系。']);
			}

			//step3.用权限通过权限表查出所属的所有权限的url
			$urlJsonArr = [];
			foreach ($authority_ids as $key => $value) {
				// dump($value['access_id']);
				$urlJsonArr[] = (new \app\admin\model\Authority())->all(['authority_id'=>$value]);
			}

			//测试有多少个urls json 组
			/*foreach ($urlJsonArr as $key => $value) {
				dump($value[0]->toArray());
			}
			exit;*/

			//step4.用json_decode()遍历所有权限的url
			$urlsArr = [];
			foreach ($urlJsonArr as $value) {
				// dump($value);	
				$urlsArr[] = json_decode($value[0]['authority_urls']);
			}

			//step5.合并成urls数组
			$urls = [];
			foreach ($urlsArr as $value) {
				foreach ($value as $home) {
					$urls[] = $home;
				}
			}

			//step6.判断当前的url是否有所属的所有权限的url中	
			$url_pattern= '/\\'.Request::instance()->baseFile().'\/'.Request::instance()->module().'\/'.$this->translatePath(Request::instance()->controller()).'\/'.Request::instance()->action().'/';

			$res = preg_grep($url_pattern, $urls);
			if(empty($res)){
				$this->redirect('app/admin/login/noAuthority',['msg'=>'您没有权限，请与管理员联系。']);
			}
			//step6.判断当前的url是否有所属的所有权限的url中	
			// echo Request::instance()->url() . '<br/>';
			/*if(!in_array(Request::instance()->url(), $urls)){
				$this->redirect('app/admin/admin_login/noAuthority',['msg'=>'您没有权限，请与管理员联系。']);
			}*/
			// exit;
		}

		//translatePath 首字母小写，然后第二个大写字母开始，转为_加其小写(注只支持5层)
	    public function translatePath($str){
		    $str = lcfirst($str);

			preg_match_all('/[A-Z]/',$str,$res);
			// var_dump($res[0]);exit;
			if(count($res[0]) == 1){
			    $str = preg_replace_callback('/(\w+)([A-Z])(\w+)/',function ($matches) {
	            	return $matches[1].'_'.strtolower($matches[2]).$matches[3];
	        	},$str);
				return $str;
			}
			if(count($res[0]) == 2){
			    $str = preg_replace_callback('/(\w+)([A-Z])(\w+)([A-Z])(\w+)/',function ($matches) {
	            	return $matches[1].'_'.strtolower($matches[2]).$matches[3].'_'.strtolower($matches[4]).$matches[5];
	        	},$str);
			    return $str;
			}
			if(count($res[0]) == 3){
			    $str = preg_replace_callback('/(\w+)([A-Z])(\w+)([A-Z])(\w+)([A-Z])(\w+)/',function ($matches) {
	            	return $matches[1].'_'.strtolower($matches[2]).$matches[3].'_'.strtolower($matches[4]).$matches[5].'_'.strtolower($matches[6]).$matches[7];
	        	},$str);
			    return $str;
			}
			if(count($res[0]) == 4){
			    $str = preg_replace_callback('/(\w+)([A-Z])(\w+)([A-Z])(\w+)([A-Z])(\w+)([A-Z])(\w+)/',function ($matches) {
	            	return $matches[1].'_'.strtolower($matches[2]).$matches[3].'_'.strtolower($matches[4]).$matches[5].'_'.strtolower($matches[6]).$matches[7].'_'.strtolower($matches[8]).$matches[9];
	        	},$str);
			    return $str;
			}
			return $str;
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