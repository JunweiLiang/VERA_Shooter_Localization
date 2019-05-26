<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<?php
//活动展示模块，横向顺序排版，
	class ActivityDisplayerWidget extends CWidget
	{
		public $width;//整个模块的宽度，一般为980px(有最小值)
		public $blockWidth;//单个活动块的宽度
		public $headingWidth;//左边“活动”标签的宽度
		public $height;
		public $containerId;
		public $marginBottom = "0px";//整个部件的下边距
		//***活动元素
		public $actArray = array(
			array(
				'title' => '',
				'time' => '',
				'loc' => '',
				'lecturer' => '',
				'link' =>'',
			),
		);
		//***
		public function run()
		{
			if(count($this->actArray) == 0)
			{
				echo "";
			}
			else
			{
			$this->render('activityDisplayer',array(
				'width' => $this->width,
				'blockWidth' => $this->blockWidth,
				'headingWidth' => $this->headingWidth,
				'height' => $this->height,
				'containerId' => $this->containerId,
				'actArray' => $this->actArray,
				'marginBottom'=> $this->marginBottom,
			));	
			}
		}
	}
?>