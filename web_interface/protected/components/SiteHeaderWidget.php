<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	class SiteHeaderWidget extends CWidget
	{
		//可以自使用电脑屏幕与手机屏幕
		public $id = "siteHeader";
		public $username;
		public $userLevel;
		//载入中接口
			//外界直接调用 #id > input.loading/stopLoading 
			
		//新增项目后的 项目名填充处，以及会触发change事件的地方，默认一样
		public $targetName="";
		public $targetChange=array();
		
		public $headerChange = array();//点击首logo后响应的change事件
		
		//点击项目列表中的项目的响应
		public $targetProjectId="";
		public $targetProjectName = "";
		public $targetProjectIntro = "";
		public $targetChangeP=array();
		
		public function run()
		{
			if(empty($this->targetChange))
			{
				$this->targetChange[] = $this->targetName;
			}
			if(empty($this->targetChangeP))
			{
				$this->targetChangeP[] = $this->targetProjectId;
			}
			$this->render('siteHeader',array(
				"id" => $this->id,
				"username" => $this->username,
				"userLevel" => $this->userLevel,
				"targetName" => $this->targetName,
				"targetChange" => $this->targetChange,
				
				"targetProjectId" => $this->targetProjectId,
				"targetProjectName" => $this->targetProjectName,
				"targetProjectIntro" => $this->targetProjectIntro,
				"targetChangeP" => $this->targetChangeP,
				
				"headerChange" => $this->headerChange,
			));
		}
	}
	
?>