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
<script loc="text/javascript">
$(document).ready(function(){
	<?php echo $id;?>makeList();
	$("#<?php echo $id;?> > div.main > div.block").eq(0).click();
});
//绑定关键方法
//点击其中的一项
$(document).delegate("#<?php echo $id?> > div.main > div.block","click",function(){
	var locationId = $(this).children("input.locationId").val();
	$("<?php echo $targetSelector;?>").val(locationId);
	<?php if($targetLocationName != ""){ ?>
		var locationName = $(this).children("input.locationName").val();
		$("<?php echo $targetSelector;?>").val(locationName);
	<?php } ?>
	$("<?php echo $targetSelector;?>").change();
	//点击后toggle
	<?php if($showToggle){ ?>
		//删除所有的toggle class
		$("#<?php echo $id;?> > div.main > div.block").removeClass("toggle");
		$(this).addClass("toggle");
	<?php } ?>
});
var <?php echo $id;?>locArr = <?php echo Text::json_encode_ch($locArr,JSON_UNESCAPED_UNICODE);?>;
function <?php echo $id;?>makeLocBlock(locObject)
{
	return $('<div class="block">'+
		'<input class="locationId" type="hidden" value='+locObject.locationId+'></input>'+
		'<input class="locationName" type="hidden" value='+locObject.locationName+'></input>'+
		'<div class="line">'+locObject.locationName+'</div>'+
	'</div>');
}
function <?php echo $id;?>makeList()
{
	//添加"全部"选项
	<?php if($hasAll){ ?>
		var tempObject = {"locationId":"all","locationName":"全部"};
		$("#<?php echo $id;?> > div.main").append(<?php echo $id;?>makeLocBlock(tempObject));
	<?php } ?>
	for(var i= 0;i<<?php echo $id;?>locArr.length;++i)
	{
		$("#<?php echo $id;?> > div.main").append(<?php echo $id;?>makeLocBlock(<?php echo $id;?>locArr[i]));
	}
}

</script>