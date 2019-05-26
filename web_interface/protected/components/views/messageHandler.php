<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{padding:30px 10px}
	#<?php echo $id;?> > div.tabbable > div.tab-content{}
	#<?php echo $id;?> > div.tabbable > div.tab-content > div.tab-pane > div.mesBlock{padding:10px 5px;border:solid #F5D8DB;border-width:0 1px 1px 0;background-color:rgb(250,250,250)}
	#<?php echo $id;?> > div.tabbable > div.tab-content > div.tab-pane > div.mesBlock > div.mesLine{padding:5px}
	#<?php echo $id;?> > div.tabbable > div.tab-content > div.tab-pane > div.unRead{border-left:3px solid red}
</style>
<script tyle='text/javascript'>
	//控件载入就载入评论的提醒
	$(document).ready(function(){
		getComMes(<?php echo Yii::app()->session['userId'];?>);
	});
	//点击载入文章审核的提醒
	$(document).delegate("#<?php echo $id;?> > div.tabbable > ul > li > a.ctB",'click',function(){
		getCTMes(<?php echo Yii::app()->session['userId'];?>);
	});
function getComMes(userId)
{
	var data= {};
	data.userId = userId;
	$.post('<?php echo Yii::app()->baseUrl;?>/index.php/message/getCom',data,function(result){
		//alert(result);
		if(result.length == 0)
		{
			$("#<?php echo $id;?> > div > div.tab-content > #comDiv").html("<div class='wrapLoading'>暂时没有提醒.</div>");
		}
		else
		{
			$("#<?php echo $id;?> > div > div.tab-content > #comDiv").html("");
			$.each(result,function(index,item){
				if(item.isOwnText == 1)
				{
				var tempBlock = $("<div class='mesBlock'>"+
					"<div class='mesLine'>"+
						"<a href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+item.commerId+"'>"+item.commerName+"</a>"+
						"回复了你的文章&nbsp;"+"<a href='#' class='readMes' id='"+item.textId+"'>"+item.textTitle+" :"+
						'"'+item.comContent+'"</a>'+
						"<input type='hidden' id='mId' value='"+item.mId+"'></input>"+
					"</div>"+
					"<div class='mesLine'>"+	
						"<span style='font-size:12px;color:gray'>"+item.comTime+"</span>"+
					"</div>"+
				"</div>");
				
				}
				else
				{
				var tempBlock = $("<div class='mesBlock'>"+
					"<div class='mesLine'>"+
						"<a href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+item.commerId+"'>"+item.commerName+"</a>"+
						"在文章&nbsp;"+"<a href='#' class='readMes' id='"+item.textId+"'>"+item.textTitle+" 下回复了你:"+
						'"'+item.comContent+'"</a>'+
						"<input type='hidden' id='mId' value='"+item.mId+"'></input>"+
					"</div>"+
					"<div class='mesLine'>"+	
						"<span style='font-size:12px;color:gray'>"+item.comTime+"</span>"+
					"</div>"+
				"</div>");
				}
				if(item.isRead == 0)
				{
					tempBlock.addClass('unRead');
				}
				tempBlock.appendTo("#<?php echo $id;?> > div > div.tab-content > #comDiv");
			});
			
			
		}
	},'json');
}
 $(document).delegate("#<?php echo $id;?> > div.tabbable > div.tab-content > #comDiv > div.mesBlock > div.mesLine > a.readMes","click",function(e){
 	e.preventDefault();
 	<?php /*先去修改isRead信息 */ ?>
 	var data = {};
 	data.mId = $(this).parent().children("#mId").val();
 	data.textId = $(this).attr('id');
 	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/message/readMes",data,function(result){
 		//alert(result);
 		if(result.textId == null)
 		{
 			alert('Oops');
 			return;
 		}
 		window.open('<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/text?id='+result.textId,'_self');
 	},'json');
 });
function getCTMes(userId)
{
	var data= {};
	data.userId = userId;
	$.post('<?php echo Yii::app()->baseUrl;?>/index.php/message/getCT',data,function(result){
		//alert(result);
		if(result.length == 0)
		{
			$("#<?php echo $id;?> > div > div.tab-content > #ctDiv").html("<div class='wrapLoading'>暂时没有提醒.</div>");
		}
		else
		{
			$("#<?php echo $id;?> > div > div.tab-content > #ctDiv").html("");
			$.each(result,function(index,item){
				if(item.checkStatus == 2)
				{
					var tempBlock = $("<div class='mesBlock'>"+
					"<div class='mesLine'>"+
						"你的文章 "+item.textTitle+" (提交至"+item.catalogTitle+") 已经通过审核"+
					"</div>"+
					"<div class='mesLine'>"+	
						"<span style='font-size:12px;color:gray'>"+item.checkTime+"</span>"+
					"</div>"+
				"</div>");
				}
				else
				{
					var tempBlock = $("<div class='mesBlock'>"+
					"<div class='mesLine'>"+
						"你的文章 "+item.textTitle+" (提交至"+item.catalogTitle+") 未通过审核"+
					"</div>"+
					"<div class='mesLine'>"+	
						"<span style='font-size:12px;color:gray'>"+item.checkTime+"</span>"+
					"</div>"+
				"</div>");
				}
				if(item.isRead == 0)
				{
					tempBlock.addClass('unRead');
				}
				tempBlock.appendTo("#<?php echo $id;?> > div > div.tab-content > #ctDiv");
			});
		}
	},'json');
}
</script>
<div id='<?php echo $id;?>'>
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<li class="active"><a class='comB' href="#comDiv" data-toggle="tab">评论</a></li>
			<li><a class='ctB' href="#ctDiv" data-toggle="tab">文章审核</a></li>
    	</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="comDiv">
    			<div class='wrapLoading'><div class='loading'></div></div>
    		</div>
    		<div class="tab-pane" id="ctDiv">
    			<div class='wrapLoading'><div class='loading'></div></div>
    		</div>
		</div>
	</div>
</div>