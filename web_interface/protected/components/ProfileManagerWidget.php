<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php 
	class ProfileManagerWidget extends CWidget
	{
		//以后要改写为非instantLoad
		public $userId = 0;//传入要获取谁的profilemanager,自动判断是否自己，是自己就带入编辑部件
		public $id = 'profileManager';//div的id
		public $hasEditComp = false;
		public $showNickName = false;
		public $showIntro = false;
		public function run()
		{
			if($this->userId == 0)
			{
				echo 'shit';
			}
			else
			{
				if($this->userId == Yii::app()->session['userId'])
				{
					$this->hasEditComp = true;
				}
				//获取user信息
				$User = User::model()->findByPk($this->userId);
				$userName = $User->userName;
				$userNickName = $User->nickName;
				$userIntro = $User->intro;
				//判断user角色，载入更多的内容,对于每个角色都要载入其所属或者管理的catalog
				//先判断是否竞赛者，再判断评委，最后是参赛者 ,然后获取相应的profile
				$isCompetitor = false;
				$isJudge = false;
				$isManager = false;
				$specificArr = array();
				//if($User->isCompetitor == 1)
				if(false)
				{
					$isCompetitor = true;
					//获取赛区名字，学生类型，省份等文本信息
				/*	$Competitor = Competitor::model()->findByPk($User->userId);
					if($Competitor == null)
					{
						die("error");
					}
					$specificArr = $Competitor->attributes;
				*/
				
					
					//print_r($cmd->queryRow());
					$specificArr = Competitor::getProfile($this->userId);
					if($specificArr === false)
					{
						die("error");
					}
					$specificArr['schoolType'] = $specificArr['schoolType']==1?"本科":"高职高专";
					//获取赛区列表，省份列表//用户不能修改赛区以及省份信息
					
				//}
				//else if($User->isJudge == 1)
				//{
				}
				else
				{
					$isManager = true;
					$Manager = Manager::model()->findByPk($User->userId);
					if($Manager === null)
					{
						die("error");
					}
					//获取manager管理的catalog以及管理员种类
					//**
					$specificArr = $Manager->attributes;
				}
				$this->render('profileManager',array(
					'userId' => $this->userId,	
					'hasEditComp' => $this->hasEditComp,		
					'id' => $this->id,
					'userName' => $userName,
					'userNickName' => $userNickName,
					'userIntro' => $userIntro,
					'showNickName' => $this->showNickName,
					'showIntro' => $this->showIntro,
					
					'isCompetitor' => $isCompetitor,
					'isManager' => $isManager,
					
					'specific' => $specificArr,
				));
			}
		}
	}
?>