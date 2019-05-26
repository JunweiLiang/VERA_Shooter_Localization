<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
/* @var $this ClubSiteController */

?>
<style type="text/css">
	#superManage > div.block{
		padding:10px;
	}
	
</style>

<script type="text/javascript">
	cw.ec("#superManage > div.block > div.line > div.changeLog",function(){
		//alert("h");
		var data = {};
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/changeLog",data,function(result){
			alert(result);
		},null,function(dump,err){alert(err)},null,"text");
	});
	cw.ec("#superManage > div.block > div.line > div.clean",function(){
		//alert("h");
		var data = {};
		cw.post("<?php echo Yii::app()->baseUrl?>/index.php/super/clean",data,function(result){
			alert(result);
		},null,function(dump,err){alert(err)},null,"text");
	});
</script>
<div id="superManage">
	<div class="block">
		<div class="line">修改日志，添加项目属性</div>
		<div class="line">
			<div class="btn btn-info changeLog">开始</div>
		</div>
	</div>
	<div class="block">
		<div class="line">清空数据库，保留用户信息</div>
		<div class="line">
			<div class="btn btn-info clean">开始</div>
		</div>
	</div>
</div>
