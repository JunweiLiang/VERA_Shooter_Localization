<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<style type="text/css">
	#<?php echo $id?>{
		height:100%;
		width:100%;
		display:none;
		position:fixed;
		top:0;
		left:0;
		z-index:<?php echo $zindex;?>;
		<?php if($transparent){ ?>
			background:transparent;
		<?php }else{ ?>
			background-color:<?php echo COLOR1_DARKER1?>;
		/*	
			opacity:0.7;
			filter:alpha(opacity=70); 
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
			*/
		<?php } ?>
	}
</style>
<script type="text/javascript">
	cw.ech("#<?php echo $id; ?> > input.show",function(){
		$("#<?php echo $id; ?>").show();
	});
	cw.ech("#<?php echo $id; ?> > input.hide",function(){
		$("#<?php echo $id; ?>").hide();
	});
	//点击mask后响应,然后消失
	cw.ec("#<?php echo $id; ?>",function(){
		//alert("a");
		<?php if(is_array($targetSelector)){ ?>
			<?php foreach($targetSelector as $one){ ?>
				$("<?php echo $one;?>").change();
			<?php } ?>
		<?php }else{ ?>
			$("<?php echo $targetSelector;?>").change();
		<?php } ?>
		$("#<?php echo $id; ?>").hide();
	});
</script>
<div id="<?php echo $id?>">
	<input class="show" type="hidden"></input>
	<input class="hide" type="hidden"></input>
</div>