<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{
		position:relative;
	}
	#<?php echo $id;?> > div.cjLoading{
		padding:10px 0;
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
</style>
<script type="text/javascript">
	$(document).delegate("#<?php echo $id?> > input.judgeId","change",function(){
		<?php echo $id;?>getCheckStatus();
	});
function <?php echo $id;?>getCheckStatus()
{
		var judgeId = $("#<?php echo $id?> > input.judgeId").val();
		<?php echo $id;?>showLoading();
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/getCheckStatus?judgeId="+judgeId,"",function(result){
			//alert(result);
			if(result.isProved == 0)
			{
				<?php echo $id;?>showCheckStatus("等待审核");
				<?php echo $id;?>enableCheck();	
			}
			else if(result.isProved == 1)
			{
				<?php echo $id;?>showCheckStatus("通过审核");
				<?php echo $id;?>disableCheck();
			}
			else if(result.isProved == 2)
			{
				<?php echo $id;?>showCheckStatus("未通过审核");
				<?php echo $id;?>disableCheck();
			}
			<?php echo $id;?>hideLoading();
		},'json');
}

	$(document).delegate("#<?php echo $id?> > div.main > div.ctr > div.checkButton","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			var data = {};
			data.judgeId = $("#<?php echo $id?> > input.judgeId").val();
			if($(this).hasClass("pass"))
			{
				data.check="pass";
			}
			else
			{
				data.check="fail";
			}
			<?php echo $id?>showLoading();
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/checkJudge",data,function(result){
				//alert(result);	
				<?php echo $id;?>getCheckStatus();
			});
		}
	});
function <?php echo $id;?>showLoading()
{
	$("#<?php echo $id?> > div.cjLoading").show();
}
function <?php echo $id;?>hideLoading()
{
	$("#<?php echo $id?> > div.cjLoading").hide();
}
function <?php echo $id;?>showCheckStatus(str)
{
	$("#<?php echo $id?> > div.main > div.line > span.status").html(str);
}
function <?php echo $id;?>enableCheck()
{
	$("#<?php echo $id?> > div.main > div.ctr > div.checkButton").removeClass("disabled");
}
function <?php echo $id;?>disableCheck()
{
	$("#<?php echo $id?> > div.main > div.ctr > div.checkButton").addClass("disabled");
}
</script>
<div id="<?php echo $id?>">
	<div class="cjLoading">
		<div class="wrapLoading"><div class="loading"></div></div>
	</div>
	<input class="judgeId" type="hidden"></input>
	<div class="main">
		<div class="line">
			当前状态:
			<span class="status"></span>
		</div>
		<div class="line ctr">
			<div class="btn btn-small checkButton btn-success pass">通过</div>
			<div class="btn btn-small checkButton btn-success fail">不通过</div>
		</div>
	</div>
</div>