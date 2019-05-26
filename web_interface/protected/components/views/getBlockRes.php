<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/

?>
<style type='text/css'>
	#<?php echo $id;?> > div.title{
		padding:5px;
		text-align:center;
		background-color:rgb(245,245,245);
		font-weight:bold;
		margin-bottom:10px;
	}
	#<?php echo $id?> > div.workList{
		padding:5px;
	}
	#<?php echo $id?> > div.workList > div.block{
		background-color:rgb(250,250,250);
		cursor:pointer;
		padding:10px;
		border:1px solid silver;
		border-width:0 1px 1px 0;
	}
	
	#<?php echo $id?> > div.workList > div.block:hover{
		background-color:rgb(245,245,245);
	}
	#<?php echo $id?> > div.workList > div.block > div.line{
		padding:3px 0;
		text-align:left;
		background-color:transparent;
	}
	#<?php echo $id?> > div.workList > div.block > div.line.subTitle{
		color:gray;
	}
</style>
<div id="<?php echo $id;?>">
	<input class="blockId" type="hidden" value="<?php echo $blockId;?>"></input>
	<input class="zoneId" type="hidden" value="<?php echo $zoneId;?>"></input>
	<input class="subTypeId" type="hidden" value="<?php echo $subTypeId;?>"></input>
	<?php if($hasHead){ ?>
	<input class="zoneName" type="hidden"></input>
	<input class="typeName" type="hidden"></input>
	<input class="subTypeName" type="hidden"></input>
	<div class="title">
		<?php echo $headTitle; ?>
		<div class="btn btn-small btn-primary refresh">刷新</div><br/>
		<a class="btn btn-small btn-success download" target="_blank" href="">下载<span class="zoneName"></span> <span class="typeName"></span>-<span class="subTypeName"></span> 提交结果</a>
	</div>
	<?php } ?>
	<div class="workList">
	</div>
</div>
<script type="text/javascript">
<?php if($instantLoad){ ?>
$(document).ready(function(){
	<?php echo $id;?>getResList();
})
<?php } ?>
<?php if($hasHead){ ?>
$(document).delegate("#<?php echo $id;?> > div.title > div.refresh","click",function(){
	<?php echo $id;?>getResList();
});
<?php } ?>
	$(document).delegate("#<?php echo $id;?> > input.blockId","change",function(){
		<?php echo $id;?>getResList();
	});
	$(document).delegate("#<?php echo $id;?> > input.zoneId","change",function(){
		<?php echo $id;?>getResList();
	});
	$(document).delegate("#<?php echo $id;?> > input.subTypeId","change",function(){
		<?php echo $id;?>getResList();
	});
	function <?php echo $id;?>getResList()
	{	
		var data = {};
		data.zoneId = $("#<?php echo $id?> > input.zoneId").val();
		data.subTypeId = $("#<?php echo $id?> > input.subTypeId").val();
		<?php if($hasHead){ ?>
		//设置下载显示信息
			var zoneName = $("#<?php echo $id?> > input.zoneName").val();
			var typeName = $("#<?php echo $id?> > input.typeName").val();
			var subTypeName = $("#<?php echo $id?> > input.subTypeName").val();
			$("#<?php echo $id?> > div.title > a.download > span").html("");
			$("#<?php echo $id?> > div.title > a.download").children("span.zoneName").html(zoneName);
			if(subTypeName != "全部")
			{
				$("#<?php echo $id?> > div.title > a.download").children("span.typeName").html(typeName).end()
				.children("span.subTypeName").html(subTypeName);
			}	
			
			//设置下载链接
			$("#<?php echo $id?> > div.title > a.download").prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/result/downloadRes?blockId=<?php echo $blockId;?>&zoneId="+$("#<?php echo $id?> > input.zoneId").val()+"&subTypeId="+$("#<?php echo $id?> > input.subTypeId").val());
			
		<?php } ?>
		if((data.zoneId == "") || (data.subTypeId == ""))
		{
			return;
		}
		$("#<?php echo $id?> > div.workList").html("<div class='wrapLoading'><div class='loading'></div></div>");
		//alert("getting");
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/result/getRes?blockId=<?php echo $blockId;?>",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > div.workList").html("");
			$.each(result,function(index,item){
				var $temp = <?php echo $id;?>makeBlock(item);
				//分resultNum,按照rank排序插入
				$("#<?php echo $id;?> > div.workList").append($temp);
			});
		},'json');
	}
	function <?php echo $id;?>makeBlock(item)
	{
		return $('<div class="block">'+
		'<input class="resultNum" type="hidden" value="'+item.resultNum+'"></input>'+
		'<input class="rank" type="hidden" value="'+item.rank+'"></input>'+
		'<input class="checkId" type="hidden" value="'+item.checkId+'"></input>'+
		'<input class="workTitle" type="hidden" value="'+item.workTitle+'"></input>'+
		'<input class="workSubTypeId" type="hidden" value="'+item.subTypeId+'"></input>'+
		'<input class="workSubTypeName" type="hidden" value="'+item.typeName+'"></input>'+
		'<input class="workFirstTypeName" type="hidden" value="'+item.firstTypeName+'"></input>'+
		'<div class="line title">'+item.workTitle+'</div>'+
		'<div class="line subTitle">'+item.firstTypeName+' - '+item.typeName+
			' 提交至: '+item.resultNum + '('+item.strategyTitle+')'+' 排序:'+item.rank+
		'</div>'+
	'</div>');
	}
</script>
