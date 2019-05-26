<?php

/**
 * This is the model class for table "T_urlQueue".
 *
 * The followings are the available columns in table 'T_urlQueue':
 * @property integer $urlId
 * @property string $url
 * @property integer $status
 * @property string $createTime
 * @property string $note
 */
class UrlQueue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UrlQueue the static model class
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
		return 'T_urlQueue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createTime', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('url, note', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('urlId, url, status, createTime, note', 'safe', 'on'=>'search'),
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
			'urlId' => 'Url',
			'url' => 'Url',
			'status' => 'Status',
			'createTime' => 'Create Time',
			'note' => 'Note',
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

		$criteria->compare('urlId',$this->urlId);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}