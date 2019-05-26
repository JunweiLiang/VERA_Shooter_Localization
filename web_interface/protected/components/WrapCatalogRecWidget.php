<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.11
	*/
?>
<?php 
	class WrapCatalogRecWidget extends CWidget
	{
		public $id = "catalogRec";
		public $catalogId;
		public $notNullShowMarginBottom = false;//有内容时自带下边距
		public function run()
		{
			if(!isset($this->catalogId))
			{
				die("errror");
			}
			//获取该栏目setup.
			$setup = CatalogRecSetup::getSetup($this->catalogId);
			//获取catalogRec
			$recArr = CHomeCatalogRec::getRecArr($this->catalogId);
			if((count($recArr) > 0) && ($this->notNullShowMarginBottom === true))//有内容的情况且设定有内容时自带下边距
			{
				//die("e");
				$this->widget('CatalogRecWidget',array(
					'id' => $this->id,
					'width' => $setup['width'],
					'lineNum' => $setup['lineNum'],
					'gapWidth' => $setup['gapWidth'],
					'cHeight' => $setup['height'],
					'catalogArr' => $recArr,
					'cataT_font_size' => $setup['cataT_font_size'],
					'cataI_font_size' => $setup['cataI_font_size'],
					'bgColor' => $setup['bgColor'],
					'left' => $setup['left'],
					"marginBottom" => "20px",
				));
				
			}
			else
			{
				$this->widget('CatalogRecWidget',array(
					'id' => $this->id,
					'width' => $setup['width'],
					'lineNum' => $setup['lineNum'],
					'gapWidth' => $setup['gapWidth'],
					'cHeight' => $setup['height'],
					'catalogArr' => $recArr,
					'cataT_font_size' => $setup['cataT_font_size'],
					'cataI_font_size' => $setup['cataI_font_size'],
					'bgColor' => $setup['bgColor'],
					'left' => $setup['left'],
				));
			}
		}
	}
	
?>