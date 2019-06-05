<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8//modified in 2013.11
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{
		background-color:<?php echo COLOR1_LIGHTER1?>;
		height:30px;
		padding:5px 0px;
		
		width:100%;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	div.makeupspace{
		height:30px;
		padding:5px 0;
		width:100%;
		position:relative;
	}
	#<?php echo $id;?> > a.logo{
		position:absolute;
		left:50%;
		width:300px;
		text-align:center;
		margin-left:-150px;
		font-size:1.2em;
		font-weight:bold;
		padding-top:5px;
		color:white;
		text-decoration:none;
		outline:none;
	}
	#<?php echo $id;?> > a.logo:focus{
		outline:none;
	}
	#<?php echo $id?> > span.loading{
		position:absolute;
		left:50%;
		width:20px;
		margin-left:52px;
		font-size:1.2em;
		font-weight:bold;
		padding-top:5px;
		color:white;
	}
	
	#<?php echo $id;?> > .header-button,
	#<?php echo $id;?> > div.back{
		float:left;
		padding:5px 10px;
		cursor:pointer;
		margin-right:5px;
		margin-left:5px;
		height:20px;
		background-color:<?php echo COLOR1_LIGHTER2;?>;
		border-radius:3px;		
		position:relative;
	}
	#<?php echo $id;?> > div.back{
		background-color:transparent;
		padding:8px;
		padding-left:0;
		padding-bottom:0px;
		display:none;
	}
	#<?php echo $id;?> > .header-button:hover{
		background-color:<?php echo COLOR1_LIGHTER2_MORE;?>;
	}
	#<?php echo $id;?> > .header-button > span{
		color:white;
		font-size:0.8em;
		font-weight:bold;
	}
	#<?php echo $id;?> > .header-button > span > input.search{
		width:100px;
		background-color:transparent;
		border:0;
	}
	#<?php echo $id;?> > .header-button.right{
		float:right;		
	}
	#<?php echo $id;?> > .header-button > span.header-icon > i{
		margin-top:2px;
	}
	#<?php echo $id;?> > .header-button.highlight{
		background-color:<?php echo COLOR1_LIGHTER2_MORE;?>;
	}
	#<?php echo $id;?> > .header-button.remind > div.remindSum{
		position:absolute;
		top:-4px;
		right:-3px;
		background-color:rgb(250,0,0);
		color:white;
		font-weight:bold;
		font-size:0.8em;		
		width:auto!important;
		width:10px;
		min-width:10px;
		height:10px;
		line-height:10px;
		padding:3px;
		border-radius:8px;
		text-align:center;
		display:none;
	}
	#<?php echo $id?> > div.pop-up{
		position:absolute;
		border-radius:5px;
		top:45px;
		display:none;
		background-color:white;
		-moz-box-shadow:0 1px 6px #999;              
 	   -webkit-box-shadow:0 1px 6px #999;           
 	   box-shadow:0 1px 6px #999;
 	   z-index:999;
	}
	
	#<?php echo $id?> > div.pop-up.projectList,
	#<?php echo $id?> > div.pop-up.humanResource{
		left:10px;
		width:300px;
		border:1px silver solid;
	}
	#<?php echo $id?> > div.pop-up.new,
	#<?php echo $id?> > div.pop-up.profile,
	#<?php echo $id?> > div.pop-up.remind{
		right:10px;
		width:300px;
		border:1px silver solid;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list{
		padding:10px 0;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > a.block,
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to{
		display:block;
		padding:5px 20px;
		font-weight:bold;
		text-decoration:none;
		color:black;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > a.block:hover,
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to:hover{
		color:white;
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up{
		display:none;
		padding:10px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up input{
		margin:0;
	}
	#<?php echo $id?> > div.pop-up > div.delete{
		position:absolute;
		top:10px;
		right:2px;
		cursor:pointer;
		color:gray;
		font-weight:bold;
		width:25px;
		height:25px;
		opacity:0.9;
			filter:alpha(opacity=90); 
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.pop-up > div.back{
		position:absolute;
		top:14px;
		left:15px;
		cursor:pointer;
		color:gray;
		font-weight:bold;
		width:25px;
		height:25px;
		display:none;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.title,
	#<?php echo $id?> > div.pop-up > div.title{
		text-align:center;
		padding:10px 0;
		margin:0px 10px;
		margin-bottom:5px;
		border-bottom:1px <?php echo COLORDARKER?> solid;
		color:gray;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content{
		padding:5px;
		overflow-x:hidden;
		overflow-y:auto;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar {
		height: 9px;
		width: 9px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-button {
		display: block;
		height: 5px;
		width: 5px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-track-piece {
		background: <?php echo COLORDARK?>;
		border-radius:5px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-thumb{
		background:<?php echo COLORDARKERER?>;
		border-radius:5px;
		display:block;
		height:10px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block{
		margin-bottom:5px;
		background-color:<?php echo COLOR1_LIGHTER1?>;
		border-radius:3px;
		padding-left:10%;
		cursor:pointer;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block > div.projectName{
		padding:10px;
		font-weight:bold;
		border-radius:0 3px 3px 0;
		background-color:<?php echo COLOR1_LIGHTER3?>;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block:hover > div.projectName{
		background-color:<?php echo COLOR1_LIGHTER3_DARK?>;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body{
		padding:5px 0;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block{
		padding:10px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block > div.title{
		font-weight:bold;
		padding:5px;
		font-size:1.2em;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block > div.subTitle{
		font-size:1em;
		color:gray;
		padding:5px;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover{
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover > div.title{
		color:white;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover > div.subTitle
	{
		color:silver;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body
	{
		padding:5%;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body > div.title{
		font-weight:bold;
		padding-bottom:5px;
		font-size:1em;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body > div.line > input.projectName{
		width:95%;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content{
		padding-bottom:10px;
		word-break:break-all;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block{
		padding:10px;
		position:relative;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block:hover{
		
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.time{
		color:silver;
		font-size:0.8em;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.delete{
		display:none;
		z-index:994;
		position:absolute;
		top:5px;
		right:10px;
		background-color:white;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block:hover > div.delete{
		display:block;
	}
	/*手机上ipad就直接显示*/
	@media screen and (max-device-width:1100px)
	{
		#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.delete{
			display:block;
		}
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.line{
		padding:5px 0;
		word-break:break-all;
	}
	/*手机屏幕*/
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id;?> > div.header-button{
			padding-top:7px;
			padding-bottom:3px;
		}
		#<?php echo $id;?> > div.header-button > span.header-text
		{
			display:none
		}
		#<?php echo $id;?> > div.header-button:hover{
			background-color:<?php echo COLOR1_LIGHTER2;?>;
		}
		/*弹出框*/
		#<?php echo $id?> > div.pop-up.new,
		#<?php echo $id?> > div.pop-up.profile,
		#<?php echo $id?> > div.pop-up.remind{
			right:5%;
			width:90%;
		}
		#<?php echo $id?> > div.pop-up.projectList{
			left:5%;
			width:90%;
		}
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line{
		padding:3px 0;
		position:relative;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.left{
		float:left;
		width:60px;
		padding-top:3px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.right{
		margin-left:60px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.alertpw{
		color:red;
		font-size:0.9em;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		startLoading();
		//$("#<?php echo $id?> > input.loading").change();
	});
	//loading, stop loading
	cw.ech("#<?php echo $id?> > input.loading",function(){
		//alert("a");
		$("#<?php echo $id?> > span.loading").show();
		//startLoading();
	});
	cw.ech("#<?php echo $id?> > input.stopLoading",function(){
		$("#<?php echo $id?> > span.loading").hide();
		//startLoading();
	});
	function startLoading()
	{
		setInterval(function(){
			$Object = $("#<?php echo $id?> > span.loading");
			/*
			if($Object.html() == "")
			{
				$Object.html(".");
			}
			else if($Object.html() == ".")
			{
				$Object.html("..");
			}
			else if($Object.html() == "..")
			{
				$Object.html(".:");
			}
			else if($Object.html() == ".:")
			{
				$Object.html("::");
			}
			else if($Object.html() == "::")
			{
				$Object.html("");
			}
			*/
			if($Object.html() == "")
			{
				$Object.html(".");
			}
			else if($Object.html() == ".")
			{
				$Object.html("..");
			}
			else if($Object.html() == "..")
			{
				$Object.html(".&nbsp;");
			}
			else 
			{
				$Object.html("");
			}
			
		},300);
	}
</script>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl;?>/index.php/main/";
	<?php /*关于新增的函数*/?>
	//点击新增
	cw.ec("#<?php echo $id?> > div.header-button.new",function(){
		//alert("a");
		if($("#<?php echo $id?> > div.pop-up.new").css("display") == "none")
		{
			resetNew();
			$("#<?php echo $id?> > div.pop-up.new").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.new").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
	function resetNew()
	{
		$("#<?php echo $id?> > div.pop-up.new > div.pop-up-item").hide();
		$("#<?php echo $id?> > div.pop-up.new > div.addwhat").show();
	}
	//新增关闭
	cw.ec("#<?php echo $id?> > div.pop-up > div.delete",function(){
		$(this).parent().hide();
		$("#overlayPopups > input.hide").change();
	});
	//新增项目
	cw.ec("#<?php echo $id?> > div.pop-up.new > div.addwhat > div.body > div.block.project",function(){
		$("#<?php echo $id?> > div.pop-up.new > div.pop-up-item").hide();
		$("#<?php echo $id?> > div.pop-up.new > div.addProject").show()
			.find("div.body > div.line > input.projectName").focus();
	});
	//确认新增项目
	cw.ec("#<?php echo $id?> > div.pop-up.new > div.addProject > div.body > div.line > div.create",function(){
		var data = {};
		data.name = $(this).parent().parent().find("div.line > input.projectName").val();
		if(data.name == "")
		{
			return false;
		}
		//填充新项目名字
		$("<?php echo $targetName;?>").val(data.name);
		//显示载入中 
		$("#<?php echo $id?> > input.loading").change();
		cw.post(cw.url+"newProject",data,function(result){
			//alert(result);
			//清楚新建框
			$("#<?php echo $id?> > div.pop-up.new > div.addProject > div.body > div.line > input.projectName").val("");
			<?php foreach($targetChange as $one){ ?>
				$("<?php echo $one;?>").change();
			<?php } ?>
		});
		//关闭新建框
		$("#<?php echo $id?> > div.pop-up.new").hide();
		$("#overlayPopups > input.hide").change();
	});
</script>
<script type="text/javascript">
	//点击项目框，
	<?php  /*获取 project List*/?>
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	cw.ec("#<?php echo $id?> > div.header-button.projectList",function(){
		if($("#<?php echo $id?> > div.pop-up.projectList").css("display") == "none")
		{
			<?php echo $id?>getProjectList();
			$("#<?php echo $id?> > div.pop-up.projectList").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.projectList").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
	function <?php echo $id?>getProjectList()
	{
		<?php /*全部更新*/ ?>
		/*
		var data = {};
		$("#<?php echo $id?> > div.pop-up.projectList > div.content").html("<div class='wrapLoading'><div class='loading'></div></div>");
		//alert("h");
		cw.post(cw.url+"getProjectList",data,function(result){
			//alert(result.length);
			$("#<?php echo $id?> > div.pop-up.projectList > div.content").html("");
			$.each(result,function(index,item){
				$("#<?php echo $id?> > div.pop-up.projectList > div.content").prepend(<?php echo $id?>makeProject(item.name,item.intro,item.id));			
			});
			//检查项目列表是否过长
				//不检查，直接获取窗口高度，然后设置max-height
				var totalHeight = $(window).height();
				var otherHeight = 45+50+25;
				var projectListHeight = totalHeight-otherHeight;
				$("#<?php echo $id?> > div.pop-up.projectList > div.content").css("maxHeight",projectListHeight+"px");
			
		});
		*/
		<?php /*增量更新*/ ?>
		var data = {};
		//alert("h");
		cw.post(cw.url+"getProjectList",data,function(result){
			//alert(result.length);
			//第一次载入
			if($("#<?php echo $id?> > div.pop-up.projectList > div.content > div.wrapLoading").length != 0)
			{
				$("#<?php echo $id?> > div.pop-up.projectList > div.content").html("");
			}
			$.each(result,function(index,item){
				//当此projectId不存在 ,添加到rank比其小的第一个去
				if($("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block > input.projectId[value='"+item.id+"']").length == 0)
				{
					//$("#<?php echo $id?> > div.pop-up.projectList > div.content").prepend(<?php echo $id?>makeProject(item.name,item.intro,item.id,item.rank));
						var ltIndex=0;//比其小的project的index
						$("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block").each(function(){
							if($(this).children("input.rank").val() <= item.rank)
							{
								return false;
							}
							ltIndex++;
						});
						if(ltIndex == $("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block").length)
						{
							$("#<?php echo $id?> > div.pop-up.projectList > div.content").append(<?php echo $id?>makeProject(item.name,item.intro,item.id,item.rank));
						}
						else
						{
							<?php echo $id?>makeProject(item.name,item.intro,item.id,item.rank).insertBefore($("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block").eq(ltIndex));
						}
					}
				else
				{
					//更新projectname,intro
					$("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block > input.projectId[value='"+item.id+"']").parent()
						.children("input.name").val(item.name).end()
						.children("input.intro").val(item.intro).end()
						.children("input.rank").val(item.rank).end()
						.children("div.projectName").html(item.name).end();
						//.children("div.projectIntro").html(item.intro);
				}
			});
			var totalHeight = $(window).height();
				var otherHeight = 45+50+25;
				var projectListHeight = totalHeight-otherHeight;
				$("#<?php echo $id?> > div.pop-up.projectList > div.content").css("maxHeight",projectListHeight+"px");
		});
	}
	function <?php echo $id?>makeProject(name,intro,projectId,rank)
	{
		return $('<div class="block">'+
			'<input class="projectId" type="hidden" value="'+projectId+'"></input>'+
			'<input class="name" type="hidden" value="'+name+'"></input>'+
			'<input class="rank" type="hidden" value="'+rank+'"></input>'+
			'<input class="intro" type="hidden" value="'+intro+'"></input>'+
			'<div class="projectName">'+name+'</div>'+
			//'<div class="projectIntro">'+intro+'</div>'+
		'</div>');
	}
	//点击project
	cw.ec("#<?php echo $id?> > div.pop-up.projectList > div.content > div.block",function(){
		var projectId = $(this).children("input.projectId").val();
		var projectName = $(this).children("input.name").val();
		var projectIntro = $(this).children("input.intro").val();
		<?php if($targetProjectName != ""){ ?>
			$("<?php echo $targetProjectName;?>").val(projectName);
		<?php } ?>
		<?php if($targetProjectIntro != ""){ ?>
			$("<?php echo $targetProjectIntro;?>").val(projectIntro);
		<?php } ?>
		$("<?php echo $targetProjectId;?>").val(projectId);
		<?php foreach($targetChangeP as $one){ ?>
				$("<?php echo $one;?>").change();
		<?php } ?>
		//关闭此框
		$("#<?php echo $id?> > div.pop-up.projectList").hide();
		$("#overlayPopups > input.hide").change();
	});
</script>
<script type="text/javascript">
	//点击首logo的事件
	cw.ec("#<?php echo $id?> > a.logo",function(e){
		e.preventDefault();
		//window.location.reload();
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application","_self");
		/*
		<?php foreach($headerChange as $one){ ?>
				$("<?php echo $one;?>").change();
		<?php } ?>
		//隐藏返回
		$("#<?php echo $id?> > div.back").hide();
		*/
	});
</script>
<script type="text/javascript">
	//点击profile
	cw.ec("#<?php echo $id?> > div.header-button.profile",function(){
		//alert("a");
		if($("#<?php echo $id?> > div.pop-up.profile").css("display") == "none")
		{
			//把profile内所有inpop-up 隐藏,显示按钮
			$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up").hide();
			$("#<?php echo $id?> > div.pop-up.profile > div.list a").show();
			$("#<?php echo $id?> > div.pop-up.profile > div.back").hide();
			$("#<?php echo $id?> > div.pop-up.profile").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.profile").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
	//点击to,打开inpop-up
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to",function(){
		$(this).parent().children("div.inpop-up").show()
			.find("input").eq(0).focus();
		$(this).parent().parent().find('a').hide();
		//显示返回按钮
		$("#<?php echo $id?> > div.pop-up.profile > div.back").show();
	});
	//inpop-up 返回
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.back",function(){
		//把profile内所有inpop-up 隐藏,显示按钮
		$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up").hide();
		$("#<?php echo $id?> > div.pop-up.profile > div.list a").show();
		$(this).hide();
	});
	//确认修改名字 
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changeName > div.ok",function(){
		var data = {};
		data.nickname = $(this).parent().children("input.nickname").val();
		if(data.nickname == "")
		{
			return false;
		}
		cw.post(cw.url+"changeNickname",data,function(result){
		
		});
		$("#<?php echo $id?> > div.pop-up.profile").children("input.nickName").val(data.nickname).end()
			.children("div.title").html(data.nickname);
		$("#<?php echo $id?> > div.header-button.profile > span.header-text").html(data.nickname);
		//触发返回
		$("#<?php echo $id?> > div.pop-up.profile > div.back").trigger(cw.ectype);
	});
	//确认修改密码 
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.ok",function(){
		
		var data = {};
		data.oldPw = $(this).parent().find("div.line > div.right > input.oldPw").val();
		data.newPw = $(this).parent().find("div.line > div.right > input.newPw").val();
		data.newPw1 = $(this).parent().find("div.line > div.right > input.newPw2").val();
		if($(this).hasClass("disabled") || (data.oldPw == "") || (data.newPw == ""))
		{
			return false;
		}
		if(data.newPw != data.newPw1)
		{
			setPwAlert("Passwords are not the same.");
			return;
		}
		//不检查格式了
		
		$(this).addClass("disabled").html("Sending request...");
		setPwAlert('<div class="wrapLoading"><div class="loading"></div></div>',true);
		cw.post(cw.url+"changePw",data,function(result){
			$(this).removeClass("disabled").html("OK");
			//
			if(result.error == 1)
			{
				setPwAlert("Original password is not correct.");
			}
			else
			{
				setPwAlert("Success");
				$(this).parent().find("input").val("");
			}
		},$(this));
	});
	function setPwAlert(str)
	{
		var noErase = arguments[1]?arguments[1]:false;
		$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.line > div.alertpw").html(str);
		if(!noErase)
		{
			setTimeout(function(){
				$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.line > div.alertpw").html("");
			},3000);		
		}
	}
</script>
<script type="text/javascript">
	//点击人力资源
	cw.ec("#<?php echo $id?> > div.header-button.humanResource",function(){
		if($("#<?php echo $id?> > div.pop-up.humanResource").css("display") == "none")
		{		
			//载入人力资源
			$("#<?php echo $id?> > div.pop-up.humanResource > input.loadHR").change();
			$("#<?php echo $id?> > div.pop-up.humanResource").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.humanResource").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
</script>
<script type="text/javascript">
	//显示返回按钮
	cw.ech("#<?php echo $id?> > input.showBack",function(){
		//alert("ss");
		$("#<?php echo $id?> > div.back").show();
	});
	//点击返回
	cw.ec("#<?php echo $id?> > div.back",function(){
		$("#<?php echo $id?> > a.logo").trigger(cw.ectype);
	});
	cw.ech("#<?php echo $id?> > input.closePopup",function(){
		//alert('d');
		$("#<?php echo $id?> > div.pop-up").hide();
	});
	//点击logo
	cw.ec("#<?php echo $id?> > a.logo",function(){
		window.location.hash = "";
	});
</script>
<script type="text/javascript">
	//进入页面获取提醒数量
	$(document).ready(function(){
		//getRemindSum();
	});
	//轮训获取提醒数量
	/*
	setInterval(function(){
		getRemindSum();
	},20000);//20秒
*/
	function getRemindSum()
	{
		var data = {};
		data.userId = "a";
		//setRemindSum(1);
		cw.post(cw.url+"getRemindSum",data,function(result){
			setRemindSum(result.remindSum);
			
		});
	}
	function setRemindSum(number)
	{
		if(number > 0)
		{
			highlight($("#<?php echo $id?> > div.header-button.remind"));
			$("#<?php echo $id?> > div.header-button.remind > div.remindSum").show().html(number);
		}
		else
		{
			dehighlight($("#<?php echo $id?> > div.header-button.remind"));
			$("#<?php echo $id?> > div.header-button.remind > div.remindSum").hide();
		}
	}
	function highlight(object)
	{
		object.addClass("highlight");
	}
	function dehighlight(object)
	{
		object.removeClass("highlight");
	}
	
	//点击消息
	cw.ec("#<?php echo $id?> > div.header-button.remind",function(){
		//显示
		if($("#<?php echo $id?> > div.pop-up.remind").css("display") == "none")
		{
			setRemindSum(0);
			getRemind();
			$("#<?php echo $id?> > div.pop-up.remind").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			//关闭弹出
			$("#<?php echo $id?> > div.pop-up.remind").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
	function getRemind()
	{
		//获取消息详情
		var data = {};
		cw.post(cw.url+"getReminds",data,function(result){
			//原来是载入中或者没有更多，就清除
			if($("#<?php echo $id?> > div.pop-up.remind > div.content > div.wrapLoading").length > 0)
			{
				$("#<?php echo $id?> > div.pop-up.remind > div.content").html("");
			}
			//没有提醒且原来是空白的
			if((result.reminds.length == 0) && ($("#<?php echo $id?> > div.pop-up.remind > div.content > div.block").length == 0))
			{
				setRemindNoMore();
			}
			$.each(result.reminds,function(index,item){
				//先检查有没重复
				if($("#<?php echo $id?> > div.pop-up.remind > div.content > div.block > input.remindId[value='"+item.remindId+"']").length == 0)
				{
					var newBlock = cw.parseRemind(item);
					$("#<?php echo $id?> > div.pop-up.remind > div.content").prepend(newBlock);
				}
			});
		});
	}
	//删除此提醒
	cw.ec("#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.delete",function(){
		$(this).parent().remove();
		//空了就加“没有更多了”
		if($("#<?php echo $id?> > div.pop-up.remind > div.content > div.block").length == 0)
		{
			setRemindNoMore();
		}
	});
	function setRemindNoMore()
	{
		$("#<?php echo $id?> > div.pop-up.remind > div.content").html("<div class='wrapLoading'>"+
					"<span style='color:gray'>没有更多了</span>"+
				"</div>");
	}
	// click help
	cw.ec("#<?php echo $id?> > div.header-button.help",function(){
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cHelp","_self");
	});
</script>
<div class="makeupspace"></div>
<div id="<?php echo $id;?>">
	<?php $this->widget("OverlayWidget",array(
			"zindex" => "998",
			"id" => "overlayPopups",
			"transparent" => true,
			"targetSelector" => "#".$id." > input.closePopup",
		));?>
	<input class="closePopup" type="hidden"></input>
	<input class="showBack" type="hidden"></input>
	<input class="loading" type="hidden"></input>
	<input class="stopLoading" type="hidden"></input>
	<a class="logo" title="home" href="<?php echo Yii::app()->baseUrl;?>/index.php/application">
		VERA<sup style="font-size:50%;vertical-align:super">Alpha</sup>
	</a>
	<span class="loading" style="display:none"></span>
	<?php /*按钮，全部float*/ 
	?>
	<!--
	<div class="header-button projectList">
		<span class="header-icon"><i class="icon-th-large icon-white"></i></span>
		<span class="header-text">项目列表</span>
	</div>
	-->
	<div class="back">
		<i class="icon-chevron-left"></i>
	</div>	
	<!--
	<div class="header-button humanResource">
		<span class="header-icon"><i class="icon-globe icon-white"></i></span>
		<span class="header-text"><?php echo t::o("Human Resource")?></span>
	</div>
	-->
	<!--
	<div class="header-button">
		<span class="header-icon"><i class="icon-search icon-white"></i></span>
		<span class="header-text">
			<input class='search' ></input>
		</span>
	</div>	
	-->
	<div class="header-button right profile">
		<span class="header-icon"><i class="icon-th-large icon-white"></i></span>
		<span class="header-text">Account</span>
	</div>
	<a class="header-button right help" href="<?php echo Yii::app()->baseUrl?>/index.php#guide">
		<span class="header-icon"><i class="icon-exclamation-sign icon-white"></i></span>
		<span class="header-text">User Guide</span>
	</a>
	<!--
	<div class="header-button right remind">
		<div class="remindSum"></div>
		<span class="header-icon"><i class="icon-bell icon-white"></i></span>
		<span class="header-text"><?php echo t::o("Message"); ?></span>
	</div>
	-->
	<?php if($userLevel == 3){ //高级用户 ?>
	<!--
	<div class="header-button right new">
		<span class="header-icon"><i class="icon-plus icon-white"></i></span>
		<span class="header-text">新增</span>
	</div>
	-->
	<?php } ?>
	
	<?php /*下面是各种弹出框*/ ?>
	<div class="pop-up remind">
		<div class="delete close">&times;</div>
		<div class="title"><?php echo t::o("Message"); ?></div>
		<div class="content"><div class='wrapLoading'><div class='loading'></div></div></div>
	</div>
	<?php if($userLevel == 3){ //高级用户 ?>
	<!--
	<div class="pop-up new">
		<div class="delete close">&times;</div>
		<div class="addwhat pop-up-item">
			<div class="title">新增</div>
			<div class="body">
				<div class="block project">
					<div class="title">项目</div>
					<div class="subTitle">新的项目...</div>
				</div>
			</div>
		</div>
		<div class="addProject pop-up-item">
			<div class="title">新增项目</div>
			<div class="body">
				<div class="title">项目名</div>
				<div class="line">
					<input class="projectName" type="text"></input>
				</div>
				<div class="line">
					<div class="btn btn-primary create">建立</div>
				</div>
			</div>
		</div>
	</div>
	-->
	<?php } ?>
	<!--
	<div class="pop-up projectList">
		<div class="delete close">&times;</div>
		<div class="title">项目列表</div>
		<div class="content"><div class='wrapLoading'><div class='loading'></div></div></div>
	</div>
	-->

	<div class="pop-up humanResource">
		<div class="delete close">&times;</div>
		<div class="title"><?php echo t::o("Human Resource"); ?></div>
		<input class="loadHR" type="hidden"></input>
		<div class="content">
			<?php 
			/*
				$this->widget("HumanResourceWidget",array(
					"id" => $id."humanResource",
					//监听载入
					"listen" => "#".$id." > div.pop-up.humanResource > input.loadHR",
					//有修改功能
					"canEdit" => true,
					"noHeader" => true,
				));
				*/
			?>
		</div>
	</div>
	<div class="pop-up profile">
		<div class="close back"><i class="icon-chevron-left"></i></div>
		<div class="delete close">&times;</div>
		<div class="title"><?php echo $username;?></div>
		<input class="nickName" type="hidden" value="<?php echo $username;?>"></input>
		<div class="list">
			<div class="block">
				<a class="to" href="#"><?php echo t::o("Change Nickname"); ?></a>
				<div class="changeName inpop-up">
					<input class="input-medium nickname" type="text" value="<?php echo $username;?>"></input>
					<div class="btn ok"><?php echo t::o("OK"); ?></div>
				</div>
			</div>
			<div class="block">
				<a class="to" href="#"><?php echo t::o("Change Password"); ?></a>
				<div class="changePw inpop-up">
					<div class="line">
						<div class="left"><?php echo t::o("Original"); ?>: </div>
						<div class="right">
							<input class="input-medium oldPw" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="left"><?php echo t::o("New"); ?>: </div>
						<div class="right">
							<input class="input-medium newPw" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="left"><?php echo t::o("Again"); ?>: </div>
						<div class="right">
							<input class="input-medium newPw2" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="alertpw"></div>
					</div>
					<div class="btn btn-block ok"><?php echo t::o("OK"); ?></div>
				</div>
			</div>
			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/application/cWatch"><?php echo t::o("Watch Video Pairs"); ?></a>
			<!--<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/application/cGunshot"><?php echo t::o("gunshot detection"); ?></a>-->
			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/user/logout"><?php echo t::o("Logout"); ?></a>
		</div>
	</div>

</div>