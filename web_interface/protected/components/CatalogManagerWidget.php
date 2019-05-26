<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
	class CatalogManagerWidget extends CWidget
	{
		public $id;//整个widget的div id
		//栏目操作的ajax地址
		public $getUrl;//获取栏目信息的地址
		public $changeUrl;
		public $addUrl;
		public $deleteUrl;
		public $instantLoad = false;//是否载入页面就自动加载数据
		public $triggerId;//当非自动加载时，传入出发载入动作的HTML的按钮id,默认click动作触发一次（当div为空）
		public $parentCataIdArr = array();//初始读取的所有管理的栏目的id
		public function run()
		{
			$this->render('catalogManager',array(
				'id' => $this->id,
				'instantLoad' => $this->instantLoad,
				'triggerId' => $this->triggerId,
				'parentCataIdArr' => $this->parentCataIdArr,
				'getUrl' => $this->getUrl,
				'changeUrl' => $this->changeUrl,
				'addUrl' => $this->addUrl,
				'deleteUrl' => $this->deleteUrl,
			));
		}
	}
?>