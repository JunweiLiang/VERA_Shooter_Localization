<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
	class BroadcastWidget extends CWidget
	{
	//公告板部件
	//自定宽度，当传入权限时点击可修改
	//暂时默认“用户管理员”有权限修改广播
		public $width = '140px';
		public $canChange = false;
		//public $changerId = '';
		public $id = 'broadcastBoard';
		public $changeUrl = '';
		public $getUrl = '';
		public $boardTitle = '通知';
		public function run()
		{
			if($this->changeUrl == '')
			{
				$this->changeUrl = Yii::app()->baseUrl.'/index.php/broadcast/change';
			}
			if($this->getUrl == '')
			{
				$this->getUrl = Yii::app()->baseUrl.'/index.php/broadcast/get';
			}
			/*if($this->canChange && ($this->changerId == ''))
			{
				die('error');
			}*///changeId直接在控制器中使用Yii::app()->session['userId']
			$this->render('broadcast',array(
				'id' => $this->id,
				'canChange' => $this->canChange,
				//'changerId' => $this->changerId,
				'width' => $this->width,
				'changeUrl' => $this->changeUrl,
				'getUrl' => $this->getUrl,
				'boardTitle' => $this->boardTitle,
			));
		}
	}
?>