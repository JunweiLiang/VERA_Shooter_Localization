<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
	class UserManageWidget extends CWidget
	{
		//接收权限列表，得到所管理的用户列表，管理的操作集
		public $getUserUrl;//ajax获取用户列表的url
		public $getCataUrl;//ajax获取栏目的url
		public $addUserUrl;//ajax新增用户的url
		public $deleteUserUrl;//删除用户 url
		public $changeUserUrl;//ajax改变用户的url
		public $resetPwUserUrl;
		public $copyUserUrl;
		public $ifUserNameExistsUrl;//检查用户名是否存在的url
		public $id;//装载整个widget的div id
		public $catalogArray = array();//栏目列表
		public $isSuper = false;
		//是否有密码重置功能
		
		public function run()
		{
			
			$this->render('userManage',array(
				'id' => $this->id,
				'getCataUrl' => $this->getCataUrl,
				'getUserUrl' => $this->getUserUrl,
				'addUserUrl' => $this->addUserUrl,
				'changeUserUrl' => $this->changeUserUrl,
				'deleteUserUrl' => $this->deleteUserUrl,
				"resetPwUserUrl" => $this->resetPwUserUrl,
				'ifUserNameExistsUrl' => $this->ifUserNameExistsUrl,
				'catalogArray' => $this->catalogArray,
				'isSuper' => $this->isSuper,
				"copyUserUrl" => $this->copyUserUrl,
			));
		}
	}
?>