<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class ProjectWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "project";
		public $userLevel;
		public $username;
		public $nickname;
		//获取项目细节接口
			//外界直接调用 #id > input.projectId change, name,intro
			
		//呼叫显示loading的接口
		public $loading="";
		public $stopLoading="";
		
		public $hidden = true;//初始的时候是否隐藏
		
		public function run()
		{
			$this->render('project',array(
				"id" => $this->id,
				"userLevel" => $this->userLevel,
				"username" => $this->username,
				"nickname" => $this->nickname,
				
				"loading" => $this->loading,
				"stopLoading" => $this->stopLoading,
				"hidden" => $this->hidden,
			));
		}
	}
	
?>