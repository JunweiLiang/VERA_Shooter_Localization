<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		每个种类的work一次全部获取，同时按照时间升序
	*/
?>
<style type="text/css">
#juesaichushen{
	height:auto!important;
	height:700px;
	min-height:700px;
}
#juesaichushen > div.fenzu > div.ctr{
	width:600px;
	background-color:rgb(245,245,245);
	margin:10px;
	padding:5px;
	line-height:30px;
}
#juesaichushen > div.fenzu > div.title{
	padding:3px 0;
	background-color:rgb(245,245,245);
	font-weight:bold;
	text-align:center;
}
#juesaichushen > div.fenzu > div.left{
	width:250px;
	float:left;
}
#juesaichushen > div.fenzu > div.typeList{
	height:300px;
	overflow:auto;
}


#juesaichushen > div.fenzu > div.judgeWorkList > #judgeWorkList > div.main > div.group > div.judgeList > div.judgeBlock{
	padding:5px;
	position:relative;
	border-bottom:1px silver solid;
}
#juesaichushen > div.fenzu > div.judgeWorkList > #judgeWorkList > div.main > div.group > div.judgeList > div.judgeBlock > div.line{
	padding:3px 0;
}
#juesaichushen > div.fenzu > div.judgeWorkList > #judgeWorkList > div.main > div.group > div.judgeList > div.judgeBlock > div.delete{
	width:20px;
	cursor:pointer;
	position:absolute;
	top:3px;right:3px;
}

#juesaichushen > div.fenzu > div.newGroup{
	padding:5px;
}
#juesaichushen > div.fenzu > div.newGroup > div.list{
	float:left;
	padding:5px;
}
#juesaichushen > div.fenzu > div.newGroup > div.list > textarea{
	height:200px;
	width:150px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList{
	height:300px;
	overflow:auto;
	width:400px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList > div.block{
	padding:5px;
	background-color:rgb(245,245,245);
	position:relative;
	border-bottom:1px silver solid;
	cursor:pointer;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList > div.block > div.delete{
	position:absolute;
	top:2px;
	right:22px;
	width:10px;
	cursor:pointer;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new {
	float:left;
	width:200px;
	height:300px;
	overflow:auto;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList{
	margin:0 0 0 210px;
	height:300px;
	overflow:auto;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addList,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addList{
	padding:5px 0;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addList > div.block,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addList > div.block{
	position:relative;
	padding:5px;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addList > div.block > div.delete,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addList > div.block > div.delete{
	width:8px;
	position:absolute;
	top:2px;
	right:22px;
	cursor:pointer;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList > div.block,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList > div.block{
	padding:5px;
	position:relative;
	background-color:rgb(245,245,245);
	border-bottom:1px silver solid;
	cursor:pointer;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList > div.block:hover,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList > div.block:hover{
	background-color:<?php echo COLORDARK;?>;
}
#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList > div.block > div.delete,
#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList > div.block > div.delete{
	width:8px;
	position:absolute;
	top:2px;
	right:22px;
	cursor:pointer;
}
div.markUp{
	height:30px;
}
#juesaichushen > div.title{
	text-align:center;
	font-weight:bold;
	background-color:rgb(230,230,230);
	padding:5px;
}
#juesaichushen > div.final,
#juesaichushen > div.allFinal{
	position:relative;
}
#juesaichushen > div.final > div.left{
	float:left;
	width:250px;
}
#juesaichushen > div.final > div.left > div.groupList
{
	height:250px;
	overflow:auto;
}
#juesaichushen > div.final > div.left > div.groupList > div.block{
	cursor:pointer;
	padding:5px;
	color:#0088cc;
}
#juesaichushen > div.final > div.workList{
	margin:0 0 0 260px;
}
#juesaichushen > div.final > div.left > div.groupList > div.block.toggle{
	color:white;
	background-color:#0088cc;
}
#juesaichushen > div.final > div.left > div.statics > input{
	width:50px;
}
#juesaichushen > div.final > div.left > div.statics,
#juesaichushen > div.allFinal > div.statics{
	padding:5px;
	line-height:25px;
}
#juesaichushen > div.final > div.workList > div.block,
#juesaichushen > div.allFinal > div.workList > div.block{
	background-color:rgb(230,230,230);
	/*cursor:pointer;*/
	border:1px solid silver;
	border-width:0 0 1px 0px;
	position:relative;
	padding:10px;
	line-height:25px;
}
#juesaichushen > div.final > div.workList,
#juesaichushen > div.allFinal > div.workList{
	height:auto!important;
	height:400px;
	min-height:400px;
}
#juesaichushen > div.final > div.workList > div.block > a.line,
#juesaichushen > div.final > div.workList > div.block > div.line,
#juesaichushen > div.allFinal > div.workList > div.block > .line{
	height:auto!important;
	height:30px;
	min-height:30px;
	text-decoration:none;
}
#juesaichushen > div.final > div.workList > div.block > div.prize,
#juesaichushen > div.allFinal > div.workList > div.block > div.prize{
	position:absolute;
	right:10px;
	top:5px;
}
#juesaichushen > div.final > div.workList > div.block > div.prize > select,
#juesaichushen > div.allFinal > div.workList > div.block > div.prize > select{
	width:180px;
}
#juesaichushen span.show{
	color:red;
	display:inline;
}
#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType{
	height:30px;
}
#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType > div.type{
	padding:5px;
	width:50px;
	color:black;
	float:left;
	margin-right:20px;
	background-color:white;
	cursor:pointer;
}
#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType > div.type.toggle{
	color:white;
	background-color:#0088cc;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line,
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line{
	padding:5px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input{
	width:150px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.left{
	float:left;
	width:200px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.right{
	margin:0 0 0 250px;
}
#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea{
	height:200px;
}
#juesaichushen div.loadingP{
	padding-top:30px;
	background-color:silver;
	opacity:0.7;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
	filter:alpha(opacity=70);   /*IE5、IE5.5、IE6、IE7*/
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; /*IE8*/
	z-index:888;
	position:absolute;
	top:0px;
	left:0px;
	width:100%;
}
#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.ctr{
	text-align:center;
}
#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.info{
	padding:5px;
	font-weight:bold;
}
#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.result{
	height:150px;
	overflow:auto;
}
</style>
<div id="juesaichushen">
	<div class="opNote"></div>
	<div class="fenzu pi">
		<div class="title">作品分组</div>
		<div class="ctr">	
			<!--<a class="btn btn-info btn-small" href="<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadAllWork?blockId=<?php echo $blockId; ?>" target="_blank">下载全部决赛作品信息</a>-->
			<a class="btn btn-info btn-small" href="<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadAllJudge?blockId=<?php echo $blockId; ?>" target="_blank">下载全部评委信息</a>
			<a class="btn btn-info btn-small" href="<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadFenzu?blockId=<?php echo $blockId; ?>" target="_blank">下载当前分组信息</a>
			<div class="btn btn-small btn-info addStuff">评审附加项</div>
			<div class="btn btn-small btn-info checkGroup">组间作品查重</div>
			<div class="modal hide fade addStuffModal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 				<h3 style='line-height:25px'>评审附加项</h3>
				</div>
				<div class="modal-body">
					<div class="new">
						<div class="line">新增附加项
							<div class="btn btn-small btn-primary addNew">确认新增</div>
						</div>
						<div class="addList">
							<div class="block">
								<div class="delete">&times;</div>
								<input class="input-medium one"></input>
							</div>
						</div>
						<div class="addOne btn btn-block btn-small btn-info">+</div>
					</div>
					<div class="addStuffList"></div>
				</div>
				<div class="modal-footer">
		    		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
				</div>
			</div>
			<div class="modal hide fade checkGroupModal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 				<h3 style='line-height:25px'>组间作品查重</h3>
				</div>
				<div class="modal-body">
					<div class="ctr">
						<div class="btn checkGroup btn-primary">开始查重</div>						
					</div>
					<div class="info">将返回作品ID与其所在重复的组名，请手动删除。删除组中作品时请注意，不要同时进行评审，否则该组此时评审将不能保存成功。</div>
					<div class="result"></div>
				</div>
				<div class="modal-footer">
		    		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
				</div>
			</div>
		</div>	
		
		<div class="newGroup">
			<div class="workList list">
				作品ID列表:<br/>
				<div class="markUp"></div>
				<textarea class="workList"></textarea>
			</div>
			<div class="judgeList list">
				评委列表(空格加1表示为组长):<br/>
				<div class="judgeNameType">
					<div class="type id">ID</div>
					<div class="type toggle username">用户名</div>
				</div>
				<textarea class="judgeList"></textarea>
			</div>
			<div class="groupList list">
				当前分组列表(点击进行修改)(括号中为附加项序号):<br/>
				<div class="groupList"></div>					
				<div class="modal hide fade groupModal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 				<h3 style='line-height:25px' class="groupName"></h3>
				</div>
				<div class="modal-body">
					<div class="line">
						组名: <input class="groupName"></input>
						附加项目: <input class="addNum"></input>
						<input class="groupId" type="hidden"></input>
					</div>
					<div class="left">
						<div class="line">作品ID列表</div>
						<div class="line">
							<textarea class="workList"></textarea>
						</div>
					</div>
					<div class="right">
						<div class="line">评委用户名列表(空格加1表示组长)</div>
						<div class="line">
							<textarea class="judgeList"></textarea>
						</div>
					</div>
					<div class="btn btn-block btn-primary save">保存修改</div>
					<!--<div class="line">修改分组信息提示:</div>-->
					<span class="show show2"></span>
				</div>
				<div class="modal-footer">
		    		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
				</div>
			</div>			
			</div>
			<div style="clear:both"></div>	
			<div class="new">
				附加选项ID(点击“评审附加项”可以选择): <input class="addNum input-small"></input> <div class="btn btn-small btn-info addStuff">评审附加项</div><br/>			
				新组名: <input class="groupName input-small"></input>
				<div class="btn btn-primary saveFenzu">新建分组</div><br/>
			</div>		
		</div>
		<script type="text/javascript">
		//点击组间作品查重,显示modal
		$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.checkGroup","click",function(){
			$("#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal").modal("show");
		});
		//开始查重
		$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.ctr > div.checkGroup","click",function(){
			var data = {};
			//显示载入中。
			$("#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.result").html('<div class="wrapLoading"><div class="loading"></div></div>');
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/checkGroup?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				$("#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.result").html("");
				$.each(result,function(index,item){
					$("#juesaichushen > div.fenzu > div.ctr > div.checkGroupModal > div.modal-body > div.result").append(makeRepeated(item))
				});
			},'json');
		});
		function makeRepeated(item)
		{
			var groups = "";
			for(i=0;i<item.groupNames.length;++i)
			{
				groups+=(i+1)+". "+item.groupNames[i]+" ";
			}
			return $('<div class="blockId">'+
				item.workId+" "+groups+
			'</div>');
		
		}
		
		
		//保存修改组信息
		$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.save","click",function(){
			//alert("a");
			if($(this).hasClass("disabled"))
			{
				return;
			}
			var data = {};
			data.workIdStr = $("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea.workList").val();
			data.judgeIdStr = $("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea.judgeList").val();
			data.groupName = $("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.groupName").val();
			data.groupId = $("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.groupId").val();
			data.addNum = $("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.addNum").val();
			data.judgeNameType = "username";
			if(($.trim(data.workIdStr) == "") || ($.trim(data.judgeIdStr) == "") || (data.groupName == ""))
				{
					return;
				}
			$(this).addClass("disabled");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/changeGroupInfo?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				show2("保存成功");
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.save").removeClass("disabled");
			});
		});
		//点击组，获取组的分组作品列表，评委列表，组名字进行修改
		$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList > div.block","click",function(){
			var data = {};
			data.groupId = $(this).children("input.groupId").val();
			data.groupName = $(this).children("input.groupName").val();
			data.addNum = $(this).children("input.addNum").val();
		//	alert("a");
			$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-header > .groupName").html(data.groupName);
			$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.groupName").val(data.groupName);
			getGroupInfo(data.groupId);
			$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal").modal("show");
		});
		function getGroupInfo(groupId)
		{
			//modal中显示载入中
			$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea").val("载入中...");
			var data = {};
			data.groupId = groupId;
			$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.groupId").val(data.groupId);
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getGroupInfo?blockId=<?php echo $blockId?>",data,function(result){
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea.judgeList").html(result.judgeListStr).val(result.judgeListStr);
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div > div.line > textarea.workList").html(result.workListStr).val(result.workListStr);
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupModal > div.modal-body > div.line > input.addNum").val(result.addNum);
				//alert(result.addNum);
			},'json');
		}
			//点击评委列表按照什么名字输入的东西
			$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType > div.type","click",function(){
				$("#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType > div.type").removeClass("toggle");
				$(this).addClass("toggle");
			});
			//附加项的modal
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuff,#juesaichushen > div.fenzu > div.newGroup > div.new > div.addStuff","click",function(){
				$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal").modal("show");
				getAddStuffList();
			});
			//点击新增项
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addOne","click",function(){
				$(this).parent().children("div.addList").append($(
					'<div class="block">'+
						'<div class="delete">&times;</div>'+
						'<input class="input-medium one"></input>'+
					'</div>'
				));
			});
			//点击删除
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addList > div.block > div.delete","click",function(){
				$(this).parent().remove();
			});
			//确认新增
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.line > div.addNew","click",function(){
				if($(this).hasClass("disabled"))
				{
					return;
				}
				var data = {};
				data.newArr = new Array();
				//遍历新增项目
				$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.addList > div.block > input.one").each(function(){
					if($(this).val() != "")
					{
						data.newArr.push($(this).val());
					}
				});
				if(data.newArr.length == 0)
				{
					return;
				}
				$(this).addClass("disabled").html("新增中...");
				//alert(data.newArr.length);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/newAddStuff?blockId=<?php echo $blockId?>",data,function(result){
					$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.new > div.line > div.addNew").removeClass("disabled").html("确认新增")
						.parent().parent().children("div.addList").html(
							'<div class="block">'+
								'<div class="delete">&times;</div>'+
								'<input class="input-medium one"></input>'+
							'</div>'
						);
					getAddStuffList();
					//alert(result);
				});
			});
			//删除附加项
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList > div.block > div.delete",'click',function(e){
				e.stopPropagation();
				if(!confirm("确认删除此附加项?"))
				{
					return;
				}
				var data = {};
				data.addNum = $(this).parent().children("input.addNum").val();
				$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/deleteAddStuff?blockId=<?php echo $blockId?>",data,function(result){
					//alert(result);
					getAddStuffList();
				});
			});
			//点击附加项，添加到输入 框
			$(document).delegate("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList > div.block","click",function(){
				var addNum = $(this).children("input.addNum").val();
				$("#juesaichushen > div.fenzu > div.newGroup > div.new > input.addNum").val(addNum);
				alert("已经选择附加项"+addNum);
			});
			//获取fujiaxiangmu 
			function getAddStuffList()
			{
				$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getAddStuffList?blockId=<?php echo $blockId?>","",function(result){
					//alert(result);
					$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList").html("");
					//按照addNum 聚类
					if(result.length > 0)
					{
						var curAddNum = result[0].addNum;
						var curAddNoteStr = curAddNum+".";
						$.each(result,function(index,item){
							if(curAddNum != item.addNum)
							{
								$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList").append($(
									'<div class="block">'+
										'<div class="delete">&times;</div>'+
										'<input class="addNum" type="hidden" value="'+curAddNum+'"></input>'+
										'<div class="line">'+curAddNoteStr+'</div>'+
									'</div>'
								));
								curAddNum = item.addNum;
								curAddNoteStr = curAddNum+".";
							}
							curAddNoteStr+=item.addNote+" ";
							if(index == result.length -1)
							{
								$("#juesaichushen > div.fenzu > div.ctr > div.addStuffModal > div.modal-body > div.addStuffList").append($(
									'<div class="block">'+
										'<div class="delete">&times;</div>'+
										'<input class="addNum" type="hidden" value="'+curAddNum+'"></input>'+
										'<div class="line">'+curAddNoteStr+'</div>'+
									'</div>'
								));
							}
						});
					}
				},'json');
			}
			
			//进入页面获取最新分组
			$(document).ready(function(){
				getGroupList();
			});
			//绑定groupList的change事件,获取最新的分组列表
			$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList","change",function(){
				getGroupList();
			});
			
			//获取最新分组,包括组名，然后还有附加NUm
			function getGroupList()
			{
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getGroupList?blockId=<?php echo $blockId?>","",function(result){
					$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList").html("");
					$.each(result,function(index,item){
						var addNum = ((item.addNum == null) || (item.addNum == ""))?"":"("+item.addNum+")";
						//本组评审状态 (完全没有评委评审的)/(本组作品总数)
					//	var status = item.notRankCount+"/"+item.workCount;
						//alert(status);
						$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList").append($(
							'<div class="block">'+
								'<div class="delete">&times;</div>'+
								'<input class="groupId" type="hidden" value="'+item.groupId+'"></input>'+
								'<input class="groupName" type="hidden" value="'+item.groupName+'"></input>'+
								'<div class="line">'+item.groupId+". "+item.groupName+' '+addNum+'</div>'+
							'</div>'
						));
					});
				},'json');
			}
			
			
			
			//添加新的作品分组
			$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.new > div.saveFenzu","click",function(){
				if($(this).hasClass("disabled"))
				{
					return;
				}
				var data = {};
				data.workIdStr = $("#juesaichushen > div.fenzu > div.newGroup > div.workList > textarea.workList").val();
				data.judgeIdStr = $("#juesaichushen > div.fenzu > div.newGroup > div.judgeList > textarea.judgeList").val();
				data.groupName = $("#juesaichushen > div.fenzu > div.newGroup > div.new > input.groupName").val();
				data.addNum = $("#juesaichushen > div.fenzu > div.newGroup > div.new > input.addNum").val();
				if(($.trim(data.workIdStr) == "") || ($.trim(data.judgeIdStr) == "") || (data.groupName == ""))
				{
					return;
				}
				data.judgeNameType = $("#juesaichushen > div.fenzu > div.newGroup > div.judgeList > div.judgeNameType > div.type.toggle").hasClass("id")?"id":"username";
				//alert("a");
				$(this).addClass("disabled").html("添加中...");
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/newGroup?blockId=<?php echo $blockId?>",data,function(result){
				//	alert(result);
					$("#juesaichushen > div.fenzu > div.newGroup > div.new > div.saveFenzu").removeClass("disabled").html("新建分组");
					//重置输入
					$("#juesaichushen > div.fenzu > div.newGroup > div.workList > textarea.workList").val("");
					$("#juesaichushen > div.fenzu > div.newGroup > div.judgeList > textarea.judgeList").val("");
					$("#juesaichushen > div.fenzu > div.newGroup > div.new > input.groupName").val("");
					$("#juesaichushen > div.fenzu > div.newGroup > div.new > input.addNum").val("");
					getGroupList();
				});
			});
			//删除作品分组
			$(document).delegate("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList > div.block > div.delete","click",function(e){
				e.stopPropagation();
				var data = {};
				data.groupId = $(this).parent().children("input.groupId").val();
				if(!confirm("确认删除"+$(this).parent().children("div.line").html()+"?"))
				{
					return;
				}
				$("#juesaichushen > div.fenzu > div.newGroup > div.groupList > div.groupList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/deleteGroup?blockId=<?php echo $blockId?>",data,function(result){
					//alert(result);
					getGroupList();
				});
			});
		</script>
		
		
		
	</div>
	<div style="clear:both"></div>	
	<div class="title">
		决赛分组结果 
		<div class="btn btn-small btn-info freshGroup">刷新分组</div>
		<div class="btn btn-small btn-success save">保存奖项设置</div>
		<a class="btn btn-small btn-info printFinalRank" target="_blank" href="">打印本组最终评审结果</a>
			<a class="btn btn-small btn-info downloadFinalRank" target="_blank" href="">下载本组最终评审结果</a>
		<span class="show show1"></span>
	</div>
	<div class="final">
		<div class="loadingP" style="display:none">
				<div class="wrapLoading">
					<div class="loading"></div>
				</div>
			</div>
		<div class="left">
			小组列表:<br/>
			<div class="groupList"></div>	
			<div class="statics">
				本组奖项设置:<br/><input class="prizeNum"></input><div class="btn btn-small btn-primary save">保存</div>
				<div class="btn btn-info btn-small prize">奖项设置</div>
				<br/>	
				作品总数:<span class="workSum"></span><br/>
				<span class="prizeStr"></span><br/><br/>
			</div>
		</div>
		<input class="groupId" type="hidden"></input>
		<input class="groupName" type="hidden"></input>
		<div class="workList"></div>
		<div class="modal hide fade prizeModal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 				<h3 style='line-height:25px'>奖项设置</h3>
				</div>
				<div class="modal-body">
					<div class="new">
						<div class="line">新增奖项组合
							<div class="btn btn-small btn-primary addNew">确认新增</div>
						</div>
						<div class="addList">
							<div class="block">
								<div class="delete">&times;</div>
								<input class="input-medium one"></input>
							</div>
						</div>
						<div class="addOne btn btn-block btn-small btn-info">+</div>
					</div>
					<div class="prizeList"></div>
				</div>
				<div class="modal-footer">
		    		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
				</div>
			</div>
	</div>
	
	<script type="text/javascript">
		//统计当前奖项设置
		function calPrize()
		{
			var cal = {};
			$("#juesaichushen > div.final > div.workList > div.block").each(function(){
				var $option = $(this).find("div.prize > select > option:selected");
				if(($option.length == 1) && ($option.html() != ""))
				{
					var prizeName = $option.html();
					var prizeId = $option.val();
					//alert(prizeName);
					//return false;
					if(cal[prizeName] == null)
					{
						cal[prizeName] = 0;
					}
					cal[prizeName]++;
				}
			});
			var prizeStr = "";
			for(var prizeName in cal)
			{
				prizeStr+=prizeName+": "+cal[prizeName]+" <br/>";
			}
			$("#juesaichushen > div.final > div.left > div.statics > span.prizeStr").html(prizeStr);
		}
		//保存该组的奖项
		$(document).delegate("#juesaichushen > div.title > div.save","click",function(){
			if($(this).hasClass("disabled"))
			{
				return;
			}
			var groupId = $("#juesaichushen > div.final > input.groupId").val();
			if(groupId == "")
			{
				return;
			}
			var data = {};
			data.groupId = groupId;
			data.workList = new Array();
			$("#juesaichushen > div.final > div.workList > div.block").each(function(){
				var temp = {};
				temp.id = $(this).children("input.id").val();
				temp.prizeId = $(this).find("div.prize > select > option:selected").val();
				data.workList.push(temp);
			});
			$(this).addClass("disabled");
			showWorkListLoading();
			/*$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/savePrize?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				hideWorkListLoading();
				$("#juesaichushen > div.title > div.save").removeClass("disabled");
				show1("保存成功!");
				calPrize();
			});*/
			$.ajax({
				"type":"POST",
				"url":"<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/savePrize?blockId=<?php echo $blockId?>",
				"data":data,
				"success":function(result){
					show1("保存成功!");
					calPrize();
				},
				"error":function(){
					alert("网络超时，请重试");
				},
				"complete":function(){
					hideWorkListLoading();
					$("#juesaichushen > div.title > div.save").removeClass("disabled");
				}
			});
		});
		//保存奖项组合到该groupId
		$(document).delegate("#juesaichushen > div.final > div.left > div.statics > div.save","click",function(){
			if($(this).hasClass("disabled"))
			{
				return;
			}
			var data = {};
			data.groupId = $("#juesaichushen > div.final > input.groupId").val();
			data.prizeNum = $("#juesaichushen > div.final > div.left > div.statics > input.prizeNum").val();
			var groupName = $("#juesaichushen > div.final > input.groupName").val();;
			if(!confirm("确认保存小组:"+groupName+"奖项组合为"+data.prizeNum+"?之前的奖项设置将删除"))
			{
				return;
			}
			$(this).addClass("disabled");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/changePrizeNum?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				$("#juesaichushen > div.final > div.left > div.statics > div.save").removeClass("disabled");
				getWorkList2();
			});
		});
		//奖项的modal
			$(document).delegate("#juesaichushen > div.final > div.left > div.statics > div.prize","click",function(){
				$("#juesaichushen > div.final > div.prizeModal").modal("show");
				getPrizeList();
			});
			//点击
			$(document).delegate("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addOne","click",function(){
				$(this).parent().children("div.addList").append($(
					'<div class="block">'+
						'<div class="delete">&times;</div>'+
						'<input class="input-medium one"></input>'+
					'</div>'
				));
			});
			//点击删除
			$(document).delegate("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addList > div.block > div.delete","click",function(){
				$(this).parent().remove();
			});
			//确认新增
			$(document).delegate("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.line > div.addNew","click",function(){
				if($(this).hasClass("disabled"))
				{
					return;
				}
				var data = {};
				data.newArr = new Array();
				//遍历新增项目
				$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.addList > div.block > input.one").each(function(){
					if($(this).val() != "")
					{
						data.newArr.push($(this).val());
					}
				});
				if(data.newArr.length == 0)
				{
					return;
				}
				$(this).addClass("disabled").html("新增中...");
				//alert(data.newArr.length);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/newPrize?blockId=<?php echo $blockId?>",data,function(result){
					$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.new > div.line > div.addNew").removeClass("disabled").html("确认新增")
						.parent().parent().children("div.addList").html(
							'<div class="block">'+
								'<div class="delete">&times;</div>'+
								'<input class="input-medium one"></input>'+
							'</div>'
						);
					getPrizeList();
					//alert(result);
				});
			});
			//删除
			$(document).delegate("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList > div.block > div.delete",'click',function(e){
				e.stopPropagation();
				if(!confirm("确认删除此奖项?"))
				{
					return;
				}
				var data = {};
				data.prizeNum = $(this).parent().children("input.prizeNum").val();
				$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/deletePrize?blockId=<?php echo $blockId?>",data,function(result){
					//alert(result);
					getPrizeList();
				});
			});
			//点击，添加到输入 框
			$(document).delegate("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList > div.block","click",function(){
				var prizeNum = $(this).children("input.prizeNum").val();
				$("#juesaichushen > div.final > div.left > div.statics > input.prizeNum").val(prizeNum);
				alert("已经选择附加项"+prizeNum);
			});
			//获取奖项设置 
			function getPrizeList()
			{
				$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList").html(
					'<div class="wrapLoading"><div class="loading"></div></div>'
				);
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getPrizeList?blockId=<?php echo $blockId?>","",function(result){
					//alert(result);
					$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList").html("");
					//按照prizeNum 聚类
					if(result.length > 0)
					{
						var curPrizeNum = result[0].prizeNum;
						var curPrizeNoteStr = curPrizeNum+".";
						$.each(result,function(index,item){
							if(curPrizeNum != item.prizeNum)
							{
								$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList").append($(
									'<div class="block">'+
										'<div class="delete">&times;</div>'+
										'<input class="prizeNum" type="hidden" value="'+curPrizeNum+'"></input>'+
										'<div class="line">'+curPrizeNoteStr+'</div>'+
									'</div>'
								));
								curPrizeNum = item.prizeNum;
								curPrizeNoteStr = curPrizeNum+".";
							}
							curPrizeNoteStr+=item.prizeNote+" ";
							if(index == result.length -1)
							{
								$("#juesaichushen > div.final > div.prizeModal > div.modal-body > div.prizeList").append($(
									'<div class="block">'+
										'<div class="delete">&times;</div>'+
										'<input class="prizeNum" type="hidden" value="'+curPrizeNum+'"></input>'+
										'<div class="line">'+curPrizeNoteStr+'</div>'+
									'</div>'
								));
							}
						});
					}
				},'json');
			}
		
		
		$(document).ready(function(){
			getGroupList2();
		});
		$(document).delegate("#juesaichushen > div.title > div.freshGroup","click",function(){
			getWorkList2();
		});
		//点击组,获取该组的评审结果，按照finalRank排序;获取该组的prizeNum
		$(document).delegate("#juesaichushen > div.final > div.left > div.groupList > div.block","click",function(){
			$("#juesaichushen > div.final > div.left > div.groupList > div.block").removeClass("toggle");
			$(this).addClass("toggle");
			var data = {};
			data.groupId = $(this).children("input.groupId").val();
			$("#juesaichushen > div.final > input.groupId").val(data.groupId);
			$("#juesaichushen > div.final > input.groupName").val($(this).children("input.groupName").val());
			//修改下载链接
			//设置下载链接
			$("#juesaichushen > div.title > a.downloadFinalRank").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadFinalRank?blockId=<?php echo $blockId;?>&groupId="+data.groupId);
			//设置打印链接
			$("#juesaichushen > div.title > a.printFinalRank").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/printFinalRank?blockId=<?php echo $blockId;?>&groupId="+data.groupId);
			getWorkList2();
		});
		function getWorkList2()
		{
			var data = {};
			data.groupId = $("#juesaichushen > div.final > input.groupId").val();
			$("#juesaichushen > div.final > div.workList").html('<div class="wrapLoading"><div class="loading"></div></div>');
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getFinal?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				//设置prizeNum
				var prizeNum = result.prizeNum;
				//alert(prizeNum);
				if(prizeNum != null)
				{
					$("#juesaichushen > div.final > div.left > div.statics > input.prizeNum").val(prizeNum);
				}
				else
				{
					$("#juesaichushen > div.final > div.left > div.statics > input.prizeNum").val("");
				}
				$("#juesaichushen > div.final > div.workList").html("");
				$("#juesaichushen > div.final > div.left > div.statics > span.workSum").html(result.workList.length);
				$.each(result.workList,function(index,item){
					$("#juesaichushen > div.final > div.workList").append(makeFinalBlock(item));
				});
				calPrize();
			},'json');
		}
	function makeFinalBlock(item)
	{
		
		if((item.prizeNum != null) && (item.prize != null))
		{
			prize = "<option value='null'></option>";
			$.each(item.prize,function(index,it){
				prize+='<option value="'+it.prizeId+'">'+it.prizeNote+'</option>';
			});
			p = '<div class="prize"><select>'+prize+'</select></div>';
		}
		else
		{
			p = "";
		}
		var workIdStr = parseInt(item.workId)+<?php echo IDADDUP;?>;
		var $res = $('<div class="block">'+
			'<input class="id" type="hidden" value="'+item.id+'"></input>'+
			'<input class="checkId" type="hidden" value="'+item.checkId+'"></input>'+
			'<input class="workTitle" type="hidden" value="'+item.workTitle+'"></input>'+
			'<input class="prizeNum" type="hidden" value="'+item.prizeNum+'"></input>'+
			'<input class="workId" type="hidden" value="'+item.workId+'"></input>'+
			'<a target="_blank" class="line" href="<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/viewWorkForJM?blockId=<?php echo $blockId;?>&checkId='+item.checkId+'">'+
				workIdStr+". "+item.workTitle+
			'</a>'+
			'<div class="line">小组排名:'+item.rank+'</div>'+
			//'<div class="line">评审备注:'+item.note+'</div>'+
			p+
		'</div>');
		//选择附加项目
		if(item.prizeNum != null)
		{
			$res.find("div.prize > select > option[value='"+item.prizeId+"']").prop("selected",true);
		}
		return $res;
	}
		function getGroupList2()
	{
		$("#juesaichushen > div.final > div.left > div.groupList").html('<div class="wrapLoading"><div class="loading"></div></div>');
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getGroupList?blockId=<?php echo $blockId?>","",function(result){
			//alert(result);
			$("#juesaichushen > div.final > div.left > div.groupList").html("");
			$.each(result,function(index,item){
					var prizeNum = ((item.prizeNum == "") || (item.prizeNum == null))?" ":" ("+item.prizeNum+") ";
					var status = "("+item.rankedCount+"/"+item.workCount+")";
					$("#juesaichushen > div.final > div.left > div.groupList").append(
						'<div class="block">'+
							'<input class="groupId" type="hidden" value="'+item.groupId+'"></input>'+
							'<input class="groupName" type="hidden" value="'+item.groupName+'"></input>'+
							item.groupName+prizeNum+status+
						'</div>'
					);
			});
			
			//点击第一项目
			$("#juesaichushen > div.final > div.left > div.groupList > div.block").eq(0).click();
		},'json');
	}
		
		function show1(str)
	{
		$("#juesaichushen span.show1").html(str);
		setTimeout(function(){
			$("#juesaichushen span.show1").html("");
		},3000);
	}
	function show2(str)
	{
		$("#juesaichushen span.show2").html(str);
		setTimeout(function(){
			$("#juesaichushen span.show2").html("");
		},3000);
	}
	$(document).ready(function(){
		//$.cookie("exa","cdf");
		//alert($.cookie("exa"));
		//getAllFinal();
	});
	$(document).delegate("#juesaichushen > div.title > div.fresh2,#juesaichushen > div.allFinal > div.statics > div.getWork","click",function(){
		getAllFinal();
	});
	//点击赛区、种类，获取结果
	/*
	$(document).delegate("#juesaichushen > div.allFinal > input.zoneId","change",function(){
		//var zoneName = $("#juesaichushen > div.allFinal > input.zoneName").val();
		//var zoneId = $(this).val();
		var groupIds = $().val();
		//修改下载显示，以及链接
		//$("#juesaichushen > div.title > a.downloadPrize").children("span").html(zoneName);
		$("#juesaichushen > div.title > a.downloadPrize").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadFinal?blockId=<?php echo $blockId;?>&zoneId="+zoneId);
		getAllFinal();
	});*/
	$(document).delegate("#juesaichushen > div.allFinal > input.subTypeId","change",function(){
		getAllFinal();
	});
	//获取全部奖项结果 
	function getAllFinal()
	{
		var data = {};
		data.zoneId = $("#juesaichushen > div.allFinal > input.zoneId").val();
		data.subTypeId = $("#juesaichushen > div.allFinal > input.subTypeId").val();
		data.groupIds = $("#juesaichushen > div.allFinal > input.groupIds").val();
		$("#juesaichushen > div.allFinal > div.workList").html('<div class="wrapLoading"><div class="loading"></div></div>');
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getAllFinal?blockId=<?php echo $blockId?>",data,function(result){
			$("#juesaichushen > div.allFinal > div.workList").html("");
			//alert(result);
			$("#juesaichushen > div.allFinal > div.statics > span.workSum").html(result.workList.length);
			$.each(result.workList,function(index,item){
				$("#juesaichushen > div.allFinal > div.workList").append(makeFinalBlock2(item));
			});
			calPrize2();
		},'json');
	}
	function calPrize2()
		{
			var cal = {};
			$("#juesaichushen > div.allFinal > div.workList > div.block").each(function(){
				var $option = $(this).find("div.prize > select > option:selected");
				if(($option.length == 1) && ($option.html() != ""))
				{
					var prizeName = $option.html();
					var prizeId = $option.val();
					//alert(prizeName);
					//return false;
					if(cal[prizeName] == null)
					{
						cal[prizeName] = 0;
					}
					cal[prizeName]++;
				}
			});
			var prizeStr = "";
			for(var prizeName in cal)
			{
				prizeStr+=prizeName+": "+cal[prizeName]+" <br/>";
			}
			$("#juesaichushen > div.allFinal > div.statics > span.prizeStr").html(prizeStr);
		}
		//保存某个奖项
		$(document).delegate("#juesaichushen > div.allFinal > div.workList > div.block > div.save","click",function(){
			if($(this).hasClass("disabled"))
			{
				return;
			}
			var data = {};
			data.id = $(this).parent().children("input.id").val();
			data.prizeId = $(this).parent().find("div.prize > select > option:selected").val();
			$(this).addClass("disabled");
			showWorkListLoading2();
			/*$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/saveOnePrize?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				$("#juesaichushen > div.allFinal > div.workList > div.block > div.save").removeClass("disabled");
				//show2("保存成功!");
				alert("修改成功!");
				hideWorkListLoading2();
				calPrize2();
			});*/
			$.ajax({
				"type":"POST",
				"url":"<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/saveOnePrize?blockId=<?php echo $blockId?>",
				"data":data,
				"success":function(result){
					alert("修改成功!");
					calPrize2();
				},
				"error":function(){
					alert("网络超时，请重试");
				},
				"complete":function(){
					hideWorkListLoading2();
					$("#juesaichushen > div.allFinal > div.workList > div.block > div.save").removeClass("disabled");
				}
			});
		});
		function makeFinalBlock2(item)
	{
		
			if((item.prizeNum != null) && (item.prize != null))
		{
			prize = "<option value='null'></option>";
			$.each(item.prize,function(index,it){
				prize+='<option value="'+it.prizeId+'">'+it.prizeNote+'</option>';
			});
			p = '<div class="prize"><select>'+prize+'</select></div>';
		}
		else
		{
			p = "";
		}
		var workIdStr = parseInt(item.workId)+<?php echo IDADDUP;?>;
		var $res = $('<div class="block">'+
			'<input class="id" type="hidden" value="'+item.id+'"></input>'+
			'<input class="checkId" type="hidden" value="'+item.checkId+'"></input>'+
			'<input class="workTitle" type="hidden" value="'+item.workTitle+'"></input>'+
			'<input class="prizeNum" type="hidden" value="'+item.prizeNum+'"></input>'+
			'<input class="workId" type="hidden" value="'+item.workId+'"></input>'+
			'<a target="_blank" class="line" href="<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/viewWorkForJM?blockId=<?php echo $blockId;?>&checkId='+item.checkId+'">'+
				workIdStr+". "+item.workTitle+
			'</a>'+
			'<div class="line">所属小组: '+item.groupName+'</div>'+
			'<div class="line">小组排名: '+item.rank+'</div>'+
			'<div class="line">备注/小组评语: '+item.note+'</div>'+
			'<div class="btn btn-small btn-danger save">修改</div>'+
			p+
		'</div>');
		//选择附加项目
		if(item.prizeNum != null)
		{
			$res.find("div.prize > select > option[value='"+item.prizeId+"']").prop("selected",true);
		}
		return $res;
	}
	function showWorkListLoading()
	{
		//计算当前workList高度
		var height = $("#juesaichushen > div.final > div.workList").height();
		//alert(height);
		$("#juesaichushen > div.final > div.loadingP").css("height",height+"px");
		$("#juesaichushen > div.final > div.loadingP").show();
	}
	function hideWorkListLoading()
	{
		$("#juesaichushen > div.final > div.loadingP").hide();
	}
	function showWorkListLoading2()
	{
		//计算当前workList高度
		var height = $("#juesaichushen > div.allFinal > div.workList").height();
		//alert(height);
		$("#juesaichushen > div.allFinal > div.loadingP").css("height",height+"px");
		$("#juesaichushen > div.allFinal > div.loadingP").show();
	}
	function hideWorkListLoading2()
	{
		$("#juesaichushen > div.allFinal > div.loadingP").hide();
	}
	$(document).ready(function(){
		getGroupList3();
	});
	function getGroupList3()
	{
		$("#juesaichushen > div.allFinal > div.statics > div.groupList").html('<div class="wrapLoading"><div class="loading"></div></div>');
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/getGroupList?blockId=<?php echo $blockId?>","",function(result){
			//alert(result);
			$("#juesaichushen >div.allFinal > div.statics > div.groupList").html("");
			$.each(result,function(index,item){
					$("#juesaichushen > div.allFinal > div.statics > div.groupList").append(
						'<div class="block">'+
							'<input class="groupName" type="hidden" value="'+item.groupName+'"></input>'+
							'<input class="groupId" type="checkbox" value="'+item.groupId+'"></input> '+
							item.groupName+
						'</div>'
					);
			});			
		},'json');
	}
	//点击了组
	$(document).delegate("#juesaichushen > div.allFinal > div.statics > div.groupList > div.block > input.groupId","click",function(){
		//alert("a");
		resetGroupIds();
		//设置下载链接
		var groupIds = $("#juesaichushen > div.allFinal > input.groupIds").val();
		$("#juesaichushen > div.title > a.downloadPrize").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/juesaichushen/downloadFinal?blockId=<?php echo $blockId;?>&groupIds="+groupIds);

	});
	function resetGroupIds()
	{
		//根据打勾的修改input.groupIds,用|分隔groupId
		var groupIds = "";
		$("#juesaichushen > div.allFinal > div.statics > div.groupList > div.block > input.groupId:checked").each(function(){
			groupIds+=$(this).val()+"|";
		});
		$("#juesaichushen > div.allFinal > input.groupIds").val(groupIds);
	}
	</script>
	<style type="text/css">
		#juesaichushen > div.allFinal > div.statics{
			float:left;
			width:200px;
			padding-left:10px;
		}
		#juesaichushen > div.allFinal > div.statics > div.list{
			height:150px;
			overflow:auto;
		}
		#juesaichushen > div.allFinal > div.workList{
			margin:0 0 0 220px;
		}
		#juesaichushen > div.allFinal > div.workList > div.block > div.save{
			position:absolute;
			top:8px;
			right:210px;
		}	
	</style>
	<br/>
	<div class="title">
		全部奖项结果 
		<div class="btn btn-small btn-info fresh2">刷新</div>
		<a class="btn btn-small btn-success downloadPrize" target="_blank" href="">下载<span class="zoneName"></span>奖项结果</a>
		<span class="show show2"></span>
	</div>
	<br/>
	<div class="allFinal">
		<div class="loadingP" style="display:none">
				<div class="wrapLoading">
					<div class="loading"></div>
				</div>
			</div>
		<div class="statics">
			<!--
			<div class="zoneList list">
					<?php 
					/*
			$this->widget('CatalogViewerWidget',array(
				'id' => 'catalogDiv3',
				'targetSelector' => array(
					'"#juesaichushen > div.allFinal > input.zoneId"',
				),
				'targetTitleSelector' => '"#juesaichushen > div.allFinal > input.zoneName"',
				'catalogIdArray' => $allWCataId,
				'showInternal' => true,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'hasAll' => false,//JM会被限定某个赛区中
				'instantChange' => true,//进入页面就选中第一个“全部”
			));
			*/
		?>
			</div>
			<br/>
			<div class="typeList list">
				<?php
				/*
			$this->widget("TypeListWidget",array(
				"id" => "typeListRes2",
				"targetSelector" => array(
					"#juesaichushen > div.allFinal > input.subTypeId",
				),
				"targetTypeName" => "#juesaichushen > div.allFinal > input.subTypeName",
				"targetFirstTypeName" => "#juesaichushen > div.allFinal > input.typeName",
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => true,//前头多一个选项block,填充"all"到target
				'instantChange' => true,//进入页面就选中第一个选项
			));*/
		?>
			</div>
			-->
			<div class="groupList list">
			</div>
			<div class="btn btn-block btn-primary getWork">获取奖项结果</div>
			作品总数: <span class="workSum"></span><br/>
			<span class="prizeStr"></span>
		</div>
		<input type="hidden" class="zoneId"></input>
		<input type="hidden" class="zoneName"></input>
		<input type="hidden" class="typeName"></input>
		<input type="hidden" class="subTypeId"></input>
		<input type="hidden" class="subTypeName"></input>
		<input type="hidden" class="groupIds"></input>
		<div class="workList">
		
		</div>
	</div>
</div>