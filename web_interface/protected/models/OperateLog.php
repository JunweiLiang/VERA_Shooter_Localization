<?php

/**
 * This is the model class for table "D_operateLog".
 *
 * The followings are the available columns in table 'D_operateLog':
 * @property integer $id
 * @property integer $type
 * @property string $createTime
 * @property integer $userId
 * @property string $param
 * @property integer $datasetId
 */
class OperateLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperateLog the static model class
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
		return 'D_operateLog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, createTime, userId', 'required'),
			array('type, userId, datasetId', 'numerical', 'integerOnly'=>true),
			array('param', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, createTime, userId, param, datasetId', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'createTime' => 'Create Time',
			'userId' => 'User',
			'param' => 'Param',
			'datasetId' => 'Dataset',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('datasetId',$this->datasetId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}