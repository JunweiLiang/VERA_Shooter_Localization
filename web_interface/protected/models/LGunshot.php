<?php

/**
 * This is the model class for table "L_gunshot".
 *
 * The followings are the available columns in table 'L_gunshot':
 * @property integer $id
 * @property integer $datasetId
 * @property string $gunName
 * @property double $bulletSpeedMin
 * @property string $note
 * @property integer $userId
 * @property string $createTime
 * @property double $bulletSpeedMax
 * @property integer $isDeleted
 */
class LGunshot extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LGunshot the static model class
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
		return 'L_gunshot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('datasetId, gunName, bulletSpeedMin, userId, createTime, bulletSpeedMax', 'required'),
			array('datasetId, userId, isDeleted', 'numerical', 'integerOnly'=>true),
			array('bulletSpeedMin, bulletSpeedMax', 'numerical'),
			array('gunName', 'length', 'max'=>128),
			array('note', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, datasetId, gunName, bulletSpeedMin, note, userId, createTime, bulletSpeedMax, isDeleted', 'safe', 'on'=>'search'),
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
			'datasetId' => 'Dataset',
			'gunName' => 'Gun Name',
			'bulletSpeedMin' => 'Bullet Speed Min',
			'note' => 'Note',
			'userId' => 'User',
			'createTime' => 'Create Time',
			'bulletSpeedMax' => 'Bullet Speed Max',
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
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('gunName',$this->gunName,true);
		$criteria->compare('bulletSpeedMin',$this->bulletSpeedMin);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('bulletSpeedMax',$this->bulletSpeedMax);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}