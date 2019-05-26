
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
	#cVideoTiler{
		width:1100px;
		margin:30px auto;
		min-height:500px;
		padding-bottom:30px;
		background-color:white;
	}
	#cVideoTiler > div.workProgress{
		padding:30px;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cVideoTiler > div.mainTitle{
		padding:15px;
		text-align:center;
		font-weight:bold;
		font-size:1.1em;
	}
	#cVideoTiler > div.title{
		padding:10px;
		border-bottom:1px silver solid;
		margin-bottom:10px;
		color:gray;
		font-weight:bold;
		margin-top:10px;
	}
	#cVideoTiler > div.sync > div.block{
		background-color:white;
		border-radius:5px;
		padding:10px;
		margin-right:20px;
		float:left;
		-moz-box-shadow:0 2px 2px #999;              
 	  -webkit-box-shadow:0 2px 2px #999;           
 	   box-shadow:0 2px 2px #999;
 	   cursor:pointer;
 	   color:rgb(0,128,192);
 	   font-weight:bold;
 	   border:1px silver solid;
 	   margin-bottom:10px;
	}
	#cVideoTiler > div.sync {
		padding:20px;
	}
	#cVideoTiler > div.sync > div.block.toggle{
		color:white;
		background-color:rgb(0,128,192);
	}
</style>
<script type="text/javascript">

	//click a cluster
	cw.ec("#cVideoTiler > div.sync > div.block",function(){
		$("#cVideoTiler > div.sync > div.block").removeClass("toggle");
		$(this).addClass("toggle");
		// search for tiled player
		getTilerVideo($(this).children("input.clusterId").val());
	});
	// click process
	cw.ec("#cVideoTiler > div.ctr > div.go",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.datasetId = <?php echo $datasetId?>;
		data.clusterId = $("#cVideoTiler > div.sync > div.block.toggle > input.clusterId").val();
		if(data.clusterId == null)
		{
			$(this).parent().children("span.info").html("You need to select a Sync Cluster").emptyLater();
			return;
		}
		$(this).addClass("disabled").parent().children("span.info").html("<div class='loading'></div>");
		$("#cVideoTiler > div.ctr > div.link").html("");
		cw.post(cw.url+"runVideoTiler",data,function(result){
			$(this).removeClass("disabled").parent().children("span.info").html("Request Sent...").emptyLater();
			if(result.status == 0)
			{
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#videoTilerProgress > input.processId").val(result.processId);
					$("#videoTilerProgress > input.showing").val(1).change();
					$("#videoTilerProgress > input.updating").val(1).change();
				}
			}
		},$(this));
	});
	cw.ech("#cVideoTiler > div.ctr > input.done",function(){
		var clusterId = $("#cVideoTiler > div.sync > div.block.toggle > input.clusterId").val();
		getTilerVideo(clusterId);
	});
	function getTilerVideo(clusterId)
	{
		var data = {};
		data.datasetId = <?php echo $datasetId?>;
		data.clusterId = clusterId;
		$('#cVideoTiler > div.ctr > span.info').html('<div class="loading"></div>');
		$('#cVideoTiler > div.ctr > div.link').html("");
		$("#cVideoTiler > div.ctr > div.go").addClass("disabled");
		cw.post(cw.url+"getERtileVideo",data,function(result){
			$('#cVideoTiler > div.ctr > span.info').html('');
			if(result.status == 0)
			{
				if(result.videoPath != "")
				{
					$('#cVideoTiler > div.ctr > div.link').html('<a href="<?php echo Yii::app()->baseUrl?>/'+result.videoPath+'" target="_blank">Download Tiled Video</a>');
				}
				else
				{
					$("#cVideoTiler > div.ctr > div.go").removeClass("disabled");
				}
			}
		});
	}
</script>
<div id="cVideoTiler">
	<div class="workProgress">
	<?php 
			$this->widget("DaisyProgressWidget",array(
				'id' => "daisyProgress",
				'datasetId' => $datasetId,
			));
		?>
	</div>
	<div class="mainTitle">Video Tiler for <span class="text-info"><?php echo $datasetname?></span></div>
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
	<div class="title">Video Tiler</div>
	<div class="ctr" style="margin:20px;">
		<input class="done" type="hidden"></input>
		<div class="btn btn-primary go">Process</div>
		<!--
		<a class="btn back" href="<?php echo Yii::app()->baseUrl?>/index.php/application?datasetId=<?php echo $datasetId?>" target="_self">Cancel</a>-->
		<span class="text-error info"></span>
		<div class="line">
			<?php 
				$this->widget("ProgressWidget",array(
					"id" => "videoTilerProgress",
					"doneCall" => "#cVideoTiler > div.ctr > input.done",
					"noMessage" => false,
				));
			?>
		</div>
		<div class="link" style="margin-top:10px;"></div>
	</div>
</div>