<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?>{
		position:relative;
		padding-left:5%;
	}
	#<?php echo $id?> > div.projectList{
			
		padding-top:20px;
		padding-bottom:0px;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
		
	}
	#<?php echo $id?> > div.projectList > div.block{
		padding:10px;
		margin:0 16px 16px 0;
		background-color:white;
		border:1px silver solid;
		-moz-box-shadow:0 1px 1px #e1e1e1;              
 	   -webkit-box-shadow:0 1px 1px #e1e1e1;           
 	   box-shadow:0 1px 1px #e1e1e1;
		width:21%;
		border-radius:4px;
		float:left;
		height:auto!important;
		height:120px;
		min-height:120px;
		max-height:120px;
		overflow:hidden;
		cursor:pointer;
		position:relative;
	}
	#<?php echo $id?> > div.projectList > div.block > div.type{
		border:2px solid silver;
		position:absolute;
		right:10px;
		width:40px;
		height:0px;
		top:0;
	}
	/*项目建立者*/
	#<?php echo $id?> > div.projectList > div.block > div.type.t1{
		border-color:<?php echo COLOR1_LIGHTER1?>;
	}
	/*项目经理*/
	#<?php echo $id?> > div.projectList > div.block > div.type.t2{
		border-color:#f89406;
	}
	/*项目成员*/
	#<?php echo $id?> > div.projectList > div.block > div.type.t3{
		display:none;
	}
	#<?php echo $id?> > div.newproject{
		width:23%;
		float:left;
		position:relative;
		margin:0 16px 16px 0;
	}
	#<?php echo $id?> > div.newproject > div.block{
		width:100%;
		height:auto!important;
		height:120px;
		min-height:120px;
		max-height:120px;
		padding:10px 0;
		cursor:pointer;		
		border-radius:4px;		
		background-color:silver;
		color:white;
	}
	#<?php echo $id?> > div.newproject > div.block > div.new{
		position:absolute;
		top:50%;
		left:50%;
		font-size:1em;
		text-align:center;
		margin-left:-55px;
		margin-top:-15px;
		width:120px;
		color:white;
		font-weight:bold;
		height:20px;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new{
		right:10px;
		width:300px;
		border:1px silver solid;
		position:absolute;
		border-radius:5px;
		top:50%;
		left:0;
		display:none;
		background-color:white;
		-moz-box-shadow:0 1px 6px #999;              
 	   -webkit-box-shadow:0 1px 6px #999;           
 	   box-shadow:0 1px 6px #999;
 	   z-index:999;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new > div.delete{
		position:absolute;
		top:10px;
		right:3px;
				opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";

		cursor:pointer;
		color:gray;
		font-weight:bold;
		width:25px;
		height:25px;
	}
	
	#<?php echo $id?> > div.newproject > div.pop-up.new > div.title{
		text-align:center;
		padding:10px 0;
		margin:0px 10px;
		margin-bottom:5px;
		border-bottom:1px <?php echo COLORDARKER?> solid;
		color:gray;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body{
		padding:5px 0;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block{
		padding:10px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block > div.title{
		font-weight:bold;
		padding:5px;
		font-size:1.2em;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block > div.subTitle{
		font-size:1em;
		color:gray;
		padding:5px;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block:hover{
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block:hover > div.title{
		color:white;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new  > div.body > div.block:hover > div.subTitle
	{
		color:silver;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new > div.body
	{
		padding:5%;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new > div.body > div.title{
		font-weight:bold;
		padding-bottom:5px;
		font-size:1em;
	}
	#<?php echo $id?> > div.newproject > div.pop-up.new > div.body > div.line > input.projectName{
		width:95%;
	}
	
	#<?php echo $id?> > div.projectList > div.block > div.projectName{
		font-size:1.2em;
		font-weight:bold;
		padding-bottom:5px;
		word-break:break-all;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectIntro{
		font-size:1em;
		color:<?php echo COLORDARKERER?>;
		word-break:break-all;
		display:none;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectInstr{
		padding:10px;
		word-break:break-all;
		position:relative;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectInstr > div.dot{
		background-color:red;
		width:0px;
		height:0px;
		padding:3px;
		border-radius:3px;
		position:absolute;
		top:18px;
		left:0px;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectInstr > div.line{
		padding:2px 0;
		font-size:1em;
		word-break:break-all;
	}
	
	#<?php echo $id?> > div.projectList > div.block > div.projectFinishInfo{
		position:absolute;
		bottom:10px;
		right:20px;
		width:30%;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectFinishInfo > div.progress{
		background-color:gray;
		margin:0;
		height:15px;
	}
	#<?php echo $id?> > div.projectList > div.block > div.projectFinishInfo > div.progress > div.bar{
		color:silver;
	}
	#<?php echo $id?> > div.projectList > div.block > div.spe,
	#<?php echo $id?> > div.projectList > div.block > div.timeline{
		position:absolute;
		top:10px;
		right:10px;
		width:15px;
		height:15px;
		padding:12px;
		border-radius:5px;
		background-color:white;
		cursor:pointer;
		display:none;
		z-index:99;
	}
	#<?php echo $id?> > div.projectList > div.block:hover > div.spe,
	#<?php echo $id?> > div.projectList > div.block:hover > div.timeline
	{
		display:block;
	}
	#<?php echo $id?> > div.projectList > div.block > div.timeline{
		top:54px;
	}
	#<?php echo $id?> > div.projectList > div.block > div.spe:hover,
	#<?php echo $id?> > div.projectList > div.block > div.timeline:hover
	{
		/*background-color:<?php echo COLOR1_LIGHTER2_MORE?>;*/
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal,
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal
	{
		width:500px;
		position:absolute;
		margin-bottom:30px;
		z-index:10001;
		left:50%;
		margin-left:-250px;
		background-color:white;
		border-radius:5px;
		display:none;
		-moz-box-shadow:0 1px 1px #999;              
 	   	-webkit-box-shadow:0 1px 1px #999;           
 	   	box-shadow:0 1px 1px #999;
 	   	word-break:break-all;
	}
	
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > #<?php echo $id;?>projectSpeModal,
		#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal{
			width:96%;
			left:2%;
			margin-left:0px;
		}
		
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > div.close,
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-header > div.close
	{
		opacity:0.9;
		filter:alpha(opacity=90); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body,
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body{
		padding-top:0;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body{
		background-color:<?php echo COLORDARKER?>;
		border-radius:0 0 5px 5px;
		padding:0;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline{
		margin-left:30px;
		margin-bottom:30px;
		border-left:3px white solid;
		padding:20px;	
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.time{
		font-weight:bold;
		padding:50px 0 4px 0;
		position:relative;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block:first-child > div.time{
		padding-top:0px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.time > div.cursor{
		border-bottom:3px white solid;
		width:15px;
		height:1px;
		position:absolute;
		top:55px;
		left:-20px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block:first-child > div.time > div.cursor{
		top:5px;
	}
	
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff{
		padding:10px 10px;
		font-size:1em;
		background-color:white;
		margin-bottom:10px;
		-moz-box-shadow:0 1px 3px #999;              
 	  -webkit-box-shadow:0 1px 3px #999;           
 	   box-shadow:0 1px 3px #999;
 	   border-radius:5px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff > div.taskName{
		padding-bottom:3px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff > div.workList > div.block{
		padding:5px 10px;
		margin-left:30px;
		color:gray;
		font-size:0.9em;
		position:relative;
		margin-bottom:15px;
		background-color:rgb(250,250,250);
		border-radius:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
 	   line-height:25px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff > div.workList > div.block > div.doneLogo{
		display:none;
		position:absolute;
		left:-25px;
		width:15px;
		height:15px;
		top:10px;
		opacity:0.3;
		filter:alpha(opacity=30); 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff > div.workList > div.block > div.time > span{
		font-size:0.8em;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.stuff > div.workList > div.block.done > div.doneLogo{
		display:block
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline{
			padding-left:20px;
			padding-right:10px;
			margin-left:20px;
		}
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.line{
		padding:5px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.projectIntro{
		color:gray;
		padding:10px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.sayInstr{
		padding:5px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.sayInstr > textarea.instr{
		height:40px;
		width:95%;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList{
		padding:10px 0;
		background-color:rgb(245,245,245);
		height:auto!important;
		height:100px;
		min-height:100px;
		border-radius:5px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block{
		position:relative;
		padding-bottom:10px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.sayer{
		position:absolute;
		top:0px;
		width:20%;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type1 > div.sayer{
		left:0px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type2 > div.sayer{
		right:0px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.sayer > div.sayerName{
		color:gray;
		padding:10px 0px;
		font-size:0.9em;
		font-weight:bold;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type1 > div.sayer > div.sayerName{
		text-align:right;
		padding-right:6px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type2 > div.sayer > div.sayerName{
		text-align:left;
		padding-left:6px;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.saying{
		width:60%;
		margin:0 auto;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.saying > div.text
	{
		background-color:white;
		padding:10px;
		border-radius:5px;
		max-width:70%;
		-moz-box-shadow:0 1px 3px #999;              
 	  -webkit-box-shadow:0 1px 3px #999;           
 	   box-shadow:0 1px 3px #999;
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.saying > div.text
		{
			max-width:100%;
		}
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > div.saying > div.publicity{
		color:silver;
		padding:10px;
		font-size:0.8em;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type1 > div.saying > div.text{
		float:left;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type1 > div.saying > div.publicity{
		float:left
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type2 > div.saying > div.text{
		float:right;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block.type2 > div.saying > div.publicity{
		float:right
	}
	
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body,
	#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body{
		max-height:none;
	}
	#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.deleteProject{
		padding:10px;
		text-align:right;
	}
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id?>{
			padding-left:10px;	
		}
		#<?php echo $id?> > div.projectList > div.block{
			padding:10px;
			margin:0 0px 16px 0;
			width:90%;
			border-radius:4px;
		}
		#<?php echo $id?> > div.newproject{
			width:100%;
		}
		#<?php echo $id?> > div.newproject > div.block{
			width:90%;
			padding:10px;
			margin:0 0px 16px 0;
		}
		#<?php echo $id?> > div.newproject > div.pop-up.new
		{
			width:95%;
		}
		
	}
	@media screen and (max-device-width:1100px)
	{
		#<?php echo $id?> > div.projectList > div.block > div.spe,
		#<?php echo $id?> > div.projectList > div.block > div.timeline{
			display:block;
		}	
		#<?php echo $id?> > div.projectList > div.block > div.projectName,
		#<?php echo $id?> > div.projectList > div.block > div.projectInstr,
		#<?php echo $id?> > div.projectList > div.block > div.projectIntro{
			width:80%;
		}
	}
</style>
<script type="text/javascript">
	<?php  /*获取 project List*/?>
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	cw.ech("#<?php echo $id?> > input.project",function(){
		<?php echo $id?>getProjectList();
	});
	function <?php echo $id?>getProjectList()
	{
		<?php /*增量更新*/ ?>
		var data = {};
		$("<?php echo $loading?>").change();
		//alert("h");
		cw.post(cw.url+"getProjectList",data,function(result){
			//alert(result.length);
			//记录本次更新有哪些projectId,没有的要删除掉
			var projectIdList = new Array();
			$.each(result,function(index,item){
				projectIdList.push(item.id);
				//当此projectId不存在 ,直接添加到此index上
				if($("#<?php echo $id?> > div.projectList > div.block > input.projectId[value='"+item.id+"']").length == 0)
				{
					/*
					var ltIndex=0;//比其小的project的index
					$("#<?php echo $id?> > div.projectList > div.block").each(function(){
						if($(this).children("input.rank").val() <= item.rank)
						{
							return false;
						}
						ltIndex++;
					});
					*/
					//if(ltIndex == $("#<?php echo $id?> > div.projectList > div.block").length)
					if(index == $("#<?php echo $id?> > div.projectList > div.block").length)
					{
						$("#<?php echo $id?> > div.projectList").append(<?php echo $id?>makeProject(item.name,item.intro,item.id,item.instr,item.rank,item.top,item.type));
					}
					else
					{
						if(index == 0)//第一个元素且界面中已经有别的元素
						{
							<?php echo $id?>makeProject(item.name,item.intro,item.id,item.instr,item.rank,item.top,item.type).insertBefore($("#<?php echo $id?> > div.projectList > div.block").eq(0));
						}
						else
						{
							<?php echo $id?>makeProject(item.name,item.intro,item.id,item.instr,item.rank,item.top,item.type).insertAfter($("#<?php echo $id?> > div.projectList > div.block").eq(index-1));
						}
					}
					
				}
				else
				{
					//更新projectname,intro,instr,不管其排名暂时
					var instrStr = '<div class="dot"></div>';
					if(item.instr.length == 0)
					{
						instrStr = "";
					}
					$.each(item.instr,function(index,item){
						var instrName = item.nickName==""?item.userName:item.nickName;
						instrStr+='<div class="line" title="'+item.content+'">'+
							instrName+": "+ item.content.substr(0,10)+"..."+
						'</div>';
					});
					$("#<?php echo $id?> > div.projectList > div.block > input.projectId[value='"+item.id+"']").parent()
						.children("input.name").val(item.name).end()
						.children("input.intro").val(item.intro).end()
						.children("input.rank").val(item.rank).end()
						.children("input.top").val(item.top).end()
						.children("div.projectName").html(item.name).end()
						.children("div.projectIntro").html(item.intro).end()
						.children("div.projectInstr").html(instrStr);
				}
			});
			//清除哪些被删除了的project
			$("#<?php echo $id?> > div.projectList > div.block > input.projectId").each(function(index,item){
				if(<?php echo $id?>notIn2($(this).val(),projectIdList))
				{
					$(this).parent().remove();
				}
			});
			$("<?php echo $stopLoading?>").change();
			//获取每个project的完成度
			getProjectFinishInfo();
		});
	}
	//检查id是否再list中
	function <?php echo $id?>notIn2(id,list)
	{
		var notIn = true;
		id = parseInt(id);
		for(var i = 0;i<list.length;++i)
		{
			list[i] = parseInt(list[i]);
			if(id == list[i])
			{
				notIn = false;
				break;
			}
		}
		return notIn;
	}
	function getProjectFinishInfo()
	{
		var data = {};
		data.projectIdList = new Array();
		$("#<?php echo $id?> > div.projectList > div.block > input.projectId").each(function(){
			data.projectIdList.push($(this).val());
		});
		cw.post(cw.url+"getProjectFinishInfo",data,function(result){
			for(var projectId in result)
			{
				if(result[projectId]['workSum'] == 0)
				{
					var finishRate = 0;
				}
				else
				{
					var finishRate = (result[projectId]['workDone']/result[projectId]['workSum']) * 100;
				}
				//更新projectFinishInfo
				var $theBlock = $("#<?php echo $id?> > div.projectList > div.block > input.projectId[value='"+projectId+"']").parent();
				var finishInfo = finishRate.toFixed(0)+"%("+result[projectId]['workDone']+"/"+result[projectId]['workSum']+")";
				$theBlock.children("div.projectFinishInfo").prop("title","项目完成度:"+finishInfo)
						.children("div.progress").show().children("div.bar").width(finishRate.toFixed(0)+"%")/*.html(finishRate.toFixed(0)+"%")*/
						.removeClass("bar-success").removeClass("bar-danger").removeClass("bar-warning").end().end()//bar 的样式初始化
						.children("input.finishInfo").val(finishInfo);
				//为0%的就隐藏
				if(finishRate == 0)
				{
					$theBlock.find("div.projectFinishInfo > div.progress").hide();
				}
				//当1%~50%就是橘色
				else if((finishRate > 0) && (finishRate < 50))
				{
					$theBlock.find("div.projectFinishInfo > div.progress > div.bar").addClass("bar-warning");
				}
				else
				{
					$theBlock.find("div.projectFinishInfo > div.progress > div.bar").addClass("bar-success");
				}
			}
		});
	}
	function <?php echo $id?>makeProject(name,intro,projectId,instrArr,rank,top,type)
	{
		/*var rank = arguments[4]?arguments[4]:0;
		var top = arguments[5]?arguments[5]:0;
		*/
		var instrStr = '<div class="dot"></div>';
		if(instrArr.length == 0)
		{
			instrStr = "";
		}
		$.each(instrArr,function(index,item){
			var instrName = item.nickName==""?item.userName:item.nickName;
			instrStr+='<div class="line" title="'+item.content+'">'+
				instrName+": "+ item.content.substr(0,10)+"..."+
			'</div>';
		});
	
		return $('<div class="block">'+
			'<input class="projectId" type="hidden" value="'+projectId+'"></input>'+
			'<input class="name" type="hidden" value="'+name+'"></input>'+
			'<input class="intro" type="hidden" value="'+intro+'"></input>'+
			'<input class="rank" type="hidden" value="'+rank+'"></input>'+
			'<input class="top" type="hidden" value="'+top+'"></input>'+
			'<div class="type t'+type+'"></div>'+
			'<div class="spe">'+
				'<i class="icon-folder-open"></i>'+
			'</div>'+
			'<div class="timeline">'+
				'<i class="icon-eye-open"></i>'+
			'</div>'+
			'<div class="projectName">'+name+'</div>'+
			'<div class="projectIntro">'+intro+'</div>'+
			'<div class="projectInstr">'+instrStr+'</div>'+
			'<div class="projectFinishInfo" title="项目完成度:0%(0/0)">'+
				'<input class"workSum" type="hidden" value="0"></input>'+
				'<input class"workDone" type="hidden" value="0"></input>'+
				'<input class"workUnDone" type="hidden" value="0"></input>'+
				'<input class="finishInfo" type="hidden" value="0%(0/0)"></input>'+
				//'<span class="info">0%</span>'+
				'<div class="progress">'+
					'<div class="bar" style="width:0%">'+/*'0%'+*/'</div>'+
				'</div>'+
			'</div>'+
		'</div>');
	}
</script>
<script type="text/javascript">
	//点击project
	cw.ec("#<?php echo $id?> > div.projectList > div.block",function(){
		var projectId = $(this).children("input.projectId").val();
		var projectName = $(this).children("input.name").val();
		var projectIntro = $(this).children("input.intro").val();
		<?php if($targetProjectName != ""){ ?>
			$("<?php echo $targetProjectName;?>").val(projectName);
		<?php } ?>
		<?php if($targetProjectIntro != ""){ ?>
			$("<?php echo $targetProjectIntro;?>").val(projectIntro);
		<?php } ?>
		$("<?php echo $targetProjectId;?>").val(projectId);
		<?php foreach($targetChange as $one){ ?>
			//alert("d");
				$("<?php echo $one;?>").change();
		<?php } ?>
		//构造浏览器url防止错误后退（暂时）
		//window.location.hash = "#!pt"+projectId+"0";
		window.location.hash = "#!"+projectName;
	});
</script>
<script type="text/javascript">
	//点击项目时间轴，
	cw.ec("#<?php echo $id?> > div.projectList > div.block > div.timeline",function(e){
		e.stopPropagation();
		e.preventDefault();
		//alert("a");
		var projectId = $(this).parent().children("input.projectId").val();
		var projectName = $(this).parent().children("input.name").val();
		var projectIntro  = $(this).parent().children("input.intro").val();
		
		//设置弹出框的高度
		var projectTop = $(this).parent().offset().top - 150;
		projectTop = projectTop > 0 ? projectTop:50;
		//项目完成度
		var projectFinishInfo  = $(this).parent().find("div.projectFinishInfo > input.finishInfo").val();
		//打开项目详情框，并且载入项目详情
		$("#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal")
			.children("input.projectName").val(projectName).end()
			.children("input.projectIntro").val(projectIntro).end()
			.children("input.modalTop").val(projectTop).end()
			.find("div.modal-header > h2 > span.projectFinishInfo").html(projectFinishInfo).end()
			.children("input.projectId").val(projectId).change();		
	});
	//用于轮训instr
	var instrInterval;
	//点击项目设置（详情）
	cw.ec("#<?php echo $id?> > div.projectList > div.block > div.spe",function(e){
		e.stopPropagation();
		e.preventDefault();
		//alert("a");
		var projectId = $(this).parent().children("input.projectId").val();
		var projectName = $(this).parent().children("input.name").val();
		var projectIntro  = $(this).parent().children("input.intro").val();
		//是否已经置顶
		var top = $(this).parent().children("input.top").val();
		<?php echo $id?>setTopProjectBtn(top);
		//设置项目框的高度
		var projectTop = $(this).parent().offset().top - 150;
		projectTop = projectTop > 0 ? projectTop:50;
		//项目完成度
		var projectFinishInfo  = $(this).parent().find("div.projectFinishInfo > input.finishInfo").val();
		//打开项目详情框，并且载入项目详情
		$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal")
			.children("input.projectName").val(projectName).end()
			.children("input.projectIntro").val(projectIntro).end()
			.children("input.modalTop").val(projectTop).end()
			.find("div.modal-header > h2 > span.projectFinishInfo").html(projectFinishInfo).end()
			.children("input.projectId").val(projectId).change();
	});
	//关闭项目设置框
	cw.ec("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > div.close",function(){
		$(this).parent().parent().children("input.close").change();
		$("#<?php echo $id?> > #overlayProjectInstr > input.hide").change();
	});
	cw.ech("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.close",function(){
		$(this).parent().hide();
		//关闭轮训获取更新
		window.clearInterval(instrInterval);
		//更新projcetList
		$("#<?php echo $id?> > input.project").change();
		//alert("h");
	});
	//关闭时间zhou
	cw.ec("#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-header > div.close",function(){
		$(this).parent().parent().children("input.close").change();
		$("#<?php echo $id?> > #overlayProjectTimeline > input.hide").change();
	});
	cw.ech("#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > input.close",function(){
		$(this).parent().hide();
		//更新projcetList
		//$("#<?php echo $id?> > input.project").change();
	});
	//打开时间轴
	cw.ech("#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > input.projectId",function(){
		//设置项目名字
		var projectName = $(this).parent().children("input.projectName").val();
		//触发overlay
		$("#<?php echo $id?> > #overlayProjectTimeline > input.show").change();
		$(this).parent().show().find("div.modal-header > h2 > span.projectName").html(projectName);
		//设置项目简介
		var projectIntro = $(this).parent().children("input.projectIntro").val();
		$(this).parent().find("div.modal-body > div.projectIntro").html(projectIntro);
		//设置top
		var top = $(this).parent().children("input.modalTop").val();
		$(this).parent().css("top",top+"px");
		$(this).parent().children("input.canSayInstr").val(0);
		$(this).parent().find("div.modal-body > div.timeline").html('<div class="wrapLoading"><div class="loading"></div></div>');
		var data = {};
		data.projectId = $(this).parent().children("input.projectId").val();
		//显示载入中
		cw.post(cw.url+"getProject",data,function(result){
			//alert(result.taskList.length);
			var $modal = $(this);
			$modal.find("div.modal-body > div.timeline").html("");
			$.each(result.taskList,function(index,item){
				$modal.find("div.modal-body > div.timeline").append(<?php echo $id?>maketlTask(item));
			});
			//显示任务时间，相同时间的不显示
			<?php echo $id?>collectTime();
		},$(this).parent());
	});
	//打开项目设置框
		
	cw.ech("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.projectId",function(){
		//设置项目名字
		var projectName = $(this).parent().children("input.projectName").val();
		//$(this).parent().modal("show").find("div.modal-header > h2 > span.projectName").html(projectName);
		//触发overlay
		$("#<?php echo $id?> > #overlayProjectInstr > input.show").change();
		$(this).parent().show().find("div.modal-header > h2 > span.projectName").html(projectName);
		//设置项目简介
		var projectIntro = $(this).parent().children("input.projectIntro").val();
		$(this).parent().find("div.modal-body > div.projectIntro").html(projectIntro);
		//设置top
		var top = $(this).parent().children("input.modalTop").val();
		$(this).parent().css("top",top+"px");
		$(this).parent().children("input.canSayInstr").val(0);
		//隐藏输入框
		$(this).parent().find("div.modal-body > div.sayInstr").hide();
		//隐藏删除项目
		$(this).parent().find("div.modal-body > div.deleteProject").hide();
		//设置载入project信息
		$(this).parent().find("div.modal-body > div.instrList").html('<div class="wrapLoading"><div class="loading"></div></div>');
		var data = {};
		data.projectId = $(this).parent().children("input.projectId").val();
		//显示载入中
		cw.post(cw.url+"getProjectInfo",data,function(result){
			//设置placeholder
			if(result.type==1)<?php /*项目建立者*/ ?>
			{
				$(this).find("div.modal-body > div.sayInstr").show().children("textarea.instr").prop("placeholder","输入项目指示...");
				//显示删除项目
				$(this).parent().find("div.modal-body > div.deleteProject").show();
			}
			else if(result.type==2)<?php /*项目经理*/ ?>
			{
				$(this).find("div.modal-body > div.sayInstr").show().children("textarea.instr").prop("placeholder","回答项目指示...");
			}
			else
			{
				//nothing
			}
			//设置type
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.type").val(result.type);
			$(this).find("div.modal-body > div.instrList").html("");
			if(result.instr.length == 0)
			{
				$(this).find("div.modal-body > div.instrList").html("<div class='noContent' style='text-align:center;color:gray;padding-top:20px;'>没有内容</div>");
			}
			else
			{
				$.each(result.instr,function(index,item){
					$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList").append(<?php echo $id?>makeInstr(item));
				});
			}
			//开始轮训更新
			instrInterval = setInterval(function(){
				//alert("getting");
				<?php echo $id?>getInstr();
			},5000);
		},$(this).parent());
	});
	//点击删除
	cw.ec("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.deleteProject > div.ok",function(){
		if(!confirm("确认删除项目?"))
		{
			return false;
		}
		else
		{
			var data = {};
			data.projectId = $(this).parent().parent().parent().children("input.projectId").val();
			cw.post(cw.url+"deleteProject",data,function(result){
				$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > div.close").trigger(cw.ectype);				
			});
		}
	});
	
	//点击发送
	cw.ec("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.sayInstr > div.sendInstr",function(){
		var data = {};
		data.instr = $(this).parent().children("textarea.instr").val();
		data.projectId = $(this).parent().parent().parent().children("input.projectId").val();
		if($(this).hasClass('disabled') || (data.instr == ""))
		{
			return false;
		}
		data.publicity = $(this).parent().children("input.publicity").prop("checked")?1:0;
		//alert(data.publicity+" "+data.instr);
		$(this).addClass("disabled").html("发送中...").parent().children("textarea.instr").prop("readOnly",true);
		//直接添加
		data.fromId = $("#<?php echo $id?> > input.ownId").val();
		data.userName = $("#<?php echo $id?> > input.ownName").val();
		data.content = data.instr;
		data.type = $("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.type").val();
		var newInstr = <?php echo $id?>makeInstr(data);
		$(this).parent().parent().children("div.instrList").prepend(newInstr);
		
		cw.post(cw.url+"sendInstr",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.sayInstr > div.sendInstr").removeClass("disabled").html("发送").parent()
				.children("textarea.instr").prop("readOnly",false).val("").end();
				//.children("input.publicity").prop("checked",false);
			//更新instrId
			$(this).children("input.instrId").val(result.instrId);
		},newInstr);
		
	});
	
	//点击置顶/取消置顶
	cw.ec("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > h2 > div.toTop",function(){
		var data = {};
		data.projectId = $("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.projectId").val();
		if($(this).hasClass("top1"))
		{
			data.top = 1;
			//找到此项目,克隆后扔到最前面
			var target = $("#<?php echo $id?> > div.projectList > div.block > input.projectId[value='"+data.projectId+"']")
				.parent();
			target.children("input.top").val(1);
			var $Project = target.clone();
			target.remove();
			$("#<?php echo $id?> > div.projectList").prepend($Project);
		}
		else
		{
			//alert("untoping!");
			data.top = 0;
			//找到此项目,克隆后从top=0的项目中找到第一个rank比其小的，插到其前面
			var target = $("#<?php echo $id?> > div.projectList > div.block > input.projectId[value='"+data.projectId+"']")
				.parent();
			target.children("input.top").val(0);
			//alert(target.children("input.top").val());
			var targetRank = target.children("input.rank").val();
			var $Project = target.clone();
			target.remove();
			$("#<?php echo $id?> > div.projectList > div.block").each(function(){
				var thisTop = $(this).children("input.top").val();
				var thisRank = $(this).children("input.rank").val();
				if(thisTop == 0)
				{
					if(targetRank > thisRank)
					{
						$Project.insertBefore($(this));
						return false;
					}
				}
			});
			//return false;
		}
		<?php echo $id?>setTopProjectBtn(data.top);
		cw.post(cw.url+"topProject",data,function(result){
			//alert(result.rank);
			$Project.children("input.rank").val(result.rank);
		},$Project);
		//显示操作成功
		$(this).parent().children("span.toTopOk").show();
		setInterval(function(){
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > h2 > span.toTopOk").hide();
		},3000);
	});
	function <?php echo $id?>setTopProjectBtn(top)
	{
		//当top==0是 设置class top1与“置顶此项目”
		if(top == 1)
		{
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > h2 > div.toTop")
				.html("取消此项目置顶").removeClass("top1").addClass("top0")
				.removeClass("btn-success").addClass("btn-danger");
		}
		else
		{
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-header > h2 > div.toTop")
				.html("置顶此项目").addClass("top1").removeClass("top0")
				.addClass("btn-success").removeClass("btn-danger");
		}
	}
	function <?php echo $id?>getInstr()
	{
		//根据当前 projectId获取instr,更新当前内容
		var data = {};
		data.projectId = $("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > input.projectId").val();
		cw.post(cw.url+"getProjectInfo",data,function(result){
			//alert(result.instr.length);
			//清楚“没有内容”
			$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal").find("div.modal-body > div.instrList > div.noContent").remove();
			if(result.instr.length == 0)
			{
				$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal").find("div.modal-body > div.instrList").html("<div class='noContent' style='text-align:center;color:gray;padding-top:20px;'>没有内容</div>");
			}
			else
			{
				//检查有没有instr不在此列表中的
				var instrIdList = new Array();
				$.each(result.instr,function(ind,item){
					instrIdList.push(item.instrId);
					//不存在，就插入，
					if($("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > input.instrId[value='"+item.instrId+"']").length == 0)
					{
						if(ind == 0)//当前大的
						{
							$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList").prepend(<?php echo $id?>makeInstr(item));
						}
						else//插入前一个之后
						{
							<?php echo $id?>makeInstr(item).insertAfter($("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > input.instrId[value='"+result.instr[ind-1].instrId+"']").parent());
						}
					}
					//存在了，更新
					else
					{
						var sayerName = ((item.nickName==null) || (item.nickName == ""))?item.userName:item.nickName;
						var publicity = item.publicity==0?"":"不公开";
						$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > input.instrId[value='"+item.instrId+"']")
							.parent().children("input.instrId").val(item.instrId).end()
								.children("input.fromId").val(item.fromId).end()
								.children("div.sayer").children("div.sayerName").html(sayerName).end().end()
								.children("div.saying")
									.children("div.text").html(item.content).end()
									.children("div.publicity").html(publicity);
					}
				});
				//检查有没instr不再result.instr中的(不管那些没有instrId的)
				//清楚不属于的instr
				$("#<?php echo $id?> > #<?php echo $id;?>projectSpeModal > div.modal-body > div.instrList > div.block > input.instrId").each(function(){
					if(($(this).val() == "") || ($(this).val() == null))
					{
						//nothing
					}
					else
					{
						if(<?php echo $id?>notIn($(this).val(),instrIdList))	
						{
							$(this).parent().remove();
						}
					}
				});
			}
		});
	}
	function <?php echo $id?>notIn(testVal,valList)
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
	
	function <?php echo $id?>makeInstr(item)
	{
		<?php
			/*
				item.publicity  0公开 其他 仅仅建立者与项目经理可见
				item.type 1-建立者  2-项目经理 3-成员
				项目经理写的头像放右边
				建立者头像放左边
			*/
		?>
		var sayerName = ((item.nickName==null) || (item.nickName == ""))?item.userName:item.nickName;
		//var publicity = item.publicity==0?"公开":"仅项目经理可见";
		var publicity = item.publicity==0?"":"不公开";
		var instrId = item.instrId==null?"":item.instrId;
		var fromId = item.fromId==null?"":item.fromId;
		return $('<div class="block type'+item.type+'">'+
			'<input class="instrId" type="hidden" value="'+instrId+'"></input>'+
			'<input class="fromId" type="hidden" value="'+fromId+'"></input>'+
			'<div class="sayer">'+
				'<div class="sayerName">'+sayerName+'</div>'+
			'</div>'+
			'<div class="saying">'+
				'<div class="text">'+item.content+'</div>'+
				'<div class="publicity">'+publicity+'</div>'+
				'<div style="clear:both"></div>'+
			'</div>'+		
		'</div>');
	}
	//构造时间轴内容
	function <?php echo $id?>maketlTask(data)
	{
		var showTime = cw.showTime(data.startTime,0)==""?false:true;
		var task = $('<div class="block">'+
			'<input class="taskId" type="hidden" value="'+data.taskId+'">'+
			/*//不显示截止时间
			'<div class="time">'+
				'<span class="startTime">'+cw.showTime(data.startTime,0)+'</span> &nbsp;'+
				'<span class="endTime">'+cw.showTime(data.endTime,0)+'</span>'+
			'</div>'+
			*/
			(showTime?
			'<div class="time" style="display:none">'+
				'<div class="cursor"></div>'+
				'<span class="startTime">'+cw.showTime(data.startTime,0)+' '+cw.showTime(data.startTime,4)+'</span> &nbsp;'+
			'</div>':
			'<div class="time" style="display:none">'+
				'<div class="cursor"></div>'+
				'<span class="startTime"><i class="icon-time"></i></span> &nbsp;'+
			'</div>'
			)+
			'<div class="stuff">'+
				'<div class="taskName">'+data.name+'</div>'+
				'<div class="workList"></div>'+
			'</div>'+
		'</div>');
		$.each(data.works,function(index,item){
			task.find("div.stuff > div.workList").append(<?php echo $id?>maketlWork(item));
		});
		return task;
	}
	//显示任务时间，相同时间的不显示
	function <?php echo $id?>collectTime()
	{
		var curTime = "";
		$("#<?php echo $id?> > #<?php echo $id;?>projectTimelineModal > div.modal-body > div.timeline > div.block > div.time").each(function(){
			if($(this).html() != curTime)
			{
				$(this).show();
				curTime = $(this).html();
			}
		});
	}
	function <?php echo $id?>maketlWork(data)
	{
		var workDoneStr = data.isDone==1?"done":"notDone";
		var $work = $('<div class="block '+workDoneStr+'">'+
			'<input class="workId" type="hidden" value="'+data.workId+'"></input>'+
			'<div class="doneLogo"><i class="icon-ok"></i></div>'+
			'<div class="time">'+
				'<span class="startTime label label-warning">'+cw.showTime(data.startTime,2)+'</span> '+
				'<span class="endTime label label-important">'+cw.showTime(data.endTime,2)+'</span>'+
			'</div>'+
			'<div class="workName">'+data.name+'</div>'+
		'</div>');
		//构造workAssign
		$.each(data.assigns,function(index,item){
			var userName = item.nickName==""?item.userName:item.nickName;
			$work.children("div.workName").append(' <span class="label label-success">'+userName+'</span>');
		});
		return $work;
	}
</script>
<script type="text/javascript">
	//点击new project
	cw.ec("#<?php echo $id?> > div.newproject > div.block",function(){
		//清空
		$(this).parent().children("div.pop-up.new").toggle().find("div.body > div.line > input.projectName").val("").focus();
		//alert("h");
	});
	//确认新增项目
	cw.ec("#<?php echo $id?> > div.newproject > div.pop-up.new > div.body > div.line > div.create",function(){
		var data = {};
		data.name = $(this).parent().parent().find("div.line > input.projectName").val();
		if(data.name == "")
		{
			return false;
		}
		cw.post(cw.url+"newProject",data,function(result){
			<?php echo $id?>getProjectList();
		});
		//关闭新建框
		$(this).parent().parent().parent().hide();
	});
	//关闭新增
	cw.ec("#<?php echo $id?> > div.newproject > div.pop-up.new > div.delete",function(){
		$(this).parent().hide();
	});
</script>
<div id="<?php echo $id?>">
	<?php /*此change将发生project list的获取*/ ?>
	<input class="project" type="hidden"></input>
	<input class="ownId" type="hidden" value="<?php echo Yii::app()->session['userId']?>"></input>
	<input class="ownName" type="hidden" value="<?php echo Yii::app()->session['nickName']==""?(Yii::app()->session['userName']):(Yii::app()->session['nickName']); ?>"></input>
	<?php /*项目详情框*/?>
		<?php $this->widget("OverlayWidget",array(
			"zindex" => "10000",
			"id" => "overlayProjectInstr",
			"transparent" => false,
			"targetSelector" => "#".$id." > div.instrModal > input.close",
		));?>
	<?php /*时间轴框*/?>
		<?php $this->widget("OverlayWidget",array(
			"zindex" => "10000",
			"id" => "overlayProjectTimeline",
			"transparent" => false,
			"targetSelector" => "#".$id." > div.timelineModal > input.close",
		));?>
	<div class="hide instrModal" id="<?php echo $id;?>projectSpeModal"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<input class="close" type="hidden"></input>
		<input class="projectId" type="hidden"></input>
		<input class="projectName" type="hidden"></input>
		<input class="projectIntro" type="hidden"></input>
		<input class="type" type="hidden"></input>
		<input class="modalTop" type="hidden"></input>
		<input class="canSayInstr" value="0" type="hidden"></input>
		<div class="modal-header">
    		<div class="close">&times;</div>
    		<h2>
    			<span class="projectName"></span>
    			<?php echo t::o("done"); ?>:
    			<span class="projectFinishInfo"></span>
    			<div class="btn btn-success btn-small toTop top1"><?php echo t::o("top it"); ?></div>
    			<span class="toTopOk" style="display:none;font-size:0.8em;color:red"><?php echo t::o("ok"); ?></span>
    		</h2>
		</div>
		<div class='modal-body'>
			<div class="line projectIntro"></div>
			<div class='sayInstr'>
				<textarea class="instr" placeholder="输入..."></textarea>
				<br/>
				<input type="checkbox" style="width:15px;height:15px;margin-top:4px;" class="publicity"></input>
				<span style="color:gray;font-size:0.9em"><?php echo t::o("private"); ?></span>
				<br/><br/>
				<div class="btn btn-block btn-info sendInstr"><?php echo t::o("send"); ?></div>
			</div>
			<div class="instrList"></div>
			<div class="deleteProject">
				<div class="btn btn-danger ok"><?php echo t::o("delete project"); ?></div>
			</div>
		</div>
	</div>
	<div class="hide timelineModal" id="<?php echo $id;?>projectTimelineModal"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<input class="close" type="hidden"></input>
		<input class="projectId" type="hidden"></input>
		<input class="projectName" type="hidden"></input>
		<input class="projectIntro" type="hidden"></input>
		<input class="modalTop" type="hidden"></input>
		<input class="type" type="hidden"></input>
		<div class="modal-header">
    		<div class="close">&times;</div>
    		<h2>
    			<span class="projectName"></span>
    			<?php echo t::o("done"); ?>:
    			<span class="projectFinishInfo"></span>
    		</h2>
		</div>
		<div class='modal-body'>
			<div class="timeline"></div>
		</div>
	</div>
	<div class="projectList">
	</div>
	<?php if($userLevel == 3){ ?>
	<div class="newproject">
		<div class="block">
			<div class="new"><?php echo t::o("new project"); ?>...</div>
		</div>
		<div class="pop-up new">
			<div class="title"><?php echo t::o("new project"); ?></div>
			<div class="delete close">&times;</div>
			<div class="body">
				<div class="title"><?php echo t::o("name"); ?></div>
				<div class="line">
					<input class="projectName" type="text"></input>
				</div>
				<div class="line">
					<div class="btn btn-primary create"><?php echo t::o("create"); ?></div>
				</div>
			</div>
		</div>
	</div>
	
	<?php } ?>
	<div style="clear:both"></div>
</div>