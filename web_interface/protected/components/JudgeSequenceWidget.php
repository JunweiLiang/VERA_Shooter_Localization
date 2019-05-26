<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class JudgeSequenceWidget extends CWidget
	{
		public $id = "judgeSequence";
		public $strategyArr = array();
		public function run()
		{
			if(empty($this->strategyArr))
			{
				$Strategies = Strategy::model()->findAll();
				foreach($Strategies as $strategy)
				{
					$temp = array();
					$temp = $strategy->attributes;
					$SRArr = StrategyResult::model()->findAll("strategyId =:strategyId ORDER BY resultNum ASC",array(
						":strategyId" => $temp['strategyId'],
					));
					foreach($SRArr as $sr)
					{
						$temp['resultCluster'][] = $sr->attributes;
					}
					$temp['resultSum'] = count($SRArr);
					$this->strategyArr[] = $temp;
				}
			}
			$this->render("judgeSequence",array(
				"id" => $this->id,
				"strategyArr" => $this->strategyArr,
			));
		}
	}
?>