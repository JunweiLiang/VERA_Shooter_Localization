
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
	#cWell{
		position:relative;
		padding:5px;
		padding-bottom:50px;
	}
	#cWell input{margin:0}
	#cWell div.searchVideo,#cWell div.searchDataset{
		position:relative;
	}
	#cWell div.searchVideo > div.guessList,
	#cWell div.searchDataset > div.guessList{
		padding:5px;
	}
	#cWell div.searchVideo > div.guessList > div.block,
	#cWell div.searchDataset > div.guessList > div.block{
		padding:5px;
		cursor:pointer;
		border-bottom:1px silver solid;
	}
	#cWell div.searchVideo > div.guessList > div.block:hover,
	#cWell div.searchDataset > div.guessList > div.block:hover{
		color:gray
	}
	#cWell  div.searchVideo > div.dismissGuess,
	#cWell  div.searchDataset > div.dismissGuess{
		position:absolute;
		top:90px;
		right:20px;
	}
	#cWell div.display > div.block > div.ctr{
		text-align:center;
		padding:10px;
		line-height:40px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	#cWell div.display > div.block > div.ctr > i{
		cursor:pointer;
	}
	#cWell > div.left{
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
	#cWell > div.right{
		margin:0 0 0 40%;
		padding-left:10px;
	}
	#cWell video{
		width:100%;
	}
	#cWell div.title{
		text-align:center;
	}
	#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > div.progressForImportVideo{
		width:200px;
	}
	#cWell > div.right div.title{
		font-weight:bold;
		color:gray;
		padding:5px;
		border-bottom:1px silver solid;
		margin-bottom:5px;
	}
	#cWell > div.right > div.videoList{
		
		max-height:500px;
		overflow:auto;
	}
	#cWell > div.right > div.videoList > div.block{
		padding:10px;
		border-bottom:1px silver solid;
	}
	#cWell > div.right > div.videoList > div.block > div.imgs{
		color:gray;
	}
	#cWell > div.right > div.videoList > div.block > div.imgs > img{
		max-height:60px;max-width:100px;
	}
	#cWell > div.right > div.videoList > div.block.dataset > div.imgs > img{
		max-height:100px;max-width:150px;
	}
	#cWell > div.right > div.videoList > div.block > div.blockType{
		padding-bottom:5px;
	}
	#cWell > div.right > div.videoList > div.block > div.videotitle{
		padding:5px;
		font-weight:bold;
	}
	#cWell > div.right > div.ctr{
		margin:10px;
		padding:10px;
		background-color:white;
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#cWell > div.right > div.ctr > div.line{
		padding:10px;
	}
	#cWell > div.left{
		max-height:800px;
		overflow:hidden;
	}
	#cWell #runListModal > div.modal-body > div.block{
		padding:10px;
		cursor:pointer;
		font-weight:bold;
		word-break:break-all;
	}#cWell #runListModal > div.modal-body > div.block:hover{
		background-color:rgb(220,220,220);
	}
	#cWell > div.left > div.session{
		border-bottom:1px silver solid;margin-bottom:10px;padding-bottom:10px;
	}
	#cWell > div.left > div > div.title{
		font-size:1.1em;
		font-weight:bold;
		text-align:left;
		padding:0;
		margin:0;
		padding-bottom:5px;
	}
</style>
<script type="text/javascript">

cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
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
	});
	cw.ec("div.searchDataset > div.searchDataset",function(){
		//search video
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.datasetname = $(this).parent().children("input.datasetname").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/searchDatasets",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			$(this).parent().children("div.guessList").html('');
			if(result.datasetList.length == 0)
			{
				$(this).parent().children("div.guessList").html('<div class="wrapLoading">No match</div>');
			}
			$(this).parent().children("div.dismissGuess").show();
			for(var i =0;i<result.datasetList.length;++i)
			{
				$(this).parent().children("div.guessList").append('<div class="block">'+
					'<input class="datasetname" type="hidden" value="'+result.datasetList[i].datasetname+'"></input>'+
					result.datasetList[i].datasetname+
				'</div>');
			}
		},$(this));
	});
	//click any guess
	cw.ec("div.searchDataset > div.guessList > div.block",function(){
		var datasetname = $(this).children("input.datasetname").val();
		//alert(videoname);
		$(this).parent().parent().children("input.datasetname").val(datasetname);
	});
	var thisVideoNames = new Array();//each time the video name list that used to upload
	function beforeUpload()
	{
		$("#cWell > div.left > div.uploadVideo > span.info").html("");
		$("#cWell > div.left > div.preprocessing").hide();
		$("#cWell > div.left > div.processing").hide();
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
		//$("#cWell > div.left > div.uploadVideo > input.newvideoUrl").val(data.url);
		//alert(data.files.length);
		$("#cWell > div.left > div.uploadVideo > span.info").html("Upload "+data.files.length+" files Success");
		$("#cWell > div.left > div.preprocessing").show();
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
		$("#cWell > div.left > div.uploadVideo > span.info").html(str);
	}
	// load video into database, may trigger process
	function loadVideo(urls)
	{
		
		var data = {};
		data.urls = urls;
		// put the video name into search input, so that after it is in the database, it can be used for person detection
		
		//alert(url);
		//$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("<div class='wrapLoading'><div class='loading'></div></div>");
		$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("posting request...");
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/importVideos",data,function(result){
			if(result.status == 0)
			{
				//display counting results
				/*
				$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html(
					result.count.addToDatabase+" added to database directly, since related path and original path exists;<br/>"+
					result.count.ignore+" are ignored since original not exists;<br/>"+
					result.count.furtherProcess+" are posted to python for futher process<br/>"+
					"python will need 5 minutes to process a 40-minute video"
				);*/
				if(result.count.furtherProcess != 0)
				{
					$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Loading video...");
				}
				else
				{
					$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Training Bucket");
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
	cw.ech("#cWell > div.left > div.preprocessing > input.importDone",function(){
		$("#cWell > div.left > div.preprocessing > div.loadVideoToDatabase > span.info").html("Video loaded and added to Training Bucket");
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
	cw.ec("#cWell > div.left > div.searchVideo > div.add",function(){
		var videoname = $(this).parent().children("input.videoname").val();
		addVideosToList([videoname]);
	});
	// add dataset to bucket
	cw.ec("#cWell > div.left > div.searchDataset > div.add",function(){
		var datasetname = $(this).parent().children("input.datasetname").val();
		addDatasetToList(datasetname);
	});
	function addDatasetToList(datasetname)
	{
		//for each name, check whether already in page, then ask for video info, then add to list
		
		if(inDatasetList(datasetname))
		{
			return;
		}

		var data = {};
		data.datasetname = datasetname;
		data.labelType = $("#cWell > div.left > div.searchDataset > input.datasetLabel:checked").val();
		// ask for info and then add to list
		$("#cWell > div.right > div.title > span.videoListInfo").html('<div class="loading"></div>');
		cw.post(cw.url+"getDatasetInfo",data,function(result){
			$("#cWell > div.right > div.title > span.videoListInfo").html("");
			if(result.status == 0)
			{

				// get the label of the video , currently selected
				var labelType = parseInt($("#cWell > div.left > div.searchDataset > input.datasetLabel:checked").val());// 1 for pos, 0 for neg, 2 for WELL
				//if((result.dataset.hasMeta != 1) && (labelType == 2))
				if(false)// whatever
				{
					alert("This dataset has no metadata for webly learning!");
				}
				else
				{
					var thisCount = $("#cWell > div.right > div.videoList > div.block").length+1;
					$("#cWell > div.right > div.videoList").append(makeDatasetBlock(result.dataset,thisCount,labelType));
					calCurStat();
				}
			}
			else if(result.status == -1)
			{
				$("#cWell > div.right > div.title > span.videoListInfo").html("Dataset not exists");
			}
		});
	}
	function inDatasetList(datasetname)
	{
		var inIt = false;
		$("#cWell > div.right > div.videoList > div.block.dataset > input.datasetname").each(function(){
			if($(this).val() == datasetname)
			{
				inIt = true;
				return false;
			}
		});
		return inIt;
	}
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
		$("#cWell > div.right > div.title > span.videoListInfo").html('<div class="loading"></div>');
		cw.post(cw.url+"getVideosInfo",data,function(result){
			$("#cWell > div.right > div.title > span.videoListInfo").html("");
			if(result.status == 0)
			{
				// get the label of the video , currently selected
				var labelType = $("#cWell > div.left > div.uploadVideo > input.videoLabel:checked").val();// 1 for pos, 0 for neg, 2 for WELL
				for(var i =0;i<result.videos.length;++i)
				{
					var thisCount = $("#cWell > div.right > div.videoList > div.block").length+1;
					$("#cWell > div.right > div.videoList").append(makeVideoBlock(result.videos[i],thisCount,labelType));
				}
				//$("#cWell > div.right > div.ctr > div.line > span.videoCount").html($("#cWell > div.right > div.videoList > div.block").length);
				calCurStat();
			}
			else if(result.status == -1)
			{
				$("#cWell > div.right > div.title > span.videoListInfo").html("Video not exists");
			}
		});
	}
	function makeDatasetBlock(dataset,count,labelType){
		//var videoname = urlencode();
		//added the label indicating this is the positive sample or negative
		var temp = $('<div class="block dataset">'+
			'<div class="close delete">&times</div>'+
			'<input class="labelType" type="hidden" value="'+labelType+'"></input>'+
			'<input class="videoCount" type="hidden" value="'+dataset.videoCount+'"></input>'+
			'<input class="datasetId" type="hidden" value="'+dataset.datasetId+'"></input>'+
			'<input class="datasetname" type="hidden" value="'+dataset.datasetname+'"></input>'+
			'<div class="blockType">'+
				'<span class="label label-warning">Dataset</span>'+
				" Videos: "+dataset.videoCount+
			'</div>'+
			'<div class="imgs"><div class="wrapLoadng">No Preview Images Available</div></div>'+
			'<div class="videotitle">'+
				'<span class="count">'+count+"</span>. "+dataset.datasetname+
				' <a class="watch" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?datasetId='+dataset.datasetId+'"><i class="icon-eye-open"></i></a>'+
				' '+makeLabelHtml(labelType)+
			'</div>'+
			
			'</div>');
		if(dataset.previews.length > 0)
		{
			temp.find("div.imgs").html("");
			for(var i =0;i<dataset.previews.length;++i)
			{
				temp.find("div.imgs").append('<img class="videoImg" data-videoname="'+dataset.previews[i]['videoname']+'" src="'+dataset.previews[i]['img']+'"></div>');
			}
		}
		return temp;
	}
	// for color, label: success(green) for pos, important(red), inverse(black) for WELL
	//             blockType, video for info(blue), dataset for warning (yellow)
	function makeLabelHtml(labelType)
	{
		labelType = parseInt(labelType);
		var typeColor = labelType==1?"success":(labelType==0?"important":"inverse");
		var typeStr = labelType==1?"Positive Sample":(labelType==0?"Negative Sample":"Webly Learning Decide");
		return '<span class="badge badge-'+typeColor+'">'+typeStr+'</span> ';
	}
	function makeVideoBlock(video,count,labelType){
		//var videoname = urlencode();
		//added the label indicating this is the positive sample or negative
		var temp = $('<div class="block video">'+
			'<div class="close delete">&times</div>'+
			'<input class="labelType" type="hidden" value="'+labelType+'"></input>'+
			'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>'+
			'<input class="videoId" type="hidden" value="'+video.videoId+'"></input>'+
			'<div class="blockType">'+
				'<span class="label label-info">Video</span>'+
			'</div>'+
			'<div class="imgs"><div class="wrapLoadng">No Preview Images Available</div></div>'+
			'<div class="videotitle">'+
				'<span class="count">'+count+"</span>. "+video.videoname+
				' <a class="watch" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname='+video.videoname+'"><i class="icon-eye-open"></i></a>'+
				' '+makeLabelHtml(labelType)+
			'</div>'+
			'</div>');
		if(video.hasImgs == 1)
		{
			temp.find("div.imgs").html("");
			for(var i =0;i<video.imgCount;++i)
			{
				temp.find("div.imgs").append('<img class="videoImg" data-videoname="'+video.videoname+'" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname+"_"+i+'.png"></img>');
			}
		}
		return temp;
	}
	//delete one
	cw.ec("#cWell > div.right > div.videoList > div.block > div.delete",function(){
		$(this).parent().remove();
		changeVideoCount();
		calCurStat();
	});
	function changeVideoCount()
	{
		var count=0;
		$("#cWell > div.right > div.videoList > div.block > div.videotitle > span.count").each(function(){
			count+=1;
			$(this).html(count);
		});
	}
	function inVideoList(videoname)
	{
		var inIt = false;
		$("#cWell > div.right > div.videoList > div.block > input.videoname").each(function(){
			if($(this).val() == videoname)
			{
				inIt = true;
				return false;
			}
		});
		return inIt;
	}
	

	
function calCurStat()
{
	//get the stat of the current training bucket number to training control
	var count = {
		0:0,//neg
		1:0, // pos
		2:0 //well
	};
	$("#cWell > div.right > div.videoList > div.block.dataset").each(function(){
		var labelType = parseInt($(this).children("input.labelType").val());
		var videoCount = parseInt($(this).children("input.videoCount").val());
		count[labelType]+=videoCount;
	});
	$("#cWell > div.right > div.videoList > div.block.video").each(function(){
		var labelType = parseInt($(this).children("input.labelType").val());
		count[labelType]+=1;
	});
	var total = count[0]+count[1]+count[2];

	$("#cWell > div.right > div.ctr > div.line > span.videoCount").html(total)
		.parent().children("span.videoCountW").html(count[2])
		.end().children("span.videoCountP").html(count[1])
		.end().children("span.videoCountN").html(count[0]);
}
// click searching for video
cw.ec("#cWell > div.left > div.webSearch > div.search2add",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data ={};
	data.search = $(this).parent().children("input.concept").val();
	//alert(data.search);
	if(data.search == "")
	{
		return;
	}
	// set the detector name
	$("#cWell > div.right > div.ctr > div.line > input.detectorName").val(data.search);
	//return;
	$(this).addClass("disabled");
	$("#cWell > div.left > div.webSearch > span.info").html("<div class='loading'></div>");
	cw.post(cw.url+"searchWebVideos",data,function(result){
		$(this).removeClass("disabled");
		$("#cWell > div.left > div.webSearch > span.info").html("");
		if(result.status == 0)
		{
			if(result.hasResult == 1)
			{
				if(inDatasetList(result.dataset.datasetname))
				{
					return;
				}
				var labelType = 1;
				var thisCount = $("#cWell > div.right > div.videoList > div.block").length+1;
				$("#cWell > div.right > div.videoList").append(makeDatasetBlock(result.dataset,thisCount,labelType));
				calCurStat();
			}
			else
			{
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#searchProgress > input.processId").val(result.processId);
					$("#searchProgress > input.showing").val(1).change();
					$("#searchProgress > input.updating").val(1).change();
					//save the search content
					var search = $(this).parent().children("input.concept").val();
					$("#cWell > div.left > div.webSearch > input.searchDone").val(search);
				}
			}
		}
	},$(this));
});
// search and downloaded web video, 

cw.ech("#cWell > div.left > div.webSearch > input.searchDone",function(){
	var data = {};
	data.search = $(this).val();
	$("#cWell > div.right > div.title > span.videoListInfo").html('<div class="loading"></div>');
	// go ask for what the dataset info of this searching
	cw.post(cw.url+"getWebSearchInfo",data,function(result){
		$("#cWell > div.right > div.title > span.videoListInfo").html("");
		if(result.exists == 1)
		{
			if(inDatasetList(result.dataset.datasetname))
			{
				return;
			}
			//var labelType = 2; //WELL
			var labelType = 1; //pos
			var thisCount = $("#cWell > div.right > div.videoList > div.block").length+1;
			$("#cWell > div.right > div.videoList").append(makeDatasetBlock(result.dataset,thisCount,labelType));
			calCurStat();
		}
	});
});
function getBucket()
{
	var bucket = new Array();
	// get training bucket
	$("#cWell > div.right > div.videoList > div.block.dataset").each(function(){
		var temp = {};
		temp['labelType'] = parseInt($(this).children("input.labelType").val());
		temp['type'] = "dataset";
		temp['datasetId'] = $(this).children("input.datasetId").val();
		temp['datasetName'] = $(this).children("input.datasetname").val();
		bucket.push(temp);
	});
	$("#cWell > div.right > div.videoList > div.block.video").each(function(){
		var temp = {};
		temp['labelType'] = parseInt($(this).children("input.labelType").val());
		temp['type'] = "video";
		temp['videoId'] = $(this).children("input.videoId").val();
		bucket.push(temp);
	});
	return bucket;
}
// start training!
cw.ec("#cWell > div.right > div.ctr > div.line > div.run",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.detectorName = $(this).parent().parent().find("div.line > input.detectorName").val();
	if(data.detectorName == "")
	{
		$(this).parent().children("span.info").html("Please Enter Detector for?");
		return;
	}
	data.note = $(this).parent().parent().find("div.line > input.note").val();
	if(data.note == "")
	{
		$(this).parent().children("span.info").html("Please Enter Detector Name");
		return;
	}
	data.bucket = getBucket();
	if(data.bucket.length == 0)
	{
		$(this).parent().children("span.info").html("Training Bucket Can't be empty");
		return;
	}
	$(this).parent().children("span.info").html("<div class='loading'></div>");
	$(this).addClass("disabled");
	cw.post(cw.url+"trainWell",data,function(result){
		$(this).removeClass("disabled");
		$(this).parent().children("span.info").html("");
		if(result.status == 0)
		{
			//refresh the mulit progress listener
			//$("#detectors > input.userId").change();
			if((result.processStatus ==0) && (result.processId != null))
			{
				//start monitoring the process
				$("#wellTrainProgress > input.processId").val(result.processId);
				$("#wellTrainProgress > input.showing").val(1).change();
				$("#wellTrainProgress > input.updating").val(1).change();
			}
			else
			{
				alert(result.processError);
			}
		}
		else if(result.status == -1)
		{
			$(this).parent().children("span.info").html("This Training Bucket is already used by detector: '"+result.detectorName+"'");
		}
	},$(this));
});
//get the test run list
cw.ech("#testRuns > input.userId",function(){
	var data = {};
	data.userId = $(this).val();
	$("#testRuns > div.runList").html('<div class="wrapLoading"><div class="loading"></div></div>');
	cw.post(cw.url+"getWellTestRunList",data,function(result){
		$("#testRuns > div.runList").html("");
		if(result.status == 0)
		{
			for(var i=0;i<result.runList.length;++i)
			{
				var run = result.runList[i];
				$("#testRuns > div.runList").append('<div class="block">'+
					'<input class="runId" type="hidden" value="'+run.id+'"></input>'+
					'<input class="runName" type="hidden" value="'+run.runName+'"></input>'+
					'Query Name: '+'<span class="text-error">'+run.runName+'</span> <span class="muted">'+run.createTime+'</span>'+
					'<div class="ctr">'+
						'<div class="btn btn-small btn-info check">see result</div> '+
						"<div class='close delete'>&times;</div>"+
					'</div>'+
				'</div>');
			}
		}
	});
});
//check detector
cw.ec("#testRuns > div.runList > div.block > div.ctr > div.check",function(){
	$("#testRunModal > input.runId").val($(this).parent().parent().children("input.runId").val()).change();
});

//get the trained detector list
cw.ech("#detectors > input.userId",function(){
	//alert("ha");
	var data = {};
	data.userId = $(this).val();
	$("#detectors > div.detectorList").html('<div class="wrapLoading"><div class="loading"></div></div>');
	cw.post(cw.url+"getWellDetectors",data,function(result){
		$("#detectors > div.detectorList").html("");
		if(result.status == 0)
		{
			for(var i=0;i<result.detectorList.length;++i)
			{
				var detector = result.detectorList[i];
				$("#detectors > div.detectorList").append('<div class="block" title="'+detector.modelPath+'">'+
					'<input class="detectorId" type="hidden" value="'+detector.id+'"></input>'+
					'<input class="detectorName" type="hidden" value="'+detector.name+'"></input>'+
					'<input class="note" type="hidden" value="'+detector.note+'"></input>'+
					'<input class="testRunId" type="hidden" value="'+detector.testRunId+'"></input>'+
					'detector for: '+'<span class="text-error">'+detector.name+' ('+detector.videoNum+')</span> <span class="muted">'+baseName(detector.modelPath)+'</span>'+
					'</span> <span class="muted">'+detector.note+'</span>'+
					'<div class="ctr">'+
						'<div class="btn btn-small btn-info check">check detector</div> '+
						'<div class="btn btn-small btn-success test">test on bucket</div> '+
						"<div class='close delete'>&times;</div>"+
					'</div>'+
				'</div>');
			}
		}
	});
});
//check detector
cw.ec("#detectors > div.detectorList > div.block > div.ctr > div.check",function(){
	$("#testRunModal > input.runId").val($(this).parent().parent().children("input.testRunId").val()).change();
});
//get test run results
cw.ech("#testRunModal > input.runId",function(){
	var data = {};
	data.runId = $(this).val();
	$("#testRunModal > div.modal-body > div.result").html('<div class="wrapLoading"><div class="loading"></div></div>');
	$("#testRunModal").modal("show");
	cw.post(cw.url+"getWellTestRun",data,function(result){
		$("#testRunModal > div.modal-body > div.result").html("");
		if(result.status == 0)
		{
			for(var i in result.detectors)
			{
				var detector = result.detectors[i];
				$("#testRunModal > div.modal-body > div.result").append(makeRunResult(detector));
			}
		}
	});
});
//labeling the result
cw.ec("#testRunModal > div.modal-body > div.result > div.block > div.fullList > div.oneResult > div.labeling > div.btn",function(){
	$(this).parent().children("div.btn").removeClass("btn-info");
	if($(this).hasClass("wrong") || $(this).hasClass("correct"))
	{
		$(this).addClass("btn-info");
	}
	//send to save
	var data = {};
	data.label = $(this).data("label");
	data.testScoreId = $(this).parent().parent().children("input.testScoreId").val();
	//alert(data.label);
	$(this).parent().children("span.info").html('<div class="loading"></div>');
	cw.post(cw.url+"wellLabelTestScore",data,function(result){
		if(result.status == 0)
		{
			$(this).parent().children("span.info").html('');
			calAP($(this).parent().parent().parent());
		}
	},$(this));

});
//calculate AP based on labeling result
function calAP(fullList)
{
	var data = new Array();
	$(fullList).find("div.oneResult > div.labeling > div.btn-info").each(function(){
		var temp = {};
		temp.score = parseFloat($(this).parent().parent().children("input.score").val());
		if($(this).hasClass("correct"))
		{
			temp.label = 1;
		}
		else
		{
			temp.label = -1;
		}
		data.push(temp);
	});
	var ap = cw.calculateAP(data);
	$(fullList).find("div.ap > span.ap").html(ap);
}
// get a full result of a runid and a detectorId
cw.ec("#testRunModal > div.modal-body > div.result > div.block > div.showFull",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.detectorId = $(this).parent().children("input.detectorId").val();
	data.runId = $(this).parent().children("input.runId").val();
	var $listDiv = $(this).parent().children("div.fullList");
	if($listDiv.html() != "")
	{
		if($(this).hasClass("hideFull"))
		{
			$listDiv.hide();
			$(this).removeClass("hideFull").html("show full list (top30)");
		}
		else
		{
			$listDiv.show();
			$(this).addClass("hideFull").html("hide list");
		}
	}
	else
	{
		$(this).addClass("disabled");
		$listDiv.html('<div class="wrapLoading"><div class="loading"></div></div>');
		cw.post(cw.url+"getWellTestRunFull",data,function(result){
			$(this).removeClass("disabled");
			var $listDiv = $(this).parent().children("div.fullList");
			$listDiv.html("");
			if(result.status == 0)
			{
				//Average precision Div
				$listDiv.append("<div class='ap'> AP: <span class='text-info ap'>0.0</span></div>");
				$(this).addClass("hideFull").html("hide full list");
				var count=0;
				for(var i in result.ranklist)
				{
					count+=1;
					var one = result.ranklist[i];
					var temp = $('<div class="oneResult">'+
						'<input class="testScoreId" type="hidden" value="'+one.testScoreId+'"></input>'+
						'<input class="score" type="hidden" value="'+one.score+'"></input>'+
						'<div class="preview">No preview img available</div>'+
						'<div class="score">('+count+') '+one.score+'</div>'+
						//for labeling
						'<div class="labeling">'+
							'<div class="btn btn-small correct" data-label=1><i class="icon icon-ok"></i></div> '+
							'<div class="btn btn-small wrong" data-label=-1><i class="icon icon-remove"></i></div> '+
							'<div class="btn btn-small noLabel" data-label=0>Not Labeled</div> '+
							'<span class="info text-warning"></span>'+
						'</div>'+
					'</div>');
					if(one.hasImgs == 1)
					{
						temp.find("div.preview").html("");
						for(var j =0;j<one.imgCount;++j)
						{
							temp.find("div.preview").append('<img class="videoImg" data-videoname="'+one.videoname+'" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+one.videoname+"_"+j+'.png"></img>');
						}
					}
					if(one.label == 1)
					{
						temp.find("div.labeling > div.correct").addClass("btn-info");
					}else if(one.label == -1)
					{
						temp.find("div.labeling > div.wrong").addClass("btn-info");
					}
					$listDiv.append(temp);				
				}
				calAP($listDiv);
			}
		},$(this));
	}
});
function makeRunResult(detector)
{
	var $temp = $('<div class="block">'+
		'<input class="runId" type="hidden" value="'+detector.runId+'"></input>'+
		'<input class="detectorId" type="hidden" value="'+detector.detectorId+'"></input>'+
		'<div class="detector">'+
			"detecting result for: "+ detector.name+" on "+detector.total+" videos"+
		'</div>'+
		'<div class="pos imgs"></div>'+
		'<div class="margin"> ------------------------------- Margin -------------------------------</div>'+
		'<div class="neg imgs"></div>'+
		'<div class="btn btn-block btn-small btn-info showFull">show full list (top30)</div>'+
		'<div class="fullList"></div>'+
	'</div>');
	for(var i in detector.pos)
	{
		var video = detector.pos[i];
		$temp.children("div.pos").append('<img class="videoImg" data-videoname="'+video.videoname+'" title="'+video.videoname+' score:'+video.score+'" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname+'_3.png"></img>');
	}
	for(var i in detector.neg)
	{
		var video = detector.neg[i];
		$temp.children("div.neg").append('<img class="videoImg" data-videoname="'+video.videoname+'" title="'+video.videoname+' score:'+video.score+'" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname+'_3.png"></img>');
	}
	return $temp;
}
$(document).ready(function(){
	$("#detectors > input.userId").change();
	$("#testRuns > input.userId").change();
});
//assign all img to be shown big
cw.ec("#cWell img",function(){
	//var src = $(this).prop("src");
	//window.open(src,"_blank");
	var videoname = $(this).data("videoname");
	if(videoname != null)
	{
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname="+videoname,"_blank");
	}
});
//test on bucket!!
var testRuning = false;
cw.ec("#detectors > div.detectorList > div.block > div.ctr > div.test",function(){
	/*if($(this).hasClass("disabled"))
	{
		return;
	}*/
	var detectorIds = new Array();
	detectorIds.push($(this).parent().parent().children("input.detectorId").val());
	var bucket = getBucket();
	var runName = $(this).parent().parent().children("input.detectorName").val()+"("+$(this).parent().parent().children("input.note").val()+")";
	runName+=" on";
	//get dataset name and video count
	var countVideo = 0;
	for(var i in bucket)
	{
		if(bucket[i].type == "video")
		{
			countVideo+=1;
		}
		else
		{
			runName+=" "+bucket[i].datasetName;
		}
	}
	runName+=" & "+countVideo+" videos";
	//$(this).addClass("disabled");
	runDetection(runName,bucket,detectorIds,"#cWell > div.right > div.ctr > div.title > span.testRunInfo");
});
function runDetection(runName,bucket,detectorIds,alertGoTo)
{
	if(testRuning)
	{
		$(alertGoTo).html("Can't submit multiple run");
		return;
	}
	var data = {};
	data.runName = runName;
	data.detectorIds = detectorIds;
	data.bucket = bucket;
	if(data.bucket.length == 0)
	{
		$(alertGoTo).html("Bucket can't be empty!");
		return;
	}
	cw.post(cw.url+"wellTest",data,function(result){
		if(result.status == 0)
		{
			if((result.processStatus ==0) && (result.processId != null))
			{
				//start monitoring the process
				$("#wellTestProgress > input.processId").val(result.processId);
				$("#wellTestProgress > input.showing").val(1).change();
				$("#wellTestProgress > input.updating").val(1).change();
			}
			else
			{
				alert(result.processError);
			}
		}
		else if(result.status == -1)
		{
			$(this).html("You have already submitted this run as: "+result.runName);
		}
		else if(result.status == -2)
		{
			$(this).html("Detector not ready yet");
		}
	},$(alertGoTo));
}
//delete detectors
cw.ec("#detectors > div.detectorList > div.block > div.ctr > div.delete",function(){
	var data = {};
	data.detectorId = $(this).parent().parent().children("input.detectorId").val();
	if(!confirm("delete this detector?"))
	{
		return;
	}
	cw.post(cw.url+"deleteWellDetector",data,function(result){

	});
	$(this).parent().parent().remove();
});
cw.ec("#testRuns > div.runList > div.block > div.ctr > div.delete",function(){
	var data = {};
	data.runId = $(this).parent().parent().children("input.runId").val();
	if(!confirm("delete this query?"))
	{
		return;
	}
	cw.post(cw.url+"deleteWellRun",data,function(result){

	});
	$(this).parent().parent().remove();
});
</script>
<style type="text/css">
	#testRunModal > div.modal-body > div.result > div.block > div.fullList{
		background-color:silver;
		padding:0 20px;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.fullList > div.oneResult{
		background-color:white;
		padding:10px;
		border-radius:5px;
		margin:10px 0;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.fullList > div.oneResult > div.preview > img{
		max-height:150px;
		max-width:100px;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.fullList > div.oneResult > div.score{
		color:red;
		font-weight:bold;
		text-align:center;
	}
	#detectors > div.detectorList > div.block,
	#testRuns > div.runList > div.block{
		padding:10px;
		position:relative;
		margin:10px;
		border:1px silver solid;
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
 	   padding-right:120px;
	}
	#detectors > div.detectorList > div.block{
		padding-right:240px;
	}
	#detectors > div.detectorList > div.block > div.ctr,
	#testRuns > div.runList > div.block > div.ctr{
		position:absolute;
		top:5px;right:10px;
		text-align:right;
	}
	#testRunModal > div.modal-body > div.result > div.block{
		padding:10px;margin:10px;
		border-bottom:1px silver solid;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.detector{
		font-weight:bold;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.margin{
		margin:5px;
		padding:5px;
		border:2px black dotted;
		border-width:1px 0;
		text-align:center;
		color:gray;font-weight:bold;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.imgs{
		padding:5px;
	}
	#testRunModal > div.modal-body > div.result > div.block > div.imgs > img{
		max-height:150px;
		max-width:110px;
	}
	#cWell > div.left{
		border:2px solid green
	}
	#cWell > div.left > div.title{
		color:green;
		font-weight:bold;
		padding:5px;
	}
</style>
<div id="cWell">
	<div class="modal hide fade" id="testRunModal" style="width:800px;margin-left:-400px;position:absolute;top:400px;">
		<input class="runId" type="hidden"></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			View
    		</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="result">
			</div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button> 	
		</div>
	</div>
	<div class="left">
		<div class="title">
			Prepare your videos (for training or testing)
		</div>
		<div class="webSearch session">
			<div class="title">1. Ad-hoc Concept Learning from Web Videos</div>
			<input class="concept input-medium" type="text" placeholder="Concept Name"></input>
			<div class="btn btn-small btn-success search2add">Search and Download Web Videos to Bucket</div>
			<input class="searchDone" type="hidden" value=0></input>
			<div class="progressForSearching">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "searchProgress",
						"doneCall" => "#cWell > div.left > div.webSearch > input.searchDone",
						"noMessage" => false,
					));
				?>
			</div>
			<span class="text-error info"></span>
		</div>
		<div class="uploadVideo" style="width:450px;">
			<div class="title">2. Add Your Own Videos</div>
			
			<input name="label" class="videoLabel pos" value=1 type="radio" checked="checked"></input> Positive
			<input name="label" class="videoLabel neg" value=0 type="radio"></input> Negative
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
						"doneCall" => "#cWell > div.left > div.preprocessing > input.importDone",
						"noMessage" => true,
					));
				?>
				</div>
			</div>
		</div>
		<div class="searchVideo session" style="padding:5px 0;">
			<input class="input-medium videoname" placeholder="Search Video" type="text"></input>
			<div class="btn btn-small btn-info search">Search by Video Name</div>
			<div class="btn btn-small btn-success add">Add to Bucket</div>
			<span class="text-error info"></span>
			<br/>
			<div class="dismissGuess close" style="display:none">&times;</div>
			<div class="guessList" style="max-height:200px;overflow:auto"></div>
		</div>
		<div class="searchDataset session">
			<div class="title">3. Add Existing Dataset</div>
			<input name="labelDataset" class="datasetLabel pos" value=1 type="radio" checked="checked"></input> Positive
			<input name="labelDataset" class="datasetLabel neg" value=0 type="radio"></input> Negative
			<input name="labelDataset" class="datasetLabel webly" value=2 type="radio"></input> Webly Learning (requires metadata)
			<br/>
			<input class="input-medium datasetname" placeholder="Search Dataset" type="text"></input>
			<div class="btn btn-small btn-info searchDataset">Search by Dataset Name</div>
			<div class="btn btn-small btn-success add">Add to Bucket</div>
			<span class="text-error info"></span>
			<br/>
			<div class="dismissGuess close" style="display:none">&times;</div>
			<div class="guessList" style="max-height:200px;overflow:auto"></div>
			<div class="note muted">For testing, recommend dataset "aladdin16Test_sub". Click "see result" in Query Results for example.</div>
		</div>
	</div>
	<div class="right">
		<input class="syncDone" vaule=1 type="hidden"></input>
		<div class="title">Bucket <span class="text-error videoListInfo"></span></div>
		<div class="videoList"></div>
		<div class="ctr">
			<div class="title">Training Control</div>
			<div class="line">
				detector for: <input class="detectorName input-large" type="text"></input>
				<input class="note input-medium" type="text" placeholder="Name of the detector"></input>
				(<span class="videoCount">0</span> videos <span class="videoCountW">0</span> for WELL <span class="videoCountP">0</span> Pos <span class="videoCountN">0</span> Neg) (use space to seperate keyword) (Since we are not using GPU, feature extraction for a 200-video bucket will take up to 24 hours)
			</div>
			<div class="line">
				<div class="btn btn-primary run">Train Video Detector</div>
				<span class="info text-error"></span>
			</div>
			<div class="progressForWellTrain">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "wellTrainProgress",
						"doneCall" => "#detectors > input.userId"
					));
				?>
			</div>
			<div class="title">Video Detectors (To test them, replace bucket with testset)</div>
			<div class="line">
				<div id="detectors">
					<input class="userId" value="<?php echo Yii::app()->session['userId']?>" type="hidden"></input>
					<div class="detectorList">
						
					</div>
				</div>
			</div>
			<div class="title">Testing Runs (Query Results) <span class="text-error testRunInfo"></span></div>
			<div class="line">
				<div id="testRuns">
					<input class="userId" value="<?php echo Yii::app()->session['userId']?>" type="hidden"></input>
					<div class="progressForWellTest">
						<?php 
							$this->widget("ProgressWidget",array(
								"id" => "wellTestProgress",
								"doneCall" => "#testRuns > input.userId"
							));
						?>
					</div>
					<div class="runList">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="footer" style="text-align:center;color:gray;position:fixed;bottom:0;width:100%;padding:5px;">
	If you have any questions, you can contact us by aronson@andrew.cmu.edu
</div>