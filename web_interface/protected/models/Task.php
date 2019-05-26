<?php

/**
 * This is the model class for table "T_task".
 *
 * The followings are the available columns in table 'T_task':
 * @property integer $id
 * @property integer $projectId
 * @property string $name
 * @property string $intro
 * @property string $time
 * @property integer $deleted
 * @property integer $rank
 * @property string $startTime
 * @property string $endTime
 */
class Task extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Task the static model class
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
		return 'T_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectId, name, time, rank', 'required'),
			array('projectId, deleted, rank', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>256),
			array('intro', 'length', 'max'=>512),
			array('startTime, endTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, projectId, name, intro, time, deleted, rank, startTime, endTime', 'safe', 'on'=>'search'),
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
			'projectId' => 'Project',
			'name' => 'Name',
			'intro' => 'Intro',
			'time' => 'Time',
			'deleted' => 'Deleted',
			'rank' => 'Rank',
			'startTime' => 'Start Time',
			'endTime' => 'End Time',
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
		$criteria->compare('projectId',$this->projectId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('startTime',$this->startTime,true);
		$criteria->compare('endTime',$this->endTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}