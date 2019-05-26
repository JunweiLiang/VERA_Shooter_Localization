<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		被调用input.checkId change时，载入信息，
	*/
?>
<style type="text/css">
	#<?php echo $id;?>{
		position:relative;
	}
	#<?php echo $id;?> > div.cwLoading{
		padding:60px 0;
		height:30px;
		width:100%;
		display:none;
		background-color:silver;
		opacity:0.70;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=70);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; /*IE8*/
		position:absolute;top:0;left:0;
		z-index:990;
	}
	#<?php echo $id?> > div.main > div.ctr > select.check{width:100px;}
	#<?php echo $id?> > div.main > div.ctr{
		height:30px;
	}
	#<?php echo $id?> > div.main > div.line{padding:5px 0;}
	#<?php echo $id?> > div.main > div.ctr > div.check{
		float:left;
		padding:3px;
		width:60px;
		text-align:center;
		cursor:pointer;
		margin-right:10px;
	}
	#<?php echo $id?> > div.main > div.ctr > div.check.toggle{
		color:white;
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
</style>
<script type="text/javascript">
	$(document).delegate("#<?php echo $id?> > input.checkId","change",function(){
		getCheckStatus();
	});
function getCheckStatus()
{
		var checkId = $("#<?php echo $id?> > input.checkId").val();
		<?php echo $id;?>showLoading();
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/check?m=get","checkId="+checkId,function(result){
			//alert(result);
			enableCheck();
			if(result.checkStatus == 0)
			{
				showCheckStatus("等待审核");
				setCheck(0);	
			}
			else if(result.checkStatus == 1)
			{
				showCheckStatus("未通过审核");
				setCheck(1);
			}
			else if(result.checkStatus == 2)
			{
				showCheckStatus("已通过审核");
				setCheck(2);
			}
			<?php if($hasCom){ ?>
				<?php echo $id;?>showCom(result.com);
			<?php } ?>
			<?php echo $id;?>hideLoading();
		},'json');
}
function setCheck(val)
{
	//设置当前审核状态，之前是下拉筐
//	$("#<?php echo $id?> > div.main > div.ctr > select.check > option[value='"+val+"']").prop("selected",true);
	$("#<?php echo $id?> > div.main > div.ctr > div.check").removeClass("toggle");
	$("#<?php echo $id?> > div.main > div.ctr > div.check > input[value='"+val+"']").parent().addClass("toggle");
}
function <?php echo $id?>showCom(str)
{
	$("#<?php echo $id;?> > div.main > div.line > textarea.com").val(str);
}
	//保存评论，直接调用select.Change()
	$(document).delegate("#<?php echo $id?> > div.main > div.line > div.saveCom","click",function(){
		//alert("a");
		//下面是旧的下拉框模式
		//$("#<?php echo $id?> > div.main > div.ctr > select.check").change();
		$("#<?php echo $id?> > div.main > div.ctr > input.check").change();
	});
	$(document).delegate("#<?php echo $id?> > div.main > div.ctr > input.check","change",function(){
		//alert("changed!");
		if(!$(this).hasClass("disabled"))
		{
			var data = {};
			data.checkId = $("#<?php echo $id?> > input.checkId").val();
			//下面是旧的下拉筐模式
			/*
			if($(this).children("option:selected").val() == 2)
			{
				data.check="pass";
			}
			else if($(this).children("option:selected").val() == 1)
			{
				data.check="fail";
			}
			else
			{
				data.check="wait";
			}
			*/
			//alert($(this).parent().children("div.check.toggle > input.v").val());
			if($(this).parent().find("div.check.toggle > input.v").val() == 2)
			{
				data.check="pass";
			}
			else if($(this).parent().find("div.check.toggle > input.v").val() == 1)
			{
				data.check="fail";
			}
			else
			{
				data.check="wait";
			}
			<?php if($hasCom){ ?>
				data.com = $("#<?php echo $id?> > div.main > div.line > textarea.com").val();
			<?php } ?>
			<?php echo $id?>showLoading();
			 disableCheck();
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/check?m=check",data,function(result){
				//alert(result);	
				if(result == "no")
				{
					alert("不能修改旧的提交记录，请查看此作品最新的提交!");
				}
				getCheckStatus();
			});
		}
	});
	//定义选择审核了的事件
	$(document).delegate("#<?php echo $id?> > div.main > div.ctr > div.check","click",function(){
		$("#<?php echo $id?> > div.main > div.ctr > div.check").removeClass("toggle");
		$(this).addClass("toggle");
		$("#<?php echo $id?> > div.main > div.ctr > input.check").change();//调用审核事件
	});
function <?php echo $id;?>showLoading()
{
	$("#<?php echo $id?> > div.cwLoading").show();
}
function <?php echo $id;?>hideLoading()
{
	$("#<?php echo $id?> > div.cwLoading").hide();
}
function showCheckStatus(str)
{
	$("#<?php echo $id?> > div.main > div.line > span.status").html(str);
}
function enableCheck()
{
	//$("#<?php echo $id?> > div.main > div.ctr > select.check").removeClass("disabled");
	$("#<?php echo $id?> > div.main > div.ctr > input.check").removeClass("disabled");
	<?php if($hasCom){ ?>
		$("#<?php echo $id?> > div.main > div.ctr > input.com").prop("disabled",false);
	<?php } ?>
}
function disableCheck()
{
//	$("#<?php echo $id?> > div.main > div.ctr > select.check").addClass("disabled");
	$("#<?php echo $id?> > div.main > div.ctr > input.check").addClass("disabled");
	<?php if($hasCom){ ?>
		$("#<?php echo $id?> > div.main > div.ctr > input.com").prop("disabled",true);
	<?php } ?>
}
</script>
<div id="<?php echo $id?>">
	<div class="cwLoading">
		<div class="wrapLoading"><div class="loading"></div></div>
	</div>
	<input class="checkId" type="hidden"></input>
	<div class="main">
		<div class="line">
			当前状态:
			<span class="status"></span>
		</div>
		<div class="line ctr">
			<!--
			<div class="btn btn-small checkButton btn-success pass">通过</div>
			<div class="btn btn-small checkButton btn-success fail">不通过</div>
			-->
			<div style="float:left;width:80px;padding-top:3px;">审核作品:</div>
			<input class="check" type="hidden" value=""></input><?php /*以前select的change绑定到这里*/ ?>
			<div class="check toggle"><input class="v" type="hidden" value="0"></input>等待审核</div>
			<div class="check"><input class="v" type="hidden" value="1"></input>不通过</div>
			<div class="check"><input class="v" type="hidden" value="2"></input>通过</div>
			<!-- 
			<select class="check">
				<option value="0"></option>
				<option value="1">不通过</option>
				<option value="2">通过</option>
			</select>
			-->
		</div>
		<?php if($hasCom){ ?>
		<div class="line">
			评论信息以短消息发送给参赛者，请在评论中标注好作品信息。<br/>
			评论:
			<textarea style="height:50px;width:250px;" class="com input-medium" type="text" value=""></textarea>
			<div class="btn btn-small btn-success saveCom">保存</div>
			<span class="checkComE" style="color:red"></span>
		</div>
		<?php } ?>
	</div>
</div>