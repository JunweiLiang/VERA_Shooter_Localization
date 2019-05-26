<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	/*
		userManage,去掉说说功能，评论文章的权限设置，分栏目管理
	*/
	
?>
<style type="text/css">
	#<?php echo $id;?>{
		height:auto!important;
		height:550px;
		min-height:550px;
	}
	#<?php echo $id;?> div.line{padding:5px 10px}
	#<?php echo $id;?> #newUserDiv{padding-top:5px}
	#<?php echo $id;?> #leftCtrlDiv{float:left;width:300px;position:relative}
	#<?php echo $id;?> div.right{margin:0 0 0 300px;padding:20px 0 5px 10px}
	#<?php echo $id;?> #leftCtrlDiv #ctrlPanel{padding:20px 0 0 10px}
	#<?php echo $id;?> select{margin:0;width:200px}
	#<?php echo $id;?> #userListDiv{margin:0 0 0 301px;border-left:1px solid #F5D8DB;}
		#<?php echo $id;?> #userListDiv a{padding:5px 10px;line-height:20px}
	#<?php echo $id;?> #userListDiv ul{display:block;padding:0;margin:0;overflow:hidden/*!important to kill bootstrap!*/}
	#<?php echo $id;?> #userListDiv li{padding:0;margin:0;}
	/*reset some bootstrap class*/
	#<?php echo $id;?> .hero-unit{display:none;padding:5px;margin:0}
	#<?php echo $id;?> .alert{margin:0}
	#<?php echo $id;?> div.cataList{
		overflow:auto;
		height:200px;
		border:solid 1px silver;
		border-width:1px 0;
		background-color:rgb(245,245,245);
	}
	#<?php echo $id;?> > #leftCtrlDiv > div.uLoading{
		padding:150px 0;
		height:200px;
		width:100%;
		background-color:silver;
		opacity:0.7;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=70);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; /*IE8*/
		position:absolute;top:0;left:0;
		z-index:990;
}
</style>
<div id="<?php echo $id;?>">
<div id="leftCtrlDiv">
	<div class="uLoading" style="display:none">
		<div class="wrapLoading">
			<div class="loading"></div>
		</div>
	</div>
	<div id="ctrlPanel">
		<span class="label label-info">Add New User</span>
	</div>
	<div id="newUserDiv">
		<div class="line">
			<span style="padding-left:0" class="help-inline">Username:</span> <input type="text" style="margin:0;width:200px" class="input-medium userName" placeholder="" value=""></input>
		</div>
		<div class="line">
			<span style="padding-left:0" class="help-inline">Password:</span> <input type="text" style="margin:0;width:200px" class="input-medium userPw" placeholder="Will be 123456 if left empty" value=""></input>
		</div>
		<?php if($isSuper){ ?>
		<div class="line">
			<label class="checkbox inline">
				<input type="checkbox" class="isSuper"></input> Super Manager
			</label>
		</div>
		<?php } ?>
		<div class="line">		
			<label class="checkbox inline">
				<input type="checkbox" class="isUM"></input> User Manager
			</label>
		</div>
		<div class="line userLevel">		
			<select class="userLevel">
				<option value="0" selected></option>
				<option value="3">Demo User</option>
				<!--<option value="2">普通用户</option>-->
			</select>
		</div>
		<div class="line">
			<div class="btn btn-success btn-block" id="newUserB">Add User</div>
			<div class="btn btn-warning btn-block" id="copyUser">Copy User</div>
			<span id="newUserE"></span>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){		
			getUserList();
	});
	//  copy user to a new one
	cw.ec("#<?php echo $id?> #newUserDiv #copyUser",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var selected = $("#<?php echo $id?> #userListDiv > ul > li.active");
		if(selected.length == 0)
		{
			alert("please select at least one user!");
			return;
		}
		var data = {};
		data.userId = selected.children("input.userId").val();
		data.isUM = selected.children("input.isUM").val();
		data.isSuper = selected.children("input.isSuper").val();
		data.userLevel = selected.children("input.userLevel").val();
		data.userName = selected.children("input.userName").val();
		if((data.userLevel == 0) || (data.isUM != 0) || (data.isSuper != 0))
		{
			alert("You can only copy normal user");
			return;
		}
		data.thisUserName = $(this).parent().parent().find("input.userName").val();
		data.thisUserPw = $(this).parent().parent().find("input.userPw").val();
		if(data.thisUserName == "")
		{
			$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'> Username cannot be empty. </span>");
			setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
			return;
		}
		if(!confirm("Confirm copy "+data.userName+"'s all data to new user:"+data.thisUserName+"?"))
		{
			return;
		}
		$(this).addClass("disabled");
		//先post检查用户名是否重复
		$.post("<?php echo $ifUserNameExistsUrl;?>","userName="+data.thisUserName,function(res){
			//alert(res);
			//return;
			if(res == "error")
			{
				alert("Oops!");
				$("#<?php echo $id;?> #newUserDiv #copyUser").removeClass("disabled");
				return;
			}
			if(res == "true")
			{
				$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'>This username has been taken！</span>");
				setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
				$("#<?php echo $id;?> #newUserDiv #copyUser").removeClass("disabled");
				return;
			}
			var selected = $("#<?php echo $id?> #userListDiv > ul > li.active");
			if(selected.length == 0)
			{
				alert("please select at least one user!");
				return;
			}
			var data = {};
			data.userId = selected.children("input.userId").val();
			data.isUM = selected.children("input.isUM").val();
			data.isSuper = selected.children("input.isSuper").val();
			data.userLevel = selected.children("input.userLevel").val();
			data.thisUserName = $("#newUserDiv").find("input.userName").val();
			data.thisUserPw = $("#newUserDiv").find("input.userPw").val();
			if((data.userLevel == 0) || (data.isUM != 0) || (data.isSuper != 0))
			{
				alert("you can only copy normal client");
				return;
			}
			$.post("<?php echo $copyUserUrl;?>", data, function(result){
				$("#<?php echo $id;?> #newUserDiv #copyUser").removeClass("disabled");
				//alert(result);
				if(result.status != 0)
				{
					alert("Oops! "+result.error);
					return;
				}
				$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'>Success!</span>");
				setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
				getUserList();
				//清理新建用户的div
				$("#<?php echo $id;?> #newUserDiv :checkbox").prop("checked",false);
				$("#<?php echo $id;?> #newUserDiv div.line.JM").hide();
				$("#<?php echo $id;?> #newUserDiv div.alert").remove();
				$("#<?php echo $id;?> #newUserDiv .addC2M").addClass("disabled");
				$("#<?php echo $id;?> #newUserDiv .userName").val("");
			},"json");
		});
	});
	//定义“新增用户”/"保存修改"按钮
	$(document).delegate("#<?php echo $id;?> #newUserDiv #newUserB,#<?php echo $id;?> #userListDiv div.save","click",function(){
		var data = {
			'isUM':0,
			<?php if($isSuper){ ?>
				'isSuper':0,
				'userLevel':0,
			<?php } ?>
			'userId':[],'userName':[]};
		if($(this).parent().parent().find(".isUM").is(":checked"))
		{
			data.isUM = 1;
		}
		<?php if($isSuper){ ?>
		if($(this).parent().parent().find(".isSuper").is(":checked"))
		{
			data.isSuper = 1;
		}
		
		//用户级别
		data.userLevel = $(this).parent().parent().find("select.userLevel > option:selected").val();
		//alert(data.userLevel);
		<?php } ?>
		if($(this).hasClass("save"))//保存修改 按钮//点击时禁用此按钮与“删除”按钮
		{
			if(!$(this).hasClass("disabled"))
			{
				$(this).parent().children('div.btn').addClass("disabled");
				data.userId = getNum($(this).parent().parent().children("input.userId").val());
				$.post("<?php echo $changeUserUrl;?>",data,function(result){
				//alert(result);
				if(result == "error")
				{
					alert("Oops!");
					return;
				}
				getUserList();
			});
			}
		}
		else
		{
			//新建用户，检查用户名是否输入
			if(!$(this).hasClass("disabled"))
			{
				$(this).addClass("disabled");
				data.userName = $(this).parent().parent().find("input.userName").val();
				data.userPw = $(this).parent().parent().find("input.userPw").val();
				if(data.userName == "")
				{
					$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'>Username cannot be empty</span>");
					setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
					$(this).removeClass("disabled");
					return;
				}
				//先post检查用户名是否重复
				$.post("<?php echo $ifUserNameExistsUrl;?>","userName="+data.userName,function(res){
					//alert(res);
					//return;
					if(res == "error")
					{
						alert("Oops!");
						$("#<?php echo $id;?> #newUserDiv #newUserB").removeClass("disabled");
						return;
					}
					if(res == "true")
					{
						$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'> sername has been taken！</span>");
						setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
						$("#<?php echo $id;?> #newUserDiv #newUserB").removeClass("disabled");
						return;
					}
					
					$.post("<?php echo $addUserUrl;?>",data,function(result){
						$("#<?php echo $id;?> #newUserDiv #newUserB").removeClass("disabled");
						//alert(result);
						if(result == "error")
						{
							alert("Oops!");
							return;
						}
						$("#<?php echo $id;?> #newUserE").html("<span class='text-warning'> Success!</span>");
						setTimeout(function(){$("#<?php echo $id;?> #newUserE").html("");},3000);
						getUserList();
						//清理新建用户的div
						$("#<?php echo $id;?> #newUserDiv :checkbox").prop("checked",false);
						$("#<?php echo $id;?> #newUserDiv div.line.JM").hide();
						$("#<?php echo $id;?> #newUserDiv div.alert").remove();
						$("#<?php echo $id;?> #newUserDiv .addC2M").addClass("disabled");
						$("#<?php echo $id;?> #newUserDiv .userName").val("");
					});
				});
				
			}
		}
	});


function getNum(str)
{
	var reg = /^[a-zA-Z]+([0-9]+)$/g;
	return reg.exec(str)[1];
}
</script>
<div class="right">
	<span class="label label-info">User List</span>
</div>
<div id="userListDiv"><div class="loading"></div></div>
</div><!--<?php echo $id;?>-->
<script type="text/javascript">
	//下面是userList脚本
	//点击用户显示
	$(document).delegate("#<?php echo $id;?> #userListDiv a:not(.close)","click",function(e){// 排除掉栏目选择单元中d的a标签
		e.preventDefault();
		//取消所有的active,userSpecific的显示
		$("#<?php echo $id;?> #userListDiv a").not(this).parent().next("div.userSpecific").slideUp(300);
		$("#<?php echo $id;?> #userListDiv a").not(this).parent().removeClass("active");		
		//被点击的项目显示active
		$(this).parent().toggleClass("active").next("div.userSpecific").slideToggle(300);
	});//定义用户列表中用户项点击后动作，显示详细修改信息
	//页面载入就向服务器请求用户列表


function getUserList()
{
	var data = {'get':{'id':'all'}};//实际获取了所有非competitor,非judge的用户
	//清除原来d的用户列表,设置为载入图标
	$("#<?php echo $id;?> #userListDiv").html("<div class='loading'></div>");
	$.post("<?php echo $getUserUrl;?>",data,function(res){
		//alert(res);		
		$("#<?php echo $id;?> #userListDiv").empty().append(parseUser(res));					
	},"json");
}
function parseUser(data)//data为json,返回<ul>
{
	<?php
		/*
			对于第一个数据(即用户管理者本人)只构造查看，不允许修改
		*/
	?>
	//data中有CatalogArr,每个元素有CM,CHM,WM,JM标识
	var res = $("<ul class='nav nav-pills nav-stacked'></ul>");
	$.each(data,function(key,item){
		var tempLi = $("<li></li>");
		tempLi.append("<input class='userId' type='hidden' value='"+item.userId+"'></input>");
		tempLi.append("<input class='isUM' type='hidden' value='"+item.isUM+"'></input>");
		tempLi.append("<input class='isSuper' type='hidden' value='"+item.isSuper+"'></input>");
		tempLi.append("<input class='userName' type='hidden' value='"+item.userName+"'></input>");
		tempLi.append("<input class='userLevel' type='hidden' value='"+item.userLevel+"'></input>");
		if(key == 0)//不能修改自己的权限
		{
			//每个数据构造一对<li></li><div></div>

		var tempA = $("<a href='#'></a>").attr('id','u'+item.userId).html(item.userName);
		var tempSpan = $(" <div style='font-size:12px;color:silver'></div>");	
		
		//第3
		if(item.isUM == 1)
		{
			tempSpan.html(tempSpan.html()+"User Manager ");
		}
		if(item.isSuper == 1)
		{
			tempSpan.html(tempSpan.html()+"Super Manager ");
		}
		
		
		tempSpan.appendTo(tempA);
		tempA.appendTo(tempLi);
		tempLi.appendTo(res);
		}
		else
		{
		//每个数据构造一对<li></li><div></div>
		//var tempLi = $("<li></li>");
		var tempDiv = $("<div  class='userSpecific hero-unit'></div>");
		var tempA = $("<a href='#'></a>").attr('id','u'+item.userId).html(item.userName);
		var tempSpan = $(" <div style='font-size:12px;color:silver'></div>");		
			
		//第3
		
		<?php if($isSuper){ ?>
		
		var tempLine = $("<div class='line'></div>");
		if(item.isSuper == 1)
		{
			var tempInput = $("<input type='checkbox' class='isSuper'></input>")
			.prop('checked',true);
			tempSpan.html(tempSpan.html()+"Super Manager ");
		}
		else
		{
			var tempInput = $("<input type='checkbox' class='isSuper'></input>")
			.prop('checked',false);
		}
		var tempLabel = $("<label class='checkbox inline'></label>")
			.append(tempInput)
			.append(" Super Manager")
			.appendTo(tempLine);	
		tempDiv.append(tempLine);
		
		
		<?php } ?>
		var tempLine = $("<div class='line'></div>");
		if(item.isUM == 1)
		{
			var tempInput = $("<input type='checkbox' class='isUM'></input>")
			.prop('checked',true);
			tempSpan.html(tempSpan.html()+"User Manager ");
		}
		else
		{
			var tempInput = $("<input type='checkbox' class='isUM'></input>")
			.prop('checked',false);
		}
		var tempLabel = $("<label class='checkbox inline'></label>")
			.append(tempInput)
			.append(" User Manager")
			.appendTo(tempLine);		
		tempDiv.append(tempLine);
		<?php if($isSuper){ ?>
			
		var tempLine = $("<div class='line userLevel'></div>");
		var tempSelectU = $('<select class="userLevel">'+
				'<option value="0" selected></option>'+
				'<option value="3">Demo User</option>'+
				//'<option value="2">普通用户</option>'+
			'</select>');
		tempSelectU.find("option[value='"+item.userLevel+"']").prop("selected",true);
		tempSelectU.appendTo(tempLine);
		if(item.userLevel != 0)
		{
			if(item.userLevel == 2)
			{
				tempSpan.html(tempSpan.html()+"Demo User ");
			}
			else if(item.userLevel == 3)
			{
				tempSpan.html(tempSpan.html()+"High-level User ");
			}
		}
						
		tempDiv.append(tempLine);
		
		<?php } ?>
		
		//添加保存按钮
		tempDiv.append($('<div class="line"><div class="btn btn-success save">Save</div> <div class="btn cancel">Cancel</div> <div class="btn delete btn-danger">Delete</div> <div class="btn resetPw btn-info">Reset Password</div></div>'))
		//添加存储用户id信息的input
		.append($('<input type="hidden" class="userId" value="u'+item.userId+'"></input>'));
		
		tempSpan.appendTo(tempA);
		tempA.appendTo(tempLi);
		tempLi.appendTo(res);
		tempDiv.appendTo(res);
		}
	});
	return res;
}
//定义删除按钮行为
$(document).delegate("#<?php echo $id;?> #userListDiv div.delete","click",function(){
	//获得该用户id
	if(!$(this).hasClass('disabled'))
	{
		//$(this).addClass('disabled');
		if(!confirm("Confirm deleting?"))
		{
			return;
		}
		$(this).parent().children('div.btn').addClass("disabled");
		var userId = getNum($(this).parent().next("input.userId").val());
		var data = {'delete':{'userId':userId}};
		$.post("<?php echo $deleteUserUrl;?>",data,function(result){
			//alert(result);
				if(result == "error")
				{
					alert("Oops!");
					return;
				}
			getUserList();
		});
	}
});
//定义“密码重置”
$(document).delegate("#<?php echo $id;?> #userListDiv div.resetPw","click",function(){
	//获得该用户id
	if(!$(this).hasClass('disabled'))
	{
		//$(this).addClass('disabled');
		if(!confirm("Confirm reset password to 123456?"))
		{
			return;
		}
	//	$(this).parent().children('div.btn').addClass("disabled");
		var userId = getNum($(this).parent().next("input.userId").val());
		var data = {'resetPw':{'userId':userId}};
		$.post("<?php echo $resetPwUserUrl;?>",data,function(result){
			//alert(result);
				if(result == "error")
				{
					alert("Oops!");
					return;
				}
			//
			if(result == "ok")
			{
				alert("Success");
			}
			
		});
	}
});
//定义“取消”按钮行为
$(document).delegate("#<?php echo $id;?> #userListDiv div.cancel","click",function(){
	//收起该block
	//$(this).parent().parent().prev("li").children('a').click();
	//直接重新获取用户列表
	if(!$(this).hasClass('disabled'))
	{
		getUserList();
	}
});
function <?php echo $id;?>hideLoading()
{
	$("#<?php echo $id;?> > #leftCtrlDiv > div.uLoading").hide();
}
</script>