<?php
	namespace app\admin\model;
	use think\Loader;
	/**
	* This class is about user infotation.
	*/
	class User extends Common
	{
		public function passwordEdit($data){
			$validate = Loader::validate('User');
			if(!$validate->check($data)){
			    return ['valid'=>0,'msg'=>$validate->getError()];
			}

			$password_old = $this ->where('user_id',$data['user_id']) -> value('user_password');
			if($password_old != md5(md5('skyuse').md5($data['password_old']))){
				return ['valid'=>0,'msg'=>'旧密码输入有误，请重新输入'];
			}

			$res = $this-> where('user_id',$data['user_id'])->update(['user_password'=>md5(md5('skyuse').md5($data['password_new']))]);
			if($res){
				return ['valid'=>1,'msg'=>'密码修改成功'];
			}else{
				return ['valid'=>0,'msg'=>$this->getError()];
			}
		}
	}