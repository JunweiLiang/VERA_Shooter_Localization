<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	//此controller有漏洞，get方法直接返回全部栏目，在客户端才去掉内部栏目、无文章栏目等
?>
<?php

class CatalogController extends Controller
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
	//************栏目管理员CM的方法
	public function actionAdd()
	{
		////以后这里要对$parentId检查userId权限，
		if(!isset($_POST['add']))
		{
			die("error");
		}
		else
		{
			$parentId = $_POST['add']['parentId'];
			$isPublic = $_POST['add']['isPublic'];
			$hasText = $_POST['add']['hasText'];
			$cataTitle = $_POST['add']['cataTitle'];
			$cataIntro = $_POST['add']['cataIntro'];
			$userId = Yii::app()->session['userId'];
			//对提交的数据进行合法性验证
			if(($isPublic != "1") && ($isPublic != "0"))
			{
				die("error");
			}
			if(($hasText != "1") && ($hasText != "0"))
			{
				die("error");
			}
			//入库
			$db = Yii::app()->db;
			//先获取该parent下有多少child,得rank,
			$sqlcmd = "SELECT * FROM T_catalog WHERE catalogId = '".$parentId."'";
			$res = $db->createCommand($sqlcmd)->queryRow();
			$childNum = $res['childNum'];
			//插入到T_catalog中，同时更新parentId的childNum
			$rank = ++$childNum;
			$sqlcmd = "INSERT INTO T_catalog(creatorId,createTime,catalogTitle,catalogRank,childNum,hasText,isPublic,catalogIntro) VALUES('".$userId."',NOW(),'".$cataTitle."','".$rank."','0','".$hasText."','".$isPublic."','".$cataIntro."')";
			$db->createCommand($sqlcmd)->execute();

			$newChildId = Yii::app()->db->getLastInsertID();//取得新插入的id
			$sqlcmd = "UPDATE T_catalog SET childNum=childNum+1 WHERE catalogId='".$parentId."'";
			$db->createCommand($sqlcmd)->execute();
			//插入到T_catalogStruct中
			$sqlcmd = "INSERT INTO T_catalogStructure(parentId,childId) VALUES('".$parentId."','".$newChildId."')";
			$db->createCommand($sqlcmd)->execute();

			echo "ok";
		}
	}
	public function actionChange()//删除catalog的方法在这里//不应该删除了？赛区节点及其父节点不能删除？
	{
		//以后要注意对管理员管理的最高级栏目的修改是否授予的问题
		//获取$_POST['data'][method],$_POST['data']['catalogId']
		//包括上移，下移，改变
		if(!isset($_POST['data']))
		{
			die("error");
		}
		else
		{
			if(!isset($_POST['data']['method']) || !isset($_POST['data']['catalogId']))
			{
				die("error");
			}
			$method = $_POST['data']['method'];
			$catalogId = $_POST['data']['catalogId'];
			//要检查该修改人是否该栏目d的管理员
			if(($method == "upThis") || ($method == "downThis"))
			{
				//获取catalogId的parent id
				$parentId = CatalogStructure::model()->find('childId = :childId',array(':childId'=>$catalogId))->parentId;
				$thisCata = Catalog::model()->find('catalogId = :catalogId',array(':catalogId'=>$catalogId));
				if(!$parentId)
				{
					die("ok");//最顶级的栏目不用做任何事情
				}
				//下面获取该下一层所有子节点的信息
				$db = Yii::app()->db;
				if($method == "upThis")
				{
					$sqlcmd = "SELECT * FROM T_catalog WHERE catalogId IN(SELECT childId FROM T_catalogStructure WHERE parentId = '".$parentId."') ORDER BY catalogRank ASC";
				}
				else if($method == "downThis")
				{
					$sqlcmd = "SELECT * FROM T_catalog WHERE catalogId IN(SELECT childId FROM T_catalogStructure WHERE parentId = '".$parentId."') ORDER BY catalogRank DESC";
				}
				$children = $db->createCommand($sqlcmd)->query();//其元素是T_catalog中的行
				//
				$lastId = 0;
				foreach($children as $child)
				{
					if($child['catalogId'] == $catalogId)//遍历到当前节点
					{
						if($lastId == 0)//当前栏目已经是最顶，什么也不做
						{
							die("ok");
						}
						//交换$lastid与catalogId的catalogRank信息
						$lastCata = Catalog::model()->findByPk($lastId);
						$rank = $lastCata->catalogRank;//获得上一个栏目的序号
						$lastCata->catalogRank = $thisCata->catalogRank;
						$thisCata->catalogRank = $rank;
						
						$thisCata->save();
						$lastCata->save();
					}
					$lastId = $child['catalogId'];//作为下一个遍历时上一个栏目的id
				}
				echo "ok";
			}
			else if($method == "removeThis")
			{
				//删除栏目，将删除其所有子栏目及其子栏目对应的文章、作品，//外部栏目的不删除，对外显示文章已删除
				//先获取所有相关的栏目 
				$catalogData = CatalogStructure::getCataStruct($catalogId);
				$catalogArray = CatalogStructure::parseCata($catalogData,'catalogId');
				//print_r($catalogArray);
				//die("");
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				//开始删除
				try{
					//循环
					foreach($catalogArray as $oneCataId)
					{
						$thisCatalog = Catalog::model()->findByPk($oneCataId);//不管T_catalog中父栏目的childNum数据，否则新create时的catalogRank会出错
						//删除T_catalogStructure中的数据
					 	//不会有多个parentID指向相同childId的前提
						CatalogStructure::model()->deleteAll('childId =:childId',array(':childId'=>$oneCataId));
						//删除相应的文章(包括抄送的)
						CheckText::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						Text::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						//删除相应的作品
						Work::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						CheckWork::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						//删除CHM,CM
						CHM::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						CatalogManager::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						//(如果是赛区的话)
						if($thisCatalog->hasWork == 1)
						{
							//删除此栏目对应的参赛账号
							$Competitors = Competitor::model()->findAll("catalogId=:c",array(":c"=>$oneCataId));
							foreach($Competitors as $Competitor)
							{
								User::model()->delete("userId=:u",array(":u"=>$Competitor->competitorId));
								$Competitor->delete();
							}	
							//删除WM
							WM::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
							//删除赛区作品种类、地点信息
							ZoneLoc::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
							ZoneWorkType::model()->deleteAll("catalogId=:c",array(":c"=>$oneCataId));
						}
						//忽略Chat
						$thisCatalog->delete();
					}
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					die($e->getMessage());
					die("error");
				}
				echo "ok";
			}
			else if($method == "changeThis")
			{
				
				$parentId = $_POST['data']['parentId'];
				$isPublic = $_POST['data']['isPublic'];
				$hasText = $_POST['data']['hasText'];
				$cataTitle = $_POST['data']['cataTitle'];
				$cataIntro = $_POST['data']['cataIntro'];
				$userId = Yii::app()->session['userId'];
				//对提交的数据进行合法性验证
				if(($isPublic != "1") && ($isPublic != "0"))
				{
					die("error");
				}
				if(($hasText != "1") && ($hasText != "0"))
				{
					die("error");
				}
				if($parentId == $catalogId)//不能以自己为父节点
				{
					die("error");
				}
				//新parentId与原来parentId相同的情况，只需修改catalogId的T_catalog
				$oldParentId = CatalogStructure::model()->find('childId = :childId',array(':childId'=>$catalogId))->parentId;
				if($oldParentId == $parentId)
				{
					$db = Yii::app()->db;
					$sqlcmd = "UPDATE T_catalog SET creatorId='".$userId."',createTime=NOW(),catalogTitle='".$cataTitle."',hasText='".$hasText."',isPublic='".$isPublic."',catalogIntro='".$cataIntro."' WHERE catalogId='".$catalogId."'";
					$db->createCommand($sqlcmd)->execute();
				}
				else
				{
					//删除原来的T_catalogStruct
					CatalogStructure::model()->deleteAll('childId =:childId',array(':childId'=>$catalogId));
					//入库
					$db = Yii::app()->db;
					//先获取该parent下有多少child,得rank,
					$sqlcmd = "SELECT * FROM T_catalog WHERE catalogId = '".$parentId."'";
					$res = $db->createCommand($sqlcmd)->queryRow();
					$childNum = $res['childNum'];
					//更新到T_catalog中，同时更新parentId的childNum
					$rank = ++$childNum;
					$sqlcmd = "UPDATE T_catalog SET creatorId='".$userId."',createTime=NOW(),catalogTitle='".$cataTitle."',catalogRank='".$rank."',hasText='".$hasText."',isPublic='".$isPublic."',catalogIntro='".$cataIntro."' WHERE catalogId='".$catalogId."'";
					$db->createCommand($sqlcmd)->execute();

					$sqlcmd = "UPDATE T_catalog SET childNum=childNum+1 WHERE catalogId='".$parentId."'";
					$db->createCommand($sqlcmd)->execute();
					//插入到T_catalogStruct中
					$sqlcmd = "INSERT INTO T_catalogStructure(parentId,childId) VALUES('".$parentId."','".$catalogId."')";
					$db->createCommand($sqlcmd)->execute();
				}
				echo "ok";
			}
		}
	}
	//**************

	public function actionGet()
	{
		if(!isset($_POST['data']))
		{
			die("error");
		}
		else
		{
			if(!isset($_POST['data']['method']))
			{
				die("error");
			}
			$method = $_POST['data']['method'];
			if($method == "getCatalogById")//根据id,获取该栏目信息以及该栏目下所有子栏目的信息
			{
				if(!isset($_POST['data']['parentCataIdArr']))
				{
					die("[]");
				}
				$parentCataIdArr = $_POST['data']['parentCataIdArr'];
				////以后这里要对$parentCataIdArr检查userId权限，(不需要，此处只是读取操作，不需检查，以后外部主页也可能需要此操作)
				//下面根据$parentCataIdArr一个个获取所有catalog
				$data = array();
				foreach($parentCataIdArr as $catalogId)//遍历该管理员管理的所有父栏目id
				{
					$data[] = CatalogStructure::getCataStruct($catalogId);//新数据放入data数组尾部
				}
				//print_r($data);
				//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			}
			else if($method == "getCatalogNodeById")//根据栏目id获取该栏目信息（'不会返回其子级'）
			{
				if(!isset($_POST['data']['cataIdArr']))
				{
					die("error");
				}
				$cataIdArr = $_POST['data']['cataIdArr'];
				////以后这里要对$parentCataIdArr检查userId权限，(不需要，此处只是读取操作，不需检查，以后外部主页也可能需要此操作)
				//下面根据$parentCataIdArr一个个获取所有catalog
				$data = array();
				foreach($cataIdArr as $catalogId)//遍历该管理员管理的所有父栏目id
				{
					$data[] = Catalog::model()->findByPk($catalogId)->attributes;
				}
				//print_r($data);
				//echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			echo Text::json_encode_ch($data);
			}			
		}
	}
	//*****超级管理员管理赛区的方法 super
	public function actionGetZoneInfo()
	{
		if(!isset($_POST['catalogId']))
		{
			die("");
		}
		else
		{
			$catalogId = (int)$_POST['catalogId'];
			$Catalog = Catalog::model()->findByPk($catalogId);
			if($Catalog == null)
			{
				die("");
			}
			else
			{
				$data = array();
				$data = $Catalog->attributes;
				//获取所包括的workTypeId
				$data['workSubTypeArr'] = array();
				$data['workSubTypeArr'] = ZoneWorkType::getZoneTypeArr($data['catalogId']);
				$data['workLocArr'] = array();
				$temp = ZoneLoc::model()->findAll("catalogId=:c",array(
					":c"=> $catalogId,
				));
				foreach($temp as $one)
				{
					$data['workLocArr'][] = $one->attributes;
				}
				
				echo Text::json_encode_ch($data,JSON_UNESCAPED_UNICODE);
			}
		}
	}
	public function actionChangeZoneInfo()
	{
		
		if(!isset($_POST['catalogId']))
		{
			die("");
		}
		else
		{
			$catalogId = (int)$_POST['catalogId'];
			$Catalog = Catalog::model()->findByPk($catalogId);
			if($Catalog == null)
			{
				die("");
			}
			else
			{
				//print_r($_POST);
				//die("");
				//必须有作品种类,省份才设置为赛区,且允许选手类型不能为空
				if(!empty($_POST['zoneTypeArr']) &&
					!empty($_POST['zoneLocArr']) &&
					 isset($_POST['isZone']) && 
					 ($_POST['isZone'] == 1) && 
					 is_array($_POST['zoneTypeArr']) &&
					 is_array($_POST['zoneLocArr'])//非数组值，count()会返回1
					 && ($_POST['zoneSchoolType'] > 0) && ($_POST['zoneSchoolType'] < 4))
				{
					//设置为赛区
					$ok1 = false;
					$ok2 = false;
					$db = Yii::app()->db;
					$transaction = $db->beginTransaction();
					try{
						ZoneWorkType::model()->deleteAll("catalogId=:catalogId",array(
							":catalogId" => $catalogId,
						));
						ZoneLoc::model()->deleteAll("catalogId=:catalogId",array(
							":catalogId" => $catalogId,
						));
						//先去重
						$_POST['zoneTypeArr'] = array_unique($_POST['zoneTypeArr']);
						$_POST['zoneLocArr'] = array_unique($_POST['zoneLocArr']);
						foreach($_POST['zoneTypeArr'] as $one)
						{
							//检查workSubtype是否存在
							if(WorkSubType::model()->exists("subTypeId=:a",array(":a"=>$one)))
							{
								$ok1 = true;		
								$ZoneWorkType = new ZoneWorkType();
								$ZoneWorkType->catalogId = $catalogId;
								$ZoneWorkType->workSubTypeId = $one;
								if(!$ZoneWorkType->save())
								{
									throw new Exception("damn1");
								}
							}	
						}
						foreach($_POST['zoneLocArr'] as $one)
						{
							//检查location是否存在
							if(Location::model()->exists("locationId=:a",array(":a"=>$one)))
							{
								$ok2 = true;		
								$ZoneLoc = new ZoneLoc();
								$ZoneLoc->catalogId = $catalogId;
								$ZoneLoc->locationId = $one;
								if(!$ZoneLoc->save())
								{
									throw new Exception("damn2");
								}
							}	
						}
						if($ok1 && $ok2)
						{
							$Catalog->hasWork = 1;
							$Catalog->zoneSchoolType = (int)$_POST['zoneSchoolType'];
							if(!$Catalog->save())
							{
								throw new Exception("damn");
							}
						}
						$transaction->commit();
					}catch(Exception $e)
					{
						$transaction->rollback();
						die("a");
					}//transaction
				}
				else
				{
					//设置为非赛区 
					$db = Yii::app()->db;
					$transaction = $db->beginTransaction();
					try{
						!ZoneWorkType::model()->deleteAll("catalogId=:catalogId",array(
							":catalogId" => $catalogId,
						));
						ZoneLoc::model()->deleteAll("catalogId=:catalogId",array(
							":catalogId" => $catalogId,
						));
						$Catalog->hasWork = 0;
						if(!$Catalog->save())
						{
							throw new Exception("fuck");
						}
						$transaction->commit();
					}catch(Exception $e)
					{
						$transaction->rollback();
						die("aa");
					}
				}
			}
		}
	
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',//所有方法都需要登录
			//后面是各个方法的filter
			'isCM + add,change',
			'isSuper + changeZoneInfo',
		);
	}
	public function filterIsCM($filterChain)
	{
		if(!User::isCM(Yii::app()->session['userId']))
		{
			die("error");
		}
		$filterChain->run();
	}
	public function filterIsSuper($filterChain)
	{
		if(!User::isSuper(Yii::app()->session['userId']))
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