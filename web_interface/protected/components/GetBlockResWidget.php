<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/

?>
<?php
	class GetBlockResWidget extends CWidget
	{
		//直接从T_result获取workList的widget,分resultNum,以rank为order查看 
		//带有刷新的input接口(input.blockId)
		
		public $id="getBlockRes";
		public $blockId = null;
		public $instantLoad = false;//是否进入页面就刷新
		public $hasHead = false;//是否有一个“输出结果”的标题同，带上刷新按钮
		public $headTitle = "输出结果";
		
		//筛选器的初始值
		public $zoneId = "all";
		public $subTypeId = "all";
		public function run()
		{
			if($this->blockId == null)
			{
				die("");
			}
			$this->render("getBlockRes",array(
				"id" => $this->id,
				"blockId" => $this->blockId,
				"instantLoad" => $this->instantLoad,
				"hasHead" => $this->hasHead,
				"headTitle" => $this->headTitle,
				
				"zoneId" => $this->zoneId,
				"subTypeId" => $this->subTypeId,
			));
		}
	}
?>