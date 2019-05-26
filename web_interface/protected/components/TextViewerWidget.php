<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php 
	class TextViewerWidget extends CWidget
	{
		//viewer只载入文章标题，点击才显示文章内容，然后
		public $id;//viewer的id
		public $width;//viewer的宽度，建议于textEditor相同宽度
		public $feedNum = 5;//一次显示的条数//0为显示所有
		
		//public $componentArray = array(
		//	'评论' => '',
		//);
		
		public $getOne = false;//只获取一篇，那就只有“查看”，“评论”按钮,
		public $oneTextId = "";
		//**************文章选择功能
		public $chooseFunc = false;
				//该文章相关参数输出到d的地方（jquery选择器字符串）
		public $textIdTo = '';
		public $textTitleTo = '';
		public $checkIdTo = '';
		public $textTitlePicTo = '';
		public $actIdTo = '';
		public $actLocTo = '';
		public $actTimeTo = '';
		public $actLecturerTo = '';
		public $textContentTo = '';
		public $textAuthorNameTo = '';
		public $textCataNameTo = '';
		public $targetSelector = '';//选择后触发change事件的对象d的选择器字符串
		//*************************************
		public $instantLoad = false;
		public $catalogIdContainer = '';//装载catalogId的input:hidden的id,放在$id下,其他部件动态改变其值使用"#$id #$catalogContainer",然后调用其change();
		public $userIdContainer = '';
		public $orderContainer = '';
		public $checkStatusContainer = '';
		public $isCopyToContainer = '';
		public $actTextOnly = false;
		public $onlyPublic = false;//仅获取公开栏目的文章
		public $getCopy = false;//获取抄送的文章
		//初始以及默认（没有动态改变时）获取文章的参数
		public $catalogId = 0;//获取的text所属的catalogId,0为全部
		public $userId = 0;//获取的text所属的userId,0为全部
		public $startNum = 0;//结果集中开始的序号
		public $order = 'time';//默认按时间desc//checktime,提交审核、通过/不通过审核的时间
		public $checkStatus = 2;//获取text所处的checkStatus,0 for waiting ,1 for failed,2 for approved，'' for all,3 for 1&2,4 for all,5for 0&2
		public $toWhom = 0;//0 for public,1 for CM only;1 for CM page
		public $isCopyTo = 1;//抄送文章是否可见，0不可见，1可见
		
		public $showInModal = false;//是否点击“查看”后在模态对话框中查看//width小于700时建议开启
		
		public $getTextListUrl = "";
		public $getTextUrl = "";
		//*********审核功能
		public $hasCheckComp = false;//是否含有审核组件
		public $editorConfig = array();//审核时文本编辑器d的设置
	
		public $checkCompParam = array(
			//'textIdSelector' => '',//外部的存储textId的input hidden的jquery选择器(必须包括双引号，或者为this)
			//'getTextIdSelector' => '',//触发填充id到编辑器中的按钮的jquery选择器(默认click触发)
		//当textIdSelector不为空时，执行：
		/*	
			$(document).delegate(<?php echo $clickButtonSelector;?>,"click",function(){
				$("#<?php echo $id?> #editTextDiv #editTextId").val($(<?php echo $textIdSelector;?>).val());
				getText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),"editTextDiv");
			});
		*/
		);
		public $checkTextUrl = '';
		//********抄送功能
		public $hasCopyComp = false;//是否含抄送部件
		public $getCataUrl = '';
		public $copyUrl = '';
		public $getCopyUrl = '';
		//****评论功能
		public $hasComComp = false;
		public $canComT = '';//是否有评论文章的权限
		public $getComUrl = '';
		public $comUrl = '';
		public $deleteComUrl = '';
		public $instantExpandCom = false;//是否载入就展开评论
		public function run()
		{
			if($this->canComT == '')
			{
				//外部为定义是否有评论文章权限时，自动往数据库检查权限
				$User = User::model()->findByPk(Yii::app()->session['userId']);
				if($User == null)
				{
					die('error');
				}
				else if($User->canComT == 1)
				{
					$this->canComT = true;
				}
				else
				{
					$this->canComT = false;
				}
			}	
			if($this->checkStatus === '')
			{
				die('error');
			}
			if($this->getTextListUrl == '')
			{
				$this->getTextListUrl = Yii::app()->baseUrl."/index.php/text/getList";
			}
			if($this->getTextUrl == '')
			{
				$this->getTextUrl = Yii::app()->baseUrl."/index.php/text/get";
			}
			//****抄送功能
			if($this->hasCopyComp && ($this->getCataUrl == ''))
			{
				$this->getCataUrl = Yii::app()->baseUrl."/index.php/catalog/get";
			}
			if($this->hasCopyComp && ($this->copyUrl == ''))
			{
				$this->copyUrl = Yii::app()->baseUrl."/index.php/text/copy";
			}
			if($this->hasCopyComp && ($this->getCopyUrl == ''))
			{
				$this->getCopyUrl = Yii::app()->baseUrl."/index.php/text/getCopy";
			}
			//*******审核功能
			if($this->hasCheckComp && ($this->checkTextUrl == ''))
			{
				$this->checkTextUrl = Yii::app()->baseUrl."/index.php/text/check";
			}
			
			//构造getTextList后面的参数
			/*
			function <?php echo $id;?>getTextList(c,u,ch,s,n,o)//分重新获取另一个栏目的text与继续获取本栏目的后一些text的情况
			{
	
				var actTextOnly = arguments[6]?arguments[6]:'no';
				var onlyPublic = arguments[7]?arguments[7]:'no';
				var getCopy = arguments[8]?arguments[8]:'no';
			*/
			$a = $this->actTextOnly?"'yes'":"'no'";
			$b = $this->onlyPublic?"'yes'":"'no'";
			$c = $this->getCopy?"'yes'":"'no'";
			$param = ",".$a.",".$b.",".$c;
			//只查看一篇文章
			if($this->getOne == true)
			{
				if($this->oneTextId == "")
				{
					die('error');
				}
				else
				{
					$this->hasComComp = true;
					$this->hasCheckComp = false;
					$this->hasCopyComp = false;
				}
			}
			//*********评论功能
			if($this->hasComComp && ($this->getComUrl == ''))
			{
				$this->getComUrl = Yii::app()->baseUrl."/index.php/comment/get";
			}
			if($this->hasComComp && ($this->comUrl == ''))
			{
				$this->comUrl = Yii::app()->baseUrl."/index.php/comment/add";
			}
			if($this->hasComComp && ($this->deleteComUrl == ''))
			{
				$this->deleteComUrl = Yii::app()->baseUrl."/index.php/comment/delete";
			}
			$this->render('textViewer',array(
				'id' => $this->id,
				'width' => $this->width,
				'showInModal' => $this->showInModal,
				'feedNum' => $this->feedNum,
				'chooseFunc' => $this->chooseFunc,
				'textIdTo' => $this->textIdTo,
				'textTitlePicTo' => $this->textTitlePicTo,
				'textContentTo' => $this->textContentTo,
				'textTitleTo' => $this->textTitleTo,
				'checkIdTo' => $this->checkIdTo,
				'actIdTo' => $this->actIdTo,
				'actTimeTo' => $this->actTimeTo,
				'actLocTo' => $this->actLocTo,
				'actLecturerTo' => $this->actLecturerTo,
				//'onlyPublic' => $this->onlyPublic,
				'param' => $param,
				'textAuthorNameTo' => $this->textAuthorNameTo,
				'textCataNameTo' => $this->textCataNameTo,
				'targetSelector' => $this->targetSelector,
				'instantLoad' => $this->instantLoad,
				'catalogId' => $this->catalogId,
				'userId' => $this->userId,
				'startNum' => $this->startNum,
				'order' => $this->order,
				'checkStatus' => $this->checkStatus,
				'toWhom' => $this->toWhom,
				'isCopyTo' => $this->isCopyTo,
				//'actTextOnly' => $this->actTextOnly,
				'hasCheckComp' => $this->hasCheckComp,
				//'getCopy' => $this->getCopy,
				//'editorConfig' => $this->editorConfig,
				'checkCompParam' => $this->checkCompParam,
				'getTextListUrl' => $this->getTextListUrl,
				'getTextUrl' => $this->getTextUrl,
				'catalogIdContainer' => $this->catalogIdContainer,
				'hasCopyComp' => $this->hasCopyComp,
				'getCataUrl' => $this->getCataUrl,
				'copyUrl' => $this->copyUrl,
				'getCopyUrl' => $this->getCopyUrl,
				'checkTextUrl' => $this->checkTextUrl,
				'hasComComp' => false,//阉割掉所有评论功能
				'getComUrl' => $this->getComUrl,
				'canComT' => $this->canComT,
				'comUrl' => $this->comUrl,
				'deleteComUrl' => $this->deleteComUrl,
				'getOne'=>$this->getOne,
				'oneTextId'=>$this->oneTextId,
				'instantExpandCom' => $this->instantExpandCom,
			));
		}
	}
?>