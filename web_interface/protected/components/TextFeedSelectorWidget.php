<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	//属于optWidget,其siteWidgetId在页面载入时已经载入到input id="echo$id"+"siteWidgetIdContainer" class="siteWidgetIdContainer"
	//约定最高级<div id="$id;">
	//<input id="$id"+"catalogIdContainer" class="$catalogIdContainer" value="" type='hidden'></input>'
	
	//可修改所有页面的文章推送信息

	class TextFeedSelectorWidget extends CWidget
	{	
		/********optWidget basic**********/
		public $id = 'textFeedSelector';
		public $class= 'optWidget';//外部包div的class
		public $siteWidgetId;//控件的唯一标识
		public $siteWidgetTitle = '文章推送部件';
		public $catalogIdContainer = 'catalogIdContainer';//装载catalogId的input:hidden的id,放在$id下,其他部件动态改变其值使用"#$id #$catalogContainer",然后调用其change();
		public $width = "750px";
		/********optWidget basic***********/
		public $Aheight = "400px";//第一行的高度
		public $Bheight = "300px";//第二行高度
		public $feedDefaultCharNum = '500';//选择文章后默认截取的字符数，有风险，可能截取标签
		public $editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo','-','SelectAll','RemoveFormat'),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				'/',
				//array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				'/',
				array('Styles','Font','FontSize'),
				array('TextColor','BGColor'),
				
				array('Image','Flash','Link') 
			),
			'filebrowserBrowseUrl'=>"/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>"/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>"/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>"/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>"/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>"/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		);
		public function run()
		{
		
			$this->editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo','-','SelectAll','RemoveFormat'),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				'/',
				//array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				'/',
				array('Styles','Font','FontSize'),
				array('TextColor','BGColor'),
				
				array('Image','Flash','Link') 
			),
			'width' => '310px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		);
			$this->render('textFeedSelector',array(
			/********optWidget basic**********/
				'id' => $this->id,
				'catalogIdContainer' => $this->catalogIdContainer,
				'siteWidgetId' => $this->siteWidgetId,
				'width' => $this->width,
				'siteWidgetTitle' => $this->siteWidgetTitle,
				'class' => $this->class,
				/********optWidget basic**********/
				'Aheight' => $this->Aheight,
				'Bheight' => $this->Bheight,
				'editorConfig' => $this->editorConfig,
				'feedDefaultCharNum' => $this->feedDefaultCharNum,
			));
		}
	}

?>