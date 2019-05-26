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
	

	#cIndex > div.videoPairs{
		padding-top:10px;
	}
	#cIndex > div.videoPairs > div.block{
		border-top:1px gray solid;
		margin-top:5px;
		position:relative;
	}
	#cIndex > div.videoPairs > div.block > div.srcVideo{
		float:left;
		text-align:center;
		width:50%;
	}
	#cIndex > div.videoPairs > div.block > div.srcVideo > div.rank{
		position:absolute;
		bottom:0;
		text-align:center;
	}
	#cIndex > div.videoPairs > div.block > div.srcVideo >  video,
	#cIndex > div.videoPairs > div.block > div.desVideo > video{
		width:100%;
		max-height:400px;
	}
	#cIndex > div.videoPairs > div.block > div.desVideo {
		margin:0 0 0 50%;	
	}
	
	#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr{
		text-align:right;
		padding:10px;
		line-height:40px;
	}
	#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > input.offset{
		width:40px;
		margin:0;
	}
	#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > i{
		cursor:pointer;
	}
	
</style>
<script type="text/javascript">

//click a video, get the er_pair
var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
//create source now.
var videoSource = {};//{} each videoname'ssource

//play together
var merger = null;// used when click play sync, put sound into two channel

cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
// jumping
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.jumpAhead",function(){
		if(hasTwo($(this).parent().parent().parent()))
		{
			var jump = parseFloat($(this).parent().children("input.jump").val());
			if(isNaN(jump) || (jump == 0))
			{
				return;
			}
			var leftVideoName = $(this).parent().parent().parent().find("div.srcVideo > input.videoname").val();
			var rightVideoName = $(this).parent().parent().children("input.videoname").val();
			var baseVideoObject = videoSource[leftVideoName]['object'];
			var thisVideoObject = videoSource[rightVideoName]['object'];
			// check any of the jump exceed the duration
			if((baseVideoObject.currentTime+jump >= baseVideoObject.duration) || (thisVideoObject.currentTime+jump >= thisVideoObject.duration))
			{
				$(this).parent().children("span.info").html("No jumping, exceed duration").emptyLater();
			}
			else
			{
				baseVideoObject.currentTime+=jump;
				thisVideoObject.currentTime+=jump;
			}
		}
	});
	cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.jumpBack",function(){
		if(hasTwo($(this).parent().parent().parent()))
		{
			var jump = -parseFloat($(this).parent().children("input.jump").val());
			if(isNaN(jump) || (jump == 0))
			{
				return;
			}
			var leftVideoName = $(this).parent().parent().parent().find("div.srcVideo > input.videoname").val();
			var rightVideoName = $(this).parent().parent().children("input.videoname").val();
			var baseVideoObject = videoSource[leftVideoName]['object'];
			var thisVideoObject = videoSource[rightVideoName]['object'];
			if((baseVideoObject.currentTime+jump <= 0.0) || (thisVideoObject.currentTime+jump <= 0.0))
			{
				$(this).parent().children("span.info").html("No jumping, small than 0").emptyLater();
			}
			else
			{
				baseVideoObject.currentTime+=jump;
				thisVideoObject.currentTime+=jump;
			}
		}
	});
// check whether
function hasTwo(videoBlock)
{
	if((videoBlock.find("div.srcVideo > video").length > 0) && (videoBlock.find("div.desVideo > video").length > 0))
	{
		return true;
	}
	return false;
}
//get current offset.
//load videeo
function loadVideo(videoBlock)
{
	var videoname1 = videoBlock.find("div.srcVideo > input.videoname").val();
	var videoPath1 = videoBlock.find("div.srcVideo > input.videoPath").val();
	var videoname2 = videoBlock.find("div.desVideo > input.videoname").val();
	var videoPath2 = videoBlock.find("div.desVideo > input.videoPath").val();
	var pairId = videoBlock.children("input.pairId").val();
	//load src video
	videoBlock.children("div.srcVideo").prepend('<video controls>'+
		'<source src=""></source>'+
		'Your browser does not support the video tag.'+
	'</video>');
	videoBlock.children("div.srcVideo").find("video > source").prop("src",videoPath1);
	videoBlock.children("div.srcVideo").find("video").prop("src",videoPath1);

	videoSource[videoname1] = {
		"source":audioCtx.createMediaElementSource(videoBlock.find("div.srcVideo > video").get(0)),
		"object":videoBlock.find("div.srcVideo > video").get(0)
	};
	videoSource[videoname1]['object'].addEventListener("waiting",function(){
					$("#cIndex > div.videoPairs > div.block > div.srcVideo > span.info").html("warning, video on the right has been out of sync due to bufferring. Click Play agian to play sync").emptyLater(4000);
			});
	videoSource[videoname1]['object'].addEventListener("playing",function(){
					$("#cIndex > div.videoPairs > div.block > div.srcVideo > span.info").html("");
			});

	// load des video
	videoBlock.children("div.desVideo").prepend('<video controls>'+
		'<source src=""></source>'+
		'Your browser does not support the video tag.'+
	'</video>');
	videoBlock.children("div.desVideo").find("video > source").prop("src",videoPath2);
	videoBlock.children("div.desVideo").find("video").prop("src",videoPath2);
	videoSource[videoname2] = {
		"source":audioCtx.createMediaElementSource(videoBlock.find("div.desVideo > video").get(0)),
		"object":videoBlock.find("div.desVideo > video").get(0)
	};
	videoSource[videoname2]['object'].addEventListener("waiting",function(){
					$("#cIndex > div.videoPairs > div.block > div.srcVideo > span.info").html("warning, video on the right has been out of sync due to bufferring. Click Play agian to play sync").emptyLater(4000);
			});
	videoSource[videoname2]['object'].addEventListener("playing",function(){
					$("#cIndex > div.videoPairs > div.block > div.srcVideo > span.info").html("");
			});

	//get the sound wave image
	var srcAnalyser = audioCtx.createAnalyser();
	videoSource[videoname1]['source'].connect(srcAnalyser);
	bindAudioV("#audioVForSrc"+pairId,srcAnalyser,videoSource[videoname1]['object'],"rgba(0,0,0,0.7)");
	var desAnalyser = audioCtx.createAnalyser();
	videoSource[videoname2]['source'].connect(desAnalyser);
	bindAudioV("#audioVForDes"+pairId,desAnalyser,videoSource[videoname2]['object'],"rgba(255,175,0,0.9)");
}
//load video button
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.loadVideo",function(){
	loadVideo($(this).parent().parent().parent());
	$(this).removeClass("loadVideo").addClass("destroyVideo").html("Destroy Video");
});

//destroy video
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.destroyVideo",function(){
	var videoBlock = $(this).parent().parent().parent();
	var videoname1 = videoBlock.find("div.srcVideo > input.videoname").val();
	var videoname2 = videoBlock.find("div.desVideo > input.videoname").val();
	delete videoSource[videoname1];
	delete videoSource[videoname2];
	videoBlock.find("video").each(function(){
	    this.pause(); // can't hurt
	    delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
	    $(this).remove(); // this is probably what actually does the trick
	});
	$(this).removeClass("destroyVideo").addClass("loadVideo").html("Load Video");
});
function showAudioV(canvasId,analyser,color)
{
	var canvas = $(canvasId).get(0);
	var canvasCtx = canvas.getContext("2d");
	 WIDTH = canvas.width;
  	HEIGHT = canvas.height;
  
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
//save the new offset
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.saveOffset",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	//data.erId = $(this).parent().parent().parent().children("input.pairId").val();
	data.pairId = $(this).parent().parent().parent().children("input.pairId").val();
	data.offset = $(this).parent().children("input.offset").val();
	//alert(data.erId);
	$(this).parent().children("span.errorInfo").html('<div class="loading"></div>');
	$(this).addClass("disabled");
	cw.post(cw.url+"saveOffsetAudioSyncExp",data,function(result){
		$(this).removeClass("disabled");
		if(result.status==0)
		{
			$(this).parent().children("span.errorInfo").html('revised');
		}
	},$(this));
});

// change the offset a bit
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > i.co",function(){
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
// get the current offset of the two video
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.getOffset",function(){
	if(hasTwo($(this).parent().parent().parent()))
	{
		//alert("f");
		var leftVideoName = $(this).parent().parent().parent().find("div.srcVideo > input.videoname").val();
		var rightVideoName = $(this).parent().parent().children("input.videoname").val();
		var baseVideoObject = videoSource[leftVideoName]['object'];
		var thisVideoObject = videoSource[rightVideoName]['object'];
		var newoffset = thisVideoObject.currentTime - baseVideoObject.currentTime;
		$(this).parent().children("input.offset").val(newoffset);
	}
});
function stopAll()
{
	for(var videoname in videoSource)
	{
		videoSource[videoname]['object'].pause();
	}
}

cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.playSync",function(){
	
	//get the offset first
	var offset = parseFloat($(this).parent().children("input.offset").val());
	var srcVideoName = $(this).parent().parent().parent().find("div.srcVideo > input.videoname").val();
	var desVideoName = $(this).parent().parent().children("input.videoname").val();
	//if((videoSource[srcVideoName] == null) || (videoSource[desVideoName] == null))
	if(!hasTwo($(this).parent().parent().parent()))
	{
		alert("Video not loaded");
		return;
	}
	var baseVideoSource = videoSource[srcVideoName]['source'];
	var baseVideoObject = videoSource[srcVideoName]['object'];
	var thisVideoSource = videoSource[desVideoName]['source'];
	var thisVideoObject = videoSource[desVideoName]['object'];
	
	//var source1 = audioCtx.createMediaElementSource(videoObj1);//can only create once
	//var source2 = audioCtx.createMediaElementSource(videoObj2);// a meida element audio source
	stopAll();
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


	//baseVideoObject.currentTime = 0.0;
	//thisVideoObject.currentTime = 0.0;
	targetTime = baseVideoObject.currentTime;
	//alert(offset);
	targetTime+=offset;	
	if(targetTime < 0)
	{
		$(this).parent().children("span.info").html("warning, this video is not started at this time. Jump to mutual time to play").emptyLater();
		// play at mutual time
		playMutual(baseVideoObject,thisVideoObject,offset);
	}
	else if(targetTime > thisVideoObject.duration)
	{
		$(this).parent().children("span.info").html("warning, this video is ended at this time. Jump to mutual time to play").emptyLater();
		playMutual(baseVideoObject,thisVideoObject,offset);
	}
	else
	{
		thisVideoObject.currentTime = targetTime;
		baseVideoObject.play();
		thisVideoObject.play();
	}
});
function playMutual(baseVideoObject,thisVideoObject,offset)
{
	baseVideoObject.currentTime = 0.0;
	thisVideoObject.currentTime = 0.0;

	//alert(offset);
	if(offset > 0)
	{
		//video in the videolist will play first
		//add a #t=offset to the src
		//var ori_src = $("#cIndex > div.videoPairs > div.block > div.desVideo.toggle > video > source").eq(0).prop("src");
		//alert(ori_src);
		// strip out the # from before
		//$("#cIndex > div.videoPairs > div.block > div.desVideo.toggle > video > source").eq(0).prop("src",ori_src+"#t="+offset+",");
		thisVideoObject.currentTime = offset;	
	}
	else
	{
		baseVideoObject.currentTime = -offset;	
	}
	stopAll();
	baseVideoObject.play();
	thisVideoObject.play();
}
//stop all video
cw.ec("#cIndex > div.videoPairs > div.left > div.ctr > div.stop,#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.stop",function(){
	stopAll();
});


cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.correctD",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.pairId = $(this).parent().parent().parent().children("input.pairId").val();
	data.mark = 1;
	setBorderColor($(this).parent(),"green");
	setLabel(data,$(this));
});
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.correct",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.pairId = $(this).parent().parent().parent().children("input.pairId").val();
	data.mark = 2;	
	setBorderColor($(this).parent(),"rgb(0,200,0)");
	setLabel(data,$(this));

	
});
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.wrong",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.pairId = $(this).parent().parent().parent().children("input.pairId").val();
	data.mark = -1;	
	setBorderColor($(this).parent(),"red");
	setLabel(data,$(this));
	
});
cw.ec("#cIndex > div.videoPairs > div.block > div.desVideo > div.ctr > div.reset",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.pairId = $(this).parent().parent().parent().children("input.pairId").val();
	data.mark = 0;	
	setBorderColor($(this).parent(),"none");
	setLabel(data,$(this));
});
//set one ER's labeling result
function setLabel(data,object)
{
	object.parent().children("span.errorInfo").html('<div class="loading"></div>');
	object.addClass("disabled");
	var propagate = $("#propagate").prop("checked");
	data.propagate = propagate?1:0;
	cw.post(cw.url+"setAudioSyncExpMark",data,function(result){
		$(this).removeClass("disabled");
		if(result.status==0)
		{
			$(this).parent().children("span.errorInfo").html('');
		}
	},object);
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
<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px">
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&perPage=<?php echo $perPage?>&mark=all" style="text-decoration:none">All</a>
	&nbsp;&nbsp;
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&perPage=<?php echo $perPage?>&mark=2" style="text-decoration:none">Correct Only</a>
	&nbsp;&nbsp;
	&nbsp;&nbsp;
  Experiment - <?php echo $AudioSyncExp->runName; ?>
&nbsp;&nbsp;
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
	<a class="btn btn-small btn-warning download" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/main/downloadAudioSyncExpLabel?expId=<?php echo $expId?>">download</a>
	<br/>
	Current Page : <?php echo $page?>/<?php echo $totalPage?>
	|
	Current Precition@<?php echo $totalMarked?>: <?php echo $totalMarked==0?0:$totalCorrect/$totalMarked;?>
	&nbsp; | &nbsp;
	<input id='propagate' type="checkbox"></input> Propagate Labels
	&nbsp; | &nbsp;
	<?php if($page > 1){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>&mark=<?php echo $mark?>" style="text-decoration:none">Previous Page</a>
	<?php } ?>
	
	&nbsp;&nbsp;
	<?php if($page < $totalPage){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>&mark=<?php echo $mark?>" style="text-decoration:none">Next Page</a>
	<?php } ?>
</div>
<div id="cIndex">
	<input class="expId" type="hidden" value="<?php echo $expId?>"></input>
	<div class="videoPairs" style="">
		<?php foreach($pairs as $pair){ ?>
		<div class="block">
			<input class="pairId" type="hidden" value="<?php echo $pair['pairId']?>"></input>
			<input class="score" value="<?php echo $pair['score']?>" type="hidden"></input>
			<input class="mark" value="<?php echo $pair['mark']?>" type="hidden"></input>
			<div class="srcVideo">
				<div class="rank muted">Rank:<?php echo $pair['rank']?></div>
				<input class="videoname" value="<?php echo $pair['videoname1']?>" type="hidden"></input>
				<input class="videoPath" value="<?php echo Yii::app()->baseUrl?>/<?php echo $pair['relatedPath1']?>" type="hidden">
				<?php echo $pair['videoname1']?>
				<br/><span class='text-error info'></span>
			</div>
			<div class="desVideo">
				<input class="videoname" value="<?php echo $pair['videoname2']?>" type="hidden"></input>
				<input class="videoPath" value="<?php echo Yii::app()->baseUrl?>/<?php echo $pair['relatedPath2']?>" type="hidden">
				<div class="ctr" style="position:relative;<?php
					if($pair['mark'] == 1)
					{
						echo "border:3px solid green";
					}
					else if($pair['mark'] == 2)
					{
						echo "border:3px solid rgb(0,200,0)";
					}
					else if($pair['mark'] == -1)
					{
						echo "border:3px solid red";
					}
				?>">
					<canvas id="audioVForSrc<?php echo $pair['pairId']?>" style="height:140px;position:absolute;z-index:1;top:50px;left:0;width:150px;"></canvas>
					<canvas id="audioVForDes<?php echo $pair['pairId']?>" style="height:140px;position:absolute;z-index:2;top:50px;left:0;width:150px;"></canvas>

					<div class="btn btn-warning loadVideo">Load Video</div>  
					<?php echo $pair['videoname2']?>
					<span class="text-warning score">(<?php echo $pair['score']?>)</span><br/>

					<i class="co icon-plus" title="this video is behind global time,click to play it further a little"></i>
					offset: <input class="offset input-small" type="text" value="<?php echo $pair['offset']?>"></input> (s)
					<i class="co icon-minus" title="this video is ahead of global time,click to play it back a little"></i>
					<div class="btn btn-small btn-info getOffset">Get Offset</div>
					<?php if($pair['originalOffset'] != NULL){ ?>
						<span class='text-warning autoOffset'>Original:<?php echo $pair['originalOffset']?>(s)</span>
					<?php } ?>
					<br/>

					<div class="btn btn-info playSync">Play Sync From Left Video</div> <div class="btn btn-info stop">Stop All</div>
					<div class="btn saveOffset">Save Offset</div><br/>

					<div class="btn btn-info jumpAhead">Both Jump Ahead</div>
					<div class="btn btn-info jumpBack">Both Jump Back</div>
					<input class="jump input-small" style="width:30px" type="text" value="10"></input> (s)
					<br/>

					<div class="btn correct btn-success">Correct</div>
					<div class="btn correctD btn-success">Correct Duplicate</div>
					<div class="btn wrong btn-danger">Wrong</div>
					<div class="btn reset">Reset</div><br/>

					<span class="text-error errorInfo info"></span>
				</div>

			</div>
		</div>
		<?php } ?>
	</div>
	<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px">  Experiment - <?php echo $AudioSyncExp->runName; ?>
&nbsp;&nbsp;
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
		<br/>
		Current Page : <?php echo $page?>/<?php echo $totalPage?>
		<?php if($page > 1){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>&mark=<?php echo $mark?>" style="text-decoration:none">Previous Page</a>
		<?php } ?>
		&nbsp;&nbsp;
		&nbsp;&nbsp;
		<?php if($page < $totalPage){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>&mark=<?php echo $mark?>" style="text-decoration:none">Next Page</a>
		<?php } ?>
	</div>
</div>



