<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	modified in 2013.12
	****************/
?>
<?php
/************
PicSlider
author:leongchunwai
*********/
/*.transparent_class { 
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; // ie8  
    filter:alpha(opacity=50);    // ie5-7  
    opacity: 0.5;    // css standard, currently it works in most modern browsers  
} */
//外部门户网站图片切换部件，

if($picNum == 1)//只有一张图，不显示图片控制
{
?>
<script type='text/javascript'>
	$(document).ready(function(){
		$("#<?php echo $containerId;?>wrap > #<?php echo $containerId;?> > div.picSliderCtr").css({'display':'none'});
	});
</script>
<?php } ?>
<?php
if(!$noBG)//需要背景图时，可能背景图较大，等图片砸入完成再显示
{
?>
<script type='text/javascript'>
<?php /*旧版方法，耗流量且ie效果不好
	$(document).ready(function(){
		if(!$.support.leadingWhitespace)// for ie
		{
			$("#<?php echo $containerId;?>wrap > img").css('display','block');
		}
		else
		{
			$("#<?php echo $containerId;?>wrap > img").load(function(){
				$(this).fadeIn(2000);
			});
		}
		
	});*/
?>
//判断是否加载完成 ,url为载入的图片地址，imgid为img标签的id,
function loadBigImg(url,imgId)
{    
    var img = new Image(); 
	//如果因为网络或图片的原因发生异常,不显示bg img
	//img.onerror=function(){img.src='error.gif'} 
	img.src = url; 
	if(img.complete || img.width)//FF ok;ie8 ok;//chrome false all the time
	{
		///该图片已经存在于缓存之中，直接显示
		//alert('w');
		$("#<?php echo $containerId;?>wrap > #"+imgId).attr('src',url);
		$("#<?php echo $containerId;?>wrap > #"+imgId).css('display','block');
	}
	else
	{
		if(!$.support.leadingWhitespace)// for ie
		{ 
			img.onreadystatechange = function()
			{  
				if(img.readyState == "complete" || img.readyState == "loaded")
				{ 
					<?php echo $containerId;?>showImg(img,imgId); 
				} 
			}        
		}
		else
		{ 
			img.onload = function(){
				if(img.complete == true)
				{ 
					<?php echo $containerId;?>showImg(img,imgId); 
				} 
			}        
		}    
    }
} 

//显示图片 
function <?php echo $containerId;?>showImg(imgObj,imgId){ 
	//document.getElementById(imgid).src=obj.src; 
	$("#<?php echo $containerId;?>wrap > #"+imgId).attr('src',imgObj.src);
	$("#<?php echo $containerId;?>wrap > #"+imgId).fadeIn(500);
} 
$(document).ready(function(){
	loadBigImg("<?php echo $picBG;?>","bgImg");	

});
</script>
<?php } ?>
<style type="text/css">
#<?php echo $containerId;?>wrap{
	width:100%;
	position:relative;
	overflow:hidden;background-color:gray;
	margin-bottom:<?php echo $marginBottom;?>;
}
#<?php echo $containerId;?>wrap > #bgImg{display:none;position:absolute;top:0;left:0;width:100%;} <?php /*bg img*/ ?>
#<?php echo $containerId;?>{
	position:relative;
	width:<?php echo $width;?>;
	height:<?php echo $height;?>;
	overflow:hidden;
	margin:0 auto;
}
#<?php echo $containerId;?> > div.picSliderCtr{
	width:98px;
	position:absolute;
	top:<?php echo (int)($height-70)."px";?>;
	left:<?php echo (int)($width/12)."px";?>;
	height:32px;
	z-index:10;overflow:hidden
}
#<?php echo $containerId;?> > div.picSliderCtr > a.pre,#<?php echo $containerId;?> > div.picSliderCtr > a.play,#<?php echo $containerId;?> > div.picSliderCtr > a.stop,#<?php echo $containerId;?> > div.picSliderCtr > a.next{
	display:block;
	background-image:url("<?php 
		//echo Yii::app()->baseUrl/protected/components/assets/picSliderWidget/sliderCtr.gif;//此地址forbidden
		echo Yii::app()->baseUrl;?>/assets/picSliderWidget/sliderCtr.gif");
	width:32px;
	height:32px;
	float:left;
	cursor:pointer;
}

#<?php echo $containerId;?> > div.pic{
	width:<?php echo $width;?>;
	height:<?php echo $height;?>;
	display:none;position:
	absolute;top:0;left:0;z-index:8
}
#<?php echo $containerId;?> > div.pic > a > div.picTitle{position:absolute;
	font-size:<?php echo $titleFontSize;?>;
	color:white;
	top:<?php echo $titleTop;?>;
	left:<?php echo $titleLeft;?>;
	width:<?php echo $titleWidth;?>;
	font-weight:bold;
	z-index:10}
#<?php echo $containerId;?> > div.pic > div.picSubDiv{
position:absolute;
	font-size:<?php echo $subTitleFontSize;?>;
	color:white;
	top:<?php echo $subTitleTop;?>;
	left:<?php echo $subTitleLeft;?>;
	width:<?php echo $subTitleWidth;?>;
	z-index:10;
}
#<?php echo $containerId;?> > div.pic > div.picMask{
	width:<?php echo $maskOpt['width'];?>;
	height:<?php echo $height;?>;
	background-color:black;
	opacity:0.<?php echo $maskOpt['opacity'];?>;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
	filter:alpha(opacity=<?php echo $maskOpt['opacity'];?>);   /*IE5、IE5.5、IE6、IE7*/
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $maskOpt['opacity'];?>)"; /*IE8*/
	position:absolute;top:0;left:0;z-index:9}
#<?php echo $containerId;?> > div.pic > a > img.pic{
	float:right;
	width:<?php echo $width;?>;/*height:<?php echo $height;?>*/}
/*dont change!!!gif's */
div.picSliderCtr > a.preOut{background-position:0px -32px}
div.picSliderCtr > a.preIn{background-position:0px 0px}

div.picSliderCtr > a.playOut{background-position:-65px -32px}
div.picSliderCtr > a.playIn{background-position:-65px 0px}

div.picSliderCtr > a.stopOut{background-position:-32px -32px}
div.picSliderCtr > a.stopIn{background-position:-32px 0px}

div.picSliderCtr > a.nextOut{background-position:-98px -32px}
div.picSliderCtr > a.nextIn{background-position:-98px 0px}
</style>
<script type="text/javascript">
//先注册slider控制的动画
$(document).delegate("div.picSliderCtr a.pre","mouseenter",function(){
	//$(this).css("backgroundPosition","0px 0px");	
	$(this).removeClass("preOut");
	$(this).addClass("preIn");
});
$(document).delegate("div.picSliderCtr a.pre","mouseleave",function(){
	//$(this).css("backgroundPosition","0px -32px");
	$(this).removeClass("preIn");
	$(this).addClass("preOut");	
});

$(document).delegate("div.picSliderCtr a.play","mouseenter",function(){
	//$(this).css("backgroundPosition","-65px 0px");	
	$(this).addClass("playIn");
	$(this).removeClass("playOut");
});
$(document).delegate("div.picSliderCtr a.play","mouseleave",function(){
	//$(this).css("backgroundPosition","-65px -32px");	
	$(this).removeClass("playIn");
	$(this).addClass("playOut");
});

$(document).delegate("div.picSliderCtr a.next","mouseenter",function(){
	//$(this).css("backgroundPosition","-98px 0px");	
	$(this).addClass("nextIn");
	$(this).removeClass("nextOut");
});
$(document).delegate("div.picSliderCtr a.next","mouseleave",function(){
	//$(this).css("backgroundPosition","-98px -32px");	
	$(this).removeClass("nextIn");
	$(this).addClass("nextOut");
});

$(document).delegate("div.picSliderCtr a.stop","mouseenter",function(){
	//$(this).css("backgroundPosition","-32px 0px");	
	$(this).addClass("stopIn");
	$(this).removeClass("stopOut");
});
$(document).delegate("div.picSliderCtr a.stop","mouseleave",function(){
	//$(this).css("backgroundPosition","-32px -32px");	
	$(this).removeClass("stopIn");
	$(this).addClass("stopOut");
});

//控制器动画完毕
//下面绑定左箭头与右箭头动作
$(document).delegate("div.picSliderCtr a.pre,div.picSliderCtr a.next","click",function(e){
	e.preventDefault();//停止默认锚点动作
	var $sliderContainer = $("#<?php echo $containerId;?>");//获取整个slider的对象
	if($sliderContainer.prop('moving'))//如果正在切换时点击按钮，则什么都不发生
	{
		return true;	
	}
	if(e.clientX)//真正点击时此为true
	{
		//停止播放
		$("div.picSliderCtr a.stop").click();	
	}
	$sliderContainer.prop('moving',true);
	if(!$sliderContainer.prop('curSlideIndex'))//若此属性未设置，则设置为初始值1
	{
		$sliderContainer.prop('curSlideIndex',1);	
	}
	var curSlideIndex = $sliderContainer.prop('curSlideIndex');//当前显示图片的索引值
	var movingForward = $(this).hasClass('next');//true为点击右箭头，false为点击左箭头
	
	var $slides = $sliderContainer.find("div.pic");//获取所有幻灯片对象
	var $curSlide = $slides.eq(curSlideIndex-1);//当前幻灯片对象
	var $next = movingForward ? nextSlide($sliderContainer,curSlideIndex):previousSlide($sliderContainer,curSlideIndex);
	
	var nextSlideIndex = $next.index;//下一个幻灯片的索引，从1开始
	if(nextSlideIndex == curSlideIndex)//只有一张幻灯片的情况
	{
		$sliderContainer.prop('moving',false);
		return true;
	}
	var $nextSlide = $next.object;//下一个幻灯片对象
	
	var fromLeft = (movingForward ? <?php echo (int)$width;?>:-<?php echo (int)$width;?>)+"px";//下一个幻灯片的起始Left
	var targetLeft = (movingForward ? -<?php echo (int)$width;?>:<?php echo (int)$width;?>)+"px";//当前幻灯片的目标Left
	//默认当前幻灯片当前位置与下一个幻灯片目标位置均为 left:0px
	
	$nextSlide.css({// 设置下一个幻灯片的css
		'top':'0px',
		'left':fromLeft,
		'display':'block'
	});
		//animate and then reset curSlide
	$nextSlide.animate({'left':'0px'},<?php echo $animateSpeed;?>);
	$curSlide.animate({'left':targetLeft},<?php echo $animateSpeed;?>,function(){
		$curSlide.css({'display':'none','left':'0'});		
		$sliderContainer.prop('moving',false);
		$sliderContainer.prop('curSlideIndex',nextSlideIndex);
	});
});
//自动播放动作******
var picSlideTimer;
$(document).delegate("div.picSliderCtr a.play","click",function(e){//点击了“开始播放”按钮
	e.preventDefault();//阻止默认锚点动作	
	picSlideTimer = setInterval(function(){$("div.picSliderCtr a.next").click();},<?php echo $slideTime;?>);
	$(this).removeClass('play');//转换外观
	$(this).removeClass('playIn');//转换外观
	$(this).removeClass('playOut');//转换外观
	$(this).addClass('stop');
	if(e.clientX)//真的点击时，要添加mouseenter后的class,否则为mouseleave的class
	{
		$(this).addClass("stopIn");
		//鼠标点击，马上切换到下一张
		$("div.picSliderCtr a.next").click();
	}
	else
	{
		$(this).addClass("stopOut");
	}
});
$(document).delegate("div.picSliderCtr a.stop","click",function(e){//点击了"停止播放"按钮
	e.preventDefault();//阻止默认锚点动作	
	clearInterval(picSlideTimer);
	$(this).removeClass('stop');//转换外观
	$(this).removeClass('stopIn');//转换外观
	$(this).removeClass('stopOut');//转换外观
	$(this).addClass('play');
	if(e.clientX)//真的点击时，要添加mouseenter后的class,否则为mouseleave的class
	{
		$(this).addClass("playIn");
	}
	else
	{
		$(this).addClass("playOut");
	}
});
//*********************
setTimeout(function(){$("div.picSliderCtr a.play").click();},0)//设置进入页面就自动播放
function nextSlide($sliderContainer,curSlideIndex)//根据当前幻灯片获取下一个幻灯片
{
	$slides = $sliderContainer.find("div.pic");
	if(curSlideIndex >= $slides.size())//当前幻灯片是最后一个幻灯片
	{
		return {'index':1,'object':$slides.eq(0)};	//返回第一个幻灯片的index与对象,json格式
	}	
	else
	{
		return {'index':curSlideIndex+1,'object':$slides.eq(curSlideIndex)};//返回下一个幻灯片	
	}
}
function previousSlide($sliderContainer,curSlideIndex)//根据当前幻灯片获取上一个幻灯片
{
	$slides = $sliderContainer.find("div.pic");
	if(curSlideIndex <= 1)//当前幻灯片是第一个幻灯片
	{
		return {'index':$slides.size(),'object':$slides.eq(-1)};	//返回最后一个幻灯片的index与对象,json格式
	}	
	else
	{
		return {'index':curSlideIndex-1,'object':$slides.eq(curSlideIndex-2)};//返回前一个幻灯片	
	}
}
</script>
<div id="<?php echo $containerId;?>wrap">
<?php if(!$noBG){ 
	/*<img src='<?php echo $picBG."?".time(); ?>'></img>*/
		?>
		<img id="bgImg" ></img>
<?php } ?>
	<div id="<?php echo $containerId;?>">
		<div class="picSliderCtr">
    		<a class="pre preOut"></a>
    	    <a class="play playOut"></a>
    	    <a class="next nextOut"></a>
	    </div>
    	<?php echo $widgetContent;?>
	</div>
</div>