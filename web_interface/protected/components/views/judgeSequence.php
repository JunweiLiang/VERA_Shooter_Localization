<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id?>{
		padding:10px;
		width:400px;
	}
	#<?php echo $id?> > div.addBlock{
		margin-top:20px;
		background-color:silver;
		padding:20px;
		cursor:pointer;
		text-align:center;
	}
	#<?php echo $id?> > div.blockList > div.block{
		background-color:rgb(230,230,230);
		padding:10px;
		margin:10px 0;
		position:relative;		
	}
	#<?php echo $id?> > div.blockList > div.block > div.deleteBlock{
		position:absolute;
		top:3px;
		right:3px;
		width:15px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.blockList > div.block > div.line{
		padding:5px 0;
	}
</style>
<div id="<?php echo $id?>">
	<div class="wrapLoading"><div class="loading"></div></div>
	<div class="blockList"></div>
	<div class="addBlock" title="添加流程点"><i class="icon-plus"></i></div>
</div>
<script type="text/javascript">
var strategyArr = <?php echo Text::json_encode_ch($strategyArr,JSON_UNESCAPED_UNICODE);?>;
$(document).ready(function(){
	//进入页面获取流程信息
	getEP();
});
//点击添加一个block
$(document).delegate("#<?php echo $id?> > div.addBlock","click",function(){
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/add","",function(result){
		//alert(result);
		//addBlock(result.strategyId,result.blockId,result.distributeArr);
		//更新所有的result distribute的select
		getEP();
	},'json');
});
//点击删除一个block，然后重新获取
$(document).delegate("#<?php echo $id?> > div.blockList > div.block > div.deleteBlock","click",function(){
if(!confirm("确认删除此流程吗？在评审开始后不要修改!"))
{
	return;
}
	var data = {};
	data.blockId = $(this).parent().children("input.blockId").val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/delete",data,function(result){
		getEP();	
	});
});
//改变输出
$(document).delegate("#<?php echo $id?> > div.blockList > div.block > div.resultSelect > select.distribute","change",function(){
	//alert("hi");
	var data = {};
	data.method = "changeToBlockId";
	data.blockId = $(this).parent().parent().children("input.blockId").val();
	data.toBlockId = $(this).children("option:selected").val();
	data.resultNum = $(this).prop("resultNum");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/change",data/*,function(result){
		//alert(result);
	}*/);
});
//改变策略 
$(document).delegate("#<?php echo $id?> > div.blockList > div.block > div.strategySelect > select.strategy","change",function(){
	var data = {};
	data.method = "changeStrategyId";
	data.blockId = $(this).parent().parent().children("input.blockId").val();
	data.strategyId = $(this).children("option:selected").val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/change",data,function(result){
	//	alert(result);
		getEP();
	});
});



function addBlock(strategyId,blockId,distributeArr)
{
	var temp = $('<div class="block">'+
		'<div class="deleteBlock" title="删除此block">&times;</div>'+
		'<input class="blockId" type="hidden" value="'+blockId+'"></input>'+		
	'</div>');
	var strategy = parseStrategy(strategyId);
	temp.append('<div class="line">序号: '+blockId+'</div>')
		.append($('<div class="line strategySelect">策略选择: </div>').append(makeStrategySelect(strategyId)))
		.append($('<div class="line strategyIntro">'+strategy.strategyIntro+'</div>'));
	if(distributeArr.length > 0)
	{
		var tempSelect = $('<div class="line resultSelect">输出选择:<br/> </div>');
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
	var select = $("<select class='distribute'></select>");
	select.prop("resultNum",distribute.resultNum);
	for(var i = 0;i<distribute.toBlockArr.length;++i)
	{
		select.append($("<option value='"+distribute.toBlockArr[i]+"'>"+distribute.toBlockArr[i]+"</option>"));
	}
	select.append($("<option selected='selected' value='"+distribute.toBlockId+"'>"+distribute.toBlockId+"</option>"));
	return select;
}
function makeStrategySelect(strategyId)
{
	var $res = $("<select class='strategy'></select>");
	for(var i=0;i<strategyArr.length;++i)
	{
		$res.append("<option value='"+strategyArr[i].strategyId+"' title='"+strategyArr[i].strategyIntro+"'>"+
			strategyArr[i].strategyTitle+"</option>");
	}

	$res.find("option[value='"+strategyId+"']").prop("selected",true);
	return $res;
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
function getEP()
{
	<?php echo $id?>showLoading();
	$("#<?php echo $id;?> > div.blockList").html("");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeSequence/get","",function(result){
		$.each(result,function(index,item){
			addBlock(item.strategyId,item.blockId,item.distributeArr);
		});
		<?php echo $id?>hideLoading();
	},'json');
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