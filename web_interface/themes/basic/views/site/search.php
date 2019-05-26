<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<style type="text/css">
	#search{margin:0 auto;width:980px}
	#search > div.searchDiv{padding:40px 0}
</style>
<div id='search'>
	<div class="searchDiv">
	<?php
		$this->widget('SearchWidget',array(
			'width' => "500px",
			'w' => $w,
			'id' => 'searchPageSearch',
			'returnResult' => true,
		));
	?>
	</div>
</div>