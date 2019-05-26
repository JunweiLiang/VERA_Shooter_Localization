<?php

/**
 * This is the model class for table "D_er_global_results".
 *
 * The followings are the available columns in table 'D_er_global_results':
 * @property integer $id
 * @property integer $clusterId
 * @property integer $datasetId
 * @property integer $dvId
 * @property double $offset
 * @property double $duration
 */
class ERresults extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ERresults the static model class
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
		return 'D_er_global_results';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clusterId, datasetId, dvId, offset, duration', 'required'),
			array('clusterId, datasetId, dvId', 'numerical', 'integerOnly'=>true),
			array('offset, duration', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clusterId, datasetId, dvId, offset, duration', 'safe', 'on'=>'search'),
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
			'clusterId' => 'Cluster',
			'datasetId' => 'Dataset',
			'dvId' => 'Dv',
			'offset' => 'Offset',
			'duration' => 'Duration',
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
		$criteria->compare('clusterId',$this->clusterId);
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('dvId',$this->dvId);
		$criteria->compare('offset',$this->offset);
		$criteria->compare('duration',$this->duration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}