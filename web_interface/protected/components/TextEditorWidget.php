<?php 
	/****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<?php 
	class TextEditorWidget extends CWidget
	{
		public $id;//$id下编辑器id为editTextDiv,文章列表id为textListDiv(有的话)
		public $hasTextList = false;
		//包括文章编辑区与文章列表
		public $textIdJqueryObjStr = '';//外部的存储textId的input hidden的jquery完整的object,一般从getTextIdSelector开始 ,必须返回个jquery字符串
		public $getTextIdSelector = '';//触发填充id到编辑器中的按钮的jquery选择器(默认click触发)
		//当textIdSelector不为空时，执行：
		/*	
			$(document).delegate(<?php echo $getTextIdSelector;?>,"click",function(){
				$("#<?php echo $id?> #editTextDiv #editTextId").val(<?php echo $textIdJqueryObjStr;?>);
				getText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),"editTextDiv");
			});
		*/
		public $hasCheckComp = false;//是否用于审核，
		public $checkTextUrl = '';//审核文章的url
		//初始载入的textId
		public $textId;
		
		public $saveTextUrl = "";//保存文章d的地址
		public $postTextUrl = "";//提交文章去审核的地址(post提交)
		public $getTextUrl = "";//获取文章的地址
		public $deleteTextUrl = "";//删除文章地址
		public $getTextListUrl = "";//获取文章列表
		public $getCataUrl = "";//获取文章栏目的地址
		public $authorId;//作者id
		public $editorWidth;//编辑器外部div的总宽度
		public $textListWidth;//文章列表id
		//所有值为布尔值，是否有该字段输入框
		public $title = true;//默认一篇文章必须要title
		public $actTextOption = true; //文章必须要选择是否活动文章
		public $subTitle = false;
		public $catalog = true;//一篇文章必须对应一个栏目
		public $titlePic = true;//文章对应的标题图片,将带入一个ckfinder的单独应用
		public $textIntro = true;//文章的简介，默认需要
		public $src = false;//文章出处（字符串）
		public $keyWord = false;//文章关键词（字符串，多个关键词用逗号隔开）
		
		//public $hasFile = false;//附件直接在文章内容中点击link按钮附加
		//ckeditor的config,以json格式导入js:CKEDITOR.replace("#textareaId",$editorConfig);
		//由于ckfinder路劲要使用Yii::app()->baseUrl;所以每次调用此widget需要覆盖editorConfig属性
		public $editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				array('NewPage','-','Templates'),
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				'/',
				array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				'/',
				array('Styles','Format','Font','FontSize'),
				array('TextColor','BGColor'),
				'/',
				array('Image','Flash','Link','Table','HorizontalRule','SpecialChar','PageBreak') 
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
			//编辑器的config的filebrowser要重置
			$this->editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				array('NewPage','-','Templates'),
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				'/',
				array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				'/',
				array('Styles','Format','Font','FontSize'),
				array('TextColor','BGColor'),
				'/',
				array('Image','Flash','Link','Table','HorizontalRule','SpecialChar','PageBreak') 
			),
			'width' => '680px',
			'font_size' => '14px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		);
			$this->render('textEditor',array(
				'id' => $this->id,
				'hasTextList' => $this->hasTextList,
				'editorWidth' => $this->editorWidth,
				'saveTextUrl' => $this->saveTextUrl,
				'getCataUrl' => $this->getCataUrl,
				'getTextListUrl' => $this->getTextListUrl,
				'getTextUrl' => $this->getTextUrl,
				'postTextUrl' => $this->postTextUrl,
				'deleteTextUrl' => $this->deleteTextUrl,
				'catalog' => $this->catalog,
				'textListWidth' => $this->textListWidth,
				'authorId' => $this->authorId,
				'editorConfig' => $this->editorConfig,
				'titlePic' => $this->titlePic,
				'textId' => $this->textId,
				'textIdJqueryObjStr' => $this->textIdJqueryObjStr,
				'getTextIdSelector' => $this->getTextIdSelector,
				'checkTextUrl' => $this->checkTextUrl,
				'title' => $this->title,
				'actTextOption' => $this->actTextOption,
				'subTitle' => $this->subTitle,
				'textIntro' => $this->textIntro,
				'src' => $this->src,
				'keyWord' => $this->keyWord,
				'hasCheckComp' => $this->hasCheckComp,
			));
		}
	
	}


		/*
	config.toolbar_Full = [
		['Source','-','Save','NewPage','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor']
	];

	*/

	/*html页面中调用编辑器的js方法,要用$(document).ready()调用
	CKEDITOR.replace( 'editor', {
					 toolbar :              [ 
//加粗     斜体，     下划线      穿过线      下标字        上标字 
                ['Bold','Italic','Underline','Strike','Subscript','Superscript'], // 数字列表          实体列表            减小缩进    增大缩进 
                ['NumberedList','BulletedList','-','Outdent','Indent'], //左对 齐             居中对齐          右对齐          两端对齐 
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], //超链接  取消超链接 锚点 
                ['Link','Unlink','Anchor'], 
//图片    flash    表格       水平线            表情       特殊字符        分页符 
                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'], '/', 
// 样式       格式      字体    字体大小 
                ['Styles','Format','Font','FontSize'], //文本颜色     背景颜色 
                ['TextColor','BGColor'], //全屏           显示区块 
                ['Maximize', 'ShowBlocks','-']              ]    ,

        filebrowserBrowseUrl        : '<?php echo Yii::app()->baseUrl;?>/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl   : '<?php echo Yii::app()->baseUrl;?>/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl   : '<?php echo Yii::app()->baseUrl;?>/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl   : '<?php echo Yii::app()->baseUrl;?>/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl   : '<?php echo Yii::app()->baseUrl;?>/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl   : '<?php echo Yii::app()->baseUrl;?>/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });*/
?>