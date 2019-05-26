<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{
		width:auto;
		white-space:nowrap;
		border:1px rgb(210,210,210) solid;
		border-radius:5px;
		min-height:200px;
	}
	#<?php echo $id;?> > div.main{
		display:none;
		position:relative
	}
	#<?php echo $id;?> > div.main > div.title{
		padding-top:5px;
		text-align:center;
		color:gray;
		font-weight:bold;
	}
	#<?php echo $id;?> > div.main > div.block{
		float:left;
		width:250px;
		padding-top:5px;
	}
	#<?php echo $id;?> > div.main > div.block.collection{
		padding-top:50px;
	}
	#<?php echo $id;?> > div.main > div.block.collection > div.line{
		padding:5px 15px;
		padding-right:60px;
		white-space:normal;
		word-break:break-all;
	}
	#<?php echo $id;?> > div.main > div.block.collection > div.line > a.btn{
		margin-bottom:5px;
	}
	#<?php echo $id;?> > div.main > div.block.collection > div.collectionName{
		font-weight:bold;
		font-size:1.1em;
	}
	#<?php echo $id;?> > div.main > div.block.collection > div.createTime{
		font-size:0.9em;
	}
	#<?php echo $id;?> > div.main > div.block.apps > div.bub{
		margin:0 10px;
		margin-left:30px;
		margin-right:15px;
		-moz-box-shadow:0 2px 3px #999;              
 	  -webkit-box-shadow:0 2px 3px #999;           
 	   box-shadow:0 2px 3px #999;
 	   border-radius:5px;
 	   border:1px silver solid;
 	   height:45px;
 	   margin-bottom:15px;
 	   padding:10px;
 	   position:relative;
	}
	#<?php echo $id;?> > div.main > div.block.apps > div.bub > div.ctr{
		position:absolute;
		bottom:10px;
		right:10px;
		text-align:right;
	}
	#<?php echo $id;?> > div.main > div.block > div.bub > div.line{
		padding:2px 0;
	}
	#<?php echo $id;?> > div.main > div.block.apps > div.bub.sync,
	#<?php echo $id;?> > div.main > div.block.apps > div.bub.loc{
		border-top:3px red solid;
	}
	#<?php echo $id;?> > div.main > div.block > div.bub > div.title{
		font-weight:bold;
		text-align:left;
	}
	#<?php echo $id;?> > div.main > div.block.apps > div.bub > div.status{

	}
	#<?php echo $id;?> > div.main > div.block.player > div.bub,
	#<?php echo $id;?> > div.main > div.block.tiler > div.bub
	{
		margin:0 5px;
		margin-left:35px;
		-moz-box-shadow:0 2px 3px #999;              
 	  -webkit-box-shadow:0 2px 3px #999;           
 	   box-shadow:0 2px 3px #999;
 	   border-radius:5px;
 	   height:100px;
 	   margin-top:15px;
 	   padding:10px 5px;
 	   position:relative;
 	   border-top:3px gray solid;
	}#<?php echo $id;?> > div.main > div.block.apps > div.bub.other{
		border-top:3px gray solid;
	}
	#<?php echo $id;?> > div.main > div.block.player > div.bub > div.ctr,
	#<?php echo $id;?> > div.main > div.block.tiler > div.bub > div.ctr
	{
		position:absolute;
		bottom:5px;
		right:10px;
	}
	#<?php echo $id;?> > div.main > img.arrow1{
		position:absolute;
		top:70px;
		left:190px;
	}
	#<?php echo $id;?> > div.main > img.arrow4{
		position:absolute;
		top:105px;
		left:440px;
	}
	#<?php echo $id;?> > div.main > img.arrow5{
		position:absolute;
		top:105px;
		left:460px;
	}
	#<?php echo $id;?> > div.main > img.arrow2{
		position:absolute;
		top:80px;
		left:630px;
	}#<?php echo $id;?> > div.main > img.arrow3{
		position:absolute;
		top:90px;
		left:900px;
	}
</style>
<div id="<?php echo $id;?>">
	<input class="datasetId" type="hidden" value="<?php echo $datasetId?>"></input>
	<div class="wrapLoading" style="display:none"><div class='loading'></div></div>
	<div class="main">
		<img class="arrow1" src="<?php echo Yii::app()->theme->baseUrl?>/img/arrow1.png"></img>
		<img class="arrow2" src="<?php echo Yii::app()->theme->baseUrl?>/img/arrow2.png"></img>
		<img class="arrow3" src="<?php echo Yii::app()->theme->baseUrl?>/img/arrow3.png"></img>
		<img class="arrow4" src="<?php echo Yii::app()->theme->baseUrl?>/img/arrow4.png"></img>
		<img class="arrow5" src="<?php echo Yii::app()->theme->baseUrl?>/img/arrow5.png"></img>
		<div class="title">Video Analysis Pipeline
			<span class="close refresh" style="float:none;"><i class="icon-repeat" style="margin-top:5px;"></i></span>
		</div>
		<div class="block collection">
			<?php /* for collection detail  */ ?>
			<div class="line collectionName">
				<span class="collectionName">hahaawdawdawdwadawdawdawdwadawdawda</span>
				<span class="muted videoNum" style="display:none">3</span>
			</div>
			<div class="line collectionNote">d</div>
			<div class="line createTime muted">2015</div>
			<div class="line">
				<a class="btn btn-small videoList btn-warning" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?showWorkBoard=1&datasetId=<?php echo $datasetId?>" target="_self">Video List</a><br/>
				<a class="btn btn-small" href="<?php echo Yii::app()->baseUrl?>" target="_self">Main Page</a><br/>
				<!--
				<span class="muted">Detect:</span>
				<a class="btn btn-small btn-primary soundDetection" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId=" target="_self">Gunshot</a>
				<a class="btn btn-small btn-primary personDetection" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId=" target="_self">Crowd</a>
				-->
			</div>
		</div>
		<div class="block apps" style="width:400px;">
			<?php /* for sync and loc  */ ?>
			<div class="bub sync" style="margin-bottom:30px;">
				<div class="title line">Video Synchronization</div>
				<div class="status line">Status:
					<span class="status text-warning">Not Run</span>
				</div>
				<div class="ctr">
					<a class="btn btn-success btn-small run">Run/Refine</a>
				</div>
			</div>
			<div class="bub loc">
				<div class="title line">Video Localization</div>
				<div class="status line">Status:
					<span class="status text-warning">Not Run</span>
				</div>
				<div class="ctr">
					<a class="btn btn-success btn-small run">Run/Refine</a>
				</div>
			</div>
			<div class="bub other">
				<div class="title line">Other Analysis Tools</div>
				<div class="line">
					<a class="btn btn-small btn-primary soundDetection" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId=" target="_self">Gunshot Detection</a>
					<a class="btn btn-small btn-primary personDetection" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId=" target="_self">Crowd Counting</a>
				</div>
			</div>
		</div>
		<div class="block player">
			<?php /* for rashmon  */ ?>
			<div class="bub">
				<div class="title line">Video Player</div>
				<div class="line" style="width:80%">
					<img src="<?php echo Yii::app()->theme->baseUrl?>/img/rashmon.png"></img>
				</div>
				<div class="ctr">
					<a class="btn btn-small btn-info run">Watch</a>
				</div>
			</div>
		</div>
		<div class="block tiler" style="width:100px">
			<?php /* for video tiler  */ ?>
			<div class="bub">
				<div class="title line">Video <br/>Tiler</div>
				<div class="ctr">
					<a class="btn btn-small btn-info run">Run</a>
				</div>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	<?php if($datasetId!=""){ ?>
		$(document).ready(function(){
			$("#<?php echo $id?> > input.datasetId").change();
		});
		<?php } ?>
	// all the run button
	cw.ec("#<?php echo $id?> a.run",function(e){
		if($(this).hasClass("disabled"))
		{
			e.preventDefault();
		}
		else
		{
			window.open($(this).prop("href"),"_self");
		}
	});
	//refresh
	cw.ec("#<?php echo $id?> > div.main > div.title > span.refresh",function(){
		$("#<?php echo $id?> > input.datasetId").change();
	});
	cw.ech("#<?php echo $id?> > input.datasetId",function(){
		var data = {};
		data.datasetId = $(this).val();
		// change the link to video list
		$("#<?php echo $id?>  > div.main > div.block.collection > div.line > a.videoList").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?showWorkBoard=1&datasetId="+data.datasetId);
		//change button stuff's datasetId
		//1. person detection and sound detection
		$("#<?php echo $id?>  > div.main > div.block.apps > div.bub.other > div.line > a.personDetection").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?showWorkBoard=1&showVideoDetection=1&datasetId="+data.datasetId);
		$("#<?php echo $id?>  > div.main > div.block.apps > div.bub.other > div.line > a.soundDetection").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?showWorkBoard=1&showVideoDetection=1&datasetId="+data.datasetId);
		//sync,
		$("#<?php echo $id?>  > div.main > div.block.apps > div.sync > div.ctr > a.run").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSync?datasetId="+data.datasetId);
		//loc
		$("#<?php echo $id?>  > div.main > div.block.apps > div.loc > div.ctr > a.run").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoLoc?datasetId="+data.datasetId);
		//player
		$("#<?php echo $id?>  > div.main > div.block.player > div.bub > div.ctr > a.run").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoPlayer?datasetId="+data.datasetId);
		//video tiler
		$("#<?php echo $id?>  > div.main > div.block.tiler > div.bub > div.ctr > a.run").prop("href","<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoTiler?datasetId="+data.datasetId);
		$("#<?php echo $id?> > div.main").hide();
		$("#<?php echo $id?> > div.wrapLoading").show();
		cw.post(cw.url+"getDatasetProgressInfo",data,function(result){
			$("#<?php echo $id?> > div.main").show();
			$("#<?php echo $id?> > div.wrapLoading").hide();
			if(result.status == 0)
			{
				//set datasetinfo
				$("#<?php echo $id?>  > div.main > div.block.collection > div.collectionName > span.collectionName").html(result.dataset.name);
				$("#<?php echo $id?>  > div.main > div.block.collection > div.collectionName > span.videoNum").html(result.dataset.videoNum+" videos");
				$("#<?php echo $id?>  > div.main > div.block.collection > div.collectionNote").html(result.dataset.note);
				$("#<?php echo $id?>  > div.main > div.block.collection > div.createTime").html(result.dataset.createTime);
				//set the videoSync and video loc status, set the button able, and the top color
				if(result.runSync == 1)
				{
					$("#<?php echo $id?>  > div.main > div.block.apps > div.sync").css("borderTop","3px green solid").find("div.status > span.status").html("Done").end().find("div.ctr > a.run").removeClass("disabled");
				}
				else
				{
					$("#<?php echo $id?>  > div.main > div.block.apps > div.sync").css("borderTop","3px red solid").find("div.status > span.status").html("Not Run").end().find("div.ctr > a.run").removeClass("disabled");
				}
				if(result.runLoc == 1)
				{
					$("#<?php echo $id?>  > div.main > div.block.apps > div.loc").css("borderTop","3px green solid").find("div.status > span.status").html("Done").end().find("div.ctr > a.run").removeClass("disabled");
				}
				else
				{
					$("#<?php echo $id?>  > div.main > div.block.apps > div.loc").css("borderTop","3px red solid").find("div.status > span.status").html("Not Run").end().find("div.ctr > a.run").removeClass("disabled");
				}
				//video player
				if(result.canPlay == 1)
				{
					$("#<?php echo $id?>  > div.main > div.block.player > div.bub").css("borderTop","3px green solid").find("div.ctr > a.run").removeClass("disabled");
				}
				else
				{
					$("#<?php echo $id?>  > div.main > div.block.player > div.bub").css("borderTop","3px gray solid").find("div.ctr > a.run").addClass("disabled");
				}
				//video tiler
				if(result.canTiler == 1)
				{
					$("#<?php echo $id?>  > div.main > div.block.tiler > div.bub").css("borderTop","3px green solid").find("div.ctr > a.run").removeClass("disabled");
				}
				else
				{
					$("#<?php echo $id?>  > div.main > div.block.tiler > div.bub").css("borderTop","3px gray solid").find("div.ctr > a.run").addClass("disabled");
				}

			}
		});
	});
	
</script>