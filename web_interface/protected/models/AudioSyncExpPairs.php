<?php

/**
 * This is the model class for table "D_audioSyncExpPairs".
 *
 * The followings are the available columns in table 'D_audioSyncExpPairs':
 * @property integer $id
 * @property integer $expId
 * @property integer $videoId1
 * @property integer $videoId2
 * @property double $offset
 * @property double $evidenceStart
 * @property double $evidenceLast
 * @property string $score
 * @property integer $rank
 * @property integer $mark
 * @property string $createTime
 * @property string $changeTime
 * @property double $originalOffset
 */
class AudioSyncExpPairs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AudioSyncExpPairs the static model class
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
		return 'D_audioSyncExpPairs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('expId, videoId1, videoId2, offset, evidenceStart, evidenceLast, score, rank, createTime, changeTime', 'required'),
			array('expId, videoId1, videoId2, rank, mark', 'numerical', 'integerOnly'=>true),
			array('offset, evidenceStart, evidenceLast, originalOffset', 'numerical'),
			array('score', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, expId, videoId1, videoId2, offset, evidenceStart, evidenceLast, score, rank, mark, createTime, changeTime, originalOffset', 'safe', 'on'=>'search'),
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
			'videoId1' => 'Video Id1',
			'videoId2' => 'Video Id2',
			'offset' => 'Offset',
			'evidenceStart' => 'Evidence Start',
			'evidenceLast' => 'Evidence Last',
			'score' => 'Score',
			'rank' => 'Rank',
			'mark' => 'Mark',
			'createTime' => 'Create Time',
			'changeTime' => 'Change Time',
			'originalOffset' => 'Original Offset',
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
		$criteria->compare('videoId1',$this->videoId1);
		$criteria->compare('videoId2',$this->videoId2);
		$criteria->compare('offset',$this->offset);
		$criteria->compare('evidenceStart',$this->evidenceStart);
		$criteria->compare('evidenceLast',$this->evidenceLast);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('mark',$this->mark);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('originalOffset',$this->originalOffset);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}