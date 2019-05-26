<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type='text/css'>
#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
#cIndex{
		position:relative;
		padding-left:5%;
	}
	#cIndex > div.datasetVideos > div.instruction{
		font-weight:bold;
		padding:10px 0;
	}
	#cIndex > div.datasetList,
	#cIndex > div.datasetVideos{
			
		padding-top:20px;
		padding-bottom:0px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
		
	}
	#cIndex > div.datasetList > div.block,
	#cIndex > div.datasetVideos > div.block,
	#cIndex > div.datasetVideos > div.more,
	#cIndex > div.datasetList > a.block{
		padding:10px;
		margin:0 16px 16px 0;
		background-color:white;
		border:1px silver solid;
		-moz-box-shadow:0 4px 4px silver;              
 	   -webkit-box-shadow:0 4px 4px silver;           
 	   box-shadow:0 4px 4px silver;
		width:21%;
		border-radius:5px;
		float:left;
		height:auto!important;
		height:120px;
		min-height:120px;
		max-height:120px;
		overflow:hidden;
		cursor:pointer;
		position:relative;
	}
	#cIndex > div.datasetList > a.block{
		color:rgb(0,128,192);
		text-decoration:none;
	}
	#cIndex > div.datasetList > a.block:hover{
		color:rgb(0,128,192);
	}
	#cIndex > div.datasetList > a.block > div.appName,
	#cIndex > div.datasetList > div.block > div.datasetname{
		text-align:center;
		font-weight:bold;
		font-size:1.1em;
		word-break:break-all;
		padding-top:40px;
		color:rgb(0,128,192);
	}
	#cIndex > div.datasetVideos > div.more{
		font-size:1.2em;
		font-weight:bold;
		color:gray;
		text-align:center;padding-top:50px;
		height:auto!important;
		height:80px;
		min-height:80px;
	}
	@media screen and (max-device-width:500px)
	{
		#cIndex{
			padding-left:10px;	
		}
		#cIndex > div.datasetList > div.block,
		#cIndex > div.datasetVideos > div.block,
		#cIndex > div.datasetVideos > div.more,
		#cIndex > div.datasetList > a.block{
			padding:10px;
			margin:0 0px 16px 0;
			width:90%;
			border-radius:4px;
		}
		
	}
	#cIndex > div.datasetVideos > div.filters{
		padding:20px 0;
	}
	#cIndex > div.datasetVideos > div.block > div.thumbnailx{
		float:left;
		width:125px;
	}
	#cIndex > div.datasetVideos > div.block > div.thumbnailx > img{
		max-width:120px;
	}
	#cIndex > div.datasetVideos > div.block > div.right{
		margin:0 0 0 130px;
		font-size:0.9em;
		font-weight:bold;
		padding-bottom:5px;
		line-height:25px;
		word-break:break-all;
	}
	/*#cIndex > div.datasetVideos > div.block > div.right > audio*/
	#cIndex > div.datasetVideos > div.block > div.thumbnailx > audio{
		width:40px;
		margin:10px 0px;
	}
	#cIndex > div.datasetList > div.block > div.datasetName{
		font-size:1.2em;
		font-weight:bold;
		padding-bottom:5px;
		word-break:break-all;
	}
	#cIndex > div.datasetList > div.block > div.datasetIntro{
		font-size:1em;
		color:rgb(220,220,220);
		word-break:break-all;
		display:none;
	}
	#cIndex > div.datasetList > div.block:hover > div.spe,
	#cIndex > div.datasetList > div.block:hover > div.timeline,
	#cIndex > div.datasetVideos > div.block:hover > div.spe,
	#cIndex > div.datasetVideos > div.block:hover > div.timeline
	{
		display:block;
	}
	#cIndex > div.datasetList > div.block > div.spe,
	#cIndex > div.datasetList > div.block > div.timeline,
	#cIndex > div.datasetVideos > div.block > div.spe,
	#cIndex > div.datasetVideos > div.block > div.timeline{
		position:absolute;
		top:10px;
		right:10px;
		width:15px;
		height:15px;
		padding:12px;
		border-radius:5px;
		background-color:white;
		cursor:pointer;
		display:none;
		z-index:99;
	}
	#cIndex > div.datasetList > div.block:hover > div.timeline
	{
		top:54px;
	}
	#cIndex > div.datasetVideos > div.block:hover > div.timeline
	{
		top:60px;
		left:10px;
	}

	#cIndex > div.videoPairs{
		padding-top:50px;
	}
	#cIndex > div.videoPairs > div.left{
		position:fixed;
		top:10%;
		left:0%;
		padding-left:5px;
		width:50%;
		text-align:center;
	}
	#cIndex > div.videoPairs > div.left > div.srcVideo > video{
		width:100%;
	}
	#cIndex > div.videoPairs > div.right{
		margin:0 0 0 50%;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block{
		width:100%;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > video{
		width:100%;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > input.offset{
		width:40px;
		margin:0;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cIndex > div.videoPairs > div.left > div.segmentTools,
	#cIndex > div.videoPairs > div.left > div.labelTools{
		text-align:left
	}
	#cIndex > div.videoPairs > div.left > div.segmentTools > div.title,
	#cIndex > div.videoPairs > div.left > div.labelTools > div.title{
		padding:5px 0;
		font-weight:bold;
	}
	#cIndex > div.videoPairs > div.left > div.labelTools > div.ctr{
		padding:20px;
		text-align:center;
	}
	#cIndex > div.videoPairs > div.left > div.segmentTools input{margin:0}
	#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment{
		padding:0px 20px;
		line-height:40px;
	}
	#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList{
		padding:2px 20px;
		background-color:rgb(220,220,220);
		overflow:auto;
		height:100px;
	}
	#cIndex > div.datasetList > a.block{
		position:relative;
	}
	#cIndex > div.datasetList > a.block > div.addonBlock{
		position:absolute;
		bottom:30px;
		right:30px;
	}
</style>
<script type="text/javascript">
//click a addonBlock, jump tp data-href 
cw.ec("#cIndex > div.datasetList > a.block > div.addonBlock",function(e){
	e.stopPropagation();
	var href = $(this).data("href");
	//alert(href);
	window.open(href,"_self");
});
	$(document).ready(function(){
		//$("#cIndex > input.gotoDatasetList").change();
		//goTo("datasetList");
		$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSync" target="_self">'+
						'<div class="appName">Audio Synchronization Tool</div>'+
						'<div class="btn btn-success btn-small addonBlock" data-href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncRunList">Run List</div>'+
					'</a>');
		// add some direct link to other app
		$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshot" target="_self">'+
				'<div class="appName">Gunshot Detection Tool'+
				'</div>'+
			'</a>');
		$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cCrowdCounting" target="_self">'+
				'<div class="appName">Crowd Counting Tool</div>'+
			'</a>');
		$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cPersonDetection" target="_self">'+
				'<div class="appName">Person Detection Tool</div>'+
			'</a>');
		<?php // if(Yii::app()->session['userLevel'] > 2){ ?>
		$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWell" target="_self">'+
				'<div class="appName">WEbly Learning Tool</div>'+
			'</a>');
		<?php // } ?>
		<?php foreach($AudioSyncs as $AudioSync){ ?>
			$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $AudioSync->id?>" target="_self">'+
				'<div class="appName">Exp: <?php echo $AudioSync->runName?></div>'+
			'</a>');
		<?php } ?>
		<?php foreach($GunshotExps as $GunshotExp){ ?>
			$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $GunshotExp->id?>" target="_self">'+
				'<div class="appName">Exp: <?php echo $GunshotExp->runName?></div>'+
			'</a>');
		<?php } ?>
		<?php foreach($VideoCutExps as $VideoCutExp){ ?>
			$("#cIndex > div.datasetList").append('<a class="block app" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $VideoCutExp->id?>" target="_self">'+
				'<div class="appName">Exp: <?php echo $VideoCutExp->name?></div>'+
			'</a>');
		<?php } ?>
	});

//--------------------------------not used in the main page now



	cw.ech("#cIndex > input.gotoDatasetList",function(){
		//get dataset list
		getDatasetList();
		goTo("datasetList");
	});
	function goTo(divClass)
	{
		$("#cIndex > div").hide();
		$("#cIndex > div."+divClass).show();
	}
	function getDatasetList()
	{

		var data = {};
		$("#siteHeader > input.loading").change();
		cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getDatasetList",data,function(result){
			$("#siteHeader > input.stopLoading").change();
			$("#cIndex > div.datasetList").html("");
			if(result.status == 0)
			{
				for(var i =0;i<result.datasets.length;++i)
				//for(var i =0;i<1;++i)// show the first , temporary
				{
					$("#cIndex > div.datasetList").append('<div class="block">'+
						'<input class="datasetId" type="hidden" value="'+result.datasets[i].id+'"></input>'+
						'<input class="isImported" type="hidden" value="'+result.datasets[i].isImported+'"></input>'+
						'<div class="datasetname">'+result.datasets[i].name+'</div>'+
						'<div class="spe">'+
							'<i class="icon-folder-open"></i>'+
						'</div>'+
						/*
						<div class="timeline">
							<i class="icon-eye-open"></i>
						</div>
						*/
					'</div>');
				}
				

			}
		});
	}
	// click a dataset
		//get videos
	cw.ec("#cIndex > div.datasetList > div.block",function(){
		goTo("datasetVideos");
		var data = {};
		data.datasetId = $(this).children("input.datasetId").val();
		data.forLabeling = $(this).children("input.isImported").val();
		$("#siteHeader > input.loading").change();
		$("#cIndex > div.datasetVideos").html("");
		$("#cIndex > input.datasetId").val(data.datasetId);
		cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getDatasetVideos?start=2&limit=10&sign=0&forLabeling="+data.forLabeling,data,function(result){
			$("#siteHeader > input.stopLoading").change();
			if(result.status == 0)
			{
				// append a instruction
				$("#cIndex > div.datasetVideos").html('<div class="instruction">'+
						'All synchronization results for each video are listed here, where each block contains the video name and the number is the synchronization confidence. Click the block to see synchronization results for that video. On the left will be the query video and on the right are the synchronized candidate videos.'+
					'</div>');
				if(result.forLabeling == 1)
				{
					// add filter in the front
					$("#cIndex > div.datasetVideos").append(
						'<div class="filters">'+
							'<input class="datasetId" type="hidden" value="'+result.datasetId+'"></input>'+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=0></input>'+
								'Not labeled' +' ('+result.stat['sign0']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=1></input>'+
								'correct' +' ('+result.stat['sign1']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=2></input>'+
								'correct actual' + ' ('+result.stat['sign2']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=-1></input>'+
								'wrong' +' ('+result.stat['sign-1']+')'+
							'</div> '+
							'<a class="btn btn-small btn-warning download" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/main/downloadLabel?datasetId='+result.datasetId+'">download</a>'+
						'</div>'
					);
					$("#cIndex > div.datasetVideos").find("div.filters > div.btn > input.sign[value='"+result.sign+"']").parent().addClass("btn-success");
				}
				addToDatasetVideos(result);
			}
		});
	});
	// click different filter
	cw.ec("#cIndex > div.datasetVideos > div.filters > div.btn",function(){
		goTo("datasetVideos");
		var data = {};
		data.datasetId = $(this).parent().children("input.datasetId").val();
		data.forLabeling = 1;
		var sign = $(this).children("input.sign").val();
		$("#siteHeader > input.loading").change();
		$("#cIndex > div.datasetVideos").html("");
		$("#cIndex > input.datasetId").val(data.datasetId);
		cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getDatasetVideos?start=2&limit=10&sign="+sign+"&forLabeling="+data.forLabeling,data,function(result){
			$("#siteHeader > input.stopLoading").change();
			if(result.status == 0)
			{
				if(result.forLabeling == 1)
				{
					// add filter in the front
					$("#cIndex > div.datasetVideos").append(
						'<div class="filters">'+
							'<input class="datasetId" type="hidden" value="'+result.datasetId+'"></input>'+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=0></input>'+
								'Not labeled' + ' ('+result.stat['sign0']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=1></input>'+
								'correct' + ' ('+result.stat['sign1']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=2></input>'+
								'correct actual' + ' ('+result.stat['sign2']+')'+
							'</div> '+
							'<div class="btn btn-small" >'+
								'<input class="sign" type="hidden" value=-1></input>'+
								'wrong' + ' ('+result.stat['sign-1']+')'+
							'</div> '+
							'<a class="btn btn-small btn-warning download" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/main/downloadLabel?datasetId='+result.datasetId+'">download</a>'+
						'</div>'
					);
					$("#cIndex > div.datasetVideos").find("div.filters > div.btn > input.sign[value='"+result.sign+"']").parent().addClass("btn-success");
				}
				addToDatasetVideos(result);
			}
		});
	});
	//click more video
	cw.ec("#cIndex > div.datasetVideos > div.more",function(){
		goTo("datasetVideos");
		var data = {};
		data.datasetId = $(this).children("input.datasetId").val();
		data.forLabeling = 1;
		var sign = $(this).children("input.sign").val();
		var start = $(this).children("input.start").val();
		$("#siteHeader > input.loading").change();
		$("#cIndex > input.datasetId").val(data.datasetId);
		$(this).html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getDatasetVideos?start="+start+"&limit=10&sign="+sign+"&forLabeling="+data.forLabeling,data,function(result){
			$("#siteHeader > input.stopLoading").change();
			$(this).remove();
			if(result.status == 0)
			{
				addToDatasetVideos(result);
			}
		},$(this));
	});
	function addToDatasetVideos(result)
	{
		for(var i=0;i<result.videos.length;++i)
		//for(var i=0;i<13;++i)
		{
			$("#cIndex > div.datasetVideos").append('<div class="block">'+
				'<input class="forLabeling" value="'+result.forLabeling+'" type="hidden"></input>'+
				'<input class="dvId" type="hidden" value="'+result.videos[i].dvId+'"></input>'+
				'<input class="datasetId" type="hidden" value="'+result.videos[i].datasetId+'"></input>'+
				(((result.videos[i].thumbnailPath != "") && (result.videos[i].signAudioPath != ""))?(
				'<div class="thumbnailx">'+
					'<img src="<?php echo Yii::app()->baseUrl?>/'+result.videos[i].thumbnailPath+'"></img>'+
					'<audio controls>'+
						'<source src="<?php echo Yii::app()->baseUrl?>/'+result.videos[i].signAudioPath+'"></source>'+
						"Your browser does not support the audio element."+
					'</audio>'+
				'</div>'
				):"")+
				'<div class="right">'+
					'<div class="videoname">'+result.videos[i].videoname+'</div>'+
					"<span class='text-error'>"+parseFloat(result.videos[i].rankScore).toFixed(2)+"</span><br/>"+
					/*"Signature: "+
					'<audio controls>'+
						'<source src="<?php echo Yii::app()->baseUrl?>/'+result.videos[i].signAudioPath+'"></source>'+
						"Your browser does not support the audio element."+
					'</audio>'+
					*/
				'</div>'+
				/*
				'<div class="spe">'+
					'<i class="icon-folder-open"></i>'+
				'</div>'+
				
				
				'<div class="timeline">'+
					'<i class="icon-eye-open"></i>'+
				'</div>'+
				*/
			'</div>');
		}
		//if for labelling, 
		//     check if add a block to load more
		if(result.forLabeling == 1)
		{
			if(result.videos.length >= 10)
			{
					// add a block to click for more video, with current last dvId
				$("#cIndex > div.datasetVideos").append(
					'<div class="more">'+
						'<input class="datasetId" type="hidden" value="'+result.datasetId+'"></input>'+
						'<input class="start" type="hidden" value="'+result.videos[result.videos.length-1].rankScore+'"></input>'+
						'<input class="sign" type="hidden" value="'+result.sign+'"></input>'+
						"More"+
					'</div>'
				);
			}
		}
	}
//click a video, get the er_pair
var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
//create source now.
var videoSource = null;
var srcAnalyser = null;// analyser for src video
var top1Analyser = null;//analyser for top 1 des video
cw.ec("#cIndex > div.datasetVideos > div.block",function(){
	//whether to show search.
	var forLabeling = $(this).children("input.forLabeling").val();
	var data = {};
	data.dvId = $(this).children("input.dvId").val();
	if(forLabeling == 0)
	{
		$("#cIndex > div.videoPairs > div.left > div.segmentTools").show();
		$("#cIndex > div.videoPairs > div.left > div.labelTools").hide();
		getSegmentList(data.dvId);
	}
	else
	{
		$("#cIndex > div.videoPairs > div.left > div.segmentTools").hide();
		$("#cIndex > div.videoPairs > div.left > div.labelTools").show();
		getLabelResult(data.dvId);
	}
	data.datasetId = $(this).children("input.datasetId").val();
	//alert(data.datasetId);
	goTo("videoPairs");
	$("#siteHeader > input.loading").change();
	$("#cIndex > div.videoPairs > div.right > div.videoList").html("");
	$("#cIndex > div.videoPairs > div.left > div.srcVideo").html("");
	//clean up video source
	videoSource = {};// video.name -> source
	resetCtrDV();
	cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getResultsER?forLabeling="+forLabeling,data,function(result){
		$("#siteHeader > input.stopLoading").change();
		if(result.status == 0)
		{
			// load video info first
			$("#cIndex > div.videoPairs > div.left > div.srcVideo").html(
				'<input class="videoname" value="'+result.videoInfo.videoname+'" type="hidden"></input>'+
				'<input class="dvId" value="'+result.videoInfo.dvId+'" type="hidden"></input>'+
				'<video controls>'+
				'<source src="<?php echo Yii::app()->baseUrl?>/'+result.videoInfo.relatedPath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video><br/>'+result.videoInfo.videoname);
			videoSource[result.videoInfo.videoname] = {
				"source":audioCtx.createMediaElementSource($("#cIndex > div.videoPairs > div.left > div.srcVideo > video").get(0)),
				"object":$("#cIndex > div.videoPairs > div.left > div.srcVideo > video").get(0)
			};
			merger = audioCtx.createChannelMerger(2);

			videoSource[result.videoInfo.videoname]['source'].connect(merger,0,0);//has to connect to something now, or can't play

			//for audio visualization
			/*
			//bind the source for every des below
			srcAnalyser = audioCtx.createAnalyser();
			videoSource[result.videoInfo.videoname]['source'].connect(srcAnalyser);
			bindAudioV("#audioForSrc",srcAnalyser,videoSource[result.videoInfo.videoname]['object'],"black");
			*/

			bindCallbacks(videoSource[result.videoInfo.videoname]['object']);

			merger.connect(audioCtx.destination);
			//load videoList, hide all first,
			for(var i=0;i<result.ranklist.length;++i)
			{
				var video = result.ranklist[i];
				var temp = $('<div class="block">'+
					'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
					'<input class="erId" type="hidden" value="'+video.erId+'"></input>'+
					'<input class="score" type="hidden" value="'+parseFloat(video.confidence).toFixed(4)+'"></input>'+
					//'<input class="offset" type="hidden" value="'+video.offset+'"></input>'+
					'<video controls>'+
					'<source src="<?php echo Yii::app()->baseUrl?>/'+video.relatedPath+'"></source>'+
						'Your browser does not support the video tag.'+
					'</video>'+
					'<div class="ctr" style="position:relative;">'+
						'<canvas id="audioVForSrc'+i+'" style="height:140px;position:absolute;z-index:1;top:30px;left:0;width:150px;"></canvas>'+
						'<canvas id="audioVForDes'+i+'" style="height:140px;position:absolute;z-index:2;top:30px;left:0;width:150px;"></canvas>'+
						'<span class="text-error videoname">'+video.videoname+'</span> '+
						'<span class="text-warning score">('+parseFloat(video.confidence).toFixed(4)+')</span><br/>'+
						//'offset: <span class="text-error offset"></span><br/>'+
						'<i class="co icon-plus"></i> '+
						'offset: <input class="offset input-small" type="text" value="'+video.offset+'"></input> (s) '+
						'<i class="co icon-minus"></i><br/> '+
						(video.autoOffset!=null?"<span class='text-warning autoOffset'>Automatic: "+video.autoOffset+" (s)</span>":"" )+
						'<br/>'+
						'<div class="btn btn-info playSync">play sync</div> <div class="btn btn-info stop">stop all</div> '+
						'<div class="btn saveOffset">saveOffset</div>'+
						((result.forLabeling!=1)?"":
							'<br/><div class="btn correct btn-success">correct</div> '+
							'<div class="btn correctD btn-success">correct duplicate</div> '+
							'<div class="btn wrong btn-danger">wrong</div> '+
							'<div class="btn reset">reset</div> '
						)+
						'<span class="text-error errorInfo"></span>'+
					'</div>'+
				'</div>');
				if(result.forLabeling == 1)
				{
					// set label color
					if(video.mark == 1)
					{
						setBorderColor(temp.find("div.ctr"),"green");
					}
					else if(video.mark == 2)
					{
						setBorderColor(temp.find("div.ctr"),"rgb(0,200,0)");
					}
					else if(video.mark == -1)
					{
						setBorderColor(temp.find("div.ctr"),"red");
					}
					else
					{
						//setBorderColor(temp.find("div.ctr"),"green");
					}
				}
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource(temp.find("video").get(0)),
					"object":temp.find("video").get(0)
				};
				videoSource[video.videoname]['source'].connect(merger,0,1);//has to connect to something now, or can't play
				$("#cIndex > div.videoPairs > div.right > div.videoList").append(temp);
				// visualize top 1 video audio
				//if(i == 0)//all have visual now

				if(true)
				{
					srcAnalyser = audioCtx.createAnalyser();
					videoSource[result.videoInfo.videoname]['source'].connect(srcAnalyser);
					bindAudioV("#audioVForSrc"+i,srcAnalyser,videoSource[result.videoInfo.videoname]['object'],"rgba(0,0,0,0.7)");
					top1Analyser = audioCtx.createAnalyser();
					videoSource[video.videoname]['source'].connect(top1Analyser);
					bindAudioV("#audioVForDes"+i,top1Analyser,videoSource[video.videoname]['object'],"rgba(255,175,0,0.9)");
				}
			}
			//getVideoInfo();
		}
	});
});
function showAudioV(canvasId,analyser,color)
{
	var canvas = $(canvasId).get(0);
	var canvasCtx = canvas.getContext("2d");
	 WIDTH = canvas.width;
  	HEIGHT = canvas.height;
  	/*
  	// this is for a sound wave
	 analyser.fftSize = 2048;
	 var bufferLength = analyser.fftSize;
	 var dataArray = new Uint8Array( analyser.fftSize);
	 canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

    function draw() {

      drawVisual = window.requestAnimationFrame(draw);// this will fire 

      analyser.getByteTimeDomainData(dataArray);

      canvasCtx.fillStyle = 'rgb(200, 200, 200)';
      canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);

      canvasCtx.lineWidth = 2;
      canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

      canvasCtx.beginPath();

      var sliceWidth = WIDTH * 1.0 / bufferLength;
      var x = 0;

      for(var i = 0; i < bufferLength; i++) {
   
        var v = dataArray[i] / 128.0;
        var y = v * HEIGHT/2;

        if(i === 0) {
          canvasCtx.moveTo(x, y);
        } else {
          canvasCtx.lineTo(x, y);
        }

        x += sliceWidth;
      }

      canvasCtx.lineTo(canvas.width, canvas.height/2);
      canvasCtx.stroke();
    };

    draw();
    */
	analyser.fftSize = 256;
    var bufferLength = analyser.frequencyBinCount;
    var dataArray = new Uint8Array(bufferLength);

    canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

    function draw() {
      drawVisual = window.requestAnimationFrame(draw);//fireing every some time

      analyser.getByteFrequencyData(dataArray);

      //canvasCtx.fillStyle = 'rgb(0, 0, 0)';
     // canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
      canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);
      var barWidth = (WIDTH / bufferLength) * 2.5;
      var barHeight;
      var x = 0;

      for(var i = 0; i < bufferLength; i++) {
        barHeight = dataArray[i];

        canvasCtx.fillStyle = color;
        canvasCtx.fillRect(x,HEIGHT-barHeight/2,barWidth,barHeight/2);

        x += barWidth + 1;
      }
    };

    draw();
    
}
function bindAudioV(canvasId,analyser,videoObject,color)
{
	$(videoObject).on("play",function(){
		showAudioV(canvasId,analyser,color);
	});
}
cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
//save the new offset
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.saveOffset",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.erId = $(this).parent().parent().children("input.erId").val();
	data.offset = $(this).parent().children("input.offset").val();
	//alert(data.erId);
	$(this).parent().children("span.errorInfo").html('<div class="loading"></div>');
	$(this).addClass("disabled");
	cw.post(cw.url+"saveOffset",data,function(result){
		$(this).removeClass("disabled");
		if(result.status==0)
		{
			$(this).parent().children("span.errorInfo").html('revised');
		}
	},$(this));
});

// change the offset a bit
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > i.co",function(){
	var curOffset = parseFloat($(this).parent().children("input.offset").val());
	if($(this).hasClass("icon-plus"))
	{
		curOffset+=0.2;
	}
	else
	{
		curOffset-=0.2;
	}
	$(this).parent().children("input.offset").val(curOffset.toFixed(1));
});
function stopAll()
{
	for(var videoname in videoSource)
	{
		videoSource[videoname]['object'].pause();
	}
}
//play together
var merger = null;
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.playSync",function(){
	
	//get the offset first
	var offset = parseFloat($(this).parent().children("input.offset").val());
	var baseVideoSource = videoSource[$("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val()]['source'];
	var baseVideoObject = videoSource[$("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val()]['object'];
	var thisVideoSource = videoSource[$(this).parent().parent().children("input.videoname").val()]['source'];
	var thisVideoObject = videoSource[$(this).parent().parent().children("input.videoname").val()]['object'];
	//var source1 = audioCtx.createMediaElementSource(videoObj1);//can only create once
	//var source2 = audioCtx.createMediaElementSource(videoObj2);// a meida element audio source
	if(merger != null)
	{
		//disconnect previous, other wise it get louder and louder
		merger.disconnect(audioCtx.destination);
	}
	merger = audioCtx.createChannelMerger(2);//Each input(multi-channel) is used to fill a channel of the output. 
	//alert(source1.channelCount); //2
	//alert(source1.numberOfInputs); //0
	//alert(source1.numberOfOutputs); //1
	//input , output -> multi channel in one output
	thisVideoSource.connect(merger,0,1);//(audioNode,outputIndexOftheSource, inputIndexOfMerger)

	baseVideoSource.connect(merger,0,0);

	merger.connect(audioCtx.destination);
	baseVideoObject.currentTime = 0.0;
	thisVideoObject.currentTime = 0.0;

	//alert(offset);
	if(offset > 0)
	{
		//video in the videolist will play first
		//add a #t=offset to the src
		//var ori_src = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src");
		//alert(ori_src);
		// strip out the # from before
		//$("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src",ori_src+"#t="+offset+",");
		thisVideoObject.currentTime = offset;	
	}
	else
	{
		baseVideoObject.currentTime = -offset;	
	}
	stopAll();
	baseVideoObject.play();
	thisVideoObject.play();
});
//stop all video
cw.ec("#cIndex > div.videoPairs > div.left > div.ctr > div.stop,#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.stop",function(){
	stopAll();
});
/*
function getVideoInfo()// for videoList
{
	var videoname = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.videoname").val();
	var offset = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.offset").val();
	var score = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.score").val();
	$("#cIndex > div.videoPairs > div.right > div.ctr").children("span.videoname").html(videoname)
		.end().children("span.score").html(score)
		.end().children("span.offset").html(offset);
}*/
//play the video
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play",function(){
	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	videoObject.play();
	$(this).removeClass("play").addClass("pause").html("pause");
	///playingLabel = false;stopAt = -1;
});
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.pause",function(){
	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	videoObject.pause();
	$(this).removeClass("pause").addClass("play").html("play");
	///playingLabel = false;stopAt = -1;
});
//hold the button to get play time
var labeling = false;
var labelArr = {};
cw.edown("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling",function(){
	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	labeling = true;
	labelArr.start = videoObject.currentTime;
	labelArr.end = -1;
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play").trigger(cw.ectype);
	$(this).addClass("btn-danger").html("getting...");
});
$(document).delegate("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling","mouseleave",function(){
	if(labeling)
	{
		$(this).trigger('mouseup');
	}
});
cw.eup("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling",function(){
	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	if(labeling)
	{
		labelArr.end = videoObject.currentTime;
		if(labelArr.start < labelArr.end)			
		{
			addSegmentTime(labelArr.start,labelArr.end);
		}
	}
	labelArr = {};
	labeling = false;
	$(this).removeClass("btn-danger").html("GetTime");
});
//play segment
var playingLabel = false;
var stopAt = -1;

//var intervalForSrcAudio;
//the visualization of src video is canvas#audioForSrc

function bindCallbacks(videoObject)// for the source video only
{
	
	$(videoObject).on("pause",function(){
		$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.pause").removeClass("pause").addClass("play").html("play");
	});
	$(videoObject).on("play",function(){
		$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play").addClass("pause").removeClass("play").html("pause");
	});
	/*
	videoObject.onpause = function(){
		$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.pause").removeClass("pause").addClass("play").html("play");
		//clearInterval(intervalForSrcAudio);
	};
	videoObject.onplay = function(){
		$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play").addClass("pause").removeClass("play").html("pause");
		//get the audio visualization
		//intervalForSrcAudio = setInterval(function(){
		//	showSrcAudioV();// every 20 ms show the srcAudio visualization
		//},20);
	};*/
	//playback binding
	$(videoObject).on("timeupdate",function(){
		//alert(this.currentTime);
		//this.pause();
		if(playingLabel && (stopAt-this.currentTime < 0.4))
		{
			stopAll();
			playingLabel = false;
			stopAt = -1;
		}
	});	
}
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > div.play",function(){
	var start = parseFloat($(this).parent().children("input.start").val());
	var end = parseFloat($(this).parent().children("input.end").val());
	
	if(isNaN(start) || isNaN(end) || (start<0) || (end<0))
	{
		alert("illegal start or end");
	}
	stopAt = end;
	playingLabel = true;

	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	videoObject.currentTime = start;
	videoObject.play();
});
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > div.playTogether",function(){
	//play the segment of this video , along with the best result
	var start = parseFloat($(this).parent().children("input.start").val());
	var end = parseFloat($(this).parent().children("input.end").val());
	var otherVideoName = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block").eq(0).children("input.videoname").val();
	var offset = parseFloat($("#cIndex > div.videoPairs > div.right > div.videoList > div.block").eq(0).find("div.ctr > input.offset").val());
	//alert(offset);
	//return;
	if(isNaN(start) || isNaN(end) || (start<0) || (end<0) || (otherVideoName == ""))
	{
		alert("illegal start or end");
	}
	

	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	//get the offset first

	var baseVideoSource = videoSource[videoname]['source'];
	var baseVideoObject = videoObject;
	var thisVideoSource = videoSource[otherVideoName]['source'];
	var thisVideoObject = videoSource[otherVideoName]['object'];
	//var source1 = audioCtx.createMediaElementSource(videoObj1);//can only create once
	//var source2 = audioCtx.createMediaElementSource(videoObj2);// a meida element audio source
	if(merger != null)
	{
		//disconnect previous, other wise it get louder and louder
		merger.disconnect(audioCtx.destination);
	}
	merger = audioCtx.createChannelMerger(2);//Each input(multi-channel) is used to fill a channel of the output. 
	//alert(source1.channelCount); //2
	//alert(source1.numberOfInputs); //0
	//alert(source1.numberOfOutputs); //1
	//input , output -> multi channel in one output
	thisVideoSource.connect(merger,0,1);//(audioNode,outputIndexOftheSource, inputIndexOfMerger)

	baseVideoSource.connect(merger,0,0);

	merger.connect(audioCtx.destination);
	baseVideoObject.currentTime = start;
	thisVideoObject.currentTime = start;

	//alert(offset);
	if(offset > 0)
	{
		//video in the videolist will play first
		//add a #t=offset to the src
		//var ori_src = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src");
		//alert(ori_src);
		// strip out the # from before
		//$("#cIndex > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src",ori_src+"#t="+offset+",");
		thisVideoObject.currentTime+=offset;	
	}
	else // cant play this with minus offset
	{
		
		baseVideoObject.currentTime+=-offset;	
	}

	stopAll();
	stopAt = end;
	playingLabel = true;
	baseVideoObject.play();
	thisVideoObject.play();
	
});
function addSegmentTime(start,end)
{
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > input.start").val(start).parent().children("input.end").val(end);
}
function resetCtrDV()
{
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment").html(
		'<div class="ctr">'+
			'<div class="btn btn-small btn-primary play">play</div> '+
			'<div class="btn btn-small labeling">GetTime</div> '+
			'<div class="btn btn-small btn-success searchSegment">search</div> '+
			'<span class="text-error errorInfo"></span>'+
		'</div>'+
		'<div class="newSegment">'+
			'<input class="input-small segmentName" type="text" placeholder="name"></input> '+
			'start: '+
			'<input class="input-small start" type="text"></input> '+
			'end: '+
			'<input class="input-small end" type="text"></input> '+
			'<div class="btn btn-small play">play</div> '+
			'<div class="btn btn-small btn-info playTogether">playWithTop</div>'+
		'</div>'
	);
}
// start searching!!
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.searchSegment",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var videoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var videoObject = videoSource[videoname]['object'];
	var maxEnd = videoObject.duration;
	var data = {};
	data.name = $(this).parent().parent().find("div.newSegment > input.segmentName").val();
	data.start = parseFloat($(this).parent().parent().find("div.newSegment > input.start").val());
	data.end = parseFloat($(this).parent().parent().find("div.newSegment > input.end").val());
	data.dvId = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
	//alert(data.start);
	if(isNaN(data.start) || isNaN(data.end) || (data.start ==null) || (data.start<0) ||(data.start ==null) || (data.end<0) || 
		(data.end > maxEnd) || (data.start > maxEnd)
	)
	{
		$(this).parent().children("span.errorInfo").html("illegal start or end");
		return;
	}
	if(data.name == "")
	{
		$(this).parent().children("span.errorInfo").html("please enter a name");
		return;
	}
	$(this).addClass("disabled");
	$(this).parent().children("span.errorInfo").html('<div class="loading"></div>');
	cw.post(cw.url+"searchSegment",data,function(result){
		$(this).removeClass("disabled");
		$(this).parent().children("span.errorInfo").html('');
		if(result.status == 0)
		{
			//clean up
			//$(this).parent().parent().find("div.newSegment > input.segmentName").val("");
			//$(this).parent().parent().find("div.newSegment > input.start").val("");
			//$(this).parent().parent().find("div.newSegment > input.end").val("");
			//show progress
			$("#SegmentProgress > input.processId").val(result.processId);
			$("#SegmentProgress > input.showing").val(1).change();
			$("#SegmentProgress > input.updating").val(1).change();
		}
		else{
			$(this).parent().children("span.errorInfo").html('error');
		}
	},$(this));
});
//get segmentList
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.title > div.refreshSegmentList",function(){
	var dvId = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
	getSegmentList(dvId);
});
function getSegmentList(dvId)
{
	var data = {};
	data.dvId = dvId;
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList").html('<div class="loading"></div>');
	cw.post(cw.url+"getSegmentList",data,function(result){
		$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList").html('');
		if(result.status == 0)
		{
			var datasetId=$("#cIndex > input.datasetId").val();
			//for(var i =0;i<result.segmentList.length;++i)
			for(var key in result.segmentList)
			{
				var s = result.segmentList[key];
				$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList").append('<div class="block">'+
						'<input class="segmentId" type="hidden" value="'+s.segmentId+'"></input>'+
						'<input class="start" type="hidden" value="'+s.start+'"></input>'+
						'<input class="end" type="hidden" value="'+s.end+'"></input>'+
						'<input class="name" type="hidden" value="'+s.labelName+'"></input>'+
						" "+s.labelName+" : <span class='text-warning'>"+s.start +"(s)</span> - <span class='text-warning'>"+s.end+"(s)</span> "+
						'<a class="btn btn-small playThis" target="_blank" href="<?php echo Yii::app()->baseUrl;?>/index.php/application/showSegment?segmentId='+s.segmentId+'&datasetId='+datasetId+'">seeResult</a> <div class="btn btn-small btn-info copy">copy</div> <div class="btn btn-small delete">delete</div>'+
					'</div>');
			}
		}
	});
}
function getLabelResult(dvId)
{
	var data = {};
	data.dvId = dvId;
	$("#cIndex > div.videoPairs > div.left > div.labelTools > div.ctr > span.info").html('<div class="loading"></div>');
	cw.post(cw.url+"getLabelResult",data,function(result){
		$("#cIndex > div.videoPairs > div.left > div.labelTools > div.ctr > span.info").html('');
		if(result.status == 0)
		{
			$("#cIndex > div.videoPairs > div.left > div.labelTools > div.ctr > input.rankScoreManual").val(result.rankScoreManual).parent()
				.children("span.current").html(currentLabel(result.rankScoreManual));
		}
	});
}
function currentLabel(score)
{
	if(score < 0)
	{
		return "all wrong";
	}
	else if(score > 0)
	{
		return "correct";
	}
	return "Not Labeled";
}
//copy segment info
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList > div.block > div.copy",function(){
	var data = {};
	data.segmentId = $(this).parent().children("input.segmentId").val();
	data.start = $(this).parent().children("input.start").val();
	data.end = $(this).parent().children("input.end").val();
	data.name = $(this).parent().children("input.name").val();
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > input.start").val(data.start);
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > input.end").val(data.end);
	$("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > input.segmentName").val(data.name);
});
//delete segment results
cw.ec("#cIndex > div.videoPairs > div.left > div.segmentTools > div.segmentList > div.block > div.delete",function(){
	var data = {};
	data.segmentId = $(this).parent().children("input.segmentId").val();
	if(!confirm("delete segment?"))
	{
		return;
	}
	$(this).addClass("disabled");
	cw.post(cw.url+"deleteSegment",data,function(result){
		var dvId = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
		getSegmentList(dvId);
	});
});
cw.ech("#cIndex > div.videoPairs > div.left > div.segmentTools > input.refreshSegmentList",function(){
	var dvId = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
	getSegmentList(dvId);
});
//labeling control
	// click correct

cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.correctD",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.erId = $(this).parent().parent().children("input.erId").val();
	data.mark = 1;	
	setBorderColor($(this).parent(),"green");
	setLabel(data,$(this));

	
});
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.correct",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.erId = $(this).parent().parent().children("input.erId").val();
	data.mark = 2;	
	setBorderColor($(this).parent(),"rgb(0,200,0)");
	setLabel(data,$(this));

	
});
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.wrong",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.erId = $(this).parent().parent().children("input.erId").val();
	data.mark = -1;	
	setBorderColor($(this).parent(),"red");
	setLabel(data,$(this));

	
});
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.reset",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.erId = $(this).parent().parent().children("input.erId").val();
	data.mark = 0;	
	setBorderColor($(this).parent(),"none");
	setLabel(data,$(this));

	
});
//set one ER's labeling result
function setLabel(data,object)
{
	object.parent().children("span.errorInfo").html('<div class="loading"></div>');
	object.addClass("disabled");

	cw.post(cw.url+"setERmark",data,function(result){
		$(this).removeClass("disabled");
		if(result.status==0)
		{
			$(this).parent().children("span.errorInfo").html('');
		}
		var dvId = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
		getLabelResult(dvId);
	},object);
}
function setBorderColor(object,color)
{
	if(color == "none")
	{
		object.css({"border":"none"});
	}
	else
	{
		object.css({"border":"3px solid "+color})
	}
}
</script>
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		"#cIndex > input.gotoDatasetList",
	),//点击头导航的发生的事件
	//"targetName" => "#cIndex > #projectList > input.project",
	"targetChange" => array(
	//	"#cIndex > #projectList > input.project",//新建了项目后就获取新项目列表
	//	"#cIndex > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#cIndex > #project > input.projectId",
		"targetProjectName" => "#cIndex > #project > input.projectName",
		"targetProjectIntro" => "#cIndex > #project > input.projectIntro",
		"targetChangeP" => array(
			"#cIndex > #project > input.projectId",//点击了项目后载入项目内容 
			"#cIndex > input.toProject",//点击了项目后显示项目部件 
		),
)); ?>
<div id="cIndex">
	<input class="gotoDatasetList" type="hidden"></input>
	<div class="datasetList">
		
	</div>
	<input class="datasetId" type="hidden" value=""></input>
	<div class="datasetVideos"></div>
	<input class="srcVideoDvId" type="hidden" value=""></input>
	<div class="videoPairs" style="display:none">
		<div class="notice" style="position:absolute;top:20px;left:0;width:100%;text-align:center;color:gray;font-weight:bold;">
			please wait till videos are buffered to play sync.
		</div>
		<div class="left">
			<div class="srcVideo">
			</div>
			<div class="ctr" style="position:relative">
				<!--<div class="btn btn-success play">play together from the start</div>
				<canvas id="audioForSrc" style="height:100px;position:absolute;top:0;right:0;width:200px;"></canvas>
				<canvas id="audioForDes" style="height:100px;position:absolute;top:0;right:0;width:200px;"></canvas>
				<div class="btn btn-info stop">stop all</div>-->
			</div>
			<div class="segmentTools">
				<div class="title">Segment Search</div>
				<div class="segment">
					<div class="ctr">
						<div class="btn btn-small btn-primary play">play</div>
						<div class="btn btn-small labeling">GetTime</div>
						<div class="btn btn-small btn-success searchSegment">search</div>
						<span class="text-error errorInfo"></span>
					</div>
					<div class="newSegment">
						<input class="input-small segmentName" type="text" placeholder="name"></input>
						start:
						<input class="input-small start" type="text"></input>
						end:
						<input class="input-small end" type="text"></input>
						<div class="btn btn-small play">play</div>
						<div class="btn btn-small btn-info playTogether">playWithTop</div>
					</div>
				</div>
				<div class="segProgress">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "SegmentProgress",
						"noMessage" => true,
						"doneCall" => "#cIndex > div.videoPairs > div.left > div.segmentTools > input.refreshSegmentList"
					));
				?>
				</div>
				<div class="title">Segment list <div class='btn btn-small refreshSegmentList'>refresh</div></div>
				<input class="refreshSegmentList" type="hidden"></input>
				<div class="segmentList"></div>
			</div>
			<div class="labelTools">
				<div class="title">Labeling</div>
				<div class="ctr">
					<input class="rankScoreManual" type="hidden"></input>
					<span class="text-info current"></span>
					<!--
					<div class="btn btn-small btn-danger wrong">all wrong</div>
					<div class="btn btn-small reset">reset</div>
					-->
					<span class="text-error info"></span>
				</div>
			</div>
		</div>
		<div class="right">
			<!--<input class="offset" type="hidden"></input>-->
			<div class="videoList">
			</div>
			<!--<div class="ctr">
				videoname: <span class="text-error videoname"></span><br/>
				score: <span class="text-error score"></span><br/>
				offset: <span class="text-error offset"></span><br/>
				<div class="btn btn-info next">next</div>
				<div class="btn btn-info prev">prev</div>
			</div>
			-->
		</div>
	</div>
</div>
<div class="footer" style="text-align:center;color:gray;position:fixed;bottom:0;width:100%;padding:5px;">
	If you have any questions, you can contact us by aronson@andrew.cmu.edu.
</div>












<?php /*
//////////////////stuff for project website
<div id="cIndex">
	<input class="toProjectList" type="hidden"></input>
	<input class="toProject" type="hidden"></input>
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $nickname,
	"userLevel" => $userLevel,
	"headerChange" =>array(
		"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
	),//点击头导航的发生的事件
	"targetName" => "#cIndex > #projectList > input.project",
	"targetChange" => array(
		"#cIndex > #projectList > input.project",//新建了项目后就获取新项目列表
		"#cIndex > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#cIndex > #project > input.projectId",
		"targetProjectName" => "#cIndex > #project > input.projectName",
		"targetProjectIntro" => "#cIndex > #project > input.projectIntro",
		"targetChangeP" => array(
			"#cIndex > #project > input.projectId",//点击了项目后载入项目内容 
			"#cIndex > input.toProject",//点击了项目后显示项目部件 
		),
));?>
<?php 
	$this->widget("ProjectListWidget",array(
		"id" => "projectList",
		"userLevel" => $userLevel,
		"loading" => "#siteHeader > input.loading",
		"stopLoading" => "#siteHeader > input.stopLoading",
		"targetProjectId" => "#cIndex > #project > input.projectId",
		"targetProjectName" => "#cIndex > #project > input.projectName",
		"targetProjectIntro" => "#cIndex > #project > input.projectIntro",
		"targetChange" => array(
			"#cIndex > #project > input.projectId",//点击了项目后载入项目内容 
			"#cIndex > input.toProject",//点击了项目后显示项目部件 
			"#cIndex > #siteHeader > input.showBack",//点击项目后显示siteHeader的back按钮
		),
	));
?>
<?php
	$this->widget("ProjectWidget",array(
		"id" => "project",
		"userLevel" => $userLevel,
		"username" => $username,
		"nickname" => $nickname,
		"loading" => "#siteHeader > input.loading",
		"stopLoading" => "#siteHeader > input.stopLoading",
	));
?>
</div>
<script type="text/javascript">
	//进入页面就获取项目列表
	
	$(document).ready(function(){
		$("#projectList > input.project").change();
	});
	//两个部件的切换
	cw.ech("#cIndex > input.toProjectList",function(){
		$("#project").hide();
		$("#projectList").fadeIn();
	});
	cw.ech("#cIndex > input.toProject",function(){
		$("#project").fadeIn();
		$("#projectList").hide();
	});
</script>
*/ ?>
