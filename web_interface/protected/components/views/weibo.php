<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>;height:<?php echo $height;?>;background-color:white}
	#<?php echo $id;?> > div.title{padding:5px}
	#<?php echo $id;?> > div.title > div.titleText{border-bottom:1px solid red;padding-left:10px;color:rgb(140,0,0);font-size:16px}
</style>
<div id='<?php echo $id;?>'>
	<div class='title'><div class='titleText'>微博</div></div>
	<div class='weiboDiv'>
		<?php echo $weiboStr;?>
	</div>
</div>