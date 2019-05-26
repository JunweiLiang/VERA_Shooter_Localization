<?php

/**
 * This is the model class for table "D_gunshot_results".
 *
 * The followings are the available columns in table 'D_gunshot_results':
 * @property integer $id
 * @property integer $runId
 * @property double $startSec
 * @property double $endSec
 * @property double $score
 * @property string $type
 */
class GunshotResults extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GunshotResults the static model class
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
		return 'D_gunshot_results';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('runId, startSec, endSec, score', 'required'),
			array('runId', 'numerical', 'integerOnly'=>true),
			array('startSec, endSec, score', 'numerical'),
			array('type', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, runId, startSec, endSec, score, type', 'safe', 'on'=>'search'),
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
			'runId' => 'Run',
			'startSec' => 'Start Sec',
			'endSec' => 'End Sec',
			'score' => 'Score',
			'type' => 'Type',
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
		$criteria->compare('runId',$this->runId);
		$criteria->compare('startSec',$this->startSec);
		$criteria->compare('endSec',$this->endSec);
		$criteria->compare('score',$this->score);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}