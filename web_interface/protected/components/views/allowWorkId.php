<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id?>{
		
	}
	#<?php echo $id?> > div.main > div.workIdList {
		<?php if($overflowHeight != ""){ ?>
			height:<?php echo $overflowHeight?>;
			overflow:auto;
		<?php } ?>
	}
	#<?php echo $id?> > div.main > div.workIdList > div.block{
		position:relative;
		padding:5px;
		background-color:rgb(245,245,245);
		border-bottom:1px silver solid;
	}	
	#<?php echo $id?> > div.main > div.workIdList > div.block > div.delete{
		position:absolute;
		top:2px;
		right:4px;
		width:10px;
		cursor:pointer;
	}
</style>
<div id="<?php echo $id?>">
	<input class="catalogId" value="<?php echo $initialCataId?>" type="hidden"></input>
	<div class="main">
	
		<?php if($canEdit){ ?>
		<div class="ctr">
			<textarea class="workIdArr" style="width:90%"></textarea>
			<div class="btn btn-small btn-block btn-primary add">添加</div>
		</div>
		<?php } ?>
		
		<div class="workIdList">
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	<?php echo $id?>getWorkIdArr();
});
$(document).delegate("#<?php echo $id?> > input.catalogId","change",function(){
	<?php echo $id?>getWorkIdArr();
});
function <?php echo $id?>getWorkIdArr()
{
	var data  ={};
	data.catalogId = $("#<?php echo $id?> > input.catalogId").val();
	if(data.catalogId == "")
	{
		return;
	}
	$("#<?php echo $id?> > div.main > div.workIdList").html('<div class="wrapLoading"><div class="loading"></div></div>');
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/getAllowWorkId",data,function(result){
	//		alert(result);
	$("#<?php echo $id?> > div.main > div.workIdList").html("");
		for(var i=0;i<result.length;++i)
		{
			$("#<?php echo $id?> > div.main > div.workIdList").append(<?php echo $id?>makeBlock(result[i]));
		}
	},'json');
}
function <?php echo $id?>makeBlock(workId)
{
	return $('<div class="block">'+
	<?php if($canEdit){ ?>
		'<div class="delete">&times;</div>'+
	<?php } ?>
		'<input class="workId" type="hidden" value="'+workId+'"></input>'+
		'<div class="line">'+workId+'</div>'+
	'</div>');
}
<?php if($canEdit){ ?>
//点击添加
$(document).delegate("#<?php echo $id?> > div.main > div.ctr > div.add","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var workIdStr = $("#<?php echo $id?> > div.main > div.ctr > textarea.workIdArr").val();
		if($.trim(workIdStr) == "")
		{
			return;
		}
	}
	<?php echo $id?>addWorkId(workIdStr);
});	
//点击删除
$(document).delegate("#<?php echo $id?> > div.main > div.workIdList > div.block > div.delete","click",function(){
	var data = {};
	data.workId = $(this).parent().children("input.workId").val();
	if(!confirm("确认移除"+data.workId+"?"))
	{
		return;
	}
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/deleteAllowWorkId",data,function(result){
		alert("ok");
		<?php echo $id?>getWorkIdArr();
	});
});
function <?php echo $id?>addWorkId(workIdStr)
{
	//alert(workIdStr);
	var data = {};
	data.workIdStr = workIdStr;
	$("#<?php echo $id?> > div.main > div.ctr > div.add").addClass("disabled");
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/addAllowWorkId",data,function(result){
		//alert(result);
		var goodStr = "";
		for(var i=0;i<result.length;++i)
		{
			goodStr+=result[i]+" \n"
		}
		$("#<?php echo $id?> > div.main > div.ctr > div.add").removeClass("disabled");
		<?php echo $id?>getWorkIdArr();
		alert("成功添加了"+result.length+"个作品,\n"+goodStr);
	},'json');
}
<?php } ?>
</script>