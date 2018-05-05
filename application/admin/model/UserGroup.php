<?php
	namespace app\admin\model;

	class UserGroup extends Common{
		protected $insert = ['insert_time'];

		protected function setInsertTimeAttr($value){
			return time();
		}
	}