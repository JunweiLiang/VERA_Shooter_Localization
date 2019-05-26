<?php

/**
 * This is the model class for table "D_dataset_video".
 *
 * The followings are the available columns in table 'D_dataset_video':
 * @property integer $id
 * @property integer $videoId
 * @property integer $datasetId
 * @property double $rankScore
 * @property string $thumbnailPath
 * @property string $signAudioPath
 * @property string $changeTime
 * @property string $createTime
 * @property double $rankScoreManual
 */
class DatasetVideo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DatasetVideo the static model class
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
		return 'D_dataset_video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, datasetId, changeTime, createTime', 'required'),
			array('videoId, datasetId', 'numerical', 'integerOnly'=>true),
			array('rankScore, rankScoreManual', 'numerical'),
			array('thumbnailPath, signAudioPath', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, datasetId, rankScore, thumbnailPath, signAudioPath, changeTime, createTime, rankScoreManual', 'safe', 'on'=>'search'),
		);
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
			'videoId' => 'Video',
			'datasetId' => 'Dataset',
			'rankScore' => 'Rank Score',
			'thumbnailPath' => 'Thumbnail Path',
			'signAudioPath' => 'Sign Audio Path',
			'changeTime' => 'Change Time',
			'createTime' => 'Create Time',
			'rankScoreManual' => 'Rank Score Manual',
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
		$criteria->compare('videoId',$this->videoId);
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('rankScore',$this->rankScore);
		$criteria->compare('thumbnailPath',$this->thumbnailPath,true);
		$criteria->compare('signAudioPath',$this->signAudioPath,true);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('rankScoreManual',$this->rankScoreManual);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}