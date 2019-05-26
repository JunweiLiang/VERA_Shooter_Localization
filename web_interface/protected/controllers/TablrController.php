<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class TablrController extends Controller
{
	public function actionImgUpload()
	{
		$this->render('imgUpload');
	}

	// Uncomment the following methods and override them if needed
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'loginCheck',
		);
	}
	public function filterLoginCheck($filterChain)
	{
		//检查是否已经登录
		if(!isset(Yii::app()->session['userId']) || !isset(Yii::app()->session['userName']))
		{
			//先判断是否ajax.是ajxa就返回错误
			if(Yii::app()->request->isAjaxRequest)
			{
				die("error:not login.");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			
		}
		$filterChain->run();
	}
/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}