<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
	class ClubSiteFooterWidget extends CWidget
	{
		public $id = 'clubSiteFooter';
		public $siteWidth = '980px';
		public function run()
		{
			$this->render('clubSiteFooter',array(
				'id' => $this->id,
				'siteWidth' => $this->siteWidth,
			));
		}
	}	
?>