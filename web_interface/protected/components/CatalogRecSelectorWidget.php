<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	//属于optWidget,其siteWidgetId在页面载入时已经载入到input id="echo$id"+"siteWidgetIdContainer" class="siteWidgetIdContainer"
	//约定最高级<div id="$id;">
	//<input id="$id"+"catalogIdContainer" class="$catalogIdContainer" value="" type='hidden'></input>'
	
	//可修改所有页面的图片推荐，添加，减少，修改图片标题，
	//必须给出修改的地址
	class CatalogRecSelectorWidget extends CWidget
	{	
		/********optWidget basic**********/
		public $id = 'catalogRecSelector';
		public $class = 'optWidget';//外部包div的class
		public $siteWidgetId;//控件的唯一标识
		public $siteWidgetTitle = '子栏目推荐部件';
		public $catalogIdContainer = 'catalogIdContainer';//装载catalogId的input:hidden的id,放在$id下,其他部件动态改变其值使用"#$id #$catalogContainer",然后调用其change();
		public $width = "800px";//部件宽度
		public $height = '500px';
		/********optWidget basic***********/
		public function run()
		{
			$this->render('catalogRecSelector',array(
			/********optWidget basic**********/
				'id' => $this->id,
				'catalogIdContainer' => $this->catalogIdContainer,
				'siteWidgetId' => $this->siteWidgetId,
				'width' => $this->width,
				'siteWidgetTitle' => $this->siteWidgetTitle,
				'class' => $this->class,
				'height'=>$this->height,
				/********optWidget basic**********/
			));
		}
	}

?>