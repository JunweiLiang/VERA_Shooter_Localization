<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php 
	//根据catalogId按textListId选取文章，ajax切换
	class TextListWidget extends CWidget
	{
		//textList整体选项
		//public $ajaxGet = true;
		public $textPerList = 7;//一页显示多少条
		public $width = '700px';
		public $id = 'textList';
		public $catalogId;
		public $isSimple = false;//简版//简版只显示标题，
			public $showYinYang = true;//简板是否文章以阴影间隔
			public $showDate = false;//简板是否显示文章日期 
		public $hasCataTitle = false;
		public $cataTitle = '';
		public $noMore = false;//不显示“查看更多”
		//textList单元选项
		public $hasEditTime = false;
		public $hasAuthor = false;
		public $hasTitlePic =false;
		public $nullTitlePicReplace = "";//不存在文章介绍图时的替代
		public function run()
		{
			if($this->hasCataTitle && $this->cataTitle == '')
			{
				echo "error";
			}
			if($this->nullTitlePicReplace == "")
			{
				$this->nullTitlePicReplace = '"<div class=\'imgReplace\'>中国大学生<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;计算机大赛</div>"';
			//	$this->nullTitlePicReplace = '"<img class=\'textTitleImg\' src=\''.Yii::app()->baseUrl.'/assets/images/bg.jpg\'></img>"';
			}
			$this->render('textList',array(
				'id' => $this->id,
				'width' => $this->width,
				'textPerList' => $this->textPerList,
				'hasEditTime' => $this->hasEditTime,
				'hasAuthor' => $this->hasAuthor,
				'catalogId' => $this->catalogId,
				"showDate" => $this->showDate,
				'showYinYang' => $this->showYinYang,
				//'ajaxGet' => $this->ajaxGet,
				'isSimple' => $this->isSimple,
				'hasCataTitle' => $this->hasCataTitle,
				'cataTitle' => $this->cataTitle,
				'noMore' => $this->noMore,
				'nullTitlePicReplace'=>$this->nullTitlePicReplace,
			));
		}
	
	}
?>