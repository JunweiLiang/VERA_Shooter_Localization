<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php 
	//属于optWidget,其siteWidgetId在页面载入时已经载入到input id="echo$id"+"siteWidgetIdContainer" class="siteWidgetIdContainer"
	//约定最高级<div id="$id;">
	//<input id="$id"+"catalogIdContainer" class="$catalogIdContainer" value="" type='hidden'></input>'

	class TextListSelectorWidget extends CWidget
	{
		/********optWidget basic**********/
		public $id = 'textListSelector';
		public $class= 'optWidget';//外部包div的class
		public $siteWidgetId;//控件的唯一标识
		public $siteWidgetTitle = '活动展示部件';
		public $catalogIdContainer = 'catalogIdContainer';//装载catalogId的input:hidden的id,放在$id下,其他部件动态改变其值使用"#$id #$catalogContainer",然后调用其change();
		public $width = "750px";
		/********optWidget basic***********/
		public $height = '300px';//文章选择框的高度，不是总高度
		public function run()
		{
			$this->render('textListSelector',array(
			/********optWidget basic**********/
				'id' => $this->id,
				'class' => $this->class,
				'catalogIdContainer' => $this->catalogIdContainer,
				'siteWidgetId' => $this->siteWidgetId,
				'width' => $this->width,
				'siteWidgetTitle' => $this->siteWidgetTitle,
				/********optWidget basic**********/
				'height' => $this->height,
			));
		}
	}
?>