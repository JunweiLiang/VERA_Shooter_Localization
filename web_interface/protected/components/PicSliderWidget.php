<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
/************
PicSlider
author:leongchunwai
*********/
//此部件有外部的整体wrap,width 100%,给予的width参数只是内部图片的宽度，使用时需要一个外部容器wrap住 (要显示背景，必须外部的wrap宽度大于此width)
//外部门户网站图片切换部件，接收参数：宽度，高度height;containerId,图片数量(countArray)，图片完整地址，图片链接
//(参数必须设置为public)

	class PicSliderWidget extends CWidget
	{
		public $width = '980px';//展示区的宽度，展示区外还有一个wrap,背景大图，width:100%//**********!!!所有图片将拉伸到此宽度，高度自适应，
		public $slideTime = '6000';//图片切换的间隔，毫秒级
		public $animateSpeed = '800';//图片切换的速度，毫秒
		public $marginBottom = "0px";//整个部件的下边距
		public $height = '300px';//外容器的高度，图片超过此部分的将截去(并不需要指定，在外部使用宽高比指定 )
		public $containerId = 'picSlider';//图片显示div的id
		public $picArray = array(
			array(
				//***new version added hasMask,with mask ,title and sub title will be shown
				'hasMask' => true,
				'addr' => '',//图片地址是必须的
				'link' =>'',//图片点击后链接
				'title' =>'',
				'subArr' => array(//副标题数组
					'2013年度任务',
					'这是第二行东西',
					'第三行哈',
				),
			),
		);	
		//背景
		public $picBG = '';
		public $noBG = false;
		//关键可修改css元素
		//蒙板
		//public $hasMask = true;//整体的mask开关//不用了，对每个图片单独使用mask
		public $maskOpt = array(
			'opacity' => '70',//0---100
			'width' => '25%',//以外容器为准，即以其图片宽度为准
		);
		public $titleTop = "30%";//主标题距离上边框
		public $titleLeft = "4%";//主标题距离左边
		public $titleWidth = "20%";//以外容器为准，即以其图片宽度为准
		public $titleFontSize = "16px";
		public $subTitleTop = "50%";//副标题距离上边距离
		public $subTitleLeft = "4%";//副标题距离左边
		public $subTitleWidth = "20%";//以外容器为准，即以其图片宽度为准
		public $subTitleFontSize = "13px";
		public function run(){			
			if(count($this->picArray) == 0)
			{
				echo "";
			}
			else
			{
				if($this->picBG == "")
				{
					//以后可以使用随机数配上几个不同的背景?
					$this->picBG = Yii::app()->baseUrl.'/assets/images/bg.jpg';
				}
				
				
			//****组装图片HTML
//pic:
/* 
	<div class="pic" style="display:block">
    	<div class="picTitle">中国与全球经济</div>
    	<div class="picSubDiv">
    		<div class="line"></div>
    		...
    	</div>
    	<div class="picMask"></div>
    	<a title="" href="">
        	<img class="pic" src="<?php echo Yii::app()->baseUrl?>/assets/images/1.jpg"></img>
        </a>
    </div>
	
*/
$widgetContent="";
$i=0;
foreach($this->picArray as $pic)
{
	//当 $pic['link']为空时，不设置href
	$link = $pic['link'] == ""?"":'href="'.$pic['link'].'"';	
	if($i++==0)//第一个图片显示
	{
		$temp = '<div class="pic" style="display:block">';
	
	}
	else
	{
		$temp = '<div class="pic">';
	}
	//判断是否要蒙板，要蒙板才显示主副标题
	if(!isset($pic['hasMask']))//用于兼容以前的设计
	{
		$pic['hasMask'] = true;
	}
		if($pic['hasMask'] === true)
		{
			//******组装主标题
			$temp.='<a style="text-decoration:none" '.$link.'>'.
				'<div class="picTitle">'.$pic['title'].'</div>'.
			'</a>';	
			//组装副标题
			$j = 0 ;
			foreach($pic['subArr'] as $oneLine)
			{
				if($j == 0)
				{
					$temp.='<div class="picSubDiv">';
				}
				$temp.='<div class="line">'.$oneLine.'</div>';
				$j++;
			}
			if($j != 0)
			{
				$temp.='</div>';
			}
			$temp.='<div class="picMask"></div>';
			//组装图片
			$temp.='<a title="'.$pic['title'].'" '.$link.'>'.
				'<img class="pic" src="'.$pic['addr'].'"></img>'.
				'</a>'.
			'</div>';//div.pic
		}
		else
		{	
			//组装图片
			$temp.='<a title="" '.$link.'>'.
				'<img class="pic" src="'.$pic['addr'].'"></img>'.
			'</a>'.
		'</div>';//div.pic
		}
	$widgetContent .= $temp; 
}
			
			
			$this->render('picSlider',array(
				'width'=>$this->width,
				'height'=>$this->height,
				'containerId'=>$this->containerId,
				'picBG' => $this->picBG,
				'noBG' => $this->noBG,
				'widgetContent' => $widgetContent,
				'picNum' => count($this->picArray),
				'slideTime' => $this->slideTime,
				'marginBottom'=> $this->marginBottom,
				'animateSpeed' => $this->animateSpeed,
				//关键可修改css元素
				'maskOpt' => $this->maskOpt,
				'titleTop' => $this->titleTop,
				'titleLeft' => $this->titleLeft,
				'titleWidth' => $this->titleWidth,
				'subTitleTop' => $this->subTitleTop,
				'subTitleLeft' => $this->subTitleLeft,
				'subTitleWidth' => $this->subTitleWidth,
				'titleFontSize' => $this->titleFontSize,
				'subTitleFontSize' => $this->subTitleFontSize,
			));
			}//if count(picArray)==0
			
		}	
	}
?>
