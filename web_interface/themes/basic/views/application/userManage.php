<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

	$this->widget('UserManageWidget',array(
 	'id' => 'userMange',
 	'getCataUrl' => Yii::app()->baseUrl."/index.php/catalog/get",
 	'getUserUrl' => Yii::app()->baseUrl."/index.php/user/get",
 	'addUserUrl' => Yii::app()->baseUrl."/index.php/user/add",
 	'changeUserUrl' => Yii::app()->baseUrl."/index.php/user/change",
 	'deleteUserUrl' => Yii::app()->baseUrl."/index.php/user/delete",
 	"resetPwUserUrl" => Yii::app()->baseUrl."/index.php/user/resetPw",
 	'ifUserNameExistsUrl' => Yii::app()->baseUrl."/index.php/user/ifUserNameExists",
 	"copyUserUrl" => Yii::app()->baseUrl."/index.php/super/daisyCopyUser",
 	'isSuper' => $isSuper,
 ));
?>

