<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php 
	class WorkTypeManageWidget extends CWidget
	{
		public $id = "workTypeManage";
		public $instantLoad = true;
		public function run()
		{
			$this->render("workTypeManage",array(
				"id" => $this->id,
				"instantLoad" => $this->instantLoad,
			));
		}
	}
?>