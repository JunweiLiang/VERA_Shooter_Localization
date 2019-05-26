
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		//"#cIndex > input.gotoDatasetList",
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
<style type="text/css">
#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cWatch{
		position:relative;
		padding:5px;
	}
	#cWatch input{margin:0}
	#cWatch div.searchVideo > div.guessList{
		padding:5px;
	}
	#cWatch div.searchVideo > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cWatch div.searchVideo > div.guessList > div.block:hover{
		color:gray
	}
	#cWatch div.display > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	#cWatch div.display > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cWatch > div.left{
		position:fixed;
		top:45px;
		left:0%;
		padding-left:5px;
		width:50%;
	}
	#cWatch > div.right{
		margin:0 0 0 50%;
		padding-left:10px;
	}
	#cWatch video{
		width:100%;
	}
</style>
<script type="text/javascript">
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
	});
	//set videos
	var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
	//create source now.
	var videoSource = {};
	//videoSource = {'1':2,'d':4};
	//alert(videoSource.keys().length);
	var srcAnalyser = null;// analyser for src video
	var top1Analyser = null;//analyser for top 1 des video
	var merger = null;
	cw.ec("div.searchVideo > div.set",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchVideo",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			$(this).parent().parent().children("div.display").html('');
			if(result.videoList.length == 0)
			{
				$(this).parent().parent().children("div.display").html('<div class="wrapLoading">Video Not Found</div>');
			}
			else
			{
				var video = result.videoList[0];
				var isLeft = $(this).parent().parent().hasClass("left");
				//alert(isLeft);
				var $display = $(this).parent().parent().children("div.display");
				$display.html(makeVideoHtml(video,isLeft));
				//remember video source
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource($display.find("video").get(0)),
					"object":$display.find("video").get(0)
				};
				//connect to a merge now
				merger = audioCtx.createChannelMerger(2);
				if(isLeft)
				{
					videoSource[video.videoname]['source'].connect(merger,0,0);
				}
				else
				{
					videoSource[video.videoname]['source'].connect(merger,0,1);
				}
				merger.connect(audioCtx.destination);
				if(hasTwo())//check left and right video ready
				{
					var i =0;
					var leftVideoName = $("#cWatch > div.left > div.display > div.block > input.videoname").val();
					var rightVideoName = $("#cWatch > div.right > div.display > div.block > input.videoname").val();
					//alert(leftVideoName);
					//set the sound graph
					srcAnalyser = audioCtx.createAnalyser();
					videoSource[leftVideoName]['source'].connect(srcAnalyser);
					bindAudioV("#audioVForSrc"+i,srcAnalyser,videoSource[leftVideoName]['object'],"rgba(0,0,0,0.7)");
					top1Analyser = audioCtx.createAnalyser();
					videoSource[rightVideoName]['source'].connect(top1Analyser);
					bindAudioV("#audioVForDes"+i,top1Analyser,videoSource[rightVideoName]['object'],"rgba(255,175,0,0.9)");
				}
			}
		},$(this));
	});

	//play sync
	cw.ec("#cWatch div.display > div.block > div.ctr > div.playSync",function(){
		if(!hasTwo())
		{
			alert("Needs two video!");
			return;
		}
		var leftVideoName = $("#cWatch > div.left > div.display > div.block > input.videoname").val();
		var rightVideoName = $("#cWatch > div.right > div.display > div.block > input.videoname").val();
		//alert(leftVideoName+rightVideoName);
		//get the offset first
		var offset = parseFloat($(this).parent().children("input.offset").val());
		var baseVideoSource = videoSource[leftVideoName]['source'];
		var baseVideoObject = videoSource[leftVideoName]['object'];
		var thisVideoSource = videoSource[rightVideoName]['source'];
		var thisVideoObject = videoSource[rightVideoName]['object'];
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
		stopAll();
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
		
		baseVideoObject.play();
		thisVideoObject.play();
	}
	cw.ec("#cWatch div.display > div.block > div.ctr > div.stop",function(){
		stopAll();
	});
	//get the current offset based on the two video current Time
	cw.ec("#cWatch div.display > div.block > div.ctr > div.getCurOffset",function(){
		if(hasTwo())
		{
			var leftVideoName = $("#cWatch > div.left > div.display > div.block > input.videoname").val();
			var rightVideoName = $("#cWatch > div.right > div.display > div.block > input.videoname").val();
			var baseVideoObject = videoSource[leftVideoName]['object'];
			var thisVideoObject = videoSource[rightVideoName]['object'];
			var newoffset = thisVideoObject.currentTime - baseVideoObject.currentTime;
			$(this).parent().children("input.offset").val(newoffset);
		}
	});
	//two video jump together
	cw.ec("#cWatch div.display > div.block > div.ctr > div.jumpAhead",function(){
		if(hasTwo())
		{
			var jump = parseFloat($(this).parent().children("input.jump").val());
			var leftVideoName = $("#cWatch > div.left > div.display > div.block > input.videoname").val();
			var rightVideoName = $("#cWatch > div.right > div.display > div.block > input.videoname").val();
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
	cw.ec("#cWatch div.display > div.block > div.ctr > div.jumpBack",function(){
		if(hasTwo())
		{
			var jump = -parseFloat($(this).parent().children("input.jump").val());
			var leftVideoName = $("#cWatch > div.left > div.display > div.block > input.videoname").val();
			var rightVideoName = $("#cWatch > div.right > div.display > div.block > input.videoname").val();
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
	// change the offset a bit
cw.ec("#cWatch div.display > div.block > div.ctr > i.co",function(){
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
	function hasTwo()
	{
		if(($("#cWatch > div.left").find("video").length > 0) && ($("#cWatch > div.right").find("video").length > 0))
		{
			return true;
		}
		return false;
	}
	function makeVideoHtml(video,isLeft)
	{
		$temp = $('<div class="block">'+
			'<input class="videoname" value="'+video.videoname+'" type="hidden"></input>'+
				'<video controls>'+
					'<source src="<?php echo Yii::app()->baseUrl?>/'+video.relatedPath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video>'+
		'</div>');
		if(!isLeft)
		{
			var i = 0;
			$temp.append('<div class="ctr" style="position:relative">'+
				'<canvas id="audioVForSrc'+i+'" style="height:140px;position:absolute;z-index:1;top:30px;left:0;width:150px;"></canvas>'+
				'<canvas id="audioVForDes'+i+'" style="height:140px;position:absolute;z-index:2;top:30px;left:0;width:150px;"></canvas>'+
				'<span class="text-error videoname">'+video.videoname+'</span><br/> '+
				//'offset: <span class="text-error offset"></span><br/>'+
				'<i class="co icon-plus" title="this video is behind global time"></i> '+
				'offset: <input class="offset input-medium" type="text" value="0"></input> (s) '+
				'<i class="co icon-minus" title="this video is ahead of global time"></i><br/> '+
				'<div class="btn btn-info playSync">play sync start from left</div> <div class="btn btn-info stop">stop all</div><br/> '+
				'<div class="btn btn-info getCurOffset">current offset</div><br/> '+
				'<div class="btn btn-info jumpAhead">jump ahead</div> '+
				'<div class="btn btn-info jumpBack">jump back</div><br/> '+
				'<input class="jump input-small" type="text" value="10"></input>s <br/>'+
				'<span class="text-error errorInfo info"></span>'+
			'</div>');
		}
		return $temp;
	}
// for audio bar
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
</script>
<div id="cWatch">
	<div class="left">
		<div class="searchVideo">
			<input class="input-large videoname" type="text"></input> 
			<div class="btn btn-small btn-info search">search</div>
			<div class="btn btn-small btn-success set">setVideo</div>
			<span class="text-error info"></span>
			<br/>
			<div class="guessList"></div>
		</div>
		<div class="display"></div>
	</div>
	<div class="right">
		<div class="searchVideo">
			<input class="input-large videoname" type="text"></input> 
			<div class="btn btn-small btn-info search">search</div>
			<div class="btn btn-small btn-success set">setVideo</div>
			<span class="text-error info"></span>
			<br/>
			<div class="guessList"></div>
		</div>
		<div class="display"></div>
	</div>
</div>