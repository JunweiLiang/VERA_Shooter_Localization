<?php

/**
 * This is the model class for table "D_videos".
 *
 * The followings are the available columns in table 'D_videos':
 * @property integer $id
 * @property string $name
 * @property string $relatedPath
 * @property string $processPath
 * @property string $changeTime
 * @property string $createTime
 * @property integer $userId
 * @property integer $hasImgs
 * @property integer $imgCount
 * @property string $metaPath
 * @property double $duration
 * @property integer $num_frame
 * @property double $fps
 */
class Videos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Videos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'D_videos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, changeTime, createTime, userId', 'required'),
			array('userId, hasImgs, imgCount, num_frame', 'numerical', 'integerOnly'=>true),
			array('duration, fps', 'numerical'),
			array('name, relatedPath', 'length', 'max'=>255),
			array('processPath', 'length', 'max'=>512),
			array('metaPath', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, relatedPath, processPath, changeTime, createTime, userId, hasImgs, imgCount, metaPath, duration, num_frame, fps', 'safe', 'on'=>'search'),
		);
	}
	public static function getDuration($path)
	{
		$output = shell_exec("ffmpeg -i '".$path."' 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
		if($output == "")
		{
			$output = shell_exec("/home/chunwaileong/lib/ffmpeg -i '".$path."' 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
		}
		list($hour,$min,$sec) = explode(":",$output);
		$duration = (double)$sec+ (double)$min*60.0+(double)$hour*60.0*60.0;
		return $duration;
	}
	public static function getInfoUsingDvId($dvId)
    {
            $cmd = "SELECT D_videos.*,D_videos.name AS videoname,D_videos.id AS videoId,D_dataset_video.id AS dvId,D_dataset.name AS datasetName,D_dataset.id AS datasetId FROM D_videos,D_dataset_video,D_dataset ".
                    " WHERE D_dataset_video.id=:dv AND D_dataset_video.videoId=D_videos.id AND D_dataset_video.datasetId=D_dataset.id";
            return Text::sql($cmd,array(":dv"=>$dvId))[0];
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'relatedPath' => 'Related Path',
			'processPath' => 'Process Path',
			'changeTime' => 'Change Time',
			'createTime' => 'Create Time',
			'userId' => 'User',
			'hasImgs' => 'Has Imgs',
			'imgCount' => 'Img Count',
			'metaPath' => 'Meta Path',
			'duration' => 'Duration',
			'num_frame' => 'Num Frame',
			'fps' => 'Fps',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('relatedPath',$this->relatedPath,true);
		$criteria->compare('processPath',$this->processPath,true);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('hasImgs',$this->hasImgs);
		$criteria->compare('imgCount',$this->imgCount);
		$criteria->compare('metaPath',$this->metaPath,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('num_frame',$this->num_frame);
		$criteria->compare('fps',$this->fps);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}