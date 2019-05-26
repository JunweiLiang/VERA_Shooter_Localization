


<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		"#cIndex > input.gotoDatasetList",
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
	div.main {
		width:1200px;
		margin:20px auto;
		background-color:white;
		border-radius:5px;
		min-height:500px;

	}
	div.main > div.data > div.block{
		padding:5px;
		background-color:rgb(240,240,240);
		border-radius:5px;
		margin:15px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
	}
	div.main input{margin:0;}
</style>
<script type="text/javascript">
// load the data in page load
var data = {};
<?php foreach($items as $item){ ?>
	data[<?php echo $item['videoId']?>] = {"autoCutPoints":<?php echo $item['autoCutPoints']?>,"gtCutPoints":<?php echo $item['gtCutPoints']?>};
	
<?php } ?>
$(document).ready(function(){
		for(var videoId in data)
		{
			// remove last cuts
			
			data[videoId]['autoCutPoints'].pop();
			data[videoId]['gtCutPoints'].pop();
			console.log(videoId);
		}
	});

cw.ec("div.main > div.total > div > div.cal",function(){
	// get tol
	var tol = parseFloat($(this).parent().children("input.tol").val());
	d = getprf1(data,tol);
	//return;
	nocuts = filterOut(data,0,false);
	haveCuts = filterOut(data,0,true);
	d1 = getprf1(nocuts,tol);
	//return;
	d2 = getprf1(haveCuts,tol);
	//return;
	$("div.main > div.total > div > span.precision").html(d['p']);
	$("div.main > div.total > div > span.recall").html(d['r']);
	$("div.main > div.total > div > span.F1").html(d['f1']);

	$("div.main > div.total > div > span.n1").html(countDict(nocuts));
	$("div.main > div.total > div > span.precision1").html(d1['p']);
	$("div.main > div.total > div > span.recall1").html(d1['r']);
	$("div.main > div.total > div > span.F11").html(d1['f1']);
	$("div.main > div.total > div > span.fp").html(d1['fp']);

	$("div.main > div.total > div > span.n2").html(countDict(haveCuts));
	$("div.main > div.total > div > span.precision2").html(d2['p']);
	$("div.main > div.total > div > span.recall2").html(d2['r']);
	$("div.main > div.total > div > span.F12").html(d2['f1']);
});
function countDict(dataDict)
{
	var count=0;
	for(var id in dataDict)
	{
		count++;
	}
	return count;
}
// filter the data for video with a number of cuts
function filterOut(data,thres,isSmaller)// if is smaller, then smaller than thres will be filtered
{
	var newdata = {};
	for(var id in data)
	{
		if(isSmaller)
		{
			if(data[id]['gtCutPoints'].length > thres)
			{
				newdata[id] = data[id];
			}
		}
		else
		{
			if(data[id]['gtCutPoints'].length <= thres)
			{
				newdata[id] = data[id];
			}
		}
	}
	return newdata;
}
function getprf1(data,tol)
{
	// get stuff
	var tp = 0,fp = 0,tn=0,fn=0;
	//var fpList = "";
	for(var id in data)
	{
		

		var autoPoints = data[id]['autoCutPoints'];
		var gtPoints = data[id]['gtCutPoints'];
		var debug = "";
		//if(gtPoints.length != 33)continue;
		//console.log(JSON.stringify(autoPoints));
		//console.log(JSON.stringify(gtPoints));
		//tp, go through all gt check if in auto
		for(var i=0;i<autoPoints.length;++i)
		{
			if(isIn(autoPoints[i],gtPoints,tol))
			{
				tp+=1;
				debug+=autoPoints[i]+" ";
			}
			else
			{
				fp+=1;
				//fpList+=autoPoints[i]+" ";
			}
		}
		
		for(var i=0;i<gtPoints.length;++i)
		{
			if(!isIn(gtPoints[i],autoPoints,tol))
			{
				fn+=1;
			}
		}
		/*
		console.log(tp);
		console.log(fp);
		console.log(debug);
		return;*/
	}
	//console.log(fpList);
	var precision=0.0,recall=0.0;
	if(tp+fp>0) precision = tp/parseFloat(tp+fp);
	if(tp+fn>0) recall = tp/parseFloat(tp+fn);
	var f1 = 0.0;
	if(precision+recall >0) f1 = 2*(precision*recall)/(precision+recall);
	return {"p":precision.toFixed(5),"r":recall.toFixed(5),"f1":f1.toFixed(5),'fp':fp};
}
function isIn(cutPoint, pointList,tol)
{
	var itIsIn = false;
	for(var i=0;i<pointList.length;++i)
	{
		if(Math.abs(cutPoint - pointList[i]) < tol)
		{
			itIsIn = true;
			break;
		}
	}
	return itIsIn;
}
</script>
<div class="main">
	<div class="total">
		<div class="wrapLoading">
			total video in exp: <?php echo $VideoCutExp->name?>  is <?php echo $totalExpVideos?>;
			<?php echo count($items)?> have ground truth.
			<br/>
			tolerate (within how many seconds it is the same cut): <input class="tol input-small" type="text" value="0.5"></input>
			<div class="btn btn-small btn-primary cal">Calculate</div>
			<a class="btn btn-small" target="_self" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabeling?expId=<?php echo $expId?>">Back to Annotation</a>
			<a class="btn btn-small" target="_blank" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cVideoCutExpLabelCalculate?expId=<?php echo $expId?>&d=1&useAllGt=<?php echo $useAllGt?>">downloadResult</a>
			<br/>
			Overall
			precision: <span class="text-error precision"></span>
			recall: <span class="text-error recall"></span>
			F1: <span class="text-error F1"></span>
			<br/>
			video with no cuts (<span class="text-error n1"></span>)
			precision: <span class="text-error precision1"></span>
			recall: <span class="text-error recall1"></span>
			F1: <span class="text-error F11"></span>
			false positives: <span class="text-error fp"></span>
			<br/>
			
			video with multiple cuts (<span class="text-error n2"></span>)
			precision: <span class="text-error precision2"></span>
			recall: <span class="text-error recall2"></span>
			F1: <span class="text-error F12"></span>
		</div>
	</div>
	<div class="data">
		<?php $cutCountDict = array();foreach($items as $item){ ?>
			<div class="block">
				<?php 
				$cutCount = count(json_decode($item['gtCutPoints'],true));
				if(!isset($cutCountDict[$cutCount]))$cutCountDict[$cutCount]=0;
				$cutCountDict[$cutCount]+=1;
				echo $item['expVideoId']." ".
					$item['videoname']." ".
					$item['autoCutPoints']." ".
					$item['gtCutPoints']. " gt ". $cutCount." cuts";
				?>
			</div>
		<?php } ?>
		<div class="cutCountTypes">
			<?php print_r($cutCountDict);?>
		</div>
	</div>
</div>