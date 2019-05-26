<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	D_process minitoring widget
	*/
	class DaisyProgressWidget extends CWidget
	{
		public $id = "daisyProgress"; // need to be specified
		public $datasetId = "";// initial dataset, if empty then no load on ready
		public function run()
		{
			
			$this->render('daisyProgress',array(
				"id" => $this->id,
				"datasetId" => $this->datasetId,
			));
		}
	}
	
?>