<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#cWork{position:relative}
#cWork > #newWorkModal > div.modal-body > div.line{
	padding:5px;
	position:relative;
}
#cWork > #newWorkModal > div.modal-body > div.title > div.right{
	font-size:15px;
	font-weight:bold;
}
#cWork > #newWorkModal > div.modal-body > div.line > div.right > div.block > input{
	margin:0 0 3px 0;
}
#cWork > #newWorkModal > div.modal-body > div.line > div.right > div.tailNotice{
	position:absolute;
	top:5px;
	left:100px;
	color:red;
}
	#cWork > div.cLeft{
	/*	float:left;*/
	/*	position:fixed;
		background-color:white;
		border:1px silver solid;
		border-width:1px 1px 1px 0;
		top:20%;
		left:0;
		width:180px;
		padding:10px;
		z-index:9999;
		*/
		position:absolute;
		top:230px;
		left:-150px;
		background-color:white;
		padding:10px;width:120px;
		border-top:3px solid <?php echo COLOR1_LIGHTER1;?>;
		-moz-box-shadow:0px 0px 2px 1px #999;              
 	    -webkit-box-shadow:0px 0px 2px 1px #999;           
  		box-shadow:0px 0px 2px 1px #999;
	}
	/*
	#cWork > div.cLeft > div.x{
		position:absolute;
		top:46px;
		right:-20px;
		width:15px;
		height:80px;
		padding:15px 2px 0px 2px;
		background-color:white;
		border:1px silver solid;
		border-width:1px 1px 1px 0;
	}
	#cWork > div.cLeft > div.ctr{
		position:absolute;
		cursor:pointer;
		top:-1px;
		right:-20px;
		width:15px;
		height:30px;
		padding-top:15px;
		padding-left:4px;
		background-color:white;
		border:1px silver solid;
		border-width:1px 1px 1px 0;
	}
	#cWork > div.cLeft > div.ctr:hover{
		background-color:rgb(245,245,245);
	}*/
	#cWork > div.cLeft > div.fixed{
		color:gray;
		font-size:13px;
		padding-left:0px;
	}
	#cWork > div.cLeft div.title{
		border-left:3px solid rgb(200,0,0);
		padding-left:10px;
		margin:10px 0;
	}
	#cWork > div.cRight{
		/*margin:0 0 0 200px;*/
		padding:10px;
	}
	#cWork > div.cRight > div.notice{
		/*background-color:rgb(252,252,252);*/
		padding:5px;
		/*border:1px solid silver;
		border-radius:5px;
		margin-bottom:20px;*/
	}
</style>
<script type="text/javascript">
//绑定cLeft(作品列表)的或者展开动作
/*
$(document).delegate("#cWork > div.cLeft > div.ctr","click",function(){
	if(!$(this).prop("moving"))
	{
		if($(this).children("i").hasClass("icon-chevron-left"))
		{
			//alert("a");
			$(this).prop("moving",true);
			$(this).parent().animate({'left':'-200px'},500,"swing",function(){
				$("#cWork > div.cLeft > div.ctr").prop("moving",false);
				setLeftCtr("right");
			});
		}
		else
		{
			$(this).prop("moving",true);
			$(this).parent().animate({'left':'0'},500,"swing",function(){
				$("#cWork > div.cLeft > div.ctr").prop("moving",false);
				setLeftCtr("left");
			});
		}
	}
});
function setLeftCtr(opt)//控制收起作品列表箭头指向
{
	if(opt == "left")
	{
		$("#cWork > div.cLeft > div.ctr > i").removeClass("icon-chevron-right")
			.addClass("icon-chevron-left")
			.prop("title","收起作品列表");
		$("#cWork > div.cLeft > div.x").hide();
	}
	else
	{
		$("#cWork > div.cLeft > div.ctr > i").removeClass("icon-chevron-left")
			.addClass("icon-chevron-right")
			.prop("title","展开作品列表");
		$("#cWork > div.cLeft > div.x").show();
	}
}
*/
//绑定作品列表的滑动固定
$(document).ready(function(){

	$(window).bind('scroll',function(){
		//
		if($(this).scrollTop() >= 250)//40 for div.main > div.title
		{
			//alert('wd');
			$("#cWork > div.cLeft").css('position','fixed')
				.css("top","28px")		
				.css("left","50%")	
				.css("marginLeft","-490px");
		}
		else
		{
			$("#cWork > div.cLeft").css('position','absolute')
				.css("top","230px")	
				.css("left","-150px")	
				.css("marginLeft","0px");
		}
	});
});
//绑定新增作品打开下拉框动作
$(document).delegate("#cWork > div.cLeft > div.line > a.newWork,#cWork > div.cRight > div.newWork","click",function(){

	//计算高度
	$("#newWorkModal").css("top",$(window).scrollTop()+100+"px").modal("show");
});
//新增作品modal的确定,检查是否选中一个
$(document).delegate("#cWork > #newWorkModal > div.modal-footer > button.newWork","click",function(){
if(!$(this).hasClass("disabled"))
{
	//alert($(this).parent().parent().find("div.modal-body > div.line > div.right > div.block > input:checked").val());
	//$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("请选择一个作品类型！");
	if($(this).parent().parent().find("div.modal-body > div.line > div.right > div.block > input:checked").length == 0)
	{
		$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("请选择一个作品类型！");
		setTimeout(function(){
			$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("");
		},3000);
	}
	var data = {};
	data.workTypeId = $(this).parent().parent().find("div.modal-body > div.line > div.right > div.block > input:checked").val();
	//禁用确定按钮
	$(this).addClass("disabled");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/newWork",data,function(result){
		//alert(result);
		$("#cWork > #newWorkModal > div.modal-footer > button.newWork").removeClass("disabled");
		if(result == "ok")
		{
			$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("新增作品成功!");
			setTimeout(function(){
				$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("");
			},3000);
			$("#cWork > #newWorkModal").modal("hide");
			//刷新WorkListWidget,change事件
			$("#workList > #filter > input.competitorId").change();
		}
		else
		{
			$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("新建作品出错，作品数量已经达上限或者本赛区已停止报名");
			setTimeout(function(){
				$("#cWork > #newWorkModal > div.modal-footer > #newWorkE").html("");
			},3000);
		}
	});
}
});
//当作品edit的input改变，显示其
$(document).delegate("#workEdit > input.workId","change",function(){
	$("#workEdit").parent().show();
});
</script>
<div id="cWork">
	<div class="modal hide fade" id="newWorkModal" style="position:absolute;width:700px;margin-left:-350px;margin-top:60px;"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>新增作品</h3>
		</div>
		<div class='modal-body'>
			<?php 
				//print_r($tablrArr);
				$this->widget("TablrWidget",array(
					"param" => $tablrArr,
				));
			?>
		</div>
		<div class="modal-footer">
			<span class='help-inline' style='color:orange' id='newWorkE'></span>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
   		 	<button class="btn btn-primary newWork">确定</button>   	
		</div>
	</div> 
	<div class="cLeft">
		<!--<div class="ctr">
			<i class="icon-chevron-left" title="收起作品列表"></i>
		</div>
		<div class="x" style="display:none">作品列表</div>
		-->
		<div class="line newWorkDiv">
			<a class="btn btn-block btn-danger newWork btn-info">新增作品</a>
		</div>
		<div class="line fixed">学校类型: <?php echo $competitorProfile['schoolType'];?></div>
		<div class="line fixed">学校位置: <?php echo $competitorProfile['locationName'];?></div>
		<div class="line fixed">参加赛区: <?php echo $competitorProfile['catalogTitle'];?></div>
		<div class="line title">我的作品列表</div>
		<div class="line">(绿色为成功提交的作品，红色为未提交的作品)</div>
		<div class="line">(您有 <span id="goodNum" style="color:red"></span> 个作品未提交)</div>
		<div class="line" style="height:200px;overflow:auto;">
			<?php $this->widget("WorkListWidget",array(
				"competitorId" => Yii::app()->session['userId'],				
				"targetSelector" => '#workEdit > input.workId',
				"toggle" => true,
				"instantLoad" => true,
				"showContent" => false,
				"width" => "120px",
				"sumSelector" => "#cWork > div.cLeft > div.line > #goodNum",
			)); ?>
		</div>
	</div>
	<div class="cRight">
		<div class="btn btn-block btn-info newWork">新增作品</div>
		<div class="notice">
			<?php 
				$this->widget("NoticeWidget",array(
					"name"=>"workMain",
				));
			?>
		</div>
		<div class="workEdit" style="display:none;">
			<?php 
				$this->widget("WorkEditWidget",array(
					"id" => "workEdit",
					'authorTypeArr' => $authorTypeArr,
					"overflow" => false,
					"fixedHead" => true,
					"fixedTop" => "30px",
					"allowSubmittedSave" => Yii::app()->cache->get("allowSubmittedSave"),
					'school' => $competitorProfile['school'],
				));
			?>
		</div>
	</div>
</div>