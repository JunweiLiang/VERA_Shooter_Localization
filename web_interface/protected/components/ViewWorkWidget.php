<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		通过workId获取信息，打印表格出来 
	*/
?>
<?php
	class ViewWorkWidget extends CWidget
	{
		public $workId = null;
		public $showBaomingbiao = true;//是否显示报名表信息
		public $hasHead = true;//用于是否有一个html的包裹
		public $width = "900px";
		public $showcybswj = true;//显示查阅、部署、文件信息。
		public $showhk = true;//显示汇款信息
		
		public $dayin = false;//显示用于打印的格式
		
		public function run()
		{
			$Work = Work::model()->findByPk($this->workId);
			if($Work != null)
			{
				//获取种类
				$typeArr = WorkType::getTypeNameArr($Work->workSubTypeId);
				//获取地点、学校,T_competitorProfile
				$Competitor = Competitor::model()->findByPk($Work->competitorId);
				$location = Location::model()->findByPk($Competitor->location)->locationName;
				$school = $Competitor->school;
				//获取赛区信息
				$Catalog = Catalog::model()->findByPk($Competitor->catalogId);
				if($this->dayin)
				{
					$this->render("dayinWork",array(
						"param" => $Work->attributes,
						"typeArr" => $typeArr,
						"location" => $location,
						"school" => $school,
						"showBaomingbiao" => $this->showBaomingbiao,
						"hasHead" => $this->hasHead,
						"width" => $this->width,
						"showcybswj" => $this->showcybswj,
						"catalogTitle" => $Catalog->catalogTitle,
						"showhk" => $this->showhk,
					));
				}
				else
				{
					$this->render("viewWork",array(
						"param" => $Work->attributes,
						"typeArr" => $typeArr,
						"location" => $location,
						"school" => $school,
						"showBaomingbiao" => $this->showBaomingbiao,
						"hasHead" => $this->hasHead,
						"width" => $this->width,
						"showcybswj" => $this->showcybswj,
						"catalogTitle" => $Catalog->catalogTitle,
						"showhk" => $this->showhk,
					));
				}
			}
		}
	}
?>