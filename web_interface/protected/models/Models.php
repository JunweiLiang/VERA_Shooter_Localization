<?php

/**
 * This is the model class for table "D_models".
 *
 * The followings are the available columns in table 'D_models':
 * @property integer $id
 * @property string $modelname
 * @property integer $isDeleted
 * @property integer $userId
 * @property string $modelpath
 * @property integer $isDone
 * @property string $type
 * @property integer $isDefault
 */
class Models extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Models the static model class
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
		return 'D_models';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('modelname, userId, type', 'required'),
			array('isDeleted, userId, isDone, isDefault', 'numerical', 'integerOnly'=>true),
			array('modelname', 'length', 'max'=>256),
			array('modelpath', 'length', 'max'=>512),
			array('type', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, modelname, isDeleted, userId, modelpath, isDone, type, isDefault', 'safe', 'on'=>'search'),
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
			'modelname' => 'Modelname',
			'isDeleted' => 'Is Deleted',
			'userId' => 'User',
			'modelpath' => 'Modelpath',
			'isDone' => 'Is Done',
			'type' => 'Type',
			'isDefault' => 'Is Default',
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
		$criteria->compare('modelname',$this->modelname,true);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('modelpath',$this->modelpath,true);
		$criteria->compare('isDone',$this->isDone);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('isDefault',$this->isDefault);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}