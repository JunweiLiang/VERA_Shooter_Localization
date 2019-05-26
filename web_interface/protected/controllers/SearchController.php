<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

class SearchController extends Controller
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
	public static function preProcess($inputStr)
	{
		//以后这里要检查特殊字符，去掉特殊字符,限制长度64字符
			//去掉开始的空格	
		return trim(substr($inputStr,0,64));
	}
	public function actionSearch()
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['w']))
		{
			//保护searchController,请求时间小于1秒，不予显示
			if(isset(Yii::app()->session['lastSearchTime']) && (time() - Yii::app()->session['lastSearchTime'] <= 1))
			{
				echo "[]";
				$status = true;
			}		
			else
			{
			//返回文章节点，包括题目，textId,直接链接到viewText;文章简介(如果有),暂时不搜索文章内容;文章作者信息			
			$wordStr = self::preProcess($_POST['w']);
			//从所有T_cHome*中获取可搜索的checkId
			$idArray = self::getAvailId();
				
			$result = array();//array('rankScore'=>,'textdata'=>array())
			//加入日志
			self::searchLog($wordStr);
			//这里先从历史搜索里获取//(有新文章怎么处理?---记录时间，有历史的只从最新的文章开始处理?)
			//把关键字放入T_predict中
			self::leongchunwai($wordStr);
		//	die(print_r($idArray));
			foreach($idArray as $oneSample)//遍历每一篇文章，计算符合度
			{
				$temp = array();
				$temp['rankScore'] = 0;
					
					$idA = explode(' ',$oneSample);
					$checkId = (int)$idA[0];
					$textId = (int)$idA[1];
					$Text = Text::model()->find('textId=:textId ORDER BY editTime DESC',array(':textId'=>$textId));
					//当text存在时才继续
					if($Text == null)
					{
						continue;
					}
					$temp['textdata']['textTitle'] = $Text->title;
					$temp['textdata']['textIntro'] = $Text->textIntro;
					$temp['textdata']['textTime'] = $Text->editTime;
					$temp['rankScore'] = self::searchRank($temp['textdata'],$wordStr);
				//	die("{$temp['rankScore']}");
					if($temp['rankScore'] > 1)//分数不小于1（1为时间的分数），才缓存结果 
					{
						$temp['textdata']['textTime'] = date("Y-m-d",strtotime($temp['textdata']['textTime']));//只显示年月日
						$temp['textdata']['textId'] = $textId;
						$temp['textdata']['authorId'] = $Text->authorId;
							$User = User::model()->findByPk($Text->authorId);
							if($User == null)
							{
								$temp['textdata']['authorName'] = "佚名";
							}
							else
							{
								if($User->nickName == "")
								{
									$temp['textdata']['authorName'] = $User->userName;
								}
								else
								{
									$temp['textdata']['authorName'] = $User->nickName;
								}
							}
						$temp['textdata']['checkId'] = $checkId;
						$result[] = $temp;
					}
			}
			$data = array();
			//$data = $result;
			$data = self::sortByRank($result);
			//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			$status = true;
			}
			Yii::app()->session['lastSearchTime'] = time();
		}
		if(!$status)
		{
			die("error");
		}
	}
	//*******************对搜索串进行预处理，放入T_predict中 
	public static function leongchunwai($searchStr)
	{
		self::leong($searchStr);//把整个搜索串（经过预处理的只用空格隔开关键字的前后没有空格的 ）放入predict中
		//下面对每个关键字放入predict
		$wArray = explode(" ",$searchStr);	
		if(count($wArray)>1)//有多个关键字的情况
		{
			foreach($wArray as $oneWord)
			{
				self::leong($oneWord);
			}
		}
	}
	public static function leong($str)//把一个关键字处理放入T_predict中//以后要处理掉表中无用的字段（inputStr == predictStr的）
	{
		//安全检查，是否字符串？
		//if()
		//遍历从头开始一次增添一个字符，知道64个
		$length = mb_strlen($str,'utf-8') > 20?20:mb_strlen($str,'utf-8')-1;//最后一个字符没有意义，对于中文，最后一个字没有意义(怎么判断?)//*************重要！！数据表中有大部分这些无用的东西（3个字符表示一个汉字，字符分开就没用了）//解决，用mb_str
		for($i=0;$i<$length;++$i)
		{
			$inputStr = mb_substr($str,0,$i+1,'utf-8');
			//先检查表中之前有没这个输入 
			$Predict = Predict::model()->find("inputStr=:inputStr AND predictStr=:predictStr",array(
				':inputStr' => $inputStr,
				':predictStr' => $str,
			));
			if($Predict != null)//非空，增加predictRank
			{
				$Predict->predictRank = $Predict->predictRank+1;
				$Predict->save();
			}
			else//新输入纪录
			{
				$Predict = new Predict();
				$Predict->inputStr = $inputStr;
				$Predict->predictStr = $str;
				$Predict->save();
			}
		}
		/***
			T_predict 表
			predictId 长度11整数
			inputStr  长度64,索引，默认空字符串
			predictStr 长度256,默认空字符串
			predictRank 浮点数  默认0
		**/
	}
	//*************
	public static function searchLog($searchStr)
	{
		$SearchLog = new SearchLog();
		$SearchLog->searchStr = $searchStr;
		$SearchLog->searchUserAgent = $_SERVER['HTTP_USER_AGENT'];
		$SearchLog->searchRemoteAddr = $_SERVER['REMOTE_ADDR'];
		$SearchLog->searchTime = new CDbExpression('NOW()');
		$SearchLog->save();
	}
	public static function sortByRank($resArr)
	{
		/*
			$resArr =  array(
				array(
					'rankScore'=>,
					'textdata'=>array(),
				),
			);
			返回只含textdata的数组
		*/
		$returnData = array();
		if(count($resArr)!=0)
		{
			$data = $resArr;
			foreach ($data as $key => $row) 
			{ 
				$rankScore[$key] = $row['rankScore']; 
			} 

			// 将数据根据 volume 降序排列，根据 edition 升序排列 
			// 把 $data 作为最后一个参数，以通用键排序 
			array_multisort($rankScore, SORT_DESC, $data); 
			//只返回textdata字段
			$i=0;//暂时最多返回30个结果
		
			foreach($data as $one)
			{
				if($i >= 30)
				{
					break;
				}
				$returnData[] = $one['textdata'];
				$i++;
			}
		}
		return $returnData;
	}
	
	public static function searchRank($TextClass,$wordStr)//对一篇文章计算与关键字的拟合度
	{
		$score = 0;//计算总排名分数
		//题目全部匹配*100+简介全部匹配*20+题目匹配关键字数*3+简介匹配关键字数*2+时间戳去掉首两位末四位/10^4;(不会有相差1000天同时符合关键字的情况(吧),同时忽略3小时以内的误差)
		//全部匹配与个别匹配会有重复
		//echo strtotime($TextClass['textTime'])."\n";
		//echo substr(strtotime($TextClass['textTime']),2,4)/pow(10,4);
		//die('');
		$wArray = explode(" ",$wordStr);
		//先整体匹配
		if(stripos($TextClass['textTitle'],$wordStr) !== false)
		{
			$score+=100;
		}
		if(stripos($TextClass['textIntro'],$wordStr) !== false)
		{
			$score+=20;
		}
		//分别匹配
		if(count($wArray)>1)//有多个关键字的情况
		{
			$score += self::matchedNum($TextClass['textTitle'],$wArray)*3;
			$score += self::matchedNum($TextClass['textIntro'],$wArray)*2;//textIntro可能为空!－－－无所谓	
		}
		$score += substr(strtotime($TextClass['textTime']),2,4)/pow(10,4);// definately < 1
		return $score;
	}
	public static function matchedNum($str,$wordArr)//返回$str中匹配关键字数组$wordArr的个数
	{
		$num = 0;
		foreach($wordArr as $oneWord)
		{
			if(stripos($str,$oneWord) !== false)
			{
				$num++;
			}
		}
		return $num;
	}
	public static function getAvailId()//获取可以匹配的集合，text的id组合: checkId+空格+textId
	{
		$idArray = array();
			$TextList = CHomeTextList::model()->findAll();
				foreach($TextList as $one)
				{
					//$temp = array();
					//$temp['checkId'] = $one['checkId'];
					//$temp['textId'] = $one['textId'];
					if(($one['checkId']!=0) && ($one['textId']!=0))
					{
						$idArray[] = $one['checkId']." ".$one['textId'];//组合方便去重
					}
				}
				$TextFeed = CHomeFeed::model()->findAll();
				foreach($TextFeed as $one)
				{
					//$temp = array();
					//$temp['checkId'] = $one['checkId'];
					//$temp['textId'] = $one['textId'];
					if(($one['checkId']!=0) && ($one['textId']!=0))
					{
						$idArray[] = $one['checkId']." ".$one['textId'];//组合方便去重
					}
				}
				$Act = CHomeAct::model()->findAll();
				foreach($Act as $one)
				{
					//$temp = array();
					//$temp['checkId'] = $one['checkId'];
					//$temp['textId'] = $one['textId'];
					if(($one['checkId']!=0) && ($one['textId']!=0))
					{
						$idArray[] = $one['checkId']." ".$one['textId'];//组合方便去重
					}
				}
				$Pic = CHomePic::model()->findAll();
				foreach($Pic as $one)
				{
					//$temp = array();
					//$temp['checkId'] = $one['checkId'];
					//$temp['textId'] = $one['textId'];
					if(($one['checkId']!=0) && ($one['textId']))
					{
						$idArray[] = $one['checkId']." ".$one['textId'];//组合方便去重
					}
				}
				$idArray = array_unique($idArray);
			return $idArray;
	}
	public function actionPredict()//超大负荷的控制器，注意
	{
		//print_r($_POST);
		$status = false;
		if(isset($_POST['w']))
		{
			//
			$wordStr = self::preProcess($_POST['w']);
			$Predict = Predict::model()->findAll('inputStr=:inputStr ORDER BY predictRank DESC',array(
				':inputStr'=>$wordStr,
			));
			$data = array();
			foreach($Predict as $one)
			{
				$temp = array();
				$temp['predictW'] = $one->predictStr;
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