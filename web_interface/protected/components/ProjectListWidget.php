<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class ProjectListWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "projectList";
		public $userLevel;
		//获取新项目列表接口
			//外界直接调用 #id > input.project
			
		//点击project之后
		public $targetProjectId="";
		public $targetProjectName = "";
		public $targetProjectIntro = "";
		public $targetChange=array();
		//呼叫显示loading的接口
		public $loading="";
		public $stopLoading="";
		
		public function run()
		{
			if(empty($this->targetChange))
			{
				$this->targetChange[] = $this->targetProjectId;
			}
			$this->render('projectList',array(
				"id" => $this->id,
				"userLevel" => $this->userLevel,
				"targetProjectId" => $this->targetProjectId,
				"targetProjectName" => $this->targetProjectName,
				"targetProjectIntro" => $this->targetProjectIntro,
				"targetChange" => $this->targetChange,
				"loading" => $this->loading,
				"stopLoading" => $this->stopLoading,
			));
		}
	}
	
?>