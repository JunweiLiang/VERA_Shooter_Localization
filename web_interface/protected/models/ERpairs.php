<?php

/**
 * This is the model class for table "D_er_pairs".
 *
 * The followings are the available columns in table 'D_er_pairs':
 * @property integer $id
 * @property integer $srcId
 * @property integer $isSegment1
 * @property integer $desId
 * @property integer $isSegment2
 * @property double $offset
 * @property double $confidence
 * @property integer $auto
 * @property integer $userId
 * @property string $changeTime
 * @property string $createTime
 * @property integer $datasetId
 * @property double $autoOffset
 * @property integer $mark
 */
class ERpairs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ERpairs the static model class
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
		return 'D_er_pairs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('srcId, desId, offset, confidence, changeTime, createTime, datasetId', 'required'),
			array('srcId, isSegment1, desId, isSegment2, auto, userId, datasetId, mark', 'numerical', 'integerOnly'=>true),
			array('offset, confidence, autoOffset', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, srcId, isSegment1, desId, isSegment2, offset, confidence, auto, userId, changeTime, createTime, datasetId, autoOffset, mark', 'safe', 'on'=>'search'),
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
			'srcId' => 'Src',
			'isSegment1' => 'Is Segment1',
			'desId' => 'Des',
			'isSegment2' => 'Is Segment2',
			'offset' => 'Offset',
			'confidence' => 'Confidence',
			'auto' => 'Auto',
			'userId' => 'User',
			'changeTime' => 'Change Time',
			'createTime' => 'Create Time',
			'datasetId' => 'Dataset',
			'autoOffset' => 'Auto Offset',
			'mark' => 'Mark',
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
		$criteria->compare('srcId',$this->srcId);
		$criteria->compare('isSegment1',$this->isSegment1);
		$criteria->compare('desId',$this->desId);
		$criteria->compare('isSegment2',$this->isSegment2);
		$criteria->compare('offset',$this->offset);
		$criteria->compare('confidence',$this->confidence);
		$criteria->compare('auto',$this->auto);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('autoOffset',$this->autoOffset);
		$criteria->compare('mark',$this->mark);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}