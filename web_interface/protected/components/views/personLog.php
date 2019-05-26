<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?> > div.main > div.personLogModal
	{
		width:500px;
		position:absolute;
		top:5%;
		margin-bottom:30px;
		z-index:10001;
		left:50%;
		margin-left:-250px;
		background-color:white;
		border-radius:5px;
		display:none;
		-moz-box-shadow:0 1px 1px #999;              
 	   	-webkit-box-shadow:0 1px 1px #999;           
 	   	box-shadow:0 1px 1px #999;
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.personLogModal{
			width:92%;
			top:0;
			left:4%;
			margin-left:0px;
		}	
		#<?php echo $id?> > div.main > div.personLogModal > div.modal-body{
			max-height:none;
		}
	}
	#<?php echo $id?> > div.main > div.personLogModal > div.modal-header > div.close
	{
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.main > div.personLogModal > div.modal-body > div.projectName{
		padding:5px 0;
		color:silver;
		font-weight:bold;
		text-align:center;
		word-break:break-all;
	}
	#<?php echo $id?> > div.main > div.personLogModal > div.modal-body > div.logs > div.block{
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.personLogModal > div.modal-body > div.logs > div.block > div.line{
		padding:5px 0;
		word-break:break-all;
	}
	#<?php echo $id?> > div.main > div.personLogModal > div.modal-body > div.logs > div.block > div.time{
		font-size:0.9em;
		color:gray;
		text-align:right;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//坚听projectId
	cw.ech("<?php echo $listen?>",function(){
		var projectId = $(this).val();
		$("#<?php echo $id?> > input.projectId").val(projectId);
	});
	//显示
	cw.ech("#<?php echo $id?> > input.show",function(){
		//alert("a");
		var data = {};
		data.projectId = $(this).parent().children("input.projectId").val();
		data.userId = $(this).parent().children("input.userId").val();
		data.username = $(this).parent().children("input.username").val();
		data.nickname = $(this).parent().children("input.nickname").val();
		//alert(data.nickname);
		var user = data.nickname==""?data.username:data.nickname;
		$("#<?php echo $id?> > div.main > div.personLogModal > div.modal-header > h2 > span.user").html(user);
		//显示载入中，隐藏projectName
		$("#<?php echo $id?> > div.main > div.personLogModal > div.modal-body").children("div.projectName").hide().end()
			.children("div.logs").html('<div class="wrapLoading"><div class="loading"></div></div>');
		//显示overlay
		$("#<?php echo $id?> > div.main > #overlay<?php echo $id; ?> > input.show").change();
		$("#<?php echo $id?> > div.main > div.personLogModal").show();
		cw.post(cw.url+"getLog?projectId="+data.projectId+"&userId="+data.userId+"&s=0&l=-1",data,function(result){
			//alert(result);
			var $main = $("#<?php echo $id?> > div.main > div.personLogModal > div.modal-body");
			//若有projectName,显示
			$main.children("div.logs").html("");
			if(result.projectName != null)
			{
				$main.children("div.projectName").html(result.projectName).show();
			}
			$.each(result.logs,function(index,item){
				$main.children("div.logs").append(cw.parseLog(item));
			});
		});
	});
	//关闭事件
	cw.ech("#<?php echo $id?> > input.hide",function(){
		//隐藏layout,隐藏内容
		$("#<?php echo $id?> > div.main > #overlay<?php echo $id; ?> > input.hide").change();
		$("#<?php echo $id?> > div.main > div.personLogModal").hide();
	});
	//点击关闭
	cw.ec("#<?php echo $id?> > div.main > div.personLogModal > div.modal-header > div.close",function(){
		$("#<?php echo $id?> > input.hide").change();
	});
</script>
<div id="<?php echo $id?>">
	<input class="projectId" type="hidden" value="0"></input>
	
	<input class="show" type="hidden"></input>
	<input class="hide" type="hidden"></input>
	
	<input class="userId" type="hidden"></input>
	<input class="username" type="hidden"></input>
	<input class="nickname" type="hidden"></input>
	
	<div class="main">
		<div class="personLogModal"><!--to set the modal in the center,margin-left should be (-)half its width-->
			
			<div class="modal-header">
				<div class="close">&times;</div>
				<h2>
					<span class="user"></span> <?php echo t::o("activities")?>
				</h2>
			</div>
			<div class='modal-body'>
				<div class="projectName"></div>
				<div class="logs"></div>
			</div>
		</div>
		<?php $this->widget("OverlayWidget",array(
			"zindex" => "10000",
			"id" => "overlay".$id,
			"transparent" => false,
			"targetSelector" => "#".$id." > input.hide",
		)); ?>
	</div>		
</div>