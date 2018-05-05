<?php
	namespace app\admin\controller;
	use think\Session;

	class Index extends Common{
		public function index(){
			return $this -> fetch();
		}
	}