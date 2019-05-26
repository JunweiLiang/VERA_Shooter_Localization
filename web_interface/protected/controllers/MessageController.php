<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

class MessageController extends Controller
{
	public function actionGetCT()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['userId']))
		{
			//检查userId是不是自己
			if($_POST['userId'] != Yii::app()->session['userId'])
			{
				die('error');
			}
			$Message = Message::model()->findAll('userId=:userId AND type=1 ORDER BY messageId DESC',array(':userId'=>$_POST['userId']));
			$data = array();
			
			foreach($Message as $line)//遍历每一个审核 提醒//（你的文章＊＊ （提交至＊＊ ）已经通过审核／未通过审核）
			{
				$temp = array();
				$checkId = $line['underId'];
				$CheckText = CheckText::model()->findByPk($checkId);
				if(($CheckText == null) || ($CheckText->isCopyTo == 1) || ($CheckText->checkStatus == 0))//抄送文章不提醒！
				{
					die('error');
				}
				$catalogId = $CheckText->catalogId;
				$Cata = Catalog::model()->findByPk($catalogId);
				if($Cata == null || $Cata->hasText == 0)
				{
					die('error');
				}
				
				$textId = $CheckText->textId;
				$Text = Text::model()->find('textId=:textId ORDER BY editTime DESC',array(':textId'=>$textId));
				if(($Text == null) || ($Text->authorId != Yii::app()->session['userId']))
				{
					die('error');
				}
				//die('hi');
				$temp['textTitle'] = $Text->title;
				//$temp['textId'] = $Text->textId;
				$temp['checkTime'] = $CheckText->checkTime;
				$temp['catalogTitle'] = $Cata->catalogTitle;
				$temp['checkStatus'] = $CheckText->checkStatus;
				$data[] = $temp;
				//返回的所有信息都标记已读
				$line->isRead = 1;
				$line->save();
			}
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			$status = true;
		}
		if(!$status)
		{
			die('error');
		}
	}
	
	public function actionReadMes()
	{
	//	print_r($_POST);
		$status = false;
		if(isset($_POST['mId']) && isset($_POST['textId']))//textId 是回传参数
		{
			$Mes = Message::model()->findByPk($_POST['mId']);
			if($Mes == null)
			{
				die('error');
			}
			if($Mes->userId != Yii::app()->session['userId'])
			{
				die('error');
			}
			$Mes->isRead = 1;
			$Mes->save();
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch(array(
				'textId' => $_POST['textId'],
			));
		//	echo Text::json_encode_ch(,JSON_UNESCAPED_UNICODE);
			$status = true;
		}
		if(!$status)
		{
			die('error');
		}
	}
	public function actionGetCom()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['userId']))
		{
			//检查userId是不是自己
			if($_POST['userId'] != Yii::app()->session['userId'])
			{
				die('error');
			}
			$Message = Message::model()->findAll('userId=:userId AND type=0 ORDER BY messageId DESC',array(':userId'=>$_POST['userId']));
			$data = array();
			foreach($Message as $line)//遍历每一个评论提醒
			{
				//获取com
				$temp = array();
				$comId = $line['underId'];
				$Com = Comment::model()->findByPk($comId);
				if($Com->comType == 0)//文章评论
				{
					//获取评论者
					$User = User::model()->findByPk($Com->userId);
					if($User->userId == Yii::app()->session['userId'])
					{
						die('error');//逻辑出错，评论者为本人（评论给自己）不可能出现在提醒中
					}
					//获取文章作者
					$Text = Text::model()->find('textId=:textId',array(':textId' => $Com->underId));
					
					if($Text == null)
					{
						continue;//文章已经被删除？
					}
					$authorId = $Text->authorId;
					if($authorId == Yii::app()->session['userId'])//本人文章下的提醒(***回复了你的文章**:"..")
					{
						$temp['isOwnText'] = 1;
						/*$temp['commerId'] = $Com->userId;
						$temp['commerName'] = ($User->nickName == '')?$User->userName:$User->nickName;
						$temp['textId'] = $Text->textId;
						$temp['textTitle'] = $Text->title;
						$temp['comTime'] = $Com->comTime;
						$temp['isRead'] = $Com->isRead;*/
					}
					else//别人的文章中回复了我(***在文章***下回复了你:"..")
					{
						//检查一下toWHomId是否为我，不然就是逻辑出错了
						if(Yii::app()->session['userId'] != $Com->toWhomId)
						{
							die('error');
						}
						$temp['isOwnText'] = 0;

						/*$temp['commerId'] = $Com->userId;
						$temp['commerName'] = ($User->nickName == '')?$User->userName:$User->nickName;
						$temp['textId'] = $Text->textId;
						$temp['textTitle'] = $Text->title;
						$temp['comTime'] = $Com->comTime;
						$temp['isRead'] = $Com->isRead;*/
					}
						$temp['comContent'] = $Com->content;
						$temp['commerId'] = $Com->userId;					
						$temp['commerName'] = ($User->nickName == '')?$User->userName:$User->nickName;
						$temp['textId'] = $Text->textId;
						$temp['textTitle'] = $Text->title;
						$temp['comTime'] = $Com->comTime;
						$temp['isRead'] = $line['isRead'];
						$temp['mId'] = $line['messageId'];
					$data[] = $temp;
				}
			}
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			$status = true;
		}
		if(!$status)
		{
			die('error');
		}
	}

	public function actionGetSum()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['userId']))
		{
			$data = array(
				'comNum' => 0,
				'ctNum' => 0,
			);
			$Message = Message::model()->findAll('userId=:userId AND isRead=0',array(':userId'=>$_POST['userId']));
			foreach($Message as $line)
			{
				if($line['type'] == 0)
				{
					$data['comNum']++;
				}
				else if($line['type'] == 1)
				{
					$data['ctNum']++;
				}
			}
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			$status = true;
		}
		if(!$status)
		{
			die('error');
		}
	}
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
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl'//所有方法都需要登录
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
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

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