<?php

/**
 * This is the model class for table "L_gunshot_in_video".
 *
 * The followings are the available columns in table 'L_gunshot_in_video':
 * @property integer $id
 * @property integer $gunshotId
 * @property integer $videoId
 * @property integer $userId
 * @property string $createTime
 * @property double $muzzleBlastTime
 * @property double $shockwaveTime
 * @property integer $isDeleted
 * @property double $latitude
 * @property double $longitude
 * @property double $angleMin
 * @property double $angleMax
 * @property double $elevation
 */
class LGunshotInVideo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LGunshotInVideo the static model class
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
		return 'L_gunshot_in_video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gunshotId, videoId, userId, createTime, muzzleBlastTime', 'required'),
			array('gunshotId, videoId, userId, isDeleted', 'numerical', 'integerOnly'=>true),
			array('muzzleBlastTime, shockwaveTime, latitude, longitude, angleMin, angleMax, elevation', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gunshotId, videoId, userId, createTime, muzzleBlastTime, shockwaveTime, isDeleted, latitude, longitude, angleMin, angleMax, elevation', 'safe', 'on'=>'search'),
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
			'gunshotId' => 'Gunshot',
			'videoId' => 'Video',
			'userId' => 'User',
			'createTime' => 'Create Time',
			'muzzleBlastTime' => 'Muzzle Blast Time',
			'shockwaveTime' => 'Shockwave Time',
			'isDeleted' => 'Is Deleted',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'angleMin' => 'Angle Min',
			'angleMax' => 'Angle Max',
			'elevation' => 'Elevation',
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
		$criteria->compare('gunshotId',$this->gunshotId);
		$criteria->compare('videoId',$this->videoId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('muzzleBlastTime',$this->muzzleBlastTime);
		$criteria->compare('shockwaveTime',$this->shockwaveTime);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('angleMin',$this->angleMin);
		$criteria->compare('angleMax',$this->angleMax);
		$criteria->compare('elevation',$this->elevation);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}