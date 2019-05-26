<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class JudgeViewerWidget extends CWidget
	{
		//ajax载入，监听 #id > input.judgeId change事件		
		public $id = "judgeViewer";
		public $hasEditComp = false;
		public $instantLoad = false;
		public $initialId = "";
		public $typeArr = array();
		public function run()
		{
			$goodAtArr = array();
			if($this->hasEditComp && empty($this->typeArr))
			{
				//获取作品种类，用于评委擅长领域
				$workTypeArr = WorkType::getAll();
		/*
			workTypeArr = array(
				array(
					"typeName" => "***",
					"typeId" =>"",
					"subType" => array(
						array(
							"typeName" => "**",
							"notice" => "****",
							"subTypeId"=> "",
						),
						array(..),
						..
					),		
				)
				..	
			);
		*/
				/*获取出array(
					array('value'=>subTypeId,'title'=>typeName)
				)
					用于tablr
				*/
				foreach($workTypeArr as $oneType)
				{
					$temp = array();
					$temp['title'] = $oneType['typeName'];
					$temp['check'] = 0;
					$goodAtArr[] = $temp;
					foreach($oneType['subType'] as $oneSubType)
					{
						$temp = array();
						//die($oneSubType['subTypeId']);
						$temp['value'] = $oneSubType['subTypeId'];
						$temp['title'] = $oneSubType['typeName']."<br/>";
						$temp['check'] = 1;
						$goodAtArr[] = $temp;
					}
				}
			}
			$this->render("judgeViewer",array(
				"id" => $this->id,
				"hasEditComp" => $this->hasEditComp,
				"instantLoad" => $this->instantLoad,
				"initialId" => $this->initialId,
				"goodAtArr" => $goodAtArr,
			));
		}
	}
?>