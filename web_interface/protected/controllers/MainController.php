<?php
class MainController extends Controller
{
	// get video's number of frames and fps info, if not exists, then tell python to extract frames.
	public function actionGetVideoFrames()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId", -1);
		if(($videoId != -1))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0,
			);

			$Video = Videos::model()->findByPk($videoId);
			if(($Video == NULL) || ($Video->userId != $userId))
			{
				$result['status'] = 1;
			}
			else
			{
				$videoFramePath = f::get("videoFramePath"); // "assets/videoFrames"
				if(!file_exists($videoFramePath))
				{
					mkdir($videoFramePath, 0777, true);
					chmod($videoFramePath, 0777); // need this so python can access the folder
				}
				// TODO: we need to avoid client calling extracting frames all the time
				if(($Video->num_frame < 0) || ($Video->fps < 0))
				{
					// send to python to extract frames
					// send to python to get stuff
					$result['processStatus'] = 0;// sucessfully submit process job
					$Process = new Process();
					$Process->type = 19;
					$Process->createTime = new CDbExpression("NOW()");
					$Process->changeTime = new CDbExpression("NOW()");
					$Process->userId = $userId;
					if(!$Process->save())
					{
						$result['processStatus'] = 1; //couldn't save process.
					}
					else
					{
						//post job to python
						Yii::import("application.extensions.PP");
						$callback = PP::cb("getVideoFramesDone");
						$this_frame_path = realpath($videoFramePath)."/".$Video->name."/";
						try
						{
							PP::ppython_asyn("run::getVideoFrames", $Process->id, $callback, $userId, $Video->id, $Video->processPath, $this_frame_path);
							$result['processId'] = $Process->id;
						}
						catch(Exception $e)
						{
							$result['processStatus'] = 2;// send to python error
							$result['processError'] = $e->getMessage();
						}
					}
					$result['videoId'] = $Video->id;
				}
				else
				{
					$frame_rel_path =  $videoFramePath. $Video->name."/";
					$result['hasResult'] = 1;
					$result['video'] = array(
						'fps' => $Video->fps,
						'num_frame' => $Video->num_frame,
						"frame_rel_path" => $frame_rel_path,
					);
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteGunshot()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		$gunshotId = $request->getPost("gunshotId", -1);
		if(($datasetId != -1) && ($gunshotId != -1))
		{
			$result = array(
				"status" => 0,
				"hasDeleted" => 0,
			);
			// check whether this gunshot is used in marking
			$Gunshot = LGunshotInVideo::model()->find("gunshotId=:g AND userId=:u", array(
				":g" => $gunshotId,
				":u" => $userId
			));
			if($Gunshot == NULL)
			{
				$Gunshot = LGunshot::model()->findByPk($gunshotId);
				if($Gunshot != NULL)
				{
					$Gunshot->isDeleted = 1;
					if(!$Gunshot->save())
					{
						$result['status'] = 1;
						$result['error'] = $Gunshot->getErrors();
					}
					else
					{
						$result['hasDeleted'] = 1;
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// given the markers with all the data needed, get data from database or send to python to run
	public function actionRunMethod1()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		$markers = $request->getPost("markers", array());
		if(($datasetId != -1) && (count($markers) > 0))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0,
			);
			// get the latest run for these markers, compare whether all of them have the same running conditions: elevation, angleMin max, mb time and shockwave time diff, sound speed, bullet speed

			// first, convert the array to dict
			$markers_dict = array();
			foreach($markers as $marker)
			{
				$markers_dict[$marker['markerId']] = $marker;
			}

			$criteria = new CDbCriteria();
			$criteria->addInCondition('L_method1_runs.markerId', array_keys($markers_dict));
			$markers_in_database_all = Text::sql("SELECT L_method1_runs.* FROM L_method1_runs WHERE L_method1_runs.datasetId=:d AND L_method1_runs.isDeleted=0 AND ".$criteria->condition." ORDER BY L_method1_runs.id DESC LIMIT 0,1000", array_merge(array(
				":d" => $datasetId
			),$criteria->params));
			// make them into a dict, where the markerId with later id will stay
			$markers_in_database = array();
			foreach($markers_in_database_all as $marker)
			{
				if(!array_key_exists($marker['markerId'], $markers_in_database))
				{
					$markers_in_database[$marker['markerId']] = $marker;
				}
			}
			// check all requrest markers with the database , need every one the same and exists
			// also the ones in database should have dists data
			$all_the_same = true;
			$check_fields = array(
				'time_diff',
				"soundSpeedMin", "soundSpeedMax",
				"bulletSpeedMin", "bulletSpeedMax",
				"elevation",
				"angleMin", "angleMax"
			); 
			foreach($markers_dict as $markerId => &$marker)
			{
				if(array_key_exists($markerId, $markers_in_database))
				{
					// need this database record has computed dists
					if(($markers_in_database[$markerId]['min_dist'] == -1) || ($markers_in_database[$markerId]['max_dist'] == -1) || ($markers_in_database[$markerId]['mean_dist'] == -1))
					{
						$all_the_same = false;
						break;
					}
					foreach($check_fields as $check_field)
					{
						if($marker[$check_field] != $markers_in_database[$markerId][$check_field])
						{
							$all_the_same = false;
							break;
						}
					}
					// so all the check passed for this marker, then load the previously computed dists info
					$marker['min_dist'] = $markers_in_database[$markerId]['min_dist'];
					$marker['max_dist'] = $markers_in_database[$markerId]['max_dist'];
					$marker['mean_dist'] = $markers_in_database[$markerId]['mean_dist'];
				}
				else
				{
					$all_the_same = false;
					break;
				}
			}

			if($all_the_same)
			{
				$result['hasResult'] = 1;
				$result['method1result'] = $markers_dict;
			}
			else
			{
				// send to python to get stuff
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 18;
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
					$callback = PP::cb("gunshotMethod1");
					try
					{
						PP::ppython_asyn("run::gunshotLocalizationMethod1", $Process->id, $callback, $markers, $datasetId, $userId);
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
	public function actionGetMethod1Result()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$processId = $request->getPost("processId", -1);
		$datasetId = $request->getPost("datasetId", -1); 
		if(($datasetId != -1) && ($processId != -1))
		{
			$result = array(
				"status" => 0,
			);
			
			$markers_in_database = Text::sql("SELECT L_method1_runs.* FROM L_method1_runs WHERE L_method1_runs.datasetId=:d AND L_method1_runs.isDeleted=0 AND L_method1_runs.processId=:p ORDER BY L_method1_runs.id DESC LIMIT 0,1000", array(
				":d" => $datasetId,
				":p" => $processId,
			));
			$markers_dict = array();
			foreach($markers_in_database as $marker)
			{
				$markers_dict[$marker['markerId']] = $marker;
			}

			$result['method1result'] = $markers_dict;

			echo Text::json_encode_ch($result);
		}
	}
	public function actionSaveEventInfo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		$longitude = $request->getPost("longitude", -1);
		$latitude = $request->getPost("latitude", -1);
		$radius = $request->getPost("radius", -1);
		$soundSpeedMax = $request->getPost("soundSpeedMax", -1);
		$soundSpeedMin = $request->getPost("soundSpeedMin", -1);
		if(($datasetId != -1) && ($longitude != -1) && ($latitude != -1) && ($radius != -1) && ($soundSpeedMin != -1) && ($soundSpeedMax != -1))
		{
			$result = array(
				"status" => 0,
			);
			$Dataset = Dataset::model()->findByPk($datasetId);
			if($Dataset == NULL)
			{
				$result['status'] = 1;
			}
			else
			{
				$Dataset->longitude = $longitude;
				$Dataset->latitude = $latitude;
				$Dataset->radius = $radius;
				$Dataset->soundSpeedMin = $soundSpeedMin;
				$Dataset->soundSpeedMax = $soundSpeedMax;
				if(!$Dataset->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetEventInfo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0,
			);
			$Dataset = Dataset::model()->findByPk($datasetId);
			if($Dataset == NULL)
			{
				$result['status'] = 1;
			}
			else
			{
				$result['dataset'] = $Dataset->attributes;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetSpecImg()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId", 0);
		$startSec = $request->getPost("startSec", NULL);
		$videoname = $request->getPost("videoname", NULL);
		$endSec = $request->getPost("endSec", NULL);
		if(($videoId != 0) && ($startSec != NULL) && ($endSec != NULL) && ($videoname != NULL))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0,
			);
			$specImgPath = f::get("specImgPath");
			$specfilename = $videoname."_spectrogram_".$startSec."_".$endSec.".png";
			$specFilePath = $specImgPath.$specfilename;
			$powerfilename = $videoname."_power_".$startSec."_".$endSec.".png";
			$powerFilePath = $specImgPath.$powerfilename;
			if(file_exists($specFilePath) && file_exists($powerFilePath))
			{
				$result['hasResult'] = 1;
				$result['spectrogram'] = Yii::app()->baseUrl."/".$specFilePath;
				$result['power'] = Yii::app()->baseUrl."/".$powerFilePath;
			}
			else
			{
				// get the video path
				$Video = Videos::model()->findByPk($videoId);
				$specfilePathAbs = realpath($specImgPath)."/".$specfilename;
				$powerfilePathAbs = realpath($specImgPath)."/".$powerfilename;
				// send to python to get stuff
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
					try
					{
						PP::ppython_asyn("run::getSpecImg", $Process->id, $Video->processPath, (double)$startSec, (double)$endSec, $specfilePathAbs, $powerfilePathAbs);
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
	public function actionGetGunshotAny()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoname = $request->getPost("videoname","");
		if(($videoname!=""))
		{
			$result = array(
				"haveResult" => 0,
				"status" => 0,
			);
			// get video Id.
			$Video = Videos::model()->find("name=:s",array(":s"=>$videoname));

			//check whether has any run result
			$GunshotRun = GunshotRun::model()->find("videoId=:vid AND haveResult=1 AND isDeleted=0 ORDER BY id DESC",array(":vid"=>$Video->id));
			if($GunshotRun == NULL)// not submitting detection job here
			{}
			else
			{
				// get the result and send back
				$result['haveResult'] = 1;
				$result['runId'] = $GunshotRun->id;
				$result['scoreList'] = array();
				$GunshotResults = GunshotResults::model()->findAll("runId=:r ORDER BY startSec ASC",array(":r"=>$GunshotRun->id));
				foreach($GunshotResults as $GunshotResult)
				{
					$temp = array(
						"startSec" => $GunshotResult->startSec,
						"endSec" => $GunshotResult->endSec,
						"score" => $GunshotResult->score,
					);
					$resultType = $GunshotResult->type;
					if(!isset($result['scoreList'][$resultType]))
					{
						$result['scoreList'][$resultType] = array();
					}
					$result['scoreList'][$resultType][] = $temp;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
			);
			$result['videos'] = Text::sql("SELECT D_videos.*,D_videos.name AS videoname,D_dataset.name AS datasetname,D_videos.id as videoId FROM D_videos,D_dataset_video,D_dataset WHERE D_dataset.id=:d AND D_dataset.id=D_dataset_video.datasetId AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id ASC LIMIT 0,1000",array(":d"=>$datasetId));

			// for each video, find the gunshot marking info
			foreach($result['videos'] as $i=>$video)
			{
				$videoId = $video['videoId'];
				
				$GunshotMarks = Text::sql("SELECT L_gunshot_in_video.* FROM L_gunshot_in_video, L_gunshot WHERE L_gunshot.isDeleted=0 AND L_gunshot.datasetId=:d AND L_gunshot.id=L_gunshot_in_video.gunshotId AND L_gunshot_in_video.videoId=:v AND L_gunshot_in_video.isDeleted=0 ORDER BY L_gunshot_in_video.id ASC LIMIT 0,1000",array(":d"=>$datasetId, ":v"=>$videoId));
				
				$result['videos'][$i]['gunshotMarks'] = $GunshotMarks;
			}
			
			echo Text::json_encode_ch($result);
		}
	}
	public function actionNewLGunshot()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		$bulletSpeedMax = $request->getPost("bulletSpeedMax", -1);
		$bulletSpeedMin = $request->getPost("bulletSpeedMin", -1);
		$gunName = $request->getPost("gunName", NULL);
		$note = $request->getPost("note", "");
		if(($datasetId != -1) && ($bulletSpeedMin != -1) && ($bulletSpeedMax != -1) && ($gunName != NULL))
		{
			$result = array(
				"status" => 0,
			);
			$Gunshot = new LGunshot();
			$Gunshot->gunName = $gunName;
			$Gunshot->datasetId = $datasetId;
			$Gunshot->userId = $userId;
			$Gunshot->createTime = new CDbExpression("NOW()");
			$Gunshot->bulletSpeedMax = $bulletSpeedMax;
			$Gunshot->bulletSpeedMin = $bulletSpeedMin;
			$Gunshot->note = $note;
			if(!$Gunshot->save())
			{
				$result['status'] = 1;
				$result['error'] = $Gunshot->getErrors();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteGunshotMark()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId", -1);
		$gunshotMarkId = $request->getPost("gunshotMarkId", -1);
		if(($videoId != -1) && ($gunshotMarkId != -1))
		{
			$result = array(
				"status" => 0,
			);
			$GunshotMark = LGunshotInVideo::model()->findByPk($gunshotMarkId);
			if(($GunshotMark == NULL) || ($GunshotMark->userId != $userId) || ($GunshotMark->videoId != $videoId))
			{
				$result['status'] = 1;
			}
			else
			{
				$GunshotMark->delete();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionEditLGunshot()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		$gunshotId = $request->getPost("gunshotId", -1);
		$bulletSpeedMax = $request->getPost("bulletSpeedMax", -1);
		$bulletSpeedMin = $request->getPost("bulletSpeedMin", -1);
		$gunName = $request->getPost("gunName", NULL);
		$note = $request->getPost("note", "");
		if(($gunshotId != -1) && ($datasetId != -1) && ($bulletSpeedMin != -1) && ($bulletSpeedMax != -1) && ($gunName != NULL))
		{
			$result = array(
				"status" => 0,
			);
			$Gunshot = LGunshot::model()->findByPk($gunshotId);
			if($Gunshot != NULL)
			{
				$Gunshot->gunName = $gunName;
				$Gunshot->datasetId = $datasetId;
				$Gunshot->userId = $userId;
				$Gunshot->bulletSpeedMax = $bulletSpeedMax;
				$Gunshot->bulletSpeedMin = $bulletSpeedMin;
				$Gunshot->note = $note;
				if(!$Gunshot->save())
				{
					$result['status'] = 1;
					$result['error'] = $Gunshot->getErrors();
				}
				echo Text::json_encode_ch($result);
			}
		}
	}

	// add new gunshot marking or edit the current one
	public function actionNewLGunshotInVideo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId", -1);
		$gunshotId = $request->getPost("gunshotId", -1);
		$shockwaveTime = $request->getPost("shockwaveTime", -1);
		$angleMin = $request->getPost("angleMin", -1);
		$angleMax = $request->getPost("angleMax", -1);
		$muzzleBlastTime = $request->getPost("muzzleBlastTime", -1);
		$elevation = $request->getPost("elevation", 0);
		if(($videoId != -1) && ($gunshotId != -1) && ($muzzleBlastTime != -1))
		{
			// allow shockwave and angleMin and angleMax to be empty
			$result = array(
				"status" => 0,
			);
			// find previous record first
			$GunshotMark = LGunshotInVideo::model()->find("gunshotId=:g AND videoId=:v AND isDeleted=0", array(
				':g' => $gunshotId,
				":v" => $videoId
			));
			if($GunshotMark == NULL)
			{
				$GunshotMark = new LGunshotInVideo();
				$GunshotMark->userId = $userId;
				$GunshotMark->createTime = new CDbExpression("NOW()");
				$GunshotMark->videoId = $videoId;
				$GunshotMark->gunshotId = $gunshotId;
			}
			$GunshotMark->muzzleBlastTime = $muzzleBlastTime;
			$GunshotMark->shockwaveTime = $shockwaveTime;
			$GunshotMark->angleMin = $angleMin;
			$GunshotMark->angleMax = $angleMax;
			$GunshotMark->elevation = $elevation;

			if(!$GunshotMark->save())
			{
				$result['status'] = 1;
				$result['error'] = $GunshotMark->getErrors();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetLGunshotInVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId", -1);
		$gunshotId = $request->getPost("gunshotId", -1);
		if(($videoId != -1) && ($gunshotId != -1))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0
			);

			$GunshotMark = LGunshotInVideo::model()->find("gunshotId=:g AND videoId=:v AND isDeleted=0", array(
				':g' => $gunshotId,
				":v" => $videoId
			));
			if($GunshotMark != NULL)
			{
				$result['hasResult'] = 1;
				$result['gunshotMark'] = $GunshotMark->attributes;
			}
			
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSaveCameraLocations()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$gunshotMarks = $request->getPost("gunshotMarks", array());
		if((count($gunshotMarks) > 0))
		{
			$result = array(
				"status" => 0,
			);

			foreach($gunshotMarks as $gunshot)
			{
				$GunshotMark = LGunshotInVideo::model()->findByPk($gunshot['gunshotMarkId']);
				if($GunshotMark != NULL)
				{
					$GunshotMark->latitude = $gunshot['latitude'];
					$GunshotMark->longitude = $gunshot['longitude'];
					if(!$GunshotMark->save())
					{
						$result['status'] = 1;
						$result['error'] = $GunshotMark->getErrors();
						break;
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// given gunshot, get all gunshot in video, group by video
	// also get the global offset
	public function actionGetLGunshotAllInVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$gunshotId = $request->getPost("gunshotId", -1);
		$datasetId = $request->getPost("datasetId", -1);
		if(($gunshotId != -1) && ($datasetId != -1))
		{
			$result = array(
				"status" => 0,
			);
			$result['gunshotMarks'] = Text::sql("SELECT D_videos.*, L_gunshot_in_video.*, D_videos.name AS videoname, D_videos.id AS videoId, L_gunshot_in_video.id AS gunshotMarkId, D_dataset_video.id as dvId  FROM D_videos, L_gunshot_in_video, D_dataset_video WHERE L_gunshot_in_video.gunshotId=:g AND L_gunshot_in_video.isDeleted=0 AND L_gunshot_in_video.videoId=D_videos.id AND D_dataset_video.videoId=D_videos.id AND D_dataset_video.datasetId=:d ORDER BY D_videos.id ASC LIMIT 0,1000", array(
					":g" => $gunshotId,
					":d" => $datasetId,
				));
			// get the synchronization clusters
			$ERcluster = ERclusters::model()->find("isDeleted=0 AND datasetId=:d ORDER BY id DESC", array(
				":d" => $datasetId
			));
				
			foreach($result['gunshotMarks'] as &$gunshotMark)
			{
				$gunshotMark['time_offset'] = "";
				$gunshotMark['duration'] = "";
				if($ERcluster != NULL)
				{
					$ERresult = ERresults::model()->find("clusterId=:c AND datasetId=:d AND dvId=:v ORDER BY id DESC", array(
						":c" => $ERcluster['id'],
						":d" => $datasetId,
						":v" => $gunshotMark['dvId'],
					));
					if($ERresult != NULL)
					{
						$gunshotMark['time_offset'] = $ERresult['offset'];
						$gunshotMark['duration'] = $ERresult['duration'];
					}
				}
			}

			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetLGunshots()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", -1);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0,
				"gunshots" => array(),
			);

			$Gunshots = LGunshot::model()->findAll("datasetId=:d AND isDeleted=0", array(
				':d' => $datasetId,
			));
			foreach($Gunshots as $Gunshot)
			{

				$temp = $Gunshot->attributes;
				$result['gunshots'][] = $temp;
			}	
			echo Text::json_encode_ch($result);
		}
	}
	//gunshot counting
	public function actionCountGunshot()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId",0);
		$startSec = $request->getPost("startSec",NULL);
		$videoname = $request->getPost("videoname",NULL);
		$endSec = $request->getPost("endSec",NULL);
		if(($videoId != 0) && ($startSec != NULL) && ($endSec != NULL) && ($videoname != NULL))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0,
			);
			$countGunshotPath = f::get("countGunshotPath");
			$filename = $videoname."_".$startSec."_".$endSec.".png";
			$filePath = $countGunshotPath.$filename;
			if(file_exists($filePath))
			{
				$result['hasResult'] = 1;
				$result['resultPic'] = Yii::app()->baseUrl."/".$filePath;
			}
			else
			{
				// get the video path
				$Video = Videos::model()->findByPk($videoId);
				$filePathAbs = realpath($countGunshotPath)."/".$filename;
				// send to python to get stuff
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 15;
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
					try
					{
						PP::ppython_asyn("run::countGunshot",$Process->id,$Video->processPath,(double)$startSec,(double)$endSec,$filePathAbs);
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
	public function actionGetGunshotClassificationResults()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId",0);
		$videoname = $request->getPost("videoname",NULL);
		$segments = $request->getPost("segments",array());
		if(($videoId != 0)  && ($videoname != NULL))
		{
			$result = array(
				"status" => 0,
				"results" => array(),
			);
			foreach($segments as $segment)
			{
				$startSec = $segment["startSec"];
				$endSec = $segment['endSec'];
				// each segment has the start sec and end sec
				$Run = GunshotClassification::model()->find("videoId=:v AND start=:s AND end=:e AND hasResult=1 AND isDeleted=0",array(
					":v" => $videoId,
					":s" => $startSec, # should be int
					":e" => $endSec
				));
				// check whether result exists in database
				if($Run != NULL)
				{
					$temp = array(
						"start" => $startSec,
						"end" => $endSec,
						"scorelist" => json_decode($Run->result,true)
					);
					$result['results'][] = $temp;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// gunshot classification
	public function actionGunshotClassification()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoId = $request->getPost("videoId",0);
		$startSec = $request->getPost("startSec",NULL);
		$videoname = $request->getPost("videoname",NULL);
		$endSec = $request->getPost("endSec",NULL);
		if(($videoId != 0) && ($startSec != NULL) && ($endSec != NULL) && ($videoname != NULL))
		{
			$result = array(
				"status" => 0,
				"hasResult" => 0,
			);
			$Run = GunshotClassification::model()->find("videoId=:v AND start=:s AND end=:e AND hasResult=1 AND isDeleted=0",array(
				":v" => $videoId,
				":s" => $startSec, # should be int
				":e" => $endSec
			));
			// check whether result exists in database
			if($Run != NULL)
			{
				$result['hasResult'] = 1;
				$result['result'] = json_decode($Run->result, true);
			}
			else
			{

				// get the video path
				$Video = Videos::model()->findByPk($videoId);
				// send to python to get stuff
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
					// new run 
					$Run = new GunshotClassification();
					$Run->videoId = $videoId;
					$Run->createTime = new CDbExpression("NOW()");
					$Run->start = $startSec;
					$Run->end = $endSec;
					$Run->hasResult = 0;
					if(!$Run->save())
					{
						$result['status'] = 1;//couldn't save
						$result['error'] = $Run->getErrors();
					}
					else
					{
						//post job to python
						Yii::import("application.extensions.PP");
						$callback = PP::cb("gunshotClassification");
						try
						{
							PP::ppython_asyn("run::gunshotClassification",$Process->id,$callback,$Video->processPath,$startSec,$endSec,$Run->id);
							#PP::ppython_asyn("run::gunshotClassificationAnkit",$Process->id,$callback,$Video->processPath,$startSec,$endSec,$Run->id);
							$result['processId'] = $Process->id;
						}
						catch(Exception $e)
						{
							$result['processStatus'] = 2;// send to python error
							$result['processError'] = $e->getMessage();
						}
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// make json for rash player
	public function actionMakeRashJson()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$loc2datasetId = $request->getPost("loc2datasetId",0);
		$clusterId = $request->getPost("clusterId",0);
		if(($datasetId != 0) && ($clusterId != 0))
		{
			$result = array(
				"status" => 0,
				"jsonFileName" => "${datasetId}_${clusterId}_${loc2datasetId}",
			);
			$targetPath = f::get("rashJsonPath");
			$targetFile = $targetPath.$result['jsonFileName'];
			$dvId2loc = array();
			if($loc2datasetId != 0)
			{
				$locResults = LocResult::model()->findAll("datasetId=:d AND loc2datasetId=:l",array(":d"=>$datasetId,":l"=>$loc2datasetId));
				foreach($locResults as $locResult)
				{
					$dvId2loc[$locResult->dvId] = array(
						"lat" => $locResult->lat,
						"long" => $locResult->longitude,
					);
				}
			}
			//get dataset Name
			$Dataset = Dataset::model()->findByPk($datasetId);
			//echo $datasetId;
			//get the result first
			$results = ERclusters::getResult($clusterId);
			$data = array(
				"mediaPath" => Yii::app()->baseUrl."/assets/videos/",
				"event" => $Dataset->name,
				"videos" => array(),
			);
			foreach($results as $one)
			{
				//rashomon bug? 0.0 offset it wont play
				/*
				if($one['offset'] == 0)
				{
					$one['offset'] = 0.001;
				}*/
				$temp = array(
					"name" => $one['videoname'],
					"offset" => $one['offset'],
					"duration" => $one['duration'],
				);
				if(isset($dvId2loc[$one['dvId']]))
				{
					$temp['cameraLatLng'] = array(
						"lat" => $dvId2loc[$one['dvId']]['lat'],
						"lng" => $dvId2loc[$one['dvId']]['long'],
					);
				}
				$data['videos'][] = $temp;
			}
			if(file_exists($targetFile))
			{
				unlink($targetFile);
			}
			$result['jsonPath'] = $targetFile;
			$targetFile = fopen($targetFile,'w');
			
			fwrite($targetFile,Text::json_encode_ch($data));
			
			fclose($targetFile);
			echo Text::json_encode_ch($result);
		}
	}
	//delete dataset
	// just hide it
	public function actionDeleteDataset()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
			);
			$Dataset = Dataset::model()->findByPk($datasetId);
			if(($Dataset != null) && ($Dataset->userId == $userId))
			{
				$Dataset->isDeleted = 1;
				if(!$Dataset->save())
				{
					$result['status'] = 1;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetDatasetProgressInfo()
	{
		// get the datatsetId info, and its run of sync, and maybe loc.
		// whether to allow wathc video sync player of video tiler.
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
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
				$result['dataset'] = $Dataset->attributes;
				$result['dataset']['videoNum'] = DatasetVideo::model()->count("datasetId=:d",array(":d"=>$Dataset->id));
				//whether this dataset has run apps
				$result['runSync'] = 0;
				$result['runLoc'] = 0;
				$result['canPlay'] = 0;// whether can go to sync player to play
				$result['canTiler'] = 0; // whether can use tiler
				if(ERresults::model()->exists("datasetId=:d",array(":d"=>$Dataset->id)))
				{
					$result['runSync'] = 1;
					$result['canPlay'] = 1;
					$result['canTiler'] = 1;
				}
				//check loc
				if(Loc2dataset::model()->exists("datasetId=:d",array(":d"=>$Dataset->id)))
				{
					$result['runLoc'] = 1;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// get a userid's all dataset
	public function actionGetDatasetListMain()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$userId = $request->getPost("userId",0);
		if($userId != 0)
		{
			$result = array(
				"status" => 0,
			);
			$result['datasetList'] = Text::sql("SELECT D_dataset.*,D_dataset.name AS datasetname,D_dataset.id AS datasetId from D_dataset WHERE D_dataset.userId=:u AND D_dataset.isDeleted=0 AND D_dataset.isSearch=0 AND D_dataset.isImported=0 ORDER BY D_dataset.id DESC",array(":u"=>$userId)); 
			foreach($result['datasetList'] as &$dataset)
			{
				$dataset['videoNum'] = DatasetVideo::model()->count("datasetId=:d",array(":d"=>$dataset['datasetId']));
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetModels()
	{
		//get admin model and users model seperately
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$result = array(
			"status" => 0,
			"adminModelList" => array(),
			"myModelList" => array(),
		);
		$result['adminModelList'] = Text::sql("SELECT D_models.*,D_models.id AS modelId FROM D_models,T_user WHERE D_models.isDeleted=0 AND D_models.userId=T_user.userId AND T_user.isSuper=1 AND D_models.isDefault=1  ORDER BY modelId ASC");
		$result['myModelList'] = Text::sql("SELECT D_models.*,D_models.id AS modelId FROM D_models WHERE D_models.isDeleted=0 AND D_models.userId=:u ORDER BY modelId DESC LIMIT 0,1",array(":u"=>$userId));
		echo Text::json_encode_ch($result);
	}
	public function actionGetLabels($videoId,$classname)
	{
		// get labels labeled by this user for this video for this classname
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$result = array(
			"status" => 0
		);
		$result['labels'] = Text::sql("SELECT * FROM D_labels WHERE videoId=:v AND classname=:c AND userId=:u AND isDeleted=0 ORDER BY id ASC",array(":v"=>$videoId,":c"=>$classname,":u"=>$userId));
		echo Text::json_encode_ch($result);
	}
	public function actionDeleteLabel($videoId,$classname)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$labelId = $request->getPost("labelId",-1);
		if($labelId!=-1)
		{
			$result = array(
				"status" => 0,
			);
			$Label = Labels::model()->findByPk($labelId);
			if(($Label != null) && ($Label->userId == $userId) && ($Label->videoId == $videoId) && ($Label->classname == $classname))
			{
				//$Label->delete();
				$Label->isDeleted = 1;
				if(!$Label->save())
				{
					$result['status'] = 2;
				}
			}
			else
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionAddLabel($videoId,$classname)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$startSec = $request->getPost('startSec',-1);
		$endSec = $request->getPost('endSec',-1);
		$pos = $request->getPost("pos",-1);
		if(($startSec != -1)&&($endSec != -1)&&($pos!=-1))
		{
			$result = array(
				"status" => 0
			);
			$Label = new Labels();
			$Label->userId = $userId;
			$Label->startSec = $startSec;
			$Label->endSec = $endSec;
			$Label->classname = $classname;
			$Label->videoId = $videoId;
			$Label->pos = $pos;
			if(!$Label->save())
			{
				$result['status'] = 1;
			}
			else
			{
				$result['labelId'] = $Label->id;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteGunshotRun()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$runId = $request->getPost("runId",0);
		if($runId != 0)
		{
			$result = array(
				"status" => 0,
			);
			// get all avialable runs
			$GunshotRun = GunshotRun::model()->findByPk($runId);

			$GunshotRun->isDeleted = 1;
			$videoId = $GunshotRun->videoId;

			if($GunshotRun->save())
			{
				# also delete the gunshot classification results
				Text::sql("UPDATE D_gunshot_classification SET isDeleted=1 WHERE (videoId=:v AND isDeleted=0)",array(
						":v"=>$videoId,
					),array(),false);
			}
			else
			{
				
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetRunList()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		if(true)
		{
			$result = array(
				"runList" => array(),
				"status" => 0,
			);
			// get all avialable runs
			$GunshotRuns = GunshotRun::model()->findAll("haveResult=1 AND isDeleted=0 ORDER BY id ASC");
			foreach($GunshotRuns as $GunshotRun)
			{
				$Video = Videos::model()->findByPk($GunshotRun->videoId);
				$modelName = "";
				if($GunshotRun->modelId > 0)
				{
					$Model = Models::model()->findByPk($GunshotRun->modelId);
					$modelName = $Model->modelname;
				}
				$result['runList'][] = array(
					"videoname" => $Video->name,
					"runId" => $GunshotRun->id,
					"runTime" => $GunshotRun->createTime,
					"modelName" => $modelName,
					"modelId" => $GunshotRun->modelId,
				);
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetGunshot()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoname = $request->getPost("videoname","");
		$modelId = $request->getPost("modelId",-2);
		if(($videoname!="") && ($modelId != -2))
		{
			$result = array(
				"haveResult" => 0,
				"status" => 0,
			);
			// get video Id.
			$Video = Videos::model()->find("name=:s",array(":s"=>$videoname));

			//check whether has any run result
			$GunshotRun = GunshotRun::model()->find("videoId=:vid AND modelId=:m AND haveResult=1 AND isDeleted=0 ORDER BY id DESC",array(":vid"=>$Video->id,":m"=>$modelId));
			if($GunshotRun == NULL)
			{
				// create one run and post to python, return processId.
				$GunshotRun = new GunshotRun();
				$GunshotRun->videoId = $Video->id;
				$GunshotRun->createTime = new CDbExpression("NOW()");
				$GunshotRun->runName = "default";
				$GunshotRun->modelId = $modelId;
				$Model = Models::model()->findByPk($modelId);
				if(!$GunshotRun->save() || ($Model == null))
				{
					$result['status'] = 1;
				}
				else
				{
					$result['processStatus'] = 0;// sucessfully submit process job
					$Process = new Process();
					$Process->type = 6;
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
						$callback = PP::cb("gunshotDetection");
						// path for prediction graph
						$gunshotGraphPath = f::get("gunshotGraphPath");//path for website videos
						$gunshotGraphRealPath = realpath($gunshotGraphPath);
						try
						{
							PP::ppython_asyn("run::gunshotDetection",$Process->id,$callback,$Video->name,$Video->processPath,$gunshotGraphRealPath,$GunshotRun->id,$Model->id,$Model->modelpath);
							$result['processId'] = $Process->id;
						}
						catch(Exception $e)
						{
							$result['processStatus'] = 2;// send to python error
							$result['processError'] = $e->getMessage();
						}
					}
				}
			}
			else
			{
				// get the result and send back
				$result['haveResult'] = 1;
				$result['runId'] = $GunshotRun->id;
				$result['scoreList'] = array();
				$GunshotResults = GunshotResults::model()->findAll("runId=:r ORDER BY startSec ASC",array(":r"=>$GunshotRun->id));
				foreach($GunshotResults as $GunshotResult)
				{
					$temp = array(
						"startSec" => $GunshotResult->startSec,
						"endSec" => $GunshotResult->endSec,
						"score" => $GunshotResult->score,
					);
					$resultType = $GunshotResult->type;
					if(!isset($result['scoreList'][$resultType]))
					{
						$result['scoreList'][$resultType] = array();
					}
					$result['scoreList'][$resultType][] = $temp;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	//given a new video url, load into database and use python to get mp4
	public function actionImportVideo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoUrl = $request->getPost("url","");
		$websitePath = f::get("videoPath");//path for website videos
		$websiteRealPath = realpath($websitePath);
		//echo $websiteRealPath;//  : /opt/lampp/htdocs/daisy/assets/videos
		
		//if(count($videoList)>0)
		if($videoUrl != "")
		{
			$result = array(
				"status" => 0,
				"dataError" => array(),
			);
			$basePathName = Yii::app()->baseUrl."/";
			$pos = strpos($videoUrl, $basePathName);
			if ($pos !== false) {
			    $videoUrl = substr_replace($videoUrl, "", $pos, strlen($basePathName));
			}
			$videoList = array(
				//$basePathName,
				//$videoUrl,
				realpath($videoUrl), // realpath analyze relative from index.php
			);
			
			// we get a detailed list with video basename,related path and absolute path, ruled out that can be ignore
			$videoListProcessed = array(
				"addToDatabase" => array(), // the ones only need to add into database(or change something)
				"ignore" => array(),//orignal path not exists, 
				"furtherProcess" => array(), //ask python to further process.(resizing and copying)
			);
			$videoIds = array();// the video ids of the videos that have directly into the database
			foreach($videoList as $one)
			{
				$temp = array(
					"basename" => basename($one),
					"relatedPath" => $websitePath.basename($one), //directly watch path
					"websitePath" => realpath($websitePath.basename($one)),// website version //if not exists, will be false
					"originPath" => $one,// the original video
					"websiteExists" => file_exists(realpath($websitePath.basename($one))), // check if this video's website versioin exists
					"originExists" => file_exists($one),
					"websiteP" => realpath($websitePath),// realpath to videos of the website
				);
				//process
				if(!$temp['originExists'])
				{
					$videoListProcessed['ignore'][] = $temp;
				}
				else if($temp['originExists'] && $temp['websiteExists'])
				{
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
					if(!$Video->save())
					{
						$temp['error'] = $Video->getErrors();
						$result['dataError'][] = $temp;
						$result['status'] = 1;
					}
					$videoIds[] = $Video->id;
				}else
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
					try
					{
						PP::ppython_asyn("run::importVideos",$Process->id,$callback,$videoListProcessed['furtherProcess'],$userId);
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
				'addToDatabase' => count($videoListProcessed['addToDatabase']),
				'ignore' => count($videoListProcessed['ignore']),
			);
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteERRun()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
			);
			$Dataset = Dataset::model()->findByPk($datasetId);
			$Dataset->isDeleted = 1;
			if(($Dataset->userId != $userId) || !$Dataset->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetERRunList()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		if(true)
		{
			$result = array(
				"runList" => array(),
				"status" => 0,
			);
			$datasetList = Text::sql("SELECT D_dataset.*,D_dataset.id AS datasetId FROM D_dataset WHERE D_dataset.userId=:u AND D_dataset.isDeleted=0 ORDER BY D_dataset.id ASC",array(":u"=>$userId));
			// for each dataset, get its cluster id.
			foreach($datasetList as &$one)
			{
				$datasetId = $one['datasetId'];
				$Clusters = ERclusters::model()->findAll("datasetId=:d ORDER BY videoNum DESC",array(":d"=>$datasetId));
				if(count($Clusters) != 0)//not youtube search or others
				{
					//TODO: delete it
					$one['clusterIds'] = array();
					foreach($Clusters as $Cluster)
					{
						$one['clusterIds'][] = $Cluster->id;
					}
					$result['runList'][] = $one;
				}
				
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetERRunVideos()
	{
		// return datasetId's video name list
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",-1);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
			);
			$result['videos'] = Text::sql("SELECT D_videos.name AS videoname FROM D_videos,D_dataset,D_dataset_video WHERE D_dataset.id=:d AND D_dataset.id=D_dataset_video.datasetId AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id ASC",array(":d"=>$datasetId));
			echo Text::json_encode_ch($result);
		}
	}
	/*
	public function actionTest()
	{
		$videopath = "/home/chunwaileong/htdocs/daisy/assets/uploadFiles/174fa8c93ededc233174d8637d3cd877/0JeoaeIUNm0.mp4";
		$duration = Videos::getDuration($videopath);
		echo $duration;
	}*/
	//delete ER cluster
	public function actionDeleteCluster()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$clusterId = $request->getPost("clusterId",0);
		if(($clusterId != 0) && ($datasetId != 0))
		{
			$result=array(
				"status" => 0
			);
			$ERcluster = ERclusters::model()->find("datasetId=:d AND id=:c",array(":d"=>$datasetId,":c"=>$clusterId));
			if($ERcluster!=null)
			{
				/*
				$ERcluster->isDeleted = 1;
				if(!$ERcluster->save())
				{
					$result['status'] = 1;
				}*/
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					ERresults::model()->deleteAll("clusterId=:c",array(":c"=>$ERcluster->id));
					$ERcluster->delete();
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 3;
					$result['error'] = $e->getMessage();
				}
			}
			else
			{
				$result['status']= 2;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetVideoSyncResult()
	{
		//given clusterId , get global result
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",-1);
		$clusterId = $request->getPost("clusterId",0);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0
			);
			if($clusterId == 0)
			{
				// get the largest cluster
				$Cluster = ERclusters::model()->find("datasetId=:d AND isDeleted=0 ORDER BY videoNum DESC",array(":d"=>$datasetId));
				$clusterId = $Cluster->id;
			}
			$result['videos'] = ERclusters::getResult($clusterId);
			// for each video,count the pair mark with marks
			foreach($result['videos'] as &$video)
			{
				$video['correct'] = ERpairs::model()->count("srcId=:v AND datasetId=:d AND userId=:u AND mark>0",array(":d"=>$datasetId,":v"=>$video['dvId'],":u"=>$userId));
				$video['wrong'] = ERpairs::model()->count("srcId=:v AND datasetId=:d AND userId=:u AND mark<0",array(":d"=>$datasetId,":v"=>$video['dvId'],":u"=>$userId));
			}
			$Dataset = Dataset::model()->findByPk($datasetId);
			$result['datasetId'] = $Dataset->id;
			//$result['forLabeling'] = $Dataset->isImported;
			$result['forLabeling'] = 1;// all result need to be refine manually pairwisely.
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteVideoSyncResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$clusterId = $request->getPost("clusterId",0);
		$resultId = $request->getPost("resultId",0);
		if(($datasetId !=0) && ($clusterId!=0) && ($resultId !=0))
		{
			$result = array(
				"status" => 0
			);
			$Cluster = ERclusters::model()->findByPk($clusterId);
			if(($Cluster == null) || ($Cluster->datasetId != $datasetId))
			{
				$result['status'] = 1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$Result = ERresults::model()->findByPk($resultId);
					if($Result == null)
					{
						throw new Exception("no result");
					}
					$Result->delete();

					$Cluster->videoNum-=1;
					if(!$Cluster->save())
					{
						throw new Exception("ERcluster save");
					}
					$result['cluster'] = $Cluster->attributes;
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionChangeVideoSyncResultBatch()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId", 0);
		$clusterId = $request->getPost("clusterId", 0);
		$videos = $request->getPost("videos", NULL);
		if(($datasetId !=0) && ($clusterId!=0) && (count($videos) > 0))
		{
			$result = array(
				"status" => 0
			);
			$Cluster = ERclusters::model()->findByPk($clusterId);
			if(($Cluster == null) || ($Cluster->datasetId != $datasetId))
			{
				$result['status'] = 1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					foreach ($videos as $video) {
						$Result = ERresults::model()->findByPk($video['resultId']);
						$offset = $video['offset'];
						if($Result == null)
						{
							throw new Exception("no result");
						}
						$Result->offset = $offset;
						if(!$Result->save())
						{
							throw new Exception("result save");
						}
					}
					
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionChangeVideoSyncResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$clusterId = $request->getPost("clusterId",0);
		$resultId = $request->getPost("resultId",0);
		$offset = (double)$request->getPost("offset",-1.0);
		if(($datasetId !=0) && ($clusterId!=0) && ($resultId !=0) && ($offset >= 0.0))
		{
			$result = array(
				"status" => 0
			);
			$Cluster = ERclusters::model()->findByPk($clusterId);
			if(($Cluster == null) || ($Cluster->datasetId != $datasetId))
			{
				$result['status'] = 1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$Result = ERresults::model()->findByPk($resultId);
					if($Result == null)
					{
						throw new Exception("no result");
					}
					$Result->offset = $offset;
					if(!$Result->save())
					{
						throw new Exception("result save");
					}
					$result['cluster'] = $Cluster->attributes;
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionAddCluster()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		if(($datasetId != 0))
		{
			$result=array(
				"status" => 0
			);
			$ERcluster = new ERclusters();
			$ERcluster->isAuto = 0;
			$ERcluster->videoNum = 0;
			$ERcluster->datasetId = $datasetId;
			if(!$ERcluster->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionAddVideo2Cluster()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$clusterId = $request->getPost("clusterId",0);
		$videos = $request->getPost("videos",array());
		if(($datasetId !=0) && ($clusterId!=0) && (count($videos)!=0))
		{
			$result = array(
				"status" => 0
			);
			$Cluster = ERclusters::model()->findByPk($clusterId);
			if(($Cluster == null) || ($Cluster->datasetId != $datasetId))
			{
				$result['status'] = 1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$insertCount = 0;
					foreach($videos as $video)
					{
						$dvId = $video['dvId'];
						$offset = (double)$video['offset'];
						if(!ERresults::model()->exists("datasetId=:d AND clusterId=:c AND dvId=:v",array(":d"=>$datasetId,":c"=>$clusterId,":v"=>$dvId)))
						{
							$ERresult = new ERresults();
							$ERresult->datasetId = $datasetId;
							$ERresult->clusterId = $clusterId;
							$ERresult->dvId = $dvId;
							$ERresult->offset = $offset;
							$videoInfo = Videos::getInfoUsingDvId($dvId);
							if($videoInfo['duration'] == -1)
							{
								$Video = Videos::model()->findByPk($videoInfo['videoId']);
								$Video->duration = Videos::getDuration($Video->processPath);
								if(!$Video->save())
								{
									throw new Exception("video save");
								}
								$videoInfo['duration'] = $Video->duration;
							}
							$ERresult->duration = $videoInfo['duration'];
							if(!$ERresult->save())
							{
								throw new Exception("ERresult save");
							}
							$insertCount++;
						}
					}
					if($insertCount>0)
					{
						$Cluster->videoNum+=$insertCount;
						if(!$Cluster->save())
						{
							throw new Exception("ERcluster save");
						}
					}
					$result['insertCount'] = $insertCount;
					$result['cluster'] = $Cluster->attributes;
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}

	}
	public function actionGetVideoSyncClusters()
	{
		//given clusterId , get global result
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",-1);
		if($datasetId != -1)
		{
			$result = array(
				"status" => 0,
				"clusters" => array(),
			);
			$Dataset = Dataset::model()->findByPk($datasetId);
			if($Dataset != null)
			{
				$result['datasetname'] = $Dataset->name;
				// get the clusters
				$Clusters = ERclusters::model()->findAll("datasetId=:d AND isDeleted=0 ORDER BY id DESC",array(":d"=>$datasetId));
				foreach($Clusters as $Cluster)
				{
					$result['clusters'][] = $Cluster->attributes;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionRunVideoSync()
	{
		$request = Yii::app()->request;
		$videonames = $request->getPost("videonames",array());
		$runName = $request->getPost("runName","");
		$datasetId = $request->getPost("datasetId",0);
		$makeNewDataset = $request->getPost("makeNewDataset",0);
		$userId = Yii::app()->session['userId'];
		if((count($videonames)!=0 || ($makeNewDataset == 0)) && ($runName!=""))
		{
			$result = array(
				"status" => 0
			);
			//if want to make new dataset
			//check this datasetName exists or not
			if(($makeNewDataset == 1) && Dataset::model()->exists("name=:n AND userId=:u",array(
				":n" => $runName,
				":u" => $userId
			)))
			{
				$result['status'] = -1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					if($makeNewDataset == 1)
					{
						//find all video names and found a new dataset, new DVs
						//create dataset first
						$Dataset = new Dataset();
						$Dataset->name = $runName;
						$Dataset->note = "user run video sync";
						$Dataset->userId = $userId;
						$Dataset->createTime = new CDbExpression("NOW()");
						$Dataset->isImported = 0;
						if(!$Dataset->save())
						{
							throw new Exception("error creating dataset");
						}
						
						// create DV for each video
						foreach($videonames as $videoname)
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
							//$DV->rankScore = $rankScore;
							if(!$DV->save())
							{
								throw new Exception("dv saving error");
							}
						}
					}
					else
					{
						$Dataset = Dataset::model()->findByPk($datasetId);
						//check whether this dataset has already run sync
							// unless rerun?
						if(ERresults::model()->exists("datasetId=:d",array(":d"=>$Dataset->id)))
						{
							$result['status'] = -2;
						}
					}
					// get all the current video list and dataset name
					$push = array();
					if(($Dataset != null) && ($result['status'] == 0))
					{
						$push['datasetname'] = $Dataset->name;
						$push['datasetId'] = $Dataset->id;
						//get all the dv
						$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
							" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id DESC";
						$push['videos'] = Text::sql($cmd,array(":d"=>$Dataset->id));
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
						//return the datasetId for retreat result
						$result['datasetId'] = $Dataset->id;
					}
					else
					{
						throw new Exception("e:dataset not exists");
					}
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					$result['errorInfo'] = $e->getMessage();
					//$result['']
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetVideosInfo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoList = $request->getPost("videoList",array());
		if(count($videoList) > 0)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
			);
			foreach($videoList as $videoname)
			{
				$Video = Videos::model()->find("name=:v",array(":v"=>$videoname));
				if($Video == null)
				{
					$result['status'] = -1;
				}
				else
				{
					$temp = $Video->attributes;
					$temp['videoname'] = $temp['name'];
					$temp['videoId'] = $temp['id'];
					$result['videos'][] = $temp;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}

	public function actionAddDataset()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$bucket = $request->getPost("bucket",array());
		$name = $request->getPost("datasetName","");
		$note = $request->getPost("datasetNote","");
		if(($name != "") && (count($bucket) != 0))
		{
			$result = array(
				"status" => 0,
			);
			if(Dataset::model()->find("name=:n AND userId=:u",array(":n"=>$name,":u"=> $userId)))
			{
				$result['status'] = 1;
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					//make dataset
					$Dataset = new Dataset();
					$Dataset->name = $name;
					$Dataset->note = $note;
					$Dataset->createTime = new CDbExpression("NOW()");
					$Dataset->userId = $userId;
					if(!$Dataset->save())
					{
						print_r($Dataset->getErrors());
						throw new Exception("dataset save()");
					}
					$videoIdList = array();
					foreach($bucket as $one)
					{
						if($one['type'] == "video")
						{
							$videoIdList[] = $one['videoId'];
						}
						//dataset?
					}
					foreach($videoIdList as $videoId)
					{
						$DV = new DatasetVideo();
						$DV->datasetId = $Dataset->id;
						$DV->videoId = $videoId;
						$DV->createTime = new CDbExpression("NOW()");
						$DV->changeTime = new CDbExpression("NOW()");
						if(!$DV->save())
						{
							throw new Exception("DV save");
						}
					}
					$result['datasetId'] = $Dataset->id;
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 1;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}

	public function actionGetDatasetInfo()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetname = $request->getPost("datasetname","");
		if($datasetname != "")
		{
			$result = array(
				"status" => 0,
				"dataset" => array(),
			);
			
			$Dataset = Dataset::model()->find("name=:v AND userId=:u",array(":v"=>$datasetname,":u"=>$userId));
			if($Dataset == null)
			{
				$result['status'] = -1;
			}
			else
			{
				$temp = $Dataset->attributes;
				$temp['datasetname'] = $temp['name'];
				$temp['datasetId'] = $temp['id'];
				$temp['previews'] = array();
				//get video COunt
				$Count = Text::sql("SELECT COUNT(*) as a FROM D_dataset_video WHERE D_dataset_video.datasetId=:d",array(":d"=>$Dataset->id));
				$temp['videoCount'] = $Count[0]['a'];
				// get preview img
				$Videos = Text::sql("SELECT D_videos.id,D_videos.name FROM D_dataset_video,D_videos WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id AND D_videos.hasImgs=1 ORDER BY D_videos.id DESC LIMIT 0,5",array(":d"=>$Dataset->id));
				foreach($Videos as $one)
				{
					$temp['previews'][] = array(
						"img" => Yii::app()->baseUrl."/".f::get("videoImgPath").$one['name']."_1.png",
						"videoname" => $one['name'],
					);
				}

				$result['dataset'] = $temp;
			}
			echo Text::json_encode_ch($result);
		}
	}
	
	public function actionImportVideos()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$videoUrls = $request->getPost("urls","");
		$websitePath = f::get("videoPath");//path for website videos
		$imgPath = realpath(f::get("videoImgPath"));//video preview img path
		$websiteRealPath = realpath($websitePath);
		//echo $websiteRealPath;//  : /opt/lampp/htdocs/daisy/assets/videos
		
		//if(count($videoList)>0)
		if($videoUrls != "")
		{
			$result = array(
				"status" => 0,
				"dataError" => array(),
			);
			$basePathName = Yii::app()->baseUrl."/";
			foreach($videoUrls as &$videoUrl)
			{
				$pos = strpos($videoUrl, $basePathName);
				if ($pos !== false) {
				    $videoUrl = substr_replace($videoUrl, "", $pos, strlen($basePathName));
				}
				
				$videoUrl = realpath($videoUrl);
			}
			$videoList = $videoUrls;
			
			// we get a detailed list with video basename,related path and absolute path, ruled out that can be ignore
			$videoListProcessed = array(
				"addToDatabase" => array(), // the ones only need to add into database(or change something)
				"ignore" => array(),//orignal path not exists, 
				"furtherProcess" => array(), //ask python to further process.(resizing and copying)
			);
			foreach($videoList as $one)
			{
				$temp = array(
					"basename" => basename($one),
					"relatedPath" => $websitePath.basename($one), //directly watch path
					"websitePath" => realpath($websitePath.basename($one)),// website version //if not exists, will be false
					"originPath" => $one,// the original video
					"websiteExists" => file_exists(realpath($websitePath.basename($one))), // check if this video's website versioin exists
					"originExists" => file_exists($one),
					"websiteP" => realpath($websitePath),// realpath to videos of the website
				);
				//process
				if(!$temp['originExists'])
				{
					$videoListProcessed['ignore'][] = $temp;
				}
				else if($temp['originExists'] && $temp['websiteExists'])
				{
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
					if(!$Video->save())
					{
						$temp['error'] = $Video->getErrors();
						$result['dataError'][] = $temp;
						$result['status'] = 1;
					}
				}else
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
					try
					{
						PP::ppython_asyn("run::importVideos",$Process->id,$callback,$videoListProcessed['furtherProcess'],$userId,true,$imgPath);
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
				'addToDatabase' => count($videoListProcessed['addToDatabase']),
				'ignore' => count($videoListProcessed['ignore']),
			);
			echo Text::json_encode_ch($result);
		}
	}

	public function actionDownloadLabel($datasetId)
	{
		//get datasetId, 
		$datasetName = Dataset::model()->findByPk($datasetId)->name;
		$sqlcmd = "SELECT D_er_pairs.*,dv1.rankScore,v1.name AS videoname1,v2.name AS videoname2 FROM D_er_pairs,D_dataset_video AS dv1,D_dataset_video AS dv2,D_videos AS v1,D_videos AS v2 WHERE D_er_pairs.datasetId=:d AND D_er_pairs.mark <>0 AND D_er_pairs.srcId=dv1.id AND dv1.videoId=v1.id AND D_er_pairs.desId=dv2.id AND dv2.videoId=v2.id ORDER BY dv1.rankScore DESC";
		$data = Text::sql($sqlcmd,array(":d"=>$datasetId));
		$csv = array();
		$csvHead = explode(",","videoname1,videoname2,offset(s),\"mark(1duplicate,2correct,-1wrong)\",rankScoreForV1");
		$csv[] = $csvHead;
		$filename = "labeling result - $datasetName ".date("Y-m-d",time());
		foreach($data as $one)
		{
			$line = array(
					$one['videoname1'],
						$one['videoname2'],
						$one['offset'],
						$one['mark'],
						$one['rankScore']
								
			);
			$csv[] = $line;
		}
		Yii::import("application.extensions.CsvPrinter");
		$CsvPrinter = new CsvPrinter($csv, $filename);
		$CsvPrinter->run();
	}
	public function actionSearchVideos()
	{
		$request = Yii::app()->request;
		$videoname = $request->getPost("videoname","");
		if($videoname != "")
		{
			$result = array(
				"status" => 0
			);
			$sqlcmd = "SELECT D_videos.*,D_videos.name AS videoname FROM D_videos WHERE D_videos.name LIKE :keyword ORDER BY D_videos.id ASC LIMIT 0,10 ";
			$result['videoList'] = Text::sql($sqlcmd,array(":keyword"=>"%$videoname%"));
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSearchDatasets()
	{
		$request = Yii::app()->request;
		$datasetname = $request->getPost("datasetname","");
		if($datasetname != "")
		{
			$result = array(
				"status" => 0
			);
			$sqlcmd = "SELECT D_dataset.*,D_dataset.name AS datasetname FROM D_dataset WHERE D_dataset.name LIKE :keyword ORDER BY D_dataset.id ASC LIMIT 0,10 ";
			$result['datasetList'] = Text::sql($sqlcmd,array(":keyword"=>"%$datasetname%"));
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSearchVideo()
	{
		$request = Yii::app()->request;
		$videoname = $request->getPost("videoname","");
		if($videoname != "")
		{
			$result = array(
				"status" => 0
			);
			$sqlcmd = "SELECT D_videos.*,D_videos.name AS videoname FROM D_videos WHERE D_videos.name = :keyword ORDER BY D_videos.id ASC LIMIT 0,10 ";
			$result['videoList'] = Text::sql($sqlcmd,array(":keyword"=>$videoname));
			echo Text::json_encode_ch($result);
		}
	}
	//get the progress of a processId (from phpwebsite)
	public function actionProgress()
	{
		$request = Yii::app()->request;
		$processId = $request->getPost("processId",0);
		$userId = Yii::app()->session['userId'];
		if($processId != 0)
		{
			$result = array(
				"status" => 0,
			);
			$Process = Process::model()->findByPk($processId);
			if($Process == null)
			{
				$result['status'] = 1;//process not found
			}
			else if($Process->userId != $userId)
			{
				$result['status'] = 2;//process not owner
			}
			else
			{
				$result['processId'] = $Process->id;
				$result['progress'] = $Process->progress;
				$result['done'] = $Process->done;
				$result['message'] = $Process->message;
				$result['createTime'] = $Process->createTime;
				$result['changeTime'] = $Process->changeTime;
				$result['type'] = $Process->type; //type 2 job?
			}
			echo Text::json_encode_ch($result);
		}
	}

	//get datasetlist (identical with superController)
	// for audio sync
	public function actionGetDatasetList($forSync=0)
	{
		$request = Yii::app()->request;
		$result = array(
			"status" => 0,
			"datasets" => array(),
		);
		$userId = Yii::app()->session['userId'];
		$Datasets = Dataset::model()->findAll("isDeleted=0 AND userId=:u ORDER BY id DESC",array(":u"=>$userId));
		foreach($Datasets as $Dataset)
		{
			if($forSync == 1)
			{
				if(ERpairs::model()->exists("datasetId=:d",array(":d"=>$Dataset->id)))
				{
					$result['datasets'][] = $Dataset->attributes;
				}
			}
			else
			{
				$result['datasets'][] = $Dataset->attributes;
			}
		}
		echo Text::json_encode_ch($result);
	}
	//get datasetVideo (identical with superController)
	public function actionGetDatasetVideos($forLabeling=0,$sign=0,$start=1,$limit=10)
	{
		//$sign:  1: get the result with rankScoreManual >0, 0: get ==0, -1 get <0;means correct, not labeled, all error
		$limit = (int)$limit;
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		if($datasetId != 0)
		{
			$result = array(
				"status" => 0,
				"videos" => array(),
				"stat" => array(
					"sign0" => 0,
					"sign1" => 0,// > 0, maybe 1(duplicate correct),2,
					"sign-1" => 0,
					'sign2' => 0,
				),
			);
			if($forLabeling == 1)
			{
				// get statics
				$result['stat']['sign0'] = DatasetVideo::model()->count("datasetId=:d AND rankScoreManual = 0",array(":d"=>$datasetId));
				$result['stat']['sign1'] = DatasetVideo::model()->count("datasetId=:d AND rankScoreManual > 0",array(":d"=>$datasetId));
				$result['stat']['sign-1'] = DatasetVideo::model()->count("datasetId=:d AND rankScoreManual < 0",array(":d"=>$datasetId));
				$result['stat']['sign2'] = Text::sql("SELECT COUNT(DISTINCT D_dataset_video.id) AS a FROM D_dataset_video,D_er_pairs WHERE D_dataset_video.datasetId=:d AND D_er_pairs.srcId=D_dataset_video.id AND D_er_pairs.mark=2",array(":d"=>$datasetId))[0]['a'];
				//actual correct, that has a ER mark with 2.
				if($sign == 2)
				{
					//get all dvId first
					$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
					//" WHERE D_dataset_video.id > :s AND D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id AND ${signStr} ORDER BY D_dataset_video.rankScore DESC LIMIT 0,${limit}";
					" WHERE D_dataset_video.rankScore < :s AND D_dataset_video.id IN (".
						"SELECT DISTINCT D_dataset_video.id FROM D_dataset_video,D_er_pairs WHERE D_dataset_video.datasetId=:d AND D_er_pairs.srcId=D_dataset_video.id AND D_er_pairs.mark=2".
					") AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.rankScore DESC LIMIT 0,${limit}";
					$result['videos'] = Text::sql($cmd,array(":d"=>$datasetId),array(":s"=>$start));//$start use STR as float
				}
				else
				{
					$signStr = "D_dataset_video.rankScoreManual = 0";
					if($sign == -1)
					{
						$signStr = "D_dataset_video.rankScoreManual < 0";
					}
					else if($sign == 1)
					{
						$signStr = "D_dataset_video.rankScoreManual > 0";
					}
					$start-=0.0000001; // accuracy prob? // this is the smallest 
					$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
					//" WHERE D_dataset_video.id > :s AND D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id AND ${signStr} ORDER BY D_dataset_video.rankScore DESC LIMIT 0,${limit}";
					" WHERE D_dataset_video.rankScore < :s AND D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id AND ${signStr} ORDER BY D_dataset_video.rankScore DESC LIMIT 0,${limit}";
					$result['videos'] = Text::sql($cmd,array(":d"=>$datasetId),array(":s"=>$start));
				}
			}
			else
			{
				$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
				" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.rankScore DESC";
				$result['videos'] = Text::sql($cmd,array(":d"=>$datasetId));
			}
			
			$result['forLabeling'] = $forLabeling;
			$result['sign'] = $sign;
			$result['datasetId'] = $datasetId;
			echo Text::json_encode_ch($result);
		}
	}
	//get D_er_pair result with the des video name
	public function actionGetResultER($forLabeling=0)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$dvId = $request->getPost("dvId",0);
		$datasetId = $request->getPost("datasetId",0);
		$videoname = $request->getPost("videoname","");
		if(($dvId != 0) && ($datasetId != 0) && ($videoname != ""))
		{
			$result = array(
				"status" => 0,
				"videoInfo" => array(),
				"forLabeling" => $forLabeling,
			);

			$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,D_videos.*,D_videos.name AS videoname from D_er_pairs,D_videos,D_dataset_video ".
					" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.datasetId=:d".
					" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id AND D_videos.name=:v";
			$search = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$dvId,":v"=>$videoname));
			if(count($search) == 0)
			{
				//$result['status'] = 1;
				// if not found, it means the video pair not in the video's top 5. so we create a new pair, with fake score
				// first find the video's dvId
				$cmd = "SELECT D_dataset_video.id AS dvId, D_videos.name AS videoname FROM D_videos, D_dataset_video WHERE D_videos.name=:v AND D_videos.id=D_dataset_video.videoId AND D_dataset_video.datasetId=:d";
				$dvsearch = Text::sql($cmd, array(":d"=>$datasetId,":v"=>$videoname));
				
				if(count($dvsearch) == 0)
				{
					$result['status'] = 1;
				}
				else
				{
					$desdvId = $dvsearch[0]['dvId'];
					// make a new ERpair
					$ERpair = new ERpairs();
					$ERpair->datasetId = $datasetId;
					$ERpair->srcId = $dvId;
					$ERpair->desId = $desdvId;
					$ERpair->createTime = new CDbExpression("NOW()");
					
					$ERpair->offset = 0.0;
					$ERpair->confidence = 10.0;
					$ERpair->changeTime = new CDbExpression("NOW()");
					if(!$ERpair->save())
					{
						$result['status'] = 2;
					}
					else
					{
						// then search it again
						$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,D_videos.*,D_videos.name AS videoname,D_videos.id AS videoId from D_er_pairs,D_videos,D_dataset_video ".
						" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.datasetId=:d".
						" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id AND D_videos.name=:v";
						$search = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$dvId,":v"=>$videoname));
						$result['videoInfo'] = $search[0];
					}
				}
			}
			else
			{
				$result['videoInfo'] = $search[0];
			}
			echo Text::json_encode_ch($result);
		}

	}
	//get D_er_pair result base on 
	public function actionGetResultsER($forLabeling=0)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$dvId = $request->getPost("dvId",0);
		$datasetId = $request->getPost("datasetId",0);
		if(($dvId != 0) && ($datasetId != 0))
		{
			$result = array(
				"status" => 0,
				"videoInfo" => array(),// this dvId's video Info, get it again
				"ranklist" => array(),
				"forLabeling" => $forLabeling,
			);
			$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,D_videos.*,D_videos.name AS videoname,D_dataset_video.id AS desDvId,D_videos.id AS videoId from D_er_pairs,D_videos,D_dataset_video ".
					" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.datasetId=:d".
					" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id ORDER BY D_er_pairs.mark DESC,D_er_pairs.confidence DESC LIMIT 0,10";
			$result['ranklist'] = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$dvId));
			$result['videoInfo'] = Videos::getInfoUsingDvId($dvId);
			echo Text::json_encode_ch($result);
		}

	}
	public function actionGetResultsERsegment()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$segmentId = $request->getPost("segmentId",0);
		$datasetId = $request->getPost("datasetId",0);
		$dvId = $request->getPost("dvId",0);
		if(($segmentId != 0) && ($datasetId != 0))
		{
			$result = array(
				"status" => 0,
				"videoInfo" => array(),// this dvId's video Info, get it again
				"ranklist" => array(),
			);
			$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,D_videos.*,D_videos.name AS videoname from D_er_pairs,D_videos,D_dataset_video ".
					" WHERE D_er_pairs.srcId=:srcdvId AND D_er_pairs.isSegment1=1 AND D_er_pairs.datasetId=:d".
					" AND D_er_pairs.desId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id ORDER BY D_er_pairs.confidence DESC LIMIT 0,5";
			$result['ranklist'] = Text::sql($cmd,array(":d"=>$datasetId,":srcdvId"=>$segmentId));
			$result['videoInfo'] = Videos::getInfoUsingDvId($dvId);
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteSegment()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$segmentId = $request->getPost("segmentId",0);
		if($segmentId != 0)
		{
			$result = array(
				"status" => 0,
				//"segmentList" => array(),
			);
			//delete segment, delete er_pairs
			$Segment = Segments::model()->findByPk($segmentId);
			if(($Segment == null) || ($Segment->userId != $userId))
			{
				$result['status'] = 1;
			}
			else
			{
				ERpairs::model()->deleteAll("srcId=:s AND isSegment1=1",array(":s"=>$segmentId));
				$Segment->delete();
			}
			echo Text::json_encode_ch($result);
		}
	}
	//get dvId's segment list
	public function actionGetSegmentList()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$dvId = $request->getPost("dvId",0);
		if($dvId != 0)
		{
			$result = array(
				"status" => 0,
				//"segmentList" => array(),
			);
			$cmd = "SELECT D_segments.*,D_segments.id AS segmentId FROM D_segments WHERE D_segments.userId=:u AND D_segments.dvId=:d ORDER BY D_segments.id DESC";
			$result['segmentList'] = Text::sql($cmd,array(":u"=> $userId,":d"=>$dvId));
			//get rid of those don't have results
			foreach($result['segmentList'] as $key=>$val)
			{
				if(!ERpairs::model()->exists("srcId=:s AND isSegment1=1",array(":s"=>$val['segmentId'])))
				{
					unset($result['segmentList'][$key]);
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// get the pairwise er result to python to refine the result and get the global result
	public function actionRefineERresults()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$datasetId = $request->getPost("datasetId",0);
		$refineType = $request->getPost("refineType",0);// 1 for only confirmed, 2 for all
		if(($datasetId != 0) && ($refineType != 0))
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
				$erRefinePath = f::get("erRefinePath");
				$workDir = $erRefinePath.$Dataset->name."/";
				try
				{
					if($refineType == 1)
					{
						// get the confirmed result and make into files
						$cmd = "SELECT D_er_pairs.*,D_er_pairs.id AS erId,V1.name AS srcVideoname,V2.name AS desVideoname,D1.id AS srcDvId,D2.id AS desDvId from D_er_pairs,D_videos AS V1,D_videos AS V2,D_dataset_video AS D1,D_dataset_video AS D2 ".
							" WHERE D_er_pairs.datasetId=:d".
							" AND D_er_pairs.mark > 0 AND D_er_pairs.srcId=D1.id AND D1.videoId=V1.id AND D_er_pairs.desId=D2.id AND D2.videoId=V2.id ORDER BY D_er_pairs.mark DESC,D_er_pairs.confidence DESC";
						$data = Text::sql($cmd,array(":d"=>$datasetId));
						$ranklist = array();
						foreach($data as $one)
						{
							if(!isset($ranklist[$one['srcVideoname']]))
							{
								$ranklist[$one['srcVideoname']] = array();
							}
							$ranklist[$one['srcVideoname']][$one['desVideoname']] = array(
								"offset" => $one['offset'],
								"conf" => $one['confidence'],
							);
						}
						unset($data);
						//$result['data'] = Text::json_encode_ch($ranklist);
						if(is_dir($workDir))
						{
							//rmdir($workDir);
							Text::deletePath($workDir);
						}
						//write it into files
						mkdir($workDir,0777,true);
						$workDir = realpath($workDir)."/";
						foreach($ranklist as $srcVideoname=>$one)
						{
							$srcVideoname = basename($srcVideoname,".mp4");
							$rankFilePath = $workDir.$srcVideoname.".txt";
							$rankFile = fopen($rankFilePath,'w');
							foreach($one as $desVideoname=>$data)
							{
								fwrite($rankFile,basename($desVideoname,".mp4").",".$data['offset'].",".$data['conf'].",0.0,0.0\n");
							}
							fclose($rankFile);
						}

						// send to python to do it
						//not use transaction, since python could fail anyway
						$result['processStatus'] = 0;// sucessfully submit process job
						$Process = new Process();
						$Process->type = 1;
						$Process->createTime = new CDbExpression("NOW()");
						$Process->changeTime = new CDbExpression("NOW()");
						$Process->userId = $userId;
						$Process->metaId = $Dataset->id;
						if(!$Process->save())
						{
							$result['processStatus'] = 1;//couldn't save process.
						}
						else
						{
							//post job to python
							Yii::import("application.extensions.PP");
							$callback = PP::cb("eventReconstruction");
							try
							{
								PP::ppython_asyn("run::refineER",$Process->id,$callback,$workDir,$Dataset->id);
								$result['processId'] = $Process->id;
							}
							catch(Exception $e)
							{
								$result['processStatus'] = 2;// send to python error
								$result['processError'] = $e->getMessage();
								$result['status'] = 2;
							}
						}
					}//refineType == 1
				}catch(Exception $e)
				{
					$result['error'] = $e->getMessage();
					$result['status'] = 1;
				}

			}
			echo Text::json_encode_ch($result);
		}
	}
	//set audio sync experiment label
	public function actionSetAudioSyncExpMark()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$pairId = $request->getPost("pairId",0);
		$mark = $request->getPost("mark",null);
		$propagate = $request->getPost("propagate",0);
		if(($pairId != 0) && ($mark != null))
		{
			$result = array(
				"status" => 0
			);
			$Pair = AudioSyncExpPairs::model()->findByPk($pairId);
			if($Pair != NULL)
			{
				$Pair->mark = $mark;
				$Pair->changeTime = new CDbExpression("NOW()");
				if(!$Pair->save())
				{
					$result['status'] = 1;
				}
				if(($mark!=0) && ($propagate == 1))
				{
					Text::sql("UPDATE D_audioSyncExpPairs SET mark=:m,changeTime=NOW() WHERE (videoId1=:v1 AND videoId2=:v2) OR (videoId1=:v3 AND videoId2=:v4)",array(
						":v1"=>$Pair->videoId1,
						":v2"=>$Pair->videoId2,
						":v3"=>$Pair->videoId2,
						":v4"=>$Pair->videoId1,
						":m"=>$Pair->mark,
					),array(),false);
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSetERmark()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$erId = $request->getPost("erId",0);
		$mark = $request->getPost("mark",null);
		if(($erId != 0) && ($mark != null))
		{
			$result = array(
				"status" => 0,
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try
			{
				$ER = ERpairs::model()->findByPk($erId);
				if($ER!=null)
				{
					$ER->mark = $mark;
					$ER->changeTime = new CDbExpression("NOW()");
					$ER->userId = $userId;
					if(!$ER->save())
					{
						throw new Exception("ER save 1");
					}
					$dvIds = array($ER->srcId);
					//set the opposite ER to be the same
					// what about the chain? should we refresh all videos in the chain?
					// should it propagate?
					$ERop = ERpairs::model()->find("srcId=:s AND desId=:d AND datasetId=:r",array(":s"=>$ER->desId,":d"=>$ER->srcId,":r"=>$ER->datasetId));
					if($ERop!=null)
					{
						$dvIds[] = $ERop->srcId;
						$ERop->mark = $mark;
						$ERop->changeTime = new CDbExpression("NOW()");
						$ERop->userId = $userId;
						//$ERop->offset = -$ER->offset;
						if($ERop->offset != -$ER->offset)
						{
							if(($ERop->auto == 1) && ($ERop->autoOffset == null))//save auto offset
							{
								$ERop->autoOffset = $ERop->offset;
							}
							$ERop->offset = -$ER->offset;
							$ERop->auto = 0;
							$ERop->changeTime = new CDbExpression("NOW()");
						}
						
						if(!$ERop->save())
						{
							throw new Exception("ER save 2");
						}
					} 
					/*else
					{
						throw new Exception($ER->srcId." ".$ER->desId);
					}*/

					//set the status of this video, since one ER is correct then the video is correct.
					//set the DVId 's rankScoreManual to be correct if any correct, wrong if any wrong
					/*// for each dvId, the rankScoreManual decides that
						if(score < 0)
						{
							return "all wrong";
						}
						else if(score > 0)
						{
							return "correct";
						}
						return "Not Labeled";
					*/
					foreach($dvIds as $dvId)
					{
						$DV = DatasetVideo::model()->findByPk($dvId);
						if($DV == null)
						{
							$result['status'] = 3;
						}
						else
						{
							if($mark > 0) // mark == 1 or 2
							{
								$DV->rankScoreManual = 1;// one ER correct then all correct
							}
							else if($mark == -1)// this er mark as wrong. check other ER
							{
								//check any is 1, if there is 1, then still 1
								if(!ERpairs::model()->exists("srcId=:dvId and mark>0",array(":dvId"=>$dvId)))
								{
									$DV->rankScoreManual = -1;
								}
							}
							else// reset.
							{
								//check any is 1, if there is 1, then still 1
								if(!ERpairs::model()->exists("srcId=:dvId and mark>0",array(":dvId"=>$dvId)))
								{
									$DV->rankScoreManual = -1;
								}
							}
							if(!$DV->save())
							{
								throw new Exception("DV save");
							}
						}
					}
				}else
				{
					throw new Exception("ER not found");
				}
				$transaction->commit();
			}
			catch(Exception $e)
			{
				$transaction->rollback();
				$result['status'] = 1;
				$result['errorInfo'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetLabelResult()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$dvId = $request->getPost("dvId",0);
		if($dvId != 0)
		{
			$result = array(
				"status" => 0,
				//"segmentList" => array(),
			);
			$DV = DatasetVideo::model()->findByPk($dvId);
			$result['rankScoreManual'] = $DV->rankScoreManual;
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSearchSegment()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$dvId = $request->getPost("dvId",0);
		$start = (double)$request->getPost("start",-1);
		$end = (double)$request->getPost("end",-1);
		$labelName = $request->getPost("name","");
		if(($dvId != 0) && ($start >= 0.0) && ($end > 0.0) && ($labelName != ""))
		{
			$result = array(
				"status" => 0
			);
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			try
			{
				$videoInfo = Videos::getInfoUsingDvId($dvId);
				$videoName = $videoInfo['videoname'];
				$datasetName = $videoInfo['datasetName'];
				$datasetId = $videoInfo['datasetId'];
				// get all the video, need the dvId for python to return result
				$cmd = "SELECT D_videos.*, D_dataset_video.*,D_videos.name AS videoname,D_dataset_video.id AS dvId FROM D_videos,D_dataset_video".
						" WHERE D_dataset_video.datasetId=:d AND D_dataset_video.videoId=D_videos.id ORDER BY D_dataset_video.id DESC";
					$videos = Text::sql($cmd,array(":d"=>$datasetId));
				// save the segment and get segment Id
				$Segment = new Segments();
				$Segment->dvId = $dvId;
				$Segment->start = $start;
				$Segment->end = $end;
				$Segment->labelName = $labelName;
				$Segment->userId = $userId;
				$Segment->createTime = new CDbExpression("NOW()");
				if(!$Segment->save())
				{
					$result['status'] = 1;
					throw new Exception("e:save");
				}
				$Process = new Process();
				$Process->type = 4;
				$Process->createTime = new CDbExpression("NOW()");
				$Process->changeTime = new CDbExpression("NOW()");
				$Process->userId = $userId;
				if(!$Process->save())
				{
					$result['status'] = 2;
					throw new Exception("e:process");
				}
				else
				{
					//post job to python
					Yii::import("application.extensions.PP");
					$callback = PP::cb("eventReconstructionSegmentSearch");
					
					PP::ppython_asyn("run::eventReconstructionSegmentSearch",$Process->id,$callback,$videoName,$start,$end,$datasetName,$datasetId,$videos,$Segment->id);
					$result['processId'] = $Process->id;
				}
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollback;
				$result['errorInfo'] = $e->getMessage();
			}
			echo Text::json_encode_ch($result);
		}
	}
	//save offset for audio sync experiemtn
	public function actionSaveOffsetAudioSyncExp()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$pairId = $request->getPost("pairId",0);
		$offset = $request->getPost("offset",null);
		if(($pairId != 0) && ($offset != null))
		{
			$result = array(
				"status" => 0,
			);
			$Pair = AudioSyncExpPairs::model()->findByPk($pairId);
			if($Pair != NULL)
			{
				if($offset == $Pair->offset)
				{

				}
				else
				{
					if($Pair->originalOffset  == NULL)
					{
						$Pair->originalOffset = $Pair->offset;
					}
					$Pair->offset = $offset;
					$Pair->changeTime = new CDbExpression("NOW()");
					if(!$Pair->save())
					{
						$result['status'] = 1;
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSaveOffset()
	{	
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$erId = $request->getPost("erId",0);
		$offset = $request->getPost("offset",null);
		if(($erId != 0) && ($offset != null))
		{
			$result = array(
				"status" => 0,
			);
			$ER = ERpairs::model()->findByPk($erId);
			if($ER!=null)
			{
				// the auto one is the same as new one
				if($offset == $ER->offset)
				{
					// do nothing
				}
				else
				{
					if(($ER->auto == 1) && ($ER->autoOffset == null))//save auto offset
					{
						$ER->autoOffset = $ER->offset;
					}
					$ER->offset = $offset;
					$ER->auto = 0;
					$ER->changeTime = new CDbExpression("NOW()");
					$ER->userId = $userId;
					if(!$ER->save())
					{
						$result['status'] = 2;
					}
				}
			}else
			{
				$result['status'] = 1;//not found
			}
			echo Text::json_encode_ch($result);
		}
	}


	//修改用户 nickname
	public function actionChangeNickname()
	{
		if(isset($_POST['nickname']) && ($_POST['nickname'] != ""))
		{
			$userId = Yii::app()->session['userId'];
			$User = User::model()->findByPk($userId);
			if($User != NULL)
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$nicknameBefore = $User->nickName;
					$User->nickName = $_POST['nickname'];
					if(!$User->save())
					{
						throw new Exception("error");
					}
					//修改session
					Yii::app()->session['nickName'] = $User->nickName;
					//加入日志
						//获取user信息
						$nickname = $User->nickName;
					Log::addLog(array(
						"type" => USER_CHANGENICKNAME,
						"userId" => $userId,
						"actionId" => $userId,
						"param" => array(
							"nicknameBefore" => $nicknameBefore,
							"nicknameNow" => $nickname,
						),
					));
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					die("error");
				}
			}
		}
	}
	//修改用户 密码 
	public function actionChangePw()
	{
		if(isset($_POST['oldPw']) && isset($_POST['newPw']) && !empty($_POST['newPw']))
		{
			$userId = Yii::app()->session['userId'];
			$User = User::model()->findByPk($userId);
			if(($User == NULL) || ($User->userPw != md5($_POST['oldPw'])))
			{
				$data = array(
					"error" => 1,
				);
				echo Text::json_encode_ch($data);
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$pwBefore = $User->userPw;
					$User->userPw = md5($_POST['newPw']);
					if(!$User->save())
					{
						throw new Exception("e");
					}
					//添加日志
					Log::addLog(array(
						"type" => USER_CHANGEPW,
						"userId" => $userId,
						"actionId" => $userId,
						"param" => array(
							"pwBefore" => $pwBefore,
							"pwNow" => $User->userPw,
						),
					));
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					die("error");
				}
				$data = array();
				echo Text::json_encode_ch($data);
			}
		}
	}
	
	
	//获取消息总数
	public function actionGetRemindSum()
	{
		$userId = Yii::app()->session['userId'];
		$data = array();
		$data['remindSum'] = Remind::model()->count("isRead=0 AND isRevoked=0 AND toUserId=:u",array(
			":u" => $userId,
		));
		echo Text::json_encode_ch($data);
		
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
			
			'accessControl',
			//'replaceHtml',
			//'userLevel3 + newProject',//高级用户的筛选
			
		);
	}
	
	public function filterAccessControl($filterChain)
	{
		if(!isset(Yii::app()->session['userId']) || !isset(Yii::app()->session['userName']))
		{
			//不可能是ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
				if(!isset(Yii::app()->session['userId']))
				{
					echo "not set userId";
				}
				if(!isset(Yii::app()->session['userName']))
				{
					echo "not set userName";
				}
				
					die("error:f*c*k.");			
			}
		}
		Yii::import("application.extensions.f");
		$filterChain->run();
	}
	public function filterReplaceHtml($filterChain)
	{
		//对POST字段进行单层的特殊字符过滤
		$exceptions = array();
		if(isset($_POST))	
		{
			foreach($_POST as $key => &$val)
			{
				if(!isset($exceptions[$key]))
				{
					Text::replaceHtml($val);
				}
			}
		}
		$filterChain->run();
	}
	public function filterUserLevel3($filterChain)
	{
		if(Yii::app()->session['userLevel'] != 3)//高级用户
		{
			die("error");
		}
		$filterChain->run();
	}
}
?>
