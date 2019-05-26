<?php

/**
 * This is the model class for table "T_log".
 *
 * The followings are the available columns in table 'T_log':
 * @property integer $id
 * @property integer $type
 * @property integer $userId
 * @property string $param
 * @property string $time
 * @property integer $actionId
 * @property integer $projectId
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
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
		return 'T_log';
	}
	public static function addLog($data)
	{
		if(isset($data['type']) && isset($data['userId']) && isset($data['actionId']))
		{
			if(!isset($data['param']))
			{
				$data['param'] = array();
			}
			$Log = new Log();
			$Log->userId = $data['userId'];
			$Log->type = $data['type'];
			$Log->param = Text::json_encode_ch($data['param']);
			//有projectId或者此日志的TYPE就是projectId就添加此日志的projectId属性，没有就NULL
			if(isset($data['param']['projectId']) || in_array($data['type'],Log::$projectType))
			{
				$projectId = isset($data['param']['projectId'])?$data['param']['projectId']:$data['actionId'];
				$Log->projectId=$projectId;
			}
			else
			{
				$Log->projectId = NULL;
			}
			$Log->time = new CDbExpression("NOW()");
			$Log->actionId = $data['actionId'];
			if(!$Log->save())
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
	public static $projectType = array(
		PROJECT_ADD,
		PROJECT_LOCK,
		PROJECT_UNLOCK,
		PROJECT_DELETE,
		PROJECT_UNDELETE,
		PROJECT_NAME,
		PROJECT_INTRO,
	);
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, userId, time, actionId', 'required'),
			array('type, userId, actionId, projectId', 'numerical', 'integerOnly'=>true),
			array('param', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, userId, param, time, actionId, projectId', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'param' => 'Param',
			'time' => 'Time',
			'actionId' => 'Action',
			'projectId' => 'Project',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('actionId',$this->actionId);
		$criteria->compare('projectId',$this->projectId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}