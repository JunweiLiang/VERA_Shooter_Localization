<?php

/**
 * This is the model class for table "T_remind".
 *
 * The followings are the available columns in table 'T_remind':
 * @property integer $id
 * @property integer $type
 * @property integer $toUserId
 * @property integer $isRead
 * @property string $param
 * @property string $time
 * @property integer $isRevoked
 */
class Remind extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Remind the static model class
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
		return 'T_remind';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, toUserId, time', 'required'),
			array('type, toUserId, isRead, isRevoked', 'numerical', 'integerOnly'=>true),
			array('param', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, toUserId, isRead, param, time, isRevoked', 'safe', 'on'=>'search'),
		);
	}
	public static function addRemind($data)
	{
		if(isset($data['type']) && isset($data['toUserId']))
		{
			if(!isset($data['param']))
			{
				$data['param'] = array();
			}
			$Remind = new Remind();
			$Remind->toUserId = $data['toUserId'];
			$Remind->type = $data['type'];
			$Remind->param = Text::json_encode_ch($data['param']);
			$Remind->time = new CDbExpression("NOW()");
			if(!$Remind->save())
			{
				throw new Exception("save error");
				return false;
			}
		}
		else
		{
			throw new Exception("data error");
			return false;
		}
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
			'toUserId' => 'To User',
			'isRead' => 'Is Read',
			'param' => 'Param',
			'time' => 'Time',
			'isRevoked' => 'Is Revoked',
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
		$criteria->compare('toUserId',$this->toUserId);
		$criteria->compare('isRead',$this->isRead);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('isRevoked',$this->isRevoked);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}