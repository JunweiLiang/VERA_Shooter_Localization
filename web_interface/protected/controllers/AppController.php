<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class AppController extends Controller
{
	public $layout="";
	public $paramForLayout = array();

	public function actionIndex()
	{
		//判断角色
		$UserRole = User::getUserRole(Yii::app()->session['userId']);
		
		if($UserRole == false)
		{
			die("error");
		}
		/*
			判断用户是否管理员，或者用户
		*/
		$username = $UserRole['userName'];
		$nickname = $UserRole['nickName'] == ""?$UserRole['userName']:$UserRole['nickName'];
		if($UserRole['userLevel'] != 0)
		{
			//用户角色	
				$this->layout = "cClubSiteLayout";
				$this->render('cIndex',array(
					"username" => $username,
					"nickname" => $nickname,
					'userLevel' => $UserRole['userLevel'],
				));
			
		}
		else//管理员角色,或者什么角色都不是，用于在栏目中发文章
		{
			//先获取用户的权限，是否栏目管理员等，用于构造左半边栏
			$userId = Yii::app()->session['userId'];
			$res = User::model()->findByPK("$userId");
			$this->paramForLayout = array(
				'isUM' => $res['isUM'],				
				'isSuper' => $res['isSuper'],
			);
			$this->layout = "clubSiteLayout";
			$this->render('index');
		}
	}
	
	public function actionUserManage()
	{
		//获取该用户能管理的栏目id,即为其能授予其用户的栏目 (只要直接节点，不需要子结点)(创建该管理员时，其所管理的栏目会经过去重，即一个catalogId被另一个覆盖时，会删掉此重复)
		$isSuper = User::isSuper(Yii::app()->session['userId']);//true false;
		$this->render('userManage',array(
			"isSuper" => $isSuper,
		));
	}
	public function actionPersonalPage($id=0)
	{
		$userId = Yii::app()->session['userId'];
		if($id!=0)
		{	
			//检查$id的用户存在不存在
			$User = User::model()->findByPk($id);
			if($User == null)
			{
				echo "Hey,You!Please dont screw with the address board.A** hole.";
			}
						
		}
		else
		{
			$id = $userId;	
		}
				
				$this->render('personalPage',array(
					'id' => $id,
				));
		
	}
	//*****下面时超级管理员操作
	public function actionSuperManage()
	{
		$this->render('superManage',array(
		));
	}
	//*******************************************
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			
			'accessControl',//所有进入内部论坛都需要登录
			//后面是各种其它方法的filter(分三类角色的acition)
			//'judgeFilter',
			'managerFilter + userManage,personalPage,superManage',
			'isSuper + superManage',
			'isUM + userManage',
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
	public function filterManagerFilter($filterChain)
	{
		if(!User::isManager(Yii::app()->session['userId']))
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
		//先获取用户的权限，是否栏目管理员等，用于构造左半边栏
		$userId = Yii::app()->session['userId'];
		$res = User::model()->findByPK("$userId");
		$this->paramForLayout = array(
			'isUM' => $res['isUM'],
			'isSuper' => $res['isSuper'],			
		);
		
		$this->layout = "clubSiteLayout";
		$filterChain->run();
	}
	
	
	public function filterIsUM($filterChain)
	{
		if(!User::isUM(Yii::app()->session['userId']))
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