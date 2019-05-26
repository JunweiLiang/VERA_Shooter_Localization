<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id;?> > div.main{
	padding-top:20px;
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
#<?php echo $id;?> > div.ctr{
	background-color:rgb(240,240,240);
	padding:5px;
}
#<?php echo $id;?> > div.ctr > div.line{
	height:30px;
	padding:5px 0;
}
#<?php echo $id;?> > div.ctr > div.line > div.order{
	float:left;
	padding:3px;
	width:60px;
	text-align:center;
	cursor:pointer;
	margin-right:10px;
}
#<?php echo $id;?> > div.ctr > div.line > div.order.toggle{
	color:white;
	background-color:rgb(140,0,0);
}
#<?php echo $id;?> > div.main > div.block > div.subTitle{
	color:gray;
	font-size:13px;
}
<?php if($overflowHeight != ""){ ?>
	#<?php echo $id;?> > div.main{
		height:<?php echo $overflowHeight;?>;
		overflow:auto;
	}
<?php } ?>
</style>
<div id="<?php echo $id;?>">
	<input class="blockId" type="hidden" value="<?php echo $blockId?>"></input>
	<?php if($hasInitial){ ?>
	<input class="catalogId" type="hidden" value="all"></input>
	<input class="locationId" type="hidden" value="all"></input>
	<input class="subTypeId" type="hidden" value="all"></input>
	<?php }else{ ?>
	<input class="catalogId" type="hidden" value=""></input>
	<input class="locationId" type="hidden" value="all"></input>
	<input class="subTypeId" type="hidden" value=""></input>
	<?php } ?>
	<input class="competitorId" type="hidden" value="all"></input>
	<?php if(!$noCtr){ ?>
	<div class="ctr">
		<div class="line">
			一次获取:
			<input class="feedNum input-small" type="text" value="<?php echo $feedNum;?>"></input>
			<div class="btn btn-small btn-primary getList">获取列表</div>
		</div>
		<!--
		<div class="line">
			审核状态:
			<select class="checkStatus">
				<option value="all">全部</option>
				<option value="0">等待审核</option>
				<option value="1">不通过</option>
				<option value="2">审核通过</option>
			</select>
		</div>-->
		<div class="line">
			<div class="order asc toggle">ID升序</div>
			<div class="order desc">ID降序</div>
		</div>
	</div>
	<?php } ?>
	<div class="main">	
	</div>
	
	<div class="wrapLoading cLoading"><div class="loading"></div></div>
	
</div>
<script type="text/javascript">
<?php if($instantLoad){ ?>
$(document).ready(function(){
	<?php echo $id;?>startNum = 0;
	//alert("s");
	var data = <?php echo $id;?>getFilterParam();
	for(one in data)
	{
		if((typeof(data[one]) === "string") && (data[one] == ""))//有空的，就不继续执行//0与空字符串相等
		{
			//alert(one);
			//alert(data[one]);
			return;
		}
	}
	//清空
	$("#<?php echo $id?> > div.main").html("");
	<?php echo $id;?>getCheckWorkList(data);
});
<?php } ?>
//绑定关键方法
//input.catalogId change事件
var <?php echo $id;?>startNum = 0;//记录当前结果开始的序号，每次change之后就设置为0
$(document).delegate("#<?php echo $id;?> > input.catalogId","change",function(){
	<?php echo $id;?>startNum = 0;
	//alert("s");
	var data = <?php echo $id;?>getFilterParam();
	for(one in data)
	{
		if((typeof(data[one]) === "string") && (data[one] == ""))//有空的，就不继续执行//0与空字符串相等
		{
			//alert(one);
			//alert(data[one]);
			return;
		}
	}
	//清空
	$("#<?php echo $id?> > div.main").html("");
	<?php echo $id;?>getCheckWorkList(data);
});
function <?php echo $id;?>getCheckWorkList(data)
{
	<?php echo $id;?>showLoading();
	//alert("k");
	$.post("<?php echo $getWorkListUrl;?>",data,function(result){
		//alert(result);
		//alert(result.length);
		if(result.length > 0)
		{
			$.each(result,function(key,item){
				$("#<?php echo $id;?> > div.main").append(<?php echo $id?>makeCheckWorkBlock(item));
				//alert(item.workTitle);
			});
		}
		<?php echo $id;?>hideLoading();
		var feedNum = $("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val() == ""?5:$("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val();
		if(result.length == feedNum)
		{
			//显示获取更多按钮
			$("#<?php echo $id?> > div.main").append('<div class="btn btn-block btn-small getMore">更多</div>');
		}
		<?php echo $id;?>startNum+=result.length;
		<?php
			if($readyFuncName != "")
			{?>
			<?php echo $readyFuncName;?>();
		<?php
			}
		?>
	},'json');
}
//点击查看更多按钮
$(document).delegate("#<?php echo $id;?> > div.main > div.getMore","click",function(){
var data = <?php echo $id;?>getFilterParam();
	for(one in data)
	{
		if((typeof(data[one]) === "string") && (data[one] == ""))//有空的，就不继续执行//0与空字符串相等
		{
			//alert(one);
			//alert(data[one]);
			return;
		}
	}
	$(this).remove();
	<?php echo $id;?>getCheckWorkList(data);
});
//其他input change调用input.catalogId
$(document).delegate("#<?php echo $id;?> > input.locationId,"+
"#<?php echo $id;?> > input.subTypeId,"+
"#<?php echo $id;?> > input.competitorId","change",function(){
	$("#<?php echo $id;?> > input.catalogId").change();
});
//点击其中的一项
$(document).delegate("#<?php echo $id?> > div.main > div.block","click",function(){
	var checkId = $(this).children("input.checkId").val();
	var workTitle = $(this).children("input.workTitle").val();
	var workId = $(this).children("input.workId").val();
	var workSubTypeId = $(this).children("input.workSubTypeId").val();
	var workSubTypeName = $(this).children("input.workSubTypeName").val();
	var workFirstTypeName = $(this).children("input.workFirstTypeName").val();
<?php
			foreach($targetSelector as $one)
			{
				if(!isset($one['checkWorkId']))
				{
					continue;
				}
	?>
			$("<?php echo $one['checkWorkId'];?>").val(checkId);
			<?php if(isset($one['workTitle'])){ ?>
				$("<?php echo $one['workTitle'];?>").val(workTitle);
			<?php } ?>
			<?php if(isset($one['workId'])){ ?>
				$("<?php echo $one['workId'];?>").val(workId);
			<?php } ?>
			<?php if(isset($one['workSubTypeId'])){ ?>
				$("<?php echo $one['workSubTypeId'];?>").val(workSubTypeId);
			<?php } ?>
			<?php if(isset($one['workSubTypeName'])){ ?>
				$("<?php echo $one['workSubTypeName'];?>").val(workSubTypeName);
			<?php } ?>
			<?php if(isset($one['workFirstTypeName'])){ ?>
				$("<?php echo $one['workFirstTypeName'];?>").val(workFirstTypeName);
			<?php } ?>
			
			$("<?php echo $one['checkWorkId'];?>").change();//噢！他改变了！			
	<?php } ?>
	

	//点击后toggle
	<?php if($showToggle){ ?>
		//删除所有的toggle class
		$("#<?php echo $id;?> > div.main > div.block").removeClass("toggle");
		$(this).addClass("toggle");
	<?php } ?>
});
$(document).delegate("#<?php echo $id;?> > div.ctr > div.line > select","change",function(){
	$("#<?php echo $id;?> > input.catalogId").change();
});
$(document).delegate("#<?php echo $id;?> > div.ctr > div.line > div.getList","click",function(){
	$("#<?php echo $id;?> > input.catalogId").change();
});
//定义选择order动画
$(document).delegate("#<?php echo $id;?> > div.ctr > div.line > div.order","click",function(){
	$("#<?php echo $id;?> > div.ctr > div.line > div.order").removeClass("toggle");
	$(this).addClass("toggle");
	$("#<?php echo $id;?> > input.catalogId").change();
});
function <?php echo $id;?>makeCheckWorkBlock(checkWorkObject)//JSON
{
	var workId = <?php echo IDADDUP ;?>+parseInt(checkWorkObject.workId);
	var name = checkWorkObject.nickName==""?checkWorkObject.userName:checkWorkObject.nickName;
	var moreInfo = "";
	//用于初赛初审
	if((checkWorkObject.cscsGroup != null) && (checkWorkObject.cscsGroup.length > 0))
	{
		moreInfo = "当前所在分组: ";
		$.each(checkWorkObject.cscsGroup,function(index,it){
			moreInfo+=it.groupName+" ";
		});
	}
	return $('<div class="block">'+
		'<input class="checkId" type="hidden" value="'+checkWorkObject.checkId+'"></input>'+
		'<input class="workTitle" type="hidden" value="'+checkWorkObject.workTitle+'"></input>'+
		'<input class="workSubTypeId" type="hidden" value="'+checkWorkObject.subTypeId+'"></input>'+
		'<input class="workSubTypeName" type="hidden" value="'+checkWorkObject.typeName+'"></input>'+
		'<input class="workFirstTypeName" type="hidden" value="'+checkWorkObject.firstTypeName+'"></input>'+
		'<input class="workId" type="hidden" value="'+checkWorkObject.workId+'"></input>'+
		'<div class="line">'+workId+". "+checkWorkObject.workTitle+'</div>'+
		'<div class="line subTitle">'+checkWorkObject.firstTypeName+' - '+checkWorkObject.typeName+' by '+checkWorkObject.school+" : "+name+'</div>'+
		'<div class="line subTitle">'+moreInfo+'</div>'+
	'</div>');
}
function <?php echo $id;?>getFilterParam()
{
	var data = {};
	//自身的筛选器
	data.feedNum = $("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val() == ""?5:$("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val();
	data.checkStatus = 2;
	data.order = $("#<?php echo $id;?> > div.ctr > div.line > div.order.asc").hasClass("toggle")?"asc":"desc";
	<?php if($all){ ?>
		data.all = "true";
	<?php } ?>
	//input筛选器
	data.catalogId = $("#<?php echo $id;?> > input.catalogId").val();
	data.location = $("#<?php echo $id;?> > input.locationId").val();
	data.workSubTypeId = $("#<?php echo $id;?> > input.subTypeId").val();
	data.competitorId = $("#<?php echo $id;?> > input.competitorId").val();
	data.startNum = <?php echo $id;?>startNum;
	return data;
}
function <?php echo $id?>showLoading()
{
	$("#<?php echo $id?> > div.cLoading").show();
}
function <?php echo $id?>hideLoading()
{
	$("#<?php echo $id?> > div.cLoading").hide();
}
</script>