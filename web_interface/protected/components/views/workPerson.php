<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?> > div.userlist > div.block{
		background-color:<?php echo COLORDARKER?>;
		float:left;
		padding:3px 20px 3px 10px;
		margin-right:10px;
		margin-bottom:2px;
		position:relative;
		color:gray;
		border-radius:5px;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.userlist > div.block > div.line > div.delete{
		position:absolute;
		top:3px;
		right:0px;
		width:15px;
		color:silver;
		font-weight:bold;
		cursor:pointer;
		font-size:1.1em;
	}
	#<?php echo $id?> > div.userlist > div.block > div.line > div.delete:hover{
		color:gray;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//监听projectId 的变化
	cw.ech("<?php echo $listen?>",function(){
		$("#<?php echo $id?> > input.workId").val($(this).val()).change();
	});
	cw.ech("#<?php echo $id?> > input.workId",function(){
		//获取本work人
		var workId = $(this).val();
		<?php echo $id;?>getWorkUser(workId);
	});
	//直接添加,同时发送修改到服务器
	cw.ech("#<?php echo $id?> > input.added",function(){
		<?php if($listenCanEdit != ""){ ?>
			if($("<?php echo $listenCanEdit;?>").val() != 1)
			{
				return;
			}
		<?php } ?>
		var data = {};
		data.workId = $("#<?php echo $id?> > input.workId").val();
		data.userId = $("#<?php echo $id?> > input.userId").val();
		
		data.userName = $("#<?php echo $id?> > input.userName").val();
		data.nickName = $("#<?php echo $id?> > input.nickName").val();
		data.type = $("#<?php echo $id?> > input.type").val();
		data.canDelete = $("#<?php echo $id?> > input.canDelete").val();
		//检查是否已经存在
		//alert("d");
		if($("#<?php echo $id?> > div.userlist > div.block > input.userId[value='"+data.userId+"']").length == 0)
		{
			var newBlock = <?php echo $id?>makeBlock(data);
			$("#<?php echo $id?> > div.userlist").append(newBlock);
			cw.post(cw.url+"addUser2Work",data,function(result){
				//alert(result);
				$(this).children("input.assignId").val(result.assignId);
			},newBlock);
		}
	});
	//删除work assign
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.line > div.delete",function(){
		<?php if($listenCanEdit != ""){ ?>
			if($("<?php echo $listenCanEdit;?>").val() != 1)
			{
				return;
			}
		<?php } ?>
		//直接修改，发送请求
		var data = {};
		data.assignId = $(this).parent().parent().children("input.assignId").val();
		if(data.assignId == "")
		{
			return false;
		}
		cw.post(cw.url+"removeAssign",data,function(result){
			//alert(result);
		});
		$(this).parent().parent().remove();
	});
	function <?php echo $id;?>getWorkUser(workId)
	{
		data = {};
		data.workId = workId;
		$("#<?php echo $id?> > div.userlist").html("");
		//alert(data.workId);
		cw.post(cw.url+"getWorkAssign",data,function(result){	
			//alert(result.length);
			$.each(result,function(index,item){
				item.canDelete = 0;
				<?php if($listenCanEdit != ""){ ?>
				if($("<?php echo $listenCanEdit;?>").val() == 1)
				{
					item.canDelete = 1;
				}
				<?php } ?>
				//alert(index);
				//检查是否已经存在
				if($("#<?php echo $id?> > div.userlist > div.block > input.userId[value='"+item.userId+"']").length == 0)
				{
					$("#<?php echo $id?> > div.userlist").append(<?php echo $id?>makeBlock(item));
				}
			});
		});
	}
	function <?php echo $id?>makeBlock(item)
	{
		item.assignId = ((item.id==null)||(item.id==undefined))?"":item.id;
		return $('<div class="block">'+
			'<input class="userId" type="hidden" value="'+item.userId+'"></input>'+
			'<input class="assignId" type="hidden" value="'+item.assignId+'"></input>'+
			'<div class="line userName">'+(item.nickName == ""?item.userName:item.nickName)+	
				(item.canDelete == 1?" <div class='delete'>&times;</div>":"")+
			'</div>'+
			//'<div class="line type">'+(item.type==1?"项目建立者":item.type==2?"项目经理":"项目成员")+'</div>'+
		'</div>');		
	}
</script>
<div id="<?php echo $id?>" >
	<input class="workId" type="hidden"></input>
	<?php /*用于直接添加*/ ?>
	<input class="added" type="hidden"></input>
	<input class="userId" type="hidden"></input>
	<input class="userName" type="hidden"></input>
	<input class="nickName" type="hidden"></input>
	<input class="type" type="hidden"></input>
	<input class="canDelete" value="1" type="hidden"></input>
	<div class="userlist"></div>
	<div style="clear:both"></div>
</div>