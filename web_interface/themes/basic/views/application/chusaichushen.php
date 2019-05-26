<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#chusaichushen{
	height:auto!important;
	height:700px;
	min-height:700px;
}
#chusaichushen div.title{
	padding:5px 0;
	margin-top:5px;
	background-color:rgb(245,245,245);
	font-size:15px;
	font-weight:bold;
	text-align:center;
}
#chusaichushen > div.opNote{
	padding:10px;
}

#chusaichushen > div.judgeCtr > div.left{
	float:left;
	width:350px;
}
#chusaichushen > div.judgeCtr > div.right{
	margin:0 0 0 360px;
}
#chusaichushen > div.judgeCtr > div.right > div.filterDiv{
	position:relative;
	height:200px;
	overflow:auto;
}
#chusaichushen > div.left > div.ctr{
	padding:5px;
	margin:5px;
	background-color:rgb(250,250,250);
	width:100px;
}

#chusaichushen > div.judgeCtr > div.left > div.ctr{
	padding:5px;
	margin:5px;
	background-color:rgb(250,250,250);
	width:100px;
}
#chusaichushen > div.judgeCtr > div.left > div.bili{
	padding:5px;
	margin:5px;
	background-color:rgb(250,250,250);
}
#chusaichushen > div.judgeCtr > div.left > div.bili > div.line > input.bili{
	width:30px;
}
#chusaichushen > div.judgeCtr > div.left > div.judgeList{
	padding:5px;
}
#chusaichushen > div.judgeCtr > div.left > div.judgeList > div.judgeBlock
{
	background-color:rgb(245,245,245);
	padding:5px;
	border:1px solid silver;
	border-width:0 1px 1px 0;
	position:relative;
}
#chusaichushen > div.judgeCtr > div.left > div.judgeList > div.judgeBlock > div.delete{
	cursor:pointer;
	width:20px;
	position:absolute;
	top:3px;
	right:3px;
}
#chusaichushen > div.resCtr{
	margin:10px;
	width:400px;
	background-color:rgb(250,250,250);
	padding:10px;
	height:25px;
}
#chusaichushen > div.resCtr > div.filter{
	width:50px;
	padding:3px;
	text-align:center;
	float:left;
	margin-left:15px;
	cursor:pointer;
}
#chusaichushen > div.resCtr > div.filter:hover{
	background-color:rgb(240,240,240);
}
#chusaichushen > div.resCtr > div.filter.toggle{
	color:white;
	background-color:#0088ff;
}
#chusaichushen > div.resultList{
	padding:10px
}
#chusaichushen > div.resultList > div.block{
	position:relative;
	background-color:rgb(245,245,245);
	padding:10px;
	border:1px silver solid;
	border-width:0 1px 1px 0;
}
#chusaichushen > div.resultList > div.block > div.line{
	padding:3px 0;
}
#chusaichushen > div.resultList > div.block > div.line.workTitle{
	font-size:14px;
	font-weight:bold;
}
#chusaichushen > div.resultList > div.block > div.line.workSubTitle{
	color:gray;
}
/*
#chusaichushen > div.resultList > div.block > div.score{
	position:absolute;
	top:10px;
	right:40%;
	width:200px;
}*/
#chusaichushen > div.groupDetail > div.left{
	float:left;
	width:200px;
	height:300px;
	overflow:auto;
	position:relative;
}
#chusaichushen > div.groupDetail > div.right{
	margin:0 0 0 210px;
	height:auto!important;
	height:300px;
	min-height:300px;
	position:relative;
}
#chusaichushen > div.groupDetail > div.right > div.loading1{
	padding:120px 0;
	background-color:silver;
	position:absolute;
	top:0;left:0;
	width:630px;
	display:none;
		background-color:silver;
		opacity:0.7;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=70);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; /*IE8*/
		z-index:990;
}
#chusaichushen > div.groupDetail > div.right > div.block{
	height:250px;
}
#chusaichushen > div.groupDetail > div.right > div.workList{
	float:left;
	width:400px;
	border-right:1px silver solid;
}
#chusaichushen > div.groupDetail > div.right > div.block > div.list{
	padding-top:10px;
	height:220px;
	position:relative;
	overflow:auto;
}
#chusaichushen > div.groupDetail > div.right > div.judgeList{
	margin:0 0 0 400px;
}
#chusaichushen > div.groupDetail > div.right > div.block > div.list > div.block{
	position:relative;
	background-color:rgb(245,245,245);
	border-bottom:1px silver solid;
	padding:5px;
}
#chusaichushen > div.groupDetail > div.right > div.block > div.list > div.block > div.delete{
	position:absolute;
	top:2px;
	right:3px;
	width:10px;
	cursor:pointer;
}
#chusaichushen > div.selectStuff > div.filter{
	float:left;
	width:120px;
	height:500px;
	overflow:auto;
	position:relative;
}
#chusaichushen > div.selectStuff > div.stuff{
	margin:0 0 0 240px;
	height:500px;
}
#chusaichushen > div.selectStuff > div.stuff > div.workList{
	float:left;
	width:400px;
}
#chusaichushen > div.selectStuff > div.stuff > div.judgeList{
	margin:0 0 0 400px;
}
#chusaichushen > div.selectStuff > div.stuff > div.judgeList > div.judgeType{
	height:150px;
	overflow:auto;
	position:relative;
}
#chusaichushen > div.judgeCtr > div.right > div.zone{
	width:200px;
	float:left;
}
#chusaichushen > div.judgeCtr > div.right > div.typeSelect{
	margin: 0 0 0 210px;
}
#chusaichushen > div.cataSelectRes,
#chusaichushen > div.typeSelectRes{
	float:left;
	width:150px;
	height:300px;
	overflow:auto;
	position:relative;
}
#chusaichushen > div.resultList{
	margin:0 0 0 300px;
	height:400px;
	overflow:auto;
	position:relative;
}
#chusaichushen > div.resultList > div.block > div.result{
	padding:5px;
}
#chusaichushen > div.resultList > div.block > div.result > input.resultNum{
	padding:0;margin:0
}
#chusaichushen > div.resStatistic
{
	margin:10px 0 10px 310px;
	padding:10px;
	background-color:rgb(245,245,245);
}
#chusaichushen > div.resStatistic > div.line{
	padding:3px 0;
}
#chusaichushen > div.resStatistic > div.line.small{
	color:gray;font-size:13px;
}
#chusaichushen > div.title.resultSave2{
	margin:0 0 0 300px;
}
#chusaichushen > div.final{
	margin:0 0 0 310px;
	height:auto!important;
	height:300px;
	min-height:300px;
}
#chusaichushen > div.pModal > div.modal-body > div.note{
	padding:5px;
}
#chusaichushen > div.pModal > div.modal-body > div.result{
	padding:5px;
	height:30px;
}
#chusaichushen > div.pModal > div.modal-body > div.result > div.block{
	float:left;
	padding:5px;
	text-align:center;
	cursor:pointer;
	width:80px;
}
#chusaichushen > div.pModal > div.modal-body > div.result > div.block.toggle{
	color:white;
	background-color:<?php echo COLOR1_LIGHTER1;?>;
}
#chusaichushen > div.pModal > div.modal-body > textarea.p{
	height:100px;
}
</style>
<div id="chusaichushen">
	<div class="opNote"><?php 
		$this->widget("NoticeWidget",array(
			"name" => "chusaichushenJM",
		));
	?></div>
	<div class="groupDetail">
		<div class="left">
			<div class="btn btn-block btn-small btn-danger newGroupx">清空以新建分组</div>
			<div class="title">本赛区分组列表</div>
			<?php 
				$this->widget("CscsGroupListWidget",array(
					"id" => "cscsGroup",
					"blockId" => $blockId,
					"targetSelector" => array(
						array(
							"groupId" => "#chusaichushen > div.groupDetail > div.right > input.groupId",
							"groupName" => "#chusaichushen > div.groupDetail > div.right > div.groupName > input.groupName",
						)
					),
				));
			?>
		</div>
		<div class="grouping right">
			<div class="loading1">
				<div class="wrapLoading"><div class="loading"></div></div>
			</div>
			<input class="groupId" type="hidden"></input>
			<input class="catalogId" type="hidden"></input>
			<input class="catalogTitle" type="hidden"></input>
			<div class="groupName">
				当前赛区: <span class="zoneName"></span> 组名: <input class="groupName"></input> <div class="btn btn-small btn-info saveGroup">新建/保存</div> <span class="groupE" style="color:red"></span>
			</div>
			<div class="workList block">
				<div class="title">作品列表</div>
				<input class="checkWorkId" type="hidden" ></input>
				<input class="workId" type="hidden" ></input>
				<input class="workTitle" type="hidden" ></input>
				<input class="typeName" type="hidden"></input>
				<input class="subTypeName" type="hidden"></input>
				<div class="list"></div>
			</div>
			<div class="judgeList block">
				<div class="title">评委列表(一组三个)</div>
				<input class="judgeId" type="hidden"></input>
				<input class="judgeName" type="hidden"></input>
				<div class="list"></div>
			</div>
		</div>
		<script type="text/javascript">
			//新建/保存分组
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > div.groupName > div.saveGroup","click",function(){
				var data={};
				data.groupId = $("#chusaichushen  > div.groupDetail > div.right > input.groupId").val();
				data.groupName = $("#chusaichushen  > div.groupDetail > div.right > div.groupName > input.groupName").val();
				if(data.groupName == "")
				{
					showGroupE("请输入组名");
					return;
				}
				data.catalogId = $("#chusaichushen  > div.groupDetail > div.right > input.catalogId").val();
				data.workList = new Array();
				data.judgeList = new Array();
				$("#chusaichushen  > div.groupDetail > div.right > div.judgeList > div.list > div.block").each(function(){
					data.judgeList.push($(this).children("input.judgeId").val());
				});
				if(data.judgeList.length < 3)
				{
					showGroupE("一个作品组需要3名初审评委!");
					return;
				}
				$("#chusaichushen  > div.groupDetail > div.right > div.workList > div.list > div.block").each(function(){
					data.workList.push($(this).children("input.checkId").val());
				});
				if(data.workList.length == 0)
				{
					showGroupE("请选择作品!");
					return;
				}
				showLoading1();
				$.post("<?php echo Yii::app()->baseUrl?>/index.php/chusaichushen/saveNewGroup?blockId=<?php echo $blockId?>",data,function(result){
					//alert(result);
					hideLoading1();
					//刷新
					$("#chusaichushen > div.groupDetail > div.left > #cscsGroup > input.catalogId").change();
				});
			});
			//新建分组，刷新groupList,同时清空一些东西 
			$(document).delegate("#chusaichushen > div.groupDetail > div.left > div.newGroupx","click",function(){
				if(!confirm("确定清空当前分组并新建吗？"))
				{
					return;
				}
				$("#chusaichushen > div.groupDetail > div.left > #cscsGroup > input.catalogId").change();
				//$().val("");
			});
			//绑定赛区切换的change
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > input.catalogId","change",function(){
				var zoneName = $(this).parent().children("input.catalogTitle").val();
				$("#chusaichushen  > div.groupDetail > div.right > div.groupName > span.zoneName").html(zoneName);
			});
			//删除
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > div.block > div.list > div.block > div.delete","click",function(){
				$(this).parent().remove();
			});
			//绑定workList 的change事件 ,添加一个work
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > div.workList > input.checkWorkId","change",function(){
				var checkId = $(this).val();
				var workId = $(this).parent().children("input.workId").val();
				var workTitle = $(this).parent().children("input.workTitle").val();
				var typeName = $(this).parent().children("input.typeName").val();
				var subTypeName = $(this).parent().children("input.subTypeName").val();
				//检查是否重复
				var repeat = false;
				$("#chusaichushen  > div.groupDetail > div.right > div.workList > div.list > div.block").each(function(){
					var id = $(this).children("input.checkId").val();
					if(id == checkId)
					{
						repeat=true;
						return false;
					}
				});
				if(repeat)
				{
					showGroupE("此作品已经被选择");
					return;
				}
				else
				{
					$("#chusaichushen  > div.groupDetail > div.right > div.workList > div.list").append(makeWorkBlock(checkId,workId,workTitle,typeName,subTypeName));
				}
			});
			//绑定judgeList 的change事件 ,添加一个judge
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > div.judgeList > input.judgeId","change",function(){
				var judgeId = $(this).val();
				var judgeName = $(this).parent().children("input.judgeName").val();
				//检查是否已经够三个
				if($("#chusaichushen  > div.groupDetail > div.right > div.judgeList > div.list > div.block").length == 3)
				{
					showGroupE("一个作品组只分配3个初审评委!");
					return;
				}
				//检查是否重复
				var repeat = false;
				$("#chusaichushen  > div.groupDetail > div.right > div.judgeList > div.list > div.block").each(function(){
					var id = $(this).children("input.judgeId").val();
					if(id == judgeId)
					{
						repeat=true;
						return false;
					}
				});
				if(repeat)
				{
					showGroupE("此评委已经被选择");
					return;
				}
				else
				{
					$("#chusaichushen  > div.groupDetail > div.right > div.judgeList > div.list").append(makeJudgeBlock(judgeId,judgeName));
				}
			});
			function showGroupE(str)
			{
				$("#chusaichushen > div.groupDetail > div.right > div.groupName > span.groupE").html(str);
				setTimeout(function(){
					$("#chusaichushen > div.groupDetail > div.right > div.groupName > span.groupE").html("");
				},3000);
			}
			//groupId的change,获取该group所有的judgeList,workList,
			$(document).delegate("#chusaichushen  > div.groupDetail > div.right > input.groupId","change",function(){
				var data = {};
				//alert("a");
				data.groupId = $(this).val();
				//当groupId为空，清空
				if(data.groupId == "")
				{
					$("#chusaichushen > div.groupDetail > div.right > div.groupName > input.groupName").val("");
					$("#chusaichushen > div.groupDetail > div.right > div.block > div.list").html("");
					return;
				}
				showLoading1();
				$.post("<?php echo Yii::app()->baseUrl?>/index.php/chusaichushen/getGroup?blockId=<?php echo $blockId?>",data,function(result){
					//alert(result);
					
					$("#chusaichushen > div.groupDetail > div.right > div.block > div.list").html("");
					$.each(result.judgeList,function(index,item){
						var name = item.realName!=""?item.realName:item.nickName!=""?item.nickName:item.userName;
						$("#chusaichushen > div.groupDetail > div.right > div.judgeList > div.list").append(makeJudgeBlock(item.judgeId,name));
					});
					$.each(result.workList,function(index,item){
						$("#chusaichushen > div.groupDetail > div.right > div.workList > div.list").append(makeWorkBlock(item.checkId,item.workId,item.workTitle,item.typeName,item.subTypeName));
					});
					hideLoading1();
				},'json');
			});
			function makeJudgeBlock(judgeId,judgeName)
			{
				return $('<div class="judgeBlock block">'+
					'<input class="judgeId" type="hidden" value="'+judgeId+'"></input>'+
					'<div class="delete">&times;</div>'+
					'<div class="line">'+judgeName+'</div>'+					
					'<div class="line" style="color:silver">No. '+judgeId+'</div>'+
				'</div>');
			}
			function makeWorkBlock(checkId,rworkId,workTitle,workTypeName,workSubTypeName)
			{
				var workId =<?php echo IDADDUP ;?>+parseInt(rworkId);
				return $('<div class="workBlock block">'+
					'<input class="checkId" type="hidden" value="'+checkId+'"></input>'+
					'<div class="delete">&times;</div>'+
					'<div class="line">'+workId+". "+workTitle+'</div>'+
					'<div class="line" style="color:silver">'+workTypeName+"-"+workSubTypeName+'</div>'+
				'</div>');
			}
			function showLoading1()
			{
				$("#chusaichushen > div.groupDetail > div.right > div.loading1").show();
			}
			function hideLoading1()
			{
				$("#chusaichushen > div.groupDetail > div.right > div.loading1").hide();
			}
		</script>
	</div>
	<div class="selectStuff">
		<div class="filter zone">
		<?php 
			$this->widget('CatalogViewerWidget',array(
				'id' => 'catalogDiv1',
				'targetSelector' => array(
					'"#chusaichushen > div.selectStuff > div.stuff > div.workList > #judgeWorkList1 > input.catalogId"',
					'"#chusaichushen > div.selectStuff > div.stuff > div.judgeList > #judgeList1 > form > input.zoneId"',
					'"#chusaichushen > div.groupDetail > div.left > #cscsGroup > input.catalogId"',
					'"#chusaichushen  > div.groupDetail > div.right > input.catalogId"',
				),
				'targetTitleSelector' => '"#chusaichushen  > div.groupDetail > div.right > input.catalogTitle"',
				'catalogIdArray' => $allWCataId,
				'showInternal' => true,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'hasAll' => false,//JM会被限定某个赛区中
				'instantChange' => true,//进入页面就选中第一个“全部”
			));
		?>
		</div>
		<div class="filter type">
		<?php
			$this->widget("TypeListWidget",array(
				"id" => "typeList1",
				"targetSelector" => array(
					//"#chusaichushen > div.selectStuff > div.stuff > div.judgeList > #judgeList1 > form > input.goodAtId",
					"#chusaichushen > div.selectStuff > div.stuff > div.workList > #judgeWorkList1 > input.subTypeId",
				),
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => true,//前头多一个选项block,填充"all"到target
				'instantChange' => true,//进入页面就选中第一个选项
			));
		?>
		</div>
		<div class="stuff">
			<div class="workList">
				
		<?php 
			$this->widget("JudgeWorkListWidget",array(
				"id" => "judgeWorkList1",
				"blockId" => $blockId,
				"getWorkListUrl" => Yii::app()->baseUrl."/index.php/chusaichushen/getWorkList?blockId=".$blockId,
				"overflowHeight" => "500px",
				"targetSelector" => array(
					array(
						"workTitle" => "#chusaichushen  > div.groupDetail > div.right > div.workList > input.workTitle",
						"workSubTypeName" => "#chusaichushen  > div.groupDetail > div.right > div.workList > input.subTypeName",
						"workFirstTypeName" => "#chusaichushen  > div.groupDetail > div.right > div.workList > input.typeName",
						"checkWorkId" => "#chusaichushen  > div.groupDetail > div.right > div.workList > input.checkWorkId",
						"workId" => "#chusaichushen  > div.groupDetail > div.right > div.workList > input.workId",
					),
				),
			));
		?>
		
			</div>
			<div class="judgeList">
			<div class="title">评委擅长</div>
			<div class="judgeType">
			<?php
			$this->widget("TypeListWidget",array(
				"id" => "typeListJudge",
				"targetSelector" => array(
					"#chusaichushen > div.selectStuff > div.stuff > div.judgeList > #judgeList1 > form > input.goodAtId",
				),
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => true,//前头多一个选项block,填充"all"到target
				'instantChange' => true,//进入页面就选中第一个选项
			));
			?>
			</div>
			<?php 
			$this->widget("JudgeListWidget",array(
				"id" => "judgeList1",
				"goodAtId" => "",
				"provedOnly" => true,
				"targetSelector" => "#chusaichushen  > div.groupDetail > div.right > div.judgeList > input.judgeId",
				"targetName" => "#chusaichushen  > div.groupDetail > div.right > div.judgeList > input.judgeName",
				"showContent" => true,
				"overflowHeight" => "200px",
			));
		?>
			</div>
		</div>
	</div>
	
	<div style="clear:both"></div>
	<div class="title">评审结果 
		<div class="btn btn-small btn-info refreshRes">刷新</div>
		<div class="btn btn-small btn-success default">按默认设置审核结果*</div>
		<div class="btn btn-small btn-info p">批量操作</div><br/>
		<div class="btn btn-danger saveRes">保存<span class="zoneName"></span> <span class="typeName"></span>-<span class="subTypeName"></span> 评审结果</div>
		<span class="saveResE" style="color:red"></span>
		<a class="btn btn-small btn-success download" target="_blank" href="">下载<span class="zoneName"></span> <span class="typeName"></span>-<span class="subTypeName"></span> 评审结果</a>
	</div>
	<div class="resCtr" style="display:none">
		<div class="filter all toggle">全部</div>
		<div class="filter above">3-6</div>
		<div class="filter two">2</div>
		<div class="filter one">1</div>
		<div class="filter zero">0</div>
	</div>
	<div class="cataSelectRes">
		<?php 
			$this->widget('CatalogViewerWidget',array(
				'id' => 'catalogDiv2',
				'targetSelector' => array(
					'"#chusaichushen > input.resCataId"',
				),
				'targetTitleSelector' => '"#chusaichushen > input.zoneName"',
				'catalogIdArray' => $allWCataId,
				'showInternal' => true,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'hasAll' => false,//JM会被限定某个赛区中
				'instantChange' => true,//进入页面就选中第一个“全部”
			));
		?>
	</div>
	<div class="typeSelectRes">
		<?php
			$this->widget("TypeListWidget",array(
				"id" => "typeListRes",
				"targetSelector" => array(
					"#chusaichushen >  input.subTypeId",
				),
				"targetTypeName" => "#chusaichushen > input.subTypeName",
				"targetFirstTypeName" => "#chusaichushen > input.typeName",
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => true,//前头多一个选项block,填充"all"到target
				'instantChange' => true,//进入页面就选中第一个选项
			));
		?>
	</div>
	<input class="resCataId" type="hidden"></input>
	<input class="subTypeId" type="hidden"></input>
	<input class="zoneName" type="hidden"></input>
	<input class="typeName" type="hidden"></input>
	<input class="subTypeName" type="hidden"></input>
	<div class="resStatistic">
		<div class="line">以下列表作品总数:<span class="wholeSum"></span>
			<div class="btn btn-small btn-info resetSta">重新统计</div>
		</div>
		<div class="line">
			递交至初赛复审:<span class="csfsSum"></span>
			决赛初审:<span class="jscsSum"></span>
		</div>
		<div class="line">
			淘汰:<span class="taotaiSum"></span>
		</div>
		<div class="line small">*按默认设置评审结果:3分以上提交至决赛初审，1分到2分提交至初赛复审,其余淘汰。（设置后请点保存！）</div>
	</div>
	<div class="resultList"></div>
	<div class="title resultSave2">
		<div class="btn btn-danger saveRes">保存<span class="zoneName"></span> <span class="typeName"></span>-<span class="subTypeName"></span> 评审结果</div>
		<span class="saveResE" style="color:red"></span>
	</div>
	<div class="modal hide fade pModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 		<h3 style='line-height:25px'>批量操作</h3>
		</div>
		<div class="modal-body">
			<div class="note">批量设置评审结果</div>
			<div class="result">
				<div class="block r1">初赛复审</div>
				<div class="block r2 toggle">决赛</div>
				<div class="block r3">淘汰</div>
			</div>
			<textarea class="p"></textarea>
			<div class="btn btn-small btn-info save">保存</div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>
	<script type="text/javascript">
		//保存批量
		$(document).delegate("#chusaichushen > div.pModal > div.modal-body > div.save","click",function(){
			if(!$(this).hasClass("disabled"))
				{
					var workIdStr = $("#chusaichushen > div.pModal > div.modal-body > textarea.p").val();
					if($.trim(workIdStr) == "")
					{
						return;
					}
					var data = {};
					data.workIdStr = workIdStr;
					//2初赛复审,1决赛，0淘汰
					var $result = $("#chusaichushen > div.pModal > div.modal-body > div.result > div.block.toggle");
					data.result = $result.hasClass("r1")?2:($result.hasClass("r2")?1:0);
					resStr = $("#chusaichushen > div.pModal > div.modal-body > div.result > div.block.toggle").html();
					if(!confirm("确认设置这些作品评审结果为"+resStr+":\n"+data.workIdStr+"?"))
					{
						return ;
					}
					$(this).addClass("disabled");
					$.post("<?php echo Yii::app()->baseUrl?>/index.php/chusaichushen/psaveRes?blockId=<?php echo $blockId;?>",data,function(result){
						//alert(result);
						var goodStr = "";
						for(var i=0;i<result.length;++i)
						{
							goodStr+=result[i]+" \n";
						}
						$("#chusaichushen >  div.pModal > div.modal-body > div.save").removeClass("disabled");
						//重新载入结果列表
						$("#chusaichushen > input.resCataId").change();
						alert("成功修改了"+result.length+"个作品的评审结果,\n"+goodStr);
					},'json');
				}
		
		});
		//点击不同输出结果
		$(document).delegate("#chusaichushen > div.pModal > div.modal-body > div.result > div.block","click",function(){
			$(this).parent().children("div.block").removeClass("toggle");
			$(this).addClass("toggle");
		});
		//点击批量操作
		$(document).delegate("#chusaichushen > div.title > div.p","click",function(){
			$("#chusaichushen > div.pModal").modal("show");
		});
		//重新统计  result
		$(document).delegate("#chusaichushen > div.resStatistic > div.line > div.resetSta","click",function(){
			setResStc();
		});
		//刷新获取结果
		$(document).delegate("#chusaichushen > div.title > div.refreshRes","click",function(){
			$("#chusaichushen > input.resCataId").change();
		});
		//点击筛选
		$(document).delegate("#chusaichushen > div.resCtr > div.filter","click",function(){
			if(!$(this).hasClass("toggle"))
			{
				$("#chusaichushen > div.resCtr > div.filter").removeClass("toggle");
				$(this).addClass("toggle");
				getResList();
			}
		});
		//进入页面获取
		/*$(document).ready(function(){
			getResList();
		});*/
		//选择赛区获取结果
		$(document).delegate("#chusaichushen > input.resCataId","change",function(){
			getResList();
		});
		$(document).delegate("#chusaichushen > input.subTypeId","change",function(){
				getResList();
		});
		function getResList()
		{
			if(($("#chusaichushen > input.subTypeId").val() == "") || ($("#chusaichushen > input.resCataId").val() == ""))
			{
				return false;
			}
			//设置保存信息、下载信息
			$("#chusaichushen > div.title > div.saveRes > span").html("");
			$("#chusaichushen > div.title > a.download > span").html("");
			var zoneName = $("#chusaichushen > input.zoneName").val();
			var typeName = $("#chusaichushen > input.typeName").val();
			var subTypeName = $("#chusaichushen > input.subTypeName").val();
			$("#chusaichushen > div.title > div.saveRes").children("span.zoneName").html(zoneName);
			$("#chusaichushen > div.title > a.download").children("span.zoneName").html(zoneName);
			if(subTypeName != "全部")
			{
				$("#chusaichushen > div.title > div.saveRes").children("span.typeName").html(typeName).end()
				.children("span.subTypeName").html(subTypeName);
				$("#chusaichushen > div.title > a.download").children("span.typeName").html(typeName).end()
				.children("span.subTypeName").html(subTypeName);
			}	
			
			//设置下载链接
			$("#chusaichushen > div.title > a.download").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/downloadRes?blockId=<?php echo $blockId;?>&catalogId="+$("#chusaichushen > input.resCataId").val()+"&subTypeId="+$("#chusaichushen > input.subTypeId").val());
			
			var data = {};
			data.filter = $("#chusaichushen > div.resCtr > div.filter.toggle").hasClass("all")?"all":($("#chusaichushen > div.resCtr > div.filter.toggle").hasClass("above")?"above":($("#chusaichushen > div.resCtr > div.filter.toggle").hasClass("two")?"two":($("#chusaichushen > div.resCtr > div.filter.toggle").hasClass("one")?"one":"zero")));
			data.catalogId = $("#chusaichushen > input.resCataId").val();
			data.subTypeId = $("#chusaichushen > input.subTypeId").val();
			$("#chusaichushen > div.resultList").html("<div class='wrapLoading'><div class='loading'></div></div>");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/getRes?blockId=<?php echo $blockId;?>",data,function(result){
				//alert(result);
				$("#chusaichushen > div.resultList").html("");
				
				$.each(result.resList,function(index,item){
					var temp = makeResBlock(item,result.strategyList);
					$("#chusaichushen > div.resultList").append(temp);					
				});
				//设置统计信息
				setResStc();
				
			},'json');
		}
		//按默认设置结果 
		$(document).delegate("#chusaichushen > div.title > div.default","click",function(){
			$("#chusaichushen > div.resultList > div.block").each(function(){
				var score = $(this).children("input.score").val();
				if(score >= 3)
				{
					$(this).find("div.result > input.resultNum[value='1']").prop("checked",true);
				}
				else if(score == 0)
				{
					$(this).find("div.result > input.resultNum[value=null]").prop("checked",true);
				}
				else
				{
					//初赛复审
					$(this).find("div.result > input.resultNum[value='2']").prop("checked",true);
				}				
			});
			setResStc();
		});
		function setResStc()
		{
			//计算信息
			var wholeSum = 0,csfs = 0,jscs = 0,taotaiSum = 0;
			$("#chusaichushen > div.resultList > div.block").each(function(){
				var res = $(this).find("div.result > input.resultNum:checked").val();
				wholeSum++;
				res == 2?csfs++:res==1?jscs++:taotaiSum++;
			});			
			//alert(jscs);
			$("#chusaichushen > div.resStatistic").find("div.line > span.wholeSum").html(wholeSum).end()
					.find("div.line > span.csfsSum").html(csfs).end()
					.find("div.line > span.jscsSum").html(jscs).end()
					.find("div.line > span.taotaiSum").html(taotaiSum);
		}
		function makeResBlock(item,strategyList)
		{
			var detailStr = "";
			$.each(item.detail,function(index,it){
				if(it.score != null)
				{
					detailStr+=it.judgeName+"("+it.score+") ";
				}
				else
				{
					detailStr+=it.judgeName+"(未评分) ";
				}
			});
			
			var strategyStr = "";
			$.each(strategyList,function(index,it){
				strategyStr+= ' <input name="resultNum'+item.checkId+'" class="resultNum" type="radio" value="'+it.resultNum+'"></input>  '+it.strategyTitle;
			});
			strategyStr+=' <input name="resultNum'+item.checkId+'" class="resultNum" type="radio" value=null> '+"淘汰";
			
			var workId = <?php echo IDADDUP ;?> + parseInt(item.workId);
			
			var $temp = $('<div class="block">'+
				'<input class="checkWorkId" type="hidden" value="'+item.checkId+'"></input>'+
				'<input class="subTypeId" type="hidden" value="'+item.subTypeId+'"></input>'+
				'<input class="score" type="hidden" value="'+item.total+'"></input>'+
				'<div class="line workTitle">'+
					'<a target="_blank" href="<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/viewWorkForJM?blockId=<?php echo $blockId;?>&checkId='+item.checkId+'">'+
							workId+". "+item.workTitle+'</a>'+
				'</div>'+
				'<div class="result">'+
					'评审结果: '+
					strategyStr+
				'</div>'+
				'<div class="line workSubTitle">'+' 总得分: '+item.total+" "+item.typeName+' - '+item.subTypeName+' 评分细节: '+detailStr+'</div>'+
				//'<div class="score">总得分: '+item.total+' 评分: '+detailStr+'</div>'+
			'</div>');
			//设置本结果状态
			var resultNum = item.result.resultNum;
			//alert(resultNum);
			$temp.find("div.result > input[value='"+resultNum+"']").prop("checked",true);
			return $temp;
		}
		//点击保存结果
		$(document).delegate("#chusaichushen > div.title > div.saveRes","click",function(){
			var data = {};
			data.resList = new Array();
			$("#chusaichushen > div.resultList > div.block").each(function(){
				var temp = {};
				temp.checkId = $(this).children("input.checkWorkId").val();
				temp.resultNum = $(this).find("div.result > input.resultNum:checked").val();
				if(temp.resultNum == "null")
				{
					temp.resultNum = -1;
				}
				data.resList.push(temp);
			});
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/saveRes?blockId=<?php echo $blockId?>",data,function(result){
				//alert(result);
				if(result == "ok")
				{
					setSaveResE("保存成功!");
				}
				setResStc();
			});
		});
		function setSaveResE(str)
		{
			$("#chusaichushen > div.title > span.saveResE").html(str);
			setTimeout(function(){
				$("#chusaichushen > div.title > span.saveResE").html("");
			},3000);
		}
		//点击输出结果
		/*
		$(document).delegate("#chusaichushen > div.output","click",function(){
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/chusaichushen/result?blockId=<?php echo $blockId?>","",function(result){
				alert(result);
			});
		});
		*/
	</script>
	<!--<div class="btn btn-block btn-success output">输出结果(之前的输出结果会被覆盖)</div>-->
	<br/>
	<div class="cataSelectRes">
		<?php 
			$this->widget('CatalogViewerWidget',array(
				'id' => 'catalogDiv3',
				'targetSelector' => array(
					'"#chusaichushen > div.final > #getBlockRes > input.zoneId"',
				),
				'targetTitleSelector' => '"#chusaichushen > div.final > #getBlockRes > input.zoneName"',
				'catalogIdArray' => $allWCataId,
				'showInternal' => true,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'hasAll' => false,//JM会被限定某个赛区中
				'instantChange' => true,//进入页面就选中第一个“全部”
			));
		?>
	</div>
	<div class="typeSelectRes">
		<?php
			$this->widget("TypeListWidget",array(
				"id" => "typeListRes2",
				"targetSelector" => array(
					"#chusaichushen > div.final > #getBlockRes > input.subTypeId",
				),
				"targetTypeName" => "#chusaichushen > div.final > #getBlockRes > input.subTypeName",
				"targetFirstTypeName" => "#chusaichushen > div.final > #getBlockRes > input.typeName",
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => true,//前头多一个选项block,填充"all"到target
				'instantChange' => true,//进入页面就选中第一个选项
			));
		?>
	</div>
	<div class="final">
		<?php
			$this->widget("GetBlockResWidget",array(
				"id" => "getBlockRes",
				"blockId" => $blockId,
				"zoneId" => "",
				"subTypeId" => "",
				"instantLoad" =>  true,
				"hasHead" => true,
				"headTitle" => "最终评审提交结果",
			));
		?>
	</div>
</div>