<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
//内部论坛网站的头导航栏模块，需要输入登录参数等
	class clubSiteHeaderWidget extends CWidget
	{
		public $userName;
		public $showSearch = true;
		public $headerBackImgUrl = "";
		//**头导航的参数，对应的url设置为false才会不显示
		/*
			固定的url有：
				内部网站首页url:clubSite/index
				登出的url:user/logout
				内部网站的logo:clubLogo.gif
				外部网站url: /	
		*/
		public $chatUrl = "";
		public $personalUrl = "";
		public $friendsUrl = "";
		//***下面是给侧边栏的参数
		public $width;
		public $panelParam;
		public $showBroadCast = true;
		public $showChat = false;
		public function run()
		{	
			//下面的参数决定header外观 
			if($this->headerBackImgUrl === "")//现在背景色是纯色所以没有用了
			{
				$this->headerBackImgUrl = Yii::app()->theme->baseUrl."/assets/images/clubSiteHBG.png";
			}
			//下面是header内的链接
			if($this->chatUrl === "")//网站内通信获取链接
			{
				$this->chatUrl = Yii::app()->baseUrl."/index.php/application/chat";
			}
			if($this->personalUrl === "")//未被设置成false且是默认情况，则是管理员角色
			{
				$this->personalUrl = Yii::app()->baseUrl."/index.php/application/personalPage";
			}
			if($this->friendsUrl === "")//未被设置成false且是默认情况，则是管理员角色
			{
				$this->friendsUrl = Yii::app()->baseUrl."/index.php/application/friends";
			}
			
			$this->render('clubSiteHeader',array(
				'userName' => $this->userName,
				'headerBackImgUrl' => $this->headerBackImgUrl,
				
				'chatUrl' => $this->chatUrl,
				'personalUrl' => $this->personalUrl,
				'friendsUrl' => $this->friendsUrl,
				
				'width' => $this->width,
				'showSearch' => $this->showSearch,
				'panelParam' => $this->panelParam,
				'showBroadCast' => $this->showBroadCast,
				"showChat" => $this->showChat,
			));
		}
	}

?>