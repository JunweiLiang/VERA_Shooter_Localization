<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	D_process minitoring widget
	*/
	class DatasetWidget extends CWidget
	{
		public $id = "DatasetWidget"; // need to be specified
		public $userId;
		public $target = "";//where to set the input.datasetId when click
		public $datasetId = 0;
		public $scrollCall ="";// if datasetId !=0 , will send the position.left to this and call change
		
		public function run()
		{
			
			$this->render('dataset',array(
				"id" => $this->id,
				"userId" => $this->userId,
				"target" => $this->target,
				"datasetId" => $this->datasetId,
				"scrollCall" => $this->scrollCall,
			));
		}
	}
	
?>