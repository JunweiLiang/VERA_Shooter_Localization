<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class TypeListWidget extends CWidget
	{
		//作品种类列表部件
		//点击输出subTypeId		
		public $id = "typeList";
		public $typeArr = array();//外部不指定 作品类型总集合时，会自动按默认获取
		public $showToggle = false;//点击后是否保持一个深色状态
		public $hasAll = false;//是否含有“全部”这个选项 div.block,点击输出"all"给target
		public $targetSelector = "";//输出subTypeId的地方
		public $targetTypeName = "";//输出subTypeName的地方
		public $targetFirstTypeName = "";//输出typeName的地方
		public $instantChange = false;//进入页面就选中第一个项
		//****css
		public $colorBefore = "#0088cc";
		public $colorHover = "#0088ff";
		public $colorAfter = "white";
		
		public $showTypeName = false;//是否显示大类名称
		
		public function run()
		{
			if(empty($this->typeArr))
			{
				$temp = WorkType::getAll();
				foreach($temp as $a)
				{
					if($this->showTypeName)
					{
						$tempT = array(
							"isType" => 1,//用于客户端标记为大类，使用另外的显示方式
							"typeName" => $a['typeName'],
							"typeId" => $a['typeId'],
						);
						$this->typeArr[] = $tempT;
					}
					foreach($a['subType'] as $one)
					{
						$tempT = $one;
						$tempT['firstTypeName'] = $a['typeName'];
						$this->typeArr[] = $tempT;
					}					
				}
			}
			
			$this->render("typeList",array(
				'id' => $this->id,
				'typeArr' => $this->typeArr,
				'showToggle' => $this->showToggle,
				'hasAll' => $this->hasAll,
				'targetSelector' => $this->targetSelector,
				'targetTypeName' => $this->targetTypeName,
				'targetFirstTypeName' => $this->targetFirstTypeName,
				'instantChange' => $this->instantChange,
				//**css
				'colorBefore' => $this->colorBefore,
				'colorHover' => $this->colorHover,
				'colorAfter' => $this->colorAfter,
				
				"showTypeName" => $this->showTypeName,
			));
		}
	}
?>