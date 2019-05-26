<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id?> > div.filter{
		height:200px;
		overflow:auto;
		float:left;
		width:250px;
	}
	#<?php echo $id?> > div.input{
	
	}
</style>
<script type="text/javascript">
//修改workIdArr到catalogId,subTypeId
$(document).delegate("#<?php echo $id?> > div.change","click",function(){	
	if($(this).hasClass("disabled"))
	{
		return;
	}
	var data ={};
	data.workIdStr = $("#<?php echo $id?> > div.input > #workIdArr > textarea").val();
	data.catalogId = $("#<?php echo $id?> > input.catalogId").val();
	data.subTypeId = $("#<?php echo $id?> > input.subTypeId").val();
	var catalogTitle = $("#<?php echo $id?> > input.catalogTitle").val();
	var typeName = $("#<?php echo $id?> > input.typeName").val();
	var subTypeName = $("#<?php echo $id?> > input.subTypeName").val();
	//检查空
	if((data.catalogId == "") || (data.workIdStr == "") || (data.subTypeId == ""))
	{
		return;
	}
	var str = "确认把 "+data.workIdStr.replace(/\n/g," ")+" 属性修改至 "+catalogTitle+" "+typeName+"-"+subTypeName+" ";
	if(!confirm(str))
	{
		return;
	}
	data.workIdStr = $("#<?php echo $id?> > div.input > #workIdArr > textarea").val();
	$("#<?php echo $id?> > div.changeE").html("修改中...");
	$("#<?php echo $id?> > div.change").addClass("disabled");
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/match/changeWork",data,function(result){
		//alert(result);
		$("#<?php echo $id?> > div.changeE").html("");
		if(result.error != null)
		{
			if(result.error == "no")
			{	
				alert("该赛区没有此作品类别，修改失败！");
			}
		}
		else
		{
			var str = "成功修改了这些作品ID的属性: <br/>";
			for(var i=0;i<result.success.length;++i)
			{
				str+=result.success[i]+" <br/>";
			}
			$("#<?php echo $id?> > div.changeE").html(str);
		}
		$("#<?php echo $id?> > div.change").removeClass("disabled");
		
	},'json');
});
//下载备份，post 作品id 列表到iframe中
$(document).delegate("#<?php echo $id?> > div.backup","click",function(){	
	if($(this).hasClass("disabled"))
	{
		return;
	}
	/*var data ={};
	data.workIdStr = $("#<?php echo $id?> > div.input > #workIdArr > textarea").val();
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/match/changeWorkBackup",data,function(result){
		alert(result);
	});*/
	if($("#<?php echo $id?> > div.input > #workIdArr > textarea").val() == "")
	{
		return;
	}
	//显示下载中
	$(this).addClass("disabled").html("下载中...");
	setTimeout(function(){
		$("#<?php echo $id?> > div.backup").removeClass("disabled").html("下载备份");
	},3000);
	$("#<?php echo $id?> > div.input > #workIdArr").submit();
});
</script>
<div id="<?php echo $id?>">
	<input class="catalogId" type="hidden"></input>
	<input class="subTypeId" type="hidden"></input>
	<input class="catalogTitle" type="hidden"></input>
	<input class="subTypeName" type="hidden"></input>
	<input class="typeName" type="hidden"></input>
	<div class="line">说明:确认修改,删除这些作品原来所有评审信息！此处备份只是该作品评审流程中的概览，请务必在各个评审流程中对该作品完整备份</div>
	<div class="input">
		<form id="workIdArr" action="<?php echo Yii::app()->baseUrl?>/index.php/match/changeWorkBackup" method="post" target="download">
			<textarea name="workIdStr" class="workIdStr" style="height:100px;"></textarea>
		</form>
	</div>
	<div class="filter">
		<?php 
			
			$this->widget('CatalogViewerWidget',array(
				'id' => $id.'catalogDiv',
				'targetSelector' => array(
					'"#'.$id.' > input.catalogId"',
				),
				'targetTitleSelector' => '"#'.$id.' > input.catalogTitle"',
				'catalogIdArray' => $allWId,
				'showInternal' => true,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'hasAll' => false,//JM会被限定某个赛区中
				'instantChange' => false,//进入页面就选中第一个
			));
		?>
	</div>
	<div class="filter">
	<?php
			$this->widget("TypeListWidget",array(
					'id' => $id."typeList",
					"targetSelector" => array(
						"#".$id." >  input.subTypeId",
					),
				"targetTypeName" => "#".$id." > input.subTypeName",
				"targetFirstTypeName" => "#".$id." > input.typeName",
					"showTypeName" => true,
					'hasAll' => false,
					'instantChange' => false,
					'showToggle' => true,
				));
		?>
	</div>
	<iframe name="download" id="download" style="display:none"></iframe>
	<div style="clear:both"></div>
	<div class="btn btn-success backup">下载备份</div>
	<div class="btn btn-danger change">修改</div>
	<div class="changeE"></div>
</div>