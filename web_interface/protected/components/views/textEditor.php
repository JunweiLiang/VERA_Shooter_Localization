<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	****************/
?>
<div id="<?php echo $id;?>">
<input type="hidden" value="a<?php echo $authorId;?>" id="authorId"></input>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ckeditor/ckeditor.js"></script>
<?php	
	if($titlePic === true)//要载入ckfinder的单独应用
	{
		echo '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/ckfinder/ckfinder.js"></script>';
	}

?>
<style type="text/css">
	#<?php echo $id;?> #editTextDiv{width:<?php echo $editorWidth-20;?>px;padding:10px;text-align:left;
	<?php if($hasTextList == true){ ?>
		float:left;
	<?php } ?>
	}
	#<?php echo $id;?> div.modal-body{padding:10px}
	#<?php echo $id;?> #editTextDiv .editorBlock{padding:5px 0 5px 0}
	#<?php echo $id;?> #editTextDiv .span2{margin-left:0}
</style>

<div id="editTextDiv">
	<input type="hidden" id="editTextId" value="<?php if($textId!=""){echo "t".$textId;}?>"></input>
	<?php if($textId != ""){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			//当载入编辑器的 editTextId不为空时，向服务器请求该文章数据
			if(($("#<?php echo $id;?> #editTextDiv #editTextId").val() != "") && ($("#<?php echo $id;?> #editTextId").val() != null))
			{
				getText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),"editTextDiv");
			}
		});
	</script>
	<?php } ?>
	
	<?php if(($textIdJqueryObjStr != "") && ($getTextIdSelector != "")) { ?>
	<script type="text/javascript">
		$(document).delegate(<?php echo $getTextIdSelector;?>,"click",function(){
				$("#<?php echo $id?> #editTextDiv #editTextId").val(<?php echo $textIdJqueryObjStr;?>);
				//去除按钮的禁用
				$("#<?php echo $id?> #editTextDiv #editorCtr div.btn").removeClass("disabled");
				//去掉提示
				$("#<?php echo $id?> #editTextDiv #editorCtr #newTextE").html("");
				getText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),"editTextDiv");
				
			});
	</script>
	<?php } ?>
	<?php if(!$hasCheckComp) { //发表文章情况 ?>
	
	<div id="editorCtr" class="editorBlock">
		<div id="newText" class="btn">新建</div> 
		<div id="saveText" class="btn btn-success">保存</div> 
		<div id="submitText" class="btn btn-danger">提交审核</div>
		<span id="newTextE" class="text-warning"></span>
	</div>
	<script type="text/javascript">
	//定义新建按钮动作
	$(document).delegate("#<?php echo $id;?> #editorCtr #newText","click",function(){
		//清空所有输入，清空textId
		//CKEDITOR.instances.editorMain.setData("");
		//
		//重新载入此页面进行新建
		window.open("<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/postText","_self");
	});
	//定义提交审核按钮操作
	$(document).delegate("#<?php echo $id;?> #editorCtr #submitText","click",function(){
		if(!$(this).hasClass('disabled'))
		{
			saveText(true);
		}
	});
	</script>
	
	<?php } else { //此时是审核文章情况 ?>
	
	<div id="editorCtr" class="editorBlock">
		<div id="saveText" class="btn btn-success" title="修改内容后记得点保存噢！">保存</div> 
		<div id="failText" class="btn btn-info" title="修改内容后记得点保存噢！">不通过</div>
		<span class='space'></span>
		<div id="passText" class="btn btn-danger" title="修改内容后记得点保存噢！">审核通过</div>
		<span id="newTextE" class="text-warning"></span>
	</div>
	<script type="text/javascript">
	//定义不通过按钮动作
	$(document).delegate("#<?php echo $id;?> #editorCtr #failText","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			checkText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),'no');
		}
	});
	//定义审核通过按钮动作
	$(document).delegate("#<?php echo $id;?> #editorCtr #passText","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			checkText(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()),'yes');
		}
	});
function checkText(textId,passed)//提交审核结果然后去掉审核框并且重新载入文章列表
{
	var data = {};
	data.textId = textId;
	data.passed = passed;
	$.post("<?php echo $checkTextUrl;?>",data,function(result){
	//alert(result);
		if(result == "error")
		{
			alert("Oops!");
			return;
		}
		//去掉审核框(审核框在外部，去不了，改成禁用所有按钮)
		$("#<?php echo $id;?> #editorCtr div.btn").addClass("disabled");
		$("#<?php echo $id;?> #editorCtr #newTextE").html("操作成功！可关闭对话框");
		
	});
}
	</script>
	<?php } ?>
<script type="text/javascript">
	
	//定义保存按钮动作
	$(document).delegate("#<?php echo $id;?> #editorCtr #saveText","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			saveText(false);
		}
	});
function saveText(isSubmit)
{
	//检查输入
		var data = {};
		//检查是否活动栏目
		if($("#<?php echo $id;?> #isActTextDiv #isActText").is(":checked"))
		{
			data.isActText = 1;
			//活动时间与活动地点为必须
			if(($("#<?php echo $id;?> #actTextDiv1 #actTime").val() == "") || ($("#<?php echo $id;?> #actTextDiv1 #actTime").val() == null))
			{
				$("#<?php echo $id;?> #editTextDiv #newTextE").html("活动时间不能为空！");
				setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
				return;
			}	
			if(($("#<?php echo $id;?> #actTextDiv2 #actLoc").val() == "") || ($("#<?php echo $id;?> #actTextDiv2 #actLoc").val() == null))
			{
				$("#<?php echo $id;?> #editTextDiv #newTextE").html("活动地点不能为空！");
				setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
				return;
			}
			data.actTime = $("#<?php echo $id;?> #actTextDiv1 #actTime").val();
			data.actLoc = $("#<?php echo $id;?> #actTextDiv2 #actLoc").val();
			data.actLecturer = $("#<?php echo $id;?> #actTextDiv3 #actLecturer").val();
		}
		//文章栏目必须
		if(($("#<?php echo $id;?> #editTextDiv #catalogId").val() == "") || ($("#<?php echo $id;?> #editTextDiv #catalogId").val() == null))
		{
			$("#<?php echo $id;?> #editTextDiv #newTextE").html("请选择文章栏目！");
			setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
			return;
		}
		data.catalogId = getNum($("#<?php echo $id;?> #editTextDiv #catalogId").val());
		//alert(data.catalogId);
		//文章标题必须
		if(($("#<?php echo $id;?> #editTextDiv #title").val() == "") || ($("#<?php echo $id;?> #editTextDiv #title").val() == null))
		{
			$("#<?php echo $id;?> #editTextDiv #newTextE").html("文章标题不能为空！");
			setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
			return;
		}
		data.title = $("#<?php echo $id;?> #editTextDiv #title").val();
		//文章内容必须
		var content= CKEDITOR.instances.editorMain.getData();
		//alert(content);
		if(content == "")
		{
			$("#<?php echo $id;?> #editTextDiv #newTextE").html("文章内容不能为空！");
			setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
			return;
		}
		data.content = content;
		//副标题
		//if($("#<?php echo $id;?> #editTextDiv #subTitle").val() != "")
		//{
			data.subTitle = $("#<?php echo $id;?> #editTextDiv #subTitle").val();
		//}
		//标题图片
		data.titlePicAddr = $("#<?php echo $id;?> #editTextDiv #titlePicAddr").val();
		//文章简介
		data.textIntro = $("#<?php echo $id;?> #editTextDiv #textIntro").val();
		//文章来源
		data.src = $("#<?php echo $id;?> #editTextDiv #src").val();
		//文章关键字
		data.keyWord = $("#<?php echo $id;?> #editTextDiv #keyWord").val();
		//************textId,authorId
		data.editTextId = getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val());
		data.authorId = getNum($("#<?php echo $id;?> #authorId").val());
		//**********
		//alert(data.editTextId);
		$("#<?php echo $id;?> #editTextDiv #newTextE").html("保存中...");
		$.post("<?php echo $saveTextUrl;?>",data,function(result){
			//alert(result);
			if(result == "error")
			{
				alert('Oops!');
				return;
			}
			//新的文章会返回textId,填充至$editTextId
			if($("#<?php echo $id;?> #editTextDiv #editTextId").val() == "")
			{
				$("#<?php echo $id;?> #editTextDiv #editTextId").val("t"+result);		
			}
			//alert(result);
			//alert($("#<?php echo $id;?> #editTextDiv #editTextId").val());
			$("#<?php echo $id;?> #editTextDiv #newTextE").html("保存成功！");
			setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
			
			if(isSubmit)
			{
				
				//改变显示为“提交中..”
				$("#<?php echo $id;?> #editTextDiv #newTextE").html("提交中...");
				var data = {};
				data.textId = getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val());
				//alert(data.textId);
				//var test="t21";
				//alert("test="+getNum(test));
				if((data.textId == "") || (data.textId == null))
				{
					alert("Oops");
					return;
				}
				$.post("<?php echo $postTextUrl;?>",data,function(result){
					//alert(result);
					<?php if($hasTextList){?>
					//有文章列表时每保存一次重新载入一次列表
					getTextList(getNum($("#<?php echo $id;?> #authorId").val()),"textListDiv");
					<?php } ?>
					//改变按钮
					$("#<?php echo $id;?> #editorCtr #submitText").addClass("disabled");
					$("#<?php echo $id;?> #editorCtr #submitText").html("文章已提交");
					//提示
					$("#<?php echo $id;?> #editTextDiv #newTextE").html("提交成功！");
					setTimeout(function(){$("#<?php echo $id;?> #editTextDiv #newTextE").html("");},3000);
					
				});
				
			}
			else
			{
			<?php if($hasTextList){?>
			//有文章列表时每保存一次重新载入一次列表
			getTextList(getNum($("#<?php echo $id;?> #authorId").val()),"textListDiv");
			<?php } ?>
			}
		});
}
</script>
	<?php if($actTextOption === true){ ?>
	<div id="isActTextDiv" class="form-inline editorBlock" style="display:none">
		<span class="help-inline span2">是否为活动:</span>
		<input  type="checkbox" id="isActText"></input>
	</div>
	<div id="actTextDiv1" style="display:none" class="form-inline editorBlock">
		<span class="help-inline span2">活动时间:</span>
		<input  class="input-large" value="" id="actTime"></input>
	</div>
	<div id="actTextDiv2" style="display:none" class="form-inline editorBlock">
		<span class="help-inline span2">活动地点:</span>
		<input value="" class="input-large" id="actLoc"></input>
	</div>
	<div id="actTextDiv3" style="display:none" class="form-inline editorBlock">
		<span class="help-inline span2">活动主讲人:</span>
		<input value="" class="input-large" id="actLecturer" placeholder='可留空'></input>
	</div>
	<script type="text/javascript">
		//定义勾选“是否为活动”动作
		$(document).delegate("#<?php echo $id;?> #isActTextDiv #isActText","click",function(){
		//	alert('hi');
			if($(this).is(":checked"))
			{
				//清空活动详情输入框
				$("#<?php echo $id;?> #actTextDiv1 #actTime").val("");
				$("#<?php echo $id;?> #actTextDiv2 #actLoc").val("");
				$("#<?php echo $id;?> #actTextDiv2 #actLecturer").val("");
				//显示输入框
				$("#<?php echo $id;?> #actTextDiv1").slideDown(300);
				$("#<?php echo $id;?> #actTextDiv2").slideDown(300);
				$("#<?php echo $id;?> #actTextDiv3").slideDown(300);
			}
			else
			{
				$("#<?php echo $id;?> #actTextDiv1").slideUp(300);
				$("#<?php echo $id;?> #actTextDiv2").slideUp(300);
				$("#<?php echo $id;?> #actTextDiv3").slideUp(300);
			}
		});
	</script>
	<?php } ?>
	
	<?php if(($catalog === true) && ($getCataUrl != ""))//文章保存至的栏目，
	{?>
	<div id="catalogDiv" class="form-inline editorBlock">
		<input type="hidden" id="catalogId" value=""></input>
		<span class="help-inline span2">文章栏目*:</span> 
		<select>
		</select>	
	</div>
	<script type="text/javascript">
	//编辑器载入时就载入栏目数据
var cataDataTE = new Array();//栏目选择下拉框d的全局变量
function parseCataTE(data)//与栏目浏览器命名冲突
{
	//alert('hi');
	$.each(data,function(key,item){
		//alert(item.catalogId);
		var temp = {'id':item.catalogId,'title':item.catalogTitle,'hasText':item.hasText,'cataIntro':item.catalogIntro,'isPublic':item.isPublic};
		cataDataTE.push(temp);
		if((item.children != null) && (item.children != ""))
		{
			parseCataTE(item.children);
		}
	});
}
	$(document).ready(function(){
		//先获取了栏目列表再获取用户列表
		var data = {'data':{'method':'getCatalogById','parentCataIdArr':[1]}};
		$.post("<?php echo $getCataUrl;?>",data,function(result){
				if(result == "error")
				{
					alert("Oops!");
					return;
				}
			parseCataTE(result);//把取得的栏目列表载入到全局变量cataDataTE中
			//把栏目信息载入到下拉框中
			//alert(result);
			for(var i=0;i<=cataDataTE.length;++i)
			{
				if(i == 0)//第一项是空项
				{
				
					var tempOpt = $("<option></option>");
					tempOpt.attr("selected",false);
					tempOpt.attr('id','c0');
					tempOpt.html('请选择文章所属栏目');
					tempOpt.appendTo($("#<?php echo $id;?> #catalogDiv select"));
				}
				else if(cataDataTE[i-1].hasText == 1)
				{
					
					var tempOpt = $("<option></option>");
					tempOpt.attr("selected",false);
					if(cataDataTE[i-1].isPublic == 1)
					{
						tempOpt.attr("title","公开栏目 "+cataDataTE[i-1].cataIntro);
					}
					else
					{
						tempOpt.attr("title","内部栏目 "+cataDataTE[i-1].cataIntro);
					}
					tempOpt.attr('id','c'+cataDataTE[i-1].id);
					tempOpt.html(cataDataTE[i-1].title);
					//alert(tempOpt.attr('id'));
					tempOpt.appendTo($("#<?php echo $id;?> #catalogDiv select"));
				}
			}
		},'json');
	});
	//定义选择栏目项动作，添加其id到catalogId中
	$(document).delegate("#<?php echo $id;?> #catalogDiv select","change",function(){
		$("#<?php echo $id;?> #catalogDiv #catalogId").val("c"+getNum($("#<?php echo $id;?> #catalogDiv select option:selected").attr('id')));
		//alert($("#<?php echo $id;?> #catalogDiv #catalogId").val());
	});
function getNum(str)
{
	var reg=/^[a-zA-Z]*([0-9]+)$/g;
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



	</script>
	<?php }
	?>
	<?php if($title === true)
	{?>
	<div id="titleDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章标题*:</span> <input class="input-large" id="title"></input>
	</div>
	<?php }
	?>

	<?php if($subTitle === true)
	{?>
	<div id="subTitleDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章副标题:</span> <input class="input-large" id="subTitle"></input>
	</div>
	<?php }
	?>

	<?php if($titlePic === true)//要载入ckfinder的单独应用//注意！！popup窗口的”上传“按键在ie7中没有反应，chrome没问题
	{?>
	<div id="titlePicDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章标题图片:</span> 
		<input class="input-large" disabled="disabled" title="请点击按钮选择图片地址" id="titlePicAddr" placeholder="图片地址" type="text"></input> 
		<div class="btn" title="注意浏览器可能阻止弹出的图片选择窗口" id="getTitlePic">选择文章标题图片</div>
		<script type="text/javascript">
		$(document).delegate("#<?php echo $id;?> #titlePicDiv #getTitlePic","click",function(){
			$("#<?php echo $id;?> #titlePicAddr").prop("imgToMe",true);
			window.open("<?php echo Yii::app()->baseUrl;?>/index.php/tablr/imgUpload","_blank");
		});
		</script>
	</div>
	<?php }?>
	
	<?php if($textIntro === true){ ?>
	<div id="textIntroDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章简介:</span>
		<textarea id="textIntro"></textarea>
	</div>
	<?php } ?>
	
	<?php if($src === true){ ?>
	<div id="srcDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章来源:</span>
		<input  class="input-large" id="src"></input>
	</div>
	<?php } ?>
	
	<?php if($keyWord === true){ ?>
	<div id="keyWordDiv" class="form-inline editorBlock">
		<span class="help-inline span2">文章关键字:</span>
		<input  title="不同关键字用逗号相隔" class="input-large" id="keyWord"></input>
	</div>
	<?php } ?>
	
	<textarea name="editorMain" id="editorMain" ></textarea>
<script type="text/javascript">
	$(document).ready(function(){
		CKEDITOR.replace('editorMain', <?php echo Text::json_encode_ch($editorConfig);
		?>);	
	});
function getText(textId,textEditorId)//文章id,获取文章内容后所放入的部件组的父级div的id
{
	var data = {};
	data.textId = textId;
	$.post("<?php echo $getTextUrl;?>",data,function(result){
		//alert(result);
		//把文章内容填充至textEditorId中
		//先修改textId
		$("#<?php echo $id;?> #editTextDiv #editTextId").val("t"+result.textId);
		
		//文章是否已经提交
		if(result.submitState == "failed")
		{
			//换按钮
			$("#<?php echo $id;?> #editorCtr #submitText").removeClass("disabled");
			$("#<?php echo $id;?> #editorCtr #submitText").html("提交审核");	
			
		}
		else//提交审核中或者已经通过审核
		{
			//换按钮
			$("#<?php echo $id;?> #editorCtr #submitText").addClass("disabled");
			$("#<?php echo $id;?> #editorCtr #submitText").html("文章已提交");
			if(result.submitState == "passed")
			{
				$("#<?php echo $id;?> #editorCtr #submitText").html("审核通过");
			}
		}
		//活动
		if($("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv").length != 0)
		{
			
				$("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv #isActText").attr("disabled",false);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv1 #actTime").attr("disabled",false);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv2 #actLoc").attr("disabled",false);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv3 #actLecturer").attr("disabled",false);
			if(result.isActText == 0)
			{
				$("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv #isActText").attr("checked",false);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv1").slideUp(300);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv2").slideUp(300);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv3").slideUp(300);
			}
			else
			{
				$("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv #isActText").attr("checked",true);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv1 #actTime").val(result.act.actTime);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv2 #actLoc").val(result.act.actLoc);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv3 #actLecturer").val(result.act.actLecturer);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv1").slideDown(300);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv2").slideDown(300);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv3").slideDown(300);
			}
			//审核通过的文章活动信息也不能改了
			if(result.submitState == "passed")
			{
				$("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv #isActText").attr("disabled",true);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv1 #actTime").attr("disabled",true);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv2 #actLoc").attr("disabled",true);
				$("#<?php echo $id;?> #"+textEditorId+" #actTextDiv3 #actLecturer").attr("disabled",true);
			}
			<?php if($hasCheckComp) { //审核文章时也不能修改“是否”活动 ?>
				$("#<?php echo $id;?> #"+textEditorId+" #isActTextDiv #isActText").attr("disabled",true);
			<?php } ?>
		}
		//文章标题
		if($("#<?php echo $id;?> #"+textEditorId+" #titleDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #titleDiv #title").val(result.title);
		}
		//alert($("#<?php echo $id;?> #editTextDiv #editTextId").val());
		//文章栏目
		<?php if(!$hasCheckComp){ ?>
		if($("#<?php echo $id;?> #"+textEditorId+" #catalogDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv #catalogId").val("c"+result.catalogId);
			//alert(result.catalogId);
			//选择到这个栏目（文章通过审核后不能修改栏目 id）
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select option").each(function(){
				$(this).attr('selected',false);
				//alert($(this).html());
				if(getNum($(this).attr('id')) == result.catalogId)
				{
					$(this).attr('selected',true);
				}
			});
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('disabled',false);
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('title',"");
			if(result.submitState == "passed")
			{
				$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('disabled',true);
				$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('title',"审核通过，不能修改栏目id");
			}
		}
		
		<?php } else { //审核文章栏目id不能改变 ?>
		
		if($("#<?php echo $id;?> #"+textEditorId+" #catalogDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv #catalogId").val("c"+result.catalogId);
			//alert(result.catalogId);
			//选择到这个栏目（文章通过审核后不能修改栏目 id）
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select option").each(function(){
				$(this).attr('selected',false);
				//alert($(this).html());
				if(getNum($(this).attr('id')) == result.catalogId)
				{
					$(this).attr('selected',true);
				}
			});
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('disabled',true);
			$("#<?php echo $id;?> #"+textEditorId+" #catalogDiv select").attr('title','审核文章不能修改栏目');
			
		}
		
		<?php } ?>
		//alert($("#<?php echo $id;?> #editTextDiv #editTextId").val());
		//文章副标题
		if($("#<?php echo $id;?> #"+textEditorId+" #subTitleDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #subTitleDiv #subTitle").val(result.subTitle);
		}
		//文章简介
		if($("#<?php echo $id;?> #"+textEditorId+" #textIntroDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #textIntroDiv #textIntro").val(result.textIntro);
		}
		//文章来源
		if($("#<?php echo $id;?> #"+textEditorId+" #srcDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #srcDiv #src").val(result.src);
		}
		//文章标题图片
		if($("#<?php echo $id;?> #"+textEditorId+" #titlePicDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #titlePicDiv #titlePicAddr").val(result.titlePicAddr);
		}
		//文章关键字
		if($("#<?php echo $id;?> #"+textEditorId+" #keyWordDiv").length != 0)
		{
			$("#<?php echo $id;?> #"+textEditorId+" #keyWordDiv #keyWord").val(result.keyWord);
		}
		//文章内容
		CKEDITOR.instances.editorMain.setData(result.content);
		//alert($("#<?php echo $id;?> #editTextDiv #editTextId").val());
	},'json');
}
</script>
</div>
<?php if($hasTextList == true){ ?>
<style type="text/css">
	#<?php echo $id;?> #textListDiv{width:<?php echo $textListWidth-1;?>px;margin:0 0 0 <?php echo $editorWidth;?>;border-left:1px solid #F5D8DB;}
	#<?php echo $id;?> #textListDiv div.textListBlock{padding:5px 0 0 5px}
</style>
<div id="textListDiv">
	<div class="textListBlock">
		<span class="label label-success">我的文章</span>
	</div>
	<ul class="nav nav-pills nav-stacked">
		<div class="loading"></div>
		<!--
		<li><a href="#" id="t5" title="fa 最后编辑:2013-2">fa<i class="icon-trash"></i></a></li>
		<li><a href="#" id="t6" title="ga 最后编辑:2013-1">ga<i class="icon-trash"></i></a></li>
		-->
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//页面载入就加载文章列表一次
	//	alert('hi');
		getTextList(getNum($("#<?php echo $id;?> #authorId").val()),"textListDiv");

	});
//定义点击文章列表项动作
	$(document).delegate("#<?php echo $id;?> #textListDiv > ul > li > a","click",function(e){
		e.preventDefault();
		//alert($(this).attr('id'));
		getText(getNum($(this).attr('id')),"editTextDiv");
		$(this).parent('li').parent('ul').children("li").removeClass("active");
		$(this).parent('li').addClass("active");
	});
//定义点击文章列表项中的显示删除按钮动画
	$(document).delegate("#<?php echo $id;?> #textListDiv > ul > li > a","mouseenter",function(){
		$(this).children("a.close").show();
	});
	$(document).delegate("#<?php echo $id;?> #textListDiv > ul > li > a","mouseleave",function(){
		$(this).children("a.close").hide();
	});
//定义点击文章列表项中的删除动作
	$(document).delegate("#<?php echo $id;?> #textListDiv > ul > li > a > a","click",function(e){
		//防止冒泡
		e.stopPropagation();
		
		var data={};
		data.textId = getNum($(this).parent('a').attr('id'));
		//alert(data.textId);
		$(this).parent('a').parent('li').parent('ul').html('<div class="loading"></div>');
		$.post("<?php echo $deleteTextUrl;?>",data,function(result){
			//alert(result);
			getTextList(getNum($("#<?php echo $id;?> #authorId").val()),"textListDiv");
		});
		//当删除的是当前文章时，最后要清空编辑区(相当于点击“新建”按钮)
		if($(this).parent('a').parent('li').hasClass('active'))
		{
			//alert('新建！');
			$("#<?php echo $id;?> #editorCtr #newText").click();
		}
	});
function getTextList(u,textListDivId)
{
	var data = {};
	//alert("hi");
	data.u = u;
	//alert(data.u);	
	data.c = 0;
	data.ch = "";
	data.s = 0;
	data.n = 0;
	data.o = 'time';
	$.post("<?php echo $getTextListUrl;?>",data,function(result){
		//alert(result);
		//return;
		if(result == "error")
		{
			alert('Oops!');
			return;
		}
		// 清空列表
		$("#<?php echo $id;?> #"+textListDivId+" > ul").html("");
		//result 是字符串
		for(var i=0;i<result.length;++i)
		{
			var tempLi = $("<li></li>");
			if(getNum($("#<?php echo $id;?> #editTextDiv #editTextId").val()) == result[i].textId)//当此文章与编辑区中文章id相同时显示为active
			{
				tempLi.addClass("active");
			}
			var tempA = $("<a href='#'></a>");
			if(result[i].title.length > 6)
			{
				tempA.html(result[i].title.substring(0,6)+"..");
			}
			else
			{
				tempA.html(result[i].title);
			}
			
			var tempClose = $("<a class='close' style='margin-top:-5px;display:none' title='删除'>&times;</a>");
			
			//如果该文章已经提交
			if(result[i].submitState == "passed")
			{
				tempA.attr('title',result[i].title+" 已通过审核 最后编辑:"+result[i].editTime);
				//审核通过的文章不能删除
			}
			else if(result[i].submitState == "waiting")
			{
				tempA.attr('title',result[i].title+" 审核中 最后编辑:"+result[i].editTime);
				tempClose.appendTo(tempA);
			}
			else
			{
				tempA.attr('title',result[i].title+" 最后编辑:"+result[i].editTime);
				tempClose.appendTo(tempA);
			}
			tempA.attr('id',"t"+result[i].textId);
			tempA.appendTo(tempLi);
			$("#<?php echo $id;?> #"+textListDivId+" > ul").append(tempLi);
		}
		
	},'json');
}
</script>
<?php } ?>
</div><!--<?php echo $id;?>-->