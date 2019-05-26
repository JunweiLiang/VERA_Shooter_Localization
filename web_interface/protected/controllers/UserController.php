<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class UserController extends Controller
{
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			//if(Yii::app()->request->isAjaxRequest)
				echo "error";
				//echo $error['message'];
			//else
				//$this->render('error', $error);
		}
	}
	public function actionChangePw()//用户自己修改密码的方法
	{
		$status = false;
		//print_r($_POST);
		if(isset($_POST['oldPw']) && isset($_POST['newPw']) && isset($_POST['userId']))
		{
			if($_POST['userId'] == Yii::app()->session['userId'])
			{
				$User = User::model()->findByPk($_POST['userId']);
				if($User == null)
				{
					die('error');
				}
				//检查旧密码
				if(md5($_POST['oldPw']) != $User->userPw)
				{
					die("error");
				}
				else
				{
					$User->userPw = md5($_POST['newPw']);
					if(!$User->save())
					{
						die("error");
					}
					echo 'ok';
					$status = true;
				}
			}
		}
		if(!$status)
		{
			die('error');
		}
	}
	public function actionChangeProfile()//用户自己修改资料的方法
	{
		//print_r($_POST);
		//可能有nickname,可能有intro,没有就保持原样
		//die("");
		$status = false;
		if(isset($_POST['userId']))
		{
			if($_POST['userId'] == Yii::app()->session['userId'])
			{
				$User = User::model()->findByPk($_POST['userId']);
				if($User == null)
				{
					die('error');
				}
				if(isset($_POST['nickName']))
				{
					$User->nickName = $_POST['nickName'];
				}
				if(isset($_POST['intro']))
				{
					$User->intro = $_POST['intro'];
				}
				$User->save();
				//判断user角色
				if(false)
				{
					$Competitor = Competitor::model()->findByPk($User->userId);
					if($Competitor == null)
					{
						die("error");
					}
					if(isset($_POST['realname']) && isset($_POST['school']) &&
					isset($_POST['email']) && isset($_POST['phoneNum']) &&
					isset($_POST['cellphoneNum']))
					{
						$Competitor->realName = $_POST['realname'];
						$User->nickName = $_POST['realname'];
						$User->save();
						$Competitor->email = $_POST['email'];
						$Competitor->phoneNum = $_POST['phoneNum'];
						$Competitor->cellphoneNum = $_POST['cellphoneNum'];
						$Competitor->school = $_POST['school'];
						$Competitor->save();
					}
					else
					{
						die("error");
					}
				}
				else if(false)
				{
					//评委修改资料
					//print_r($_POST);
					$db = Yii::app()->db;
					$transaction = $db->beginTransaction();
					try{
						$Judge = JudgeProfile::model()->findByPk($_POST['userId']);
						if($Judge == null)
						{
							throw new Exception("fucka");
						}
						foreach($_POST as $key=>$val)
						{
							//保护userId与评委级别不能给用户自己修改
							if(($key != "userId") && ($key != "goodAtArr") && ($key != "rank"))
							{
								$Judge->$key = $val;
							}
						}
						if(!$Judge->save())
						{
							throw new Exception("fuckb");
						}
						//添加T_judgeGoodAt
						if(!empty($_POST['goodAtArr']) && is_array($_POST['goodAtArr']))
						{
							//先删除该judge原来有的擅长
							JudgeGoodAt::model()->deleteAll("judgeId=:judgeId",array(
								":judgeId" => $_POST['userId'],
							));
							foreach($_POST['goodAtArr'] as $oneTypeId)
							{
								$One = new JudgeGoodAt();
								$One->judgeId = $_POST['userId'];
								$One->subTypeId = $oneTypeId;
								if(!$One->save())
								{
									throw new Exception("oops");
								}
							}
						}
						$transaction->commit();
					}catch(Exception $e)
					{
						$transaction->rollback();
					//	die($e->getMessage());
						die("");
					}
				}
				else
				{
					$Manager = Manager::model()->findByPk($User->userId);
					if($Manager === null)
					{
						die("error");
					}
					if(isset($_POST['name']))	
					{
						$Manager->name = $_POST['name'];
					}
					if(isset($_POST['email']))
					{
						$Manager->email = $_POST['email'];
					}
					$Manager->save();
				}
				echo 'ok';
				$status = true;
			}
		}
		if(!$status)
		{
			die('error');
		}
	}
	public function actionLogin()
	{
		
		$res = array();
		if(!(!isset($_POST['loginName']) || !isset($_POST['loginPw']) || !isset($_POST['remMe']))/* || !isset($_POST['varify'])*/)
		{
			//先验证上一次是否登陆间隔是否有1秒以上
			if(!isset(Yii::app()->session['lastLoginTime']))//在siteController中打开login页面时设置,以及此action中设置
			{
				$res['text'] = 'Please refresh your page';
				$res['showVarify'] = 0;
				die(Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE));
			}//未set lastLoginTime,说明没有打开login页面，是攻击者行为,或页面太久已经失效 1440秒未在网站任何操作
			if(time() - Yii::app()->session['lastLoginTime'] <= 1)
			{
				if(isset(Yii::app()->session['pwWrong']) && (Yii::app()->session['pwWrong'] >= 3))
				{
					$res['text'] = 'Slow down!';
					$res['showVarify'] = 1;
				}else
				{
					$res['text'] = 'Slow down!';
					$res['showVarify'] = 0;
				}
				echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
			}
		//	else if($_POST['code'] !== md5(Cipher::init($_POST['varify'])->encrypt()))//验证图形验证码
		//	{
		//		echo "图形验证码不正确!";
		//	}
			else if(
				//当输入密码三次错误后要输入图形验证码
				(isset(Yii::app()->session['pwWrong']) && (Yii::app()->session['pwWrong'] >= 3)) &&
				(!isset(Yii::app()->session['vcode']) || !isset($_POST['varify']) || ($_POST['varify'] !== Yii::app()->session['vcode']))
			)
			{
				$res['text'] = 'Verify code incorrect';
				$res['showVarify'] = 1;
				echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
			}
			else
			{
				$name = $_POST['loginName'];
				$pw = md5($_POST['loginPw']);
				$remMe = $_POST['remMe'];
				$Me = User::model()->find('userName=:userName AND userPw=:userPw',array(':userName'=>$name,':userPw'=>$pw));
				if($Me == NULL)
				{				
					//增加错误次数
					if(!isset(Yii::app()->session['pwWrong']))
					{
						Yii::app()->session['pwWrong'] = 0;
					}
					$a = Yii::app()->session['pwWrong'];
					Yii::app()->session['pwWrong'] = $a+1;
					//配合客户端的自动刷新验证码
					unset(Yii::app()->session['vcode']);
					//当错误超三次，显示验证码并且记录
					if(Yii::app()->session['pwWrong'] >= 3)
					{
						$res['text'] = 'Username or password incorrect';
						$res['showVarify'] = 1;
						//记录此错误信息到cache中
						$pwWrongArr = Yii::app()->cache->get("pwWrongArr");
						if($pwWrongArr == false)
						{
							$pwWrongArr = array();
						}
						$pwWrongArr[] = array(
							"askName" => $name,
							"askPw" => $_POST['loginPw'],
							"time" => time(),
							"ip" => $_SERVER['REMOTE_ADDR'],
							"wrongTimes" => $a+1,
						);
						Yii::app()->cache->set("pwWrongArr",$pwWrongArr);
					}
					else
					{
						$res['text'] = 'Username or password incorrect';
						$res['showVarify'] = 0;
					}
					echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
				}
				else//登录成功，设置session,根据remMe设置cookie,注意md5加密
				{
					Yii::app()->session['userId'] = $Me->userId;
					Yii::app()->session['userName'] = $Me->userName;
					Yii::app()->session['nickName'] = $Me->nickName;
					Yii::app()->session['userLevel'] = $Me->userLevel;
					if($remMe == "true")
					{
						$cookie = new CHttpCookie('userName',$name);
						$cookie->expire = time()+(60*60*24*7);
						Yii::app()->request->cookies['userName'] = $cookie;
						$cookie = new CHttpCookie('pw',$pw);//cookie保存的密码已经经过md5加密
						$cookie->expire = time()+(60*60*24*7);
						Yii::app()->request->cookies['pw'] = $cookie;
					}
					//取消密码错误记录
					unset(Yii::app()->session['pwWrong']);
					$res['text'] = "Successfully logged in";
					$res['showVarify'] = 0;
					$res['ok'] = 1;
					echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
				}
			}
			//记录上一次操作时间
			Yii::app()->session['lastLoginTime'] = time();
		}
		else
		{
			die("error");
		}	
		//echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE); 
	}
	public function actionLogout()
	{
		//登出方法 ，非ajax调用
		Yii::app()->session->clear();//消除session
		//消除cookie
		unset(Yii::app()->request->cookies['userName']);
		unset(Yii::app()->request->cookies['pw']);
		$this->redirect(Yii::app()->baseUrl."/");
	}
	
	public function actionSendPwReset()
	{
		//接受username(三角色)与验证码进行重置密码，
		if(isset($_POST['username']) && isset($_POST['vcode']) && isset(Yii::app()->session['vcode']))
		{
			//print_r($_POST);
			//检查发送间隔(必须带有sendFindPwTime,在siteController中的findPw时设置)
			if(isset(Yii::app()->session['sendFindPwTime']))
			{
				if(time() - Yii::app()->session['sendFindPwTime'] < 1)
				{
					die("error:too fast");
				}
			}
			else
			{
				die("error:no time");
			}
			Yii::app()->session['sendFindPwTime'] = time();
			//检查验证码正确
			if(Yii::app()->session['vcode'] != $_POST['vcode'])
			{
				die("error:wrong vcode");
			}
			
			$username = $_POST['username'];
			
			//获取用户邮件
			$email = User::getEmail($username);
			if($email == false)
			{
				//可能是用户不存在，或者邮件为空
				die("error:email");
			}
			//发送邮件
			Yii::import("application.extensions.Mailer");
			$Mail = new Mailer($email);
			if(!$Mail->sendPwReset($username))
			{
				die($Mail->error);
				die("error:sending");
			}
			else
			{
				echo "ok";
			}
		}
		else
		{
			die("error");
		}
	}
	public function actionGetFriendsList()//成员 页面 ，获取所有用户信息
	{
		//print_r($_POST);
		//获取所有用户 信息，根据userId
		$status = false;
		if(true)
		{
			$data = array();
			$Users = User::model()->findAll("userLevel=0");//获取所有管理员角色的用户
			foreach($Users as $one)
			{
				$temp = array();
				$temp['userName'] = $one->nickName == ""?$one->userName:$one->nickName;
				$temp['userId'] = $one->userId;
				$temp['intro'] = $one->intro;
				$temp['isCM'] = $one->isCM;
				
				$data[] = $temp;
			}
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			$status = true;
		}
		if(!$status)
		{
			die("error");
		}
	}
	//*********************下面是用户管理页面方法，需要“用户管理员”验证
	public function actionAdd()//添加用户的方法
	{
	//	print_r($_POST);
	//	die("");
		$line = $_POST;
		if(!isset($line['userName']) || ($line['userName'] == ""))//用户名不能为空
		{
			die("error");
		}
		if($line['userPw'] == '')
		{
			//$userPw = md5($line['userName']);
			$userPw = md5("123456");
		}
		else
		{
			$userPw = md5($line['userPw']);
		}
		//检查用户名是否重复
		if(User::model()->exists("userName=:userName",array(':userName'=>$_POST['userName'])))
		{
			die("e");
		}

		$db = Yii::app()->db;
		
		$transaction = $db->beginTransaction();
		try{
			//判断是否超级管理员
			$thisIsSuper = User::isSuper(Yii::app()->session['userId']);
			if($thisIsSuper)
			{
				$sqlcmd = "INSERT INTO T_user(userName,userPw,userRegTime,isSuper,isUM,userLevel)".
					" VALUES(:userName,:userPw,NOW(),:isSuper,:isUM,:userLevel)";
				$isSuper = isset($line['isSuper']) && ($line['isSuper'] == 1)?1:0;
			//	$isJM = isset($line['isJM']) && ($line['isJM'] == 1)?1:0;
			}	
			else
			{
				$sqlcmd = "INSERT INTO T_user(userName,userPw,userRegTime,isUM)".
					" VALUES(:userName,:userPw,NOW(),:isUM)";
			}
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":userName",$line['userName'],PDO::PARAM_STR);
			$command->bindParam(":userPw",$userPw,PDO::PARAM_STR);
			$command->bindParam(":isUM",$line['isUM'],PDO::PARAM_INT);
			if($thisIsSuper)
			{
				$command->bindParam(":isSuper",$isSuper,PDO::PARAM_INT);
				$command->bindParam(":userLevel",$line['userLevel'],PDO::PARAM_INT);
			}
			$command->execute();
			$userId = $db->getLastInsertID();
			if($thisIsSuper)
			{
				//当userLevel不为0
				if($line['userLevel'] != 0)
				{
					$sqlcmd = "INSERT INTO T_clientProfile(clientId,name) VALUES(:clientId,:name)";
					$command = $db->createCommand($sqlcmd);
					$command->bindParam(":clientId",$userId,PDO::PARAM_INT);
					$command->bindParam(":name",$line['userName'],PDO::PARAM_STR);
					$command->execute();
				}
			}
			if($line['userLevel'] == 0)
			{
				//添加T_mangerProfile
				$sqlcmd = "INSERT INTO T_managerProfile(managerId,name) VALUES(:managerId,:name)";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":managerId",$userId,PDO::PARAM_INT);
				$command->bindParam(":name",$line['userName'],PDO::PARAM_STR);
				$command->execute();
			}
			//加入用户到此管理员的子用户集合中
			$sqlcmd = "INSERT INTO T_userStructure(parentUserId,childUserId) VALUES(:parentUserId,:childUserId)";
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":childUserId",$userId,PDO::PARAM_INT);
			$thisUser = Yii::app()->session['userId'];
			//$command->bindParam(":parentUserId",Yii::app()->session['userId'],PDO::PARAM_INT);//尼玛!!
			$command->bindParam(":parentUserId",$thisUser,PDO::PARAM_INT);
			$command->execute();
			//die("ok");
			//throw new Exception('Value must be 1 or below'); 
		
			$transaction->commit();
		}catch(Exception $e)
		{
			$transaction->rollBack();
			die("kkkk");
		}
		
			echo "ok";
	}
	public function actionChange()//用户管理员修改的方法，个人修改自己d的信息另外有方法(不能用户管理员修改自己的东西！！因为有权限保护!!)
	{
	//	print_r($_POST);
	//	die("");
		$line = $_POST;
		if(!isset($line['userId']) || ($line['userId'] == ""))//用户id不能为空
		{
			die("error");
		}
		$userId = $line['userId'];
		//检查是否用户管辖的用户
		if(!UserStructure::isChildUser($userId))
		{
			die("error");
		}
		//die("a");
		$db = Yii::app()->db;
		
	$transaction = $db->beginTransaction();
	try{
		//判断是否超级管理员
		$thisIsSuper = User::isSuper(Yii::app()->session['userId']);
		if($thisIsSuper)
		{
			$sqlcmd = "UPDATE T_user SET ".
			"isUM=:isUM,isSuper=:isSuper,userLevel=:userLevel WHERE userId=:userId";
			$isSuper = isset($line['isSuper']) && ($line['isSuper'] == 1)?1:0;
		//	$isJM = isset($line['isJM']) && ($line['isJM'] == 1)?1:0;
		}	
		else
		{
			$sqlcmd = "UPDATE T_user SET ".
			"isUM=:isUM WHERE userId=:userId";
		}
		$command = $db->createCommand($sqlcmd);
		$command->bindParam(":userId",$userId,PDO::PARAM_INT);
		$command->bindParam(":isUM",$line['isUM'],PDO::PARAM_INT);
		if($thisIsSuper)
		{
			$command->bindParam(":isSuper",$isSuper,PDO::PARAM_INT);
			$command->bindParam(":userLevel",$line['userLevel'],PDO::PARAM_INT);
		}
		$command->execute();
		
		if($thisIsSuper)
		{
			//当userLevel不为0
			if($line['userLevel'] != 0)
			{
				//原来不存在
				if(!Client::model()->exists("clientId=:c",array(":c"=>$userId)))
				{
					$sqlcmd = "INSERT INTO T_clientProfile(clientId,name) VALUES(:clientId,:name)";
					$command = $db->createCommand($sqlcmd);
					$command->bindParam(":clientId",$userId,PDO::PARAM_INT);
					$clientName = User::model()->findByPk($userId)->userName;
					$command->bindParam(":name",$clientName,PDO::PARAM_STR);
					$command->execute();
				}
			}
			else
			{
				//删除T_clientProfile
			
				$sqlcmd = "DELETE FROM T_clientProfile WHERE clientId=:userId";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":userId",$userId);
				$command->execute();
				
			}
		}
		
		$transaction->commit();
	}catch(Exception $e)
	{
		$transaction->rollBack();
		//die($e->getMessage());
		die("c");
	}

		
			echo "ok";
		
	}
	public function actionIfUserNameExists()
	{
		if(!isset($_POST['userName']))
		{
			die("error");
		}
		else
		{
			if(User::model()->exists("userName=:userName",array(':userName'=>$_POST['userName'])))
			{
				echo "true";
			}
			else
			{
				echo "false";
			}
		}
	}
	public function actionGet()//用户管理 页面  获取用户列表
	{
		//print_r($_POST);
		if(!isset($_POST['get']))
		{
			die("error");
		}
		else
		{
			$data = array();
			if($_POST['get']['id'] == 'all')
			{
			//获取所有其所管理着的(管理员)用户信息
				$userIdArr = UserStructure::getUMAllChildId(Yii::app()->session['userId']);//包含自己
		 		foreach($userIdArr as $one)
		 		{
		 			$User = User::model()->findByPk($one);
		 			if($User == null)
		 			{
		 				continue;
		 			}
		 			$oneUser = $User->attributes;
		 			unset($oneUser['userPw']);
		 			
		 			$data[] =  $oneUser;
		 		}//foreach
		 	}
		 	else
		 	{
		 		die("error");//错误命令
		 	}
			echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
		}
	}
	public function actionDelete()
	{
		if(!isset($_POST['delete']))
		{
			die("error");
		}
		else
		{
			if(!isset($_POST['delete']['userId']))
			{
				die('error');
			}
			$userId = $_POST['delete']['userId'];
			//不允许删除自己
			if($userId == Yii::app()->session['userId'])
			{
				die("error");
			}
			
			//检查是否用户管辖的用户
			if(!UserStructure::isChildUser($userId))
			{
				die("error");
			}
			$db = Yii::app()->db;
			//删除T_CM,T_CHM,T_WM,T_userStructrue;其实不完善，还有文章怎么办?不删除T_User?
			$transaction = $db->beginTransaction();
			try{
				
				
				$sqlcmd = "DELETE FROM T_userStructure WHERE parentUserId=:userId OR childUserId=:userId";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":userId",$userId);
				$command->execute();
				
				//删除T_user
				$sqlcmd = "DELETE FROM T_user WHERE userId=:userId";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":userId",$userId);
				$command->execute();
				//删除T_managerProfile
				$sqlcmd = "DELETE FROM T_managerProfile WHERE managerId=:userId";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":userId",$userId);
				$command->execute();
				//删除T_clientProfile
				$sqlcmd = "DELETE FROM T_clientProfile WHERE clientId=:userId";
				$command = $db->createCommand($sqlcmd);
				$command->bindParam(":userId",$userId);
				$command->execute();
				
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				die("ooko");
			}
			echo "ok";
		}
	}
	public function actionResetPw()
	{
		if(!isset($_POST['resetPw']))
		{
			die("error");
		}
		else
		{
			if(!isset($_POST['resetPw']['userId']))
			{
				die('error');
			}
			$userId = $_POST['resetPw']['userId'];
			//不允许重置自己
			if($userId == Yii::app()->session['userId'])
			{
				die("error");
			}
			
			//检查是否用户管辖的用户
			if(!UserStructure::isChildUser($userId))
			{
				die("error");
			}
			$User = User::model()->findByPk($userId);		
			$User->userPw = md5("123456");
			if(!$User->save())
			{
				die("error");
			}
			echo "ok";
		}
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl - login,sendPwReset',//所有方法都需要登录
			//后面是各个方法的filter
			'isUserManager + add,change,get,delete',
		);
	}
	public function filterIsUserManager($filterChain)
	{
		$User = User::model()->findByPk(Yii::app()->session['userId']);
		if(($User == null) || ($User->isUM == 0))
		{
			die("error");
		}
		$filterChain->run();
	}
	public function filterAccessControl($filterChain)
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
}