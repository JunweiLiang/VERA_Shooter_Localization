<?php

/**
 * This is the model class for table "T_message".
 *
 * The followings are the available columns in table 'T_message':
 * @property string $messageId
 * @property string $type
 * @property string $underId
 * @property string $userId
 * @property integer $isRead
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'T_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, underId, userId', 'required'),
			array('isRead', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>1),
			array('underId, userId', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('messageId, type, underId, userId, isRead', 'safe', 'on'=>'search'),
		);
	}
	public static function addMessage($type,$param=array())
	{
		if($type == 'comment')
		{
			if(isset($param['comId']) && isset($param['underId']) && isset($param['toWhomId']) && isset($param['comType']))
			{
				//先添加到underId下的提醒
					//获取underId(textId,shortTextId)的作者
					if($param['comType'] == 0)
					{
						$Text = Text::model()->find('textId=:textId',array(':textId'=>$param['underId']));
					}
					else if($param['comType'] == 1)
					{}
					else
					{
						die('error');
					}
					//最多产生两个提醒,
				$Message1 = new Message();
				$Message2 = new Message();
				$Message1->underId = $param['comId'];
				$Message1->type = 0;//for comment
				$Message2->underId = $param['comId'];
				$Message2->type = 0;//for comment
				if(($param['toWhomId'] != 0) && ($param['toWhomId'] != $Text->authorId))//回复给***情况(在某人帖子下回复不同的某人)
				{
					//下面分textId是否回复自己分情况讨论
					if($param['toWhomId'] == Yii::app()->session['userId'])
					{
						if($Text->authorId == Yii::app()->session['userId'])
						{
							return;//实际上是不可能事件
						}
						else
						{
							//在别人的帖子下回复自己，只提醒别人
							$Message1->userId = $Text->authorId;
							$Message1->save();
						}
					}
					else
					{
						if($Text->authorId == Yii::app()->session['userId'])
						{
							//在自己的帖子下回复别人，只提醒别人
							$Message1->userId = $param['toWhomId'];
							$Message1->save();
						}
						else
						{
							//别人的帖子下回复不同的别人,提醒两人
							$Message1->userId = $param['toWhomId'];
							$Message1->save();
							$Message2->userId = $Text->authorId;
							$Message2->save();
						}
					}
				}
				else//只在帖子下回复
				{
					//看是否自己的帖子，是自己的帖子就不提醒
					if($Text->authorId == Yii::app()->session['userId'])
					{
						return;
					}
					else
					{
						$Message1->userId = $Text->authorId;
						$Message1->save();
					}
				}
			}
			else
			{
				die('error');
			}
		}
		else if($type == 'checkText')
		{
			if(isset($param['checkId']) && isset($param['textId']) && isset($param['isCopyTo']))
			{
			//现在抄送文章的审核暂时不提醒 
				if($param['isCopyTo'] == 0)
				{
				//	echo 'fuck';
					//检查该文章作者是否该栏目的栏目管理员，是就不需要提醒
					$Text = Text::model()->find('textId=:textId',array(':textId'=>$param['textId']));
					//echo 'authoId='.$Text->authorId;
					//$authorId = (int)$Text->authorId;
					$catalogIdArray = CatalogManager::getCMsAllCataId2($Text->authorId);
					//print_r($catalogIdArray);
					//die('');
					if(!in_array($Text->catalogId,$catalogIdArray))
					{
					//	echo 'hi';
						//非该栏目管理员
						$Message = new Message();
						$Message->underId = $param['checkId'];
						$Message->type = 1;//for checkText
						$Message->userId = $Text->authorId;//帖子拥有者
						$Message->save();
					}
					else
					{
						return;
					}
				}
				else
				{
					return;
				}
			}
			else
			{
				die('error');
			}
		}
		else
		{
			die('error');
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
			'messageId' => 'Message',
			'type' => 'Type',
			'underId' => 'Under',
			'userId' => 'User',
			'isRead' => 'Is Read',
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

		$criteria->compare('messageId',$this->messageId,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('underId',$this->underId,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('isRead',$this->isRead);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}