<?php

/**
 * This is the model class for table "D_er_global_clusters".
 *
 * The followings are the available columns in table 'D_er_global_clusters':
 * @property integer $id
 * @property integer $datasetId
 * @property integer $videoNum
 * @property integer $isAuto
 * @property integer $isDeleted
 * @property string $refineName
 * @property string $tilerVideoPath
 */
class ERclusters extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ERclusters the static model class
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
		return 'D_er_global_clusters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('datasetId, videoNum', 'required'),
			array('datasetId, videoNum, isAuto, isDeleted', 'numerical', 'integerOnly'=>true),
			array('refineName', 'length', 'max'=>128),
			array('tilerVideoPath', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, datasetId, videoNum, isAuto, isDeleted, refineName, tilerVideoPath', 'safe', 'on'=>'search'),
		);
	}
public static function getResult($clusterId)
	{
		return Text::sql("SELECT D_er_global_results.*,D_er_global_results.id AS resultId,D_videos.name AS videoname,D_videos.hasImgs,D_videos.imgCount,D_videos.processPath,D_videos.relatedPath FROM D_er_global_results,D_dataset_video,D_videos WHERE D_er_global_results.clusterId=:c AND D_er_global_results.dvId=D_dataset_video.id AND D_dataset_video.videoId=D_videos.id ORDER BY D_er_global_results.offset ASC",array(":c"=>$clusterId));
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
			'datasetId' => 'Dataset',
			'videoNum' => 'Video Num',
			'isAuto' => 'Is Auto',
			'isDeleted' => 'Is Deleted',
			'refineName' => 'Refine Name',
			'tilerVideoPath' => 'Tiler Video Path',
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
		$criteria->compare('datasetId',$this->datasetId);
		$criteria->compare('videoNum',$this->videoNum);
		$criteria->compare('isAuto',$this->isAuto);
		$criteria->compare('isDeleted',$this->isDeleted);
		$criteria->compare('refineName',$this->refineName,true);
		$criteria->compare('tilerVideoPath',$this->tilerVideoPath,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}