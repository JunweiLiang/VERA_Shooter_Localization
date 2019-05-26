<?php 
	/*
	@author Chun Wai Leong<2546858999@qq.com>  in 2014
	*/
?>
<?php
	/*
	单文件上传控件
		需要<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.form.js支持

//彩色效果图上传
			function newModelPicsE(str)
			{
				$("#workEdit div.uploadModelPic > span.text-error").html(str);
				setTimeout(function(){
					$("#workEdit div.uploadModelPic > span.text-error").html("");
				},3000);
			}
			function newModelPicsOk(data)
			{
				//保存在空的input中
				var saveName = "";
				$("#workEdit > div.main > div.tougao > div.edits > div.modelPic > input.modelPic").each(function(){
					if($(this).val() == "")
					{
						saveName = $(this).prop("name");
						$(this).val(data.url);
						return false;
					}
				});
				//preview
				$("#workEdit > div.main > div.tougao > div.edits > div.modelPic > img."+saveName).prop("src",data.url);
			}
			// need to set filename

	*/
	class UploadWidget extends CWidget
	{
		public $id = "uploadFile";
		public $uploadTo = "";//上传到...处理的url
		//下面这些预定义的函数必须在此控件前定义
		public $beforeSubmit="";//提交前call的函数名//必须返回true才继续执行
		public $success="";//上传完成并且服务器处理完成后调用的//f返回一个data,data['url'],data['status']
		public $error="";//处理错误的函数
		
		//上传文件的参数
		public $filename;//文件名//必须全页面唯一 
		public $maxSize="1024*1024*2";//2MB
		public $types="png,jpg,gif";
		
		//button的 css class
		public $buttonClasses = "btn btn-primary";
		public $buttonName = "点击上传";
		//是否显示进度条
		public $showProgress = true;//即使显示，也只会在上传时显示
			//html after the button
		public $htmlBeforeButton = "";
		//html before the button
		public $htmlAfterButton = "";
		public function run()
		{
			if($this->uploadTo == "")
			{
				$this->uploadTo = Yii::app()->baseUrl."/index.php/upload";
			}
			//验证，确保maxSize与types与设置是一致的
			Yii::import("application.extensions.f");
			$varify = md5($this->maxSize.$this->types.f::get("ppythonMD5key"));
			$this->render('upload',array(
				"id" => $this->id,
				"uploadTo" => $this->uploadTo,
				"beforeSubmit" => $this->beforeSubmit,
				"success" => $this->success,
				"error" => $this->error,
				
				"filename" => $this->filename,
				"maxSize" => $this->maxSize,
				"types" => $this->types,
				
				"buttonClasses" => $this->buttonClasses,
				"buttonName" => $this->buttonName,
				
				"showProgress" => $this->showProgress,
				"varify" => $varify,
				
				"htmlBeforeButton" => $this->htmlBeforeButton,
				"htmlAfterButton" => $this->htmlAfterButton,
			));
		}
	}
	
?>