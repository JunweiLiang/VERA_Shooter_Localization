<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php 
	class TextFeedWidget extends CWidget
	{
		//tf
		//非raw widget,view中直接ajax取数据(因为实现非一次性载入功能)
		//页面中使用 input.id='curId'纪录当前id(feedId)
		//次序在optWidget里已经确定，所以直接按T_cHome**的id
		public $id = 'textFeed';//tf的id
		public $width = '660px';//tf宽度,一个textfeed宽度为310px,(加padding 313px)建议660
		//*********获取推送的参数
		public $feedNum = 4;//一次显示的条数//0为显示所有//必须为偶数!!
		public $catalogId = 1;//初始的catalogId//初始的catalogId就决定了后来所取的catalog的父级
		//*******
		//******外部可改变的接口
		public $catalogIdContainer = 'tfCataId';//装载catalogId的input:hidden的id,放在$id下,其他部件动态改变其值使用"#$id #$catalogContainer",然后调用其change();
		//该catalogId必须是初始catalog的儿子
		
		public function run()
		{
			if($this->feedNum % 2 != 0)//必须为偶数!!
			{
				die('error!');
			}
			$this->render('textFeed',array(
				'id' => $this->id,
				'width' => $this->width,
				'feedNum' => $this->feedNum,
				'catalogId' => $this->catalogId,
				'catalogIdContainer' => $this->catalogIdContainer,
			));
		}
	}
?>