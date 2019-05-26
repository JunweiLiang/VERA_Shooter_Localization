<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>
<style type="text/css">
	#<?php echo $id?> > div.content::before{
		content:'';
		position:absolute;
		top:0;
		height:100%;
		width:4px;
		left:50%;
		margin-left:-2px;
		background:#d7e4ed;
	}
	#<?php echo $id?> > div.content{
		background-color:white;
		padding:30px 10px;
	}
	#<?php echo $id?> > div.content > div.block{
		height:auto!important;
		height:150px;
		min-height:150px;
		margin-bottom:20px;
		position:relative;
	}
	#<?php echo $id?> > div.content > div.block > div.content{
		width:45%;
		height:100%;
		background-color:#d7e4ed;
		position:relative;
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#<?php echo $id?> > div.content > div.block > div.content::before{
		content:'';
		position:absolute;
		left:100%;
		top:10px;
		height:0;width:0;
		border:7px solid transparent;
		border-left:7px solid #d7e4ed;
	}
	#<?php echo $id?> > div.content > div.block > div.content.right::before{
		right:100%;
		left:auto;
		border:7px solid transparent;
		border-right:7px solid #d7e4ed;
	}
	#<?php echo $id?> > div.content > div.block > div.content > div{
		padding:10px;
	}
	#<?php echo $id?> > div.content > div.block > div.content > div.imgs > img{
		width:33.3%;
	}
	#<?php echo $id?> > div.content > div.block > div.content.right{
		float:right;
	}
	#<?php echo $id?> > div.content > div.block > div.content > div.videotitle{
		word-break:break-all;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.content > div.block > div.content > div.offset{
		font-size:1em;
		font-weight:bold;
		color:gray;
		width:100%;
		position:absolute;
		top:0px;
		left:122%;
		margin:0;
		padding:10px 0;
	}
	#<?php echo $id?> > div.content > div.block > div.content > div.offset > div.edit{
		display:none;
	}
	#<?php echo $id?> > div.content > div.block:hover > div.content > div.offset > div.edit{
		display:inline-block;
	}

	#<?php echo $id?> > div.content > div.block > div.content > div.offset.right{
		left:auto;
		right:122%;
		text-align:right;
	}
	#<?php echo $id?> > div.content > div.block > div.pin{
		background-color:#75ce66;
		width:20px;
		height:20px;
		left:50%;
		margin-left:-10px;
		position:absolute;
		top:5px;
		border-radius:50%;
		box-shadow:0 0 0 4px #d7e4ed, inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 3px 0 4px rgba(0, 0, 0, 0.05);

	}
</style>
<div id="<?php echo $id;?>" style="position:relative">
	<input class="datasetId" type="hidden" value=""></input>
	<input class="clusterId" type="hidden" value=""></input>
	<div class="content"></div>
</div>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//save offset
	cw.ec("#<?php echo $id?> > div.content > div.block > div.content > div.offset > div.saveOffset",function(){
		var data = {};
		data.datasetId = $("#<?php echo $id?> > input.datasetId").val();
		data.clusterId = $("#<?php echo $id?> > input.clusterId").val();
		data.resultId = $(this).parent().parent().children("input.resultId").val();
		var stuff = $(this).parent().children("input.newOffset").val().split(":");
		data.offset = parseFloat(stuff[0])*60.0*60.0+parseFloat(stuff[1])*60.0+parseFloat(stuff[2]);
		//alert(offset);
		if(isNaN(data.offset) || (data.offset < 0.0))
		{
			alert("Time format error!");
		}
		$(this).parent().html('<div class="loading"></div>');
		cw.post(cw.url+"changeVideoSyncResult",data,function(result){
			$("#<?php echo $id?> > input.datasetId").change();
		});
	});
	//edit offset
	cw.ec("#<?php echo $id?> > div.content > div.block > div.content > div.offset > div.edit",function(){
		var offset = cw.sec2time($(this).parent().parent().children("input.offset").val());
		$(this).replaceWith('<input class="newOffset input-medium" type="text" value="'+offset+'"></input> <div class="btn btn-small btn-info saveOffset">Save</div> <div class="btn btn-small cancel">Cancel</div> ');
	});
	cw.ec("#<?php echo $id?> > div.content > div.block > div.content > div.offset > div.cancel",function(){
		var offsetBlock = $(this).parent();
		offsetBlock.children("input.newOffset").remove();
		offsetBlock.children("div.btn").remove();
		offsetBlock.append('<div class="btn btn-small edit">Edit</div>');
	});
	// delete a result
	cw.ec("#<?php echo $id?> > div.content > div.block > div.content > div.videotitle > div.delete",function(){
		var data = {};
		data.datasetId = $("#<?php echo $id?> > input.datasetId").val();
		data.clusterId = $("#<?php echo $id?> > input.clusterId").val();
		data.resultId = $(this).parent().parent().children("input.resultId").val();
		//alert(data.resultId);
		if(!confirm("Confirm delete this video in timeline?"))
		{
			return;
		}
		$(this).parent().html("<div class='wrapLoading'><div class='loading'></div></div>");
		cw.post(cw.url+"deleteVideoSyncResult",data,function(result){
			$("#<?php echo $id?> > input.datasetId").change();
		});
	});
	cw.ech("#<?php echo $id?> > input.datasetId",function(){
		var data = {};
		data.datasetId = $(this).val();
		data.clusterId = $(this).parent().children("input.clusterId").val();
		cw.post(cw.url+"getVideoSyncResult",data,function(result){
			$("#<?php echo $id?> > div.content").html("");
			if(result.status == 0)
			{
				//alert(result.videos.length);
				for(var i =0;i<result.videos.length;++i)
				{
					var rightStr = i%2==0?"":"right";
					var count = i+1;
					var video = result.videos[i];
					var temp  = $('<div class="block">'+
						//a round thing
						'<div class="pin"></div>'+
						'<div class="content '+rightStr+'">'+
							'<input class="resultId" type="hidden" value="'+video.resultId+'"></input>'+
							'<input class="offset" type="hidden" value="'+video.offset+'"></input>'+
							'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
							'<div class="imgs"><div class="wrapLoadng">No Preview Images Available</div></div>'+
							'<div class="videotitle"><span class="count">'+count+"</span>. "+
								'<a style="text-decoration:none" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncPairView?showBackLink=0&dvId='+video.dvId+'&datasetId='+result.datasetId+'&forLabeling='+result.forLabeling+'&videoname='+encodeURIComponent(video.videoname)+'" target="_blank">'+video.videoname+"</a>"+
								' <a class="watch" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname='+video.videoname+'"><i class="icon-eye-open"></i></a>'+
								'<div class="delete close">&times;</div>'+
								//'<div class="refine">Confirmed Correct '+video.correct+', wrong '+video.wrong+'</div>'+
								(video.correct >0?'<div class="refine">Confirmed '+video.correct+' Syncs</div>':"")+
							'</div>'+
							'<div class="offset '+rightStr+'">'+
								'<span class="text">'+cw.sec2time(video.offset)+'</span><br/>'+
								'<div class="btn btn-small edit">Edit</div>'+
							'</div>'+
						'</div>'+
						'<div style="clear:both"></div>'+
						'</div>');
					if(video.hasImgs == 1)
					{
						
						temp.find("div.imgs").html("");
						for(var j =0;j<video.imgCount;++j)
						{
							temp.find("div.imgs").append('<img class="videoImg" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname+"_"+j+'.png"></div>');
						}
					}
					$("#<?php echo $id?> > div.content").append(temp);
				}
			}
		});
	});
</script>