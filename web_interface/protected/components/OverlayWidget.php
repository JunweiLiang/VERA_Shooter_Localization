<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
		覆盖整个document的overlay层，有show方法(直接#id > input.show change)，也有点击后的响应
	*/
	class OverlayWidget extends CWidget
	{
		public $id = "overlay";
		public $zindex = "998";
		public $targetSelector = array();//array 或者 str
		public $transparent = false;
		public function run()
		{
			$this->render("overlay",array(
				"id" => $this->id,
				"zindex" => $this->zindex,
				"targetSelector" => $this->targetSelector,
				"transparent" => $this->transparent,
			));
		}
	}
?>