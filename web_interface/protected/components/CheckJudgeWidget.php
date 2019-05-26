<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class CheckJudgeWidget extends CWidget
	{
		public $id = "checkJudge";
		public function run()
		{
			$this->render("checkJudge",array(
				"id" => $this->id,
			));
		}
	}
?>