<?php

/**
 * This is the model class for table "T_userStructure".
 *
 * The followings are the available columns in table 'T_userStructure':
 * @property integer $parentUserId
 * @property integer $childUserId
 */
class UserStructure extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserStructure the static model class
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
		return 'T_userStructure';
	}
	public static function isChildUser($userId)//检查$userId是否sessoin['userId']的直系或者非直系子用户 
	{
		//获取当前用户包含的子用户集合(去除第一个值，自己)
		$userIdArr = self::getUMAllChildId(Yii::app()->session['userId']);
		array_shift($userIdArr);
		if(in_array($userId,$userIdArr))
		{
			return true;
		}else
		{
			return false;
		}
	}
	public static function getUMAllChildId($userId)//返回userId的所有子用户
	{
		$data = self::getChildUser($userId);
		//return $data;
		$userArr = self::parseUserStruct($data);//包括自己的id
		return $userArr;
	}
	public static function parseUserStruct($data)
	{
		//把data中的userId全部获取出来 
		//深度优先获取
		static $userAr = array();
		/*$userAr[] = $data['userId'];
		foreach($data['children'] as $one)
		{
			self::parseUserStruct($one);
		}*/
		//第一层广度优先, 只要保证我自己生成的子管理员在前面即可
		$userAr[] = $data['userId'];
		foreach($data['children'] as $one)
		{
			$userAr[] = $one['userId'];
		}
		foreach($data['children'] as $one)
		{
			foreach($one['children'] as $oneNew)
			{
				self::parseUserStruct($oneNew);
			}
		}
		return $userAr;
	}
	public static function getChildUser($userId)//获取该id下的所有userid/
	{
		/*
			array(
				"userId" =>n,
				"children" => array(
					array(
						"userId"=>k,
						"children" =>array(..)
					),
					array(..),
					..
				)
			)
		*/
		$data = array();
		$data['userId'] = $userId;
		$data['children'] = array();
		$db = Yii::app()->db;
		$sqlcmd = "SELECT * FROM T_userStructure WHERE parentUserId=:parentUserId";
		$command = $db->createCommand($sqlcmd);
		$command->bindParam(":parentUserId",$userId);
		$res = $command->queryAll();
		foreach($res as $oneChild)
		{
			$data['children'][] = UserStructure::getChildUser($oneChild['childUserId']);
		}
		return $data;
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentUserId, childUserId', 'required'),
			array('parentUserId, childUserId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('parentUserId, childUserId', 'safe', 'on'=>'search'),
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
			'parentUserId' => 'Parent User',
			'childUserId' => 'Child User',
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

		$criteria->compare('parentUserId',$this->parentUserId);
		$criteria->compare('childUserId',$this->childUserId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}