<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{padding-top:20px}
	#<?php echo $id;?> > div.top{min-height:200px}
	#<?php echo $id;?> > div.top > div.left{float:left;width:300px}
	#<?php echo $id;?> > div.top > div.right{margin:0 0 0 300px}
	#<?php echo $id;?> > div.optWidgetsDiv{padding-top:10px}
</style>
<div id="<?php echo $id;?>">
	<div class='top'>
		<div class='left'>
		<?php 
			//获取所有的siteWidget
			$siteWidgetArray = SiteWidget::getAllWidgets();
			//$this->widget('siteWidgetOptWidget',array(
			//同时有catalogIdContainer、id 与 tartgetSelector  
			//	targetSelector
			//));//用于增添，删除部件，增添删除时(首先判断是否已经选择了catalog)触发change事件
			$optWidgetSelectorArr = array();
			foreach($siteWidgetArray as $one)
			{
				$temp = strtolower($one['optWidgetName'][0]);
				$temp.= substr($one['optWidgetName'],1,-6);//跳过结尾的'Widget'
				$optWidgetSelectorArr[] = '"#'.$temp.' input.catalogIdContainer"';
			}
			$this->widget('SiteWidgetOptWidget',array(
				'id' => 'siteWidgetOpt',
				'siteWidgetArray' => $siteWidgetArray,
				'targetSelector' => $optWidgetSelectorArr,
			));
			?>
		</div>
		<div class="right">
			<?php
			//从T_siteWidget中预载入所有optWidgetName,(内部optWidget都700px宽，这样可以不用外部wrap);optWidget的$id默认就为其名(驼峰)，catalogIdContainer默认为其名(input.class=name),且catalogIdContainer的父级就是id
			//optWidget都必须具备 catalogId的change响应事件，只来自siteWidgetOpt（siteWidget添加其时也触发change事件），响应时要判断其css display,响应动作就是ajax去T_cHomeDesign添加（如果原来没有，原来有就去自己对应的T_cHome**去获取该栏目已有的数据）
			//optWidget以siteWidgetId唯一表识
			$this->widget('CatalogViewerWidget',array(
				'id' => 'catalogDiv',
				'targetSelector' => array(
					'"#siteWidgetOpt input.catalogIdContainer"',//作用于siteWidgetOptWidget ,
					'"#catalogRecSelectorcvId"',//作用于子栏目推荐部件的栏目选择器
				),
				'width' => '400px',
				'catalogIdArray' => $homeCataIdArr,
				'getUrl' => Yii::app()->baseUrl.'/index.php/catalog/get',
				'showInternal' => false,
				'showNoText' => true,
				'noChild' => true,
				'instantLoad' => true,
				'instantChange' => true,
			));
		?>
		</div>
	</div>
	<div class="optWidgetsDiv">
		<?php 
			foreach($siteWidgetArray as $one)
			{
				$this->widget($one['optWidgetName'],array(
					'siteWidgetId' => $one['siteWidgetId'],
					'width' => '800px',
					'class' => 'optWidget',
					'siteWidgetTitle' => $one['siteWidgetTitle'],
				));
			}
		?>
	</div>
</div>
