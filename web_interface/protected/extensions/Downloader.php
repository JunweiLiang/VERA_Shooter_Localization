<?php 

	/*
		@author Chun Wai Leong 2014.5
		
		 传入文件绝对路径，以及要显示的文件名字（含后缀），直接下载
		 用于下载用户不能直接获取的文件(deny 的directory)给用户,不会读入到内存
	*/
	class Downloader
	{
		function __construct($file,$filename)//filename包含后缀,file是完整的文件绝对路径
		{
			$this->filename = $filename;
			$this->file = $file;
		}
		private $filename;//显示的下载名字与后缀支持中文
		private $file;//文件绝对路径
		
		//此类直接把内容打印，执行成功会返回true,错误会返回false
		public function run()
		{
			if(!file_exists($this->file) || !is_readable($this->file) || ($this->filename == ""))
			{
				return false;
			}
			
			//防止输出内存缓冲
			if(@ob_get_level()) 
			{
				@ob_end_clean();
			}
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			
			//支持中文名字，通过浏览器判断
			$ua = $_SERVER["HTTP_USER_AGENT"];
			$filename = $this->filename;
			$encoded_filename = urlencode($filename);
			$encoded_filename = str_replace("+", "%20", $encoded_filename);

			if(preg_match("/MSIE/", $ua) || preg_match("/Trident\/7.0/", $ua)){
				header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
			} else if (preg_match("/Firefox/", $ua)) {
				header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
			} else {
				header('Content-Disposition: attachment; filename="' . $filename . '"');
			}
			
			//header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: '.filesize($this->file));
			@ob_clean();
			@flush();
			/*if(readfile($this->file) === false)
			{
				return false;
			}*///这里再return false没有用了
			readfile($this->file);
			return true;
				
		}
	}

?>