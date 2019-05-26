<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CheckWorkViewerWidget extends CWidget
	{
		public $id="checkWorkViewer";
		public function run()
		{
			$this->render("checkWorkViewer",array(
				"id" => $this->id,
			));
		}
	}
?>