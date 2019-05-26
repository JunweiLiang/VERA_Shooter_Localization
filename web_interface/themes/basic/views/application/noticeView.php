<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	div.mainx > div.block{
		padding:10px;
	}
	div.mainx > div.block > div.title{
		text-align:center;
		color:blue;
		padding:10px 0;
		border-bottom:1px solid silver;
	}
	div.mainx > div.block > div.content{
		padding-top:10px;
	}
</style>
<div class="mainx">
	<?php foreach($arr as $one){ ?>
		<div class="block">
			<div class="title">
				<?php echo $one['noticeIntro']?>
				<a class="btn btn-small btn-info" target="_self" href="<?php echo Yii::app()->baseUrl?>/index.php/application/notice?noticeId=<?php echo $one['noticeId']?>">edit</a>
			</div>
			<div class="content"><?php echo $one['content']?></div>
		</div>
	<?php } ?>
</div>