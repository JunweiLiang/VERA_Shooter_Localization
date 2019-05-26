
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
	#cCrowdCounting{
		position:relative;
		padding:5px;
	}
	#cCrowdCounting input{margin:0}
	#cCrowdCounting div.searchVideo > div.guessList{
		padding:5px;
	}
	#cCrowdCounting div.searchVideo > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cCrowdCounting div.searchVideo > div.guessList > div.block:hover{
		color:gray
	}
	#cCrowdCounting div.display > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	#cCrowdCounting div.display > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cCrowdCounting > div.left{
		/*
		position:fixed;
		top:45px;
		left:0%;
		width:40%;
		*/
		padding-left:5px;
		float:left;
		width:40%;
	}
	#cCrowdCounting > div.right{
		margin:0 0 0 40%;
		padding-left:10px;
	}
	#cCrowdCounting video{
		width:100%;
	}
	#cCrowdCounting > div.left div.title{
		text-align:center;
	}
	#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > div.progressForImportVideo{
		width:200px;
	}
	#cCrowdCounting > div.right > div.personBlocks > div.block {
		margin-bottom:10px;
		border-radius:5px;
		background-color:rgb(220,220,220);
		padding:10px;
		font-weight:bold;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
</style>
<script type="text/javascript">
//get into the page and try to load the first detection results
$(document).ready(function(){
	<?php 
	if($videoname!="")
	{
		?>
	clickOneRun = true;
	$("#cCrowdCounting > div.left > div.searchVideo > input.videoname").val("<?php echo $videoname?>");
	$("#cCrowdCounting > div.left > div.searchVideo > div.detect").trigger(cw.ectype);
	<?php }else{ ?>
	getRunList(true);
	<?php } ?>
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
	function beforeUpload()
	{
		$("#cCrowdCounting > div.left > div.uploadVideo > span.info").html("");
		$("#cCrowdCounting > div.left > div.preprocessing").hide();
		$("#cCrowdCounting > div.left > div.processing").hide();
		return true;
	}
	// succes upload
	function videoUploadOk(data)
	{
		//保存在空的input中
		/*
		for(var key in data)
		{
			alert(key);//status
		}*/
		$("#cCrowdCounting > div.left > div.uploadVideo > input.newvideoUrl").val(data.url);
		$("#cCrowdCounting > div.left > div.uploadVideo > span.info").html("Upload Success");
		$("#cCrowdCounting > div.left > div.preprocessing").show();
		// trigger the system to load this video into database
		loadVideo(data.url);
	}
	function videoUploadError(str)
	{
		$("#cCrowdCounting > div.left > div.uploadVideo > span.info").html(str);
	}
	// load video into database, may trigger process
	function loadVideo(url)
	{
		
		var data = {};
		data.url = url;
		// put the video name into search input, so that after it is in the database, it can be used for person detection
		var filename = baseName(data.url);
		$("div.searchVideo > input.videoname").val(filename);
		//alert(url);
		//$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("<div class='wrapLoading'><div class='loading'></div></div>");
		$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("posting request...");
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/importVideo",data,function(result){
			if(result.status == 0)
			{
				//display counting results
				/*
				$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html(
					result.count.addToDatabase+" added to database directly, since related path and original path exists;<br/>"+
					result.count.ignore+" are ignored since original not exists;<br/>"+
					result.count.furtherProcess+" are posted to python for futher process<br/>"+
					"python will need 5 minutes to process a 40-minute video"
				);*/
				if(result.count.furtherProcess != 0)
				{
					$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Loading video...");
				}
				else
				{
					$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded. Please click Run Crowd Counting");
				}
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#importVideoProgress > input.processId").val(result.processId);
					$("#importVideoProgress > input.showing").val(1).change();
					$("#importVideoProgress > input.updating").val(1).change();
				}
			}
		})
	}
	//video import success, tell them to click run person
	cw.ech("#cCrowdCounting > div.left > div.preprocessing > input.importDone",function(){
		$("#cCrowdCounting > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded. Please click Run PersonDetection Detection");
	});
	function baseName(str)
	{
	   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
	   // if(base.lastIndexOf(".") != -1)       
	    //    base = base.substring(0, base.lastIndexOf("."));
	   return base;
	}
	//set videos
	var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
	//create source now.
	var videoSource = {};
	var videoAnalyser = null;// analyser for src video
	// crowd counting
	cw.ec("#cCrowdCounting > div.left > div.searchVideo > div.detect",function(){
		// show video first		
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		$(this).addClass("disabled");
		$("#cCrowdCounting > div.right > div.ctr").hide();
		$("#cCrowdCounting > div.right > div.personBlocks").hide();
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchVideo",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			$(this).parent().parent().children("div.display").html('');
			if(result.videoList.length == 0)
			{
				$(this).parent().children("span.info").html('<div class="wrapLoading">Video Not Found</div>');
			}
			else
			{
				var video = result.videoList[0];
				$("#cCrowdCounting > div.right > input.videoname").val(video.videoname);
				//alert(isLeft);
				var $display = $("#cCrowdCounting > div.right > div.display");
				$display.html(makeVideoHtml(video));
				//remember video source
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource($display.find("video").get(0)),
					"object":$display.find("video").get(0)
				};
				videoAnalyser = audioCtx.createAnalyser();
				videoSource[video.videoname]['source'].connect(videoAnalyser);
				videoAnalyser.connect(audioCtx.destination);
				//bindAudioV("#audioVForDes",videoAnalyser,videoSource[video.videoname]['object'],"rgba(0,0,0,0.7)");
				// start the person detection now.
				$("#cCrowdCounting > div.left > div.processing").show();
				postDetectionJob(video.videoname);
				//bind video for segment playing
				bindVideoStop(videoSource[video.videoname]['object']);
			}
		},$(this));
	});
	cw.ec("#cCrowdCounting > div.left > div.searchVideo > div.seeVideo",function(){
		// show video first		
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		$("#cCrowdCounting > div.right > div.ctr").hide();
		$("#cCrowdCounting > div.right > div.personBlocks").hide();
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchVideo",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			$(this).parent().parent().children("div.display").html('');
			if(result.videoList.length == 0)
			{
				$(this).parent().children("span.info").html('<div class="wrapLoading">Video Not Found</div>');
			}
			else
			{
				var video = result.videoList[0];
				$("#cCrowdCounting > div.right > input.videoname").val(video.videoname);
				//alert(isLeft);
				var $display = $("#cCrowdCounting > div.right > div.display");
				$display.html(makeVideoHtml(video));
				//remember video source
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource($display.find("video").get(0)),
					"object":$display.find("video").get(0)
				};
				videoAnalyser = audioCtx.createAnalyser();
				videoSource[video.videoname]['source'].connect(videoAnalyser);
				videoAnalyser.connect(audioCtx.destination);
				//bindAudioV("#audioVForDes",videoAnalyser,videoSource[video.videoname]['object'],"rgba(0,0,0,0.7)");
				
			}
		},$(this));
	});
	var personResult = new Array();
	function postDetectionJob(videoname)
	{
		personResult = new Array();
		// clean the person detection result section.
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.detectionGraph").html("").parent().find("div.info > div.wrapLoading > span.info").html("");
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult").hide()
			.find("div.things").hide().end()
			.find("div.things > img.original").prop("src","").end()
			.find("div.things > div.resultType > div.type").removeClass("toggle").end()
			.find("div.things > div.resultType > div.original").addClass("toggle");
		resetFrameDetection();
		// send the videoname to ask for result. If already have it, show result. if not, wait for python
		var data = {};
		data.videoname = videoname;
		var rerun = $("#cCrowdCounting > div.left > div.searchVideo > input.rerun").prop("checked");
		data.rerun = rerun?1:0;
		// reset this now
		$("#cCrowdCounting > div.left > div.searchVideo > input.rerun").prop("checked",false);
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.info > div.wrapLoading > span.info").html('<div class="loading"></div>');
		$("#cCrowdCounting > div.left > div.processing > input.personDone").val(videoname);// remember it
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getPersonDetection",data,function(result){
			if(result.status == 0)
			{
				$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.info > div.wrapLoading > span.info").html('');
				if(result.haveResult == 1)
				{
					//show the result
					// set the detection graph via runId
					$("#cCrowdCounting > div.right > div.ctr").show();
						$("#cCrowdCounting > div.right > div.ctr > div.line > input.thres").val(20);
						$("#cCrowdCounting > div.right > div.ctr > div.line > input.padding").val(1.0);
					$("#cCrowdCounting > div.right > div.personBlocks").show();
					$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.detectionGraph").html('<img src="<?php echo Yii::app()->baseUrl?>/assets/personGraph/'+result.runId+'_prob.png"></img>');
					
					//show more result things
					$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult").show();
					var resultType = $("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type.toggle").html();
					//$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > img.original").prop('src','<?php echo Yii::app()->baseUrl?>/assets/personGraph/'+result.runId+'_original.png');
					
					// save the result locally, so that 
					//alert(resultType);
					personResult = result.scoreList;

					segments = getSegments(personResult[resultType],20.0);
					//console.log(segments);
					setSegments(segments);
					//alert(segments.length);
					$("#cCrowdCounting > div.right > div.display > div.block > video").get(0).addEventListener("loadedmetadata",function(){
						//alert("done");
						$("#cCrowdCounting > div.right > div.ctr > div.line > div.setThres").trigger(cw.ectype);
					});
					// load the frame detection big img
					// no need, we use pack.mp4 now
					//loadFrameDetectionImage("<?php echo Yii::app()->baseUrl?>/assets/personGraph/"+result.runId+"_pack.png",personResult[resultType].length);
					loadFrameDetectionVideo("<?php echo Yii::app()->baseUrl?>/assets/personGraph/"+result.runId+"_pack.mp4");
				}
				else
				{
					$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.info > div.wrapLoading > span.info").html('Processing...');
					//set processId and wait for python
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#personProgress > input.processId").val(result.processId);
						$("#personProgress > input.showing").val(1).change();
						$("#personProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
			}
		});
	}
	//var frameDetectionImageLoaded = false;
	//var onePicWidth = null;
	//var detectionLength = null;// one detection last how long?
	function loadFrameDetectionImage(src,imageCount)
	{
		resetFrameDetection();
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection").show().children("div.loadingFrame").show();
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionImage > img.big").on("progress",function(e){
			//alert("c");
			if(e.lengthComputable)
			{
				//alert('a');
				var progressValue = e.loaded/e.total*100;
				$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.loadingFrame > div.progress > div.bar").width(progressValue+"%");
			}
		})
			.on("load",function(){
				//alert("c");
				$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.loadingFrame").hide().parent().children("div.frameDetectionImage").show();

				// set the original size and position
				$(this).width(this.naturalWidth).height(this.naturalHeight).css("top",0).css("left",0);
				//alert(this.naturalWidth);
				onePicWidth = this.naturalWidth/imageCount;
				//alert(onePicWidth);
				$(this).parent().width(onePicWidth).height(this.naturalHeight+5);
				frameDetectionImageLoaded = true;
				// bind the video with frame detection showing
				var videoObject = videoSource[$("#cCrowdCounting > div.right > input.videoname").val()]['object'];
				$(videoObject).on("timeupdate",function(){
					//alert("d");
					if(frameDetectionImageLoaded)
					{
						var pos = parseInt(this.currentTime/detectionLength);
						$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionImage > img.big").css("left",-onePicWidth*(pos+1));
					}
				});
			})
			.prop("src",src);
	}
	var detectionVideo = null
	function loadFrameDetectionVideo(src)
	{
		resetFrameDetection();
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionVideo > video > source").prop("src",src);
		detectionVideo = $("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionVideo > video").get(0);
		detectionVideo.load();
		var videoObject = videoSource[$("#cCrowdCounting > div.right > input.videoname").val()]['object'];
		$(videoObject).on("timeupdate",function(){
			if(detectionVideo != null)
			{
				detectionVideo.currentTime = this.currentTime;
			}
		});
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection").show();
	}
	function resetFrameDetection()
	{
		/*frameDetectionImageLoaded = false;
		//onePicWidth = null;
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection").hide().children("div.loadingFrame").hide().end()
			.children("div.frameDetectionImage").hide().end()
			.find("div.loadingFrame > div.progress > div.bar").width("0%").end()
			.find("div.frameDetectionImage > img").prop("src","");
		*/
		detectionVideo = null;
		$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection").hide().children("div.loadingFrame").hide().end()
			.children("div.frameDetectionImage").hide().end()
			.find("div.loadingFrame > div.progress > div.bar").width("0%").end()
			.find("div.frameDetectionImage > img").prop("src","").end()
			.find("div.frameDetectionVideo > video > source").prop("src","");
	}
	// set new threshold
	cw.ec("#cCrowdCounting > div.right > div.ctr > div.line > div.setThres",function(){
		var thres = parseFloat($(this).parent().children("input.thres").val());
		//alert(thres);
		var resultType = $("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type.toggle").html();
		segments = getSegments(personResult[resultType],thres);
		setSegments(segments);
	});
	function sec2time(secs)
	{
		var sec_num = secs;
	    var hours   = Math.floor(sec_num / 3600);
	    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	    var seconds = sec_num - (hours * 3600) - (minutes * 60);
	    seconds = seconds.toFixed(1);

	    if (hours   < 10) {hours   = "0"+hours;}
	    if (minutes < 10) {minutes = "0"+minutes;}
	    if (seconds < 10) {seconds = "0"+seconds;}
	    var time    = hours+':'+minutes+':'+seconds;
	    return time;
	}
	// given segments, make a lot of block in result display
	function setSegments(segments)
	{
		$("#cCrowdCounting > div.right > div.personBlocks").html("");
		var threshold = $("#cCrowdCounting > div.right > div.ctr > div.line > input.thres").val();
		// set the timeline stuff
		$("#timeline").html("");
		var duration = $("#cCrowdCounting > div.right > div.display > div.block > video").get(0).duration;
		// get the max score of all the segments
		var maxScore = -1;
		for(var i=0;i<segments.length;++i)
		{
			if(segments[i].personCount > maxScore)
			{
				maxScore = segments[i].personCount;
			}
		}
		for(var i=0;i<segments.length;++i)
		{
			$("#cCrowdCounting > div.right > div.personBlocks").append(
				'<div class="block">'+
					'<input class="startSec" type="hidden" value="'+segments[i].startSec+'"></input>'+
					'<input class="endSec" type="hidden" value="'+segments[i].endSec+'"></input>'+
					sec2time(segments[i].startSec)+" to "+sec2time(segments[i].endSec)+
					' has from '+threshold+' to '+segments[i].personCount+' person(s) <div class="btn btn-small btn-success playSegment">play person clip</div>'+
				'</div>'
			);
			if(!isNaN(duration))
			{
				var temp = $('<div class="block" title="'+sec2time(segments[i].startSec)+" to "+sec2time(segments[i].endSec)+', max '+segments[i].personCount+'">'+
					'<input class="startSec" type="hidden" value="'+segments[i].startSec+'"></input>'+
					'<input class="endSec" type="hidden" value="'+segments[i].endSec+'"></input>'+
					'</div>');
				var width = (segments[i].endSec - segments[i].startSec)/duration;
				width = width*100.0;
				var left = segments[i].startSec/duration;
				left = left*100.0;
				temp.css({"left":left+"%","width":width+"%"});
				//console.log(segments[i].endSec);
				if(duration - segments[i].endSec < 1.0)
				{
					temp.css({"width":"100%"});// so that it cover the tail
				}
				// set the color //background-color:rgb(255,200,0);
				var p = (segments[i].personCount - parseFloat(threshold))/(maxScore-parseFloat(threshold));// color relative to threshold
				//alert(p);
				var color = parseInt((1-p)*200);// color for green
				//alert(color);
				temp.css({"backgroundColor":"rgb(255,"+color+",0)"});

				$("#timeline").append(temp);
			}
		}
	}

	var segmentPlaying = false;
	var ending = null;
	//click play!!
	cw.ec("#cCrowdCounting > div.right > div.personBlocks > div.block > div.playSegment,#timeline > div.block",function(){
		if($(this).hasClass("block"))
		{
			//timeline block
			var startSec = parseFloat($(this).children("input.startSec").val());
			var endSec = parseFloat($(this).children("input.endSec").val());
		}
		else
		{
			var startSec = parseFloat($(this).parent().children("input.startSec").val());
			var endSec = parseFloat($(this).parent().children("input.endSec").val());
		}
		var padding = parseFloat($("#cCrowdCounting > div.right > div.ctr > div.line > input.padding").val());
		startSec-=padding;
		endSec+=padding;

		var videoObject = videoSource[$("#cCrowdCounting > div.right > input.videoname").val()]['object'];
		segmentPlaying = true;
		ending = endSec;
		videoObject.currentTime = startSec;
		videoObject.play();
	});
	//bind a video to watch for segment playing
	function bindVideoStop(videoObject)
	{
		$(videoObject).on("timeupdate",function(){
			//alert("d");
			if(segmentPlaying && (ending != null))
			{
				if(this.currentTime > ending)
				{
					//alert("o");
					this.pause();
				}
			}
		});
		// when stop, clean the global flag
		$(videoObject).on("pause",function(){
			//alert("ok");
			segmentPlaying = false;
			ending = null;
		});
	}
	//given a score list with time, and threshold, return  consecutive segments
	function getSegments(scoreList,thres)
	{
		// sort first
		scoreList.sort(function(a,b){return a.startSec - b.startSec});
		var segments = new Array();
		curSegment = {"personCount":0};
		for(var i=0;i<scoreList.length;++i)
		{
			var score = scoreList[i];
			detectionLength = score.length;
			if(parseFloat(score.personCount) >= thres)
			{

				if(curSegment.startSec == null)
				{
					curSegment.startSec = parseFloat(score.startSec);
				}
				curSegment.endSec = parseFloat(score.startSec)+parseFloat(score.length);
				if(parseFloat(score.personCount) > curSegment.personCount)
				{
					curSegment.personCount = parseFloat(score.personCount);
				}
			}
			else
			{
				// save this segment
				//console.log(curSegment.startSec);
				if((curSegment.startSec!=null)&& (curSegment.endSec != null))
				{
					segments.push(curSegment);
					curSegment = {"personCount":0};
				}
			}
		}
		if((curSegment.startSec!=null)&& (curSegment.endSec != null))
		{
			segments.push(curSegment);
		}
		return segments;
	}
	// person backend processing is done, get result
	cw.ech("#cCrowdCounting > div.left > div.processing > input.personDone",function(){
		var videoname = $(this).val();
		postDetectionJob(videoname);
	});
	function makeVideoHtml(video,isLeft)
	{
		$temp = $('<div class="block">'+
			'<input class="videoname" value="'+video.videoname+'" type="hidden"></input>'+
				'<video controls>'+
					'<source src="<?php echo Yii::app()->baseUrl?>/'+video.relatedPath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video>'+
		'</div>');
		
			$temp.append('<div class="ctr" style="position:relative;padding:0">'+
				//'<canvas id="audioVForDes" style="height:80px;position:absolute;z-index:2;top:2px;right:0;width:200px;"></canvas>'+
				//'<span class="text-error videoname">'+video.videoname+'</span><br/> '+
				//'<span class="text-error errorInfo"></span>'+
			'</div>');
		
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
//show more result or hide
cw.ec("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.show > div.showMore",function(){
	$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things").slideToggle();
});
// toggle different result
cw.ec("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type",function(){
	$("#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type").removeClass("toggle");
	$(this).addClass("toggle");
	// trigger changing result
	$("#cCrowdCounting > div.right > div.ctr > div.line > div.setThres").trigger(cw.ectype);
});
// see existing result.
cw.ec("#cCrowdCounting > div.left > div.line > div.runList",function(){
	getRunList();
	$("#runListModal").modal("show");
});
function getRunList()
{
	var clickOne = arguments[0]?arguments[0]:false; // whether to click the first run
	$("#runListModal > input.clickOne").val(clickOne);
	$("#runListModal > div.modal-body").html('<div class="wrapLoading"><div class="loading"></div></div>');
	var data = {};
	data.count = -1;
	// if the video is not destroy, after afew request it will stuck
	//save the video to a temp place
	$("#cCrowdCounting > div.right > input.videoTemp").val($("#cCrowdCounting > div.right > div.display > div.block > video > source").prop("src")); 
	$("#cCrowdCounting > div.right > div.display > div.block > video").prop("src","");
	$("#cCrowdCounting > div.right > div.display > div.block > video > source").prop("src","");
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getPersonRunList",data,function(result){
		if(result.status ==0)
		{
			var clickOne = $("#runListModal > input.clickOne").val()=="true"?true:false;
			$("#runListModal > div.modal-body").html('');
			for(var i=0;i< result.runList.length;++i)
			{
				$("#runListModal > div.modal-body").append(
					'<div class="block">'+
						'<input class="runId" type="hidden" value="'+result.runList[i].runId+'"></input>'+
						'<input class="videoname" type="hidden" value="'+result.runList[i].videoname+'"></input>'+
						result.runList[i].videoname+
						' <div class="close">&times</div>'+
					'</div>'
				);
			}
			if((result.runList.length>0) && (clickOne))
			{
				$("#runListModal > div.modal-body > div.block").eq(0).trigger(cw.ectype);
				clickOneRun = false;
			}
		}
	});
}
var clickOneRun = false;
// when the runlist modal is cancel, and no new video is load, get the videoTemp back
$(document).delegate("#runListModal","hide",function(){
	//alert(clickOneRun);
	if(!clickOneRun)
	{
		if($("#cCrowdCounting > div.right > input.videoTemp").val()!= "")
		{
			var oldvideo = $("#cCrowdCounting > div.right > input.videoTemp").val();
			//alert(oldvideo);
			$("#cCrowdCounting > div.right > div.display > div.block > video > source").prop("src",oldvideo);
			$("#cCrowdCounting > div.right > div.display > div.block > video").prop("src",oldvideo);
			$("#cCrowdCounting > div.right > div.display > div.block > video").get(0).load();
			$("#cCrowdCounting > div.right > input.videoTemp").val("");
		}
	}
	clickOneRun = false;
});
// click a video
cw.ec("#runListModal > div.modal-body > div.block",function(){
	videoname = $(this).children("input.videoname").val();
	// remember it have clickOne
	clickOneRun = true;
	$("#runListModal").modal("hide");
	$("#cCrowdCounting > div.left > div.searchVideo > input.videoname").val(videoname);
	$("#cCrowdCounting > div.left > div.searchVideo > div.detect").trigger(cw.ectype);
});
// delete a run
cw.ec("#runListModal > div.modal-body > div.block > div.close",function(e){
	e.stopPropagation();
	var data = {};
	data.runId = $(this).parent().children("input.runId").val();
	data.videoname = $(this).parent().children("input.videoname").val();
	if(!confirm("Confirm delete result for "+data.videoname+"?"))
	{
		return;
	}
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/deletePersonRun",data,function(result){
		if(result.status ==0)
		{
			getRunList();
		}
	});
});
</script>
<style type="text/css">
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult{
		display:none;
	}
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType{
		padding:5px;
		height:30px;
	}
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type{
		padding:5px;
		float:left;
		font-weight:bold;
		cursor:pointer;
		color:#49afcd;
		background-color:white;
		margin-right:10px;
		border-radius:5px;
	}
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.moreResult > div.things > div.resultType > div.type.toggle{
		color:white;
		background-color:#49afcd;
	}
	#cCrowdCounting #runListModal > div.modal-body > div.block{
		padding:10px;
		cursor:pointer;
		font-weight:bold;
		word-break:break-all;
	}#cCrowdCounting #runListModal > div.modal-body > div.block:hover{
		background-color:rgb(220,220,220);
	}
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionImage{
		height:400px;
		overflow:hidden;
		position:relative;
	}
	#cCrowdCounting > div.left > div.processing > div.personDetection > div.frameDetection > div.frameDetectionImage > img.big{
		max-width:none;
		top:0;
		left:0;
		position:absolute;
	}
	#timeline{
		background-color:white;
		border-radius:5px;
		height:20px;
		position:relative;
		margin:5px 0;
		margin-right:80px;
		margin-left:80px;-moz-box-shadow:0 1px 3px #999;              
 	  -webkit-box-shadow:0 1px 3px #999;           
 	   box-shadow:0 1px 3px #999;
 	   overflow:hidden;
	}
	#timeline::before{
		/*horizontal line*/
		 content: '';
		  position: absolute;
		  top: 50%;
		  left: 0;
		  height: 4px;
		  margin-top:-2px;
		  width: 100%;
		  background: #99D4FF;
	}
	#timeline > div.block{
		/*background-color:#5bb75b;*/
		background-color:rgb(255,200,0);
		position:absolute;
		height:20px;
		cursor:pointer;
		border-radius:5px;

	}
	#timeline > div.block:hover{
		/*background-color:#4CAF50;*/
	}
</style>
<div id="cCrowdCounting">
	<div class="modal hide fade" id="runListModal" style="width:500px;margin-left:-250px">
		<input class="clickOne" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Existing PersonDetection Detection Results
    		</h2>
		</div>
		<div class='modal-body'>
			
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="left">
	<?php if($videoname==""){ ?>
		<div class="line" style="padding:10px;border-bottom:1px silver solid;margin-bottom:10px">
			<div class="btn btn-warning btn-small runList">Browse Results from Uploaded Videos</div><br/>
			<span class="muted">Click this to see crowd counting results of previously uploaded videos</span>
		</div>
		<div class="uploadVideo" style="width:400px;">
			<?php $this->widget("UploadWidget",array(
				"success" => "videoUploadOk", //what to do after successful upload
				"error" => "videoUploadError",
				"maxSize" => "1024*1024*300",
				"types" => "mp4",
				"buttonName" => "upload New Video",
				"filename" => "newVideoUploaded",
				"id" => "forNewVideoUpload",
				"beforeSubmit" => "beforeUpload",
				"htmlAfterButton" => '<span class="text-error">Max file size: 300MB; mp4 only. A 1-minute video may take 10 minutes to process</span>',
			));?>
			<input class="newvideoUrl" type="hidden"></input>
			<span class="text-error info"></span>
		</div>
		<div class="preprocessing" style="display:none;border:1px solid silver;border-width:1px 0;margin:10px 0;padding:5px;">
			<input class="importDone" type="hidden" value=0></input>
			<div class="loadVideoToDatabase">
				<div class="title">Loading video into database</div>
				<span class="text-error info"></span>
				<div class="progressForImportVideo">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "importVideoProgress",
						"doneCall" => "#cCrowdCounting > div.left > div.preprocessing > input.importDone",
						"noMessage" => true,
					));
				?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="searchVideo" style="padding:5px 0;">
			<input class="input-medium videoname" type="text"></input>
			<?php if($videoname==""){ ?>
			<div class="btn btn-small btn-info search">Search by Video Name</div>
			<!--<div class="btn btn-small btn-info seeVideo">See Video</div>-->
			<?php } ?>
			<div class="btn btn-small btn-success detect">Run Crowd Counting</div>
			<input class="rerun" type="checkbox"></input>Re-Run
			<span class="text-error info"></span>
			<br/>
			<div class="guessList"></div>
		</div>
		<div class="processing" style="border-top:1px solid silver;margin-top:10px;padding:5px;display:none">
			<input class="personDone" type="hidden" value=1></input>
			<div class="personDetection">
				<div class="title">Crowd Counting</div>		
				<div class="info">
					<div class='wrapLoading'><span class="text-error info"></span></div>
					<div class="progressForPersonDetection">
					<?php 
						$this->widget("ProgressWidget",array(
							"id" => "personProgress",
							"doneCall" => "#cCrowdCounting > div.left > div.processing > input.personDone"
						));
					?>
					</div>
				</div>
				<div class="frameDetection" style="display:none" >
					<div class="title"><span class="muted">Frame Crowd Counting</span></div>
					<div class="loadingFrame" style="display:none" >
						<div class="progress"><div class="bar" style="width:0%"></div>Loading frame detection results...</div>
					</div>
					<div class="frameDetectionImage" style="display:none" >
						<img class="big"></img>
					</div>
					<div class="frameDetectionVideo">
						<video>
						<source></source>
						Your browser does not support the video tag.
						</video>
					</div>
				</div>
				
				<div class="detectionGraph"></div>
				<div class="moreResult">
					<div class="show">
						<div class="btn btn-small btn-info showMore" style="display:none">Show More Result</div>
					</div>
					<div class="things" style="display:none">
						<div class="resultType">
							<!--<div class="type reranking">reranking</div>-->
							<div class="type original toggle">original</div>
						</div>
						<img class="original"></img>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="right">
		<input class="videoTemp" type="hidden"></input>
		<input class="videoname" type="hidden"></input>
		<div class="display"></div>		
		<div class="ctr" style="padding:10px 0px;display:none">
			<div class="line"> 
				Person Count Threshold for PersonDetection: <input class="thres input-small" style="width:50px;" type="text" value=20></input>
				<div class="btn btn-small btn-info setThres">set</div>
			</div>
			<div class="line" style="display:none"> 
				Padding around PersonDetection: <input class="padding input-small" style="width:50px;" type="text" value=1.0></input> seconds
				<div class="btn btn-small btn-info setPadding">set</div>
			</div>
			<div class="line" style="">
				<span class="muted" style="float:left">Timeline:</span>
				<!--
				<i class="icon-repeat close refreshSegments" style="float:right;margin-right:50px;margin-top:5px;"></i>
				-->
				<div id="timeline">

				</div>
			</div>
		</div>
		<div class="personBlocks" style="display:none;padding:10px;background-color:white;border-radius:5px;height:200px;overflow:auto;">
		</div>
		
	</div>
</div>
<div class="footer" style="text-align:center;color:gray;width:100%;padding:5px;">
	If you have any questions, you can contact us by junweil@cs.cmu.edu
</div>