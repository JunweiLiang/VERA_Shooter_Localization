<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

class OptWidgetController extends Controller//各个部件对应各个栏目的修改  控制器
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
	public function actionTextFeedSelector()
	{
	
		$status = false;
		if(isset($_POST['method']))
		{
			if($_POST['method'] == 'change')
			{
				if($_POST['catalogId'])
				{
					//检查该catalogId是否公开栏目
					$Cata = Catalog::model()->findByPk($_POST['catalogId']);
					if(($Cata == null) || ($Cata->isPublic == 0))
					{
						die("error");
					}
					
					//删除原来的
					CHomeFeed::model()->deleteAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					if(isset($_POST['tfArr']))
					{
						//这里未检查textId是否重复!!***************************************
						//现在检查了，不过很丑陋！！
						$isRepeat = false;
						for($i = 0;$i<count($_POST['tfArr']);++$i)
						{
							for($j =0;$j<count($_POST['tfArr']);++$j)
							{
								if($i!=$j)
								{
									if($_POST['tfArr'][$i]['textId'] == $_POST['tfArr'][$j]['textId'])
									{
										$isRepeat = true;
										break;
									}
								}
							}
							if($isRepeat)
							{
								break;
							}
						}
						if($isRepeat)
						{
							die("error");
						}
						//先取该catalog的所有catalog
							$CataData = CatalogStructure::getCataStruct($_POST['catalogId']);
							$cataArr = CatalogStructure::parseCata($CataData,'catalogId',array());
						foreach($_POST['tfArr'] as $oneTF)
						{
							//检查该文章是否属于该catalog(无从得知textId的catalogId,抄送的可能有很多
							$CheckText = CheckText::model()->findByPk($oneTF['checkId']);
							if($CheckText == null || !in_array($CheckText->catalogId,$cataArr))
							{
								die('error');
							}
							$TF = new CHomeFeed();
							$TF->catalogId = $_POST['catalogId'];
							$TF->textId = $oneTF['textId'];
							$TF->checkId = $oneTF['checkId'];
							$TF->feedContent = $oneTF['feedContent'];
							$TF->feedTitle = $oneTF['textTitle'];//暂时feedTitle直接为textTitle，客户端feedTitle不能修改
							$TF->save();	
												
						}
					}
					echo 'ok';
					$status = true;
				}
			}
			else if($_POST['method'] == 'get')
			{
				if(isset($_POST['catalogId']))
				{
					$data = array();
					$TF = CHomeFeed::model()->findAll('catalogId=:catalogId ORDER BY feedId DESC',array(
						':catalogId' => $_POST['catalogId'],
					));
					foreach($TF as $line)
					{
						$temp = $line->attributes;
	
						$data[] = $temp; 
					}
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
					$status = true;
				}
			
			}
		}
		if(!$status)
		{
			die('error');
		}
	}
	public function actionActSelector()
	{
		$status = false;
		if(isset($_POST['method']))
		{
			if($_POST['method'] == 'get')
			{
				if(isset($_POST['catalogId']))
				{
					$data = array();
					$Act = CHomeAct::model()->findAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					foreach($Act as $line)
					{
						$temp = $line->attributes;
						//获取text与act信息
						$db = Yii::app()->db;
						$sqlcmd = "SELECT * FROM T_text WHERE textId= '".$line['textId']."' ORDER BY editTime DESC LIMIT 0,1";
						$res = $db->createcommand($sqlcmd)->query();
						foreach($res as $l)
						{
						
							$temp['textTitle'] = $l['title'];
						}
						$ActInfo = Act::model()->findByPk($line['actId']);
				
						$temp['actTime'] = $ActInfo->actTime;
						$temp['actLoc'] =$ActInfo->actLoc;
						$temp['actLecturer'] = $ActInfo->actLecturer;
						$data[] = $temp; 
					}
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
					$status = true;
				}
			}
			else if($_POST['method'] == 'change')
			{
				//print_r($_POST);
				//die("");
				if(isset($_POST['catalogId']))
				{
					//检查该catalogId是否公开栏目
					$Cata = Catalog::model()->findByPk($_POST['catalogId']);
					if(($Cata == null) || ($Cata->isPublic == 0))
					{
						die("error");
					}
					//删除原来的
					CHomeAct::model()->deleteAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					if(isset($_POST['actArr']))
					{
						//这里未检查textId是否重复!!***************************************
						//现在检查了，不过很丑陋！！
						$isRepeat = false;
						for($i = 0;$i<count($_POST['actArr']);++$i)
						{
							for($j =0;$j<count($_POST['actArr']);++$j)
							{
								if($i!=$j)
								{
									if($_POST['actArr'][$i]['textId'] == $_POST['actArr'][$j]['textId'])
									{
										$isRepeat = true;
										break;
									}
								}
							}
							if($isRepeat)
							{
								break;
							}
						}
						if($isRepeat)
						{
							die("error");
						}
						//先取该catalog的所有catalog
							$CataData = CatalogStructure::getCataStruct($_POST['catalogId']);
							$cataArr = CatalogStructure::parseCata($CataData,'catalogId',array());
						foreach($_POST['actArr'] as $oneAct)
						{
							//检查该文章是否属于该catalog(无从得知textId的catalogId,抄送的可能有很多
							$CheckText = CheckText::model()->findByPk($oneAct['checkId']);
							if($CheckText == null || !in_array($CheckText->catalogId,$cataArr))
							{
								die('error');
							}
							$Act = new CHomeAct();
							$Act->catalogId = $_POST['catalogId'];
							$Act->textId = $oneAct['textId'];
							$Act->actId = $oneAct['actId'];
							$Act->checkId = $oneAct['checkId'];
							$Act->actTitle = $oneAct['actTitle'];
							$Act->save();						
						}
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
	public function actionTextListSelector()
	{
		$status = false;
		if(isset($_POST['method']))
		{
			if($_POST['method'] == 'get')
			{
				if(isset($_POST['catalogId']))
				{
					$data = array();
					$TextList = CHomeTextList::model()->findAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					foreach($TextList as $line)
					{
						$temp = $line->attributes;
						//获取text与act信息
						/*$db = Yii::app()->db;
						$sqlcmd = "SELECT * FROM T_text WHERE textId= '".$line['textId']."' ORDER BY editTime DESC LIMIT 0,1";
						$res = $db->createcommand($sqlcmd)->query();
						foreach($res as $l)
						{
						
							$temp['textTitle'] = $l['title'];
						}*/
						
						$data[] = $temp; 
					}
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
					$status = true;
				}
			}
			else if($_POST['method'] == 'change')
			{
				//print_r($_POST);
				//die("");
				if(isset($_POST['catalogId']))
				{
					//检查该catalogId是否公开栏目
					$Cata = Catalog::model()->findByPk($_POST['catalogId']);
					if(($Cata == null) || ($Cata->isPublic == 0))
					{
						die("error");
					}
					//删除原来的
					CHomeTextList::model()->deleteAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					if(isset($_POST['textArr']))
					{
						//这里未检查textId是否重复!!***************************************
						//现在检查了，不过很丑陋！！
						$isRepeat = false;
						for($i = 0;$i<count($_POST['textArr']);++$i)
						{
							for($j =0;$j<count($_POST['textArr']);++$j)
							{
								if($i!=$j)
								{
									if($_POST['textArr'][$i]['textId'] == $_POST['textArr'][$j]['textId'])
									{
										$isRepeat = true;
										break;
									}
								}
							}
							if($isRepeat)
							{
								break;
							}
						}
						if($isRepeat)
						{
							die("error");
						}
						//先取该catalog的所有catalog
							$CataData = CatalogStructure::getCataStruct($_POST['catalogId']);
							$cataArr = CatalogStructure::parseCata($CataData,'catalogId',array());
						foreach($_POST['textArr'] as $oneText)
						{
							$CheckText = CheckText::model()->findByPk($oneText['checkId']);
							if($CheckText == null || !in_array($CheckText->catalogId,$cataArr))
							{
								die('error');
							}
							$TextList = new CHomeTextList();
							$TextList->catalogId = $_POST['catalogId'];
							$TextList->textId = $oneText['textId'];
							$TextList->checkId = $oneText['checkId'];
							$TextList->textTitle = $oneText['textTitle'];
							$TextList->save();						
						}
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
	public function actionCatalogRec()
	{
		$status = false;
		//print_r($_POST);
		if(isset($_POST['method']))
		{
			$method = $_POST['method'];
			if($method === "getSetup")
			{
				if(isset($_POST['catalogId']))
				{
					$catalogId = $_POST['catalogId'];
					$Setup = CatalogRecSetup::model()->find("catalogId=:catalogId",array(
						':catalogId'=>$catalogId,
					));
					if($Setup == null)//记录为空，那么先检查该catalogId是否在T_catalog中存在(且为公开栏目且有文章)，存在才添加默认的一行并且返回
					{
						$Catalog = Catalog::model()->findByPk($catalogId);
						if(($Catalog == null) || ($Catalog->isPublic == 0))
						{
							die('{"status":"error"}');
						}
						$Setup = new CatalogRecSetup();
						$Setup->catalogId = $catalogId;
						$Setup->save();
					}
					$data = $Setup->attributes;
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
					echo Text::json_encode_ch($data);
					$status = true;
				}
			}else if($method === "save")
			{
				//print_r($_POST);
				if(isset($_POST['catalogId']) && isset($_POST['setup']))
				{
					//检查catalogId是否存在，是否公开的外部栏目
					$catalogId = $_POST['catalogId'];
					$setupArr = $_POST['setup'];
					$Catalog = Catalog::model()->findByPk($catalogId);
					if(($Catalog == null) || ($Catalog->isPublic == 0))
					{
						die('{"status":"error"}');
					}
					$Setup = CatalogRecSetup::model()->find("catalogId=:catalogId",array(
						':catalogId'=>$catalogId,
					));
					if($Setup == null)//记录为空，出错了！！
					{
						die('{"status":"error"}');
					}
					//这里需要是否为空的检查,空的就保持原样
					$Setup->catalogId = $catalogId;
					$Setup->width = $setupArr['width'] == ""?$Setup->width:$setupArr['width'];
					$Setup->height = $setupArr['height'] == ""?$Setup->height:$setupArr['height'];
					$Setup->gapWidth = $setupArr['gapWidth'] == ""?$Setup->gapWidth:$setupArr['gapWidth'];
					$Setup->textLeft = $setupArr['left'] == ""?$Setup->textLeft:$setupArr['left'];
					$Setup->bgColor = $setupArr['bgColor'] == ""?$Setup->bgColor:$setupArr['bgColor'];
					$Setup->cataT_font_size = $setupArr['cataT'] == ""?$Setup->cataT_font_size:$setupArr['cataT'];
					$Setup->cataI_font_size = $setupArr['cataI'] == ""?$Setup->cataI_font_size:$setupArr['cataI'];
					$Setup->lineNum = $setupArr['lineNum'] == ""?$Setup->lineNum:$setupArr['lineNum'];
					$Setup->save();
					//先删除所有该catalogId 下的 T_cHomeCatalogRec数据 
					CHomeCatalogRec::model()->deleteAll('catalogId=:catalogId',array(
						':catalogId' => $catalogId,
					));
					if(isset($_POST['rec']))
					{
						$recArr = $_POST['rec'];
						foreach($recArr as $oneRec)
						{
							$Rec = new CHomeCatalogRec();
							$Rec->catalogId = $catalogId;
							$Rec->recCatalogId = $oneRec['recCatalogId'];//以后要检查这个recCatalogId是否catalogId 的子栏目且是公开有文章栏目
							$Rec->recTitle = $oneRec['catalogTitle'];
							$Rec->recIntro = $oneRec['catalogIntro'];
							if(isset($oneRec['imgAddr']) && ($oneRec['imgAddr'] != ''))
							{
								$Rec->recImgAddr = $oneRec['imgAddr'];
							}
							$Rec->save();
						}
					}
					$status = true;
				}
			}
			else if($method === "getRec")
			{
				if(isset($_POST['catalogId']))
				{
					$catalogId = $_POST['catalogId'];
						//检查catalogId
						$Catalog = Catalog::model()->findByPk($catalogId);
						if(($Catalog == null) || ($Catalog->isPublic == 0))
						{
							die('{"status":"error"}');
						}
						//***
					$RecArr = CHomeCatalogRec::model()->findAll("catalogId=:catalogId",array(
						':catalogId' => $catalogId,
					));
					$data = array();
					foreach($RecArr as $oneRec)
					{
						$temp = array();
						$temp = $oneRec->attributes;
						$data[] = $temp;
					}
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
					echo Text::json_encode_ch($data);
					$status = true;
				}
			}
		}
		if(!$status)
		{
			die('{"status":"error"}');
		}
	}
	public function actionPicSelector()
	{
		//print_r($_POST);
		//die("");
		$status = false;
		if(isset($_POST['method']))
		{
			if($_POST['method'] === 'get')
			{
				if(isset($_POST['catalogId']))
				{
					$data = array();
					$Pic = CHomePic::model()->findAll('catalogId=:catalogId',array(
						':catalogId' => $_POST['catalogId'],
					));
					foreach($Pic as $line)
					{
						$temp = $line->attributes;
						//对textId获取文章标题
						$db = Yii::app()->db;
						if($line['textId'] == 0)//此图片没有选择文章
						{
							$temp['textName'] = "";
						}
						else
						{
							$sqlcmd = "SELECT * FROM T_text WHERE textId= '".$line['textId']."' ORDER BY editTime DESC LIMIT 0,1";
							$res = $db->createcommand($sqlcmd)->query();
							foreach($res as $l)
							{
								$temp['textName'] = $l['title'];
							}
						}
						$data[] = $temp;
					}
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
					echo Text::json_encode_ch($data);
					$status = true;
				}
			}
			else if($_POST['method'] === 'change')
			{
				//print_r($_POST);
			//	if(null == "")
			//	{
			//		echo "j";
			//	}
			//	die("");
				if(isset($_POST['catalogId']) && isset($_POST['setup']))
				{
					$catalogId = $_POST['catalogId'];
					$setupArr = $_POST['setup'];
					//检查该catalogId是否公开栏目
					$Cata = Catalog::model()->findByPk($catalogId);
					if(($Cata == null) || ($Cata->isPublic == 0))
					{
						die("error");
					}
					//修改设置
					$Setup = CHomePicSetup::model()->find("catalogId=:catalogId",array(
						':catalogId'=>$catalogId,
					));
					if($Setup == null)//记录为空，出错了！！
					{
						die('{"status":"error"}');
					}
					//这里需要是否为空的检查,空的就保持原样
					$Setup->catalogId = $catalogId;
					$Setup->width = $setupArr['width'] == ""?$Setup->width:$setupArr['width'];
					$Setup->kgval = $setupArr['kgval'] == ""?$Setup->kgval:$setupArr['kgval'];
					$Setup->maskOpacity = $setupArr['maskOpacity'] == ""?$Setup->maskOpacity:$setupArr['maskOpacity'];
					$Setup->maskWidth = $setupArr['maskWidth'] == ""?$Setup->maskWidth:$setupArr['maskWidth'];
					$Setup->titleTop = $setupArr['titleTop'] == ""?$Setup->titleTop:$setupArr['titleTop'];
					$Setup->titleLeft = $setupArr['titleLeft'] == ""?$Setup->titleLeft:$setupArr['titleLeft'];
					$Setup->titleWidth = $setupArr['titleWidth'] == ""?$Setup->titleWidth:$setupArr['titleWidth'];
					$Setup->titleFontSize = $setupArr['titleFontSize'] == ""?$Setup->titleFontSize:$setupArr['titleFontSize'];
					$Setup->subTitleLeft = $setupArr['subTitleLeft'] == ""?$Setup->subTitleLeft:$setupArr['subTitleLeft'];
					$Setup->subTitleTop = $setupArr['subTitleTop'] == ""?$Setup->subTitleTop:$setupArr['subTitleTop'];
					$Setup->subTitleWidth = $setupArr['subTitleWidth'] == ""?$Setup->subTitleWidth:$setupArr['subTitleWidth'];
					$Setup->subTitleFontSize = $setupArr['subTitleFontSize'] == ""?$Setup->subTitleFontSize:$setupArr['subTitleFontSize'];
					$Setup->hasBG = $setupArr['hasBG'] == ""?$Setup->hasBG:$setupArr['hasBG'] === "true"?1:0;
					$Setup->save();
					//删除原来的
					CHomePic::model()->deleteAll('catalogId=:catalogId',array(
						':catalogId' => $catalogId,
					));
					if(isset($_POST['picArr']))
					{
						//先取该catalog的所有catalog
						$CataData = CatalogStructure::getCataStruct($catalogId);
						$cataArr = CatalogStructure::parseCata($CataData,'catalogId',array());
						foreach($_POST['picArr'] as $onePic)
						{
							//检查该文章是否属于该catalog(无从得知textId的catalogId,抄送的可能有很多
							/*$CheckText = CheckText::model()->find('textId=:textId AND checkStatus=2',array(
								':textId' => $onePic['textId'],
							));
							if(!in_array($CheckText->catalogId,$cataArr))
							{
								die('error');
							}*///直接根据checkId获取栏目id
							if(($onePic['checkId'] == 0) && ($onePic['textId'] == 0))//textId 和 checkId 为0就是没有选择文章，就不需要验证
							{
								;
							}
							else
							{
								$CheckText = CheckText::model()->findByPk($onePic['checkId']);
								if($CheckText == null || !in_array($CheckText->catalogId,$cataArr))
								{
									die('error');
								}
							}
							$Pic = new CHomePic();
							$Pic->catalogId = $catalogId;
							$Pic->textId = $onePic['textId'];   //当textId 为0表示没有选择文章，在picSlider中再判断 是否为0，然后再是否为空链接
							$Pic->picAddr = $onePic['picAddr'];
							$Pic->picTitle = $onePic['picTitle'];
							$Pic->hasMask = $onePic['hasMask'] === "true"?1:0;
							$Pic->picSubTitle = $onePic['picSubTitle'];
							$Pic->checkId = $onePic['checkId'];
							//$Pic->textName = $onePic['textName'];
							$Pic->save();						
						}
					}
					echo 'ok';
					$status = true;
				}
			}
			/*else if($_POST['method'] === 'changekg')//ancient stuff
			{
				//print_r($_POST);
				if(!isset(Yii::app()->session['userId']) || !isset($_POST['kgval']))
				{
					die('error');
				}
				$PicOption = PicOption::model()->findByPk(1);
				$PicOption->kgval = $_POST['kgval'];
				$PicOption->save();
				$status = true;
				echo "ok";
			}*/
			else if($_POST['method'] === 'getSetup')
			{
				if(isset($_POST['catalogId']))
				{
					$catalogId = $_POST['catalogId'];
					$Setup = CHomePicSetup::model()->find("catalogId=:catalogId",array(
						':catalogId'=>$catalogId,
					));
					if($Setup == null)//记录为空，那么先检查该catalogId是否在T_catalog中存在(且为公开栏目且有文章)，存在才添加默认的一行并且返回
					{
						$Catalog = Catalog::model()->findByPk($catalogId);
						if(($Catalog == null) || ($Catalog->isPublic == 0))
						{
							die('{"status":"error"}');
						}
						$Setup = new CHomePicSetup();
						$Setup->catalogId = $catalogId;
						$Setup->save();
					}
					$data = $Setup->attributes;
					//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
					echo Text::json_encode_ch($data);
					$status = true;
				}
			}
		}
		if(!$status)
		{
			die('error');
		}
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',//所有方法都需要登录
			//后面是各个方法的filter
			'isCHM',
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
	public function filterIsCHM($filterChain)
	{
		if(!User::isCHM(Yii::app()->session['userId']))
		{
			die("error");
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