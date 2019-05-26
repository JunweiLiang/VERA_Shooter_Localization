<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/

?>
<style type="text/css">
	#<?php echo $id?>{
		padding:10px;
		width:500px;
	}
	#<?php echo $id?> > div.blockList > div.block{
		background-color:rgb(230,230,230);
		padding:10px;
		margin:10px 0;
		position:relative;		
		height:auto!important;
		height:200px;
		min-height:200px;
	}
	#<?php echo $id?> > div.blockList > div.block > div.ctr{
		position:absolute;
		top:0px;right:0;
		width:150px;
		padding:10px 0;
	}
	#<?php echo $id?> > div.blockList > div.block > div.line{
		padding:5px 0;
		width:330px;
	}
	#<?php echo $id?> > div.blockList > div.block > div.ctr > div.title{
		font-size:15px;
		font-weight:bold;
		margin-bottom:10px;
		text-align:center;
	}
	#<?php echo $id?> > div.blockList > div.block > div.ctr > div.line{
		padding:10px;
	}
</style>
<div id="<?php echo $id?>">
	<div class="wrapLoading"><div class="loading"></div></div>
	<div class="blockList"></div>
</div>
<script type="text/javascript">
var strategyArr = <?php echo Text::json_encode_ch($strategyArr,JSON_UNESCAPED_UNICODE);?>;
$(document).ready(function(){
	//进入页面获取流程信息
	getEP();
});
function getEP()
{
	<?php echo $id?>showLoading();
	$("#<?php echo $id;?> > div.blockList").html("");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/get","",function(result){
		$.each(result,function(index,item){
			addBlock(item.strategyId,item.blockId,item.distributeArr,item);
		});
		<?php echo $id?>hideLoading();
	},'json');
}

//点击跳过
$(document).delegate("#<?php echo $id;?> > div.blockList > div.block > div.ctr > div.line > div.skip","click",function(){
	$(this).removeClass("btn-primary")
		.removeClass("skip")
		.addClass("w") //用于标记
		.html("...");
	var data = {};
	data.method = "skip";
	data.blockId = $(this).parent().parent().parent().children("input.blockId").val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeStage/skip",data,function(result){
		//alert(result);
		var blockId = result;
		$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
		.parent().find("div.ctr > div.line > div.w").removeClass("w")
			.addClass("btn-danger")
			.addClass("unskip")
			.html("取消跳过");
	});
});
//取消跳过
$(document).delegate("#<?php echo $id;?> > div.blockList > div.block > div.ctr > div.line > div.unskip","click",function(){
	$(this).removeClass("btn-danger")
		.removeClass("unskip")
		.addClass("ww") //用于标记
		.html("...");
	var data = {};
	data.method = "unskip";
	data.blockId = $(this).parent().parent().parent().children("input.blockId").val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeStage/skip",data,function(result){
		//alert(result);
		var blockId = result;
		$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
		.parent().find("div.ctr > div.line > div.ww").removeClass("ww")
			.addClass("btn-primary")
			.addClass("skip")
			.html("跳过");
	});
});

//开始、停止(管理、评审)
$(document).delegate("#<?php echo $id;?> > div.blockList > div.block > div.ctr > div.line > div.start","click",function(){
	var data = {};
	data.blockId = $(this).parent().parent().parent().children("input.blockId").val();
	if($(this).hasClass("startJM"))
	{
		data.method = "startJM";
		$(this).removeClass("btn-success")
			.removeClass("startJM")
			.addClass("s") //用于标记
			.html("...");
	}
	else if($(this).hasClass("startJ"))
	{
		data.method = "startJ";
		$(this).removeClass("btn-success")
			.removeClass("startJ")
			.addClass("s") //用于标记
			.html("...");
	}
	else if($(this).hasClass("stopJM"))
	{
		data.method = "stopJM";
		$(this).removeClass("btn-danger")
			.removeClass("stopJM")
			.addClass("s") //用于标记
			.html("...");
	}
	else if($(this).hasClass("stopJ"))
	{
		data.method = "stopJ";
		$(this).removeClass("btn-danger")
			.removeClass("stopJM")
			.addClass("s") //用于标记
			.html("...");
	}

	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeStage/ctr",data,function(result){
		//alert(result);
		var blockId = result.blockId;
		var method = result.method;
		if(method == "startJM")
		{
			$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
				.parent().find("div.ctr > div.line > div.s").removeClass("s")
				.addClass("btn-danger")
				.addClass("stopJM")
				.html("停止管理");
		}
		else if(method == "startJ")
		{
			$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
				.parent().find("div.ctr > div.line > div.s").removeClass("s")
				.addClass("btn-danger")
				.addClass("stopJ")
				.html("停止评审");
		}
		else if(method == "stopJM")
		{
			$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
				.parent().find("div.ctr > div.line > div.s").removeClass("s")
				.addClass("btn-success")
				.addClass("startJM")
				.html("开始管理");
		}
		else if(method == "stopJ")
		{
			$("#<?php echo $id?> > div.blockList > div.block > input[value='"+blockId+"']")
				.parent().find("div.ctr > div.line > div.s").removeClass("s")
				.addClass("btn-success")
				.addClass("startJ")
				.html("开始评审");
		}
	},'json');
});


function addBlock(strategyId,blockId,distributeArr,blockStatus)
{
	//blockStatus.isSkipped,hasStartJM,hasStartJ
	
	var temp = $('<div class="block">'+
		'<input class="blockId" type="hidden" value="'+blockId+'"></input>'+
		'<div class="ctr">'+
			'<div class="title">控制</div>'+
			'<div class="line"><div class="btn btn-block btn-small '+((blockStatus.isSkipped == 1)?'unskip btn-danger':'skip btn-primary')+'">'+((blockStatus.isSkipped == 1)?'取消跳过':'跳过')+'</div></div>'+
			'<div class="line"><div class="btn btn-block btn-small start '+((blockStatus.hasStartJM == 1)?'stopJM btn-danger':'startJM btn-success')+'">'+((blockStatus.hasStartJM == 1)?'停止管理':'开始管理')+'</div></div>'+
			'<div class="line"><div class="btn btn-block btn-small start '+((blockStatus.hasStartJ == 1)?'stopJ btn-danger':'startJ btn-success')+'">'+((blockStatus.hasStartJ == 1)?'停止评审':'开始评审')+'</div></div>'+
		'</div>'+
	'</div>');
	var strategy = parseStrategy(strategyId);
	temp.append('<div class="line">序号: '+blockId+'</div>')
		.append($('<div class="line strategySelect">策略名: </div>').append(makeStrategySelect(strategyId)))
		.append($('<div class="line strategyIntro">'+strategy.strategyIntro+'</div>'));
	if(distributeArr.length > 0)
	{
		var tempSelect = $('<div class="line resultSelect">输出:<br/> </div>');
		$.each(distributeArr,function(index,item){
			tempSelect.append(makeResultSelect(strategyId,item))
				.append(" <span class='resultIntro'>"+getResultIntro(strategyId,item.resultNum)+"</span><br />");
		});
		temp.append(tempSelect);
	}
		
	temp.appendTo("#<?php echo $id;?> > div.blockList");
}
function makeResultSelect(strategyId,distribute)
{
	return distribute.toBlockId+"号 ";
}
function makeStrategySelect(strategyId)
{
	return parseStrategy(strategyId).strategyTitle;
}
function getResultIntro(strategyId,resultNum)
{
	return parseResult(parseStrategy(strategyId),resultNum).resultIntro;
}
function parseResult(strategy,resultNum)
{
	//从strategy对象中返回对应resultNum的result对象
	for(var i=0;i<strategy.resultCluster.length;++i)
	{
		if(strategy.resultCluster[i].resultNum == resultNum)
		{
			return strategy.resultCluster[i];
		}
	}
	return null;
}
function parseStrategy(strategyId)
{
	//从strategyArr中返回strategyId的对象
	for(var i=0;i<strategyArr.length;++i)
	{
		if(strategyArr[i].strategyId == strategyId)
		{
			return strategyArr[i];
		}
	}
	return null;
}

function <?php echo $id?>showLoading()
{
	$("#<?php echo $id?> > div.wrapLoading").show();
}
function <?php echo $id?>hideLoading()
{
	$("#<?php echo $id?> > div.wrapLoading").hide();
}
</script>