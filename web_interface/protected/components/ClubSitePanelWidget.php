<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
//内部论坛网站的控制栏（左栏），接收width,border属性,控制条数组
	class ClubSitePanelWidget extends CWidget
	{
		public $id = "panel";//整个容器的id
		public $width;//控制条宽度
		public $showBroadCast = true;
		public $panelParam;/* array(
			'Basic' => array('title'=>'Basic','head'=>true),
			'index' => array('title'=>'首页','head'=>false,'active'=>false,'icon'=>'home','href'=>'#'),
			'message' => array('title'=>'消息','head'=>false,'active'=>false,'icon'=>'envelope','href'=>'#'),
			'shortText' => array('title'=>'简文','head'=>false,'active'=>false,'icon'=>'file','href'=>'#'),
			'text' => array('title'=>'文章','head'=>false,'active'=>false,'icon'=>'book','href'=>'#'),
			'Special' => array('title'=>'Special','head'=>true),
			'catalogManage' => array('title'=>'栏目管理','head'=>false,'active'=>false,'icon'=>'envelope','href'=>'#'),
			'homepageManage' => array('title'=>'首页管理','head'=>false,'active'=>false,'icon'=>'envelope','href'=>'#'),
			'userManage' => array('title'=>'用户管理','head'=>false,'active'=>false,'icon'=>'envelope','href'=>'#')
		);*/
		public function run()
		{
			//检查当前方法是什么，对应active=true//echo $this->getAction()->getId();
			$curAction = Yii::app()->controller->getAction()->getId();
			if(isset($this->panelParam["$curAction"]))
			{
				$this->panelParam["$curAction"]['active']=true;
			}

			$this->render('clubSitePanel',array(
				'id' => $this->id,
				'width' => $this->width,
				'panelParam' => $this->panelParam,
				'showBroadCast' => false,//直接阉割
			));
		}
	}

?>