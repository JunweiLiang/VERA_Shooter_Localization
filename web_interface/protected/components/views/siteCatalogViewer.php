<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<style type='text/css'>
	<?php if(!$hasChooseFunc){ ?>
	<?php /*二级页面中的栏目导航器*/ ?>
	#<?php echo $id;?>{background-color:white}
	#<?php echo $id;?> > div.header{
		padding:10px;
		text-align:center;
		font-size:14px;
		font-weight:bold;
		background-color:<?php echo COLOR1;?>;
		color:white;
	}
	#<?php echo $id;?> > ul {padding:0px 0;}
	#<?php echo $id;?> > ul > li > a{	
		padding:15px 20px;
		margin:0;
		color:black;
		background-color:<?php echo COLORDARK;?>;
		font-size:16px;
		border-bottom:1px silver solid;
	}
	#<?php echo $id;?> > ul > li > a:hover{
		background-color:rgb(242,242,242);
	}
	#<?php echo $id;?> > ul > li.active > a{color:<?php echo COLOR1;?>;background-color:white}
	<?php }else{ ?>
	<?php /*配合textFeed的栏目选择器*/ ?>
	#<?php echo $id;?>{width:<?php echo $width;?>;background-color:rgb(180,22,9);height:30px;padding:5px}
	#<?php echo $id;?> > div.catalogDiv{text-align:right;float:right;width:160px;}
	#<?php echo $id;?> > div.catalogDiv > div.btn{position:relative}
	#<?php echo $id;?> > div.catalogDiv ul.dropdown-menu{position:absolute;top:25px;left:0}
	#<?php echo $id;?> > div.catalogDiv ul.dropdown-menu > li > a:hover{background-image:none;background-color:rgb(140,0,0)}
	<?php } ?>
</style>
<script type='text/javascript'>
	$(document).ready(function(){
		<?php if(!$hasChooseFunc){ ?>
		$("#<?php echo $id;?> > ul > li > a").each(function(){
			if($(this).attr('id') == <?php echo $thisCatalogId;?>)
			{
				$(this).parent('li').addClass('active');
				return false;
			}
		});
		<?php } ?>
	});
</script>
<?php if(!$hasChooseFunc){ ?>
<div id='<?php echo $id;?>'>
	<div class="header">中国大学生计算机设计大赛</div>
	<ul class="nav nav-list">
		<?php 
			foreach($cataArr as $oneCata)
			{
				echo '<li><a id="'.$oneCata['catalogId'].'" href="'.Yii::app()->baseUrl.'/index.php/site/view?id='.$oneCata['catalogId'].'">'.$oneCata['catalogTitle'].'</a></li>';
			}
		?>
	</ul>
</div>
<?php }else{ ?>
<script type='text/javascript'>
	$(document).delegate("#<?php echo $id?> > div.catalogDiv > div.btn","mouseenter",function(){
	//alert('hi');
		$(this).children('ul').show();
	});
	$(document).delegate("#<?php echo $id?> > div.catalogDiv > div.btn","mouseleave",function(){
		$(this).children('ul').hide();
	});
	//定义选择栏目后动作
	$(document).delegate("#<?php echo $id;?> > div.catalogDiv ul.dropdown-menu > li > a",'click',function(e){
		e.preventDefault();
		$(this).parent().parent().hide();
		//添名字
		$(this).parent().parent().parent('div.btn').children('span.text').html($(this).html());
		$(<?php echo $targetSelector;?>).val($(this).attr('id'));
		$(<?php echo $targetSelector;?>).change();
	});
</script>
<div id='<?php echo $id;?>'>
	<div class='catalogDiv'>
		<div class="btn btn-danger"><span class='text'>所有栏目</span>
			<span class="caret"></span>
			<ul class="dropdown-menu">
				<li><a id='0' href='#'>所有栏目</a></li>
    			<?php 
					foreach($cataArr as $oneCata)
					{
					echo '<li><a id="'.$oneCata['catalogId'].'" href="#">'.$oneCata['catalogTitle'].'</a></li>';
					}
				?>
  			</ul>
		</div> 					
	</div>
</div>
<?php } ?>