<?php
	namespace app\admin\model;

	/*
	Authority
	 */
	class Authority extends Common{
		protected $insert = ['authority_insert_time'];
		protected $update = ['authority_update_time'];

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
		authority add
		 */
		public function authorityadd($data){
			halt($data);
		}
	}