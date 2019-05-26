<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<?php
	class ScrollToTopWidget extends CWidget
	{
		//“返回顶部”按钮，接受参数背景颜色，,使用icon-arrow-up,字体大小12px，竖排,宽20，有边框
		//前提：使用锚点控制时，给所有body 加上 id="bodyTop"!!
		//根据页面宽度，取其一半的margin-left,然后position fixed,bottom 100px,left:50%;
		public $id = "scrollToTop";
		public $bodyId = "bodyTop";
		public $backgroundColor = "rgb(243,243,241)";
		public $toPageCenter = "490px";//元素离页面中心的距离（在右边）
		//下面都是 <= >=来比较
		public $activeScrollTop = "400";//滚动条滚过高度以触发显示,$(document).scrollTop();返回数字
		public $disactiveScrollBottom = "0";//离底部多少时隐藏
		//
		public $toBottom = "230px";//离window bottom的距离
		//使用锚点控制还是用js
		//锚点:简单，速度，但是会在地址栏加上#
		//js
		public $useJs = true;
		public $useAnimation = true;
		public $toTopTime = '';//动画回到顶部的时间，毫秒单位
		public function run()
		{
			if($this->useJs && $this->useAnimation && ($this->toTopTime == ''))
			{
				$this->toTopTime = 100;//这个时间不够精确，不知道为什么
			}
			$this->render('scrollToTop',array(
				'id' => $this->id,
				'bodyId' => $this->bodyId,
				'backgroundColor' => $this->backgroundColor,
				'toPageCenter' => $this->toPageCenter,
				'activeScrollTop' => $this->activeScrollTop,
				'disactiveScrollBottom' => $this->disactiveScrollBottom,
				'toBottom' => $this->toBottom,
				'useJs' => $this->useJs,
				'useAnimation' => $this->useAnimation,
				'toTopTime' => $this->toTopTime,
			));
		}	
	}
?>