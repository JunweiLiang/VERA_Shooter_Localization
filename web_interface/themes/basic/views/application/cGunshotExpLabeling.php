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
	

	#cIndex > div.videoLists{
		padding-top:10px;
	}
	#cIndex > div.videoLists > div.block{
		border-top:1px gray solid;
		margin-top:5px;
		padding-top:5px;
		position:relative;
	}
	#cIndex > div.videoLists > div.block > div.srcVideo{
		float:left;
		text-align:center;
		width:50%;
	}
	#cIndex > div.videoLists > div.block > div.srcVideo > div.rank{
		position:absolute;
		bottom:0;
		text-align:center;
	}
	#cIndex > div.videoLists > div.block > div.srcVideo >  video{
		width:100%;
		max-height:400px;
	}
	#cIndex > div.videoLists > div.block > div.labels {
		margin:0 0 0 50%;
		min-height:400px;
	}
	#cIndex > div.videoLists > div.block > div.labels > div.left{
		float:left;
		width:50%;
	}
	#cIndex > div.videoLists > div.block > div.labels > div.right{
		margin: 0 0 0 50%;
	}
	#cIndex > div.videoLists > div.block > div.labels > div > div.title{
		text-align:center;
	}
	#cIndex > div.videoLists > div.block > div.labels > div > div.segments{
		border-radius:5px;
		background-color:white;
		height:400px;
		overflow:auto;
		padding:10px;
		margin:5px;
	}
	#cIndex > div.videoLists > div.block > div.labels > div > div.segments > div.segment{
		margin-bottom:10px;
		border-radius:5px;
		background-color:rgb(220,220,220);
		padding:10px;
		font-weight:bold;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#cIndex > div.videoLists > div.block > div.labels > div > div.segments > div.segment > input.gunshotCount{
		width:40px;
		margin:0;
	}
</style>
<script type="text/javascript">
function loadVideo(videoBlock)
{
	var videoname = videoBlock.find("div.srcVideo > input.videoname").val();
	var videoPath = videoBlock.find("div.srcVideo > input.videoPath").val();
	
	//load src video
	videoBlock.children("div.srcVideo").prepend('<video controls>'+
		'<source src=""></source>'+
		'Your browser does not support the video tag.'+
	'</video>');
	videoBlock.children("div.srcVideo").find("video > source").prop("src",videoPath);
	videoBlock.children("div.srcVideo").find("video").prop("src",videoPath);
	//get the sound wave image
	//var srcAnalyser = audioCtx.createAnalyser();
	//videoSource[videoname1]['source'].connect(srcAnalyser);
	//bindAudioV("#audioVForSrc"+pairId,srcAnalyser,videoSource[videoname1]['object'],"rgba(0,0,0,0.7)");
	// bind the stop 
	bindVideoStop(videoBlock.children("div.srcVideo").find("video").get(0));
}
cw.ec("div.block > div.srcVideo > div.loadVideo",function(){
	$(this).removeClass("loadVideo").html("Remove Video").addClass("removeVideo");
	loadVideo($(this).parent().parent());
});
cw.ec("div.block > div.srcVideo > div.removeVideo",function(){
	$(this).addClass("loadVideo").html("Load Video").removeClass("removeVideo");
	// remove the video
	$(this).parent().find("video").each(function(){
	    this.pause(); // can't hurt
	    delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
	    $(this).remove(); // this is probably what actually does the trick
	});
});
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

  Experiment - <?php echo $GunshotExp->runName; ?>
&nbsp;&nbsp;
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
	<a class="btn btn-small btn-warning download" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/main/downloadGunshotExpLabel?expId=<?php echo $expId?>">download</a>
	<br/>
	Current Page : <?php echo $page?>/<?php echo $totalPage?>
	|
	Current Precition@<?php echo $totalMarked?>: <?php echo $totalMarked==0?0:$totalCorrect/$totalMarked;?> (<?php echo $totalCorrect?> / <?php echo $totalMarked?>)
	&nbsp; | &nbsp;
	<?php if($page > 1){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Previous Page</a>
	<?php } ?>
	&nbsp;&nbsp;
	<?php if($page < $totalPage){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Next Page</a>
	<?php } ?>
</div>
<script type="text/javascript">
	var data = {};
	var dataCount = {};// gunshot count data
	<?php foreach($items as $item){ 
		// prepare the data
	?>
		data[<?php echo $item['listsId']?>] = <?php echo $item['segmentJson']?>;
		dataCount[<?php echo $item['listsId']?>] = <?php echo $item['gunshotCountJson']?>;

	<?php } ?>
	function getGunshotCount(listsId,start,end)
	{
		var count = -1;
		for(var id in dataCount[listsId])
		{
			var one = dataCount[listsId][id];
			if((one.start == start) && (one.end == end))
			{
				count = one.gunshotCount;
			}
		}
		return count;
	}
	// load and combine the recognized segment based on the threshold after document ready
	var threshold = <?php echo $threshold?>;
	$(document).ready(function(){
		for(var listsId in data)
		{
			var segments = getSegments(data[listsId],threshold);
			// load the segment into DOM
			var videoBlock = $("div.block > input.listsId[value='"+listsId+"']").parent();
			videoBlock.find("div.labels > div.left > div.segments").html("");
			for(var i=0;i<segments.length;++i)
			{
				// find the gunshot count data
				var count = getGunshotCount(listsId,segments[i].start,segments[i].end);
				videoBlock.find("div.labels > div.left > div.segments").append(
					'<div class="segment">'+
						'<input class="start" type="hidden" value="'+segments[i].start+'"></input>'+
						'<input class="autoGunshotCount" type="hidden" value="'+count+'"></input>'+
						'<input class="end" type="hidden" value="'+segments[i].end+'"></input>'+
						sec2time(segments[i].start)+" to "+sec2time(segments[i].end)+
						' maxScore '+segments[i].score.toFixed(4)+' <div class="btn btn-small btn-success playSegment">play</div> '+
						'<div class="btn btn-small btn-primary countGunshot">Graph</div> '+
						" Auto gunshot count:"+count+
						" <input class='gunshotCount' type='text' value='-1'></input> "+
						/*
						(
							(hasLabel(segments[i].startSec,segments[i].endSec))?"":
						'<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> '+
						'<div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div> '
						)+
						*/
					'</div>'
				);
				
			}
		}
		// go through each recognized segments and compare to their labels, set the labeling control
		$("#cIndex > div.videoLists > div.block > div.labels > div.left > div.segments > div.segment").each(function(){
			var hasLabel = false;
			var correct = false;
			var gunshotCount = -1;
			var thisStart = parseFloat($(this).children("input.start").val());
			var thisEnd = parseFloat($(this).children("input.end").val());
			$(this).parent().parent().parent().find("div.right > div.segments > div.segment").each(function(){
				var start = parseFloat($(this).children("input.start").val());
				var end = parseFloat($(this).children("input.end").val());
				if((thisStart == start) && (thisEnd == end))
				{
					hasLabel = true;
					correct = $(this).children("input.correct").val()==1?true:false;
					gunshotCount = $(this).children("input.gunshotCount").val();
					return false;
				}
			});
			if(hasLabel)
			{
				$(this).children("span.muted").remove();
				$(this).children("div.labeling").remove();
				$(this).append("<span class='muted'>"+(correct?"correct":"wrong")+"</span>");
				$(this).find("input.gunshotCount").val(gunshotCount);

			}
			else
			{
				$(this).children("span.muted").remove();
				$(this).children("div.labeling").remove();
				$(this).append('<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>');
			}
		});
	});
	// play the segment
	var segmentPlaying = false;
	var ending = null;
	cw.ec("div.block > div.labels > div > div.segments > div.segment > div.playSegment",function(){
		// reset everything
			// stop all video
		$("div.block > div.srcVideo > video").each(function(){
			$(this).get(0).pause();
		});
		segmentPlaying = false;
		ending = null;
		// check the video loaded
		if($(this).parents("div.block").find("div.srcVideo > video").length == 0)
		{
			alert("Video not loaded");
			return;
		}
		var start = parseFloat($(this).parent().children("input.start").val());
		var end = parseFloat($(this).parent().children("input.end").val());
		var padding = 1.0;// add padding to start and end
		start-=padding;
		end+=padding;

		var videoObject = $(this).parents("div.block").find("div.srcVideo > video").get(0);
		segmentPlaying = true;
		ending = end;
		videoObject.currentTime = start;
		videoObject.play();
		// the video stop is bind when loaded video
	});
	// label it
	cw.ec("#cIndex > div.videoLists > div.block > div.labels > div.left > div.segments > div.segment > div.labeling",function(){
		var thisStartSec = parseFloat($(this).parent().children("input.start").val());
		var thisEndSec = parseFloat($(this).parent().children("input.end").val());
		var autoGunshotCount = parseInt($(this).parent().children("input.autoGunshotCount").val());
		var gunshotCount = parseInt($(this).parent().children("input.gunshotCount").val());
		var videoBlock = $(this).parents("div.block");
		var videoId = videoBlock.children("input.videoId").val();
		var listsId = videoBlock.children("input.listsId").val();
		var correct = false;
		if($(this).hasClass("correct"))
		{
			correct = true;
		}
		if(!hasLabel(videoBlock,thisStartSec,thisEndSec))
		{
			// add to the labels on the page
			var thisLabel = makeLabel(thisStartSec,thisEndSec,correct,autoGunshotCount,gunshotCount);
			videoBlock.find("div.labels > div.right > div.segments").append(thisLabel);
			// then send to the server to save
			var data = {}; data.startSec = thisStartSec;data.endSec = thisEndSec;data.pos = correct?1:0;
			data.videoId = videoId;
			data.listsId = listsId;
			data.autoGunshotCount = autoGunshotCount;
			data.gunshotCount = gunshotCount;
			cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/addGunshotExpLabel?expId=<?php echo $expId?>",data,function(result){
				if(result.status == 0)
				{
					thisLabel.children("input.labelId").val(result.labelId);
				}
			},thisLabel);
		}
		// remove button and added a label tag to it
		$(this).parent().append("<span class='muted'>"+(correct?"correct":"wrong")+"</span>")
			.children("div.labeling").remove();
	});
	// delete a label
	cw.ec("#cIndex > div.videoLists > div.block > div.labels > div.right > div.segments > div.segment > div.delete",function(){
		var startSec = parseFloat($(this).parent().children("input.start").val());
		var endSec = parseFloat($(this).parent().children("input.end").val());
		var labelId = $(this).parent().children("input.labelId").val();
		var videoBlock = $(this).parents("div.block");
		//if(labelId)
		//find the current segment and reset its controll
		videoBlock.find("div.labels > div.left > div.segments > div.segment").each(function(){
			var thisStartSec = parseFloat($(this).children("input.start").val());
			var thisEndSec = parseFloat($(this).children("input.end").val());
			if((thisStartSec == startSec) && (thisEndSec == endSec))
			{
				$(this).children("span.muted").remove();
				$(this).append('<div class="btn btn-small btn-primary labeling correct"><i class="icon-ok icon-white"></i></div> <div class="btn btn-small btn-danger labeling wrong"><i class="icon-remove icon-white"></i></div>');
			//	$(this).append(' ');
				return false;
			}
		});
		var data = {};
		data.labelId = labelId;
		// send to the server to delete
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/deleteGunshotExpLabel?expId=<?php echo $expId?>",data,function(result){

		});
		$(this).parent().remove();
	});
	function makeLabel(startSec,endSec,correct,autoGunshotCount,gunshotCount)
	{
		var labelId = arguments[3]?arguments[3]:"";
		return $('<div class="segment">'+
			'<input class="start" type="hidden" value="'+startSec+'"></input>'+
			'<input class="end" type="hidden" value="'+endSec+'"></input>'+
			'<input class="gunshotCount" type="hidden" value="'+gunshotCount+'"></input>'+
			'<input class="labelId" type="hidden" value="'+labelId+'"></input>'+
			'<input class="correct" type="hidden" value="'+(correct?1:0)+'"></input>'+
			sec2time(startSec)+' to '+sec2time(endSec)+(correct?" <i class='icon-ok'></i>":" <i class='icon-remove'></i>")+
			' autoGunshotCount:'+autoGunshotCount+" gunshotCountReal:"+gunshotCount+
			' <div class="btn btn-small btn-success playSegment">play</div> '+
			'<div class="delete close">&times;</div>'+
		'</div>');
	}
	function hasLabel(videoBlock,startSec,endSec)
	{
		//check segment with startSec and endSec, whether already in Your labels
		var hasLabel = false;
		videoBlock.find("div.labels > div.right > div.segments > div.segment").each(function(){
			var thisStart = parseFloat($(this).children("input.start").val());
			var thisEnd = parseFloat($(this).children("input.end").val());
			if((thisStart == startSec) && (thisEnd == endSec))
			{
				hasLabel = true;
				return false;
			}
		});
		//alert(hasLabel);
		return hasLabel;
	}
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
	//given a score list with time, and threshold, return  consecutive segments
	function getSegments(scoreList,thres)
	{
		// sort first
		scoreList.sort(function(a,b){return a.start - b.start});
		var segments = new Array();
		curSegment = {};
		for(var i=0;i<scoreList.length;++i)
		{
			var score = scoreList[i];
			
			if(parseFloat(score.score) >= thres)
			{
				if(curSegment.start == null)
				{
					curSegment.start =parseFloat( score.start);
				}
				// save the max score in the merged segments
				if((curSegment.score == null) || (parseFloat(score.score) > curSegment.score))
				{
					curSegment.score = parseFloat(score.score);
				}
				curSegment.end = parseFloat(score.end);
			}
			else
			{
				// save this segment
				if((curSegment.start!=null)&& (curSegment.end != null)&& (curSegment.end < parseFloat(score.start)))
				{
					segments.push(curSegment);
					curSegment = {};
				}
			}
		}
		if((curSegment.start!=null)&& (curSegment.end != null))
		{
			segments.push(curSegment);
		}
		return segments;
	}
</script>
<div id="cIndex">
	<input class="expId" type="hidden" value="<?php echo $expId?>"></input>
	<div class="videoLists" style="">
		<?php foreach($items as $item){ ?>
		<div class="block">
			<input class="listsId" type="hidden" value="<?php echo $item['listsId']?>"></input>
			<input class="rankScore" value="<?php echo $item['rankScore']?>" type="hidden"></input>
			<input class="videoId" type="hidden" value="<?php echo $item['videoId']?>"></input>
			<div class="srcVideo">
				<div class="rank muted">Rank:<?php echo $item['rank']?></div>
				<input class="videoname" value="<?php echo $item['videoname']?>" type="hidden"></input>
				<input class="videoPath" value="<?php echo Yii::app()->baseUrl?>/<?php echo $item['relatedPath']?>" type="hidden">
				<?php echo $item['videoname']?>
				<div class="btn btn-small btn-warning loadVideo">Load Video</div>
				<br/><span class='text-error info'></span>
			</div>
			<div class="labels">
				<div class="left">
					<div class="title">Recognized Segments (> <?php echo $threshold?>)</div>
					<div class="segments">
						
					</div>
				</div>
				<div class="right">
					<div class="title">Labeled Segments</div>
					<div class="segments">
						<?php foreach($item['labels'] as $label){ ?>
							<div class="segment">
								<input class="start" type="hidden" value="<?php echo $label['startSec']?>"></input>
								<input class="gunshotCount" type="hidden" value="<?php echo $label['gunshotCountReal']?>"></input>
								<input class="end" type="hidden" value="<?php echo $label['endSec']?>"></input>
								<input class="correct" type="hidden" value="<?php echo $label['pos'] > 0?"1":"0"; ?>"></input>
								<input class="labelId" type="hidden" value="<?php echo $label['id']?>"></input>
								<?php echo Text::sec2time($label['startSec'])?>
								to
								<?php echo Text::sec2time($label['endSec'])?>
								<?php echo $label['pos'] > 0?"<i class='icon-ok'></i>":"<i class='icon-remove'></i>"; ?>
								autoGunshotCount:<?php echo $label['autoGunshotCount']?>
								gunshotCountReal:<?php echo $label['gunshotCountReal']?>
								<div class="btn btn-small btn-success playSegment">play</div>
								<div class="close delete">&times;</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
		<?php } ?>
	</div>
	<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px">  Experiment - <?php echo $GunshotExp->runName; ?>
&nbsp;&nbsp;
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
		<br/>
		Current Page : <?php echo $page?>/<?php echo $totalPage?>
		<?php if($page > 1){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Previous Page</a>
		<?php } ?>
		&nbsp;&nbsp;
		&nbsp;&nbsp;
		<?php if($page < $totalPage){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshotExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Next Page</a>
		<?php } ?>
	</div>
</div>



