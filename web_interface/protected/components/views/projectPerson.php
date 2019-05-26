<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?> > div.header{
		padding:5px 0;
		font-weight:bold;
		font-size:1.2em;
	}
	#<?php echo $id?> > div.userlist{
		padding:5px 0;
	}
	#<?php echo $id?> > div.userlist > div.block{
		position:relative;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user{
		cursor:pointer;
		padding:5px;
		border-radius:3px;
		position:relative;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user > div.additionChoose{
		position:absolute;
		width:15px;
		height:15px;
		padding:10px;
		top:5px;right:5px;
		/*background-color:gray;*/
		border-radius:5px;
		display:none;
		z-index:10;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user:hover > div.additionChoose
	{
		display:block;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user > div.additionChoose:hover{
		/*background-color:silver;*/
	}
	@media screen and (max-device-width:1100px)
	{
		#<?php echo $id?> > div.userlist > div.block > div.user > div.additionChoose
		{
			display:block;
		}
	}
	#<?php echo $id?> > div.userlist > div.block > div.user:hover{
		background-color:<?php echo COLORDARK?>;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user > div.line{
		padding:3px 0;
		font-size:1em;
	}
	#<?php echo $id?> > div.userlist > div.block > div.user > div.type{
		color:silver;
		font-size:0.8em;
	}
	#<?php echo $id?> > div.addMember{
		position:relative;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup{
		/*position:absolute;
		top:35px;
		right:0;
		width:280px;
		-moz-box-shadow:0 1px 6px #999;              
 	 	-webkit-box-shadow:0 1px 6px #999;           
 	    box-shadow:0 1px 6px #999;
 	    z-index:999;
 	    border-radius:5px;
 	    background-color:white;
		*/
		padding:0px;		
		display:none;
		
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.close{
		color:gray;
		position:absolute;
		top:10px;
		right:10px;
		width:20px;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.header{
		text-align:center;
		color:gray;
		font-size:1.1em;
		font-weight:bold;
		padding:5px 0;
		border-bottom:1px solid <?php echo COLORDARKERER?>;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search{
		padding:5px;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line{
		padding:5px 0;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line > input{
		width:150px;margin:0;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result > div.title{
		text-align:center;
		color:gray;
		font-weight:bold;
		padding:10px;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result{
		padding:5px 0;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result > div.block{
		cursor:pointer;
		padding:10px;
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result > div.block:hover{
		background-color:<?php echo COLORDARK?>;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr{
		position:absolute;
		top:30px;
		left:0;
		width:90%;
		background-color:white;
		padding:10px;
		border-radius:5px;
		-moz-box-shadow:0 1px 6px #999;              
 	 	-webkit-box-shadow:0 1px 6px #999;           
 	    box-shadow:0 1px 6px #999;	
 	    display:none;    
 	    z-index:1000;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr > div.block{
		padding:10px;		
		cursor:pointer;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr > div.block:hover{
		background-color:<?php echo COLORDARKER?>;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr > div.user > div.line{
		padding:5px 0;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr > div.user > div.userName{
		font-weight:bold;
		font-size:1em;
	}
	#<?php echo $id?> > div.userlist > div.block > div.ctr > div.user > div.type{
		font-size:0.8em;
		color:gray
	}
	#<?php echo $id?> > div.addMember > div.addMemberPopup > #<?php echo $id?>humanResource{
		border-top:1px silver solid;
	}
	<?php if($showLog){ ?>
	
	#<?php echo $id?> > div.projectLog{
		padding-bottom:30px;
	}
	#<?php echo $id?> > div.projectLog > div.title{
		text-align:center;
		padding:10px 0;
		border-bottom:1px silver solid;
		margin-bottom:5px;
		color:gray;
		font-weight:bold;
		font-size:0.9em;
		margin-top:20px;
	}
	#<?php echo $id?> > div.projectLog > div.main > div.block{
		padding:5px;
	}
	
	#<?php echo $id?> > div.projectLog > div.main > div.block > div.line{
		font-size:0.9em;
		word-break:break-all;
	}
	#<?php echo $id?> > div.projectLog > div.main > div.block > div.time{
		color:gray;
		font-size:0.8em;
		text-align:right;
	}
	<?php } ?>
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//监听projectId 的变化
	cw.ech("<?php echo $listen?>",function(){
		$("#<?php echo $id?> > input.projectId").val($(this).val()).change();
	});
	cw.ech("#<?php echo $id?> > input.projectId",function(){
		//获取本project人员
		var projectId = $(this).val();
		<?php echo $id ?>getProjectUser(projectId);
		<?php if($showLog){ ?>
		//设置日志初始
		$("#<?php echo $id?> > div.projectLog").children("div.main").html("").end()
			.children("input.startId").val(0);
		//获取日志
		<?php echo $id?>getProjectLog(projectId);
		<?php } ?>
	});
	//点击添加成员
	cw.ec("#<?php echo $id?> > div.addMember > div.addMember",function(){
		if($("#<?php echo $id?> > div.addMember > div.addMemberPopup").css("display") == "none")
		{
			//显示overlay
			<?php echo $id?>getHR();
			$(this).html("收起");
		//	$("#<?php echo $id?> > #overlay<?php echo $id?> > input.show").change();
			$("#<?php echo $id?> > div.addMember > div.addMemberPopup").slideDown("fast");
			
			//获取输入框焦点 //不focus了，可能直接点击人力资源圈子
			//$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line > input.name").focus();
			//载入人力资源圈子			
		}
		else
		{
			$("#<?php echo $id?> > div.addMember > div.addMemberPopup").slideUp("fast");
			$(this).html("添加成员...");
			//清空搜索
			$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line > input.name").val("")
				.parent().parent().children("div.result").html("");
		}
	});
	//关闭添加成员框
	cw.ec("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.close",function(){
		$(this).parent().parent().parent().children("input.closeAddMember").change();
		//$("#<?php echo $id?> > #overlay<?php echo $id?> > input.hide").change();
	});
	cw.ech("#<?php echo $id?> > input.closeAddMember",function(){
		$("#<?php echo $id?> > div.addMember > div.addMemberPopup").slideUp("fast");
		//清空搜索
		$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line > input.name").val("")
			.parent().parent().children("div.result").html("");
	});
	function <?php echo $id ?>getProjectUser(projectId)
	{
		data = {};
		data.projectId = projectId;
		$("#<?php echo $id?> > div.userlist").html("");
		//alert(data.projectId);
		cw.post(cw.url+"getPU",data,function(result){	
			//设置当前用户是否可以设置项目经理
			$("#<?php echo $id?> > input.canChangePM").val(result.canChangePM);
			/*
				注意这里没有增量更新，删除了的不会消失
			*/
			$.each(result.userlist,function(index,item){
				//alert(index);
				<?php echo $id?>addUser2ProjectUserList(item);
			});
			//是否显示自己
			<?php if(!$showMe){ ?>
				$("#<?php echo $id?> > div.userlist > div.block > div.user > input.userId[value='<?php echo Yii::app()->session['userId'];?>']").parent().hide();
			<?php } ?>
		});
	}
	function <?php echo $id?>addUser2ProjectUserList(item)
	{	
		//获取当前用户是否可以设置项目经理信息
		var canChangePM = $("#<?php echo $id?> > input.canChangePM").val()==1?true:false;
		item.type = item.type==null?3:item.type;
		var newBlock = $('<div class="block">'+
			'<div class="user">'+
				'<input class="userId" type="hidden" value="'+item.userId+'"></input>'+
				'<input class="userName" type="hidden" value="'+item.userName+'"></input>'+
				'<input class="nickName" type="hidden" value="'+item.nickName+'"></input>'+
				'<input class="type" type="hidden" value="'+item.type+'"></input>'+
				<?php if($additionChoose){ ?>
					'<div class="additionChoose"><i class="icon-tasks"></i></div>'+
				<?php } ?>
				'<div class="line userName">'+(item.nickName == ""?item.userName:item.nickName)+'</div>'+
				'<div class="line type">'+(item.type==1?"项目建立者":item.type==2?"项目经理":"项目成员")+'</div>'+
			'</div>'+
			<?php if($ctrMember){ ?>
			(item.type==1?"":
			'<div class="ctr">'+
				'<input class="userId" type="hidden" value="'+item.userId+'"></input>'+
				'<div class="close">&times;</div>'+
				'<div class="user">'+
					'<div class="line userName">'+(item.nickName == ""?item.userName:item.nickName)+'</div>'+
					'<div class="line type">'+(item.type==1?"项目建立者":item.type==2?"项目经理":"项目成员")+'</div>'+
				'</div>'+
				(canChangePM?
					('<div class="block '+(item.type==2?"removePM":"setPM")+'">'+(item.type==2?"撤除":"设为")+'项目经理...</div>')
					:""
				)+
				((item.self != null) && (item.self == 1)?"":
					(
					<?php /*只有canChangePM时才能删除项目经理*/ ?>
						(item.type != 2)?'<div class="block remove">从项目中移除...</div>':
							(
								canChangePM?'<div class="block remove">从项目中移除...</div>':""			
							)
					)
				)+
			'</div>'
			)+
			<?php } ?>
		'</div>');
		//检查是否已经存在
		if($("#<?php echo $id?> > div.userlist > div.block > div.user > input.userId[value='"+item.userId+"']").length == 0)
		{
			$("#<?php echo $id?> > div.userlist").append(newBlock);
		}
	}
</script>
<?php if($addMember){ ?>
<script type="text/javascript">
	//点击查找
	cw.ec("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.line > div.search",function(){
		var data = {};
		data.searchBy = "name";
		data.search = $(this).parent().children("input.name").val();
		if(data.search == "")
		{
			return false;
		}
		cw.load("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result");
		cw.post(cw.url+"searchUser",data,function(result){
			if(result.length == 0)
			{
				$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result").html(
					'<div class="title">无结果</div>'
				);
			}
			else
			{
				$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result").html("");
				$.each(result,function(index,item){
					item.type = item.type==null?3:item.type;
					$("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result").append('<div class="block">'+
						'<input class="userId" type="hidden" value="'+item.userId+'"></input>'+
						'<input class="userName" type="hidden" value="'+item.userName+'"></input>'+
						'<input class="nickName" type="hidden" value="'+item.nickName+'"></input>'+
						'<input class="type" type="hidden" value="'+item.type+'"></input>'+
						'<div class="line userName">'+(item.nickName == ""?item.userName:item.nickName)+'</div>'+
					'</div>');
				});
			}
		});
	});
	//点击找到的成员，添加到当前组中
	cw.ec("#<?php echo $id?> > div.addMember > div.addMemberPopup > div.search > div.result > div.block",function(){
		//alert("a");
		var data = {};
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.userId = $(this).children("input.userId").val();
		data.type = $(this).children("input.type").val();
		data.userName = $(this).children("input.userName").val();
		data.nickName = $(this).children("input.nickName").val();
		data.nickName = data.nickName == undefined?"":data.nickName;
		<?php echo $id?>addUser2ProjectUserListAndSend(data);
	});
	//捕捉人力资源点击
	cw.ech("#<?php echo $id?> > div.addMember > div.addMemberPopup > input.userId",function(){
		//alert("a");
		var data = {};
		data.userId = $(this).val();
		data.userName = $(this).parent().children("input.userName").val();
		data.nickName = $(this).parent().children("input.nickName").val();
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.type = 3;
		//alert(userId);
		//直接加入到userlist
		<?php echo $id?>addUser2ProjectUserListAndSend(data);
	});
	function <?php echo $id?>addUser2ProjectUserListAndSend(data)
	{
		//检查是否已经存在
		if($("#<?php echo $id?> > div.userlist > div.block > div.user > input.userId[value='"+data.userId+"']").length == 0)
		{
			cw.post(cw.url+"addUser2Project",data,function(result){
			<?php if(count($refreshAdd) > 0){ ?>
			//刷新
			
				<?php foreach($refreshAdd as $one){ ?>
					$("<?php echo $one?>").change();
				<?php } ?>
			
			<?php } ?>
			});	
			//直接加入到userlist
			<?php echo $id?>addUser2ProjectUserList(data);
		}
	}
</script>
<script type="text/javascript">
	//获取人力资源圈
	function <?php echo $id?>getHR()
	{
		//触发载入
		$("#<?php echo $id?> > div.addMember > div.addMemberPopup > input.loadHR").change();
	}
</script>
<?php } ?>
<?php if(count($targetArr) > 0){ ?>
<script type="text/javascript">
	//点击userlist中
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.user",function(){
		//alert("a");
		<?php if($listenCanEdit != ""){ ?>
		//当在只读模式下时
		if($("<?php echo $listenCanEdit; ?>").val() == 0)	
		{
			return false;
		}
		<?php } ?>
		<?php foreach($targetArr as $one){
			foreach($one as $key=>$val){
				if($key == "fire"){
		?>
			$("<?php echo $val?>").change();
			<?php }else{ ?>
			$("<?php echo $val?>").val($(this).children("input.<?php echo $key?>").val());
			<?php } ?>
		<?php /*
			$("<?php echo $one['userId']?>").val($(this).children("input.userId").val());
			$("<?php echo $one['userName']?>").val($(this).children("input.userName").val());
			$("<?php echo $one['nickName']?>").val($(this).children("input.nickName").val());
			$("<?php echo $one['type']?>").val($(this).children("input.type").val());
			
			$("<?php echo $one['fire']?>").change();
			*/
		?>
		<?php }} ?>
	});
</script>
<?php } ?>
<?php if($ctrMember){ ?>
<script type="text/javascript">
	//点击userlist中, 开启控制
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.user",function(){	
		<?php if($listenCanEdit != ""){ ?>
		//当在只读模式下时
		if($("<?php echo $listenCanEdit; ?>").val() == 0)	
		{
			return false;
		}
		<?php } ?>
		
		if($(this).parent().children("div.ctr").css("display") == "none")
		{			
			//关闭其他的
			$("#<?php echo $id?> > div.userlist > div.block > div.ctr").hide();
			$(this).parent().children("div.ctr").show();
		}
		else
		{
			//关闭其他的
			$("#<?php echo $id?> > div.userlist > div.block > div.ctr").hide();
		}
	});
	//关闭
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.ctr > div.close",function(){
		$(this).parent().hide();
	});
	//设置为项目经理
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.ctr > div.setPM",function(){
		//发送请求(请求成功后刷新)
		var data = {};
		data.userId = $(this).parent().children("input.userId").val();
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.type = 2;
		cw.post(cw.url+"changePUType",data,function(result){
			
			
		});
		//直接修改
		$(this).html("撤除项目经理...").removeClass("setPM").addClass("removePM")
			.parent().find("div.user > div.type").html("项目经理").parent().parent()
			.parent().children("div.user").children("input.type").val(2).end()
				.children("div.type").html("项目经理");
		$(this).parent().hide();
		
	});
	//移除项目经理
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.ctr > div.removePM",function(){
		//发送请求(请求成功后刷新)
		var data = {};
		data.userId = $(this).parent().children("input.userId").val();
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.type = 3;//普通成员
		cw.post(cw.url+"changePUType",data,function(result){
			
		});
		//直接修改
		$(this).html("设为项目经理...").addClass("setPM").removeClass("removePM")
			.parent().find("div.user > div.type").html("项目成员").parent().parent()
			.parent().children("div.user").children("input.type").val(3).end()
				.children("div.type").html("项目成员");
		$(this).parent().hide();
	});
	//移除出本组
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.ctr > div.remove",function(){
		if(!confirm("确认移除出本项目?"))
		{
			return false;
		}
		var data = {};
		data.userId = $(this).parent().children("input.userId").val();
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		cw.post(cw.url+"deletePU",data,function(result){
		//	alert(result);
			<?php if(count($refreshRemove) > 0){ ?>
			//刷新
			
				<?php foreach($refreshRemove as $one){ ?>
					$("<?php echo $one?>").change();
				<?php } ?>
			
			<?php } ?>
			
		});
		//直接修改
		$(this).parent().parent().remove();
	});
</script>
<?php } ?>
<script type="text/javascript">
	<?php if($listenCanEdit != ""){ ?>
	//readOnly 设置
	cw.ech("<?php echo $listenCanEdit; ?>",function(){
		//设置为只读模式
		if($(this).val() == 0)
		{
			<?php if($addMember){ ?>
			$("#<?php echo $id?> > div.addMember").hide();
			<?php } ?>
		}
		else
		{
			<?php if($addMember){ ?>
			$("#<?php echo $id?> > div.addMember").show();
			//当添加成员框是显示的，就收起
			if($("#<?php echo $id?> > div.addMember > div.addMemberPopup").css("display") == "block")
			{
				$("#<?php echo $id?> > div.addMember > div.addMember").trigger(cw.ectype);
			}
			<?php } ?>
		}
	});
	<?php } ?>
</script>
<?php if($showLog){ ?>
<script type="text/javascript">
	//获取更多
	cw.ec("#<?php echo $id?> > div.projectLog > div.more",function(){
		var projectId = $("#<?php echo $id?> > input.projectId").val();
		<?php echo $id?>getProjectLog(projectId);
	});
	//获取日志
	function <?php echo $id?>getProjectLog(projectId)
	{
		//隐藏显示更多，显示载入中
		$("#<?php echo $id?> > div.projectLog > div.wrapLoading").show().parent().children("div.more").hide();
		//alert("s");
		var data = {};
		data.startId = $("#<?php echo $id?> > div.projectLog > input.startId").val();
		cw.post(cw.url+"getLog?projectId="+projectId+"&s="+data.startId,data,function(result){
			//alert(result);
			//隐藏载入中
			$("#<?php echo $id?> > div.projectLog > div.wrapLoading").hide();
			//显示显示更多，
			if(result.logs.length == 10)
			{
				$("#<?php echo $id?> > div.projectLog > div.more").show();
			}
			$.each(result.logs,function(index,item){
				$("#<?php echo $id?> > div.projectLog > div.main").append(cw.parseLog(item))
					.parent().children("input.startId").val(item.id);//设置当前最后一项的id	
			});
			
		});
	}
	
</script>
<?php } ?>
<?php if($additionChoose){ ?>
<script type="text/javascript">
	//点击user上的addition
	cw.ec("#<?php echo $id?> > div.userlist > div.block > div.user > div.additionChoose",function(e){
		e.stopPropagation();
		e.preventDefault();
		var userId = $(this).parent().children("input.userId").val();
		var username = $(this).parent().children("input.userName").val();
		var nickname = $(this).parent().children("input.nickName").val();
		//alert(userId);
		<?php if(isset($additionTarget['userId']) && isset($additionTarget['fire'])){ ?>
			$("<?php echo $additionTarget['userId']; ?>").val(userId);
			$("<?php echo $additionTarget['username']; ?>").val(username);
			$("<?php echo $additionTarget['nickname']; ?>").val(nickname);
			$("<?php echo $additionTarget['fire']; ?>").change();
		<?php } ?>
	});
	
</script>
<?php } ?>
<div id="<?php echo $id?>">
	<input class="projectId" type="hidden"></input>
	<input class="canChangePM" type="hidden"></input>
	
	<input class="closeAddMember" type="hidden"></input>
	
	<?php if($header){ ?>
	<div class="header">
		<?php echo t::o("project members")?>
	</div>
	<?php } ?>
	
	<div class="userlist"></div>
	
	<?php if($addMember){ ?>
	<div class="addMember">
		<div class="btn btn-block addMember"><?php echo t::o("add members")?>...</div>
		<!--
		<div class="popup addMemberPopup">
			<div class="close">&times;</div>
			<div class="header">成员</div>
			<div class="search">
				<div class="line">
					<input class="input-medium name" type="text" placeholder="根据名字查找"></input>
					<div class="btn btn-info search">查找</div>
				</div>
				<div class="result"></div>
			</div>
			<?php /*人力资源组*/?>
			<div class="resource" style=""><div class="wrapLoading"><div class="loading"></div></div></div>
		</div>
		-->
		<div class="addMemberPopup">
			<div class="search">
				<div class="line">
					<input class="input-medium name" type="text" placeholder="<?php echo t::o("by name")?>"></input>
					<div class="btn btn-info search"><?php echo t::o("search")?></div>
				</div>
				<div class="result"></div>
			</div>
			<?php /*人力资源组*/?>
			<input class="loadHR" type="hidden"></input>
			<input class="userId" type="hidden"></input>
			<input class="userName" type="hidden"></input>
			<input class="nickName" type="hidden"></input>
			<?php 
				$this->widget("HumanResourceWidget",array(
					"target" => array(
						"userName" => "#".$id." > div.addMember > div.addMemberPopup > input.userName",
						"nickName" => "#".$id." > div.addMember > div.addMemberPopup > input.nickName",
						"userId" => "#".$id." > div.addMember > div.addMemberPopup > input.userId",
						"trigger" => "#".$id." > div.addMember > div.addMemberPopup > input.userId",
					),//点击成员的响应
					"id" => $id."humanResource",
					//监听载入
					"listen" => "#".$id." > div.addMember > div.addMemberPopup > input.loadHR",
					"showAll" => $showAll,
				));
			?>			
		</div>
	</div>
	<?php } ?>
	
	<?php if($showLog){ ?>
	<div class="projectLog">
		<input class="startId" value="0" type="hidden"></input>
		<div class="title"><?php echo t::o("log")?></div>
		<div class="main"></div>
		<div class="wrapLoading"><div class="loading"></div></div>
		<div class="btn btn-block more"><?php echo t::o("more")?></div>
	</div>
	<?php } ?>
	
		<?php /*$this->widget("OverlayWidget",array(
			"zindex" => "998",
			"id" => "overlay".$id,
			"transparent" => true,
			"targetSelector" => "#".$id." > input.closeAddMember",
		));*/ ?>
</div>