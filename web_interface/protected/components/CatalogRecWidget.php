<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<?php 
	//栏目推荐部件
	//并行方块式的推荐，可定义一行多少个div.
	class CatalogRecWidget extends CWidget
	{
		public $id = "catalogRec";
		public $width = "980px";//整个部件的大小,内有10px的padding
		public $lineNum = 3;//一行有多少个推荐
		public $gapWidth = "15px";//块之间的间隔
		public $marginBottom = "0px";//整个部件的下边距
		public $cHeight = "140px";//推荐块儿的高度
		public $catalogArr = array();
		/*public $catalogArr = array(
			array(
				'catalogTitle'=>'高礼新闻',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动1',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'/gaolihome/assets/uploadFiles/images/20130915_181000.jpg',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动2',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动3',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'/gaolihome/assets/uploadFiles/images/20130915_181000.jpg',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动5',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动6',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'/gaolihome/assets/uploadFiles/images/20130915_181000.jpg',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
			array(
				'catalogTitle'=>'高礼活动7',//栏目标题
				'catalogIntro'=>'我是栏目简介哈哈哈',//栏目简介
				'catalogImgLink'=>'/gaolihome/assets/uploadFiles/images/20130915_181000.jpg',//栏目推荐中的图片
				'catalogLink'=>'/gaolihome/index.php/site/view?id=16&checkId=12',//栏目的链接
			),
		);//推荐内容的数组*/
		/*
		形式:array(
			array(
				'catalogTitle'=>,//栏目标题
				'catalogIntro'=>,//栏目简介
				'catalogImgLink'=>,//栏目推荐中的图片
				'catalogLink'=>,//栏目的链接
			),
			array(),
			..
		)
		*/
		//**********下面是部件的css样式
		public $cataT_font_size = "18px";//栏目标题字体大小
		public $cataI_font_size = "14px";//栏目简介字体大小
		public $bgColor = "rgb(220,22,9)";//主体颜色 
		public $left = "13%";//文字与左边的距离
		public $maskOpa = "80";//鼠标放上去产生的蒙板的透明度 0-100越大越不透明//以后才添加
		public function run()
		{
			if(($this->lineNum < 0) || ($this->lineNum > 5))
			{
				die("error,lineNum");
			}
			//**下面根据linNum组装a.block,
			$blockHTMLArr = array();
			for($i=1;$i<=count($this->catalogArr);++$i)
			{
				$imgHTML = "";
				if(isset($this->catalogArr[$i-1]["catalogImgLink"]) && ($this->catalogArr[$i-1]["catalogImgLink"] != ""))
				{
					$imgHTML = 
						'<div class="imgDiv">'.
							'<img src="'.$this->catalogArr[$i-1]["catalogImgLink"].'"></img>'.
						'</div>';
				}
				if(($i % $this->lineNum) === 0)//每行最后一个元素
				{
					$temp = 
					'<a class="block last" href="'.$this->catalogArr[$i-1]['catalogLink'].'">'.
						'<div class="catalogTitle">'.$this->catalogArr[$i-1]['catalogTitle'].'</div>'.
						'<div class="catalogIntro">'.$this->catalogArr[$i-1]['catalogIntro'].'</div>'.
						$imgHTML.
					'</a>';
				}
				else
				{
					$temp = 
					'<a class="block" href="'.$this->catalogArr[$i-1]['catalogLink'].'">'.
						'<div class="catalogTitle">'.$this->catalogArr[$i-1]['catalogTitle'].'</div>'.
						'<div class="catalogIntro">'.$this->catalogArr[$i-1]['catalogIntro'].'</div>'.
						$imgHTML.
					'</a>';
				}
				$blockHTMLArr[] = $temp;
			}
			//组装div.line
			$lineArr = array();
			for($i=1;$i<=count($blockHTMLArr);$i = $i+$this->lineNum)
			{
				$tempLine = 
					'<div class="line">';
				if(count($blockHTMLArr) - $i >= $this->lineNum)
				{
					for($j = 0;$j<$this->lineNum;++$j)
					{
						$tempLine = $tempLine.$blockHTMLArr[$i-1+$j];
					}
				}
				else
				{
					for($j = 0;$j<count($blockHTMLArr) - $i+1;++$j)
					{
						$tempLine = $tempLine.$blockHTMLArr[$i-1+$j];
					}
				}
				$tempLine = $tempLine.
					'<div class="clear"></div>'.
				'</div>';
				$lineArr[] = $tempLine;
			}
			$blockWidth = ($this->width-($this->lineNum-1)*$this->gapWidth)/$this->lineNum."px";
			$this->render("catalogRec",array(
				'id' => $this->id,
				'width' => $this->width,
				'lineNum' => $this->lineNum,
				'blockWidth' => $blockWidth,
				'gapWidth' => $this->gapWidth,
				'cHeight' => $this->cHeight,
				'lineArr' => $lineArr,
				'cataT_font_size' => $this->cataT_font_size,
				'cataI_font_size' => $this->cataI_font_size,
				'bgColor' => $this->bgColor,
				'left' => $this->left,
				'maskOpa' => $this->maskOpa,
				'marginBottom'=> $this->marginBottom,
			));
		}
		
	}
?>