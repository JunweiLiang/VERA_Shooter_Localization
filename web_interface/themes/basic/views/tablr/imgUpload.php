<?php
	/*
		回调逻辑，选中的图片会填入两种类型的地方
		1.原来页面中标记了prop("imgToMe")的input的val,
		2.原来页面中标记了prop("imgToMe")的img的src,
		这些标记会在填充了内容后在此取消 
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>个人图片管理器 - Chun Wai Leong modified from ckfinder</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
</head>
<body>
	<p style="padding-left: 30px; padding-right: 30px;">
		<script type="text/javascript">

			function showFileInfo( fileUrl, data )
			{	
				
				$(window.opener.document).find("input").each(function(){
					if($(this).prop("imgToMe"))
					{
						$(this).val(fileUrl);
						$(this).prop("imgToMe",false);
						return false;
					}					
				});
				$(window.opener.document).find("img").each(function(){
					if($(this).prop("imgToMe"))
					{
						$(this).prop("src",fileUrl);
						$(this).prop("imgToMe",false);
						return false;
					}					
				});
				closeWindow();
			}
			var finder = new CKFinder();
			finder.basePath = 'ckfinder/';
			finder.resourceType = 'Images';
			finder.selectActionFunction = showFileInfo;
			finder.create();
			 function closeWindow(){ var browserName=navigator.appName; if (browserName=="Netscape") { window.open('','_parent',''); window.close(); } else if (browserName=="Microsoft Internet Explorer") { window.opener = "whocares"; window.close(); } } 
		</script>
	</p>
</body>
</html>