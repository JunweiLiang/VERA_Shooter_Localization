<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?> > div.resource{
		background-color:<?php echo COLORDARK?>;
		padding:0 10px;
		border-radius:0 0 5px 5px;
	}
	#<?php echo $id?> > div.resource > div.header,
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.header{
		position:relative;
		padding-top:10px;
		padding-bottom:5px;
	}
	#<?php echo $id?> > div.resource > div.header > div.title,
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.header > div.title{
		text-align:center;
		font-weight:bold;
		font-size:1em;
	}
	#<?php echo $id?> > div.resource > div.header > div.back,
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.header > div.back{
		position:absolute;
		width:20px;
		height:20px;
		padding:5px;
		top:7px;
		left:0px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.content{
		padding:5px 0;
	}
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.content > div.line{
		padding:4px 0 ;
	}
	#<?php echo $id?> > div.resource > div.popups > div.popup > div.content > div.line > input{
		margin:0;
	}
	#<?php echo $id?> > div.resource > div.header > div.main > div.addGroup{
		text-align:left;
		color:gray;
		padding-left:5px;
		position:relative;
		cursor:pointer;
		top:5px;
	}
	#<?php echo $id?> > div.resource > div.uGroup{
		padding:5px 0;
	}
	#<?php echo $id?> > div.resource > div.uGroup > div.block,
	#<?php echo $id?> > div.resource > div.member > div.groupBlock > div.memberList > div.block,
	#<?php echo $id?> > div.resource > div.popups > div.popup.addTo > div.content > div.groupList > div.block,
	#<?php echo $id?> > div.resource > div.newGroup{
		cursor:pointer;
		padding:8px;
		background-color:white;
		border-radius:5px;
		-moz-box-shadow:0 1px 2px #999;              
 	 	-webkit-box-shadow:0 1px 2px #999;           
 	    box-shadow:0 1px 2px #999;
 	    margin-bottom:10px;		
 	    position:relative;
	}
	#<?php echo $id?> > div.resource > div.newGroup{
		display:none;
		top:5px;
	}
	#<?php echo $id?> > div.resource > div.newGroup > input.groupName{
		border:0;
		width:170px;
		padding:0px;
 	    margin:0;
	}
	/*
	#<?php echo $id?> > div.resource > div.uGroup > div.block:hover,
	#<?php echo $id?> > div.resource > div.member > div.lock > div.memberList > div.block:hover{
		background-color:<?php echo COLORDARKER?>;
	}*/
	#<?php echo $id?> > div.resource > div.member{
		display:none;
		padding:5px 0;
	}
	#<?php echo $id?> div.buttons{
		position:absolute;
		right:0;
		top:0;
		border-radius:0 5px 5px 0;
	}
	#<?php echo $id?> div.buttons > div.button{
		float:right;
		cursor:pointer;
		padding:8px;
		font-weight:bold;
		/*border-left:1px silver solid;*/
	}
	#<?php echo $id?> div.buttons > div.button.deleteGroup,
	#<?php echo $id?> div.buttons > div.button.deleteMember,
	#<?php echo $id?> div.buttons > div.button.confirm{
		background-color:#CC0033;
		color:white;
		border-radius:0 5px 5px 0;
	}
	#<?php echo $id?> div.buttons > div.button.addTo,
	#<?php echo $id?> div.buttons > div.button.changeGroup,
	#<?php echo $id?> div.buttons > div.button.cancel{
		background-color:#CCCC00;
		color:white;
	}
	
</style>
<script type="text/javascript">
	//载入监听
	cw.ech("<?php echo $listen?>",function(){
		<?php echo $id?>clearHR();
		<?php echo $id?>getHR();
	});
</script>
<script type="text/javascript">
	//获取人力资源圈子，增量更新
	function <?php echo $id?>getHR()
	{
		//显示载入中
		/*
		if($("#<?php echo $id?> > div.resource").html() == "")
		{
			$("#<?php echo $id?> > div.resource").html('<div class="wrapLoading"><div class="loading"></div></div>');
		}
		*/
		var data = {};
		cw.post(cw.url+"getUGroup",data,function(result){
			//alert(result);
			//是否是载入中
			$("#<?php echo $id?> > div.resource > div.uGroup > div.wrapLoading").remove();
			//记录本次更新有的groupId
			var groupIds = new Array();
			//alert(result.length);
			<?php if(!$showAll){ ?>
				//删除第一个组，
				if(result[0].groupId == -1)
				{
					//alert("continue");
					result.shift();
				}
			<?php } ?>
			$.each(result,function(index,item){
				//alert("a");
				
				groupIds.push(item.groupId);
				
				//检查该组是否存在,不存在就加在之前的前面;现在是新建的组会在前面
				if($("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+item.groupId+"']").length == 0)
				{
					if(index == 0)
					{
						$("#<?php echo $id?> > div.resource > div.uGroup").prepend(<?php echo $id?>makeUGroup(item.groupId,item.groupName));
					}else
					{
						<?php echo $id?>makeUGroup(item.groupId,item.groupName).insertBefore($("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+result[index-1].groupId+"']").parent());
					}
				}
				else//更新 组信息
				{
					$("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+item.groupId+"']")
						.parent().children("input.groupName").val(item.groupName).end()
							.children("div.groupName").children("span.groupName").html(item.groupName);
				}
				//更新本组member
				<?php echo $id?>updateUMember(item.groupMember,item.groupId);
			});
			//删除本次更新不存在的分组
			//alert(groupIds[1]);
			$("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId").each(function(){
				var groupId = $(this).val();
				//alert(groupId);
				if(<?php echo $id?>notIn(groupId,groupIds))
				{
					//alert('removing');
					$(this).parent().remove();
				}
			});
		});
	}
	function <?php echo $id?>notIn(value,arr)
	{
		var notIn = true;
		for(var i=0;i < arr.length;++i)
		{
			if(value == arr[i])
			{
				notIn = false;
				break;
			}
		}
		return notIn;
	}
	//更新一个人力资源分组
	function <?php echo $id?>updateUMember(groupMember,groupId)
	{
		//此小组成员组不存在,添加一个组
		if($("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+groupId+"']").length == 0)
		{
			//直接添加一个组
			$("#<?php echo $id?> > div.resource > div.member").append('<div class="groupBlock">'+
				'<input class="groupId" type="hidden" value="'+groupId+'"></input>'+
				'<div class="memberList"></div>'+
			'</div>');
		}
		//增量更新
		var memberIds = new Array();
		var $group = $("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+groupId+"']").parent();
		for(var i=0;i < groupMember.length;++i)
		{
			memberIds.push(groupMember[i].userId);
			var memberI = $group.find("div.memberList > div.block > input.userId[value='"+groupMember[i].userId+"']");
			//该成员存在,更新
			if(memberI.length > 0)
			{
				var name = groupMember[i].nickName==""?groupMember[i].userName:groupMember[i].nickName;
				memberI.parent().children('input.userName').val(groupMember[i].userName).end()
					.children("input.nickName").val(groupMember[i].nickName).end()
					.children("div.name").html(name);
			}
			else//插入之前的后面 
			{
				if(i == 0)
				{
					$group.children("div.memberList").append(<?php echo $id?>makeUGMember(groupMember[i],groupId));
				}
				else
				{
					<?php echo $id?>makeUGMember(groupMember[i],groupId).insertAfter($group.find("div.memberList > div.block > input.userId[value='"+groupMember[i-1].userId+"']").parent());
				}
			}
		}
		//删除本次更新不存在的成员 
		$group.find("div.memberList > div.block > input.userId").each(function(){
			var userId = $(this).val();
			if(<?php echo $id?>notIn(userId,memberIds))
			{
				$(this).parent().remove();
			}
		});
		//计算本次更新后的本组成员总数
		<?php echo $id?>countGroupMembers(groupId)
	}
	function <?php echo $id?>makeUGroup(groupId,groupName)
	{
		var memberCount = arguments[2]?arguments[2]:0;
		hasEdit = false;
		<?php if($canEdit){ ?>
			hasEdit = true;
		<?php } ?>
		//当groupId==0,不添加按钮，member也不添加删除按钮 
		if(groupId == 0)
		{
			hasEdit = false;
		}
		return $('<div class="block">'+
			'<input class="groupId" type="hidden" value="'+groupId+'"></input>'+
			'<input class="groupName" type="hidden" value="'+groupName+'"></input>'+
			'<div class="groupName"><span class="groupName">'+groupName+'</span> <span class="count">('+memberCount+')</span></div>'+
			(
				hasEdit?<?php echo $id?>makeButtonsHtml(groupId,null,null,null,groupName,"<?php echo t::o("delete"); ?>","<?php echo t::o("change name"); ?>","",""):""
			)+
		'</div>');
	}
	function <?php echo $id?>makeUGMember(data,groupId)
	{
		hasEdit = false;
		onlyAdd = false;
		<?php if($canEdit){ ?>
			hasEdit = true;
		<?php } ?>
		//当groupId==0,不添加按钮，member也不添加删除按钮 
		if(groupId == 0)
		{
			if(hasEdit == true)
			{
				onlyAdd = true;
			}
			hasEdit = false;
		}
		var name = data.nickName==""?data.userName:data.nickName;
		return $('<div class="block">'+
			'<input class="userId" type="hidden" value="'+data.userId+'"></input>'+
			'<input class="userName" type="hidden" value="'+data.userName+'"></input>'+
			'<input class="nickName" type="hidden" value="'+data.nickName+'"></input>'+
			'<div class="name">'+name+'</div>'+
			(
				hasEdit?<?php echo $id?>makeButtonsHtml(data.userId,groupId,data.userName,data.nickName,name,"","","<?php echo t::o("add to"); ?>...","<?php echo t::o("delete"); ?>"):""
			)+
			(
				onlyAdd?<?php echo $id?>makeButtonsHtml(data.userId,groupId,data.userName,data.nickName,name,"","","<?php echo t::o("add to"); ?>...",""):""
			)+
		'</div>');
	}
	function <?php echo $id?>makeButtonsHtml(actionId,actionId2,actionId3,actionId4,actionStr,deleteGroupStr,changeGroupStr,addToStr,deleteMemberStr)
	{
		<?php
			/*
				构造控制按钮，用统一的事件来响应，点击后会取button的class去显示popup中的div.class,并且传入actionId,同时会触犯change
			*/
		?>
			
			return '<div class="buttons">'+
				'<input class="actionId" value="'+actionId+'" type="hidden"></input>'+
				'<input class="actionId2" value="'+actionId2+'" type="hidden"></input>'+
				'<input class="actionId3" value="'+actionId3+'" type="hidden"></input>'+
				'<input class="actionId4" value="'+actionId4+'" type="hidden"></input>'+
				'<input class="actionStr" value="'+actionStr+'" type="hidden"></input>'+
				(
					deleteGroupStr==""?"":
					'<div class="button deleteGroup">'+
						'<input class="class" value="deleteGroup" type="hidden"></input>'+
						deleteGroupStr+
					'</div>'
				)+
				(
					deleteMemberStr==""?"":
					'<div class="button deleteMember">'+
						'<input class="class" value="deleteMember" type="hidden"></input>'+
						deleteMemberStr+
					'</div>'
				)+
				(
					changeGroupStr==""?"":
					'<div class="button changeGroup">'+
						'<input class="class" value="changeGroup" type="hidden"></input>'+
						changeGroupStr+
					'</div>'
				)+
				(
					addToStr==""?"":
					'<div class="button addTo">'+
						'<input class="class" value="addTo" type="hidden"></input>'+
						addToStr+
					'</div>'
				)+
				
			'</div>';
		
	}
	function <?php echo $id?>countGroupMembers(groupId)
	{
		var $group = $("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+groupId+"']").parent();
		if($group != null)
		{
			//查找对应的member数量
			var groupMemberCount = $group.find("div.memberList > div.block > input.userId").length;
			$("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+groupId+"']").parent()
				.find("div.groupName > span.count").html("("+groupMemberCount+")");
		}
	}
</script>
<?php if($canEdit){ ?>
<script type="text/javascript">
	
	//统一的按钮响应
	cw.ec("#<?php echo $id?> > div.resource div.block > div.buttons > div.button",function(e){
		//alert("s");
		e.stopPropagation();
		e.preventDefault();
		var actionId = $(this).parent().children("input.actionId").val();
		var actionId2 = $(this).parent().children("input.actionId2").val();
		var actionId3 = $(this).parent().children("input.actionId3").val();
		var actionId4 = $(this).parent().children("input.actionId3").val();
		var actionStr = $(this).parent().children("input.actionStr").val();
		var className = $(this).children("input.class").val();
		//alert(className);
		//隐藏头
		//隐藏uGroup与member与newGroup
		$("#<?php echo $id?> > div.resource").children("div.header").hide().end()
			.children("div.uGroup").hide().end()
			.children("div.member").hide().end()
			.children("div.newGroup").hide();
		//显示该class的popup,填充actionId,actionStr
		$("#<?php echo $id?> > div.resource > div.popups").children("div.popup").hide().end().children("div.popup."+className)
			.children("input.actionId").val(actionId).end()
			.children("input.actionId2").val(actionId2).end()
			.children("input.actionId3").val(actionId3).end()
			.children("input.actionId4").val(actionId4).end()
			.children("input.actionStr").val(actionStr).end()
			.children("input.change").change().end()
			.show();
		
	});
	//统一的popup的返回
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup > div.header > div.back",function(e){
		e.stopPropagation();
		//<?php echo $id?>clearHR();
		
		//判断上一个状态是在小组中还是小组列表里
		toGroupList = false;
		if($("#<?php echo $id?> > div.resource > div.header > div.groupName").css("display") == "none")
		{
			toGroupList = true;
		}
		$("#<?php echo $id?> > div.resource").children("div.popups").children("div.popup").hide().end().end()
				.children("div.header").show();
		if(toGroupList)
		{
			
				$("#<?php echo $id?> > div.resource > div.uGroup").show();
		}
		else
		{
			//切换回去到小组成员中
			$("#<?php echo $id?> > div.resource > div.member").show();
		}	
	});
	//popup > div.content > div.line > div.cancel  相当于点击返回 
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup > div.content > div.line > div.cancel",function(e){
		e.stopPropagation();
		$(this).parent().parent().parent().find("div.header > div.back").trigger(cw.ectype);
	});
	//删除小组响应，填充组名字
	cw.ech("#<?php echo $id?> > div.resource > div.popups > div.popup.deleteGroup > input.change",function(){
		var groupId = $(this).parent().children("input.actionId").val();
		var groupName = $(this).parent().children("input.actionStr").val();
		$(this).parent().find("div.header > div.title > span.groupName").html(groupName);
	});
	//修改小组响应，填充组名字
	cw.ech("#<?php echo $id?> > div.resource > div.popups > div.popup.changeGroup > input.change",function(){
		var groupId = $(this).parent().children("input.actionId").val();
		var groupName = $(this).parent().children("input.actionStr").val();
		$(this).parent().find("div.content > div.line > input.groupName").val(groupName);
	});
	//删除小组成员，响应，填充小组成员名字
	cw.ech("#<?php echo $id?> > div.resource > div.popups > div.popup.deleteMember > input.change",function(){
		var userId = $(this).parent().children("input.actionId").val();
		var name = $(this).parent().children("input.actionStr").val();
		$(this).parent().find("div.header > div.title > span.name").html(name);
	});
	//添加小组成员到,响应，填充小组成员名字，获取小组列表
	cw.ech("#<?php echo $id?> > div.resource > div.popups > div.popup.addTo > input.change",function(){
		var userId = $(this).parent().children("input.actionId").val();
		var name = $(this).parent().children("input.actionStr").val();
		$(this).parent().find("div.header > div.title > span.name").html(name);
		//获取当前uGroup中的小组列表 
		$("#<?php echo $id?> > div.resource > div.popups > div.popup.addTo > div.content > div.groupList").html("");
		$("#<?php echo $id?> > div.resource > div.uGroup > div.block").each(function(){
			var groupName = $(this).children("input.groupName").val();
			var groupId = $(this).children("input.groupId").val();
			//所有不能增加，
			if(groupId != 0)
			{
				$("#<?php echo $id?> > div.resource > div.popups > div.popup.addTo > div.content > div.groupList").append(
					'<div class="block">'+
						'<input class="groupName" value="'+groupName+'" type="hidden"></input>'+
						'<input class="groupId" value="'+groupId+'" type="hidden"></input>'+
						'<div class="line groupName">'+groupName+'</div>'+
					'</div>'
				);
			}
		});
	});
	//确认删除小组
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup.deleteGroup > div.content > div.line > div.confirm",function(){
		var groupId = $(this).parent().parent().parent().children("input.actionId").val();
		//alert(groupId);
		var data = {};
		data.groupId = groupId;
		cw.post(cw.url+"deleteUGroup",data,function(result){
		
		});
		//直接移除该小组和该小组成员
		$("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+groupId+"']").parent().remove();
		$("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+groupId+"']").parent().remove();
		//返回
		$(this).parent().parent().parent().find("div.header > div.back").trigger(cw.ectype);
	});
	//确认修改小组
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup.changeGroup > div.content > div.line > div.confirm",function(){
		var data = {};
		data.groupId = $(this).parent().parent().parent().children("input.actionId").val();
		data.groupName = $(this).parent().parent().find("div.line > input.groupName").val();
		if(data.groupName == "")
		{
			return false;
		}
		//发送
		cw.post(cw.url+"changeUGroup",data,function(result){
			
		});
		$("#<?php echo $id?> > div.resource > div.uGroup > div.block > input.groupId[value='"+data.groupId+"']").parent()
			.children("input.groupName").val(data.groupName).end()
			.children("div.groupName").children("span.groupName").html(data.groupName);
		//返回
		$(this).parent().parent().parent().find("div.header > div.back").trigger(cw.ectype);
	});
	//确认移除成员
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup.deleteMember > div.content > div.line > div.confirm",function(){
		var data = {};
		data.userId = $(this).parent().parent().parent().children("input.actionId").val();
		data.groupId = $(this).parent().parent().parent().children("input.actionId2").val();
		cw.post(cw.url+"deleteUGroupMember",data,function(result){
			
		});
		//直接删除
		var $group = $("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+data.groupId+"']").parent();
		$group.find("div.memberList > div.block > input.userId[value='"+data.userId+"']").parent().remove();
		<?php echo $id?>countGroupMembers(data.groupId);
		//返回
		$(this).parent().parent().parent().find("div.header > div.back").trigger(cw.ectype);
	});
	//添加成员到...
	cw.ec("#<?php echo $id?> > div.resource > div.popups > div.popup.addTo > div.content > div.groupList > div.block",function(){
		var data = {};
		data.userId = $(this).parent().parent().parent().children("input.actionId").val();
		data.groupId = $(this).children("input.groupId").val();
		data.userName = $(this).parent().parent().parent().children("input.actionId3").val();
		data.nickName = $(this).parent().parent().parent().children("input.actionId4").val();
		//查重
		var $group = $("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='"+data.groupId+"']").parent();
		if($group.find("div.memberList > div.block > input.userId[value='"+data.userId+"']").length == 0)
		{
			cw.post(cw.url+"addMember2UGroup",data,function(result){
			
			});
			//直接添加此成员到
			$group.children("div.memberList").append(<?php echo $id?>makeUGMember(data,data.groupId));
		}
		<?php echo $id?>countGroupMembers(data.groupId);
		//返回
		$(this).parent().parent().parent().find("div.header > div.back").trigger(cw.ectype);
	});
	
	
	//点击新建组
	cw.ec("#<?php echo $id?> > div.resource > div.header > div.main > div.addGroup",function(){
		$("#<?php echo $id?> > div.resource > div.newGroup").show().children("input.groupName").val("").focus();
	});
	//点击新建组取消
	cw.ec("#<?php echo $id?> > div.resource > div.newGroup > div.buttons > div.button.cancel",function(){
		$(this).parent().parent().hide();
	});
	//点击新建组确定
	cw.ec("#<?php echo $id?> > div.resource > div.newGroup > div.buttons > div.button.confirm",function(){
		var groupName = $(this).parent().parent().children("input.groupName").val();
		if(groupName == "")
		{
			return false;
		}
		//直接添加新组
		var newGroup = <?php echo $id?>makeUGroup(-1,groupName);
		//添加一个新的member组,后面修改
		<?php echo $id?>updateUMember(new Array(),-1);
		var data = {};
		data.groupName = groupName;
		cw.post(cw.url+"newUGroup",data,function(result){
			$(this).children("input.groupId").val(result.groupId).parent().find("div.buttons > input.actionId").val(result.groupId);
			//修改groupId=-1的 member中
			$("#<?php echo $id?> > div.resource > div.member > div.groupBlock > input.groupId[value='-1']").val(result.groupId);
		},newGroup);
		$("#<?php echo $id;?> > div.resource > div.uGroup").prepend(newGroup);	
		//清空
		$(this).parent().parent().children("input.groupName").val("");
	});
	
</script>
<?php } ?>
<script type="text/javascript">
	<?php /*人力资源分组的行为*/ ?>
	//点击分组
	cw.ec("#<?php echo $id?> > div.resource > div.uGroup > div.block",function(){
		var groupId = $(this).children("input.groupId").val();
		var groupName = $(this).children("input.groupName").val();
		//隐藏分组,修改标题,现实返回按钮
		$(this).parent().hide()
			.parent().find('div.header > div.groupName').html(groupName).show()
			.parent().children("div.main").hide()
			.end().children("div.back").show();
		//隐藏显示新分组
		$("#<?php echo $id?> > div.resource > div.newGroup").hide();
		//显示该分组
		$("#<?php echo $id?> > div.resource > div.member").show().children("div.groupBlock").hide()
			.end().find("div.groupBlock > input.groupId[value='"+groupId+"']").parent().show();
	});
	//点击返回
	cw.ec("#<?php echo $id?> > div.resource > div.header > div.back",function(){
		<?php echo $id?>clearHR();
	});
	//点击成员
	cw.ec("#<?php echo $id?> > div.resource > div.member > div.groupBlock > div.memberList > div.block",function(){
		var userId = $(this).children("input.userId").val();
		var userName = $(this).children("input.userName").val();
		var nickName = $(this).children("input.nickName").val();
		<?php if(!empty($target)){ ?>
			//alert(userId);
			$("<?php echo $target['userId']?>").val(userId);
			$("<?php echo $target['userName']?>").val(userName);
			$("<?php echo $target['nickName']?>").val(nickName);
			$("<?php echo $target['trigger']?>").change();
		<?php } ?>
	});
	function <?php echo $id?>clearHR()
	{
		//回到初始状态
		$("#<?php echo $id?> > div.resource").children("div.header").show()
			.children("div.main").show().end()
			.children("div.groupName").hide().end()
			.children("div.back").hide().end()
			.end()
		.children("div.uGroup").show().end()
		.children("div.member").hide().end()
		.children("div.newGroup").hide().end()
		.children("div.popups").find("div.popup").hide();
	}
</script>
<div id="<?php echo $id?>">
	<div class="resource" style="">
		<div class="header">
			<div class="back"><i class="icon-chevron-left"></i></div>
			<div class="main title">
				<?php if(!$noHeader){ ?>
					<?php echo t::o("Human Resource"); ?>
				<?php } ?>
				<?php if($canEdit){ ?>
					<div class="addGroup"><?php echo t::o("New group"); ?>...</div>
				<?php } ?>
			</div>
			<div class="groupName title" style="display:none"></div>
		</div>
		<?php if($canEdit){ ?>
		<div class='newGroup'>
			<input class="groupName" type="text"></input>
			<div class="buttons">	
				<div class="button confirm"><?php echo t::o("ok"); ?></div>
				<div class="button cancel"><?php echo t::o("cancel"); ?></div>
			</div>
		</div>
		<div class="popups">
			<?php 
				/*			
			<div class="popup className">
				<input class="change" type="hidden"></input>
				<input class="actionId" type="hidden"></input>
				<input class="actionId2" type="hidden"></input>
				<input class="actionId3" type="hidden"></input>
				<input class="actionId4" type="hidden"></input>
				<input class="actionStr" type="hidden"></input>
				<div class="header">
					<div class="back"><i class="icon-chevron-left"></i></div>
					<div class="title">
					</div>
				</div>
				<div class="content"></div>
			</div>
				*/
			?>
			<div class="popup deleteGroup">
				<input class="change" type="hidden"></input>
				<input class="actionId" type="hidden"></input>
				<input class="actionId2" type="hidden"></input>
				<input class="actionId3" type="hidden"></input>
				<input class="actionId4" type="hidden"></input>
				<input class="actionStr" type="hidden"></input>
				<div class="header">
					<div class="back"><i class="icon-chevron-left"></i></div>
					<div class="title">
						<?php echo t::o("confirm"); ?> <?php echo t::o("delete"); ?> <?php echo t::o("group"); ?><span class="groupName"></span>?
					</div>
				</div>
				<div class="content">
					<div class="line" style="text-align:center">
						<div class="btn cancel"><?php echo t::o("cancel"); ?></div>
						<div class="btn btn-danger confirm"><?php echo t::o("ok"); ?></div>
					</div>
				</div>
			</div>
			<div class="popup changeGroup">
				<input class="change" type="hidden"></input>
				<input class="actionId" type="hidden"></input>
				<input class="actionId2" type="hidden"></input>
				<input class="actionId3" type="hidden"></input>
				<input class="actionId4" type="hidden"></input>
				<input class="actionStr" type="hidden"></input>
				<div class="header">
					<div class="back"><i class="icon-chevron-left"></i></div>
					<div class="title">
						<?php echo t::o("change group name"); ?>
					</div>
				</div>
				<div class="content">
					<div class="line" style="text-align:center">
						<input class="groupName" style="width:150px" type="text"></input>
					</div>
					<div class="line" style="text-align:center">
						<div class="btn cancel"><?php echo t::o("cancel"); ?></div>
						<div class="btn btn-danger confirm"><?php echo t::o("ok"); ?></div>
					</div>
				</div>
			</div>
			<div class="popup deleteMember">
				<input class="change" type="hidden"></input>
				<input class="actionId" type="hidden"></input>
				<input class="actionId2" type="hidden"></input>
				<input class="actionId3" type="hidden"></input>
				<input class="actionId4" type="hidden"></input>
				<input class="actionStr" type="hidden"></input>
				<div class="header">
					<div class="back"><i class="icon-chevron-left"></i></div>
					<div class="title">
						<?php echo t::o("confirm removing"); ?><span class="name"></span>
					</div>
				</div>
				<div class="content">
					<div class="line" style="text-align:center">
						<div class="btn cancel"><?php echo t::o("cancel"); ?></div>
						<div class="btn btn-danger confirm"><?php echo t::o("ok"); ?></div>
					</div>
				</div>
			</div>
			<div class="popup addTo">
				<input class="change" type="hidden"></input>
				<input class="actionId" type="hidden"></input>
				<input class="actionId2" type="hidden"></input>
				<input class="actionId3" type="hidden"></input>
				<input class="actionId4" type="hidden"></input>
				<input class="actionStr" type="hidden"></input>
				<div class="header">
					<div class="back"><i class="icon-chevron-left"></i></div>
					<div class="title">
						<?php echo t::o("adding"); ?> <span class="name"></span> <?php echo t::o("to"); ?>...
					</div>
				</div>
				<div class="content">
					<div class="groupList">
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="uGroup">
			<div class="wrapLoading"><div class="loading"></div></div>
		</div>
		<div class="member"></div>
	</div>
</div>