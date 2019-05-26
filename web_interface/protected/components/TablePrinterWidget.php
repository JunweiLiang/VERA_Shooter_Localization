<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class TablePrinterWidget extends CWidget
	{
		public $title;
		public $table;
		public $hasWrap = true;
		public function run()
		{	
			$this->render("tablePrinter",array(
				"title" => $this->title,
				"table" => $this->table,
				"hasWrap" => $this->hasWrap,
			));
		}
	}
?>