<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{padding-left:20px;}
	#<?php echo $id;?> > div.cataTitle{padding:0 5px}
	#<?php echo $id;?> > div.cataTitle > a > div.titleText{color:<?php echo COLOR1;?>;font-size:16px;border-bottom:1px solid silver;padding:10px 10px 2px 10px}
	#<?php echo $id;?> a{text-decoration:none}
	#<?php echo $id;?> > div.textListDiv{padding:0px;}
	<?php if($isSimple){ ?>
		#<?php echo $id;?> > div.textListDiv{padding:0px}
	<?php } ?>
	#<?php echo $id;?> > div.textListDiv > div.sBlock{padding:7px;}
	<?php if($showYinYang){ ?>
		#<?php echo $id;?> > div.textListDiv > div.even{background-color:rgb(245,245,245)}
		#<?php echo $id;?> > div.textListDiv > div.odd{background-color:white}
	<?php } ?>
	#<?php echo $id;?> > div.textListDiv > div.sBlock > a.sText{text-decoration:none;color:black}
	#<?php echo $id;?> > div.textListDiv > div.sBlock > a.sText:hover{color:<?php echo COLOR1;?>)}
	#<?php echo $id;?> > div.textListDiv > div.sBlock > div.date{float:right;}
	#<?php echo $id;?> > div.textListDiv > div.viewMore{background-color:<?php echo COLOR1;?>;color:white;cursor:pointer}
	#<?php echo $id;?> > div.textListDiv > div.listBlock{border-top:1px silver solid;margin:0px 0 20px 0}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockLeft{
		float:left;
		width:200px;
	}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockLeft > div.blockImgDiv{position:relative;height:150px;overflow:hidden;}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockLeft > div.blockImgDiv > div.imgReplace{position:absolute;top:0px;left:0px;background-color:<?php echo COLORDARK;?>;padding:35px 30px;font-size:20px;width:140px;color:gray;line-height:30px;font-weight:bold}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockLeft > div.blockImgDiv > a > img.textTitleImg{height:150px;width:200px}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight{
		margin:0 0 0 200px;padding:20px;
		height:auto!important;  
		height:150px;  
		min-height:150px; 
	}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line{line-height:25px}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line > a.textTitle{font-size:18px;color:<?php echo COLOR1;?>;font-weight:bold}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line > a.textTitle:hover{color:rgb(23,116,55)}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line > a.textEditTime{font-size:12px;color:gray}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line > a.textActInfo{font-size:12px;color:#0088cc}
	#<?php echo $id;?> > div.textListDiv > div.listBlock > div.blockRight > div.line > a.textIntro{font-size:14px;color:black}
</style>
<script type='text/javascript'>
	//页面载入就取数据
	$(document).ready(function(){
		<?php echo $id;?>getSiteTextList(<?php echo $catalogId;?>,0,<?php echo $textPerList;?>);
	});
	//定义查看更多按钮动作，
	$(document).delegate("#<?php echo $id?> > div.textListDiv > div.viewMore",'click',function(){
		var textNum = $(this).children("div.wrapLoading").attr("id");
		if(textNum == null || textNum == '')
		{
			alert('shit!');
			return;
		}
		<?php echo $id;?>getSiteTextList(<?php echo $catalogId;?>,textNum,<?php echo $textPerList;?>);
	});
function <?php echo $id;?>getSiteTextList(catalogId,startId,getNum)
{
	<?php
		//startId 是结果集中的起始序号，不是实际id
	?>
	//alert('hi');
	var data = {};
	data.catalogId = catalogId;
	data.startId = startId;
	data.getNum = getNum;
	//变查看更多为'loading'
	$('#<?php echo $id;?> > div.textListDiv > div.viewMore').replaceWith("<div class='wrapLoading'><div class='loading'></div></div>");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/siteWidget/textList",data,function(result){
		//alert(result);
		$('#<?php echo $id;?> > div.textListDiv > div.wrapLoading').remove();
		$.each(result,function(index,item){
			<?php if(!$isSimple){ ?>
			var titlePic = (item.titlePicAddr == '' || item.titlePicAddr == null)?<?php echo $nullTitlePicReplace;?>:"<a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"'><img class='textTitleImg' src='"+item.titlePicAddr+"'></img></a>";
			if(item.actTime == null)//没有活动信息
			{
			var tempBlock = $("<div class='listBlock'>"+
			'<div class="blockLeft">'+
				"<div class='blockImgDiv'>"+
					titlePic+
				"</div>"+
			"</div>"+
			"<div class='blockRight'>"+
				"<div class='line'><a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"&checkId="+item.checkId+"' class='textTitle'>"+item.textTitle+"</a></div>"+
				"<div class='line'><a class='textEditTime'>"+item.textEditTime+"</a></div>"+
				"<div class='line'><a class='textIntro'>"+item.textIntro+"</a></div>"+
			"</div>"+
			
		"</div>");
		}
		else
		{
			var lecturer = (item.actLecturer == '' || item.actLecturer == null)?"":"主讲: "+item.actLecturer;
			var tempBlock = $("<div class='listBlock'>"+
			'<div class="blockLeft">'+
				"<div class='blockImgDiv'>"+
					titlePic+
				"</div>"+
			"</div>"+
			"<div class='blockRight'>"+
				"<div class='line'><a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"&checkId="+item.checkId+"' class='textTitle'>"+item.textTitle+"</a></div>"+
				"<div class='line'><a class='textEditTime'>"+item.textEditTime+"</a></div>"+
				"<div class='line'><a class='textActInfo'>"+item.actTime+" "+item.actLoc+" "+lecturer+"</a></div>"+
				"<div class='line'><a class='textIntro'>"+item.textIntro+"</a></div>"+
			"</div>"+
		"</div>");
		}
		
			tempBlock.appendTo("#<?php echo $id;?> > div.textListDiv");
			<?php }else{ 
				//简板
			?>
				if(index % 2 == 0)
				{
					var tempBlock = $("<div class='sBlock even'>"+
						"<a class='sText' href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"&checkId="+item.checkId+"'>"+item.textTitle+"</a>"+
						<?php if($showDate){ ?>
							"<div class='date'>"+item.textEditTime+"</div>"+
						<?php } ?>
					"</div>");
				}
				else
				{
					var tempBlock = $("<div class='sBlock odd'>"+
						"<a class='sText' href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"&checkId="+item.checkId+"'>"+item.textTitle+"</a>"+
						<?php if($showDate){ ?>
							"<div class='date'>"+item.textEditTime+"</div>"+
						<?php } ?>
					"</div>");				
				}
			tempBlock.appendTo("#<?php echo $id;?> > div.textListDiv");
			<?php } ?>
		});
		<?php if(!$noMore){ ?>
		if(result.length != 0)
		{
		//把loading变成查看更多
			//计算当前页面的text总数
			var textNum = $("#<?php echo $id;?> > div.textListDiv > div.listBlock").length;
			<?php if($isSimple){ ?>
			var textNum = $("#<?php echo $id;?> > div.textListDiv > div.sBlock").length;
			<?php } ?>
			//当获取的结果集数量少于要求的数量时，说明没有数据了，就不用查看更多
			if(result.length >= getNum)
			{
				$("#<?php echo $id;?> > div.textListDiv").append("<div class='viewMore'><div class='wrapLoading' id='"+textNum+"'>查看更多</div></div>");
			}
		}
		<?php } ?>
	},'json');
}
</script>
<div id="<?php echo $id;?>">
	<?php if($hasCataTitle){ ?>
		<div class='cataTitle'><a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/view?id=<?php echo $catalogId;?>'><div class='titleText'><?php echo $cataTitle;?></div></a></div>
	<?php } ?>
	<input type='hidden'></input>
	<div class='textListDiv'><div class='viewMore'><div class='wrapLoading'>查看更多</div></div>
		<!--<div class='wrapLoading'><div class='loading'></div></div>-->
		
	</div>
</div>