<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class PersonLogWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "personLog";
		public $listen;//监听 input.projectId
		
		//是否使用overlay且展示时占满屏幕
		//public $overlayShow = true;
		
		public function run()
		{
			$this->render('personLog',array(
				"id" => $this->id,
				"listen" => $this->listen,
				//"overlayShow" => $this->overlayShow,
			));
		}
	}
	
?>