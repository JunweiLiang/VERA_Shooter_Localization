<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	D_process minitoring widget
	*/
	class DatasetVideoWidget extends CWidget
	{
		public $id = "datasetVideo"; // need to be specified
		
		public function run()
		{
			
			$this->render('datasetVideo',array(
				"id" => $this->id,
			));
		}
	}
	
?>