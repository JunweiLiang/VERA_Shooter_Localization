<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<script type="text/javascript">
	//当userId的change发生，获取聊天信息
	$(document).delegate("#<?php echo $id?> > input.userId","change",function(){
		$("#<?php echo $id?> > div.say > textarea.chatText").val("").html("");
		<?php echo $id;?>getChatTextList();
	});
	//点击refresh
	$(document).delegate("#<?php echo $id?> > div.refresh > div.refresh","click",function(){
		<?php echo $id;?>getChatTextList();
	});
	//点击回复
	$(document).delegate("#<?php echo $id?> > div.say > div.send","click",function(){
		var data = {};
		data.toUserId = $("#<?php echo $id?> > input.userId").val();
		data.say = $("#<?php echo $id?> > div.say > textarea.chatText").val();
		if(data.say != "")
		{
			$.post("<?php echo Yii::app()->baseUrl?>/index.php/chat/say",data,function(result){
				//alert(result);
				//清空text
				$("#<?php echo $id?> > div.say > textarea.chatText").val('').html('');
				<?php echo $id?>getChatTextList();
			});
		}
	});
	function <?php echo $id?>getChatTextList()
	{
		var userId = $("#<?php echo $id?> > input.userId").val();
		if(userId != "")
		{
			$("#<?php echo $id?> > div.chatMain").html("<div class='wrapLoading'><div class='loading'></div></div>");		
			var data = {};
			data.userId = userId;
			$.post("<?php echo Yii::app()->baseUrl?>/index.php/chat/getChat",data,function(result){
			//	alert(result);
				$("#<?php echo $id?> > div.chatMain").html("");
				$.each(result,function(index,item){
					$("#<?php echo $id?> > div.chatMain").append('<div class="block '+(item.me==1?"me":"")+'">'+
						'<div class="line '+(item.me==1?"me":"")+'" title="'+item.createTime+'">'+item.text+'</div>'+
					'</div>');
				});
			},'json');
		}
	}
</script>
<div id="<?php echo $id?>">
	<input class="userId" type="hidden"></input>
	<div class="refresh"><div class="btn btn-block btn-info btn-small refresh">刷新</div></div>
	<div class="chatMain"></div>
	<div class="say">
		<textarea class="chatText"></textarea>
		<div class="btn btn-small send">发送</div>
	</div>
</div>