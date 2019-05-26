<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
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
<body>
<style type='text/css'>
	
	body{
		font-family:"Microsoft YaHei",微软雅黑,宋体,Helvetica,arial;
		background-color:rgb(245,245,245);
	}
	.modal-backdrop{
		/*fixed ie7*/
		*+display:none;
	}
</style>
<?php 
//这里要获取登录的用户信息给headerWIdget

$panelWidth = '140px';
//**下面应载入此user的权限数组，构造相应左边栏条数组(名称、地址)
$isUM = $this->paramForLayout['isUM'];
$isSuper = $this->paramForLayout['isSuper'];

$panelParam=array(
//	'Basic' => array('title'=>'基本操作','head'=>true),
	'index' => array('title'=>'Home','head'=>false,'active'=>false,'icon'=>'home','href'=> Yii::app()->baseUrl.'/index.php/application'),
);

if($isUM == 1)
{
	$panelParam['userManage'] = array('title'=>'userManage','head'=>false,'active'=>false,'icon'=>'user','href'=>Yii::app()->baseUrl.'/index.php/application/userManage');
}

if($isSuper == 1)
{
	//$panelParam['superManage'] = array('title'=>'superManage','head'=>false,'active'=>false,'icon'=>'wrench','href'=>Yii::app()->baseUrl.'/index.php/application/superManage');
	//$panelParam['gunshot'] = array('title'=>'gunshot','head'=>false,'active'=>false,'icon'=>'wrench','href'=>Yii::app()->baseUrl.'/index.php/application/gunshot');
	//$panelParam['notice'] = array('title'=>'documents','head'=>false,'active'=>false,'icon'=>'exclamation-sign','href'=>Yii::app()->baseUrl.'/index.php/application/notice');
}
//获取昵称
$User = User::model()->findByPk(Yii::app()->session['userId']);
if($User == null)
{
	die('error');
}
if($User->nickName == "")
{
$userName = Yii::app()->session['userName'];//这里之前必须filter过
}
else
{
$userName = $User->nickName;
}
$this->widget('ClubSiteHeaderWidget',array(
	'userName' => $userName,
	'panelParam' => $panelParam,
	'width' => $panelWidth,
	 	'showSearch' => false,
));?>


<style type="text/css">
		#leftContainer{
		position:absolute;
		top:50px;left:0;
		border-top:3px solid <?php echo COLOR1_LIGHTER1;?>;
		-moz-box-shadow:0px 0px 2px 1px #999;              
 	    -webkit-box-shadow:0px 0px 2px 1px #999;           
  		box-shadow:0px 0px 2px 1px #999;
	}
	#contentContainer{
		margin:0px 0 0 150px;
		border-top:3px solid <?php echo COLOR1_LIGHTER1;?>;
		width:830px;
		position:relative;
		height:auto!important;
		height:500px;
		min-height:500px;
		background-color:white;
		-moz-box-shadow:0px 0px 2px 1px #999;              
    -webkit-box-shadow:0px 0px 2px 1px #999;           
    box-shadow:0px 0px 2px 1px #999;
    padding-bottom:40px;
	}
</style>

<div class="wrap" style="position:relative;padding:50px 0/*for fixed header30px*/">
<div id="leftContainer">

<div class='panelDiv'>
			
			<?php
			$this->widget('ClubSitePanelWidget',array(
	'id' => 'navPanel',
	'width' => $panelWidth,//控制版的宽度
	'panelParam' => $panelParam,
));
?>
			</div>

</div><!--leftContainer-->
<?php echo '<div id="contentContainer">';//这里必须wrap,content都在leftContainer右边?>
<?php echo $content; ?>
<?php echo '</div>'//for contentContainer?>
</div><!--wrap-->
<?php 
	$this->widget('ScrollToTopWidget',array());
?>

<?php $this->widget('ClubSiteFooterWidget');?>
<!--
	a Chun Wai Leong's production
	contact: 2546858999@qq.com
-->
</body>
</html>
