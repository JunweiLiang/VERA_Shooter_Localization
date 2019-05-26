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
	#cIndex > div.videoPairs > div.left{
		position:fixed;
		top:80px;
		left:0%;
		padding-left:5px;
		width:50%;
		text-align:center;
	}
	#cIndex > div.videoPairs > div.left > div.srcVideo > video,
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > video{
		width:100%;
		max-height:400px;
	}
	#cIndex > div.videoPairs > div.right{
		margin:0 0 0 50%;
	}
	#cIndex > div.videoPairs > div.right > div.videoList > div.block{
		width:100%;
		border-top:1px gray solid;
		margin-top:5px;
	}
	
	#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr{
		text-align:right;
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
	#cIndex input {margin:0}
	#cIndex div.searchVideo{
		position:relative;
	}
	#cIndex div.searchVideo > div.guessList{
		padding:5px;
		max-height:200px;overflow:auto
	}
	#cIndex div.searchVideo > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cIndex div.searchVideo > div.guessList > div.block:hover{
		color:gray
	}
	#cIndex  div.searchVideo > div.dismissGuess{
		position:absolute;
		top:40px;
		right:20px;
	}
</style>
<script type="text/javascript">

	function goTo(divClass)
	{
		$("#cIndex > div").hide();
		$("#cIndex > div."+divClass).show();
	}
	
		//get videos

//---------------------------------------------not used for audio sync runlist page-------------`
cw.ec("div.dismissGuess",function(){
		$(this).parent().children("div.guessList").html("");
		$(this).hide();
	});
cw.ec("div.searchVideo > div.search",function(){
		//search video
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchVideos",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			if(result.videoList.length == 0)
			{
				$(this).parent().children("div.guessList").html('<div class="wrapLoading">No match</div>');
			}
			$(this).parent().children("div.dismissGuess").show();
			for(var i =0;i<result.videoList.length;++i)
			{
				$(this).parent().children("div.guessList").append('<div class="block">'+
					'<input class="videoname" type="hidden" value="'+result.videoList[i].videoname+'"></input>'+
					result.videoList[i].videoname+
				'</div>');
			}
		},$(this));
	});
//click any guess
cw.ec("div.searchVideo > div.guessList > div.block",function(){
	var videoname = $(this).children("input.videoname").val();
	//alert(videoname);
	$(this).parent().parent().children("input.videoname").val(videoname);
	$(this).parent().parent().children("div.set").trigger(cw.ectype);
});
// set a new video into des video view
cw.ec("div.searchVideo > div.set",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.videoname = $(this).parent().children("input.videoname").val();
	$(this).addClass("disabled");
	$(this).parent().children("span.info").html('<div class="loading"></div>');
	// check whether this video is already here
	var findIt = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block > input.videoname[value='"+data.videoname+"']");
	if(findIt.length != 0)
	{
		$(this).removeClass("disabled");
		$(this).parent().children("div.dismissGuess").hide();
		$(this).parent().children("span.info").html('');
		$(this).parent().children("div.guessList").html('');
		findIt.parent().insertAfter("#cIndex > div.videoPairs > div.right > div.videoList > div.searchVideo");
	}
	else
	{
		//get this video's pair info with the src video
		data.datasetId = <?php echo $datasetId?>;
		data.dvId = <?php echo $dvId?>;// the src video dvId
		var forLabeling = <?php echo $forLabeling?>;
		cw.post(cw.url+"getResultER?forLabeling="+forLabeling,data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status == 1)
			{
				$(this).parent().children("span.info").html('This video is not in this dataset').emptyLater();
			}
			else if(result.status == 2)
			{
				$(this).parent().children("span.info").html('cannot create er pair').emptyLater();
			}
			else
			{
				var temp = makeDesBlock(result.videoInfo,result.forLabeling);
				temp.insertAfter("#cIndex > div.videoPairs > div.right > div.videoList > div.searchVideo");
				$(this).parent().children("div.dismissGuess").hide();
				$(this).parent().children("div.guessList").html('');
			}
		},$(this));
	}
});	
//click a video, get the er_pair
var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
//create source now.
var videoSource = null;//{} each videoname'ssource


//play together
var merger = null;// used when click play sync, put sound into two channel
$(document).ready(function(){
	//whether to show search.
	var forLabeling = <?php echo $forLabeling?>;
	var data = {};
	data.videoname = "<?php echo $videoname?>";
	data.dvId = <?php echo $dvId?>;
	if(forLabeling == 0)
	{
		//segment search is disabled
		$("#cIndex > div.videoPairs > div.left > div.segmentTools").hide();
		$("#cIndex > div.videoPairs > div.left > div.labelTools").hide();
		getSegmentList(data.dvId);
	}
	else
	{
		$("#cIndex > div.videoPairs > div.left > div.segmentTools").hide();
		$("#cIndex > div.videoPairs > div.left > div.labelTools").show();
		getLabelResult(data.dvId);
	}
	data.datasetId = <?php echo $datasetId?>;
	//alert(data.datasetId);
	goTo("videoPairs");
	$("#siteHeader > input.loading").change();
	//$("#cIndex > div.videoPairs > div.right > div.videoList").html("");
	$("#cIndex > div.videoPairs > div.right > div.videoList > div.block").remove();
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
				'<input class="videoId" value="'+result.videoInfo.videoId+'" type="hidden"></input>'+
				'<input class="dvId" value="'+result.videoInfo.dvId+'" type="hidden"></input>'+
				'<video controls>'+
				'<source src="<?php echo Yii::app()->baseUrl?>/'+result.videoInfo.relatedPath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video><br/>'+result.videoInfo.videoname+" <span class='text-error info'></span>");
			videoSource[result.videoInfo.videoname] = {
				"source":audioCtx.createMediaElementSource($("#cIndex > div.videoPairs > div.left > div.srcVideo > video").get(0)),
				"object":$("#cIndex > div.videoPairs > div.left > div.srcVideo > video").get(0)
			};
			videoSource[result.videoInfo.videoname]['object'].addEventListener("waiting",function(){
					$("#cIndex > div.videoPairs > div.left > div.srcVideo > span.info").html("warning, video on the left has been out of sync due to bufferring. Click Play agian to play sync").emptyLater(4000);
			});
			videoSource[result.videoInfo.videoname]['object'].addEventListener("playing",function(){
					$("#cIndex > div.videoPairs > div.left > div.srcVideo > span.info").html("");
			});
			// showing the video play time as it played
			videoSource[result.videoInfo.videoname]['object'].addEventListener("timeupdate", function(e){
					$("#cIndex > div.videoPairs > div.left > div.visualMatch > div.title > span.videoTime").html(this.currentTime)
			});

			$("#cIndex > div.videoPairs > div.left > input.videoId").val(result.videoInfo.videoId);
			
			//bindCallbacks(videoSource[result.videoInfo.videoname]['object']);// for segment search

			//load videoList, hide all first,
			for(var i=0;i<result.ranklist.length;++i)
			{
				var video = result.ranklist[i];
				
				var temp = makeDesBlock(video,result.forLabeling);
				$("#cIndex > div.videoPairs > div.right > div.videoList").append(temp);

			}
			//getVideoInfo();
		}
	});
});
function makeDesBlock(video,forLabeling)
{
	var forLabeling = <?php echo $forLabeling?>;
	var datasetId = <?php echo $datasetId?>;
	var showBackLink = <?php echo $showBackLink?"1":"0";?>;
	var temp = $('<div class="block isDes">'+
		'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
		'<input class="videoId" type="hidden" value="'+video.videoId+'"></input>'+
		'<input class="erId" type="hidden" value="'+video.erId+'"></input>'+
		'<input class="score" type="hidden" value="'+parseFloat(video.confidence).toFixed(4)+'"></input>'+
		//'<input class="offset" type="hidden" value="'+video.offset+'"></input>'+
		'<input class="videoPath" type="hidden" value="<?php echo Yii::app()->baseUrl?>/'+video.relatedPath+'"></input>'+
		'<div class="ctr" style="position:relative;">'+
			'<div class="delete close" title="delete the whole thing">&times;</div>'+
			'<canvas id="audioVForSrc'+video.erId+'" style="height:140px;position:absolute;z-index:1;top:50px;left:0;width:150px;"></canvas>'+
			'<canvas id="audioVForDes'+video.erId+'" style="height:140px;position:absolute;z-index:2;top:50px;left:0;width:150px;"></canvas>'+

			// --------------- 04/2019 added for frame view synchronization

			'Current Video Time: (<span class="text-info videoTime"></span>) '+
			'<div class="btn btn-small btn-success goToFrame">FrameView</div> '+
			'<div class="btn btn-small btn-primary goToVideo">VideoView</div> '+
			'<div class="btn btn-warning loadVideo">Load Video</div>  <a href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncPairView?forLabeling='+forLabeling+'&datasetId='+datasetId+'&showBackLink='+showBackLink+'&dvId='+video.desDvId+'&videoname='+video.videoname+'" title="open this video in its pairwise view" target="_blank"><span class="text-error videoname">'+video.videoname+'</span></a> '+
			'<span class="text-warning score">('+parseFloat(video.confidence).toFixed(4)+')</span><br/>'+

			//'offset: <span class="text-error offset"></span><br/>'+
			'<i class="co icon-plus" title="this video is behind global time,click to play it further a little"></i> '+
			'offset: <input class="offset input-small" type="text" value="'+video.offset+'"></input> (s) '+
			'<i class="co icon-minus" title="this video is ahead of global time,click to play it back a little"></i> '+
			' <div class="btn btn-small btn-info getOffset">Get Offset from VideoPair</div> '+
			' <div class="btn btn-small btn-info getOffsetFrame">Get Offset from FramePair</div> '+
			(video.autoOffset!=null?"<span class='text-warning autoOffset'>Automatic: "+video.autoOffset+" (s)</span>":"" )+
			'<br/>'+
			'<div class="btn btn-info playSync">Play Sync From Left Video</div> <div class="btn btn-info stop">Stop All</div> '+
			'<div class="btn saveOffset">Save Offset</div>'+
			'<br/>'+	
			'<div class="btn btn-info jumpAhead">Both Jump Ahead</div> '+
			'<div class="btn btn-info jumpBack">Both Jump Back</div> '+
			'<input class="jump input-small" style="width:30px" type="text" value="10"></input> (s) '+
			'<br/>'+
			((forLabeling!=1)?"":
				'<div class="btn correct btn-success">Correct</div> '+
				'<div class="btn correctD btn-success">Correct Duplicate</div> '+
				'<div class="btn wrong btn-danger">Wrong</div> '+
				'<div class="btn reset">Reset</div><br/> '
			)+
			'<span class="text-error errorInfo info"></span>'+
		'</div>'+
	'</div>');
	if(forLabeling == 1)
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
	return temp;
}
// jumping
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.jumpAhead",function(){
		if(hasTwo($(this).parent().parent()))
		{
			var jump = parseFloat($(this).parent().children("input.jump").val());
			if(isNaN(jump) || (jump == 0))
			{
				return;
			}
			var leftVideoName = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
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
	cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.jumpBack",function(){
		if(hasTwo($(this).parent().parent()))
		{
			var jump = -parseFloat($(this).parent().children("input.jump").val());
			if(isNaN(jump) || (jump == 0))
			{
				return;
			}
			var leftVideoName = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
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

//get current offset.
//load videeo
function loadDesVideo(videoBlock)
{
	var videoname = videoBlock.children("input.videoname").val();
	var videoPath = videoBlock.children("input.videoPath").val();
	var erId = videoBlock.children("input.erId").val();
	videoBlock.prepend('<video controls>'+
		'<source src=""></source>'+
		'Your browser does not support the video tag.'+
	'</video>');
	// ---- 04/2019 for video frame view
	videoBlock.prepend('<div class="frames" style="display:none">'+
		'<div class="frame"><div class="btn btn-small btn-info getFrames">Get Frames</div></div>' + 
		"<div class='ctr'>" +
			'Video FPS: (<span class="text-error fps"></span>) '+
			'# Frames: (<span class="text-error num_frame"></span>) '+
			'Frame ID: <input class="frameIdx input-small" style="width:40px" type="text" value="1"></input> ' + 
			'<div class="btn btn-small btn-success getCurVideoFrame">Show Current Video Frame</div> '+
			'<span class="text-error info"></span> '+
		'</div>'+
	'</div>');
	videoBlock.find("video > source").prop("src",videoPath);
	videoBlock.find("video").prop("src",videoPath);
	videoSource[videoname] = {
		"source":audioCtx.createMediaElementSource(videoBlock.find("video").get(0)),
		"object":videoBlock.find("video").get(0)
	};
	videoSource[videoname]['object'].addEventListener("waiting",function(){
		$("#cIndex > div.videoPairs > div.left > div.srcVideo > span.info").html("warning, video on the right has been out of sync due to bufferring. Click Play agian to play sync").emptyLater(4000);
	});
	videoSource[videoname]['object'].addEventListener("playing",function(){
		$("#cIndex > div.videoPairs > div.left > div.srcVideo > span.info").html("");
	});
	// showing the current video time
	videoSource[videoname]['object'].addEventListener("timeupdate",function(){
		videoBlock.find("div.ctr > span.videoTime").html(this.currentTime);
	});

	//get the sound wave image
	var srcVideoname = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var srcAnalyser = audioCtx.createAnalyser();
	videoSource[srcVideoname]['source'].connect(srcAnalyser);
	bindAudioV("#audioVForSrc"+erId,srcAnalyser,videoSource[srcVideoname]['object'],"rgba(0,0,0,0.7)");
	var top1Analyser = audioCtx.createAnalyser();
	videoSource[videoname]['source'].connect(top1Analyser);
	bindAudioV("#audioVForDes"+erId,top1Analyser,videoSource[videoname]['object'],"rgba(255,175,0,0.9)");
}
//load video button
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.loadVideo",function(){
	loadDesVideo($(this).parent().parent());
	$(this).removeClass("loadVideo").addClass("destroyVideo").html("Destroy Video");
});
//delete the whole block
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.delete",function(){
	if(!confirm("Hide this video?"))
	{
		return;
	}
	var videoBlock = $(this).parent().parent();
	videoBlock.find("video").each(function(){
	    this.pause(); // can't hurt
	    delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
	    $(this).remove(); // this is probably what actually does the trick
	});
	videoBlock.remove();
});
//destroy video
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.destroyVideo",function(){
	var videoBlock = $(this).parent().parent();
	var videoname = videoBlock.children("input.videoname").val();
	delete videoSource[videoname];
	videoBlock.find("video").each(function(){
	    this.pause(); // can't hurt
	    delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
	    $(this).remove(); // this is probably what actually does the trick
	});
	// ---- 04/2019, frame view
	videoBlock.children("div.frames").remove();
	$(this).removeClass("destroyVideo").addClass("loadVideo").html("Load Video");
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
// get the current offset of the two video
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.getOffset",function(){
	if(hasTwo($(this).parent().parent()))
	{
		var leftVideoName = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var rightVideoName = $(this).parent().parent().children("input.videoname").val();
		var baseVideoObject = videoSource[leftVideoName]['object'];
		var thisVideoObject = videoSource[rightVideoName]['object'];
		var newoffset = thisVideoObject.currentTime - baseVideoObject.currentTime;
		$(this).parent().children("input.offset").val(newoffset);
	}
});
// check whether
function hasTwo(videoBlock)
{
	if(($("#cIndex > div.videoPairs > div.left > div.srcVideo").find("video").length > 0) && (videoBlock.find("video").length > 0))
	{
		return true;
	}
	return false;
}
// --- 04 /2019 , frame pair view
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.getOffsetFrame",function(){
	if(hasTwoFrame($(this).parent().parent()))
	{
		var leftFrameIdx = $("#cIndex > div.videoPairs > div.left > div.srcFrames > div.ctr > input.frameIdx").val();
		var leftFps = $("#cIndex > div.videoPairs > div.left > div.srcFrames > div.ctr > span.fps").html();
		var rightFrameIdx = $(this).parent().parent().find("div.frames > div.ctr > input.frameIdx").val();
		var rightFps = $(this).parent().parent().find("div.frames > div.ctr > span.fps").html();
		if((leftFrameIdx == "") || (leftFps == "") || (rightFrameIdx == "") || (rightFps == ""))
		{
			return;
		}
		leftFrameIdx = parseInt(leftFrameIdx);
		rightFrameIdx = parseInt(rightFrameIdx);
		leftFps = parseFloat(leftFps);
		rightFps = parseFloat(rightFps);
		var newoffset = rightFrameIdx/rightFps - leftFrameIdx/leftFps;
		$(this).parent().children("input.offset").val(newoffset);
	}
});
function hasTwoFrame(videoBlock)
{
	if(($("#cIndex > div.videoPairs > div.left > div.srcFrames").find("div.ctr").length > 0) && (videoBlock.find("div.frames > div.ctr").length > 0))
	{
		return true;
	}
	return false;
}
function stopAll()
{
	for(var videoname in videoSource)
	{
		videoSource[videoname]['object'].pause();
	}
}

cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.playSync",function(){
	
	//get the offset first
	var offset = parseFloat($(this).parent().children("input.offset").val());
	var srcVideoName = $("#cIndex > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
	var desVideoName = $(this).parent().parent().children("input.videoname").val();
	//if((videoSource[srcVideoName] == null) || (videoSource[desVideoName] == null))
	if(!hasTwo($(this).parent().parent()))
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
}
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
// -------------------------------------  added 04/2019, for frame by frame checking

// ---------1. change from video to frame view
cw.ec("#cIndex > div.videoPairs > div.left > div.visualMatch > div.title > div.goToFrame", function(){
	$("#cIndex > div.videoPairs > div.left > div.srcVideo").hide();
	$("#cIndex > div.videoPairs > div.left > div.srcFrames").show();
});
cw.ec("#cIndex > div.videoPairs > div.left > div.visualMatch > div.title > div.goToVideo", function(){
	$("#cIndex > div.videoPairs > div.left > div.srcVideo").show();
	$("#cIndex > div.videoPairs > div.left > div.srcFrames").hide();
});
// ---- change view for des videos
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.goToFrame", function(){
	$(this).parent().parent().children("div.frames").show()
		.parent().children("video").hide();
});
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.goToVideo", function(){
	$(this).parent().parent().children("div.frames").hide()
		.parent().children("video").show();
});
// --- get frames
cw.ec("#cIndex > div.videoPairs > div.left > div.srcFrames > div.frame > div.getFrames, #cIndex > div.videoPairs > div.right > div.videoList > div.block > div.frames > div.frame > div.getFrames", function(){
	var $topBlock = $(this).parent().parent();
	var data = {};
	data.videoId = $topBlock.parent().find("input.videoId").val();
	cw.post(cw.url + "getVideoFrames", data, function(result){
		var $topBlock = $(this);
		$topBlock.children("div.frame").html('');
		if(result.status == 0)
		{
			if(result.hasResult == 1)
			{
				$topBlock.find("div.ctr > span.fps").html(result.video.fps);
				$topBlock.find("div.ctr > span.num_frame").html(result.video.num_frame);
				var showFrameIdx = $topBlock.find("div.ctr > input.frameIdx").val();
				if(showFrameIdx == "")
				{
					showFrameIdx = 1;
				}
				else
				{
					showFrameIdx = parseInt(showFrameIdx);
				}

				$topBlock.children("div.frame").append(makeFrameStr(showFrameIdx, result.video.frame_rel_path));
			}
			else
			{
				if($topBlock.parent().hasClass("isDes"))
				{
					// show progress of getting frames
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#getDesVideoFrameProgress > input.processId").val(result.processId);
						$("#getDesVideoFrameProgress > input.showing").val(1).change();
						$("#getDesVideoFrameProgress > input.updating").val(1).change();
						$("#cIndex > input.curFrameDesVideoId").val(result.videoId);
					}
					else
					{
						alert(result.processError);
					}
				}
				else{
					// show progress of getting frames
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#getSrcVideoFrameProgress > input.processId").val(result.processId);
						$("#getSrcVideoFrameProgress > input.showing").val(1).change();
						$("#getSrcVideoFrameProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
				
			}
		}
		else
		{
			$topBlock.children("div.frame").html(result.error);
		}
	}, $topBlock);
	// this object is gone
	$topBlock.children("div.frame").html('<div class="loading"></div>');
});
// frame extraction done
// src video
cw.ech("#cIndex > div.videoPairs > div.left > div.srcFrames > input.frameDone", function(){
	var $topBlock = $(this).parent();
	var data = {};
	data.videoId = $(this).parent().parent().children("input.videoId").val();
	cw.post(cw.url + "getVideoFrames", data, function(result){
		var $topBlock = $(this);
		$topBlock.children("div.frame").html('');
		if(result.status == 0)
		{
			if(result.hasResult == 1)
			{
				$topBlock.find("div.ctr > span.fps").html(result.video.fps);
				$topBlock.find("div.ctr > span.num_frame").html(result.video.num_frame);
				var showFrameIdx = $topBlock.find("div.ctr > input.frameIdx").val();
				if(showFrameIdx == "")
				{
					showFrameIdx = 1;
				}
				else
				{
					showFrameIdx = parseInt(showFrameIdx);
				}

				$topBlock.children("div.frame").append(makeFrameStr(showFrameIdx, result.video.frame_rel_path));
			}
		}
		else
		{
			$topBlock.children("div.frame").html(result.error);
		}
	}, $topBlock);
});
// des video
cw.ech("#cIndex > input.desVideoFrameExtractDone", function(){
	var desVideoId = $("#cIndex > input.curFrameDesVideoId").val();
	var $topBlock = $("#cIndex > div.videoPairs > div.right > div.videoList > div.block > input.videoId[value='"+desVideoId+"']").parent().children("div.frames");
	var data = {};
	data.videoId = desVideoId;
	cw.post(cw.url + "getVideoFrames", data, function(result){
		var $topBlock = $(this);
		$topBlock.children("div.frame").html('');
		if(result.status == 0)
		{
			if(result.hasResult == 1)
			{
				$topBlock.find("div.ctr > span.fps").html(result.video.fps);
				$topBlock.find("div.ctr > span.num_frame").html(result.video.num_frame);
				var showFrameIdx = $topBlock.find("div.ctr > input.frameIdx").val();
				if(showFrameIdx == "")
				{
					showFrameIdx = 1;
				}
				else
				{
					showFrameIdx = parseInt(showFrameIdx);
				}

				$topBlock.children("div.frame").append(makeFrameStr(showFrameIdx, result.video.frame_rel_path));
			}
		}
		else
		{
			$topBlock.children("div.frame").html(result.error);
		}
	}, $topBlock);
});

//------------------ frame view controls
cw.ec("#cIndex > div.videoPairs > div.left > div.srcFrames > div.frame > div.frame_ctr > div.prev_frame, #cIndex > div.videoPairs > div.right > div.videoList > div.block > div.frames > div.frame > div.frame_ctr > div.prev_frame", function(){
	var curFrameIdx = $(this).parent().children("input.curFrameIdx").val();
	curFrameIdx = parseInt(curFrameIdx);
	var showFrameIdx = curFrameIdx - 1;
	if(showFrameIdx <= 0)
	{
		return;
	}
	showFrame($(this).parent().parent(), showFrameIdx);
	$(this).parent().parent().parent().find("div.ctr > input.frameIdx").val(showFrameIdx);
});
cw.ec("#cIndex > div.videoPairs > div.left > div.srcFrames > div.frame > div.frame_ctr > div.next_frame, #cIndex > div.videoPairs > div.right > div.videoList > div.block > div.frames > div.frame > div.frame_ctr > div.next_frame", function(){
	var maxframeIdx = $(this).parent().parent().parent().find("div.ctr > span.num_frame").html();
	maxframeIdx = parseInt(maxframeIdx);
	var curFrameIdx = $(this).parent().children("input.curFrameIdx").val();
	curFrameIdx = parseInt(curFrameIdx);
	var showFrameIdx = curFrameIdx + 1;
	if(showFrameIdx > maxframeIdx)
	{
		return;
	}
	showFrame($(this).parent().parent(), showFrameIdx);
	$(this).parent().parent().parent().find("div.ctr > input.frameIdx").val(showFrameIdx);
});

// get the video current frame
cw.ec("#cIndex > div.videoPairs > div.left > div.srcFrames > div.ctr > div.getCurVideoFrame", function(){
	var curVideoTime = $("#cIndex > div.videoPairs > div.left > div.visualMatch > div.title > span.videoTime").html();
	if(curVideoTime == "")
	{
		$(this).parent().children("span.info").html("Please play the video first.").emptyLater();
		return;
	}
	curVideoTime = parseFloat(curVideoTime);
	var fps = $(this).parent().children("span.fps").html();
	if(fps == "")
	{
		$(this).parent().children("span.info").html("Please load video frame first.").emptyLater();
		return;
	}
	fps = parseFloat(fps);
	var max_frame = $(this).parent().children("span.num_frame").html();
	max_frame = parseInt(max_frame);
	var curFrameIdx = parseInt(curVideoTime*fps);
	curFrameIdx = curFrameIdx > max_frame? max_frame:curFrameIdx;
	curFrameIdx = curFrameIdx == 0? 1:curFrameIdx;
	
	$(this).parent().children("input.frameIdx").val(curFrameIdx);
	showFrame($("#cIndex > div.videoPairs > div.left > div.srcFrames > div.frame"), curFrameIdx);
});
// for des video
cw.ec("#cIndex > div.videoPairs > div.right > div.videoList > div.block > div.frames > div.ctr > div.getCurVideoFrame", function(){
	var curVideoTime = $(this).parent().parent().parent().children("div.ctr").children("span.videoTime").html();
	if(curVideoTime == "")
	{
		$(this).parent().children("span.info").html("Please play the video first.").emptyLater();
		return;
	}
	curVideoTime = parseFloat(curVideoTime);
	var fps = $(this).parent().children("span.fps").html();
	if(fps == "")
	{
		$(this).parent().children("span.info").html("Please load video frame first.").emptyLater();
		return;
	}
	fps = parseFloat(fps);
	var max_frame = $(this).parent().children("span.num_frame").html();
	max_frame = parseInt(max_frame);
	var curFrameIdx = parseInt(curVideoTime*fps);
	curFrameIdx = curFrameIdx > max_frame? max_frame:curFrameIdx;
	curFrameIdx = curFrameIdx == 0? 1:curFrameIdx;
	$(this).parent().children("input.frameIdx").val(curFrameIdx);
	showFrame($(this).parent().parent().children("div.frame"), curFrameIdx);
});

function showFrame($frameTop, frameIdx)
{
	$frameTop.find("div.frame_ctr > input.curFrameIdx").val(frameIdx);
	var framepath = $frameTop.find("div.frame_ctr > input.framepath").val();
	$frameTop.children("img.videoFrame").prop("src", "<?php echo Yii::app()->baseUrl?>/"+framepath+frameIdx+'.jpg');
}

function makeFrameStr(showFrameIdx, framepath)
{
	temp = 
		'<div class="frame_ctr">'+
			'<input class="framepath" type="hidden" value="'+framepath+'"></input>'+
			'<input class="curFrameIdx" type="hidden" value="'+showFrameIdx+'"></input>'+
			'<div class="btn btn-small btn-primary prev_frame">Prev</div> '+
			'<div class="btn btn-small btn-primary next_frame">Next</div>'+
		'</div>'+
		'<img class="videoFrame" src="<?php echo Yii::app()->baseUrl?>/'+framepath+showFrameIdx+'.jpg"></img>';
	return temp;
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
<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px"> You are at - Audio Synchronization Video Pair View - <?php echo $videoname?>
&nbsp;&nbsp;
<?php if($showBackLink){ ?>
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncRun?datasetId=<?php echo $datasetId; ?>&forLabeling=<?php echo $forLabeling;?>" style="text-decoration:none">Back to Video List</a>
<?php } ?>
</div>
<style type="text/css">
div.srcFrames > div.frame, div.block > div.frames > div.frame{
	height: 400px;
	text-align: center;
}
div.srcFrames > div.frame > div.frame_ctr, div.block > div.frames > div.frame > div.frame_ctr{
	text-align: center;
}
div.srcFrames > div.frame > img, div.block > div.frames > div.frame > img{
	max-width: 100%;
	max-height: 90%;
}
</style>
<div id="cIndex">
	<input class="gotoDatasetList" type="hidden"></input>
	<div class="datasetList">
		
	</div>
	<input class="datasetId" type="hidden" value=""></input>
	<input class="curFrameDesVideoId" type="hidden" value=""></input>
	<input class="desVideoFrameExtractDone" type="hidden" value=""></input>
	<div class="datasetVideos"></div>
	<input class="srcVideoDvId" type="hidden" value=""></input>
	<div class="videoPairs" style="display: none">
	<!--
		<div class="notice" style="position:absolute;top:20px;left:0;width:100%;text-align:center;color:gray;font-weight:bold;">
			please wait till videos are buffered to play sync.
		</div>
		-->
		<div class="left">
			<?php 
				$this->widget("ProgressWidget",array(
					"id" => "getSrcVideoFrameProgress",
					"doneCall" => "#cIndex > div.videoPairs > div.left > div.srcFrames > input.frameDone",
					"noMessage" => false,
				));
			?>
			<?php 
				$this->widget("ProgressWidget",array(
					"id" => "getDesVideoFrameProgress",
					"doneCall" => "#cIndex > input.desVideoFrameExtractDone",
					"noMessage" => false,
				));
			?>
			<div class="srcVideo">
			</div>
			<input class="videoId" type="hidden"></input>
			<div class="srcFrames" style="display:none">
				<input class="frameDone" type="hidden"></input>
				<div class="frame">
					<div class="btn btn-small btn-info getFrames">Get Frames</div>
				</div>
				<div class='ctr'>
					Video FPS: (<span class="text-error fps"></span>)
					# Frames: (<span class="text-error num_frame"></span>)
					Frame ID: <input class="frameIdx input-small" style="width:40px" type="text" value="1"></input> 
					<div class="btn btn-small btn-success getCurVideoFrame">Show Current Video Frame</div>
					<span class="text-error info"></span>
				</div>
			</div>
			<div class="ctr" style="position:relative">
				<!--<div class="btn btn-success play">play together from the start</div>
				<canvas id="audioForSrc" style="height:100px;position:absolute;top:0;right:0;width:200px;"></canvas>
				<canvas id="audioForDes" style="height:100px;position:absolute;top:0;right:0;width:200px;"></canvas>
				<div class="btn btn-info stop">stop all</div>-->
			</div>
			<div class="segmentTools" style="display:none">
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
			<div class="visualMatch" style="text-align:left;">
				<div class="title" style="font-weight:bold;">
					Frame by Frame Checking 
					<div class="btn btn-small btn-success goToFrame">FrameView</div>
					<div class="btn btn-small btn-primary goToVideo">VideoView</div>
					Current Video Time: (<span class="text-info videoTime"></span>)
				</div>
			</div>
			<div class="instruction" style="text-align:left;">
				<div class="title" style="font-weight:bold;">Instruction</div>
				<div class="muted">Use headset so that you can hear two videos seperately from the left and right. First click "Play Sync" to watch whether the system's offset results are correct. If not, to find the offset of two video manually, watch them seperately and stop both of them at an approxiamately aligned time. Then click "Get Offset" to get the current offset. Drag the left video's progress bar and click "play sync" to play both videos and see whether the sync is correct. During two videos playing, you can click "Both Jump Back" to review certain details again. If the sync is not completely correct, use the &plus; / &minus; button to slightly ajust the offset, then play sync again. After you are done, click "save offset" and "correct". Noted that videos should be buffered before playing.</div>
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
				<div class="searchVideo">
					<input class="input-large videoname" type="text"></input> 
					<div class="btn btn-small btn-info search">search</div>
					<div class="btn btn-small btn-success set">setVideo</div>
					<span class="text-error info"></span>
					<br/>
					<div class="dismissGuess close" style="display:none">&times;</div>
					<div class="guessList"></div>
				</div>
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
