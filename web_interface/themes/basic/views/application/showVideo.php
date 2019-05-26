<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
/* @var $this ClubSiteController */

?>
<style type="text/css">
	#showVideo {padding:30px;}
</style>

<div id="showVideo">
	<?php $this->widget("VideoWidget",array(
		"videopath" => $videopath,
		"id" => $videoname,
		"width" => "600",
	))?>
</div>
