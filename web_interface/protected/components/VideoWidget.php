<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	D_process minitoring widget
	*/
	class VideoWidget extends CWidget
	{
		public $id = "videoviewer"; // need to be specified
		public $videopath= "";
		public $width = "";
		
		public function run()
		{
			$width = f::get("videoWidth");
			if($this->width == "")
			{
				$this->width = $width;
			}
			$this->render('video',array(
				"id" => $this->id,
				"width" => $this->width,
				"videopath" => $this->videopath,
			));
		}
	}
	
?>