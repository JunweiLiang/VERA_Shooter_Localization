<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
#<?php echo $id;?>{
	width:<?php echo $width;?>;
}
#<?php echo $id;?> form{margin:0;}
#<?php echo $id;?> > div.main > div.workList > div.workBlock{
	cursor:pointer;
	padding:5px 10px;
	border:1px solid silver;
	border-width:0 1px 1px 0;
	color:white
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock > div.type{
	display:none;
	font-size:12px;
	color:silver;
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock.submitted{
	background-color:<?php echo COLOR1_LIGHTER1;?>;
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock.notSubmitted{
	background-color:rgb(230,0,0);
}
#<?php echo $id;?> > div.main > div.workList > div.toggle > div.type{
	display:block;
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock.submitted.toggle{
	background-color:rgb(45,141,97);
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock.notSubmitted.toggle{
	background-color:rgb(140,0,0);
}
#<?php echo $id;?> > div.main > div.workList > div.workBlock:hover{
	
}
</style>
<script type="text/javascript">
<?php if($instantLoad){ ?>
$(document).ready(function(){
	getWorkList();
});
<?php } ?>
//绑定交互事件
$(document).delegate("#<?php echo $id;?> > #filter > input.competitorId","change",function(){
	getWorkList();
});
//点击作品事件
$(document).delegate("#<?php echo $id;?> > div.main > div.workList > div.workBlock","click",function(){
	<?php if($toggle){ ?>
	//清空所有
	$("#<?php echo $id;?> > div.main > div.workList > div.workBlock").removeClass("toggle");
	$(this).addClass("toggle");
	<?php } ?>
	<?php if($targetSelector != ""){?>
		$("<?php echo $targetSelector;?>").val($(this).prop("id"));
		$("<?php echo $targetSelector;?>").change();
	<?php } ?>
});
function getWorkList()
{
	var data = $("#<?php echo $id;?> > #filter").serialize();//获取所有input hidden的参数
	//alert(data);
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/getWorkList",data,function(result){
		//alert(result);
		if(result.error != null)
		{
			alert("Oops!");	
			return;
		}
		$("#<?php echo $id;?> > div.main > div.workList").html("");
		$.each(result,function(index,item){
			var htmlObject = $(makeBlockHtml(item));
			$("#<?php echo $id;?> > div.main > div.workList").append(htmlObject);
		});
		//计算未提交总数
		submitNum = 0;
		$.each(result,function(index,item){
			(item.shuomingLock == 1)&&(item.baomingLock == 1)?0:submitNum++;
		});
		$("<?php echo $sumSelector?>").html(submitNum);
		//默认点击第一个作品
		if($("#<?php echo $id;?> > div.main > div.workList > div.workBlock").length != 0)
		{
			$("#<?php echo $id;?> > div.main > div.workList > div.workBlock").eq(0).click();
		}
	},'json');
}
<?php if($showContent == 0){ ?>
function makeBlockHtml(item)
{
	//暂时仅仅使用workId与类别信息显示
	var workId = <?php echo IDADDUP ;?>+parseInt(item.workId);
	//var str1 = (item.shuomingLock == 1)&&(item.baomingLock == 1)?"submitted":"notSubmitted";
	//var str2 = (item.shuomingLock == 1)&&(item.baomingLock == 1)?"(已提交)":"(未提交)";
	//改为只要提交了报名表就提交
	var str1 = item.baomingLock == 1?"submitted":"notSubmitted";
	var str2 = item.baomingLock == 1?"(已提交)":"(未提交)";
	return "<div class='workBlock "+str1+"' id='"+item.workId+"' title='"+item.typeName+"-"+item.subTypeName+"'>"+
		"<div class='line'>"+workId+" "+str2+"</div>"+
		"<div class='line type'>"+item.typeName+"</div>"+
		"<div class='line type'>"+item.subTypeName+"</div>"+
	"</div>";
}
<?php }else{ ?>
//显示内容的makeBlock方法
function makeBlockHtml(item)
{
}
<?php } ?>
</script>
<div id="<?php echo $id;?>">
	<form id="filter">
		<input type="hidden" name="competitorId" class="competitorId" value="<?php echo $competitorId;?>"></input>
		<input type="hidden" name="showContent" class="showContent" value="<?php echo $showContent;?>"></input>
		<input type="hidden" name="order" class="order" value="desc"></input>
		<input type="hidden" name="orderCol" class="orderCol" value="workId"></input>
	</form>
	<div class="main">
		<div class="workList">
		</div><!--div.workList-->
	</div><!--div.main-->
</div>