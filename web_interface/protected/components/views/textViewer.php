<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<div id="<?php echo $id;?>">
<?php if($showInModal){?>

<div class="modal hide fade" id="<?php echo $id;?>showModal" style="position:absolute;width:700px;margin-left:-350px"><!--to set the modal in the center,margin-left should be (-)half its width-->
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>查看文章</h3>
	</div>
	<div class='modal-body'>
	</div>
</div>
<?php } ?>
<?php if($hasCopyComp){?>

<div class="modal hide fade" id="<?php echo $id;?>copyModal" style="position:absolute;width:500px;margin-left:-250px"><!--to set the modal in the center,margin-left should be (-)half its width-->
	<input type='hidden' id="copyTextId"></input>
	<input type='hidden' id="copyTextCatalogId"></input><?php /*仅用于本地*/ ?>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3 style='line-height:25px'>抄送文章
    		<span class='help-inline' style='font-size:18px'></span>
    	</h3>
	</div>
	<div class='modal-body'>
		<div class='left'>
			<div class='line'><span class='label'>已抄送栏目</span></div>
			<div class='line copiedTo'></div>
		</div>
		<div class='right'>
			<div class='line'><span class='label label-info'>抄送至：</span></div>
			<div class='line'><div class='btn addc2c'>添加栏目</div></div>
			<div class='line copyTo'></div>
		</div>
	</div>
	<div class="modal-footer">
		<span class='help-inline' style='color:orange' id='copyE'></span>
    	<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    	<button class="btn btn-primary copy">确定抄送</button>
    	
	</div>
</div>
<?php } ?>
<style type="text/css"> 
	#<?php echo $id;?>{width:<?php echo $width;?>;border:1px solid #F5D8DB;border-width:1px 1px 0 1px}
	#<?php echo $id;?> div.modal-body{padding:10px}
	#<?php echo $id;?> div.modal-body > div.left{float:left;width:250px;}
	#<?php echo $id;?> div.modal-body > div.left div.copiedBlock{padding:5px}
	#<?php echo $id;?> div.modal-body > div.right{margin:0 0 0 250px;}
	#<?php echo $id;?> div.modal-body > div.right select{width:150px}
	#<?php echo $id;?> div.modal-body > div.right div.alert{margin:0;}
	#<?php echo $id;?> div.modal-body > div > div.line{padding:5px}
	#<?php echo $id;?> #textListDiv div.block{padding:10px;border-bottom:1px solid #F5D8DB;}
	#<?php echo $id;?> #textListDiv div.notice{text-align:center;font-size:13px;}
	#<?php echo $id;?> #textListDiv div.block > div.ctl{height:20px;}
	#<?php echo $id;?> #textListDiv div.block > div.textTitle{cursor:pointer}
	#<?php echo $id;?> #textListDiv div.block > div.ctl > div.btn-link{float:right}
	#<?php echo $id;?> #textListDiv div.block > p.muted{margin:0}/*rewrite bootstrap*/
	#<?php echo $id;?> #textListDiv div.block > p.muted > a{text-decoration:none;color:#999999}
	
	<?php if($hasComComp){?>
	#<?php echo $id;?> #textListDiv div.block > div.comDiv{display:none;}
	
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comInputDiv{width:350px;margin:0 auto}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comInputDiv > input{}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList{}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList > div.comBlock > div.comLine{}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList > div.comBlock > div.comLine > div.replyInputDiv{padding-left:10px}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList > div.comBlock{padding:5px}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList > div.comBlock a{text-decoration:none}
		#<?php echo $id;?> #textListDiv div.block > div.comDiv > div.comList > div.comBlock a.replyTo{display:none;color:blue;font-size:12px;}
	<?php } ?>
</style>
<script type="text/javascript">
<?php if($hasCopyComp) { ?>
	$(document).ready(function(){
		//先获取了栏目列表
		var data = {'data':{'method':'getCatalogById','parentCataIdArr':[1]}};
		$.post("<?php echo $getCataUrl;?>",data,function(result){
				if(result == "error")
				{
					alert("Oops!");
					return;
				}
			<?php echo $id;?>parseCata(result);//把取得的栏目列表载入到全局变量cataData中
			//下面去获取用户列表
		},'json');
	});

var <?php echo $id;?>cataData = new Array();//栏目选择下拉框d的全局变量
function <?php echo $id;?>parseCata(data)
{
	$.each(data,function(key,item){
		var temp = {'id':item.catalogId,'title':item.catalogTitle,'hasText':item.hasText,'cataIntro':item.catalogIntro,'isPublic':item.isPublic};
		<?php echo $id;?>cataData.push(temp);
		if((item.children != null) && (item.children != ""))
		{
			<?php echo $id;?>parseCata(item.children);
		}
	});
}
//定义'抄送'按钮动作 
	$(document).undelegate("#<?php echo $id;?> div.block div.copy","click").delegate("#<?php echo $id;?> div.block div.copy","click",function(){
	//打开抄送框动作已绑定
		//修改审核modal的高度
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal").css('top',($(this).offset().top-200)+'px');
		//填写抄送框题目
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal > div.modal-header > h3 > span").html('"'+$(this).parent().parent('div.block').attr('title')+'"');
		//填充抄送的textid,catalogId
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal > #copyTextId").val(getNum($(this).parent().parent('div.block').attr('id')));
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal > #copyTextCatalogId").val(getNum($(this).attr('id')));
		//alert($("#<?php echo $id;?> #<?php echo $id;?>copyModal > #copyTextCatalogId").val());
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal div.copiedTo").html("<div class='wrapLoading'><div class='loading'></div></div>");
		getCopyText($("#<?php echo $id;?> #<?php echo $id;?>copyModal > #copyTextId").val());
		
	});
	//监听抄送文章对话框出现，获取已抄送文章（审核中与已通过的）
	$(document).undelegate("#<?php echo $id;?> #<?php echo $id;?>copyModal",'show').delegate("#<?php echo $id;?> #<?php echo $id;?>copyModal",'show',function(){
		//alert('hi');	
		//getCopyText
		//显示载入中
	});
function getCopyText(textId)
{
	var data = {};
	data.textId = textId;
	$.post("<?php echo $getCopyUrl;?>",data,function(result){
		//alert(result);
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal div.copiedTo").html("");
		$.each(result,function(index,item){
			var temp = makeCopiedTo(item);
			temp.appendTo("#<?php echo $id;?> #<?php echo $id;?>copyModal div.copiedTo");
		});
	},'json');
}
function makeCopiedTo(data)
{
	if(data.checkStatus == 0)
	{
		var tempC = " <span  style='color:gray'>抄送审核中</span> ";
	}
	else if(data.checkStatus == 2)
	{
		var tempC = " <span  style='color:gray'>抄送已通过</span> ";
	}else
	{
		var tempC = " <span  style='color:gray'>抄送不通过</span> ";
	}
	return $("<div class='copiedBlock'>"+
		data.cataName + tempC +
	"</div>");
}
	//'抄送'页面的'添加栏目按钮'
	$(document).undelegate("#<?php echo $id;?> #<?php echo $id;?>copyModal div.modal-body > div.right > div.line > div.addc2c","click").delegate("#<?php echo $id;?> #<?php echo $id;?>copyModal div.modal-body > div.right > div.line > div.addc2c","click",function(){
		if(!$(this).hasClass("disabled"))
		{
		//alert('h');
			var tempDiv = $("<div class='alert alert-info'></div>");
			var tempA = $('<a href="#" class="close" data-dismiss="alert">&times;</a>');
			tempA.appendTo(tempDiv);
			var tempSelect = $("<select></select>");
			//alert(<?php echo $id;?>cataData.length);
			for(var i=0;i<<?php echo $id;?>cataData.length;++i)
			{
				//alert($(this).parents('#<?php echo $id;?>copyModal').children('#copyTextCatalogId').val());
				//alert(<?php echo $id;?>cataData[i-1].hasText);
				if((<?php echo $id;?>cataData[i].hasText == 1) && (<?php echo $id;?>cataData[i].id != $(this).parents('#<?php echo $id;?>copyModal').children('#copyTextCatalogId').val()))
				{
					<?php /*不能抄送到自己同一栏目*/ ?>
					//alert('1');
					var tempOpt = $("<option></option>");
					tempOpt.attr("selected",false);
					if(<?php echo $id;?>cataData[i].isPublic == 1)
					{
						tempOpt.attr("title","公开栏目 "+<?php echo $id;?>cataData[i].cataIntro);
					}
					else
					{
						tempOpt.attr("title","内部栏目 "+<?php echo $id;?>cataData[i].cataIntro);
					}
					tempOpt.attr('id','c'+<?php echo $id;?>cataData[i].id);
					tempOpt.html(<?php echo $id;?>cataData[i].title);
					//alert(tempOpt.attr('id'));
					tempOpt.appendTo(tempSelect);
				}
			}
			tempSelect.appendTo(tempDiv);
			$(this).parents('div.right').children("div.copyTo").append(tempDiv);
		}
	});
	
	//定义保存抄送按钮动作
	$(document).undelegate("#<?php echo $id;?> #<?php echo $id;?>copyModal div.modal-footer > button.copy","click").delegate("#<?php echo $id;?> #<?php echo $id;?>copyModal div.modal-footer > button.copy","click",function(){
		//$(this).parent().children('#copyE').html('fuck');
		var data = {};
		data.textId = $('#<?php echo $id;?> #<?php echo $id;?>copyModal > #copyTextId').val();
		if(data.textId == '')
		{
			alert('Oops');
			return;
		}
		data.copyArr = new Array();
		$('#<?php echo $id;?> #<?php echo $id;?>copyModal > div.modal-body div.copyTo > div.alert').each(function(){
			//alert($(this).find("select option:selected").attr('id'));
			data.copyArr.push(getNum($(this).find("select option:selected").attr('id')));
		});
		if(data.copyArr.length == 0)//未选择任何栏目抄送
		{
			$("#<?php echo $id;?> #<?php echo $id;?>copyModal > div.modal-footer > #copyE").html("未选择任何栏目！");
			setTimeout(function(){$("#<?php echo $id;?> #<?php echo $id;?>copyModal > div.modal-footer > #copyE").html("");},3000);
			return;
		}
		$.post("<?php echo $copyUrl;?>",data,function(result){
			//alert(result);
			if(result == 'error')
			{
				alert('Oops!');
				return;
			}
			//关闭抄送框
			$("#<?php echo $id;?> #<?php echo $id;?>copyModal").modal('hide');
			
		});
	});
	//抄送框关闭时将其重置
	$(document).undelegate("#<?php echo $id;?> #<?php echo $id;?>copyModal",'hidden').delegate("#<?php echo $id;?> #<?php echo $id;?>copyModal",'hidden',function(){
		$(this).find("div.modal-body > div.left > div.copiedTo").html("");
		$(this).find("div.modal-body > div.right > div.copyTo").html("");
		$("#<?php echo $id;?> #<?php echo $id;?>copyModal > div.modal-header > h3 > span").html("");
		$(this).children('input:hidden').val("");
	});
<?php } ?>
	$(document).ready(function(){
	//alert('fuck!');
	//$(document).undelegate("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>",'change');
		//文章查看器当页面载入就取请求信息
		<?php if($instantLoad){ ?>
			//alert('a');
			<?php if(!$getOne){ ?>
				<?php echo $id;?>getTextList(<?php echo $catalogId;?>,<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $startNum;?>,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>);
			<?php }else{ ?>
				<?php echo $id;?>getTextList(<?php echo $catalogId;?>,<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $startNum;?>,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>,<?php echo $oneTextId;?>);			
			<?php } ?>
		<?php } ?>
		//刚进入页面不载入，让别的控件激发 
	});
<?php if($catalogIdContainer!='') { 
	//文章浏览器d的catalogContainer不为空时，设置动作，当其被改变时，重新载入
?>
	$(document).undelegate("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>",'change').delegate("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>",'change',function(e){
		//改变后重新获取text
		//e.preventDefault();
		//e.stopPropagation();
		//alert('hia');
			
		<?php echo $id;?>getTextList($("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>").val(),<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $startNum;?>,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>);
			
	});
<?php } ?>
//点击文章标题相当于点击“查看”按钮
$(document).undelegate("#<?php echo $id;?> #textListDiv div.block > div.textTitle",'click').delegate("#<?php echo $id;?> #textListDiv div.block > div.textTitle",'click',function(){
	if($(this).parent().children('div.ctl').children('div.look').length != 0)
	{
		$(this).parent().children('div.ctl').children('div.look').click();
	}
	else
	{
		$(this).parent().children('div.ctl').children('div.unlook').click();
	}
});
var <?php echo $id;?>curTextS = 0;<?php /*由于文章列表查看不见不能单纯根据textId排序，（页面中未记录checkId）,则只能根据结果集（当前页面把结果集看做是静态的）起始序号来获取信息，*/ ?>
function <?php echo $id;?>getTextList(c,u,ch,s,n,o)//分重新获取另一个栏目的text与继续获取本栏目的后一些text的情况
{
	<?php 
		//c for catalogId,u for userId(author of the text),ch for checkStatus,
		//s for text start number in sql result set,if s=0,start from most recently,n for text num per time
		//last arguments for actTextOnly
	?>
		//alert(s)
	//alert(c);
	//alert(n);
	var actTextOnly = arguments[6]?arguments[6]:'no';
	var onlyPublic = arguments[7]?arguments[7]:'no';
	var getCopy = arguments[8]?arguments[8]:'no';
	var oneTextId = arguments[9]?arguments[9]:'none';
	var data = {};
	data.c = c;
	data.onlyPublic = onlyPublic;
	data.actTextOnly = actTextOnly;
	data.getCopy = getCopy;
	if(oneTextId != 'none')
	{
		data.oneTextId = oneTextId;
	}
	if(($("#<?php echo $id;?> #textListDiv").prop('c') == null) || ($("#<?php echo $id;?> #textListDiv").prop('s') == null))//初始条件
	{
		$("#<?php echo $id;?> #textListDiv").prop('c',c);
		$("#<?php echo $id;?> #textListDiv").prop('s',s);
		$("#<?php echo $id;?> #textListDiv").prop('refresh',true);
	}
	else
	{
		if($("#<?php echo $id;?> #textListDiv").prop('c') != c)//textList换了c
		{
			$("#<?php echo $id;?> #textListDiv").prop('refresh',true);
		}
		else if($("#<?php echo $id;?> #textListDiv").prop('s') == s)//getTextList 跟上一次的c,s相同时，也就是请求上一次相同的东西，那就全部重新刷新
		{
			$("#<?php echo $id;?> #textListDiv").prop('refresh',true);
		}
		else
		{
			$("#<?php echo $id;?> #textListDiv").prop('refresh',false);
		}
		$("#<?php echo $id;?> #textListDiv").prop('c',c);
	}
	data.u = u;
	data.ch = ch;
	data.s = s;
	data.n = <?php echo $feedNum;?>;<?php /*每次载入的文章数量在部件载入时就确定*/ ?>
	data.o = o;
	//alert('j');
	$.post("<?php echo $getTextListUrl;?>",data,function(result){
		/* after getting data,remove lastchild from <?php echo $id;?> */
		//alert(result.length);
		//alert(result[0].content);
	//alert(result);
		//return;
		if($("#<?php echo $id;?> #textListDiv").children().eq(-1).hasClass("notice") || $("#<?php echo $id;?> #textListDiv").children().eq(-1).hasClass("wrapLoading"))
		{
			$("#<?php echo $id;?> #textListDiv").children().eq(-1).remove();
			//alert('hi');
		}
		if($("#<?php echo $id;?> #textListDiv").prop('refresh'))
		{
			$("#<?php echo $id;?> #textListDiv").html("");
			<?php echo $id;?>curTextS = 0;
		}
		//没有更多结果
		
		for(var i=0;i<result.length;++i)
		{
			var tempDiv = $("<div class='block' title='"+result[i].title+"' >"+"<div class='textTitle'>"+result[i].title+"</div></div>");
				tempDiv.attr('id',"t"+result[i].textId);
				tempDiv.prop('isCopy',(result[i].isCopy == 1)?true:false);
				var checkStatus = result[i].checkStatus == 1?'未通过':result[i].checkStatus == 0?'审核中':'已通过';
				if(!tempDiv.prop('isCopy'))
				{
					var tempP = $("<p class='muted'>由 <a  target='_blank' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+result[i].authorId+"'>"+result[i].authorName+"</a> 提交至 "+result[i].catalogTitle+" <span class='space'></span> "+checkStatus+"</p>");
				}
				else
				{
					var tempP = $("<p class='muted'>从 "+result[i].catalogTitle+" 抄送至 "+result[i].copyToCatalogTitle+" <span class='space'></span> "+checkStatus+"</p>");				
				}
				var tempCtl = $("<div class='ctl'></div>");
					var lookButton = $("<div class='btn-link'></div>");
					lookButton.addClass('look');
					lookButton.html("查看");
					lookButton.appendTo(tempCtl);
					<?php if($chooseFunc) { ?>
					var space = $("<span class='space' style='float:right'></span>");
					space.appendTo(tempCtl);
					var chooseButton = $('<div class="btn-link"></div>');
					chooseButton.html('选择');
					chooseButton.addClass('choose');
					chooseButton.appendTo(tempCtl);
					<?php } ?>
					<?php if($hasCheckComp) {?>
					if(!tempDiv.prop('isCopy'))
					{
						var space = $("<span class='space' style='float:right'></span>");
						space.appendTo(tempCtl);
						var checkButton = $('<div class="btn-link" data-toggle="modal" data-target="#checkModal"></div>');
						checkButton.html('审核');
						checkButton.addClass('check');
						checkButton.appendTo(tempCtl);
					}
					else
					{
						var space = $("<span class='space' style='float:right'></span>");
						space.appendTo(tempCtl);
						var checkButton = $('<div class="btn-link" data-toggle="modal" data-target="#checkCopyModal"></div>');
						checkButton.html('审核');
						checkButton.attr('id','c'+result[i].copyToCatalogId);
						checkButton.addClass('check');
						checkButton.appendTo(tempCtl);
					}
					<?php } ?>
					<?php if($hasCopyComp) { ?>
					
					var space = $("<span class='space' style='float:right'></span>");
					space.appendTo(tempCtl);
					var copyButton = $('<div class="btn-link" data-toggle="modal" data-target="#<?php echo $id;?>copyModal"></div>');
					copyButton.html('抄送');
					copyButton.addClass('copy');
					copyButton.attr('id','c'+result[i].catalogId);
					copyButton.appendTo(tempCtl);
					<?php } ?>
					<?php if($hasComComp) { ?>
					
					var space = $("<span class='space' style='float:right'></span>");
					space.appendTo(tempCtl);
					var comButton = $('<div class="btn-link"></div>');
					comButton.html('评论');
					comButton.prop('opened',false);
					comButton.addClass('comment');
					comButton.appendTo(tempCtl);

					<?php } ?>
					
				var tempContent = $("<div class='textContent' style='display:none'>"+result[i].content+"</div>");
				var tempHidden = $("<input type='hidden' class='titlePicAddr' value='"+result[i].titlePicAddr+"'></input>");
				if(result[i].checkId != null)
				{
					var tempCheckId = $("<input type='hidden' class='checkId' value='"+result[i].checkId+"'></input>");
					tempDiv.append(tempCheckId);
				}
				tempDiv.append(tempHidden);
				tempDiv.append(tempP);
				if(result[i].actInfo.actId)
				{
					if(result[i].actInfo.actLecturer != '')
					{
					var tempAct = $("<p class='muted'>活动时间: "+result[i].actInfo.actTime+" 活动地点: "+result[i].actInfo.actLoc+" 活动主讲人: "+result[i].actInfo.actLecturer+
						"<input type='hidden' value='"+result[i].actInfo.actId+"' class='actId'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actLoc+"' class='actLoc'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actTime+"' class='actTime'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actLecturer+"' class='actLecturer'></input>"+
					"</p>");
					}
					else
					{
					var tempAct = $("<p class='muted'>活动时间: "+result[i].actInfo.actTime+" 活动地点: "+result[i].actInfo.actLoc+
						"<input type='hidden' value='"+result[i].actInfo.actId+"' class='actId'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actLoc+"' class='actLoc'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actTime+"' class='actTime'></input>"+
						"<input type='hidden' value='"+result[i].actInfo.actLecturer+"' class='actLecturer'></input>"+
					"</p>");
					}
						
					tempDiv.append(tempAct);
				}
				
				tempDiv.append(tempContent);
				tempDiv.append(tempCtl);
				<?php if($hasComComp){ ?>
				var tempComDiv = $("<div class='comDiv'>"+
						"<div class='comInputDiv'>"+
						<?php if($canComT){ ?>
							"<input class='input-xlarge comInput'></input> <span class='space'></span>"+
							"<div class='com btn btn-small btn-info'>评论</div>"+
						<?php } ?>
						"</div>"+
						"<div class='comList'>"+
							"<div class='wrapLoading'><div class='loading'></div></div>"+
							//"<div class='comBlock'></div>"
						"</div>"+
					"</div>");
				tempDiv.append(tempComDiv);
				<?php } ?>
			tempDiv.appendTo($("#<?php echo $id;?> #textListDiv"));
		}
		if(result.length == <?php echo $feedNum;?>)
		{
			//显示“查看更多”按钮
			<?php echo $id;?>curTextS += <?php echo $feedNum;?>;
			$("#<?php echo $id;?> #textListDiv").append($("<div class='btn btn-block btn-success more'>查看更多</div>"));
		}
		<?php if($hasComComp && $instantExpandCom){ ?>
			$("#<?php echo $id;?> div.block div.comment").click();
		<?php } ?>
	},'json');

	
}
$(document).undelegate("#<?php echo $id;?> #textListDiv > div.more","click").delegate("#<?php echo $id;?> #textListDiv > div.more","click",function(){
	$(this).parent().append("<div class='wrapLoading'><div class='loading'></div></div>");
	$(this).remove();
	<?php echo $id;?>getTextList($("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>").val(),<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $id;?>curTextS,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>);
});

<?php if($hasComComp) { ?>

//定义'评论'link动作 
	$(document).undelegate("#<?php echo $id;?> div.block div.comment","click").delegate("#<?php echo $id;?> div.block div.comment","click",function(){
		if($(this).prop('opened'))	
		{
			$(this).parent().parent().children('div.comDiv').css('display','none');
			$(this).prop('opened',false);
			<?php if($canComT){ ?>
			$(this).parent().parent().children('div.comDiv').find('div.comInputDiv > input').val("");
			<?php } ?>
			$(this).parent().parent().children('div.comDiv').children('div.comList').html("<div class='wrapLoading'><div class='loading'></div></div>");
		}
		else
		{
			$(this).parent().parent().children('div.comDiv').css('display','block');
			$(this).prop('opened',true);
			//获取评论
			var data = {};
			data.textId = getNum($(this).parent().parent().attr('id'));
			//alert($(this).parent().parent().attr('id'));
			$.post("<?php echo $getComUrl;?>",data,function(result){
				//alert(result);
				<?php /*清空后，获取所有的评论,重新获取textId以把评论放置正确 */ ?>
				//先找到相应的textId
				var $textBlock;
				$("#<?php echo $id;?> #textListDiv div.block").each(function(){
					if(getNum($(this).attr('id')) == result[0].textId)
					{
						$textBlock = $(this);
					}
				});
				if($textBlock == null)
				{
					alert('Oops!');
					return;
				}
				if(result.length == 1)
				{
					//alert($(this).parent().parent().children('div.comDiv').children('div.comList').html());
					$textBlock.children('div.comDiv').children('div.comList').html("<div class='wrapLoading'></div>");
				}
				else
				{
					$textBlock.children('div.comDiv').children('div.comList').html("");
					$.each(result,function(index,item){
						if(index != 0)
						{
							if(item.toWhomName == null)
							{	
								var tempComBlock = $("<div class='comBlock'></div>");
								var tempComLine1 = $("<div class='comLine'><a class='replier' id='"+item.userId+"' title='"+item.userName+"' target='_blank' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+
									item.userId+"'>"+item.userName+": </a><span class='space'></span>"+item.content+"<span class='space'></span><span class='space'></span><span class='space'></span>"+
									<?php if($canComT){ ?>
									"<a class='replyTo' href='#'>回复</a>"+
									<?php } ?>
									"</div>");
								var tempComLine2 = $("<div class='comLine'><span style='font-size:12px;color:gray'>"+item.comTime+"</div>");
								tempComBlock.append(tempComLine1);
								tempComBlock.append(tempComLine2);
								/*tempComBlock = $("<div class='comBlock'>"+
								"<div class='comLine'><a class='replier' id='"+item.userId+"' title='"+item.userName+"' target='_blank' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+
									item.userId+"'>"+item.userName+": </a><span class='space'></span>"+item.content+"<span class='space'></span><span class='space'></span><span class='space'></span>"+
									"<a class='replyTo' href='#'>回复</a>"
									+"</div>"+
									"<div class='comLine'><span style='font-size:12px;color:gray'>"+item.comTime+"</div>"+
								"</div>");*/
							}
							else
							{
								var tempComBlock = $("<div class='comBlock'></div>");
								var tempComLine1 = $("<div class='comLine'><a class='replier' id='"+item.userId+"' title='"+item.userName+"' target='_blank' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+
									item.userId+"'>"+item.userName+": </a><span class='space'></span>回复"+item.toWhomName+":<span class='space'></span>"+item.content+"<span class='space'></span><span class='space'></span><span class='space'></span>"+
									<?php if($canComT){ ?>
									"<a class='replyTo' href='#'>回复</a>"+
									<?php } ?>
									"</div>");
								var tempComLine2 = $("<div class='comLine'><span style='font-size:12px;color:gray'>"+item.comTime+"</div>");
								tempComBlock.append(tempComLine1);
								tempComBlock.append(tempComLine2);
								/*tempComBlock = $("<div class='comBlock'>"+
									"<div class='comLine'><a class='replier' id='"+item.userId+"' title='"+item.userName+"' target='_blank' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+item.userId+"'>"+item.userName+
									": </a><span class='space'></span>回复"+item.toWhomName+":<span class='space'></span>"+item.content+"<span class='space'></span><span class='space'></span><span class='space'></span>"+
									"<a class='replyTo' href='#'>回复</a>"
									+"</div>"+
									"<div class='comLine'><span style='font-size:12px;color:gray'>"+item.comTime+"</div>"+
								"</div>");*/
							}
							//undefined in ie//alert(tempComBlock.html());
							tempComBlock.appendTo($textBlock.children('div.comDiv').children('div.comList'));
						}
					});
				}
			},'json');
		}
	});
<?php if($canComT){ ?>
//mouseenter到comBlock才显示'回复'
	$(document).undelegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock","mouseenter").delegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock","mouseenter",function(){
		$(this).children().children('a.replyTo').css('display','inline');
	});
	$(document).undelegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock","mouseleave").delegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock","mouseleave",function(){
		$(this).children().children('a.replyTo').css('display','none');
	});
//点击别人回复下的回复按钮动作
	$(document).undelegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock > div.comLine > a.replyTo","click").delegate("#<?php echo $id;?> div.block > div.comDiv > div.comList > div.comBlock > div.comLine > a.replyTo","click",function(e){
		//构造回复
		e.preventDefault();
		if($(this).prop('opened'))
		{
			$(this).parent().parent().find('div.replyInputDiv').parent().remove();
			$(this).prop('opened',false);
		}
		else
		{
			var tempReply = $("<div class='comLine'>"+
						"<div class='replyInputDiv'>"+
							"<input type='hidden' class='toWhomId' value='"+$(this).parent().children('a.replier').attr('id')+"'></input>"+
							"<input class='input-large replyInput'></input> <span class='space'></span>"+
							"<div class='reply btn btn-small btn-info'>回复"+$(this).parent().children('a.replier').attr('title')+"</div>"+
						"</div>"+
			"</div>");
			tempReply.appendTo($(this).parent().parent());
			$(this).prop('opened',true);
		}
	});
//定义'评论'按钮动作，提交评论 
	$(document).undelegate("#<?php echo $id;?> div.block > div.comDiv > div.comInputDiv > div.com","click").delegate("#<?php echo $id;?> div.block > div.comDiv > div.comInputDiv > div.com","click",function(){
		if($(this).parent().children('input').val() != '')
		{
			//alert($(this).parent().children('input').val());
			var data = {};
			data.comContent = $(this).parent().children('input').val();
			data.textId = getNum($(this).parent().parent().parent().attr('id'));
			//alert(data.textId);
			var tempWait = $("<div class='comBlock'><div class='wrapLoading'><div class='loading'></div></div></div>");
			$(this).parent().parent().children('div.comList').prepend(tempWait);
			<?php echo $id;?>comOrReply(data);
			$(this).parent().children('input').val("");
		}
	});
//定义回复)动作，提交评论 
	$(document).undelegate("#<?php echo $id;?> div.block > div.comDiv > div.comList div.reply","click").delegate("#<?php echo $id;?> div.block > div.comDiv > div.comList div.reply","click",function(){
		if($(this).parent().children('input.replyInput').val() != '')
		{
			//alert($(this).parent().children('input').val());
			var data = {};
			data.comContent = $(this).parent().children('input.replyInput').val();
			data.textId = getNum($(this).parents('div.block').attr('id'));
			data.toWhomId = $(this).parent().children('input.toWhomId').val();
			if(data.toWhomId == 0)
			{
				alert('Oops!');
				return;
			}
			//alert(data.textId);
			//return;
			var tempWait = $("<div class='comBlock'><div class='wrapLoading'><div class='loading'></div></div></div>");
			$(this).parents('div.comDiv').children('div.comList').prepend(tempWait);
			<?php echo $id;?>comOrReply(data);
			$(this).parent().children('input.replyInput').val("");
		}
	});

function <?php echo $id;?>comOrReply(data)
{
	$.post("<?php echo $comUrl;?>",data,function(result){
			//alert(result);
			//return;
				//获取添加评论到前面
			if(result == 'error')
			{
				alert('Oops!');
				return;
			}
			//先找到相应的textId
			var $textBlock;
			//alert($("#<?php echo $id;?> #textListDiv div.block").length);
			$("#<?php echo $id;?> #textListDiv div.block").each(function(){
				if(getNum($(this).attr('id')) == result.textId)
				{
					$textBlock = $(this);
				}
			});
			if($textBlock == null)
			{
				alert('Oops!');
				return;
			}
			if(result.toWhomName == null)
			{
				/*var tempComBlock = $("<div class='comBlock'>"+
							"<div class='comLine'><a id='"+result.userId+"' title='"+result.userName+"' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+result.userId+"'>"+result.userName+": </a><span class='space'></span>"+result.content+"</div>"+
							"<div class='comLine'><span style='font-size:12px;color:gray'>"+result.comTime+"</div>"+
						"</div>");*/
				var tempComBlock = $("<div class='comBlock'></div>");
				var tempComLine1 = $("<div class='comLine'><a id='"+result.userId+"' title='"+result.userName+"' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+result.userId+"'>"+result.userName+": </a><span class='space'></span>"+result.content+"</div>");
				var tempComLine2 = $("<div class='comLine'><span style='font-size:12px;color:gray'>"+result.comTime+"</div>");
				tempComBlock.append(tempComLine1);
				tempComBlock.append(tempComLine2);
			}
			else
			{
				/*var tempComBlock = $("<div class='comBlock'>"+
							"<div class='comLine'><a id='"+result.userId+"' title='"+result.userName+"' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+result.userId+"'>"+result.userName+
							": </a><span class='space'></span>回复"+result.toWhomName+":<span class='space'></span>"+result.content+"</div>"+
							"<div class='comLine'><span style='font-size:12px;color:gray'>"+result.comTime+"</div>"+
						"</div>");*/
				var tempComBlock = $("<div class='comBlock'></div>");
				var tempComLine1 = $("<div class='comLine'><a id='"+result.userId+"' title='"+result.userName+"' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+result.userId+"'>"+result.userName+": </a><span class='space'></span>回复"+result.toWhomName+":<span class='space'></span>"+result.content+"</div>");
				var tempComLine2 = $("<div class='comLine'><span style='font-size:12px;color:gray'>"+result.comTime+"</div>");
				tempComBlock.append(tempComLine1);
				tempComBlock.append(tempComLine2);
			}
			$textBlock.children('div.comDiv').children('div.comList').children('div.comBlock').eq(0).replaceWith(tempComBlock);
	},'json');
}
<?php } ?>
function getNum(str)
{
var reg=/^[a-zA-Z]+([0-9]+)$/g;
if(reg.test(str))
{
reg.lastIndex = 0;
return reg.exec(str)[1];
}
else
{
return "";
}
}
<?php } ?>


<?php if($hasCheckComp) { ?>
//定义'审核'按钮动作 
	$(document).undelegate("#<?php echo $id;?> div.block div.check","click").delegate("#<?php echo $id;?> div.block div.check","click",function(){
		//修改审核modal的高度
		$("#<?php echo $id;?> #checkModal").css('top',($(this).offset().top-200)+'px');
		$("#<?php echo $id;?> #checkCopyModal").css('top',($(this).offset().top-150)+'px');
		//当为抄送时就把文章内容送入框中
		if($(this).parent().parent('div.block').prop('isCopy'))
		{
			//
			$("#<?php echo $id;?> #checkCopyModal > div.modal-header > h3 > span").html('"'+$(this).parent().parent('div.block').attr('title')+'"');
			$("#<?php echo $id;?> #checkCopyModal > div.modal-header > h5").html($(this).parent().parent('div.block').children('p').html());
			//把文章id送入抄送审核框中
			$("#<?php echo $id;?> #checkCopyModal > #checkCopyTextId").val(getNum($(this).parent().parent('div.block').attr('id')));
			//抄送文章栏目id
			$("#<?php echo $id;?> #checkCopyModal > #checkCopyTextCataId").val(getNum($(this).attr('id')));
		}
		else
		{
			$("#<?php echo $id;?> #checkModal > div.modal-header > h3 > span").html('"'+$(this).parent().parent('div.block').attr('title')+'"');			
		}
	});
//定义抄送审核框动作
$(document).undelegate("#<?php echo $id;?> #checkCopyModal > div.modal-body > div.wrapLoading > div.btn","click").delegate("#<?php echo $id;?> #checkCopyModal > div.modal-body > div.wrapLoading > div.btn","click",function(){
	var data = {};
	data.cTextId = $(this).parents('#checkCopyModal').children('#checkCopyTextId').val();
	data.cTextCataId = $(this).parents('#checkCopyModal').children('#checkCopyTextCataId').val();
	if($(this).hasClass('pass'))
	{	
		data.checkResult = 'yes';
		//alert(data.cTextId);
		//alert(data.cTextCataId);
	}
	else
	{		
		data.checkResult = 'no';
	}
	//checkCopyText(data);
	$.post("<?php echo $checkTextUrl;?>",data,function(result){
		//关闭审核框
		$("#<?php echo $id;?> #checkCopyModal").modal('hide');
		//alert(result);
		//审核完重新载入文章列表
		<?php echo $id;?>getTextList($("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>").val(),<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $startNum;?>,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>);
	});
});
<?php } ?>

<?php if($chooseFunc){ ?>
//定义选择按钮动作 
$(document).undelegate("#<?php echo $id;?> div.block div.choose",'click').delegate("#<?php echo $id;?> div.block div.choose",'click',function(){
//alert('hi');
	<?php if($textIdTo != ''){ ?>
//	alert(<?php echo $textIdTo;?>);
	//alert(getNum($(this).parent().parent().attr('id')));
		$(<?php echo $textIdTo;?>).val(getNum($(this).parent().parent().attr('id')));
	<?php } ?>
	
	<?php if($textTitleTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $textTitleTo;?>).val($(this).parent().parent().attr('title'));		
	<?php } ?>
	
	<?php if($textTitlePicTo != ''){ ?>
		$(<?php echo $textTitlePicTo;?>).val($(this).parent().parent().children('input.titlePicAddr').val());		
	<?php } ?>
	
	<?php if($checkIdTo != ''){ ?>
		$(<?php echo $checkIdTo;?>).val($(this).parent().parent().children('input.checkId').val());		
	<?php } ?>
	
	<?php if($textContentTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $textContentTo;?>).val($(this).parent().parent().children('div.textContent').html());		
	<?php } ?>
	
	<?php if($actIdTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $actIdTo;?>).val($(this).parent().parent().children('p.muted').children('input.actId').val());		
	<?php } ?>
	<?php if($actTimeTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $actTimeTo;?>).val($(this).parent().parent().children('p.muted').children('input.actTime').val());		
	<?php } ?>
	
	<?php if($actLocTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $actLocTo;?>).val($(this).parent().parent().children('p.muted').children('input.actLoc').val());		
	<?php } ?>

	<?php if($actLecturerTo != ''){ ?>
	//alert(getNum($(this).parent().parent().attr('title')));
		$(<?php echo $actLecturerTo;?>).val($(this).parent().parent().children('p.muted').children('input.actLecturer').val());		
	<?php } ?>

	
	<?php if($targetSelector != ''){ ?>
		$(<?php echo $targetSelector;?>).change();		
	<?php } ?>
});
	
<?php } ?>
<?php if(!$showInModal){ ?>
//定义“查看”按钮动作
$(document).undelegate("#<?php echo $id;?> div.block div.look","click").delegate("#<?php echo $id;?> div.block div.look","click",function(e){

	$(this).removeClass('look');
	$(this).addClass('unlook');
	$(this).html("收起");
	$(this).parent().prev().slideDown(300);
});
//定义'收起'动作
$(document).undelegate("#<?php echo $id;?> div.block div.unlook","click").delegate("#<?php echo $id;?> div.block div.unlook","click",function(e){

	$(this).removeClass('unlook');
	$(this).addClass('look');
	$(this).html("查看");
	$(this).parent().prev().slideUp(300);
});
<?php }else{ ?>
//点击查看按钮，把文章拷贝到modal中，计算modal高度，然后显示modal
$(document).undelegate("#<?php echo $id;?> div.block div.look","click").delegate("#<?php echo $id;?> div.block div.look","click",function(e){
	var textContent = $(this).parent().prev().clone();
	textContent.css('display','block');
	$("#<?php echo $id;?> > #<?php echo $id;?>showModal > div.modal-body").append(textContent);
	$("#<?php echo $id;?> > #<?php echo $id;?>showModal").css('top',($(this).offset().top-200)+'px');
	$("#<?php echo $id;?> > #<?php echo $id;?>showModal").modal('show');
});
	//点击关闭或者点击空白处，消失modal,把modal的文章内容删除掉，
	$(document).undelegate("#<?php echo $id;?> > #<?php echo $id;?>showModal",'hidden').delegate("#<?php echo $id;?> > #<?php echo $id;?>showModal",'hidden',function(){
		
		$("#<?php echo $id;?> > #<?php echo $id;?>showModal > div.modal-body").html("");
		//审核完重新载入文章列表

	});
	
<?php } ?>
</script>

<?php if($hasCheckComp){ ?>
<script type="text/javascript">
	//监听审核文章对话框出现，定义动作
	$(document).delegate("#<?php echo $id;?> #checkModal",'show',function(){
		//alert('hi');
		
	});
	$(document).undelegate("#<?php echo $id;?> #checkCopyModal",'hide').delegate("#<?php echo $id;?> #checkCopyModal",'hide',function(){
		//alert('hi');
		$("#<?php echo $id;?> #checkCopyModal > div.header > h3 > span").html("");
		$("#<?php echo $id;?> #checkCopyModal > div.header > h5").html("");
		$("#<?php echo $id;?> #checkCopyModal #checkCopyTextId").val("");
		$("#<?php echo $id;?> #checkCopyModal #checkCopyTextCataId").val("");
	});
	$(document).undelegate("#<?php echo $id;?> #checkModal",'hide').delegate("#<?php echo $id;?> #checkModal",'hide',function(){
		//清空checkTextId
		//alert('if');
		$("#<?php echo $id;?> #checkModal #checkTextId").val("");
		$("#<?php echo $id;?> #checkModal > div.header > h3 >span").html("");
		//审核完重新载入文章列表
		<?php echo $id;?>getTextList($("#<?php echo $id;?> #<?php echo $catalogIdContainer; ?>").val(),<?php echo $userId;?>,<?php echo $checkStatus;?>,<?php echo $startNum;?>,<?php echo $feedNum;?>,"<?php echo $order;?>"<?php echo $param;?>);

	});
	
</script>
<?php /*******************************/ ?>
<div class="modal hide fade" id="checkCopyModal" style="position:absolute;width:500px;margin-left:-250px"><!--to set the modal in the center,margin-left should be (-)half its width-->
	<input type="hidden" id="checkCopyTextId" value=""></input>
	<input type='hidden' id='checkCopyTextCataId' value=''></input>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>审核抄送文章
    		<span class='help-inline' style='font-size:18px'></span>
    	</h3>
    	<h5></h5>
	</div>
	<div class='modal-body'>
		<div class='wrapLoading'>
			<div class='btn btn-info pass'>通过审核</div>
			<div class='btn btn-danger fail'>不通过</div>
		</div>
	</div>
</div>

<?php /**************************/         ?>
<div class="modal hide fade" id="checkModal" style="position:absolute;width:700px;margin-left:-350px"><!--to set the modal in the center,margin-left should be (-)half its width-->
	<input type="hidden" id="checkTextId" value=""></input>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>审核文章
    		<span class='help-inline' style='font-size:16px'></span>
    	</h3>
	</div>
	<?php 
 	$userId = Yii::app()->session['userId'];
	$this->widget('TextEditorWidget',array(
				'id'=>'checkEditor',
				'hasTextList' => false,
				'editorWidth' => '700px',
				'hasCheckComp' => true,
				'authorId' => $userId,
				'textIdJqueryObjStr' => '$(this).parent().parent().attr("id")',
				'getTextIdSelector' => '"#'.$id.' div.block div.check"',
				'checkTextUrl' => $checkTextUrl,
				//'editorConfig' => $editorConfig,
				'saveTextUrl' => Yii::app()->baseUrl.'/index.php/text/save',
				
				'getCataUrl' => Yii::app()->baseUrl."/index.php/catalog/get",
				'getTextListUrl' => Yii::app()->baseUrl.'/index.php/text/getList',
				'getTextUrl' => Yii::app()->baseUrl.'/index.php/text/get',
				
			));
	?>
</div>
<?php } ?>
	<input id="<?php echo $catalogIdContainer;?>" value="<?php echo $catalogId;?>" type="hidden"></input>
	<div id="textListDiv" class='testListDiv'><div class='wrapLoading'><div class='loading'></div></div>
	</div>
</div>