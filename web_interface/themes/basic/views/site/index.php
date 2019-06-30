<?php 
	/*****************
	@author Junwei Liang<junweil@cs.cmu.edu>  in 2019.03
	****************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta  http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />  
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datepicker.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datetimepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/cssReset.css"/>
    <script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.mobile.touch.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.zh-CN.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
	<?php /*包含各种封装的函数与类*/ ?>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/basic.js"></script>
	<title><?php echo Yii::app()->name?></title>
</head>
<body id='bodyTop'>

<style type='text/css'>
	body{
		font-family:"Roboto", sans-serif,arial,"Microsoft YaHei",Helvetica;
		font-size:15px;
	}
	/*
		div.content:
			provide the content div in the middle
	*/
	body div.content{
		/*width:1280px;*/
		width:1000px;
		margin:0 auto;
		line-height:30px;
	}
	/*
		header wrapper
	*/
	body div.header{
		background-color:#2196F3;
	}
	body div.header > div.content{
		padding:10px;
	}
	/*
		footer1
	*/
	body div.footer1{
		margin-top:30px;
		background-color:#64B5F6;
	}
	body div.footer1 > div.content{
		position:relative;
	}
	body div.footer1 > div.content > div.logos{
		width:650px;
		position:absolute;
		top:0;
		right:0;
		text-align:right;
		padding:30px 0;
	}
	body div.footer1 > div.content > div.logos > img.logo{
		max-height:100px;
		max-width:300px;
		margin-left:50px;
		margin-right:0;
	}
	/*
		footer2
	*/
	body div.footer2{
		background-color:#2196F3;
	}
	body div.footer > div.content{
		padding:10px;
	}
	body div.footer1 > div.content{
		padding:20px;
		line-height:40px;
		font-size:1.2em;
	}
	/*
		utils css
	*/
	div.white-text{
		color:white;
	}
	div.content > div.title{
		padding:30px 0;
		border-top:1px silver solid;
		margin-top:30px;
		font-size:2em;
		font-weight:700;
	}
	body a{
		text-decoration:none;
		color:inherit;
	}
	div.content ul{
		list-style: disc inside none;
	}
	div.content ol{
		list-style: decimal inside none;
	}
	div.content li{
		line-height:30px;
		padding-bottom:5px;
	}
	div.content div.float-right{
		float:right;
	}
</style>
<!-- memexqa -->
<style type="text/css">
div.header > div.nav.content{
	height:50px;
	padding:0;
}
div.header > div.nav > a.block{
	float:left;
	width:100px;
	padding:10px;
	text-align:center;
	color:white;
	cursor:pointer;
	text-decoration:none;
	display:block;
	color:white;
	font-weight:bold;
}
div.header > div.nav > a.block:hover{
	background-color:#64B5F6;
}

</style>
<style type="text/css">
div.content.main{
	padding:50px 0;
	padding-bottom:10px;
	min-height:1000px;
}
div.content > div.logos{
	padding:30px 0;
	text-align:center;
}
div.content > div.logos > img.logo{
	max-height:100px;
	max-width:350px;
	margin-right:50px;
}
div.content.main > div.mainTitle{
	text-align:center;
	line-height:80px;
	padding:20px 10px;
	font-weight:bold;
	font-size:2.3em;
}
div.content.main > div.authors, div.content.main > div.publication{		
	font-size:1.3em;
	color:gray;
	text-align:center;
}
div.content.main > div.institutions{
	font-weight:bold;
	font-size:1.3em;
	color:gray;
	text-align:center;
}
div.content.main > div.links{
	text-align:center;
	padding:30px 0;
}

div.log > ul > li > span.title,div.log > ul > li > div.time{
	font-weight:bold;
	font-size:1.1em;
}
div.log > ul > li > div.info{
	padding-left:20px;
	word-wrap:break-word;
}
div.dataset > ul > li > span.title,div.dataset > ul > li > div.time{
	font-weight:bold;
	font-size:1.1em;
}
div.dataset > ul > li > div.info{
	padding-left:20px;
	word-wrap:break-word;
}
div.content div.caption{
	text-align:center;
	font-size:1.2em;
	font-weight:bold;
}
div.content div.figure{
	padding:10px 0;
}
div.content div.subTitle{
	padding:10px;
	padding-left:50px;
	font-size:1.5em;
	font-weight:bold;
	color:#A31F34;
}
div.guide_text{
	padding:5px;
	padding-left:50px;
	font-size:1.2em;
}
div.content ol.term > li{
	padding-left:50px;
	color:red;
}
div.content div.intro{
	padding:20px 0;
	font-size:1.2em;
	font-weight:400;
}
</style>

<div class="header">
	<div class="content white-text nav">
		<?php if(!$is_logged_in){ ?>
			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/site/login?redirect=<?php echo $redirect?>">Login</a>
			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/site/register">Register</a>
		<?php }else{ ?>
			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/application">VERA<sup style="font-size:50%;vertical-align:super">Alpha</sup></a>
		<?php } ?>
	</div>
</div>

<div class="content main">
	<div class="mainTitle">The Video Event Reconstruction and Analysis (VERA) System - Shooter Localization from Social Media Videos</div>
	<div class="authors">
		<a style="text-decoration:none" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>,
		<a style="text-decoration:none" href="https://www.cmu.edu/dietrich/history/people/faculty/aronson.html">Jay D. Aronson</a>,
		<a href="https://www.cs.cmu.edu/~alex/">Alexander Hauptmann</a>
	</div>
	<div class="institutions">
		Carnegie Mellon University
	</div>
	<div class="links" style="font-weight:bold">
		<a class="btn btn-info" href="https://arxiv.org/abs/1905.13313">Technical Report</a>
		&nbsp;&nbsp;&nbsp;
		<a class="btn btn-info" href="#bib">BibTex</a>
		&nbsp;&nbsp;&nbsp;
		<a class="btn btn-info" href="https://github.com/JunweiLiang/VERA_Shooter_Localization">Source Code/Models</a>
		&nbsp;&nbsp;&nbsp;
		<a class="btn btn-success" href="VERA_3D_Reconstruction/">3D Reconstruction</a>
	</div>
	<div class="intro" style="text-align:center;font-size:1.2em;line-height:50px;font-weight:bold;">
		We introduce the VERA system, enabled by established machine learning techniques and physics models, that can localize the shooter location only based on a couple of user-generated videos that capture the gunshot sound.
		<br/>
		<img style="height:230px;margin-right:20px;"src="<?php echo Yii::app()->baseUrl;?>/documents/method1.png"></img>
		<img style="height:230px;margin-right:0px;"src="<?php echo Yii::app()->baseUrl;?>/documents/method2.png"></img>
		<br/>
		We estimate shooter distance for each camera and estimate shooter direction for each pair of cameras. 
	</div>
	<div class="demoVideo" style="text-align:center">
		<iframe width="450" height="320" src="https://www.youtube.com/embed/z0KFTXg5sqI" frameborder="0" allowfullscreen></iframe>
		<iframe width="450" height="320" src="https://www.youtube.com/embed/6q7LqqzrY2I" frameborder="0" allowfullscreen></iframe>
		<br/>
		<span style="font-size:1.2em;font-weight:bold">Demo Video</span>		
	</div>
	<div class="resources">
		<ol style="font-size:1.2em;">
			<li>For full technical details, please refer to our <a style="color:#49afcd" href="https://arxiv.org/abs/1905.13313">technical report</a>. Please report on Github if you find any detail missing in the report.</li>
			<li>We have released all of our source code on <a style="color:#49afcd" href="https://github.com/JunweiLiang/VERA_Shooter_Localization">Github</a>. We encourage researchers and engineers to help continue improving this system.</li>
		</ol>
		<div class="citations" style="font-size:1.2em;">
			<a name="bib"></a>
			If you find this system helpful to your project/report/research, please cite the following papers:
			<textarea style="width:90%;height:480px;cursor: text;" disabled>@article{liang2019vera,
  	title={Technical Report of the Video Event Reconstruction and Analysis (VERA) System - Shooter Localization, Models, Interface, and Beyond},
  	author={Liang, Junwei and Aronson, Jay D. and Hauptmann, Alexander},
  	journal={arXiv preprint arXiv:1905.13313},
  	year={2019}
}
@inproceedings{liang2017synchronization,
  title={Synchronization for multi-perspective videos in the wild},
  author={Liang, Junwei and Huang, Poyao and Chen, Jia and Hauptmann, Alexander},
  booktitle={2017 IEEE International Conference on Acoustics, Speech and Signal Processing (ICASSP)},
  pages={1592--1596},
  year={2017},
  organization={IEEE}
}
@inproceedings{liang2017temporal,
  title={Temporal localization of audio events for conflict monitoring in social media},
  author={Liang, Junwei and Jiang, Lu and Hauptmann, Alexander},
  booktitle={2017 IEEE International Conference on Acoustics, Speech and Signal Processing (ICASSP)},
  pages={1597--1601},
  year={2017},
  organization={IEEE}
}
			</textarea>
		</div>
	</div>
</div>
<div class="content guide">
	<a name="guide"></a>
	<div class="title">User Guide</div>
	<div class="subTitle">Step 1. Upload Your Videos</div>
	<div class="guide_text">
		Click "Create New Collection" button and then click "Upload New Videos" to upload your videos to a video collection. Given this collection a name and then click "Create Collection" to finish this process. Note that currently you cannot add new videos after this step.
	</div>
	<div class="subTitle">Step 2. Video Synchronization</div>
	<div class="guide_text">
		In this step, we will synchronize the videos and put them into a global timeline. First click "Run Video Synchronization" to run automatic synchronization. After it is finished, you will see the videos in a global timeline control panel:
		<br/>
		<img src="<?php echo Yii::app()->baseUrl?>/documents/guide_1.png"></img>
		<br/>
		You can modify the global time offset of each video here and then click "save offsets" button to save the new time offsets. However, to ensure more accurate video synchronization result, we recommend users to conduct pairwise verification at the video frame-level, by clicking the "Manual Refine" button and go to the global synchronization page.
		<br/>
		In the global synchronization page, you will see "Click each video to confirm results pairwisely" on the right. Click each video to go into the pairwise verification papge. In the verification papge, on the left it is the video you just selected, on the right is the list of all other videos. For each of the other video, click "Load Video" button to load the video on the webpage. When you click "Play Sync from Left Video", both videos will play based on the current offset. You can adjust the offset and click "Save Offset" to save the new offset. For accurate frame-level synchronization, click "Frame View" and "Get Frames" for both videos. Click "Show Current Video Frame" to jump to the frame ID that your videos stop at. Click "Prev" or "Next" on top of the frames until you find a perfect visual synchronization. Then click "Get Offset from FramePair" to get the current synchronization into the offset. Click "Save Offset". When you are satisfy with the offset, remember to click "Correct".
		<br/>
		After pairwise synchronization, go back to the global synchronization page. Click "Refine Based on Confirmed Pairs" to run global synchronization based on your confirmed pairwise results.
	</div>
	<div class="subTitle">Step 3. Gunshot Marking</div>
	<div class="guide_text">
		In this step, we will first add information for each gunshot. Click "New Gunshot" and then enter the information. Then for each of the gunshot added, we will need to mark the bullet shockwave sound (if it is supersonic) and the muzzle blast sound. In the "Mark the Gunshot in Videos" section, click "Mark Gunshot" of each video. 
		If the video is too long and you are not sure where the gunshot is, click "Run Gunshot Detection" and it will run our gunshot detection model on this video. The gunshot segment will be labeled red on the timeline.
		To aide the marking, we provide spectrogram and power graph for users to mark the sounds. Enter the start and end time of the video, click "Show Spectrogram" and the graph will be generated:
		<br/>
		<img src="<?php echo Yii::app()->baseUrl?>/documents/guide_2.png"></img>
		<br/>
		Click on the graph to mark the time of the sounds. Click "Save" when you are done. You will need to mark each gunshot for each of the videos.
	</div>
	<div class="subTitle">Step 4. Video Localization per Gunshot</div>
	<div class="guide_text">
		In this final step, we will visualize possible shooter locations for each gunshot. You will need to mark each camera location on the map at the time of the gunshot.
		<br/>
		<img src="<?php echo Yii::app()->baseUrl?>/documents/guide_3.png"></img>
		<br/>
	</div>
</div>
<div class="content log">
	<a name="log"></a>
	<div class="title">Release Log</div>
	<ul>
		<li>
			<span class="title"> [06/2019]: Code and model released.</span> 
		</li>
		<li>
			<span class="title"> [05/2019]: Alpha version released.</span> 
		</li>
	</ul>
</div>

<div class="footer footer1">
	<div class="content white-text">
		<div class="logos">
			<img class="logo" src="<?php echo Yii::app()->theme->baseUrl;?>/img/ltilogo.png"></img>
		</div>
		Informedia Lab, Carnegie Mellon University <br/>
		School of Computer Science <br/>
		Language Technologies Institute
	</div>
<div class="footer footer2">
	<div class="content white-text">
		Designed and created by <a href="https://cs.cmu.edu/~junweil">Junwei Liang</a> at CMU.
	</div>
</div>

</body>
</html>