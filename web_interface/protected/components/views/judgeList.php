<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id;?>{
	
}
#<?php echo $id;?> form{margin:0;}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock{
	cursor:pointer;
	padding:5px 10px;
	background-color:<?php echo $bgColor;?>;
	border:1px solid <?php echo $borderColor;?>;
	border-width:0 1px 1px 0;
	position:relative;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.delete{
	position:absolute;
	top:3px;right:3px;
	width:20px;
	cursor:pointer;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.number{
	color:gray;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.type{
	display:none;
	font-size:12px;
	color:gray;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.showProfile,
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.hideProfile,
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.resetPw{
	text-align:center;
	position:absolute;
	top:20px;
	right:5px;
	cursor:pointer;
	
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.profile {
	padding:5px;
	
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.profile > div.line{
	padding:5px 0;
	height:auto!important;
	height:30px;
	min-height:30px;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.profile > div.line > div.left{
	float:left;
	width:100px;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.profile > div.line > div.right{
	margin:0 0 0 110px;
}
#<?php echo $id;?> > div.main > div.judgeList > div.toggle > div.type{
	display:block;
}
#<?php echo $id;?> > div.main > div.judgeList > div.toggle{
	background-color:<?php echo $hoverToggleColor;?>;
}
#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock:hover{
	background-color:<?php echo $hoverToggleColor;?>;
}
#<?php echo $id;?> > div.main > div.ctr{
	background-color:rgb(245,245,245);
	padding:10px;
}
#<?php echo $id;?> > div.main > div.ctr > div.line{
	height:30px;
}
#<?php echo $id;?> > div.main > div.ctr > div.line > div.filter{
	float:left;
	margin-left:20px;
	padding:3px 0;
	text-align:center;
	width:60px;
	cursor:pointer;
	color:black;
}
#<?php echo $id;?> > div.main > div.ctr > div.line > div.filter.toggle{
	background-color:#0088ff;
	color:white;
}
#<?php echo $id;?> > div.main > div.ctr > div.line > div.filter:not(.toggle):hover{
	background-color:rgb(230,230,230);
}
<?php if($overflowHeight!=""){ ?>
	#<?php echo $id;?> > div.main > div.judgeList{
		height:<?php echo $overflowHeight;?>;
		overflow:auto;
	}
<?php } ?>
</style>

<div id="<?php echo $id;?>">
	<form id="filter">
		<?php if($hasSearch){ ?>
		<input type="hidden" name="searchByName" class="searchByName" value=""></input>
		<?php } ?>
		<input type="hidden" name="goodAtId" class="goodAtId" value="<?php echo $goodAtId;?>"></input>
		<input type="hidden" name="zoneId" class="zoneId" value="<?php echo $zoneId;?>"></input>
		<input type="hidden" name="showContent" class="showContent" value="<?php echo $showContent;?>"></input>
		<input type="hidden" name="order" class="order" value="asc"></input>
		<input type="hidden" name="orderCol" class="orderCol" value="judgeId"></input>
		<input type="hidden" name="isProved" class="isProved" value="<?php echo $provedOnly?"1":"all";?>"></input>
	</form>
	<div class="main">
		<div class="ctr">
			<?php if(!$provedOnly){ ?>
			<div class="line">
				<div class="filter filterP all toggle">
					全部
					<input class="value" type="hidden" value="all"></input>
				</div>
				<div class="filter filterP isProved">
					已通过
					<input class="value" type="hidden" value="1"></input>
				</div>
				<div class="filter filterP notProved">
					未通过
					<input class="value" type="hidden" value="0"></input>
				</div>
			</div>
			<?php } ?>
			<div class="line">
				<div class="filter filterO desc">
					降序
					<input class="value" type="hidden" value="desc"></input>
				</div>
				<div class="filter filterO asc toggle">
					增序
					<input class="value" type="hidden" value="asc"></input>
				</div>
			</div>
			<?php if($hasSearch){ ?>
			<div class="line">
				<input class="searchByName input-medium"></input>
				<div class="btn btn-small searchByName btn-info">按登录名搜索</div>
				<div class="btn btn-small btn-success resetSearch">清空并刷新</div>
			</div>
			<?php } ?>
		</div>
		<div class="judgeList">
		</div><!--div.judgeList-->
	</div><!--div.main-->
</div>
<script type="text/javascript">
<?php if($instantLoad){ ?>
$(document).ready(function(){
	<?php echo $id;?>getjudgeList();
});
<?php } ?>
//绑定交互事件
$(document).delegate("#<?php echo $id;?> > #filter > input.goodAtId","change",function(){
	<?php echo $id;?>getjudgeList();
});
$(document).delegate("#<?php echo $id;?> > #filter > input.zoneId","change",function(){
	<?php echo $id;?>getjudgeList();
});
//点击筛选器动作 
$(document).delegate("#<?php echo $id;?> > div.main > div.ctr > div.line > div.filter","click",function(){
	if($(this).hasClass("filterP"))
	{
		<?php if(!$provedOnly){ ?>
		$("#<?php echo $id;?> > #filter > input.isProved").val($(this).children("input.value").val());
		$("#<?php echo $id;?> > #filter > input.goodAtId").change();
		$("#<?php echo $id;?> > div.main > div.ctr > div.line > div.filterP").removeClass("toggle");
		$(this).addClass("toggle");
		<?php } ?>
	}
	else if($(this).hasClass("filterO"))
	{
		$("#<?php echo $id;?> > #filter > input.order").val($(this).children("input.value").val());
		$("#<?php echo $id;?> > #filter > input.goodAtId").change();
		$("#<?php echo $id;?> > div.main > div.ctr > div.line > div.filterO").removeClass("toggle");
		$(this).addClass("toggle");
	}
});
//点击评委事件
$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock","click",function(){
	<?php if($toggle){ ?>
	//清空所有
	$("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock").removeClass("toggle");
	$(this).addClass("toggle");
	<?php } ?>
	var judgeId = $(this).prop("id");
	var judgeName = $(this).children("input.judgeName").val();
	<?php if(!is_array($targetSelector)){ ?>
		$("<?php echo $targetName;?>").val(judgeName);
		$("<?php echo $targetSelector;?>").val(judgeId)
			.change();
	<?php }else{ 
			foreach($targetSelector as $one)
			{
	?>
			$("<?php echo $targetName;?>").val(judgeName);
			$("<?php echo $one;?>").val(judgeId)
				.change();//噢！他改变了！			
	<?php } 
	} ?>
});
<?php if($hasSearch){ ?>
//清空输入框并重新刷新 
$(document).delegate("#<?php echo $id;?> > div.main > div.ctr > div.line > div.resetSearch","click",function(){
	$("#<?php echo $id;?> > div.main > div.ctr > div.line > input.searchByName").val("");
	$("#<?php echo $id;?> > form > input.searchByName").val("");
	<?php echo $id;?>getjudgeList();
});
//按登录名字搜索
$(document).delegate("#<?php echo $id;?> > div.main > div.ctr > div.line > div.searchByName","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var searchName = $("#<?php echo $id;?> > div.main > div.ctr > div.line > input.searchByName").val();
		if(searchName != "")
		{
			$("#<?php echo $id;?> > form > input.searchByName").val(searchName);
			<?php echo $id;?>getjudgeList();
		}
	}
	
});
<?php } ?>
function <?php echo $id;?>getjudgeList()
{
	//filter还有空的就不执行
	var hasNull = false;
	$("#<?php echo $id?> > form > input").each(function(){
		//排除搜索的字段
		if(!$(this).hasClass("searchByName"))
		{
			if($(this).val() == "")
			{
				hasNull = true;
			}
		}
	});
	if(hasNull)
	{
		return;
	}
	var data = $("#<?php echo $id;?> > #filter").serialize();//获取所有input hidden的参数
	//alert(data);
	//显示载入中
	$("#<?php echo $id;?> > div.main > div.judgeList").html('<div class="wrapLoading"><div class="loading"></div></div>');
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/getJudgeList",data,function(result){
	//	alert(result);
		if(result.error != null)
		{
			alert("Oops!");	
			return;
		}
		$("#<?php echo $id;?> > div.main > div.judgeList").html("");
		$.each(result,function(index,item){
			var htmlObject = <?php echo $id;?>makeBlockHtml(item);
			$("#<?php echo $id;?> > div.main > div.judgeList").append(htmlObject);
		});
	},'json');
}
<?php if($hasDelete){ ?>
//绑定删除评委动作 
$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.delete","click",function(e){
	e.stopPropagation();
	//alert("deleting");
	var data = {};
	data.judgeId = $(this).parent().prop("id");
	if(!confirm("确认删除此评委?"))
	{
		return;
	}
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/delete",data,function(result){
		//alert(result);
		<?php echo $id;?>getjudgeList();
	});
});
<?php } ?>
<?php if($hasResetPw){ ?>
$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.resetPw","click",function(e){
	e.stopPropagation();
	//alert("deleting");
	var data = {};
	data.judgeId = $(this).parent().prop("id");
	if(!confirm("确认重置此评委密码至123456?"))
	{
		return;
	}
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/resetPw",data,function(result){
		//alert(result);
		if(result == "ok")
		{
			alert("密码重置成功!");
		}
	});
});
<?php } ?>
<?php if($hasJudgeNotAllowList){ ?>
	//点击了评委的“不允许评审”
	$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.notAllowDiv > input.notAllow","click",function(e){
		e.stopPropagation();
		var data = {};
		data.judgeId = $(this).parent().parent().prop("id");
		data.notAllow = $(this).prop("checked")?"1":"0";
		//alert(data.judgeId);
		$.post("<?php echo Yii::app()->baseUrl?>/index.php/judgeManage/notAllowJudge",data,function(result){
			//alert(result);
			if(result == "ok")
			{
				alert("修改成功");
			}
		});
	});
<?php } ?>
function <?php echo $id;?>makeBlockHtml(item)
{
	//暂时仅仅使用judgeId与类别信息显示
	//alert(item.notAllow);
	var $temp = $("<div class='judgeBlock' id='"+item.judgeId+"'>"+
		<?php if($hasDelete){ ?>
		"<div class='delete'>&times</div>"+
		<?php } ?>
		"<input class='judgeName' type='hidden' value='"+item.userName+"'></input>"+
		"<div class='line'>"+item.userName+"</div>"+
		"<div class='line number'>No. "+item.judgeId+"</div>"+
		<?php if($hasResetPw){ ?>
			"<div class='btn btn-small btn-primary resetPw'>重置密码</div>"+
		<?php } ?>
		<?php if($hasJudgeNotAllowList){ ?>
			"<div class='notAllowDiv'>"+
				'<input class="notAllow" type="checkbox" '+(item.notAllow == 1?"checked='checked'":"")+'></input> 不允许评审'+
			"</div>"+
		<?php } ?>
		<?php if($showContent == 1){ ?>
		"<div class='btn btn-small btn-primary showProfile'>显示资料</div>"+
		"<div class='profile' style='display:none'>"+
			'<?php  $this->widget("TablrWidget",array(
			"param" => array(
				array(
					"name" => "realName",
					"title" => "真实姓名",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "sex",
					"title" => "性别",
					"type" => "text",
					"text" => ""
				),
				
				array(
					"name" => "school",
					"title" => "学校",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "rank",
					"title" => "评委级别",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "major",
					"title" => "专业",
					"type" => "text",
					"text" => "",
				),
			/*	array(
					"name" => "goodAtArr",
					"title" => "擅长领域",
					"type" => "text",
					"text" => "",
				),*/
				
				array(
					"name" => "otherSpecialfield",
					"title" => "其他擅长领域",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "address",
					"title" => "住址",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "phoneNum",
					"title" => "电话号码",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "email",
					"title" => "电子邮件",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "cellPhoneNum",
					"title" => "手机",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "IDNum",
					"title" => "身份证号",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "jobName",
					"title" => "职称",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "job",
					"title" => "职务",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bornYear",
					"title" => "出生年份",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bankName",
					"title" => "开户银行",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bankAccount",
					"title" => "银行账号",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "note",
					"title" => "备注",
					"type" => "text",
					"text" => "",
				),
			),
			));
		 ?>'+
		"</div>"+
		<?php } ?>
	"</div>");
	<?php if($showContent){ ?>
	//添加资料到temp > div.profile > div.中
		var goodAtStr = "";
		if(item.goodAtArr != null)
		{
			$.each(item.goodAtArr,function(index,it){
				goodAtStr+=it.typeName+"-"+it.subTypeName+" <br/>";
			});
			$temp.find("div.profile > div.goodAtArr > div.right").html(goodAtStr);
		}
		$temp.find("div.profile > div.sex > div.right").html(item.sex==1?"男":"女");
		for(var key in item)
		{
			if((key != "goodAtArr") && (key != "sex"))
			{
				$temp.find("div.profile > div."+key+" > div.right").html(item[key]);
			}
			//评委级别
			if(key == "rank")
			{
				var str = item[key] == 1?"校级":item[key]==2?"省级":"国家级";
				$temp.find("div.profile > div.rank > div.right").html(str);
			}
		}
		
	<?php } ?>
	return $temp;
}
<?php if($showContent){ ?>
//点击显示资料
$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.showProfile","click",function(e){
	e.stopPropagation();
	$(this).parent().children("div.profile").show();
	$(this).html("隐藏资料").removeClass("showProfile").addClass("hideProfile");
});
//点击隐藏资料
$(document).delegate("#<?php echo $id;?> > div.main > div.judgeList > div.judgeBlock > div.hideProfile","click",function(e){
	e.stopPropagation();
	$(this).parent().children("div.profile").hide();
	$(this).html("显示资料").removeClass("hideProfile").addClass("showProfile");
});
<?php } ?>
</script>