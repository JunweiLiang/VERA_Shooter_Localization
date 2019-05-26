<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CopyWorkWidget extends CWidget
	{
		public $id="copyWork";
		public function run()
		{
			$this->render("copyWork",array(
				"id" => $this->id,
			));
		}
	}
?>