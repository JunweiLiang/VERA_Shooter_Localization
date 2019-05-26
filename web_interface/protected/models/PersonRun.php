<?php

/**
 * This is the model class for table "D_person_run".
 *
 * The followings are the available columns in table 'D_person_run':
 * @property integer $id
 * @property integer $videoId
 * @property string $runName
 * @property string $createTime
 * @property integer $isDeleted
 * @property integer $haveResult
 */
class PersonRun extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonRun the static model class
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
		return 'D_person_run';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, runName, createTime', 'required'),
			array('videoId, isDeleted, haveResult', 'numerical', 'integerOnly'=>true),
			array('runName', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, runName, createTime, isDeleted, haveResult', 'safe', 'on'=>'search'),
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
			'runName' => 'Run Name',
			'createTime' => 'Create Time',
			'isDeleted' => 'Is Deleted',
			'haveResult' => 'Have Result',
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
		$criteria->compare('runName',$this->runName,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('haveResult',$this->haveResult);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}