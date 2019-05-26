<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

class SiteWidgetController extends Controller
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
	//此控制器下只能是get数据
	//不需检查 登陆
	

	public function actionTextFeed()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['catalogId']) && isset($_POST['startFeedId']) && isset($_POST['feedNum']))
		{
			//检查catalogId 是否公开栏目
			$Cata = Catalog::model()->findByPk($_POST['catalogId']);
			if(($Cata == null) || ($Cata->isPublic == 0))
			{
				die("error");
			}
			$db = Yii::app()->db;
			/*if($_POST['feedNum']!=0)
			{
				$sqlcmd = "SELECT * FROM T_cHomeFeed WHERE feedId > '".$_POST['startFeedId']."' AND catalogId = '".$_POST['catalogId']."' Limit 0,".$_POST['feedNum'];
			}
			else
			{
				$sqlcmd = "SELECT * FROM T_cHomeFeed WHERE feedId > '".$_POST['startFeedId']."' AND catalogId = '".$_POST['catalogId']."'";
			}*///数量在后面限制 
			$sqlcmd = "SELECT * FROM T_cHomeFeed WHERE feedId > '".$_POST['startFeedId']."' AND catalogId = '".$_POST['catalogId']."'";
			$res = $db->createcommand($sqlcmd)->query();
			$data = array();
			
			$i=0;
			foreach($res as $line)
			{
				if($_POST['feedNum']!=0)
				{
					if($i >= $_POST['feedNum'])
					{	
						break;
					}
				}
				//print_r($line);
				$temp = array();
				$temp = $line;
				//获取原文栏目标题????????应该获取T_checkText  的catalogId
			//	$Text = Text::model()->find('textId=:textId ORDER BY editTime DESC',array(':textId' => $line['textId']));
				$CheckText = CheckText::model()->findByPk($line['checkId']);
				$Cata = Catalog::model()->findByPk($CheckText->catalogId);
				$temp['catalogTitle'] = $Cata->catalogTitle;
				$temp['catalogId'] = $Cata->catalogId;
				if($_POST['textCataId'] != 0)
				{
					if($_POST['textCataId'] == $Cata->catalogId)
					{
						$data[] = $temp;
						$i++;
					}
				}
				else
				{
					$data[] = $temp;
					$i++;
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

	public function actionTextList()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['catalogId']) && isset($_POST['startId']) && isset($_POST['getNum']))
		{
			//检查catalogId 是否公开栏目
			$Cata = Catalog::model()->findByPk($_POST['catalogId']);
			if(($Cata == null) || ($Cata->isPublic == 0))
			{
				die("error");
			}
			$data = array();
			$db = Yii::app()->db;
			$sqlcmd = "SELECT * FROM T_cHomeTextList WHERE catalogId = '".$_POST['catalogId']."' ORDER BY textListId ASC LIMIT ".$_POST['startId'].",".$_POST['getNum'];
			$res = $db->createcommand($sqlcmd)->query();
			foreach($res as $line)
			{
				$temp = array();
				$temp['textId'] = $line['textId'];
				$temp['checkId'] = $line['checkId'];
				$temp['textTitle'] = $line['textTitle'];	
				//获取文章最后编辑时间
				$Text = Text::model()->find("textId=:textId ORDER BY editTime DESC",array(':textId'=>$line['textId']));		
				//文章最后编辑时间只显示年月日
				$temp['textEditTime'] = date("Y-m-d",strtotime($Text->editTime));
				$temp['titlePicAddr'] = $Text->titlePicAddr;
				$temp['textIntro'] = $Text->textIntro;
				//获取作者信息
					$authorId = $Text->authorId;
					$Author = User::model()->findByPk($authorId);
				$temp['authorName'] = $Author->userName;//以后这里获取作者昵称？
				//是活动文章时，获取活动信息
				if($Text->isActText == 1)
				{
					$Act = Act::model()->find('textId=:textId',array(':textId' => $Text->textId));
					$temp['actTime'] = $Act->actTime;
					$temp['actLoc'] = $Act->actLoc;
					$temp['actLecturer'] = $Act->actLecturer;
				}
				$data[] = $temp;
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