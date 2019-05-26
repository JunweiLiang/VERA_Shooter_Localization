<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php 

	class MessageHandlerWidget extends CWidget
	{
		public $id = 'messagehandler';//包裹div 的id
		public function run()
		{
			$this->render('messageHandler',array(
				'id' => $this->id,
			));
		}
	}
?>