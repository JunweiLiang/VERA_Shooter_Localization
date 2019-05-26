<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<style type='text/css'>
	#<?php echo $id;?>{}
	#<?php echo $id;?> > div.controlDiv{
		padding:10px
	}
	#<?php echo $id;?> > div.controlDiv > div.line{padding:5px}
	#<?php echo $id;?> > div.controlDiv > div.line > div.adding{display:none}
	#<?php echo $id;?> > div.status{
		padding:10px;
		border-top:1px solid #F5D8DB;
	}
	#<?php echo $id;?> > div.status > div.queue{
		border-top:3px solid red;
		padding:5px 0 50px 10px;
	}
	#<?php echo $id;?> > div.status > div.queue > div.line{
		padding:0px;
	}
	#<?php echo $id;?> > div.status > div.queue > div.line > div.note{
		font-size:13px;
		color:navy;
	}
	#<?php echo $id;?> > div.status > div.queue > div.line > div.createTime{
		font-size:12px;
		color:gray;
	}
</style>
<?php if($importJquery){ ?>
	<script type="text/javascript" src="<?php echo $importJqueryUrl;?>"></script>
<?php } ?>
<script type="text/javascript">
//每两秒取一次状态
$(document).ready(function(){
	getStatus();
	<?php if($getStatusFre != ''){ ?>
		setInterval(function(){
			getStatus();
		},<?php echo $getStatusFre;?>);
	<?php } ?>
});
function getStatus()
{
	if($("#<?php echo $id;?> > div.status").prop('getting'))
	{
		return;
	}
	$("#<?php echo $id;?> > div.status").prop('getting',true);
	var data = {};
	
	$.post("<?php echo $getStatusUrl;?>",data,function(result){
		//alert(result);
		$("#<?php echo $id;?> > div.status").prop('getting',false);
		//清空状态区域
		$("#<?php echo $id;?> > div.status > div.waitingQueue").html("");
		$("#<?php echo $id;?> > div.status > div.executingQueue").html("");
		$("#<?php echo $id;?> > div.status > div.finishedQueue").html("");
		$("#<?php echo $id;?> > div.status > div.errorQueue").html("");
		//****
		$.each(result.waiting,function(index,item){
			//等待执行的链接加上特别指定id执行
			var tempStatusLine = $("<div class='line'>"+
							"<div class='url'>"+
								item.url+
								" <div class='btn btn-danger btn-small execThis'>执行</div>"+
							"</div>"+
							"<div class='note'>"+
								item.note+
							"</div>"+
							"<div class='createTime'>缓存时间: "+
								item.createTime+
							"</div>"+
							"<input class='urlId' type='hidden' value='"+item.urlId+"'></input>"+
						"</div>");
			tempStatusLine.appendTo("#<?php echo $id;?> > div.status > div.waitingQueue");
		});
		$.each(result.executing,function(index,item){
			var tempStatusLine = $("<div class='line'>"+
							"<div class='url'>"+
								item.url+
							"</div>"+
							"<div class='note'>"+
								item.note+
							"</div>"+
							"<div class='createTime'>缓存时间: "+
								item.createTime+
							"</div>"+
							"<input class='urlId' type='hidden' value='"+item.urlId+"'></input>"+
						"</div>");
			tempStatusLine.appendTo("#<?php echo $id;?> > div.status > div.executingQueue");
		});
		$.each(result.finished,function(index,item){
			//执行成功的链接后添加“预览”按钮、“转存为文件”按钮、“更新”，“删除”按钮
			<?php
				//“转存为文件”逻辑，把该result存在主目录下的cache文件夹中，文件名为index.php...的md5值，以防前面的路径遭到修改。以后在主页点击任何一个页面链接时，
				//即点击siteController的页面，首先查看cache文件夹下是否有该文件缓存，有就直接forward.
				///暂时有问题:首页有不同的别名，那么对首页不缓存？因为首页经常改变
				//“删除”逻辑，找缓存文件删除与把result 从数据库（两个表）删除，
				//"更新”逻辑，删除后再执行，然后转存为文件
			?>
			var cacheStatus = "";
			if(item.hasCache)
			{
				if(item.hasCache == "true")
				{
					cacheStatus = "已缓存";
				}else
				{
					cacheStatus = "未缓存";
				}
			}
			var tempStatusLine = $("<div class='line'>"+
							"<div class='url'>"+
								item.url+
								" <div class='btn btn-success btn-small preview'>预览</div>"+
								" <div class='btn btn-info btn-small saveAsFile'>添加缓存</div>"+
								" <div class='btn btn-danger btn-small delete'>删除缓存</div>"+
								" <div class='btn btn-info btn-small refresh'>更新缓存</div>"+
							"</div>"+
							"<div class='note'>"+
								item.note+"("+cacheStatus+")"+
							"</div>"+
							"<div class='createTime'>缓存时间: "+
								item.createTime+
							"</div>"+
							"<input class='urlId' type='hidden' value='"+item.urlId+"'></input>"+
							"<input class='resultId' type='hidden' value='"+item.resultId+"'></input>"+
						"</div>");
			tempStatusLine.appendTo("#<?php echo $id;?> > div.status > div.finishedQueue");
		});
		$.each(result.error,function(index,item){
			var tempStatusLine = $("<div class='line'>"+
							"<div class='url'>"+
								item.url+
							"</div>"+
							"<div class='note'>"+
								item.note+
							"</div>"+
							"<div class='createTime'>缓存时间: "+
								item.createTime+
							"</div>"+
							"<input class='urlId' type='hidden' value='"+item.urlId+"'></input>"+
						"</div>");
			tempStatusLine.appendTo("#<?php echo $id;?> > div.status > div.errorQueue");
		});
	},'json');
}
//更新缓存 按钮
	$(document).delegate("#<?php echo $id;?> > div.status > div.finishedQueue > div.line > div.url > div.refresh","click",function(){
		var data = {};
		data.resultId = $(this).parent().parent().children("input.resultId").val();
		data.refresh = "true";
		$(this).html("<div class='loading'></div>");
		$.post("<?php echo $deleteUrl;?>",data,function(result){
			//alert(result);
		});
	});
//删除缓存 按钮
	$(document).delegate("#<?php echo $id;?> > div.status > div.finishedQueue > div.line > div.url > div.delete","click",function(){
		var data = {};
		data.resultId = $(this).parent().parent().children("input.resultId").val();
		//alert(data.resultId);
		$(this).html("<div class='loading'></div>");
		$.post("<?php echo $deleteUrl;?>",data,function(result){
			//alert(result);
		});
	});
//转存为文件 按钮
	$(document).delegate("#<?php echo $id;?> > div.status > div.finishedQueue > div.line > div.url > div.saveAsFile","click",function(){
		//alert("a");
		var data = {};
		data.resultId = $(this).parent().parent().children("input.resultId").val();
		$(this).html("<div class='loading'></div>");
		$.post("<?php echo $saveAsFileUrl;?>",data,function(result){
			//alert(result);
		});
	});
//预览，直接get方式调用
	$(document).delegate("#<?php echo $id;?> > div.status > div.finishedQueue > div.line > div.url > div.preview","click",function(){
		//alert($(this).parent().parent().children("input.resultId").val());
		window.open("<?php echo Yii::app()->baseUrl;?>/index.php/BugLeong/getResult?resultId="+$(this).parent().parent().children("input.resultId").val(),"_blank");
		//for testing 
		//$.post("<?php echo Yii::app()->baseUrl;?>/index.php/BugLeong/getResult?resultId="+$(this).parent().parent().children("input.resultId").val(),"",function(result){
		//	alert(result);
		//})
	});
//添加一个链接
	$(document).delegate("#<?php echo $id;?> > div.controlDiv div.addUrl","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			//alert($(this).parent().children('input.addUrl').val());			
			var data = {};
			//data.addUrl = encodeURIComponent($(this).parent().children('input.addUrl').val());//不需要，因为只有get传参数才需要转码
			data.addUrl = $(this).parent().children('input.addUrl').val();
		//	alert(data.addUrl);
			data.note = $(this).parent().children('input.note').val();
		//	alert(data.note);
			//本地检查链接合法性？
			if(data.addUrl == "")
			{
				return;
			}
			$(this).addClass('disabled');
			$.post("<?php echo $addUrl;?>",data,function(result){
				//alert(result);
				if(result == 'error')
				{
					alert("Oops!");
					return;
				}
				$("#<?php echo $id;?> > div.controlDiv div.addUrl").removeClass("disabled");
				$("#<?php echo $id;?> > div.controlDiv input.addUrl").val("");
				$("#<?php echo $id;?> > div.controlDiv input.note").val("");
			});
		}
	});
//**************
//执行第一个链接（暂时是阻塞的）
/*$(document).delegate("#<?php echo $id;?> > div.controlDiv div.execOne","click",function(){
	if(!$(this).hasClass('disabled'))
	{
		var data = {};
		$("#<?php echo $id;?> > div.controlDiv > div.line > div.adding").css('display','inline');
		$(this).addClass('disabled');
		$.post("<?php echo $execOneUrl;?>",data,function(result){
			//alert(result);
			$("#<?php echo $id;?> > div.controlDiv > div.line > div.adding").css('display','none');
			$("#<?php echo $id;?> > div.controlDiv > div.line > div.execOne").removeClass('disabled');
		});
	}
});*/
//执行全部等待链接
$(document).delegate("#<?php echo $id;?> > div.controlDiv div.execAll","click",function(){
	$("#<?php echo $id;?> > div.status > div.waitingQueue > div.line > div.url > div.execThis").click();
});
//执行一个指定链接
$(document).delegate("#<?php echo $id;?> > div.status > div.waitingQueue > div.line > div.url > div.execThis","click",function(){
	//alert("a");
	$(this).html("<div class='loading'></div>");
	var data = {};
	data.urlId = $(this).parent().parent().children("input.urlId").val();
	$.post("<?php echo $execOneUrl;?>",data,function(result){
		//alert(result);
	});
});
//更新全部缓存
$(document).delegate("#<?php echo $id;?> > div.controlDiv div.refreshAll","click",function(){
	$("#<?php echo $id;?> > div.status > div.finishedQueue > div.line > div.url > div.refresh").click();
});
</script>
<div id="<?php echo $id;?>">
	<div class='controlDiv'>
		<div class='line'>
			<div class='btn btn-info btn-small addUrl'>添加链接到队列</div>
			<input class='input-xlarge addUrl' value="" placeholder="前头自动添加http://127.0.0.1/"></input>
			<input class='input-xlarge note' placeholder="备注"></input>
		</div>
		<div class="line">
			<div class='btn btn-danger btn-small execAll'>执行全部连接</div>
			<div class='adding loading'></div>
		</div>
		<div class="line">
			<div class='btn btn-success btn-small refreshAll' title="未缓存的将自动添加缓存">更新全部缓存</div>
		</div>
	</div>
	<div class='status'>
		等待队列
		<div class="queue waitingQueue"></div>
		正在执行中
		<div class="queue executingQueue"></div>
		执行成功(执行后结果保存在数据库，缓存的意思是保存为文件到cache中,一个链接唯一对应一个缓存文件;siteController有checkCache的filter)
		<div class="queue finishedQueue"></div>
		执行失败
		<div class="queue errorQueue"></div>
	</div>
</div>