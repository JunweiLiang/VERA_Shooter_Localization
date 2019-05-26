<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/

?>
<style type="text/css">
	#<?php echo $id?>{padding:5px;}
	#<?php echo $id?> > div.line > span.genE,#<?php echo $id?> > div.line > span.gensE{
		font-size:13px;
		color:red;
	}
</style>
<script type="text/javascript">
$(document).delegate("#<?php echo $id?> > div.addJudge","click",function(){
	var data = {};
	data.userName = $("#<?php echo $id?> > div.line > input.name").val();
	if(data.userName != "")
	{
		//先检查用户名是否重复
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/ifUserNameExists",data,function(result){
			if(result == "false")
			{	
				var data = {};
				data.userName = $("#<?php echo $id?> > div.line > input.name").val();
				//获取管辖的赛区
				data.JArray = getJArray();
				if(data.JArray.length == 0)
				{
					<?php echo $id;?>showGenE("请选择评委所属赛区!");
					return;
				}
				if(data.userName != "")
				{
					$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/add",data,function(result){
						alert(result);
						<?php echo $id;?>showGenE("新建成功!");
						<?php echo $id;?>reset();
						<?php if($targetSelector != ""){ ?>
							$("<?php echo $targetSelector;?>").change();
						<?php } ?>
					});
				}
			}
			else
			{
				<?php echo $id;?>showGenE("该用户名已经被使用 ");
			}
		});
	}
});
function getJArray()
{
	var JArray = [];
	$("#<?php echo $id;?> > div.zone > input.cata:checked").each(function(){
		//alert("a");
		JArray.push($(this).val());
	});
	return JArray;
}
//点击全选
$(document).delegate("#<?php echo $id?> > div.zone > input.all","click",function(){
	if($(this).prop("checked"))
	{
		$("#<?php echo $id;?> > div.zone > input.cata").prop("checked",true);
	}
	else
	{
		$("#<?php echo $id;?> > div.zone > input.cata").prop("checked",false);
	}
});
function <?php echo $id;?>reset()
{
	$("#<?php echo $id?> > div.zone > input.cata").prop("checked",false);
	$("#<?php echo $id?> > div.line > input.name").val("");
	$("#<?php echo $id?> > div.line > textarea.names").val("");
}
function <?php echo $id;?>showGenE(str)
{
	$("#<?php echo $id?> > div.line > span.genE").html(str);
	setTimeout(function(){
		$("#<?php echo $id?> > div.line > span.genE").html("");
	},3000);
}
function <?php echo $id;?>showGensE(str)
{
	$("#<?php echo $id?> > div.line > span.gensE").html(str);
	
}
//点击批量产生
$(document).delegate("#<?php echo $id?> > div.addJudges","click",function(){
	var data = {};
	data.names = getNames($("#<?php echo $id?> > div.line > textarea.names").val());
	data.JArray = getJArray();
	if((data.names.length == 0) || (data.JArray.length == 0))
	{
		<?php echo $id;?>showGensE("请选择赛区或输入用户名");
		return;
	}
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judgeManage/addNames",data,function(result){
					//	alert(result);
						if(result.badNames.length > 0)
						{
							var str = "";
							for(var i = 0;i<result.badNames.length;++i)
							{
								str+=result.badNames[i]+" ";
							}
							<?php echo $id;?>showGensE("成功生成"+result.successNum+"个评委,因重名失败"+result.badNames.length+"个,重名的是:"+str);
						}
						else
						{
							<?php echo $id;?>showGensE("成功生成"+result.successNum+"个评委");
						}
						<?php echo $id;?>reset();
						<?php if($targetSelector != ""){ ?>
							$("<?php echo $targetSelector;?>").change();
						<?php } ?>
					},'json');
});
function getNames(str)
{
	//用换行间隔的名字集合
	//alert(str);
	var res = [];
	str = $.trim(str);
	if(str == "")
	{
		return [];
	}
	names = str.split("\n");
	for(var i=0;i<names.length;++i)
	{
		res.push($.trim(names[i]));
	}
	return res;
}
</script>
<div id="<?php echo $id?>">
	<div class="line">评委所属赛区</div>
	<div class="zone">
		<input class="all" type="checkbox" value="all"></input> 全部<br/>
		<?php
			foreach($JMArray as $one)
			{ ?>
			<input class="cata" type="checkbox" value="<?php echo $one['catalogId']?>"></input> <?php echo $one['catalogTitle']?><br/>
		<?php	}
		?>
	</div>
	<div class="line">
		批量新建评委，评委登录名(登录密码与登录名相同)(用换行间隔):<br/>
		<textarea class="names" style="height:150px"></textarea><br/>
		<span class="gensE"></span>
	</div>
	<div class="btn btn-block btn-small btn-primary addJudges">批量新建评委</div>
	<div class="line">
		新建一个评委，评委登录名(登录密码与登录名相同):<br/>
		<input class="name" type="text"></input><br/>
		<span class="genE"></span>
	</div>
	<div class="btn btn-block btn-small btn-primary addJudge">新建一个评委</div>
	
</div>