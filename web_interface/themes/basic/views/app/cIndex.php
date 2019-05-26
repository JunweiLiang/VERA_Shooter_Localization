<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type='text/css'>
	#cIndex > #siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cIndex > #projectList{
		
	}
</style>
<script type="text/javascript">
window.onhashchange = function(){
	//alert("hash change!");
}
</script>
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