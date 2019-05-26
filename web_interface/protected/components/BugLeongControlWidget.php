<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	class BugLeongControlWidget extends CWidget
	{
		//爬虫器的控制部件
		//需要两个表 T_urlQueue  T_urlResult,urlQueue中包括该抓取的备注信息（note字段）（可以为空）
		public $id = "leongchunwai";
		public $getStatusUrl = '';//获取爬虫状态的url
		public $addUrl = '';//添加url到等待队列中的url
		public $execOneUrl = '';//执行最先的队列的url
		public $saveAsFileUrl = '';//转存到文件的url
		public $deleteUrl = '';//删除缓存的url
		//****
		public $getStatusFre = "1000";//获取状态的时间间隔
		//**
		//****下面是单独使用是是否加入jquery
		public $importJquery = false;
		public $importJqueryUrl = '';
		//*****
		public function run()
		{
			if($this->getStatusUrl == '')
			{
				$this->getStatusUrl = Yii::app()->baseUrl."/index.php/bugLeong/getStatus";
			}
			if($this->addUrl == '')
			{
				$this->addUrl = Yii::app()->baseUrl."/index.php/bugLeong/addUrl";
			}
			if($this->execOneUrl == '')
			{
				$this->execOneUrl = Yii::app()->baseUrl."/index.php/bugLeong/leong";
			}
			if($this->saveAsFileUrl == '')
			{
				$this->saveAsFileUrl = Yii::app()->baseUrl."/index.php/bugLeong/saveAsFile";
			}
			if($this->deleteUrl == '')
			{
				$this->deleteUrl = Yii::app()->baseUrl."/index.php/bugLeong/delete";
			}
			if($this->importJquery)
			{
				if($this->importJqueryUrl == '')
				{
					$this->importJqueryUrl = Yii::app()->theme->baseUrl."/js/jquery.min.js";
				}
			}
			$this->render('bugLeongControl',array(
				'id' => $this->id,
				'getStatusUrl' => $this->getStatusUrl,
				'addUrl' => $this->addUrl,
				'execOneUrl' => $this->execOneUrl,
				'saveAsFileUrl' => $this->saveAsFileUrl,
				'importJquery' => $this->importJquery,
				'importJqueryUrl' => $this->importJqueryUrl,
				'getStatusFre' => $this->getStatusFre,
				'deleteUrl' => $this->deleteUrl,
			));
		}
	}

?>