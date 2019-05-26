<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{padding:10px;width:<?php echo $width;?>}
	#<?php echo $id;?> div.main{border:1px solid #F5D8DB}
	#<?php echo $id;?> div.alert{margin:0}
	#<?php echo $id;?> input{margin:0}
	#<?php echo $id;?> span.help-inline{padding-left:0}
	#<?php echo $id;?> div.A > div.selectTFDiv{position:relative/*for ie7*/;background-color:silver;height:<?php echo $Aheight;?>;overflow:auto;padding-top:20px}
	#<?php echo $id;?> div.A > div.selectTFDiv > div.feedBlock{margin:0px auto 40px auto;background:url('<?php echo Yii::app()->theme->baseUrl;?>/assets/images/feed_bg2.png') bottom left;
	height:auto!important;
	height:300px;
	min-height:300px;width:313px;padding:0 4px 10px 3px;}
	#<?php echo $id;?> div.A > div.selectTFDiv > div.feedBlock > div.feedCtr{border-top:3px solid red;padding:10px}
	#<?php echo $id;?> div.B > #TFtextViewerDiv{height:<?php echo $Bheight;?>;overflow:auto}
	/***************!!!!!important:ckeditor's <p> has padding and margin,remember to overwrite it in css both in here and home page********/
	#<?php echo $id;?> p{padding:0;margin:0}/***not useful ,ckeditor is in iframe**/
	/* already reset in config, bring in ckeditorReset.css*/
</style>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ckeditor/ckeditor.js"></script>

<div id="<?php echo $id;?>" style="display:none" class='<?php echo $class;?>'>
	<input id="<?php echo $id;?>siteWidgetIdContainer" class="siteWidgetIdContainer" type="hidden" value="sw<?php echo $siteWidgetId;?>"></input>
	<input id="<?php echo $id;?>catalogIdContainer" class="<?php echo $catalogIdContainer?>" value="" type='hidden'></input>
	<h4><?php echo $siteWidgetTitle;?>
		<div class='btn btn-success btn-small save'>保存</div>
		<span class='help-inline' style='color:orange;font-size:12px' id='<?php echo $id;?>textFeedSelectorE'></span>
	</h4>
	<h6>行距20px,建议字体大小不超过20px;未指定字体的部分将使用页面默认字体;选择文章后默认截取<?php echo $feedDefaultCharNum;?>个字符，注意结尾可能有乱码</h6>
<?php /*
	<div class='main'>
		<div class='A'>
			<input type='hidden' id='editorId' value='1'></input>
			<input type='hidden' id='textId'></input>
			<input type='hidden' id='textTitle'></input>
			<input type='hidden' id='textContent'></input>
			<div class='selectTFDiv'>
				<div class="wrapLoading"><div class="loading"></div></div>
			</div>
		</div>
		<div class='B'>	
			<div style='border-bottom:1px solid #F5D8DB;padding:5px'><span class="label label-info">选择文章</span></div>
			<div id='TFtextViewerDiv'>	
				<?php 
					$this->widget('TextViewerWidget',array(
						'id' => 'textFeedSelectorTextViewer',
						'catalogIdContainer' => 'TFTVCatalogId',
						'width' => $width,
						'getTextListUrl' => Yii::app()->baseUrl."/index.php/text/getList",
						'checkStatus' => 2,//获取通过审核的text
						'hasCheckComp' => false,
						'instantLoad' => false,
						'chooseFunc' => true,
						//'textIdTo' => '"#'.$id.' div.main > div.left > #'.$id.'selectActTextId"',
						//'textTitleTo' => '"#'.$id.' div.main > div.left > #'.$id.'selectTextTitle"',
						
						//'targetSelector' => '"#'.$id.' div.main > div.left > #'.$id.'selectActId"',
					));
				>
			</div>
		</div>
	</div>
	-->
	*/
?>
	<div class='main'>
		<div class='A'>
			<input type='hidden' id='editorId' value='1'></input>
			<input type='hidden' id='textId'></input>
			<input type='hidden' id='checkId'></input>
			<input type='hidden' id='textTitle'></input>
			<input type='hidden' id='textContent'></input>
			<input type='hidden' id='textTitlePic'></input>
			<div class='selectTFDiv'>
				<div class="wrapLoading"><div class="loading"></div></div>
			</div>
		</div>
		<div class='B'>	
			<div style='border-bottom:1px solid #F5D8DB;padding:5px'><span class="label label-info">选择文章以添加一个推送</span></div>
			<div id='TFtextViewerDiv'>	
				<?php 
					$this->widget('TextViewerWidget',array(
						'id' => 'textFeedSelectorTextViewer',
						'catalogIdContainer' => 'TFTVCatalogId',
						'width' => ($width-30).'px',
						'getTextListUrl' => Yii::app()->baseUrl."/index.php/text/getList",
						'checkStatus' => 2,//获取通过审核的text
						'hasCheckComp' => false,
						'instantLoad' => false,
						'chooseFunc' => true,
						'getCopy' => true,
						'textIdTo' => '"#'.$id.' div.main > div.A > #textId"',
						'checkIdTo' => '"#'.$id.' div.main > div.A > #checkId"',
						'textTitlePicTo' => '"#'.$id.' div.main > div.A > #textTitlePic"',
						'textTitleTo' => '"#'.$id.' div.main > div.A > #textTitle"',
						'textContentTo' => '"#'.$id.' div.main > div.A > #textContent"',
						'targetSelector' => '"#'.$id.' div.main > div.A > #textId"',
						'onlyPublic' => true,
					));
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//定义保存动作
$(document).undelegate("#<?php echo $id;?> div.save","click").delegate("#<?php echo $id;?> div.save","click",function(){
if(!$(this).hasClass('disabled'))
{
	var data = {};
	data.catalogId = $("#<?php echo $id;?> #<?php echo $id;?>catalogIdContainer").val();
	if(data.catalogId == null || data.catalogId == '')
	{
		alert('Oops!');
		return;
	}
	data.method = 'change';
	data.tfArr = new Array();
	//遍历获取信息
	$("#<?php echo $id;?> > div.main > div.A > div.selectTFDiv > div.feedBlock").each(function(index,item){
		var temp = {};
		temp.textId = $(this).children('div.feedCtr').children('input.textId').val();
		temp.checkId = $(this).children('div.feedCtr').children('input.checkId').val();
		temp.textTitle = $(this).children('div.feedCtr').children('input.textTitle').val();
			var editorId = $(this).children('textarea').attr('id');
		$.each(CKEDITOR.instances,function(key,item){
			if(item.name == editorId)
			{
				temp.feedContent = item.getData();
				return false;
			}
		});
		data.tfArr.push(temp);
	});
	//禁用保存按钮，提交
	$(this).addClass('disabled');
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/textFeedSelector",data,function(result){
	//	alert(result);
		if(result == 'error')	
		{
			alert('Oops!');
			return;
		}
		$("#<?php echo $id;?> div.save").removeClass('disabled');
		$("#<?php echo $id;?> #<?php echo $id;?>textFeedSelectorE").html("保存成功！");
		setTimeout(function(){$("#<?php echo $id;?> #<?php echo $id;?>textFeedSelectorE").html("");},3000);
	});
}
});
//定义 选择 了文章 后事件
$(document).undelegate("#<?php echo $id;?> div.main > div.A > #textId","change").delegate("#<?php echo $id;?> div.main > div.A > #textId","change",function(){
	//alert($(this).val());
	//判断显示区是否是提示
	if($("#<?php echo $id;?> div.main > div.A > div.selectTFDiv > div.wrapLoading").length != 0)
	{
		$("#<?php echo $id;?> div.main > div.A > div.selectTFDiv").html('');
	}
	//先检查有没重复添加
	var isRepeat =false;
	var textId = $("#<?php echo $id;?> div.main > div.A > #textId").val();
	$("#<?php echo $id;?> > div.main > div.A > div.selectTFDiv > div.feedBlock").each(function(){
			var tempTextId = $(this).children('div.feedCtr').children('input.textId').val();
			if(tempTextId == textId)
			{
				//alert('Oops!');
				isRepeat = true;
			}
	});
	if(isRepeat)
	{
		$("#<?php echo $id;?> #<?php echo $id;?>textFeedSelectorE").html("不能重复选择文章！");
		setTimeout(function(){$("#<?php echo $id;?> #<?php echo $id;?>textFeedSelectorE").html("");},3000);
		return;
	}
	//最新的编辑器id
	var editorId = $("#<?php echo $id;?> div.main > div.A > #editorId").val();
	$("#<?php echo $id;?> div.main > div.A > #editorId").val(editorId+1);
	//获取数据
	var data = {};
	data.editorId = editorId;
	data.textTitle = $("#<?php echo $id;?> div.main > div.A > #textTitle").val();
	data.textId = $("#<?php echo $id;?> div.main > div.A > #textId").val();
	data.checkId = $("#<?php echo $id;?> div.main > div.A > #checkId").val();
	//data.catalogId = $("#<?php echo $id;?> #<?php echo $id;?>catalogIdContainer").val();
	data.textContent = $("#<?php echo $id;?> div.main > div.A > #textContent").val().substr(0,<?php echo $feedDefaultCharNum;?>)+"...";//有风险，万一是一个标签？？？
	//alert(data.textContent);
	data.textTitlePic = $("#<?php echo $id;?> div.main > div.A > #textTitlePic").val();
	//取填充值构造feedBlock节点
	makeTextFeedBlock(data,true);
});
function makeTextFeedBlock(data,isNewTF)//该函数默认append到 div.main > div.A > div.selectTFDiv后CKEDITOR.replace
{
	if(data.textTitle == null)
	{
		alert('Oops!');
		return;
	}
	if(data.textId == null)
	{
		alert('Oops!');
		return;
	}
	if(data.editorId == null)
	{
		alert('Oops!');
		return;
	}
	var tempBlock = $('<div class="feedBlock"></div>');
		var tempCtr = $('<div class="feedCtr">' + 
			'<span class="help-inline">文章标题:</span>' +
			"<input disabled='disabled' class='textTitle input-large' value='"+data.textTitle+"'></input>"+
			"<div class='wrapLoading'>" +
				"<div class='btn btn-small btn-info up'>上移</div> " +
				"<div class='btn btn-small btn-info down'>下移</div> " +
				"<div class='btn btn-small btn-danger del'>删除</div> " +
			"</div>" +
			"<div class='wrapLoading'>" +
				"<span class='help-inline'>提示：推送编辑区域宽度为290px</span>"+
			"</div>" +
			"<input class='textId' type='hidden' value='"+data.textId+"'></input>" +
			"<input class='checkId' type='hidden' value='"+data.checkId+"'></input>" +
		'</div>');
		var tempTextarea = $('<textarea id="'+data.editorId+'"></textarea>');
		tempBlock.append(tempCtr);
		tempBlock.append(tempTextarea);
		$("#<?php echo $id;?> div.main > div.A > div.selectTFDiv").prepend(tempBlock);
		var temp = CKEDITOR.replace(data.editorId, <?php $temp = Text::json_encode_ch3($editorConfig); echo $temp;?>);
		if(isNewTF)
		{
			if(data.textTitlePic != '')
			{
				temp.setData("<img src='"+data.textTitlePic+"'></img>"+"<p><span style='font-size:24px'>"+data.textTitle+"</span></p>"+data.textContent);			
			}
			else
			{
				temp.setData("<p><span style='font-size:24px'>"+data.textTitle+"</span></p>"+data.textContent);					
			}
		}
		else
		{
			temp.setData(data.textContent);						
		}
}
//定义上下移/删除动作
$(document).undelegate("#<?php echo $id;?> div.feedBlock div.wrapLoading > div.btn","click").delegate("#<?php echo $id;?> div.feedBlock div.wrapLoading > div.btn","click",function(){
	if($(this).hasClass('up'))
	{
		var $obj = $(this);
		//顶端了
		if($obj.parent().parent().parent('div.feedBlock').prev().length == 0)
		{
			return;
		}
		var name = '';
		var data = '';
		$.each(CKEDITOR.instances,function(key,item){
			if(item.name == $obj.parent().parent().parent('div.feedBlock').children('textarea').attr('id'))
			{
				data = item.getData();
				name = item.name;
				//alert(name);
				//alert('cop');
				item.destroy();
				return false;
			}		
		});
		//alert(name);
		$obj.parent().parent().parent('div.feedBlock').insertBefore($obj.parent().parent().parent('div.feedBlock').prev());	
		//alert(name);
		var a = CKEDITOR.replace(name, <?php echo $temp;?>);
		a.setData(data);
	
	}
	else if($(this).hasClass('down'))
	{
		var $obj = $(this);
		//末尾了
		if($obj.parent().parent().parent('div.feedBlock').next().length == 0)
		{
			return;
		}
		var name = '';
		var data = '';
		$.each(CKEDITOR.instances,function(key,item){
			if(item.name == $obj.parent().parent().parent('div.feedBlock').children('textarea').attr('id'))
			{
				data = item.getData();
				name = item.name;
				//alert(name);
				//alert('cop');
				item.destroy();
				return false;
			}		
		});
		//alert(name);
		$obj.parent().parent().parent('div.feedBlock').insertAfter($obj.parent().parent().parent('div.feedBlock').next());	
		//alert(name);
		var a = CKEDITOR.replace(name, <?php echo $temp;?>);
		a.setData(data);

	}
	else if($(this).hasClass('del'))
	{
		var $obj = $(this);
		$.each(CKEDITOR.instances,function(key,item){
			if(item.name == $obj.parent().parent().parent('div.feedBlock').children('textarea').attr('id'))
			{
				item.destroy();
				return false;
			}
			
		});
		$obj.parent().parent().parent('div.feedBlock').remove();
	}
});



<?php
	/*$(document).undelegate("#<?php echo $id;?> div.addOne","click").delegate("#<?php echo $id;?> div.addOne","click",function(){
	alert('c');
	$.each(CKEDITOR.instances,function(key,item){
		alert(item.getData());
		alert(item.name);
	});
});*///ok!!!!!!!!!
?>
	<?php if($catalogIdContainer!='') { ?>
		$(document).undelegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change").delegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change",function(){
		if($("#<?php echo $id;?>").css('display') != 'none')
		{
			//栏目id改变后，取栏目id取T_cHomeDesign获取widgetName,显示在自己这，把相应的widget css display,然后触发其change事件
			if($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == null || $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == "")
			{
				alert('shit2!');
				return;
			}
		
			//alert('hifromActSelector');
			//每次改变要复原到原来状态，再去取数据
			$("#<?php echo $id;?> div.main > div.left > div.selectTFDiv").html('<div class="wrapLoading"><div class="loading"></div></div>');
		
			getFeedInfo($('#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>').val());
			//触发textViewer 变化
			$("#<?php echo $id; ?> #textFeedSelectorTextViewer #TFTVCatalogId").val($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
			$("#<?php echo $id; ?> #textFeedSelectorTextViewer #TFTVCatalogId").change();
		}
	});
<?php } ?>
function getFeedInfo(catalogId)
{
	var data={};
	data.catalogId = catalogId;
	data.method = 'get';
	$.post('<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/textFeedSelector',data,function(result){
		//alert(result);
		//清空
		
		$("#<?php echo $id;?> div.main > div.A > div.selectTFDiv").html('');
		
		$.each(result,function(index,item){
			var editorId = $("#<?php echo $id;?> div.main > div.A > #editorId").val();
			$("#<?php echo $id;?> div.main > div.A > #editorId").val(editorId+1);
			var data = {};
			data.editorId = editorId;
			data.textTitle = item.feedTitle;
			data.textId = item.textId;
			data.checkId = item.checkId;
			data.textContent = item.feedContent;
			makeTextFeedBlock(data,false);		
		});
		if(result.length == 0)
		{
			$("#<?php echo $id;?> div.main > div.A > div.selectTFDiv").html("<div class='wrapLoading'><h2 style='color:white'>没有内容</h2></div>");
		}
	},'json');
		
}
function getNum(str)
{
var reg=/^[a-zA-Z]+([0-9]+)$/g;
if(reg.test(str))
{
reg.lastIndex = 0;
return reg.exec(str)[1];
}
else
{
return "";
}
}
</script>