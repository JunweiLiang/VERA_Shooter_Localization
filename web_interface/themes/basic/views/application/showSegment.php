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
#showSegment{
		position:relative;
		padding-left:5%;
	}
	#showSegment > div.videoPairs{
		padding-top:50px;
	}
	#showSegment > div.videoPairs > div.left{
		position:fixed;
		top:10%;
		left:0%;
		padding-left:5px;
		width:50%;
		text-align:center;
	}
	#showSegment > div.videoPairs > div.left > div.srcVideo > video{
		width:100%;
	}
	#showSegment > div.videoPairs > div.right{
		margin:0 0 0 50%;
	}
	#showSegment > div.videoPairs > div.right > div.videoList > div.block{
		width:100%;
	}
	#showSegment > div.videoPairs > div.right > div.videoList > div.block > video{
		width:100%;
	}
	#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
	}
	#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr > input.offset{
		width:40px;
		margin:0;
	}
	#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr > i{
		cursor:pointer;
	}
	#showSegment > div.videoPairs > div.left > div.segmentTools{
		text-align:left
	}
	#showSegment > div.videoPairs > div.left > div.segmentTools > div.title{
		padding:5px 0;
		font-weight:bold;
	}
	#showSegment > div.videoPairs > div.left > div.segmentTools input{margin:0}
	#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment{
		padding:0px 20px;
		line-height:40px;
	}
	#showSegment > div.videoPairs > div.left > div.segmentTools > div.segmentList{
		padding:10px 20px;
		background-color:rgb(220,220,220);
	}
</style>
<script type="text/javascript">
	
//click a video, get the er_pair
var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
//create source now.
var videoSource = null;
$(document).ready(function(){
	var data = {};
	data.segmentId = <?php echo $segmentId?>;
	data.datasetId = <?php echo $datasetId?>;
	data.dvId = <?php echo $videoInfo['dvId']?>;
	$("#siteHeader > input.loading").change();
	videoSource = {};
	cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getResultsERsegment",data,function(result){
		$("#siteHeader > input.stopLoading").change();
		if(result.status == 0)
		{
			// load video info first
			$("#showSegment > div.videoPairs > div.left > div.srcVideo").html(
				'<input class="videoname" value="'+result.videoInfo.videoname+'" type="hidden"></input>'+
				'<input class="dvId" value="'+result.videoInfo.dvId+'" type="hidden"></input>'+
				'<video controls>'+
				'<source src="<?php echo Yii::app()->baseUrl?>/'+result.videoInfo.relatedPath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video><br/>'+result.videoInfo.videoname);
			videoSource[result.videoInfo.videoname] = {
				"source":audioCtx.createMediaElementSource($("#showSegment > div.videoPairs > div.left > div.srcVideo > video").get(0)),
				"object":$("#showSegment > div.videoPairs > div.left > div.srcVideo > video").get(0)
			};
			merger = audioCtx.createChannelMerger(2);
			videoSource[result.videoInfo.videoname]['source'].connect(merger,0,0);//has to connect to something now, or can't play
			bindCallbacks(videoSource[result.videoInfo.videoname]['object']);
			videoSource[result.videoInfo.videoname]['object'].currentTime = <?php echo $start?>;
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
					'<div class="ctr">'+
						'<span class="text-error videoname">'+video.videoname+'</span> '+
						'<span class="text-warning score">('+parseFloat(video.confidence).toFixed(4)+')</span><br/>'+
						//'offset: <span class="text-error offset"></span><br/>'+
						'<i class="co icon-plus"></i> '+
						'offset: <input class="offset input-small" type="text" value="'+video.offset+'"></input> (s) '+
						'<i class="co icon-minus"></i> '+
						(video.autoOffset!=null?"<br/><span class='text-warning autoOffset'>Automatic: "+video.autoOffset+" (s)</span>":"" )+
						'<br/>'+
						'<div class="btn btn-info playSync">play sync</div> '+
						'<div class="btn saveOffset">save</div> '+
						'<span class="text-error errorInfo"></span>'+
					'</div>'+
				'</div>');
				videoSource[video.videoname] = {
					"source":audioCtx.createMediaElementSource(temp.find("video").get(0)),
					"object":temp.find("video").get(0)
				};
				videoSource[video.videoname]['source'].connect(merger,0,1);//has to connect to something now, or can't play
				$("#showSegment > div.videoPairs > div.right > div.videoList").append(temp);
			}
			//getVideoInfo();
		}
	});
});
cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
//save the new offset
cw.ec("#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.saveOffset",function(){
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
cw.ec("#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr > i.co",function(){
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
cw.ec("#showSegment > div.videoPairs > div.right > div.videoList > div.block > div.ctr > div.playSync",function(){
	
	//get the offset first
	var offset = parseFloat($(this).parent().children("input.offset").val());
	var baseVideoSource = videoSource[$("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val()]['source'];
	var baseVideoObject = videoSource[$("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val()]['object']
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
	baseVideoObject.currentTime = <?php echo $start?>;
	thisVideoObject.currentTime = 0.0;

	//alert(offset);
	if(offset > 0)
	{
		//video in the videolist will play first
		//add a #t=offset to the src
		//var ori_src = $("#showSegment > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src");
		//alert(ori_src);
		// strip out the # from before
		//$("#showSegment > div.videoPairs > div.right > div.videoList > div.block.toggle > video > source").eq(0).prop("src",ori_src+"#t="+offset+",");
		thisVideoObject.currentTime+=offset;	
	}
	else
	{
		baseVideoObject.currentTime+=-offset;	
	}
	stopAll();
	baseVideoObject.play();
	thisVideoObject.play();
});
//stop all video
cw.ec("#showSegment > div.videoPairs > div.left > div.ctr > div.stop",function(){
	stopAll();
});

	function getVideoInfo()// for videoList
	{
		var videoname = $("#showSegment > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.videoname").val();
		var offset = $("#showSegment > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.offset").val();
		var score = $("#showSegment > div.videoPairs > div.right > div.videoList > div.block.toggle").children("input.score").val();
		$("#showSegment > div.videoPairs > div.right > div.ctr").children("span.videoname").html(videoname)
			.end().children("span.score").html(score)
			.end().children("span.offset").html(offset);
	}
	//play the video
	cw.ec("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play",function(){
		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var videoObject = videoSource[videoname]['object'];
		videoObject.play();
		$(this).removeClass("play").addClass("pause").html("pause");
		///playingLabel = false;stopAt = -1;
	});
	cw.ec("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.pause",function(){
		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var videoObject = videoSource[videoname]['object'];
		videoObject.pause();
		$(this).removeClass("pause").addClass("play").html("play");
		///playingLabel = false;stopAt = -1;
	});
	//hold the button to get play time
	var labeling = false;
	var labelArr = {};
	cw.edown("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling",function(){
		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var videoObject = videoSource[videoname]['object'];
		labeling = true;
		labelArr.start = videoObject.currentTime;
		labelArr.end = -1;
		$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play").trigger(cw.ectype);
		$(this).addClass("btn-danger").html("labeling...");
	});
	$(document).delegate("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling","mouseleave",function(){
		if(labeling)
		{
			$(this).trigger('mouseup');
		}
	});
	cw.eup("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.labeling",function(){
		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
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
		$(this).removeClass("btn-danger").html("holdToGetSegment");
	});
	//play segment
	var playingLabel = true;
	var stopAt = <?php echo $end?>;
	function bindCallbacks(videoObject)
	{
		videoObject.onpause = function(){
			$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.pause").removeClass("pause").addClass("play").html("play");
		};
		videoObject.onplay = function(){
			$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.play").addClass("pause").removeClass("play").html("pause");
		};
		//playback binding
		videoObject.ontimeupdate = function(){
			//alert(this.currentTime);
			//this.pause();
			if(playingLabel && (stopAt-this.currentTime < 0.4))
			{
				this.pause();
				playingLabel = false;
				stopAt = -1;
			}
		};
	}
	cw.ec("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > div.play",function(){
		var start = parseFloat($(this).parent().children("input.start").val());
		var end = parseFloat($(this).parent().children("input.end").val());
		
		if(isNaN(start) || isNaN(end) || (start<0) || (end<0))
		{
			alert("illegal start or end");
		}
		stopAt = end;
		playingLabel = true;

		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var videoObject = videoSource[videoname]['object'];
		videoObject.currentTime = start;
		videoObject.play();
	});
	function addSegmentTime(start,end)
	{
		$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.newSegment > input.start").val(start).parent().children("input.end").val(end);
	}
	function resetCtrDV()
	{
		$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment").html(
			'<div class="ctr">'+
				'<div class="btn btn-small btn-primary play">play</div> '+
				'<div class="btn btn-small labeling">holdToGetSegment</div> '+
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
			'</div>'
		);
	}
	// start searching!!
	cw.ec("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segment > div.ctr > div.searchSegment",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var videoname = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.videoname").val();
		var videoObject = videoSource[videoname]['object'];
		var maxEnd = videoObject.duration;
		var data = {};
		data.name = $(this).parent().parent().find("div.newSegment > input.segmentName").val();
		data.start = parseFloat($(this).parent().parent().find("div.newSegment > input.start").val());
		data.end = parseFloat($(this).parent().parent().find("div.newSegment > input.end").val());
		data.dvId = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
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
	cw.ec("#showSegment > div.videoPairs > div.left > div.segmentTools > div.title > div.refreshSegmentList",function(){
		var dvId = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
		getSegmentList(dvId);
	});
	function getSegmentList(dvId)
	{
		var data = {};
		data.dvId = dvId;
		$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segmentList").html('<div class="loading"></div>');
		cw.post(cw.url+"getSegmentList",data,function(result){
			$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segmentList").html('');
			if(result.status == 0)
			{
				for(var i =0;i<result.segmentList.length;++i)
				{
					var s = result.segmentList[i];
					$("#showSegment > div.videoPairs > div.left > div.segmentTools > div.segmentList").append('<div class="block">'+
							'<input class="segmentId" type="hidden" value="'+s.segmentId+'"></input>'+
							'<input class="start" type="hidden" value="'+s.start+'"></input>'+
							'<input class="end" type="hidden" value="'+s.end+'"></input>'+
							'<input class="name" type="hidden" value="'+s.labelName+'"></input>'+
							" "+s.labelName+" : <span class='text-warning'>"+s.start +"(s)</span> - <span class='text-warning'>"+s.end+"(s)</span> "+
							'<a class="btn btn-small playThis" target="_blank" href="<?php echo Yii::app()->baseUrl;?>/index.php/application/showSegment?segmentId='+s.segmentId+'">play</a>'+
						'</div>');
				}
			}
		});
	}
	cw.ech("#showSegment > div.videoPairs > div.left > div.segmentTools > input.refreshSegmentList",function(){
		var dvId = $("#showSegment > div.videoPairs > div.left > div.srcVideo > input.dvId").val();
		getSegmentList(dvId);
	});

</script>
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#showSegment > #projectList > input.project",//点击首logo就获取新项目列表
		//"#showSegment > input.toProjectList",//点击首logo后显示项目列表部件
		"#showSegment > input.gotoDatasetList",
	),//点击头导航的发生的事件
	//"targetName" => "#showSegment > #projectList > input.project",
	"targetChange" => array(
	//	"#showSegment > #projectList > input.project",//新建了项目后就获取新项目列表
	//	"#showSegment > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#showSegment > #project > input.projectId",
		"targetProjectName" => "#showSegment > #project > input.projectName",
		"targetProjectIntro" => "#showSegment > #project > input.projectIntro",
		"targetChangeP" => array(
			"#showSegment > #project > input.projectId",//点击了项目后载入项目内容 
			"#showSegment > input.toProject",//点击了项目后显示项目部件 
		),
)); ?>
<div id="showSegment">
	<input class="srcVideoDvId" type="hidden" value="<?php echo $videoInfo['dvId']?>"></input>
	<div class="videoPairs">
		<div class="notice" style="position:absolute;top:20px;left:0;width:100%;text-align:center;color:gray;font-weight:bold;">
			Segment search result for <?php echo $videoInfo['videoname']?> start from <?php echo $start?>(s) to <?php echo $end?>(s). please wait till videos are buffered to play sync.
		</div>
		<div class="left">
			<div class="srcVideo">
			
			</div>
			<div class="ctr">
				<!--<div class="btn btn-success play">play together from the start</div>-->
				<div class="btn btn-info stop">stop all</div>
			</div>
			<?php /*
			<div class="segmentTools">
				<div class="title">Segment Search</div>
				<div class="segment">
					<div class="ctr">
						<div class="btn btn-small btn-primary play">play</div>
						<div class="btn btn-small labeling">holdToGetSegment</div>
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
					</div>
				</div>
				<div class="segProgress">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "SegmentProgress",
						"noMessage" => true,
						"doneCall" => "#showSegment > div.videoPairs > div.left > div.segmentTools > input.refreshSegmentList"
					));
				?>
				</div>
				<div class="title">Segment list <div class='btn btn-small refreshSegmentList'>refresh</div></div>
				<input class="refreshSegmentList" type="hidden"></input>
				<div class="segmentList"></div>
			</div>
			*/ ?>
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












<?php /*
//////////////////stuff for project website
<div id="showSegment">
	<input class="toProjectList" type="hidden"></input>
	<input class="toProject" type="hidden"></input>
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $nickname,
	"userLevel" => $userLevel,
	"headerChange" =>array(
		"#showSegment > #projectList > input.project",//点击首logo就获取新项目列表
		"#showSegment > input.toProjectList",//点击首logo后显示项目列表部件
	),//点击头导航的发生的事件
	"targetName" => "#showSegment > #projectList > input.project",
	"targetChange" => array(
		"#showSegment > #projectList > input.project",//新建了项目后就获取新项目列表
		"#showSegment > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#showSegment > #project > input.projectId",
		"targetProjectName" => "#showSegment > #project > input.projectName",
		"targetProjectIntro" => "#showSegment > #project > input.projectIntro",
		"targetChangeP" => array(
			"#showSegment > #project > input.projectId",//点击了项目后载入项目内容 
			"#showSegment > input.toProject",//点击了项目后显示项目部件 
		),
));?>
<?php 
	$this->widget("ProjectListWidget",array(
		"id" => "projectList",
		"userLevel" => $userLevel,
		"loading" => "#siteHeader > input.loading",
		"stopLoading" => "#siteHeader > input.stopLoading",
		"targetProjectId" => "#showSegment > #project > input.projectId",
		"targetProjectName" => "#showSegment > #project > input.projectName",
		"targetProjectIntro" => "#showSegment > #project > input.projectIntro",
		"targetChange" => array(
			"#showSegment > #project > input.projectId",//点击了项目后载入项目内容 
			"#showSegment > input.toProject",//点击了项目后显示项目部件 
			"#showSegment > #siteHeader > input.showBack",//点击项目后显示siteHeader的back按钮
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
	cw.ech("#showSegment > input.toProjectList",function(){
		$("#project").hide();
		$("#projectList").fadeIn();
	});
	cw.ech("#showSegment > input.toProject",function(){
		$("#project").fadeIn();
		$("#projectList").hide();
	});
</script>
*/ ?>