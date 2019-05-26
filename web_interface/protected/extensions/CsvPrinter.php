<?php 

	/*
		@author Chun Wai Leong 2014.5
		
		可以打印纯文本，也可以完全用于下载（在run函数前不能有任何输出）
		传入大二维数组，直接打印
		可设定分隔符，并且可以定义内容转换器: 
	*/
	class CsvPrinter
	{
		function __construct($content,$filename="csvFile",$download=true,$converter=array(","=>"，","\n" => " "),$blockBreak=",",$lineBreak="\n",$toCh=true)
		{
			$this->content = $content;
			$this->filename = $filename;
			$this->download = $download;
			$this->converter = $converter;
			$this->blockBreak = $blockBreak;
			$this->lineBreak = $lineBreak;
			$this->toCh = $toCh;
		}
		private $content;//大二维数组
		private $filename;//下载时会使用此文件名,会自动加上".csv"后缀
		private $download;//是否用于下载，用于下载会加入http头
		private $converter;// 非空时会对每个元素进行 strtr(*,$converter)//传入空数组就不会转换,
							//			$converter = array(
								//			","=>"，",
											//	'"'=>"“",
											//"\n" => " ",
									//	);
		private $blockBreak;//分隔符
		private $lineBreak;//换行符
		private $toCh;//是否在打印时使用转换:iconv("UTF-8","GB18030//IGNORE",$lineStr);
		
		//此类直接把内容打印，执行成功会返回true,错误会返回false
		public function run()
		{
			//进行基本的参数检查
			if(!is_array($this->content) || !is_array($this->converter))
			{
				return false;
			}
			if($this->download && ($this->filename != ""))
			{
				//支持中文名字，通过浏览器判断
				$ua = $_SERVER["HTTP_USER_AGENT"];
				header("Content-type:text/csv");
				$filename = $this->filename.".csv";
				$encoded_filename = urlencode($filename);
				$encoded_filename = str_replace("+", "%20", $encoded_filename);

				if(preg_match("/MSIE/", $ua) || preg_match("/Trident\/7.0/", $ua)){
					header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
				} else if (preg_match("/Firefox/", $ua)) {
					header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
				} else {
					header('Content-Disposition: attachment; filename="' . $filename . '"');
				}					
			}
			//开始打印正文
			foreach($this->content as $line)
			{
				if(!is_array($line))
				{
					return false;
				}
				$lineStr = "";
				for($i=0;$i<count($line);++$i)
				{
					if($i==count($line)-1)
					{
						$lineStr.=strtr($line[$i],$this->converter).$this->lineBreak;
					}
					else
					{
						$lineStr.=strtr($line[$i],$this->converter).$this->blockBreak;
					}
				}
				//打印一行数据
				if($this->toCh)
				{
					echo iconv("UTF-8","GB18030//IGNORE",$lineStr);
				}
				else
				{
					echo $lineStr;
				}
			}
		}
		
	}

?>