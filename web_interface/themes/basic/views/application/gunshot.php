<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
/* @var $this ClubSiteController */

?>
<style type="text/css">
	#gunshot input{margin:0}
	#gunshot {padding:10px 0;}
	#gunshot div.title{
		text-align:center;
		padding:5px;
		font-weight:bold;
		border-bottom:1px silver solid;
		margin-bottom:5px;
	}
	#gunshot div.subTitle{
		padding:5px 10px;
		font-weight:800;
	}
	#gunshot > div.labels > div.labellist,
	#gunshot > div.features > div.featurelist,
	#gunshot > div.models > div.modellist{
		margin:10px;
		background-color:rgb(230,230,230);
		padding:5px;
	}
	#gunshot > div.labels > div.labellist > div.block,
	#gunshot > div.features > div.featurelist > div.block,
	#gunshot > div.models > div.modellist > div.block{
		background-color:white;
		padding:10px;
		border-radius:5px;
		margin-bottom:10px;
		word-break:break-all;
	}
	#gunshot > div.features > div.adding > div.add,
	#gunshot > div.models > div.training > div.trainIt{
		padding:10px;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/gunshot/";
	// get all the label we have.
	cw.ec("#gunshot > div.labels > div.title > div.getLabel",function(){
		var data = {};
		$("#gunshot > div.labels > div.labellist").html("<div class='wrapLoading'><div class='loading'></div></div>");
		cw.post(cw.url+"getLabels",data,function(result){
			if(result.status == 0)
			{
				$("#gunshot > div.labels > div.labellist").html("");
				for(var i =0;i< result.labels.length;++i)
				{
					$("#gunshot > div.labels > div.labellist").append(makeLabel(result.labels[i]));
				}
			}
		});
	});
	function makeLabel(label)
	{
		return $('<div class="block">'+
				'<input class="labelId" value="'+label.labelId+'" type="hidden"></input>'+
				label.videoname+" , "+cw.sec2time(label.startSec)+" to "+cw.sec2time(label.endSec)+" , "+label.pos+
				(
					(label.hasFeature == 1)?" <span class='muted'>Feature Extracted</span>":
					' <div class="btn btn-small btn-info extractFeature">extractFeature</div>'
				)+
			'</div>');
	}
	// click feature extraction for label
	cw.ec("#gunshot > div.labels > div.labellist > div.block > div.extractFeature",function(){
		var data = {};
		data.labelId = $(this).parent().children("input.labelId").val();
		$(this).parent().append('<span class="muted">extracting...</span>');
		cw.post(cw.url+"extractFeature",data,function(result){
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
	// after feature extracted, called feature done, ask the server and update all the label Id whether the feature extraced
	cw.ech("#gunshot > div.labels > input.featureDone",function(){
		var data = {};
		cw.post(cw.url+"getLabels",data,function(result){
			if(result.status == 0)
			{
				$("#gunshot > div.labels > div.labellist > div.block").each(function(){
					var labelId = $(this).children("input.labelId").val();
					for(var i =0;i< result.labels.length;++i)
					{
						if(labelId == result.labels[i].labelId)
						{
							if(result.labels[i].hasFeature == 1)
							{
								$(this).find("div.extractFeature").remove();
								$(this).find("span.muted").remove();
								$(this).append(" <span class='muted'>Feature Extracted</span>");
							}
							else
							{
								$(this).find("div.extractFeature").remove();
								$(this).find("span.muted").remove();
								$(this).append(' <div class="btn btn-small btn-info extractFeature">extractFeature</div>');
							}
							break;
						}
					}
				});
			}
		});
	});
	//------------------------------- get feature list
	cw.ec("#gunshot > div.features > div.title > div.getFeatures",function(){
		var data = {};
		$("#gunshot > div.features > div.featurelist").html("<div class='wrapLoading'><div class='loading'></div></div>");
		cw.post(cw.url+"getFeatures",data,function(result){
			if(result.status == 0)
			{
				$("#gunshot > div.features > div.featurelist").html("");
				for(var i =0;i< result.features.length;++i)
				{
					$("#gunshot > div.features > div.featurelist").append(makeFeature(result.features[i]));
				}
				showCurFeatureSelectCount();
			}
		});
	});
	function makeFeature(feature)
	{
		return $('<div class="block" title="'+feature.filelstpath+'">'+
				'<input class="featureId" value="'+feature.id+'" type="hidden"></input>'+
				'<input class="selected" type="checkbox" value="'+feature.id+'"></input> '+
				feature.featureName+" : "+ feature.pos+
			'</div>');
	}
	//-----------------------------------------
	//add local filelst into database
	cw.ec("#gunshot > div.features > div.adding > div.add > div.addToDatabase",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.featureName = $(this).parent().children("input.featureName").val();
		data.filelstpath = $(this).parent().children("input.filelstpath").val();
		data.pos = $(this).parent().children("input.ispos").prop("checked")?1:0;
		if((data.featureName == "") || (data.filelstpath == ""))
		{
			$(this).parent().children("span.info").html("Please enter feature name and filelstpath");
			return;
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"addFeature",data,function(result){
			if(result.status == 0)
			{
				$(this).removeClass("disabled");
				$(this).parent().children("span.info").html("")
					.end().children("input.featureName").val("")
					.end().children("input.filelstpath").val("")
					.end().children("input.ispos").prop("checked",false);
				$("#gunshot > div.features > div.title > div.getFeatures").trigger(cw.ectype);
			}
		},$(this));
	});
	function getCurFeatureSelectIds()
	{
		var ids = new Array();
		$("#gunshot > div.features > div.featurelist > div.block > input.selected:checked").each(function(){
			ids.push($(this).parent().children("input.featureId").val());
		});
		return ids;
	}
	function showCurFeatureSelectCount()
	{
		var count = getCurFeatureSelectIds();
		$("#gunshot > div.models > div.training > div.trainIt > span.featureCount").html(count.length);
	}
	//selected one
	$(document).delegate("#gunshot > div.features > div.featurelist > div.block > input.selected",cw.ectype,function(){
		showCurFeatureSelectCount();
	});
	//train
	cw.ec("#gunshot > div.models > div.training > div.trainIt > div.train",function(){
		var data = {};
		data.featureList = getCurFeatureSelectIds();
		data.modelName = $(this).parent().children("input.modelName").val();
		if(data.featureList.length == 0)
		{
			$("#gunshot > div.models > div.training > div.trainIt > span.info").html("No feature is selected");
			return;
		}
		if(data.modelName == "")
		{
			$("#gunshot > div.models > div.training > div.trainIt > span.info").html("modelName is needed");
			return;
		}
		$("#gunshot > div.models > div.training > div.trainIt > span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"trainModel",data,function(result){
			if(result.status==0)
			{
				$("#gunshot > div.models > div.training > div.trainIt > span.info").html("");
				$("#gunshot > div.models > div.training > div.trainIt > input.modelName").val("");
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
				$("#gunshot > div.models > div.training > div.trainIt > span.info").html("modelName exists, please change one");
			}
		});
	});
	//get model list
	//click get 
	cw.ec("#gunshot > div.models > div.title > div.getModels",function(){
		getModels();
	});
	function getModels()
	{
		var data= {};
		$("#gunshot > div.models > div.modellist").html('<div class="wrapLoading><div class="loading"></div></div>');
		cw.post(cw.url+"getModels",data,function(result){
			if(result.status == 0)
			{
				$("#gunshot > div.models > div.modellist").html("");
				for(var i=0;i<result.models.length;++i)
				{
					$("#gunshot > div.models > div.modellist").append(makeModel(result.models[i]));
				}
			}		
		});
	}
	function makeModel(model)
	{
		return $('<div class="block" title="'+model.modelpath+'">'+
				'<input class="modelId" value="'+model.id+'" type="hidden"></input>'+
				//model.modelname+
				'<input class="modelname input-xlarge" value="'+model.modelname+'" type="text"></input>'+
				' <div class="btn btn-small changeName">Change Name</div> '+
				(
					(model.isDefault == 1)?' <span class="muted">Default Model</span>':
					' <div class="btn btn-small btn-info setDefault">Set as Default</div>'
				)+
				'<span class="info text-error"></span>'+
				'<div class="close delete">&times;</div>'+
			'</div>');
	}
	//click change Name
	cw.ec("#gunshot > div.models > div.modellist > div.block > div.changeName",function(){
		var data = {};
		data.modelId = $(this).parent().children("input.modelId").val();
		data.modelName = $(this).parent().children("input.modelname").val();
		if(data.modelName == "")
		{
			alert("modelName can't be empty");
			return;
		}
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"changeModelName",data,function(result){
			$(this).parent().children("span.info").html('');
			if(result.status == 0)
			{
				alert("change success");
			}
			else if(result.status == 1)
			{
				$(this).parent().children("span.info").html('Name exists, please change another');
			}
		},$(this));

	});
	// train done'
	cw.ech("#gunshot > div.models > input.trainDone",function(){
		getModels();
	});
	//delete model
	cw.ec("#gunshot > div.models > div.modellist > div.block > div.delete",function(){
		var data= {};
		if(!confirm("confirm delete this model?"))
		{
			return;
		}
		data.modelId = $(this).parent().children("input.modelId").val();
		$(this).parent().append('<div class="loading"></div>');
		cw.post(cw.url+"deleteModel",data,function(result){
			//getModels();
		});
		$(this).parent().remove();
	});
	//set default
	cw.ec("#gunshot > div.models > div.modellist > div.block > div.setDefault",function(){
		var data= {};
		if(!confirm("confirm set this to default model?"))
		{
			return;
		}
		data.modelId = $(this).parent().children("input.modelId").val();
		$(this).parent().append('<div class="loading"></div>');
		cw.post(cw.url+"setDefaultModel",data,function(result){
			getModels();
		});
		$(this).remove();
	});
	// select all feature
	cw.ec("#gunshot > div.models > div.training > div.trainIt > div.selectAll",function(){
		$("#gunshot > div.features > div.featurelist > div.block > input.selected").prop("checked",true);
		showCurFeatureSelectCount();
	});
</script>
<div id="gunshot">
	<div class="labels">
		<input class="featureDone" type="hidden" value=1></input>
		<div class="title"> Labels of Uploaded Videos	
			<div class="btn btn-small btn-info getLabel">get</div>
		</div>
		<div class="labellist">
			<div class="wrapLoading"><span class="muted"> click get to get all labels</span></div>
		</div>
		<div class="featureExtractionProcess">
		<?php 
					$this->widget("ProgressWidget",array(
						"id" => "extractFeatureProgress",
						"doneCall" => "#gunshot > div.labels > input.featureDone",
						"noMessage" => false,
					));
			?>
		</div>
	</div>
	<div class="features">
		<div class="title"> Feature List
			<div class="btn btn-small btn-info getFeatures">get</div>
		</div>
		<div class="adding">
			<div class="subTitle">Add from Local File list: </div>
			<div class="add">
				filelstpath: <input class="filelstpath input-xlarge" type="text"></input><br/>
				featureName: <input class="featureName input-large" type="text"></input><br/>
				Is Positive: <input class="ispos" type="checkbox" value='1'></input><br/>
				<div class="addToDatabase btn btn-primary">Add filelst to database</div>
				<span class="info text-error"></span>
			</div>
		</div>
		<div class="featurelist">
			<div class="wrapLoading"><span class="muted"> click get to get all features</span></div>
		</div>
	</div>
	<div class="models">
		<input class="trainDone" type="hidden" value=1></input>
		<div class="title"> Gunshot Model List
			<div class="btn btn-small btn-info getModels">get</div>
		</div>
		<div class="training">
			<div class="subTitle">Train model: </div>
			<div class="trainIt">
				Selected Video Segments: <span class="featureCount"></span> <div class="btn btn-small selectAll">selectAll</div><br/>
				Model Name: <input class="modelName input-large" type="text"></input>
				<div class="train btn btn-primary">Train a Model Using Selected Features</div>
				<span class="info text-error"></span>
			</div>
		</div>
		<div class="modelTrainingProcess">
		<?php 
					$this->widget("ProgressWidget",array(
						"id" => "modelTrainingProgress",
						"doneCall" => "#gunshot > div.models > input.trainDone",
						"noMessage" => false,
					));
			?>
		</div>
		<div class="modellist">
			<div class="wrapLoading"><span class="muted"> click get to get all models</span></div>
		</div>
	</div>
</div>
