<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class ChangeWorkTypeWidget extends CWidget
	{
		public $id = "changeWorkType";
		//点击保存作品类别，成功后触发
		public $triggerSelectors = array();
		public $typeListHeight = "300px";
		public function run()
		{
			$this->render("changeWorkType",array(
				"id" => $this->id,
				"triggerSelectors" => $this->triggerSelectors,
				"typeListHeight" => $this->typeListHeight,
			));
		}
	}
?>