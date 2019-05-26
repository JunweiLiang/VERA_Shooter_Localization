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
	#<?php echo $id;?> i{cursor:pointer}
	#<?php echo $id;?> span.help-inline{padding-left:0}
	#<?php echo $id;?> div.left{width:400px;float:left;}
	#<?php echo $id;?> div.left > div.selectTextBDiv{overflow:auto;position:relative;height:<?php echo $height;?>}
	#<?php echo $id;?> div.right{width:380px;margin:0 0 0 410px;}
	#<?php echo $id;?> div.right > #TLStextViewerDiv{height:<?php echo $height;?>;overflow:auto}
</style>
<div id="<?php echo $id;?>" style="display:none" class='<?php echo $class;?>'>
	<input id="<?php echo $id;?>siteWidgetIdContainer" class="siteWidgetIdContainer" type="hidden" value="sw<?php echo $siteWidgetId;?>"></input>
	<input id="<?php echo $id;?>catalogIdContainer" class="<?php echo $catalogIdContainer?>" value="" type='hidden'></input>
	<h4><?php echo $siteWidgetTitle;?>
		<div class='btn btn-success btn-small save'>保存</div>
		<span class='help-inline' style='color:orange;font-size:12px' id='<?php echo $id;?>textListSelectorE'></span>
	</h4>
	<!-- 初始状态
	<div class='main'>
		<div class='left'><div class="wrapLoading"><div class="loading"></div></div>
		</div>
		<div class='right'>
			<div id='TLStextViewerDiv'>
			</div>
		</div>
	</div>
	-->
	<div class='main'>
		<div class='left'>
			<input type='hidden' id='<?php echo $id;?>selectTextId'></input>
			<input type='hidden' id='<?php echo $id;?>selectCheckId'></input>
			<input type='hidden' id='<?php echo $id;?>selectTextTitle'></input>
			
			<div class='selectTextBDiv'><div class="wrapLoading"><div class="loading"></div></div>
			</div>
		</div>
		<div class='right'>
			<div id='TLStextViewerDiv'>
				<?php
					$this->widget('TextViewerWidget',array(
						'id' => 'textListSelectorTextViewer',
						'catalogIdContainer' => 'TLSTVCatalogId',
						'width' => '360px',
						'getTextListUrl' => Yii::app()->baseUrl."/index.php/text/getList",
						'checkStatus' => 2,//获取通过审核的text
						'hasCheckComp' => false,
						'instantLoad' => false,
						'chooseFunc' => true,
						'actTextOnly' => false,
						'getCopy' => true,
						'onlyPublic' => true,
						'showInModal' => true,
						'textIdTo' => '"#'.$id.' div.main > div.left > #'.$id.'selectTextId"',
						'checkIdTo' => '"#'.$id.' div.main > div.left > #'.$id.'selectCheckId"',
						'textTitleTo' => '"#'.$id.' div.main > div.left > #'.$id.'selectTextTitle"',
						'targetSelector' => '"#'.$id.' div.main > div.left > #'.$id.'selectTextId"',
					));	
					
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function makeOneTextB(data)
{
	var tempBlock = $("<div class='alert alert-success'><a href='#' class='close' title='删除该文章' data-dismiss='alert'>&times;</a></div>");
	var tempS = $("<div class='addedTextB'>"+
		"<span class='help-inline'>文章标题:</span><input type='text' class='textTitle' value='"+data.textTitle+"'></input>"+
		
		"<input type='hidden' class='textId' value='"+data.textId+"'></input>"+
		"<input type='hidden' class='checkId' value='"+data.checkId+"'></input>"
	+"</div>");
	tempS.appendTo(tempBlock);
	var tempCtr = $("<div class='addedTextBCtr' style='display:none'>"
		+ "<i class='icon-arrow-up' title='上移'></i><span class='space'></span>" +
		"<i class='icon-arrow-down' title='下移'></i>"+
	"</div>");
	tempCtr.appendTo(tempBlock);
	return tempBlock;
}
//定义进入alert动作，显示上移 下移控件
$(document).undelegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv > div.alert","mouseenter").delegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv > div.alert","mouseenter",function(){
	$(this).children('div.addedTextBCtr').show();
});
$(document).undelegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv> div.alert","mouseleave").delegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv > div.alert","mouseleave",function(){
	$(this).children('div.addedTextBCtr').hide();
});
//定义上下移控件动作
$(document).undelegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv > div.alert i","click").delegate("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv > div.alert i","click",function(){
	if($(this).hasClass('icon-arrow-up'))
	{
		$(this).parent().parent('div.alert').insertBefore($(this).parent().parent('div.alert').prev());
	}
	else if($(this).hasClass('icon-arrow-down'))
	{
		$(this).parent().parent('div.alert').insertAfter($(this).parent().parent('div.alert').next());
	}
});
//定义selectTextId改变动作
$(document).undelegate("#<?php echo $id;?> div.main > div.left > #<?php echo $id;?>selectTextId",'change').delegate("#<?php echo $id;?> div.main > div.left > #<?php echo $id;?>selectTextId",'change',function(){
	//alert($(this).val());
	//检查文章是否重复
	var redeclare = false;
	$("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv div.addedTextB").each(function(){
		if($(this).children('input.textId').val() == $('#<?php echo $id;?> div.main > div.left > #<?php echo $id;?>selectTextId').val())
		{
			redeclare = true;
			//alert('Oops');
		}		
	});
	if(redeclare)
	{
		$("#<?php echo $id;?>textListSelectorE").html('不能重复添加相同文章!');
		setTimeout(function(){$("#<?php echo $id;?>textListSelectorE").html('');},3000);
		return;
	}
	var data = {};
	data.textTitle = $(this).parent().children('#<?php echo $id;?>selectTextTitle').val();
	
	data.textId = $(this).parent().children('#<?php echo $id;?>selectTextId').val();
	data.checkId = $(this).parent().children('#<?php echo $id;?>selectCheckId').val();
	var temp = makeOneTextB(data);
	temp.prependTo($("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv"));
});
//定义保存按钮动作
$(document).undelegate("#<?php echo $id;?> div.save","click").delegate("#<?php echo $id;?> div.save","click",function(){
if(!$(this).hasClass('disabled'))
{
	var data = {};
	data.catalogId = $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val();
	data.method = 'change';
	data.textArr = new Array();
	if(data.catalogId == '')
	{
		alert('Oops!');	
		return;
	}
	$("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv div.addedTextB").each(function(){
		if($(this).find('input.textTitle') != '')
		{
			var temp = {};
			temp.textTitle = $(this).find("input.textTitle").val();
			temp.textId = $(this).find("input.textId").val();	
			temp.checkId = $(this).find("input.checkId").val();			
			data.textArr.push(temp);
		}
	});
	//显示保存中
	$(this).addClass('disabled');
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/textListSelector",data,function(result){
		//alert(result);
		if(result == 'error')
		{
			alert('Oopsy');
			return;
		}
		$("#<?php echo $id;?> div.save").removeClass('disabled');
		$("#<?php echo $id;?>textListSelectorE").html('保存成功!');
		setTimeout(function(){$("#<?php echo $id;?>textListSelectorE").html('');},3000);
	});
}
});
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
			$("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv").html('<div class="wrapLoading"><div class="loading"></div></div>');
			getTextListInfo($('#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>').val());
			//触发textViewer 变化
			$("#<?php echo $id; ?> #textListSelectorTextViewer #TLSTVCatalogId").val($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
			$("#<?php echo $id; ?> #textListSelectorTextViewer #TLSTVCatalogId").change();
		}
	});
<?php } ?>
function getTextListInfo(catalogId)
{
	var data={};
	data.catalogId = catalogId;
	data.method = 'get';
	$.post('<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/textListSelector',data,function(result){
		//alert(result);
		//清空
		$("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv").html('');
		$.each(result,function(index,item){
			var temp = makeOneTextB(item);
			temp.appendTo($("#<?php echo $id;?> div.main > div.left > div.selectTextBDiv"));
		});
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