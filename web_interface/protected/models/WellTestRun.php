<?php

/**
 * This is the model class for table "D_wellTestRuns".
 *
 * The followings are the available columns in table 'D_wellTestRuns':
 * @property integer $id
 * @property string $runName
 * @property string $createTime
 * @property integer $userId
 * @property integer $forTrainDetectorId
 * @property string $signature
 * @property string $bucket
 */
class WellTestRun extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WellTestRun the static model class
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
		return 'D_wellTestRuns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('runName, createTime, userId', 'required'),
			array('userId, forTrainDetectorId', 'numerical', 'integerOnly'=>true),
			array('runName, signature', 'length', 'max'=>256),
			array('bucket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, runName, createTime, userId, forTrainDetectorId, signature, bucket', 'safe', 'on'=>'search'),
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
			'runName' => 'Run Name',
			'createTime' => 'Create Time',
			'userId' => 'User',
			'forTrainDetectorId' => 'For Train Detector',
			'signature' => 'Signature',
			'bucket' => 'Bucket',
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
		$criteria->compare('runName',$this->runName,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('forTrainDetectorId',$this->forTrainDetectorId);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('bucket',$this->bucket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}