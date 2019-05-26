<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class ChatController extends Controller
{
	public function actionGetSum()//long polling 方式 //此方式注意php session文件锁
	{
		//根据userId获取未读的chat消息数量
		//$i=0;//控制持续次数，现在客户端位置30秒的timeout,此程序5秒自己询一次，那么此程序最多7次循环就可以退出了，以防连接断开而服务器还是无响应的情况
		//print_r($_POST);
		//die("");
		$userId = Yii::app()->session['userId'];
		session_commit();//防止锁住！写入session文件并且释放文件锁
			//	while(true)
		for($i=0;$i<3;++$i)//
		{
			//$userId = Yii::app()->session['userId'];//php session有文件锁，不能再长轮询中使用
			$chatNum = ChatTo::model()->count("toUserId=:u AND isRead=0",array(
				":u" => $userId,
			));
			if($chatNum > 0)
			{
				$res = array(
					"chatNum" => $chatNum,
				);
				echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
				break;
			}
			else
			{
				sleep(10);//睡10秒再查看
			}			 
		}
	}
	public function actionGetSumOnce()
	{
			$userId = Yii::app()->session['userId'];
			$chatNum = ChatTo::model()->count("toUserId=:u AND isRead=0",array(
				":u" => $userId,
			));
				$res = array(
					"chatNum" => $chatNum,
				);
				echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
	}
	public function actionGetList()
	{
		//获取Yii::app()->session['userId']的所有收到的text,
		isset($_POST['startNum'])?$startNum = (int)$_POST['startNum']:$startNum=0;
		isset($_POST['feedNum'])?$feedNum = (int)$_POST['feedNum']:$feedNum=10;
		$userId = Yii::app()->session['userId'];
		$res = array();
		$db = Yii::app()->db;
		try{
		$sqlcmd = "SELECT t.userId,T_user.userName,T_user.nickName,t.id AS chatTextId,t.text,t.createTime FROM ".
			"T_chatText as t,T_user WHERE t.id = (".//相当于取了每个人发给session['userId']的最大的再取
				"SELECT max(T_chatText.id) FROM T_chatText,T_chatTo WHERE T_chatTo.toUserId=:me AND T_chatTo.chatTextId=T_chatText.id AND T_chatText.userId=t.userId ".
			" ) AND t.userId=T_user.userId ORDER BY t.id DESC LIMIT ".$startNum.",".$feedNum;
		$command = $db->createCommand($sqlcmd);
		$command->bindParam(":me",$userId,PDO::PARAM_INT);
		$res = $command->queryAll();
		foreach($res as &$one)
		{
			//修改isRead,//不修改isRead,点击了对话才去修改.
			//修改userName
			if($one['nickName'] != "")
			{
				$one['userName'] = $one['nickName'];
				unset($one['nickName']);
			}
		}
		}catch(Exception $e)
		{
			//die($e->getMessage());
			die("[]");
		}
	/*	$ChatTextList = ChatTo::model()->findAll("toUserId =:u ORDER BY chatTextId DESC LIMIT ".$startNum.",".$feedNum,array(
			":u" => $userId,
		));
		foreach($ChatTextList as $one)
		{
			$temp = array();
			$ChatText = ChatText::model()->findByPk($one->chatTextId);
			if($ChatText!=NULL)
			{				
				$User = User::model()->findByPk($ChatText->userId);
				if($User!=NULL)
				{
					$temp['chatTextId'] = $ChatText->id;
					$temp['userId'] = $ChatText->userId;
					$temp['text'] = $ChatText->text;
					$temp['createTime'] = $ChatText->createTime;
					$temp['userName'] = $User->nickName == ""?$User->userName:$User->nickName;
					$res[] = $temp;
					//获取到就把isread设为1
					$one->isRead = 1;
					$one->save();
				}//user null
			}//chattext NUll
		}//foreach*/
		echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
	}
	public function actionGetChat()
	{
		//以后这里要写保护，防止被疯狂获取
		//获取session['userId']与post userId的聊天列表，暂时一次全部获取,
		//每个数据块标记me=1
		if(isset($_POST['userId']))
		{
			$db = Yii::app()->db;
			$u1 = $_POST['userId'];
			$u2 = Yii::app()->session['userId'];
			$sqlcmd = "SELECT T_chatText.text,T_chatText.createTime,T_chatText.userId,T_chatTo.id AS chatToId FROM T_chatText,T_chatTo WHERE T_chatTo.chatTextId=T_chatText.id AND".
				" ((T_chatText.userId=:u1 AND T_chatTo.toUserId=:u2) OR".
				" (T_chatText.userId=:u2 AND T_chatTo.toUserId=:u1)) ORDER BY T_chatText.id DESC";
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":u1",$u1,PDO::PARAM_INT);
			$command->bindParam(":u2",$u2,PDO::PARAM_INT);
			$res = $command->queryAll();
			//标记是自己的话
			foreach($res as &$one)
			{
				if($one['userId'] == $u2)
				{
					$one['me'] = 1;
				}
				else//不是自己说的，才标记isRead
				{
					$one['me'] = 0;
					//修改isRead
					$ChatTo = ChatTo::model()->findByPk($one['chatToId']);
					if($ChatTo->isRead == 0)
					{
						$ChatTo->isRead=1;
						$ChatTo->save();
					}
				}
				
			}
			echo Text::json_encode_ch($res,JSON_UNESCAPED_UNICODE);
		//	echo $u1." ".$u2;
		}
	}
	public function actionSay()
	{
		//session[userId]对post toUserid说话
		if(isset($_POST['toUserId']) && isset($_POST['say']) && ($_POST['say'] != ""))
		{
			//以后这里检查toUserId的存在性?//检查！参赛者可能乱来
			$User = User::model()->findByPk($_POST['toUserId']);
			if($User != NULL)
			{
				$userId = Yii::app()->session['userId'];
				$toUserId = $_POST['toUserId'];$text = $_POST['say'];
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try{
					$ChatText = new ChatText();
					$ChatText->userId = $userId;
					$ChatText->text = $text;
					$ChatText->createTime = new CDbExpression("NOW()");
					if(!$ChatText->save())
					{
						throw new Exception("a");
					}
					$ChatTo = new ChatTo();
					$ChatTo->toUserId = $toUserId;
					$ChatTo->chatTextId = $ChatText->id;
					if(!$ChatTo->save())
					{
						throw new Exception("a");
					}
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					die("eror");
				}
				echo "ok";
			}//user not null
		}// isset
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',//所有方法都需要登
			//后面是各个方法的filter
		);
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