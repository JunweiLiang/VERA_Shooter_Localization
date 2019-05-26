<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<style type='text/css'>
	#<?php echo $id;?>{
		background-color:<?php echo $backgroundColor;?>;border:1px solid #F5D8DB;
		border-radius:2px;
		width:20px;
		position:fixed;
		bottom:<?php echo $toBottom;?>;
		left:50%;
		margin-left:<?php echo $toPageCenter;?>;
		display:none;
		text-decoration:none;
		cursor:pointer;
	}
	#<?php echo $id;?>:hover{background-color:white}
	#<?php echo $id;?> > div.text{
			line-height:13px;font-size:13px;width:12px;padding:5px 4px;
			color:gray;
	}
</style>
<script type='text/javascript'>
$(document).ready(function(){
	$(window).bind('scroll',function(){
		//alert('wd');
		if(($(this).scrollTop() >= <?php echo $activeScrollTop;?>) <?php if($disactiveScrollBottom !== "0"){ ?>
			&& ($(this).height() + $(this).scrollTop() <= $(document).height() - <?php echo $disactiveScrollBottom;?>)
		<?php } ?>)
		{
			$("#<?php echo $id;?>").css('display','block');
		}
		else
		{
			$("#<?php echo $id;?>").css('display','none');
		}
	});
});
$(document).delegate("#<?php echo $id?>",'click',function(e){
	<?php if($useJs){ ?>
		e.preventDefault();
		<?php if($useAnimation){ ?>
			var pixPerTMilSec = ($(window).scrollTop()/<?php echo $toTopTime;?>)*10;
			//alert(pixPerMilSec);
			moveOnePixUpUntilTop($(window).scrollTop(),pixPerTMilSec);
		<?php } else { ?>
			$(window).scrollTop(0);
		<?php } ?>
	<?php } ?>
	//alert('h');
});
function moveOnePixUpUntilTop(startPlace,pixPerTMilSec)
{
	if($(window).scrollTop() != 0)
	{
		setTimeout(function(){
			$(window).scrollTop(startPlace-pixPerTMilSec);
			moveOnePixUpUntilTop(startPlace-pixPerTMilSec,pixPerTMilSec);
		},10);
	}
}
</script>
<a id="<?php echo $id;?>" href="#<?php echo $bodyId;?>">
	<div class='text'>
		<i class='icon-chevron-up'></i>
		返回顶部
	</div>
</a>