<?php

/**
 * This is the model class for table "D_dataset".
 *
 * The followings are the available columns in table 'D_dataset':
 * @property integer $id
 * @property string $name
 * @property string $note
 * @property string $createTime
 * @property integer $userId
 * @property integer $isDeleted
 * @property integer $isImported
 * @property integer $hasMeta
 * @property integer $isSearch
 * @property string $searchContent
 * @property double $latitude
 * @property double $longitude
 * @property double $radius
 * @property double $soundSpeedMin
 * @property double $soundSpeedMax
 */
class Dataset extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dataset the static model class
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
		return 'D_dataset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, createTime, userId', 'required'),
			array('userId, isDeleted, isImported, hasMeta, isSearch', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude, radius, soundSpeedMin, soundSpeedMax', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('note, searchContent', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, note, createTime, userId, isDeleted, isImported, hasMeta, isSearch, searchContent, latitude, longitude, radius, soundSpeedMin, soundSpeedMax', 'safe', 'on'=>'search'),
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
			'note' => 'Note',
			'createTime' => 'Create Time',
			'userId' => 'User',
			'isDeleted' => 'Is Deleted',
			'isImported' => 'Is Imported',
			'hasMeta' => 'Has Meta',
			'isSearch' => 'Is Search',
			'searchContent' => 'Search Content',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'radius' => 'Radius',
			'soundSpeedMin' => 'Sound Speed Min',
			'soundSpeedMax' => 'Sound Speed Max',
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
		$criteria->compare('note',$this->note,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('isImported',$this->isImported);
		$criteria->compare('hasMeta',$this->hasMeta);
		$criteria->compare('isSearch',$this->isSearch);
		$criteria->compare('searchContent',$this->searchContent,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('radius',$this->radius);
		$criteria->compare('soundSpeedMin',$this->soundSpeedMin);
		$criteria->compare('soundSpeedMax',$this->soundSpeedMax);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}