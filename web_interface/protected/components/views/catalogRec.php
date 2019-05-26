<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	catalogRec  栏目推荐部件，并排块儿，点击超链接 
	**********/
	/*
		div.line 为每行的容器
		div.block 为每个推荐模块(包括了右侧的padding)，全部使用float:left；块色rgb(220,22,9);块之间间隔15px
		line 最后有clear:both
		block 中结构： 	栏目标题跟栏目简介用absolute 定位(宽度暂时未限定,自行根据是否加图片决定添加的文字多少,让用户自己添加换行，要转化为<br/>),图片靠右充满(固定height,宽度随意)
						鼠标enter后显示蒙板，上面显示更多简介，简介宽度为blockWidth的0.75,自动换行
	*/
?>
<style type="text/css">
	#<?php echo $id;?>{width:<?php echo $width;?>
		margin-bottom:<?php echo $marginBottom;?>;
	}
	#<?php echo $id;?> > div.line{padding:0 0 15px 0}
	#<?php echo $id;?> > div.line >div.clear{clear:both}
	#<?php echo $id;?> > div.line > a{display:block;text-decoration:none;cursor:pointer}
	#<?php echo $id;?> > div.line > a.block{
		height:<?php echo $cHeight;?>;
		width:<?php echo $blockWidth;?>;
		background-color:<?php echo $bgColor;?>;
		margin:0 <?php echo $gapWidth;?> 0 0;
		float:left;
		position:relative;
	}
	#<?php echo $id;?> > div.line > a.last{
		margin:0;
		float:right;
	}
	#<?php echo $id;?> > div.line > a.block > div.catalogTitle{
		font-size:<?php echo $cataT_font_size;?>;
		color:white;
		font-weight:bold;
		position:absolute;
		top:30%;
		left:<?php echo $left;?>;
		background-color:<?php echo $bgColor;?>;
		/*width:<?php echo $blockWidth*0.5."px"?>;*/
	}
	#<?php echo $id;?> > div.line > a.block > div.catalogIntro{
		font-size:<?php echo $cataI_font_size;?>;
		color:white;
		font-weight:bold;
		position:absolute;
		top:45%;
		left:<?php echo $left;?>;
		background-color:<?php echo $bgColor;?>;
		/*width:<?php echo $blockWidth*0.5."px"?>;*/
	}
	#<?php echo $id;?> > div.line > a.block > div.imgDiv{
		float:right;
	}
	#<?php echo $id;?> > div.line > a.block > div.imgDiv > img{
		height:<?php echo $cHeight;?>;
		/*width:150px;*/
	}

/*	
蒙板动画以后再加哈哈哈
#<?php echo $id;?> > div.line > a.block > div.mask{
		width:<?php echo $blockWidth;?>;
		height:<?php echo $cHeight;?>;
		background-color:black;
		opacity:0.<?php echo $maskOpa;?>;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		/*filter:alpha(opacity=<?php echo $maskOpa;?>);   /*IE5、IE5.5、IE6、IE7*/
		/*-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $maskOpa;;?>)"; /*IE8*/
		/*position:absolute;top:0;left:0;z-index:9;
	}
	#<?php echo $id;?> > div.line > a.block > div.mask > div.moreIntro{
		font-size:<?php echo $cataI_font_size;?>;
		color:white;
		font-weight:bold;
		position:absolute;
		top:35%;
		left:<?php echo $left;?>;
		text-align:left;
		width:<?php echo $blockWidth*0.75."px"?>;
	}*/
</style>
<div id="<?php echo $id;?>">
	<?php
		foreach($lineArr as $oneLine)
		{
			echo $oneLine;
		}
	?>
</div>