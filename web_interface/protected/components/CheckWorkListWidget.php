<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CheckWorkListWidget extends CWidget
	{
		//查看T_checkWork中作品的方法，有各种filter
		//有一个筛选接口(locationId,subtypeId,catalogId,checkStatus,competitorId,还有orderBy workId asc,desc
		//,还有feedNum,一次显示多少个,所以发送时要有startNum标识),以input.catalogId的change事件为准(其他input change调用input.catalogId的change)
		//一次显示n个，审核状态 两个input框，升序降序两个选择框 
		//点击输出checkWorkId		
		public $id = "checkWorkList";
		public $showToggle = false;//点击后是否保持一个深色状态
		public $targetSelector = "";//输出checkWorkId的地方//可以为数组
		public $targetWorkTitle = "";//输出workTitle的地方，字符串
		public $feedNum = "10";//一次获取多少个
		public $showInfo = false;//是否显示某赛区审核信息  
		public $showFeedNum = true;//是否显示一次获取多少作品的筛选器
		public $forCheck = false;//用于审核的作品列表，为true将向一个检查赛区是否开始审核的链接获取
		public $searchById = false;//是否显示通过ID搜索的功能
		
		//public $psubmit = false;//是否显示强制批量提交
		//public $pcheck = false;//是否显示强制批量审核
		public $moreOption = false;//显示更多操作按钮
		//****css
		public $colorBefore = "#0088cc";
		public $colorHover = "#0088ff";
		public $colorAfter = "white";
		//**filter初始的东西
		public $iLocation = "";
		public function run()
		{	
			$this->render("checkWorkList",array(
				'id' => $this->id,
				'showToggle' => $this->showToggle,
				'targetSelector' => $this->targetSelector,
				'targetWorkTitle' => $this->targetWorkTitle,
				'feedNum' => $this->feedNum,
				'showInfo' => $this->showInfo,
				"showFeedNum" => $this->showFeedNum,
				"forCheck" => $this->forCheck,
				"searchById" => $this->searchById,
			//	"psubmit" => $this->psubmit,
			//	"pcheck" => $this->pcheck,
				"moreOption" => $this->moreOption,
				//**css
				'colorBefore' => $this->colorBefore,
				'colorHover' => $this->colorHover,
				'colorAfter' => $this->colorAfter,
				//**各种filter的初始
				"iLocation" => $this->iLocation,
			));
		}
	}
?>