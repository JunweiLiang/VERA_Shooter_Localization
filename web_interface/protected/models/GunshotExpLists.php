<?php

/**
 * This is the model class for table "D_gunshotExpLists".
 *
 * The followings are the available columns in table 'D_gunshotExpLists':
 * @property integer $id
 * @property integer $expId
 * @property string $createTime
 * @property integer $videoId
 * @property double $rankScore
 * @property string $segmentJson
 * @property integer $rank
 * @property string $gunshotCountJson
 */
class GunshotExpLists extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GunshotExpLists the static model class
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
		return 'D_gunshotExpLists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('expId, createTime, videoId, rankScore, segmentJson, rank, gunshotCountJson', 'required'),
			array('expId, videoId, rank', 'numerical', 'integerOnly'=>true),
			array('rankScore', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, expId, createTime, videoId, rankScore, segmentJson, rank, gunshotCountJson', 'safe', 'on'=>'search'),
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
			'expId' => 'Exp',
			'createTime' => 'Create Time',
			'videoId' => 'Video',
			'rankScore' => 'Rank Score',
			'segmentJson' => 'Segment Json',
			'rank' => 'Rank',
			'gunshotCountJson' => 'Gunshot Count Json',
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
		$criteria->compare('expId',$this->expId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('videoId',$this->videoId);
		$criteria->compare('rankScore',$this->rankScore);
		$criteria->compare('segmentJson',$this->segmentJson,true);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('gunshotCountJson',$this->gunshotCountJson,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}