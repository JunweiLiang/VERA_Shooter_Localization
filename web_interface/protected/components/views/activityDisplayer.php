<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php
	//活动展示模块，接收width,blockWidth,height,headingWidth;containerId,actTitleArray,actTimeArray,actLocArray
	//(height = height-padding-borderTop=height-20)
	//构造活动block流
	/*<div class="actBlock" style="left:0">
        	<div class="actTitle">中国与全球经济讲座</div>
            <div class="actTime">2013年8月1日 下午4:00</div>
            <div class="actLoc">明德商学楼0402</div>
        </div>*/
//先检查array的数值是否相同:
if(empty($actArray))
{
	throw new Exception('wrong param.');	
}
	$actContent = '';
	for($i = 0;$i<count($actArray);++$i)	
	{
		if($actArray[$i]['lecturer'] != '')
		{
			$temp = '<div class="actBlock" style="left:'.($i*$blockWidth).'px"><a href="'.$actArray[$i]['link'].'"><div class="actTitle">'.
				$actArray[$i]['title'].'</div></a><div class="actTime">'.$actArray[$i]['time'].'</div><div class="actLoc">'.
				$actArray[$i]['loc'].'</div><div class="actLecturer">主讲: '.$actArray[$i]['lecturer'].'</div></div>';
		}
		else
		{
			$temp = '<div class="actBlock" style="left:'.($i*$blockWidth).'px"><a href="'.$actArray[$i]['link'].'"><div class="actTitle">'.
				$actArray[$i]['title'].'</div></a><div class="actTime">'.$actArray[$i]['time'].'</div><div class="actLoc">'.
				$actArray[$i]['loc'].'</div></div>';
		}
		$actContent .= $temp;
	}
?>
<style type="text/css">
	#<?php echo $containerId;?>{
	background-color:white;width:<?php echo $width;?>;height:<?php echo ($height)."px";?>;position:relative/*!important for ie*/;
		margin-bottom:<?php echo $marginBottom;?>;
	}
	#<?php echo $containerId;?> a:hover{text-decoration:none}
	#actDisplayerHeading{float:left;width:<?php echo ($headingWidth-20).'px';?>;padding:12px 0 8px 20px;background-color:rgb(220,22,9);height:<?php echo ($height-20)."px";?>;}
	#actDisplaySeg{height:<?php echo $height;?>;width:<?php echo (int)($width-$headingWidth)."px";?>;margin:0 0 0 120px;position:relative;overflow:hidden}
	#actDisplaySeg a.pre,#actDisplaySeg a.next{display:none;z-index:15;position:absolute;top:<?php echo ($height/2-20)."px";?>;width:43px;height:43px;background-image:url("<?php //echo Yii::app()->baseUrl/protected/components/assets/activityDisplayerWidget/prev_next.png;//此地址forbidden
	echo Yii::app()->baseUrl;?>/assets/activityDisplayerWidget/prev_next.png");}
	#actDisplaySeg a.pre{left:10px;background-position:0 0}
	#actDisplaySeg a.next{right:10px;background-position:-44px 0}
	#actDisplaySeg div.actBlock{position:absolute;top:0;z-index:10;float:left;padding:10px;height:<?php echo ($height-2-20)."px";?>;width:<?php echo ($blockWidth-1-20)."px";?>;border:solid silver;border-width:1px 1px 1px 0;}
	#actDisplaySeg div.actBlock div.actTitle{font-weight:bold;text-align:left;font-size:16px;color:rgb(140,0,0)}
	#actDisplaySeg div.actBlock div.actTime{text-align:left;font-size:12px;color:gray}
	#actDisplaySeg div.actBlock div.actLoc{text-align:left;font-size:12px;color:gray}
	#actDisplaySeg div.actBlock div.actLecturer{text-align:left;font-size:12px;color:gray}
</style>
<script type="text/javascript">
	//首先绑定左右箭头的动画
	$(document).delegate("#actDisplaySeg a.pre","mouseenter",function(){
		$(this).css('backgroundPosition','0 -44px');
	});
	$(document).delegate("#actDisplaySeg a.next","mouseenter",function(){
		$(this).css('backgroundPosition','-44px -44px');
	});
	$(document).delegate("#actDisplaySeg a.pre","mouseleave",function(){
		$(this).css('backgroundPosition','0 0px');
	});
	$(document).delegate("#actDisplaySeg a.next","mouseleave",function(){
		$(this).css('backgroundPosition','-44px 0px');
	});
	//***********
	//绑定鼠标进入actDisplaySeg动画，首先判断所有actBlock总长度是否比actDisplaySeg宽度大,再判断第一个元素是否Left<0，则显示左箭头；block流左部长度加上显示区（actDisplaySeg）小于block总长度，则显示右箭头
	$(document).delegate("#actDisplaySeg","mouseenter",function(){
		var blockStreamWidth = <?php echo $blockWidth*count($actArray);?>;//注意没有px,blockStream总长度
		var blockWidth = <?php echo (int)$blockWidth;?>;
		//alert(blockWidth);
		//alert(blockStreamWidth);
		//return;
		var streamLeft = $(this).find("div.actBlock").eq(0).position().left < 0? -($(this).find("div.actBlock").eq(0).position().left):0;//活动流超出显示区左部的长度
		var streamRight = $(this).find("div.actBlock").eq(-1).position().left+blockWidth > $(this).outerWidth()?($(this).find("div.actBlock").eq(-1).position().left+blockWidth-$(this).outerWidth()):0;
		//alert(streamLeft);
		//alert(streamRight);
		if(streamRight > 0)//显示右箭头
		{
			$(this).find("a.next").css('display','block');
		}
		if(streamLeft > 0)//显示左箭头
		{
			$(this).find("a.pre").css('display','block');
		}
	});
	
	$(document).delegate("#actDisplaySeg","mouseleave",function(){
		$(this).find("a.pre,a.next").css('display','none');
	});
	//下面绑定左右箭头动作
	var finishNum;//当前完成动作的block数
	$(document).delegate("#actDisplaySeg a.pre,#actDisplaySeg a.next","click",function(){
		finishNum =0;//当前完成动作的block数,重置为0
		if($("#actDisplaySeg").prop("moving"))
		{
			return true;//正在运动中，什么也不做	
		}
		$("#actDisplaySeg").prop("moving",true);
		var blockWidth = <?php echo (int)$blockWidth;?>;
		var streamLeft = $("#actDisplaySeg div.actBlock").eq(0).position().left < 0? -($("#actDisplaySeg div.actBlock").eq(0).position().left):0;//活动流超出显示区左部的长度
		var streamRight = $("#actDisplaySeg div.actBlock").eq(-1).position().left+blockWidth > $("#actDisplaySeg").outerWidth()?($("#actDisplaySeg div.actBlock").eq(-1).position().left+blockWidth-$("#actDisplaySeg").outerWidth()):0;
		var blockNum = <?php echo count($actArray);?>;

		//当为点击右箭头
		if($(this).hasClass("next"))
		{

			if(streamRight <= 0)
			{
				$("#actDisplaySeg").prop("moving",false);
				return true;	
			}

			if(streamRight <= blockWidth)//剩余流的右边不足一个block
			{
				$("#actDisplaySeg div.actBlock").each(function(){
					var toLeft = $(this).position().left-streamRight;
					toLeft+='px';
					if($(this).index() == blockNum-1)//遍历到最后一个元素
					{
						//取消右箭头
						$("#actDisplaySeg a.next").css('display','none');
					}
					$(this).animate({'left':toLeft},500,function(){
						finishNum++;
						if(finishNum == blockNum)//全部block的动作完成
						{
							$("#actDisplaySeg").prop("moving",false);
						}
					});	
					
				});
			}
			else
			{
				$("#actDisplaySeg div.actBlock").each(function(){
					var toLeft = $(this).position().left-blockWidth;
					toLeft+='px';
					$(this).animate({'left':toLeft},500,function(){
						finishNum++;
						if(finishNum == blockNum)//全部block的动作完成
						{
							$("#actDisplaySeg").prop("moving",false);
						}
					});		
				});
			}	
			//显示左箭头
			$("#actDisplaySeg a.pre").css('display','block');
		}
		if($(this).hasClass("pre"))
		{
			//alert(streamLeft);
			if(streamLeft <= 0)
			{
				return true;	
			}

			if(streamLeft <= blockWidth)
			{
				
				$("#actDisplaySeg div.actBlock").each(function(){
					var toLeft = $(this).position().left+streamLeft;
					toLeft+='px';
					if($(this).index() == blockNum-1)//遍历到最后一个元素
					{
						//取消左箭头
						$("#actDisplaySeg a.pre").css('display','none');
					}
					$(this).animate({'left':toLeft},500,function(){
						finishNum++;
						if(finishNum == blockNum)//全部block的动作完成
						{
							$("#actDisplaySeg").prop("moving",false);
						}
					});						
				});
			}
			else
			{
				$("#actDisplaySeg div.actBlock").each(function(){
					var toLeft = $(this).position().left+blockWidth;
					toLeft+='px';
					$(this).animate({'left':toLeft},500,function(){
						finishNum++;
						if(finishNum == blockNum)//全部block的动作完成
						{
							$("#actDisplaySeg").prop("moving",false);
						}
					});		
				});
			}	
			//显示右箭头
			$("#actDisplaySeg a.next").css('display','block');
		}
});
</script>
<div id="<?php echo $containerId;?>">
	<div id="actDisplayerHeading">
    	<div style="font-size:16px;color:white;margin:0 0 30px 0;font-weight:bold">活动预告</div>
        <div style="font-size:13px;color:white;margin:0 0 30px 0;font-weight:bold">EVENTS</div>
    </div>
    <div id="actDisplaySeg">
        <a class="pre"></a>
        <a class="next"></a>       
        <?php echo $actContent;?>
    </div>
</div>