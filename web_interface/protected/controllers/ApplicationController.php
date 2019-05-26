<?php

class ApplicationController extends Controller
{
	public $layout="";
	public $paramForLayout = array();
	
	public function actionGetDataset()
	{
		$this->render('getDataset');
	}

	
	public function actionGetVideoList()
	{
		$this->render('getVideoList');
	}
	public function actionCNewCollection()
	{
		$this->layout = "cClubSiteLayout";
		$this->render('cNewCollection');
	}
	
	//get runlist
	public function actionCAudioSyncRunList()
	{
		$this->layout = "cClubSiteLayout";
		$this->render('cAudioSyncRunList');
	}
	//go to one audio sync run(dataset)
	public function actionCAudioSyncRun($datasetId,$forLabeling)
	{
		$this->layout = "cClubSiteLayout";
		// get the datasetName
		$Dataset = Dataset::model()->findByPk($datasetId);

		$this->render('cAudioSyncRun',array(
			"datasetId" => $datasetId,
			"forLabeling" => $forLabeling,
			"datasetName" => $Dataset->name
		));
	}
	// watch video pairs result
	public function actionCAudioSyncPairView($dvId,$forLabeling,$videoname,$datasetId,$showBackLink=1)
	{
		$this->layout = "cClubSiteLayout";
		$videoname = rawurldecode($videoname);

		$this->render('cAudioSyncPairView',array(
			"dvId" => $dvId,
			"forLabeling" => $forLabeling,
			"videoname" => $videoname,
			"datasetId" => $datasetId,
			"showBackLink" =>($showBackLink==1),
		));
	}
	public function actionCWatch()
	{
		// for manully watch video	
				$this->layout = "cClubSiteLayout";
				//get dataset list
				
				$this->render('cWatch',array(

				));		
	}
	public function actionCGlobalResult()
	{
		// post the datasetId and the clusterId to here, and it will read the database for result, and load into a rashomon page.
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",-1);
		$clusterId = $request->getPost("clusterId",-1);
		if(($datasetId != -1) && ($clusterId == -1))
		{
			// get the latest cluster
			$Cluster = ERclusters::model()->find("datasetId=:d AND isDeleted=0 ORDER BY id DESC",array(":d"=>$datasetId));
			if($Cluster != NULL) 
			{
				$clusterId = $Cluster->id;
			}
			// no global sync result yet
		}
		if(($datasetId != -1) && ($clusterId != -1))
		{
			$datasetId = (int)$datasetId;
			$clusterId = (int)$clusterId;
			//get dataset Name
			$Dataset = Dataset::model()->findByPk($datasetId);
			//echo $datasetId;
			//get the result first
			$results = ERclusters::getResult($clusterId);
			//print_r($results);
			//change into rashomon json format
			$data = array(
				"mediaPath" => Yii::app()->baseUrl."/assets/videos/",
				"event" => $Dataset->name,
				"videos" => array(),
			);
			foreach($results as $one)
			{
				//rashomon bug? 0.0 offset it wont play
				if($one['offset'] == 0)
				{
					//$one['offset'] = 0.00001;
				}
				$data['videos'][] = array(
					"name" => $one['videoname'],
					"offset" => $one['offset'],
					"duration" => $one['duration'],
					"resultId" => $one['id'],
				);
			}
			//echo Text::json_encode_ch($data);
			$this->render("cRashomon",array(
				"data" => $data,
				'datasetId' => $datasetId,
				"clusterId" => $clusterId,
			));
		}
	}
	public function actionCWatchOne($videoname)
	{
		// for manully watch video	
				$this->layout = "cClubSiteLayout";
				//get dataset list
				
				$this->render('cWatchOne',array(
					"videoname" => $videoname
				));		
	}
	public function actionCShowDataset($datasetId,$showVideoDetection=0,$showWorkBoard=0)
	{
		// get the dataset stuff, order by 
		$this->layout = "cClubSiteLayout";
				
		$dataset = Text::sql("SELECT D_videos.*,D_videos.name AS videoname,D_dataset.name AS datasetname,D_videos.id as videoId FROM D_videos,D_dataset_video,D_dataset WHERE D_dataset.id=:d AND D_dataset.id=D_dataset_video.datasetId AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id ASC LIMIT 0,1000",array(":d"=>$datasetId));

		if($showVideoDetection == 1)
		{
			// get each video's person detection and sound detection result
			foreach($dataset as &$one)
			{
				$one['hasGunshotDetect'] = false;
				$GunshotRun = GunshotRun::model()->find("videoId=:v AND haveResult=1",array(":v"=>$one['videoId']));
				if($GunshotRun != null)
				{
					$one['hasGunshotDetect'] = true;
				}
				$one['hasPersonDetect'] = false;
				$PersonRun = PersonRun::model()->find("videoId=:v AND haveResult=1",array(":v"=>$one['videoId']));
				if($PersonRun != null)
				{
					$one['hasPersonDetect'] = true;
				}
			}
		}

		$this->render('cShowDataset',array(
			"dataset" => $dataset,
			"datasetId" => $datasetId,
			"showVideoDetection" => ($showVideoDetection==1),
			"showWorkBoard" => ($showWorkBoard==1),
		));		
	}
	public function actionCGunshot($videoname="")
	{
		// for manully watch video	
				$this->layout = "cClubSiteLayout";
				//get dataset list
				$userId = Yii::app()->session['userId'];
				$models = array();
				// get all the gunshot model
				$models['adminModelList'] = Text::sql("SELECT D_models.*,D_models.id AS modelId FROM D_models,T_user WHERE D_models.isDeleted=0 AND D_models.userId=T_user.userId AND T_user.isSuper=1 AND D_models.isDefault=1 ORDER BY modelId ASC");
				// only get one latested self-refined model
				$models['myModelList'] = Text::sql("SELECT D_models.*,D_models.id AS modelId FROM D_models WHERE D_models.isDeleted=0 AND D_models.userId=:u ORDER BY modelId DESC LIMIT 0,1",array(":u"=>$userId));

				$this->render('cGunshot',array(
					"videoname" => $videoname,
					"models" => $models,
				));		
	}
	public function actionCVideoPlayer($datasetId)
	{
		$this->layout = "cClubSiteLayout";
		$userId = Yii::app()->session['userId'];
		$Dataset = Dataset::model()->findByPk($datasetId);
		if(($Dataset == null) || ($Dataset->userId != $userId))
		{
			die("no dataset");
		}
		// get the Sync result,clusters list
		$syncClusters = array();
		$Clusters = ERclusters::model()->findAll("datasetId=:d ORDER BY id DESC",array(":d"=>$datasetId));
		foreach($Clusters as $Cluster)
		{
			$syncClusters[] = $Cluster->attributes;
		}
		// get the loc result
		$locClusters = Text::sql("SELECT D_location.name AS locName,D_loc2dataset.id AS loc2datasetId,D_loc2dataset.* FROM D_location,D_loc2dataset WHERE D_loc2dataset.datasetId=:d AND D_loc2dataset.locId=D_location.id ORDER BY D_loc2dataset.id DESC",array(":d"=>$datasetId));

		$this->render('cVideoPlayer',array(
				"datasetId" => $datasetId,
					"datasetname" => $Dataset->name,
					"syncClusters" => $syncClusters,
					"locClusters" => $locClusters,
				));	
	}
	
	public function actionCAudioSync($datasetId="")
	{
		// for manully watch video	
				$this->layout = "cClubSiteLayout";
				$datasetname = "";
				$hasRun = false;
				//get dataset list
				if($datasetId != "")
				{
					$Dataset = Dataset::model()->findByPk($datasetId);
					if($Dataset == null)
					{
						die("Dataset not exists");
					}
					else
					{
						$datasetname = $Dataset->name;
					}
					//check whether has result 
					if(ERresults::model()->exists("datasetId=:d",array(":d"=>$Dataset->id)))
					{
						$hasRun = true;
					}
				}
				$this->render('cAudioSync',array(
					"datasetId"=> $datasetId,
					"datasetname" => $datasetname,
					"hasRun" => $hasRun,
				));		
	}
	
	public function actionIndex($datasetId=0)// for mainPage
	{
		
		if($this->paramForLayout['userLevel'] != 0)
		{
			//
			//demo user
				$this->layout = "cClubSiteLayout";
				//get dataset list
				
				$this->render('cMainPage',array(
					"datasetId" => $datasetId,
				));		
		}
		else//admin
		{
			//先获取用户的权限，是否栏目管理员等，用于构造左半边栏
			$userId = Yii::app()->session['userId'];
			$res = User::model()->findByPK("$userId");
			$this->paramForLayout['isUM'] = $res['isUM'];
			$this->paramForLayout['isSuper'] = $res['isSuper'];
			
			$this->layout = "clubSiteLayout";
			$this->render('index');
		}
	}
	public function actionCHelp()
	{
		$this->layout = "cClubSiteLayout";
		$Notice = Notice::model()->findByPk(1);// the help is id 1
		$this->render("cHelp",array(
			"content" => $Notice->content,
		));
	}

	public function actionShowSegment($segmentId,$datasetId)
	{
		//get the segment results
		$this->layout = "cClubSiteLayout";
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$Segment = Segments::model()->findByPk($segmentId);
		//check userId?
		if(($Segment == null) || ($Segment->userId != $userId))
		{
			die("error");
		}
		/*
		$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,D_videos.*,D_videos.name AS videoname from D_er_pairs,D_videos,D_dataset_video ".
					" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.datasetId=:d".
					" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id ORDER BY D_er_pairs.confidence DESC LIMIT 0,5";
		$ranklist = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$segmentId));*/
		$videoInfo = Videos::getInfoUsingDvId($Segment->dvId);;
		$this->render("showSegment",array(
			//"ranklist" => $ranklist,
			"videoInfo" => $videoInfo,
			"start" => $Segment->start,
			"end" => $Segment->end,
			"segmentId" => $segmentId,
			"datasetId" => $datasetId,
		));
	}


/*************
	below are for management account
*/
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
	public function actionShowVideo($basename)
	{
		$this->render('showVideo',array(
			"videopath" => Yii::app()->baseUrl."/".f::get("videoPath").$basename,
			"videoname" => basename(Yii::app()->baseUrl."/".f::get("videoPath").$basename),
		));
	}
	//*****下面时超级管理员操作
	public function actionSuperManage()
	{
		$this->render('superManage',array(
		));
	}
	// for gunshot training
	public function actionGunshot()
	{
		$this->render('gunshot',array(
		));
	}
	public function actionNotice($noticeId = 0)
	{
		//不再一次获取
		//获取notice数
		/*$Num = Notice::model()->count();
		$this->render("notice",array(
			"noticeNum" => $Num,
		));
		*/
		if($noticeId == 0)
		{
			//获取所有notice
			$Notice = Notice::model()->findAll();
			$arr = array();
			foreach($Notice as $one)
			{
				$arr[] = $one->attributes;
			}
			$this->render("noticeView",array(
				"arr" => $arr
			));
		}
		else
		{
			$arr = Notice::model()->findByPk($noticeId);
			if($arr!=NULL)
			{
				$this->render("noticeEdit",array(
					"arr" => $arr,
				));
			}
			else
			{
				$this->render("notStart",array(
					"text" => "wrong noticeId"
				));
			}
		}
		
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
			'managerFilter + userManage,personalPage,superManage,showVideo,gunshot,notice',
			'isSuper + superManage,gunshot,notice',
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
				//echo Yii::app()->request->requestUri;
				//echo Yii::app()->controller->getId();
				//echo Yii::app()->controller->getAction()->getId();
				//$this->redirect(Yii::app()->baseUrl."/?r=".urlencode(Text::getRequest()));
				$this->redirect(Yii::app()->baseUrl."/index.php/site/login?redirect=".urlencode(Text::getRequest()));
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
					die("error:f**k.");			
			}
		}
		//判断角色
		$UserRole = User::getUserRole(Yii::app()->session['userId']);
		
		if($UserRole == false)
		{
			die("error");
		}
		/*
			判断用户是否管理员，或者用户
		*/
		$this->paramForLayout['username'] = $UserRole['userName'];
		$this->paramForLayout['nickname'] = $UserRole['nickName'] == ""?$UserRole['userName']:$UserRole['nickName'];
		$this->paramForLayout['userLevel'] = $UserRole['userLevel'];

		Yii::import("application.extensions.f");
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