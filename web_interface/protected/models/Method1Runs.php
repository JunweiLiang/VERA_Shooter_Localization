<?php

/**
 * This is the model class for table "L_method1_runs".
 *
 * The followings are the available columns in table 'L_method1_runs':
 * @property integer $id
 * @property integer $processId
 * @property integer $datasetId
 * @property integer $markerId
 * @property double $time_diff
 * @property double $angleMin
 * @property double $angleMax
 * @property double $elevation
 * @property integer $userId
 * @property integer $isDeleted
 * @property double $min_dist
 * @property double $max_dist
 * @property double $mean_dist
 * @property double $soundSpeedMax
 * @property double $soundSpeedMin
 * @property double $bulletSpeedMax
 * @property double $bulletSpeedMin
 */
class Method1Runs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Method1Runs the static model class
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
		return 'L_method1_runs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('processId, datasetId, markerId, time_diff, angleMin, angleMax, elevation, userId, soundSpeedMax, soundSpeedMin, bulletSpeedMax, bulletSpeedMin', 'required'),
			array('processId, datasetId, markerId, userId, isDeleted', 'numerical', 'integerOnly'=>true),
			array('time_diff, angleMin, angleMax, elevation, min_dist, max_dist, mean_dist, soundSpeedMax, soundSpeedMin, bulletSpeedMax, bulletSpeedMin', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, processId, datasetId, markerId, time_diff, angleMin, angleMax, elevation, userId, isDeleted, min_dist, max_dist, mean_dist, soundSpeedMax, soundSpeedMin, bulletSpeedMax, bulletSpeedMin', 'safe', 'on'=>'search'),
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
			'processId' => 'Process',
			'datasetId' => 'Dataset',
			'markerId' => 'Marker',
			'time_diff' => 'Time Diff',
			'angleMin' => 'Angle Min',
			'angleMax' => 'Angle Max',
			'elevation' => 'Elevation',
			'userId' => 'User',
			'isDeleted' => 'Is Deleted',
			'min_dist' => 'Min Dist',
			'max_dist' => 'Max Dist',
			'mean_dist' => 'Mean Dist',
			'soundSpeedMax' => 'Sound Speed Max',
			'soundSpeedMin' => 'Sound Speed Min',
			'bulletSpeedMax' => 'Bullet Speed Max',
			'bulletSpeedMin' => 'Bullet Speed Min',
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
		$criteria->compare('processId',$this->processId);
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('markerId',$this->markerId);
		$criteria->compare('time_diff',$this->time_diff);
		$criteria->compare('angleMin',$this->angleMin);
		$criteria->compare('angleMax',$this->angleMax);
		$criteria->compare('elevation',$this->elevation);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('min_dist',$this->min_dist);
		$criteria->compare('max_dist',$this->max_dist);
		$criteria->compare('mean_dist',$this->mean_dist);
		$criteria->compare('soundSpeedMax',$this->soundSpeedMax);
		$criteria->compare('soundSpeedMin',$this->soundSpeedMin);
		$criteria->compare('bulletSpeedMax',$this->bulletSpeedMax);
		$criteria->compare('bulletSpeedMin',$this->bulletSpeedMin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}