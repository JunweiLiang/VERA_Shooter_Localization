<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
/* @var $this ClubSiteController */

?>
<style type="text/css">
	#editTextContainer,#textFeedContainer{width:680px;padding:10px;}
	#editTextContainer{text-align:center;border-bottom:1px #F5D8DB solid}
	#editTextContainer #editorDivButton{padding:0 0 10px 0}
	#editTextContainer #editorDiv{padding:10px 0 0 0;border-top:1px #F5D8DB solid;}
</style>
<!--
<div id="editTextContainer">
	
	<div id="editorDivButton">
		<div id="showEditor" class="btn btn-primary" style="width:100px;font-weight:bold">发表文章</div>
		<div id="hideEditor" class="btn btn-primary" style="display:none;width:60px;font-weight:bold"><i class="icon-arrow-up"></i> 收起</div>
	</div>
	<div id="editorDiv" style="display:none">
	<?php
	//此处载入文章编辑器
		//先检查有无发文章权限
		/*
		$res = User::model()->findByPk(Yii::app()->session['userId']);
		if($res['canPostT'] == "0")
		{
			echo "你没有发表文章的权限";
		}
		//载入文章编辑组件
		else
		{
			$userId = Yii::app()->session['userId'];
			
			$this->widget('TextEditorWidget',array(
				'id'=>'editor',
				'hasTextList' => false,
				'editorWidth' => '680px',
				'authorId' => $userId,
				//'editorConfig' => $editorConfig,
				'saveTextUrl' => Yii::app()->baseUrl.'/index.php/text/save',
				'postTextUrl' => Yii::app()->baseUrl.'/index.php/text/post',
				'getCataUrl' => Yii::app()->baseUrl."/index.php/catalog/get",
				'getTextListUrl' => Yii::app()->baseUrl.'/index.php/text/getList',
				'getTextUrl' => Yii::app()->baseUrl.'/index.php/text/get',
				'deleteTextUrl' => Yii::app()->baseUrl.'/index.php/text/delete',
			));
		}	
		*/
	
	?></div>
	
</div>
-->
<script type="text/javascript">
	//定义显示文章编辑器动作
	$(document).delegate("#editTextContainer #showEditor","click",function(){
		$(this).css('display','none');
		$("#editTextContainer #hideEditor").css('display','inline-block');
		$("#editTextContainer #editorDiv").css('display','block');
	});//点击“发表文章”按钮，切换到editorDiv
	$(document).delegate("#editTextContainer #hideEditor","click",function(){
		$(this).css("display","none");
		$("#editTextContainer #showEditor").css("display","inline-block");
		$("#editTextContainer #editorDiv").css('display','none');
	});//点击“收起按钮”
</script>
<div id="textFeedContainer">这里是管理员的首页
<?php
/*
	$this->widget('TextViewerWidget',array(
			'id' => 'cmTextViewer',
			'catalogIdContainer' => 'TVCatalogId',
			'width' => '700px',
			'getTextListUrl' => Yii::app()->baseUrl."/index.php/text/getList",
			'checkStatus' => 5,//获取所有的text
			'instantLoad' => true,
			'hasCheckComp' => false,
			'hasComComp' => true,
		));	
	*/
?>
</div><!--textFeedContainer-->
