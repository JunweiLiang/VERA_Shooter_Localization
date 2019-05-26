<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	widget for getting the global result and show as a vertical timeline
	input.datasetId, multi cluster
	*/
	class GlobalSyncWidget extends CWidget
	{
		public $id = "globalSync"; // need to be specified
		
		public function run()
		{
			$this->render('globalSync',array(
				"id" => $this->id,
			));
		}
	}
	
?>