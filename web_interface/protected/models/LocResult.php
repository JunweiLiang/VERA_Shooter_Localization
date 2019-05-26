<?php

/**
 * This is the model class for table "D_locResult".
 *
 * The followings are the available columns in table 'D_locResult':
 * @property integer $id
 * @property integer $datasetId
 * @property integer $dvId
 * @property integer $loc2datasetId
 * @property double $lat
 * @property double $longitude
 * @property double $angle
 * @property string $tag
 */
class LocResult extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LocResult the static model class
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
		return 'D_locResult';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('datasetId, dvId, loc2datasetId, lat, longitude, angle, tag', 'required'),
			array('datasetId, dvId, loc2datasetId', 'numerical', 'integerOnly'=>true),
			array('lat, longitude, angle', 'numerical'),
			array('tag', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, datasetId, dvId, loc2datasetId, lat, longitude, angle, tag', 'safe', 'on'=>'search'),
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
			'dvId' => 'Dv',
			'loc2datasetId' => 'Loc2dataset',
			'lat' => 'Lat',
			'longitude' => 'Longitude',
			'angle' => 'Angle',
			'tag' => 'Tag',
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
		$criteria->compare('dvId',$this->dvId);
		$criteria->compare('loc2datasetId',$this->loc2datasetId);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('angle',$this->angle);
		$criteria->compare('tag',$this->tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}