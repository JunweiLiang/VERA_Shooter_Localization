<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	class FriendsListWidget extends CWidget
	{
		public $id = 'friendsList';
		public $width = '700px';
		public $instantLoad = true;
		public function run()
		{
			$this->render('friendsList',array(
				'id' => $this->id,
				'width' => $this->width,
				'instantLoad' => $this->instantLoad,
			));
		}
	}
?>