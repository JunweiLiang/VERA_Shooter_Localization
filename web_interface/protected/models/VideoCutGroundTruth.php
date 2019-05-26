<?php

/**
 * This is the model class for table "D_videoCutGroundTruth".
 *
 * The followings are the available columns in table 'D_videoCutGroundTruth':
 * @property integer $id
 * @property integer $videoId
 * @property integer $userId
 * @property string $changeTime
 * @property integer $fromExpId
 * @property string $cutPoints
 */
class VideoCutGroundTruth extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VideoCutGroundTruth the static model class
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
		return 'D_videoCutGroundTruth';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, userId, changeTime, fromExpId, cutPoints', 'required'),
			array('videoId, userId, fromExpId', 'numerical', 'integerOnly'=>true),
			array('cutPoints', 'length', 'max'=>8192),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, userId, changeTime, fromExpId, cutPoints', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'changeTime' => 'Change Time',
			'fromExpId' => 'From Exp',
			'cutPoints' => 'Cut Points',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('fromExpId',$this->fromExpId);
		$criteria->compare('cutPoints',$this->cutPoints,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}