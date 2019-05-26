<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	/*目录展示例子
	<div id="catalogMain">
		<ul class="nav nav-pills nav-stacked">  
			<li>
				<a id="c12" href="#">首页</a>
			</li>
			<li>
				<a id="c12" href="#">首页</a>
			</li>  
			<li>
				<a id="c12" href="#">首页</a>
			</li>  
			<li>
				<ul class="nav nav-pills nav-stacked">  
					<li >
						<a id="c12" href="#">首页</a>
					</li>
					<li>
						<ul class="nav nav-pills nav-stacked">  
							<li >
								<a id="c12" href="#">首页</a>
							</li>
							<li>
								<a id="c12" href="#">首页</a>
							</li>  
							<li>
								<ul class="nav nav-pills nav-stacked">  
									<li class="active">
										<a id="c12" href="#">首页</a>
									</li>
								</ul>
							</li>
							<li>
								<a id="c12" href="#">首页</a>
							</li>  
						</ul>
					</li>
					<li>
						<a id="c12" href="#">首页</a>
					</li>  
					<li>
						<a id="c12" href="#">首页</a>
					</li>  
				</ul>
			</li>
			<li>
				<a id="c12" href="#">首页</a>
			</li> 		
		</ul>
	</div>
	*/
?>
<style type="text/css">
#<?php echo $id;?>{position:relative}
	#<?php echo $id;?> div.line{padding:5px 0;font-size:13px;}
	#<?php echo $id;?> div.left{float:left;width:250px}
	#<?php echo $id;?> input{margin:0;}
	#<?php echo $id;?> span.help-inline{color:orange}
	#<?php echo $id;?> #catalogMain{margin:0 0 0 251px;border-left:1px solid #F5D8DB}
	#<?php echo $id;?> #catalogMain a{padding:5px;line-height:20px}
	#<?php echo $id;?> #catalogMain ul{display:block;padding:0;margin:0;overflow:hidden/*!important to kill bootstrap!*/}
	#<?php echo $id;?> #catalogMain li{padding:0;margin:0;}
	#<?php echo $id;?> #catalogMain ul li li{padding-left:20px}/*二级才开始缩进*/
	#<?php echo $id;?> #catalogMain ul li > a span i{cursor:pointer} 
	#<?php echo $id;?> textarea{margin:0;width:200px}
</style>
<div id="<?php echo $id;?>">
	<!--<div id="catalogMask" style="display:none" class="mask"><div class="loading"></div></div>-->
	<div class="left">
		<div id="catalogCtr"><div class="btn" id="newCatalogB">新建栏目</div> <div class="btn disabled" title="点击新建栏目收起新建区后点击要修改栏目的edit图标" id="editCatalogB">修改栏目</div></div>
		<div id="newCatalogDiv" style="display:none">
			<div class="line">
				<span class="label label-important">父栏目名:</span>&nbsp;<input class="input-medium" id="parentCataName" disabled="disabled" title ="选择父栏目.." placeholder="选择父栏目.."></input><input type="hidden" id="parentCataId" value=""></input>
			</div>
			<div class="line">
				<span class="label label-success">新栏目名:</span>&nbsp;<input class="input-medium" id="cataName" placeholder="新栏目名.."></input>
			</div>
			<div class="line">
				<span class="label label-success">栏目简介:</span>&nbsp;<textarea rows='2' id="cataIntro"></textarea>  
			</div>
			<div class="line"><input type="radio" name="isPublic" id="isPublic" >
				</input> 公开栏目 <input type="radio" name="isPublic" id="notPublic" checked="checked"> 内部栏目 
			</div>
			<div class="line">
				<input type="radio" name="hasText" id="hasText" checked="checked"></input> 有文章栏目 <input type="radio" name="hasText" id="noText" > 无文章栏目 
			</div>
			<div class="line">
				<div class="btn btn-success" id="newCataComfirm">确定</div> <div class="btn" id="newCataCancel">取消</div><span class="help-inline" id="newCatalogE"></span>
			</div>
		</div>
		<div id="editCatalogDiv" style="display:none">
			<div class="line">
				<span class="label label-important">当前父栏目:</span>&nbsp;<input class="input-medium" id="EparentCataName" disabled="disabled" title ="选择父栏目.."></input><input type="hidden" id="EparentCataId" value=""></input>
			</div>
			<div class="line">
				<span class="label label-success">更改栏目名:</span>&nbsp;<input class="input-medium" id="EcataName" placeholder="栏目名不能为空"></input><input type="hidden" id="EthisCataId" value="">
			</div>
			<div class="line">
				<span class="label label-success">栏目简介:</span>&nbsp;<textarea rows='2' id="EcataIntro"></textarea> 
			</div>
			<div class="line">
			<input type="radio" name="EisPublic" id="EisPublic" >
				</input> 公开栏目 <input type="radio" name="EisPublic" id="EnotPublic" checked="checked"> 内部栏目 
			</div>
			<div class="line">
				<input type="radio" name="EhasText" id="EhasText" checked="checked"></input> 有文章栏目 <input type="radio" name="EhasText" id="EnoText" > 无文章栏目 
			</div>
			<div class="line">
				<div class="btn btn-danger" id="editCataComfirm">确定更改</div> <div class="btn" id="editCataCancel">取消</div><span class="help-inline" id="editCatalogE"></span>
			</div>
		</div>
	</div>
	<div id="catalogMain"><div class="loading"></div></div>
</div>
<script type="text/javascript">
	<?php
		if($instantLoad == true)//进入页面就载入栏目数据
		{
	?>
			$(document).ready(function(){
				getCata();
			});
	<?php
		}
		else//等待$triigerId被点击才载入栏目数据
		{ ?>
			$(document).delegate("#<?php echo $triggerId;?>","click",function(){
				
				if(!$("#catalogMain").prop('hasData'))//第一次点击才触发载入数据
				{
					getCata();
				}
		});
	<?php
		}
	?>
	//定义“新建栏目”/“新建栏目”中的”取消“动作
	$(document).delegate("#<?php echo $id;?> #newCatalogB,#<?php echo $id;?> #newCataCancel","click",function(){
		if(!$(this).hasClass("disabled"))
		{
			$("#newCatalogDiv").slideToggle(200,function(){		
				if($("#newCatalogDiv").css('display') == "block")//打开了“新建栏目”div
				{
					getCtrOut();
				}
				else if($("#newCatalogDiv").css('display') == "none")
				{
					putCtrOn();
				}
				//每次点击都将“新建栏目”里的内容清空
				refreshNewCata();
				//每次点击都将右边栏的active去除
				$("#<?php echo $id;?> #catalogMain li").removeClass("active");
			
			});		
		}
	});
	//定义选择栏目到新建栏目/修改栏目的动作
	$(document).delegate("#<?php echo $id;?> #catalogMain a",'click',function(e){
		e.preventDefault();
		if(($("#<?php echo $id;?> #newCatalogDiv").css('display') == "block") || ($("#<?php echo $id;?> #editCatalogDiv").css('display') == "block"))//“新建栏目”显示或者“修改栏目“显示
		{
			
			//填入栏目名，栏目id
			if($("#<?php echo $id;?> #newCatalogDiv").css('display') == "block")//新建栏目的选择动作
			{
				$("#<?php echo $id;?> #newCatalogDiv #parentCataName").val($(this).html());
				$("#<?php echo $id;?> #newCatalogDiv #parentCataId").val(getNum($(this).attr('id')));
				
			}
			else//修改栏目的选择动作#<?php echo $id;?> #editCatalogDiv #EparentCataName
			{
				if($(this).parent().hasClass("disabled"))//点击自己
				{
					return;
				}
				$("#<?php echo $id;?> #editCatalogDiv #EparentCataName").val($(this).html());
				$("#<?php echo $id;?> #editCatalogDiv #EparentCataId").val(getNum($(this).attr('id')));
				
			}
			//去除其他active
			$("#<?php echo $id;?> #catalogMain li").removeClass("active");
			//显示active
			$(this).parent().addClass("active");		
		}
	});
	//定义“新建栏目”中“确定”的动作
	$(document).delegate("#<?php echo $id;?> #newCataComfirm","click",function(){
		//首先检查输入
		var a = $("#<?php echo $id;?> #newCatalogDiv #newCatalogE");//操作提示的对象
		if(($("#<?php echo $id;?> #newCatalogDiv #parentCataName").val() == "") || ($("#<?php echo $id;?> #newCatalogDiv #parentCataId").val() == ""))
		{
			a.html("请选择新栏目所属父栏目");
			setTimeout(function(){a.html("");},3000);
			return;
		}
		else if($("#<?php echo $id;?> #newCatalogDiv #cataName").val() == "")
		{
			a.html("请输入新栏目的名称");
			setTimeout(function(){a.html("");},3000);
			return;
		}
		else
		{	
			var id = $("#<?php echo $id;?> #newCatalogDiv #parentCataId").val();
			var isPublic = "1";
			if($("#newCatalogDiv #isPublic").is(':checked') == false)
			{
				isPublic = "0";
			}
			var hasText = "1";
			if($("#newCatalogDiv #hasText").is(':checked') == false)
			{
				hasText = "0";
			}
			var cataTitle = $("#<?php echo $id;?> #newCatalogDiv #cataName").val();
			var cataIntro = $("#<?php echo $id;?> #newCatalogDiv #cataIntro").val();
			//构造json数据提交
				//先禁用确定按钮，显示等待框
				$(this).attr("disabled",true);
				$("#<?php echo $id;?> #newCatalogDiv #newCataCancel").attr("disabled",true);
				a.html("<div class='loading'></div>");
			var data = {'add':{'parentId':id,'isPublic':isPublic,'hasText':hasText,'cataTitle':cataTitle,'cataIntro':cataIntro}};
			$.post("<?php echo $addUrl;?>",data,function(result){
				//alert(result);
				refreshNewCata();
				$("#<?php echo $id;?> #newCataComfirm").attr("disabled",false);
				$("#<?php echo $id;?> #newCatalogDiv #newCataCancel").attr("disabled",false);
				if(result == "error")
				{
					a.html("操作出错，请重试");
					setTimeout(function(){a.html("");},3000);
					return;
				}
				else if(result == "ok")
				{
					a.html("栏目新建成功");
					setTimeout(function(){a.html("");},3000);
					//刷新右边栏目列表
						//显示载入中
						$("#<?php echo $id;?> #catalogMain").html('<div class="loading"></div>');
					getCata();
					return;
				}
				else
				{
					a.html("出错，请重试");
					setTimeout(function(){a.html("");},3000);
					return;
				}
			});
		}
	});
	//定义“修改栏目”中“确定”的动作
	$(document).delegate("#<?php echo $id;?> #editCataComfirm","click",function(){
		//首先检查输入
		var a = $("#<?php echo $id;?> #editCatalogDiv #editCatalogE");//操作提示的对象
		if(($("#<?php echo $id;?> #editCatalogDiv #EparentCataName").val() == "") || ($("#<?php echo $id;?> #editCatalogDiv #EparentCataId").val() == ""))
		{
			a.html("请选择新栏目所属父栏目");
			setTimeout(function(){a.html("");},3000);
			return;
		}
		else if($("#<?php echo $id;?> #editCatalogDiv #EcataName").val() == "")
		{
			a.html("请输入新栏目的名称");
			setTimeout(function(){a.html("");},3000);
			return;
		}
		else
		{	
			var id = $("#<?php echo $id;?> #editCatalogDiv #EparentCataId").val();
			var isPublic = "1";
			if($("#editCatalogDiv #EisPublic").is(':checked') == false)
			{
				isPublic = "0";
			}
			var hasText = "1";
			if($("#editCatalogDiv #EhasText").is(':checked') == false)
			{
				hasText = "0";
			}
			var cataTitle = $("#<?php echo $id;?> #editCatalogDiv #EcataName").val();
			var cataIntro = $("#<?php echo $id;?> #editCatalogDiv #EcataIntro").val();
			var thisId = $("#<?php echo $id;?> #editCatalogDiv #EthisCataId").val();
			//构造json数据提交
				//先禁用确定与取消按钮，显示等待框
				$(this).attr("disabled",true);
				$("#<?php echo $id;?> #editCatalogDiv #editCataCancel").attr("disabled",true);
				a.html("<div class='loading'></div>");
			var data = {'data':{'method':'changeThis','parentId':id,'isPublic':isPublic,'hasText':hasText,'cataTitle':cataTitle,'catalogId':thisId,'cataIntro':cataIntro}};
			//alert('thisId'+thisId+'parentId'+id+'isPublic'+isPublic+'hasText'+hasText+'cataTitle'+cataTitle);
			//return;
			$.post("<?php echo $changeUrl;?>",data,function(result){
				//alert(result);
			
				$("#<?php echo $id;?> #editCataComfirm").attr("disabled",false);
				$("#<?php echo $id;?> #editCatalogDiv #editCataCancel").attr("disabled",false);
				if(result == "error")
				{
					a.html("操作出错，请重试");
					setTimeout(function(){a.html("");},3000);
					return;
				}
				else if(result == "ok")
				{
					a.html("栏目修改成功");
					setTimeout(function(){a.html("");},3000);
					refreshEditCata();
					//关闭”修改栏目“区域
					$("#<?php echo $id;?> #editCataCancel").click();
					//
					//刷新右边栏目列表
						//显示载入中
						$("#<?php echo $id;?> #catalogMain").html('<div class="loading"></div>');
					getCata();
					return;
				}
				else
				{
					a.html("出错，请重试");
					setTimeout(function(){a.html("");},3000);
					return;
				}
			});
		}
	});
	//定义栏目修改按钮等点击动作
	$(document).delegate("#<?php echo $id;?> #catalogMain ul li > a span i","click",function(e){
		if($("#catalogMain").prop("processing"))//一次处理一个操作
		{
			return;
		}
		else
		{
			$("#catalogMain").prop("processing",true);
		}
		//下面每次操作记住最后解除锁
		if($(this).hasClass("icon-arrow-up"))
		{
			//出现mask防止重复操作
			//$("#catalogMask").show(100);
			var data = {'data':{'method':'upThis','catalogId':getNum($(this).parent().parent().attr('id'))}};
			$.post("<?php echo $changeUrl?>",data,function(result){
				//alert(result);
				
				getCata();
				//关闭mask	
				//$("#catalogMask").hide(100);
				$("#catalogMain").prop("processing",false);
			});
		}else if($(this).hasClass("icon-arrow-down"))
		{
			var data = {'data':{'method':'downThis','catalogId':getNum($(this).parent().parent().attr('id'))}};
			$.post("<?php echo $changeUrl?>",data,function(result){
				//alert(result);				
				getCata();
				//关闭mask	
				//$("#catalogMask").hide(100);
				$("#catalogMain").prop("processing",false);
			});
		}else if($(this).hasClass("icon-edit"))
		{
			e.stopPropagation();//阻止click事件冒泡到<a>上
			//显示”改变栏目“对话框，去除栏目的控制,启用"改变栏目"按钮，禁用'新建栏目'按钮
			$("#<?php echo $id;?> #newCatalogB").addClass("disabled");
			$("#<?php echo $id;?> #editCatalogB").removeClass("disabled");
			$("#<?php echo $id;?> #editCatalogB").attr("title","点击取消修改栏目");
			$("#<?php echo $id;?> #editCatalogDiv").css('display',"block");
			//禁用此栏目，不能以自己作为父栏目
			$(this).parent().parent().parent().addClass("disabled");
			//获取此栏目的父栏目
			var temp = $(this).parent().parent();
			getCtrOut();
			temp.parent().parent().parent().prev('li').children('a').click();
			//添加到”更改栏目名“中
				$("#<?php echo $id;?> #editCatalogDiv #EcataName").val(temp.html());
			//把当前栏目的id添加到”更改栏目名“的id中
				$("#<?php echo $id;?> #editCatalogDiv #EthisCataId").val(getNum(temp.attr('id')));
			//把当前栏目简介添加到修改中
				$("#<?php echo $id;?> #editCatalogDiv #EcataIntro").val(temp.parent().children('input.cataIntro').val());
			$("#catalogMain").prop("processing",false);
		}else if($(this).hasClass("icon-remove"))
		{
			//alert("removethis="+$(this).parent().parent().attr('id'));
			//删除栏目,弹出确认框
			if(confirm("删除栏目将删除此栏目以及其子栏目以及对应的所有文章与作品(以及参赛账号)，是否继续?"))
			{
				var data = {'data':{'method':'removeThis','catalogId':getNum($(this).parent().parent().attr('id'))}};
				$.post("<?php echo $changeUrl?>",data,function(result){
					alert(result);				
					getCata();
					//关闭mask	
					//$("#catalogMask").hide(100);
					$("#catalogMain").prop("processing",false);
				});
			}else{
				//do nothing
				$("#catalogMain").prop("processing",false);
				return;
			}
		}
	});
	//定义改变栏目按钮动作，取消改变栏目
	$(document).delegate("#<?php echo $id;?> #editCatalogB,#<?php echo $id;?> #editCataCancel","click",function(){
		if(!$("#<?php echo $id;?> #editCatalogB").hasClass("disabled"))
		{
			$("#<?php echo $id;?> #newCatalogB").removeClass("disabled");
			$("#<?php echo $id;?> #editCatalogB").addClass("disabled");
			$("#<?php echo $id;?> #editCatalogB").attr("title","点击要修改栏目的edit图标");
			$("#<?php echo $id;?> #editCatalogDiv").hide(100);
			$("#<?php echo $id;?> #catalogMain li").removeClass("disabled");
			putCtrOn();	
			//每次点击都将“新建栏目”里的内容清空
			refreshEditCata();
			//每次点击都将右边栏的active去除
			$("#<?php echo $id;?> #catalogMain li").removeClass("active");
		}
	});
	//下面是函数部分 
function refreshNewCata()//"新建栏目"内容的刷新操作
{
	$("#newCatalogDiv #parentCataName").val("");
	$("#newCatalogDiv #parentCataId").val("");
	$("#newCatalogDiv #cataIntro").val("");
	$("#newCatalogDiv #isPublic").attr('checked',false);
	$("#newCatalogDiv #notPublic").attr('checked',true);
	$("#newCatalogDiv #hasText").attr('checked',true);
	$("#newCatalogDiv #noText").attr('checked',false);
	$("#newCatalogDiv #cataName").val("");
}
function refreshEditCata()//"新建栏目"内容的刷新操作
{
	$("#newCatalogDiv #EparentCataName").val("");
	$("#newCatalogDiv #EparentCataId").val("");
	$("#newCatalogDiv #EcataIntro").val("");
	$("#newCatalogDiv #EisPublic").attr('checked',false);
	$("#newCatalogDiv #EnotPublic").attr('checked',true);
	$("#newCatalogDiv #EhasText").attr('checked',true);
	$("#newCatalogDiv #EnoText").attr('checked',false);
	$("#newCatalogDiv #EcataName").val("");
}
function getCata()//根据管理栏目的id组去catalog取栏目数据 
{
	//先把数据区域变成等待输入
	$("#catalogMain").html("<div class='loading'></div>");
	<?php 
		$parentCataIdArr = array('data'=>array('method'=>'getCatalogById','parentCataIdArr'=>$parentCataIdArr));//方便直接构造json
	?>
	//alert('<?php echo Text::json_encode_ch($parentCataIdArr);?>');
	$.post("<?php echo $getUrl;?>",<?php echo Text::json_encode_ch($parentCataIdArr);?>,function(res){
		//alert(res);
		processCata(res,"catalogMain");
		putCtrOn();
	},'json');//返回json数据
}
function putCtrOn()//载入栏目修改的按钮(当“新建栏目”或者“修改栏目”未打开)
{
	if($("#<?php echo $id;?> #newCatalogDiv").css('display') == "none")
	{
		var tempSpan = $("<span style='margin-left:10px;height:14px' class='label label-info'> <i title='上移此栏目' class='icon-arrow-up'></i><i title='下移此栏目' class='icon-arrow-down'></i> <i  title='修改此栏目' class='icon-edit'></i> <i title='删除此栏目' class='icon-remove'></i></span>");
		$("#<?php echo $id;?> #catalogMain ul li a").append(tempSpan);
		//去掉首级栏目的控制
		$("#<?php echo $id;?> #catalogMain > ul > li > a span.label").remove();
	}
}
function getCtrOut()//去掉栏目修改的按钮
{
	$("#<?php echo $id;?> #catalogMain ul li a span.label").remove();
}
function processCata(result,id)//直接处理ajaxx返回的json数据,打印入div#id中
{

	//alert(result);//返回json格式数据
	if(result == "error")
	{
		$("#"+id).html("<span class='help-inline' style='red'>错误操作</span>");
		return;
	}
	$("#"+id).prop('hasData',true);//标记已经载入完毕数据
	$("#"+id).html("");
	parseCata(result).appendTo("#"+id);
}
function parseCata(data)//根据json数据构造栏目目录//注意每个栏目的id中加入了"c"前缀
{
	var tempul = $("<ul class='nav nav-pills nav-stacked'></ul>");
	$.each(data,function(key,item){
		var templi1 = $("<li></li>");
		var tempa = $("<a title='"+item.catalogIntro+"' id='c"+item.catalogId+"' href='#'>"+item.catalogTitle+"</a>"); 
		
			//显示栏目的具体信息，内外部，有无文章
			if(item.hasText == 1)
			{
				var tempText1 = " 有文章栏目 ";
			}
			else
			{
				var tempText1 = " 无文章栏目 ";
			}
			if(item.isPublic == 1)
			{
				var tempText2 = "公开栏目 ";
			}
			else
			{
				var tempText2 = "内部栏目 ";
			}
			var tempInfo = $("<span class='help-inline' style='font-size:12px;color:gray'>"+tempText1+tempText2+" "+item.catalogIntro+"</span>");
			var tempIntro = $("<input type='hidden' value='"+item.catalogIntro+"' class='cataIntro'></input>");
			
		tempa.appendTo(templi1);
			tempInfo.appendTo(templi1);
			tempIntro.appendTo(templi1);
		templi1.appendTo(tempul);
		if((item.children != null) && (item.children != ""))
		{
			var templi2 = $("<li></li>");
			var temp = parseCata(item.children);
			temp.appendTo(templi2);
			templi2.appendTo(tempul);
		}
	});
	return tempul;
}
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
</script>