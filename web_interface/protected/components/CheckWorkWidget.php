<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CheckWorkWidget extends CWidget
	{
		public $id = "checkWork";//conflic with checkworkViewer
		public $hasCom = true;//后端未完善，
		public function run()
		{
			$this->render("checkWork",array(
				"id" => $this->id,
				"hasCom" => $this->hasCom,
			));
		}
	}
?>