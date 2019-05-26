<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php 
	class BodyOptionWidget extends CWidget
	{
		public $id = 'bodyOption';
		public $setOptionUrl = "";
		public $initFontFamily = '';
	//	public $width = "";
		public function run()
		{
			if($this->setOptionUrl == "")
			{
				$this->setOptionUrl = Yii::app()->baseUrl."/index.php/bodyOption/set";
			}
			//获取初始已经设置的字体
			$db = Yii::app()->db;
			$sqlcmd = "SELECT bodyFontFamily FROM T_bodyOption ORDER BY optionId DESC LIMIT 0,1";
			$res = $db->createcommand($sqlcmd)->query();
			
			foreach($res as $line)
			{
				$this->initFontFamily = $line['bodyFontFamily'];
			}
			//$BodyOption = BodyOption::model()->find();
			$this->render('bodyOption',array(
				'id' => $this->id,	
				'initFontFamily' => $this->initFontFamily,
				'setOptionUrl' => $this->setOptionUrl,
			));
		}
	}
?>