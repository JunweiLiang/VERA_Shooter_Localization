<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>;padding:5px 0;}
	#<?php echo $id;?> > div.boardTitle{font-size:13px;color:gray;}
	#<?php echo $id;?> > div.board{background-color:rgb(250,250,250);font-size:14px;color:black;padding:5px}
	#<?php echo $id;?> > div.board > textarea{width:<?php echo ($width-10).'px';?>;padding:0px}
</style>
<script type='text/javascript'>
	$(document).ready(function(){
		getBroadcast();
	});
function getBroadcast()
{
	var data = {};
	$("#<?php echo $id;?> > div.board").html("<div class='wrapLoading'><div class='loading'></div></div>");
	$("#<?php echo $id;?> > div.board").removeClass('hasTA');
	$.post("<?php echo $getUrl;?>",data,function(result){
		//把result所有换行换成空格
		var reg = /[\r]?\n/g;
		if(result.content != null)
		{
			result.content = result.content.replace(reg,'');
		}
		//alert(result.content);
		if((result.content == null) || (result.content == '') || (result.content == '\n') || (result.content == '\r\n'))
		{
			$("#<?php echo $id;?> > div.board").html("暂时没有通知");
			$("#<?php echo $id;?> > div.board").removeClass('yes');
		}
		else
		{
			$("#<?php echo $id;?> > div.board").addClass('yes');
			$("#<?php echo $id;?> > div.board").html(result.content);
			$("#<?php echo $id;?> > div.board").attr('title',result.time);
		}
	},'json');
}
	<?php if($canChange){ ?>
	//点击通知区域就变成输入框
	$(document).delegate("#<?php echo $id;?> > div.board","click",function(){
		if(!$(this).hasClass('hasTA'))
		{
			var tempTextarea = $("<textarea rows='3'></textarea>");
			if($(this).hasClass('yes'))
			{
				tempTextarea.val($(this).html());
				tempTextarea.html($(this).html());
			}
			$("#<?php echo $id;?> > div.board").html("");
			tempTextarea.appendTo("#<?php echo $id;?> > div.board");
			tempTextarea.focus();
			$(this).addClass('hasTA');
		}
	});
	$(document).delegate("#<?php echo $id;?> > div.board > textarea","blur",function(){
		//提交修改
		//alert('blur fires!');
		//return;
		var data = {};
		var reg = /[\r]?\n/g;
		data.content = $(this).val().replace(reg,'');
		//data.content = $(this).val();
		$.post("<?php echo $changeUrl;?>",data,function(result){
			//alert(result);
			if(result == 'error')
			{
				alert('Oops');
				return;
			}
			getBroadcast();
		});
	});
	<?php } ?>
	
</script>
<div id='<?php echo $id;?>'>
	<div class='boardTitle'><?php echo $boardTitle;?></div>
	<div class='board'></div>
</div>