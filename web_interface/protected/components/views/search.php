<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>;}
	#<?php echo $id;?> > div.input-append > input.searchInput{width:<?php echo ($width-80-13)."px"?>}/* has 14px padding-leftRight,margin -1*/
	#<?php echo $id;?> > div.input-append > button{width:80px}
	#<?php echo $id;?> > div.input-append{position:relative}
	#<?php echo $id;?> > div.input-append > div.predict{
		position:absolute;top:30px;left:0;width:<?php echo ($width-70-13)."px"?>;
		/*height:300px;*/
		background-color:white;
		z-index:1000;
		border:1px solid silver;
		display:none;
		text-align:left;
	}
	#<?php echo $id;?> > div.input-append > div.predict > div.line{
		font-size:13px;
		padding:5px;
		cursor:pointer;
		color:black;background-color:white;
	}
	#<?php echo $id;?> > div.input-append > div.predict > div.lineHover{
		color:white;background-color:rgb(140,0,0);
	}
	#<?php echo $id;?> > div.resultDiv{}
	#<?php echo $id;?> > div.resultDiv > div.resultBlock{padding-bottom:15px;}
	#<?php echo $id;?> > div.resultDiv > div.resultBlock > div.resultLine{padding-bottom:5px}
	#<?php echo $id;?> > div.resultDiv > div.resultBlock > div.resultLine > a.resultLink{font-size:16px}
	#<?php echo $id;?> > div.resultDiv > div.resultBlock > div.resultLine > div.intro{font-size:13px}
	#<?php echo $id;?> > div.resultDiv > div.resultBlock > div.resultLine > div.sub{color:#008000;font-size:11px}
</style>
<div id="<?php echo $id;?>">
	<div class="input-append">
		<div class='predict'></div>
		<input class="searchInput" type="text" maxlength="64" value="<?php echo $w;?>"></input>
		<button class="btn search" type="button">搜一下</button>
	</div>
	<?php if($returnResult){ ?>
	<div class='resultDiv'>
	</div>
	<?php } ?>
</div>

<script type='text/javascript'>
	<?php if($returnResult){ 
		
	?>
		$(document).delegate("#<?php echo $id;?> > div.input-append > button.search",'click',function(){
			if($("#<?php echo $id;?> > div.input-append > input.searchInput").val() != '')
			{
				<?php echo $id;?>search($("#<?php echo $id;?> > div.input-append > input.searchInput").val());
			}
		});
function <?php echo $id;?>search(str)
{
	var data = {};
	data.w = str;
	$("#<?php echo $id;?> > div.resultDiv").html("<div class='wrapLoading'><div class='loading'></div></div>");
	$.post("<?php echo $searchUrl;?>",data,function(result){
		//alert(result);
		$("#<?php echo $id;?> > div.resultDiv").html("");
		if(result.length == 0)
		{
			$("#<?php echo $id;?> > div.resultDiv").html("<div class='wrapLoading'>没有匹配结果</div>");
			return;
		}
		$.each(result,function(index,item){
			var tempDiv = $("<div class='resultBlock'>"+
				"<div class='resultLine'>"+
					"<a href='<?php echo Yii::app()->baseUrl;?>/index.php/site/viewText?id="+item.textId+"&checkId="+item.checkId+"' class='resultLink'>"+item.textTitle+"</a>"+
				"</div>"+
				"<div class='resultLine'>"+
					"<div class='intro'>"+item.textIntro+"</div>"+
				"</div>"+
				"<div class='resultLine'>"+
					"<div class='sub'>"+item.textTime+" 作者: "+item.authorName+"</div>"+
				"</div>"+
			"</div>");
			tempDiv.appendTo("#<?php echo $id;?> > div.resultDiv");
		});
	},'json');
}
		<?php if($w != ''){
		 //传入关键字不为空时
		 ?>
			$(document).ready(function(){
				if($("#<?php echo $id;?> > div.input-append > input.searchInput").val() != '')
				{
					<?php echo $id;?>search($("#<?php echo $id;?> > div.input-append > input.searchInput").val());
				}
			});
		<?php } ?>
	<?php }else{
		//点击按钮不直接返回结果，则跳转搜索页面
	 ?>
		 $(document).delegate("#<?php echo $id;?> > div.input-append > button.search",'click',function(){
			var searchWord = encodeURIComponent($("#<?php echo $id;?> > div.input-append > input.searchInput").val());
			window.open("<?php echo $searchPageUrl;?>?w="+searchWord,"_target");
		});

	<?php } ?>
	<?php if($autoCl){ 
		//打开输入预测
	?>
	//绑定hover动画
	$(document).delegate("#<?php echo $id;?> > div.input-append > div.predict > div.line","mouseenter",function(){
		//移除
		$("#<?php echo $id;?> > div.input-append > div.predict > div.line").removeClass("lineHover");
		$(this).addClass("lineHover");
	});
	$(document).delegate("#<?php echo $id;?> > div.input-append > div.predict > div.line","mouseleave",function(){
		$(this).removeClass("lineHover");
	});
	//*******************************************
		//当有预测框时，去除上下箭头默认动作
		$(document).delegate("#<?php echo $id;?> > div.input-append > input.searchInput","keydown",function(ev){
			var e = e||event;
			var keycode = e.which || e.keyCode;
			if($("#<?php echo $id;?> > div.input-append > div.predict").css('display') == "block")
			{
				if((keycode == 40) || (keycode == 38))//去除上下箭头默认动作(即光标的移动)
				{
					e.preventDefault();		
				}
			}
		});
		//当文本改变时进行输入预测
		$(document).delegate("#<?php echo $id;?> > div.input-append > input.searchInput",'keyup',function(ev){
			//$(this).val("");
			//	alert('a');
			//alert('fuck');
			//ev.preventDefault();
			var e = e||event;
			var keycode = e.which || e.keyCode;								
			if((keycode != 13) && (keycode != 38) && (keycode != 40) && (keycode != 37) && (keycode != 39))//非回车键\上下左右箭头
			{
				<?php echo $id;?>searchPredict($(this).val());
			}
			else
			{
				//******绑定按键动作，上(38)下(40)箭头与回车(13)
				if((keycode == 40) || (keycode == 38))
				{
					if($("#<?php echo $id;?> > div.input-append > div.predict").css('display') == "block")//有预测项时
					{
						if(keycode == 40)//下箭头
						{
							<?php echo $id;?>movePredict("next");
						}
						else if(keycode == 38)//上箭头
						{
							<?php echo $id;?>movePredict("pre");
						}
					}
				}
				else if(keycode == 13)
				{
					if($("#<?php echo $id;?> > div.input-append > div.predict > div.lineHover").length != 1)//当未选中任何预测项时直接点击搜索
					{
						$("#<?php echo $id;?> > div.input-append > div.predict").css("display",'none');
						$("#<?php echo $id;?> > div.input-append > button.search").click();				
					}
					else//选中一项预测项，把其添加到输入框再点击搜索
					{
						$("#<?php echo $id;?> > div.input-append > div.predict > div.lineHover").click();
					}
				}
			}
			
		});
		
		
		function <?php echo $id;?>movePredict(command)
		{
		//	$("#<?php echo $id;?> > div.input-append > input.searchInput").blur();
		//	$("#<?php echo $id;?> > div.input-append > div.predict").focus();
			//获得当前选取的预测项，没有就为0
			//alert('w');
			//alert($("#<?php echo $id;?> > div.input-append > div.predict > div.lineHover").index());//-1为没有，0..n-1开始
			var lineNum = $("#<?php echo $id;?> > div.input-append > div.predict > div.line").length;
			var curSelectIndex = $("#<?php echo $id;?> > div.input-append > div.predict > div.lineHover").index();
			var nextSelectIndex = curSelectIndex+1 >= lineNum?0:curSelectIndex+1;
			var preSelectIndex = curSelectIndex-1 < 0?-1:curSelectIndex-1;
			if(command == "next")
			{
				//alert("w");
				//去除所有其他的lineHover
				$("#<?php echo $id;?> > div.input-append > div.predict > div.line").removeClass("lineHover");
				$("#<?php echo $id;?> > div.input-append > div.predict > div.line").eq(nextSelectIndex).addClass("lineHover");
				//添加预测内容到搜索输入框中
				$("#<?php echo $id;?> > div.input-append > input.searchInput").val($("#<?php echo $id;?> > div.input-append > div.predict > div.line").eq(nextSelectIndex).html());
			}
			else if(command == "pre")
			{
				//alert("w");
				//去除所有其他的lineHover
				$("#<?php echo $id;?> > div.input-append > div.predict > div.line").removeClass("lineHover");
				$("#<?php echo $id;?> > div.input-append > div.predict > div.line").eq(preSelectIndex).addClass("lineHover");
				//添加预测内容到搜索输入框中
				$("#<?php echo $id;?> > div.input-append > input.searchInput").val($("#<?php echo $id;?> > div.input-append > div.predict > div.line").eq(preSelectIndex).html());
			}
		}
		
//********************************
		//点击预测行，输入到输入框中,同时隐藏预测div
		$(document).delegate("#<?php echo $id;?> > div.input-append > div.predict > div.line",'click',function(){
			//alert($(this).html());
			$("#<?php echo $id;?> > div.input-append > input.searchInput").val($(this).html());
			$("#<?php echo $id;?> > div.input-append > div.predict").css("display",'none');
			//点击搜索按钮
			$("#<?php echo $id;?> > div.input-append > button.search").click();
		});
		var mouseNotInSearchDiv = true;
		$(document).delegate("#<?php echo $id;?> > div.input-append","mouseenter",function(){
			mouseNotInSearchDiv = false;
		});
		$(document).delegate("#<?php echo $id;?> > div.input-append","mouseleave",function(){
			mouseNotInSearchDiv = true;
		});
		//点击其他地方，失去焦点，预测框也消失
		$(document).delegate("#<?php echo $id;?> > div.input-append > input.searchInput",'blur',function(){
			if(mouseNotInSearchDiv)//当鼠标点击外面的地方触发的失去焦点才。。
			{
				$("#<?php echo $id;?> > div.input-append > div.predict").css("display",'none');
			}
		});
function <?php echo $id;?>searchPredict(str)
{
	var data = {};
	data.w = str;
	//alert(data.w);
	$.post("<?php echo $searchPredictUrl;?>",data,function(result){
		//alert(result);
		//先清空原有的提示
		$("#<?php echo $id;?> > div.input-append > div.predict").html("");
		if(result.length == 0)//当前输入没有结果
		{
			$("#<?php echo $id;?> > div.input-append > div.predict").css('display','none');
			
			return;
		}
		$.each(result,function(index,item){
			//alert(item.predictW);
			var tempLine = $("<div class='line'>"+item.predictW+"</div>");
			tempLine.appendTo("#<?php echo $id;?> > div.input-append > div.predict");
		});
		$("#<?php echo $id;?> > div.input-append > div.predict").css('display','block');
	},'json');
}
	<?php } ?>

</script>