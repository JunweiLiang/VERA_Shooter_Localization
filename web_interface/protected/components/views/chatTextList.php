<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<script type="text/javascript">
<?php if($instantLoad){ ?>
	$(document).ready(function(){
		getCheckTextList();
	});
<?php } ?>
//点击了chat Block
$(document).delegate("#<?php echo $id;?> > div.main > div.block","click",function(){
	var chatTextId = $(this).children("input.chatTextId").val();
	var userId = $(this).children("input.fromUserId").val();
	var userName = $(this).children("input.fromUserName").val();
	<?php
		foreach($target as $one){
	?>
		<?php if(isset($one['userName'])){ ?>
			$("<?php echo $one['userName']?>").val(userName);
		<?php } ?>
		<?php if(isset($one['chatTextId'])){ ?>
			$("<?php echo $one['chatTextId']?>").val(chatTextId);
		<?php } ?>
		<?php if(isset($one['userId'])){ ?>
			$("<?php echo $one['userId']?>").val(userId);
			$("<?php echo $one['userId']?>").change();
		<?php } ?>
	<?php } ?>
});
//点击查看更多
$(document).delegate("#<?php echo $id;?> > div.more > div.more","click",function(){
	getCheckTextList();
});
var <?php echo $id?>startNum = 0;
var <?php echo $id?>feedNum = 10;
function getCheckTextList()
{
	var data = {};
	data.startNum = <?php echo $id?>startNum;
	data.feedNum = <?php echo $id?>feedNum;
	//隐藏显示更多
	<?php echo $id?>hideMore();
	//显示载入中
	<?php echo $id?>showLoading();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chat/getList",data,function(result){
		<?php echo $id?>hideLoading();
		//alert(result);	
		<?php echo $id?>startNum += result.length;
		if(result.length >= <?php echo $id?>feedNum)
		{
			<?php echo $id?>showMore();
		}
		$.each(result,function(index,item){
			$("#<?php echo $id;?> > div.main").append('<div class="block">'+
					'<input class="chatTextId" type="hidden" value="'+item.chatTextId+'"></input>'+
					'<input class="fromUserId" type="hidden" value="'+item.userId+'"></input>'+
					'<input class="fromUserName" type="hidden" value="'+item.userName+'"></input>'+
					'<div class="line">'+item.userName+' : '+item.text+'</div>'+
					'<div class="line time">'+item.createTime+'</div>'+
			'</div>');
		});
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
function <?php echo $id?>showMore()
{
	$("#<?php echo $id?> > div.more").show();
}
function <?php echo $id?>hideMore()
{
	$("#<?php echo $id?> > div.more").hide();
}
</script>
<div id="<?php echo $id?>">
	<div class="main"></div>
	<div class="more" style="display:none"><div class="btn btn-block btn-small btn-info more">更多</div></div>
	<div class="wrapLoading"><div class="loading"></div></div>
</div>