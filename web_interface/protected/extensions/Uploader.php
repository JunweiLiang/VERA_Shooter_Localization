<?php
    /*
    	author Chun Wai Leong
    	20141009
    	上传文件处理类，使用Yii的CUploadedFile类,以及自己的session
    	
    */
    class Uploader
    {
    	private $types = array();//允许的文件种类
    	private $maxSize = 0;//允许的文件大小
    	public static function init($data)
    	{
    		return new Uploader($data);
    	}
    	function __construct($data)
    	{
    		//允许的文件种类数组
    		isset($data['types'])?($this->types=split(",",$data['types'])):0;
    		//文件最大大小 
    		isset($data['maxSize'])?((int)$this->maxSize=$data['maxSize']):0;
    	}
    	//根据当前约束进行处理一个上传文件,返回状态码以及该文件的url与realpath
    	/*
    		每个文件名返回一份信息
    		'inputFileName' => "url","realpath","status",
    		
    		"status": 
    			正数参考php upload 错误，
    			负数： 
    				－1，文件种类不对；
    				－2，文件大小大于最大限制
    				－3，文件转存错误
    		
    	*/
    	public function process($inputFileName,$saveTo="")
    	{
    		Yii::import("application.extensions.f");
    		if(empty($saveTo))
    		{
    			//saveTo在这里使用相对路径
    			$saveTo = "assets/uploadFiles/".md5(Yii::app()->session['userId']."ChunWaiLeong");
    		}
    		//相对路径以url入口为基准，即以index.php 所在为基准,在页面中上诉url可以直接使用访问
    		$data = array(
    			"{$inputFileName}" => array(
    				"status" => 0,
    			),
    		);
    		$File = CUploadedFile::getInstanceByName($inputFileName);
			//进行检查
			$proceed = true;
			//其他错误
			if($File->hasError)
			{
				$data[$inputFileName]['status'] = $File->getError();
				$proceed = false;
				return $data;
			}
			if(!in_array($File->extensionName,$this->types))
			{
				$data[$inputFileName]['status'] = -1;
				$proceed = false;
				return $data;
			}
			if($File->size > $this->maxSize)
			{
				$data[$inputFileName]['status'] = -2;
				$proceed = false;
				return $data;
			}
			
			if($proceed)
			{
				//转存文件
				//检查文件夹是否存在，不存在就新建
				if(!file_exists($saveTo))
				{
					mkdir($saveTo, 0777, True);
				}
				//相对路径的转存
				//$newFile = $saveTo."/".$File->name;//现在保存为原来的名字(包括了后缀)
				//$percentage_change = array('%'=>'%25');
				//url中不能直接有%号，要用%25表示%//错误，如果箱这个url能直接访问的话，url中不能有这些东西
				//$newFile = $saveTo."/".strtr(urlencode($File->name),$percentage_change);
				$extend = explode ( "." , $File->name ); 
				$va = count ( $extend )-1; 
				$extensions = $extend [ $va ];
				//去除空格等
				//$preprocess = array(
				//	'%'=>'',
				//	' '=>'',
				//);
				//$name = strtr($File->name,$preprocess);
				// remove all white space in filename
				$name = preg_replace('/[\s%\/]+/','',$File->name);

				if (preg_match("/[\x7f-\xff]/", $File->name)){
					$newFile = $saveTo."/".time().".".$extensions;
				}
				else
				{
					$newFile = $saveTo."/".$name;
				}
				$data[$inputFileName]['filename'] = urlencode($name);
				if($File->saveAs($newFile,true))//转存同时删除 
				{
					$data[$inputFileName]['status'] = 0;
				}
				else
				{
					$data[$inputFileName]['status'] = -3;
				}
				
				$realpath = realpath($newFile);		
				//$newFile是相对路径的(与index.php同谬)
				$data[$inputFileName]['url'] = Yii::app()->baseUrl."/".$newFile;
				$data[$inputFileName]['realpath'] = $realpath;					
			}
			return $data;
    	}
    	public function processMulti($inputFileName,$saveTo="")
    	{
    		if(empty($saveTo))
    		{
    			//saveTo在这里使用相对路径
    			$saveTo = "assets/uploadFiles/".md5(Yii::app()->session['userId']."ChunWaiLeong");
    		}
    		//相对路径以url入口为基准，即以index.php 所在为基准,在页面中上诉url可以直接使用访问
    		$data = array(
    			"{$inputFileName}" => array(
    				"status" => 0,
    				'files' => array(),
    			),
    		);
    		$Files = CUploadedFile::getInstancesByName($inputFileName);
			//进行检查
			$proceed = true;
			foreach($Files as $File)
			{
				//其他错误
				if($File->hasError)
				{
					$data[$inputFileName]['status'] = $File->getError();
					$proceed = false;
					return $data;
				}
				if(!in_array($File->extensionName,$this->types))
				{
					$data[$inputFileName]['status'] = -1;
					$proceed = false;
					return $data;
				}
				if($File->size > $this->maxSize)
				{
					$data[$inputFileName]['status'] = -2;
					$proceed = false;
					return $data;
				}
			}
			
			if($proceed)
			{
				//转存文件
				//检查文件夹是否存在，不存在就新建
				if(!file_exists($saveTo))
				{
					mkdir($saveTo, 0777, True);
				}

				foreach($Files as $File)
				{
					$temp = array();
					//相对路径的转存
					//$newFile = $saveTo."/".$File->name;//现在保存为原来的名字(包括了后缀)
					//$percentage_change = array('%'=>'%25');
					//url中不能直接有%号，要用%25表示%//错误，如果箱这个url能直接访问的话，url中不能有这些东西
					//$newFile = $saveTo."/".strtr(urlencode($File->name),$percentage_change);
					$extend = explode ( "." , $File->name ); 
					$va = count ( $extend )-1; 
					$extensions = $extend [ $va ];
					//去除空格等
					//$preprocess = array(
					//	'%'=>'',
					//	' '=>'',
					//);
					//$name = strtr($File->name,$preprocess);
					// remove all white space in filename
					$name = preg_replace('/[\s%\/]+/','',$File->name);

					if (preg_match("/[\x7f-\xff]/", $File->name)){
						$newFile = $saveTo."/".time().".".$extensions;
					}
					else
					{
						$newFile = $saveTo."/".$name;
					}
					$temp['filename'] = urlencode($name);
					if($File->saveAs($newFile,true))//转存同时删除 
					{
						$data[$inputFileName]['status'] = 0;
					}
					else
					{
						$data[$inputFileName]['status'] = -3;
					}
					
					$realpath = realpath($newFile);		
					//$newFile是相对路径的(与index.php同谬)
					$temp['url'] = Yii::app()->baseUrl."/".$newFile;
					$temp['realpath'] = $realpath;	
					$data[$inputFileName]['files'][] = $temp;
				}			
			}
			return $data;
    	}
    }
?>