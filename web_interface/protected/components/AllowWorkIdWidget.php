<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class AllowWorkIdWidget extends CWidget
	{
		/*
		*/
		public $id="allowWorkId";
		public $initialCataId = "";
		public $canEdit = true;
		public $overflowHeight = "200px";
		public function run()
		{
			
			$this->render("allowWorkId",array(
				"id" => $this->id,
				"initialCataId" => $this->initialCataId,
				"canEdit" => $this->canEdit,
				"overflowHeight" => $this->overflowHeight
			));
		}
	}
?>