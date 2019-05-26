<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<?php 
	class SiteCatalogViewerWidget extends CWidget
	{
		public $id = 'siteCataViewer';
		public $width = '250px';
		public $thisCatalogId;//载入后active的 catalogid
		public $hasChooseFunc = false;//有选择功能就完全不同了
		public $targetSelector = '';//choose后把catalogId输出到的地方的jquery选择器
		public function run()
		{
			//获取所有公开栏目
			$catalogArr = array();
			$catalogArr = Catalog::HgetCataArr(array('catalogTitle','catalogId'));
			//删除栏目 '高礼网站',
			$i = 0;
			foreach($catalogArr as &$val)
			{	
				if($val['catalogId'] == 1)
				{
					unset($catalogArr[$i]);
					break;
				}		
				$i++;
			}
			if($this->hasChooseFunc)
			{
				$this->thisCatalogId = 0;
			}
			$this->render('siteCatalogViewer',array(
				'id' => $this->id,
				'width' => $this->width,
				'thisCatalogId' => $this->thisCatalogId,
				'cataArr' => $catalogArr,
				'hasChooseFunc' => $this->hasChooseFunc,
				'targetSelector' => $this->targetSelector,
			));
		}
	}
?>