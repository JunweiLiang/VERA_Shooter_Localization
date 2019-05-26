<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id?> > div.main{
	height:<?php echo $typeListHeight;?>;
	overflow:auto;
}
</style>
<div id="<?php echo $id?>">
	<input class="workId" type="hidden"></input>
	<input class="subTypeId" type="hidden"></input>
	<input class="checkId" type="hidden"></input>
	<div class="btn btn-small btn-primary btn-block save">保存作品类别</div>
	<div class="main">
	<?php
		$this->widget("TypeListWidget",array(
				"id" => $id."typeList",
				"targetSelector" => array(
					"#".$id." > input.subTypeId",
				),
				"showTypeName" => true,
				"showToggle" => true,//点击后toggle
				"hasAll" => false,//前头多一个选项block,填充"all"到target
				'instantChange' => false,//进入页面就选中第一个选项
			));
	?>
	</div>
</div>
<script type="text/javascript">
$(document).delegate("#<?php echo $id?> > input.workId","change",function(){
	//alert("workId change,getType!");
	var workId = $(this).val();
	<?php echo $id?>getWorkType(workId);
});
//通过checkId获取
$(document).delegate("#<?php echo $id?> > input.checkId","change",function(){
	//alert("workId change,getType!");
	var checkId = $(this).val();
	//alert(checkId);
	<?php echo $id?>getWorkTypeC(checkId);
});
function <?php echo $id?>getWorkTypeC(checkId)
{
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/getWorkType?workId=0&checkId="+checkId,"",function(result){
		var subTypeId = result.subTypeId;
		var workId = result.workId;
		//alert(subTypeId);
		$("#<?php echo $id?> > div.main > #<?php echo $id?>typeList > div.main > div.block > input.subTypeId[value='"+subTypeId+"']").parent().click();
		$("#<?php echo $id?> > input.workId").val(workId);
	},'json');
}
function <?php echo $id?>getWorkType(workId)
{
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/getWorkType?workId="+workId,"",function(result){
		var subTypeId = result.subTypeId;
		var workId = result.workId;
		$("#<?php echo $id?> > div.main > #<?php echo $id?>typeList > div.main > div.block > input.subTypeId[value='"+subTypeId+"']").parent().click();
	},'json');
}
//保存作品类别
$(document).delegate("#<?php echo $id?> > div.save","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var workId = $("#<?php echo $id?> > input.workId").val();
		var subTypeId = $("#<?php echo $id?> > input.subTypeId").val();
		$(this).html("保存中...").addClass("disabled");
		$.post("<?php echo Yii::app()->baseUrl?>/index.php/work/changeWorkType?workId="+workId+"&subTypeId="+subTypeId,"",function(result){
			//alert(result);
			if(result == "no")
			{
				alert("对不起，本赛区没有此作品类别！");
			}
			else if(result == "error")
			{
				alert("修改失败！");
			}
			else
			{
				alert("修改成功!");
			}
			$("#<?php echo $id?> > div.save").html("保存作品类别").removeClass("disabled");
			//触发事件
			<?php foreach($triggerSelectors as $one){ ?>
				$("<?php echo $one?>").change();
			<?php } ?>
		});
	}
});
</script>