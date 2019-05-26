<?php

/**
 * This is the model class for table "D_wellVideoTestScore".
 *
 * The followings are the available columns in table 'D_wellVideoTestScore':
 * @property integer $id
 * @property integer $videoId
 * @property integer $detectorId
 * @property double $score
 * @property string $createTime
 * @property integer $label
 */
class WellVideoTestScore extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WellVideoTestScore the static model class
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
		return 'D_wellVideoTestScore';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, detectorId, score, createTime', 'required'),
			array('videoId, detectorId, label', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, detectorId, score, createTime, label', 'safe', 'on'=>'search'),
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
			'detectorId' => 'Detector',
			'score' => 'Score',
			'createTime' => 'Create Time',
			'label' => 'Label',
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
		$criteria->compare('detectorId',$this->detectorId);
		$criteria->compare('score',$this->score);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('label',$this->label);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}