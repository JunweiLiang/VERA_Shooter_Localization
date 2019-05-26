<?php 
	/****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<?php 
	class TalkListWidget extends CWidget//说说的查看部件
	{
		public $constantCheck = true;//实时
		public $checkFrequence = 2000;//默认3秒一次轮训
		public $talkNum = 10;//进入页面时或者点击获取更多,一次获取10个talk,
		public $getUrl='';
		//***********
		public $id = 'talkList';
		public $width;
		//*****
		public function run()
		{
			if($this->getUrl == '')
			{
				$this->getUrl = Yii::app()->baseUrl."/index.php/talk/get";
			}
			$this->render('talkList',array(
				'constantCheck' => $this->constantCheck,
				'checkFrequence' => $this->checkFrequence,
				'id' => $this->id,
				'width' => $this->width,
				'talkNum' => $this->talkNum,
				'getUrl' => $this->getUrl,
			));
		}
	}	
	
?>