<?php
	//检查用户是否已经登录
	class AccessControlFilter extends CFilter
	{
		public function preFilter($filterChain)
		{
			if(isset(Yii::app()->session['userId']) && 
				isset(Yii::app()->session['userName'])
			)
			{
				return true;
			}
			else
			{
				//Yii::app()->redirect(Yii::app()->baseUrl."/index.php/web/login");
				header("location:".Yii::app()->baseUrl."/index.php/web/login");
				return false;
			}
		}
		public function postFilter($filterChain)
		{
		
		}
	}
?>