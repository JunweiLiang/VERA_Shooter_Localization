<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>

<style type="text/css">
	input[type="radio"]{margin:0;}
	input[type="text"]{background-color:white}
	#reg{
		width:980px;
		margin:0 auto;
		padding:20px 0;
	}
	#reg > div.notice ,#reg > div.regForm{
		background-color:white;
		border:1px solid silver;
		border-radius:5px;
		margin-bottom:20px;
		padding:20px;
	}
	#reg > div.regForm{
		padding:140px 10px;
		line-height: 40px;
	}
	#reg > div.regForm > form > div.title{
		padding:0px 20px;
		border-left:4px solid <?php echo COLOR1_LIGHTER1;?>;
		font-size:15px;
		font-weight:bold;
		margin-bottom:15px;
	}
	#reg > div.regForm > form > div.line{
		
	}
	#reg > div.regForm > form > div.line > div.left{
		float:left;
		width:80px;
		color:gray;
	}
	#reg > div.regForm > form > div.line > div.right{
		margin:0 0 0 80px;
		position:relative;
		height:40px;
	}
	#reg > div.regForm > form > div.line > div.right > div.block{
		/*单选框*/
		float:left;
		padding-right:40px;
	}
	
	#reg > div.regForm > form > div.line > div.right > div.tailNotice{
		position:absolute;
		top:5px;
		left:240px;
	}
	#reg > div.regForm > form > div.catalog > div.right > select{
		width:350px;
	}
	#reg > div.regForm > form > div.catalog > div.right > div.tailNotice{
		position:absolute;
		top:5px;
		left:380px;
	}
	#reg > div.regForm > form > div.line.error{
		color:red;
	}
</style>
<script type="text/javascript">
	
</script>
<div id="reg">
	<div class="regForm">
		Please send an email with the title "Account Request for the DAISY System" to junweil@cs.cmu.edu to request an account.
		<br/>
		Please state your organization and the size of the video dataset you plan to run our system on. We will provide you with an account within two business days.
		<br/>
		<a class="btn btn-primary" href="<?php echo Yii::app()->baseUrl?>">Back to Main Page</a>
	</div>
</div>