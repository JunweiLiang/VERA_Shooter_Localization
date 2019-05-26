<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	//此类封装phpmailer,并且从数据库中获取 host的地址等
	//需要Yii的支持，这个类不能单独运行
	//重置密码的算法直接写在这里,需要保密
	class Mailer
	{
		private $email;//构造时必须设置的,收件人地址
		
		private $hostAddr = "smtp.qq.com";
		private $username = "2546858999@qq.com";
		private $password = "megustas0905";
		private $name =  "计算机大赛";//在接收者显示的名字
		
		public $error = "";//记录错误信息
		
		function __construct($email)
		{
			if(is_string($email))
			{
				$this->email = $email;
				//到数据库中获取host
			//	try{
				$Setup = Setup::getSetup();
				isset($Setup['smtpHost'])?$this->hostAddr=$Setup['smtpHost']:0;
				isset($Setup['smtpUsername'])?$this->username=$Setup['smtpUsername']:0;
				isset($Setup['smtpPassword'])?$this->password=$Setup['smtpPassword']:0;
				require("phpMailer/class.phpmailer.php");
			//	}catch(Exception $e)
			//	{
			//		die($e->getMessage());
			//	}
			}
		}
		public function sendPwReset($username)
		{
			//根据email与username发送密码重置邮件，成功返回true,错误返回false,错误信息记录在error中
		
			$mail = new PHPMailer(); //建立邮件发送类
			$mail->IsSMTP(); // 使用SMTP方式发送
			$mail->Host = $this->hostAddr; // 您的企业邮局域名
 
			$mail->SMTPAuth = true; // 启用SMTP验证功能
			$mail->Username = $this->username; // 邮局用户名(请填写完整的email地址)
			$mail->Password = $this->password; // 邮局密码
			$mail->Port=25;
			//$mail->SMTPSecure = "ssl";
			//$mail->Port = 465;
			$mail->From = $this->username; //邮件发送者email地址
			$mail->FromName = $this->name;
			$mail->AddAddress($this->email, "");
			//$mail->AddReplyTo("", "");

			//$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
			$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式

			$mail->Subject = "全国计算机大赛密码重置"; //邮件标题
			//密码重置算法： hash = md5($username."ChunWaiLeong")
			$hash =  md5($username."ChunWaiLeong");
			//对username进行urlencode(中文登录名情况)
			$mail->Body = "<div>你好，正在为用户名:".$username." 重置密码。点击下方链接以完成密码重置，新密码为'123456'</div>".
			"<a href='http://2014.jsjds.org/index.php/site/resetPw?username=".urlencode($username)."&hash=".$hash."'>点我完成密码重置</a>".
			"<div>若非本人操作，请忽略。</div>"; //邮件内容
			$mail->AltBody = ""; //附加信息，可以省略

			if(!$mail->Send())
			{
				$this->error = $mail->ErrorInfo;
				return false;
			}
			else
			{
				return true;
			}
		}
	}
?>