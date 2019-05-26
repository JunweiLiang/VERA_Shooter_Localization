<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class ChatTextListWidget extends CWidget
	{
		//列出写给Yii::app()->session['userId']的chatText,点击每个chatText会输出作者的id,与name
		/*
			css由外部书写
			#id > div.main > div.block
				<div class="block"><!--click绑定在此-->
					<input class="chatTextId" type="hidden"></input>
					<input class="fromUserId" type="hidden"></input>
					<input class="fromUserName" type="hidden"></input>
					<div class="line">userName:text</div>
					<div class="line time">createTime</div>
				</div>
		*/
		public $id = "chatTextList";
		public $instantLoad = true;
		public $target = array();
		/*
			array(
				array(
					"userId" => "",//以此change为主
					"userName" => "",
					"chatTextId" => "'
				),
				array(),
				..
			);
		*/
		public function run()
		{
			if(!isset(Yii::app()->session['userId']))
			{
				echo "error";
			}
			else
			{
				$this->render("chatTextList",array(
					"id" => $this->id,
					"target" => $this->target,
					"instantLoad" => $this->instantLoad,
				));
			}
		}
	}
?>
