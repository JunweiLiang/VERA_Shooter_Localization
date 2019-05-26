<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class WorkListWidget extends CWidget
	{
		/*
			为参赛者与作品查阅员使用，查看catalog或者competitor分类的作品列表，有选择功能，可以显示内容或者不显示,
			完全基于ajax获取
			外界交互主要对#id > form > input.competitorId进行附值与触发其change事件，widget内绑定change事件，进行刷新操作 
			外界也可以直接调用$(#id > div.main > div.workList > div.workBlock).click()
		*/
		//***外观属性
		public $id = "workList";
		public $width = "180px";
	//	public $bgColor = "rgb(253,253,253)";
	//	public $hoverToggleColor = "rgb(235,235,235)";//增加了提交作品后的不同颜色提示
	//	public $borderColor = "silver";
		//**功能属性
		public $toggle = false;//点击后保持css-toggle;//所有workBlock点击都会触发targetSelector的change事件，（当targetSelector不为空）
		public $targetSelector = "";//直接"div.** > ",外面在js中已经有引号包裹 
		public $instantLoad = true;//document ready就ajax获取
		public $showContent = false;
		//**work筛选器属性(初始值)，外界可以通过"#id > input.catalogId"
		public $competitorId = "all";
		public $sumSelector;//将填充未提交总数至此selector的html()
		//**
		public function run()
		{
			$this->render("workList",array(
				"id" => $this->id,
				'width' => $this->width,
			//	'bgColor' => $this->bgColor,
			//	"hoverToggleColor" => $this->hoverToggleColor,
			//	"borderColor" => $this->borderColor,
				
				'toggle' => $this->toggle,
				'targetSelector' => $this->targetSelector,
				'instantLoad' => $this->instantLoad,
				'showContent' => $this->showContent?1:0,
				
				"competitorId" => $this->competitorId,
				'sumSelector' => $this->sumSelector,
			));
		}
	}
?>