<?php

class UploadController extends Controller
{
	public function actionMulti()
	{
		Yii::import("application.extensions.f");
		//upload multi files
		if(empty($_POST['filename']) || empty($_POST['types']) || empty($_POST['maxSize']) || empty($_POST['varify'])
			|| ($_POST['varify'] != md5($_POST['maxSize'].$_POST['types'].f::get("ppythonMD5key")))
		)
		{
			die("error varification");
		}
		/*
		$filename = $_POST['filename'];
		$Files = CUploadedFile::getInstancesByName($filename);
		print_r($Files);
		
		echo count($Files);
		*/
		
		$filename = $_POST['filename'];//上传时文件的字段名，不是其文件名
		//上传方法，由UploadWidget上传到默认文件夹,
		set_time_limit(30);//30秒 
		//限制类型
		//$types = "png,jpg,gif,doc,docx,pdf,txt";
		$types = $_POST['types'];
		Yii::import("application.extensions.Uploader");
		$uploader = Uploader::init(array(
			"types" => $types,
			"maxSize" => 500*1024*1024,//400M
		));
		$userId = Yii::app()->session['userId'];
		$data = $uploader->processMulti($filename);
		
		//返回的东西
		$result = array(
			"status" => $data[$filename]['status'],
			"files" => array(),
		);
		if($data[$filename]['status'] == 0)
		{
			foreach($data[$filename]['files'] as $file)
			{
				$temp = array();
				$realpath = $file['realpath'];
				//取出realpath,不返回给客户
				$file['realpath'] = "";
				if(($realpath == false) || ($realpath == "") || !file_exists($realpath))
				{
					$data[$filename]['status'] = -4;//realpath 获取错误
				}
				else
				{
					//data 已经有 url,realpath,status字段
					$temp['url'] = $file['url'];
				}
				$temp['status'] = $data[$filename]['status'];
				$result['files'][] = $temp;
			}
		}
		
		echo Text::json_encode_ch($result);
	}
	public function actionIndex()
	{
		Yii::import("application.extensions.f");
		if(empty($_POST['filename']) || empty($_POST['types']) || empty($_POST['maxSize']) || empty($_POST['varify'])
			|| ($_POST['varify'] != md5($_POST['maxSize'].$_POST['types'].f::get("ppythonMD5key")))
		)
		{
			die("");
		}
		$filename = $_POST['filename'];//上传时文件的字段名，不是其文件名
		//上传方法，由UploadWidget上传到默认文件夹,
		set_time_limit(30);//30秒 
		//限制类型
		//$types = "png,jpg,gif,doc,docx,pdf,txt";
		$types = $_POST['types'];
		Yii::import("application.extensions.Uploader");
		$uploader = Uploader::init(array(
			"types" => $types,
			"maxSize" => 500*1024*1024,//400M
		));
		$userId = Yii::app()->session['userId'];
		$data = $uploader->process($filename);
		
		//返回的东西
		$result = array(
			"status" => $data[$filename]['status'],
		);
		if($data[$filename]['status'] == 0)
		{
			
			$realpath = $data[$filename]['realpath'];
			//取出realpath,不返回给客户
			$data[$filename]['realpath'] = "";
			if(($realpath == false) || ($realpath == "") || !file_exists($realpath))
			{
				$data[$filename]['status'] = -4;//realpath 获取错误
			}
			else
			{
				//data 已经有 url,realpath,status字段
				$result['url'] = $data[$filename]['url'];
			}
			$result['status'] = $data[$filename]['status'];
		}
		
		echo Text::json_encode_ch($result);
	}
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
		
			//所有上传都要登录了才行
			array(
				'application.filters.AccessControlFilter',
			),
		);
	}
}