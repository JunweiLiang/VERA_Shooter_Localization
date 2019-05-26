<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	div.main{
		margin:0 auto;
		width:980px;
	}
	div.main > div.findPw{
	margin:80px 100px 200px 500px;
	border-radius:5px;
	border:1px solid silver;
	background-color:white;
	position:relative;
}
div.main > div.findPw > div.header{
	background-color:<?php echo COLOR1_LIGHTER1;?>;
	color:white;
	padding:10px 30px;
	font-size:15px;
	border-radius:5px 5px 0 0;
}
div.main > div.findPw > div.body{
	padding:20px;
	padding-bottom:30px;
}
div.main > div.findPw > div.body > div.line > div.inputHead{
	width:100px;
	float:left;
	padding-top:5px;
}
div.main > div.findPw > div.body > div.line > input{padding:0;margin-top:5px;}
div.main > div.findPw > div.body > div.line > a.findPw{
	text-decoration:none;
}
div.main > div.findPw > div.body > div.text-error{
	height:20px;
}
div.main > div.findPw > div.body > div.loginDiv{
	margin-top:5px;
}
div.main > div.findPw > div.loadingx{
	padding:30px 0;
}
</style>
<script type="text/javascript">

function showE(str)
{
	$("div.main > div.findPw > div.body.start.start > div.text-error").html(str);
	setTimeout(function(){
		$("#login > div.findPw > div.body > div.text-error").html("");
	},3000);
}
function showLoading()
{
	$("div.main > div.findPw > div.loadingx").show();
	$("div.main > div.findPw > div.body").hide();
}
function hideLoading()
{
	$("div.main > div.findPw > div.loadingx").hide();
}
//刷新验证码
$(document).delegate("div.main > div.findPw > div.body > div.line > img.varifyImg","click",function(){
	$(this).prop("src","<?php echo Yii::app()->baseUrl;?>/index.php/site/vcode?freash="+Math.random());
});
//点击确定
$(document).delegate("div.main > div.findPw > div.body.start > div.send","click",function(){
	var data = {};
	data.vcode = $("#varify").val();
	if(data.vcode != "")
	{
		data.username = "<?php echo $username?>";
		showLoading();
		$.post("<?php echo Yii::app()->baseUrl?>/index.php/user/sendPwReset",data,function(result){
			//alert(result);
			if(result.indexOf("error") >= 0)
			{
				showError();
			}
			else
			{
				showOk();
			}
		});
	}
});
function showOk()
{
	hideLoading();
	$("div.main > div.findPw > div.body").hide();
	$("div.main > div.findPw > div.ok").show();
}	
function showError()
{
	hideLoading();
	$("div.main > div.findPw > div.body").hide();
	$("div.main > div.findPw > div.error").show();
}	
</script>
<div class="main">
	<div class="findPw">
		<div class="header">找回密码: <?php echo $username?></div>
		<div class="loadingx" style="display:none">
			<div class="wrapLoading">
				<div class="loading"></div>
			</div>
		</div>
		<div class="body start">
			<div class="line vcode">
				<img class='varifyImg' title="点击刷新" alt="请刷新页面" src="<?php echo Yii::app()->baseUrl;?>/index.php/site/vcode"></img>
				<div class="inputHead">请输入验证码: </div><input class="input-small" type="text" id="varify"></input>
				
			</div>
			<div class="line">点击确定，将发送重置密码链接到此帐户的邮箱中。</div>
			<div class="text-error"></div>
			<div class="btn btn-block btn-small btn-info send">确定</div>
		</div>
		<div class="body error" style="display:none">
			邮件发送出错。由于验证码错误或者邮件地址错误或者其他原因。请刷新页面重试或者联系baoming@wkjsj.org。
			<span style="color:gray">账户邮件地址: <?php echo $email;?></span>
		</div>
		<div class="body ok" style="display:none">
			邮件发送成功，请到邮箱激活密码重置。
			<span style="color:gray">账户邮件地址: <?php echo $email;?></span>
		</div>
	</div>
</div>