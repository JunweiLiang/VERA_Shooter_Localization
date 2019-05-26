<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id?> > div.main > div.block{
		cursor:pointer;
		padding:10px;
		border-bottom:1px silver solid;
		background-color:rgb(245,245,245);
		position:relative;
	}
	#<?php echo $id?> > div.main > div.block:hover{
		background-color:rgb(240,240,240);
	}
	#<?php echo $id?> > div.main > div.block.toggle{
		color:white;
		background-color:#0088cc;
	}
	#<?php echo $id?> > div.main > div.block > div.delete{
		width:10px;
		position:absolute;
		top:5px;
		right:5px;
		cursor:pointer;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	//getGroupList();
});
$(document).delegate("#<?php echo $id?> > input.catalogId","change",function(){
	getGroupList();
});
//点击block
$(document).delegate("#<?php echo $id?> > div.main > div.block","click",function(){
	//toggle
	<?php if($toggle){ ?>
		$("#<?php echo $id?> > div.main > div.block").removeClass("toggle");
		$(this).addClass("toggle");
	<?php } ?>
	var groupId = $(this).children("input.groupId").val();
	var groupName = $(this).children("input.groupName").val();
	<?php if(is_array($targetSelector)){ 
		foreach($targetSelector as $one)
		{
	?>
	$("<?php echo $one['groupName']?>").val(groupName);
	$("<?php echo $one['groupId']?>").val(groupId);
	$("<?php echo $one['groupId']?>").change();
	<?php  } } ?>
});
function getGroupList()
{
	var data = {};
	data.blockId = $("#<?php echo $id?> > input.blockId").val();
	data.catalogId = $("#<?php echo $id?> > input.catalogId").val();
	$("#<?php echo $id?> > div.main").html("<div class='wrapLoading'><div class='loading'></div></div>");
	//清空
	<?php echo $id?>reset();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/getGroupList?blockId="+data.blockId,data,function(result){
		//alert(result);
		$("#<?php echo $id?> > div.main").html("");
		$.each(result,function(index,item){
			$("#<?php echo $id?> > div.main").append(<?php echo $id?>makeGroupBlock(item));
		});
	},'json');
}
function <?php echo $id?>makeGroupBlock(item)
{
	return $('<div class="block">'+
		'<div class="delete" title="删除此分组">&times;</div>'+
		'<input class="groupId" type="hidden" value="'+item.groupId+'"></input>'+
		'<input class="groupName" type="hidden" value="'+item.groupName+'"></input>'+
		item.groupName+
	'</div>');
}
//删除一个分组
$(document).delegate("#<?php echo $id?> > div.main > div.block > div.delete","click",function(e){
	e.preventDefault();
	e.stopPropagation();
	var groupId = $(this).parent().children("input.groupId").val();
	var groupName = $(this).parent().children("input.groupName").val();
	if(!confirm("确认删除分组 "+groupName+"?评审开始后就不能删除了!"))
	{
		return;
	}else
	{
		var data = {};
		data.groupId = groupId;
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/deleteGroup?blockId=<?php echo $blockId?>",data,function(result){
			//alert(result);
			//重新调用change事件，使用一个空的groupId
			getGroupList();
			<?php echo $id?>reset();
		});
	}
});
function <?php echo $id?>reset()
{
	<?php if(is_array($targetSelector)){ 
		foreach($targetSelector as $one)
		{
	?>
	$("<?php echo $one['groupName']?>").val("");
	$("<?php echo $one['groupId']?>").val("");
	$("<?php echo $one['groupId']?>").change();
	<?php  } } ?>
}
</script>
<div id="<?php echo $id?>">
	<input class="blockId" type="hidden" value="<?php echo $blockId;?>"></input>
	<input class="catalogId" type="hidden" value="all"></input>
	<div class="main"></div>
</div>