<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class WorkPersonWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "workPerson";
		public $listen;//监听 input.projectId
		public $listenCanEdit = "";//监听是否可写,以添加删除框
		
		//是否有点击功能(userId,userName的响应)
		public $targetArr = array();
		
		public function run()
		{
			$this->render('workPerson',array(
				"id" => $this->id,
				"listen" => $this->listen,
				"listenCanEdit" => $this->listenCanEdit,
				"targetArr" => $this->targetArr,
			));
		}
	}
	
?>