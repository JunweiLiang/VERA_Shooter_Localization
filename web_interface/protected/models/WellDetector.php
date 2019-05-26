<?php

/**
 * This is the model class for table "D_wellDetectors".
 *
 * The followings are the available columns in table 'D_wellDetectors':
 * @property integer $id
 * @property string $name
 * @property integer $processId
 * @property string $createTime
 * @property string $finishTime
 * @property string $signature
 * @property string $bucket
 * @property string $modelPath
 * @property integer $userId
 * @property integer $videoNum
 * @property string $note
 * @property integer $isDeleted
 */
class WellDetector extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WellDetector the static model class
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
		return 'D_wellDetectors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, processId, createTime, signature, bucket, userId', 'required'),
			array('processId, userId, videoNum, isDeleted', 'numerical', 'integerOnly'=>true),
			array('name, modelPath, note', 'length', 'max'=>256),
			array('signature', 'length', 'max'=>128),
			array('finishTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, processId, createTime, finishTime, signature, bucket, modelPath, userId, videoNum, note, isDeleted', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'processId' => 'Process',
			'createTime' => 'Create Time',
			'finishTime' => 'Finish Time',
			'signature' => 'Signature',
			'bucket' => 'Bucket',
			'modelPath' => 'Model Path',
			'userId' => 'User',
			'videoNum' => 'Video Num',
			'note' => 'Note',
			'isDeleted' => 'Is Deleted',
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
		$criteria->compare('processId',$this->processId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('finishTime',$this->finishTime,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('bucket',$this->bucket,true);
		$criteria->compare('modelPath',$this->modelPath,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('videoNum',$this->videoNum);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}