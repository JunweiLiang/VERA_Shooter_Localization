<?php

/**
 * This is the model class for table "D_gunshotExpLabels".
 *
 * The followings are the available columns in table 'D_gunshotExpLabels':
 * @property integer $id
 * @property integer $expId
 * @property integer $listsId
 * @property integer $videoId
 * @property double $startSec
 * @property double $endSec
 * @property integer $pos
 * @property integer $isDeleted
 * @property integer $autoGunshotCount
 * @property integer $gunshotCountReal
 */
class GunshotExpLabels extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GunshotExpLabels the static model class
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
		return 'D_gunshotExpLabels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('expId, listsId, videoId, startSec, endSec, pos', 'required'),
			array('expId, listsId, videoId, pos, isDeleted, autoGunshotCount, gunshotCountReal', 'numerical', 'integerOnly'=>true),
			array('startSec, endSec', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, expId, listsId, videoId, startSec, endSec, pos, isDeleted, autoGunshotCount, gunshotCountReal', 'safe', 'on'=>'search'),
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
			'listsId' => 'Lists',
			'videoId' => 'Video',
			'startSec' => 'Start Sec',
			'endSec' => 'End Sec',
			'pos' => 'Pos',
			'isDeleted' => 'Is Deleted',
			'autoGunshotCount' => 'Auto Gunshot Count',
			'gunshotCountReal' => 'Gunshot Count Real',
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
		$criteria->compare('listsId',$this->listsId);
		$criteria->compare('videoId',$this->videoId);
		$criteria->compare('startSec',$this->startSec);
		$criteria->compare('endSec',$this->endSec);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('autoGunshotCount',$this->autoGunshotCount);
		$criteria->compare('gunshotCountReal',$this->gunshotCountReal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}