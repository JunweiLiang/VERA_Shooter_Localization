<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id?> > div.info{
		background-color:<?php echo COLOR1_LIGHTER1;?>;color:white;
		padding:20px;
	}
	#<?php echo $id?> > div.info > div.line{
		padding:3px 0;
	}
	#<?php echo $id?> > div.list > div.block{
		padding:10px;
		cursor:pointer;
		background-color:rgb(250,250,250);
		border-bottom:1px solid silver;
	}
	#<?php echo $id?> > div.list > div.block:hover{
		background-color:rgb(245,245,245);
	}
	#<?php echo $id?> > div.list > div.block > div.line{
		padding:3px 0;
	}
	#<?php echo $id?> > div.list > div.block > div.workSum{
		color:gray;
	}
	#<?php echo $id?> > div.list > div.block.toggle{
		background-color:#0088cc;
		color:white;
	}
</style>
<script type="text/javascript">
//链接方法
$(document).delegate("#<?php echo $id?> > input.locationId","change",function(){
	$("#<?php echo $id?> > input.catalogId").change();
});
$(document).delegate("#<?php echo $id?> > input.workSubTypeId","change",function(){
	$("#<?php echo $id?> > input.catalogId").change();
});
//主响应方法
$(document).delegate("#<?php echo $id?> > input.catalogId","change",function(){
	//检查其它过滤器是否空
	if(
		($("#<?php echo $id?> > input.catalogId").val() == "") ||
		($("#<?php echo $id?> > input.locationId").val() == "") ||
		($("#<?php echo $id?> > input.workSubTypeId").val() == "")
	)
	{
		return false;
	}
	//alert("aa");
	var data = {};
	data.catalogId = $(this).val();
	data.locationId = $("#<?php echo $id?> > input.locationId").val();
	data.workSubTypeId = $("#<?php echo $id?> > input.workSubTypeId").val();
	<?php echo $id?>showLoading();
	//清空list
	$("#<?php echo $id?> > div.list").html("");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitorManage/getList",data,function(result){
		//alert(result);
		<?php echo $id;?>hideLoading();
		<?php if($showHead){ ?>
		$("#<?php echo $id;?> > div.info > div.line > span.userSum").html(result.info.userSum);
		$("#<?php echo $id;?> > div.info > div.line > span.submitWorkSum").html(result.info.submitWorkSum);
		<?php } ?>
		<?php if($hasAll){ ?>
			//在头部显示一项"全部"
			$("#<?php echo $id;?> > div.list").append('<div class="block">'+
				'<input class="userId" type="hidden" value="all"></input>'+
				'<input class="userName" type="hidden" value="all"></input>'+
				'<div class="line">全部</div>'+
			'</div>');
		<?php } ?>
		$.each(result.list,function(index,item){
			userName = item.nickName==""?item.userName:item.nickName;
			$("#<?php echo $id;?> > div.list").append('<div class="block">'+
				'<input class="userId" type="hidden" value="'+item.userId+'"></input>'+
				'<input class="userName" type="hidden" value="'+userName+'"></input>'+
				'<div class="line">'+item.school+' : '+userName+'</div>'+
				<?php if($showSum){ ?>
					'<div class="line workSum">作品提交总数: '+item.submitWorkSum+'</div>'+
				<?php } ?>
			'</div>');
		});
	},'json');
	<?php if($showSchool){ ?>
	//获取学校信息
	<?php echo $id;?>getSchoolInfo(data);
	<?php } ?>
});
//主扩展方法
$(document).delegate("#<?php echo $id?> > div.list > div.block","click",function(){
	var userId = $(this).children("input.userId").val();
	var userName = $(this).children("input.userName").val();
	<?php foreach($targetArr as $one){ ?>
		<?php if(isset($one['userName'])){ ?>
			$("<?php echo $one['userName']?>").val(userName);
		<?php } ?>
		<?php if(isset($one['userId'])){ ?>
			$("<?php echo $one['userId']?>").val(userId);
			$("<?php echo $one['userId']?>").change();
		<?php } ?>
	<?php } ?>
	<?php if($toggle){ ?>
		//取消其他项的高亮
		$("#<?php echo $id?> > div.list > div.block").removeClass("toggle");
		//高亮此选择
		$(this).addClass("toggle");
	<?php } ?>
});
<?php if($showHead){ ?>
<?php if($showSchool){ ?>
//点击重新统计
$(document).delegate("#<?php echo $id?> > div.info > div.line > div.recount","click",function(){
	var data = {};
	data.catalogId = $("#<?php echo $id?> > input.catalogId").val();
	data.locationId = $("#<?php echo $id?> > input.locationId").val();
	data.workSubTypeId = $("#<?php echo $id?> > input.workSubTypeId").val();
	data.recount = 1;
	<?php echo $id?>getSchoolInfo(data);
});
function <?php echo $id?>getSchoolInfo(filter)
{
	<?php echo $id?>showSchoolLoading();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitorManage/getSchoolInfo",filter,function(result){				
		//alert(result);
		//清空
		$("#<?php echo $id?> > div.info > div.school").html("");
		<?php echo $id?>hideSchoolLoading();
		$.each(result,function(index,item){
			$("#<?php echo $id?> > div.info > div.school").append('<div class="block">'+
				'<div class="line">'+item.school+'('+item.schoolSum+')</div>'+
			'</div>');
		});
		$("#<?php echo $id?> > div.info > div.line > span.schoolSum").html(result.length);
		if(result.length != 0)
		{
			$("#<?php echo $id?> > div.info > div.line > span.logTime").html(result[0].createTime);
		}
		else
		{
			$("#<?php echo $id?> > div.info > div.line > span.logTime").html("");
		}
	},'json');
}
function <?php echo $id?>showSchoolLoading()
{
	$("#<?php echo $id;?> > div.info > div.line > div.recount").html(
		'<div class="loading"></div>'
	).addClass("disabled");
}
function <?php echo $id?>hideSchoolLoading()
{
	$("#<?php echo $id;?> > div.info > div.line > div.recount").html(
		'重新统计'
	).removeClass("disabled");
}
//收起、展开学校统计
$(document).delegate("#<?php echo $id?> > div.info > div.line > div.school","click",function(){
	if($(this).hasClass("up"))
	{
		//收起
		$("#<?php echo $id?> > div.info > div.school").slideUp();
		$(this).removeClass("up").addClass("down").html("展开");
	}
	else
	{
		//展开
		$("#<?php echo $id?> > div.info > div.school").slideDown();
		$(this).removeClass("down").addClass("up").html("收起");
	}
});
<?php } ?>
<?php } ?>
function <?php echo $id?>showLoading()
{
	$("#<?php echo $id?> > div.wrapLoading").show();
}
function <?php echo $id?>hideLoading()
{
	$("#<?php echo $id?> > div.wrapLoading").hide();
}

</script>
<div id="<?php echo $id?>">
	<input class="catalogId" value="<?php echo $initCatalog;?>" type="hidden"></input>
	<input class="locationId" value="<?php echo $initLocation;?>" type="hidden"></input>
	<input class="workSubTypeId" value="<?php echo $initWorkSubType;?>" type="hidden"></input>
	<?php if($showHead){ ?>
	<div class="info">
		<div class="line">账号总数:<span class="userSum">0</span></div>
		<div class="line">提交作品总数:<span class="submitWorkSum">0</span></div>
		<?php if($showSchool){ ?>
		<div class="line">学校统计:
			<div class="btn btn-small btn-success recount">重新统计</div>
			<div class="btn btn-small school up">收起</div>
		</div>
		<div class="line">
			学校总数: <span class="schoolSum"></span> 
			统计时间: <span class="logTime"></span>
		</div>
		<div class="school">
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	<div class="wrapLoading"><div class="loading"></div></div>
	<div class="list"></div>
</div>