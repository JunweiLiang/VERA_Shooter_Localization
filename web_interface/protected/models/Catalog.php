<?php

/**
 * This is the model class for table "T_catalog".
 *
 * The followings are the available columns in table 'T_catalog':
 * @property string $catalogId
 * @property integer $creatorId
 * @property string $createTime
 * @property string $catalogTitle
 * @property integer $catalogRank
 * @property string $childNum
 * @property string $hasText
 * @property string $isPublic
 * @property string $catalogIntro
 * @property integer $hasWork
 * @property integer $zoneSchoolType
 */
class Catalog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catalog the static model class
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
		return 'T_catalog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creatorId, createTime, catalogTitle, catalogRank, childNum, hasText, isPublic', 'required'),
			array('creatorId, catalogRank, hasWork, zoneSchoolType', 'numerical', 'integerOnly'=>true),
			array('catalogTitle', 'length', 'max'=>255),
			array('childNum', 'length', 'max'=>8),
			array('hasText, isPublic', 'length', 'max'=>1),
			array('catalogIntro', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catalogId, creatorId, createTime, catalogTitle, catalogRank, childNum, hasText, isPublic, catalogIntro, hasWork, zoneSchoolType', 'safe', 'on'=>'search'),
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
public static function WgetCataArr($param)//获取所有hasWork == 1的数据
	{
		$res = array();
		$data = CatalogStructure::getCataStruct(1);
		$res = CatalogStructure::parseCata($data,$param,array(
			'hasWork' => 1
		));
		return $res;
	}
	public static function WgetCataArr2($param)//获取所有hasWork == 1的数据
	{
		$res = array();
		$data = CatalogStructure::getCataStruct(1);
		$res = CatalogStructure::parseCata2($data,$param,array(
			'hasWork' => 1
		));
		return $res;
	}
	
	public static function checkCataIsForWork($catalogId)
	{
		$Cata = Catalog::model()->findByPk($catalogId);
		if(($Cata != null) && ($Cata->hasWork == 1))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public static function HgetCataArr($param)
	{
		$res = array();
		$data = CatalogStructure::getCataStruct(1);
		$res = CatalogStructure::parseCata($data,$param,array(
			'isPublic' => 1
		));
		return $res;
	}
	public static function HgetCataArr2($param)
	{
		$res = array();
		$data = CatalogStructure::getCataStruct(1);
		$res = CatalogStructure::parseCata2($data,$param,array(
			'isPublic' => 1
		));
		return $res;
	}
	public static function getCataNodeOfCM($catalogManagerId)//这里只是获取了栏目管理员直接管理的栏目的id,还应该包括其栏目d的子栏目(不包括管理的页面)
	{
		$data = array();
			$db = Yii::app()->db;
			$sqlcmd = "SELECT * FROM T_CM WHERE userId = '".$catalogManagerId."'";
			$res = $db->createCommand($sqlcmd)->query();
			foreach($res as $line)
			{
				$temp = Catalog::model()->findByPk($line['catalogId'])->getAttributes();
				$data[] = $temp;
			}
		return $data;
	}
	public static function getCMCataId($userId)//返回一个userId的所有T_CM中的catalogId,返回纯数组
	{
		$db = Yii::app()->db;
		$res = $db->createCommand("SELECT catalogId From T_CM WHERE userId=:userId")->bindParam(":userId",$userId,PDO::PARAM_INT)->queryAll();
		$temp = array();
		foreach($res as $one)
		{
			$temp[] = $one['catalogId'];
		}
		return $temp;
	}
	public static function getCHMCataId($userId)//返回一个userId的所有T_CHM中的catalogId,返回纯数组
	{
		$db = Yii::app()->db;
		$res = $db->createCommand("SELECT catalogId From T_CHM WHERE userId=:userId")->bindParam(":userId",$userId,PDO::PARAM_INT)->queryAll();
		$temp = array();
		foreach($res as $one)
		{
			$temp[] = $one['catalogId'];
		}
		return $temp;
	}
	public static function getWMCataId($userId)//返回一个userId的所有T_WM中的catalogId,返回纯数组
	{
		$db = Yii::app()->db;
		$res = $db->createCommand("SELECT catalogId From T_WM WHERE userId=:userId")->bindParam(":userId",$userId,PDO::PARAM_INT)->queryAll();
		$temp = array();
		foreach($res as $one)
		{
			$temp[] = $one['catalogId'];
		}
		return $temp;
	}
	public static function getCataNodeOfCHM($catalogManagerId)//这里只是获取了栏目管理员直接管理的页面栏目的id
	{

		$data = array();
			$db = Yii::app()->db;
			$sqlcmd = "SELECT * FROM T_CHM WHERE userId = '".$catalogManagerId."'";
			$res = $db->createCommand($sqlcmd)->query();
			foreach($res as $line)
			{
				$temp = Catalog::model()->findByPk($line['catalogId'])->getAttributes();
				$data[] = $temp;
			}
		return $data;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catalogId' => 'Catalog',
			'creatorId' => 'Creator',
			'createTime' => 'Create Time',
			'catalogTitle' => 'Catalog Title',
			'catalogRank' => 'Catalog Rank',
			'childNum' => 'Child Num',
			'hasText' => 'Has Text',
			'isPublic' => 'Is Public',
			'catalogIntro' => 'Catalog Intro',
			'hasWork' => 'Has Work',
			'zoneSchoolType' => 'Zone School Type',
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

		$criteria->compare('catalogId',$this->catalogId,true);
		$criteria->compare('creatorId',$this->creatorId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('catalogTitle',$this->catalogTitle,true);
		$criteria->compare('catalogRank',$this->catalogRank);
		$criteria->compare('childNum',$this->childNum,true);
		$criteria->compare('hasText',$this->hasText,true);
		$criteria->compare('isPublic',$this->isPublic,true);
		$criteria->compare('catalogIntro',$this->catalogIntro,true);
		$criteria->compare('hasWork',$this->hasWork);
		$criteria->compare('zoneSchoolType',$this->zoneSchoolType);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}