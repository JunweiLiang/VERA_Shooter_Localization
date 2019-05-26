<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class LocationListWidget extends CWidget
	{
		//地点列表部件
		//点击输出locationId		
		public $id = "locationList";
		public $locArr = array();//外部不指定 地点总集合时，会自动按默认获取
		public $showToggle = false;//点击后是否保持一个深色状态
		public $hasAll = false;//是否含有“全部”这个选项 div.block,点击输出"all"给target
		public $targetSelector = "";//输出locationId的地方
		public $targetLocationName = "";//输出locationName的地方
		public $instantChange = false;
		//****css
		public $colorBefore = "#0088cc";
		public $colorHover = "#0088ff";
		public $colorAfter = "white";
		public function run()
		{
			if(empty($this->locArr))
			{
				$temp = Location::model()->findAll();
				foreach($temp as $b)
				{
					$this->locArr[] = $b->attributes;
				}
			}
			
			$this->render("locationList",array(
				'id' => $this->id,
				'locArr' => $this->locArr,
				'showToggle' => $this->showToggle,
				'hasAll' => $this->hasAll,
				'targetSelector' => $this->targetSelector,
				'targetLocationName' => $this->targetLocationName,
				'instantChange' => $this->instantChange,
				//**css
				'colorBefore' => $this->colorBefore,
				'colorHover' => $this->colorHover,
				'colorAfter' => $this->colorAfter,
			));
		}
	}
?>