<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>
<style type="text/css">
#<?php echo $id;?> > div.progress{margin:5px;}
</style>
<div id="<?php echo $id;?>" style="position:relative">
	<input class="processId" type="hidden" value="0"></input>
	<input class="updating" type="hidden" value="0"></input> <!-- control whether to update -->
	<input class="showing" type="hidden" value="0"></input> <!-- control whether to show message and progress-->
	<div class="progress progress-striped active" style="display:none;line-height: 20px">
		<div class="bar" style="width:0%"></div>
	</div>
	<?php if(!$noMessage){ ?>
	<div class="prevMessage"></div>
	<div class="message"></div>
	<?php } ?>
</div>
<script type="text/javascript">
	
	//listen to showing
	//TODO:  bug?????
	cw.ech("#<?php echo $id?> > input.updating",function(){
		var flag = parseInt($(this).val());
		if(flag == 1)
		{
			$("#<?php echo $id?> > div.message").show();
			$("#<?php echo $id?> > div.prevMessage").show();
			$("#<?php echo $id?> > div.progress").show();
		}
		else
		{
			//$("#<?php echo $id?> > div.message").hide();
			//$("#<?php echo $id?> > div.prevMessage").hide();
			$("#<?php echo $id?> > div.progress").hide();
		}
	});
	//listen to updating
	var <?php echo $id?>inter = null;
	cw.ech("#<?php echo $id?> > input.updating",function(){
		var flag = parseInt($(this).val());		
		if(flag == 1) //start updating
		{
			<?php echo $id?>inter = setInterval(function(){
				<?php echo $id?>getProgressOnce();
			},<?php echo $interval?>);
		}else
		{
			if(<?php echo $id?>inter != null)
			{
				clearInterval(<?php echo $id?>inter);
			}
		}
	});
	
	function <?php echo $id?>getProgressOnce()
	{
		var processId = parseInt($("#<?php echo $id?> > input.processId").val());
		if((processId == null) || (processId == 0))
		{
			$("#<?php echo $id?> > div.message").html("e: process Id not set.");
			return;
		}
		else
		{
			var data = {};
			data.processId = processId;
			cw.post("<?php echo $api?>",data,function(result){
				if(result.status == 0)
				{
					<?php echo $id?>setProgress(result.progress,result.message);
					// if the progress is 100 or result.done!=0, stop refreshing
					if((result.progress >= 1) || (result.done != 0))
					{
						clearInterval(<?php echo $id?>inter);
						$("#<?php echo $id?> > input.updating").val(0).change();
						$("#<?php echo $id?> > input.processId").val(0);
						<?php echo $id?>setProgress(0.0,"");//reset
						<?php if($doneCall != ""){ ?>
							$("<?php echo $doneCall?>").change();
							<?php } ?>
					}
				}
			});
		}
	}

	function <?php echo $id?>setProgress(progress,message)
	{
			//progress is 0.0 - 1.0
		progress = parseFloat(progress)*100;
		progress = progress.toFixed(3) + "%";
		$("#<?php echo $id?> > div.progress").children("div.bar").width(progress).html(progress);
		var prevMessage = $("#<?php echo $id?> > div.message").html();
		if(message != prevMessage)
		{
			$("#<?php echo $id?> > div.message").html(message);
			$("#<?php echo $id?> > div.prevMessage").html(prevMessage);
		}
	}
</script>