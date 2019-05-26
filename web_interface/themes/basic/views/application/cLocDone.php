
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
	#cLocDone{
		width:1100px;
		margin:30px auto;
		background-color:white;
		min-height:500px;
	}#cLocDone input{margin:0}
	#cLocDone > div.title{
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
	

</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	$(document).ready(function(){
		cw.post(cw.url+"locDone?datasetId=<?php echo $datasetId?>","",function(result){
			if(result.status == 0)
			{
				$("#cLocDone > div.wrapLoading").html("Done! Redirecting to main page...");
				window.open("<?php echo Yii::app()->baseUrl?>/index.php/application?datasetId=<?php echo $datasetId?>","_self");
			}
			else
			{
				alert("something wrong...");
			}
		});
	});
</script>
<div id="cLocDone">
	<div class="title">Localization done. Loading result...</div>
	<div class="wrapLoading" style="margin-top:100px;"><div class="loading"></div></div>
</div>