<?php

class PythonController extends Controller
{
	public function actionGetVideoFramesDone()
	{
		$request = Yii::app()->request;
		$userId = $request->getPost("userId", 0);
		$videoId = $request->getPost("videoId", 0);
		$fps = $request->getPost("fps", -1);
		$num_frame = $request->getPost("num_frame", -1);
		if(($userId != 0) && ($videoId != 0))
		{
			$result = array(
				"status" => 0
			);
			$Video = Videos::model()->findByPk($videoId);
			if(($Video == NULL) || ($Video->userId != $userId))
			{
				$result['status'] = 1;
			}
			else
			{
				$Video->fps = $fps;
				$Video->num_frame = $num_frame;
				if(!$Video->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGunshotClassification()
	{
		$request = Yii::app()->request;
		$runId = $request->getPost("runId",0);
		$scores = $request->getPost("scores",array());
		if(($runId != 0) && (count($scores) > 0))
		{
			$result = array(
				"status" => 0
			);
			$Run = GunshotClassification::model()->findByPk($runId);
			if(($Run == NULL))
			{
				$result['status'] = 1;
			}
			else
			{
				$Run->result = Text::json_encode_ch($scores);
				$Run->hasResult = 1;
				if(!$Run->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// gunshot localization method 1
	public function actionGunshotMethod1()
	{
		$request = Yii::app()->request;
		$datasetId = $request->getPost("datasetId", -1);
		$userId = $request->getPost("userId", -1);
		$processId = $request->getPost("processId", -1);
		$markers = $request->getPost("markers", array());
		if(($datasetId != -1) && (count($markers) > 0) && ($processId != -1) && ($userId != -1))
		{
			$result = array(
				"status" => 0
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try{
				foreach($markers as $marker)
				{
					$Result = new Method1Runs();
					$Result->processId = $processId;
					$Result->datasetId = $datasetId;
					$Result->userId = $userId;

					$Result->markerId = $marker['markerId'];
					$Result->time_diff = $marker['time_diff'];
					$Result->angleMin = $marker['angleMin'];
					$Result->angleMax = $marker['angleMax'];
					$Result->soundSpeedMin = $marker['soundSpeedMin'];
					$Result->soundSpeedMax = $marker['soundSpeedMax'];
					$Result->bulletSpeedMin = $marker['bulletSpeedMin'];
					$Result->bulletSpeedMax = $marker['bulletSpeedMax'];
					$Result->elevation = $marker['elevation'];

					$Result->min_dist = $marker['min_dist'];
					$Result->max_dist = $marker['max_dist'];
					$Result->mean_dist = $marker['mean_dist'];
					if(!$Result->save())
					{
						throw new Exception(json_encode($Result->getErrors()));
					}
				}
			
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				$result['error'] = $e->getMessage();
				$result['status'] = 2;
			}
			
			echo Text::json_encode_ch($result);
		}
	}
	
	public function actionModelTrain()
	{
		$request = Yii::app()->request;
		$modelName = $request->getPost("modelname","");
		$type = $request->getPost("type","");
		$modelpath = $request->getPost("modelpath","");
		$userId = $request->getPost("userId",-1);
		if(
			($modelName != "") &&
			($type != "") && 
			($modelpath != "") && 
			($userId != -1)
		)
		{
			$result = array(
				"status" => 0,
			);
			$Model = New Models();
			$Model->modelname = $modelName;
			$Model->userId = $userId;
			$Model->modelpath = $modelpath;
			$Model->isDone = 1;
			$Model->type = $type;
			$Model->isDefault= 0;
			if(!$Model->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGunshotFeatureExtraction()
	{
		$request = Yii::app()->request;
		$labelId = $request->getPost("labelId",0);
		$filelstpath = $request->getPost("filelstpath","");
		$featureName = $request->getPost("featureName","");
		$type = $request->getPost("type","");
		$pos = $request->getPost("pos",-2);
		if(
			($labelId != 0) &&
			($filelstpath != "") &&
			($featureName != "") &&
			($type != "") &&
			($pos != -2)
		)
		{
			$result = array(
				"status" => 0,
			);
			$Feature = new Features();
			$Feature->filelstpath = $filelstpath;
			$Feature->featureName = $featureName;
			$Feature->labelId = $labelId;
			$Feature->type = $type;
			$Feature->pos = $pos;
			if(!$Feature->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionProgress()
	{
		$request = Yii::app()->request;
		$processId = $request->getPost("processId",0);
		$message = $request->getPost("message","");
		$done = $request->getPost("done",0);
		$progress = $request->getPost("progress",0);
		if($processId != 0)
		{
			$Process = Process::model()->findByPk($processId);
			if($Process != null)
			{
				$result = array(
					"status" => 0,
				);
				$Process->progress = $progress;
				$Process->done = $done;
				$Process->message = $message;
				$Process->changeTime = new CDbExpression("NOW()");
				if(!$Process->save())
				{
					$result['status'] = 1;//saving fail
				}
				echo Text::json_encode_ch($result);
			}
		}
	}
	public function actionGunshotDetection()
	{
		$request = Yii::app()->request;
		$scoreList = $request->getPost("scores",array());
		$runId = $request->getPost("runId",0);
		if($runId != 0)
		{
			$result = array(
				"status" => 0
			);
			$GunshotRun = GunshotRun::model()->findByPk($runId);
			if(($GunshotRun!=NULL) && ($GunshotRun->haveResult == 0))
			{
				foreach($scoreList as $score)
				{
					$GunshotResult = new GunshotResults();
					$GunshotResult['runId'] = $runId;
					$GunshotResult['startSec'] = $score['startSec'];
					$GunshotResult['endSec'] = $score['endSec'];
					$GunshotResult['score'] = $score['score'];
					$GunshotResult['type'] = $score['type'];
					if(!$GunshotResult->save())
					{
						$result['status'] = 1;
					}
				}
				$GunshotRun->haveResult = 1;
				if(!$GunshotRun->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}

	public function actionImportVideos()
	{
		$request = Yii::app()->request;
		$userId = $request->getPost("userId",0);
		$videoList = $request->getPost("videoList",array());
		$hasImgs = $request->getPost("hasImgs",0);
		$imgCount =  $request->getPost("imgCount",0);
		$websitePath = f::get("videoPath");//path for website videos
		$datasetId = $request->getPost("datasetId",0);// whether to add to a existing dataset
		// whether to appoint a dataset for all the videos
		$makeDataset = $request->getPost("makeDataset",0);
		//dataset name
		$datasetName = $request->getPost("datasetName","");
		//note
		$datasetNote = $request->getPost("datasetNote","");
		$isSearch = $request->getPost("isSearch",0);
		$searchContent = $request->getPost("searchContent","");
		if(($userId != 0) && (count($videoList) != 0))
		{
			$result = array(
				"status" => 0
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try
			{
				//add to the database
				$allHasMeta = true;
				$videoIds = array();
				foreach($videoList as $video)
				{
					$VideoIn = Videos::model()->find("name=:n",array(":n"=>$video['basename']));
					if($VideoIn == null)
					{
						$VideoIn = new Videos();
						$VideoIn->createTime = new CDbExpression("NOW()");
						$VideoIn->name = $video['basename'];
					}
					$VideoIn->changeTime = new CDbExpression("NOW()");
					$VideoIn->userId = $userId;
					if(!isset($video['relatedPath']))
					{
						$video['relatedPath'] = $websitePath.$video['basename'];
					}
					$VideoIn->relatedPath = $video['relatedPath'];
					$VideoIn->processPath = $video['originPath'];
					$VideoIn->duration = $video['duration'];
					$VideoIn->hasImgs = $hasImgs;
					$VideoIn->imgCount = $imgCount;
					if(isset($video['metaPath']))
					{
						$VideoIn->metaPath = $video['metaPath'];
					}
					else
					{
						$allHasMeta = false;
					}
					if(!$VideoIn->save())
					{
						//$video['error'] = $VideoIn->getErrors();
						$result['dataError'][] = $video;
						//$result['status'] = 1;
						throw new Exception("Video save error");
					}
					$videoIds[] = $VideoIn->id;
				}
				//if the dataset is needed to go 
				if(($makeDataset == 1) && ($datasetName != ""))
				{
					$Dataset = new Dataset();
					$Dataset->name = $datasetName;
					$Dataset->note = $datasetNote;
					$Dataset->userId = $userId;
					$Dataset->createTime = new CDbExpression("NOW()");
					$Dataset->hasMeta = $allHasMeta?1:0;
					$Dataset->isSearch = $isSearch;
					$Dataset->searchContent = $searchContent;
					$Dataset->isImported = 0;
					if(!$Dataset->save())
					{
						throw new CDbException("Dataset Save error");
					}
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
						}
					}
				}else if($datasetId != 0)
				{
					$Dataset = Dataset::model()->findByPk($datasetId);
					if($Dataset != null)
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
							}
						}
					}
					else
					{
						throw new Exception("datasetId $datasetId not found");
					}
				}
				$transaction->commit();
			}
			catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 1;
				$result['error'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionPreprocessVideos()
	{
		$request = Yii::app()->request;
		$videoList = $request->getPost("results",array());
		if(count($videoList)>0)
		{
			$result = array(
				"status" => 0
			);
			//add to the database
			foreach($videoList as $video)
			{
				$dvId = $video['dvId'];
				$score = (float)$video['score'];
				$basename = $video['basename'];
				//path to stuff is predefined, assume they are there
				$thumbnailpath = f::get("videoStuffPath").$basename."/".f::get("videopreimagename");
				$signaudiopath = f::get("videoStuffPath").$basename."/".f::get("videopresignaudioname");
				$DV = DatasetVideo::model()->findByPk($dvId);
				if($DV != null)
				{
					$DV->rankScore = $score;
					$DV->thumbnailPath = $thumbnailpath;
					$DV->signAudioPath = $signaudiopath;
					$DV->changeTime = new CDbExpression("NOW()");
					if(!$DV->save())
					{
						$result['status'] = 2;//saving error
						$result['errorInfo'] = $DV->getErrors();
					}
				}
				else
				{
					$result['status'] = 1;//dv not exists
				}
			}
			echo Text::json_encode_ch($result);
		}
	}

	public function actionEventReconstruction()// counld be refining result, no ranklists
	{
		$request = Yii::app()->request;
		$results = $request->getPost("results",array());
		if(count($results)>0)
		{
			$result = array(
				"status" => 0
			);
			//add to the database
			$db = Yii::app()->db;
			$transation = $db->beginTransaction();
			try
			{
				foreach($results['ranklists'] as $video)
				{
					$dvId = $video['dvId'];
					$datasetId = $video['datasetId'];
					foreach($video['ranklist'] as $one)
					{
						$ERpair = ERpairs::model()->find("datasetId=:data AND srcId=:s AND desId=:des AND isSegment1=0 AND isSegment2=0",
							array(":data"=>$datasetId,":s"=>$dvId,":des"=>$one['dvId']));
						if($ERpair == null)
						{
							$ERpair = new ERpairs();
							$ERpair->datasetId = $datasetId;
							$ERpair->srcId = $dvId;
							$ERpair->desId = $one['dvId'];
							$ERpair->createTime = new CDbExpression("NOW()");
						}
						$ERpair->offset = (float)$one['offset'];
						$ERpair->confidence = (float)$one['score'];
						$ERpair->changeTime = new CDbExpression("NOW()");
						if(!$ERpair->save())
						{
							throw new Exception("pari save error");
						}
					}
				}
				// load global results
				$clusterNum = count($results['global']);
				for($i=0;$i<$clusterNum;++$i)
				{
					$Cluster = new ERclusters();
					$Cluster->videoNum = count($results['global'][$i]);
					$Cluster->datasetId = $results['datasetId'];
					if(isset($results['globalResultName']) && ($results['globalResultName'] != ""))
					{
						$Cluster->refineName = $results['globalResultName'];
					}
					if(!$Cluster->save())
					{
						throw new Exception("cluster save error");
					}
					foreach($results['global'][$i] as $one)
					{
						$globalResult = new ERresults();
						$globalResult->clusterId = $Cluster->id;
						$globalResult->datasetId = $results['datasetId'];
						$globalResult->offset = $one['offset'];
						// for refining, no dvId given
						if(!isset($one['dvId']) || !isset($one['duration']))
						{
							$Video = Videos::model()->find("name=:n",array(":n"=>$one['videoname']));
							if($Video == null)
							{
								throw new Exception("no video: ".$one['videoname']);
							}
							if($Video->duration < 0)
							{
								$Video->duration = Videos::getDuration($Video->processPath);
								if(!$Video->save())
								{
									throw new Exception("Video duration update error");
								}
							}
							$one['duration'] = $Video->duration;
							$DV = DatasetVideo::model()->find("videoId=:v AND datasetId=:d",array(":v"=>$Video->id,":d"=>$results['datasetId']));
							if($DV == null)
							{
								throw new Exception("DV not found");
							}
							$one['dvId'] = $DV->id;
						}

						$globalResult->dvId = $one['dvId'];			
						$globalResult->duration = $one['duration'];

						if(!$globalResult->save())
						{
							throw new Exception("global result save error");
						}
					}
				}
				$transation->commit();
			}catch(Exception $e)
			{
				$transation->rollback();
				$result['status'] = 1;
				$result['error'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionImportAudioSyncResult()
	{
		$request = Yii::app()->request;
		$results = $request->getPost("results",array());
		$runName = $request->getPost("runName","");
		$userId = $request->getPost("userId",0);
		if((count($results)>0) && ($runName != "") && ($userId != 0))
		{
			$result = array(
				"status" => 0
			);
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				$AudioSyncExp = new AudioSyncExp();
				$AudioSyncExp->userId = $userId;
				$AudioSyncExp->runName = $runName;
				$AudioSyncExp->createTime = new CDbExpression("NOW()");
				if(!$AudioSyncExp->save())
				{
					throw new Exception("exp save error");
				}
				foreach($results as $pair)
				{
					$Video1 = Videos::model()->find("name=:n",array(":n"=>$pair['video1'].".mp4"));
					$Video2 = Videos::model()->find("name=:n",array(":n"=>$pair['video2'].".mp4"));
					if(($Video1 == NULL) || ($Video2 == NULL))
					{
						throw new Exception("video no in database:".$pair['video1']." - ".$pair['video2']);
					}
					$one = new AudioSyncExpPairs();
					$one->expId = $AudioSyncExp->id;
					$one->videoId1 = $Video1->id;
					$one->videoId2 = $Video2->id;
					$one->offset = $pair['offset'];
					$one->evidenceStart = $pair['evidenceStart'];
					$one->evidenceLast = $pair['evidenceLast'];
					$one->score = $pair['score'];
					$one->rank = $pair['rank'];
					$one->createTime = new CDbExpression("NOW()");
					$one->changeTime = new CDbExpression("NOW()");
					if(!$one->save())
					{
						throw new Exception("pair save error");
					}
				}
				$transaction->commit();
			}catch(Exception $e)
			{
				$result['status'] = 1;
				$result['errorMessage'] = $e->getMessage();
				$transaction->rollback();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionImportGunshotResult()
	{
		$request = Yii::app()->request;
		$results = $request->getPost("results",array());
		$runName = $request->getPost("runName","");
		$userId = $request->getPost("userId",0);
		if((count($results)>0) && ($runName != "") && ($userId != 0))
		{
			$result = array(
				"status" => 0
			);
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				
				$GunshotExp = new GunshotExp();
				$GunshotExp->userId = $userId;
				$GunshotExp->runName = $runName;
				$GunshotExp->createTime = new CDbExpression("NOW()");
				if(!$GunshotExp->save())
				{
					throw new Exception("exp save error");
				}
				foreach($results as $item)
				{
					$Video = Videos::model()->find("name=:n",array(":n"=>$item['video'].".mp4"));
					
					if($Video == NULL)
					{
						throw new Exception("video no in database:".$item['video']);
					}
					
					$one = new GunshotExpLists();
					$one->expId = $GunshotExp->id;
					$one['videoId'] = $Video->id;
					$one['rankScore'] = $item['rankScore'];
					$one['segmentJson'] = $item['segmentJson'];
					$one['gunshotCountJson'] = $item['gunshotCountJson'];
					$one['rank'] = $item['rank'];
					$one->createTime = new CDbExpression("NOW()");
					if(!$one->save())
					{
						throw new Exception("pair save error");
					}
				}
				$transaction->commit();
			}catch(Exception $e)
			{
				$result['status'] = 1;
				$result['errorMessage'] = $e->getMessage();
				$transaction->rollback();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionImportResult()
	{
		$request = Yii::app()->request;
		$results = $request->getPost("results",array());
		$runName = $request->getPost("runName","");
		$userId = $request->getPost("userId",0);
		if((count($results)>0) && ($runName != ""))
		{
			$result = array(
				"status" => 0
			);
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				//create dataset first
				$Dataset = new Dataset();
				$Dataset->name = $runName;
				$Dataset->note = "imported result";
				$Dataset->userId = $userId;
				$Dataset->createTime = new CDbExpression("NOW()");
				$Dataset->isImported = 1;
				if(!$Dataset->save())
				{
					throw new Exception("error creating dataset");
				}
				//add to the database
				$videoname2dvId = array();
				foreach($results as $video)//foraech the first time to construct DvId
				{
					//create dv first
					$videoname = $video['videoname'].".mp4";
					$rankScore = $video['rankScore'];
					if(isset($videoname2dvId[$videoname]))
					{
						$dvId1 = $videoname2dvId[$videoname];
					}
					else
					{
						$V = Videos::model()->find("name=:v",array(":v"=>$videoname));
						if($V == null)
						{
							throw new Exception("video ".$videoname." not found");
						}
						$DV = new DatasetVideo();
						$DV->videoId = $V->id;
						$DV->datasetId = $Dataset->id;
						$DV->createTime = new CDbExpression("NOW()");
						$DV->changeTime = new CDbExpression("NOW()");
						$DV->rankScore = $rankScore;
						if(!$DV->save())
						{
							throw new Exception("dv saving error");
						}
						$videoname2dvId[$videoname] = $DV->id;
						$dvId1 = $videoname2dvId[$videoname]; 
					}	
				}
				foreach($results as $video)
				{
					$videoname = $video['videoname'].".mp4";
					$dvId1 = $videoname2dvId[$videoname];
					foreach($video['ranklist'] as $one)
					{
						$videoname2 = $one['videoname'].".mp4";
						//load or save the order dv
						if(isset($videoname2dvId[$videoname2]))
						{
							$dvId2 = $videoname2dvId[$videoname2];
						}
						else
						{
							$result['warning'] = "dvId2 not exists";
							$V = Videos::model()->find("name=:v",array(":v"=>$videoname2));
							if($V == null)
							{
								throw new Exception("video ".$videoname2." not found");
							}
							$DV = new DatasetVideo();
							$DV->videoId = $V->id;
							$DV->datasetId = $Dataset->id;
							$DV->createTime = new CDbExpression("NOW()");
							$DV->changeTime = new CDbExpression("NOW()");
							if(!$DV->save())
							{
								throw new Exception("dv saving error");
							}
							$videoname2dvId[$videoname2] = $DV->id;
							$dvId2 = $videoname2dvId[$videoname2]; 
						}
						
						$ERpair = new ERpairs();
						$ERpair->datasetId = $Dataset->id;
						$ERpair->srcId = $dvId1;
						$ERpair->desId = $dvId2;
						$ERpair->createTime = new CDbExpression("NOW()");
						
						$ERpair->offset = (float)$one['offset'];
						$ERpair->confidence = (float)$one['score'];
						$ERpair->changeTime = new CDbExpression("NOW()");
						if(!$ERpair->save())
						{
							$result['status'] = 1;
						}
					}
				}
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 3;//error
				$result['message'] = $e->getMessage();
			}
			
			echo Text::json_encode_ch($result);
		}
	}
	public function actionEventReconstructionSegmentSearch()
	{
		$request = Yii::app()->request;
		$results = $request->getPost("results",array());
		$segmentId = $request->getPost("segmentId",0);
		$datasetId = $request->getPost("datasetId",0);
		if((count($results)>0) && ($segmentId != 0) && ($datasetId != 0))
		{
			$result = array(
				"status" => 0
			);
			$Segment = Segments::model()->findByPk($segmentId);
			if($Segment == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$thisDvId = $Segment->dvId;

				//add to the database
				foreach($results as $video)
				{					
					
					$ERpair = ERpairs::model()->find("datasetId=:data AND srcId=:s AND desId=:des AND isSegment1=1 AND isSegment2=0",
						array(":data"=>$datasetId,":s"=>$segmentId,":des"=>$video['dvId']));
					if($ERpair == null)
					{
						$ERpair = new ERpairs();
						$ERpair->datasetId = $datasetId;
						$ERpair->srcId = $segmentId;
						$ERpair->desId = $video['dvId'];
						$ERpair->isSegment1 = 1;
						$ERpair->createTime = new CDbExpression("NOW()");
					}
					$ERpair->offset = (float)$video['offset'];
					$ERpair->confidence = (float)$video['score'];
					$ERpair->changeTime = new CDbExpression("NOW()");
					if(!$ERpair->save())
					{
						$result['status'] = 1;
					}
					
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',//get post data and check key
		);
	}

	public function filterAccessControl($filterChain)
	{

		// parse the posted data and check the key
		$postData = file_get_contents("php://input");
		//echo substr($postData,count($postData)-50);
		//if(isset($GLOBALS['HTTP_RAW_POST_DATA']) && ($GLOBALS['HTTP_RAW_POST_DATA'] != ""))
		if($postData != "")
		{
			try
			{
				//print_r(split(";",$GLOBALS['HTTP_RAW_POST_DATA'],2));
				//die("");
				Yii::import("application.extensions.f");
				//list($key,$rawdata) = split(";",$GLOBALS['HTTP_RAW_POST_DATA'],2);
				list($key,$rawdata) = split(";",$postData,2);
				if(md5($rawdata.f::get("ppythonMD5key")) != $key)
				{
					throw new Exception("safety check fail");
				}
				else
				{
					$_POST = json_decode($rawdata,true);
					if($_POST == NULL)
					{
						//echo "fucked";
						$errorMessage = "";
						switch (json_last_error()) {
					        case JSON_ERROR_NONE:
					           $errorMessage =  ' - No errors';
					        break;
					        case JSON_ERROR_DEPTH:
					            $errorMessage =  ' - Maximum stack depth exceeded';
					        break;
					        case JSON_ERROR_STATE_MISMATCH:
					            $errorMessage =  ' - Underflow or the modes mismatch';
					        break;
					        case JSON_ERROR_CTRL_CHAR:
					            $errorMessage =  ' - Unexpected control character found';
					        break;
					        case JSON_ERROR_SYNTAX:
					            $errorMessage =  ' - Syntax error, malformed JSON';
					        break;
					        case JSON_ERROR_UTF8:
					            $errorMessage =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
					        break;
					        default:
					            $errorMessage =  ' - Unknown error';
					        break;
					    }
					    throw new Exception("json decode fail:".$errorMessage);
					}
					//echo $_POST;
					//print_r($_POST);
				}
			}catch(Exception $e)
			{
				die("error:".$e->getMessage());
			}
		}
		else
		{
			die("error:no data");
		}
		$filterChain->run();
	}
}