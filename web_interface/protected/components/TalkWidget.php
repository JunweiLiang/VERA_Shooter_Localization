<?php 
	/****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<?php 
	class TalkWidget extends CWidget//说说的发布部件
	{
		public $id = 'chatchat';
		public $width;
		//*****
		public $sendUrl = '';
		public $snapchat = false;
		public $canPost = '';//是否可以发表说说
		public function run()
		{
			if($this->sendUrl == '')
			{
				$this->sendUrl = Yii::app()->baseUrl."/index.php/talk/send";
			}
			if($this->canPost == '')//未指定是否可以发表说说，那么就直接检查权限
			{
				$User = User::model()->findByPk(Yii::app()->session['userId']);
				if(($User == null) || ($User->canPostSS == 0))
				{
					$this->canPost = false;
				}
				else
				{
					$this->canPost = true;
				}
			}
			$this->render('talk',array(
				'id' => $this->id,
				'width' => $this->width,
				'sendUrl' => $this->sendUrl,
				'snapchat' => $this->snapchat,
				'canPost'=> $this->canPost,
			));
		}
	}	
	
?>