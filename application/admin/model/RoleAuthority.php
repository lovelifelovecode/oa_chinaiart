<?php
	namespace app\admin\model;

	/**
	*role_aothority
	*/
	class RoleAuthority extends Common{
		protected $insert = ['insert_time'];
		
		protected function setInsertTimeAttr($value){
			return time();
		}
	}