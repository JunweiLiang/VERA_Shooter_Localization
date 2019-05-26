<?php

/**
 * This is the model class for table "T_setup".
 *
 * The followings are the available columns in table 'T_setup':
 * @property string $keyName
 * @property string $val
 */
class Setup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Setup the static model class
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
		return 'T_setup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 public static function getSetup()
	{
				$db = Yii::app()->db;
				$sqlcmd = "SELECT keyName,val FROM T_setup";
				$command = $db->createCommand($sqlcmd);
				$res = $command->queryAll();
				$result = array();
				foreach($res as $one)
				{
					$result[$one['keyName']] = $one['val'];
				}
				return $result;
	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyName', 'required'),
			array('keyName', 'length', 'max'=>128),
			array('val', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyName, val', 'safe', 'on'=>'search'),
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
			'keyName' => 'Key Name',
			'val' => 'Val',
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

		$criteria->compare('keyName',$this->keyName,true);
		$criteria->compare('val',$this->val,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}