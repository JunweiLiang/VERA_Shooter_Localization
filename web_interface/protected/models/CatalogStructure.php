<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

/**
 * This is the model class for table "T_catalogStructure".
 *
 * The followings are the available columns in table 'T_catalogStructure':
 * @property integer $parentId
 * @property integer $childId
 */
class CatalogStructure extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogStructure the static model class
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
		return 'T_catalogStructure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentId, childId', 'required'),
			array('parentId, childId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('parentId, childId', 'safe', 'on'=>'search'),
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
			'parentId' => 'Parent',
			'childId' => 'Child',
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

		$criteria->compare('parentId',$this->parentId);
		$criteria->compare('childId',$this->childId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function parseCata($data,$param,$userParam = array())
	{//为了兼容代码好长啊！
	//$param == 'catalogId','catalogTitle',userParam:用户附加条件，形式如：array(
	// 'hasText' => 1,//相当与获取param同时满足hasText == 1
	//);
	//$catalogData = CatalogStructure::getCataStruct($line['catalogId']);
	//$catalogArray = CatalogStructure::parseCata($catalogData,'catalogId');
	//$param 可为字符串或者数组
	
		//该函数把getCataStruct获取的数据中$param字段的数据获取出来（数组形式）
		if(!is_array($param))
		{
			static $res = array();
			//构造userParam条件
			if(!empty($userParam))
			{
			$unfit = false;//是否满足所有附加条件
			foreach($userParam as $key => $val)
			{
				//检查是否合法
				/*if(!isset($data[$key]))
				{
					return false;
				}*///该层可能完全是数组，这里不直接检查是否合法，参数不合法自然返回空集
				if(!isset($data[$key]) || ($data[$key] != $val))
				{
					$unfit = true;
				}
			}
			if($unfit)//该层不符合条件，递归到下一层继续
			{
				foreach($data as $key => $val)
				{
					if(is_array($val))
					{
						self::parseCata($val,$param,$userParam);
					}
				}
			}
			else
			{
				foreach($data as $key => $val)
				{
			
					if($key === $param)
					{
						$res[] = $val;
					}
					else if(is_array($val))
					{
						self::parseCata($val,$param,$userParam);
					}
				}
			}
		}
			else
			{
			foreach($data as $key => $val)
			{
			
				if($key === $param)
				{
					$res[] = $val;
				}
				else if(is_array($val))
				{
					self::parseCata($val,$param);
				}
			}
		}
		}
		else
		{
			static $res = array();
			//构造userParam条件
			if(!empty($userParam))
			{
				$unfit = false;//是否满足所有附加条件
				foreach($userParam as $key => $val)
				{
					//检查是否合法
						/*if(!isset($data[$key]))
					{
							return false;
					}*///该层可能完全是数组，这里不直接检查是否合法，参数不合法自然返回空集
					if(!isset($data[$key]) || ($data[$key] != $val))
					{
						$unfit = true;
					}	
				}
				if($unfit)//该层不符合条件，递归到下一层继续
				{
					foreach($data as $key => $val)
					{
						if(is_array($val))
						{
							self::parseCata($val,$param,$userParam);
						}
					}
				}
				else
				{
					$temp = array();
					foreach($data as $key => $val)
					{				
						if(is_array($val))
						{
							self::parseCata($val,$param,$userParam);
						}else
						{			
							foreach($param as $v)
							{
								if($v == $key)						
								{
									$temp[$v] = $val;
								}
							}
						}
					}
					if(!empty($temp))
					{
						$res[] = $temp;
					}
				}
			}
			else
			{
			$temp = array();
			foreach($data as $key => $val)
			{
			
					if(is_array($val))
					{
						self::parseCata($val,$param,$userParam);
					}else
					{
						
						foreach($param as $v)
						{
							if($v == $key)						
							{
								$temp[$v] = $val;
							}
						}
					}
			}
			if(!empty($temp))
			{
				$res[] = $temp;
			}
		}
		}
		return $res;
	}
	public static function parseCata2($data,$param,$userParam = array())
	{//为了兼容代码好长啊！
	//$param == 'catalogId','catalogTitle',userParam:用户附加条件，形式如：array(
	// 'hasText' => 1,//相当与获取param同时满足hasText == 1
	//);
	//$param 可为字符串或者数组//表示要返回的字段数据
	
		//该函数把getCataStruct获取的数据中$param字段的数据获取出来（数组形式）
		if(!is_array($param))
		{
			static $res = array();
			//构造userParam条件
			if(!empty($userParam))
			{
			$unfit = false;//是否满足所有附加条件
			foreach($userParam as $key => $val)
			{
				//检查是否合法
				/*if(!isset($data[$key]))
				{
					return false;
				}*///该层可能完全是数组，这里不直接检查是否合法，参数不合法自然返回空集
				if(!isset($data[$key]) || ($data[$key] != $val))
				{
					$unfit = true;
				}
			}
			if($unfit)//该层不符合条件，递归到下一层继续
			{
				foreach($data as $key => $val)
				{
					if(is_array($val))
					{
						self::parseCata2($val,$param,$userParam);
					}
				}
			}
			else
			{
				foreach($data as $key => $val)
				{
			
					if($key === $param)
					{
						$res[] = $val;
					}
					else if(is_array($val))
					{
						self::parseCata2($val,$param,$userParam);
					}
				}
			}
		}
			else
			{
			foreach($data as $key => $val)
			{
			
				if($key === $param)
				{
					$res[] = $val;
				}
				else if(is_array($val))
				{
					self::parseCata2($val,$param);
				}
			}
		}
		}
		else
		{
			static $res = array();
			//构造userParam条件
			if(!empty($userParam))
			{
			$unfit = false;//是否满足所有附加条件
			foreach($userParam as $key => $val)
			{
				//检查是否合法
				/*if(!isset($data[$key]))
				{
					return false;
				}*///该层可能完全是数组，这里不直接检查是否合法，参数不合法自然返回空集
				if(!isset($data[$key]) || ($data[$key] != $val))
				{
					$unfit = true;
				}
			}
			if($unfit)//该层不符合条件，递归到下一层继续
			{
				foreach($data as $key => $val)
				{
					if(is_array($val))
					{
						self::parseCata2($val,$param,$userParam);
					}
				}
			}
			else
			{
				$temp = array();
				foreach($data as $key => $val)
				{				
					if(is_array($val))
					{
						self::parseCata2($val,$param,$userParam);
					}else
					{			
						foreach($param as $v)
						{
							if($v == $key)						
							{
								$temp[$v] = $val;
							}
						}
					}
				}
				if(!empty($temp))
				{
					$res[] = $temp;
				}
			}
		}
			else
			{
			$temp = array();
			foreach($data as $key => $val)
			{
			
					if(is_array($val))
					{
						self::parseCata2($val,$param,$userParam);
					}else
					{
						
						foreach($param as $v)
						{
							if($v == $key)						
							{
								$temp[$v] = $val;
							}
						}
					}
			}
			if(!empty($temp))
			{
				$res[] = $temp;
			}
		}
		}
		return $res;
	}
	public static function getCataStruct($id)//获取该栏目id信息以及下的所有儿子信息
	{
			
		//return Yii::app()->session['userId'];
		$data = array();//data本身含有T_catalog整行的信息，还有'children'=>array()
		$catalogLine = Catalog::model()->findByPk($id);
		//当该栏目下有孩子时
		if(count($catalogLine)!=0)
		{
			foreach($catalogLine as $key=>$value)
			{
				$data[$key] = $value;
			}
			$data['children'] = array();
			//下面获取该下一层所有子节点的信息
			//****二次设计的备忘＝＝＝＝这个链接查询好浪费,没必要连接(因为要ORDER??)
			$db = Yii::app()->db;
			$sqlcmd = "SELECT * FROM T_catalog WHERE catalogId IN(
				SELECT childId FROM T_catalogStructure WHERE parentId = '".$id."'
			) ORDER BY catalogRank ASC";
			$children = $db->createCommand($sqlcmd)->query();//其元素是T_catalog中的行
		//
			foreach($children as $child)
			{
				$data['children'][] = CatalogStructure::getCataStruct($child['catalogId']);
			}
		}
		return $data;
	}
}