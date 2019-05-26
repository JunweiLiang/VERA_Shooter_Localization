<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class ChatWidget extends CWidget
	{
		//聊天信息列表与回复部件
		//必须载入input.userId,用于获取session['userId']与此userId的对话 
		//暴露 #id > input.userId,调用其change就载入 
		/*
			css由外部决定
			＃id > chatMain > div.block[.me] > div.line[.me](text)
				<input class="userId" type="hidden"></input>
				<div class="refresh"><div class="btn btn-block btn-info btn-small refresh">刷新</div></div>
				<div class="chatMain"></div>
				<div class="say">
				<textarea class="chatText"></textarea>
				<div class="btn btn-small ">发送</div>
				</div>
		*/
		public $id = "chat";		
		public function run()
		{
			if(!isset(Yii::app()->session['userId']))
			{
				echo "error";
			}
			else
			{
				$this->render("chat",array(
					"id" => $this->id,
				));
			}
		}
	}
?>