<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php
	//接收width,border,控制条数组，（地址等）,竖版
	$panelHTML="";
	foreach($panelParam as $liItem=>$liParam)
	{
		if($liParam['head'] == true)
		{
			$panelHTML.='<li class="'.$liItem.'"><a class="navHead">'.$liParam['title'].'</a></li>';
		}
		else
		{
			if($liParam['active'] == true)
			{
				$panelHTML.='<li class="'.$liItem.'"><a class="navTitle active" href="'.$liParam['href'].'"><i class="icon-'.$liParam['icon'].'"></i> '.$liParam['title'].'</a></li>';
			}
			else
			{
				$panelHTML.='<li class="'.$liItem.'"><a class="navTitle" href="'.$liParam['href'].'"><i class="icon-'.$liParam['icon'].'"></i> '.$liParam['title'].'</a></li>';
			}
			
		}
	}

?>
<style type="text/css">
#<?php echo $id;?>{background-color:white}
#<?php echo $id;?> li{margin:0;padding:0}/*kill bootstrap*/
#<?php echo $id;?> a{text-decoration:none;/*kill bootstrap*/font-size:13px;display:block}
	#<?php echo $id;?>{
		padding-bottom:50px;
		
	}
	#<?php echo $id;?> a.navHead{width:<?php echo ($width-10).'px'?>;padding:5px;color:gray}
	#<?php echo $id;?> a.navTitle{width:<?php echo ($width-10).'px'?>;padding:5px;color:<?php echo COLOR1_LIGHTER1;?>;background-color:white}
	#<?php echo $id;?> a.active{color:white;background-color:<?php echo COLOR1_LIGHTER1;?>;font-weight:bold}
	#<?php echo $id;?> i{margin-top:2px}
</style>
<script type="text/javascript">
//设置panel动画
	$(document).delegate("#<?php echo $id;?> a.navTitle","mouseenter",function(){
		if(!$(this).hasClass('active'))//非active元素
		{
			$(this).css({"backgroundColor":"silver"});
		}
	});
	$(document).delegate("#<?php echo $id;?> a.navTitle","mouseleave",function(){
		if(!$(this).hasClass('active'))//非active元素
		{
			$(this).css({"backgroundColor":"white"});
		}
	});
</script>
<div id="<?php echo $id;?>">
	<?php echo $panelHTML;?>
	<?php 
		if($showBroadCast){
		//此处再检查一下是否“超级管理员”
			$User = User::model()->findByPk(Yii::app()->session['userId']);
			if($User->isSuper == 1)
			{
				$this->widget('BroadcastWidget',array(
					'canChange' => true,
				));
			}
			else
			{
				$this->widget('BroadcastWidget',array(
				));
			}
		}
	?>
</div>