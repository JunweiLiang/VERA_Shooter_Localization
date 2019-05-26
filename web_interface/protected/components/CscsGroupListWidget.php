<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	//初赛初审策略的分组的列表部件
	//有blockId,catalogId 的筛选器
	
	class CscsGroupListWidget extends CWidget
	{
		public $id = "groupList";
		public $toggle=true;
		public $blockId;
		public $targetSelector = array();//传groupId,groupName,然后调用change
		/*
			array('groupName'=>,'groupId'=>)
		*/
		public function run()
		{
			$this->render("cscsGroupList",array(
				"blockId" => $this->blockId,
				"toggle" => $this->toggle,
				"id" => $this->id,
				"targetSelector" => $this->targetSelector,
			));
		}
	}
?>