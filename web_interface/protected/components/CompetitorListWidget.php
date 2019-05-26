<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CompetitorListWidget extends CWidget
	{
		//展示参赛者列表以及相应赛区的info,同时还有 学校的统计
		//有赛区，地区，作品种类的filter
		public $id = "competitorList";
		public $showSchool = false;
		public $showHead = true;
		public $initCatalog = "";
		public $initWorkSubType = "";
		public $initLocation = "all";
		public $toggle = false;//是否点击后高亮
		public $hasAll = false;//是否头部有一项“quanbu”
		public $showSum = true;//是否在每个block中显示此账户的提交总数
		public $targetArr = array();
		/*
			//填充userId,userName的地方
			array(
				array("userId"=>"","userName"=>),
				array("userId"=>"","userName"=>),
			)
		*/
		public function run()
		{
			$this->render("competitorList",array(
				"id" => $this->id,
				"showSchool" => $this->showSchool,
				"targetArr" => $this->targetArr,
				"showHead" => $this->showHead,
				"initCatalog" => $this->initCatalog,
				"initWorkSubType" => $this->initWorkSubType,
				"initLocation" => $this->initLocation,
				"toggle" => $this->toggle,
				"hasAll" => $this->hasAll,
				"showSum" => $this->showSum,
			));
		}
	}
?>