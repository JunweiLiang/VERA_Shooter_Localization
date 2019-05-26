<?php
	/*
		author Chun Wai Leong
		图形验证码类
		给定数字字符串，输出相应数字图形，（外部输出前要调用header("Content-type:image/PNG");）
		Yii::import("application.extensions.Vcode");
		调用: Vcode::init("234")->printCode();//会自动对传入的字符串进行trim处理,去掉空格，\r,\n,\0
		yii 中调用会返回失败//已经解决，config.php有BOM头
	*/
	/*
	//cipher method
	if(isset($_GET['num']) && is_string($_GET['num']))
	{
		$code = Cipher::init(base64_decode($_GET['num']))->decrypt();
		header("Content-type:image/PNG");
		Vcode::init($code)->printCode();
	}*/
	//session method:
	
	//	session_start();
	//	$code = sprintf("%04d",rand(1,9999));
	//	header("Content-type:image/PNG");
	//	Vcode::init($code)->printCode();
	//	$_SESSION['vcode'] = $code;
	
	class Vcode
	{
		private $numArr = array();
		private $width;//图像的宽
		private $height;//高
		public static function init($numStr,$width=44,$height=20)
		{
			return new Vcode($numStr,$width,$height);
		}
		function __construct($numStr,$width=44,$height=20)
		{
			if(is_string($numStr))
			{
				$numStr = trim($numStr);
				for($i = 0;$i<strlen($numStr);++$i)
				{
					$this->numArr[] = intval($numStr[$i]);
				}
				$this->width = $width;
				$this->height = $height;
			}
		}
		public function printCode()
		{
		//	echo "a";
		//	return;
			$im = imagecreate($this->width,$this->height);//初始化
			$back = ImageColorAllocate($im,245,245,245);
			imagefill($im,0,0,$back);
			srand((double)microtime()*1000000);
			for($i=0;$i<count($this->numArr);$i++)//遍历每个数字，填充进去
			{
				$font = ImageColorAllocate($im,rand(100,255),rand(0,100),rand(100,255));
				imagestring($im,5,2+$i*10,1,$this->numArr[$i],$font);
			}
			for($i=0;$i<100;$i++)//添加扰乱
			{
				$randcolor = ImageColorAllocate($im ,rand(0,255),rand(0,255),rand(0,255));
				imagesetpixel($im,rand()%70,rand()%30,$randcolor);
			}
			ImagePNG($im);
			ImageDestroy($im);
		}
	}
	
?>