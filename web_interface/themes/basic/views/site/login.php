<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
div.loginModal{
	background:url('<?php echo Yii::app()->theme->baseUrl;?>/img/blue.png');
	background-position:center center;
}
div.loginModal > div.body > div.line.remMe > input{
	width:15px;
	height:15px;
}
/*
	屏幕宽度大于500px
*/
	div.loginModal{
		width:600px;
		margin:0 auto;
		padding-bottom:50px;
		padding-top:130px;
	}
div.loginModal > div.header{
	background-color:transparent;
	position:relative;
	margin:0 auto;
	width:320px;
	padding-top:3px;
	margin-bottom:20px;
}
div.loginModal > div.header > div.logo{
	width:45px;
	position:absolute;
	top:0;left:0;
}
div.loginModal > div.header > div.title{
	padding:0px;
	/*margin-left:17%;*/
	color:rgb(138,125,161);
	padding-bottom:20px;
}
div.loginModal > div.header > div.title.title1{
	font-size:2.5em;
	text-align:center;
	line-height:40px;
}
div.loginModal > div.header > div.title.title2{
	font-size:1em;
}
div.loginModal > div.body{
	padding:20px 0;
	padding-bottom:30px;
	width:300px;
	margin:0 auto;
}
div.loginModal > div.body > div.line > div.inputHead{
	width:25%;
	float:left;
}
div.loginModal > div.body > div.input{
	background-color:white;
	padding:15px;
	padding-top:10px;
}
div.loginModal > div.body > div.line.username{
	border-radius:5px 5px 0 0;
	margin-bottom:1px;
}
div.loginModal > div.body > div.line.pw{
	border-radius:0 0 5px 5px;
	margin-bottom:1px;
}
div.loginModal > div.body > div.line.remMe{
	padding:20px 0;
	padding-left:10px;
}
div.loginModal > div.body > div.line.varify{
	padding:10px;
	padding-bottom:0;
}
div.loginModal > div.body > div.line > input.input-medium{
	width:65%;
	border:0;
	margin:0;
	font-size:1.1em;
	color:gray;	
	-moz-box-shadow:none;     
 	   	-webkit-box-shadow:none; 
 	   	box-shadow:none;
 	   	margin-top:2px;
}
div.loginModal > div.body > div.line.varify > input.input-small{
	width:20%;
	margin:0;
	margin-right:10px;
}
div.loginModal > div.body > div.line.varify > img.varifyImg{
	width:55px;
}
div.loginModal > div.body > div.line > a.findPw{
	text-decoration:none;
}
div.loginModal > div.body > div.text-error{
	height:20px;
	padding:5px 0;
}
div.loginModal > div.body > div.loginDiv{

}
div.loginModal > div.body > div.loginDiv > div.login{
	padding:8px;
	text-align:center;
	cursor:pointer;
	color:white;
	background-color:rgb(249,103,30);
	border-radius:5px;
}

/*
	for iphone
*/
@media screen and (max-device-width:500px)
{
div.loginModal{
		width:100%;
		margin:0 auto;
		padding-bottom:10px;
		padding-top:20%;
	}
div.loginModal > div.header{
	background-color:transparent;
	position:relative;
	margin:0 auto;
	width:90%;
	padding-top:0px;
	margin-bottom:20px;
}

div.loginModal > div.header > div.title.title1{
	font-size:1.1em;
	overflow:hidden;
	line-height:35px;
}
div.loginModal > div.header > div.title.title2{
	font-size:1em;
	overflow:hidden;
}
div.loginModal > div.header > div.logo{
	top:-2px;
}
div.loginModal > div.body{
	padding:20px 0;
	padding-bottom:30px;
	width:80%;
	margin:0 auto;
}
}
</style>
<script type="text/javascript">
$(document).delegate("div.loginModal > div.body > div.loginDiv > div.login","click",function(){
	var data = {};
	//检查空输入
	if($("#loginName").val() == "")
	{
		showE("Please enter username.");
		return;
	}
	if($("#loginPw").val() == "")
	{
		showE("Please enter password.");
		return;
	}
	//需要输入验证码时不能未空
	if($("div.loginModal > div.body > div.varify").css("display") != "none")
	{
		if($("#varify").val() == "")
		{
			showE("Please enter verify code.");
			return;
		}
		data.varify = $("#varify").val();
	}
	
	data.loginName = $("#loginName").val();
	data.loginPw = $("#loginPw").val();
	data.remMe = $("#remMe").prop("checked")?"true":"false";
	//data.code = $("#code").val();
	//showEL("登录中..请稍候");
	showEL("logging in...");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/login",data,function(result){
		//alert(result);
		showE(result.text);
		if(result.ok != null)
		{
			//window.open("<?php echo Yii::app()->baseUrl;?>/index.php/application","_self");
			window.open("<?php echo Yii::app()->baseUrl;?>/index.php/<?php echo $redirect?>","_self");	
		}
		else//登录出错，刷新验证码
		{
			if(result.showVarify == 1)
			{
				if($("div.loginModal > div.body > div.varify > img.varifyImg").prop("src") != "")
				{
					$("div.loginModal > div.body > div.line > img.varifyImg").click();
				}
				else
				{
					$("div.loginModal > div.body > div.varify > img.varifyImg").prop("src","<?php echo Yii::app()->baseUrl;?>/index.php/site/vcode");
				}
				$("div.loginModal > div.body > div.varify").css("display","block");			
			}			
		}
	},'json');
});
function showE(str)
{
	$("div.loginModal > div.body > div.text-error").html(str);
	setTimeout(function(){
		$("div.loginModal > div.body > div.text-error").html("");
	},3000);
}
function showEL(str)
{
	$("div.loginModal > div.body > div.text-error").html(str);
	/*setTimeout(function(){
		$("div.loginModal > div.body > div.text-error").html("");
	},3000);*/
}
//刷新验证码
$(document).delegate("div.loginModal > div.body > div.line > img.varifyImg","click",function(){
	$(this).prop("src","<?php echo Yii::app()->baseUrl;?>/index.php/site/vcode?freash="+Math.random());
});
							//进入页面用户名获取焦点
							$(document).ready(function(){
							setTimeout(function(){
								$("#loginName").focus();
							},1000);
							});
							//回车登录
							$(document).keypress(function(e){
									//alert('fuck');
									var e = e||event;
									var keycode = e.which || e.keyCode;
									
									if(keycode == 13)
									{
										e.preventDefault();
										$('div.loginModal > div.body > div.loginDiv > div.login').click();
									}
								});
								
		//点击忘记密码，获取当前输入的用户名<?php echo Yii::app()->baseUrl;?>/index.php/site/findPw
		$(document).delegate("div.loginModal > div.body > div.line > a.findPw","click",function(e){
			e.preventDefault();
			var username = $("#loginName").val();
			if(username != "")
			{
				window.open("<?php echo Yii::app()->baseUrl;?>/index.php/site/findPw?username="+username,"_self");
			}
			else
			{
				alert("请输入您的登录名");
			}
		});
</script>
	<div class="loginModal">
		<div class="header">
			<!--
			<div class="logo">
				<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/logo.png"></img>
			</div>
			-->
			<div class="title title1">DAISY<sup style="font-size:50%;vertical-align:super">Alpha</sup></div>
		</div>
		<div class="body">
			<div class="line input username">
				<div class="inputHead">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/username.png"></img>
				</div><input class="input-medium" type="text" placeholder="username" value='' id="loginName" value=""></input>
			</div>
			<div class="line input pw">
				<div class="inputHead">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/pw.png"></img>
				</div>
				<input class="input-medium" type="password" placeholder="password" value='' id="loginPw" value=""></input>
			</div>
			<div class="line varify" 
			<?php if(!isset(Yii::app()->session['pwWrong']) || (Yii::app()->session['pwWrong'] < 3)){ ?>style="display:none"<?php } ?>>
				<div class="inputHead"></div><input class="input-small" type="text" id="varify"></input>
				<img class='varifyImg' title="click to refresh" alt="please refresh your page" 
				<?php if(!isset(Yii::app()->session['pwWrong']) || (Yii::app()->session['pwWrong'] < 3)){ ?>src=""<?php }else{ ?> src="<?php echo Yii::app()->baseUrl;?>/index.php/site/vcode"<?php } ?>></img>
			</div>
			<div class="line remMe">
				<input type="checkBox" id="remMe"></input>&nbsp;Remember me
			</div>
			<div class="line loginDiv">
				<div class="login"><?php echo t::o("login")?></div>
			</div>
			<div class="line text-error"></div>
		</div>
	</div>
	</div>

