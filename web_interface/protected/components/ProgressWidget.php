<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	D_process minitoring widget
	*/
	class ProgressWidget extends CWidget
	{
		public $id = "progress"; // need to be specified
		public $noMessage = false;
		public $doneCall = "";

		public function run()
		{
			$api = Yii::app()->baseUrl."/index.php/main/progress";
			$interval = 1000;// time to refresh
			$this->render('progress',array(
				"id" => $this->id,
				"api" => $api,
				"interval" => $interval,
				"noMessage" => $this->noMessage,
				"doneCall" => $this->doneCall,
			));
		}
	}
	
?>