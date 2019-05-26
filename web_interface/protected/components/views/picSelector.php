<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{padding:10px;width:<?php echo $width;?>}
	#<?php echo $id;?> input{margin:0}
	#<?php echo $id;?> i{cursor:pointer}
	#<?php echo $id;?> > div.main{border:1px solid #F5D8DB}
	#<?php echo $id;?> > div.main div.block{padding:5px}
	#<?php echo $id;?> > div.main div.imgDiv{
		width:100%;
		height:<?php echo $height; ?>;/*js动态改变，算kgval*/
		background-color:silver;overflow:hidden;
		position:relative;
	}
	/*图片上的蒙板，主副标题(注意img的宽度小了10px!)*/
	#<?php echo $id;?> > div.main div.imgDiv > img{
		width:<?php echo (int)($width-10)."px";?>;
	}
	#<?php echo $id;?> > div.main div.imgDiv > div.mask{
		position:absolute;
		top:0;
		left:0;
		width:25%;/*js动态改变*/
		height:<?php echo $height; ?>;/*js动态改变,跟随imgDiv*/
		-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";/*js动态改变*/
   		filter:alpha(opacity=70);/*js动态改变*/
   		opacity: 0.7;/*js动态改变*/
	}
	#<?php echo $id;?> > div.main div.imgDiv > div.title{
		position:absolute;
		color:white;
		top:30%;/*js动态改变*/
		left:4%;/*js动态改变*/
		width:20%;/*js动态改变*/
		font-size:16px;/*js动态改变*/
	}
	#<?php echo $id;?> > div.main div.imgDiv > div.subTitle{
		position:absolute;
		color:white;
		top:50%;/*js动态改变*/
		left:4%;/*js动态改变*/
		width:20%;/*js动态改变*/
		font-size:13px;/*js动态改变*/
	}
	/****/
	#<?php echo $id;?> > div.main div.imgCtr{padding:5px}
	#<?php echo $id;?> > h4 > div.headMainCtr{display:inline}
	#<?php echo $id;?> > div.setup{
		padding:5px;
	}
	#<?php echo $id;?> > div.setup > div.line{padding:5px;}
</style>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
				$(document).undelegate("#<?php echo $id;?> div.main div.getPic","click").delegate("#<?php echo $id;?> div.main div.getPic","click",function(){
					//先标记此控件
					$(this).prop('yes',true);
					var finder = new CKFinder();	
					finder.basePath = '<?php echo Yii::app()->baseUrl;?>/ckfinder/';
					finder.resourceType = 'Images';
					finder.selectActionFunction = function( fileUrl, data ) {
						$("#<?php echo $id;?> div.main div.getPic").each(function(){
							if($(this).prop('yes') == true)
							{
						
								$(this).parent().children('input.picAddr').val(fileUrl);
								$(this).prop('yes',false);
								//预览图片
								$(this).parent().parent().children('div.imgDiv').children('img').attr('src',fileUrl);
							}
						});
						
					};
					finder.popup();
				});
</script>
<div id="<?php echo $id;?>" style="display:none" class='<?php echo $class;?>'>
	<div class="modal hide fade" id="selectTextModal" style="position:absolute;width:700px;padding-left:5px;margin-left:-350px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>选择文章</h3>
		</div>
	<?php 
		$this->widget('TextViewerWidget',array(
			'id' => 'picSelectorTextViewer',
			'catalogIdContainer' => 'PSTVCatalogId',
			'width' => '690px',
			'getTextListUrl' => Yii::app()->baseUrl."/index.php/text/getList",
			'checkStatus' => 2,//获取通过审核的text
			'hasCheckComp' => false,
			'instantLoad' => false,
			'onlyPublic' => true,
			'chooseFunc' => true,
			'getCopy' => true,
			'textIdTo' => '"#'.$id.' > div.main > div.block > div.imgCtr > input.selectTextId:enabled"',
			'checkIdTo' => '"#'.$id.' > div.main > div.block > div.imgCtr > input.selectTextCheckId:enabled"',
			'textTitleTo' => '"#'.$id.' > div.main > div.block > div.imgCtr > input.textName:enabled"',
			'targetSelector' => '"#'.$id.' > div.main > div.block > div.imgCtr > input.selectTextId:enabled"',//fire this thing's change event
		));	
	?>
	</div><!--modal-->
	<input id="<?php echo $id;?>siteWidgetIdContainer" class="siteWidgetIdContainer" type="hidden" value="sw<?php echo $siteWidgetId;?>"></input>
	<input id="<?php echo $id;?>catalogIdContainer" class="<?php echo $catalogIdContainer?>" value="" type='hidden'></input>
	<h4><?php echo $siteWidgetTitle;?> 
		<div class='headMainCtr'>
			<div class='btn btn-small btn-success' id="picSelectorSave">保存</div><span class='space'></span><div class='btn btn-small btn-info addFront'>前加一个</div><span class='space'></span><div class='btn btn-small btn-info addBack'>后加一个</div><span class='space'></span><span style='font-size:12px;color:orange' class='help-inline' id="picSelectorE"></span>
		</div>
	</h4>
	<div class="setup">
		<div class="line">本栏目此部件设置(注意文字比例不同可能导致换行与实际不同)</div>
		<div class="line">图片宽度:<input class="input-small width"></input> (主页建议980px,二级页面建议700px，本页面图片宽度790px)</div>
		<div class="line">宽高比:<input class="input-small kgval"></input> 是否有背景图:<input class="hasBG" type="checkbox">(同时背景图在外部wrap大于部件图片宽度时才会显示)</div>
		<div class="line">蒙板透明度:<input class="input-small opacity"></input> 蒙板宽度:<input class="input-small maskWidth"></input></div>
		<div class="line">
			主标题:距离顶部<input class="input-small titleTop"></input>
			距离左边<input class="input-small titleLeft"></inpit>
			行宽度<input class="input-small titleWidth"></inpit>
			字体大小<input class="input-small titleFontSize"></inpit>
		</div>
		<div class="line">
			副标题:距离顶部<input class="input-small subTitleTop"></input>
			距离左边<input class="input-small subTitleLeft"></inpit>
			行宽度<input class="input-small subTitleWidth"></inpit>
			字体大小<input class="input-small subTitleFontSize"></inpit>
		</div>
	</div>
	<div class="main"><div class="wrapLoading"><div class="loading"></div></div></div>
<?php /*	
	<div class='main'>
		<div class='block'>
			<a href='#' class='close' title='删除该图片' data-dismiss='block'>&times;</a>
			<div class='imgDiv'>
				<div class="title"></div>
				..
				<img style='width:<?php echo ($width-10)."px";?>;height:300px'></img>
			</div>
			<div class='imgCtr'>
				<span class="help-inline">图片地址:</span> 
				<input class="input-medium picAddr" readOnly='readOnly' title="请点击按钮选择图片地址" placeholder="图片地址" type="text"></input> 
				<div class="btn getPic" title="注意浏览器可能阻止弹出的图片选择窗口" >选择图片</div>
				<span class="help-inline">链接文章:</span> 
				<input class="input-medium textName" readOnly='readOnly' title="请点击按钮选择文章" disabled='disabled' placeholder="文章标题" type="text"></input> 
				<input type='hidden' class='selectTextId' disabled='disabled'></input>
				<div class="btn getText" data-toggle="modal" data-target="#selectTextModal">选择文章</div>				
			</div>
			<div class='block'>
				<span class="help-inline">图片标题:</span>
				<input class="input-large picTitle"></input>
				<span class="help-inline">图片副标题:</span>
				<input class="input-large picSubTitle"></input>
			</div>
		</div><!--one pic select block-->
	</div>
	*/
?>

</div>
<script type="text/javascript">
function makeOnePicSelector(data)
{
	if(data == '')//没有数据就返回一个空节点
	{
		var tempBlock = $("<div class='block'></div>");
			var tempClose = $("<a href='#' class='close closePS' title='删除该图片'>&times;</a>");
			tempClose.appendTo(tempBlock);
			var tempImgDiv = $("<div class='imgDiv'>"+
						"<div class='mask'></div>"+
						"<div class='title'></div>"+
						"<div class='subTitle'></div>"+
						"<img ></img>"+
					"</div>");
			tempImgDiv.appendTo(tempBlock);
			var tempImgCtr = $("<div class='imgCtr'><span class='help-inline'>图片地址:</span> <input class='input-medium picAddr' readOnly='readOnly' title='请点击按钮选择图片地址' placeholder='图片地址' type='text'></input> <div class='btn getPic' title='注意浏览器可能阻止弹出的图片选择窗口' >选择图片</div> <span class='help-inline'>链接文章:</span> <input class='input-medium textName' readOnly='readOnly' title='请点击按钮选择文章' disabled='disabled' placeholder='文章标题' type='text'></input> <input type='hidden' class='selectTextId' disabled='disabled'></input> <input type='hidden' class='selectTextCheckId' disabled='disabled'></input><div class='btn getText' data-toggle='modal' data-target='#selectTextModal'>选择文章</div> </div>");
			tempImgCtr.appendTo(tempBlock);
			tempBlock.append($('<div class="block">'+
				'<span class="help-inline">是否有蒙板:</span> <input class="hasMask" type="checkbox" checked="checked"></input>'+
				'<span class="help-inline">图片标题:</span> <input class="input-large picTitle"></input>'+
				' <span class="help-inline">图片副标题:</span><input class="input-large picSubTitle"></input>'+
			'</div>'));
		return tempBlock;
	}
	else
	{
		var tempBlock = $("<div class='block'></div>");
			var tempClose = $("<a href='#' class='close closePS' title='删除该图片'>&times;</a>");
			tempClose.appendTo(tempBlock);
			var showMask = data.hasMask == 1?"":"style='display:none'";
			var tempImgDiv = $("<div class='imgDiv'>"+
				"<div class='mask' "+showMask+"></div>"+
				"<div class='title' "+showMask+">"+data.picTitle+"</div>"+
				"<div class='subTitle' "+showMask+">"+data.picSubTitle+"</div>"+
				"<img src='"+data.picAddr+"'></img>"+
			"</div>");
			tempImgDiv.appendTo(tempBlock);
			var tempImgCtr = $("<div class='imgCtr'><span class='help-inline'>图片地址:</span> <input class='input-medium picAddr' readOnly='readOnly' value='"+
				data.picAddr+
				"' title='请点击按钮选择图片地址' placeholder='图片地址' type='text'></input> <div class='btn getPic' title='注意浏览器可能阻止弹出的图片选择窗口' >选择图片</div> <span class='help-inline'>链接文章:</span> <input class='input-medium textName' value='"+
				data.textName+"' readOnly='readOnly' title='请点击按钮选择文章' disabled='disabled' placeholder='文章标题' type='text'></input> <input type='hidden' value='"+
				data.textId+"' class='selectTextId' disabled='disabled'></input><input type='hidden' value='"+
				data.checkId+"' class='selectTextCheckId' disabled='disabled'></input> <div class='btn getText' data-toggle='modal' data-target='#selectTextModal'>选择文章</div> </div>");
			tempImgCtr.appendTo(tempBlock);
			var checkedOrNot = data.hasMask == 1?" checked='checked'":"";
			tempBlock.append($('<div class="block">'+
				'<span class="help-inline">是否有蒙板:</span> <input class="hasMask" type="checkbox"'+checkedOrNot+'></input>'+
				'<span class="help-inline">图片标题:</span> <input class="input-large picTitle" value="'+data.picTitle+'"></input>'+
				' <span class="help-inline">图片副标题:</span><input class="input-large picSubTitle" value="'+data.picSubTitle+'"></input>'+
			'</div>'));
		return tempBlock;
	}
}
//定义删除按钮动作
$(document).undelegate('#<?php echo $id;?> div.main > div.block a.closePS','click').delegate('#<?php echo $id;?> div.main > div.block a.closePS','click',function(e){
	e.preventDefault();
	$(this).parent().remove();
});
//定义保存按钮动作
$(document).undelegate('#<?php echo $id;?> div.headMainCtr #picSelectorSave','click').delegate('#<?php echo $id;?> div.headMainCtr #picSelectorSave','click',function(){
if(!$(this).hasClass('disabled')){
	//遍历所有照片，录入照片地址与文章地址已经输入d的
	var data = {};
	data.method = 'change';
	data.picArr = new Array();
	data.catalogId = $("#<?php echo $id;?> #<?php echo $id;?>catalogIdContainer").val();
	if(data.catalogId == '')
	{
		alert('Oop2s!');
		return;
	}
	$("#<?php echo $id;?> div.main > div.block").each(function(){
		if($(this).find("input.picAddr").val() != '')
		{
			var temp = {};
			if(($(this).find("input.selectTextId").val() == '') || ($(this).find("input.selectTextCheckId").val() == ''))<?php /*没有选择文章的话，就传0值*/ ?>
			{
				temp.textId = 0;
				temp.checkId = 0;
			}			
			else
			{
				temp.textId = $(this).find("input.selectTextId").val();
				temp.checkId = $(this).find("input.selectTextCheckId").val();
			}
			temp.picAddr = $(this).find("input.picAddr").val();
			temp.textName = $(this).find('input.textName').val();
			temp.picTitle = $(this).find('input.picTitle').val();
			temp.picSubTitle = $(this).find('input.picSubTitle').val();
			temp.hasMask = $(this).find('input.hasMask').prop('checked');
			data.picArr.push(temp);
		}
	});
	//部件css设置
	<?php /*不判断是否为空，在服务器端空的输入直接忽略，让其保持原样*/?>
	data.setup = {};
	data.setup.width = $("#<?php echo $id?> > div.setup > div.line > input.width").val();
	data.setup.kgval = $("#<?php echo $id?> > div.setup > div.line > input.kgval").val();
	data.setup.maskOpacity = $("#<?php echo $id?> > div.setup > div.line > input.opacity").val();
	data.setup.maskWidth = $("#<?php echo $id?> > div.setup > div.line > input.maskWidth").val();
	data.setup.titleTop = $("#<?php echo $id?> > div.setup > div.line > input.titleTop").val();
	data.setup.titleLeft = $("#<?php echo $id?> > div.setup > div.line > input.titleLeft").val();
	data.setup.titleWidth = $("#<?php echo $id?> > div.setup > div.line > input.titleWidth").val();
	data.setup.titleFontSize = $("#<?php echo $id?> > div.setup > div.line > input.titleFontSize").val();
	data.setup.subTitleTop = $("#<?php echo $id?> > div.setup > div.line > input.subTitleTop").val();
	data.setup.subTitleLeft = $("#<?php echo $id?> > div.setup > div.line > input.subTitleLeft").val();
	data.setup.subTitleWidth = $("#<?php echo $id?> > div.setup > div.line > input.subTitleWidth").val();
	data.setup.subTitleFontSize = $("#<?php echo $id?> > div.setup > div.line > input.subTitleFontSize").val();
	data.setup.hasBG = $("#<?php echo $id?> > div.setup > div.line > input.hasBG").prop("checked");
	//显示处理中并且禁用保存按钮
	$(this).addClass('disabled');
	$(this).parent().children('#picSelectorE').html('保存中...');
	//alert(data.picArr.length);
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/picSelector",data,function(result){
		//alert(result);
		if(result == 'error')
		{
			alert('Oops3');
			return;
		}
		<?php echo $id?>setCss();
		$('#<?php echo $id;?> div.headMainCtr #picSelectorSave').removeClass('disabled');
		$('#<?php echo $id;?> div.headMainCtr #picSelectorSave').parent().children('#picSelectorE').html('保存成功!');
		setTimeout(function(){$('#<?php echo $id;?> div.headMainCtr #picSelectorSave').parent().children('#picSelectorE').html('');},3000);
	});
	
}
});
//定义前加后加 动作
$(document).undelegate("#<?php echo $id;?> > h4 > div.headMainCtr > div.btn-info",'click').delegate("#<?php echo $id;?> div.headMainCtr > div.btn-info",'click',function(){
	
	var more = makeOnePicSelector('');
	if($(this).hasClass('addFront'))
	{
		$("#<?php echo $id;?> div.main").prepend(more);
	}
	else if($(this).hasClass('addBack'))
	{
		$("#<?php echo $id;?> div.main").append(more);
	}
});
$(document).undelegate("#<?php echo $id;?> div.headMainCtr #deleteLast",'click').delegate("#<?php echo $id;?> div.headMainCtr #deleteLast",'click',function(){
	$("#<?php echo $id;?> div.main > div.block").eq(-1).remove('div.block');
});
//定义文章标题、副标题、是否有蒙板改变动作
$(document).undelegate("#<?php echo $id;?> > div.main > div.block > div.block > input.picTitle","keyup").delegate("#<?php echo $id;?> > div.main > div.block > div.block > input.picTitle","keyup",function(){
	//alert($(this).val());
	$(this).parent().parent().children("div.imgDiv").children("div.title").html($(this).val());
});
$(document).undelegate("#<?php echo $id;?> > div.main > div.block > div.block > input.picSubTitle","keyup").delegate("#<?php echo $id;?> > div.main > div.block > div.block > input.picSubTitle","keyup",function(){
	//alert($(this).val());
	$(this).parent().parent().children("div.imgDiv").children("div.subTitle").html($(this).val());
});
//mask checkbox
$(document).undelegate("#<?php echo $id;?> > div.main > div.block > div.block > input.hasMask","click").delegate("#<?php echo $id;?> > div.main > div.block > div.block > input.hasMask","click",function(){
//	alert($(this).prop("checked"));
	if($(this).prop("checked") == true)
	{
		//alert('hi');
		//显示此节点的mask以预览
		$(this).parent().parent().children("div.imgDiv").children("div.title").show()
			.end().children("div.subTitle").show()
			.end().children("div.mask").show();
	}
	else
	{
		//隐藏此节点的mask以预览
		$(this).parent().parent().children("div.imgDiv").children("div.title").hide()
			.end().children("div.subTitle").hide()
			.end().children("div.mask").hide();
	}
});
//定义选择文章按钮动作，
$(document).undelegate("#<?php echo $id;?> div.block div.imgCtr div.getText",'click').delegate("#<?php echo $id;?> div.block div.imgCtr div.getText",'click',function(){
	//显示选择文章div,已经在bootstrap中定义
		//修改其div高度
		//alert($(this).offset().top-200);
		$("#<?php echo $id;?> #selectTextModal").css('top',($(this).offset().top-400)+'px');
	//把当前的input.selectTextId启用，
	$(this).parent().children('input.selectTextId').prop('disabled',false);
	//input.textName启用
	$(this).parent().children('input.textName').prop('disabled',false);
	//input.checkId启用
	$(this).parent().children('input.selectTextCheckId').prop('disabled',false);
});
//定义每个图片选择器中d的selectTextId d的change事件
$(document).undelegate("#<?php echo $id;?> > div.main > div.block > div.imgCtr > input.selectTextId",'change').delegate("#<?php echo $id;?>  > div.main > div.block > div.imgCtr > input.selectTextId",'change',function(){
	//此部件发生change,此input已经改变，隐藏modal
	$("#<?php echo $id;?> #selectTextModal").modal('hide');
	//把其textName从input textName填入 picTitle
	$(this).parent().parent().find('input.picTitle').val($(this).parent().children('input.textName').val());
	$(this).parent().parent().find('input.picTitle').keyup();//发生改变事件以预览
	//恢复input 的 disabled
	$(this).prop('disabled',true);
	$(this).parent().children('input.textName').prop('disabled',true);
	$(this).parent().children('input.selectTextCheckId').prop('disabled',true);
});
	<?php if($catalogIdContainer!='') { ?>
		$(document).delegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change",function(){
		if($("#<?php echo $id;?>").css('display') != 'none')
		{
			//栏目id改变后，取栏目id取T_cHomeDesign获取widgetName,显示在自己这，把相应的widget css display,然后触发其change事件
			if($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == null || $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == "")
			{
				alert('shit2!');
				return;
			}
		//	alert($(window).width());
			//alert('hifromPicSelector');
			//每次改变要复原到原来状态，再去取数据
			$("#<?php echo $id;?> div.main").html('<div class="wrapLoading"><div class="loading"></div></div>');
			getPicInfo($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
			//触发选择文章d的textListWidget变化 
			$("#<?php echo $id; ?> #picSelectorTextViewer #PSTVCatalogId").val($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
			$("#<?php echo $id; ?> #picSelectorTextViewer #PSTVCatalogId").change();
		}
	});
<?php } ?>
function getPicInfo(catalogId)
{
	if((catalogId == '') || (catalogId == null))
	{
		alert('Oops!c');
		return;
	}
	var data = {};
	data.catalogId = catalogId;
	data.method = 'get';
	//alert(catalogId);
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/picSelector",data,function(result){
		//alert(result);
		//清空
		$("#<?php echo $id;?> div.main").html("");
		//alert(result.catalogId);
		if(result.length == 0)
		{
			var more = makeOnePicSelector('');
			$("#<?php echo $id;?> div.main").append(more);
		}
		$.each(result,function(index,item){
			//alert(item.catalogId);
			var temp = makeOnePicSelector(item);
			$("#<?php echo $id;?> div.main").append(temp);
		});
		
		
		//获取该栏目的图片设置
		var data = {};
		data.catalogId = catalogId;
		data.method = "getSetup";
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/picSelector",data,function(result){
			//alert(result);
			//存储设置
			var kgval = result.kgval;
			var width = result.width;<?php /*宽度在预览中不直接改变，根据设置页面的800px处理宽高比来设置height*/ ?>
			var maskOpacity = result.maskOpacity;
			var maskWidth = result.maskWidth;
			var titleTop = result.titleTop;
			var titleLeft = result.titleLeft;
			var subTitleTop = result.subTitleTop;
			var subTitleLeft = result.subTitleLeft;
			var titleWidth = result.titleWidth;
			var subTitleWidth = result.subTitleWidth;
			var titleFontSize = result.titleFontSize;
			var subTitleFontSize = result.subTitleFontSize;
			var hasBG = result.hasBG;
			//填充到输入区域
			$("#<?php echo $id;?> > div.setup > div.line").children("input.kgval").val(kgval)
			.end().children("input.width").val(width)
			.end().children("input.opacity").val(maskOpacity)
			.end().children("input.maskWidth").val(maskWidth)
			.end().children("input.titleTop").val(titleTop)
			.end().children("input.titleLeft").val(titleLeft)
			.end().children("input.titleWidth").val(titleWidth)
			.end().children("input.titleFontSize").val(titleFontSize)
			.end().children("input.subTitleTop").val(subTitleTop)
			.end().children("input.subTitleLeft").val(subTitleLeft)
			.end().children("input.subTitleWidth").val(subTitleWidth)
			.end().children("input.subTitleFontSize").val(subTitleFontSize);
			if(hasBG == 1)
			{
				$("#<?php echo $id;?> > div.setup > div.line > input.hasBG").prop("checked",true);
			}
			else
			{
				$("#<?php echo $id;?> > div.setup > div.line > input.hasBG").prop("checked",false);
			}
			<?php echo $id?>setCss();
		},'json');
	},'json');	
}
function <?php echo $id;?>setCss()
{
	//修改css
	
	//alert("setting <?php echo $id?>");
	//var width = $("#<?php echo $id;?> > div.setup > div.line > input.width").val();
	var width = $("#<?php echo $id;?> > div.main div.imgDiv").css("width");
	var kgval = $("#<?php echo $id;?> > div.setup > div.line > input.kgval").val();
	var opacity = $("#<?php echo $id;?> > div.setup > div.line > input.opacity").val();
	var maskWidth = $("#<?php echo $id;?> > div.setup > div.line > input.maskWidth").val();
	var titleTop = $("#<?php echo $id;?> > div.setup > div.line > input.titleTop").val();
	var titleLeft = $("#<?php echo $id;?> > div.setup > div.line > input.titleLeft").val();
	var titleWidth = $("#<?php echo $id;?> > div.setup > div.line > input.titleWidth").val();
	var titleFontSize = $("#<?php echo $id;?> > div.setup > div.line > input.titleFontSize").val();
	var subTitleTop = $("#<?php echo $id;?> > div.setup > div.line > input.subTitleTop").val();
	var subTitleLeft = $("#<?php echo $id;?> > div.setup > div.line > input.subTitleLeft").val();
	var subTitleWidth = $("#<?php echo $id;?> > div.setup > div.line > input.subTitleWidth").val();
	var subTitleFontSize = $("#<?php echo $id;?> > div.setup > div.line > input.subTitleFontSize").val();
	//首先根据新的宽高比计算height,修改mask,imgDiv的高度
	var height = parseInt(width)/kgval;
	//alert(height);
	//div.mask
	$("#<?php echo $id;?> > div.main div.imgDiv").css({
		'height':height+"px",
	});
	$("#<?php echo $id;?> > div.main div.imgDiv > div.mask").css({
		'height':height+"px",
		'width':maskWidth,
		'-ms-filter':"progid:DXImageTransform.Microsoft.Alpha(Opacity="+opacity+")",
   		'filter':'alpha(opacity='+opacity+')',
   		'opacity': opacity/100,
	});
	//div.title
	$("#<?php echo $id;?> > div.main div.imgDiv > div.title").css({
		'top':titleTop,
		'left':titleLeft,
		'width':titleWidth,
		'font-size':titleFontSize,
	});
	$("#<?php echo $id;?> > div.main div.imgDiv > div.subTitle").css({
		'top':subTitleTop,
		'left':subTitleLeft,
		'width':subTitleWidth,
		'font-size':subTitleFontSize,
	});
	
}
</script>