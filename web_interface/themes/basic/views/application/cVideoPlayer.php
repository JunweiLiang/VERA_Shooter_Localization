
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
	#cVideoPlayer{
		width:1100px;
		margin:30px auto;
		min-height:500px;
		padding-bottom:30px;
		background-color:white;
	}
	#cVideoPlayer > div.workProgress{
		padding:30px;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cVideoPlayer > div.mainTitle{
		padding:15px;
		text-align:center;
		font-weight:bold;
		font-size:1.1em;
	}
	#cVideoPlayer > div.title{
		padding:10px;
		border-bottom:1px silver solid;
		margin-bottom:10px;
		color:gray;
		font-weight:bold;margin-top:10px;
	}
	#cVideoPlayer > div.sync > div.block,
	#cVideoPlayer > div.loc > div.block{
		background-color:white;
		border-radius:5px;
		padding:10px;
		margin-right:20px;
		margin-bottom:10px;
		float:left;
		-moz-box-shadow:0 2px 2px #999;              
 	  -webkit-box-shadow:0 2px 2px #999;           
 	   box-shadow:0 2px 2px #999;
 	   border:1px silver solid;
 	   cursor:pointer;
 	   color:rgb(0,128,192);
 	   font-weight:bold;
	}
	#cVideoPlayer > div.sync,
	#cVideoPlayer > div.loc {
		padding:20px;
	}
	#cVideoPlayer > div.sync > div.block.toggle,
	#cVideoPlayer > div.loc > div.block.toggle{
		color:white;
		background-color:rgb(0,128,192);
	}
	#cVideoPlayer > div.ctr{
		margin:20px;
	}
</style>
<script type="text/javascript">
	//click a cluster
	cw.ec("#cVideoPlayer > div.sync > div.block",function(){
		$("#cVideoPlayer > div.sync > div.block").removeClass("toggle");
		$(this).addClass("toggle");
		$("#cVideoPlayer > div.ctr > div.link").html("");
	});
	cw.ec("#cVideoPlayer > div.loc > div.block",function(){
		$("#cVideoPlayer > div.loc > div.block").removeClass("toggle");
		$(this).addClass("toggle");
		$("#cVideoPlayer > div.ctr > div.link").html("");
	});
	// delete loc2datasetId
	cw.ec("#cVideoPlayer > div.loc > div.block > div.delete",function(){

		var data = {};
		data.loc2datasetId = $(this).parent().children("input.loc2datasetId").val();
		data.locName = $(this).parent().children('input.locName').val();
		data.datasetId = <?php echo $datasetId?>;
		if(!confirm("Confirm delete localization result "+data.locName+"?"))
		{
			return;
		}
		cw.post(cw.url+"deleteLoc",data,function(result){
			if(result.status == 0)
			{
				$(this).remove();
			}
		},$(this).parent());
		$(this).parent().html('<div class="loading"></div>');
	});
	// click go,
	cw.ec("#cVideoPlayer > div.ctr > div.go",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.datasetId = <?php echo $datasetId?>;
		data.clusterId = $("#cVideoPlayer > div.sync > div.block.toggle > input.clusterId").val();
		if(data.clusterId == null)
		{
			$(this).parent().children("span.info").html("You need to select a Sync Cluster").emptyLater();
			return;
		}
		data.loc2datasetId = $("#cVideoPlayer > div.loc > div.block.toggle > input.loc2datasetId").val();
		if(data.loc2datasetId == null)
		{
			data.loc2datasetId = 0;
		}
		$(this).addClass("disabled").parent().children("span.info").html("<div class='loading'></div>");
		$("#cVideoPlayer > div.ctr > div.link").html("");
		cw.post(cw.url+"makeRashJson",data,function(result){
			$(this).removeClass("disabled").parent().children("span.info").html("Done, click the following link for more").emptyLater();
			if(result.status == 0)
			{
				//var link = "/human-rights/rashomon-play?play="+result.jsonFileName;
				var link = "/human-rights/rashomon-play/result/"+result.jsonFileName;
				$("#cVideoPlayer > div.ctr > div.link").html(
					'<a href="'+link+'" target="_blank">Play results in a new window</a> <br/>'+
					'<a href="<?php echo Yii::app()->baseUrl?>/'+result.jsonPath+'" target="_blank">Download result\'s json file</a>'
				);
				//window.open(link,"_blank"); // will be block
			}
		},$(this));
	});
</script>
<div id="cVideoPlayer">
	<div class="workProgress">
	<?php 
			$this->widget("DaisyProgressWidget",array(
				'id' => "daisyProgress",
				'datasetId' => $datasetId,
			));
		?>
	</div>
	<div class="mainTitle">Video Player for <span class="text-info"><?php echo $datasetname?></span></div>
	<div class="title">Select Synchronized Video Group</div>
	<div class="sync">
		<?php $count=1;foreach($syncClusters as $one){ ?>
			<div class="block">
				<input class="clusterId" type="hidden" value="<?php echo $one['id']?>"></input>
				<?php echo $count?>) <?php echo $one['videoNum']?> videos
				<?php echo ($one['isAuto'] ==1)?"":"(customized)";?>
				<?php echo empty($one['refineName'])?"":("(".$one['refineName'].")")?>
			</div>
		<?php $count++;} ?>
		<div style="clear:both"></div>
	</div>
	<div class="title">Select Geo-tagged Image Collection</div>
	<div class="loc">
		<?php $count=1;foreach($locClusters as $one){ ?>
			<div class="block">
				<input class="loc2datasetId" type="hidden" value="<?php echo $one['loc2datasetId']?>"></input>
				<input class="locName" type="hidden" value="<?php echo $one['locName']?>"></input>
				<?php echo $count?>) <?php echo $one['locName']?>
				<div class="close delete" style="padding:0 5px">&times;</div>
			</div>
		<?php $count++;} ?>
		<?php if(count($locClusters) == 0){ ?>
		<div class="wrapLoading"><div class="muted">No localization results yet.</div></div>
		<?php } ?>
		<div style="clear:both"></div>
	</div>
	<div class="title">Watch Results</div>
	<div class="ctr">
		<div class="btn btn-primary go">Get Result</div>
		<!--<a class="btn back" href="<?php echo Yii::app()->baseUrl?>/index.php/application?datasetId=<?php echo $datasetId?>" target="_self">Cancel</a>-->
		<span class="text-error info"></span>
		<div class="link" style="margin-top:10px;"></div>
	</div>
</div>