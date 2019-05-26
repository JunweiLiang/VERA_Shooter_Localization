<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php 
	class WrapActivityDisplayerWidget extends CWidget
	{
		//
		
		public $id = 'actDisplayer';//picSlider的id
		public $width = '980px';//picSlider的宽度 
		public $height = '140px';
		public $catalogId;//picSlider的 栏目id
		public $notNullShowMarginBottom = false;//有内容时自带下边距
		public function run()
		{
			//根据catalogId获取图片信息
			$actArray = CHomeAct::getActByCataId($this->catalogId);
			if((count($actArray) > 0) && ($this->notNullShowMarginBottom === true))//有内容的情况且设定有内容时自带下边距
			{
				$this->widget('ActivityDisplayerWidget',array(
					'width' => $this->width,
					'blockWidth' => '215px',
					'headingWidth' => '120px',
					'height' => $this->height,
					'containerId' => $this->id,
					'actArray' => $actArray,
					'marginBottom' => "20px",
				));
			}
			else
			{		
				$this->widget('ActivityDisplayerWidget',array(
					'width' => $this->width,
					'blockWidth' => '215px',
					'headingWidth' => '120px',
					'height' => $this->height,
					'containerId' => $this->id,
					'actArray' => $actArray,
			
				));
			}
		}
	}
?>