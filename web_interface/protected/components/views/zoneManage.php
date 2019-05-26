<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id;?>{
	position:relative;
}
#<?php echo $id;?> > div.main{
	padding:10px;
}
#<?php echo $id;?> > div.main > div.line{
	padding:5px 0;
}
#<?php echo $id;?> > div.main > div.title{
	border-left:3px solid blue;
	padding-left:20px;
	font-size:14px;
	font-weight:bold;
	background-color:rgb(245,245,245);
}
#<?php echo $id;?> > div.main > div.arr{
	
	background-color:rgb(250,250,250);
	border:1px solid silver;
	border-width:1px 0;
	/*
	height:200px;
	overflow:auto;
	*/
}
#<?php echo $id;?> > div.main > div.typeArr > div.typeBlock,
#<?php echo $id;?> > div.main > div.locArr > div.locBlock{
	background-color:rgb(240,240,240);
	position:relative;
	padding-top:3px;
	margin-bottom:3px;
	margin-right:10px;
}
#<?php echo $id;?> > div.main > div.typeArr > div.typeBlock > div.deleteBlock,
#<?php echo $id;?> > div.main > div.locArr > div.locBlock > div.deleteBlock{
	width:30px;
	text-align:right;
	height:30px;
	position:absolute;
	top:2px;
	right:5px;
	cursor:pointer;
}
#<?php echo $id;?> > div.main > div.title > span.zoneSaveE{
	color:red;
}
#<?php echo $id;?> > div.zloading{
		padding:100px 0;
		height:1700px;
		width:100%;
		display:none;
		background-color:silver;
		opacity:0.<?php echo $loadingOpa;?>;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=<?php echo $loadingOpa;?>);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $loadingOpa;?>)"; /*IE8*/
		position:absolute;top:0;left:0;
		z-index:990;
}
#<?php echo $id;?> > div.notZone{
		height:1800px;
		width:100%;
		background-color:rgb(245,245,245);
		opacity:0.<?php echo $loadingOpa;?>;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=<?php echo $loadingOpa;?>);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $loadingOpa;?>)"; /*IE8*/
		position:absolute;top:100px;left:0;
		z-index:990;
}
/*赛区种类的样式*/
#<?php echo $id;?> > div.main input[type="checkbox"]{margin:0}
#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType,
#<?php echo $id;?> > div.main > div.typeArr > div.type{
	padding-left:20px;
}
#<?php echo $id?> > div.main > div.locArr > div.loc{
	padding-left:20px
}
</style>
<div id="<?php echo $id;?>">
	<input type="hidden" class="catalogId" value=""></input>
	<input type="hidden" class="catalogTitle" value=""></input>
	<div class="zloading">
		<div class="wrapLoading"><div class="loading"></div></div>
	</div>
	<div class="notZone"></div>
	<div class="main">
		<div class="line title">
			<span class="catalogTitle"></span>--赛区信息
			<div class="btn btn-small btn-success saveZone">保存</div>
			<span class="zoneSaveE"></span>
		</div>
		<div class="line">
			<input class="isZone" name="isZone" type="checkbox"></input>
			赛区
			<!--<div class="btn btn-small btn-danger addAll disabled">添加所有类别</div>
			<div class="btn btn-small btn-danger addAllLoc disabled">添加所有地点</div>-->
		</div>
		<!--<div class="line">
			<div class="btn btn-small addType btn-block disabled btn-primary">添加本赛区可提交的作品类别</div>
		</div>-->
		<div class='title'>本赛区允许选手类别:</div>
		<div class="schoolType">
			<input class="schoolType" type="checkbox" value="1"></input> 本科
			<input class="schoolType" type="checkbox" value="2"></input> 高职高专
		</div>
		<div class='title'>本赛区可提交作品类别:</div>
		<div class="arr typeArr">
			<?php $this->widget("TablrWidget",array(
					"param"=>array(
						array(
							"name" => "allType",
							"title" => "",
							"type" => "checkbox",
							"param" => array(
								array("value"=>"all","title"=>"全选"),
							)
						),
					),
				))?>
				
		<?php
			foreach($typeArr as $oneType)
			{
				//构造本类的子类arr,
				$subTypeArr = array();
				foreach($oneType['subType'] as $one)
				{
					$temp = array(
						"value" => $one['subTypeId'],
						"title" => $one['typeName'],
					);
					$subTypeArr[] = $temp;
				}
		?>
			<div class="type">
				<?php $this->widget("TablrWidget",array(
					"param"=>array(
						array(
							"name" => "workType",
							"title" => "",
							"type" => "checkbox",
							"param" => array(
								array("value"=>$oneType['typeId'],"title"=>$oneType['typeName']),
							)
						),
					),
				))?>
				<div class="subType">
					<?php $this->widget("TablrWidget",array(
						"param"=>array(
							array(
								"name" => "workSubType",
								"title" => "",
								"type" => "checkbox",
								"param" => $subTypeArr,
							),
						),
					))?>
				</div>
			</div>
		<?php
			}//foreach
		?>
		</div>
		<!--<div class="line">
			<div class="btn btn-small addLoc btn-block disabled btn-primary">添加本赛区可提交的地点</div>
		</div>-->
		<div class='title'>本赛区可提交省份:</div>
		<div class="arr locArr">
		<?php $this->widget("TablrWidget",array(
					"param"=>array(
						array(
							"name" => "allLoc",
							"title" => "",
							"type" => "checkbox",
							"param" => array(
								array("value"=>"all","title"=>"全选"),
							)
						),
					),
				))?>
		<?php
			foreach($locArr as $oneLoc)
			{
		?>
			<?php $this->widget("TablrWidget",array(
					"param"=>array(
						array(
							"name" => "loc",
							"title" => "",
							"type" => "checkbox",
							"param" => array(
								array("value"=>$oneLoc['locationId'],"title"=>$oneLoc['locationName']),
							)
						),
					),
				))?>
		<?php
			}//foreach
		?>
		</div>
	</div>
</div>
<script type="text/javascript">
/*

function makeTypeSelect()
{
	var select = $("<select></select>");
	select.attr("name","oneType");
	select.addClass("oneType");
	for(var i = 0;i<typeArr.length;++i)
	{
		var temp = $("<option></option>");
		temp.attr("title",typeArr[i].firstTypeName);
		temp.attr("value",typeArr[i].subTypeId);
		temp.html(typeArr[i].typeName);
		temp.appendTo(select);
	}
	return select;
}
function makeLocSelect()
{
	var select = $("<select></select>");
	select.attr("name","oneLoc");
	select.addClass("oneLoc");
	for(var i = 0;i<locArr.length;++i)
	{
		var temp = $("<option></option>");
		temp.attr("title",locArr[i].locationName);
		temp.attr("value",locArr[i].locationId);
		temp.html(locArr[i].locationName);
		temp.appendTo(select);
	}
	return select;
}

function makeLocBlock(locId)
{
	//有两个参数控制产生的select的初始选择，subTypeId,index;index优先
	var index = arguments[1]?arguments[1]:-1;
	var select = makeLocSelect();
	if(index == -1)
	{
		if(locId != 0)
		{
			select.find("option[value='"+locId+"']").prop("selected",true);
		}
	}
	else
	{
		select.find("option").eq(index).prop("selected",true);
	}
	var locBlock = $("<div class='locBlock'>"+
		"<div class='deleteBlock'>&times</div>"+
	"</div>");
	locBlock.append(select);
	return locBlock;
}

function makeTypeBlock(subTypeId)
{
	//有两个参数控制产生的select的初始选择，subTypeId,index;index优先
	var index = arguments[1]?arguments[1]:-1;
	var select = makeTypeSelect();
	if(index == -1)
	{
		if(subTypeId != 0)
		{
			//alert(subTypeId);
			select.find("option[value='"+subTypeId+"']").prop("selected",true);
		}
	}
	else
	{
		select.find("option").eq(index).prop("selected",true);
	}
	var typeBlock = $("<div class='typeBlock'>"+
		"<div class='deleteBlock'>&times</div>"+
	"</div>");
	typeBlock.append(select);
	return typeBlock;
}*/
/*
//定义添加作品类别动作
$(document).delegate("#<?php echo $id;?> > div.main > div.line > div.addType","click",function(){
if(!$(this).hasClass("disabled"))
{
	var typeBlock = makeTypeBlock(0);
	$("#<?php echo $id;?> > div.main > div.typeArr").append(typeBlock);
}
});
//定义添加地点动作
$(document).delegate("#<?php echo $id;?> > div.main > div.line > div.addLoc","click",function(){
if(!$(this).hasClass("disabled"))
{
	var locBlock = makeLocBlock(0);
	$("#<?php echo $id;?> > div.main > div.locArr").append(locBlock);
}
});

//添加所有类别
$(document).delegate("#<?php echo $id;?> > div.main > div.line > div.addAll","click",function(){
if(!$(this).hasClass("disabled"))
{
	$("#<?php echo $id?> > div.main > div.typeArr").html("");
	for(var i=0;i<typeArr.length;++i)
	{
		var typeBlock = makeTypeBlock(0,i);
		$("#<?php echo $id;?> > div.main > div.typeArr").append(typeBlock);
	}
}
});
//添加所有地点
$(document).delegate("#<?php echo $id;?> > div.main > div.line > div.addAllLoc","click",function(){
if(!$(this).hasClass("disabled"))
{
	$("#<?php echo $id?> > div.main > div.locArr").html("");
	for(var i=0;i<locArr.length;++i)
	{
		var locBlock = makeLocBlock(0,i);
		$("#<?php echo $id;?> > div.main > div.locArr").append(locBlock);
	}
}
});

//删除类别
$(document).delegate("#<?php echo $id;?> > div.main > div.typeArr > div.typeBlock > div.deleteBlock,#<?php echo $id;?> > div.main > div.locArr > div.locBlock > div.deleteBlock","click",function(){
	$(this).parent().remove();
});*/
//点击种类全选
$(document).delegate("#<?php echo $id;?> > div.main > div.typeArr > div.allType > div.right > div.checkBlock > input.allType","click",function(){
	//alert("a");
	if($(this).prop("checked"))
	{
		$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.workType > div.right > div.checkBlock > input.workType").prop("checked",true);
		$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType").prop("checked",true);
	}else
	{
		$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.workType > div.right > div.checkBlock > input.workType").prop("checked",false);
		$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType").prop("checked",false);		
	}
});
//点击个别类别全选 
$(document).delegate("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.workType > div.right > div.checkBlock > input.workType","click",function(){
	//alert("a");
	if($(this).prop("checked"))
	{
		$(this).parent().parent().parent().parent().find("div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType").prop("checked",true);
	}else
	{
		$(this).parent().parent().parent().parent().find("div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType").prop("checked",false);		
	}
});
//点击地点全选
$(document).delegate("#<?php echo $id;?> > div.main > div.locArr > div.allLoc > div.right > div.checkBlock > input.allLoc","click",function(){
	if($(this).prop("checked"))
	{
		$("#<?php echo $id;?> > div.main > div.locArr > div.loc > div.right > div.checkBlock > input.loc").prop("checked",true);
	}
	else
	{
		$("#<?php echo $id;?> > div.main > div.locArr > div.loc > div.right > div.checkBlock > input.loc").prop("checked",false);	
	}
});
$(document).delegate("#<?php echo $id;?> > input.catalogId","change",function(){
	//alert($(this).val());
	//alert(typeArr[1].firstTypeName);
	<?php echo $id?>showLoading();
	//清空
	//$("#<?php echo $id?> > div.main > div.typeArr").html("");
	//$("#<?php echo $id?> > div.main > div.locArr").html("");
	$("#<?php echo $id?> > div.main > div.line > input.isZone").prop("checked",false);
	$("#<?php echo $id?> > div.main > div.title > span.catalogTitle").html($("#<?php echo $id?> > input.catalogTitle").val());
	emptyCheck();
	var data = {};
	data.catalogId = $(this).val();
	//获取节点的赛区信息
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/catalog/getZoneInfo",data,function(result){
		//alert(result);
		<?php echo $id?>hideLoading();
		if(result.hasWork == 1)
		{
			$("#<?php echo $id?> > div.main > div.line > input.isZone").prop("checked",true);
			showAddTypeButton();
			$.each(result.workSubTypeArr,function(index,item){
				$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType[value='"+item.subTypeId+"']").prop("checked",true);
			});
			$.each(result.workLocArr,function(index,item){
				$("#<?php echo $id;?> > div.main > div.locArr > div.loc > div.right > div.checkBlock > input.loc[value='"+item.locationId+"']").prop("checked",true);
			});
			
			//设置可提交选手类别 
			//alert(result['zoneSchoolType']);
			setSchoolType(result.zoneSchoolType);
		}
		else
		{
			$("#<?php echo $id?> > div.main > div.line > input.isZone").prop("checked",false);
			hideAddTypeButton();
		}
	},'json');
});
function setSchoolType(n)
{
	//alert(n);
	$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",true);
	//根据n设置本赛区允许选手类别,0全空，1,本科,2,高职，3两个
	if(n == 1)
	{
		$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",false);
		$("#<?php echo $id;?> > div.main > div.schoolType > input[value='1']").prop("checked",true);
	}
	else if(n ==2)
	{
		$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",false);
		$("#<?php echo $id;?> > div.main > div.schoolType > input[value='2']").prop("checked",true);
	}
	else if (n == 3)
	{
		$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",true);
	}
	else
	{
		$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",false);
	}
	
	
}
//点击“赛区”
$(document).delegate("#<?php echo $id?> > div.main > div.line > input.isZone","click",function(){
	if($(this).prop("checked"))
	{
		//赛区
		showAddTypeButton();
	}
	else
	{
		//取消赛区
		hideAddTypeButton();
		emptyCheck();
	}
});
//保存动作
$(document).delegate("#<?php echo $id?> > div.main > div.title > div.saveZone","click",function(){
	//选择为赛区时检查是否选中任何种类跟地点
	if($("#<?php echo $id?> > div.main > div.line > input.isZone").prop("checked") &&
	(($("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType:checked").length == 0) ||
	($("#<?php echo $id;?> > div.main > div.locArr > div.loc > div.right > div.checkBlock > input.loc:checked").length == 0)
		||
	($("#<?php echo $id;?> > div.main > div.schoolType > input:checked").length == 0)
	) 
	)
	{
		showZoneSaveE("必须选择种类与地点，以及允许选手类型!");
		return;
	}
	var data = {};
	data.catalogId = $("#<?php echo $id;?> > input.catalogId").val();
	data.isZone = $("#<?php echo $id?> > div.main > div.line > input.isZone").prop("checked")?1:0;
	if($("#<?php echo $id;?> > div.main > div.schoolType > input[value='1']").prop("checked"))
	{
		if($("#<?php echo $id;?> > div.main > div.schoolType > input[value='2']").prop("checked"))
		{
			data.zoneSchoolType = 3;
		}
		else
		{
			data.zoneSchoolType = 1;
		}
	}
	else if($("#<?php echo $id;?> > div.main > div.schoolType > input[value='2']").prop("checked"))
	{
		data.zoneSchoolType = 2;
	}
	else
	{
		data.zoneSchoolType = 0;
	}
	data.zoneTypeArr = new Array();
	$("#<?php echo $id;?> > div.main > div.typeArr > div.type > div.subType > div.workSubType > div.right > div.checkBlock > input.workSubType:checked").each(function(){
		data.zoneTypeArr.push($(this).val());
	});
	data.zoneLocArr = new Array();
	$("#<?php echo $id;?> > div.main > div.locArr > div.loc > div.right > div.checkBlock > input.loc:checked").each(function(){
		data.zoneLocArr.push($(this).val());
	});
	<?php echo $id;?>showLoading();
	showZoneSaveE("保存中...");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/catalog/changeZoneInfo",data,function(result){
		//alert(result);
		<?php echo $id;?>hideLoading();
		showZoneSaveE("保存成功!");		
	});
});
function emptyCheck()
{
	//alert("a");
	var $typeCheck = $("#<?php echo $id;?> > div.main > div.typeArr > div.allType > div.right > div.checkBlock > input.allType");
	var $locCheck = $("#<?php echo $id;?> > div.main > div.locArr > div.allLoc > div.right > div.checkBlock > input.allLoc");
	if($typeCheck.prop("checked"))
	{
		$typeCheck.click();
	}else
	{
		$typeCheck.click();
	}
	$typeCheck.prop("checked",false);
	if($locCheck.prop("checked"))
	{
		$locCheck.click();
	}else
	{
		$locCheck.click();
	}
	$locCheck.prop("checked",false);
	$("#<?php echo $id;?> > div.main > div.schoolType > input").prop("checked",false);
}
function showAddTypeButton()
{
	$("#<?php echo $id;?> > div.notZone").hide();
}
function hideAddTypeButton()
{
	$("#<?php echo $id;?> > div.notZone").show();	
}
function showZoneSaveE(str)
{
	$("#<?php echo $id;?> > div.main > div.title > span.zoneSaveE").html(str);
	setTimeout(function(){
		$("#<?php echo $id;?> > div.main > div.title > span.zoneSaveE").html("");
	},3000);
}
function <?php echo $id?>showLoading()
{
	$("#<?php echo $id?> > div.zloading").show();
}
function <?php echo $id?>hideLoading()
{
	$("#<?php echo $id?> > div.zloading").hide();
}
</script>