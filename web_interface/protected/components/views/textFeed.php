<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>}
	#<?php echo $id;?> div.feedCata{padding:0px 0 15px 0;}
	#<?php echo $id;?> div.feedCata > a{font-size:14px;color:silver;font-weight:bold;}
	#<?php echo $id;?> div.feedCata > a:hover{text-decoration:none;color:black}
	#<?php echo $id;?>	ul.feedLine{width:660px;margin:0px 0 20px 0;}
	#<?php echo $id;?>	li.feedBlock{float:left;margin:0px 5px;
		background:url('<?php echo Yii::app()->theme->baseUrl;?>/assets/images/feed_bg2.png') bottom left;
		/*height:auto!important;
		height:400px;高度在jquery中设置！！
		min-height:400px;*/width:313px;padding:0 4px 10px 3px;
	}
	#<?php echo $id;?> #moreFeed{background-color:<?php echo COLOR1_LIGHTER1;?>;cursor:pointer;width:<?php echo $width;?>;line-height:30px;text-align:center;color:white}
	#<?php echo $id;?> #moreFeedWait{width:<?php echo $width;?>;}
	#<?php echo $id;?>	li.feedBlock > div.wrapLoading{height:20px}
	#<?php echo $id;?>	li.feedBlock > div.feedContent{border-top:solid <?php echo COLOR1;?> 3px;padding:10px;overflow:hidden;word-wrap: break-word;}
	#<?php echo $id;?>	li.feedBlock > div.feedContent > p{margin:0;padding:0;line-height:20px}/*match ckeditorReset.css!!*/
</style>
<script type='text/javascript'>
	$(document).ready(function(){
		//初始载入载入的catalogId
		//alert($("#<?php echo $id;?> > div.textFeedDiv li.feedBlock").eq(-1).attr('id'));
		getTextFeed(<?php echo $catalogId;?>,0,<?php echo $feedNum;?>);
	});
	$(document).delegate("#<?php echo $id;?> > #<?php echo $catalogIdContainer;?>","change",function(){
		//外部改变其catalogId 的函数
		//alert($("#<?php echo $id;?> > div.textFeedDiv li.feedBlock").eq(-1).attr('id'));
			//重新获取
		//	alert($("#<?php echo $id;?> #<?php echo $catalogIdContainer;?>").val());
		getTextFeed(<?php echo $catalogId;?>,0,<?php echo $feedNum;?>,$("#<?php echo $id;?> #<?php echo $catalogIdContainer;?>").val());

		
	});
	//定义显示'查看更多'
	$(document).delegate("#<?php echo $id;?> > div.textFeedDiv > ul.feedLine > li.feedBlock",'mouseenter',function(){
		$(this).children('div.wrapLoading').children('a').css('display','inline');
	});
	$(document).delegate("#<?php echo $id;?> > div.textFeedDiv > ul.feedLine > li.feedBlock",'mouseleave',function(){
		$(this).children('div.wrapLoading').children('a').css('display','none');
	});
//定义'更多'动作
	$(document).delegate("#<?php echo $id;?> > #moreFeed",'click',function(){
		//alert('hi');
		if($("#<?php echo $id;?> > div.textFeedDiv li.feedBlock").length == 0)
		{
			getTextFeed(<?php echo $catalogId;?>,0,<?php echo $feedNum;?>,$("#<?php echo $id;?> #<?php echo $catalogIdContainer;?>").val());
		}
		else
		{
			getTextFeed(<?php echo $catalogId;?>,$("#<?php echo $id;?> > div.textFeedDiv li.feedBlock").eq(-1).attr('id'),<?php echo $feedNum;?>,$("#<?php echo $id;?> #<?php echo $catalogIdContainer;?>").val());
		}
	});
function getTextFeed(catalogId,startFeedId,feedNum)
{
	var data = {};
	if((data.catalogId == '') || (data.startFeedId == '') || (data.feedNum == ''))
	{
		alert('Oops');
		return;
	}
	data.textCataId = arguments[3]?arguments[3]:0;<?php /*在结果集中再取属于该栏目id的文章*/ ?>
	data.catalogId = catalogId;
	data.startFeedId = startFeedId;
	if(startFeedId == 0)
	{
		$("#<?php echo $id;?> > div.textFeedDiv").html('');
		$("#<?php echo $id;?> #moreFeedWait").show();
	}
	//alert(startFeedId);
	data.feedNum = feedNum;
	//把查看更多框变成载入中
	var feedWait = $("<div id='moreFeedWait' class='wrapLoading'><div class='loading'></div></div>");
	$("#<?php echo $id;?> #moreFeed").replaceWith(feedWait);
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/siteWidget/textFeed",data,function(result){
		//alert(result);
		//$("#<?php echo $id;?> #moreFeedWait").replaceWith('<div id="moreFeed">更多</div>');
		//return;
		for(var i=0;i<result.length;i = i+2)//一次添加两个
		{
			var tempUl = $("<ul class='feedLine'></ul>");
				var templi1 = $("<li class='feedBlock' id='"+result[i].feedId+"' title='"+result[i].feedTitle+"'></li>");
					var tempContent1 = $("<div class='feedContent'><div class='feedCata'><a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/view?id="+result[i].catalogId+"'>"+
					result[i].catalogTitle+" -></a></div>"+
					result[i].feedContent+"</div>");
					var tempReadMore = $('<div class="wrapLoading"><a style="display:none" href="'+
					'<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id='+result[i].textId+"&checkId="+result[i].checkId
					+'" class="readMore">查看更多</a></div>');
					templi1.append(tempContent1);
					templi1.append(tempReadMore);
					tempUl.append(templi1);
				if(result.length != i+1)//判断本段中是否还有数据，因为i是以k递增，可能跳过了result.length
				{
					var templi2 = $("<li class='feedBlock' id='"+result[i+1].feedId+"' title='"+result[i+1].feedTitle+"'></li>");
					var tempContent2 = $("<div class='feedContent'><div class='feedCata'><a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/view?id="+result[i+1].catalogId+"'>"+
					result[i+1].catalogTitle+" -></a></div>"+
					result[i+1].feedContent+"</div>");
					var tempReadMore = $('<div class="wrapLoading"><a style="display:none" href="'+
					'<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id='+result[i+1].textId+"&checkId="+result[i+1].checkId
					+'" class="readMore">查看更多</a></div>');
					templi2.append(tempContent2);
					templi2.append(tempReadMore);
					tempUl.append(templi2);
				}
			var tempClear = $("<div style='clear:both'></div>");
			tempUl.append(tempClear);
			//tempUl = matchHeight(tempUl);
			
			tempUl.appendTo("#<?php echo $id;?> > div.textFeedDiv");
			if(tempUl.children("li.feedBlock").eq(1) != undefined)//当第二个元素存在
			{//!!!!!!问题！！height在推送中的图片载入前不能确定 
				var h = tempUl.children("li.feedBlock").eq(0).height() > tempUl.children("li.feedBlock").eq(1).height() ? tempUl.children("li.feedBlock").eq(0).height():tempUl.children("li.feedBlock").eq(1).height();
				if(h < 300)
				{
					h = 300;
				}
				tempUl.children("li.feedBlock").eq(0).height(h);
				tempUl.children("li.feedBlock").eq(1).height(h);
			}			
		}
				//显示查看更多
				//当返回d的结果集与要求d的一样多才显示“查看更多”
		if((result.length != 0) && (result.length == feedNum))
		{
			$("#<?php echo $id;?> #moreFeedWait").replaceWith('<div id="moreFeed">更多</div>');
		}
		else
		{
			$("#<?php echo $id;?> #moreFeedWait").hide();
		}
	},'json');
}

</script>
<div id='<?php echo $id;?>'>
	<input type='hidden' id='<?php echo $catalogIdContainer;?>' value=''></input>
	<div class='textFeedDiv'>
		
	</div>
	<div id="moreFeed">更多</div>
</div>