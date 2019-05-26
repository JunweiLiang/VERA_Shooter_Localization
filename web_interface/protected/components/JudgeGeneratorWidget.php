<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/

?>
<?php
	class JudgeGeneratorWidget extends CWidget
	{
		/*
			仅修改T_user,T_judgeProfile的默认新建
		*/
		public $id = "judgeGenerator";
		public $targetSelector = "";//新建成功后调用的"$targetSelector".change()
		public function run()
		{
			//载入本JM的管理的赛区列表
			$db = Yii::app()->db;
			$userId = Yii::app()->session['userId'];
			$sqlcmd = "SELECT T_catalog.catalogId,T_catalog.catalogTitle ".
				" FROM T_JM,T_catalog ".
				" WHERE T_JM.userId=:u AND T_JM.catalogId=T_catalog.catalogId";
			$command = $db->createCommand($sqlcmd);
			$command->bindParam(":u",$userId,PDO::PARAM_INT);
			$JMArray = $command->queryAll();
			$this->render("judgeGenerator",array(
				"id" => $this->id,
				"targetSelector" => $this->targetSelector,
				"JMArray" => $JMArray,
			));
		}
	}
?>