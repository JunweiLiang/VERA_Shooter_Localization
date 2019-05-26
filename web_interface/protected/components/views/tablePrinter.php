<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php if($hasWrap){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<title>2014年第7届全国大学生计算机设计大赛</title>
</head>
<body>
<?php } ?>
<style type="text/css">
#tablePrinter{
	margin:0 auto;width:980px;
}
#tablePrinter > div.title{
	text-align:center;
	font-size:30px;
	font-weight:bold;
	padding:25px;
}
td{
word-break:break-all; word-wrap:normal;
}

td{max-width:200px;}
</style>
<div id="tablePrinter">
	<div class="title"><?php echo $title?></div>
	<div class="sign">评委签名:</div>
	<div class="date">2014年 &nbsp;&nbsp;月 &nbsp;&nbsp;日</div>
<table border="0px" cellpadding="25px" cellspacing="0px" width="980px" align="center" style="">
<tbody>
	<!--<div class="para">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>-->
	<tr>
		<td width="100%">
			<table border="1px" width="980px" cellpadding="5px" cellspacing="1" width="" align="center" bgcolor="#000000">
				<tbody>
				
				<?php foreach($table as $line){ ?>
					<tr bgcolor="#ffffff">
						<?php foreach($line as $one){ ?>
							<td colspan="1" align="center"><?php echo $one;?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				
				</tbody>
			</table>
		</td>
	</tr>

</tbody>
</table>
<style type="text/css">
	div.ntitle{
		padding:30px;text-align:center;
		font-weight:bold;
		font-size:30px;
		line-height:50px;
	}
	div.para{
		font-size:20px;
		padding:40px;
	}
	div.sign{
		text-align:right;
		padding:10px;
		padding-right:400px;
		padding-bottom:20px;
		font-weight:bold;
	}
	div.date{
		text-align:right;
	}
</style>
	<!--<div class="para">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>-->
	<div class="sign">评委签名:</div>
	<div class="date">2014年 &nbsp;&nbsp;月 &nbsp;&nbsp;日</div>
</div>
<?php if($hasWrap){ ?>
</body>
</html>
<?php } ?>
