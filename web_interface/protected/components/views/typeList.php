<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id;?> > div.main{

}
#<?php echo $id;?> > div.main > div.block{
	padding:5px;
	font-size:14px;
	cursor:pointer;
	color:<?php echo $colorBefore;?>;
}
#<?php echo $id;?> > div.main > div.type{
	padding:3px;
	color:gray;
}
#<?php echo $id;?> > div.main > div.block:hover{
	color:<?php echo $colorHover;?>;
	background-color:rgb(245,245,245);
}
#<?php echo $id;?> > div.main > div.block.toggle{
	color:<?php echo $colorAfter;?>;
	background-color:<?php echo $colorBefore?>;
}
</style>
<div id="<?php echo $id;?>">
	<div class="main">
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	<?php echo $id;?>makeList();
	<?php if($instantChange){ ?>
	$("#<?php echo $id;?> > div.main > div.block").eq(0).click();
	<?php } ?>
});
//绑定关键方法
//点击其中的一项
$(document).delegate("#<?php echo $id?> > div.main > div.block","click",function(){
	var subTypeId = $(this).children("input.subTypeId").val();
	
	<?php if($targetTypeName != ""){ ?>
		var subTypeName = $(this).children("input.subTypeName").val();
		$("<?php echo $targetTypeName;?>").val(subTypeName);
	<?php } ?>
	<?php if($targetFirstTypeName != ""){ ?>
		var firstTypeName = $(this).children("input.typeName").val();
		$("<?php echo $targetFirstTypeName;?>").val(firstTypeName);
	<?php } ?>
	<?php if(is_array($targetSelector)){ ?>
		<?php foreach($targetSelector as $one){ ?>
			$("<?php echo $one;?>").val(subTypeId);
			$("<?php echo $one;?>").change();
		<?php } ?>
	<?php }else{ ?>
		$("<?php echo $targetSelector;?>").val(subTypeId);
			$("<?php echo $targetSelector;?>").change();
	<?php } ?>

	//点击后toggle
	<?php if($showToggle){ ?>
		//删除所有的toggle class
		$("#<?php echo $id;?> > div.main > div.block").removeClass("toggle");
		$(this).addClass("toggle");
	<?php } ?>
});
var <?php echo $id;?>typeArr = <?php echo Text::json_encode_ch($typeArr,JSON_UNESCAPED_UNICODE);?>;
function <?php echo $id;?>makeTypeBlock(typeObject)<?php /*包括"subTypeId":"1","typeName":"","createTime":"","typeId":"1","notice":"","firstTypeName":*/ ?>
{
	if(typeObject.isType == null)
	{
		return $('<div class="block">'+
			'<input class="subTypeId" type="hidden" value='+typeObject.subTypeId+'></input>'+
			'<input class="subTypeName" type="hidden" value='+typeObject.typeName+'></input>'+
			'<input class="typeName" type="hidden" value='+typeObject.firstTypeName+'></input>'+
			'<div class="line" title="'+typeObject.firstTypeName+'">'+typeObject.typeName+'</div>'+
		'</div>');
	}else <?php  /*显示大类*/?>
	{
		return $('<div class="type">'+
			'<input class="typeId" type="hidden" value='+typeObject.typeId+'></input>'+
			typeObject.typeName+
		'</div>');
	}
}
function <?php echo $id;?>makeList()
{
	//添加"全部"选项
	<?php if($hasAll){ ?>
		var tempObject = {"subTypeId":"all","typeName":"全部"};
		$("#<?php echo $id;?> > div.main").append(<?php echo $id;?>makeTypeBlock(tempObject));
	<?php } ?>
	for(var i= 0;i<<?php echo $id;?>typeArr.length;++i)
	{
		$("#<?php echo $id;?> > div.main").append(<?php echo $id;?>makeTypeBlock(<?php echo $id;?>typeArr[i]));
	}
}

</script>