<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php 

	class WeiboWidget extends CWidget
	{
		public $width = '300px';
		public $height = '500px';
		public $id = 'weiboDiv';
		public $weiboStr = '';//一个iframe字符串
		public function run()
		{
			$this->render('weibo',array(
				'width' => $this->width,
				'height' => $this->height,
				'id' => $this->id,
				'weiboStr' => $this->weiboStr,
			));
		}
	}
?>