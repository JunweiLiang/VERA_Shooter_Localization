<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	div.mainx{
		height:auto!important;
		height:800px;
		min-height:800px;
	}
	div.mainx > div.preview,div.mainx > div.edit{
		padding:10px;
		position:relative;
	}div.mainx > div.preview > div.title{font-weight:bold;padding:10px 0;border-bottom:1px silver solid;margin-bottom:10px;}
	div.mainx > div.edit > div.loadingBlock{
		position:absolute;top:0;left:0;
		height:300px;
		background-color:silver;
		z-index:9999;
		padding-top:100px;
		width:830px;
		opacity:0.6;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=60);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"; /*IE8*/		
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		//进入页面读取
		//alert("a");
		//CKEDITOR.on('instanceReady', function (e) { alert(e.editor.name+'加载完毕！')});
		//getNotice(<?php echo $arr['noticeId']?>);
		xshowLoading();
		//为了ckeditor的载入 
		setTimeout(function(){getNotice(<?php echo $arr['noticeId']?>);},1000);
		
	});
	//保存
	$(document).delegate("div.mainx > div.edit > div.save","click",function(){
		var data = {};
		data["noticeId"] = <?php echo $arr['noticeId']?>;
		data["notice"] = notice.getData();
		xshowLoading();
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/notice/set",data,function(result){
			//alert(result);
			window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/notice?noticeId=<?php echo $arr['noticeId']?>","_self");
		});
	});

function getNotice(noticeId)
{
	xshowLoading();
	//alert(noticeId);
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/notice/get?noticeId=<?php echo $arr['noticeId']?>","",function(result){
		//alert(result);
		CKEDITOR.instances["notice"].setData(result);
		xhideLoading();
		
	});
}
function xshowLoading()
{
	$("div.mainx > div.edit > div.loadingBlock").show();
}
function xhideLoading()
{
	$("div.mainx > div.edit > div.loadingBlock").hide();
}
</script>
<div class="mainx">
	<div class="preview">
		<div class="title">
			<?php echo $arr['noticeIntro'];?>		
			<a class="btn btn-small " target="_self" href="<?php echo Yii::app()->baseUrl?>/index.php/application/notice">返回</a>
		</div>
		<div class="content"><?php echo $arr['content']?></div>
	</div>
	<div class="edit">
		<div class="loadingBlock"><div class="wrapLoading"><div class="loading"></div></div></div>
		<?php
			$this->widget("TablrWidget",array(
				"editorConfig" =>  array(
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
			'width' => '810px',
			'height' => '600px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		),
				"param" => array(
					array(
						"name" => "notice",
						"type" => "ckeditor",
						"title" => "",
					)
				)
			));
		?>
		<div class="btn btn-small btn-info btn-block save">保存</div>
	</div>
</div>