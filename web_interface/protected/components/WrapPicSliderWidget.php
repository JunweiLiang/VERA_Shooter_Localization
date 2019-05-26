<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php 
	class WrapPicSliderWidget extends CWidget
	{
		//
		
		public $id = 'picSlider';//picSlider的id
		//public $width = '980px';//picSlider的宽度 
		//public $height = '500px';//******** picslider 的宽高不需要指定了，在setup中获取width,同时根据kgval计算height
		public $catalogId;//picSlider的 栏目id
		public $notNullShowMarginBottom = false;//有内容时自带下边距
		public function run()
		{
			//根据catalogId获取图片信息
			$picArray = CHomePic::getPicByCataId($this->catalogId);
			//获取宽高比等设置信息
			$setupArr = CHomePicSetup::getPicSetupByCataId($this->catalogId);
			$height = (int)$setupArr['width']/$setupArr['kgval']."px";
			//print_r($picArray);
			if((count($picArray) > 0) && ($this->notNullShowMarginBottom === true))//有内容的情况且设定有内容时自带下边距
			{
				//die("e");
				$this->widget('PicSliderWidget',array(
					'containerId' => $this->id,
					'width' => $setupArr['width'],
					'height' => $height,
					'picArray' => $picArray,
					'noBG' => $setupArr['hasBG'] == 1?false:true,
					'marginBottom' => "20px",
					'maskOpt' => array(
						'opacity'=>$setupArr['maskOpacity'],
						'width'=>$setupArr['maskWidth'],
					),
					'titleTop'=>$setupArr['titleTop'],
					'titleLeft'=>$setupArr['titleLeft'],
					'titleWidth'=>$setupArr['titleWidth'],
					'titleFontSize'=>$setupArr['titleFontSize'],
					'subTitleTop'=>$setupArr['subTitleTop'],
					'subTitleLeft'=>$setupArr['subTitleLeft'],
					'subTitleWidth'=>$setupArr['subTitleWidth'],
					'subTitleFontSize'=>$setupArr['subTitleFontSize'],
				));
			}
			else
			{
				$this->widget('PicSliderWidget',array(
					'containerId' => $this->id,
					'width' => $setupArr['width'],
					'height' => $height,
					'picArray' => $picArray,
					'noBG' => $setupArr['hasBG'] == 1?false:true,
					'marginBottom' => "0px",
					'maskOpt' => array(
						'opacity'=>$setupArr['maskOpacity'],
						'width'=>$setupArr['maskWidth'],
					),
					'titleTop'=>$setupArr['titleTop'],
					'titleLeft'=>$setupArr['titleLeft'],
					'titleWidth'=>$setupArr['titleWidth'],
					'titleFontSize'=>$setupArr['titleFontSize'],
					'subTitleTop'=>$setupArr['subTitleTop'],
					'subTitleLeft'=>$setupArr['subTitleLeft'],
					'subTitleWidth'=>$setupArr['subTitleWidth'],
					'subTitleFontSize'=>$setupArr['subTitleFontSize'],
				));
			}
		}
	}
?>