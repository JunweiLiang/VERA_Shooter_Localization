<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>

<div id="<?php echo $id;?>" style="position:relative">
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.form.js"></script>
	<form method="post" style="display:none" action="<?php echo $uploadTo;?>" enctype="multipart/form-data">

		<input class="varify" name="varify" value="<?php echo $varify?>" type="hidden"></input>
		<input class="types" name="types" value="<?php echo $types?>" type="hidden"></input>
		<input class="maxSize" name="maxSize" value="<?php echo $maxSize?>" type="hidden"></input>
		<input class="filename" name="filename" type="hidden" value="<?php echo $filename?>"></input>

		<?php /**很巧妙的hack！ie不允许js提交文件，把文件按钮隐藏然后飘到另外按钮上就好！*

		will not work if htmlBeforeButton is not empty

		*/?>

		<input multiple type="file" name="<?php echo $filename?>[]" style="width:75px;position:absolute;top:0;left:0;filter:alpha(opacity=0);opacity:0;z-index:999" class="<?php echo $filename?>" id="<?php echo $filename?>"></input>
	</form>
	<?php echo $htmlBeforeButton; ?>
	<div class="<?php echo $buttonClasses?> upload"><?php echo $buttonName?></div>
	<?php echo $htmlAfterButton; ?>
	<?php if($showProgress){ ?>
	<div class="progress progress-striped active" style="display:none">
		<div class="bar" style="width:0%"></div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
	var <?php echo $id?>error = function(message){};
	<?php if($error!=""){ ?>
		var <?php echo $id?>error = <?php echo $error?>;
	<?php } ?>
	var <?php echo $id?>success = function(data){};
	<?php if($success!=""){ ?>
		var <?php echo $id?>success = <?php echo $success?>;
	<?php } ?>
	var <?php echo $id?>beforeSubmit = function(){return true};
	<?php if($beforeSubmit!=""){ ?>
		var <?php echo $id?>beforeSubmit = <?php echo $beforeSubmit?>;
	<?php } ?>
	
	//点击上传,自动打开文件选择
	cw.ec("#<?php echo $id?> > div.upload",function(){
		if($(this).hasClass("disabled"))
		{
			return false;
		}
		//$("#<?php echo $id?> > form > #<?php echo $filename?>").trigger(cw.ectype);// touch would work
		$("#<?php echo $id?> > form > #<?php echo $filename?>").trigger("click");
		//alert("a");
	});
	$(document).ready(function(){
		//
		if($.browser.msie) { 
			//alert("stupid ie")
			//显示上传按钮
			//$("#<?php echo $id?> > div.upload").hide();
			if(!$("#<?php echo $id?> > div.upload").hasClass("disabled"))
			{
				$("#<?php echo $id?> > form").show();
			}
		}
	});
	//选择了文件就上传 
		$("#<?php echo $id?> > form > #<?php echo $filename?>").on("change",function(){
		//检查文件
		var checkVal = $("#<?php echo $id?> > form > #<?php echo $filename?>").val();
		//不能为空
		if(checkVal == "")
		{
			<?php echo $id?>error("please select a file");
			return false;
		}
		var fileElem = document.getElementById("<?php echo $filename?>");
		//alert(fileElem.files.length);
		/*for(var key in fileElem.files[0])
		{
			alert(key+" "+fileElem.files[0][key]);
		}
		return;*/
		//检查大小
		//检查类型
		var types = "<?php echo $types;?>".split(",");
		if((fileElem != null) && (fileElem.files != null))
		{//fucking ie
			//alert(document.getElementById("<?php echo $filename?>").files[0].size);
			//return;
			for(var i=0;i<fileElem.files.length;++i)
			{
				
				//alert(types.length);
				var append = <?php echo $id?>getAppendix(fileElem.files[i].name);
				if(<?php echo $id?>notIn(append,types))
				{
					<?php echo $id?>error(fileElem.files[i].name+" file type wrong");
					return false;
				}
				if((fileElem.files[i].maxSize > <?php echo $maxSize;?>) || (fileElem.files[i].size > <?php echo $maxSize;?>))
				{
					<?php echo $id?>error(fileElem.files[i].name+" filesize too large");
					return false;
				}
			}
		}
		
		
		//alert("c");
		<?php echo $id?>error("");
		//清空进度条
		<?php echo $id?>resetProgress();
		<?php if($showProgress){ ?>
		$("#<?php echo $id?> > div.progress").show();
		<?php } ?>
		$("#<?php echo $id?> > form").ajaxForm({
			//iframe:true,// this will fail the progress bar
			dataType:"json",
			clearForm:true,
			timeout:1000*60*100,//毫秒
			beforeSubmit:<?php echo $id?>beforeSubmit,
			uploadProgress: function(event, position, total, percentComplete) {
				//alert("a");
				var percentVal = percentComplete + '%';
				//alert(percentVal);
				$("#<?php echo $id?> > div.progress").children("div.bar").width(percentVal).html(percentVal);
				if(percentVal == "100%")
				{
					//上传成功了，服务器开始处理
					//$("#<?php echo $id?> > div.main > div.progress").html("upload succes, processing....");
				}
			},
			error:function(data, message){
				//alert(message);
				<?php echo $id?>resetProgress();
				<?php echo $id?>error("Error: "+message);
			},
			success: <?php echo $id?>success,
			complete:function(xhr){
				<?php echo $id?>resetProgress();
			}
		});
		$("#<?php echo $id?> > form").submit();
	});
	
	
	//重置进度条 
	function <?php echo $id?>resetProgress()
	{
		$("#<?php echo $id?> > div.progress").html("<div class='bar'></div>").hide().children("div.bar").width("0%");
	}
	function <?php echo $id?>getAppendix(file_name)
	{
		var result =/\.([^\.]+)$/.exec(file_name);
		return result[1];
	}
	function <?php echo $id?>notIn(value,arr)
	{
		var isIn = false;
		for(var i=0;i<arr.length;++i)
		{
			if(value == arr[i])
			{
				isIn = true;
				break;
			}
		}
		return !isIn;
	}
</script>