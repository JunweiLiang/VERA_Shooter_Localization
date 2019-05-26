<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
/* @var $this ClubSiteController */

?>
<style type="text/css">
	#superManage{padding-bottom:300px}
	#superManage > div.block{
		padding:10px;
	}
	#superManage > div.title{
		padding:10px;
		font-size:1.2em;font-weight:bold;
		border-bottom:1px silver solid;
	}
	#superManage > div.block > div.line{
		padding:5px;
	}

	#superManage input{margin:0}
	#superManage div.datasetList > div.dataset{
		padding:5px;
	}
	#superManage > div.videoInputs{
		padding:10px;
	}
	#superManage > div.videoInputs > textarea.videoList,
	#superManage > div.block > div.videoRanklistInputs > textarea.ranklist{
		width:600px;
		height:120px;
		margin:10px;
	}
	#superManage > div.videoInputs > div.outputs{
		padding:10px;
	}
	#superManage > div.progressForVideo,
	#superManage > div.progressForPreVideo,
	#superManage > div.progressForER{
		padding:10px;
		width:500px;
	}
	#superManage > div.block > div.datasets,
	#superManage > div.block > div.datasetsPre,
	#superManage > div.block > div.datasetsER{
		padding:10px;
		position:relative;
	}
	#superManage > div.block > div.datasets > div.block,
	#superManage > div.block > div.datasetsPre > div.block,
	#superManage > div.block > div.datasetsER > div.block{
		float:left;
		margin-right:20px;
		padding:5px;
		border-radius:5px;
		border:1px silver solid;
		text-align:center;
		cursor:pointer;
	}
	#superManage > div.block > div.datasets > div.block.toggle,
	#superManage > div.block > div.datasetsPre > div.block.toggle,
	#superManage > div.block > div.datasetsER > div.block.toggle{
		color:white;
		background-color:rgb(0,128,192);
	}
	#superManage > div.block > div.datasetVideos,
	#superManage > div.block > div.datasetVideosPre > div.dataset,
	#superManage > div.block > div.resultsER > div.dataset{
		padding:10px;
		height:200px;
		overflow-y:auto;
		background-color:rgb(245,245,245);
		border:1px silver solid;margin:5px;
		border-radius:5px;
	}
	#superManage > div.block > div.datasetVideosPre > div.dataset,
	#superManage > div.block > div.resultsER > div.dataset{
		display:none;
	}
	#superManage > div.block > div.datasetVideos > div.block,
	#superManage > div.block > div.datasetVideosPre > div.dataset > div.block,
	#superManage > div.block > div.resultsER > div.dataset > div.block{
		padding:10px;
		position:relative;
		font-size:0.9em;
	}
	#superManage > div.block > div.resultsER > div.dataset > div.block > div.left{
		width:200px;
		float:left;
		padding:5px 0;
		word-break:break-all;
	}
	#superManage > div.block > div.resultsER > div.dataset > div.block > div.right{
		margin:0 0 0 200px;
		padding:5px 0;
	}
	#superManage > div.block > div.datasetVideos > div.block > div.ctr,
	#superManage > div.block > div.datasetVideosPre > div.dataset > div.block > div.ctr{
		position:absolute;
		top:0;right:0;
		width:100px;
		padding:5px;
	}
	#superManage > div.block > div.datasetVideos > div.block > div.ctr > i,
	#superManage > div.block > div.datasetVideosPre > div.dataset > div.block > div.ctr > i{
		cursor:pointer;
	}
</style>

<script type="text/javascript">
/*
	cw.ec("#superManage > div.block > div.line > div.changeLog",function(){
		//alert("h");
		var data = {};
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/changeLog",data,function(result){
			alert(result);
		},null,function(dump,err){alert(err)},null,"text");
	});
	
	cw.ec("#superManage > div.block > div.line > div.clean",function(){
		//alert("h");
		var data = {};
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/clean",data,function(result){
			alert(result);
		},null,function(dump,err){alert(err)},null,"text");
	});*/
	cw.ec("#superManage > div.block > div.line > div.newDataset",function(){
		var data = {};
		data.datasetName = $("#superManage input.newdatasetname").val();
		data.datasetNote = $("#superManage input.newdatasetnote").val();
		data.datasetId = 0;
		changeDataset(data,true);
	});
	cw.ec("#superManage div.datasetList > div.dataset > div.changeDataset",function(){
		var data = {};
		data.datasetName = $(this).parent().children("input.datasetName").val();
		data.datasetNote = $(this).parent().children("input.datasetNote").val();
		data.datasetId = $(this).parent().children("input.datasetId").val();;
		changeDataset(data);
	});
	cw.ec("#superManage div.datasetList > div.dataset > div.deleteDataset",function(){
		var data = {};
		data.datasetId = $(this).parent().children("input.datasetId").val();;
		deleteDataset(data);
	});
	cw.ec("#superManage > div.block > div.line > div.getDatasetList",function(){
		getDatasetList();
	});
	function deleteDataset(data)
	{
		showerror("<div class='loading'></div>",false);
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/deleteDataset",data,function(result){
			if(result.status == 0)
			{
				showerror("success");
				getDatasetList();
			}
		});
	}
	function changeDataset(data)
	{
		var emptynew = arguments[1]?arguments[1]:false;
		if((data.datasetName == "")||(data.datasetNote==""))
		{
			showerror("please enter datasetname and datasetnote");
			return;
		}
		if(emptynew)
		{
			$("#superManage input.newdatasetname").val("");
			$("#superManage input.newdatasetnote").val("");
		}
		showerror("<div class='loading'></div>",false);
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/changeDataset",data,function(result){
			if(result.status == 0)
			{
				showerror("success");
				getDatasetList();
			}
		});
	}
	function getDatasetList()
	{
		var data = {};
		$('#superManage div.datasetList').html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetList",data,function(result){
			$(this).html("");
			if(result.status == 0)
			{
				for(var i=0;i<result.datasets.length;++i)
				{
					var temp = $("<div class='dataset'>"+
							"<input class='datasetId' type='hidden' value='"+result.datasets[i].id+"'></input>"+
							"<span class='id'>"+result.datasets[i].id+"</span> "+
							"<input class='datasetName input-medium' type='text' value='"+result.datasets[i].name+"'></input> "+
							"<input class='datasetNote input-xlarge' type='text' value='"+result.datasets[i].note+"'></input> "+
							'<div class="btn btn-info changeDataset">save</div> '+
							'<div class="btn btn-danger deleteDataset">delete</div> '+
						"</div>");
					$(this).append(temp);
				}
			}else{
				$(this).html("error");
			}
		},$('#superManage div.datasetList'));
	}
	function showerror(str)
	{
		var autoempty = arguments[1]?arguments[1]:true;
		$("#superManage > div.block > div.line > span.datasetnotice").html(str);
		if(autoempty)
		{
			setTimeout(function(){
				$("#superManage > div.block > div.line > span.datasetnotice").html("");
			},3000);
		}
	}

//***************************************************************videos management

	cw.ec("#superManage > div.videoInputs > div.addList",function(){
		var data = {};
		data.videoList = new Array();
		var inputs = $.trim($(this).parent().children("textarea.videoList").val());
		inputs = inputs.split("\n");
		//alert(inputs.length);
		var countMeta = 0;
		for(var i in inputs)
		{
			var stuff = $.trim(inputs[i]);
			if(stuff != "")
			{
				// see whether we have metadata path.
				var temp = stuff.split(" ");
				if(temp.length > 1)
				{
					countMeta++;
					var video = {"originalPath":temp[0],"metaPath":temp[1]};
				}
				else
				{
					var video = {"originalPath":stuff,"metaPath":""};
				}
				// check the video is ghost or not
				var temp = video['originalPath'].split("/");
				if((temp.length == 2) && (temp[0] == "ghost"))
				{
					video['originalPath'] = temp[1];
					video['isGhost'] = 1;
				}
				else
				{
					video['isGhost'] = 0;
				}
				data.videoList.push(video);
			}
		}
		
		//whether to create Dataset at the same time 
		data.makeDataset = 0;
		var datasetStr = "";
		if($("#superManage > div.videoInputs > input.makeDataset").prop("checked"))
		{
			data.makeDataset = 1;
			data.datasetName = $("#superManage > div.videoInputs > input.datasetName").val();
			datasetStr = " also adding to dataset "+data.datasetName+" ...";
			if(data.datasetName == "")
			{
				alert("dataset name can't be empty!");
				return;
			}
		}
		data.isFile = 0;
		data.filepath = $.trim($(this).parent().children("input.filepath").val());
		if(data.filepath != "")
		{
			data.isFile = 1;
		}
		else
		{
			if((inputs == "") || (data.videoList.length ==0))
			{
				alert("please enter videolist");
				$(this).parent().children("textarea.videoList").val("");
				return;
			}
		}

		$("#superManage > div.videoInputs > div.outputs").html('posting request (total '+data.videoList.length+', has metaPath '+countMeta+', hasFile:'+data.isFile+')...'+datasetStr);
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/importVideos",data,function(result){
			//{"status":0,"dataError":[],"processStatus":0}
			if(result.status == 0)
			{
				$(this).parent().children("textarea.videoList").val("");
				$(this).parent().children("input.filepath").val("");
				//reset the make dataset part
				//display counting results
				$("#superManage > div.videoInputs > div.outputs").html(
					result.count.addToDatabase+" added to database directly, since related path and original path exists or ghost;<br/>"+
					result.count.ignore+" are ignored since original not exists;<br/>"+
					result.count.ghost+" are ghost videos<br/>"+
					result.count.furtherProcess+" are posted to python for futher process"
				);
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#videoImportProgress > input.processId").val(result.processId);
					$("#videoImportProgress > input.showing").val(1).change();
					$("#videoImportProgress > input.updating").val(1).change();
				}
			}
		},$(this));
	});
//******
//***************************************************** dataset videos management
cw.ec("#superManage > div.block > div.line > div.refreshDV",function(){
	refreshDatasetVideos();
});
//click a datset, hide the one that are not in that dataset
cw.ec("#superManage > div.block > div.datasets > div.block",function(){
	var data = {};
	data.datasetId = $(this).children("input.datasetId").val();
	//style
	$("#superManage > div.block > div.datasets > div.block").removeClass("toggle");
	$(this).addClass("toggle");
	//clear ctr
	$("#superManage > div.block > div.dvctr").find("div.btn").addClass("disabled")
		.end().find("span.selected").html(0)
		.end().find("span.datasets > input.selectThis").prop("checked",false)
		.end().find("span.info").html("");
	//clear all the selected
	$("#superManage > div.block > div.datasetVideos > div.block > input.selectThis").prop("checked",false);
	$("#superManage > div.block > div.datasetVideos > div.block").hide();//hide all first
	if(data.datasetId == "all")
	{
		//show all
		$("#superManage > div.block > div.datasetVideos > div.block").show();
		$("#superManage > div.block > div.dvctr > div.addTo").removeClass("disabled");
	}
	else
	{
		$("#superManage > div.block > div.dvctr > div.btn").removeClass("disabled");
		//foreach every video in list
		$("#superManage > div.block > div.datasetVideos > div.block").each(function(){
			var toDatasets = $(this).children("input.toDatasets").val();
			if(inDataset(toDatasets,data.datasetId))
			{
				$(this).show();
			}
		});
	}
});
//add video to dataset 
cw.ec("#superManage > div.block > div.dvctr > div.btn.addTo",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.videoIds = getSelectVideos();
	if(data.videoIds.length == 0)
	{
		showdverr("please select videos");
		return;
	}
	data.datasetIds = getSelectDatasets();
	if(data.datasetIds.length == 0)
	{
		showdverr("please select datasets");
		return;
	}
	$("#superManage > div.block > div.dvctr > span.info").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/addDatasetVideos",data,function(result){
		if(result.status == 0)
		{
			//refresh 
			refreshDatasetVideos();
		}
	});
});
//delete videos
cw.ec("#superManage > div.block > div.dvctr > div.btn.delete",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.videoIds = getSelectVideos();
	if(data.videoIds.length == 0)
	{
		showdverr("please select videos");
		return;
	}
	data.datasetId = $("#superManage > div.block > div.datasets > div.block.toggle > input.datasetId").val();
	$("#superManage > div.block > div.dvctr > span.info").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/deleteDatasetVideos",data,function(result){
		if(result.status == 0)
		{
			//refresh 
			refreshDatasetVideos();
		}
	});
});
function showdverr(str)
{
	$("#superManage > div.block > div.dvctr > span.info").html(str);
	setTimeout(function(){
		$("#superManage > div.block > div.dvctr > span.info").html("");
	},3000);
}
//select any video
cw.eck("#superManage > div.block > div.datasetVideos > div.block > input.selectThis",function(e){
	if($(this).prop("checked"))
	{
		var videoId = $(this).parent().children("input.videoId").val();
	}
	$("#superManage > div.block > div.dvctr > span.selected").html(getSelectVideos().length);
});
function getSelectVideos()
{
	var videoIds = new Array();
	$("#superManage > div.block > div.datasetVideos > div.block > input.selectThis:checked").each(function(){
		videoIds.push(parseInt($(this).parent().children("input.videoId").val()));
	});
	return videoIds;
}
function getSelectDatasets()
{
	var datasetIds = new Array();
	$("#superManage > div.block > div.dvctr > span.datasets > input.selectThis:checked").each(function(){
		datasetIds.push(parseInt($(this).val()));
	});
	return datasetIds;
}
function inDataset(datasetstr,datasetId)
{
	var ids = datasetstr.split(",");
	for(var i=0;i<ids.length;++i)
	{
		if(parseInt(ids[i]) == parseInt(datasetId))
		{
			return true;
		}
	}
	return false;
}
function refreshDatasetVideos()
{
	var data = {}
	$("#superManage > div.block > div.datasets").html('<div class="loading"></div>');
	$("#superManage > div.block > div.datasetVideos").html('<div class="loading"></div>');
	//get dataset list first
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetList",data,function(result){
		$("#superManage > div.block > div.datasets").html("");
		if(result.status == 0)
		{
			$("#superManage > div.block > div.datasets").append(makeDblock("all","All","haha"));
			$("#superManage > div.block > div.dvctr > span.datasets").html("");
			for(var i=0;i<result.datasets.length;++i)
			{
				$("#superManage > div.block > div.datasets").append(makeDblock(result.datasets[i].id,result.datasets[i].name,result.datasets[i].note));
				//add to control panel
				$("#superManage > div.block > div.dvctr > span.datasets").append('<input class="selectThis" type="checkbox" value="'+result.datasets[i].id+'"></input> '+result.datasets[i].name+"&nbsp;&nbsp;&nbsp;");
			}
			

			//get dataset videos
			var data = {};
			cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetVideos",data,function(res){
				$("#superManage > div.block > div.datasetVideos").html("");
				if(res.status == 0)
				{
					for(var videoId in res.videos)
					{
						$("#superManage > div.block > div.datasetVideos").append(makeDVblock(res.videos[videoId]));
					}
					//click the first dataset.
					$("#superManage > div.block > div.datasets > div.block").eq(0).trigger(cw.ectype);
				}
			});
		}else{
			$("#superManage > div.block > div.datasets").html("error");
		}
	});
}
function makeDblock(datasetId,datasetname,datasetnote)
{
	return $('<div class="block" title="'+datasetnote+'">'+
		'<input class="datasetId" type="hidden" value="'+datasetId+'"></input>'+
		datasetname+
	'</div>');
}
function makeDVblock(video)
{
	var toDatasets = video.toDatasets.join(",");
	return $('<div class="block" title="video changeTime:'+video.changeTime+', createTime:'+video.createTime+'">'+
		'<input class="toDatasets" type="hidden" value="'+toDatasets+'"></input>'+

		'<input class="videoId" type="hidden" value="'+video.id+'"></input>'+
		'<input class="relatedPath" type="hidden" value="'+video.relatedPath+'"></input>'+
		'<input class="basename" type="hidden" value="'+video.name+'"></input>'+

		'<input class="selectThis" type="checkbox" value="1"></input> '+
		video.name+
		'<div class="ctr"> '+
			'<i class="icon-eye-open showVideo"></i>'+
		'</div>'+
	'</div>');
}
//*********** for dataset preprocessing
function showdvpreerr(str)
{
	$("#superManage > div.block > div.dvprectr > span.info").html(str);
	setTimeout(function(){
		$("#superManage > div.block > div.dvprectr > span.info").html("");
	},3000);
}
//run preprocessing
cw.ec("#superManage > div.block > div.dvprectr > div.btn.run",function(){
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data = {};
	data.videos = getSelectPreVideos();
	if(data.videos.length == 0)
	{
		showdvpreerr("please select videos");
		return;
	}
	
	$("#superManage > div.block > div.dvprectr > span.info").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/preproDatasetVideos",data,function(result){
		$("#superManage > div.block > div.dvprectr > span.info").html('');
		if(result.status == 0)
		{
			//refresh 
			refreshDatasetVideos();
			//track progress
			if((result.processStatus == 0) && (result.processId != null))
			{
				//start monitoring the process
				$("#videoPreProgress > input.processId").val(result.processId);
				$("#videoPreProgress > input.showing").val(1).change();
				$("#videoPreProgress > input.updating").val(1).change();
			}
			else
			{
				$("#superManage > div.block > div.dvprectr > span.info").html("process error:"+result.processStatus);
			}
		}
		else
		{
			$("#superManage > div.block > div.dvprectr > span.info").html(reuslt.errorInfo);
		}
	});
});
//select a video
cw.eck("#superManage > div.block > div.datasetVideosPre > div.dataset > div.block > input.selectThis",function(e){
	if($(this).prop("checked"))
	{
		var videoId = $(this).parent().children("input.videoId").val();
	}
	$("#superManage > div.block > div.dvprectr > span.selected").html(getSelectPreVideos().length);
});
function getSelectPreVideos()//dvIds
{
	var videos = new Array();
	$("#superManage > div.block > div.datasetVideosPre > div.dataset > div.block > input.selectThis:checked").each(function(){
		var temp = {};
		temp.videoId = parseInt($(this).parent().children("input.videoId").val());
		temp.dvId = parseInt($(this).parent().children("input.dvId").val());
		videos.push(temp);
	});
	return videos;
}
cw.ec("#superManage > div.block > div.line > div.refreshPre",function(){
	refreshDatasetVideosPre();
});
//click a datset, hide the one that are not in that dataset
cw.ec("#superManage > div.block > div.datasetsPre > div.block",function(){
	var data = {};
	data.datasetId = $(this).children("input.datasetId").val();
	//style
	$("#superManage > div.block > div.datasetsPre > div.block").removeClass("toggle");
	$(this).addClass("toggle");
	//clear ctr
	$("#superManage > div.block > div.dvprectr").find("div.btn")//.addClass("disabled")
		.end().find("span.selected").html(0)
		.end().find("span.info").html("");
	//clear all the selected
	$("#superManage > div.block > div.datasetVideosPre > div.dataset > div.block > input.selectThis").prop("checked",false);
	$("#superManage > div.block > div.datasetVideosPre > div.dataset").hide();//hide all first
	$("#superManage > div.block > div.datasetVideosPre > div.dataset > input.datasetId[value='"+data.datasetId+"']").parent().show();
});
//click getting a video data for a dataset.
cw.ec("#superManage > div.block > div.datasetVideosPre > div.dataset > div.loaddatasetvideo",function(){
	var data = {};
	data.datasetId = $(this).parent().children("input.datasetId").val();
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetVideo",data,function(result){
		$(this).children("div.wrapLoading").remove();
		if(result.status == 0)
		{
			for(var i=0;i<result.videos.length;++i)
			{
				$(this).append(makeDVpreblock(result.videos[i]));
			}
		}
	},$(this).parent());
	$(this).parent().html('<input class="datasetId" type="hidden" value="'+data.datasetId+'"></input>'+
		'<div class="wrapLoading"><div class="loading"></div></div>'
	);
});
function refreshDatasetVideosPre()
{
	var data = {}
	$("#superManage > div.block > div.datasetsPre").html('<div class="loading"></div>');
	$("#superManage > div.block > div.datasetVideosPre").html('<div class="loading"></div>');
	//get dataset list first
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetList",data,function(result){
		$("#superManage > div.block > div.datasetsPre").html("");
		$("#superManage > div.block > div.datasetVideosPre").html('');
		if(result.status == 0)
		{
			for(var i=0;i<result.datasets.length;++i)
			{
				$("#superManage > div.block > div.datasetsPre").append(makeDPreblock(result.datasets[i].id,result.datasets[i].name,result.datasets[i].note));
				//get a empty container for each dataset.
				$("#superManage > div.block > div.datasetVideosPre").append('<div class="dataset">'+
					'<input class="datasetId" type="hidden" value="'+result.datasets[i].id+'"></input>'+
					'<div class="btn btn-primary btn-small loaddatasetvideo"> click to get data for '+result.datasets[i].name+'</div>'+
				'</div>');
			}
			$("#superManage > div.block > div.datasetsPre > div.block").eq(0).trigger(cw.ectype);
		}else{
			$("#superManage > div.block > div.datasetsPre").html("error");
		}
	});
}
function makeDPreblock(datasetId,datasetname,datasetnote)
{
	return $('<div class="block" title="'+datasetnote+'">'+
		'<input class="datasetId" type="hidden" value="'+datasetId+'"></input>'+
		datasetname+
	'</div>');
}
function makeDVpreblock(video)
{
	return $('<div class="block" title="video changeTime:'+video.changeTime+', createTime:'+video.createTime+'">'+
		'<input class="dvId" type="hidden" value="'+video.dvId+'"></input>'+
		'<input class="videoId" type="hidden" value="'+video.videoId+'"></input>'+
		'<input class="relatedPath" type="hidden" value="'+video.relatedPath+'"></input>'+
		'<input class="basename" type="hidden" value="'+video.videoname+'"></input>'+

		'<input class="selectThis" type="checkbox" value="1"></input> '+
		video.videoname+" thumbnail: "+video.thumbnailPath+" signAudioPath: "+video.signAudioPath+" rankScore:"+video.rankScore+
		'<div class="ctr"> '+
			'<i class="icon-eye-open showVideo"></i>'+
		'</div>'+
	'</div>');
}
//******** click any eye open icon, open video in new page
cw.ec("#superManage i.icon-eye-open.showVideo",function(){
	var basename = $(this).parent().parent().children("input.basename").val();
	//alert(basename);
	window.open("<?php echo Yii::app()->baseUrl;?>/index.php/application/showVideo?basename="+basename,"_blank");
});


//**************************************event reconstruction task
function showERerr(str)
{
	$("#superManage > div.block > div.ERctr > span.info").html(str);
	setTimeout(function(){
		$("#superManage > div.block > div.ERctr > span.info").html("");
	},3000);
}
//run event construction!!
cw.ec("#superManage > div.block > div.ERctr > div.run",function(){
	var data = {};
	data.datasetId = $("#superManage > div.block > div.datasetsER > div.block.toggle").children("input.datasetId").val();
	//alert(data.datasetId);
	if(data.datasetId == null)
	{
		showERerr("please select dataset");
		return;
	}
	$("#superManage > div.block > div.ERctr > span.info").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/runER",data,function(result){
		if(result.status == 0)
		{
			//refresh 
			refreshDatasetVideosER();
			//track progress
			if((result.processStatus ==0) && (result.processId != null))
			{
				//start monitoring the process
				$("#ERProgress > input.processId").val(result.processId);
				$("#ERProgress > input.showing").val(1).change();
				$("#ERProgress > input.updating").val(1).change();
			}
			else
			{
				$("#superManage > div.block > div.ERctr > span.info").html("process error:"+result.processStatus);
			}
		}
		else
		{
			$("#superManage > div.block > div.ERctr > span.info").html(reuslt.errorInfo);
		}
	});
});

cw.ec("#superManage > div.block > div.line > div.refreshER",function(){
	refreshDatasetVideosER();
});
//click a datset, hide the one that are not in that dataset
cw.ec("#superManage > div.block > div.datasetsER > div.block",function(){
	var data = {};
	data.datasetId = $(this).children("input.datasetId").val();
	//style
	$("#superManage > div.block > div.datasetsER > div.block").removeClass("toggle");
	$(this).addClass("toggle");
	//clear ctr
	$("#superManage > div.block > div.ERctr").find("div.btn")//.addClass("disabled")
		.end().find("span.info").html("");
	$("#superManage > div.block > div.resultsER > div.dataset").hide();//hide all first
	$("#superManage > div.block > div.resultsER > div.dataset > input.datasetId[value='"+data.datasetId+"']").parent().show();
});

//click getting a video data for a dataset.
cw.ec("#superManage > div.block > div.resultsER > div.dataset > div.loadER",function(){
	var data = {};
	data.datasetId = $(this).parent().children("input.datasetId").val();
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getResultsER",data,function(result){
		$(this).children("div.wrapLoading").remove();
		if(result.status == 0)
		{
			for(var i=0;i<result.videos.length;++i)
			{
				$(this).append(makeERblock(result.videos[i]));
			}
		}
	},$(this).parent());
	$(this).parent().html('<input class="datasetId" type="hidden" value="'+data.datasetId+'"></input>'+
		'<div class="wrapLoading"><div class="loading"></div></div>'
	);
});
function makeERblock(video)
{
	var temp = $('<div class="block"><div class="left">'+video.videoname+'</div><div class="right"></div></div>');
	for(var i=0;i<video.ranklist.length;++i)
	{
		temp.find("div.right").append('<div class="block">'+
			video.ranklist[i].videoname+" offset: "+video.ranklist[i].offset+" confidence: "+parseFloat(video.ranklist[i].confidence).toFixed(4)+
		'</div>');
	}
	return temp;
}
//refresh data for event reconstruction
function refreshDatasetVideosER()
{
	var data = {}
	$("#superManage > div.block > div.datasetsER").html('<div class="loading"></div>');
	$("#superManage > div.block > div.resultsER").html('<div class="loading"></div>');
	//get dataset list first
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getDatasetList",data,function(result){
		$("#superManage > div.block > div.datasetsER").html("");
		$("#superManage > div.block > div.resultsER").html('');
		if(result.status == 0)
		{
			for(var i=0;i<result.datasets.length;++i)
			{
				$("#superManage > div.block > div.datasetsER").append(makeDPreblock(result.datasets[i].id,result.datasets[i].name,result.datasets[i].note));
				//get a empty container for each dataset.
				$("#superManage > div.block > div.resultsER").append('<div class="dataset">'+
					'<input class="datasetId" type="hidden" value="'+result.datasets[i].id+'"></input>'+
					'<div class="btn btn-primary btn-small loadER"> click to get data for '+result.datasets[i].name+'</div>'+
				'</div>');
			}
			$("#superManage > div.block > div.datasetsER > div.block").eq(0).trigger(cw.ectype);
		}else{
			$("#superManage > div.block > div.datasetsER").html("error");
		}
	});
}
/// add ranklist
cw.ec("#superManage > div.block > div.videoRanklistInputs > div.importResult",function(){
		var data = {};
		//data.videoList = new Array();
		data.runName = $(this).parent().children("input.runName").val();
		data.filelst = $(this).parent().children("input.resultfilelst").val();
		data.userName = $(this).parent().children("input.userName").val();
		if(data.runName == "")
		{
			alert("please enter runName");
			return;
		}
		if(data.userName == "")
		{
			alert("please enter userName");
			return;
		}
		if(data.filelst == "")
		{
			alert("please enter filelst path");
			return;
		}
		
		/*
		var inputs = $.trim($(this).parent().children("textarea.ranklist").val());
		inputs = inputs.split("\n");
		//alert(inputs.length);
		for(var i in inputs)
		{
			var stuff = $.trim(inputs[i]);
			if(stuff != "")
			{
				data.videoList.push(stuff);
			}
		}
		if((inputs == "") || (data.videoList.length ==0))
		{
			alert("please enter videolist");
			$(this).parent().children("textarea.ranklist").val("");
			return;
		}
		if(!confirm("Confirm total ranklist file : "+data.videoList.length+"?"))
		{
			return;
		}
		*/
		
		
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/importResult",data,function(result){
			//{"status":0,"dataError":[],"processStatus":0}
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("input.resultfilelst").val("");
				$(this).parent().children("input.runName").val("");
				//display counting results
				$(this).parent().children("span.info").html(
					//result.count.ignore+" are ignored since video not exists;<br/>"+
					//result.count.furtherProcess+" are posted to python for importing ranklist"
					//"sended to python..."
					""
				);
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#ERIProgress > input.processId").val(result.processId);
					$("#ERIProgress > input.showing").val(1).change();
					$("#ERIProgress > input.updating").val(1).change();
				}
			}
			else
			{
				$(this).parent().children("span.info").html("user not exists");
			}
		},$(this));
	});
</script>
<div id="superManage">
	<!--
	<div class="block">
		<div class="line">
			修改日志，添加项目属性<div class="btn btn-info changeLog">开始</div>
		</div>
	</div>

	<div class="block">
		<div class="line">清空数据库，保留用户信息</div>
		<div class="line">
			<div class="btn btn-info clean">开始</div>
		</div>
	</div>
	-->
	<div class="title">Dataset management</div>
	<div class="block">
		<div class="line">
			<input class="newdatasetname input-medium" type="text" placeholder="name"></input>
			<input class="newdatasetnote input-xlarge" type="text" placeholder="note"></input>
		</div>
		<div class="line">
			<div class="btn btn-success newDataset">new dataset</div>
			<div class="btn btn-info getDatasetList">getDatasetList</div>
			<span class="datasetnotice text-error"></span>
		</div>
		<div class="datasetList">---</div>
	</div>

	<div class="title">Videos management</div>
	<div class="videoInputs">
		<textarea class="videoList" placeholder="enter video absolute path here. Will ignore the one that both exists in this path and website path, and the one not exists in website path. Each line if video has metadata json path, use space to separate. If the absolute path looks like ghost/videoname.mp4, will be import as ghost video"></textarea>
		<br/>
		or put the list into a file: 
		<input class="filepath input-xxlarge" type="text" placeholder="path to filelst"></input>
		<br/>
		<div class="btn btn-success addList">add videos</div>
		<input class="makeDataset" type="checkbox" value="1"></input> add to Dataset:
		<input class="datasetName input-medium" type="text"></input>
		<div class="outputs text-warning"></div>
	</div>
	<div class="progressForVideo">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "videoImportProgress",
		));
	?>
	</div>
	<div class="title">Datasets-Videos management</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshDV">refresh data</div>
		</div>
		<div class="datasets">datasets: --- </div>
		<div style="clear:both"></div>
		<div class="datasetVideos">videos: --- </div>
		<div class="dvctr">
			selected:
			<span class="text-warning selected">0</span>
			<div class="btn btn-info delete disabled">delete from this dataset</div>
			add To:
			<span class="datasets"></span>
			<div class="btn btn-info addTo disabled">addToDataset</div>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="title">Dataset preprocessing</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshPre">refresh data</div>
		</div>
		<div class="datasetsPre">datasets: --- </div>
		<div style="clear:both"></div>
		<div class="datasetVideosPre">videos: --- </div>
		<div class="dvprectr">
			selected:
			<span class="text-warning selected">0</span>
			<div class="btn btn-info run">run event reconstruction preprocessing</div>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="progressForPreVideo">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "videoPreProgress",
		));
	?>
	</div>
	<div class="title">Dataset Event Reconstruction Using Audio</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshER">refresh data</div>
		</div>
		<div class="datasetsER">datasets: --- </div>
		<div style="clear:both"></div>
		<div class="resultsER">results: --- </div>
		<div class="ERctr">
			<div class="btn btn-info run">run event reconstruction</div>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="progressForER">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "ERProgress",
		));
	?>
	</div>
	<div class="title">Dataset Event Reconstruction Using Audio Result Import</div>
	<div class="block">
		<span class="muted">Please load all video first. Then list the ranklist file in a file, and put the file name below. Ranklist filename correspond to the video name. Search Segment would be allowed in these. Assuming ranklist file extension is .txt</span>
	</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshERI">refresh data</div>
		</div>
		<div class="datasetsERI">runs: --- </div>
		<br/>
		<div style="clear:both"></div>
		<div class="videoRanklistInputs">
		<!-- too slow for too much video lst
			<textarea class="ranklist" placeholder="enter ranklist absolute path here. Each ranklist filename is existed videoname"></textarea>
			-->
			filelst path: <input class="input-xlarge resultfilelst" type="text" placeholder="please put the absolute rankfile list into a list file"></input>
			<br/>
			<br/>
			runName(dataset name): <input type="text" class="input-medium runName"></input>
			userName: <input type="text" class="input-small userName"></input>
			<div class="btn btn-success importResult">Import Result</div>
			<br/>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="progressForERI">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "ERIProgress",
		));
	?>
	</div>
	<div class="title">Audio Synchronization Experiemnt Result Import</div>
	<div class="block">
		<span class="muted">Please load all video first. Give the path to result file and a experiment name. No new dataset generated. Only the designated user can see it </span>
	</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshASExp">Refresh Exp List</div>
		</div>
		<div class="datasetsASExp">runs: --- </div>
		<br/>
		<div style="clear:both"></div>
		<div class="audioSyncExpInputs">
		<!-- too slow for too much video lst
			<textarea class="ranklist" placeholder="enter ranklist absolute path here. Each ranklist filename is existed videoname"></textarea>
			-->
			result file path: <input class="input-xlarge resultfile" type="text" placeholder="result file absolute path"></input>
			username: <input class="input-medium username" type="text"></input>
			<br/>
			<br/>
			runName: <input type="text" class="input-medium runName"></input>
			<div class="btn btn-success importResult">Import Result</div>
			<br/>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="progressForASExp">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "ASExpProgress",
		));
	?>
	</div>
	<div class="title">Gunshot Detection Experiemnt Result Import</div>
	<div class="block">
		<span class="muted">Please load all video first. Give the path to result json+ and a experiment name. No new dataset generated. Only the designated user can see it </span>
	</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshGunshotExp">Refresh Exp List</div>
		</div>
		<div class="datasetsGunshotExp">runs: --- </div>
		<br/>
		<div style="clear:both"></div>
		<div class="gunshotExpInputs">
		<!-- too slow for too much video lst
			<textarea class="ranklist" placeholder="enter ranklist absolute path here. Each ranklist filename is existed videoname"></textarea>
			-->
			result json path: <input class="input-xlarge resultfile" type="text" placeholder="result json absolute path"></input>
			username: <input class="input-medium username" type="text"></input>
			<br/>
			<br/>
			runName: <input type="text" class="input-medium runName"></input>
			<div class="btn btn-success importResult">Import Result</div>
			<br/>
			<span class="text-error info"></span>
		</div>
	</div>
	<div class="progressForGunshotExp">
	<?php 
		$this->widget("ProgressWidget",array(
			"id" => "GunshotExpProgress",
		));
	?>
	</div>
	<div class="title">Video cut points result input</div>
	<div class="block">
		<span class="muted">load the json of videos' cut point </span>
	</div>
	<div class="block">
		<div class="line">
			<div class="btn btn-success refreshCutExps">Refresh Exp List</div>
		</div>
		<div class="cutExpList">runs: --- </div>
		<br/>
		<div style="clear:both"></div>
		<div class="cutExpInputs">
			cut json path: <input class="input-xlarge cutfile" type="text" placeholder="cut json absolute path"></input>
			username: <input class="input-medium username" type="text"></input>
			<br/>
			runName: <input type="text" class="input-medium runName"></input>
			<div class="btn btn-success importCuts">Import Cut Exp</div>
			<br/>
			<span class="text-error info"></span>
		</div>
	</div>
</div>
<script type="text/javascript">
	// get run list
	cw.ec("#superManage > div.block > div.line > div.refreshCutExps",function(){
		//alert("s");
		var data = {};
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getCutExps",data,function(result){
			if(result.status == 0)
			{
				$("#superManage > div.block > div.cutExpList").html("");
				for(var i =0;i<result.expList.length;++i)
				{
					var item = result.expList[i];
					$("#superManage > div.block > div.cutExpList").append('<div class="run">'+
						'<input class="expId" value="'+item.id+'" type="hidden"></input>'+
						item.name+
						'<div class="close delete">&times</div>'+
					'</div>');
				}
			}
		});
	});
	// import result
	cw.ec("#superManage > div.block > div.cutExpInputs > div.importCuts",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.jsonpath = $(this).parent().children("input.cutfile").val();
		data.username = $(this).parent().children("input.username").val();
		data.runName = $(this).parent().children("input.runName").val();
		if((data.jsonpath == "") || (data.username == "") || (data.runName == ""))
		{
			alert("no empty!");
			return;
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading">');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/importCutExp",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status ==0 )
			{
				$(this).parent().children("span.info").html('done');
			}
			else
			{
				$(this).parent().children("span.info").html('error:'+result.error);
			}
		},$(this));
	});
</script>
<style type="text/css">
#superManage > div.block > div.datasetsASExp > div.run,
#superManage > div.block > div.datasetsGunshotExp > div.run{
	padding:10px;
	float:left;
	border:1px silver solid;
	margin:0 10px 10px 0;
	border-radius:5px;
}

</style>
<script type="text/javascript">
// delete a run
cw.ec("#superManage > div.block > div.datasetsASExp > div.run > div.delete",function(){
	var data = {};
	data.expId = $(this).parent().children("input.expId").val();
	if(!confirm("delete this run?"))
	{
		return;
	}
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/deleteASExp",data,function(result){
		$(this).remove();
		if(result.status == 0)
		{

		}
	},$(this).parent());
	$(this).html("<div class='loading'></div>");

});
//load audio sync experiment
cw.ec("#superManage > div.block > div.line > div.refreshASExp",function(){
	//alert("a");
	var data = {};
	$("#superManage > div.block > div.datasetsASExp").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getASExp",data,function(result){
		$("#superManage > div.block > div.datasetsASExp").html('');
		for(var i in result.explist)
		{
			$("#superManage > div.block > div.datasetsASExp").append('<div class="run">'+
					'<input class="expId" type="hidden" value="'+result.explist[i].id+'"></input>'+
					'<div class="close delete">&times;</div>'+
					result.explist[i].runName+
				'</div>');
		}
	});
});
/// add ranklist
cw.ec("#superManage > div.block > div.audioSyncExpInputs > div.importResult",function(){
		var data = {};
		//data.videoList = new Array();
		data.runName = $(this).parent().children("input.runName").val();
		data.resultfile = $(this).parent().children("input.resultfile").val();
		data.username = $(this).parent().children("input.username").val();
		if(data.runName == "")
		{
			alert("please enter runName");
			return;
		}
		if(data.resultfile == "")
		{
			alert("please enter resultfile");
			return;
		}
		if(data.username == "")
		{
			alert("please enter access username");
			return;
		}
		/*
		var inputs = $.trim($(this).parent().children("textarea.ranklist").val());
		inputs = inputs.split("\n");
		//alert(inputs.length);
		for(var i in inputs)
		{
			var stuff = $.trim(inputs[i]);
			if(stuff != "")
			{
				data.videoList.push(stuff);
			}
		}
		if((inputs == "") || (data.videoList.length ==0))
		{
			alert("please enter videolist");
			$(this).parent().children("textarea.ranklist").val("");
			return;
		}
		if(!confirm("Confirm total ranklist file : "+data.videoList.length+"?"))
		{
			return;
		}
		*/
		
		
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/importAudioSyncResult",data,function(result){
			//{"status":0,"dataError":[],"processStatus":0}
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("input.resultfile").val("");
				$(this).parent().children("input.runName").val("");
				$(this).parent().children("input.username").val("");
				//display counting results
				$(this).parent().children("span.info").html(
					""
				);
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#ASExpProgress > input.processId").val(result.processId);
					$("#ASExpProgress > input.showing").val(1).change();
					$("#ASExpProgress > input.updating").val(1).change();
				}
			}
			else if(result.status == 1)
			{
				$(this).parent().children("span.info").html("Username not exists").emptyLater();
			}
			else if(result.status == 2)
			{
				$(this).parent().children("span.info").html("Result file not exists").emptyLater();
			}
		},$(this));
	});
//---------------------------- for gunhsot exp
// delete a run
cw.ec("#superManage > div.block > div.datasetsGunshotExp > div.run > div.delete",function(){
	var data = {};
	data.expId = $(this).parent().children("input.expId").val();
	if(!confirm("delete this run?"))
	{
		return;
	}
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/deleteGunshotExp",data,function(result){
		$(this).remove();
		if(result.status == 0)
		{

		}
	},$(this).parent());
	$(this).html("<div class='loading'></div>");

});
//load audio sync experiment
cw.ec("#superManage > div.block > div.line > div.refreshGunshotExp",function(){
	//alert("a");
	var data = {};
	$("#superManage > div.block > div.datasetsGunshotExp").html('<div class="loading"></div>');
	cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/getGunshotExp",data,function(result){
		$("#superManage > div.block > div.datasetsGunshotExp").html('');
		for(var i in result.explist)
		{
			$("#superManage > div.block > div.datasetsGunshotExp").append('<div class="run">'+
					'<input class="expId" type="hidden" value="'+result.explist[i].id+'"></input>'+
					'<div class="close delete">&times;</div>'+
					result.explist[i].runName+
				'</div>');
		}
	});
});
/// add ranklist
cw.ec("#superManage > div.block > div.gunshotExpInputs > div.importResult",function(){
		var data = {};
		//data.videoList = new Array();
		data.runName = $(this).parent().children("input.runName").val();
		data.resultfile = $(this).parent().children("input.resultfile").val();
		data.username = $(this).parent().children("input.username").val();
		if(data.runName == "")
		{
			alert("please enter runName");
			return;
		}
		if(data.resultfile == "")
		{
			alert("please enter resultfile");
			return;
		}
		if(data.username == "")
		{
			alert("please enter access username");
			return;
		}
	
		
		
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/importGunshotResult",data,function(result){
			//{"status":0,"dataError":[],"processStatus":0}
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("input.resultfile").val("");
				$(this).parent().children("input.runName").val("");
				$(this).parent().children("input.username").val("");
				//display counting results
				$(this).parent().children("span.info").html(
					""
				);
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#GunshotExpProgress > input.processId").val(result.processId);
					$("#GunshotExpProgress > input.showing").val(1).change();
					$("#GunshotExpProgress > input.updating").val(1).change();
				}
			}
			else if(result.status == 1)
			{
				$(this).parent().children("span.info").html("Username not exists").emptyLater();
			}
			else if(result.status == 2)
			{
				$(this).parent().children("span.info").html("Result file not exists").emptyLater();
			}
		},$(this));
	});
</script>