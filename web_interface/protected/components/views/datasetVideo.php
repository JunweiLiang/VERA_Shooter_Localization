<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>
<style type="text/css">
	#<?php echo $id?> > div.main > div.block{
		padding:5px;
		border-bottom:1px silver solid;
		word-break:break-all;
	}
</style>
<div id="<?php echo $id;?>" style="position:relative">
	<input class="datasetId" type="hidden" value=""></input>
	<div class="main">
	</div>
</div>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	cw.ech("#<?php echo $id?> > input.datasetId",function(){
		var data = {};
		data.datasetId = $(this).val();
		$("#<?php echo $id?> > div.main").html('<div class="wrapLoading"><div class="loading"></div></div>');
		cw.post(cw.url+"getDatasetVideos?limit=-1",data,function(result){
			$("#<?php echo $id?> > div.main").html("");
			if(result.status== 0)
			{
				for(var i in result.videos)
				{
					var video = result.videos[i];
					$("#<?php echo $id?> > div.main").append('<div class="block">'+
						'<input class="dvId" type="hidden" value="'+video.dvId+'"></input>'+
						'<input class="hasImgs" type="hidden" value="'+video.hasImgs+'"></input>'+
						'<input class="imgCount" type="hidden" value="'+video.imgCount+'"></input>'+
						'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
						'<input class="select" type="checkbox" value=1></input> '+
						'<span class="videoname">'+video.videoname+'</span>'+
						' <a href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname='+video.videoname+'" target="_blank"><i class="icon-eye-open"></i></a>'+
					'</div>');
				}
			}
		});
	});
</script>