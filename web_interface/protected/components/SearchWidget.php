<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	class SearchWidget extends CWidget
	{
		public $id = "searchDiv";//装载搜索框的div id
		public $width;//整体宽度
		public $w = '';//传入的初始关键字,为编码的字符串
		public $returnResult = false;//是否点击后ajax返回结果,false的时候就打开搜索页，搜索页中的widget $w不为空且returnResult为true
		public $searchPageUrl = '';
		public $autoCl = true;//是否修改时自动猜测输入
		public $searchUrl = '';
		public $searchPredictUrl = '';
		
		public $returnStr = false;//是否返回字符串，在头导航栏中有用(而不是打印这个控件)
		public function run()
		{
			if($this->searchPageUrl == '')	
			{
				$this->searchPageUrl = Yii::app()->baseUrl."/index.php/site/search";
			}
			if($this->searchUrl == '')	
			{
				$this->searchUrl = Yii::app()->baseUrl."/index.php/search/search";
			}
			if($this->searchPredictUrl == '')	
			{
				$this->searchPredictUrl = Yii::app()->baseUrl."/index.php/search/predict";
			}
			if($this->returnStr)
			{
				$this->render('search',array(
					'id' => $this->id,
					'width' => $this->width,
					'w' => $this->w,
					'returnResult' => $this->returnResult,
					'searchPageUrl' => $this->searchPageUrl,
					'autoCl' => $this->autoCl,
					'searchUrl' => $this->searchUrl,
					'searchPredictUrl' => $this->searchPredictUrl,
				),$this->returnStr);
			}
			else
			{
				$this->render('search',array(
					'id' => $this->id,
					'width' => $this->width,
					'w' => $this->w,
					'returnResult' => $this->returnResult,
					'searchPageUrl' => $this->searchPageUrl,
					'autoCl' => $this->autoCl,
					'searchUrl' => $this->searchUrl,
					'searchPredictUrl' => $this->searchPredictUrl,
				));
			}
		}
		public function returnStr()//此方法用于为整个widget返回字符串，以在别的widget中调用widget($this->widget产生的是一个class)
		{
			return $this->render('search',array(
					'id' => $this->id,
					'width' => $this->width,
					'w' => $this->w,
					'returnResult' => $this->returnResult,
					'searchPageUrl' => $this->searchPageUrl,
					'autoCl' => $this->autoCl,
					'searchUrl' => $this->searchUrl,
					'searchPredictUrl' => $this->searchPredictUrl,
				),$this->returnStr);
		}
	}

?>