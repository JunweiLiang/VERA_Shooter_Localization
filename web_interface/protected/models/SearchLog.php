<?php

/**
 * This is the model class for table "T_searchLog".
 *
 * The followings are the available columns in table 'T_searchLog':
 * @property integer $logId
 * @property string $searchStr
 * @property string $searchUserAgent
 * @property string $searchRemoteAddr
 * @property string $searchTime
 */
class SearchLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SearchLog the static model class
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
		return 'T_searchLog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('searchTime', 'required'),
			array('searchStr, searchUserAgent', 'length', 'max'=>512),
			array('searchRemoteAddr', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('logId, searchStr, searchUserAgent, searchRemoteAddr, searchTime', 'safe', 'on'=>'search'),
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
			'logId' => 'Log',
			'searchStr' => 'Search Str',
			'searchUserAgent' => 'Search User Agent',
			'searchRemoteAddr' => 'Search Remote Addr',
			'searchTime' => 'Search Time',
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

		$criteria->compare('logId',$this->logId);
		$criteria->compare('searchStr',$this->searchStr,true);
		$criteria->compare('searchUserAgent',$this->searchUserAgent,true);
		$criteria->compare('searchRemoteAddr',$this->searchRemoteAddr,true);
		$criteria->compare('searchTime',$this->searchTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}