<?php

/**
 * This is the model class for table "D_features".
 *
 * The followings are the available columns in table 'D_features':
 * @property integer $id
 * @property string $filelstpath
 * @property string $featureName
 * @property integer $labelId
 * @property string $type
 * @property integer $pos
 */
class Features extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Features the static model class
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
		return 'D_features';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filelstpath, featureName, type, pos', 'required'),
			array('labelId, pos', 'numerical', 'integerOnly'=>true),
			array('filelstpath', 'length', 'max'=>512),
			array('featureName', 'length', 'max'=>128),
			array('type', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, filelstpath, featureName, labelId, type, pos', 'safe', 'on'=>'search'),
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
			'filelstpath' => 'Filelstpath',
			'featureName' => 'Feature Name',
			'labelId' => 'Label',
			'type' => 'Type',
			'pos' => 'Pos',
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
		$criteria->compare('filelstpath',$this->filelstpath,true);
		$criteria->compare('featureName',$this->featureName,true);
		$criteria->compare('labelId',$this->labelId);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}