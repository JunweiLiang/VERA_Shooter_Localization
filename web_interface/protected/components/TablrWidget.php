<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	/*
		此widget只负责打印html,没有任何动作 
		每个array的name属性是上传后form.serialize的字段名 
		"param" => array(
				array(
					"name" => "userName",
					"title" => "登录名",
				),
				array(
					"name" => "password",
					"title" => "密码",
				),
				array(
					"name" => "password2",
					"title" => "确认密码",
				),
				array(
					..
					"type" => 2,
				),
				array(
					..
					"size" => "large"
				)
				array(
					"tailNotice" => "尾部的通知"//<div right>下的<div class="tailNotice">
				)
			),
		构造html(css,js动作在外部指定):
		text:传入文本直接显示
			array(
					"name" => "schoolType",
					"title" => "选手类别",
					"type" => "text",
					"text" => "直接显示的东西",
			)
			div class='line $name' name="$name"
				div class="left"   title
				div class=right
					text
		input:text
			div class='line $name'
				div class="left"   title
				div class=right
					input class='$name' name='$name'
		
		input:radio	
					array(
						"name" => "schoolType",
						"title" => "选手类别",
						"type" => "radio",
						"param" => array(
							array(
								"title" => "本科",
								"value" => "B",
							),
							array(
								"title" => "高职高专",
								"value" => "Z",
							),
						)//param
					),
				<div class="line $name">
					<div class="left">
					<div class="right">
						<div class="block"><input class="$name" name="$name" radio value></input>$title</div>
		input:checkbox
			array(
				"name" => "",
				"title" => "",----div.left
				"type" => "checkbox",
				param => array(
						array("value"=>1,"title"=>"广东"),
						array("value"=>2,"title"=>"广西"),
				)
			)
			<div class="line $name">
					<div class="left">
					<div class="right">//注意!!input:checkbox中的name加入了中括号[],serialize后返回$_POST['name'] == array([0]=>$val[k],[1]=>$val[s])
						<input class="$name" type="checkbox" name="$name[]" value="$val[0]"></input>$title[0]
						<input class="$name" type="checkbox" name="$name[]" value="$val[1]"></input>$title[1]
		input:checkbox
			array(
					"name" => "workType",
					"title" => "作品种类",
					"type" => "checkbox",
					"param" => array(
						array("value"=>1,"title"=>"**"),
						array("value"=>2,"title"=>"**"),
						..
					),
			)
			<div class="line $name">
					<div class="left">
					<div class="right">
						<div class="checkBlock"><input class="$name" type="checkbox" value="$value"></input>$title</div>
						<div class="checkBlock">..</div>
		input:select
				array(
					"name" => "location",
					"title" => "学校位置",
					"type" => "select",
					"param" => array(
						array("value"=>1,"title"=>"广东"),
						array("value"=>2,"title"=>"广西"),
						..
					),
				)		
				<div class="line $name">
					<div class="left">
					<div class="right">
						<select class='$name'>
							<option value="$value" selected>$title
		img:图片上传  
			<div class="line $name">
					<input hidden class="imgRan name" name="name">
					<div class="left">$title
					<div class="right">
						<div class="ctr">
							<div class="btn imgRan">上传图片</div>
						</div>
						<div class="imgPreview">
							<img class="name imgRan"></img>
						</div>
		ckeditor//同时在js中设置name的ckeditor的全局变量，用于name.setData
			<div class="line $name">
				<div class="left">$title</div>
				<div class="right">
					<textarea id="$name"></textarea>
					$value?
				</div>
		a:超链接，//只用于展示.
			<div class="line $name">
				<div class="left">$title</div>
				<div class="right">
					<a href="$href" target="_blank">$text(为设置就使用href)</a>
				</div>
	*/
	class TablrWidget extends CWidget
	{
		public $param = array();
		
		public $noSelectDefault = false;//select的框不会默认选中第一个;此项为true时，添加一个空项在第一项位置，直接serialize不会有值,只有字段(select name)
		public $editorConfig = array();
		public function run()
		{
			if(is_array($this->editorConfig) && (count($this->editorConfig) == 0))
			{
			$this->editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo','-','SelectAll','RemoveFormat'),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				'/',
				//array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				'/',
				array('Styles','Font','FontSize'),
				array('TextColor','BGColor'),
				
				array('Image','Flash','Link') 
			),
			'width' => '350px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		);
		}//not set editorConfig
			$editorConfigStr = Text::json_encode_ch($this->editorConfig,JSON_UNESCAPED_UNICODE);
			$hasCkeditorJS = false;
			$content = "";
			$hasImgJS = false;//以免重复载入script,但是若在页面中有多个Tablr,则不可避免
			$imgRanTag = "img".rand(1,99999);//由于绑定事件的选择器很浅,用于在绑定js动作时，避免与页面其它冲突
			$imgUploaderUrl = Yii::app()->baseUrl."/index.php/tablr/imgUpload";
			if(is_array($this->param))
			{
				foreach($this->param as $one)
				{
					if(isset($one['name']) && isset($one['title']))
					{
						if(isset($one['type']) && ($one['type'] === "radio") && isset($one['param']) && is_array($one['param']))
						{
							//单选框情况
							
							$tempRadio = "";
							foreach($one['param'] as $oneRadio)
							{
								if(isset($i))
								{
									$tempRadio.='<div class="block">'.
										'<input type="radio" class="'.$one['name'].'" name="'.$one['name'].'" value="'.$oneRadio['value'].'"></input> '.$oneRadio['title'].
									'</div>';
								}else
								{
									$i=1;
									$tempRadio.='<div class="block">'.
										'<input type="radio" class="'.$one['name'].'" name="'.$one['name'].'" value="'.$oneRadio['value'].'" checked></input> '.$oneRadio['title'].
									'</div>';
								}
							}
							$temp = '<div class="line '.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									$tempRadio;
							//	'</div>'.
						//	'</div>';
						}
						else if(isset($one['type']) && ($one['type'] === "select") && isset($one['param']) && is_array($one['param']))
						{
							//select框情况 
							$tempSelect = "";
							foreach($one['param'] as $oneOption)
							{
								if($this->noSelectDefault)
								{
									if(isset($i))
									{
										$tempSelect.='<option value="'.$oneOption['value'].'">'.$oneOption['title'].'</option>';
									}else
									{
										$i=1;
										$tempSelect.='<option></option>';
									}
								}
								else//默认会选中第一个选项
								{
									if(isset($i))
									{
										$tempSelect.='<option value="'.$oneOption['value'].'">'.$oneOption['title'].'</option>';
									}else
									{
										$i=1;
										$tempSelect.='<option value="'.$oneOption['value'].'" selected>'.$oneOption['title'].'</option>';
									}
								}
							}
							//重置i
							unset($i);
							$temp = '<div class="line '.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									'<select class="'.$one['name'].'" name="'.$one['name'].'">'.
										$tempSelect.
									'</select>';
								//'</div>'.
							//'</div>';
						}
						else if(isset($one['type']) && ($one['type'] === "checkbox") && isset($one['param']) && is_array($one['param']))
						{
							//checkbox情况 
							$tempCheckbox = "";
							foreach($one['param'] as $oneCheckBlock)
							{							
								$tempCheckbox.='<div class="checkBlock"><input class="'.$one['name'].'" type="checkbox" value="'.$oneCheckBlock['value'].'"></input>'.$oneCheckBlock['title']."</div>";						
							}
							$temp = '<div class="line '.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
										$tempCheckbox;
								//'</div>'.
							//'</div>';
						}
						else if(isset($one['type']) && ($one['type'] === "checkbox") && isset($one['param']) && is_array($one['param']))
						{
							//checkbox框情况 
							$tempCheckbox = "";
							foreach($one['param'] as $oneCheckbox)
							{
								//die("a");
								//die($oneCheckbox['value']);
								$tempCheckbox.="<input class='".$one['name']."' type='checkbox' name='".$one['name']."[]' value='".$oneCheckbox['value']."'></input>".$oneCheckbox['title'];
							}
							$temp = '<div class="line '.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									$tempCheckbox;
								//'</div>'.
							//'</div>';
						}
						else if(isset($one['type']) && ($one['type'] === "ckeditor"))
						{
							$temp = "";
							if(!$hasCkeditorJS)
							{
								$temp = '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/ckeditor/ckeditor.js"></script>';
								$hasCkeditorJS = true;
							}
							
							$temp .= '<div class="line '.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									'<textarea class="'.$one['name'].'" id="'.$one['name'].'"></textarea>';
							$temp .= "<script type='text/javascript'>".
								"var ".$one['name']." = null;".//初始化装载此ckeditor实例的变量，用于setData
								"$(document).ready(function(){".
									$one['name']." = CKEDITOR.replace('".$one['name']."',".$editorConfigStr.");".
									//以后这里假如 ckeditor[one['name']] = 的形式，保存到一个变量方便获取,此变量初始: ckeditor = {}
									//不需要，可以在外部直接调用 CKEDITOR.instances["name"].getData
									//"CKEDITOR.on('instanceReady', function (e) { alert(e.editor.name+'加载完毕！')});".
								"});".
							"</script>";
							//	'</div>'.
							//'</div>';
							
						}
						else if(isset($one['type']) && ($one['type'] === "text") && isset($one['text']))
						{
							$temp = '<div class="line '.$one['name'].'" name="'.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									$one['text'];
						}
						else if(isset($one['type']) && ($one['type'] === "img"))
						{
							//下面是图片上传的情况，链接保存在div.line > input:hidden class="$name"中
							$temp = "";
							$value = "";
							$buttonStr = "上传图片";
							if(isset($one['value']))
							{
								$value = $one['value'];
							}
							if(isset($one['buttonStr']))
							{
								$buttonStr = $one['buttonStr'];
							}
							if(!$hasImgJS)//先加入js,点击上传图片按钮后,标记本block的img与input,并且修改"上传图片"为“修改图片”
							{
								$tempJS = "<script type='text/javascript'>".
									'$(document).delegate("div.line > div.right > div.ctr > div.'.$imgRanTag.'","click",function(){'.
										'$(this).parent().parent().find("div.imgPreview > img.'.$imgRanTag.'").prop("imgToMe",true);'.
										'$(this).parent().parent().children("input.'.$imgRanTag.'").prop("imgToMe",true);'.
										'$(this).html("修改图片");'.
										'window.open("'.Yii::app()->baseUrl.'/index.php/tablr/imgUpload","_blank");'.
									'});'.
								"</script>";
								$temp .= $tempJS;
								$hasImgJS = true;
							}
							if(isset($one['hideUpload']) && ($one['hideUpload'] === true))//隐藏上传图片按钮,用于纯展示
							{
							$temp .= '<div class="line '.$one['name'].'" name="'.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
								//	'<input type="hidden" name="'.$one['name'].'" class="'.$one['name'].' '.$imgRanTag.'" value="'.$value.'"></input>'.
								//	'<div class="ctr">'.
								//		'<div class="btn btn-small upload '.$imgRanTag.'">'.$buttonStr.'</div>'.
								//	'</div>'.
									'<div class="imgPreview">'.
										'<img class="'.$one['name'].' '.$imgRanTag.'" src="'.$value.'"></img>'.
									'</div>';
							}
							else
							{
							$temp .= '<div class="line '.$one['name'].'" name="'.$one['name'].'">'.
								'<div class="left">'.$one['title'].'</div>'.
								'<div class="right">'.
									'<input type="hidden" name="'.$one['name'].'" class="'.$one['name'].' '.$imgRanTag.'" value="'.$value.'"></input>'.
									'<div class="ctr">'.
										'<div class="btn btn-small upload '.$imgRanTag.'">'.$buttonStr.'</div>'.
									'</div>'.
									'<div class="imgPreview">'.
										'<img class="'.$one['name'].' '.$imgRanTag.'" src="'.$value.'"></img>'.
									'</div>';
							}
							//	"</div>".
							//"</div>";
						}
						else if(isset($one['type']) && ($one['type'] === "textarea"))
						{
							$value = "";
							if(isset($one['value']))
							{
								$value = $one['value'];
							}
							if(isset($one['maxLength']))
							{
								$maxLength = (int)$one['maxLength'];
								$temp = '<div class="line '.$one['name'].'">'.
									'<div class="left">'.$one['title'].'</div>'.
									'<div class="right">'.
										'<textarea maxlength="'.$maxLength.'" onkeyup="this.value = this.value.substring(0,'.$maxLength.')" class="'.$one['name'].'" name="'.$one['name'].'" value="'.$value.'">'.$value.'</textarea>'; 
							}
							else
							{
								$temp = '<div class="line '.$one['name'].'">'.
									'<div class="left">'.$one['title'].'</div>'.
									'<div class="right">'.
										'<textarea class="'.$one['name'].'" name="'.$one['name'].'" value="'.$value.'">'.$value.'</textarea>';
							}
						}
						else if(isset($one['type']) && ($one['type'] === "a"))//超链接情况,仅仅用于展示
						{
							isset($one['href'])?$href=$one['href']:$href="";
							isset($one['text'])?$text=$one['text']:$text=$href;
							$temp = '<div class="line '.$one['name'].'">'.
									'<div class="left">'.$one['title'].'</div>'.
									'<div class="right">'.
										'<a href="'.$href.'" name="'.$one['name'].'" target="_blank">'.$text.'</a>';
						}
						else
						{
							//下面时input:text的情况
							$size = "medium";
							if(isset($one['size']))
							{
								$size = $one['size'];
							}
							$placeholder = "";
							if(isset($one['placeholder']))
							{
								$placeholder = $one['placeholder'];
							}
							$value = "";
							if(isset($one['value']))
							{
								$value = $one['value'];
							}
							if(isset($one['type']) && ($one['type'] === "password"))
							{
								$temp = '<div class="line '.$one['name'].'">'.
									'<div class="left">'.$one['title'].'</div>'.
									'<div class="right">'.
										'<input class="input-'.$size.' '.$one['name'].'" name="'.$one['name'].'" value="'.$value.'" type="password" placeholder="'.$placeholder.'"></input>';
									//'</div>'.
								//'</div>';
							}
							else
							{
								$temp = '<div class="line '.$one['name'].'">'.
									'<div class="left">'.$one['title'].'</div>'.
									'<div class="right">'.
										'<input class="input-'.$size.' '.$one['name'].'" name="'.$one['name'].'" value="'.$value.'" type="text" placeholder="'.$placeholder.'"></input>';
									//'</div>'.
								//'</div>';
							}
						}
						if(isset($one['tailNotice']))
						{
							$temp.='<div class="tailNotice">'.$one['tailNotice'].'</div>';
						}
						$temp.="</div></div>";//for div.right < div.line
						$content.=$temp;
						
					}
				}//foreach
			}//if
			echo $content;
		}
	}
?>
