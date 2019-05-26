<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class JudgeWorkListWidget extends CWidget
	{
		//全ajax,根据blockId获取作品，同时有各种filter
		public $id="judgeWorkList";
		public $blockId = 0;//必须传入blockId,更新为正整数
		/*
			targetSelector 实现全数组
			---array(
				array(
					"workTitle" => "",
					"workSubTypeId" =>,
					"workSubTypeName" =>,
					"workFirstTypeName" => ,
					"checkWorkId" => "",//触发change,
				),
				array(..)
				..
			)
		*/
		public $targetSelector = array();
		public $instantLoad = false;
		public $showToggle = false;//点击后是否保持一个深色状态
		public $feedNum = "5";//一次获取多少个
		//****css
		public $colorBefore = "#0088cc";
		public $colorHover = "#0088ff";
		public $colorAfter = "white";
		public $overflowHeight = "";
		//**
		public $hasInitial = false;
		public $noCtr = false;//是否显示feedNum,order等控制
		public $all = false;//是否返回全部
		public $readyFuncName = "";//载入列表完毕调用的js函数名
		
		public $getWorkListUrl = "";
		//**
		public function run()
		{
			if(($this->blockId <= 0) || !is_array($this->targetSelector))
			{
				echo "error";
			}
			else
			{
				if($this->getWorkListUrl == "")
				{
					$this->getWorkListUrl = Yii::app()->baseUrl."/index.php/work/getList?blockId=".$this->blockId;
				}
				$this->render("judgeWorkList",array(
					"id" => $this->id,
					"hasInitial" => $this->hasInitial,
					"blockId" => $this->blockId,
					"showToggle" => $this->showToggle,
					"targetSelector" => $this->targetSelector,
					"instantLoad" => $this->instantLoad,
					'feedNum' => $this->feedNum,
					"noCtr" => $this->noCtr,
					"all" => $this->all,
					"getWorkListUrl" => $this->getWorkListUrl,
					"readyFuncName" => $this->readyFuncName,
					//**css
					'colorBefore' => $this->colorBefore,
					'colorHover' => $this->colorHover,
					'colorAfter' => $this->colorAfter,
					"overflowHeight" => $this->overflowHeight,
					
				));
			}
		}
	}
?>