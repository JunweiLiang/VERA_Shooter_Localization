<?php 
	/****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>;padding:10px}
	#<?php echo $id;?> > div.navbar{width:<?php echo ($width-20).'px';?>;}
	#<?php echo $id;?> > div.fbDiv > div.inputDiv{float:left;width:<?php echo ($width-140).'px';?>;
		padding:10px;
	}#<?php echo $id;?> > div.fbDiv > div.inputDiv > textarea{width:<?php echo ($width-160).'px'?>;font-size:13px}
	#<?php echo $id;?> > div.fbDiv > div.fbCtr{margin:0 0 0 <?php echo ($width-120).'px';?>;width:80px;
		padding:10px;
	}
</style>
<script type='text/javascript'>
	//定义下拉框动作 
	$(document).delegate("#<?php echo $id;?> > div.fbDiv > div.fbCtr a.menuItem",'click',function(e){
		e.preventDefault();
		//alert($(this).attr('id'));
		$(this).parent().parent().parent().attr('id',$(this).attr('id'));
		$(this).parent().parent().parent().children('a.btn').children("span.text").html($(this).html());
	});
	//定义发送按钮动作
	$(document).delegate("#<?php echo $id;?> > div.fbDiv > div.fbCtr > div.send","click",function(){
		//禁用按钮
		if(!$(this).hasClass("disabled"))
		{
		$(this).addClass("disabled");
		var data = {};
		data.text = $(this).parent().parent().children("div.inputDiv").children('textarea').val();
		if(data.text == "")
		{
			$(this).parent().parent().children("div.inputDiv").children('span.sendE').html("内容不能为空!");
			//setTimeout(function(){$(this).parent().parent().children("div.inputDiv").children('span.sendE').html("");},3000);
			return;
		}
		else if(data.text.length > 140)
		{
			$(this).parent().parent().children("div.inputDiv").children('span.sendE').html("不能超过140字!");
			//setTimeout(function(){$(this).parent().parent().children("div.inputDiv").children('span.sendE').html("");},3000);
			return;
		}
		data.privacy = $(this).parent().children("div.privacy").attr("id");
		<?php if($snapchat){ ?>
		data.snap = getNum($(this).parent().children("div.snap").attr("id"));
		<?php } ?>
		$.post("<?php echo $sendUrl;?>",data,function(result){
			//alert(result);
			$("#<?php echo $id;?> > div.fbDiv > div.fbCtr > div.send").removeClass("disabled");
			if(result == "error")
			{
				alert("Oops!");
				return;
			}
			//清空输入区
			$("#<?php echo $id;?> > div.fbDiv > div.inputDiv > textarea").val("");
			//选回"公开发布"
			$("#<?php echo $id;?> > div.fbDiv > div.fbCtr > div.privacy > ul > li > a").eq(0).click();
		});
		}
	});
	
</script>

<div id="<?php echo $id;?>">
	<div class="navbar">
		<div class="navbar-inner">
    		<a class="brand" href="#">说说</a>
    		<ul class="nav">
    			<li class="active"><a href="#">文本</a></li>
			</ul>
		</div>
	</div>
	<div class='fbDiv'>
		<?php if($canPost){ ?>
		<div class='inputDiv'>
			<textarea rows='3'></textarea>
			<span class='help-inline sendE' style='color:orange'></span>
		</div>
		<div class='fbCtr'>
			<div class='btn btn-info btn-block send btn-large'>发送</div>
			<div class="btn-group privacy" style='display:block;padding-top:5px' id='p'>
				<a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
    				<span class='text'>公开发布</span>
    				<span class="caret"></span>
  				</a>
				<ul class="dropdown-menu">
   					 <li><a class='menuItem' href='#' id='p'>公开发布</a></li>
   					 <li><a class='menuItem' href='#' id='a'>匿名发布</a></li>
				</ul>
			</div>
			<?php if($snapchat){ ?>
			<div class="btn-group snap" style='display:block;padding-top:5px;margin:0' id='s0' title='阅后即焚'>
				<a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
    				<span class='text'>阅后即焚</span>
    				<span class="caret"></span>
  				</a>
				<ul class="dropdown-menu" style='width:100px'>
   					 <li><a class='menuItem' href='#' id='s5'>5秒</a></li>
   					 <li><a class='menuItem' href='#' id='s15'>15秒</a></li>
   					 <li><a class='menuItem' href='#' id='s30'>30秒</a></li>
   					 <li><a class='menuItem' href='#' id='s0'>永久</a></li>
				</ul>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>
<script type='text/javascript'>
	function getNum(str)
{
var reg=/^[a-zA-Z]+([0-9]+)$/g;
if(reg.test(str))
{
reg.lastIndex = 0;
return reg.exec(str)[1];
}
else
{
return "";
}
}
</script>