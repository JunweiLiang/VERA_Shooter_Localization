<?php

/**
 * This is the model class for table "D_gunshot_classification".
 *
 * The followings are the available columns in table 'D_gunshot_classification':
 * @property integer $id
 * @property integer $videoId
 * @property string $createTime
 * @property integer $start
 * @property integer $end
 * @property integer $hasResult
 * @property integer $isDeleted
 * @property string $result
 */
class GunshotClassification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GunshotClassification the static model class
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
		return 'D_gunshot_classification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoId, createTime, start, end', 'required'),
			array('videoId, start, end, hasResult, isDeleted', 'numerical', 'integerOnly'=>true),
			array('result', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoId, createTime, start, end, hasResult, isDeleted, result', 'safe', 'on'=>'search'),
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
			'createTime' => 'Create Time',
			'start' => 'Start',
			'end' => 'End',
			'hasResult' => 'Has Result',
			'isDeleted' => 'Is Deleted',
			'result' => 'Result',
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
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('start',$this->start);
		$criteria->compare('end',$this->end);
		$criteria->compare('hasResult',$this->hasResult);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('result',$this->result,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}