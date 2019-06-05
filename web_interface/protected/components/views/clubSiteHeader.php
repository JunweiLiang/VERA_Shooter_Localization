<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php
	//内部论坛网站的头导航栏，已经获取用户信息
	//用session去获取message
?>
<style type="text/css">
	#headerContainer{z-index:2000;position:fixed;top:0;left:0;width:100%;height:30px;background-color:<?php echo COLOR1_LIGHTER1;?>}
	#headerLogoDiv{position:relative;float:left;width:150px;height:24px;border-bottom:silver 2px solid;background-color:white;text-align:center;padding:5px 0 0 0;}
		#clubLogo{height:20px;margin:0 0 0 5px}
	#headerNavDiv{margin:0 0 0 150px;height:30px;width:830px}
		#headerNavDiv div.headerNavItemLeft{float:left;position:relative;}
		#headerNavDiv div.headerNavItemRight{float:right;position:relative;}
			#headerNavDiv a.navTitle{height:25px;width:80px;display:block;padding:5px 0 0 0px;color:white;text-align:center;font-weight:bold;text-decoration:none}	
			#headerNavDiv a.navTitle:hover{background-color:rgb(45,191,97)}
			#headerNavDiv #searchInput{height:15px;width:150px;}
			#headerNavDiv #searchButton{height:25px;padding:0px 5px 0 5px;font-size:12px;}
			#headerNavDiv #searchButton,#headerNavDiv #searchInput{margin-top:3px}
			#userDiv{margin-top:-3px;z-index:2001;display:none;border:1px silver solid;border-top:0px;position:absolute;top:30px;left:-72px;width:110px;background-color:white;padding:5px}
			#userDiv li{}
			#userDiv a{display:block;text-decoration:none;color:<?php echo COLOR1_LIGHTER1;?>;font-size:13px;}
			#userDiv a:hover{color:white;background-color:<?php echo COLOR1_LIGHTER1;?>;background-image:none}
			
			#headerContainer div.message > a{display:block;position:relative}
			#headerContainer div.message > a > div.hasMes{display:none;
				position:absolute;top:0;left:0;height:25px;width:30px;text-align:center;background-color:rgb(230,0,0);
				padding-top:5px;
			}
</style>
<div id="headerContainer">
	<div class="wrap">
		<div id="headerLogoDiv">
			<!--<img id="clubLogo" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/images/officeLogo.png"></img>-->
			VERA
		</div>
		<div id="headerNavDiv">
		<script type="text/javascript">
			//绑定头导航栏的动画
			//已取消为单一退出登录按钮
			/*
			var timerFor_userDiv;
			$(document).delegate("#headerNavDiv div.headerNavItemLeft,#headerNavDiv div.headerNavItemRight","mouseenter",function(){
				var a = $(this).find("#userDiv");//是否有账户信息节点
				if(a.length != 0)
				{//账户信息节点延时出现
					//alert('hi');
					timerFor_userDiv = setTimeout(function(){
						$("#headerNavDiv #userDiv").css({'display':'block'});
					},500);
				}
				$(this).css({'backgroundColor':'rgb(45,191,97)'});
			});
			$(document).delegate("#headerNavDiv div.headerNavItemLeft,#headerNavDiv div.headerNavItemRight","mouseleave",function(){
				var a = $(this).find("#userDiv");//是否有账户信息节点
				if(a.length != 0)
				{
					clearInterval(timerFor_userDiv);
					$("#headerNavDiv #userDiv").css({'display':'none'});
				}
				$(this).css({'backgroundColor':'transparent'});
			});*/
			/*$(document).delegate("div.headerNavItemLeft > a",'click',function(e){
				e.preventDefault();
				alert($(this).offset().top);
			});*/
			//****
		</script>
				<div class="headerNavItemLeft"><a href="<?php echo Yii::app()->baseUrl;?>/index.php/application" class="navTitle">Home</a></div>
				<?php if($personalUrl !== false){ ?>
					<div class="headerNavItemLeft"><a href="<?php echo $personalUrl;?>" class="navTitle">profile</a></div>
				<?php } ?>
				<div class="headerNavItemRight message">
					<a href="<?php echo Yii::app()->baseUrl;?>/index.php/user/logout" class="navTitle" style="">
						logout
					</a>
				</div>
				<!--
				<div class="headerNavItemRight message">
					<a href="<?php echo Yii::app()->baseUrl;?>/" class="navTitle" style="">
						大赛首页
					</a>
				</div>
				-->
				<!--
				<div class="headerNavItemRight"><a href="<?php echo $personalUrl;?>" class="navTitle" style="width:60px;font-weight:normal;font-size:12px;">账户 <i class="icon-chevron-down"></i></a>					
					//已经换成单一退出按钮
					<ul id="userDiv"class="dropdown-menu">
						<?php if($personalUrl !== false){ ?>
 							<li><a href="<?php echo $personalUrl;?>"><i class="icon-user"></i><span class="space"></span><?php echo $userName;?></a></li>
 						<?php } ?>
  						<li><a href="<?php echo Yii::app()->baseUrl;?>/index.php/user/logout"><i class="icon-share-alt"></i><span class="space"></span>退出</a></li>
  						<li class="divider"></li>
 						<li><a href="<?php echo Yii::app()->baseUrl;?>/"><i class='icon-home'></i><span class="space"></span>返回外部网站首页</a></li>
					</ul>					
				</div>
				-->
				<?php if($showSearch){ ?>
				<div class="input-append" style="float:right;margin:0 10px 0 20px;display:inline/*ie double fixed*/">
						<input type="text" id="searchInput" class="span2">
						<button type="submit" id="searchButton" class="btn"><i class="icon-search"></i></button>
				</div>
				<?php } ?>
				<?php if($showChat){ ?>
				<div class="headerNavItemRight message">
					<a href="<?php echo $chatUrl;?>" class="navTitle" style="width:30px">
						<div class='hasMes'><i class="icon-envelope icon-white"></i></div>
						<i class="icon-envelope"></i>
					</a>
				</div>
				<?php } ?>
		</div>
	</div>
</div>
<script type='text/javascript'>
<?php if($showChat){ ?>
//定义获取短消息动作
$(document).ready(function(){
	//setTimeout(function(){getChatLongPolling();},2000);
	setTimeout(function(){getChat();},2000);
});
function getChat()
{
	$.post('<?php echo Yii::app()->baseUrl;?>/index.php/chat/getSumOnce',"",function(result){
		//每次同时还修改 侧栏目panel上的"消息"栏
		if(result.chatNum != 0)
			{
				$('#headerContainer div.message > a > div.hasMes').slideDown(300);
				//$('#headerContainer div.message > a > i').attr('title','你有新消息');
				//$('#headerContainer div.message > a').css('backgroundColor','orangeRed');
				$("#navPanel > li.chat,#navPanel > li.cChat,#navPanel > li.jChat")
					.children("a.navTitle:not(.active)").css("color","red").html('<i class="icon-envelope"></i> 你有新消息!');
			}
			else
			{
				//没有消息
				$("#navPanel > li.chat,#navPanel > li.cChat,#navPanel > li.jChat")
					.children("a.navTitle:not(.active)").css("color","<?php echo COLOR1_LIGHTER1;?>").html('<i class="icon-envelope"></i> 消息');
				
				if($('#headerContainer div.message > a > div.hasMes').css('display') == 'none')
				{
					return;
				}
				else
				{
					$('#headerContainer div.message > a > div.hasMes').slideUp(300);
				}
			}
			
	},'json');
}
function getChatLongPolling()
{
	//alert(userId);
	$.ajax({
		url:'<?php echo Yii::app()->baseUrl;?>/index.php/chat/getSum',
		data:"",
		type:"POST",
		dataType:"json",
		timeout:30000,
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			//alert("erro");
            $('#headerContainer div.message > a > div.hasMes').slideUp(300);
		//	setTimeout(function(){
				getChatLongPolling();
		//	},2000);
        },
        success:function(result)
        {
        	//alert(result);
        	//alert(result.chatNum);
			if(result.chatNum != 0)
			{
				$('#headerContainer div.message > a > div.hasMes').slideDown(300);
				$('#headerContainer div.message > a > div.hasMes').attr('title','你有新消息');
			}
			else
			{
				$('#headerContainer div.message > a > div.hasMes').slideUp(300);
			}
			//成功了，等待几秒后再获取 
			setTimeout(function(){
				getChatLongPolling();
			},<?php echo IDADDUP ;?>);
        }
	});
}
<?php } ?>
</script>