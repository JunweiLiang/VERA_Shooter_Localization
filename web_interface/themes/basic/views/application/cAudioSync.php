
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
	#cAudioSync{
		position:relative;
		padding:5px;
		padding-bottom:50px;
	}
	#cAudioSync input{margin:0}
	#cAudioSync div.searchVideo > div.guessList{
		padding:5px;
	}
	#cAudioSync div.searchVideo > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cAudioSync div.searchVideo > div.guessList > div.block:hover{
		color:gray
	}
	#cAudioSync div.display > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	#cAudioSync div.display > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cAudioSync > div.left{
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
	#cAudioSync > div.right{
		margin:0 0 0 40%;
		padding-left:10px;
	}
	#cAudioSync video{
		width:100%;
	}
	#cAudioSync div.title{
		text-align:center;
	}
	#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > div.progressForImportVideo{
		width:200px;
	}
	#cAudioSync > div.right div.title{
		font-weight:bold;
		color:gray;
		padding:5px;
		border-bottom:1px silver solid;
		margin-bottom:5px;
	}
	#cAudioSync > div.right > div.videoList{
		height:500px;
		max-height:500px;
		overflow:auto;
	}
	#cAudioSync > div.right > div.videoList > div.block{
		padding:10px;
		border-bottom:1px silver solid;
	}
	#cAudioSync > div.right > div.videoList > div.block > div.imgs{
		color:gray;
	}
	#cAudioSync > div.right > div.videoList > div.block > div.imgs > img{
		max-height:60px;max-width:100px;
	}
	#cAudioSync > div.right > div.videoList > div.block > div.videotitle{
		padding:5px;
		font-weight:bold;
	}
	#cAudioSync > div.left > div.ctr{
		margin:10px;
		padding:10px;
		background-color:white;
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#cAudioSync > div.left > div.ctr > div.line{
		padding:10px;
	}
	#cAudioSync > div.left{
		max-height:800px;
		overflow:hidden;
	}
	#cAudioSync #runListModal > div.modal-body > div.block{
		padding:10px;
		cursor:pointer;
		font-weight:bold;
		word-break:break-all;
	}#cAudioSync #runListModal > div.modal-body > div.block:hover{
		background-color:rgb(220,220,220);
	}
	#cAudioSync > div.result > div.resultDetail > div.line{
		padding:5px;
	}
	#cAudioSync > div.result > div.resultDetail > div.clusterList{
		padding:10px;
	}
	#cAudioSync > div.result > div.resultDetail > div.title
	{
		padding:10px;font-weight:bold;text-align:center;
		margin:5px;
		border-bottom:1px silver solid;
	}
	#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block,
	#cAudioSync > div.result > div.resultDetail > div.clusterList > div.oneMore{
		background-color:white;
		border-radius:5px;
		padding:10px;
		margin-right:20px;
		margin-bottom:10px;
		float:left;
		-moz-box-shadow:0 2px 4px #999;              
 	  -webkit-box-shadow:0 2px 4px #999;           
 	   box-shadow:0 2px 4px #999;
 	   border:1px silver solid;
 	   cursor:pointer;
 	   color:rgb(0,128,192);
 	   font-weight:bold;
	}
	#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block.toggle{
		color:white;
		background-color:rgb(0,128,192);
	}
	#cAudioSync > div.result > div.resultDetail > div.clusterList > div.oneMore{
		font-size:1.2em;
		padding:10px 20px;
	}
	#cAudioSync > div.result > div.resultDetail > div.refine{

	}
	#cAudioSync > div.result > div.resultDetail > div.refine > div.line{
		padding:5px;
	}
	<?php if($datasetId != ""){ ?>
		#cAudioSync > div.right {
			display:none;
		}
		#cAudioSync > div.left{
			float:none;
			margin:30px auto;
		}
	<?php } ?>
</style>
<script type="text/javascript">

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
		$(this).parent().parent().children("div.add").trigger(cw.ectype);
	});
	var thisVideoNames = new Array();//each time the video name list that used to upload
	function beforeUpload()
	{
		$("#cAudioSync > div.left > div.uploadVideo > span.info").html("");
		$("#cAudioSync > div.left > div.preprocessing").hide();
		$("#cAudioSync > div.left > div.processing").hide();
		thisVideoNames = new Array();
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
		//$("#cAudioSync > div.left > div.uploadVideo > input.newvideoUrl").val(data.url);
		//alert(data.files.length);
		$("#cAudioSync > div.left > div.uploadVideo > span.info").html("Upload "+data.files.length+" files Success");
		$("#cAudioSync > div.left > div.preprocessing").show();
		// trigger the system to load this video into database
		var urls = new Array();
		for(var i=0;i<data.files.length;++i)
		{
			urls.push(data.files[i].url);
			thisVideoNames.push(baseName(data.files[i].url));
		}
		loadVideo(urls);
	}
	function videoUploadError(str)
	{
		$("#cAudioSync > div.left > div.uploadVideo > span.info").html(str);
	}
	// load video into database, may trigger process
	function loadVideo(urls)
	{
		
		var data = {};
		data.urls = urls;
		// put the video name into search input, so that after it is in the database, it can be used for person detection
		
		//alert(url);
		//$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("<div class='wrapLoading'><div class='loading'></div></div>");
		$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("posting request...");
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/importVideos",data,function(result){
			if(result.status == 0)
			{
				//display counting results
				/*
				$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html(
					result.count.addToDatabase+" added to database directly, since related path and original path exists;<br/>"+
					result.count.ignore+" are ignored since original not exists;<br/>"+
					result.count.furtherProcess+" are posted to python for futher process<br/>"+
					"python will need 5 minutes to process a 40-minute video"
				);*/
				if(result.count.furtherProcess != 0)
				{
					$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Loading video...");
				}
				else
				{
					$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Video List");
					addVideosToList(thisVideoNames);
					thisVideoNames = new Array();
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
	cw.ech("#cAudioSync > div.left > div.preprocessing > input.importDone",function(){
		$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Video List");
		addVideosToList(thisVideoNames);
		thisVideoNames = new Array();
	});
	function baseName(str)
	{
	   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
	   // if(base.lastIndexOf(".") != -1)       
	    //    base = base.substring(0, base.lastIndexOf("."));
	   return base;
	}
	//search video to add
	cw.ec("#cAudioSync > div.left > div.searchVideo > div.add",function(){
		var videoname = $(this).parent().children("input.videoname").val();
		addVideosToList([videoname]);
	});
	function addVideosToList(videonameList)
	{
		//for each name, check whether already in page, then ask for video info, then add to list
		var videoToBeAdded = new Array();
		for(var i=0;i<videonameList.length;++i)
		{
			if(!inVideoList(videonameList[i]))
			{
				videoToBeAdded.push(videonameList[i]);
			}
		}
		if(videoToBeAdded.length == 0)
		{
			return;
		}
		var data = {};
		data.videoList = videoToBeAdded;
		// ask for info and then add to list
		$("#cAudioSync > div.right > div.title > span.videoListInfo").html('<div class="loading"></div>');
		cw.post(cw.url+"getVideosInfo",data,function(result){
			$("#cAudioSync > div.right > div.title > span.videoListInfo").html("");
			if(result.status == 0)
			{
				for(var i =0;i<result.videos.length;++i)
				{
					var thisCount = $("#cAudioSync > div.right > div.videoList > div.block").length+1;
					$("#cAudioSync > div.right > div.videoList").append(makeVideoBlock(result.videos[i],thisCount));
				}
				$("#cAudioSync > div.left > div.ctr > div.line > span.videoCount").html($("#cAudioSync > div.right > div.videoList > div.block").length);
			}
		});
	}
	function makeVideoBlock(video,count){
		//var videoname = urlencode();
		var temp = $('<div class="block">'+
			<?php if($datasetId==""){ ?>
			'<div class="close delete">&times</div>'+
			<?php } ?>
			'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
			'<div class="imgs"><div class="wrapLoadng">No Preview Images Available</div></div>'+
			'<div class="videotitle"><span class="count">'+count+"</span>. "+video.videoname+
				' <a class="watch" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname='+video.videoname+'"><i class="icon-eye-open"></i></a>'+
			'</div>'+
			
			'</div>');
		if(video.hasImgs == 1)
		{
			temp.find("div.imgs").html("");
			for(var i =0;i<video.imgCount;++i)
			{
				temp.find("div.imgs").append('<img class="videoImg" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname+"_"+i+'.png"></div>');
			}
		}
		return temp;
	}
	//delete one
	cw.ec("#cAudioSync > div.right > div.videoList > div.block > div.delete",function(){
		$(this).parent().remove();
		changeVideoCount();
		$("#cAudioSync > div.left > div.ctr > div.line > span.videoCount").html($("#cAudioSync > div.right > div.videoList > div.block").length);
	});
	function changeVideoCount()
	{
		var count=0;
		$("#cAudioSync > div.right > div.videoList > div.block > div.videotitle > span.count").each(function(){
			count+=1;
			$(this).html(count);
		});
	}
	function inVideoList(videoname)
	{
		var inIt = false;
		$("#cAudioSync > div.right > div.videoList > div.block > input.videoname").each(function(){
			if($(this).val() == videoname)
			{
				inIt = true;
				return false;
			}
		});
		return inIt;
	}
	// run event reconstruction
	var curDatasetId = null;
	<?php if($datasetId!=""){ ?>
		var curDatasetId = <?php echo $datasetId?>;
	<?php } ?>
	cw.ec("#cAudioSync > div.left > div.ctr > div.line > div.run",function(){
		var data = {};
		data.videonames = new Array();
		$("#cAudioSync > div.right > div.videoList > div.block > input.videoname").each(function(){
			data.videonames.push($(this).val());
		});
		data.makeNewDataset = 0;
		<?php if($datasetId==""){ ?>

			data.makeNewDataset = 1;
			data.runName = $(this).parent().parent().find("div.line > input.runName").val();
			if(data.runName == "")
			{
				$("#cAudioSync > div.left > div.ctr > div.line > span.info").html("Please enter a runName");
				return;
			}
			curDatasetId = null;

		<?php }else{ ?>

			data.datasetId = <?php echo $datasetId?>;
			data.runName = data.datasetId;

		<?php } ?>
		
		$("#cAudioSync > div.left > div.ctr > div.line > span.info").html('<div class="loading"></div>');
		
		
		cw.post(cw.url+"runVideoSync",data,function(result){
			$("#cAudioSync > div.left > div.ctr > div.line > span.info").html('');
			if(result.status == 0)
			{
				curDatasetId = result.datasetId;
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#videoSyncProgress > input.processId").val(result.processId);
					$("#videoSyncProgress > input.showing").val(1).change();
					$("#videoSyncProgress > input.updating").val(1).change();
				}
			}
			else
			{
				if(result.status == -1)
				{
					$("#cAudioSync > div.left > div.ctr > div.line > span.info").html('This Run Exists');
				}
				else if(result.status == -2)
				{
					$("#cAudioSync > div.left > div.ctr > div.line > span.info").html('This Dataset has already run sync. Check the result below');
				}
			}
		});
	});
	//sync run complete
	cw.ech("#cAudioSync > div.right > input.syncDone",function(){
		if(curDatasetId != null)
		{
			var data = {};
			data.datasetId = curDatasetId;
			getERclusters(data.datasetId,true);
			/*
			cw.postNew("<?php echo Yii::app()->baseUrl?>/index.php/application/cGlobalResult",data,"globalResultIframe");
			$("#globalSyncSimple > input.datasetId").val(data.datasetId).change();
			*/
			<?php if($datasetId != ""){ ?>
				$("#daisyProgress > input.datasetId").change();
			<?php } ?>
		}
	});
	//refresh /get result
	cw.ec("#cAudioSync > div.title > div.refresh",function(){
		var datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		if(datasetId != "")
		{
			getERclusters(datasetId,true);
		}
	});
	// existing run list
	cw.ec("#cAudioSync > div.left > div.line > div.runList",function(){
		getRunList();
		$("#runListModal").modal("show");
	});
	function getERvideos(datasetId)
	{
		var data = {};
		data.datasetId = datasetId;
		$("#cAudioSync > div.right > div.videoList").html("");
		cw.post(cw.url+"getERRunVideos",data,function(result){
			if(result.status == 0)
			{
				//parse video name into a list
				var videonames = new Array();
				for(var i =0;i<result.videos.length;++i)
				{
					videonames.push(result.videos[i].videoname);
				}
				addVideosToList(videonames);
			}
		});
	}
		// click a run
	cw.ec("#runListModal > div.modal-body > div.block",function(){
		runName = $(this).children("input.runName").val();
		// ask for all the video name
		var data = {};
		data.runName = runName;
		$("#cAudioSync > div.left > div.ctr > div.line > input.runName").val(runName);
		data.datasetId = $(this).children("input.runId").val();
		data.clusterIds = $(this).children("input.clusterIds").val().split(",");
		//alert(data.clusterIds[0]);
		
		//load the videos
		getERvideos(data.datasetId);
		// load the result
		getERclusters(data.datasetId,true);
		//load videolist for refine
		$("#datasetVideo > input.datasetId").val(data.datasetId).change();
		$("#datasetVideoForRefine > input.datasetId").val(data.datasetId).change();
			// now we only load the first cluster
			/*
		data.clusterId = data.clusterIds[0];
		cw.postNew("<?php echo Yii::app()->baseUrl?>/index.php/application/cGlobalResult",data,"globalResultIframe");
		// get my global sync show case
		$("#globalSyncSimple > input.datasetId").val(data.datasetId).change();
		*/
		$("#runListModal").modal("hide");
	});
	// delete a run
	cw.ec("#runListModal > div.modal-body > div.block > div.close",function(e){
		e.stopPropagation();
		var data = {};
		data.datasetId = $(this).parent().children("input.runId").val();
		data.runName = $(this).parent().children("input.runName").val();
		if(!confirm("Confirm delete result for "+data.runName+"?"))
		{
			return;
		}
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/deleteERRun",data,function(result){
			if(result.status ==0)
			{
				getRunList();
			}
		});
	});
	//get the sync clusters of a dataset
	var clickOneCluster = false;
	function getERclusters(datasetId)
	{
		var data = {};
		clickOneCluster = arguments[0]?arguments[0]:false;
		data.datasetId = datasetId;
		$("#cAudioSync > div.result > input.datasetId").val(data.datasetId);
		$("#cAudioSync > div.result > div.resultDetail > div.line > span.datasetname").html("");
		$("#cAudioSync > div.result > div.resultDetail > div.clusterList").html("<div class='loading'></div>");
		cw.post(cw.url+"getVideoSyncClusters",data,function(result){
			$("#cAudioSync > div.result > div.resultDetail > div.clusterList").html("");
			if(result.status == 0)
			{
				$("#cAudioSync > div.result > div.resultDetail > div.line > span.datasetname").html(result.datasetname);
				var count=0;
				for(var i in result.clusters)
				{
					count++;
					var temp = $('<div class="block">'+
						'<input class="clusterId" type="hidden" value="'+result.clusters[i].id+'"></input>'+
						'<input class="videoNum" type="hidden" value="'+result.clusters[i].videoNum+'"></input>'+
						'<input class="count" type="hidden" value="'+count+'"></input>'+
					'</div>');
					changeCluster(temp,result.clusters[i]);
					$("#cAudioSync > div.result > div.resultDetail > div.clusterList").append(temp);
				}
				if((result.clusters.length > 0) && clickOneCluster)
				{
					$("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block").eq(0).trigger(cw.ectype);
					clickOneCluster = false;
				}
				// add a add
				$("#cAudioSync > div.result > div.resultDetail > div.clusterList").append("<div class='oneMore'>&plus;</div>");
			}
		});
	}
	function changeCluster(block,cluster)
	{
		$(block).find("span.text").remove();
		$(block).find("div.delete").remove();
		$(block).children("input.videoNum").val(cluster.videoNum);
		var count = $(block).children("input.count").val();
		$(block).append('<span class="text">'+count+") "+cluster.videoNum +" videos "+
			((cluster.refineName==null)?((cluster.isAuto==1)?"</span>":
			' (customized)</span>'):"(refined: "+cluster.refineName+" )</span> ")
		);
		$(block).append(' <div class="close delete" style="padding-bottom:0">&times;</div>');
	}
	//delete a cluster
	cw.ec("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block > div.delete",function(){
		if(!confirm("Confirm delete "+$(this).parent().children("input.count").val()+") cluster?"))
		{
			return;
		}
		var data = {};
		data.clusterId = $(this).parent().children("input.clusterId").val();
		data.datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		cw.post(cw.url+"deleteCluster",data,function(result){
			getERclusters($("#cAudioSync > div.result > input.datasetId").val(),true);
		});
		$(this).parent().html('<div class="loading"></div>');
	});
	//click one cluster, load the result of global and simplyfied
	cw.ec("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block",function(){
		var data ={};
		data.datasetId = $(this).parent().parent().parent().children("input.datasetId").val();
		data.clusterId = $(this).children("input.clusterId").val();
		$("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block").removeClass("toggle");
		$(this).addClass("toggle");
		//alert(data.clusterId+" "+data.datasetId);
		//set the result for simple view
		$("#globalSyncSimple > input.clusterId").val(data.clusterId);
		$("#globalSyncSimple > input.datasetId").val(data.datasetId).change();
		// set the things for refining
		var videoNum = $(this).children("input.videoNum").val();
		var count = $(this).children("input.count").val();
		$("#cAudioSync > div.result > div.resultDetail > div.title > span.clusterName").html(count+") "+videoNum+" videos");
		//
		//cw.postNew("<?php echo Yii::app()->baseUrl?>/index.php/application/cGlobalResult",data,"globalResultIframe");
	});
	//add one more cluster
	cw.ec("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.oneMore",function(){
		if($(this).hasClass("disabled"))
			{return;}
		if(!confirm("Add one cutomized video group?"))
		{
			return;
		}
		var data = {};
		data.datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		$(this).addClass("disabled");
		cw.post(cw.url+"addCluster",data,function(result){
			$(this).removeClass("disabled");
			getERclusters($("#cAudioSync > div.result > input.datasetId").val(),true);
		},$(this));
	});
	//get into the page and try to load the first detection results
	$(document).ready(function(){
		<?php if($datasetId !=""){ ?>
			// load the videos.
			getERvideos(<?php echo $datasetId?>);
			// load the result
			getERclusters(<?php echo $datasetId?>,true);
			//load videolist for refine
			$("#datasetVideoForRefine > input.datasetId").val(<?php echo $datasetId?>).change();
		<?php } else{ ?>
			getRunList(true);
		<?php } ?>
	});
	function getRunList()
	{
		var clickOne = arguments[0]?arguments[0]:false; // whether to click the first run
		$("#runListModal > input.clickOne").val(clickOne);
		$("#runListModal > div.modal-body").html('<div class="wrapLoading"><div class="loading"></div></div>');
		var data = {};
		data.count = -1;
		
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/getERRunList",data,function(result){
			if(result.status ==0)
			{
				var clickOne = $("#runListModal > input.clickOne").val()=="true"?true:false;
				$("#runListModal > div.modal-body").html('');
				for(var i=0;i< result.runList.length;++i)
				{
					$("#runListModal > div.modal-body").append(
						'<div class="block">'+
							'<input class="runId" type="hidden" value="'+result.runList[i].datasetId+'"></input>'+
							'<input class="runName" type="hidden" value="'+result.runList[i].name+'"></input>'+
							'<input class="clusterIds" type="hidden" value="'+result.runList[i].clusterIds.join(",")+'"></input>'+
							result.runList[i].name+
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
	//post to rashomon to display
	cw.ec("#cAudioSync > div.title > a.watch",function(){
		var data = {};
		data.datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		data.clusterId = $("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block.toggle").children("input.clusterId").val();
		if((data.datasetId != '') && (data.clusterId != ""))
		{
			cw.postNew("<?php echo Yii::app()->baseUrl?>/index.php/application/cGlobalResult",data,"globalResultIframe");
		}
	});
	// scrollback
	cw.ec("#cAudioSync > div.title > div.back",function(){
		window.scrollTo(0,0);
	});
	//select video for cluster
	$(document).delegate("#datasetVideoForRefine > div.main > div.block > input.select","click",function(e){
		calRefineSelect();
	});
	function calRefineSelect()
	{
		$("#cAudioSync > div.result > div.resultDetail > div.refine > div.line > span.videoNum").html(getRefineSelect().length);
	}
	function getRefineSelect()
	{
		var videos = new Array();
		$("#datasetVideoForRefine > div.main > div.block > input.select:checked").each(function(){
			videos.push($(this).parent().children("input.dvId").val());
		});
		return videos;
	}
	// add selected cluster
	cw.ec("#cAudioSync > div.result > div.resultDetail > div.refine > div.line > div.addVideos",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.dvIds = getRefineSelect();
		if(data.dvIds.length == 0)
		{
			return;
		}
		data.clusterId = $("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block.toggle > input.clusterId").val();
		if(!confirm("Confirm adding "+data.dvIds.length+" videos into group "+$("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block.toggle > input.count").val()+") ?"))
		{
			return;
		}
		data.videos = new Array();
		for(var i in data.dvIds)
		{
			data.videos.push({"dvId":data.dvIds[i],"offset":0});
		}
		data.datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		//$(this).parent().children("span.info").html("fuck").emptyLater();
		//return;
		$(this).addClass("disabled").parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"addVideo2Cluster",data,function(result){
			$(this).removeClass("disabled").parent().children("span.info").html("");
			if(result.status == 0)
			{
				changeCluster($("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block > input.clusterId[value='"+result.cluster.id+"']").parent(),result.cluster);
				$("#cAudioSync > div.result > div.resultDetail > div.clusterList > div.block.toggle").trigger(cw.ectype);
				$(this).parent().children("span.info").html("added "+result.insertCount+" new videos").emptyLater();
			}
		},$(this));

	});
	//refine result
	var refining = false;
	cw.ec("#cAudioSync > div.result > div.resultDetail > div.refine > div.line > div.refineResult",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		if(refining)
		{
			$(this).parent().children("span.info").html('Refining...').emptyLater();
			return;
		}
		var data = {};
		data.datasetId = $("#cAudioSync > div.result > input.datasetId").val();
		data.refineType = 1;
		if($(this).hasClass("r2"))
		{
			data.refineType = 2;
		}
		$("#cAudioSync > div.result > div.resultDetail > div.refine > div.line > div.refineResult").addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"refineERresults",data,function(result){
			$("#cAudioSync > div.result > div.resultDetail > div.refine > div.line > div.refineResult").removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html("Request Sent").emptyLater();
				if((result.processStatus ==0) && (result.processId != null))
				{
					refining = true;
					//start monitoring the process
					$("#RefineProgress > input.processId").val(result.processId);
					$("#RefineProgress > input.showing").val(1).change();
					$("#RefineProgress > input.updating").val(1).change();
				}
			}
		},$(this));
	});
	//refine done
	cw.ech("#cAudioSync > div.result > div.resultDetail > div.refine > input.done",function(){
		refining = false;
		// get the cluster again
		getERclusters(curDatasetId,true);
	});
</script>

<div id="cAudioSync">
	<div class="modal hide fade" id="runListModal" style="width:500px;margin-left:-250px">
		<input class="clickOne" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			Existing Video Synchronization Results
    		</h2>
		</div>
		<div class='modal-body'>
			
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	
	<div class="left">
	<?php if($datasetId == ""){ ?>
		<div class="line" style="padding:10px;border-bottom:1px silver solid;margin-bottom:10px">
			<div class="btn btn-warning btn-small runList">Browse Results from Previous runs</div><br/>
			<span class="muted">Click this to see video synchronization results of previously uploaded videos</span>
		</div>
		<div class="uploadVideo" style="width:400px;">
			
			<?php $this->widget("UploadMultiWidget",array(
				"success" => "videoUploadOk", //what to do after successful upload
				"error" => "videoUploadError",
				"maxSize" => "1024*1024*400",
				"types" => "mp4",
				"buttonName" => "upload New Video",
				"filename" => "newVideoUploaded",
				"id" => "forNewVideoUpload",
				"beforeSubmit" => "beforeUpload",
				"htmlAfterButton" => '<span class="text-error">Max file size: 400MB; mp4 only</span>',
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
						"doneCall" => "#cAudioSync > div.left > div.preprocessing > input.importDone",
						"noMessage" => true,
					));
				?>
				</div>
			</div>
		</div>
		<div class="searchVideo" style="padding:5px 0;">
			<input class="input-medium videoname" type="text"></input>
			<div class="btn btn-small btn-info search">Search by Video Name</div>
			<div class="btn btn-small btn-success add">Add this video to bucket</div>
			<span class="text-error info"></span>
			<br/>
			<div class="guessList" style="max-height:200px;overflow:auto"></div>
		</div>
		<?php } ?>
		<div class="ctr">
			<div class="title">Video Synchronization</div>
			<?php if($datasetId ==""){ ?>
			<div class="line">
				runName: <input class="runName input-large" type="text"></input>
				(<span class="videoCount">0</span> videos)
			</div>
			<?php }else{ ?>
			<div class="line">
				Collection: <a href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId=<?php echo $datasetId?>" target="_blank"><span class="datasetname text-info"><?php echo $datasetname?></span></a>
				(<span class="videoCount">0</span> videos)
			</div>
			<?php } ?>
			<?php if(!$hasRun){ ?>
			<div class="line">
				<div class="btn btn-primary run">Run Video Synchronization</div>
				<span class="info text-error"></span>
			</div>
			<div class="line">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "videoSyncProgress",
						"doneCall" => "#cAudioSync > div.right > input.syncDone",
						"noMessage" => false,
					));
				?>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="right">
		<input class="syncDone" vaule=1 type="hidden"></input>
		<div class="title">Videos to be synchronized <span class="text-error videoListInfo"></span></div>
		<div class="videoList"></div>
	</div>
	<div style="clear:both"></div>
	<div class="title" style="margin:20px 0;border:1px silver solid;border-width:1px 0;padding:10px;font-weight:bold;color:gray">Synchronization Results
		<div class="btn-small btn btn-success refresh">Refresh</div>
	</div>
	<div class="result" style="position:relative">
		<input class="datasetId" type="hidden" value=""></input>
		<div class="title" style="background-color:white;position:absolute;top:0;right:0;width:700px;z-index:2;border-bottom:1px silver solid;padding:5px 0;;">2. Click each video to confirm results pairwisely.</div>
		<div class="globalResultSimple" style="position:absolute;top:0;right:0;;width:700px;height:580px;z-index:1;padding-top:20px;overflow:auto;border-radius:5px;">
			<?php $this->widget("GlobalSyncWidget",array(
				"id" => "globalSyncSimple",
		));?>
		</div>
		<div class="resultDetail" style="margin:0 710px 0 0;min-height:600px;background-color:white;border-radius:5px;">
			<div class="line title">Synchronization Results for <span class="datasetname text-info"></span>
			</div>
			<div class="line">1. Select a synchronized video group:</div>
			<div class="clusterList"></div>
			<div style="clear:both"></div>
			
			<div class="videoList" style="float:left;width:250px;height:150px;overflow:auto;">
				<?php $this->widget("DatasetVideoWidget",array(
					"id" => "datasetVideoForRefine",

				));?>
			</div>
			<div class="refine" style="margin:0 0 0 250px;min-height:150px;">
				<div class="line">
					Selected <span class="text-warning videoNum">0</span> Videos.
					<div class="btn btn-small btn-primary addVideos">Add Selected Videos to toggled Group</div>
					<span class="info text-error"></span>
				</div>
			</div>
			<div class="line title">3. Refine Result for <span class="text-info clusterName"></span></div>
			<div class="refine" style="">
				<input class="done" type="hidden" value=1></input>
				
				<div class="line">
					<div class="btn btn-info refineResult r1">Refine Based on Confirmed Pairs</div>
					<!--
					<div class="btn btn-info refineResult r2">Refine Based on Confirmed and confident Pairs</div>
					-->
					<div class="refineProgress">
					<?php 
						$this->widget("ProgressWidget",array(
							"id" => "RefineProgress",
							"noMessage" => false,
							"doneCall" => "#cAudioSync > div.result > div.resultDetail > div.refine > input.done"
						));
					?>
					</div>
					<span class="info text-error"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="title" style="padding:10px;">
		<a class="btn btn-primary watch">Watch All Videos with Global Timeline</a>
		<div class="btn back">Back to Anaysis Pipeline</div>
	</div>
	<div class="globalResult">
		<!--<iframe id="globalResultIframe" name="globalResultIframe" frameborder=0 scrolling="no" onload="resizeIframe(this)" style="width:100%;margin:0;height:100%"></iframe>-->
		<iframe id="globalResultIframe" name="globalResultIframe" frameborder=0 style="width:100%;margin:0;height:2000px"></iframe>
	</div>
	<script type="text/javascript">
	function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
	</script>
</div>
