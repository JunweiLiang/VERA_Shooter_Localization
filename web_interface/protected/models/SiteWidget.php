<?php

/**
 * This is the model class for table "T_siteWidget".
 *
 * The followings are the available columns in table 'T_siteWidget':
 * @property integer $siteWidgetId
 * @property string $siteWidgetName
 * @property string $siteWidgetTitle
 * @property string $optWidgetName
 */
class SiteWidget extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteWidget the static model class
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
		return 'T_siteWidget';
	}
	public static function getAllWidgets()
	{
		$data = array();
		$SiteWidget = SiteWidget::model()->findAll();
				
		foreach($SiteWidget as $line)
		{
			$data[] = $line->attributes;
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
			array('siteWidgetName, siteWidgetTitle, optWidgetName', 'required'),
			array('siteWidgetName, optWidgetName', 'length', 'max'=>256),
			array('siteWidgetTitle', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('siteWidgetId, siteWidgetName, siteWidgetTitle, optWidgetName', 'safe', 'on'=>'search'),
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
			'siteWidgetId' => 'Site Widget',
			'siteWidgetName' => 'Site Widget Name',
			'siteWidgetTitle' => 'Site Widget Title',
			'optWidgetName' => 'Opt Widget Name',
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

		$criteria->compare('siteWidgetId',$this->siteWidgetId);
		$criteria->compare('siteWidgetName',$this->siteWidgetName,true);
		$criteria->compare('siteWidgetTitle',$this->siteWidgetTitle,true);
		$criteria->compare('optWidgetName',$this->optWidgetName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}