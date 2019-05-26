<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php 

	class HomeManageWidget extends CWidget
	{
		public $id;
		public $instantLoad = true;
		public $triggerId = "";//外部触发数据载入的按钮id，
		public $homeCataIdArr = array();//所要管理的catalog的集合（外部栏目,无子栏目）
		
		public $hasPicSelector = true;
		
		public $hasTextSelector = false;
		
		public $hasFeedEditor = false;
		
		public function run()
		{
			if(!$this->instantLoad && $this->triggerId === '')
			{
				die('error');
			}
			$this->render('homeManage',array(
				'id' => $this->id,
				'instantLoad' => $this->instantLoad,
				'triggerId' => $this->triggerId,
				'hasPicSelector' => $this->hasPicSelector,
				'hasTextSelector' => $this->hasTextSelector,
				'hasFeedEditor' => $this->hasFeedEditor,
				'homeCataIdArr' => $this->homeCataIdArr,
			));
		}
	}
?>