<?php

/**
 * This is the model class for table "D_labels".
 *
 * The followings are the available columns in table 'D_labels':
 * @property integer $id
 * @property integer $videoId
 * @property string $classname
 * @property integer $userId
 * @property double $startSec
 * @property double $endSec
 * @property integer $pos
 * @property integer $isDeleted
 */
class Labels extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Labels the static model class
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
		return 'D_labels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, classname, userId, startSec, endSec', 'required'),
			array('videoId, userId, pos, isDeleted', 'numerical', 'integerOnly'=>true),
			array('startSec, endSec', 'numerical'),
			array('classname', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, classname, userId, startSec, endSec, pos, isDeleted', 'safe', 'on'=>'search'),
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
			'classname' => 'Classname',
			'userId' => 'User',
			'startSec' => 'Start Sec',
			'endSec' => 'End Sec',
			'pos' => 'Pos',
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
		$criteria->compare('videoId',$this->videoId);
		$criteria->compare('classname',$this->classname,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('startSec',$this->startSec);
		$criteria->compare('endSec',$this->endSec);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}