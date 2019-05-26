<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta  http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />  
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datepicker.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datetimepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/cssReset.css"/>
    <script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.mobile.touch.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.zh-CN.js"></script>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
	<?php /*包含各种封装的函数与类*/ ?>
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/basic.js"></script>
	<title><?php echo Yii::app()->name?></title>
</head>
<body id='bodyTop'>
<style type='text/css'>
	body{
		background-color:rgb(220,220,220);
		font-family:"Microsoft YaHei",微软雅黑,宋体,Helvetica,arial;
	}
	.modal-backdrop{
		/*fixed ie7*/
		*+display:none;
	}
	
</style>


<?php echo $content; ?>
<!--
	a Chun Wai Leong's production
	contact: 2546858999@qq.com
-->
</body>
</html>