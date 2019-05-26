<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	
class NoticeController extends Controller
{
	public function actionGet($noticeId=0)
	{
		//die($noticeId);
		if($noticeId == 0)
		{
			$data = array();
			$NoticeAll = Notice::model()->findAll();
			foreach($NoticeAll as $one)
			{
				$data[] = $one->attributes;
			}
			echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
		}else
		{
			$Notice = Notice::model()->findByPk($noticeId);
			if($Notice != NULL)
			{
				echo $Notice->content;
			}
		}
	}
	public function actionSet()
	{
		// print_r($_POST);
		//旧的整体保存的方法
		/*
		if(!empty($_POST['notice']))
		{
			foreach($_POST['notice'] as $one)
			{
				if(isset($one['noticeId']) && isset($one['content']))
				{
					$Notice = Notice::model()->findByPk($one['noticeId']);
					if($Notice != null)
					{
						$Notice->content = $one['content'];
						$Notice->save();
					}
				}
			}
			echo "ok";
		}
		*/
		//print_r($_POST);
		if(isset($_POST['noticeId']) && isset($_POST['notice']))
		{
					$Notice = Notice::model()->findByPk($_POST['noticeId']);
					if($Notice != null)
					{
						$Notice->content = $_POST['notice'];
						$Notice->save();
					}
					echo "ok";
		}
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			
			'accessControl',//所有进入内部论坛都需要登录		
			'isSuper + get,set',
			
		);
	}
	public function filterAccessControl($filterChain)
	{
		if(!isset(Yii::app()->session['userId']) || !isset(Yii::app()->session['userName']))
		{
			//不可能是ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
					die("error:f**k.");			
			}
		}
		$filterChain->run();
	}
	public function filterIsSuper($filterChain)
	{
		if(!User::isSuper(Yii::app()->session['userId']))
		{
			//非ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且ajax请求则rediret回外部门户主页
			{
				die("error:f**k.");			
			}
		}
		$filterChain->run();
	}
}
?>