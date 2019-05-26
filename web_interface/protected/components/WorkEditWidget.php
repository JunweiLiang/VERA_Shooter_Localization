<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class WorkEditWidget extends CWidget
	{
		/*
			编辑作品控件，完全基于ajax,控件中监听#id > input.workId的change事件,外界调用change事件就发生载入 
			空控件有保存的与提交的（只显示 ），根据lock决定显示
			有载入控件验证，在competitorController中验证			
		*/
		//外观属性
		public $id = "workEdit";
		public $loadingOpa = "70";//change事件发生时，载入workId的work,的loading蒙板的透明度
		public $width = "800px";
		public $overflow = true;//是否overflow。会设置overflow以及高度随浏览器变化 
		public $fixedHead = false;//是否滑动过某高度后把保存按钮的div fixed head
		public $fixedTop = 0;//滑过之后fixed 时的 top
		//功能属性
		//public $instantLoad = false;
		//public $workId = "";//设置了instantLoad
		public $authorTypeArr = array();
		public $school = "";
		//已经提交的是否可以保存
		public $allowSubmittedSave = false;
		public function run()
		{
		
			$this->render("workEdit",array(
				'id' => $this->id,
				'authorTypeArr' => $this->authorTypeArr,
				'school' => $this->school,
				'loadingOpa' => $this->loadingOpa,
				'width' => $this->width,
				"overflow" => $this->overflow,
				"fixedHead" => $this->fixedHead,
				"fixedTop" => $this->fixedTop,
				"allowSubmittedSave" => $this->allowSubmittedSave,
			));
		}
	}
?>