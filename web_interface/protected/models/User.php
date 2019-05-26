<?php

/**
 * This is the model class for table "T_user".
 *
 * The followings are the available columns in table 'T_user':
 * @property integer $userId
 * @property string $userName
 * @property string $userPw
 * @property string $userRegTime
 * @property string $isUM
 * @property string $nickName
 * @property string $intro
 * @property integer $isSuper
 * @property integer $userLevel
 * @property string $email
 * @property integer $isVerified
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'T_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userName, userPw, userRegTime', 'required'),
			array('isSuper, userLevel, isVerified', 'numerical', 'integerOnly'=>true),
			array('userName, userPw', 'length', 'max'=>64),
			array('isUM', 'length', 'max'=>1),
			array('nickName, email', 'length', 'max'=>256),
			array('intro', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userId, userName, userPw, userRegTime, isUM, nickName, intro, isSuper, userLevel, email, isVerified', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'userName' => 'User Name',
			'userPw' => 'User Pw',
			'userRegTime' => 'User Reg Time',
			'isUM' => 'Is Um',
			'nickName' => 'Nick Name',
			'intro' => 'Intro',
			'isSuper' => 'Is Super',
			'userLevel' => 'User Level',
			'email' => 'Email',
			'isVerified' => 'Is Verified',
		);
	}
	
	public static function getUserRole($id)//成功找到就返回数组，去掉其余的字段，只留is*字段 
	{
		$User = User::model()->findByPk($id);
		if($User == null)
		{
			return false;
		}
		$temp = $User->attributes;
		unset($temp['userId']);
		unset($temp['userPw']);
		//unset($temp['userName']);
		unset($temp['userRegTime']);
	//	unset($temp['nickName']);
		unset($temp['intro']);
		//userlLevel 客户级别，2普通用户,3高级用户
		return $temp;
	}
	public static function isClient($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole === false) || ($UserRole['userLevel'] == 0))
		{
			return false;
		}
		return true;
	}
	public static function isCompetitor($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole === false) || ($UserRole['isCompetitor'] == 0))
		{
			return false;
		}
		return true;
	}
	public static function isJudge($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole === false) || ($UserRole['isJudge'] == 0))
		{
			return false;
		}
		return true;
	}
	public static function isManager($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole !== false) && 
			(
			($UserRole['isUM'] == 1) || 
			($UserRole['isSuper'] == 1)))
		{
			return true;
		}
		return false;
	}
	
	public static function isUM($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole !== false) && (($UserRole['isUM'] == 1)))
		{
			return true;
		}
		return false;
	}

	public static function isSuper($id)
	{
		$UserRole = User::getUserRole($id);
		if(($UserRole !== false) && (($UserRole['isSuper'] == 1)))
		{
			return true;
		}
		return false;
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

		$criteria->compare('userId',$this->userId);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userPw',$this->userPw,true);
		$criteria->compare('userRegTime',$this->userRegTime,true);
		$criteria->compare('isUM',$this->isUM,true);
		$criteria->compare('nickName',$this->nickName,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('isSuper',$this->isSuper);
		$criteria->compare('userLevel',$this->userLevel);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('isVerified',$this->isVerified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}