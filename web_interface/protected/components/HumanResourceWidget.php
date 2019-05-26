<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class HumanResourceWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "humanResource";
		public $listen;//监听 此object的change事件，发生就载入
		
		//是否成员的响应
		public $target = array(
		/*
			"userName" => "",
			"nickName" => "",
			"userId" => "",
			"trigger" => "",
		*/
		);
		//是否可以修改分组
		public $canEdit = false;
		//是否显示"人力资源分组"
		public $noHeader = false;
		//是否显示“全部组”,即与此用户关联的组,组号是－1
		public $showAll = false;
		public function run()
		{
			$this->render('humanResource',array(
				"id" => $this->id,
				"listen" => $this->listen,
				"target" => $this->target,
				"canEdit" => $this->canEdit,
				"noHeader" => $this->noHeader,
				"showAll" => $this->showAll,
			));
		}
	}
	
?>