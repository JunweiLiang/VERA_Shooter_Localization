<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = 'siteLayout';
	public function actionIndex($redirect="")
	{
		// the public page for showing example image
		$this->layout = NULL;
		// check whether the use has logged in
		$is_logged_in = false;
		if(isset(Yii::app()->session['userId']) && isset(Yii::app()->session['userName']))
		{
			$is_logged_in = true;
		}
		$this->render("index", array(
			"redirect" => $redirect, // redirect link append to login
			"is_logged_in" => $is_logged_in,
		));
	}
	public function actionLogin($redirect="")// can have a redirect url, after successful login will go there //$r can be urldecode and add index.php/$r
	{
		//session method:
		//设置lastLoginTime以防止单线程dos攻击,在UserController中验证
		Yii::app()->session['lastLoginTime'] = time();
		$redirect = urldecode($redirect);
		if($redirect == "")
		{
			$redirect = "application";
		}
		$this->render('login',array(
			"redirect" => $redirect
		));
	}
	public function actionVcode()//此方法直接返回vcode图像,random四位数字(不能使用，yii有多余输出?直接在根目录下使用Vcode.php)//可以使用了，万恶的config.php有BOM头!
	{
		header("Content-type:image/PNG");
		$code = sprintf("%04d",rand(1,9999));
		//设置session,在UserControllerlogin中验证 
		Yii::app()->session['vcode'] = $code;
		//打印此图像
		Yii::import("application.extensions.Vcode");
		Vcode::init($code)->printCode();
	}

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	
	public function actionRegister()
	{
		
		// TODO: add actual registering, need email verification, registration daily limit, etc.
		$this->render('register',array(
			
		));
	}
	
	
	
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'pageCheck + login,register',//已经登录的不能进入页面
		);
	}
	
	public function filterPageCheck($filterChain)
	{
		////检查cookie
		if(isset(Yii::app()->request->cookies['userName']) && isset(Yii::app()->request->cookies['pw']))
		{
			$User = User::model()->find('userName=:userName AND userPw=:userPw',array(
				':userName' => Yii::app()->request->cookies['userName']->value,
				':userPw' => Yii::app()->request->cookies['pw']->value,
			));
			if($User != NULL)
			{
				//设置session
				Yii::app()->session['userId'] = $User['userId'];
				Yii::app()->session['userName'] = $User['userName'];
				Yii::app()->session['userLevel'] = $User['userLevel'];
				$isLogin = true;
			}
			else
			{
				//清空这不正确的cookie
				unset(Yii::app()->request->cookies['userName']);
				unset(Yii::app()->request->cookies['pw']);
			}
		}
		//检查是否已经登录，已经登录就导向内部主页
		if(isset(Yii::app()->session['userId']) && isset(Yii::app()->session['userName']))
		{
			//先判断是否ajax.是ajxa就返回错误
			if(Yii::app()->request->isAjaxRequest)
			{
				die("error:already login.");
			}
			else
			{
				$this->redirect(Yii::app()->baseUrl."/index.php/application");
				die("");
			}
			
		}
		$filterChain->run();
	}
	public function actionDesigner()
	{
		//作者页
		$this->render("designer",array());
		
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', array(
					"error" => $error
				));
		}
	}

}