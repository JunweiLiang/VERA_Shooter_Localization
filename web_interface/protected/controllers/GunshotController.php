<?php

class GunshotController extends Controller
{
	//change model name
	public function actionChangeModelName()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$modelId = $request->getPost("modelId",-1);
		$modelName = $request->getPost("modelName","");
		if(($modelId != -1) && ($modelName != ""))
		{
			$result = array(
				"status" => 0
			);
			$Model = Models::model()->findByPk($modelId);
			if($Model != null)
			{
				$modelType = "gunshot";
				if(Models::model()->exists("isDeleted=0 AND modelname=:n and type=:t",array(
					":n" => $modelName,
					":t" => $modelType,
				)))
				{
					$result['status'] = 1;
				}
				else
				{
					$Model->modelname = $modelName;
					if(!$Model->save())
					{
						$result['status'] = 2;
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	//delete model
	public function actionDeleteModel()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$modelId = $request->getPost("modelId",-1);
		if($modelId != -1)
		{
			$result = array(
				"status" => 0
			);
			$Model = Models::model()->findByPk($modelId);
			if($Model != null)
			{
				//$Model->delete();
				$Model->isDeleted = 1;
				if(!$Model->save())
				{
					$result['status'] = 1;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSetDefaultModel()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$modelId = $request->getPost("modelId",-1);
		if($modelId != -1)
		{
			$result = array(
				"status" => 0
			);
			// change all default to 0
			Text::sql("UPDATE D_models SET isDefault=0 WHERE isDeleted=0",array(),array(),false);
			$Model = Models::model()->findByPk($modelId);
			if($Model != null)
			{
				$Model->isDefault = 1;
				if(!$Model->save())
				{
					$result['status'] = 1;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	//get all models
	public function actionGetModels()// admin use this
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		//get all labels if is Super
		$User = User::model()->findByPk($userId);
		$result = array(
			"status" => 0,
			"models" => array(),
		);
		// no model trained by users
		$result['models'] = Text::sql("SELECT D_models.* FROM D_models,T_user WHERE D_models.type='gunshot' AND D_models.isDeleted=0 AND D_models.userId=T_user.userId AND T_user.isSuper=1 ORDER BY D_models.id desc");
		echo Text::json_encode_ch($result);
	}

	//train model
	public function actionTrainModel($addDefault=0)//whether to add defaulte feature list, that have no labelId
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$modelName = $request->getPost("modelName","");
		$featureIdList = $request->getPost("featureList",array());
		if(($modelName != "") && (count($featureIdList) != 0))
		{
			$result = array(
				"status" => 0,
			);
			$modelType = "gunshot";
			// check model Name exists
			if(Models::model()->exists("isDeleted=0 AND modelname=:n and type=:t",array(
				":n" => $modelName,
				":t" => $modelType,
			)))
			{
				$result['status'] = 2;
			}
			else
			{
				// get feature file lst path
				$features = array();
				foreach($featureIdList as $featureId)
				{
					$Feature = Features::model()->findByPk($featureId);
					$features[] = array(
						"filelst" => $Feature->filelstpath,
						"pos" => $Feature->pos,
					);
				}
				// whether to add a default feature list
				if($addDefault != 0)
				{
					// get feature with labelId = -1
					$DefaultFeatures = Features::model()->findAll("labelId=-1 AND type='gunshot'");
					foreach($DefaultFeatures as $Feature)
					{
						$features[] = array(
							"filelst" => $Feature->filelstpath,
							"pos" => $Feature->pos,
						);
					}
				}
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 9;
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
					$callback = PP::cb("modelTrain");
					
					try
					{
						PP::ppython_asyn("run::modelTrain",$Process->id,$callback,$modelName,$features,$modelType,$userId);
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
	public function actionAddFeature()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$featureName = $request->getPost("featureName","");
		$filelstpath = $request->getPost("filelstpath","");
		$pos = $request->getPost("pos",-2);
		if(
			($featureName != "") &&
			($filelstpath != "") &&
			($pos != -2)
		)
		{
			$result = array(
				"status" => 0,
			);
			$Feature = new Features();
			$Feature->featureName = $featureName;
			$Feature->filelstpath = $filelstpath;
			$Feature->pos = $pos;
			$Feature->type = "gunshot";
			if(!$Feature->save())
			{
				$result['status'] = 1;
				$result['error'] = $Feature->getErrors();
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionGetFeatures()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		//get all labels if is Super
		$User = User::model()->findByPk($userId);
		$result = array(
			"status" => 0,
			"features" => array(),
		);
		$result['features'] = Text::sql("SELECT * FROM D_features WHERE type='gunshot' ORDER BY id desc");
		echo Text::json_encode_ch($result);
	}
	public function actionExtractFeature()
	{
		// extract feature for a label
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$labelId = $request->getPost("labelId",0);
		if($labelId != 0)
		{
			$result = array(
				"status" => 0,
			);
			$Label = Labels::model()->findByPk($labelId);
			if($Label!=null)
			{
				$Video = Videos::model()->findByPk($Label->videoId);
				$result['processStatus'] = 0;// sucessfully submit process job
				$Process = new Process();
				$Process->type = 8;
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
					$callback = PP::cb("gunshotFeatureExtraction");
					
					try
					{
						PP::ppython_asyn("run::gunshotFeatureExtraction",$Process->id,$callback,$Video->name,$Video->processPath,$Label->startSec,$Label->endSec,$Label->pos,$Label->id);
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
	//get all the labels
	public function actionGetLabels()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		//get all labels if is Super
		$User = User::model()->findByPk($userId);
		$result = array(
			"status" => 0,
			"labels" => array(),
		);
		if($User->isSuper == 1)
		{
			//get label and check whether is extracted
			$Labels = Text::sql("SELECT D_labels.*,D_labels.id AS labelId,D_videos.name AS videoname FROM D_labels,D_videos WHERE D_labels.isDeleted=0 AND D_labels.classname='gunshot' AND D_labels.videoId=D_videos.id ORDER BY D_labels.id DESC");
		}
		else
		{
			$Labels = Text::sql("SELECT D_labels.*,D_labels.id AS labelId,D_videos.name AS videoname FROM D_labels,D_videos WHERE D_labels.isDeleted=0 AND D_labels.classname='gunshot' AND D_labels.userId=:u AND D_labels.videoId=D_videos.id ORDER BY D_labels.id DESC",array(":u"=>$userId));
		}
		foreach($Labels as $Label)
		{
			//check this whether this label has feature extracted
			$Label['hasFeature'] = 0;
			$Feature = Features::model()->find("labelId=:l",array(":l"=>$Label['labelId']));
			if($Feature != null)
			{
				$Label['hasFeature'] = 1;
				$Label['featureId'] = $Feature->id;
			}
			$result['labels'][] = $Label;
		}
		echo Text::json_encode_ch($result);

	}
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',
			//后面是各个方法的filter
			//'isSuper',
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