<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	/*
		展示通知的widget,对应编辑widget NoticeEditWidget,
		维护一个静态 name => id 变量，方便对应数据库T_notice
	*/
	class NoticeWidget extends CWidget
	{
		public static $nameToId = array(
			"competitorReg" => 1,
			"workMain" => 2,
			"baomingbiao" => 3,
			"bushuMain" => 4,
			"chayue" => 5,
			"bushu1" => 6,
			"bushu2" => 7,
			"shangchuan" => 8,//参赛作品相关文件上传(对象：所有参赛作品)总说明
			"jihuiImg" => 9,//寄汇参赛报名费并上传汇款凭证
			"jihui" => 10,//寄汇参赛报名费办法
			"chusaichushen" => 11,//初赛初审 的 评审说明
			"chusaifushen" => 12,//初赛复审 的 评审说明
			"juesaichushen" => 13,
			"juesaifushen" => 14,
			"checkWorkMain" => 15,//审核作品的通知
			"competitorIndex" => 16,//参赛者首页的通知
			"judgeIndex" => 17,//评委首页的通知
			"chusaichushenJM" => 18,//初赛初审策略中，评委管理员的通知
		);
		public $id = "notice";//包裹div 的 id
		public $noticeId = "";
		public $name = "";
		public $width = "700px";
		public function run()
		{
			//调用此widget需要指定noticeID，以去数据库读取相应的通知
			if($this->noticeId !== "")
			{
				$noticeId = $this->noticeId;
			}
			else if(($this->name !== "") && isset(self::$nameToId[$this->name]))
			{
				$noticeId = self::$nameToId[$this->name];
			}
			else
			{
				echo "error";
			}
			//去数据库读取noticeId的记录
			$Notice = Notice::model()->findByPk($noticeId);
			if($Notice == null)
			{
				echo "error";
			}
			else
			{
				$this->render("notice",array(
					'width' => $this->width,
					'content' => $Notice->content,
					'id' => $this->id,
				));
			}
		}
	}
?>