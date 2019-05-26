<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.11
	****************/
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
	//图片选择的script
			$(document).undelegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.selectPic","click").delegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.selectPic","click",function(){
					//先标记此控件
					//alert("hi");
					$(this).prop('yes',true);
					var finder = new CKFinder();	
					finder.basePath = '<?php echo Yii::app()->baseUrl;?>/ckfinder/';
					finder.resourceType = 'Images';
					finder.selectActionFunction = function( fileUrl, data ) {
						$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.selectPic").each(function(){
							if($(this).prop('yes') == true)
							{
						
								$(this).parent().parent().find('div.line > input.imgAddr').val(fileUrl);
								$(this).prop('yes',false);
								//预览图片
								$(this).parent().parent().parent().children('div.example').children('div.imgDiv').children('img').attr('src',fileUrl);
							}
						});
						
					};
					finder.popup();
				});
<?php if($catalogIdContainer!='') { ?>
		$(document).undelegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change").delegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change",function(){
		//切换了栏目id,则去数据库取
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
			$("#<?php echo $id;?> div.main > div.right > div.editArea").html('<div class="wrapLoading"><div class="loading"></div></div>');
			getCatalogRecInfo($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
			
		}
	});
<?php } ?>
function getCatalogRecInfo(catalogId)
{
	//获取setup信息
	/*controller 中此方法备忘：当当前catalogId的setup没有内容时，添加默认的一行并且返回给客户端 */
	//getCatalogRecSetup(catalogId);<?php /*现在改为在recStuff已经载入后再修改css*/?>
	//获取rec信息
	getCatalogRecStuff(catalogId);
}

function getCatalogRecStuff(catalogId)//获取该catalogId 的子推荐栏目
{
	var data = {};
	data.method = "getRec";
	data.catalogId = catalogId;
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/catalogRec",data,function(result){
		//alert(result);
		if((result.status != null) && (result.status == "error"))
		{
			alert("s!");
			return;
		}
		$("#<?php echo $id;?> div.main > div.right > div.editArea").html("");
		//alert(result.catalogId);
		if(result.length != 0)
		{
			//alert("hi");
			$.each(result,function(index,item){
				var temp = makeOneRec<?php echo $id;?>(item.recCatalogId,item.recTitle,item.recIntro,item.recImgAddr);
				$("#<?php echo $id;?> div.main > div.right > div.editArea").append(temp);
			});
		}
		getCatalogRecSetup($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
	},'json')
}
function getCatalogRecSetup(catalogId)
{
	var data = {};
	data.method = "getSetup";
	data.catalogId = catalogId;
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/catalogRec",data,function(result){
		//alert(result);
		if((result.status != null) && (result.status == "error"))
		{
			alert("s!");
			return;
		}
		$("#<?php echo $id;?> > div.setup > div.line > input.width").val(result.width);
		$("#<?php echo $id;?> > div.setup > div.line > input.bgColor").val(result.bgColor);
		$("#<?php echo $id;?> > div.setup > div.line > input.cataT").val(result.cataT_font_size);
		$("#<?php echo $id;?> > div.setup > div.line > input.cataI").val(result.cataI_font_size);
		$("#<?php echo $id;?> > div.setup > div.line > input.lineNum").val(result.lineNum);
		$("#<?php echo $id;?> > div.setup > div.line > input.gapWidth").val(result.gapWidth);
		$("#<?php echo $id;?> > div.setup > div.line > input.height").val(result.height);
		$("#<?php echo $id;?> > div.setup > div.line > input.left").val(result.textLeft);
		//下面根据上述设置，修改div.example中的样式(注意，此处cataT,cataI的位置要跟catalogRec部件中的样式相同)
		<?php echo $id?>setCss();
		
	},'json')
}
function <?php echo $id?>setCss()
{
		var width = $("#<?php echo $id;?> > div.setup > div.line > input.width").val();
		var bgColor = $("#<?php echo $id;?> > div.setup > div.line > input.bgColor").val();
		var cataT_font_size = $("#<?php echo $id;?> > div.setup > div.line > input.cataT").val();
		var cataI_font_size = $("#<?php echo $id;?> > div.setup > div.line > input.cataI").val();
		var lineNum = $("#<?php echo $id;?> > div.setup > div.line > input.lineNum").val();
		var gapWidth = $("#<?php echo $id;?> > div.setup > div.line > input.gapWidth").val();
		var height = $("#<?php echo $id;?> > div.setup > div.line > input.height").val();
		var textLeft = $("#<?php echo $id;?> > div.setup > div.line > input.left").val();
	//计算一个块的宽度
		var width = parseInt(width);
		var gapWidth = parseInt(gapWidth);
		var lineNum = parseInt(lineNum);
		var blockWidth = (width-(lineNum-1)*gapWidth)/lineNum;
		//alert(blockWidth);
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block").css("width",blockWidth+"px");
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example").css("width",blockWidth+"px");
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example").css("height",height);
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example").css("background-color",bgColor);

			//alert($("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example").css("background-color"));
			$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example").css("background-color",bgColor);
			$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogTitle").css("background-color",bgColor);
			$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogIntro").css("background-color",bgColor);

		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogTitle").css('fontSize',cataT_font_size);
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogTitle").css('left',textLeft);
		
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogIntro").css('fontSize',cataI_font_size);
		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogIntro").css('left',textLeft);

		$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.imgDiv > img").css('height',height);
}
//保存动作
$(document).undelegate("#<?php echo $id;?> > h4 > div.save","click").delegate("#<?php echo $id;?> > h4 > div.save","click",function(){
	//alert("hi");
if(!$(this).hasClass('disabled'))
{
	var data = {};
	data.method = "save";
	data.catalogId = $("#<?php echo $id;?> > #<?php echo $id;?>catalogIdContainer").val();
	if(data.catalogId == "")
	{
		alert('Oops!');
		return;
	}
//	alert('s');
	data.setup = {};
	data.setup.width = $("#<?php echo $id;?> > div.setup > div.line > input.width").val();
	data.setup.height = $("#<?php echo $id;?> > div.setup > div.line > input.height").val();
	data.setup.gapWidth = $("#<?php echo $id;?> > div.setup > div.line > input.gapWidth").val();
	data.setup.left = $("#<?php echo $id;?> > div.setup > div.line > input.left").val();
	data.setup.bgColor = $("#<?php echo $id;?> > div.setup > div.line > input.bgColor").val();
	data.setup.cataT = $("#<?php echo $id;?> > div.setup > div.line > input.cataT").val();
	data.setup.cataI = $("#<?php echo $id;?> > div.setup > div.line > input.cataI").val();
	data.setup.lineNum = $("#<?php echo $id;?> > div.setup > div.line > input.lineNum").val();

	data.rec = new Array();
	$("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block").each(function(){
		if(($(this).find("div.edit > div.line > input.catalogId").val() != "") && ($(this).find("div.edit > div.line > input.catalogTitle").val() != ""))
		{
			
			var temp = {};
			temp.recCatalogId = $(this).find("div.edit > div.line > input.catalogId").val();
			temp.catalogTitle = $(this).find("div.edit > div.line > input.catalogTitle").val();
			temp.catalogIntro = $(this).find("div.edit > div.line > input.intro").val();
			temp.imgAddr = $(this).find("div.edit > div.line > input.imgAddr").val();
			data.rec.push(temp);
		}
	});
	//显示处理中并且禁用保存按钮
	$(this).addClass('disabled');
	$(this).parent().children('#catalogRecSelectorE').html('保存中...');
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/optWidget/catalogRec",data,function(result){
		//alert(result);
		<?php echo $id?>setCss();
		$('#<?php echo $id;?> > h4 > div.save').removeClass('disabled');
		$('#<?php echo $id;?> > h4 > #catalogRecSelectorE').html('保存成功!');
		setTimeout(function(){$('#<?php echo $id;?> > h4 > #catalogRecSelectorE').html('');},3000);
	});
}
});
//****定义每个block的控制
//删除图片
$(document).undelegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.deletePic","click").delegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.deletePic","click",function(){
	//alert("a");
	//删除input:hidden的imgAddr
	$(this).parent().parent().find('div.line > input.imgAddr').val("");
	$(this).parent().parent().parent().children('div.example').children('div.imgDiv').children('img').attr('src',"");
});
//删除此推荐
$(document).undelegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.deleteBlock","click").delegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > div.deleteBlock","click",function(){
	//alert("a");
	//删除input:hidden的imgAddr
	$(this).parent().parent().parent().remove();
});
//定义简介输入框修改时，展示区域同时修改
$(document).undelegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > input.intro","keyup").delegate("#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line > input.intro","keyup",function(){
	//alert($(this).val());
	$(this).parent().parent().parent().children("div.example").children("div.catalogIntro").html($(this).val());
});
//选择栏目(在catalogView里点击，并且触发了div.right的input.catalogId的change事件)
$(document).undelegate("#<?php echo $id;?> > div.main > div.right > input.catalogId","change").delegate("#<?php echo $id;?> > div.main > div.right > input.catalogId","change",function(){
	//alert($(this).parent().children('input.catalogTitle').val());
	//alert($(this).parent().children('input.catalogIntro').val());
	//alert($(this).val());
	//先检查是否已经有该推荐//暂时不限制重复推荐
	//checkCatalog($(this).val());
	//构造节点
	var tempBlock = makeOneRec<?php echo $id;?>($(this).val(),$(this).parent().children('input.catalogTitle').val(),$(this).parent().children('input.catalogIntro').val(),"");
	$("#<?php echo $id;?> > div.main > div.right > div.editArea").append(tempBlock);
});
function makeOneRec<?php echo $id;?>(catalogId,catalogTitle,catalogIntro,imgAddr)
{
	if(imgAddr == "")
	{
	return		$('<div class="block">'+
					'<div class="example">'+
						'<div class="catalogTitle">'+catalogTitle+'</div>'+
						'<div class="catalogIntro">'+catalogIntro+'</div>'+
						'<div class="imgDiv">'+
							'<img src=""></img>'+
						'</div>'+
					'</div>'+
					'<div class="edit">'+
						'<div class="line">'+
							'栏目简介: <input class="intro input-medium" value="'+catalogIntro+'"></input>'+
							'<input type="hidden" class="catalogId" value="'+catalogId+'"></input>'+
							'<input type="hidden" class="imgAddr" value=""></input>'+
							'<input type="hidden" class="catalogTitle" value="'+catalogTitle+'"></input>'+
						'</div>'+
						'<div class="line"> '+
							'<div class="selectPic btn btn-small btn-info">选择图片</div> '+
							'<div class="deletePic btn btn-small btn-danger">删除图片</div> '+
						'</div>'+
						'<div class="line"> '+
							'<div class="deleteBlock btn btn-danger btn-small">删除此推荐</div>'+
						'</div>'+
					'</div>'+
				'</div>');
	}
	else
	{
	return		$('<div class="block">'+
					'<div class="example">'+
						'<div class="catalogTitle">'+catalogTitle+'</div>'+
						'<div class="catalogIntro">'+catalogIntro+'</div>'+
						'<div class="imgDiv">'+
							'<img src="'+imgAddr+'"></img>'+
						'</div>'+
					'</div>'+
					'<div class="edit">'+
						'<div class="line">'+
							'栏目简介: <input class="intro input-medium" value="'+catalogIntro+'"></input>'+
							'<input type="hidden" class="catalogId" value="'+catalogId+'"></input>'+
							'<input type="hidden" class="imgAddr" value="'+imgAddr+'"></input>'+
							'<input type="hidden" class="catalogTitle" value="'+catalogTitle+'"></input>'+
						'</div>'+
						'<div class="line"> '+
							'<div class="selectPic btn btn-small btn-info">选择图片</div> '+
							'<div class="deletePic btn btn-small btn-danger">删除图片</div> '+
						'</div>'+
						'<div class="line"> '+
							'<div class="deleteBlock btn btn-danger btn-small">删除此推荐</div>'+
						'</div>'+
					'</div>'+
				'</div>');
	}
}
</script>
<style type="text/css">
	#<?php echo $id;?>{padding:10px;width:<?php echo $width;?>}
	#<?php echo $id;?> > div.setup > div.line{padding:5px}
	#<?php echo $id;?> > div.main{border:1px solid #F5D8DB;position:relative}
	#<?php echo $id;?> > div.main > div.left{
		float:left;
		width:200px;
	}
	#<?php echo $id;?> > div.main > div.right{
		margin:0 0 0 200px;
		position:relative/*for ie7*/;
		background-color:silver;
		overflow:auto;
		padding-top:20px;
		height:<?php echo ($height-100)."px";?>;
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block{
		margin:0 auto;
		width:316px;/*js动态改变*/
		padding:10px 0;
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example{
		height:140px;/*js动态改变*/
		width:316px;/*js动态改变*/
		background-color:rgb(220,22,9);/*js动态改变*/
		position:relative;
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogTitle{
		font-size:18px;/*js动态改变*/
		color:white;
		font-weight:bold;
		position:absolute;
		top:30%;
		left:13%;/*js动态改变*/
		background-color:rgb(220,22,9);/*js动态改变*/
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.catalogIntro{
		font-size:14px;/*js动态改变*/
		color:white;
		font-weight:bold;
		position:absolute;
		top:45%;
		left:13%;/*js动态改变*/
		background-color:rgb(220,22,9);/*js动态改变*/
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.imgDiv{float:right}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.example > div.imgDiv > img{height:140px}/*js动态改变*/
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit{
		background-color:white;
		padding:10px;
	}
	#<?php echo $id;?> > div.main > div.right > div.editArea > div.block > div.edit > div.line{
		padding:5px;
	}
</style>
<div id="<?php echo $id;?>" style="display:none" class='<?php echo $class;?>'>
	<input id="<?php echo $id;?>siteWidgetIdContainer" class="siteWidgetIdContainer" type="hidden" value="sw<?php echo $siteWidgetId;?>"></input>
	<input id="<?php echo $id;?>catalogIdContainer" class="<?php echo $catalogIdContainer?>" value="" type='hidden'></input>
	<h4><?php echo $siteWidgetTitle;?> 
		<div class='btn btn-small btn-success save'>保存</div>
		<span style='font-size:12px;color:orange' class='help-inline' id="catalogRecSelectorE"></span>
	</h4>
	<div class="setup">
		<div class="line">部件设置</div>
		<div class="line">宽度:<input class="width input-medium"></input> 背景颜色:<input class="bgColor input-medium"></input></div>
		<div class="line">子栏目标题字体大小:<input class="cataT input-medium"></input> 简介字体大小:<input class="cataI input-medium"></input></div>
		<div class="line">一行有几个:<input class="lineNum input-medium"> 块高度:<input class="height input-medium"></div>
		<div class="line">块左右间隔:<input class="gapWidth input-medium" readOnly="readOnly"> 文字离左边距离:<input class="left input-medium" readOnly="readOnly"></div>
		<div class="line">操作提示:点击左边的子栏目即可添加新的推荐(暂时不能上下移动哈哈哈) 二级页面建议宽度700px,一行2个推荐 <br/>要换行的请自行写入换行标签</div>
	</div>
	<div class="main">
		<div class="left">
		<?php 
			$this->widget("CatalogViewerWidget",array(
				'id' => $id."cv",
				'targetSelector' => '"#'.$id.' > div.main > div.right > input.catalogId"',
				'targetIntroSelector' => '"#'.$id.' > div.main > div.right > input.catalogIntro"',
				'targetTitleSelector' => '"#'.$id.' > div.main > div.right > input.catalogTitle"',
				'width' => '190px',
				'noChild' => false,
				'getUrl' => Yii::app()->baseUrl."/index.php/catalog/get",
				'showInternal' => false,
				'showNoText' => false,
				'instantChange'=>false,
				'dynamicChange'=>true,
				'cataIdArrContainerId'=>$id."cvId",
			));
		?>
		</div>
		<div class="right">
			<input class="catalogId" type="hidden" value=""></input>
			<input class="catalogTitle" type="hidden" value=""></input>
			<input class="catalogIntro" type="hidden" value=""></input>
			<div class="editArea"></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>