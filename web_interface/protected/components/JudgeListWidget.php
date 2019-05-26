<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class JudgeListWidget extends CWidget
	{
		/*
			完全基于ajax获取
			
		*/
		//***外观属性
		public $id = "judgeList";
	
		public $bgColor = "rgb(253,253,253)";
		public $hoverToggleColor = COLORDARK;
		public $borderColor = "silver";
		//**功能属性
		public $hasDelete = false;//是否有删除评委按钮
		public $toggle = false;//点击后保持css-toggle;//所有workBlock点击都会触发targetSelector的change事件，（当targetSelector不为空）
		public $targetSelector = "";//直接"div.** > ",外面在js中已经有引号包裹 //填充judgeId的地方 
		public $targetName = "";//userName的填充
		public $instantLoad = true;//document ready就ajax获取
		//是否显示评委资料
		public $showContent = false;
		//**judge筛选器属性,goodAtType array(),isProved
		public $goodAtId = "all";//暂时是单workSubTypeId,
		public $zoneId = "";
		public $provedOnly = false;
		public $overflowHeight = "";
		//是否有按照评委登录名搜索功能
		public $hasSearch = false;
		//是否有重置密码功能
		public $hasResetPw = false;
		//是否有禁止进入功能，在别的流程使用接口判断( file cache "judgeNotAllowList")
		//**
		public $hasJudgeNotAllowList = false;
		public function run()
		{
			$this->render("judgeList",array(
				"id" => $this->id,
				
				'bgColor' => $this->bgColor,
				"hoverToggleColor" => $this->hoverToggleColor,
				"borderColor" => $this->borderColor,
				
				'hasDelete' => $this->hasDelete,
				'toggle' => $this->toggle,
				'targetSelector' => $this->targetSelector,
				'targetName' => $this->targetName,
				'instantLoad' => $this->instantLoad,
				'showContent' => $this->showContent?1:0,
				
				'goodAtId' => $this->goodAtId,
				"provedOnly" => $this->provedOnly,
				"overflowHeight" => $this->overflowHeight,
				"zoneId" => $this->zoneId,
				"hasSearch" => $this->hasSearch,
				"hasResetPw" => $this->hasResetPw,
				"hasJudgeNotAllowList" => $this->hasJudgeNotAllowList,
			));
		}
	}
?>