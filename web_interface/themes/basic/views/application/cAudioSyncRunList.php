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
		$("#cIndex > input.gotoDatasetList").change();
		
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
		cw.post("<?php echo Yii::app()->baseUrl;?>/index.php/main/getDatasetList?forSync=1",data,function(result){
			$("#siteHeader > input.stopLoading").change();
			$("#cIndex > div.datasetList").html("");
			if(result.status == 0)
			{
				for(var i =0;i<result.datasets.length;++i)
				//for(var i =0;i<1;++i)// show the first , temporary
				{
					var note = "";
					if(result.datasets[i].isImported == 1)
					{
						note = " (for Annotation)";
					}
					$("#cIndex > div.datasetList").append('<div class="block">'+
						'<input class="datasetId" type="hidden" value="'+result.datasets[i].id+'"></input>'+
						'<input class="isImported" type="hidden" value="'+result.datasets[i].isImported+'"></input>'+
						'<div class="datasetname">'+result.datasets[i].name+note+'</div>'+
						//'<div class="spe">'+
						//	'<i class="icon-folder-open"></i>'+
						//'</div>'+
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
		//now we go to another page
		var data = {};
		data.datasetId = $(this).children("input.datasetId").val();
		data.forLabeling = $(this).children("input.isImported").val();
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSyncRun?datasetId="+data.datasetId+"&forLabeling="+data.forLabeling,"_self");
		return;
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
//---------------------------------------------not used for audio sync runlist page-------------`

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
<div class="mainTitle" style="color:gray;text-align:center;font-weight:bold;padding-top:10px"> You are at - Audio Synchronization Run List.
<a class="" href="<?php echo Yii::app()->baseUrl?>/" style="text-decoration:none">Back to Main Page</a>
</div>
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
