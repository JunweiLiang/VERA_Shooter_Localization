<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class ChangeWorkWidget extends CWidget
	{
		/*
		*/
		public $id="changeWork";
		public $allWId = array();
		public function run()
		{
			//获取所有赛区Id
			if(empty($this->allWId))
			{
				$arr = Catalog::WgetCataArr2(array("catalogId"));
				foreach($arr as $one)
				{
					$this->allWId[] = $one['catalogId'];
				}
			}
			$this->allWId = array_unique($this->allWId);
			$this->render("changeWork",array(
				"id" => $this->id,
				"allWId" => $this->allWId,
			));
		}
	}
?>