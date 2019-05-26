<?php 
/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php 
	class CatalogViewerWidget extends CWidget
	{
		public $id = "catalogViewer";//viewer的外包div id
		public $targetSelector;//装载catalogId,可能为数组
		//可以为数组//触发该selector的change事件
		//点击栏目项，填充其id到的地方的jquery 选择器字符串，必须要双引号或者this,
		//如调用textViewer里的catalogIdContainer,
		//$this->widget('TextViewerWidget',array(
		//	'id' => 'cmTextViewer',
		//	'catalogIdContainer' => 'TVCatalogId',
		//);
		//其选择器就是'targetSelector' => '"#cmTextViewer #TVCatalogId"',
		//下面与字符串的targetSelector配套，暂不支持数组
		public $targetIntroSelector = '';//返回栏目简介的地方
		public $targetTitleSelector = '';//返回栏目标题的地方
		
		public $width;
		public $catalogIdArray;//所有要查看的栏目的父级id
		public $noChild = false;//不显示上述id的子级id(默认显示)
		
		public $initialCataId;//初始选中的栏目d的id(暂时未用)
		public $getUrl = "";//获取栏目信息的地址
		public $showInternal = true;//是否显示内部栏目
		public $showNoText = true;//是否显示无文章栏目
		
		public $noBorder = false;
		
		public $instantChange = true;//是否载入catalog完毕就触发外部change事件
		public $instantChangeIndex = 0;//默认载入catalog完毕就点击的栏目序号 
		
		public $instantLoad = true;//是否页面载入就载入栏目信息，否则要指定触发按钮的id triggerId
		public $triggerId = '';//触发载入catalog的按钮id       //只在没有数据时触发一次，下次再点击将不触发
		
		public $hasAll = false;//是否有一个“全部”的按钮 
		//从前版本不能动态改变cataId(父级id)
		public $dynamicChange = false;//是否能动态控制catalogViewer,
		public $cataIdArrContainerId = "";//暂时只支持单一id的传入  注意！！div.#id外的input(一定不能命名冲突);外部只要修改了#input.catalogIdArrContainerId后，调用此的change事件
		public function run()
		{
			if(!$this->instantLoad && $this->triggerId === '')
			{
				die('error');
			}
			if($this->getUrl == "")
			{
				$this->getUrl = Yii::app()->baseUrl."/index.php/catalog/get";
			}
			if($this->dynamicChange && $this->cataIdArrContainerId === '')
			{
				die('error');
			}
			if($this->dynamicChange)
			{
				$this->instantLoad = false;//要动态改变，那么就不instantLoad,且catalogIdArray也可以不设置
				$this->catalogIdArray = array();
			}
			$this->render('catalogViewer',array(
				'id' => $this->id,
				'targetSelector' => $this->targetSelector,
				'targetIntroSelector' => $this->targetIntroSelector,
				'targetTitleSelector' => $this->targetTitleSelector,
				'width' => $this->width,
				'catalogIdArray' => $this->catalogIdArray,
				'noChild' => $this->noChild,
				'getUrl' => $this->getUrl,
				'showInternal' => $this->showInternal,
				'showNoText' => $this->showNoText,
				'instantChange' => $this->instantChange,
				'instantChangeIndex' => $this->instantChangeIndex,
				'instantLoad' => $this->instantLoad,
				'triggerId' => $this->triggerId,
				'dynamicChange' => $this->dynamicChange,
				'cataIdArrContainerId' => $this->cataIdArrContainerId,
				"hasAll" => $this->hasAll,
				"noBorder" => $this->noBorder,
			));
		}
	}
?>