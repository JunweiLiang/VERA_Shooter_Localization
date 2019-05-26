<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?>{
		/*background-color:<?php echo COLOR1_LIGHTER1_LIGHT;?>;*/
		background-color:white;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
		position:relative;
	}
	#<?php echo $id?> > div.main{
		position:relative;	
	}
	#<?php echo $id?> > div.workDetailContainer{
		position:absolute;
		top:0;
		left:0;
		width:100%;
	}
	#<?php echo $id?> > div.main > div.header{
		padding:10px;
		position:relative;
		
	}
	#<?php echo $id?> > div.main > div.header > div.touch{
		float:left;
		cursor:pointer;
		padding:0px 10px;
		line-height:30px;
		border-radius:3px;
		width:auto!important;
		width:50px;
		min-width:50px;
		word-break:break-all;
	}
	
	#<?php echo $id?> > div.main > div.header > div.touch:hover{
		/*background-color:<?php echo COLOR1_LIGHTER1?>;*/
		background-color:rgb(240,240,240);
	}
	#<?php echo $id?> > div.main > div.header > div.showSlider:hover{
		/*background-color:<?php echo COLOR1_LIGHTER1?>;*/
		width:40px;
	}
	#<?php echo $id?> > div.main > div.header > div.showSlider{
		position:absolute;
		top:10px;right:0;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
		cursor:pointer;
		padding:10px;
		border-radius:3px;
		width:15px;
		height:15px;
		overflow:hidden;
		background-color:rgb(245,245,245);
	}
	#<?php echo $id?> > div.main > div.header > div.projectName{
		font-weight:bold;
		font-size:1.2em;
	}
	#<?php echo $id?> > div.main > div.header > div.projectIntro{
		font-size:0.9em;
	}
	#<?php echo $id?> > div.sliderContainer{
		overflow:hidden;
		/*position:absolute;
		top:0;
		left:0;
		width:100%;
		height:100%;*/
	}
	#<?php echo $id?> > div.sliderContainer > div.slider > div.body{
		overflow-y:auto;
		height:100%;
		width:100%;
		position:absolute;
		top:0;
		left:0;
	}
	#<?php echo $id?> > div.sliderContainer > div.slider > div.body > #projectPerson1{
		padding:12px 12px 80px 12px;
	}
	#<?php echo $id?> > div.sliderContainer > div.slider{
		position:absolute;
		top:0px;
		right:-330px;/*30px for slideBack*/	
		border-radius:3px;
		width:288px;
		background-color:rgb(245,245,245);
		-moz-box-shadow:0 1px 2px #999;              
 	  -webkit-box-shadow:0 1px 2px #999;           
 	   box-shadow:0 1px 2px #999;
 	   z-index:99;
 	   height:100%;
 	   	overflow-y:visible; 	
 	   	overflow-x:visible;
	}
	#<?php echo $id?> > div.sliderContainer > div.slider > div.header{
		text-align:center;
		position:relative;
	}
	#<?php echo $id?> > div.sliderContainer > div.slider > div.header > div.slideBack{
		cursor:pointer;
		position:absolute;
		top:10px;
		left:-30px;/*30px for slideBack*/
		padding:10px 0;
		border-radius:3px 0 0 3px;
		-moz-box-shadow:-1px 1px 1px #999;              
 	  -webkit-box-shadow:-1px 1px 1px #999;           
 	   box-shadow:-1px 1px 1px #999;
		background-color:rgb(245,245,245);
		width:30px;
	}
	#<?php echo $id?> > div.sliderContainer > div.slider > div.header > div.slideBack:hover{
		background-color:<?php echo COLORDARK?>;
		width:28px;
		left:-28px;
	}
	
	#<?php echo $id?> > div.main > div.header > div.pop-up{
		position:absolute;
		border-radius:5px;
		top:35px;
		display:none;
		background-color:white;
		-moz-box-shadow:0 1px 6px #999;              
 	   -webkit-box-shadow:0 1px 6px #999;           
 	   box-shadow:0 1px 6px #999;
 	   z-index:999;
 	   width:300px;
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectIntro{
		top:60px;
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up > div.delete{
		position:absolute;
		top:10px;
		right:3px;
		cursor:pointer;
		width:25px;
		height:25px;
		color:gray;
		font-weight:bold;
		opacity:1;
		filter:alpha(opacity=100); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up > div.title{
		text-align:center;
		padding:10px 0;
		margin:0px 10px;
		margin-bottom:5px;
		border-bottom:1px <?php echo COLORDARKER?> solid;
		color:gray;
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up > div.content{
		padding:10px;
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up > div.content > div.line {
		padding-bottom:5px;
	}
	#<?php echo $id?> > div.main > div.header > div.pop-up > div.content > div.line > .edit{
		width:265px;
	}
	
	#<?php echo $id?> > div.main > div.canvas{
		position:relative;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task{
		background-color:<?php echo COLORDARK?>;
		border-radius: 3px;
		width: 260px;
		padding: 4px 3px 3px;
		position: relative;
		margin: 0 5px;
		-moz-box-shadow:0 1px 2px #999;              
 	   -webkit-box-shadow:0 1px 2px #999;           
 	   box-shadow:0 1px 2px #999;
	}
	/*电脑屏幕，横排canvas task*/
	@media screen and (min-width:500px)
	{
		#<?php echo $id?> > div.main > div.canvas > #canvas{
			-ms-flex-align: start;
			-moz-box-align: start;
			-webkit-box-align: start;
			-webkit-align-items: flex-start;
			align-items: flex-start;
			display: -moz-box;
			display: -ms-flexbox;
			display: -webkit-box;
			display: -webkit-flex;
			display: flex;
			-moz-box-orient: horizontal;
			-webkit-box-orient: horizontal;
			-ms-flex-direction: row;
			-webkit-flex-direction: row;
			flex-direction: row;
			flex-wrap: nowrap;
			margin-bottom: 10px;
			overflow-x: auto;
			overflow-y: hidden;
			padding-bottom: 10px;
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		  
		}
		/* 项目总面板滚动条!*/
		#<?php echo $id?> > div.main > div.canvas > #canvas::-webkit-scrollbar {
			height: 13px;
			width: 13px;
		}
		#<?php echo $id?> > div.main > div.canvas > #canvas::-webkit-scrollbar-button {
			display: block;
			height: 5px;
			width: 5px;
		}
		#<?php echo $id?> > div.main > div.canvas > #canvas::-webkit-scrollbar-track-piece {
			background: rgba(0,0,0,.15);
			border-radius:5px;
		}
		#<?php echo $id?> > div.main > div.canvas > #canvas::-webkit-scrollbar-thumb{
			background:#c2c2c2;
			border-radius:5px;
			display:block;
			height:50px
		}	
		#<?php echo $id?> > div.main > div.canvas > #canvas > div.task:first-child{
			margin-left:10px;
		}	
		#<?php echo $id?> > div.main > div.canvas > #canvas > div.task{
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			display: -moz-box;
			display: -ms-flexbox;
			display: -webkit-box;
			display: -webkit-flex;
			display: flex;
			-moz-box-orient: vertical;
			-webkit-box-orient: vertical;
			-ms-flex-direction: column;
			-webkit-flex-direction: column;
			flex-direction: column;
			-moz-box-flex: 0;
			-webkit-box-flex: 0;
			-ms-flex: 0 0 260px;
			-webkit-flex: 0 0 260px;
			flex: 0 0 260px;
			max-height: 100%;			
			-webkit-transform: translate3d(0,0,0);
		}
	}
	/*手机屏幕的排版使用竖排?*/
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.canvas > #canvas > div.task{
			width: 90%;
			padding: 4px 1%;
			margin: 0px 4%;
			margin-bottom:30px;
		}
		#<?php echo $id?> > div.main > div.canvas > #canvas
		{
			/*background-color:<?php echo COLOR1_LIGHTER1_LIGHT;?>;*/
			background-color:white;
			padding-bottom:80px;
		}
		#<?php echo $id?> > div.main.sliderContainer{
		}
	}
	
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.close{
		position:absolute;
		top:8px;
		right:8px;
		
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.addTask{
		text-align:center;
		color:black;
		cursor:pointer;
		padding:5px 0;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.ctr{
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.ctr > div.line > input.taskName{
		width:94%;
		padding:3px 3%;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header{
		padding:5px;
		font-size:1em;
		font-weight:bold;
		-moz-box-flex: 0;
		-webkit-box-flex: 0;
		-ms-flex: 0 0 auto;
		-webkit-flex: 0 0 auto;
		flex: 0 0 auto;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.taskName{
		cursor:pointer;
		word-break:break-all;
		width:90%;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr{
		
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr > div.line{
		padding:3px 0;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr > div.line > textarea{
		width:85%;
		background-color:<?php echo COLORDARK?>;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body{
		-moz-box-flex: 1;
		-webkit-box-flex: 1;
		-ms-flex: 1 1 auto;
		-webkit-flex: 1 1 auto;
		flex: 1 1 auto;
		margin-bottom: 0;
		overflow-y: auto;
		overflow-x: hidden;
		padding: 0 5px;
		z-index: 1;
	}
	/* 任务面板滚动条!*/
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body::-webkit-scrollbar {
		height: 9px;
		width: 9px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body::-webkit-scrollbar-button {
		display: block;
		height: 5px;
		width: 5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body::-webkit-scrollbar-track-piece {
		background: <?php echo COLORDARK?>;
		border-radius:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body::-webkit-scrollbar-thumb{
		background:<?php echo COLORDARKERER?>;
		border-radius:5px;
		display:block;
		height:50px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork{
		-moz-box-flex: 0;
		-webkit-box-flex: 0;
		-ms-flex: 0 0 auto;
		-webkit-flex: 0 0 auto;
		flex: 0 0 auto;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork {
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.addWork{
		cursor:pointer;
		border-radius:3px;	
		color:gray;
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.addWork:hover{
		background-color:<?php echo COLORDARKER?>;		
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.ctr > div.line > textarea.workName{
		width:94%;
		padding:3px 3%;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.ctr > div.line{
		padding-bottom:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work{
		background-color:white;
		border-bottom:1px silver solid;
		padding:5px 5px;
		border-radius:3px;
		cursor:pointer;
		margin-bottom:5px;
		/*
			max-width:300px;
		*/
		word-break:break-all;
		height:auto!important;
		height:20px;
		min-height:20px;
		position:relative;
		z-index:0;
		display:block;
	}
	/*
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work{
			max-width:none;
		}
	}
	*/
	/*
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work:hover{
		background-color:rgb(245,245,245);
	}*/
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.time
	{
		padding:0 5px;
		margin-top:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.time > span{
		font-size:0.8em;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > .workName{
		padding:7px 5px;
		font-size:1em;
		/*font-weight:bold;*/
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.info{
		padding:4px 10px;
		color:silver;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.info > i{
		margin-top:1px;
		opacity:0.3;
		filter:alpha(opacity=30); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.assigns{
		padding-left:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.workDone{
		border-top:3px <?php echo COLOR1_LIGHTER1_LIGHT;?> solid;
		height:1px;
		width:40px;
		position:absolute;
		top:0;right:20px;
		z-index:21;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.myWork{
		/*border-radius:3px;
		height:6px;
		width:6px;
		*/
		border-top:3px rgb(210,0,0) solid;
		height:1px;
		width:40px;
		position:absolute;
		top:0px;right:20px;
		z-index:20;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work > div.assigns > div.block{
		float:left;
		padding:0 5px;
		background-color:#3a87ad;
		margin-right:5px;
		font-size:0.8em;
		color:white;
		border-radius:4px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup{
		position:absolute;
		width:90%;
		padding:10px;
		-moz-box-shadow:0 1px 6px #999;              
 	   	-webkit-box-shadow:0 1px 6px #999;           
 	   	box-shadow:0 1px 6px #999;
 	   z-index:1000;
 	   display:none;
 	   border-radius:5px;
 	   background-color:white;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup > div.header{
		padding:5px;
		padding-bottom:10px;
		text-align:center;
		font-size:1em;
		font-weight:bold;
		border-bottom:1px <?php echo COLORDARK?> solid;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup > div.body{
		padding:5px 0;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup > div.body > div.block > div.button{
		padding:5px;
		cursor:pointer;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup > div.body > div.block > div.popup{
		display:none;
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup > div.body > div.block > div.button:hover{
		background-color:<?php echo COLORDARK?>;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup{
		top:25px;right:5px;	
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtr{
		width:15px;
		height:15px;
		padding:5px;
		position:absolute;
		top:3px;
		right:3px;
		cursor:pointer;
		border-radius:5px;
		/*background-color:<?php echo COLOR1_LIGHTER1;?>;*/
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.close{
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.back{
		width:20px;
		position:absolute;
		top:15px;
		left:15px;
		cursor:pointer;
		display:none;
	}
	#<?php echo $id?> input[readOnly="readOnly"]{
		cursor:pointer;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block > div.popup > div.datepicker > input{
		width:120px;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.time{
		line-height:20px;
		margin:2px 0;
	}
	#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.time > span{
		font-size:0.9em;
		color:white;
	}
	#<?php echo $id?> > div.main > div.workDetail{
		width:700px;
		z-index:10001;
		position:absolute;
		top:5%;
		left:50%;
		margin-left:-350px;
		background-color:<?php echo COLORLITTLEDARK;?>;
		border-radius:3px;
		display:none;
		margin-bottom:20px;
		-moz-box-shadow:0 1px 1px #999;              
 	   	-webkit-box-shadow:0 1px 1px #999;           
 	   	box-shadow:0 1px 1px #999;
	}
	/*手机*/
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.workDetail{
			width:96%;
			top:5%;
			left:2%;
			margin-left:0px;
		}/*还需要动态改变top*/
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header{
		padding:10px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title{
		padding:5px 0;
		font-weight:bold;
		max-width:400px;
		word-break:break-all;
	}
	/*手机,标题要留空给关闭按钮*/
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.workDetail > div.header > div.title{
			max-width:90%;	
		}
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.workName{
		font-size:1.1em;
		cursor:pointer;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.taskName{
		font-size:0.9em;
		color:gray;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr{
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr > div.line{
		padding:3px 0;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle{
		padding-left:10px;
		margin-top:5px;
		/*height:auto!important;
		height:30px;
		min-height:30px;*/
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro{
		min-width:100px;
		max-width:400px;
		word-break:break-all;
		float:left;
		padding:0 5px;
		line-height:30px;
		cursor:pointer;
		color:gray;
		border-radius:3px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro:hover{
		background-color:<?php echo COLORDARK?>;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr{
		
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line {
		padding:5px 0;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line > textarea,
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr > div.line > textarea.workName{
		background-color:<?php echo COLORLITTLEDARK;?>;
		width:400px;
		height:80px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.workPerson{
		width:400px;
		padding-left:15px;
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line > textarea,
		#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr > div.line > textarea.workName{
			background-color:<?php echo COLORLITTLEDARK;?>;
			width:90%;
			height:80px;
		}
		#<?php echo $id?> > div.main > div.workDetail > div.header > div.workPerson{
			width:90%;
			padding-left:15px;
		}
		#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro{
			max-width:90%;
		}
	}
	
	#<?php echo $id?> > div.main > div.workDetail > div.close{
		cursor:pointer;
		position:absolute;
		top:10px;
		width:20px;
		right:5px;
		z-index:997;
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body{
		padding:5px;
		
		height:auto!important;
		height:400px;
		min-height:400px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff{
		padding-bottom:10px;
		padding-right:200px;
		
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff
		{
			padding-right:20px;
		}
		
	}
	/*浏览器的 控制浮动右边*/
	@media screen and (min-width:500px)
	{
		#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr
		{
			position:absolute;
			top:10px;right:0;
			width:180px;
			padding:10px;
		}
		
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block{
		padding:0px 20px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add{
		position:relative;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.btn{
		text-align:left;
		height:40px;
		padding:10px;
		margin-bottom:5px;
		position:relative;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup{
		position:absolute;
		top:45px;
		left:-30px;
		width:280px;
		background-color:white;
		border-radius:5px;
		padding:10px;
		-moz-box-shadow:0 1px 3px #999;              
 	 	-webkit-box-shadow:0 1px 3px #999;           
 	    box-shadow:0 1px 3px #999;
 	    display:none;
 	    z-index:10005;
 	    cursor:default;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup > div.header{
		text-align:center;
		font-weight:bold;
		color:gray;
		padding-top:3px;
		padding-bottom:10px;
		border-bottom:1px <?php echo COLORDARKERER?> solid;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.remove > div.body > div.delete,
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.done > div.body > ul.done{
		padding:10px 60px;
	}

	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup > div.body{
		padding:5px 0;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup > div.close{
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff > div.stuff,
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff > div.comment > div.stuff{
		margin:0 0 0 40px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff > div.stuff > div.line,
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.commentStuff > div.comment > div.stuff > div.line{
		padding:3px 0;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.title,
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.title{
		font-size:1em;
		font-weight:bold;
		padding:5px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > textarea.comment{
		display:block;
		width:80%;
		height:80px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo{
		padding:5px;
		position:relative;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.popup.commentTo{
		position:absolute;
		background-color:white;
		width:240px;
		top:70px;
		left:-50px;
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	 	-webkit-box-shadow:0 1px 1px #999;           
 	    box-shadow:0 1px 1px #999;
 	    padding:10px;
 	    z-index:999;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list{
		/*position:absolute;
		top:5px;
		left:100px;*/
		background-color:silver;
		padding:3px;
		overflow-x:auto;
		height:auto!important;
		height:30px;
		min-height:30px;
		width:80%;
		margin-bottom:3px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list > div.block{
		float:left;
		margin-right:10px;
		padding:3px;
		font-size:0.8em;
		font-weight:bold;
		height:20px;
		background-color:white;
		position:relative;
		padding-right:25px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list > div.block > div.delete{
		position:absolute;
		top:3px;
		right:0;
		width:15px;
		height:15px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.popup.commentTo > div.close{
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.popup.commentTo > #projectPersonForComment{
		padding-top:20px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments > div.comment{
		border-bottom:1px <?php echo COLORDARKER?> solid;
		padding:10px 0;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments > div.comment > div.stuff > div.name{
		font-weight:bold;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments > div.comment > div.stuff > div.time{
		font-size:0.8em;
		color:gray;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments > div.comment > div.stuff > div.line > div.content{
		background-color:white;
		border-radius:3px;
		padding:10px;
		-moz-box-shadow:0 1px 1px #999;              
 	 	-webkit-box-shadow:0 1px 1px #999;           
 	    box-shadow:0 1px 1px #999;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments > div.comment > div.stuff > div.line > div.commentTo{
		font-size:0.8em;
		color:gray;
	}
	#<?php echo $id?> > div.main > div.workDetail i{
		margin-top:3px;
	}
	#<?php echo $id?> > div.main > div.header > div.lock{
		padding:5px;
		width:20px;
		min-width:auto;
		float:left;
		margin-top:3px;
	}
	#<?php echo $id?> > div.main > div.header > div.locked{
		opacity:0.7;
			filter:alpha(opacity=70); 
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
	}
	#<?php echo $id?> > div.main > div.header > div.unlocked{
		opacity:0.15;
			filter:alpha(opacity=15); 
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=15)";
	}
	#<?php echo $id?> > div.main > div.header > div.lock.avail{
		cursor:pointer;
	}
	/* date picker*/
	#<?php echo $id?> > div.main > div.workDetail div.popup.workDate > div.body > div.datepicker > input{
		width:120px;
		margin:2px;
	}
	#<?php echo $id?> > div.main > div.workDetail div.popup.workDate > div.body > div.datepicker > div.empty{
		display:inline-block;
	}
	#<?php echo $id?> > div.main > div.workDetail div.popup.workDate > div.body > div.line > span.saveDateN{
		color:red;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.time{
		padding-left:15px;
		line-height:25px;
	}
	#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span{
		font-size:0.9em;
		color:gray;
	}
</style>
<script type="text/javascript">
	<?php /*项目标题与简介*/ ?>
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//弹出框关闭
	cw.ec("#<?php echo $id?> > div.main > div.header > div.pop-up > div.delete",function(){
		$(this).parent().hide();
	});
	//失去焦点就隐藏
	var thisPopup = null;
	/*
	$(document).delegate("#<?php echo $id?> > div.main > div.header > div.pop-up","blur",function(){
		//检查自己的子元素是否有焦点
		//var activeEl = document.activeElement;
		//alert($(activeEl).html());
		//alert("bluring,hiding..");
		thisPopup = $(this);
		setTimeout(function(){	
			if(thisPopup != null)
			{
				thisPopup.hide();
				thisPopup = null;
			}
		},50);
		
	});*/
	//点击项目名称或者项目简介
	cw.ec("#<?php echo $id?> > div.main > div.header > div.touch",function(){
		//只读模式不能操作
		if($("#<?php echo $id; ?> > input.canEdit").val() != 1)
		{
			return;
		}
		//有任何一个显示了，就都隐藏
		if(
			($("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectName").css("display")!="none") || 
			($("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectIntro").css("display")!="none")
		)
		{
			$("#<?php echo $id?> > div.main > div.header > div.pop-up").hide();
		}
		else
		{
			var projectName = $("#<?php echo $id?> > input.projectName").val();
			var projectIntro = $("#<?php echo $id?> > input.projectIntro").val();
			if($(this).hasClass("projectName"))
			{
				$("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectName").show()
					.find("div.content > div.line > input.projectName").val(projectName).focus();
			}
			else
			{
				$("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectIntro").show()
					.find("div.content > div.line > textarea.projectIntro").val(projectIntro).focus();
			}
		}
	});
	//确认修改名称
	cw.ec("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectName > div.content > div.line > div.ok",function(){
		var data = {};
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.projectName = $(this).parent().parent().find("div.line > input.projectName").val();
		if(data.projectName == "")
		{
			return false;
		}
		//直接修改
		$("#<?php echo $id?> > input.projectName").val(data.projectName);
		$("#<?php echo $id?> > div.main > div.header > div.projectName").html(data.projectName);
		cw.post(cw.url+"editProject",data,function(result){
			//nothing
		});
		//隐藏
		$(this).parent().parent().parent().hide();
	});
	//确认修改简介
	cw.ec("#<?php echo $id?> > div.main > div.header > div.pop-up.edit-projectIntro > div.content > div.line > div.ok",function(){
		var data = {};
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.projectIntro = $(this).parent().parent().find("div.line > textarea.projectIntro").val();
	/*	if(data.projectIntro == "")
		{
			return false;
		}*/
		//直接修改
		$("#<?php echo $id?> > input.projectIntro").val(data.projectIntro);
		if(data.projectIntro != "")
		{
			$("#<?php echo $id?> > div.main > div.header > div.projectIntro").html(data.projectIntro);
		}
		else
		{
			$("#<?php echo $id?> > div.main > div.header > div.projectIntro").html("<?php echo t::o("set project intro"); ?>...");
		}
		cw.post(cw.url+"editProject",data,function(result){
			//nothing
		});
		//隐藏
		$(this).parent().parent().parent().hide();
	});
</script>
<script type="text/javascript">
	<?php /*projectId的change 事件，载入新的project内容 */?>
	
	cw.ech("#<?php echo $id?> > input.projectId",function(){
		var projectName = $("#<?php echo $id?> > input.projectName").val();
		var projectIntro = $("#<?php echo $id?> > input.projectIntro").val();
		var projectId = $("#<?php echo $id?> > input.projectId").val();
		/*
		if(projectIntro == "")
		{
			projectIntro = "点击设置项目简介...";
		}*/
		//设置标题
		$("#<?php echo $id?> > div.main > div.header > div.projectName").html(projectName);
		$("#<?php echo $id?> > div.main > div.header > div.projectIntro").html(projectIntro);
		//关闭弹出框 
		$("#<?php echo $id?> > div.main > div.header > div.pop-up").hide();
		//关闭人员滑动框
		$("#<?php echo $id?> > div.sliderContainer > div.slider > div.header > div.slideBack").trigger(cw.ectype);
		//设置canvas高度//因为稍后才载入//动画
		
		if($(window).width() > 500)
		{
			setTimeout(function(){
				setCanvasHeight();
			},10);
		}
		else
		{
			setCanvasMinHeight();
		}
		//开始载入主内容
		var data = {};
		data.projectId = projectId;
		//重设canvas
		$("#<?php echo $id?> > div.main > div.canvas > #canvas").html(
				'<div class="task addTask" style="display:none">'+
					'<div class="addTask"><i class="icon-white icon-plus"></i></div>'+
					'<div class="ctr" style="display:none">'+
						'<div class="line">'+
							'<input class="taskName" type="text"></input>'+
						'</div>'+
						'<div class="line">'+
							'<div class="btn btn-success newTask"><?php echo t::o("new task"); ?></div> '+
							'<div class="btn btn-info cancel"><?php echo t::o("cancel"); ?></div>'+
						'</div>'+
					'</div>'+
				'</div>');
		cw.post(cw.url+"getProject",data,function(result){
			//alert(result.length);
			//设置锁
			if(result.locked == 1)
			{
				$("#<?php echo $id?> > div.main > div.header > div.lock").removeClass("unlocked").addClass("locked");
			}
			else
			{				
				$("#<?php echo $id?> > div.main > div.header > div.lock").addClass("unlocked").removeClass("locked");
			}
			//是否能编辑
			setProjectEdit(result.canEdit);
			//是否可以上锁
			if(result.canLock == 1)
			{
				$("#<?php echo $id; ?> > div.main > div.header > div.lock").addClass("avail");
				$("#<?php echo $id; ?> > input.canLock").val(1);
			}
			else
			{
				$("#<?php echo $id?> > div.main > div.header > div.lock").removeClass("avail");
				$("#<?php echo $id; ?> > input.canLock").val(0);
			}
			//初次进入直接载入
			$.each(result.taskList,function(index,task){
				makeOneTask(task);
			});
			$("<?php echo $stopLoading?>").change();
		});
		$("<?php echo $loading?>").change();
		
	});
	//锁操作
	cw.ec("#<?php echo $id?> > div.main > div.header > div.lock",function(){
		if($("#<?php echo $id?> > input.canLock").val() != 1)
		{
			return false;
		}
		var data = {};
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		if(data.projectId == "")
		{
			return false;
		}
		if($(this).hasClass("unlocked"))
		{
			data.isLocked = 1;
			$(this).removeClass("unlocked").addClass("locked");
		}
		else
		{
			data.isLocked = 0;
			$(this).addClass("unlocked").removeClass("locked");
		}
		cw.post(cw.url+"editProject",data,function(result){
			
		});
	});
	function setProjectEdit(canEdit)
	{
		if(canEdit == 1)
		{
			//显示新增任务
			$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask").show();
			//修改taskIntro
			if($("#<?php echo $id?> > div.main > div.header > div.projectIntro").html() == "")
			{
				$("#<?php echo $id?> > div.main > div.header > div.projectIntro").html("<?php echo t::o("set project intro"); ?>...");
			}
			$("#<?php echo $id?> > input.canEdit").val(1);
		}
		else
		{
			//隐藏新增任务
			$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask").hide();
			
			//隐藏task操作
			$("#<?php echo $id?> > input.canEdit").val(0);
		}
		$("#<?php echo $id?> > input.canEdit").change();
	}
	//当页面缩放时，也要修改大小 
	$(window).resize(function(){
		//alert($(window).width());
		if($(window).width() > 500)
		{
			setCanvasHeight();
		}
	});
	function setCanvasHeight()
	{
		//alert($(window).width());
		var totalHeight = $(window).height();
		//alert(totalHeight);
		//alert(totalHeight);
		var siteHeaderHeight = 40;
		var headerHeight = $("#<?php echo $id?> > div.main > div.header").outerHeight(true);
		if(headerHeight < 80)
		{
			headerHeight = 80;
		}
		//alert(headerHeight);
		var canvasHeight = totalHeight - siteHeaderHeight - headerHeight;
		//alert(canvasHeight);
		$("#<?php echo $id?> > div.main > div.canvas").css("height",canvasHeight+"px");
	}
	function setCanvasMinHeight()
	{
		//alert($(window).width());
		var totalHeight = $(window).height();
		//alert(totalHeight);
		//alert(totalHeight);
		var siteHeaderHeight = 40;
		var headerHeight = $("#<?php echo $id?> > div.main > div.header").outerHeight(true);
		if(headerHeight < 80)
		{
			headerHeight = 80;
		}
		//alert(headerHeight);
		var canvasHeight = totalHeight - siteHeaderHeight - headerHeight;
		//alert(canvasHeight);
		$("#<?php echo $id?> > div.main > div.canvas").css("minHeight",canvasHeight+"px");
	}
	//刷新
	cw.ech("#<?php echo $id?> > input.refresh",function(){
		var data = {};
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		if(data.projectId == "")
		{
			return false;
		}
		//标题简介就不管了
		//获取数据
		cw.post(cw.url+"getProject",data,function(result){
			//alert(result.length);
			//设置锁
			if(result.locked == 1)
			{
				$("#<?php echo $id?> > div.main > div.header > div.lock").removeClass("unlocked").addClass("locked");
			}
			else
			{				
				$("#<?php echo $id?> > div.main > div.header > div.lock").addClass("unlocked").removeClass("locked");
			}
			//是否能编辑
			setProjectEdit(result.canEdit);
			var taskIdList = new Array();
			$.each(result.taskList,function(index,data){
				//检查有无此task存在,有就直接更新数据
				if($("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId[value='"+data.taskId+"']").length > 0)
				{
					//alert("in!");
					//更新task信息，包括名字，时限等 
					var $thisTask = $("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId[value='"+data.taskId+"']").parent();
					var taskStartTime = cw.showTime(data.startTime);
					var taskEndTime = cw.showTime(data.endTime);
					$thisTask.children("input.taskName").val(data.name).end()
						.find("div.header > div.taskName").html(data.name).end()
						.children("input.startTime").val(data.startTime).end()
						.children("input.endTime").val(data.endTime).end()
						.find("div.header > div.time").children("span.startTime").html(taskStartTime).end()
							.children("span.endTime").html(taskEndTime);
					//更新work的信息
					if((data.works != null) && (data.works.length > 0))
					{
						//检查有没有work不在此列表中的
						var workIdList = new Array();
						$.each(data.works,function(ind,work){
							//检查有没此work
							if($thisTask.find("div.body > div.work > input.workId[value='"+work.workId+"']").length > 0
							)
							{
								//assgin、commentCount信息
								var assigns = "";
								var info = "";
								if(work.assigns != null)
								{
									$.each(work.assigns,function(i,item){
										assigns+='<div class="block">'+
											'<input class="userId" value="'+item.userId+'" type="hidden"></input>'+
											'<div class="name">'+(item.nickName==""?item.userName:item.nickName)+'</div>'+
										'</div>';
									});
									assigns+='<div style="clear:both"></div>';
								}
								//alert(work.commentCount);
								if((work.commentCount != null) && (work.commentCount != 0))
								{
									
									info+="<i class='icon-comment'></i> &nbsp;"+work.commentCount+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									//info+="评论 "+work.commentCount+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								//更新
								var isDoneDisplay = work.isDone==1?"block":"none";
								var myWorkDisplay = work.myWork==1?"block":"none";
								var workStartTime = cw.showTime(work.startTime,2);
								var workEndTime = cw.showTime(work.endTime,2);
								$thisTask.find("div.body > div.work > input.workId[value='"+work.workId+"']").parent()
									.children("div.workName").html(work.name).end()
									.children("input.workName").val(work.name).end()
									.children("input.workIntro").val(work.intro).end()
									.children("div.assigns").html(assigns).end()
									.children("div.info").html(info).end()
									.children("div.workDone").css("display",isDoneDisplay).end()
									.children("div.myWork").css("display",myWorkDisplay).end()
									.children("div.time").children("span.startTime").html(workStartTime).end()
									.children("span.endTime").html(workEndTime);
								
							}
							else//没有的就插入
							{
								if(ind == 0)
								{
									$thisTask.find("div.body").append(makeOneWork(work));
								}
								else
								{
									makeOneWork(work).insertAfter($thisTask.find("div.body > div.work > input.workId[value='"+data.works[ind-1].workId+"']").parent());
								}
							}
							workIdList.push(work.workId);
						});
						//清楚不属于的work
						$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId[value='"+data.taskId+"']")
							.parent().find("div.body > div.work > input.workId").each(function(){
								if(notIn($(this).val(),workIdList))	
								{
									$(this).parent().remove();
								}
							});
					}
					else
					{
						$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId[value='"+data.taskId+"']")
							.parent().children("div.body").html("");
					}
				}
				else//按照传输来的顺序插入
				{
					if(index == 0)
					{
						makeOneTask(data);
					}
					else
					{
						//直接载入到当前index处
						//makeOneTask(data,true).insertAfter($("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId[value='"+result[index-1].taskId+"']").parent());//这个载入到之前的taskId的那个
						makeOneTask(data,true).insertAfter($("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task").eq(index-1));
					}
				}
				taskIdList.push(data.taskId);
			});
			//把不在taskIdList中的task删除 
			$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > input.taskId").each(function(){
				if(notIn($(this).val(),taskIdList))
				{
					$(this).parent().remove();
				}
			});
			
			$("<?php echo $stopLoading?>").change();
		});
		$("<?php echo $loading?>").change();
	});
	function notIn(testVal,valList)
	{
		var isInOrNot = true;
		for(var i=0;i<valList.length;++i)
		{
			if(testVal == valList[i])
			{
				isInOrNot = false;
				break;
			}
		}
		return isInOrNot;
	}
	
</script>
<script type="text/javascript">
	<?php /*新建任务*/?>
	//点击addTask,显示或者隐藏新建任务框
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.addTask",function(){
		//只读模式不能操作
		if($("#<?php echo $id; ?> > input.canEdit").val() != 1)
		{
			return;
		}
		if($(this).parent().children("div.ctr").css("display") == "none")
		{
			$(this).parent().children("div.ctr").slideDown("fast")
				.find("div.line > input.taskName").focus();
		}
		else
		{
			$(this).parent().children("div.ctr").slideUp("fast");
		}
	});
	var isNewTask = false;
	//失去焦点就隐藏
	/*
	$(document).delegate("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask","blur",function(){
		//检查自己的子元素是否有焦点
		//var activeEl = document.activeElement;
		//alert($(activeEl).html());
		//alert("bluring,hiding..");
		if(!$.browser.msie && cw.notTrident())
		{
		setTimeout(function(){
			if(!isNewTask)
			{
				$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.ctr").slideUp("fast");
			}
				isNewTask = false;
			
		},50);
		}
		
	});
	*/
	//新建任务
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.ctr > div.line > div.newTask",function(){
		isNewTask = true;
		var data = {};
		data.name = $(this).parent().parent().find("div.line > input.taskName").val();
		data.projectId = $("#<?php echo $id?> > input.projectId").val();
		data.works = new Array();
		if(data.name == "")
		{
			return false;
		}
		//直接新建对象
		var newTask = makeOneTask(data);
		cw.post(cw.url+"newTask",data,function(result){
			//alert(result);
			//alert(result.taskId);
			$(this).children("input.taskId").val(result.taskId);
		},newTask);
		$(this).parent().parent().find("div.line > input.taskName").val("");
		//保持输入框焦点
		$(this).parent().parent().find("div.line > input.taskName").focus();
	});
	//显示taskCtr
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtr",function(){
		$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.popup").hide();
		$(this).parent().children("div.taskCtrPopup").show();
		$thisTask = $(this).parent();
		//设置任务时限
		var taskStartTime = $thisTask.children("input.startTime").val();
		//alert(taskStartTime);
		var taskEndTime = $thisTask.children("input.endTime").val();
		if((taskStartTime == "null") || (taskStartTime == ""))
		{
			taskStartTime = null;
		}
		else
		{
			taskStartTime = cw.showTime(taskStartTime,1);
		}
		if((taskEndTime == "null") || (taskEndTime == ""))
		{
			taskEndTime = null;
		}
		else
		{
			taskEndTime = cw.showTime(taskEndTime,1);
		}
		//alert(taskStartTime);
		$(this).parent().find("div.taskCtrPopup > div.body > div.block.taskTime > div.popup > div.datepicker > input.startTime").datepicker('setDate', taskStartTime);
		$(this).parent().find("div.taskCtrPopup > div.body > div.block.taskTime > div.popup > div.datepicker > input.endTime").datepicker("setDate", taskEndTime);
		//重新设置弹出框,点击返回
		$(this).parent().find("div.taskCtrPopup > div.back").trigger(cw.ectype);
	});
	//关闭task popup
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.close",function(){
		$(this).parent().hide();
	});
	//取消新建
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask > div.ctr > div.line > div.cancel",function(){
		$(this).parent().parent().slideUp("fast");
	});
	//删除task
	/* 
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block.deleteTask",function(){
		if(!confirm("确认删除任务?"))
		{
			return false;
		}
		var data = {};
		data.taskId = $(this).parent().parent().parent().children("input.taskId").val();
		if(data.taskId == "")
		{
			return false;
		}
		cw.post(cw.url+"deleteTask",data,function(result){
		
		});
		$(this).parent().parent().parent().remove();
	});	*/
	//点击task ctr后显示popup
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block > div.button",function(){
		//隐藏 所有button显示back
		$(this).parent().children("div.popup").show().end().parent().parent().children("div.back").show().parent().find("div.body > div.block > div.button").hide();
		
	});
	//确认删除
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block.deleteTask > div.popup > div.line > div.ok",function(){
		var data = {};
		data.taskId = $(this).parent().parent().parent().parent().parent().parent().children("input.taskId").val();
		if(data.taskId == "")
		{
			return false;
		}
		cw.post(cw.url+"deleteTask",data,function(result){
		
		});
		$(this).parent().parent().parent().parent().parent().parent().remove();
	});
	//确认设置日期
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block.taskTime > div.popup > div.line > div.ok",function(){
		var data = {};
		var $thisTask = $(this).parent().parent().parent().parent().parent().parent();
		data.taskId = $thisTask.children("input.taskId").val();
		if(data.taskId == "")
		{
			return false;
		}
		//alert(data.taskId);
		data.taskStartTime = $(this).parent().parent().find("div.datepicker > input.startTime").val();
		data.taskEndTime = $(this).parent().parent().find("div.datepicker > input.endTime").val();
		cw.post(cw.url+"changeTask",data,function(result){
		
		});
		//修改input存储值
		var taskStartTime = cw.showTime(data.taskStartTime);
		var taskEndTime = cw.showTime(data.taskEndTime);
		$thisTask.children("input.startTime").val(data.taskStartTime)
			.end().children("input.endTime").val(data.taskEndTime)
			.end().find("div.header > div.time").children("span.startTime").html(taskStartTime).end()
							.children("span.endTime").html(taskEndTime);
		//返回
		$(this).parent().parent().parent().parent().parent().children("div.back").trigger(cw.ectype);
	});
	//点击返回，
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.back",function(){
		//隐藏所有popup
		$(this).hide().parent().find("div.body > div.block > div.popup").hide().end().find("div.body > div.block > div.button").show();
	});
	//点击取消
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.taskCtrPopup > div.body > div.block > div.popup > div.line > div.cancel",function(){
		$(this).parent().parent().parent().parent().parent().children("div.back").trigger(cw.ectype);
	});
	function makeOneTask(data)
	{		
		var notInsert = arguments[1]?true:false;
		var showTaskCtr = $("#<?php echo $id?> > input.canEdit").val() == 1?true:false;
		var taskStartTime = cw.showTime(data.startTime);
		var taskEndTime = cw.showTime(data.endTime);
		var temp = $('<div class="task">'+
				'<div class="taskCtr" style="'+(showTaskCtr?"":"display:none")+'"><i class=" icon-th-list"></i></div>'+
				'<div class="popup taskCtrPopup">'+					
					'<div class="close">&times;</div>'+
					'<div class="header"><?php echo t::o("options"); ?></div>'+
					'<div class="back"><i class="icon-chevron-left"></i></div>'+
					'<div class="body">'+
						'<div class="block taskTime">'+
							'<div class="button"><?php echo t::o("due"); ?></div>'+
							'<div class="popup">'+
								'<div class="input-daterange input-group datepicker line">'+
										'<?php echo t::o("start"); ?>: '+
										'<input type="text" class="dateInput form-control startTime" name="start" readOnly="readOnly"></input><br/>'+
										'<?php echo t::o("due"); ?>: '+
										'<input type="text" class="dateInput form-control endTime" name="end" readOnly="readOnly"></input>'+
									'</div>'+
								'<div class="line">'+
									'<div class="btn btn-danger ok"><?php echo t::o("ok"); ?></div> '+
									'<div class="btn cancel"><?php echo t::o("cancel"); ?></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="block deleteTask">'+
							'<div class="button"><?php echo t::o("delete"); ?></div>'+
							'<div class="popup">'+
								'<div class="line">'+
									'<div class="btn btn-danger ok"><?php echo t::o("ok"); ?></div> '+
									'<div class="btn cancel"><?php echo t::o("cancel"); ?></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<input class="taskId" type="hidden" value="'+data.taskId+'"></input>'+
				'<input class="taskName" type="hidden" value="'+data.name+'"></input>'+
				'<input class="startTime" type="hidden" value="'+data.startTime+'"></input>'+
				'<input class="endTime" type="hidden" value="'+data.endTime+'"></input>'+
				'<div class="header">'+
					'<div class="taskName">'+data.name+'</div>'+
					'<div class="ctr" style="display:none">'+
						'<div class="line">'+
							'<textarea class="taskName"></textarea>'+
						'</div>'+
						'<div class="line">'+
							'<div class="btn btn-primary ok"><?php echo t::o("ok"); ?></div> '+
							'<div class="btn btn-info cancel"><?php echo t::o("cancel"); ?></div>'+
						'</div>'+
					'</div>'+
					'<div class="time">'+
						'<span class="startTime label label-warning">'+taskStartTime+'</span> '+
						'<span class="endTime label label-important">'+taskEndTime+'</span>'+
					'</div>'+
				'</div>'+
				'<div class="body">'+
				
				'</div>'+
				'<div class="work addWork" style="'+(showTaskCtr?"":"display:none")+'">'+
						'<div class="addWork"><?php echo t::o("add work"); ?>...</div>'+
						'<div class="ctr" style="display:none">'+
							'<div class="line">'+
								'<textarea class="workName"></textarea>'+
							'</div>'+
							'<div class="line">'+
								'<div class="btn btn-success newWork"><?php echo t::o("ok"); ?></div> '+
								'<div class="btn btn-info cancel"><?php echo t::o("cancel"); ?></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
			'</div>');
		//增加时限控制
		temp.find("div.popup > div.body > div.block > div.popup > div.datepicker").datepicker({
			//format: 'yyyy年mm月dd日',
			format: 'yyyy-mm-dd',
			weekStart: 1,
			autoclose: true,
			todayBtn: 'linked',
			language: 'zh-CN',
			//startDate:new Date(2013,10,27), //开始时间，在这时间之前都不可选
			//endDate:'+1',//结束时间，在这时间之后都不可选
			clearBtn:true,
			todayHighlight:true
		});
		if((data.works != null) && (data.works.length > 0))
		{
			$.each(data.works,function(index,work){
				temp.children("div.body").append(makeOneWork(work));
			});
		}
		if(! notInsert)
		{
			temp.insertBefore("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task.addTask");
		}
		
		return temp;
	
	}
	<?php /*修改任务*/?>
	var isChangeTask = false;
	var thisTask = null;
	//失去焦点就隐藏
	$(document).delegate("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr","blur",function(){
		//检查自己的子元素是否有焦点
		//var activeEl = document.activeElement;
		//alert($(activeEl).html());
		//alert("bluring,hiding..");
		thisTask = $(this);
		setTimeout(function(){
			if(!isChangeTask)
			{
				if(thisTask != null)
				{
					thisTask.hide().parent().children("div.taskName").show();
				}
			}
				isChangeTask = false;
			
		},50);
		
		
	});
	//点击任务名
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.taskName",function(){
		//只读模式不能操作
		if($("#<?php echo $id; ?> > input.canEdit").val() != 1)
		{
			return;
		}
		$(this).hide();
		var taskName = $(this).parent().parent().children("input.taskName").val();
		$(this).parent().children("div.ctr").show().find("div.line > textarea.taskName").val(taskName).focus();
	});
	//取消
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr > div.line > div.cancel",function(){
		$(this).parent().parent().hide().parent().children("div.taskName").show();
	});
	//确定修改
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.header > div.ctr > div.line > div.ok",function(){
		isChangeTask = true;
		var data = {};
		data.taskName = $(this).parent().parent().find("div.line > textarea.taskName").val();
		data.taskId = $(this).parent().parent().parent().parent().children("input.taskId").val();
		//taskId还未获取
		if(data.taskId == "")
		{
			return false;
		}
		//发送
		cw.post(cw.url+"changeTask",data,function(result){
			
		});
		//直接修改
		$(this).parent().parent().parent().parent().children("input.taskName").val(data.taskName);
		$(this).parent().parent().hide().parent().children("div.taskName").html(data.taskName).show();
	});
</script>
<script type="text/javascript">
	<?php /*新建活儿*/?>
	//点击addWork,显示或者隐藏新建任务框
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.addWork",function(){
		//只读模式不能操作
		if($("#<?php echo $id; ?> > input.canEdit").val() != 1)
		{
			return;
		}
		if($(this).parent().children("div.ctr").css("display") == "none")
		{
			$(this).parent().children("div.ctr").slideDown("fast").find("div.line > textarea.workName").focus();
		}
		else
		{
			$(this).parent().children("div.ctr").slideUp("fast");
		}
	});
	var isNewWork = false;
	var theWork = null;//记录本次获得焦点的work对象
	//失去焦点就隐藏
	/*
	$(document).delegate("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork","blur",function(){
		//检查自己的子元素是否有焦点
		//var activeEl = document.activeElement;
		//alert($(activeEl).html());
		//alert("bluring,hiding..");
		if(!$.browser.msie && cw.notTrident())
		{
		theWork = $(this).children("div.ctr");
		setTimeout(function(){
			//alert("f");
			if(!isNewWork)
			{
			//alert("a");
				if(theWork != null)
				{
					theWork.slideUp("fast");
					theWork = null;
				}
			}
				isNewWork = false;
			
		},50);
		}
		
	});
	*/
	//新建活儿
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.ctr > div.line > div.newWork",function(){
		isNewWork = true;
		var data = {};
		data.name = $(this).parent().parent().find("div.line > textarea.workName").val();
		data.taskId = $(this).parents("div.task").children("input.taskId").val();
		data.intro = "";
		//taskId还未获取
		if((data.name == "") || (data.taskId == "undefined") || (data.taskId == ""))
		{
			return false;
		}
		//直接新建对象
		var newWork = makeOneWork(data);
		newWork.appendTo($(this).parent().parent().parent().parent().children("div.body"));
		cw.post(cw.url+"newWork",data,function(result){
			//alert(result);
			//alert(result.taskId);
			$(this).children("input.workId").val(result.workId);
		},newWork);
		$(this).parent().parent().find("div.line > textarea.workName").val("");
		//保持焦点
		$(this).parent().parent().find("div.line > textarea.workName").focus();
	});
	function makeOneWork(data)
	{
		//assgin、commentCount信息，可能有
		var assigns = "";
		var info = "";
		if(data.assigns != null)
		{
			$.each(data.assigns,function(index,item){
				assigns+='<div class="block">'+
					'<input class="userId" value="'+item.userId+'" type="hidden"></input>'+
					'<div class="name">'+(item.nickName==""?item.userName:item.nickName)+'</div>'+
				'</div>';
			});
			assigns+='<div style="clear:both"></div>';
		}
		if((data.commentCount != null) && (data.commentCount != 0))
		{
			info+="<i class='icon-comment'></i> &nbsp;"+data.commentCount+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			//info+="评论 "+data.commentCount+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		var workStartTime = cw.showTime(data.startTime,2);
		var workEndTime = cw.showTime(data.endTime,2);
		var temp = $('<div class="work"> '+
			'<input class="workId" type="hidden" value="'+data.workId+'"></input>'+
			'<input class="workName" type="hidden" value="'+data.name+'"></input>'+
			'<input class="workIntro" type="hidden" value="'+data.intro+'"></input>'+
			'<div class="workDone" style="'+(data.isDone==1?"":"display:none")+'"></div>'+
			'<div class="myWork" style="'+(data.myWork==1?"":"display:none")+'"></div>'+
			'<div class="workName">'+data.name+'</div>'+
			'<div class="assigns">'+assigns+'</div>'+
			'<div class="time">'+
				'<span class="startTime label label-warning">'+workStartTime+'</span> '+
				'<span class="endTime label label-important">'+workEndTime+'</span>'+
			'</div>'+
			'<div class="info">'+info+'</div>'+
		'</div>');
		return temp;
	}
	//取消新建
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.work.addWork > div.ctr > div.line > div.cancel",function(){
		$(this).parent().parent().slideUp("fast");
	});
</script>
<script type="text/javascript">
	//点击活儿
	
	cw.ec("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work",function(){
		//alert("v");
		//清空时间
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time")
			.children("span.start").hide().children("span.startTime").html("").end().end()
			.children("span.end").hide().children("span.endTime").html("");
		//启动日期选取器件		
		/*
		$('#<?php echo $id?> > div.main > div.workDetail div.datepicker').datepicker({
			//format: 'yyyy年mm月dd日',
			format: 'yyyy-mm-dd',
			weekStart: 1,
			autoclose: true,
			todayBtn: 'linked',
			language: 'zh-CN',
			//startDate:new Date(2013,10,27), //开始时间，在这时间之前都不可选
			//endDate:'+1',//结束时间，在这时间之后都不可选
			clearBtn:true,
			todayHighlight:true
		});
		//清空时间选择
		$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.start').datepicker('setDate', null);
		$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.end').datepicker('setDate', null);
		*/
		//获取taskStartTime与endTime,只要日期
		var taskStartTime = cw.showTime($(this).parent().parent().children("input.startTime").val(),1);
		var taskEndTime = cw.showTime($(this).parent().parent().children("input.endTime").val(),1);
		//alert(taskStartTime);
		/*
			0 or 'hour' for the hour view
			1 or 'day' for the day view
			2 or 'month' for month view (the default)
			3 or 'year' for the 12-month overview
			4 or 'decade' for the 10-year overview. Useful for date-of-birth datetimepickers.
		*/
		$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.start').val("").datetimepicker({
			//format: 'yyyy年mm月dd日',
			format: 'yyyy-mm-dd hh',
			weekStart: 1,
			autoclose: true,
			todayBtn: 'linked',
		//	startDate: taskStartTime, //开始时间，在这时间之前都不可选
		//	endDate: taskEndTime,//结束时间，在这时间之后都不可选
			//clearBtn:true,
			todayHighlight:true,
			minView: 1,//小时就够了
			maxView: 2,
			initialDate:null,
			language: 'zh-CN',
		}).datetimepicker("setStartDate",taskStartTime).datetimepicker("setEndDate",taskEndTime);
		$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.end').val("").datetimepicker({
			//format: 'yyyy年mm月dd日',
			format: 'yyyy-mm-dd hh',
			weekStart: 1,
			autoclose: true,
			todayBtn: 'linked',
		//	startDate: taskStartTime, //开始时间，在这时间之前都不可选
		//	endDate: taskEndTime,//结束时间，在这时间之后都不可选
			//clearBtn:true,
			todayHighlight:true,
			minView: 1,//小时就够了
			maxView: 2,
			initialDate:null,
			language: 'zh-CN',
		}).datetimepicker("setStartDate",taskStartTime).datetimepicker("setEndDate",taskEndTime);
		var workName = $(this).children("input.workName").val();
		var workIntro = $(this).children("input.workIntro").val();
		var workId = $(this).children("input.workId").val();
		var taskName = $(this).parent().parent().children("input.taskName").val();
		$("#<?php echo $id?> > div.main > #overlayWork > input.show").change();
		//fire up 
		//alert(workId);
		loadWorkDetail(workId,workName,taskName,workIntro);
		//为手机浏览器时设置workDetail的高度
		if($(window).width() < 500)
		{
			var workTop = $(this).offset().top - 150;
			workTop = workTop > 50 ? workTop:50;
			//alert(workTop);
			$("#<?php echo $id?> > div.main > div.workDetail").css("top",workTop+"px");
		}
		$("#<?php echo $id?> > div.main > div.workDetail").show();
		$("#<?php echo $id?> > div.main > div.workDetail > input.workId").change();
	});
	/*
	$(document).delegate("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > .work","click",function(e){
		e.preventDefault();
		//alert("v");
		var workName = $(this).children("input.workName").val();
		var workIntro = $(this).children("input.workIntro").val();
		var workId = $(this).children("input.workId").val();
		var taskName = $(this).parent().parent().children("input.taskName").val();
		$("#<?php echo $id?> > div.main > #overlayWork > input.show").change();
		//fire up 
		loadWorkDetail(workId,workName,taskName,workIntro);
		$("#<?php echo $id?> > div.main > div.workDetail").show();
		$("#<?php echo $id?> > div.main > div.workDetail > input.workId").change();
	});
	*/
	function loadWorkDetail(workId,workName,taskName,workIntro)
	{
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.workName").html(workName);
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.taskName").html(taskName);
		$("#<?php echo $id?> > div.main > div.workDetail")
			.children("input.workId").val(workId).end()
			.children("input.workName").val(workName).end()
			.children("input.workIntro").val(workIntro).end()
			.children("input.taskName").val(taskName);
		//设置 body高度
		/*
		var totalHeight = $(window).height();
		var otherHeight = 45+50+85;
		var bodyHeight = totalHeight-otherHeight;
		$("#<?php echo $id?> > div.main > div.workDetail > div.body").css("maxHeight",bodyHeight+"px");
		*/
		//workIntro
			//添加到textarea中
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line > textarea.workIntro").val(workIntro);
		
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro").html(workIntro).show();
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr").hide();
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr").hide();
		//所有控制按钮都先隐藏
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr").hide()
			.children("div.title").hide().end()
			.find("div.block > div.add").hide();//所有按钮
		//清除评论框
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > textarea.comment").val("").parent().parent()
			.find("div.line > div.commentTo > div.list").html('<div style="clear:both"></div>').parent().children("div.popup.commentTo").hide().parent()
			.children("input.userId").val("").end()
			.children("input.userName").val("").end()
			.children("input.nickName").val("").end();
		//获取活儿细节 
			//获取评论等
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments").html('<div class="wrapLoading"><div class="loading"></div></div>');
			var data = {};
			data.workId = workId;
			cw.post(cw.url+"getWork",data,function(result){
				$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments").html("");
				$.each(result.comments,function(idnex,item){
					$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments").append(<?php echo $id?>makeComment(item));
				});
				//设置是否完成状态
				if(result.isDone == 1)
				{
					setWorkDone(1);
				}
				else
				{
					setWorkDone(0);
				}
				$("#<?php echo $id?> > div.main > div.workDetail > input.isAssign").val(result.isAssign);
				//显示开始时间 
				if((result.startTime != "") && (result.startTime != null))
				{	
					//现在只要日期
					startTime = result.startTime;
					$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.start").show()
						.children("span.startTime").html(cw.showTime(startTime,2));
					//设置datepicker
					$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.start').val(cw.showTime(startTime,3)).datetimepicker('update');
				
				}
				//显示结束时间 
				if((result.endTime != "") && (result.endTime != null))
				{	
					//现在只要日期
					endTime = result.endTime;
					$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.end").show()
						.children("span.endTime").html(cw.showTime(endTime,2));
					//设置datepicker
					$('#<?php echo $id?> > div.main > div.workDetail div.datepicker > input.end').val(cw.showTime(endTime,3)).datetimepicker('update');
				}
				//设置权限 isAssign,还要根据之前canEdit
				//canEdit或isAssign的权限
				if(
					($("#<?php echo $id;?> > input.canEdit").val() == 1) ||
					($("#<?php echo $id;?> > div.main > div.workDetail > input.isAssign").val() == 1)
				)
				{
					$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr").show();
					
					if($("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro").html() == "")
					{
						$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro").html("<?php echo t::o("add work description")?>...");
					}
					
					if($("#<?php echo $id;?> > input.canEdit").val() == 1)
					{
						//设置datepicker
						
						
						//显示所有按钮
						$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr")
							.children("div.title").show().end()
							.find("div.addStuff > div.addMember").show().end()
							.find("div.ctrStuff > div.add").show();
					}
					if($("#<?php echo $id;?> > div.main > div.workDetail > input.isAssign").val() == 1)
					{
						//显示状态设置按钮
						$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr")
							.children("div.titleCtrStuff").show().end()
							.find("div.ctrStuff > div.done").show();
					}
				}
			});
		//添加活儿名字到删除弹出框中//添加活儿名字到完成状态弹出框中
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup > div.header > span.workName").html(workName);
		
	}
	//点击回复给
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.commentToPop",function(){
		//alert("f");
		$(this).parent().children("div.popup.commentTo").toggle();
	});
	//回复给关闭
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.popup.commentTo > div.close",function(){
		$(this).parent().hide();
	});
	//回复给相应
	cw.ech("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > input.added",function(){
		var data = {};
		data.userId = $(this).parent().children("input.userId").val();
		data.userName = $(this).parent().children("input.userName").val();
		data.nickName = $(this).parent().children("input.nickName").val();
		var name = data.nickName == ""?data.userName:data.nickName;
		//alert(userName);
		if($("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list > div.block > input.userId[value='"+data.userId+"']").length == 0)
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list").show().prepend(<?php echo $id?>makeCommentTo(data));
			//添加到comment中 
			var $newComment = $("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > textarea.comment");
			$newComment.val($newComment.val()+" @"+name+" ");
		}
	});
	//点击删除此人
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > div.list > div.block > div.delete",function(){
		$(this).parent().remove();
	});
	
	//关闭
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.close",function(){
		$(this).parent().children("input.close").change();
	});
	cw.ech("#<?php echo $id?> > div.main > div.workDetail > input.close",function(){
		//alert("c");
		$(this).parent().hide();
		$("#<?php echo $id?> > div.main > #overlayWork > input.hide").change();
		//刷新
		$("#<?php echo $id?> > input.refresh").change();
	});
	//点击活儿描述
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.line > div.workIntro",function(){
		//只有canEdit或isAssign才能修改
		if(
			($("#<?php echo $id;?> > input.canEdit").val() != 1) &&
			($("#<?php echo $id;?> > div.main > div.workDetail > input.isAssign").val() != 1)
		)
		{
			return;
		}
		$(this).hide().parent().parent().children("div.ctr").show()
			.find("textarea.workIntro").focus();
	});
	//取消活儿描述
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line > div.cancel",function(){
		var originWorkIntro = $("#<?php echo $id?> > div.main > div.workDetail > input.workIntro").val();
		$(this).parent().parent().find("textarea.workIntro").val(originWorkIntro);
		$(this).parent().parent().hide().parent().find("div.workIntro").show();
	});
	//确定修改活儿描述
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.subtitle > div.ctr > div.line > div.ok",function(){
		//只有canEdit或isAssign才能修改
		if(
			($("#<?php echo $id;?> > input.canEdit").val() != 1) &&
			($("#<?php echo $id;?> > div.main > div.workDetail > input.isAssign").val() != 1)
		)
		{
			return;
		}
		var data = {};
		data.workIntro = $(this).parent().parent().find("textarea.workIntro").val();
		data.workId = $("#<?php echo $id?> > div.main > div.workDetail > input.workId").val();
		//发送
		cw.post(cw.url+"changeWork",data,function(result){
			//alert(result);
		});
		$("#<?php echo $id?> > div.main > div.workDetail > input.workIntro").val(data.workIntro);
		$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > div.work > input.workId[value='"+data.workId+"']").parent().children("input.workIntro").val(data.workIntro);
		$(this).parent().parent().hide().parent().find("div.workIntro").html(data.workIntro).show();
	});
	//发表评论
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.ok",function(){
		var data = {};
		data.content = $(this).parent().parent().find("div.line > textarea.comment").val();
		if((data.content == "") || $(this).hasClass("disabled"))
		{
			return false;
		}
		data.workId = $("#<?php echo $id?> > div.main > div.workDetail > input.workId").val();
		data.nickName = $("#<?php echo $id?> > input.nickname").val();
		data.userName = $("#<?php echo $id?> > input.username").val();
		data.time = getTimeNow();
		data.commentTo = new Array();
		$(this).parent().parent().find("div.line > div.commentTo > div.list > div.block").each(function(){
			var temp = {};
			temp.userId = $(this).children("input.userId").val();
			//alert(temp.userId);
			temp.userName = $(this).children("input.userName").val();
			temp.nickName = $(this).children("input.nickName").val();
			data.commentTo.push(temp);
		});
		//发送
		$(this).addClass("disabled");
		cw.post(cw.url+"comment",data,function(result){
			//alert(result);
			$(this).removeClass("disabled");
		},$(this));
		$(this).parent().parent().find("div.line > textarea.comment").val("").end().find("div.line > div.commentTo > div.list").html("<div style='clear:both'></div>");
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.comments").prepend(<?php echo $id?>makeComment(data));
	});
	//点击活儿名字
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.workName",function(){
		//只有canEdit才能修改
		if(
			($("#<?php echo $id;?> > input.canEdit").val() != 1) 
		)
		{
			return;
		}
		//获取当前workName
		if($(this).parent().children("div.ctr").css("display") == "none")
		{
			var workName = $("#<?php echo $id?> > div.main > div.workDetail > input.workName").val();
			$(this).parent().children("div.ctr").slideDown("fast").find("div.line > textarea.workName").val(workName).focus();
		}
		else
		{
			$(this).parent().children("div.ctr").slideUp("fast");
		}
	});
	//修改取消 
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr > div.line > div.cancel",function(){
		//获取当前workName
		$(this).parent().parent().slideUp("fast");
	});
	//修改活儿名字
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr > div.line > div.ok",function(){
		//只有canEdit才能修改
		if(
			($("#<?php echo $id;?> > input.canEdit").val() != 1) 
		)
		{
			return;
		}
		var data = {};
		data.workId = $("#<?php echo $id?> > div.main > div.workDetail > input.workId").val();
		data.workName = $(this).parent().parent().find("div.line > textarea.workName").val();
		if(data.workName == "")
		{
			return false;
		}
		//发送
		cw.post(cw.url+"changeWork",data,function(result){
			
		});
		//直接修改
		$("#<?php echo $id?> > div.main > div.workDetail > input.workName").val(data.workName);
		$("#<?php echo $id?> > div.main > div.canvas > #canvas > div.task > div.body > div.work > input.workId[value='"+data.workId+"']")
			.parent().children("input.workName").val(data.workName).end()
			.children("div.workName").html(data.workName);
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.workName").html(data.workName);
		$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > div.ctr").slideUp("fast");
		
	});
	function getTimeNow()
	{
		var now= new Date();
		var year=now.getYear()+1900;
		var month=now.getMonth()+1;
		month = month<10?"0"+month:month;
		var day=now.getDate();
		day = day<10?"0"+day:day;
		var hour=now.getHours();
		hour = hour<10?"0"+hour:hour;
		var minute=now.getMinutes();
		minute = minute<10?"0"+minute:minute;
		var second=now.getSeconds();
		second = second<10?"0"+second:second;
		return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
	}
	//点击 
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.btn",function(){
		//alert("hi");
		if($(this).parent().children("div.popup").css("display") == "none")
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > #overlayWorkCtr > input.show").change();
		}
		$(this).parent().children("div.popup").toggle();		
	});
	//关闭popup
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup > div.close",function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parent().hide();
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > #overlayWorkCtr > input.hide").change();
	});
	cw.ech("#<?php echo $id?> > div.main > div.workDetail > div.body > input.closePopup",function(){
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup").hide();
	});
	function setWorkDone(isDone)
	{
		if(isDone == 1)
		{
			//设置header
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.done")
				.html("<?php echo t::o("done")?>").addClass("badge-success").removeClass("badge-important");
			//设置选项
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.done > div.body > ul.done")
				.children("li.isDone").addClass("active").end().children("li.notDone").removeClass("active");
		}
		else
		{
			//设置header
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.title > span.done")
				.html("<?php echo t::o("undone")?>").addClass("badge-important").removeClass("badge-success");
			//设置选项
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.done > div.body > ul.done")
				.children("li.isDone").removeClass("active").end().children("li.notDone").addClass("active");
		}
	}
	//设置工作完成状态
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.done > div.body > ul.done > li.done",function(){
		//只有canEdit或isAssign才能修改
		if(
			($("#<?php echo $id;?> > input.canEdit").val() != 1) &&
			($("#<?php echo $id;?> > div.main > div.workDetail > input.isAssign").val() != 1)
		)
		{
			return;
		}
		$(this).parent().children("li.done").removeClass("active");
		$(this).addClass("active");
		//发送
		var data = {};
		data.workId = $(this).parents("div.workDetail").children("input.workId").val();
		if($(this).hasClass("isDone"))
		{
			//alert(data.workId);
			data.isDone = 1;
		}
		else
		{
			data.isDone = 0;
		}
		cw.post(cw.url+"changeWork",data,function(result){
		
		
		});
		//设置头
		setWorkDone(data.isDone);
	});
	
	function <?php echo $id?>makeComment(data)
	{
		//进行文本替换
	//	alert(data.content);
		data.content = cw.replaceHtml(data.content);
		//alert(data.content);
		var commentTo = "";
		if(data.commentTo != null)
		{
			if(data.commentTo.length > 0)
			{
				commentTo = "<span class='title'><?php echo t::o("comment to"); ?></span> ";
			}
			$.each(data.commentTo,function(index,item){
				var name = item.nickName==""?item.userName:item.nickName;
				commentTo+='<span class="name">'+name+'</span> ';
			});
		}
		return $('<div class="comment">'+
						'<div class="header">'+
						'</div>'+
						'<div class="stuff">'+
							'<div class="line name">'+(data.nickName==""?data.userName:data.nickName)+'</div>'+
							'<div class="line">'+
								'<div class="content">'+data.content+'</div>'+
							'</div>'+
							/*
							'<div class="line">'+
								'<div class="commentTo">'+
									commentTo+
								'</div>'+
							'</div>'+
							*/
							'<div class="line time">'+data.time+' '+commentTo+'</div>'+
						'</div>'+
					'</div>');
	}
	function <?php echo $id?>makeCommentTo(data)
	{
		var name = data.nickName==""?data.userName:data.nickName;
		return $('<div class="block">'+
			'<input class="userId" type="hidden" value="'+data.userId+'"></input>'+
			'<input class="userName" type="hidden" value="'+data.userName+'"></input>'+
			'<input class="nickName" type="hidden" value="'+data.nickName+'"></input>'+
			'<div class="delete">&times;</div>'+
			'<div class="name">'+name+'</div>'+
		'</div>');
	}
</script>
<script type="text/javascript">
	
	//点击人员框滑动
	cw.ec("#<?php echo $id?> > div.main > div.header > div.showSlider",function(){
		//修改人员框中body最高高度
		var totalHeight = $(window).height();
		var otherHeight = 45+10+45;
		var bodyHeight = totalHeight-otherHeight;
		/*$("#<?php echo $id?> > div.sliderContainer > div.slider > div.body").css("maxHeight",bodyHeight+"px").parent()
			.animate({"right":"0px"},"fast");
			*/
		$("#<?php echo $id?> > div.sliderContainer > div.slider > div.body").parent()
			.animate({"right":"0px"},"fast");
	});
	//点击人员框滑回
	cw.ec("#<?php echo $id?> > div.sliderContainer > div.slider > div.header > div.slideBack",function(){
		
		$("#<?php echo $id?> > div.sliderContainer > div.slider")
			.animate({"right":"-330px"},"fast");
	});
</script>
<script type="text/javascript">
	<?php /*workDetail按钮操作*/?>
	//取消删除
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.remove > div.body > div.delete > div.cancel",function(){
		//alert("a");
		$(this).parent().parent().parent().hide();
		$("#<?php echo $id?> > div.main > div.workDetail > div.body > #overlayWorkCtr > input.hide").change();
	});
	//确认删除活儿
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.remove > div.body > div.delete > div.removeWork",function(){
		if($(this).hasClass("disabled"))
		{
			return false;
		}
		//alert("v");
		var data = {};
		data.workId = $("#<?php echo $id?> > div.main > div.workDetail > input.workId").val();
		if(data.workId == "")
		{
			return false;
		}
		$(this).addClass("disabled");
		cw.post(cw.url+"removeWork",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().parent().parent().hide();
			$("#<?php echo $id?> > div.main > div.workDetail > div.body > #overlayWorkCtr > input.hide").change();
			//关闭整个workDetail
			$("#<?php echo $id?> > div.main > div.workDetail > input.close").change();
		},$(this));		
	});
	//清空时间
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.workDate > div.body > div.datepicker > div.empty",function(){
		if($(this).hasClass("emptyStart"))
		{
			$(this).parent().children("input.start").val("");
		}
		else
		{
			$(this).parent().children("input.end").val("");
		}
	});
	//确认项目期限
	cw.ec("#<?php echo $id?> > div.main > div.workDetail > div.body > div.ctr > div.block > div.add > div.popup.workDate > div.body > div.line > div.saveDate",function(){
		//$('div.datepicker').datepicker('update', new Date(2011, 2, 5));
		//alert($('div.datepicker > input.start').val());
		var data = {};
		data.workId = $("#<?php echo $id?> > div.main > div.workDetail > input.workId").val();
		if(data.workId == "")
		{
			return false;
		}
		data.startDate = $(this).parent().parent().find("div.datepicker > input.start").val();
		data.endDate = $(this).parent().parent().find("div.datepicker > input.end").val();
		
		//直接修改，然后关闭pupup
		if(data.startDate != "")
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.start").show()
				.children("span.startTime").html(cw.showTime(data.startDate,2));
		}
		else
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.start").hide();
		}
		if(data.endDate != "")
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.end").show()
				.children("span.endTime").html(cw.showTime(data.endDate,2));
		}
		else
		{
			$("#<?php echo $id?> > div.main > div.workDetail > div.header > div.time > span.end").hide();
		}
		$(this).parent().parent().parent().children("div.close").trigger(cw.ectype);
		cw.post(cw.url+"changeWork",data,function(result){
			//alert(result.info);
		});
	});
</script>
<div id="<?php echo $id?>" style="<?php if($hidden){ ?> display:none <?php } ?>">
	<input class="projectId" type="hidden"></input>
	<input class="projectName" type="hidden"></input>
	<input class="projectIntro" type="hidden"></input>
	<input class="username" type="hidden" value="<?php echo $username?>"></input>
	<input class="nickname" type="hidden" value="<?php echo $nickname; ?>"></input>
	
	<input class="refresh" type="hidden"></input>
	
	<input class="canEdit" type="hidden" value="0"></input>
	
	<input class="canLock" type="hidden" value="0"></input>
	<?php 
					$this->widget("PersonLogWidget",array(
						"id" => "personLog",
						"listen" => "#".$id." > input.projectId",
					));
				?>
	
	<div class="main sliderContainer">
		<div class="slider">
			<div class="header">
				<div class="slideBack">
					<i class="icon-user"></i>
				</div>
				<!--人员资料-->
			</div>
			<div class="body">
				<?php $this->widget("ProjectPersonWidget",array(
					"id" => "projectPerson1",
					"listen" => "#".$id." > input.projectId",
					"listenCanEdit" => "#".$id." > input.canEdit",
					//添加成员后通知指派中的成员列表更新
					"refreshAdd" => array(
						"#".$id.' > div.main > div.workDetail #projectPersonForWork > input.projectId',
					),
					//删除成员后通知project内容更新
					"refreshRemove" => array(
						"#".$id.' > input.refresh',
					),
					"showAll" => true,
					"showLog" => true,
					"additionChoose" => true,
					"additionTarget" => array(
						"userId" => "#".$id." > #personLog > input.userId",
						"username" => "#".$id." > #personLog > input.username",
						"nickname" => "#".$id." > #personLog > input.nickname",
						"fire" => "#".$id." > #personLog > input.show",
					),
				));?>
				
			</div>
		</div>
		<div class="header">
			<div class="showSlider">
				<i class="icon-user"></i>
				<!--显示人员...	-->
			</div>
			
			<div class="touch projectName"></div>
			<div class="lock locked"><i class="icon-lock"></i></div>
			<div style="clear:both"></div>
			<div class="touch projectIntro"></div>
			<div style="clear:both"></div>
			<div class="pop-up edit-projectName">
				<div class="delete close invalid">&times;</div>
				<div class="title"><?php echo t::o("project"); ?> <?php echo t::o("name"); ?></div>
				<div class="content">
					<div class="line">
						<input class="edit projectName" type="text"></input>
					</div>
					<div class="line">
						<div class="btn btn-success ok"><?php echo t::o("ok"); ?></div>
					</div>
				</div>
			</div>
			<div class="pop-up edit-projectIntro">
				<div class="delete close">&times;</div>
				<div class="title"><?php echo t::o("project"); ?> <?php echo t::o("intro"); ?></div>
				<div class="content">
					<div class="line">
						<textarea class="edit projectIntro"></textarea>
					</div>
					<div class="line">
						<div class="btn btn-success ok"><?php echo t::o("ok"); ?></div>
					</div>
				</div>
			</div>			
		</div>
		<div class="canvas">
			<div id="canvas">
			</div>
		</div>
		<?php $this->widget("OverlayWidget",array(
			"zindex" => "10000",
			"id" => "overlayWork",
			"transparent" => false,
			"targetSelector" => "#".$id." > div.main > div.workDetail > input.close",
		));?>
		
	</div>
	<div class="main workDetailContainer">
		<div class="workDetail">
			<input class="workId" type="hidden"></input>
			<input class="workIntro" type="hidden"></input>
			<input class="workName" type="hidden"></input>
			<input class="taskName" type="hidden"></input>
			<input class="isAssign" type="hidden" value="0"></input>
			<input class="close" type="hidden"></input>
			<div class="close">&times;</div>
			<div class="header">
				<div class="title">
					<i class="icon-th-large"></i>
					<span class="workName"></span>
					-
					<span class="taskName"></span>
					<span class="done badge badge-important"><?php echo t::o("undone"); ?></span>
					<div class="ctr" style="display:none">
						<div class="line">
							<textarea class="workName"></textarea>
						</div>
						<div class="line">
							<div class="btn btn-primary ok"><?php echo t::o("ok"); ?></div>
							<div class="cancel btn btn-info"><?php echo t::o("cancel"); ?></div>
						</div>
					</div>
				</div>
				<div class="time">
					<span class="start"><?php echo t::o("start"); ?>: <span class="startTime"></span></span>
					<span class="end"><?php echo t::o("due"); ?>: <span class="endTime"></span></span>
				</div>
				<div class="workPerson">
					<?php $this->widget("WorkPersonWidget",array(
						"id" => "workPerson",
						"listen" => "#".$id." > div.main > div.workDetail > input.workId",
						"listenCanEdit" => "#".$id." > input.canEdit",
					));?>
				</div>
				<div class="subtitle">
					<div class="line">
						<div class="workIntro"></div>
					</div>
					<div style="clear:both"></div>
					<div class="ctr" style="display:none">
						<div class="line">
							<textarea class="workIntro" placeholder="<?php echo t::o("add work description"); ?>..."></textarea>
						</div>
						<div class="line">
							<div class="btn btn-primary ok"><?php echo t::o("ok"); ?></div>
							<div class="cancel btn btn-info"><?php echo t::o("cancel"); ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="body">	
				<input class="closePopup" type="hidden"></input>
				<?php $this->widget("OverlayWidget",array(
					"zindex" => "10003",
					"id" => "overlayWorkCtr",
					"transparent" => true,
					"targetSelector" => "#".$id." > div.main > div.workDetail > div.body > input.closePopup",
				));?>
				<div class="title">
					<i class="icon-comment"></i>
				</div>
				<div class="newComment commentStuff">
					<div class="header">	
					</div>
					<div class="stuff">
						<div class="line">
							<textarea class="comment" placeholder="<?php echo t::o("write your comment"); ?>..."></textarea>
						</div>
						<div class="line">
							<div class="commentTo">
								<input class="userId" type="hidden"></input>
								<input class="userName" type="hidden"></input>
								<input class="nickName" type="hidden"></input>
								<input class="added" type="hidden"></input>
								<div class="list">
									<div style="clear:both"></div>
								</div>
								<div class="btn btn-small commentToPop"><?php echo t::o("comment to"); ?></div>
								<div class="popup commentTo">
									<div class="close">&times;</div>
									
										<?php $this->widget("ProjectPersonWidget",array(
										"id" => "projectPersonForComment",
										"listen" => "#".$id." > input.projectId",
										"addMember" => false,
										"header" => false,
										"showMe" => false,
										"ctrMember" => false,
										"targetArr" => array(
											array(
												"userId" => "#".$id." > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > input.userId",
												"userName" => "#".$id." > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > input.userName",
												"nickName" => "#".$id." > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > input.nickName",
												"fire" => "#".$id." > div.main > div.workDetail > div.body > div.newComment > div.stuff > div.line > div.commentTo > input.added",
											),
										),
									));?>
									
								</div>
							</div>
						</div>
						<div class="line">
							<div class="btn btn-primary ok"><?php echo t::o("send"); ?></div>
						</div>
					</div>
				</div>
				<div class="comments commentStuff">
					<!--
					<div class="comment">
						<div class="header">	
						</div>
						<div class="stuff">
							<div class="line name">Chun Wai Leong</div>
							<div class="line">
								<div class="content">评论内润</div>
							</div>
						</div>
					</div>
					-->
				</div>
				<div class="ctr">
					<div class="title titleAddStuff"><?php echo t::o("assign"); ?></div>
					<div class="addStuff block">
						<div class="add addMember">
							<div class="btn btn-block member">
								<i class="icon-user"></i>
								<?php echo t::o("member"); ?>				
							</div>
							<div class="popup addMember">
								<div class="close">&times;</div>
								<div class="header"><?php echo t::o("assign member to work"); ?></div>
								<div class="body">
									<?php $this->widget("ProjectPersonWidget",array(
										"id" => "projectPersonForWork",
										"listen" => "#".$id." > input.projectId",
										"addMember" => false,
										"header" => false,
										"ctrMember" => false,
										"targetArr" => array(
											array(
												"userId" => "#".$id." > div.main > div.workDetail > div.header > div.workPerson > #workPerson > input.userId",
												"userName" => "#".$id." > div.main > div.workDetail > div.header > div.workPerson > #workPerson > input.userName",
												"nickName" => "#".$id." > div.main > div.workDetail > div.header > div.workPerson > #workPerson > input.nickName",
												"type" => "#".$id." > div.main > div.workDetail > div.header > div.workPerson > #workPerson > input.type",
												"fire" => "#".$id." > div.main > div.workDetail > div.header > div.workPerson > #workPerson > input.added",
											),
										),
									));?>
								</div>
							</div>
						</div>
						<div class="add addLabel" style="display:none">
							<div class="btn btn-block workLabel">
								<i class="icon-bookmark"></i>
								<?php echo t::o("label"); ?>
							</div>
							<div class="popup addLabel">
								<div class="close">&times;</div>
							</div>
						</div>
						<div class="add addDue" style="display:none">
							<div class="btn btn-block due">
								<i class="icon-calendar"></i>
								<?php echo t::o("due"); ?>
							</div>
							<div class="popup addDue">
								<div class="close">&times;</div>
							</div>
						</div>
					</div>
					<div class="title titleCtrStuff"><?php echo t::o("options"); ?></div>
					<div class="ctrStuff block">
						<div class="add done">
							<div class="btn btn-block done">
								<i class="icon-check"></i>
								<?php echo t::o("status"); ?>
							</div>
							<div class="popup done">
								<div class="close">&times;</div>
								<div class="header"><span class="workName"></span></div>
								<div class="body">
									<ul class="done nav nav-pills">
										<li class="done active notDone">
											<a href="#"><?php echo t::o("undone"); ?></a>
										</li>
										<li class="done isDone">
											<a href="#"><?php echo t::o("done"); ?></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="add workDate">
							<div class="btn btn-block remove">
								<i class="icon-calendar"></i>
								<?php echo t::o("due"); ?>
							</div>
							<div class="popup workDate">
								<div class="close">&times;</div>
								<div class="header"><?php echo t::o("due"); ?></div>
								<div class="body">
									<div class="input-daterange input-group datepicker">
										<?php echo t::o("start"); ?>:
										<input type="text" class="dateInput form-control start" name="start" readOnly="readOnly"></input> <div class="btn btn-small empty emptyStart">清空</div>
										<br/>
										<?php echo t::o("due"); ?>:
										<input type="text" class="dateInput form-control end" name="end" readOnly="readOnly"></input> <div class="btn btn-small empty emptyEnd">清空</div>
									</div>
									<div class="line">
										<div class="btn btn-primary saveDate"><?php echo t::o("save"); ?></div>
										<span class="saveDateN"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="add remove">
							<div class="btn btn-block remove">
								<i class="icon-trash"></i>
								<?php echo t::o("delete"); ?>
							</div>
							<div class="popup remove">
								<div class="close">&times;</div>
								<div class="header"><?php echo t::o("confirm"); ?> <span class="workName"></span>?</div>
								<div class="body">
									<div class="delete">
										<div class="btn btn-danger removeWork"><?php echo t::o("ok"); ?></div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<div class="btn cancel"><?php echo t::o("cancel"); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>