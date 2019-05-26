<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	class DownloadCataBaomingWidget extends CWidget
	{
		public $id = "downloadCataBaoming";
		public function run()
		{
		?>
<script>
	$(document).delegate("#<?php echo $this->id;?> > input.catalogId","change",function(){
	//	alert("a");
		var catalogTitle = $("#<?php echo $this->id;?> > input.catalogTitle").val();
		$("#<?php echo $this->id;?> > a > span.catalogTitle").html(catalogTitle).parent().prop("href","<?php echo Yii::app()->baseUrl;?>/index.php/competitorManage/downloadbaoming?catalogId="+$(this).val());
	});
</script>
<div id="<?php echo $this->id?>">
	<input class="catalogId" type="hidden" value=""></input>
	<input class="catalogTitle" type="hidden"></input>
	<a class="btn btn-info" href="" target="_blank">点击下载<span class="catalogTitle"></span>报名资料</a>
</div>
		<?php
		}
	}
?>