
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
	#cNewCollection{
		width:1100px;
		margin:30px auto;
		background-color:white;
		min-height:500px;
	}#cNewCollection input{margin:0}
	#cNewCollection > div.title{
		padding:10px;
		font-weight:bold;
		font-size:1.1em;
		color:gray;
		border-bottom:1px silver solid;
		margin-bottom:10px;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cNewCollection > div.collectionList{
		height:150px;
		background-color:rgb(230,230,230);
		overflow-x:auto;
		margin:0 20px;
	}
	#cNewCollection > div.newCollection{

	}
	#cNewCollection > div.newCollection > div.left{
		float:left;
		width:470px;
		padding-left:30px;
		padding-top:30px;
	}
	#cNewCollection > div.newCollection > div.left div.info{
		padding:5px 0;

	}
	#cNewCollection > div.newCollection > div.left > div.ctr{
		border-top:1px silver solid;
		margin-top:10px;
		padding:10px;
	}
	#cNewCollection > div.newCollection > div.right{
		margin:0 0 0 500px;
		min-height:500px;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList{
		height:300px;
		overflow:auto;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList > div.block{
		padding:10px;
		border-bottom:1px silver solid;
		border-left:1px silver solid;
	}
	#cNewCollection > div.newCollection > div.right > div.right > div.videoList > div.block > div.imgs{
		color:gray;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList > div.block > div.imgs > img{
		max-height:60px;max-width:80px;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList > div.block.dataset > div.imgs > img{
		max-height:100px;max-width:150px;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList > div.block > div.blockType{
		padding-bottom:5px;
	}
	#cNewCollection > div.newCollection > div.right > div.videoList > div.block > div.videotitle{
		padding:5px;
		font-weight:bold;
	}
	#cNewCollection > div.newCollection > div.right > div.title{
		color:gray;
		font-weight:bold;
		text-align:center;
		padding:5px;
		border-bottom:1px silver solid;
	}
	#cNewCollection > div.newCollection > div.left > div.ctr > div.line{
		padding:5px 0;
		line-height:40px;
	}
	#cNewCollection  div.searchVideo > div.guessList,
	#cNewCollection  div.searchDataset > div.guessList{
		padding:5px;
		
	}
	#cNewCollection div.searchVideo,#cNewCollection div.searchDataset{
		position:relative;
	}

	#cNewCollection  div.searchVideo > div.guessList > div.block,
	#cNewCollection  div.searchDataset > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cNewCollection  div.searchVideo > div.guessList > div.block:hover,
	#cNewCollection  div.searchDataset > div.guessList > div.block:hover{
		color:gray
	}
	#cNewCollection  div.searchVideo > div.dismissGuess,
	#cNewCollection  div.searchDataset > div.dismissGuess{
		position:absolute;
		top:90px;
		right:20px;
	}

</style>
<script type="text/javascript">
	var thisVideoNames = new Array();//each time the video name list that used to upload
	function beforeUpload()
	{
		$("#cNewCollection > div.newCollection > div.left > div.uploadVideo > span.info").html("");
		$("#cNewCollection > div.newCollection > div.left > div.preprocessing").hide();
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
		$("#cNewCollection > div.newCollection > div.left > div.uploadVideo > span.info").html("Upload "+data.files.length+" files Success");
		$("#cNewCollection > div.newCollection > div.left > div.preprocessing").show();
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
		$("#cNewCollection > div.newCollection > div.left > div.uploadVideo > span.info").html(str);
	}
	// load video into database, may trigger process
	function loadVideo(urls)
	{
		
		var data = {};
		data.urls = urls;
		// put the video name into search input, so that after it is in the database, it can be used for person detection
		
		//alert(url);
		//$("#cAudioSync > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("<div class='wrapLoading'><div class='loading'></div></div>");
		$("#cNewCollection > div.newCollection > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("posting request...");
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
					$("#cNewCollection > div.newCollection > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Loading video...");
				}
				else
				{
					$("#cNewCollection > div.newCollection > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Video List");
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
	cw.ech("#cNewCollection > div.newCollection > div.left > div.preprocessing > input.importDone",function(){
		$("#cNewCollection > div.newCollection > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Video List");
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
	//dismissguess
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
		if($.trim(data.videoname) == "")
		{
			return;
		}
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
		//set it
		$(this).parent().parent().children("div.add").trigger(cw.ectype);
	});
	//search video to add
	cw.ec("#cNewCollection > div.newCollection > div.left > div.searchVideo > div.add",function(){
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
		$("#cNewCollection > div.newCollection > div.right > div.title > span.videoListInfo").html('<div class="loading"></div>');
		cw.post(cw.url+"getVideosInfo",data,function(result){
			$("#cNewCollection > div.newCollection > div.right > div.title > span.videoListInfo").html("");
			if(result.status == 0)
			{
				for(var i =0;i<result.videos.length;++i)
				{
					var thisCount = $("#cNewCollection > div.newCollection > div.right > div.videoList > div.block").length+1;
					$("#cNewCollection > div.newCollection > div.right > div.videoList").append(makeVideoBlock(result.videos[i],thisCount));
				}
				calCurStat();
			}
		});
	}
	function makeVideoBlock(video,count){
		//var videoname = urlencode();
		var temp = $('<div class="block video">'+
			'<div class="close delete">&times</div>'+
			'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
			'<input class="videoId" type="hidden" value="'+video.videoId+'"></input>'+
			'<div class="blockType">'+
				'<span class="label label-info">Video</span>'+
			'</div>'+
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
	cw.ec("#cNewCollection > div.newCollection > div.right > div.videoList > div.block > div.delete",function(){
		$(this).parent().remove();
		changeVideoCount();
		calCurStat();
	});
	function calCurStat()
	{
		//get the stat of the current training bucket number to training control
		var count=0;
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block.dataset").each(function(){
			//var labelType = parseInt($(this).children("input.labelType").val());
			var videoCount = parseInt($(this).children("input.videoCount").val());
			count+=videoCount;
		});
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block.video").each(function(){
			//var labelType = parseInt($(this).children("input.labelType").val());
			count+=1;
		});
		//var total = count[0]+count[1]+count[2];

		$("#cNewCollection > div.newCollection > div.left > div.ctr > div.line > span.videoCount").html(count);
	}
	function changeVideoCount()
	{
		var count=0;
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block > div.videotitle > span.count").each(function(){
			count+=1;
			$(this).html(count);
		});
	}
	function inVideoList(videoname)
	{
		var inIt = false;
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block > input.videoname").each(function(){
			if($(this).val() == videoname)
			{
				inIt = true;
				return false;
			}
		});
		return inIt;
	}
	function getBucket()
	{
		var bucket = new Array();
		// get training bucket
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block.dataset").each(function(){
			var temp = {};
			temp['type'] = "dataset";
			temp['datasetId'] = $(this).children("input.datasetId").val();
			temp['datasetName'] = $(this).children("input.datasetname").val();
			bucket.push(temp);
		});
		$("#cNewCollection > div.newCollection > div.right > div.videoList > div.block.video").each(function(){
			var temp = {};
			temp['type'] = "video";
			temp['videoId'] = $(this).children("input.videoId").val();
			bucket.push(temp);
		});
		return bucket;
	}
	//confirm create collection
	cw.ec("#cNewCollection > div.newCollection > div.left > div.ctr > div.line > div.new",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.datasetName = $.trim($(this).parent().children("input.datasetName").val());
		data.datasetNote = $.trim($(this).parent().children("input.datasetNote").val());
		if(data.datasetName == "")
		{
			$(this).parent().children("span.info").html("Collection Name is needed");
			return;
		}
		if(data.datasetName.indexOf(" ")>=0)// check wired character.
		{
			$(this).parent().children("span.info").html("Collection Name cannot have spaces");
			return;
		}
		data.bucket = getBucket();
		if(data.bucket.length == 0)
		{
			$(this).parent().children("span.info").html("Bucket Can't be empty");
			return;
		}
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		$(this).addClass("disabled");
		cw.post(cw.url+"addDataset",data,function(result){
			$(this).parent().children("span.info").html("");
			$(this).removeClass("disabled");
			if(result.status==0)
			{
				$(this).parent().children("span.info").html("Success! Going back to Main Page");
				$(this).parent().children("input.datasetName").val("");
				$(this).parent().children("input.datasetNote").val("");
				//$("#datasetWidget > input.userId").change();
				//back to mainPage
				window.open("<?php echo Yii::app()->baseUrl?>/index.php/application?datasetId="+result.datasetId,"_self");
			}else if(result.status == 1)
			{
				$(this).parent().children("span.info").html("Collection name exists. Please use another.");
			}
		},$(this));
	});

</script>
<div id="cNewCollection">
	<div class="title">New Collection</div>
	<div class="newCollection">
		<div class="left">
			<div class="uploadVideo" style="">
				
				<?php $this->widget("UploadMultiWidget",array(
					"success" => "videoUploadOk", //what to do after successful upload
					"error" => "videoUploadError",
					"maxSize" => "1024*1024*500",
					"types" => "mp4",
					"buttonName" => "Upload New Videos",
					"filename" => "newVideoUploaded",
					"id" => "forNewVideoUpload",
					"beforeSubmit" => "beforeUpload",
					"htmlAfterButton" => '<span class="text-error">Max file size: 500MB; mp4 only</span>',
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
							"doneCall" => "#cNewCollection > div.newCollection > div.left > div.preprocessing > input.importDone",
							"noMessage" => true,
						));
					?>
					</div>
				</div>
			</div>
			<div class="searchVideo" style="padding:5px 0;padding-top:20px;">
				<div class="info">Or you can search for already uploaded videos:</div>
				<input class="input-medium videoname" type="text" placeholder="Video Name"></input>
				<div class="btn btn-small btn-info search">Search by Video Name</div>
				<div class="btn btn-small btn-success add">Add to Bucket</div>
				<span class="text-error info"></span>
				<br/>
				<div class="dismissGuess close" style="display:none">&times;</div>
				<div class="guessList" style="max-height:200px;overflow:auto"></div>
			</div>
			<div class="ctr">
				<div class="line">
					Total Videos: <span class="videoCount text-info">0</span>
					<br/>
					Collection Name: 
					<input class="datasetName input-medium" type="text" placeholder="collection name"></input>
					<br/>
					Note: 
					<input class="datasetNote input-medium" type="text" placeholder="note(optional)"></input>
					<br/>
					<br/>
					<div class="btn btn-primary new">Create Collection</div>
					<a class="btn btn back" href="<?php echo Yii::app()->baseUrl?>/" target="_self">Cancel</a>
					<span class="text-error info"></span>
				</div>
			</div>
		</div>
		<div class="right">
			<div class="title">Bucket
				<span class="videoListInfo text-error"></span>
			</div>
			<div class="videoList"></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>