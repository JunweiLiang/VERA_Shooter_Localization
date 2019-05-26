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
	height:auto!important;
	height:30px;
	min-height:30px;
	padding:5px 0;
}

#<?php echo $id;?> > div.ctr > div.line > div.order,
#<?php echo $id;?> > div.ctr > div.line > div.checkStatus{
	float:left;
	padding:3px;
	width:60px;
	text-align:center;
	cursor:pointer;
	margin-right:10px;
}
#<?php echo $id;?> > div.ctr > div.line > div.order.toggle,
#<?php echo $id;?> > div.ctr > div.line > div.checkStatus.toggle{
	color:white;
	background-color:<?php echo COLOR1_LIGHTER1;?>;
}
#<?php echo $id;?> > div.main > div.block > div.subTitle{
	color:gray;
	font-size:13px;
}
</style>
<div id="<?php echo $id;?>">
	<input class="catalogId" type="hidden" value=""></input>
	<input class="locationId" type="hidden" value="<?php echo $iLocation;?>"></input>
	<input class="subTypeId" type="hidden" value=""></input>
	<input class="competitorId" type="hidden" value="all"></input>
	<div class="ctr">
		
		<div class="line"<?php if(!$showFeedNum){ ?> style="display:none" <?php } ?>>		
			一次获取:
			<input class="feedNum input-small" type="text" value="<?php echo $feedNum;?>"></input>
			<div class="btn btn-small btn-primary getList">获取作品列表信息</div>
		</div>
		<div class="line">
			<div class="checkStatus toggle"><input class="v" type="hidden" value="all"></input>全部</div>
			<div class="checkStatus"><input class="v" type="hidden" value="0"></input>等待审核</div>
			<div class="checkStatus"><input class="v" type="hidden" value="1"></input>不通过</div>
			<div class="checkStatus"><input class="v" type="hidden" value="2"></input>审核通过</div>
			<!--
			审核状态:
			<select class="checkStatus" style="width:100px;">
				<option value="all">全部</option>
				<option value="0">等待审核</option>
				<option value="1">不通过</option>
				<option value="2">审核通过</option>
			</select>
			-->
		</div>
		<div class="line">
			<div class="order asc toggle">ID升序</div>
			<div class="order desc">ID降序</div>
		</div>
		<?php if($showInfo){ ?>
		<div class="line">
			<div class="title">审核信息:</div>
			<div class="line">
				本赛区总提交作品数量:<span class="csubmitSum">0</span>
				本子类别总提交数量:<span class="tsubmitSum">0</span><br/>
				本赛区总已通过审核数量:<span class="cpassSum">0</span>
				本子类别已通过审核数量:<span class="tpassSum">0</span>
			</div>
		</div>
		<?php } ?>
		<?php if($searchById){ ?>
		<div class="line">
			<div class="title">通过作品Id搜索: <span class="searchIdE" style="color:red;font-size:13px"></span></div>
			<div class="line">
				<input class="searchId"></input>
				<div class="btn btn-small btn-info searchById">搜索</div>
				<div class="btn btn-small btn-info reset">清空并刷新</div>
			</div>
		</div>
		<?php } ?>
		<?php if($moreOption){ ?>
		
		<div class="line">
			<div class="btn btn-small btn-info moreOption">更多操作</div>
		</div>
		<div class="modal hide fade moreOptionModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    		<h3 style='line-height:25px'>更多操作</h3>
			</div>
			<div class="modal-body">
				<div class="line">
					<div class="title">批量强制提交作品(仅您所管辖赛区)</div>
					<div class="line">
						<textarea class="psubmit"></textarea>
						<div class="btn btn-small btn-info psubmit">提交</div>
					</div>
				</div>
				<div class="line">
					<div class="title">批量强制审核作品(仅您所管辖赛区)</div>
					<div class="line checkS">
						<div class="block wait">等待审核</div>
						<div class="block pass toggle">审核通过</div>
						<div class="block notPass">审核不通过</div>
					</div>
					<div class="line">
						<textarea class="pcheck"></textarea>
						<div class="btn btn-small btn-info pcheck">审核</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
    			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
			</div>
		</div>
		<script type="text/javascript">
			//点击更多操作
			$(document).delegate("#<?php echo $id?> > div.ctr > div.line > div.moreOption","click",function(){
				$("#<?php echo $id?> > div.ctr > div.moreOptionModal").modal("show");
			});
			//点击 审核设置
			$(document).delegate("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.checkS > div.block","click",function(){
				$(this).parent().children("div.block").removeClass("toggle");
				$(this).addClass("toggle");
			});
			//点击 提交
			$(document).delegate("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > div.psubmit","click",function(){
				if(!$(this).hasClass("disabled"))
				{
					var workIdStr = $("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > textarea.psubmit").val();
					if($.trim(workIdStr) == "")
					{
						return;
					}
					var data = {};
					data.workIdStr = workIdStr;
					if(!confirm("确认强制提交这些作品:\n"+data.workIdStr+"?"))
					{
						return ;
					}
					$(this).addClass("disabled");
					$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/psubmitWork",data,function(result){
						//alert(result);
						var goodStr = "";
						for(var i=0;i<result.length;++i)
						{
							goodStr+=result[i]+" \n";
						}
						$("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > div.psubmit").removeClass("disabled");
						//重新载入作品列表
						$("#<?php echo $id;?> > input.catalogId").change();
						alert("成功提交了"+result.length+"个作品,\n"+goodStr);
					},'json');
				}
			});
			//点击 审核
			$(document).delegate("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > div.pcheck","click",function(){
				if(!$(this).hasClass("disabled"))
				{
					var workIdStr = $("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > textarea.pcheck").val();
					if($.trim(workIdStr) == "")
					{
						return;
					}
					var $check = $("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.checkS > div.block.toggle");
					var checkStatus = $check.hasClass("pass")?2:($check.hasClass("notPass")?1:0);
					var checkStr = checkStatus == 2?"通过":(checkStatus == 1?"不通过":"等待审核");
					var data = {};
					data.workIdStr = workIdStr;
					data.checkStatus = checkStatus;
					//alert(checkStatus);
					if(!confirm("确认强制设置这些作品审核状态为"+checkStr+":\n"+data.workIdStr+"?"))
					{
						return ;
					}
					$(this).addClass("disabled");
					$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/pcheckWork",data,function(result){
						//alert(result);
						var goodStr = "";
						for(var i=0;i<result.length;++i)
						{
							goodStr+=result[i]+" \n";
						}
						$("#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > div.pcheck").removeClass("disabled");
						//重新载入作品列表
						$("#<?php echo $id;?> > input.catalogId").change();
						alert("成功设置了"+result.length+"个作品的审核状态,\n"+goodStr);
					},'json');
				}
			});
		</script>
		<style type="text/css">
			#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.checkS{
				height:30px;
				padding:5px;
			}
			#<?php echo $id;?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.line > textarea{
				width:300px;
				height:150px;
			}
			#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.checkS > div.block{
				float:left; 
				margin-right:20px;
				width:80px;
				padding:5px;
				text-align:center;
				cursor:pointer;
			}
			#<?php echo $id?> > div.ctr > div.moreOptionModal > div.modal-body > div.line > div.checkS > div.block.toggle{
				color:white;
				background-color:<?php echo COLOR1_LIGHTER1;?>;
			}
		</style>
		<?php } ?>
	</div>
	<div class="main">
		
	</div>
	<div class="wrapLoading cLoading"><div class="loading"></div></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
});
<?php if($searchById){ ?>
//点击搜索
$(document).delegate("#<?php echo $id?> > div.ctr > div.line > div.line > div.searchById","click",function(){
	var data = {};
	//转换真实id(yeah,so what?!)
	data.workId = parseInt($("#<?php echo $id?> > div.ctr > div.line > div.line > input.searchId").val())-<?php echo IDADDUP ;?>;
	if(data.workId == "")
	{
		showSearchE("请输入Id!");
		return;
	}
	//重置startNum
	<?php echo $id;?>startNum = 0;
	//清空
	$("#<?php echo $id?> > div.main").html("");
	<?php echo $id;?>showLoading();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/searchByWorkId",data,function(result){
		<?php echo $id;?>hideLoading();
		//alert(result);
		if(result.error != null)
		{
			showSearchE("没有结果!");
			//alert("a");
		}
		else
		{
			$.each(result,function(key,item){
				$("#<?php echo $id;?> > div.main").append(<?php echo $id?>makeCheckWorkBlock(item));
				//alert(item.workTitle);
			});
		}
	},'json');
});
//重置
$(document).delegate("#<?php echo $id?> > div.ctr > div.line > div.line > div.reset","click",function(){
	$("#<?php echo $id?> > div.ctr > div.line > div.line > input.searchId").val("");
	$("#<?php echo $id;?> > input.catalogId").change();
});
function showSearchE(str)
{
	$("#<?php echo $id?> > div.ctr > div.line > div.title > span.searchIdE").html(str);
	setTimeout(function(){
		$("#<?php echo $id?> > div.ctr > div.line > div.title > span.searchIdE").html("");
		
	},3000);
}
<?php } ?>
//绑定关键方法
//input.catalogId change事件
var <?php echo $id;?>startNum = 0;//记录当前结果开始的序号，每次change之后就设置为0
$(document).delegate("#<?php echo $id;?> > input.catalogId","change",function(){
	<?php echo $id;?>startNum = 0;
	//alert("s");
	var data = getFilterParam();
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
	getCheckWorkList(data);
	<?php if($showInfo){ ?>
	getCheckWorkInfo(data);
	<?php } ?>
});
function getCheckWorkList(data)
{
	<?php echo $id;?>showLoading();
	<?php if($forCheck){ ?>
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/getWorkListForCheck",data,function(result){
	<?php }else{ ?>
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/getList",data,function(result){
	<?php } ?>
		//alert(result);
		//alert(result.length);
		$.each(result,function(key,item){
			$("#<?php echo $id;?> > div.main").append(<?php echo $id?>makeCheckWorkBlock(item));
			//alert(item.workTitle);
		});
		<?php echo $id;?>hideLoading();
		var feedNum = $("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val() == ""?5:$("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val();
		if(result.length == feedNum)
		{
			//显示获取更多按钮
			$("#<?php echo $id?> > div.main").append('<div class="btn btn-block btn-small getMore">更多</div>');
		}
		<?php echo $id;?>startNum+=result.length;
	},'json');
}
function getCheckWorkInfo(data)
{
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/getInfo",data,function(result){
		//alert(result);
		//清空
		for(var key in result)
		{
			$("#<?php echo $id;?> > div.ctr > div.line > div.line > span."+key).html(result[key]);
		}
	},'json');
}
//点击查看更多按钮
$(document).delegate("#<?php echo $id;?> > div.main > div.getMore","click",function(){
var data = getFilterParam();
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
	getCheckWorkList(data);
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
	<?php if(!is_array($targetSelector)){ ?>
		$("<?php echo $targetSelector;?>").val(checkId);
		$("<?php echo $targetWorkTitle;?>").val(workTitle);
		$("<?php echo $targetSelector;?>").change();
	<?php }else{ 
			foreach($targetSelector as $one)
			{
	?>
			$("<?php echo $one;?>").val(checkId);
			$("<?php echo $targetWorkTitle;?>").val(workTitle);
			$("<?php echo $one;?>").change();//噢！他改变了！			
	<?php } 
	} ?>
	

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
//定义选择order筛选器
$(document).delegate("#<?php echo $id;?> > div.ctr > div.line > div.order","click",function(){
	$("#<?php echo $id;?> > div.ctr > div.line > div.order").removeClass("toggle");
	$(this).addClass("toggle");
	$("#<?php echo $id;?> > input.catalogId").change();
});
//定义选择审核筛选器
$(document).delegate("#<?php echo $id;?> > div.ctr > div.line > div.checkStatus","click",function(){
	$("#<?php echo $id;?> > div.ctr > div.line > div.checkStatus").removeClass("toggle");
	$(this).addClass("toggle");
	$("#<?php echo $id;?> > input.catalogId").change();
});
function <?php echo $id;?>makeCheckWorkBlock(checkWorkObject)//JSON
{
	var workId = <?php echo IDADDUP ;?>+parseInt(checkWorkObject.workId);
	var name = checkWorkObject.nickName==""?checkWorkObject.userName:checkWorkObject.nickName;
	return $('<div class="block">'+
		'<input class="checkId" type="hidden" value='+checkWorkObject.checkId+'></input>'+
		'<input class="workTitle" type="hidden" value='+checkWorkObject.workTitle+'></input>'+
		'<div class="line">'+workId+". "+checkWorkObject.workTitle+'</div>'+
		'<div class="line subTitle">'+checkWorkObject.firstTypeName+' - '+checkWorkObject.typeName+' by '+checkWorkObject.school+" : "+name+'</div>'+
	'</div>');
}
function getFilterParam()
{
	var data = {};
	//自身的筛选器
	data.feedNum = $("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val() == ""?5:$("#<?php echo $id;?> > div.ctr > div.line > input.feedNum").val();
	data.checkStatus = $("#<?php echo $id;?> > div.ctr > div.line > div.checkStatus.toggle > input.v").val();
	data.order = $("#<?php echo $id;?> > div.ctr > div.line > div.order.asc").hasClass("toggle")?"asc":"desc";
	//input筛选器
	data.catalogId = $("#<?php echo $id;?> > input.catalogId").val();
	data.location = $("#<?php echo $id;?> > input.locationId").val();
	data.workSubTypeId = $("#<?php echo $id;?> > input.subTypeId").val();
	data.competitorId = $("#<?php echo $id;?> > input.competitorId").val();
	data.startNum = <?php echo $id;?>startNum;
	//alert(data.feedNum);
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