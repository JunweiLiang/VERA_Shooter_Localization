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
#cVideoCutExpLabeling{
		position:relative;
		padding-left:5%;
	}
	

	#cVideoCutExpLabeling > div.videoLists{
		padding-top:10px;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block{
		border-top:1px gray solid;
		margin-top:5px;
		padding-top:5px;
		position:relative;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.srcVideo{
		float:left;
		text-align:center;
		width:50%;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.srcVideo > div.rank{
		position:absolute;
		bottom:0;
		text-align:center;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.srcVideo >  video{
		width:100%;
		max-height:400px;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels {
		margin:0 0 0 50%;
		min-height:400px;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div.left{
		float:left;
		width:50%;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div.right{
		margin: 0 0 0 50%;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div > div.title{
		text-align:center;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div > div.cuts{
		border-radius:5px;
		background-color:white;
		height:400px;
		overflow:auto;
		padding:10px;
		margin:5px;
	}
	#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div > div.cuts > div.cut{
		margin-bottom:10px;
		border-radius:5px;
		background-color:rgb(220,220,220);
		padding:10px;
		font-weight:bold;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	div.mainTitle input{margin:0}
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
		//"#cVideoCutExpLabeling > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cVideoCutExpLabeling > input.toProjectList",//点击首logo后显示项目列表部件
		"#cVideoCutExpLabeling > input.gotoDatasetList",
	),//点击头导航的发生的事件
	//"targetName" => "#cVideoCutExpLabeling > #projectList > input.project",
	"targetChange" => array(
	//	"#cVideoCutExpLabeling > #projectList > input.project",//新建了项目后就获取新项目列表
	//	"#cVideoCutExpLabeling > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#cVideoCutExpLabeling > #project > input.projectId",
		"targetProjectName" => "#cVideoCutExpLabeling > #project > input.projectName",
		"targetProjectIntro" => "#cVideoCutExpLabeling > #project > input.projectIntro",
		"targetChangeP" => array(
			"#cVideoCutExpLabeling > #project > input.projectId",//点击了项目后载入项目内容 
			"#cVideoCutExpLabeling > input.toProject",//点击了项目后显示项目部件 
		),
)); ?>
<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px">

  Experiment - <?php echo $VideoCutExp->name; ?>
&nbsp;&nbsp;
	<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
	<a class="btn btn-small btn-warning download" target="_self" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabelCalculate?expId=<?php echo $expId?>">Check Accuracy</a>
	<br/>
	Current Page : <?php echo $page?>/<?php echo $totalPage?>
	|
	&nbsp;
	<?php if($page > 1){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Previous Page</a>
	<?php } ?>
	&nbsp;&nbsp;
	<?php if($page < $totalPage){ ?>
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Next Page</a>
	<?php } ?>
	<br/>
	Your reflex time in seconds (will minus the time you click addCutPoint): <input class="reflex input-small" type="text" value="0.4"></input>
</div>
<script type="text/javascript">
	var data = {};
	var dataGt = {};// labeled
	<?php foreach($items as $item){ 
		// prepare the data
	?>
		data[<?php echo $item['expVideoId']?>] = <?php echo $item['cutPoints']?>;
		<?php if(isset($item['gt'])){ ?>
			dataGt[<?php echo $item['expVideoId']?>] = <?php echo $item['gt']?>;
		<?php } ?>

	<?php } ?>
	
	$(document).ready(function(){
		// load all the cutpoints into the place and 
		for(var expVideoId in data)
		{
			var videoBlock = $("div.block > input.expVideoId[value='"+expVideoId+"']").parent();
			videoBlock.find("div.labels > div.left > div.cuts").html("");
			for(var i=0;i<data[expVideoId].length;++i)
			{
				videoBlock.find("div.labels > div.left > div.cuts").append(makeCutBlock(data[expVideoId][i],true));
			}
			if(dataGt[expVideoId] != null)
			{
				// sort it in assending order first
				dataGt[expVideoId].sort(function(a,b){return a-b});
				for(var i=0;i<dataGt[expVideoId].length;++i)
				{
					videoBlock.find("div.labels > div.right > div.cuts").append(makeCutBlock(dataGt[expVideoId][i],false));
				}
			}
		}
		
	});
	function makeCutBlock(cutpoint,add)
	{
		return $('<div class="cut">'+
			'<input class="cutPoint" type="hidden" value="'+cutpoint+'"></input>'+
			sec2time(cutpoint)+
			" "+
			'<div class="btn btn-small btn-primary play before">PlayBefore</div> '+
			'<div class="btn btn-small btn-primary play after">PlayAfter</div> '+
			(
				// for adding the cut to groud truth
				add?'<div class="btn btn-small btn-success addToGt">Correct</div>'
				:
				""
			)+
			(
				// for deleting the cut of ground truth
				add?""
				:
				'<div class="close delete">&times;</div>'
			)+
		'</div>');
	}
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	var cutGap = 0.5; // the time diff from we think a cut is the same

	// play the segment
	var segmentPlaying = false;
	var ending = null;
	cw.ec("div.block > div.labels > div > div.cuts > div.cut > div.play",function(){
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
		var cutBlock = $(this).parent();
		var isBefore = $(this).hasClass("before")?true:false;
		var videoObject = $(this).parents("div.block").find("div.srcVideo > video").get(0);
		//alert(videoObject.duration);
		//return;
		// first and last scenario
		var start=null;var end = null;
		if(isBefore)
		{
			var end = parseFloat(cutBlock.children("input.cutPoint").val());
			if(cutBlock.index() == 0)
			{
				//the first cut, start from the begining
				var start = 0.0;
			}
			else
			{
				// get the previous cut as starting point
				var start = parseFloat(cutBlock.prev("div.cut").children("input.cutPoint").val());
			}

		}
		else
		{
			var start = parseFloat(cutBlock.children("input.cutPoint").val());
			if(cutBlock.index() == (cutBlock.parent().children("div.cut").length - 1))
			{
				var end = videoObject.duration;
			}
			else
			{
				// get the next cut as the ending point;
				var end = parseFloat(cutBlock.next("div.cut").children("input.cutPoint").val());
			}
		}
		if(end - start <= cutGap)
		{
			alert("start and end too close!");
			return;
		}
		var padding = 0.0;// add padding to start and end
		start-=padding;
		end+=padding;

		segmentPlaying = true;
		ending = end;
		videoObject.currentTime = start;
		videoObject.play();
		// the video stop is bind when loaded video
	});
	
	// delete a gt cut point
	cw.ec("#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div.right > div.cuts > div.cut > div.delete",function(){
		$(this).parent().remove();
	});
	//correct a automattic cutpoints
	cw.ec("#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div.left > div.cuts > div.cut > div.addToGt",function(){
		var cutPoint = parseFloat($(this).parent().children("input.cutPoint").val());
		addGtCutPoint(cutPoint,$(this).parents("div.labels").find("div.right > div.cuts"));
		$(this).remove();
	});
	// add Cut point during video playing or not
	cw.ec("#cVideoCutExpLabeling > div.videoLists > div.block > div.srcVideo > div.addCut",function(){
		if($(this).parents("div.block").find("div.srcVideo > video").length == 0)
		{
			alert("Video not loaded");
			return;
		}
		//relfex
		var reflex = parseFloat($("div.mainTitle > input.reflex").val());
		
		var videoObject = $(this).parents("div.block").find("div.srcVideo > video").get(0);
		var cutPoint = videoObject.currentTime - reflex;
		if(cutPoint < 0)cutPoint=0;
		if(cutPoint > videoObject.duration)cutPoint = videoObject.duration;
		addGtCutPoint(cutPoint,$(this).parents("div.block").find("div.labels > div.right > div.cuts"));
	});
	// save the cuts//
	// will remove the 0.0 cut and add the final duration as cut
	cw.ec("#cVideoCutExpLabeling > div.videoLists > div.block > div.labels > div.right > div.title > div.save",function(){
		if($(this).parents("div.block").find("div.srcVideo > video").length == 0)
		{
			alert("Video not loaded");
			return;
		}
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var videoObject = $(this).parents("div.block").find("div.srcVideo > video").get(0);
		var finalPoint = videoObject.duration;
		addGtCutPoint(finalPoint,$(this).parents("div.block").find("div.labels > div.right > div.cuts"));
		// gett all the points
		var cutList = new Array();
		$(this).parents("div.block").find("div.labels > div.right > div.cuts > div.cut").each(function(){
			var cut = parseFloat($(this).children("input.cutPoint").val());
			cutList.push(cut);
		});

		// sort it in assending order first
		cutList.sort(function(a,b){return a-b});

		var data = {};
		data.cutListJson = JSON.stringify(cutList);
		data.videoId = $(this).parents("div.block").children("input.videoId").val();
		data.expVideoId = $(this).parents("div.block").children("input.expVideoId").val();
		//alert(data.cutListJson);
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"videoCutExpLabel?expId=<?php echo $expId?>",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html("done").emptyLater();
			}
			else
			{
				$(this).parent().children("span.info").html("error:"+result.error);
			}
		},$(this));
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
	function addGtCutPoint(newcut,gtDiv) // gt Div should be a div.right > div.cuts
	{
		// first get all current cut
		var curCutList = new Array();
		$(gtDiv).children("div.cut").each(function(){
			var cut = parseFloat($(this).children("input.cutPoint").val());
			curCutList.push(cut);
		});
		// check this newcut in the curCutlist or not
		// and find the right index for inserting, assuming the curCutList is in assending order
		var isIn = false;
		var insertPoint = -1;
		for(var i=0;i<curCutList.length;++i)
		{
			if(Math.abs(newcut - curCutList[i]) < cutGap)
			{
				isIn = true;
				break;
			}
			if(i<curCutList.length - 1)
			{
				if((newcut > curCutList[i]) && (newcut < curCutList[i+1]))
				{
					insertPoint = i;// new cut should be after i
				}
			}
			if(i == 0)
			{
				if(newcut < curCutList[i])
				{
					insertPoint = -2;
				}
			}
		}
		if(!isIn)
		{
			//alert(insertPoint);
			//alert(curCutList[2]);
			// add to the gtDiv to the right place
			var newCutBlock = makeCutBlock(newcut,false);
			if(insertPoint == -1)
			{
				$(gtDiv).append(newCutBlock);
			}
			else if (insertPoint == -2)
			{
				$(gtDiv).prepend(newCutBlock);
			}
			else
			{
				newCutBlock.insertAfter($(gtDiv).find("div.cut").eq(insertPoint));
			}
		}
	}
</script>
<div id="cVideoCutExpLabeling">
	<input class="expId" type="hidden" value="<?php echo $expId?>"></input>
	<div class="videoLists" style="">
		<?php foreach($items as $item){ ?>
		<div class="block">
			<input class="expVideoId" type="hidden" value="<?php echo $item['expVideoId']?>"></input>
			
			<input class="videoId" type="hidden" value="<?php echo $item['videoId']?>"></input>
			<div class="srcVideo">
				<div class="rank muted">Rank:<?php echo $item['rank']?></div>
				<input class="videoname" value="<?php echo $item['videoname']?>" type="hidden"></input>
				<input class="videoPath" value="<?php echo Yii::app()->baseUrl?>/<?php echo $item['relatedPath']?>" type="hidden">
				<?php echo $item['videoname']?>
				<div class="btn btn-small btn-warning loadVideo">Load Video</div>
				<div class="btn btn-small btn-primary addCut">addCutPoint</div>
				<br/><span class='text-error info'></span>
			</div>
			<div class="labels">
				<div class="left">
					<div class="title">Automatic CutPoints</div>
					<div class="cuts">
						
					</div>
				</div>
				<div class="right">
					<div class="title">Labeled cutPoints <!-- (will remove 0 sec and add duration) -->
						<div class="btn btn-small btn-primary save">Save</div>
						<span class="text-info info"></text>
					</div>
					<div class="cuts">
						
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
		<?php } ?>
	</div>
	<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px">  Experiment - <?php echo $VideoCutExp->name; ?>
&nbsp;&nbsp;
		<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $lastLabeledInPage;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Last Labeled</a>
		<br/>
		Current Page : <?php echo $page?>/<?php echo $totalPage?>
		<?php if($page > 1){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page-1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Previous Page</a>
		<?php } ?>
		&nbsp;&nbsp;
		&nbsp;&nbsp;
		<?php if($page < $totalPage){ ?>
			<a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId; ?>&page=<?php echo $page+1;?>&perPage=<?php echo $perPage?>" style="text-decoration:none">Next Page</a>
		<?php } ?>
	</div>
</div>



