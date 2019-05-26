
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
	#cGunshot{
		position:relative;
		padding:5px;
		padding-bottom:30px;
	}
	#cGunshot input{margin:0}
	#cGunshot div.searchVideo > div.guessList{
		padding:5px;
	}
	#cGunshot div.searchVideo > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cGunshot div.searchVideo > div.guessList > div.block:hover{
		color:gray
	}
	#cGunshot div.display > div.block > video{max-height:600px;}
	#cGunshot div.display > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	#cGunshot div.display > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cGunshot > div.left{
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
	#cGunshot > div.right{
		margin:0 0 0 40%;
		padding-left:10px;
	}
	#cGunshot video{
		width:100%;
	}
	#cGunshot > div.left div.title{
		text-align:center;
	}
	#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > div.progressForImportVideo{
		width:200px;
	}
	#cGunshot > div.right > div.gunshotBlocks > div.block {
		margin-bottom:10px;
		border-radius:5px;
		background-color:rgb(220,220,220);
		padding:10px;
		font-weight:bold;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.detectionGraph
	{
		position:relative;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things{
		position:relative;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.detectionGraph > div.playback,#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.playback{
		position:absolute;
		top:0;
		left:8.5%;
		border-left:2px green solid;
		width:1px;
		height:100%;
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
	$("#cGunshot > div.left > div.searchVideo > input.videoname").val("<?php echo $videoname?>");
	$("#cGunshot > div.left > div.searchVideo > div.detect").trigger(cw.ectype);
	<?php }else{ ?>
	getRunList(true);
	<?php } ?>
});
cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
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
		$("#cGunshot > div.left > div.uploadVideo > span.info").html("");
		$("#cGunshot > div.left > div.preprocessing").hide();
		$("#cGunshot > div.left > div.processing").hide();
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
		$("#cGunshot > div.left > div.uploadVideo > input.newvideoUrl").val(data.url);
		$("#cGunshot > div.left > div.uploadVideo > span.info").html("Upload Success");
		$("#cGunshot > div.left > div.preprocessing").show();
		// trigger the system to load this video into database
		loadVideo(data.url);
	}
	function videoUploadError(str)
	{
		$("#cGunshot > div.left > div.uploadVideo > span.info").html(str);
	}
	// load video into database, may trigger process
	function loadVideo(url)
	{
		
		var data = {};
		data.url = url;
		// put the video name into search input, so that after it is in the database, it can be used for gunshot detection
		var filename = baseName(data.url);
		$("div.searchVideo > input.videoname").val(filename);
		//alert(url);
		//$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("<div class='wrapLoading'><div class='loading'></div></div>");
		$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("posting request...");
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/importVideo",data,function(result){
			if(result.status == 0)
			{
				//display counting results
				/*
				$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html(
					result.count.addToDatabase+" added to database directly, since related path and original path exists;<br/>"+
					result.count.ignore+" are ignored since original not exists;<br/>"+
					result.count.furtherProcess+" are posted to python for futher process<br/>"+
					"python will need 5 minutes to process a 40-minute video"
				);*/
				if(result.count.furtherProcess != 0)
				{
					$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Loading video...");
				}
				else
				{
					$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded. Please click Run Gunshot Detection");
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
	//video import success, tell them to click run gunshot
	cw.ech("#cGunshot > div.left > div.preprocessing > input.importDone",function(){
		$("#cGunshot > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded. Please click Run Gunshot Detection");
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
	// gunshot detection!!!
	cw.ec("#cGunshot > div.left > div.searchVideo > div.detect",function(){
		// show video first		
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		if(data.videoname == "")
		{
			return;
		}
		$(this).addClass("disabled");
		$("#cGunshot > div.right > div.ctr").hide();
		$("#cGunshot > div.right > div.gunshotBlocks").hide();
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchVideo",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			/*
			$(this).parent().parent().children("div.display").find("video").each(function(){
				this.pause();
				delete this;
				$(this).remove();
			});*/
			$(this).parent().parent().children("div.display").html('');
			if(result.videoList.length == 0)
			{
				$(this).parent().children("span.info").html('<div class="wrapLoading">Video Not Found</div>');
			}
			else
			{
				var video = result.videoList[0];
				$("#cGunshot > div.right > input.videoname").val(video.videoname);
				$("#cGunshot > div.right > input.videoId").val(video.id);
				//alert(isLeft);
				var $display = $("#cGunshot > div.right > div.display");
				$display.html(makeVideoHtml(video));
				//remember video source
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource($display.find("video").get(0)),
					"object":$display.find("video").get(0)
				};
				videoAnalyser = audioCtx.createAnalyser();
				videoSource[video.videoname]['source'].connect(videoAnalyser);
				videoAnalyser.connect(audioCtx.destination);
				bindAudioV("#audioVForDes",videoAnalyser,videoSource[video.videoname]['object'],"rgba(0,0,0,0.7)");
				// start the gunshot detection now.
				$("#cGunshot > div.left > div.processing").show();
				//clean the label
				$("#cGunshot > div.right > div.gunshotLabels").html("");
				postDetectionJob(video.videoname);
				//bind video for segment playing
				bindVideoStop(videoSource[video.videoname]['object']);
			}
		},$(this));
	});
	cw.ec("#cGunshot > div.left > div.searchVideo > div.seeVideo",function(){
		// show video first		
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.videoname = $(this).parent().children("input.videoname").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		$("#cGunshot > div.right > div.ctr").hide();
		$("#cGunshot > div.right > div.gunshotBlocks").hide();
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
				$("#cGunshot > div.right > input.videoname").val(video.videoname);
				$("#cGunshot > div.right > input.videoId").val(video.id);
				//alert(isLeft);
				var $display = $("#cGunshot > div.right > div.display");
				$display.html(makeVideoHtml(video));
				//remember video source
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource($display.find("video").get(0)),
					"object":$display.find("video").get(0)
				};
				videoAnalyser = audioCtx.createAnalyser();
				videoSource[video.videoname]['source'].connect(videoAnalyser);
				videoAnalyser.connect(audioCtx.destination);
				bindAudioV("#audioVForDes",videoAnalyser,videoSource[video.videoname]['object'],"rgba(0,0,0,0.7)");
				
			}
		},$(this));
	});
	var gunshotResult = new Array();
	function postDetectionJob(videoname)
	{
		gunshotResult = new Array();
		// clean the gunshot detection result section.
		$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.detectionGraph").html("").parent().find("div.info > div.wrapLoading > span.info").html("");
		$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult").hide()
			.find("div.things").hide().end()
			.find("div.things > img.original").prop("src","").end()
			.find("div.things > div.resultType > div.type").removeClass("toggle").end()
			.find("div.things > div.resultType > div.reranking").addClass("toggle");
		// send the videoname to ask for result. If already have it, show result. if not, wait for python
		var data = {};
		data.videoname = videoname;
		var modelname = "";
		// check whether has preset modelId first
		if($("#cGunshot > div.left > div.searchVideo > input.presetModelId").val() != "")
		{
			data.modelId = $("#cGunshot > div.left > div.searchVideo > input.presetModelId").val();
			modelname = $("#cGunshot > div.left > div.searchVideo > input.presetModelName").val();
			$("#cGunshot > div.left > div.searchVideo > input.presetModelId").val("");
			$("#cGunshot > div.left > div.searchVideo > input.presetModelName").val("");
		}
		else
		{
			data.modelId = $("#modelListModal > div.modal-body > div.modellist > div.block.toggle > input.modelId").val();
			modelname = $("#modelListModal > div.modal-body > div.modellist > div.block.toggle > input.modelName").val();
		}
		$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.title > span.videoname").html(" for "+videoname+" with model "+modelname);
		$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.info > div.wrapLoading > span.info").html('<div class="loading"></div>');
		$("#cGunshot > div.left > div.processing > input.gunshotDone").val(videoname);// remember it
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getGunshot",data,function(result){
			if(result.status == 0)
			{
				$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.info > div.wrapLoading > span.info").html('');
				if(result.haveResult == 1)
				{
					//show the result
					// set the detection graph via runId
					$("#cGunshot > div.right > div.ctr").show();
						$("#cGunshot > div.right > div.ctr > div.line > input.thres").val(0.5);
						$("#cGunshot > div.right > div.ctr > div.line > input.padding").val(1.0);
					$("#cGunshot > div.right > div.gunshotBlocks").show();
					$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.detectionGraph").append('<img src="<?php echo Yii::app()->baseUrl?>/assets/gunshotGraph/'+result.runId+'_reranking.png"></img>').append('<div class="playback"></div>');

					//show more result things
					$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult").show();
					var resultType = $("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type.toggle").html();
					$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > img.original").prop('src','<?php echo Yii::app()->baseUrl?>/assets/gunshotGraph/'+result.runId+'_original.png').parent().append('<div class="playback"></div>');
					// save the result locally, so that 
					gunshotResult = result.scoreList;

					segments = getSegments(gunshotResult[resultType],0.5);
					setSegments(segments);
					// bind the video loaded to get duration , so that we can reload the segment timeline
					$("#cGunshot > div.right > div.display > div.block > video").get(0).addEventListener("loadedmetadata",function(){
						//alert("done");
						$("#cGunshot > div.right > div.ctr > div.line > div.setThres").trigger(cw.ectype);
					});
					
					//alert(segments.length);
					//get the label result for this video for this user
					var videoId = $("#cGunshot > div.right > input.videoId").val();
					//getLabels(videoId);
				}
				else
				{
					$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.info > div.wrapLoading > span.info").html('Processing...');
					//set processId and wait for python
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#gunshotProgress > input.processId").val(result.processId);
						$("#gunshotProgress > input.showing").val(1).change();
						$("#gunshotProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
			}
		});
	}
	function getLabels(videoId)
	{
		var data = {};data.videoId = videoId;
		$("#cGunshot > div.right > div.gunshotLabels").html("<div class='wrapLoading'><div class='loading'></div></div>");
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getLabels?classname=gunshot&videoId="+data.videoId,data,function(result){
			$("#cGunshot > div.right > div.gunshotLabels").html("");
			if(result.status == 0)
			{
				for(var i=0;i<result.labels.length;++i)
				{
					var correct = result.labels[i].pos == 1? true:false;
					$("#cGunshot > div.right > div.gunshotLabels").append(makeLabel(result.labels[i].startSec,result.labels[i].endSec,correct,result.labels[i].id));
				}
				setCurSegmentsLabel();
			}
		});
	}
	function setCurSegmentsLabel()
	{
		// go through all segments and go through all label, reset the labeling contrl
		$("#cGunshot > div.right > div.gunshotBlocks > div.block").each(function(){
			var hasLabel = false;
			var correct = false;
			var thisStartSec = parseFloat($(this).children("input.startSec").val());
			var thisEndSec = parseFloat($(this).children("input.endSec").val());
			$("#cGunshot > div.right > div.gunshotLabels > div.block").each(function(){
				var startSec = parseFloat($(this).children("input.startSec").val());
				var endSec = parseFloat($(this).children("input.endSec").val());
				if((thisStartSec == startSec) && (thisEndSec == endSec))
				{
					hasLabel = true;
					correct = $(this).children("input.correct").val()==1?true:false;
					return false;
				}
			});
			if(hasLabel)
			{
				$(this).children("span.muted").remove();
				$(this).children("div.labeling").remove();
				//$(this).append("<span class='muted'>"+(correct?"correct":"wrong")+"</span>");
				$(" <span class='muted'>"+(correct?"correct":"wrong")+"</span>").insertAfter($(this).children("div.playSegment"));
			}
			else
			{
				$(this).children("span.muted").remove();
				$(this).children("div.labeling").remove();
				//$(this).append('<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>');
				$(' <div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>').insertAfter($(this).children("div.playSegment"));
			}
		});
	}
	// set new threshold
	cw.ec("#cGunshot > div.right > div.ctr > div.line > div.setThres",function(){
		var thres = parseFloat($(this).parent().children("input.thres").val());
		//alert(thres);
		var resultType = $("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type.toggle").html();
		segments = getSegments(gunshotResult[resultType],thres);
		setSegments(segments);
	});
	function sec2time(secs)
	{
		var sec_num = secs;
	    var hours   = Math.floor(sec_num / 3600);
	    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	    var seconds = sec_num - (hours * 3600) - (minutes * 60);

	    if (hours   < 10) {hours   = "0"+hours;}
	    if (minutes < 10) {minutes = "0"+minutes;}
	    if (seconds < 10) {seconds = "0"+seconds;}
	    var time    = hours+':'+minutes+':'+seconds;
	    return time;
	}
	//click the gunshot counting image
	cw.ec("#countModal img",function(){
		var src = $(this).prop("src");
		window.open(src,"_blank");
	});
	//click counting gunshot
	cw.ec("#cGunshot > div.right > div.gunshotBlocks > div.block > div.countGunshot",function(){
		var startSec = parseFloat($(this).parent().children("input.startSec").val());
		var endSec = parseFloat($(this).parent().children("input.endSec").val());
		var videoname = $("#cGunshot > div.right > input.videoname").val();
		var videoId = $("#cGunshot > div.right > input.videoId").val(); 
		$("#countModal > input.videoId").val(videoId);
		$("#countModal > input.videoname").val(videoname);
		$("#countModal > input.startSec").val(startSec);
		$("#countModal > input.endSec").val(endSec);
		//alert(videoname);
		$("#countModal").modal("show");
		//set the title
		$("#countModal > div.modal-body > div.title").html(videoname+" - "+sec2time(startSec)+" - "+sec2time(endSec));
		// go get result, if no result, will run
		$("#countModal > div.modal-body > div.resultPic").html("<div class='wrapLoading'><div class='loading'></div></div>");
		getGunshotCountResult(videoId,startSec,endSec,videoname);
	});
	cw.ech("#countModal > input.done",function(){
		var startSec = parseFloat($(this).parent().children("input.startSec").val());
		var endSec = parseFloat($(this).parent().children("input.endSec").val());
		var videoId = $(this).parent().children("input.videoId").val();
		var videoname = $(this).parent().children("input.videoname").val();
		getGunshotCountResult(videoId,startSec,endSec,videoname);
	});
	function getGunshotCountResult(videoId,startSec,endSec,videoname)
	{
		var data = {};
		data.videoId = videoId;
		data.startSec = startSec;
		data.endSec = endSec;
		data.videoname = videoname;
		cw.post(cw.url+"countGunshot",data,function(result){
			if(result.status == 0)
			{
				if(result.hasResult == 1)
				{
					$("#countModal > div.modal-body > div.resultPic").html('<img class="result" src="'+result.resultPic+'" style="width:100%"></img>');
				}
				else
				{
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#countGunshotProgress > input.processId").val(result.processId);
						$("#countGunshotProgress > input.showing").val(1).change();
						$("#countGunshotProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
			}
		});
	}
	// ------------------- gunshot classification
	//click classification gunshot
	cw.ec("#cGunshot > div.right > div.gunshotBlocks > div.block > div.gunshotClassification",function(){
		var startSec = parseFloat($(this).parent().children("input.startSec").val());
		var endSec = parseFloat($(this).parent().children("input.endSec").val());
		var videoname = $("#cGunshot > div.right > input.videoname").val();
		var videoId = $("#cGunshot > div.right > input.videoId").val(); 

		$("#gunshotClassModal > input.videoId").val(videoId);
		$("#gunshotClassModal > input.videoname").val(videoname);
		$("#gunshotClassModal > input.startSec").val(startSec);
		$("#gunshotClassModal > input.endSec").val(endSec);
		//alert(videoname);
		$("#gunshotClassModal").modal("show");
		//set the title
		$("#gunshotClassModal > div.modal-body > div.title").html(videoname+" - "+sec2time(startSec)+" - "+sec2time(endSec));
		// go get result, if no result, will run
		$("#gunshotClassModal > div.modal-body > div.result").html("<div class='wrapLoading'><div class='loading'></div></div>");
		getGunshotClassificationResult(videoId,startSec,endSec,videoname);
	});
	cw.ech("#gunshotClassModal > input.done",function(){
		var startSec = parseFloat($(this).parent().children("input.startSec").val());
		var endSec = parseFloat($(this).parent().children("input.endSec").val());
		var videoId = $(this).parent().children("input.videoId").val();
		var videoname = $(this).parent().children("input.videoname").val();
		getGunshotClassificationResult(videoId,startSec,endSec,videoname);
	});
	function getGunshotClassificationResult(videoId,startSec,endSec,videoname)
	{
		var data = {};
		data.videoId = videoId;
		data.startSec = parseInt(startSec);
		data.endSec = parseInt(endSec);
		data.videoname = videoname;
		cw.post(cw.url+"gunshotClassification",data,function(result){
			if(result.status == 0)
			{
				if(result.hasResult == 1)
				{
					var topk = 4; // show topk results
					topk = result.result.length < topk?result.result.length:topk;
					//$("#gunshotClassModal > div.modal-body > div.result").html('<img class="result" src="'+result.resultPic+'" style="width:100%"></img>');

					$("#gunshotClassModal > div.modal-body > div.result").html("");
					// parse the json output
					//console.log(result.result);
					for(var i=0;i<topk;++i)
					{
						var classname = result.result[i][0];
						var score = result.result[i][1];
						score = score.toFixed(3);
						var temp = $('<div class="block">'+
							'<div class="score"> '+(i+1)+'.'+classname+" : "+score+'</div>'+
							'<img src="<?php echo Yii::app()->baseUrl; ?>/assets/gunshotClasses/'+classname+'.jpg"></img>'+
						'</div>');
						$("#gunshotClassModal > div.modal-body > div.result").append(temp);
					}
					// also update result in the segment list
					$("#cGunshot > div.right > div.ctr > div.line > div.setThres").trigger(cw.ectype);
				}
				else
				{
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#gunshotClassificationProgress > input.processId").val(result.processId);
						$("#gunshotClassificationProgress > input.showing").val(1).change();
						$("#gunshotClassificationProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
			}
		});
	}



	// given segments, make a lot of block in result display
	function setSegments(segments)
	{
		$("#cGunshot > div.right > div.gunshotBlocks").html("");
		$("#cGunshot > div.right > div.ctr > div.line > img.gunshotClass").prop("src","")
		var threshold = $("#cGunshot > div.right > div.ctr > div.line > input.thres").val();
		// set the timeline stuff
		$("#timeline").html("");
		// get the video duration
		var duration = $("#cGunshot > div.right > div.display > div.block > video").get(0).duration;
		// get the max score of all the segments
		var maxScore = -1;
		for(var i=0;i<segments.length;++i)
		{
			if(segments[i].score > maxScore)
			{
				maxScore = segments[i].score;
			}
		}
		//alert(duration);
		for(var i=0;i<segments.length;++i)
		{
			$("#cGunshot > div.right > div.gunshotBlocks").append(
				'<div class="block">'+
					'<input class="startSec" type="hidden" value="'+segments[i].startSec+'"></input>'+
					'<input class="endSec" type="hidden" value="'+segments[i].endSec+'"></input>'+
					'<input class="classname" type="hidden" value=""></input>'+
					sec2time(segments[i].startSec)+" to "+sec2time(segments[i].endSec)+
					' has one or more gunshots above threshold '+threshold+'  <br/> '+
					' <div class="btn btn-small btn-success playSegment" title="Play this gunshot segment">Play Gunshot Clip</div> '+
					'<div class="btn btn-small btn-primary countGunshot" title="Count how many shots in this gunshot segment">Count Gunshot</div> <br/>'+
					'<div class="btn btn-small btn-info gunshotClassification" title="Classify the gun type">Gunshot Type Classification</div> '+
					/*
					(
						(hasLabel(segments[i].startSec,segments[i].endSec))?"":
					'<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> '+
					'<div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div> '
					)+
					*/
				'</div>'
			);
			if(!isNaN(duration))
			{
				var temp = $('<div class="block" title="'+sec2time(segments[i].startSec)+" to "+sec2time(segments[i].endSec)+', max '+segments[i].score+'">'+
					'<input class="startSec" type="hidden" value="'+segments[i].startSec+'"></input>'+
					'<input class="endSec" type="hidden" value="'+segments[i].endSec+'"></input>'+
					'<input class="classname" type="hidden" value=""></input>'+
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
				var p = (segments[i].score - parseFloat(threshold))/(maxScore-parseFloat(threshold));// color relative to threshold
				//alert(p);
				var color = parseInt((1-p)*200);// color for green
				//alert(color);
				temp.css({"backgroundColor":"rgb(255,"+color+",0)"});
				$("#timeline").append(temp);
			}
		}
		// add the playback mark for timeline
		$("#timeline").prepend('<div class="playback"></div>');
		// for each seg, go get the gunshot classification results
		var data = {};
		data.videoname = $("#cGunshot > div.right > input.videoname").val();
		data.videoId = $("#cGunshot > div.right > input.videoId").val(); 

		data.segments = segments;
		cw.post(cw.url+"getGunshotClassificationResults",data,function(result){
			if((result.status == 0) && (result.results.length > 0))
			{
				var duration = $("#cGunshot > div.right > div.display > div.block > video").get(0).duration;
				var thres = 0.04; // if the segment length is longer than this percentage in the timeline, then we will show the gun image
				// check each segment result
				var countSeg = 0; // used to also add the gun image to the gunshot block below
				$("#timeline > div.block").each(function(){
					var thisStart = parseFloat($(this).find("input.startSec").val());
					var thisEnd = parseFloat($(this).find("input.endSec").val());
					var width = (thisEnd - thisStart)/duration;
					//console.log(width);
					if(!isNaN(duration))
					{
						for(var i=0;i < result.results.length;++i)
						{
							var this_result = result.results[i];
							var res_start = parseFloat(this_result.start);
							var res_end = parseFloat(this_result.end);
							//console.log(res_start);
							//console.log(thisStart);
							//console.log((res_start == thisStart));
							if((res_start == thisStart) && (res_end == thisEnd))
							{
								var top_classname = this_result.scorelist[0][0];
								//console.log(top_classname);
								// only add gunimg if long enough
								if(width > thres)
								{
									$(this).find("img.gunimg").remove();
									$(this).append('<img class="gunimg" src="<?php echo Yii::app()->baseUrl; ?>/assets/gunshotClasses/'+top_classname+'.jpg" style="max-width:80%;max-height:100%"></img>');
								}
								$(this).children("input.classname").val(top_classname);
								// also add to the gunshot block below
								$("#cGunshot > div.right > div.gunshotBlocks > div.block").eq(countSeg).find("img.gunimg").remove();
								$("#cGunshot > div.right > div.gunshotBlocks > div.block").eq(countSeg).append(' <img class="gunimg" src="<?php echo Yii::app()->baseUrl; ?>/assets/gunshotClasses/'+top_classname+'.jpg" style="width:100px"></img>');
								$("#cGunshot > div.right > div.gunshotBlocks > div.block").eq(countSeg).children("input.classname").val(top_classname);
								break;
							}
						}
					}
					countSeg+=1;
				});
			}
		});


		//setCurSegmentsLabel();
	}
	//labeling the existing segments
	cw.ec("#cGunshot > div.right > div.gunshotBlocks > div.block > div.labeling",function(){
		var thisStartSec = parseFloat($(this).parent().children("input.startSec").val());
		var thisEndSec = parseFloat($(this).parent().children("input.endSec").val());
		var videoId = $("#cGunshot > div.right > input.videoId").val();
		var correct = false;
		if($(this).hasClass("correct"))
		{
			correct = true;
		}
		if(!hasLabel(thisStartSec,thisEndSec))
		{
			// add to the labels on the page
			var thisLabel = makeLabel(thisStartSec,thisEndSec,correct);
			$("#cGunshot > div.right > div.gunshotLabels").append(thisLabel);
			// then send to the server to save
			var data = {}; data.startSec = thisStartSec;data.endSec = thisEndSec;data.pos = correct?1:0;
			cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/addLabel?classname=gunshot&videoId="+videoId,data,function(result){
				if(result.status == 0)
				{
					thisLabel.children("input.labelId").val(result.labelId);
				}
			},thisLabel);
		}
		// remove button and added a label tag to it
		//$(this).parent().append("<span class='muted'>"+(correct?"correct":"wrong")+"</span>")
		$(" <span class='muted'>"+(correct?"correct":"wrong")+"</span>").insertAfter($(this).parent().children("div.playSegment"));

		$(this).parent().children("div.labeling").remove();
	});
	// delete a label, 
	cw.ec("#cGunshot > div.right > div.gunshotLabels > div.block > div.delete",function(){
		var startSec = parseFloat($(this).parent().children("input.startSec").val());
		var endSec = parseFloat($(this).parent().children("input.endSec").val());
		var labelId = $(this).parent().children("input.labelId").val();
		var videoId = $("#cGunshot > div.right > input.videoId").val();
		//if(labelId)
		//find the current segment and reset its controll
		$("#cGunshot > div.right > div.gunshotBlocks > div.block").each(function(){
			var thisStartSec = parseFloat($(this).children("input.startSec").val());
			var thisEndSec = parseFloat($(this).children("input.endSec").val());
			if((thisStartSec == startSec) && (thisEndSec == endSec))
			{
				$(this).children("span.muted").remove();
				//$(this).append('<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>');
				$(' <div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>').insertAfter($(this).children("div.playSegment"));
				return false;
			}
		});
		var data = {};
		data.labelId = labelId;
		// send to the server to delete
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/deleteLabel?classname=gunshot&videoId="+videoId,data,function(result){

		});
		$(this).parent().remove();
	});
	function makeLabel(startSec,endSec,correct)
	{
		var labelId = arguments[3]?arguments[3]:"";
		return $('<div class="block">'+
			'<input class="startSec" type="hidden" value="'+startSec+'"></input>'+
			'<input class="endSec" type="hidden" value="'+endSec+'"></input>'+
			'<input class="labelId" type="hidden" value="'+labelId+'"></input>'+
			'<input class="correct" type="hidden" value="'+(correct?1:0)+'"></input>'+
			sec2time(startSec)+' to '+sec2time(endSec)+(correct?" is correct":" is wrong")+
			'<div class="delete close">&times;</div>'+
		'</div>');
	}
	function hasLabel(startSec,endSec)
	{
		//check segment with startSec and endSec, whether already in Your labels
		var hasLabel = false;
		$("#cGunshot > div.right > div.gunshotLabels > div.block").each(function(){
			var thisStart = parseFloat($(this).children("input.startSec").val());
			var thisEnd = parseFloat($(this).children("input.endSec").val());
			if((thisStart == startSec) && (thisEnd == endSec))
			{
				hasLabel = true;
				return false;
			}
		});
		return hasLabel;
	}
	var segmentPlaying = false;
	var ending = null;
	//click play!!
	cw.ec("#cGunshot > div.right > div.gunshotBlocks > div.block > div.playSegment, #timeline > div.block",function(){
		if($(this).hasClass("block"))
		{
			//timeline block
			var startSec = parseFloat($(this).children("input.startSec").val());
			var endSec = parseFloat($(this).children("input.endSec").val());
			var classname = $(this).children("input.classname").val();
		}
		else
		{
			var startSec = parseFloat($(this).parent().children("input.startSec").val());
			var endSec = parseFloat($(this).parent().children("input.endSec").val());
			var classname = $(this).parent().children("input.classname").val();
		}
		var padding = parseFloat($("#cGunshot > div.right > div.ctr > div.line > input.padding").val());
		startSec-=padding;
		endSec+=padding;

		var videoObject = videoSource[$("#cGunshot > div.right > input.videoname").val()]['object'];
		segmentPlaying = true;
		ending = endSec;
		videoObject.currentTime = startSec;
		videoObject.play();

		// show the gunshot class if there is result
		
		if(classname != "")
		{
			$("#cGunshot > div.right > div.ctr > div.line > img.gunshotClass").prop("src","<?php echo Yii::app()->baseUrl; ?>/assets/gunshotClasses/"+classname+".jpg");
		}
	});
	//bind a video to watch for segment playing
	function bindVideoStop(videoObject)
	{
		$(videoObject).on("timeupdate",function(){
			// added 05/08/2018
			// also update the playback mark for the prediction graph and the time line;
			var duration = $("#cGunshot > div.right > div.display > div.block > video").get(0).duration;
			if(!isNaN(duration))
			{
				var percentage = this.currentTime/duration;
				percentage*=100;
				$("#timeline > div.playback").css({"left":percentage+"%"});
				// update the detection graph playgraph as well
				var left_space = 0.085; // how many percent on the left legend
				// convert width percentage 
				var percentage = this.currentTime/duration;
				percentage = (1.0 - left_space)*percentage;
				percentage+=left_space;
				percentage*=100;
				$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.detectionGraph > div.playback").css({"left":percentage+"%"});
				$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.playback").css({"left":percentage+"%"});
			}
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
		curSegment = {};
		for(var i=0;i<scoreList.length;++i)
		{
			var score = scoreList[i];
			
			if(parseFloat(score.score) >= thres)
			{
				if(curSegment.startSec == null)
				{
					curSegment.startSec =parseFloat( score.startSec);
				}
				// save the max score in the merged segments
				if((curSegment.score == null) || (parseFloat(score.score) > curSegment.score))
				{
					curSegment.score = parseFloat(score.score);
				}
				curSegment.endSec = parseFloat(score.endSec);
			}
			else
			{
				// save this segment
				if((curSegment.startSec!=null)&& (curSegment.endSec != null) && (curSegment.endSec < parseFloat(score.startSec)))
				{
					segments.push(curSegment);
					curSegment = {};
				}
			}
		}
		if((curSegment.startSec!=null)&& (curSegment.endSec != null))
		{
			segments.push(curSegment);
		}
		return segments;
	}
	// gunshot backend processing is done, get result
	cw.ech("#cGunshot > div.left > div.processing > input.gunshotDone",function(){
		var videoname = $(this).val();
		// will use the current modelId to get result again
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
				'<canvas id="audioVForDes" style="height:70px;position:absolute;z-index:2;top:2px;right:0;width:200px;"></canvas>'+
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
cw.ec("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.show > div.showMore",function(){
	$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things").slideToggle();
});
// toggle different result
cw.ec("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type",function(){
	$("#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type").removeClass("toggle");
	$(this).addClass("toggle");
	// trigger changing result
	$("#cGunshot > div.right > div.ctr > div.line > div.setThres").trigger(cw.ectype);
});
// see existing result.
cw.ec("#cGunshot > div.left > div.line > div.runList",function(){
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
	$("#cGunshot > div.right > input.videoTemp").val($("#cGunshot > div.right > div.display > div.block > video > source").prop("src")); 
	$("#cGunshot > div.right > div.display > div.block > video").prop("src","");
	$("#cGunshot > div.right > div.display > div.block > video > source").prop("src","");
	//$("#cGunshot > div.right > div.display > div.block > video").get(0).load();
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getRunList",data,function(result){
		if(result.status ==0)
		{
			var clickOne = $("#runListModal > input.clickOne").val()=="true"?true:false;
			$("#runListModal > div.modal-body").html('');
			for(var i=0;i< result.runList.length;++i)
			{
				$("#runListModal > div.modal-body").append(
					'<div class="block">'+
						'<input class="runId" type="hidden" value="'+result.runList[i].runId+'"></input>'+
						'<input class="modelId" type="hidden" value="'+result.runList[i].modelId+'"></input>'+
						'<input class="modelName" type="hidden" value="'+result.runList[i].modelName+'"></input>'+
						'<input class="videoname" type="hidden" value="'+result.runList[i].videoname+'"></input>'+
						result.runList[i].videoname+
						(
							(result.runList[i].modelName == "")?"":
							" ("+result.runList[i].modelName+") "
						)+
						' <div class="close">&times</div>'+
					'</div>'
				);
			}
			if((result.runList.length>0) && (clickOne))
			{
				// last run!
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
		if($("#cGunshot > div.right > input.videoTemp").val()!= "")
		{
			var oldvideo = $("#cGunshot > div.right > input.videoTemp").val();
			//alert(oldvideo);
			$("#cGunshot > div.right > div.display > div.block > video > source").prop("src",oldvideo);
			$("#cGunshot > div.right > div.display > div.block > video").prop("src",oldvideo);
			$("#cGunshot > div.right > div.display > div.block > video").get(0).load();
			$("#cGunshot > div.right > input.videoTemp").val("");
		}

	}
	clickOneRun = false;
});
// click a video
cw.ec("#runListModal > div.modal-body > div.block",function(){
	var videoname = $(this).children("input.videoname").val();
	var modelId = $(this).children("input.modelId").val();
	var modelName = $(this).children("input.modelName").val();
	$("#cGunshot > div.left > div.searchVideo > input.presetModelId").val(modelId);
	$("#cGunshot > div.left > div.searchVideo > input.presetModelName").val(modelName);
	// remember it have clickOne
	clickOneRun = true;
	$("#runListModal").modal("hide");
	$("#cGunshot > div.left > div.searchVideo > input.videoname").val(videoname);
	$("#cGunshot > div.left > div.searchVideo > div.detect").trigger(cw.ectype);
	
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
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/deleteGunshotRun",data,function(result){
		if(result.status ==0)
		{
			getRunList(true);
		}
	});
});
// click detectors
cw.ec("#cGunshot > div.left > div.searchVideo > div.modellist",function(){
	$("#modelListModal").modal("show");
});
//load gunshot detectors at the begining
$(document).ready(function(){
	//loadModelList();
	// now we load at page load.
});
function loadModelList()
{
	var data ={};
	$("#modelListModal > div.modal-body > div.adminModelList").html('<div class="wrapLoading"><div class="loading"></div></div>');
	$("#modelListModal > div.modal-body > div.myModelList").html("");
	cw.post(cw.url+"getModels",data,function(result){
		$("#modelListModal > div.modal-body > div.adminModelList").html('');
		if(result.status == 0)
		{
			for(var i = 0;i<result.adminModelList.length;++i)
			{
				// change the model name
				result.adminModelList[i].modelname = "System Default Detector";
				$("#modelListModal > div.modal-body > div.adminModelList").append(makeModel(result.adminModelList[i]));
			}
			for(var i = 0;i<result.myModelList.length;++i)
			{
				$("#modelListModal > div.modal-body > div.myModelList").append(makeModel(result.myModelList[i]));
			}
		}
	});
}
function makeModel(model)
{
	var temp = $('<div class="block" title="'+model.modelpath+'">'+
		'<input class="modelId" value="'+model.modelId+'" type="hidden"></input>'+
		'<input class="modelName" value="'+model.modelname+'" type="hidden"></input>'+
		model.modelname +
	'</div>');
	if(model.isDefault == 1)
	{
		temp.addClass("toggle");
	}
	return temp;
}
//click different model
cw.ec("#modelListModal > div.modal-body > div.modellist > div.block",function(){
	$("#modelListModal > div.modal-body > div.modellist > div.block").removeClass("toggle");
	$(this).addClass("toggle");
});
// train detectors
cw.ec("#cGunshot > div.left > div.searchVideo > div.train",function(){
	$("#trainModal").modal("show");
	getLabelsForTraining();
});
function getLabelsForTraining()
{
	var data = {};
	$("#trainModal > div.modal-body > div.labellist").html('<div class="wrapLoading"><div class="loading"></div></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/gunshot/getLabels",data,function(result){
		if(result.status == 0)
		{
			$("#trainModal > div.modal-body > div.labellist").html("");
			for(var i =0;i< result.labels.length;++i)
			{
				$("#trainModal > div.modal-body > div.labellist").append(makeLabelForTraining(result.labels[i]));
			}
		}
	});
}
function makeLabelForTraining(label)
	{
		var pos = label.pos == 1?"has gunshot":"no gunshot";
		return $('<div class="block">'+
				'<input class="labelId" value="'+label.labelId+'" type="hidden"></input>'+
				label.videoname+" , "+cw.sec2time(label.startSec)+" to "+cw.sec2time(label.endSec)+" , "+pos+
				(
					(label.hasFeature == 1)?" <span class='muted'>Signature Extracted</span> <input class='selected' type='checkbox' value=1></input> <input class='featureId' value='"+label.featureId+"' type='hidden'></input>":
					' <div class="btn btn-small btn-info extractFeature">Extract Acoustic Signature</div>'
				)+
			'</div>');
	}
	// extract feature
	cw.ec("#trainModal > div.modal-body > div.labellist > div.block > div.extractFeature",function(){
		var data = {};
		data.labelId = $(this).parent().children("input.labelId").val();
		$(this).parent().append('<span class="muted">extracting...</span>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/gunshot/extractFeature",data,function(result){
			if(result.status==0)
			{
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#extractFeatureProgress > input.processId").val(result.processId);
					$("#extractFeatureProgress > input.showing").val(1).change();
					$("#extractFeatureProgress > input.updating").val(1).change();
				}
				else
				{
					alert(result.processError);
				}
			}
		});
		$(this).remove();
	});
	cw.ech("#trainModal > div.modal-body > input.featureDone",function(){
		getLabelsForTraining();
	});
	// select feature
	function getCurFeatureSelectIds()
	{
		var ids = new Array();
		$("#trainModal > div.modal-body > div.labellist > div.block > input.selected:checked").each(function(){
			ids.push($(this).parent().children("input.featureId").val());
		});
		return ids;
	}
	function showCurFeatureSelectCount()
	{
		var count = getCurFeatureSelectIds();
		$("#trainModal > div.modal-body > div.trainIt > span.featureCount").html(count.length);
	}
	//selected one
	$(document).delegate("#trainModal > div.modal-body > div.labellist > div.block > input.selected",cw.ectype,function(){
		showCurFeatureSelectCount();
	});
	//train
	cw.ec("#trainModal > div.modal-body > div.trainIt > div.train",function(){
		var data = {};
		data.featureList = getCurFeatureSelectIds();
		data.modelName = $(this).parent().children("input.modelName").val();
		if(data.featureList.length == 0)
		{
			$("#trainModal > div.modal-body > div.trainIt > span.info").html("No feature is selected");
			return;
		}
		if(data.modelName == "")
		{
			$("#trainModal > div.modal-body > div.trainIt > span.info").html("model name is needed");
			return;
		}
		if(data.modelName.indexOf(" ") >=0)
		{
			$("#trainModal > div.modal-body > div.trainIt > span.info").html("model name cannot have spaces");
			return;
		}
		$("#trainModal > div.modal-body > div.trainIt > span.info").html("<div class='loading'></div>");
		//return;
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/gunshot/trainModel?addDefault=1",data,function(result){
			if(result.status==0)
			{
				$("#trainModal > div.modal-body > div.trainIt > span.info").html("");
				$("#trainModal > div.modal-body > div.trainIt > input.modelName").val("");
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#modelTrainingProgress > input.processId").val(result.processId);
					$("#modelTrainingProgress > input.showing").val(1).change();
					$("#modelTrainingProgress > input.updating").val(1).change();
				}
				else
				{
					alert(result.processError);
				}
			}
			else if(result.status == 2)
			{
				$("#trainModal > div.modal-body > div.trainIt > span.info").html("modelName exists, please change one");
			}
		});
	});
	//train done
	cw.ech("#trainModal > div.modal-body > input.trainDone",function(){
		loadModelList();
	});
	//select all feature
	cw.ec("#trainModal > div.modal-body > div.trainIt > div.selectAll",function(){
		$("#trainModal > div.modal-body > div.labellist > div.block > input.selected").prop("checked",true);
		showCurFeatureSelectCount();
	});
</script>
<style type="text/css">
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult{
		display:none;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType{
		padding:5px;
		height:30px;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type{
		padding:5px;
		float:left;
		font-weight:bold;
		cursor:pointer;
		color:#49afcd;
		background-color:white;
		margin-right:10px;
		border-radius:5px;
	}
	#cGunshot > div.left > div.processing > div.gunshotDetection > div.moreResult > div.things > div.resultType > div.type.toggle{
		color:white;
		background-color:#49afcd;
	}
	#cGunshot #runListModal > div.modal-body > div.block{
		padding:10px;
		cursor:pointer;
		font-weight:bold;
		word-break:break-all;
	}#cGunshot #runListModal > div.modal-body > div.block:hover{
		background-color:rgb(220,220,220);
	}
	#cGunshot > div.right div.title{
		text-align:center;
		color:gray;
		font-weight:bold;
		padding:5px 0;
		border-bottom:1px silver solid;
	}
	#cGunshot > div.right > div.gunshotLabels > div.block{
		padding:5px;
	}
	#cGunshot #modelListModal > div.modal-body > div.modellist{
		padding:5px;
	}
	#cGunshot #modelListModal > div.modal-body > div.adminModelList{
		border-bottom:1px silver solid;
		margin-bottom:5px;
	}
	#cGunshot #modelListModal > div.modal-body > div.modellist > div.block{
		padding:5px;
		cursor:pointer;
		font-weight:bold;
		color:#2f96b4;
	}
	#cGunshot #modelListModal > div.modal-body > div.modellist > div.block.toggle{
		background-color:#2f96b4;
		color:white;
	}
	#trainModal > div.modal-body > div.title{
		padding:10px;
		font-weight:bold;
		text-align:center;
	}
	#trainModal > div.modal-body > div.labellist{
		margin:10px;
		padding:10px;
		background-color:rgb(230,230,230);
		max-height:400px;
		overflow:auto;
	}
	#trainModal > div.modal-body > div.labellist > div.block{
		background-color:white;
		padding:10px;
		border-radius:5px;
		margin-bottom:10px;
		word-break:break-all;
	}
	#trainModal > div.modal-body > div.trainIt{
		padding:10px;
		border-top:1px silver solid;
		margin-top:5px;
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
		text-align:center;
	}
	#timeline > div.block:hover{
		/*background-color:#4CAF50;*/
	}
	#timeline > div.playback{
		position:absolute;
		top:0;
		left:0;
		border-left:3px green solid;
		width:1px;
		height:100%;
		z-index:99;
	}
	#gunshotClassModal > div.modal-body > div.result > div.block {
		height:120px;
		position:relative;
	}
	#gunshotClassModal > div.modal-body > div.result > div.block > img{
		position:absolute;
		top:10px;
		right:0;
		max-height:110px;
	}
</style>
<div id="cGunshot">
	<div class="modal hide fade" id="trainModal" style="width:1000px;margin-left:-500px;position:absolute;top:50px;">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Refine gunshot detector
    		</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<input class="featureDone" type="hidden" value=1></input>
			<input class="trainDone" type="hidden" value=1></input>
			<div class="title"> Your Label List (click to extract acoustic signature for each segment, then select for refining)</div>
			<div class="labellist"></div>
			<div class="featureExtractionProcess">
				<?php 
						$this->widget("ProgressWidget",array(
							"id" => "extractFeatureProgress",
							"doneCall" => "#trainModal > div.modal-body > input.featureDone",
							"noMessage" => false,
						));
				?>
			</div>
			<div class="trainIt">
				Selected labeled video segments to refine model: <span class="featureCount">0</span> <div class="btn btn-small selectAll">selectAll</div><br/>
				Model Name: <input class="modelName input-large" type="text" value="RefinedDetector"></input>
				<div class="train btn btn-primary">Refine Gunshot Detector</div>
				<span class="info text-error"></span>
			</div>
			<div class="modelTrainingProcess">
				<?php 
						$this->widget("ProgressWidget",array(
							"id" => "modelTrainingProgress",
							"doneCall" => "#trainModal > div.modal-body > input.trainDone",
							"noMessage" => false,
						));
				?>
			</div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="modal hide fade" id="modelListModal" style="width:500px;margin-left:-250px">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Select Gunshot Detectors. Then close and click "Run Gunshot Detection".
    		</h2>
		</div>
		<div class='modal-body'>
			<div class="adminModelList modellist">
				<?php foreach($models['adminModelList'] as $model){ 
					// only show the default model
					if($model['isDefault']!=1){
						continue;
					}
					?>
					<div class="block <?php echo $model['isDefault']==1?"toggle":"";?>" title="<?php echo $model['modelpath']?>">
						<input class="modelId" value="<?php echo $model['modelId']?>" type="hidden"></input>
						<input class="modelName" value="<?php echo $model['modelname']?>" type="hidden"></input>
						<?php echo 
							//$model['modelname'];
							"System Default Detector";
						?>
					</div>
				<?php } ?>
			</div>
			<div class="myModelList modellist">
				<?php foreach($models['myModelList'] as $model){ ?>
					<div class="block <?php echo $model['isDefault']==1?"toggle":"";?>" title="<?php echo $model['modelpath']?>">
						<input class="modelId" value="<?php echo $model['modelId']?>" type="hidden"></input>
						<input class="modelName" value="<?php echo $model['modelname']?>" type="hidden"></input>
						<?php echo //$model['modelname'];
							"Refined Detector";
							//break;// only show the latest self-refined model
						?>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="modal hide fade" id="runListModal" style="width:500px;margin-left:-250px">
		<input class="clickOne" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Existing Gunshot Detection Results
    		</h2>
		</div>
		<div class='modal-body'>
			
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="modal hide fade" id="countModal" style="width:800px;margin-left:-400px;position:absolute">
		<input class="done" type="hidden"></input>
		<input class="videoId" type="hidden"></input>
		<input class="videoname" type="hidden"></input>
		<input class="startSec" type="hidden"></input>
		<input class="endSec" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Gunshot Counting
    		</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="title"></div>
			<div class="progressForCounting">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "countGunshotProgress",
						"doneCall" => "#countModal > input.done",
						"noMessage" => false,
					));
				?>
			</div>
			<div class="resultPic"></div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="modal hide fade" id="gunshotClassModal" style="width:800px;margin-left:-400px;position:absolute">
		<input class="done" type="hidden"></input>
		<input class="videoId" type="hidden"></input>
		<input class="videoname" type="hidden"></input>
		<input class="startSec" type="hidden"></input>
		<input class="endSec" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Gunshot Type Classification
    		</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="title"></div>
			<div class="progressForClass">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "gunshotClassificationProgress",
						"doneCall" => "#gunshotClassModal > input.done",
						"noMessage" => false,
					));
				?>
			</div>
			<div class="result"></div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="left">
		<?php if($videoname == ""){ ?>
		<div class="line" style="padding:10px;border-bottom:1px silver solid;margin-bottom:10px">
			<div class="btn btn-warning btn-small runList">Browse Results from Processed Videos</div><br/>
			<span class="muted">Click to see gunshot detection results of previously processed videos</span>
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
				"htmlAfterButton" => '<span class="text-error">Max file size: 300MB; mp4 only. A 10-minute video may take 10 minutes to process</span>',
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
						"doneCall" => "#cGunshot > div.left > div.preprocessing > input.importDone",
						"noMessage" => true,
					));
				?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="searchVideo" style="padding:5px 0;">
			<input class="presetModelId" type="hidden"></input>
			<input class="presetModelName" type="hidden"></input>
			<input class="input-medium videoname" type="text"></input>
			<?php if($videoname==""){ ?>
			<div class="btn btn-small btn-info search">Search by Video Name</div>
			<?php } ?>
			<?php if($videoname==""){ ?>
			<div class="btn btn-small modellist">Select Detector</div>	
			<?php } ?>
			<!--<div class="btn btn-small btn-info seeVideo">See Video</div>-->
			<div class="btn btn-small btn-success detect">Run Gunshot Detection</div>
			<?php if($videoname==""){ ?>
			<div class="btn btn-small train">Refine Detector</div>
			<?php } ?>
			<span class="text-error info"></span>
			<br/>
			<div class="guessList"></div>
		</div>
		<div class="processing" style="border-top:1px solid silver;margin-top:10px;padding:5px;display:none">
			<input class="gunshotDone" type="hidden" value=1></input>
			<div class="gunshotDetection">
				<div class="title" sytle="word-break:break-all">Gunshot detection
					<span class="info videoname"></span>
				</div>		
				<div class="info">
					<div class='wrapLoading'><span class="text-error info"></span></div>
					<div class="progressForGunshot">
					<?php 
						$this->widget("ProgressWidget",array(
							"id" => "gunshotProgress",
							"doneCall" => "#cGunshot > div.left > div.processing > input.gunshotDone"
						));
					?>
					</div>
				</div>
				<div class="detectionGraph"></div>
				<div class="moreResult">
					<div class="show">
						<!--<div class="btn btn-small btn-info showMore" style="display:none">Show original Result</div>-->
						<div class="btn btn-small btn-info showMore" style="">Show original Result</div>
					</div>
					<div class="things" style="display:none">
						<div class="resultType">
							<div class="type reranking toggle">reranking</div>
							<div class="type original">original</div>
						</div>
						<img class="original"></img>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="right">
		<input class="videoname" type="hidden"></input>
		<input class="videoId" type="hidden"></input>
		<input class="videoTemp" type="hidden"></input>
		<div class="display"></div>		
		<div class="ctr" style="padding:10px 0px;display:none">
			<div class="line"> 
				Prediction Score Threshold for Gunshot: <input class="thres input-small" style="width:50px;" type="text" value=0.0></input>
				<div class="btn btn-small btn-info setThres" title="Set the threshold to get gunshot segments">set</div>
				<img class="gunshotClass" style="max-height:50px;"></img>
			</div>
			<div class="line"> 
				Padding around Gunshot: <input class="padding input-small" style="width:50px;" type="text" value=1.0></input> seconds
				<div class="btn btn-small btn-info setPadding" title="Set the padding around gunshot segment">set</div>
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
		<div class="gunshotBlocks" style="display:none;padding:10px;background-color:white;border-radius:5px;height:200px;overflow:auto;">
		</div>
		<div class="title"> Your Gunshot Detection Labels for Refining</div>
		<div class="gunshotLabels"></div>
	</div>
</div>
<div class="footer" style="text-align:center;color:gray;width:100%;padding:5px;">
	If you have any questions, you can contact us by junweil@cs.cmu.edu
</div>