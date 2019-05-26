<?php

/**
 * This is the model class for table "T_uGroup".
 *
 * The followings are the available columns in table 'T_uGroup':
 * @property integer $id
 * @property string $groupName
 * @property integer $userId
 */
class UGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UGroup the static model class
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
		return 'T_uGroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupName, userId', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('groupName', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupName, userId', 'safe', 'on'=>'search'),
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
//添加成员到 人力资源中，或者进组里
	public static function add($param)
	{
		//添加$param['userId'] 到本人的人力资源圈子，如果设置了['uGroupId']就同时添加到该分组
		if(isset($param['userId']))
		{
			$param['userId'] = (int)$param['userId'];
			if(User::model()->exists("userId=:u",array(":u" => $param['userId'])))
			{
				$ownId = Yii::app()->session['userId'];
				//直接添加 T_uGUeeMain,查重
				if(!UGUeeMain::model()->exists("userId=:o AND uGUserId=:u",array(":o"=>$ownId,":u"=>$param['userId'])))
				{
					$NewUGUeeMain = new UGUeeMain();
					$NewUGUeeMain->userId = $ownId;
					$NewUGUeeMain->uGUserId = $param['userId'];
					if(!$NewUGUeeMain->save())
					{
						throw new Exception("e");
						return;
					}
				}
				//添加到某分组
				if(isset($param['uGroupId']))
				{
					//检查该组存在
					if(UGroup::model()->exists("userId=:o AND id=:g",array(":o"=>$ownId,":u"=>$param['uGroupId'])))
					{
						//添加此人到此组（检查是否已经存在）
						if(!UGUee::model()->exists("userId=:u AND uGroupId=:g",array(":u"=>$param['userId'],":u"=>$param['uGroupId'])))
						{
							$NewUGUee = new UGUee();
							$NewUGUee->userId = $param['userId'];
							$NewUGUee->uGroupId = $param['uGroupId'];
							if(!$NewUGUee->save())
							{
								throw new Exception("e");
								return;
							}
						}
					}
				}
			}
		}
	}
	//获取本人的人力资源组
	public static function get($param)
	{
		/*
			返回的groupMember = array(
				array(
					"userName"=>,
					"nickName" => ,
					"userId"=>,
				),
			)
		*/
		if(isset($param['num']))
		{
			$ownId = Yii::app()->session['userId'];
			$res = array();
			if($param['num'] == "all")
			{
				$uGroups = UGroup::model()->findAll("userId=:o",array(":o"=>$ownId));
			}
			else
			{
				$num = (int)$param['num'];
				$uGroups = UGroup::model()->findAll("userId=:o LIMIT 0,$num",array(":o"=>$ownId));
			}
			$db = Yii::app()->db;
			//以后的优化：groups只要userId,名字从T_uGUeeMain获得的取
			//获取机构所有的人，以后这些要换成获取该人的关联组，
			$sqlcmd = "SELECT userName,nickName,userId FROM T_user WHERE isUM<>1 AND isSuper<>1 AND userId<>:u";
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":u",$ownId,PDO::PARAM_INT);
			$res[] = array(
				"groupName" => t::o("more")."...",
				"groupId" => -1,
				"groupMember" => $command->queryAll(),
			);
			//获取T_uGUeeMain 
			
			$sqlcmd = "SELECT T_user.userName,T_user.nickName,T_uGUeeMain.uGUserId AS userId FROM T_uGUeeMain,T_user WHERE ".
				" T_uGUeeMain.userId=:o AND T_uGUeeMain.uGUserId=T_user.userId";
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":o",$ownId,PDO::PARAM_INT);
			$res[] = array(
				"groupName" => t::o("all"),
				"groupId" => 0,
				"groupMember" => $command->queryAll(),
			);
			//获取groups下的分组人id名字等
			foreach($uGroups as $uGroup)
			{
				$sqlcmd = "SELECT T_user.userName,T_user.nickName,T_uGUee.userId FROM T_user,T_uGUee WHERE".
					" T_uGUee.uGroupId=:g AND T_uGUee.userId=T_user.userId";
				$command = $db->createCommand($sqlcmd);
				$uGroupId = $uGroup->id;
				$command->bindParam(":g",$uGroupId,PDO::PARAM_INT);
				$res[] = array(
					"groupName" => $uGroup->groupName,
					"groupId" => $uGroup->id,
					"groupMember" => $command->queryAll(),
				);
			}
			
			return $res;
			//return array("a"=>1);
		}
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'groupName' => 'Group Name',
			'userId' => 'User',
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
		$criteria->compare('groupName',$this->groupName,true);
		$criteria->compare('userId',$this->userId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}