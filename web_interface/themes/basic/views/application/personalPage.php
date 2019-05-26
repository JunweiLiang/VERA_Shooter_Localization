<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<style type='text/css'>
	#pHomeDiv{padding:10px;}
	
	
</style>
<div id="pHomeDiv">
	
		<div class='profile stuff'>
			<?php 
				$this->widget('ProfileManagerWidget',array(
					'userId' => $id,
				//	'showNickName' => true,
				//	'showIntro' => true,
				));
			?>
		</div>

</div>

