<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<?php

/**
 * This is the model class for table "T_text".
 *
 * The followings are the available columns in table 'T_text':
 * @property string $textId
 * @property string $title
 * @property string $subTitle
 * @property string $catalogId
 * @property string $titlePicAddr
 * @property string $textIntro
 * @property string $authorId
 * @property string $src
 * @property string $content
 * @property string $keyWord
 * @property string $isActText
 * @property string $editTime
 * @property string $editId
 * @property string $isLocked
 */
class Text extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Text the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'T_text';
	}
	public static function getRequest()
	{
		// get the current requested url, controllerName/actionName and params
		$uri = Yii::app()->request->requestUri;
		// replace the baseUrl and index.php
		$baseUrl = Yii::app()->baseUrl;
		$uri = str_replace($baseUrl,"",$uri);
		$uri = str_replace("index.php","",$uri);
		$uri = trim($uri,"/");
		return $uri;
	}
	//delete a path
	public static function deletePath($dir)
	{
		$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($it,
		             RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files as $file) {
		    if ($file->isDir()){
		        rmdir($file->getRealPath());
		    } else {
		        unlink($file->getRealPath());
		    }
		}
		rmdir($dir);
	}
	public static function readFilelst($abspath)
	{
		//given a local absolute path to a file lst, read it and return array
		$filelst = array();
		$handle = fopen($abspath, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        // process the line read.
		        $filelst[] = trim($line);
		    }

		    fclose($handle);
		} else {
		    // error opening the file.
		} 
		return $filelst;
	}
	//判断值是否等于$val或者checkVal是数组而且包含val,等就打印"checked"
	public static function checked($checkVal,$val,$strict=false)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo "checked='checked'";
			}
		}
		else
		{
			if(!$strict)
			{
				if($checkVal == $val)
				{
					echo "checked='checked'";
				}
			}
			else
			{
				if($checkVal === $val)
				{
					echo "checked='checked'";
				}

			}
		}
	}
	//获取时间
	public static function within2time($withinTimeId)
	{
		/*
			('withinTime', 1, '一周内', 0, 1),
			('withinTime', 2, '一个月内', 0, 2),
			('withinTime', 3, '两个月内', 0, 3)
		*/
		//返回最早的时间字符串
		switch($withinTimeId)
		{
			case 1:
				return date("Y-m-d H:i:s",time()-60*60*24*7);
			case 2:
				return date("Y-m-d H:i:s",time()-60*60*24*30);
			default:
				return date("Y-m-d H:i:s",time()-60*60*24*60);
		}
	}
	// give double seconds, return the time format string
	public static function sec2time($secs)
	{
		$secs = (int)$secs;
		return date("H:i:s",$secs-60*60);
	}
	//判断值是否等于$val或者checkVal是数组而且包含val,等就打印"selected"
	public static function selected($checkVal,$val,$strict=false)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo "selected='selected'";
			}
		}
		else
		{
			if(!$strict)
			{
				if($checkVal == $val)
				{
					echo "selected='selected'";
				}
			}
			else
			{
				if($checkVal === $val)
				{
					echo "selected='selected'";
				}

			}
		}
	}
	public static function hide($checkVal,$val)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo "style='display:none'";
			}
		}
		else
		{
			if($checkVal == $val)
			{
				echo  "style='display:none'";
			}
		}
	}
	public static function disabled($checkVal,$val)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo "disabled";
			}
		}
		else
		{
			if($checkVal == $val)
			{
				echo "disabled";
			}
		}
	}
	public static function printStr($checkVal,$val,$str)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo $str;
			}
		}
		else
		{
			if($checkVal == $val)
			{
				echo $str;
			}
		}
	}
	
	//年龄，获取到生日日期 
	public static function age2birth($age)
	{
		$age = (int)trim($age);
		return date("Y-m-d",time()-$age*60*60*24*365);
	}
	public static function active($checkVal,$val)
	{
		if(is_array($checkVal))
		{
			if(in_array($val,$checkVal))
			{
				echo "active";
			}
		}
		else
		{
			if($checkVal == $val)
			{
				echo "active";
			}
		}
	}
	//传入参数的值跟数组对应的字段名字相等就返回其值，否则空
	public static function val2str($val,$arr)
	{
		if(isset($arr[$val]))
		{
			return $arr[$val];
		}
		else
		{
			return "";
		}
	}
	//执行sql,arr为":a"=>$a的数组
	public static function sql($sql,$intArr=array(),$strArr=array(),$query=true)
	{
		$db = Yii::app()->db;
		$command = $db->createCommand($sql);
		foreach($intArr as $mark=>$val)
		{
			//foreach中不能用bindParam!
			$command->bindValue($mark,$val,PDO::PARAM_INT);
		}
		foreach($strArr as $mark=>$val)
		{
			$command->bindValue($mark,$val,PDO::PARAM_STR);
		}
		if($query)
		{
			return $command->queryAll();
		}
		else
		{
			return $command->execute();
		}
	}
	//获取过去的日子，返回一个数组，每个"Y-m-d"格式
	public static function getDays($startDate=NULL,$endDate=NULL)
	{
		if($startDate == "")
		{
			$startDate = date("Y-m-d",time()-60*60*24*10);//默认10天前
		}
		if($endDate == "")
		{
			$endDate = date("Y-m-d",time());
		}
		//计算两个Date相差多少天
		$d1=strtotime($startDate);
		$d2=strtotime($endDate);
		$Days=round(($d2-$d1)/3600/24);
		$res = array();
		for($i=0;$i<=$Days;++$i)
		{
			$res[] = date("Y-m-d",strtotime("-".$i." day",$d2));
		}
		return $res;
	}
	//检查$arr 中每个数组中的paramName字段的值是否为$val
	public static function inArr($val,$paramName,$arr)
	{
		$in = false;
		foreach($arr as $one)
		{
			if(isset($one[$paramName]))
			{
				if($one[$paramName] == $val)
				{
					$in = true;
					break;
				}
			}
		}
		return $in;
	}
	//接收要求的页面序号，以一页为10个条目，返回转换到的 n,m 字符串
	public static function page2limit($page,$perPage=10)
	{
		//$perPage = 10;//一个页面10个条目
		$a = $perPage*($page-1);
		$b = $perPage;
		return "$a,$b";
	}
	//传入不定个参数,从头开始，不空就返回
	public static function getStr()
	{
	/*
		$numargs = func_num_args();  
		echo "参数个数: $numargs\n";  
		$args = func_get_args();//获得传入的所有参数的数组 
	*/
		$args = func_get_args();
		foreach($args as $one)
		{
			if($one != "")
			{
				return $one;
			}
		}
		return "";
	}
	//根据config,返回一个ckeditor 控件的html代码,name是字段名称，必须在全页面唯一,外面可以用CKEDITOR.instances["name"].getData或者setData
	public static function ckeditor($name,$width="350px")
	{
		$editorConfig = array(
			'font_names'=>'宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Arial;Georgia;Times New Roman;Verdanna',
			'toolbar'=>array(
				//['Source','-','Save','NewPage','Preview','-','Templates'],//ie下Preview有bug,禁用
				//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				//array('Cut','Copy','Paste','PasteText','PasteFromWord'),
				array('Undo','Redo',/*'-','SelectAll','RemoveFormat'*/),
				//['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
				//'/',
				//array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
				//['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
				//['Link','Unlink','Anchor'],
				//'/',
				array(/*'Styles',*/'Font','FontSize'),
				array('TextColor','BGColor'),
				
				array('Image','Flash','Link') 
			),
			'width' => $width,
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		);
		$editorConfigStr = Text::json_encode_ch($editorConfig);
		$temp = "";
		//载入 ckeditor的js
		$temp = '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/ckeditor/ckeditor.js"></script>';
		//载入html
		$temp .= '<textarea class="'.$name.'" id="'.$name.'"></textarea>';
		//载入所需的页面执行代码
		$temp .= "<script type='text/javascript'>".
			"var ".$name." = null;".//初始化装载此ckeditor实例的变量，用于setData
			"$(document).ready(function(){".
				$name." = CKEDITOR.replace('".$name."',".$editorConfigStr.");".
				//可以在外部直接调用 CKEDITOR.instances["name"].getData
				//"CKEDITOR.on('instanceReady', function (e) { alert(e.editor.name+'加载完毕！')});".
			"});".
		"</script>";
		return $temp;
	}
	//对输入进行文本替换，把<>换成&lt;&gt;
	public static function replaceHtml(&$str)
	{
		if(is_string($str))
		{
			$search = array(
				"<",
				">",
				//"&",
			);
			$replace = array(
				"&#60;",
				"&#62;",
				//"&#38;",
			);
			$str = str_replace($search,$replace,$str);
		}
	}
	public static function process($str)
	{
		//把str中的双引号、换行符号等转换，让其可以在html 中直接 value="$str"
		$process = array(
			'"'=>'\"',
			'\n'=>'',
			'\r'=>'',
			PHP_EOL => '',
		);
		return strtr($str,$process);
	}
	public static function json_encode_ch($data) {
		//假定所有的键名都没有中文
		if(!function_exists("ch_urlencode"))
		{
		//把数组内所有东西urlencode ,然后json_encode,再urldecode
			function ch_urlencode(&$data) {
				foreach($data as $k => $val)
				{
					if(is_array($val))
					{
						ch_urlencode($data[$k]);
					}
					else
					{
							//先给内容中的双引号添加转义字符,转义字符前加转义字符
						$data[$k] = urlencode(addcslashes($val,"\v\t\n\r\f\"\\/"));
						//注意5.2.5以前没有\v\f
					}
				}
			}
		}
		
		if(phpversion() < '5.4.0')
		{
			ch_urlencode($data);
			return urldecode(json_encode($data));
		}
		else
		{
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
//$str = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", Text::json_encode_ch($data));
//return $str;
}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('textId, title, catalogId, authorId, content, editTime', 'required'),
			array('textId, catalogId, authorId', 'length', 'max'=>8),
			array('title, titlePicAddr, src, keyWord', 'length', 'max'=>255),
			array('subTitle, textIntro', 'length', 'max'=>512),
			array('isActText, isLocked', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('textId, title, subTitle, catalogId, titlePicAddr, textIntro, authorId, src, content, keyWord, isActText, editTime, editId, isLocked', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	public static function getTextNum($userId)//获取该用户发表的文章
	{
		$db = Yii::app()->db;
		$sqlcmd = "SELECT COUNT(DISTINCT textId) as a FROM T_text WHERE authorId='".$userId."'";
		$res = $db->createcommand($sqlcmd)->query();
		foreach($res as $line)
		{
			 return $line['a'];
		}
	}
	public static function getPassedTextNum($userId)//获取该用户发表并且审核通过的文章（非抄送）
	{
		$count = 0;
		$db = Yii::app()->db;
		$sqlcmd = "SELECT DISTINCT textId FROM T_text WHERE authorId='".$userId."'";//先取该用户所有textid,对每个id到checkText查找
		$res = $db->createcommand($sqlcmd)->query();
		foreach($res as $line)
		{
			 $oneTextId = $line['textId'];
			 if(CheckText::model()->exists('textId=:textId AND checkStatus=2 AND isCopyTo=0',array(':textId'=>$oneTextId)))
			 {
			 	$count++;
			 }
		}
		return $count;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'textId' => 'Text',
			'title' => 'Title',
			'subTitle' => 'Sub Title',
			'catalogId' => 'Catalog',
			'titlePicAddr' => 'Title Pic Addr',
			'textIntro' => 'Text Intro',
			'authorId' => 'Author',
			'src' => 'Src',
			'content' => 'Content',
			'keyWord' => 'Key Word',
			'isActText' => 'Is Act Text',
			'editTime' => 'Edit Time',
			'editId' => 'Edit',
			'isLocked' => 'Is Locked',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('textId',$this->textId,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('subTitle',$this->subTitle,true);
		$criteria->compare('catalogId',$this->catalogId,true);
		$criteria->compare('titlePicAddr',$this->titlePicAddr,true);
		$criteria->compare('textIntro',$this->textIntro,true);
		$criteria->compare('authorId',$this->authorId,true);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('keyWord',$this->keyWord,true);
		$criteria->compare('isActText',$this->isActText,true);
		$criteria->compare('editTime',$this->editTime,true);
		$criteria->compare('editId',$this->editId,true);
		$criteria->compare('isLocked',$this->isLocked,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}