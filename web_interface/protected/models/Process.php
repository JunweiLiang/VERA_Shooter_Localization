<?php

/**
 * This is the model class for table "D_process".
 *
 * The followings are the available columns in table 'D_process':
 * @property integer $id
 * @property double $progress
 * @property integer $done
 * @property string $message
 * @property string $createTime
 * @property string $changeTime
 * @property integer $type
 * @property integer $userId
 * @property integer $metaId
 */
class Process extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Process the static model class
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
		return 'D_process';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createTime, changeTime, type, userId', 'required'),
			array('done, type, userId, metaId', 'numerical', 'integerOnly'=>true),
			array('progress', 'numerical'),
			array('message', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, progress, done, message, createTime, changeTime, type, userId, metaId', 'safe', 'on'=>'search'),
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
			'progress' => 'Progress',
			'done' => 'Done',
			'message' => 'Message',
			'createTime' => 'Create Time',
			'changeTime' => 'Change Time',
			'type' => 'Type',
			'userId' => 'User',
			'metaId' => 'Meta',
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
		$criteria->compare('progress',$this->progress);
		$criteria->compare('done',$this->done);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('changeTime',$this->changeTime,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('metaId',$this->metaId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}