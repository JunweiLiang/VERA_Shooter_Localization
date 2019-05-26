<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class ZoneManageWidget extends CWidget
	{
		//赛区管理部件
		//配合catalogViewer使用，id > input.catalogId,change后获取信息，然后保存的时候修改该节点的赛区信息;与catalog控制器通信 
		
		public $id = "zoneManage";
		public $typeArr = array();//外部不指定 作品类型总集合时，会自动按默认获取
		public $loadingOpa = "70";
		public $locArr = array();//外部不指定 地点总集合时，会自动按默认获取
		public function run()
		{
			if(empty($this->typeArr))
			{
				$this->typeArr = WorkType::getAll();
				//线性化
				/*
				$temp = WorkType::getAll();
				foreach($temp as $a)
				{
					foreach($a['subType'] as $one)
					{
						$tempT = $one;
						$tempT['firstTypeName'] = $a['typeName'];
						$this->typeArr[] = $tempT;
					}					
				}*/
			}
			if(empty($this->locArr))
			{
				$temp = Location::model()->findAll();
				foreach($temp as $b)
				{
					$this->locArr[] = $b->attributes;
				}
			}
			$this->render("zoneManage",array(
				'id' => $this->id,
				'typeArr' => $this->typeArr,
				'loadingOpa' => $this->loadingOpa,
				'locArr' => $this->locArr,
			));
		}
	}
?>