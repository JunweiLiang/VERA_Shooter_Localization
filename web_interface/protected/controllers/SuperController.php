<?php

class SuperController extends Controller
{

	

	public function actionDaisyCopyUser()
	{
		$request = Yii::app()->request;
		$userId = $request->getPost("userId",-1);
		$userLevel = $request->getPost("userLevel",-1);
		$thisUserName = $request->getPost("thisUserName", "");
		$thisUserPw = $request->getPost("thisUserPw", $thisUserName);
		$adminId = Yii::app()->session['userId'];
		if(($userId != -1) && ($userLevel != -1) && ($thisUserName != ""))
		{
			$result = array(
				"status" => 0,
			);
			if(User::model()->exists("userName=:u",array(':u'=>$thisUserName)))
			{
				$result['status'] = 1;
				$result['error'] = "Username exists.";
			}
			else
			{
				if($thisUserPw == '')
				{
					$thisUserPw = "123456";
				}
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$thisUserPw = md5($thisUserPw);
					$sqlcmd = "INSERT INTO T_user(userName,userPw,userRegTime,isSuper,isUM,userLevel)".
							" VALUES(:userName,:userPw,NOW(),0,0,:userLevel)";
					Text::sql($sqlcmd,array(
						":userLevel" => $userLevel,
					),array(
						":userName" => $thisUserName,
						":userPw" => $thisUserPw,
					),false);
					$newUserId = $db->getLastInsertID();
					// add to admin user tree
					Text::sql("INSERT INTO T_userStructure (parentUserId,childUserId) VALUES (:a,:c)",array(":a"=>$adminId,":c"=>$newUserId),array(),false);
					// copying stuff!
					// 1. get the original user video dataset, process one by one
					$src_datasets = Dataset::model()->findAll("userId=:u AND isDeleted=0 AND isImported=0 AND isSearch=0",array(":u"=>$userId));
					foreach($src_datasets as $src_dataset)
					{
						// new dataset
						$des_dataset = new Dataset();
						$des_dataset->name = $src_dataset->name;
						$des_dataset->note = $src_dataset->note;
						$des_dataset->createTime = new CDbExpression("NOW()");
						$des_dataset->userId = $newUserId;
						$des_dataset->isImported = 0;
						$des_dataset->hasMeta = $src_dataset->hasMeta;

						$des_dataset->latitude = $src_dataset->latitude;
						$des_dataset->longitude = $src_dataset->longitude;
						$des_dataset->radius = $src_dataset->radius;
						$des_dataset->soundSpeedMin = $src_dataset->soundSpeedMin;
						$des_dataset->soundSpeedMax = $src_dataset->soundSpeedMax;

						if(!$des_dataset->save())
						{
							throw new Exception("dataset saving error");
						}
						// get the original videoId -> dvId
						$src_v2dvId = array();$src_dvId2v = array();
						$data = Text::sql("SELECT D_dataset_video.* FROM D_dataset_video WHERE D_dataset_video.datasetId=:d",array(":d"=>$src_dataset['id']));
						$insertStrArr = array();
						$insertHeader = "(videoId,datasetId,rankScore,thumbnailPath,signAudioPath,changeTime,createTime,rankScoreManual)";
						foreach($data as $one)
						{
							$insertStrArr[] = "(".
								"'".$one['videoId']."'".",".
								"'".$des_dataset['id']."'".",".
								"'".$one['rankScore']."'".",".
								"'".$one['thumbnailPath']."'".",".
								"'".$one['signAudioPath']."'".",".
								"NOW()".",".
								"NOW()".",".
								"'".$one['rankScoreManual']."'".
							")";
							$src_v2dvId[$one['videoId']] = $one['id'];
							$src_dvId2v[$one['id']] = $one['videoId'];
						} 
						Text::sql("INSERT INTO D_dataset_video".$insertHeader." VALUES ".join(",",$insertStrArr),array(),array(),false);
						// get the new dvId2video Id
						$data = Text::sql("SELECT D_dataset_video.* FROM D_dataset_video WHERE D_dataset_video.datasetId=:d",array(":d"=>$des_dataset['id']));
						$des_v2dvId = array();$des_dvId2v = array();
						foreach($data as $one)
						{
							$des_v2dvId[$one['videoId']] = $one['id'];
							$des_dvId2v[$one['id']] = $one['videoId'];
						}
						//D_er_pairs and er_culster,er_global
						// no copying segment results
						$data = Text::sql("SELECT D_er_pairs.* FROM D_er_pairs WHERE D_er_pairs.datasetId=:d AND D_er_pairs.isSegment1=0 AND D_er_pairs.isSegment2=0",array(":d"=>$src_dataset['id']));
						$insertStrArr = array();
						$insertHeader = "(srcId,desId,offset,confidence,auto,userId,changeTime,createTime,datasetId,autoOffset,mark)";
						foreach($data as $one)
						{
							$insertStrArr[] = "(".
								"'".$des_v2dvId[$src_dvId2v[$one['srcId']]]."'".",".
								"'".$des_v2dvId[$src_dvId2v[$one['desId']]]."'".",".
								"'".$one['offset']."'".",".
								"'".$one['confidence']."'".",".
								"'".$one['auto']."'".",".
								"'".$one['userId']."'".",".
								"NOW()".",".
								"NOW()".",".
								"'".$des_dataset['id']."'".",".
								"'".$one['autoOffset']."'".",".
								"'".$one['mark']."'".
							")";
						}
						Text::sql("INSERT INTO D_er_pairs".$insertHeader." VALUES ".join(",",$insertStrArr),array(),array(),false);
						// get all er_cluster
						$data = Text::sql("SELECT D_er_global_clusters.* FROM D_er_global_clusters WHERE D_er_global_clusters.datasetId=:d AND D_er_global_clusters.isDeleted=0",array(":d"=>$src_dataset['id']));

						foreach($data as $one)
						{
							Text::sql("INSERT INTO D_er_global_clusters(datasetId,videoNum,isAuto,refineName,tilerVideoPath) VALUES (:d,:v,:a,:n,NULL)",array(":d"=>$des_dataset['id'],":v"=>$one['videoNum'],":a"=>$one['isAuto']),array(":n"=>$one['refineName']),false);
							$newClusterId = $db->getLastInsertID();
							// get all the original er_result and add to new
							$subData = Text::sql("SELECT D_er_global_results.* FROM D_er_global_results WHERE D_er_global_results.clusterId=:c AND D_er_global_results.datasetId=:d", array(":d"=>$src_dataset['id'], ":c"=>$one['id']));
							$insertHeader = "(clusterId,datasetId,dvId,offset,duration)";
							$insertStrArr = array();
							foreach($subData as $subone)
							{
								$insertStrArr[] = "(".
									"'".$newClusterId."'".",".
									"'".$des_dataset['id']."'".",".
									"'".$des_v2dvId[$src_dvId2v[$subone['dvId']]]."'".",".
									"'".$subone['offset']."'".",".
									"'".$subone['duration']."'".
								")";
							}
							Text::sql("INSERT INTO D_er_global_results".$insertHeader." VALUES ".join(",",$insertStrArr),array(),array(),false);
						}
						// copy the shooter localization stuff
						//-----------------------------------
						// record the old gunshotId -> new gunshotId
						$gunshotIdMapping = array(); 

						$data = Text::sql("SELECT L_gunshot.* FROM L_gunshot WHERE L_gunshot.datasetId=:d AND L_gunshot.isDeleted=0 AND L_gunshot.userId=:u", array(
							":d" => $src_dataset['id'],
							":u" => $userId
						));
						foreach($data as $one)
						{
							// we need to insert new gunshot one-by-one to record the the mapping
							$NewGunshot = new LGunshot();
							$NewGunshot->datasetId = $des_dataset['id'];
							$NewGunshot->gunName = $one['gunName'];
							$NewGunshot->bulletSpeedMin = $one['bulletSpeedMin'];
							$NewGunshot->bulletSpeedMax = $one['bulletSpeedMax'];
							$NewGunshot->note = $one['note'];
							$NewGunshot->userId = $newUserId;
							$NewGunshot->createTime = new CDbExpression("NOW()");
							if(!$NewGunshot->save())
							{
								throw new Exception("New Gunshot saving error");
							}
							$gunshotIdMapping[$one['id']] = $NewGunshot->id;
						}
						
						// gunshot marking table
						$gunshot_str = join(",", array_keys($gunshotIdMapping));
						$gunshot_str = "(".$gunshot_str.")";
						$data = Text::sql("SELECT L_gunshot_in_video.* FROM L_gunshot_in_video WHERE L_gunshot_in_video.gunshotId IN ".$gunshot_str." AND L_gunshot_in_video.isDeleted=0", array());
						foreach($data as $one)
						{
							// insert one by one
							Text::sql("INSERT INTO L_gunshot_in_video(gunshotId,videoId,userId,createTime,muzzleBlastTime,shockwaveTime,latitude,longitude,angleMin,angleMax,elevation) VALUES('".$gunshotIdMapping[$one['gunshotId']]."','".$one['videoId']."','".$newUserId."',NOW(),'".$one['muzzleBlastTime']."','".$one['shockwaveTime']."','".$one['latitude']."','".$one['longitude']."','".$one['angleMin']."','".$one['angleMax']."','".$one['elevation']."')", array(), array(), false);
							// for each of these marking, copy the method 1 estimation
							$gunshotMarkId = Yii::app()->db->getLastInsertID();
							$method1_estimations = Text::sql("SELECT L_method1_runs.* FROM L_method1_runs WHERE L_method1_runs.markerId=:m AND L_method1_runs.isDeleted=0", array(
								":m" => $one['id']
							));
							foreach($method1_estimations as $method1_estimation)
							{
								Text::sql("INSERT INTO L_method1_runs(processId,datasetId,markerId,time_diff,angleMin,angleMax,elevation,userId,min_dist,max_dist,mean_dist,soundSpeedMax,soundSpeedMin,bulletSpeedMin,bulletSpeedMax) VALUES(:p,:d,:m,'".$method1_estimation['time_diff']."','".$method1_estimation['angleMin']."','".$method1_estimation['angleMax']."','".$method1_estimation['elevation']."',:u,'".$method1_estimation['min_dist']."','".$method1_estimation['max_dist']."','".$method1_estimation['mean_dist']."','".$method1_estimation['soundSpeedMax']."','".$method1_estimation['soundSpeedMin']."','".$method1_estimation['bulletSpeedMin']."','".$method1_estimation['bulletSpeedMax']."')", array(
									":p" => $method1_estimation['processId'],
									":d" => $des_dataset['id'],
									":m" => $gunshotMarkId, 
									":u" => $newUserId,
								), array(), false);
							}
						}
					}
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	
//******************************* about dataset operation


	public function actionChangeDataset()
	{
		$request = Yii::app()->request;
		$datasetId = $request->getPost("datasetId",0);
		$datasetName = $request->getPost("datasetName","");
		$datasetNote = $request->getPost("datasetNote","");
		$userId = Yii::app()->session['userId'];
		if(($datasetName != "") && ($datasetNote != ""))
		{
			$result = array(
				"status" => 0,
			);
			if($datasetId == 0)
			{
				$Dataset = new Dataset();
			}
			else
			{
				$Dataset = Dataset::model()->findByPk($datasetId);
			}
			if($Dataset == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$Dataset->name = $datasetName;
				$Dataset->note = $datasetNote;
				$Dataset->userId = $userId;
				$Dataset->createTime = new CDbExpression("NOW()");
				if(!$Dataset->save())
				{
					$result['status'] = 2;
					$result['error'] = $Dataset->getErrors();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteDataset()
	{
		$request = Yii::app()->request;
		$datasetId = $request->getPost("datasetId",0);
		$userId = Yii::app()->session['userId'];
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
			);
			
			$Dataset = Dataset::model()->findByPk($datasetId);
			if($Dataset == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$Dataset->isDeleted=1;
				if(!$Dataset->save())
				{
					$result['status'] = 2;
					$result['error'] = $Dataset->getErrors();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetDatasetList()
	{
		$request = Yii::app()->request;
		$result = array(
			"status" => 0,
			"datasets" => array(),
		);
		$Datasets = Dataset::model()->findAll("isDeleted=0 ORDER BY id DESC");
		foreach($Datasets as $Dataset)
		{
			$result['datasets'][] = $Dataset->attributes;
		}
		echo Text::json_encode_ch($result);
	}
//***********************************************************get videos
	public function actionImportVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoList = $request->getPost("videoList",array());
		$filepath = $request->getPost("filepath","");

		$makeDataset = $request->getPost("makeDataset",0);
		$datasetName = $request->getPost("datasetName","");

		if($filepath != "")
		{
			// read the local file to get videoList
			if(file_exists($filepath) && is_readable($filepath))
			{
				set_time_limit(0);
				$file_handle = fopen($filepath,"r");
				while(!feof($file_handle))
				{
					$line = trim(fgets($file_handle));
					if($line != "")
					{
						$things = explode(" ",$line);
						if(count($things) > 1)
						{
							$oneVideo = array(
								"originalPath" => $things[0],
								"metaPath" => $things[1]
							);
						}
						else
						{
							$oneVideo = array(
								"originalPath" => $line,
								"metaPath" => ""
							);
						}
						// check for ghost
						$things = explode("/",$oneVideo['originalPath']);
						if((count($things) == 2) && ($things[0] == "ghost"))
						{
							$oneVideo['originalPath'] = $things[1];
							$oneVideo['isGhost'] = 1;
						}
						else
						{
							$oneVideo['isGhost'] = 0;
						}
						$videoList[] = $oneVideo;
					}
				}
				fclose($file_handle);
			}
		}

		$websitePath = f::get("videoPath");//path for website videos
		$websiteRealPath = realpath($websitePath);
		//echo $websiteRealPath;//  : /opt/lampp/htdocs/daisy/assets/videos
		$imgPath = realpath(f::get("videoImgPath"));//video preview img path
		
		if(count($videoList)>0)
		{
			$result = array(
				"status" => 0,
				"dataError" => array(),
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try{
				// we get a detailed list with video basename,related path and absolute path, ruled out that can be ignore
				$videoListProcessed = array(
					"addToDatabase" => array(), // the ones only need to add into database(or change something)
					"ignore" => array(),//orignal path not exists, 
					"furtherProcess" => array(), //ask python to further process.(resizing and copying)
					"ghost" => array(),
				);
				$videoIds = array();// video ids that directly into database
				$allHasMeta = true;
				foreach($videoList as $video)
				{
					$one = $video['originalPath'];
					$metaPath = trim($video['metaPath']); // absolute path to json metadata file
					if($metaPath == "")
					{
						$allHasMeta = false;
					}
					$isGhost = $video['isGhost']==1?true:false; // whether to treat this video as a ghost video. no processPath and Original Path

					$temp = array(
						"basename" => basename($one),
						"relatedPath" => $websitePath.basename($one), //directly watch path
						"websitePath" => realpath($websitePath.basename($one)),// website version //if not exists, will be false
						"originPath" => $one,// the original video
						"websiteExists" => file_exists(realpath($websitePath.basename($one))), // check if this video's website versioin exists
						"originExists" => file_exists($one),
						"websiteP" => realpath($websitePath),// realpath to videos of the website
						"metaPath" => $metaPath,
					);
					if($isGhost)//ghost video, directly add to database, no relatedPath,processPath
					{
						if($temp['basename'] != "")
						{
							$videoListProcessed['addToDatabase'][] = $temp;
							$videoListProcessed['ghost'][] = $temp;
							$Video = Videos::model()->find("name=:videoname",array(":videoname"=>$temp["basename"]));
							if(($Video == null) || ($Video->metaPath != $temp['metaPath']))// only add if the original video not exists, or the metaPath has changed
							{
								if($Video == null)
								{
									$Video = new Videos();
									$Video->createTime = new CDbExpression("NOW()");
									$Video->name = $temp['basename'];
									$Video->userId = $userId;
									$Video->relatedPath = "";
									$Video->processPath = "";
								}
								$Video->changeTime = new CDbExpression("NOW()");
								$Video->metaPath = $temp['metaPath'];
								if(!$Video->save())
								{
									$temp['error'] = $Video->getErrors();
									$result['dataError'][] = $temp;
									//$result['status'] = 1;
									throw new Exception("ghost video save error");
								}
							}
							$videoIds[] = $Video->id;
						}
					}
					else
					{
						//process
						if(!$temp['originExists'])
						{
							$videoListProcessed['ignore'][] = $temp;
						}
						else if($temp['originExists'] && $temp['websiteExists'])
						{
							//metaPath will change only if here
							//warning, if given a new ori_path of a same video existed in the website, we only modified the ori_path, we assume the original video doesn't change.
							// so you can copy the whole website to some place, and change the ori_path really quickly
							$videoListProcessed['addToDatabase'][] = $temp;
							//see wher the filename exists
							$Video = Videos::model()->find("name=:videoname",array(":videoname"=>$temp["basename"]));
							if($Video == null)
							{
								$Video = new Videos();
								$Video->createTime = new CDbExpression("NOW()");
								$Video->name = $temp['basename'];
							}
							$Video->changeTime = new CDbExpression("NOW()");
							$Video->userId = $userId;
							$Video->relatedPath = $temp['relatedPath'];
							$Video->processPath = $temp['originPath'];
							$Video->metaPath = $temp['metaPath'];
							if(!$Video->save())
							{
								$temp['error'] = $Video->getErrors();
								$result['dataError'][] = $temp;
								//$result['status'] = 1;
								throw new Exception("video save error");
							}
							$videoIds[] = $Video->id;
						}else
						{
							$videoListProcessed['furtherProcess'][] = $temp;
						}
					}
				}
				//whther to make dataset of it
				$datasetId = 0 ;
				if(($makeDataset == 1) && ($datasetName != ""))
				{
					//check whether the dataset exists
					$Dataset = Dataset::model()->find("name=:d",array(":d"=>$datasetName));
					if($Dataset == null)
					{
						$Dataset = new Dataset();
						$Dataset->name = $datasetName;
						$Dataset->note = "direct make from video Import";
						$Dataset->userId = $userId;
						$Dataset->createTime = new CDbExpression("NOW()");
					}
						
					$Dataset->hasMeta = ($allHasMeta && ($Dataset->hasMeta==1))?1:0;

					$Dataset->isSearch = 0;
					$Dataset->searchContent = "";
					$Dataset->isImported = 0;
					if(!$Dataset->save())
					{
						throw new CDbException("Dataset Save error");
						//$result['status'] = 11;
					}
					else
					{
						foreach($videoIds as $videoId)
						{
							$DV = new DatasetVideo();
							$DV->datasetId = $Dataset->id;
							$DV->videoId = $videoId;
							$DV->createTime = new CDbExpression("NOW()");
							$DV->changeTime = new CDbExpression("NOW()");
							if(!$DV->save())
							{
								throw new CDbExpression("DV save error");
								//$result['status'] = 12;
							}
						}
					}
				}
				//get the process Id then post the job
				$result['processStatus'] = -1;//nothing for further process
				if(count($videoListProcessed['furtherProcess']) > 0)
				{
					//not use transaction, since python could fail anyway
					$result['processStatus'] = 0;// sucessfully submit process job
					$Process = new Process();
					$Process->type = 1;
					$Process->createTime = new CDbExpression("NOW()");
					$Process->changeTime = new CDbExpression("NOW()");
					$Process->userId = $userId;
					if(!$Process->save())
					{
						$result['processStatus'] = 1;//couldn't save process.
					}
					else
					{
						//post job to python
						Yii::import("application.extensions.PP");
						$callback = PP::cb("importVideos");
						
							PP::ppython_asyn("run::importVideos",$Process->id,$callback,$videoListProcessed['furtherProcess'],$userId,true,$imgPath,$datasetId);
							$result['processId'] = $Process->id;
						
						//	$result['processStatus'] = 2;// send to python error
						//	$result['processError'] = $e->getMessage();
						
					}
				}
				$result['count'] = array(
					'furtherProcess' => count($videoListProcessed['furtherProcess']),
					'addToDatabase' => count($videoListProcessed['addToDatabase']),
					'ignore' => count($videoListProcessed['ignore']),
					"ghost" => count($videoListProcessed['ghost'])
				);
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 1;
				$result['errorMsg'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	// import audio sync exp result
	public function actionImportAudioSyncResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$runName = $request->getPost("runName","");
		$resultFile = $request->getPost("resultfile","");
		$username = $request->getPost("username","");
		if(($runName != "") && ($resultFile != "") && ($username != ""))
		{
			$result = array(
				"status" => 0,
			);
			$resultFile = trim($resultFile);
			//check username fist
			$User = User::model()->find("userName=:u",array(":u"=>$username));
			if($User == NULL)
			{
				$result['status'] = 1;
			}
			else if(!file_exists($resultFile))
			{
				$result['status'] = 2;
			}
			else
			{
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 16;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['processStatus'] = 1;//couldn't save process.
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("importAudioSyncResult");
					try
					{
						PP::ppython_asyn("run::importAudioSyncResult",$Process->id,$callback,$resultFile,$User->userId,$runName);
						$result['processId'] = $Process->id;
					}
					catch(Exception $e)
					{
						$result['processStatus'] = 2;// send to python error
						$result['processError'] = $e->getMessage();
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionImportGunshotResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$runName = $request->getPost("runName","");
		$resultFile = $request->getPost("resultfile","");
		$username = $request->getPost("username","");
		if(($runName != "") && ($resultFile != "") && ($username != ""))
		{
			$result = array(
				"status" => 0,
			);
			$resultFile = trim($resultFile);
			//check username fist
			$User = User::model()->find("userName=:u",array(":u"=>$username));
			if($User == NULL)
			{
				$result['status'] = 1;
			}
			else if(!file_exists($resultFile))
			{
				$result['status'] = 2;
			}
			else
			{
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 17;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['processStatus'] = 1;//couldn't save process.
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("importGunshotResult");
					try
					{
						PP::ppython_asyn("run::importGunshotResult",$Process->id,$callback,$resultFile,$User->userId,$runName);
						$result['processId'] = $Process->id;
					}
					catch(Exception $e)
					{
						$result['processStatus'] = 2;// send to python error
						$result['processError'] = $e->getMessage();
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	//*********************** given ranklist path, import result directly

	public function actionImportResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$userName = $request->getPost("userName","");
		//$videoList = $request->getPost("videoList",array());//ranklist file list
		$runName = $request->getPost("runName","");
		$filelstpath = $request->getPost("filelst","");
		// send the filelst path directly
		if(($runName != "") && ($filelstpath != "") && ($userName != ""))
		{
			$result = array(
				"status" => 0,
				"dataError" => array(),
			);
			// find the user first
			$User = User::model()->find("userName=:u",array(":u"=>$userName));
			if($User == NULL)
			{
				$result['status'] = 1;
			}
			else
			{
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 5;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['processStatus'] = 1;//couldn't save process.
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("importResult");
					try
					{
						PP::ppython_asyn("run::importResult",$Process->id,$callback,$filelstpath,$User->userId,$runName);
						$result['processId'] = $Process->id;
					}
					catch(Exception $e)
					{
						$result['processStatus'] = 2;// send to python error
						$result['processError'] = $e->getMessage();
					}
					
				}
			}
			echo Text::json_encode_ch($result);
		}
		/*
		// not sending a whole list now, python takes forever
		if(($runName != "") && ($filelstpath != ""))
		{
			$videoList = Text::readFilelst($filelstpath);
		}
		
		if(count($videoList)>0)
		{
			$result = array(
				"status" => 0,
				"dataError" => array(),
			);
			$videoListProcessed = array(
				"ignore" => array(),//video not exists in database, 
				"furtherProcess" => array(), //ask python to further process. get ranklist
			);
			foreach($videoList as $one)
			{
				$temp = array(
					"videoname" => basename($one,".txt").".mp4",
					"ranklistPath" => $one,
				);
				//process
				if(!Videos::model()->exists("name=:v",array(":v"=>$temp['videoname'])))
				{
					$videoListProcessed['ignore'][] = $temp;
				}
				else
				{
					$videoListProcessed['furtherProcess'][] = $temp;
				}
			}
			//get the process Id then post the job
			$result['processStatus'] = -1;//nothing for further process
			if(count($videoListProcessed['furtherProcess']) > 0)
			{
				//not use transaction, since python could fail anyway
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 5;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['processStatus'] = 1;//couldn't save process.
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("importResult");
					try
					{
						PP::ppython_asyn("run::importResult",$Process->id,$callback,$videoListProcessed['furtherProcess'],$userId,$runName);
						$result['processId'] = $Process->id;
					}
					catch(Exception $e)
					{
						$result['processStatus'] = 2;// send to python error
						$result['processError'] = $e->getMessage();
					}
				}
			}
			$result['count'] = array(
				'furtherProcess' => count($videoListProcessed['furtherProcess']),
				'ignore' => count($videoListProcessed['ignore']),
			);
			echo Text::json_encode_ch($result);
		}*/
	}
//*********************************************dataset video management
	public function actionGetDatasetVideos()
	{
		// get all videos, each one check dataset belongings
			//in the future , this needs to be limit length// and change to sql
		$request = Yii::app()->request;
		$result = array(
			"status" => 0,
			"videos" => array(),
		);
		$userId = Yii::app()->session['userId'];
		//get all videos 
		$Videos = Videos::model()->findAll();
		$videoIds = array();
		foreach($Videos as $Video)
		{
			$videoIds[] = $Video->id;
			$temp = $Video->attributes;
			$temp['toDatasets'] = array();
			$result['videos'][$Video->id] = $temp;
		}
		// for each video ,get all its datasetVideo relations
		/*
			$criteria=new CDbCriteria;
			$criteria->select='title';  // only select the 'title' column
			$criteria->condition='postID=:postID';
			$criteria->params=array(':postID'=>10);
		*/
			$criteria = new CDbCriteria();
			$criteria->addInCondition("videoId",$videoIds);
			$criteria->order = "id DESC";
			$datasetVideos = DatasetVideo::model()->findAll($criteria);
			foreach($datasetVideos as $datasetVideo)
			{
				if(array_key_exists($datasetVideo->videoId,$result['videos']))
				{
					$result['videos'][$datasetVideo->videoId]['toDatasets'][] = $datasetVideo->datasetId;
				}
			}
			echo Text::json_encode_ch($result);
	}
	//get one dataset info of datasetVideo
	public function actionGetDatasetVideo()
	{
		// get all videos, each one check dataset belongings
			//in the future , this needs to be limit length// and change to sql
		$request = Yii::app()->request;
		$result = array(
			"status" => 0,
			"videos" => array(),
		);
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
			);
			$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
				" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.rankScore DESC";
			$result['videos'] = Text::sql($cmd,array(":d"=>$datasetId));
			echo Text::json_encode_ch($result);
		}
	}
	//datasetVideo preprocessing
	public function actionPreproDatasetVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videos = $request->getPost("videos",array());// include dv Id and videoId
		if(count($videos) > 0)
		{
			$result = array(
				"status" => 0
			);
			try
			{
				$videoList = array();
				foreach($videos as $video)
				{
					$temp = array();
					// get video basename,, mkdir asset/stuff/basename/
					$Video = Videos::model()->findByPk($video['videoId']);
					if($Video == null)
					{
						throw new Exception("video ".$video['videoId']." not exists");
						break;
					}
					$temp['processPath'] = $Video->processPath;
					$temp['dvId'] = $video['dvId'];
					$temp['basename'] = $Video->name;
					//check the stuff path exists or not, if not then create path.
					$pathToStuff = realpath(f::get("videoStuffPath"))."/".$temp['basename'];
					if(!file_exists($pathToStuff))
					{
						$oldmask = umask(0);
						mkdir($pathToStuff,0777,true);
						umask($oldmask);
					}
					$temp['thumbnailpath'] = $pathToStuff."/".f::get("videopreimagename");
					$temp['signaudiopath'] = $pathToStuff."/".f::get("videopresignaudioname");
					$temp['videoId'] = $video['videoId'];
					$videoList[] = $temp;
				}
				// generate a process
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 2;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['processStatus'] = 1;//couldn't save process.
					throw new Exception("process can't save");
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("preprocessVideos");
					
					PP::ppython_asyn("run::preprocessing",$Process->id,$callback,$videoList);
					$result['processId'] = $Process->id;

				}
			}catch(Exception $e)
			{
				$result['errorInfo'] = $e->getMessage();
			}
			 
			echo Text::json_encode_ch($result);
		}
	}
	//add videos to datasets
	public function actionAddDatasetVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoIds = $request->getPost("videoIds",array());
		$datasetIds = $request->getPost("datasetIds",array());
		if((count($videoIds)>0)&&(count($datasetIds)>0))
		{
			$result = array(
				"status" => 0,
				"added" => array(),
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try
			{
				foreach($datasetIds as $datasetId)
				{
					foreach($videoIds as $videoId)
					{

						$DV = DatasetVideo::model()->find("videoId=:v AND datasetId=:d",array(
							":v" => $videoId,
							":d" => $datasetId,
						));
						if($DV == null)
						{
							$DV = new DatasetVideo();
							$DV->videoId = $videoId;
							$DV->datasetId = $datasetId;
							$DV->createTime = new CDbExpression("NOW()");
							$DV->changeTime = new CDbExpression("NOW()");
							if(!$DV->save())
							{
								throw new Exception("save error");
								break;
							}
							else
							{
								$result['added'][] = array(
									"dvId" => $DV->id,
									"videoId" => $videoId,
									"datasetId" => $datasetId,
								);
							}
						}
					}
					//check all video and see whether all has metadata
					$CountAll = Text::sql("SELECT COUNT(*) as a FROM D_dataset_video WHERE D_dataset_video.datasetId=:d",array(":d"=>$datasetId))[0]['a'];
					$CountHasMeta = Text::sql("SELECT COUNT(*) as a FROM D_dataset_video,D_videos WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id AND D_videos.metaPath <> ''",array(":d"=>$datasetId))[0]['a'];

					$Dataset = Dataset::model()->findByPk($datasetId);
					if($CountAll == $CountHasMeta)
					{
						$Dataset->hasMeta = 1;
					}
					else
					{
						$Dataset->hasMeta = 0;
					}
					if(!$Dataset->save())
					{
						throw new Exception("save error2");
					}
				}

				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 1;//something is wrong
				$result['errorInfo'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	//delete video to datasets
	public function actionDeleteDatasetVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoIds = $request->getPost("videoIds",array());
		$datasetId = $request->getPost("datasetId",0);
		if((count($videoIds)>0)&&($datasetId != 0))
		{
			$result = array(
				"status" => 0,
				"deleted" => array(),
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try
			{
				foreach($videoIds as $videoId)
				{
					$DV = DatasetVideo::model()->find("videoId=:v AND datasetId=:d",array(
						":v" => $videoId,
						":d" => $datasetId,
					));
					if($DV != null)
					{
						$dvId = $DV->id;
						$DV->delete();
						$result['deleted'][] = array(
							"dvId" => $dvId,
							"videoId" => $videoId,
							"datasetId" => $datasetId,
						);
					}
				}
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 1;//something is wrong
				$result['errorInfo'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	
	//*****************************************************************run event reconstruction
	public function actionRunER()
	{
		$request = Yii::app()->request;
		$datasetId = $request->getPost("datasetId",0);
		$userId = Yii::app()->session['userId'];
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0
			);
			try
			{
				// get all the current video list and dataset name
				$Dataset = Dataset::model()->findByPk($datasetId);
				$push = array();
				if($Dataset != null)
				{
					$push['datasetname'] = $Dataset->name;
					$push['datasetId'] = $Dataset->id;
					//get all the dv
					$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
						" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id DESC";
					$push['videos'] = Text::sql($cmd,array(":d"=>$datasetId));
					if(count($push['videos']) == 0)
					{
						throw new Exception("e:no videos!");
					}
					// generate a process
					$result['processStatus'] = 0;// sucessfully submit process job
					$Process = new Process();
					$Process->type = 3;
					$Process->createTime = new CDbExpression("NOW()");
					$Process->changeTime = new CDbExpression("NOW()");
					$Process->userId = $userId;
					if(!$Process->save())
					{
						$result['processStatus'] = 1;//couldn't save process.
						throw new Exception("process can't save");
					}
					else
					{
						//post job to python
						Yii::import("application.extensions.PP");
						$callback = PP::cb("eventReconstruction");
						
						PP::ppython_asyn("run::eventReconstruction",$Process->id,$callback,$push);
						$result['processId'] = $Process->id;

					}
				}
				else
				{
					throw new Exception("e:dataset not exists");
				}
			}catch(Exception $e)
			{
				$result['errorInfo'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}

	public function actionGetResultsER()
	{
		$request = Yii::app()->request;
		$datasetId = $request->getPost("datasetId",0);
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
			);
			//get all video from dv, then search for result for each one
			$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
						" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id DESC";
			$result['videos'] = Text::sql($cmd,array(":d"=>$datasetId));
			foreach($result['videos'] as &$one)
			{
				//serach for results
					//no segment results
				$cmd = "SELECT D_er_pairs.*,D_videos.*,D_videos.name AS videoname from D_er_pairs,D_videos,D_dataset_video ".
					" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.datasetId=:d".
					" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id ORDER BY D_er_pairs.confidence DESC";
				$one['ranklist'] = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$one['dvId']));
			}

			echo Text::json_encode_ch($result);
		}
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',
			//后面是各个方法的filter
			'isSuper',
		);
	}
	public function filterIsSuper($filterChain)
	{
		$User = User::model()->findByPk(Yii::app()->session['userId']);
		if(($User == null) || ($User->isSuper == 0))
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
		Yii::import("application.extensions.f");
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