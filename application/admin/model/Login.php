<?php
	namespace app\admin\model;
	use think\Session;
	/*
	This class is about landing.
	 */
	class Login extends Common{
		protected $name='user';

		protected $insert = ['user_insert_time'];
		protected $update = ['user_update_time'];

		protected function setUserInsertTimeAttr($value){
			return time();
		}
		protected function setUserUpdateTimeAttr($value){
			return time();
		}

		protected function getUserInsertTimeAttr($value){
			return data("Y-m-d H:i:s",$value);
		}
		protected function getUserUpdateTimeAttr($value){
			return data("Y-m-d H:i:s",$value);
		}

		/*
		This is about login.
		 */
		public function login($data){
			$res = $this -> where('user_username',$data['username'])->find();
			if(!$res){
				return ['valid'=>0,'msg'=>'用户名不存在!'];
			}
			$res = $this -> where('user_username',$data['username'])->where('user_password',md5(md5('skyuse').md5($data['password'])))->find();
			if($res){
				//3.将用户信息存入到session中
				Session::set('user.user_id',$res['user_id']);
				Session::set('user.user_username',$res['user_username']);
				Session::set('user.session_time',time());
				return ['valid'=>1,'msg'=>'登录成功'];
			}else{
				return ['valid'=>0,'msg'=>'密码不正确'];
			}
		}
	}