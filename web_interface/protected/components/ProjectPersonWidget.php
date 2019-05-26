<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class ProjectPersonWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "projectPerson";
		public $listen;//监听 input.projectId
		public $listenCanEdit = "";//监听是否可写;
		
		//是否有点击功能(userId,userName的响应)
		public $targetArr = array();
		
		//是否有头
		public $header = true;
		//是否有添加成员功能
		public $addMember = true;
		
		public $ctrMember = true;
		
		//widget内发生修改后触发刷新请求的selector
			//添加成员后
		public $refreshAdd = array();
			//删除成员后
		public $refreshRemove = array();
		//是否显示人力资源的全部组
		public $showAll = false;
		//是否显示项目日志
		public $showLog = false;
		//是否有浮出选择功能
		public $additionChoose = false;
		public $additionTarget = array();
		
		//是否显示自己
		public $showMe = true;
		public function run()
		{
			$this->render('projectPerson',array(
				"id" => $this->id,
				"listen" => $this->listen,
				"listenCanEdit" => $this->listenCanEdit,
				"targetArr" => $this->targetArr,
				"header" => $this->header,
				"addMember" => $this->addMember,
				"ctrMember" => $this->ctrMember,
				"refreshAdd" => $this->refreshAdd,
				"refreshRemove" => $this->refreshRemove,
				"showAll" => $this->showAll,
				"showLog" => $this->showLog,
				"additionChoose" => $this->additionChoose,
				"additionTarget" => $this->additionTarget,
				"showMe" => $this->showMe,
			));
		}
	}
	
?>