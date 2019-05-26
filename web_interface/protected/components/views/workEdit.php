<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		注意！由于使用了Tablr的ckeditor，在其hmtl处才载入ckeditor实例，所以需要此页面的js放在最后
		//没有用，把js放回前面了；因为载入ckediotr数据的时间是绑定在change事件上，change事件在前面的ready中就调用了
		//现在的解决办法是对getWork使用setTimeout(50)//0、10不行!!
	*/
?>
<style type="text/css">
	#<?php echo $id?>{width:<?php echo $width;?>}
	#<?php echo $id?> > div.main > div{position:relative}
	#<?php echo $id?> > div.main > div.title{
		text-align:center;font-weight:bold;
		font-size:16px;
		padding:10px 0;
	}
	#<?php echo $id?> > #shuomingEditModal > div.modal-body{
		max-height:none;
	}
	#<?php echo $id?> > div.main > div > div.tab-content{
	<?php if($overflow){ ?>
		overflow:auto;
	<?php } ?>
		border-bottom:3px solid silver;		
	}
	#<?php echo $id?> > div.main > div > div.workEditLoading{
		/*height 在页面载入与resize的时候与tabcontent一致 ,width与整个控件宽度一致*/
		width:<?php echo $width;?>;
		background-color:silver;
		opacity:0.<?php echo $loadingOpa;?>;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=<?php echo $loadingOpa;?>);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $loadingOpa;?>)"; /*IE8*/
		position:absolute;top:0;left:0;
		z-index:1000;
	}
	#<?php echo $id?> > div.main > div > div.workEditLoading > div.wrapLoading{
		/*
			其margin－top跟随workEditLoading的一半，以使得载入动画居中
		*/
		<?php if(!$overflow){ ?>
		padding-top:150px;
		height:500px;
		<?php } ?>
	}
	#<?php echo $id;?> > div.main > div > div.tab-content > #baoming,
	#<?php echo $id;?> #shuoming,
	#<?php echo $id;?> #bushu,
	#<?php echo $id;?> #jihui,
	#<?php echo $id;?> #dayin{
		padding-top:50px;
	}
	#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.ctr,
	#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr,
	#<?php echo $id?> > div.main > div > div.tab-content > #bushu > div.fixedHead,
	#<?php echo $id?> > div.main > div > div.tab-content > #jihui > div.fixedHead,
	#<?php echo $id?> > div.main > div > div.tab-content > #dayin > div.fixedHead{
		position:absolute;
		top:50px;
		left:0px;
		background-color:white;
		padding:10px 0px;
		padding-left:10px;
		border-bottom:2px solid silver;
		width:790px;
		z-index:999;
		font-size:16px;
		font-weight:bold;
	}
	#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock > div.baomingbiaoF,
	#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock > div.notice,
	#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock > div.uploadBaomingbiao,
	#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock > div.uploadBanquan,
	#<?php echo $id?> #shuoming > div.afterLock,
	#<?php echo $id;?> #bushu > div.block,
	#<?php echo $id;?> #jihui > div.block,
	#<?php echo $id;?> #dayin > div.block{
		border:1px solid silver;
		border-radius:5px;
		padding:20px;
		margin:0px 15px 25px 15px;
		background-color:rgb(250,250,250);
	}
	#<?php echo $id?> #baomingbiao > div.line,/*  #baomingbiao === #baoming > div.beforeLock > #baomingbiao  */
	#<?php echo $id?> #baomingbiao > div.author > div.line,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.line,
	#<?php echo $id?> #zuopinshuoming > div.line,
	#<?php echo $id?> #shuoming > div.afterLock > div.line,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.line,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.line,
	#<?php echo $id?> #dayin > div.block > div.line{
		padding:5px 0;
	}
	#<?php echo $id?> #zuopinshuoming > div.line,
	#<?php echo $id?> #shuoming > div.afterLock > div.line{
		padding:0 0 20px 0;
	}
	#<?php echo $id;?> #shuoming > div.beforeLock > form > div.block{
		padding:10px 0;
	}
	#<?php echo $id;?> #shuoming > div.beforeLock > form > div.block > div.title{
		font-weight:bold;
		background-color:rgb(245,245,245);
		padding:5px;
	}
	 #<?php echo $id;?> #shuoming > div.beforeLock > form > div.block > div.content{
	 	padding:10px;
	 }
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.line,
	#<?php echo $id?> #shuoming > div.afterLock > div.line,
	#<?php echo $id?> #bushu > div.block > div.line{
		height:auto!important;
		height:30px;
		min-height:30px;
		position:relative;
	}
	#<?php echo $id;?> #zuopinshuoming > div.line > div.left{padding:5px}
	#<?php echo $id?> #baomingbiao > div.line > div.left,
	#<?php echo $id?> #baomingbiao > div.author > div.line > div.left,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.line > div.left,
	/*#<?php echo $id?> #zuopinshuoming > div.line > div.left,*/
	/*#<?php echo $id?> #shuoming > div.afterLock > div.line > div.left,*/
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.line > div.left,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.line > div.left,
	#<?php echo $id?> #bushu > div.block > div.line > div.left,
	#<?php echo $id?> #dayin > div.block > div.line > div.left{
		width:100px;
		float:left;
	}
	#<?php echo $id?> #bushu > div.block > div.line > div.left{
		width:150px;float:left;
	}
	#<?php echo $id?> #baomingbiao > div.line > div.right,
	#<?php echo $id?> #baomingbiao > div.author > div.line > div.right,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.line > div.right,
	/*#<?php echo $id?> #zuopinshuoming > div.line > div.right,*/
	/*#<?php echo $id?> #shuoming > div.afterLock > div.line > div.right,*/
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.line > div.right,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.line > div.right,
	#<?php echo $id?> #bushu > div.block > div.line > div.right,
	#<?php echo $id?> #dayin > div.block > div.line > div.right{
		margin:0 0 0 100px;
	}
	#<?php echo $id?> #bushu > div.block > div.line > div.right{
		margin:0 0 0 150px;
	}
	#<?php echo $id?> #bushu > div.block > div.line > div.right > input{width:485px;}
	#<?php echo $id?> #baomingbiao > div.line > div.right > div.tailNotice,
	#<?php echo $id?> #baomingbiao > div.author > div.line > div.right > div.tailNotice,
	#<?php echo $id?> #zuopinshuoming > div.line > div.right > div.tailNotice,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.line > div.right > div.tailNotice,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.line > div.right > div.tailNotice,
	#<?php echo $id?> #dayin > div.block > div.line > div.right > div.tailNotice{
		color:rgb(170,0,0);
		font-size:13px;
	}
	#<?php echo $id?> #bushu > div.block > div.line > div.right > div.tailNotice{
		position:absolute;top:0;right:0;
	}
	#<?php echo $id?> #baomingbiao > div.line > div.right > div.imgPreview,
	#<?php echo $id?> #baomingbiao > div.author > div.line > div.right > div.imgPreview,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.line > div.right > div.imgPreview,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.line > div.right > div.imgPreview,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.line > div.right > div.imgPreview,
	#<?php echo $id?> #dayin > div.block > div.line > div.right > div.imgPreview{
		width:200px;
		padding:10px;
	}
	#<?php echo $id?> #baomingbiao > div.line > div.right > textarea{
		width:350px;
		height:150px;
	}
	#<?php echo $id?> #baomingbiao > div.title > div.right,
	#baomingbiao > div.artTeacher > div.title > div.right,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.title > div.right,
	#<?php echo $id?> #zuopinshuoming > div.title > div.right,
	#<?php echo $id?> #shuoming > div.afterLock > div.title > div.right{
		margin:5px 0;
		border-left:3px blue solid;
		padding-left:10px;
		font-weight:bold;
	}
	#<?php echo $id?> #baomingbiao > div.subTitle > div.right,
	#baomingbiao > div.author > div.subTitle > div.right,
	#<?php echo $id?> #baoming > div.afterLock > div.baomingbiaoF > div.subTitle > div.right,
	#<?php echo $id?> #zuopinshuoming > div.subTitle > div.right,
	#<?php echo $id?> #shuoming > div.afterLock > div.subTitle > div.right{
		margin:0;
		color:blue;
	}
	#<?php echo $id;?> #baoming > div.ctr > span.baomingE,
	#<?php echo $id;?> #shuoming > div.ctr > span.shuomingE,
	#<?php echo $id;?> #jihui > div.block > div.jihuiE,
	#<?php echo $id;?> #bushu > div.block > div.bushuE{
		font-size:13px;
		color:red;
	}
	#<?php echo $id;?> #jihui > div.block > div.jihuiE,
	#<?php echo $id;?> #bushu > div.block > div.bushuE{
		text-align:center;
	}
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBaomingbiao > div.ctr,
	#<?php echo $id?> #baoming > div.afterLock > div.uploadBanquan > div.ctr{
		
	}
	#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.line,
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.line{
		padding:10px 0;
		height:auto!important;
		height:20px;
		min-height:20px;
	}
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.line > div.left{
		float:left;width:100px;
	}
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.line > div.right{
		margin:0 0 0 100px
	}
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.title{
		padding:0 10px;border-left:2px green solid;
	}
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.subTitle{
		color:gray;
	}
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.title > div.right,
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div.subTitle > div.right{
		margin:0;
	}
	#<?php echo $id;?> > div.shuomingModal > div.modal-body,
	#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body{
		/*overflow:visible;
		max-height:none;
		height:auto;*/
		height:300px;
		overflow:auto;
	}
</style>
<script type="text/javascript">
//测试链接
$(document).delegate("div.testLink","click",function(){
	var link = $(this).parent().parent().children("input").val();
	if(link != "")
	{
		window.open(link,"_blank");
	}
});


<?php 
	if($overflow){
?>
//进入页面就获取当前浏览器窗口大小，让控件编辑区高度始终小于窗口;同时要绑定resize事件
var gap = 270;//编辑区高度与窗口高度的差,是个固定值;应为header,footer,baomingMain notice的和
$(document).ready(function(){
	//alert($(window).height());
	$("#<?php echo $id?> > div.main > div > div.tab-content").css("height",$(window).height()-gap+"px");
	$("#<?php echo $id?> > div.main > div > div.workEditLoading").css("height",$(window).height()-gap+80+"px");
	$("#<?php echo $id?> > div.main > div > div.workEditLoading > div.wrapLoading").css("marginTop",($(window).height()-gap)/2+"px");
});
$(window).resize(function(){
	//alert($(this).height());
	$("#<?php echo $id?> > div.main > div > div.tab-content").css("height",$(this).height()-gap+"px");
	$("#<?php echo $id?> > div.main > div > div.workEditLoading").css("height",$(this).height()-gap+80+"px");
	$("#<?php echo $id?> > div.main > div > div.workEditLoading > div.wrapLoading").css("marginTop",($(this).height()-gap)/2+"px");
});

<?php } ?>
<?php if($fixedHead){ ?>
$(document).ready(function(){
	//alert($("#<?php echo $id?>").offset().top);
	$(window).bind('scroll',function(){
		//
		if($(this).scrollTop() >= $("#<?php echo $id?>").offset().top+50)//40 for div.main > div.title
		{
			//alert('wd');
			$("#<?php echo $id?> > div.main > div > div.tab-content > div.tab-pane > div.head").css('position','fixed')
				.css("top","<?php echo $fixedTop;?>")
				.css("left","50%")				
				.css("marginLeft","-340px")
				.css("width","820px");
		}
		else
		{
			$("#<?php echo $id?> > div.main > div > div.tab-content > div.tab-pane > div.head").css('position','absolute')
				.css("top","50px")
				.css("left","0")				
				.css("marginLeft","0")
				.css("width","790px");
		}
	});
});
<?php } ?>
//与外界交互的关键,change事件，载入相应的work信息 
var workEditInitial = true;
$(document).delegate("#<?php echo $id;?> > input.workId","change",function(){
	showWorkEditLoading();
//	if(workEditInitial)//不需要initial了
	if(false)
	{
		setTimeout(function(){
			var workId = $("#<?php echo $id;?> > input.workId").val();
			getWorkInfo(workId);
			$("#changeWorkType > input.workId").val(workId);
			$("#changeWorkType > input.workId").change();
		},2000);//延时为了ckeditor的载入，
		workEditInitial = false;
	}
	else
	{
		var workId = $("#<?php echo $id;?> > input.workId").val();
		getWorkInfo(workId);
		$("#changeWorkType > input.workId").val(workId);
		$("#changeWorkType > input.workId").change();
	}
});
function getWorkInfo(workId)
{
	showWorkEditLoading();
	//修改作品标题
	workIdStr = <?php echo IDADDUP ;?>+parseInt(workId);
	$("#<?php echo $id?> > div.main > div.title").html("作品 "+workIdStr);
	//alert(workId);
	$.ajax({
		type:"POST",
		url:"<?php echo Yii::app()->baseUrl;?>/index.php/competitor/getWork",
		data:"workId="+workId,
		dataType:"JSON",
		success:function(result){
		//alert(result.propertyIsEnumerable("workCode"));
		//更新报名表div
		resetAuthorAndArt();
		if(result.baomingLock == 0)//没有提交报名表的情况
		{
			$("#<?php echo $id?> > div.main > div > ul > li > a.baoming > span.status")
				.css("color","red")
				.html("(请提交!)");
			//重置ctr
			resetBaomingbiaoCtr("beforeLock");
			//隐藏afterLock(Submit),显示beforeLock
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock").hide();
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.beforeLock").show();
			//允许修改作品种类
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.beforeLock > div.changeWorkType").show();
			//填写beforeSubmit
			for(var name in result)
			{
			//alert(name+result[name]);
			//break;
			//div.uploadBaomingbiao
				//未上传盖章
				if((name == "baomingImgAddr") && (result[name] == null))
				{
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > input.gaizhang").val("");
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > div.imgPreview > img").prop("src","");
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > input.gaizhang").val("");
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "baomingImgAddr") && (result[name] != null))
				{
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > input.gaizhang").val(result[name]);
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > div.imgPreview > img").prop("src",result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > input.gaizhang").val(result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				//div.uploadBanquan
				//未上传版权声明
				if((name == "banquanImgAddr") && (result[name] == null))
				{
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > input.gaizhang").val("");
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > div.imgPreview > img").prop("src","");
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > input.gaizhang").val("");
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "banquanImgAddr") && (result[name] != null))
				{
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > input.gaizhang").val(result[name]);
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > div.imgPreview > img").prop("src",result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > input.gaizhang").val(result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > div.imgPreview > img").prop("src",result[name]);
				}
			$("#<?php echo $id;?> #baomingbiao input."+name).val(result[name]);
			//图片情况
			if($("#<?php echo $id;?> #baomingbiao img."+name).length != 0)
			{
				//input:hidden的值在前面已经修改
				if((result[name] != "") && (result[name] != null))//有内容
				{
					$("#<?php echo $id;?> #baomingbiao img."+name).prop("src",result[name])
					.parent().parent().children("div.ctr").children("div.upload").html("修改图片");
				}
				else//无内容
				{
					$("#<?php echo $id;?> #baomingbiao img."+name).prop("src","")
					.parent().parent().children("div.ctr").children("div.upload").html("上传图片");
				}
			}
			//select情况
			if($("#<?php echo $id;?> #baomingbiao select."+name).length != 0)
			{
				$("#<?php echo $id;?> #baomingbiao select."+name).children("option").prop("selected",false);//用于初始化
				if((result[name] == "") || (result[name] == null))
				{
					$("#<?php echo $id;?> #baomingbiao select."+name).children("option").eq(0).prop("selected",true);
				}
				else
				{
					$("#<?php echo $id;?> #baomingbiao select."+name).children("option[value='"+result[name]+"']").prop("selected",true);
				}
			}
			else//非select情况才判断作者是否为空
			{
				//作者二有内容情况
				if(name.indexOf("author2") >= 0)//作者二的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor2").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor2").removeClass("addAuthor2")
							.addClass("removeAuthor2")
							.html("取消作者二");
						$("#<?php echo $id;?> #baomingbiao > div.author2").show();
						//显示新增作者三
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").show();
					}
				}
				//作者三有内容情况
				if(name.indexOf("author3") >= 0)//作者三的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						//隐藏新增作者三，显示作者三信息
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").removeClass("addAuthor3")
							.addClass("removeAuthor3")
							.html("取消作者三");
						$("#<?php echo $id;?> #baomingbiao > div.author3").show();
						//显示新增作者四五
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").show();
						
					}
				}
				//作者四五有内容情况
				if((name.indexOf("author4") >= 0)||(name.indexOf("author5") >= 0))//作者三或者四的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						
						//显示作者四五
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").removeClass("addAuthor45")
							.addClass("removeAuthor45")
							.html("取消作者四五");
						$("#<?php echo $id;?> #baomingbiao > div.author45").show();
					}
				}
				//指导二有内容
				if(name.indexOf("artTeacher") >= 0)//指导老师2的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addArtTeacher").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addArtTeacher").removeClass("addArtTeacher")
							.addClass("removeArtTeacher")
							.html("取消指导老师二");
						$("#<?php echo $id;?> #baomingbiao > div.artTeacher").show();
					}
				}
			}
			$("#<?php echo $id;?> #baomingbiao textarea."+name).val(result[name]);
			
		}
		}
		else
		{
			$("#<?php echo $id?> > div.main > div > ul > li > a.baoming > span.status")
				.css("color","black")
				.html("(已提交)");
			<?php
				if($allowSubmittedSave)
				{
			?>
			resetBaomingbiaoCtr("beforeLock");
			
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.beforeLock").show();
			//填写beforeSubmit
			for(var name in result)
			{
			//alert(name+result[name]);
			//break;
			//div.uploadBaomingbiao
				
				//div.uploadBanquan
				
			$("#<?php echo $id;?> #baomingbiao input."+name).val(result[name]);
			//图片情况
			if($("#<?php echo $id;?> #baomingbiao img."+name).length != 0)
			{
				//input:hidden的值在前面已经修改
				if((result[name] != "") && (result[name] != null))//有内容
				{
					$("#<?php echo $id;?> #baomingbiao img."+name).prop("src",result[name])
					.parent().parent().children("div.ctr").children("div.upload").html("修改图片");
				}
				else//无内容
				{
					$("#<?php echo $id;?> #baomingbiao img."+name).prop("src","")
					.parent().parent().children("div.ctr").children("div.upload").html("上传图片");
				}
			}
			//select情况
			if($("#<?php echo $id;?> #baomingbiao select."+name).length != 0)
			{
				$("#<?php echo $id;?> #baomingbiao select."+name).children("option").prop("selected",false);//用于初始化
				if((result[name] == "") || (result[name] == null))
				{
					$("#<?php echo $id;?> #baomingbiao select."+name).children("option").eq(0).prop("selected",true);
				}
				else
				{
					$("#<?php echo $id;?> #baomingbiao select."+name).children("option[value='"+result[name]+"']").prop("selected",true);
				}
			}
			else//非select情况才判断作者是否为空
			{
				//作者二有内容情况
				if(name.indexOf("author2") >= 0)//作者二的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor2").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor2").removeClass("addAuthor2")
							.addClass("removeAuthor2")
							.html("取消作者二");
						$("#<?php echo $id;?> #baomingbiao > div.author2").show();
						//显示新增作者三
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").show();
					}
				}
				//作者三有内容情况
				if(name.indexOf("author3") >= 0)//作者三的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						//隐藏新增作者三，显示作者三信息
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").removeClass("addAuthor3")
							.addClass("removeAuthor3")
							.html("取消作者三");
						$("#<?php echo $id;?> #baomingbiao > div.author3").show();
						//显示新增作者四五
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").show();
						
					}
				}
				//作者四五有内容情况
				if((name.indexOf("author4") >= 0)||(name.indexOf("author5") >= 0))//作者三或者四的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						
						//显示作者四五
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").removeClass("addAuthor45")
							.addClass("removeAuthor45")
							.html("取消作者四五");
						$("#<?php echo $id;?> #baomingbiao > div.author45").show();
					}
				}
				//指导二有内容
				if(name.indexOf("artTeacher") >= 0)//指导老师2的字段
				{
					if((result[name] != "") && (result[name] != null))//有不为空
					{
						//$("#<?php echo $id;?> #baomingbiao > div.line > div.addArtTeacher").hide();
						$("#<?php echo $id;?> #baomingbiao > div.line > div.addArtTeacher").removeClass("addArtTeacher")
							.addClass("removeArtTeacher")
							.html("取消指导老师二");
						$("#<?php echo $id;?> #baomingbiao > div.artTeacher").show();
					}
				}
			}
			$("#<?php echo $id;?> #baomingbiao textarea."+name).val(result[name]);
			}
			<?php } ?>
			//重置ctr
			resetBaomingbiaoCtr("afterLock");
			//显示afterLock(Submit),隐藏beforeLock
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.afterLock").show();
			<?php if(!$allowSubmittedSave){ ?>
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.beforeLock").hide();
			<?php } ?>
			//不允许用户自己修改作品种类
			$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.beforeLock > div.changeWorkType").hide();
			//填写afterLock,有报名表，以及上传纸质文件
			for(var name in result)
			{
				//直接填入此div.afterLock下的所有字段 
				//div.baomingbiaoF(注意这里有一些字段会失陪)
				if($("#<?php echo $id;?> #baoming > div.afterLock > div.baomingbiaoF > div."+name+" > div.right > div.imgPreview").length == 0)
				{
					$("#<?php echo $id;?> #baoming > div.afterLock > div.baomingbiaoF > div."+name).children("div.right").html(result[name]);
				}
				else
				{
					$("#<?php echo $id;?> #baoming > div.afterLock > div.baomingbiaoF > div."+name+" > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				//div.uploadBaomingbiao
				//未上传盖章
				if((name == "baomingImgAddr") && (result[name] == null))
				{
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > input.gaizhang").val("");
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > div.imgPreview > img").prop("src","");
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > input.gaizhang").val("");
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "baomingImgAddr") && (result[name] != null))
				{
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > input.gaizhang").val(result[name]);
				//	$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBaomingbiao > div.gaizhang > div.right > div.imgPreview > img").prop("src",result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > input.gaizhang").val(result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				//div.uploadBanquan
				//未上传版权声明
				if((name == "banquanImgAddr") && (result[name] == null))
				{
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > input.gaizhang").val("");
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > div.imgPreview > img").prop("src","");
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > input.gaizhang").val("");
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "banquanImgAddr") && (result[name] != null))
				{
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > input.gaizhang").val(result[name]);
					//$("#<?php echo $id;?> #baoming > div.afterLock > div.uploadBanquan > div.banquan > div.right > div.imgPreview > img").prop("src",result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > input.gaizhang").val(result[name]);
					$("#<?php echo $id;?> #dayin > div.block > div.banquan > div.right > div.imgPreview > img").prop("src",result[name]);
				}
			}
		}
		//更新作品说明div
			//没有提交
		if(result.shuomingLock == 0)
		{		
			$("#<?php echo $id?> > div.main > div > ul > li > a.shuoming > span.status")
				.css("color","red")
				.html("(请提交!)");	
			resetShuomingCtr("beforeLock");
			//隐藏after
			$("#<?php echo $id;?> #shuoming > div.afterLock").hide();
			$("#<?php echo $id;?> #shuoming > div.beforeLock").show();
			//这里只能一个一个设定
			//不设定了，只展示
		//	alert(result.workInstallNote);
		/*	workInstallNote.setData(result.workInstallNote);
		//	alert(workInstallNote.getData());
			workPreview.setData(result.workPreview);
			workDesignNote.setData(result.workDesignNote);
			workDifficulties.setData(result.workDifficulties);
			teacherComment.setData(result.teacherComment);
			otherNote.setData(result.otherNote);
			//workInstallNote.focus();
			*/
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workInstallNote > div.content").html(result.workInstallNote);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workPreview > div.content").html(result.workPreview);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workDesignNote > div.content").html(result.workDesignNote);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workDifficulties > div.content").html(result.workDifficulties);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.teacherComment > div.content").html(result.teacherComment);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.otherNote > div.content").html(result.otherNote);
		}
		else//作品说明已经提交 
		{
			$("#<?php echo $id?> > div.main > div > ul > li > a.shuoming > span.status")
				.css("color","black")
				.html("(已提交)");
			resetShuomingCtr("afterLock");
			<?php if($allowSubmittedSave){ ?>
			
		
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workInstallNote > div.content").html(result.workInstallNote);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workPreview > div.content").html(result.workPreview);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workDesignNote > div.content").html(result.workDesignNote);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.workDifficulties > div.content").html(result.workDifficulties);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.teacherComment > div.content").html(result.teacherComment);
			$("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.otherNote > div.content").html(result.otherNote);
			<?php } ?>
			//隐藏beforeLock
			$("#<?php echo $id;?> #shuoming > div.afterLock").show();
			<?php if(!$allowSubmittedSave){ ?>$("#<?php echo $id;?> #shuoming > div.beforeLock").hide();<?php } ?>
			//
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.workInstallNote > div.right").html(result.workInstallNote);
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.workPreview > div.right").html(result.workPreview);
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.workDesignNote > div.right").html(result.workDesignNote);
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.workDifficulties > div.right").html(result.workDifficulties);
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.teacherComment > div.right").html(result.teacherComment);
			$("#<?php echo $id;?> #shuoming > div.afterLock > div.otherNote > div.right").html(result.otherNote);
		}
		
		//更新作品部署div
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr1").val(result.workPreviewAddr1);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr2").val(result.workPreviewAddr2);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr3").val(result.workPreviewAddr3);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr4").val(result.workPreviewAddr4);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr5").val(result.workPreviewAddr5);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.deployAddr1").val(result.deployAddr1);
		$("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.deployAddr2").val(result.deployAddr2);
		//更新寄汇报名费div
		if(result.transferImgAddr != null)
		{
			$("#<?php echo $id;?> #jihui > div.block > div.line > div.right > input.transferImgAddr").val(result.transferImgAddr);
			$("#<?php echo $id;?> #jihui > div.block > div.line > div.right > div.imgPreview > img").prop("src",result.transferImgAddr);
		}
		else//清空
		{
			$("#<?php echo $id;?> #jihui > div.block > div.line > div.right > input.transferImgAddr").val("");
			$("#<?php echo $id;?> #jihui > div.block > div.line > div.right > div.imgPreview > img").prop("src","");
		}
		//alert("ok");
		hideWorkEditLoading();
	},
		error:function(){
		
		}
	});
}
//整个workEdit区域的载入动画
function showWorkEditLoading()
{
	//获取div.main的高度然后修改自身高度
	$("#<?php echo $id?> > div.main > div > div.workEditLoading").css("height",$("#<?php echo $id?> > div.main").css("height"))
		.show();
}
function hideWorkEditLoading()
{
	$("#<?php echo $id?> > div.main > div > div.workEditLoading").hide();
}
//*************************
function resetAuthorAndArt()
{
	//把报名表格中新增作者二三，增加艺术老师的按钮和div恢复初始样子
	$("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor2").removeClass("removeAuthor2").addClass("addAuthor2").html("添加作者二");
	$("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor3").removeClass("removeAuthor3").addClass("addAuthor3").html("添加作者三");
	$("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor45").removeClass("removeAuthor45").addClass("addAuthor45").html("添加作者四五");
	$("#<?php echo $id;?> #baomingbiao > div.line > div.removeArtTeacher").removeClass("removeArtTeacher").addClass("addArtTeacher").html("添加指导老师二");
	$("#<?php echo $id;?> #baomingbiao > div.author2").hide();
	$("#<?php echo $id;?> #baomingbiao > div.author3").hide();
	$("#<?php echo $id;?> #baomingbiao > div.author45").hide();
	$("#<?php echo $id;?> #baomingbiao > div.artTeacher").hide();
	
}
//**************下面是报名表的动作
//重置报名表ctr,分beforeLock,afterLock
function resetBaomingbiaoCtr(str)
{
	if(str == "beforeLock")
	{
		//未提交，显示“提交”，“保存”，禁用"预览 "
		$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.ctr > div.save").removeClass("disabled").html("保存")
		.parent().children("div.submit").removeClass("disabled").html("提交");
		//.parent().children("a.preview").addClass("disabled");
	}
	else
	{
		$("#<?php echo $id?> > div.main > div > div.tab-content > #baoming > div.ctr > div.save").html("保存")<?php if(!$allowSubmittedSave){ ?>.addClass("disabled")<?php } ?>
		.parent().children("div.submit").addClass("disabled").html("已提交");
		//.parent().children("a.preview").removeClass("disabled");
	}
}
//新增作者二动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor2","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3").slideDown();
	$("#<?php echo $id;?> #baomingbiao > div.author2").slideDown();
//	$(this).hide();
	$(this).removeClass("addAuthor2").addClass("removeAuthor2").html("取消作者二");
});
//取消作者二动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor2","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.author2").slideUp();
//	$(this).hide();
	$(this).removeClass("removeAuthor2").addClass("addAuthor2").html("添加作者二");
	//清空字段 
	$("#<?php echo $id;?> #baomingbiao > div.author2 > div.line > div.right > input").val("");
	$("#<?php echo $id;?> #baomingbiao > div.author2 > div.line > div.right > select > option").eq(0).prop("selected",true);
	$("#<?php echo $id;?> #baomingbiao > div.author2 > div.line > div.right > div.imgPreview > img").prop("src","");
});
//新增作者三动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor3","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.author3").slideDown();
	$("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45").slideDown();
//	$(this).hide();
	$(this).removeClass("addAuthor3").addClass("removeAuthor3").html("取消作者三");
});
//取消作者三动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor3","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.author3").slideUp();
//	$(this).hide();
	$(this).removeClass("removeAuthor3").addClass("addAuthor3").html("添加作者三");
	//清空字段 
	$("#<?php echo $id;?> #baomingbiao > div.author3 > div.line > div.right > input").val("");
	$("#<?php echo $id;?> #baomingbiao > div.author3 > div.line > div.right > select > option").eq(0).prop("selected",true);
	$("#<?php echo $id;?> #baomingbiao > div.author3 > div.line > div.right > div.imgPreview > img").prop("src","");
});
//新增作者四五动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.addAuthor45","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.author45").slideDown();
//	$(this).hide();
	$(this).removeClass("addAuthor45").addClass("removeAuthor45").html("取消作者四五");
});
//取消作者四五动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.removeAuthor45","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.author45").slideUp();
//	$(this).hide();
	$(this).removeClass("removeAuthor45").addClass("addAuthor45").html("添加作者四五");
	//清空字段 
	$("#<?php echo $id;?> #baomingbiao > div.author45 > div.line > div.right > input").val("");
	$("#<?php echo $id;?> #baomingbiao > div.author45 > div.line > div.right > select > option").eq(0).prop("selected",true);
	$("#<?php echo $id;?> #baomingbiao > div.author45 > div.line > div.right > div.imgPreview > img").prop("src","");
});
//增加指导老师二动作
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.addArtTeacher","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.artTeacher").slideDown();
//	$(this).hide();
	$(this).removeClass("addArtTeacher").addClass("removeArtTeacher").html("取消指导老师二");
});
//取消指导老师二
$(document).delegate("#<?php echo $id;?> #baomingbiao > div.line > div.removeArtTeacher","click",function(){
	$("#<?php echo $id;?> #baomingbiao > div.artTeacher").slideUp();
	$(this).removeClass("removeArtTeacher").addClass("addArtTeacher").html("添加指导老师二");
	//清空字段 
	$("#<?php echo $id;?> #baomingbiao > div.artTeacher > div.line > div.right > input").val("");
});
//保存报名表动作
$(document).delegate("#<?php echo $id;?> #baoming > div.ctr > div.save","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		//alert($("#baomingbiao").serialize());
		var data = $("#<?php echo $id;?> #baomingbiao").serialize();
		data+="&workId="+$("#<?php echo $id;?> > input.workId").val();
	//	alert(data);
	//	return;
		$(this).addClass("disabled");
		//alert("a");
		//alert(data);
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
			//	alert(result);
			$("#<?php echo $id;?> #baoming > div.ctr > div.save").removeClass("disabled");
			if(result == "ok")
			{
				showBaomingBiaoE("保存成功!");
				return;
			}
			else if(result == "tooFast")
			{
				showBaomingBiaoE("你操作太快了！");
				return;
			}
			else
			{
				showBaomingBiaoE("保存失败!");
				return;
			}
		});
	}
});
//预览报名表
//从报名表中移到了外面
//$(document).delegate("#<?php echo $id;?> #baoming > div.ctr > div.preview","click",function(){
$(document).delegate("#<?php echo $id;?> > div.main > div > ul > li > div.preview,#<?php echo $id;?> #zuopinshuoming > div.line > div.left > div.preview,#<?php echo $id?> #dayin > div.block > div.line > div.dayin","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var workId = $("#<?php echo $id;?> > input.workId").val();
		window.open("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/viewWork?id="+workId,"_blank");
	}
});
//引入报名表提交确认 
//提交报名表动作
$(document).delegate("#<?php echo $id;?> #baoming > div.ctr > div.submit","click",function(){
if(!$(this).hasClass("disabled"))
{
	<?php
		/*
			本地检查字段是否为空，服务端不检查，有空的就返回错误，有两个不同的submit方法，方法要首先检查字段是否合法,然后检查是否为空(有些可以为空)
		*/
	?>
	//遍历检查输入是否空,input,textarea,
	var ok = true;
	$("#<?php echo $id;?> #baomingbiao input").each(function(){
		if($(this).val() == "")//空输入
		{
			//alert($(this).attr("name"));
			//alert($(this).parent().parent().children("div.left").html());
			if(($(this).attr("name").indexOf("author2") < 0) && ($(this).attr("name").indexOf("author3") < 0) 
			&& ($(this).attr("name").indexOf("author4") < 0) && ($(this).attr("name").indexOf("author5") < 0) 
			&& ($(this).attr("name").indexOf("artTeacher") < 0)
			&& ($(this).attr("name").indexOf("techTeacher") < 0)
			)//排除作者二与作者三,两个指导老师 ,作者四五
			{
				showBaomingBiaoE($(this).parent().parent().children("div.left").html()+"不能为空!");
				//alert($(this).attr("name"));
				ok = false;
				return false;
			}
		}
	});
	if(!ok)
	{
		return false;
	}
//	alert("v");
	$("#<?php echo $id;?> #baomingbiao textarea").each(function(){
		if($(this).val() == "")//空输入
		{
			//alert($(this).attr("name"));
			//alert($(this).parent().parent().children("div.left").html());
			showBaomingBiaoE($(this).parent().parent().children("div.left").html()+"不能为空!");
			ok = false;
			return false;
		}
	});
	//检查作者1的类别
	//alert("a");
	//alert($("#<?php echo $id;?> #baomingbiao select.author1TypeId > option:selected").val());
	//if($("#<?php echo $id;?> #baomingbiao select.author1TypeId > option:selected").length == 0)//不是用此检查，因为设置了一个空项供默认
	if($("#<?php echo $id;?> #baomingbiao select.author1TypeId > option:selected").val() == "")
	{
		showBaomingBiaoE("请选择作者一院系类别!");
		ok = false;
	}
	if(!ok)
	{
		return false;
	}
	
	var data = $("#baomingbiao").serialize();
	data+="&workId="+$("#<?php echo $id;?> > input.workId").val();
	//禁用提交按钮
	$(this).addClass("disabled");
	showBaomingBiaoE("<div class='loading'></div>");
	//提交一次保存，后显示确认信息
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
			//	alert(result);
			$("#<?php echo $id;?> #baoming > div.ctr > div.submit").removeClass("disabled");
			if(result == "ok")
			{
				showBaomingBiaoE("保存成功!显示提交预览信息中..");
				workId = $("#<?php echo $id;?> > input.workId").val();
				$("#<?php echo $id?> > div.baomingbiaoModal > input.workId").val(workId).change();
				return;
			}
			else if(result == "tooFast")
			{
				showBaomingBiaoE("你操作太快了！");
				return;
			}
			else
			{
				showBaomingBiaoE("保存失败!请重试");
				return;
			}
		});
}
});
//****引入提交报名表确认
$(document).delegate("#<?php echo $id?> > div.baomingbiaoModal > input.workId","change",function(){
	//调整高度 
	$(this).parent().css("top",$(window).scrollTop()+100+"px")
		.modal("show")
		.children("div.modal-body")
			.children("div.wrapLoading").show().end()
			.children("div.content").hide().end()
		.end().find("div.modal-footer > span.confirmE").html("");
		
	//获取提交信息
	var data = {};
	data.workId = $(this).val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/getBaomingbiao",data,function(result){
	//alert(result);
		//填写afterLock,有报名表，以及上传纸质文件
			for(var name in result)
			{
				//直接填入此div.afterLock下的所有字段 
				//div.baomingbiaoF(注意这里有一些字段会失陪)
				if($("#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div."+name+" > div.right > div.imgPreview").length == 0)
				{
					$("#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div."+name).children("div.right").html(result[name]);
				}
				else
				{
					$("#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content > div."+name+" > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				
			}
		$("#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.content").show();
		$("#<?php echo $id;?> > div.baomingbiaoModal > div.modal-body > div.wrapLoading").hide();
	},'json');
});
//报名表确认
$(document).delegate("#<?php echo $id?> > div.baomingbiaoModal > div.modal-footer > div.submitBaomingbiao","click",function(){
if(!$(this).hasClass("disabled")){
	var data = {};data.workId = $(this).parent().parent().children("input.workId").val();
	//显示提交中。。
	$(this).parent().parent().find("div.modal-footer > span.confirmE").html("提交中...");
	$(this).addClass("disabled");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/submitBaoming",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > div.baomingbiaoModal > div.modal-footer > div.submitBaomingbiao").removeClass("disabled");
			$("#<?php echo $id?> > div.baomingbiaoModal").modal("hide");
			if(result == "ok")
			{				
				//showBaomingbiaoE("提交成功");//so wired!!
				$("#<?php echo $id;?> > input.workId").change();
				$("#<?php echo $id;?> #baoming > div.ctr > span.baomingE").html("提交成功");
				setTimeout(function(){
					$("#<?php echo $id;?> #baoming > div.ctr > span.baomingE").html("");
				},4000);
				return;
			}
			else if(result == "hasNull")
			{
				showBaomingbiaoE("提交出错，请检查是否数据缺漏");
				return;
			}
			else if(result == "tooFast")
			{
				showBaomingBiaoE("你操作太快了！");
				return;
			}
			else
			{
				showBaomingbiaoE("提交出错，请刷新页面!");
				return;
			}
		});
}
});
//保存报名表纸质版，版权声明
$(document).delegate("#<?php echo $id?> #dayin > div.uploadBaomingbiao > div.ctr > div.save","click",function(){
	//alert("a");
	if(!$(this).hasClass("disabled"))
	{
		//alert($(this).parent().parent().find("div.gaizhang > div.right > input.gaizhang").val());
		if($(this).parent().parent().find("div.gaizhang > div.right > input.gaizhang").val() != "")
		{
			var data = {};
			data.workId = $("#<?php echo $id;?> > input.workId").val();
			data.baomingImgAddr = $(this).parent().parent().find("div.gaizhang > div.right > input.gaizhang").val();
			$(this).addClass("disabled");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
				//alert(result);	
				$("#<?php echo $id?> #dayin > div.block > div.ctr > div.save").removeClass("disabled");
				if(result == "tooFast")
				{
					showBaomingBiaoDayinE("你操作太快了！");
					return;
				}
				else if(result == "ok")
				{
					showBaomingBiaoDayinE("保存成功!");
				}
				else
				{
					showBaomingBiaoDayinE("保存失败");
				}
				return;
			});
		}
	}
});
function showBaomingBiaoDayinE(str)
{
	$("#baomingbiaoDaYinE").html(str);
	setTimeout(function(){
		$("#baomingbiaoDaYinE").html("");
	},3000);
}
$(document).delegate("#<?php echo $id?> #dayin > div.uploadBanquan > div.ctr > div.save","click",function(){
	//alert("a");
	if(!$(this).hasClass("disabled"))
	{
		if($(this).parent().parent().find("div.banquan > div.right > input.banquan").val() != "")
		{
			var data = {};
			data.workId = $("#<?php echo $id;?> > input.workId").val();
			data.banquanImgAddr = $(this).parent().parent().find("div.banquan > div.right > input.banquan").val();
			$(this).addClass("disabled");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
				//alert(result);	
				$("#<?php echo $id?> #dayin > div.block > div.ctr > div.save").removeClass("disabled");
				if(result == "tooFast")
				{
					showBanquanDayinE("你操作太快了！");
					return;
				}
				else if(result == "ok")
				{
					showBanquanDayinE("保存成功!");
				}
				else
				{
					showBanquanDayinE("保存失败");
				}
				return;
			});
		}
	}
});
function showBanquanDayinE(str)
{
	$("#banquanDaYinE").html(str);
	setTimeout(function(){
		$("#banquanDaYinE").html("");
	},3000);
}
function showBaomingBiaoE(str)
{
	$("#<?php echo $id;?> #baoming > div.ctr > span.baomingE").html(str);
	setTimeout(function(){
		$("#<?php echo $id;?> #baoming > div.ctr > span.baomingE").html("");
	},3000);
}
//*******************************************
//作品说明动作
function resetShuomingCtr(str)
{
	if(str == "beforeLock")
	{
		//未提交，显示“提交”，“保存”
		$("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.submit").removeClass("disabled").html("提交")
	}
	else
	{
		$("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.submit").addClass("disabled").html("已提交")
	}
}
//保存作品说明
/*
$(document).delegate("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.save","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var data = {};
		data.workId = $("#<?php echo $id;?> > input.workId").val();
		data.workInstallNote = workInstallNote.getData();
		data.workPreview = workPreview.getData();
		data.workDesignNote = workDesignNote.getData();
		data.workDifficulties = workDifficulties.getData();
		data.teacherComment = teacherComment.getData();
		data.otherNote = otherNote.getData();
		$(this).addClass("disabled");
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.save").removeClass("disabled");
			if(result == "ok")
			{
				showShuomingE("保存成功！");
			}
			else
			{
				showShuomingE("保存出错，请刷新页面!");
				return;
			}
		});
	}
});
*/
//分开保存作品说明//废弃，使用单个ckeditor来保存
/*
$(document).delegate("#<?php echo $id;?> #zuopinshuoming > div.line > div.left > div.save","click",function(){
	//alert("as");
	if(!$(this).hasClass("disabled"))
	{
		$(this).addClass("disabled")
			.siblings("span.saveE").html("<div class='loading'></div>");
		var data = {};
		data.workId = $("#<?php echo $id;?> > input.workId").val();
		if($(this).parent().parent().hasClass("workInstallNote"))
		{
			data.workInstallNote = workInstallNote.getData();
		}else if($(this).parent().parent().hasClass("workPreview"))
		{
			data.workPreview = workPreview.getData();
		}else if($(this).parent().parent().hasClass("workDesignNote"))
		{
			data.workDesignNote = workDesignNote.getData();
		}else if($(this).parent().parent().hasClass("workDifficulties"))
		{
			data.workDifficulties = workDifficulties.getData();
		}else if($(this).parent().parent().hasClass("teacherComment"))
		{
			data.teacherComment = teacherComment.getData();
		}else if($(this).parent().parent().hasClass("otherNote"))
		{
			data.otherNote = otherNote.getData();
		}
		$.ajax({
			url:"<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",
			type:"POST",
			data:data,
			context:$(this),
			success:function(result){
			//	alert(result);
				if(result == "tooFast")
				{
					$(this).removeClass("disabled")
						.siblings("span.saveE").html("你操作太快了");
					
				}
				else
				{
					$(this).removeClass("disabled")
						.siblings("span.saveE").html("保存成功");
				}
				//清空
				setTimeout(function(){
					$("#<?php echo $id;?> #zuopinshuoming > div.line > div.left > span.saveE").html("")
				},4000);
				
			},
			error:function(XMLHttpRequest,textStatus){
				// alert(XMLHttpRequest.status);
                  //      alert(XMLHttpRequest.readyState);
                    //    alert(textStatus);
				$(this).siblings("span.saveE").html("保存失败");
			}
		});
	}
});
*/
//点击作品说明中的修改按钮，获取workId与种类，打开shuoming modal,载入相关信息，
$(document).delegate("#<?php echo $id;?> #shuoming > div.beforeLock > form > div.block > div.title > div.change","click",function(){
	var data = {};
	data['workId'] = $("#<?php echo $id?> > input.workId").val();
	data['type'] = $(this).parent().parent().children("input.mark").val();
	$("#<?php echo $id?> > div.shuomingEditModal > input.workId").val(data['workId']);
	$("#<?php echo $id?> > div.shuomingEditModal > input.type").val(data['type']);
	var title = $(this).parent().children("span").html();
	//alert(type);
	var workIdStr = <?php echo IDADDUP ;?>+parseInt(data['workId']);
	//调整modal高度
	//显示modal
	//显示载入中
	//调整高度 
	$("#<?php echo $id?> > div.shuomingEditModal").css("top",$(window).scrollTop()+100+"px")
		.modal("show")
		.children("div.modal-body")
			.children("div.wrapLoading").show().end()
			.children("div.content").hide().end()
		.end().find("div.modal-footer > span.saveE").html("");
	$("#<?php echo $id?> > div.shuomingEditModal > div.modal-header > h3 > span.workTitle")
		.children("span.workId").html(workIdStr).end()
		.children("span.mark").html(title);
		
	//给modal载入信息
	$.post("<?php echo Yii::app()->baseUrl?>/index.php/competitor/getShuomingEdit",data,function(result){
		//alert(result);
		stuffx.setData(result["a"]);
		$("#<?php echo $id?> > div.shuomingEditModal > div.modal-body")
			.children("div.wrapLoading").hide().end()
			.children("div.content").show().end();
	},'json');
});
//点击说明修改modal中的保存,保存完成就刷新
$(document).delegate("#<?php echo $id?> > div.shuomingEditModal > div.modal-footer > div.save","click",function(){
if(!$(this).hasClass("disabled"))
{
	var data = {};
	data['workId'] = $(this).parents("div.shuomingEditModal").children("input.workId").val();
	var type = $(this).parents("div.shuomingEditModal").children("input.type").val();
	data[type] = stuffx.getData();
	$(this).addClass("disabled");
	$.ajax({
			url:"<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",
			type:"POST",
			data:data,
			context:$(this),
			success:function(result){
			//	alert(result);
				if(result == "tooFast")
				{
					$(this).removeClass("disabled")
						.siblings("span.saveE").html("你操作太快了");
					
				}
				else
				{
					$(this).removeClass("disabled")
						.siblings("span.saveE").html("保存成功");
					//刷新作品信息
					$("#<?php echo $id?> > input.workId").change();
				}
				//清空
				setTimeout(function(){
					$("#<?php echo $id?> > div.shuomingEditModal > div.modal-footer > span.saveE").html("")
				},4000);
				
			},
			error:function(XMLHttpRequest,textStatus){
				// alert(XMLHttpRequest.status);
                  //      alert(XMLHttpRequest.readyState);
                    //    alert(textStatus);
				$(this).siblings("span.saveE").html("保存失败")
					.removeClass("disabled");
			}
		});
}
});
//提交作品说明(获取确认信息)
$(document).delegate("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.submit","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		//所有的都自动保存//不，有保存与预览时差
	//	$("#<?php echo $id;?> #zuopinshuoming > div.line > div.left > div.save").click();
		workId = $("#<?php echo $id;?> > input.workId").val();
		$("#<?php echo $id?> > div.shuomingModal > input.workId").val(workId).change();
	/*	var data = {};
		data.workInstallNote = workInstallNote.getData();
		data.workPreview = workPreview.getData();
		data.workDesignNote = workDesignNote.getData();
		data.workDifficulties = workDifficulties.getData();
		data.teacherComment = teacherComment.getData();
		data.otherNote = otherNote.getData();	
		//alert(data.otherNote);
		//检查空输入
		for(var name in data)
		{
			if((name != "workId") && (name != "otherNote") && (name != "teacherComment"))
			{
				if(data[name] == "")
				{
					showShuomingE("前四项不能留空!");
					return;
				}
			}
		}*/
		
		/*
		$(this).addClass("disabled");
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/submitShuoming",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > div.main > div > div.tab-content > #shuoming > div.ctr > div.submit").removeClass("disabled");
			if(result == "ok")
			{
				showShuomingE("提交成功！");
				//刷新
				$("#<?php echo $id;?> > input.workId").change();
			}
			else
			{
				showShuomingE("提交出错，请刷新页面!");
				return;
			}
		});
		*/
	}
});
//提交作品说明
$(document).delegate("#<?php echo $id?> > div.shuomingModal > div.modal-footer > div.submitShuoming","click",function(){
if(!$(this).hasClass("disabled")){
	var data = {};data.workId = $(this).parent().parent().children("input.workId").val();
	//显示提交中。。
	$(this).parent().parent().find("div.modal-footer > span.confirmE").html("提交中...");
	$(this).addClass("disabled");
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/submitShuoming",data,function(result){
			//alert(result);
			$("#<?php echo $id?> > div.shuomingModal > div.modal-footer > div.submitShuoming").removeClass("disabled");
			$("#<?php echo $id?> > div.shuomingModal").modal("hide");
			if(result == "ok")
			{
				showShuomingE("提交成功！");
				//刷新
				$("#<?php echo $id;?> > input.workId").change();
			}
			else if (result == "hasNull")
			{
				showShuomingE("前四项不能有留空!");
				return;
			}
			else if (result == "tooFast")
			{
				showShuomingE("你操作太快了!");
				return;
			}
			else
			{
				showShuomingE("提交出错，请刷新页面!");
				return;
			}
		});
}
});
//****引入提交作品相关说明确认
$(document).delegate("#<?php echo $id?> > div.shuomingModal > input.workId","change",function(){
	//调整高度 
	$(this).parent().css("top",$(window).scrollTop()+100+"px")
		.modal("show")
		.children("div.modal-body")
			.children("div.wrapLoading").show().end()
			.children("div.content").hide().end()
		.end().find("div.modal-footer > span.confirmE").html("");
		
	//获取提交信息
	var data = {};
	data.workId = $(this).val();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/getShuoming",data,function(result){
	//alert(result);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.workInstallNote > div.right").html(result.workInstallNote);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.workPreview > div.right").html(result.workPreview);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.workDesignNote > div.right").html(result.workDesignNote);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.workDifficulties > div.right").html(result.workDifficulties);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.teacherComment > div.right").html(result.teacherComment);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content > div.otherNote > div.right").html(result.otherNote);
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.content").show();
		$("#<?php echo $id;?> > div.shuomingModal > div.modal-body > div.wrapLoading").hide();
	},'json');
});

function showShuomingE(str)
{
	$("#<?php echo $id;?> #shuoming > div.ctr > span.shuomingE").html(str);
	setTimeout(function(){
		$("#<?php echo $id;?> #shuoming > div.ctr > span.shuomingE").html("");
	},5000);
}
//*************************下面是部署 ，寄汇动作
//部署的保存动作
$(document).delegate("#<?php echo $id;?> #bushu > div.block > div.save","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var data = {};
		data.workId = $("#<?php echo $id;?> > input.workId").val();
		data.workPreviewAddr1 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr1").val();
		data.workPreviewAddr2 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr2").val();
		data.workPreviewAddr3 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr3").val();
		data.workPreviewAddr4 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr4").val();
		data.workPreviewAddr5 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.workPreviewAddr5").val();
		data.deployAddr1 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.deployAddr1").val();
		data.deployAddr2 = $("#<?php echo $id;?> #bushu > div.block > div.line > div.right > input.deployAddr2").val();
		$(this).addClass("disabled");
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
			//alert(result);
			$("#<?php echo $id;?> #bushu > div.block > div.save").removeClass("disabled");
			if(result == "ok")
			{
				showBushuE("保存成功!");
				return;
			}else if(result == "tooFast")
			{
				showBushuE("你操作太快了");
				return;
			}
			else
			{
				showBushuE("保存失败");
				return;
			}
		});
	}
});
$(document).delegate("#<?php echo $id;?> #jihui > div.block > div.save","click",function(){
	if(!$(this).hasClass("disabled"))
	{
		var data = {};
		data.workId = $("#<?php echo $id;?> > input.workId").val();
		data.transferImgAddr = $("#<?php echo $id;?> #jihui > div.block > div.line > div.right > input.transferImgAddr").val();
		$(this).addClass("disabled");
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/competitor/saveWork",data,function(result){
			//alert(result);
			$("#<?php echo $id;?> #jihui > div.block > div.save").removeClass("disabled");
			if(result == "ok")
			{
				showJihuiE("保存成功!");
				return;
			}else if(result == "tooFast")
			{
				showJihuiE("你操作太快了");
				return;
			}
			else
			{
				showJihuiE("保存失败");
				return;
			}
		});
	}
});
function showBushuE(str)
{
	$("#<?php echo $id;?> #bushu > div.block > div.bushuE").html(str);
	setTimeout(function(){
		$("#<?php echo $id;?> #bushu > div.block > div.bushuE").html("");
	},3000);
}
function showJihuiE(str)
{
	$("#<?php echo $id;?> #jihui > div.block > div.jihuiE").html(str);
	setTimeout(function(){
		$("#<?php echo $id;?> #jihui > div.block > div.jihuiE").html("");
	},3000);
}

</script>
<div id="<?php echo $id;?>">
	<div class="modal hide fade shuomingModal" id="shuomingModal" style="position:absolute;margin-left:-400px;width:800px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<input class="workId" type="hidden" value=""></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	   		<h3 style='line-height:25px'>
	 			<span class="workTitle">确认提交作品说明</span>
	   		</h3>
		</div>
		<div class='modal-body'>
			<div class="wrapLoading"><div class="loading"></div></div>
			<div class="content" style="display:none">
			<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
    										"name" => "workInstallNote",
    										"title" => "作品安装说明",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workPreview",
    										"title" => "作品效果图",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDesignNote",
    										"title" => "作品思路",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDifficulties",
    										"title" => "设计重点难点",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "teacherComment",
    										"title" => "指导老师自评",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "otherNote",
    										"title" => "其他说明",
    										"type" => "text",
    										"text" => "",
    									),
    						),
    					));?>
			</div>
		</div>
		<div class="modal-footer">
	 		<span style="font-size:13px;color:red" class="confirmE"></span>
			<div class="btn btn-success submitShuoming">确认提交</div>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
		</div>
	</div><!--modal-->
	<div class="modal hide fade shuomingEditModal" id="shuomingEditModal" style="position:absolute;margin-left:-400px;width:800px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<input class="workId" type="hidden" value=""></input>
		<input class="type" type="hidden" value=""></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	   		<h3 style='line-height:25px'>
	 			<span class="workTitle">
	 				作品 <span class="workId"></span> :
	 				<span class="mark"></span>(关闭编辑框前记得保存)(点击黑色区域也会关闭编辑框)
	 			</span>
	   		</h3>
		</div>
		<div class='modal-body'>
			<div class="wrapLoading"><div class="loading"></div></div>
			<div class="content" style="display:none">
			<?php $this->widget("TablrWidget",array(
			"editorConfig" =>  array(
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
				//'/',
				array('Styles','Font','FontSize'),
				array('TextColor','BGColor'),
				
				array('Image','Flash','Link') 
			),
			'width' => '750px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		),
    						"param" => array(
    								array(
										"name" => "stuffx",
										"type" => "ckeditor",
										"title" => "",
								)	
    						),
    					));?>
			</div>
		</div>
		<div class="modal-footer">
	 		<span style="font-size:13px;color:red" class="saveE"></span>
			<div class="btn btn-success save">保存修改</div>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
		</div>
	</div><!--modal-->
	<div class="modal hide fade baomingbiaoModal" id="baomingbiaoModal" style="position:absolute;margin-left:-400px;width:800px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<input class="workId" type="hidden" value=""></input>
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	   		<h3 style='line-height:25px'>
	 			<span class="workTitle">确认提交报名表</span>
	 			<span style="font-size:13px;color:red" class="confirmE"></span>
	   		</h3>
		</div>
		<div class='modal-body'>
			<div class="wrapLoading"><div class="loading"></div></div>
			<div class="content" style="display:none">
			<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
    								"name" => "workTitle",
    								"title" => "作品名称",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "workTypeName",
    								"title" => "作品类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "title",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者信息"
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者一"
    							),
    							array(
    								"name" => "author1Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author1SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者二"
    							),
    							array(
    								"name" => "author2Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author2SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者三"
    							),
    							array(
    								"name" => "author3Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author3SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者四"
    							),
    							array(
    								"name" => "author4Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author4SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者五"
    							),
    							array(
    								"name" => "author5Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author5SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师一信息"
    								),
    								array(
	    								"name" => "techTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师二信息"
    								),
    								array(
	    								"name" => "artTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "单位联系人信息"
    								),
    								array(
	    								"name" => "unitContactName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactJob",
    									"title" => "职务",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPost",
    									"title" => "邮编",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactAddr",
    									"title" => "地址",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "shareAgreement",
    									"title" => "共享协议",
    									"type" => "text",
    									"text" => "作者同意大赛组委会将该作品列入集锦出版发行。",
    								),
    								array(
    									"name" => "schoolRec",
    									"title" => "学校推荐意见",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "origAgreement",
    									"title" => "原创声明",
    									"type" => "text",
    									"text" => "声明：本参赛作品为我们原创构思和使用正版软件制作，我们对参赛作品拥有完整、合法的著作权或其他相关之权利，绝无侵害他人著作权、商标权、专利权等知识产权或违反法令或其他侵害他人合法权益的情况。若因此导致任何法律纠纷，一切责任应由我们（作品提交人）自行承担。",
    								),
    								array(
    									"name" => "workIntro",
    									"title" => "作品简介",
    									"type" => "text",
    									"text" => "",
    								),
    						),
    					));?>
			</div>
		</div>
		<div class="modal-footer">
 			<span style="font-size:13px;color:red" class="confirmE"></span>
			<div class="btn btn-success submitBaomingbiao">确认提交</div>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
		</div>
	</div><!--modal-->
	<input class="workId" type="hidden" value=""></input>
	<div class="main">
		<div class="title"></div>
		<div class="tabbable">
			<div class="workEditLoading" style="display:none">
				<div class="wrapLoading"><div class="loading"></div></div>
			</div>
			<ul class="nav nav-tabs">
				<li class="active"><a class='baoming' href="#baoming" data-toggle="tab">报名表 <span class="status" style="color:red;font-size:16px;">	</span></a></li>
				<li><a class='shuoming' href="#shuoming" data-toggle="tab">作品相关说明 <span class="status" style="color:red;font-size:16px;">	</span></a></li>
				<li><a class='dayin' href="#dayin" data-toggle="tab">报名表打印上传等</a></li>
				<li><a class='bushu' href="#bushu" data-toggle="tab">作品部署、查阅与上传链接填写</a></li>
				<li><a class='jihui' href="#jihui" data-toggle="tab">寄汇报名费</a></li>
				<!--<li><div class="btn btn-success preview">预览</div></li>-->
    		</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="baoming">
					<div class="head ctr">
						报名表
    					<div class="btn btn-primary save">保存</div>
    					<div class="btn btn-danger submit" title="注意提交后不可更改!">提交</div>
    					<!--<div class="btn btn-success preview" title="填写完毕提交后才可预览">预览报名表</div>-->
    					<span class="baomingE"></span>
					</div>
    				<div class="beforeLock">		
    					<form id="baomingbiao">
    					<?php
    						if($school !== "")
    						{
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "school",
    										"title" => "学校",
    										"type" => "text",
    										"text" => $school,
    									),
    								),
    							));
    						}
    					?>
    					<?php $this->widget("TablrWidget",array(
    						"noSelectDefault" => true,
    						"param" => array(
    							array(
    								"name" => "workTitle",
    								"title" => "作品名称",
    								"size" => "xlarge",
    							),
    							array(
    								"name" => "title",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者信息"
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者一"
    							),
    							array(
    								"name" => "author1Name",
    								"title" => "姓名",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1TypeId",
    								"title" => "院系类别",
    								"type" => "select",
    								"param" => $authorTypeArr,
    							),
    							array(
    								"name" => "author1Major",
    								"title" => "专业",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1Grade",
    								"title" => "年级",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1Email",
    								"title" => "电邮",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1PhoneNum",
    								"title" => "电话",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1IDNum",
    								"title" => "身份证",
    								"size" => "large",
    							),
    							array(
    								"name" => "author1HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    							),
    							array(
    								"name" => "author1SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"tailNotice" => "将学生证中含姓名和专业的页面上传。如不在一页请合成一张图片上传。",
    							),
    						),
    					));?>
    					<div class="line">
    						<div class="btn btn-small addAuthor2">添加作者二</div>
    					</div>
    					<div class="author2 author" style="display:none">
    						<?php $this->widget("TablrWidget",array(
    							"noSelectDefault" => true,
    							"param" => array(
    								array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者二"
    							),
    							array(
    								"name" => "author2Name",
    								"title" => "姓名",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2TypeId",
    								"title" => "院系类别",
    								"type" => "select",
    								"param" => $authorTypeArr
    							),
    							array(
    								"name" => "author2Major",
    								"title" => "专业",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2Grade",
    								"title" => "年级",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2Email",
    								"title" => "电邮",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2PhoneNum",
    								"title" => "电话",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2IDNum",
    								"title" => "身份证",
    								"size" => "large",
    							),
    							array(
    								"name" => "author2HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    							),
    							array(
    								"name" => "author2SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"tailNotice" => "将学生证中含姓名和专业的页面上传。如不在一页请合成一张图片上传。",
    							),
    							),
    						));?>
    					</div>
    					<div class="line">
    						<div class="btn btn-small addAuthor3">添加作者三</div>
    					</div>
    					<div class="author3 author" style="display:none">
    						<?php $this->widget("TablrWidget",array(
    							"noSelectDefault" => true,
    							"param" => array(
    								array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者三"
    							),
    							array(
    								"name" => "author3Name",
    								"title" => "姓名",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3TypeId",
    								"title" => "院系类别",
    								"type" => "select",
    								"param" => $authorTypeArr,
    							),
    							array(
    								"name" => "author3Major",
    								"title" => "专业",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3Grade",
    								"title" => "年级",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3Email",
    								"title" => "电邮",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3PhoneNum",
    								"title" => "电话",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3IDNum",
    								"title" => "身份证",
    								"size" => "large",
    							),
    							array(
    								"name" => "author3HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    							),
    							array(
    								"name" => "author3SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"tailNotice" => "将学生证中含姓名和专业的页面上传。如不在一页请合成一张图片上传。",
    							),
    							),
    						));?>
    					</div>
    					<div class="line">
    						<div class="btn btn-small addAuthor45">添加作者四五</div>
    					</div>
    					<div class="author45 author" style="display:none">
    						<?php $this->widget("TablrWidget",array(
    							"noSelectDefault" => true,
    							"param" => array(
    								array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者四"
    							),
    							array(
    								"name" => "author4Name",
    								"title" => "姓名",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4TypeId",
    								"title" => "院系类别",
    								"type" => "select",
    								"param" => $authorTypeArr,
    							),
    							array(
    								"name" => "author4Major",
    								"title" => "专业",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4Grade",
    								"title" => "年级",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4Email",
    								"title" => "电邮",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4PhoneNum",
    								"title" => "电话",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4IDNum",
    								"title" => "身份证",
    								"size" => "large",
    							),
    							array(
    								"name" => "author4HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    							),
    							array(
    								"name" => "author4SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"tailNotice" => "将学生证中含姓名和专业的页面上传。如不在一页请合成一张图片上传。",
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者五"
    							),
    							array(
    								"name" => "author5Name",
    								"title" => "姓名",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5TypeId",
    								"title" => "院系类别",
    								"type" => "select",
    								"param" => $authorTypeArr,
    							),
    							array(
    								"name" => "author5Major",
    								"title" => "专业",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5Grade",
    								"title" => "年级",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5Email",
    								"title" => "电邮",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5PhoneNum",
    								"title" => "电话",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5IDNum",
    								"title" => "身份证",
    								"size" => "large",
    							),
    							array(
    								"name" => "author5HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    							),
    							array(
    								"name" => "author5SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"tailNotice" => "将学生证中含姓名和专业的页面上传。如不在一页请合成一张图片上传。",
    							),
    							),
    						));?>
    					</div>
    					<?php 
    						$this->widget("TablrWidget",array(
    							"param" => array(
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师一信息"
    								),
    								array(
	    								"name" => "techTeacherName",
    									"title" => "姓名",
    									"size" => "large",
    								),
    								array(
	    								"name" => "techTeacherUnit",
    									"title" => "单位",
    									"size" => "large",
    								),
    								array(
	    								"name" => "techTeacherPhoneNum",
    									"title" => "电话",
    									"size" => "large",
    								),
    								array(
	    								"name" => "techTeacherEmail",
    									"title" => "电邮",
    									"size" => "large",
    								),
    							),
    						));
    					?>
    					<div class="line">
    						<div class="btn btn-small addArtTeacher">添加指导老师二</div>
    					</div>
    					<div class="artTeacher author" style="display:none">
    					<?php 
    						$this->widget("TablrWidget",array(
    							"param" => array(
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师二信息"
    								),
    								array(
	    								"name" => "artTeacherName",
    									"title" => "姓名",
    									"size" => "large",
    								),
    								array(
	    								"name" => "artTeacherUnit",
    									"title" => "单位",
    									"size" => "large",
    								),
    								array(
	    								"name" => "artTeacherPhoneNum",
    									"title" => "电话",
    									"size" => "large",
    								),
    								array(
	    								"name" => "artTeacherEmail",
    									"title" => "电邮",
    									"size" => "large",
    								),
    							),
    						));
    					?>
    					</div>
    					<?php 
    						$this->widget("TablrWidget",array(
    							"param" => array(
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "单位联系人信息"
    								),
    								array(
	    								"name" => "unitContactName",
    									"title" => "姓名",
    									"size" => "large",
    								),
    								array(
	    								"name" => "unitContactJob",
    									"title" => "职务",
    									"size" => "large",
    								),
    								array(
	    								"name" => "unitContactPhoneNum",
    									"title" => "电话",
    									"size" => "large",
    								),
    								array(
	    								"name" => "unitContactEmail",
    									"title" => "电邮",
    									"size" => "large",
    								),
    								array(
	    								"name" => "unitContactPost",
    									"title" => "邮编",
    									"size" => "large",
    								),
    								array(
	    								"name" => "unitContactAddr",
    									"title" => "地址",
    									"size" => "xlarge",
    								),
    								array(
    									"name" => "shareAgreement",
    									"title" => "共享协议",
    									"type" => "text",
    									"text" => "作者同意大赛组委会将该作品列入集锦出版发行。",
    								),
    								array(
    									"name" => "schoolRec",
    									"title" => "学校推荐意见",
    									"type" => "textarea",
    									"tailNotice" => "(可在线填写,亦可先提交,并在打印纸质报名表后手工填写)",
    								),
    								array(
    									"name" => "origAgreement",
    									"title" => "原创声明",
    									"type" => "text",
    									"text" => "声明：本参赛作品为我们原创构思和使用正版软件制作，我们对参赛作品拥有完整、合法的著作权或其他相关之权利，绝无侵害他人著作权、商标权、专利权等知识产权或违反法令或其他侵害他人合法权益的情况。若因此导致任何法律纠纷，一切责任应由我们（作品提交人）自行承担。",
    								),
    								array(
    									"name" => "workIntro",
    									"title" => "作品简介(300字内)",
    									"type" => "textarea",
    									"maxLength" => 300,
    								),
    							),
    						));
    					?>
    					
    				
    					</form>
    					<div style="padding:30px" class="changeWorkType">
    					<div class="title">修改作品类别</div>
    					<?php $this->widget("ChangeWorkTypeWidget",array(
    						"id" => "changeWorkType",
    						"triggerSelectors" => array(
    							"#".$id." > input.workId",
    						),
    					));?>
    					</div>
    				</div>
    				<div class="afterLock" style="display:none">
    					<div class="baomingbiaoF">
    					<?php
    						if($school !== "")
    						{
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "school",
    										"title" => "学校",
    										"type" => "text",
    										"text" => $school,
    									),
    								),
    							));
    						}
    					?>
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
    								"name" => "workTitle",
    								"title" => "作品名称",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "workTypeName",
    								"title" => "作品类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "title",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者信息"
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者一"
    							),
    							array(
    								"name" => "author1Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author1SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者二"
    							),
    							array(
    								"name" => "author2Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author2SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者三"
    							),
    							array(
    								"name" => "author3Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author3SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者四"
    							),
    							array(
    								"name" => "author4Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author4SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者五"
    							),
    							array(
    								"name" => "author5Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author5SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师一信息"
    								),
    								array(
	    								"name" => "techTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师二信息"
    								),
    								array(
	    								"name" => "artTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "单位联系人信息"
    								),
    								array(
	    								"name" => "unitContactName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactJob",
    									"title" => "职务",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPost",
    									"title" => "邮编",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactAddr",
    									"title" => "地址",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "shareAgreement",
    									"title" => "共享协议",
    									"type" => "text",
    									"text" => "作者同意大赛组委会将该作品列入集锦出版发行。",
    								),
    								array(
    									"name" => "schoolRec",
    									"title" => "学校推荐意见",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "origAgreement",
    									"title" => "原创声明",
    									"type" => "text",
    									"text" => "声明：本参赛作品为我们原创构思和使用正版软件制作，我们对参赛作品拥有完整、合法的著作权或其他相关之权利，绝无侵害他人著作权、商标权、专利权等知识产权或违反法令或其他侵害他人合法权益的情况。若因此导致任何法律纠纷，一切责任应由我们（作品提交人）自行承担。",
    								),
    								array(
    									"name" => "workIntro",
    									"title" => "作品简介",
    									"type" => "text",
    									"text" => "",
    								),
    						),
    					));?>
    					</div>
    					<!--
    					<div class="notice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "baomingbiao",
	    					));?>
    					</div>
    					
    					<div class="uploadBaomingbiao">
    						<div class="line"><div class="btn btn-small btn-info dayin">点击预览报名表</div>
    							请在预览报名表页面中使用浏览器的打印功能打印
    						</div>
    						<?php
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "gaizhang",
    										"title" => "报名表签字盖章后上传",
    										"type" => "img",
    										"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    									),
    								),
    							));
    						?>
    						<div class="ctr">
    							<div class="btn btn-small btn-primary save">保存</div>
    						</div>
    					</div>
    					<div class="uploadBanquan">
    						<?php
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "banquan",
    										"title" => "版权声明",
    										"type" => "img",
    										"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    									),
    								),
    							));
    						?>
    						<div class="ctr">
    							<div class="btn btn-small btn-primary save">保存</div>
    						</div>
    					</div>
    					-->
    				</div>
    			</div>
    			<div class="tab-pane" id="dayin">
    				<div class="head fixedHead">
    					<div class="title">报名表打印上传等</div>					
    				</div><!--head-->
    				
    				<div class="notice block">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "baomingbiao",
	    					));?>
    				</div>
					<div class="uploadBaomingbiao block">
    						<div class="line"><div class="btn btn-small btn-info dayin">点击预览报名表</div>
    							请在预览报名表页面中使用浏览器的打印功能打印
    						</div>
    						<?php
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "gaizhang",
    										"title" => "报名表签字盖章后上传",
    										"type" => "img",
    										"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    									),
    								),
    							));
    						?>
    						<div class="ctr">
    							<div class="btn btn-small btn-primary save">保存</div>
    							<span style="color:red" id="baomingbiaoDaYinE"></span>
    						</div>
    					</div>
    					<div class="uploadBanquan block">
    						<?php
    							$this->widget("TablrWidget",array(
    								"param" => array(
    									array(
    										"name" => "banquan",
    										"title" => "版权声明",
    										"type" => "img",
    										"tailNotice" => "在新开页面中双击图片或者右键进行图片选择"
    									),
    								),
    							));
    						?>
    						<div class="ctr">
    							<div class="btn btn-small btn-primary save">保存</div>
    							<span style="color:red" id="banquanDaYinE"></span>
    						</div>
    					</div>
    			</div>
	    		<div class="tab-pane" id="shuoming">
	    			<div class="head ctr">
    					<!--<div class="btn btn-primary save">保存</div>-->
    					作品相关说明
    					<div class="btn btn-danger submit" title="注意提交后不可更改!">提交</div>
    					<span class="shuomingE"></span>
					</div>
    				<div class="beforeLock">
    					<form id="zuopinshuoming">
    						<div class="workInstallNote block">
    							<input class="mark" type="hidden" value="workInstallNote"></input>
    							<div class="title"><span>作品安装说明</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<div class="workPreview block">
    							<input class="mark" type="hidden" value="workPreview"></input>
    							<div class="title"><span>作品效果图</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<div class="workDesignNote block">
    							<input class="mark" type="hidden" value="workDesignNote"></input>
    							<div class="title"><span>作品思路</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<div class="workDifficulties block">
    							<input class="mark" type="hidden" value="workDifficulties"></input>
    							<div class="title"><span>设计重点难点</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<div class="teacherComment block">
    							<input class="mark" type="hidden" value="teacherComment"></input>
    							<div class="title"><span>指导老师自评</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<div class="otherNote block">
    							<input class="mark" type="hidden" value="otherNote"></input>
    							<div class="title"><span>其他说明</span> <div class='btn btn-small btn-primary change'>修改</div></div>
    							<div class="content"></div>
    						</div>
    						<?php
    						//不使用多个ckeditor,会可能载入困难
    						/*
    							$this->widget("TablrWidget",array(
    								"editorConfig" =>  array(
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
			'width' => '790px',
			'contentsCss' => Yii::app()->theme->baseUrl.'/css/ckeditorReset.css',
			'filebrowserBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html",
			'filebrowserImageBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Images",
			'filebrowserFlashBrowseUrl'=>Yii::app()->baseUrl."/ckfinder/ckfinder.html?Type=Flash",
			'filebrowserUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			'filebrowserImageUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			'filebrowserFlashUploadUrl'=>Yii::app()->baseUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
		),
    								"param" => array(
    									array(
    										"name" => "workInstallNote",
    										"title" => "作品安装说明 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    									array(
    										"name" => "workPreview",
    										"title" => "作品效果图 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    									array(
    										"name" => "workDesignNote",
    										"title" => "作品思路 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    									array(
    										"name" => "workDifficulties",
    										"title" => "设计重点难点 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    									array(
    										"name" => "teacherComment",
    										"title" => "指导老师自评 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    									array(
    										"name" => "otherNote",
    										"title" => "其他说明 <div class='save btn btn-small btn-primary'>保存</div> <div class='btn btn-small btn-success preview'>预览</div> <span class='saveE' style='color:red'></span>",
    										"type" => "ckeditor",
    									),
    								),
    							));
    						*/
    						
    						?>
    					</form>
    				</div><!--shuomin beforeLock-->
    				<div class="afterLock" style="display:none">
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
    										"name" => "workInstallNote",
    										"title" => "作品安装说明",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workPreview",
    										"title" => "作品效果图",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDesignNote",
    										"title" => "作品思路",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDifficulties",
    										"title" => "设计重点难点",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "teacherComment",
    										"title" => "指导老师自评",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "otherNote",
    										"title" => "其他说明",
    										"type" => "text",
    										"text" => "",
    									),
    						),
    					));?>
    				</div>
    			</div>
    			<div class="tab-pane" id="bushu">
    				<div class="head fixedHead">
    					<div class="title">参赛作品上传、部署与查阅链接填写</div>    					
    				</div><!--head--->
    				<div class="block">
    					<div class="bushuMainNotice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "bushuMain",
    						));?>
    					</div>
    				</div>
    				<div class="block">
    					<div class="title">作品查阅链接填写(对象：所有参赛作品)</div>
    					<div class="chayueNotice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "chayue",
    						));?>
    					</div>
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
    								"name" => "workPreviewAddr1",
    								"title" => "参赛文件夹访问网址",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    							array(
    								"name" => "workPreviewAddr2",
    								"title" => "作品文件包",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    							array(
    								"name" => "workPreviewAddr3",
    								"title" => "素材、源码包",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    							array(
    								"name" => "workPreviewAddr4",
    								"title" => "答辩辅助文件",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    							array(
    								"name" => "workPreviewAddr5",
    								"title" => "作品演示视频",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    						),
    					));?>
    					<div class="bushuE"></div>
    					<div class="btn btn-block btn-success save">保存</div>
    				</div>
    				<div class="block">
    					<div class="title">作品部署及网址填写(对象：网站设计和数据库应用类作品)</div>
    					<div class="bushu1Notice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "bushu1",
    						));?>
    					</div>
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
    								"name" => "deployAddr1",
    								"title" => "部署链接1",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    						),
    					));?>
    					<div class="bushu2Notice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "bushu2",
    						));?>
    					</div>
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
    								"name" => "deployAddr2",
    								"title" => "部署链接2",
    								"size" => "xxlarge",
    								"tailNotice" => ' <div class="btn btn-small testLink">测试链接</div>'
    							),
    						),
    					));?>
    					<div class="bushuE"></div>
    					<div class="btn btn-block btn-success save">保存</div>
    				</div>
    				<!--
    				<div class="block">
    					<div class="title">参赛作品相关文件上传(对象：所有参赛作品)</div>
    					<div class="shangchuanNotice">
    						<?php $this->widget("NoticeWidget",array(
    							"name" => "shangchuan",
    						));?>
    					</div>
    				</div>
    				-->
    			</div>
    			<div class="tab-pane" id="jihui">
    				<div class="head fixedHead">
    					<div class="title">寄汇报名费</div>					
    				</div><!--head-->
					<div class="block">
						<div class="title">寄汇参赛报名费并上传汇款凭证</div>
						<div class="jihuiImgNotice">
							<?php $this->widget("NoticeWidget",array(
    							"name" => "jihuiImg",
    						));?>
						</div>
						<?php 
							$this->widget("TablrWidget",array(
								"param" => array(
									array(
										"name" => "transferImgAddr",
										"title" => "",
										"type" => "img",
										"tailNotice" => "在新开页面中双击图片进行选择",
									),
								),
							));
						?>
					</div>
					<div class="block">
						<div class="jihuiE"></div>
    					<div class="btn btn-block btn-success save">保存</div>
    				</div>
					<div class="block">
						<div class="title">寄汇参赛报名费办法</div>
						<div class="jihuiNotice">
							<?php $this->widget("NoticeWidget",array(
    							"name" => "jihui",
    						));?>
						</div>
					</div>
    			</div>
    			
			</div>
		</div>
	</div>
</div>
