
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
	#cShowDataset{
		width:1100px;
		margin:30px auto;
		padding:20px 0;
		background-color:white;
	}
	#cShowDataset > div.title{
		text-align:center;
		font-weight:bold;
		font-size:1.2em;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cShowDataset > div.videoList > div.block > div.preview > img{
		max-height:200px;
		max-width:170px;
		min-height:none;
	}
	#cShowDataset > div.videoList > div.block {
		padding:5px 0;
		border-bottom:1px silver solid;
		margin-bottom:5px;
		padding-left:10px;
	}
	#cShowDataset > div.videoList > div.block > div.ctr{


	}
	#cShowDataset > div.videoList > div.block > div.ctr > div.detection{
		margin:5px;
		padding:5px;
		border:1px silver solid;
				width:150px;
		float:left;
	}
	#cShowDataset > div.videoList > div.block > div.ctr > div.detection > div.bub{
		height:40px;

		margin-bottom:7px;
		border-radius:5px;
		background-color:rgb(220,220,220);
		margin-right:5px;
		color:gray;
		font-weight:bold;
		font-size:1em;
		text-align:center;
		line-height:30px;
		border-top:3px transparent solid;
		cursor:pointer;
	}

	#cShowDataset > div.videoList > div.block > div.ctr > div.detection > div.bub.done{
		border-top:3px green solid;
	}
	#cShowDataset > div.videoList > div.block > div.ctr > div.title{
		text-align:center;
	}
</style>
<script type="text/javascript">
// click the any video detection
cw.ec("#cShowDataset > div.videoList > div.block > div.ctr > div.detection > div.bub",function(){
	var videoId = $(this).data("videoId");
	var videoname = $(this).data("videoname");
	//alert(videoname);
	if($(this).hasClass("gunshot"))
	{
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshot?videoname="+videoname,"_self");
	}
	if($(this).hasClass("person"))
	{
		//window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cPersonDetection?videoname="+videoname,"_self");
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cCrowdCounting?videoname="+videoname,"_self");
	}
});
	//click img to show one video
//assign all img to be shown big
/*
cw.ec("#cShowDataset img",function(){
	//var src = $(this).prop("src");
	//window.open(src,"_blank");
	var videoname = $(this).data("videoname");
	if(videoname != null)
	{
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname="+videoname,"_blank");
	}
});*/
</script>
<div id="cShowDataset">
	<div class="title"><?php echo $dataset[0]['datasetname']?></div>
	<div class="videoList">
	<?php foreach($dataset as $video){ ?>
		<div class="block">
			<div class="videoname">
				<?php echo $video['videoname']?>
				<a class="showVideo" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname=<?php echo $video['videoname']?>" target="_blank"><i class="icon icon-eye-open"></i></a>
			</div>
			<div class="preview">
				<?php if($video['hasImgs'] != 0){ 
					for($i=0;$i<$video['imgCount'];++$i){
				?>
				<img class="videoImg" data-videoname="<?php echo $video['videoname']?>" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/<?php echo $video['videoname']."_".$i;?>.png"></img>

				<?php }}else{ ?>
					No Preview Images Available.
				<?php } ?>
			</div>
			<?php if($showVideoDetection){ ?>
				<div class="ctr">
					<div class="detection">
						<div class="title">Sound Detection</div>
						<div class="bub gunshot <?php
							echo ($video['hasGunshotDetect']?"done":"");
						?>" data-videoId="<?php echo $video['videoId']?>" data-videoname="<?php echo $video['videoname']?>">
							Gunshot
						</div>
					</div>
					<div class="detection">
						<div class="title">Situation Awareness</div>
						<div class="bub person <?php
							echo ($video['hasPersonDetect']?"done":"");
						?>" data-videoId="<?php echo $video['videoId']?>" data-videoname="<?php echo $video['videoname']?>">
							Crowd Counting
						</div>
					</div>
					<!--
					<div class="detection">
						<div class="title">Object Detection</div>
						<div class="bub person <?php
							echo ($video['hasPersonDetect']?"done":"");
						?>" data-videoId="<?php echo $video['videoId']?>" data-videoname="<?php echo $video['videoname']?>">
							Person
						</div>
					</div>
					-->
					<div style="clear:both"></div>
				</div>
			<?php }?>
		</div>
		
	<?php } ?>
	</div>
</div>