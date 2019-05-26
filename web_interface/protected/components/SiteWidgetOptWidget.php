<?php 
	/********************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

			//同时有catalogIdContainer、id 与 tartgetSelector  
			//	targetSelector
			//));//用于增添，删除部件，增添删除时(首先判断是否已经选择了catalog)触发change事件
			class SiteWidgetOptWidget extends CWidget
			{
				public $id = 'siteWidgetOpt';
				public $catalogIdContainer = 'catalogIdContainer';//class
				public $targetSelector = '';
				public $width = '300px';
				public $siteWidgetArray = array();
				public function run()
				{
					$this->render('siteWidgetOpt',array(
						'id' => $this->id,
						'catalogIdContainer' => $this->catalogIdContainer,
						'targetSelector' => $this->targetSelector,
						'width' => $this->width,
						'siteWidgetArray' => $this->siteWidgetArray,
					));
				}
			}
?>