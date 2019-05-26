<?php
    /*
    	author Chun Wai Leong
    	20140122
    	加密解密类，采用3-DES对称加密,密钥固定
    	yii调用：
		Yii::import("application.extensions.Cipher");
    	$encrypt = Cipher::init("input")->encrypt();
    	echo $encrypt;
    	echo Cipher::init($encrypt)->decrypt();//注意，decrypt会产生多余空格
    */
    class Cipher
    {
    	private $key = "secret_key";//密钥
    	private $input = "";
    	public static function init($input)
    	{
    		return new Cipher($input);
    	}
    	function __construct($input)
    	{
    		$this->input = $input;
    	}
    	public function encrypt()//加密方法
    	{
    		// 打开mcrypt，或者mcrypt类型的资源对象，该对象使用ecb模式，使用3des作为加密算法。
  			$td = mcrypt_module_open('tripledes', '', 'ecb', '');
   			// 创建iv(初始化向量)
   			$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
   			 // 根据密钥和iv初始化$td,完成内存分配等初始化工作
			mcrypt_generic_init($td, $this->key, $iv);
    		// 进行加密
    		$encrypted_data = mcrypt_generic($td, $this->input);
    		// 反初始化$td,释放资源
    		mcrypt_generic_deinit($td);
    		// 关闭资源对象，退出
     		mcrypt_module_close($td);
     		return $encrypted_data;
    	}
    	public function decrypt()//加密方法
    	{
    		// 打开mcrypt，或者mcrypt类型的资源对象，该对象使用ecb模式，使用3des作为加密算法。
  			$td = mcrypt_module_open('tripledes', '', 'ecb', '');
   			// 创建iv(初始化向量)
   			$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
   			 // 根据密钥和iv初始化$td,完成内存分配等初始化工作
			mcrypt_generic_init($td, $this->key, $iv);
    		// 进行加密
    		$decrypted_data = mdecrypt_generic($td, $this->input);
    		// 反初始化$td,释放资源
    		mcrypt_generic_deinit($td);
    		// 关闭资源对象，退出
     		mcrypt_module_close($td);
     		return $decrypted_data;
    	}
    }
?>