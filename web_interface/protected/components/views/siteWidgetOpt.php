<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>}
	#<?php echo $id;?> div.block{padding:0 10px 10px 10px}
	#<?php echo $id;?> select{width:150px;margin:0}
	#<?php echo $id;?> div.alert{margin:0}
</style>
<div id="<?php echo $id;?>">
	<input id="<?php echo $id;?>catalogIdContainer" class="<?php echo $catalogIdContainer;?>" type="hidden" value=""></input>
	<script type='text/javascript'>
		$(document).ready(function(){
			//初始先载入所能使用的widget
			//getWidget($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val(),'all');
			//控件中已经载入
			setSelect();
		});
		<?php if($catalogIdContainer!='') { ?>
		$(document).delegate("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>","change",function(){
		//栏目id改变后，取栏目id取T_cHomeDesign获取widgetName,显示在自己这，把所有的widget的catalogId改变，把相应的widget css display,,触发其change事件
		if($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == null || $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == "")
		{
			alert('shit!');
			return;
		}
		var data = {};
		data.catalogId = $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val();
		//alert('alie');
		refresh(data);
	});
function refresh(data)//data.catalogId
{
	//清空原来已有的部件
	$("#<?php echo $id;?> div.addedSW").remove();
		$.post("<?php echo Yii::app()->baseUrl; ?>/index.php/cHomeDesign/get",data,function(result){
			//alert(result);
			//隐藏所有的widget
			$("div.optWidgetsDiv input.siteWidgetIdContainer").parent().css('display','none');
			//去除原来div.alert
			$("#<?php echo $id;?> div.alert").remove();
			$.each(result,function(index,item){
				var tempBlock = $("<div class='alert alert-info'><a href='#' class='close' title='删除该部件' data-dismiss='alert'>&times;</a></div>");
				var tempS = $("<div class='addedSW'>"+item.siteWidgetTitle+"</div>");
				tempS.attr('id',"sw"+item.siteWidgetId);
				tempS.appendTo(tempBlock);
				tempBlock.appendTo($("#<?php echo $id;?>"));
				var thisWidgetIndex = index;
				//显示指定的widget
				$("div.optWidgetsDiv input.siteWidgetIdContainer").each(function(){
					//alert('2');
					if(getNum($(this).val()) == item.siteWidgetId)
					{
						//alert('1');
						//alert($(this).parent().index("div.optWidget"));
						//alert(thisWidgetIndex);
						var thisWidget = $(this).parent().clone();//*******************************************************
						//这里clone导致该元素的js 载入两次！！！clone的部分所有事件处理都要先undelegate再delegate
						thisWidget.css('display','block');
						thisWidget.insertBefore("div.optWidgetsDiv div.optWidget:eq("+thisWidgetIndex+")");
						$(this).parent().remove();
						
					}
				});
			});
			
			
			
			//改变所有的widgetd的catalogId
			<?php if(!is_array($targetSelector)){ ?>
					$(<?php echo $targetSelector;?>).val($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
					$(<?php echo $targetSelector;?>).change();//噢！他改变了！
			<?php }else{ 
				foreach($targetSelector as $one)
				{
			?>
					$(<?php echo $one;?>).val($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val());
					$(<?php echo $one;?>).change();//噢！他改变了！
			
			<?php }
			} ?>
			
		},'json');
}
<?php } ?>
		//定义“添加部件”按钮
		$(document).delegate("#<?php echo $id;?> #addWidget",'click',function(){
			if(!$(this).hasClass("disabled"))
			{
				//先检查有没catalogId
				if($("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == null || $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val() == "")
				{
					alert('shit!');
					return;
				}
				var data = {};
				data.siteWidgetId = getNum($("#<?php echo $id?> select option:selected").attr('id'));
				data.catalogId = $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val();
				data.method = 'add';
				//检查有没重复
				var ok = true;
				$("#<?php echo $id;?> div.addedSW").each(function(){
					if(getNum($(this).attr('id')) == data.siteWidgetId)
					{
						$("#<?php echo $id;?> #addWidgetE").html("不能重复添加相同部件！");
						setTimeout(function(){$("#<?php echo $id;?> #addWidgetE").html("");},3000);
						//return;
						ok = false;
					}
				});
				if(!ok)
				{
					return;
				}
				
				$.post("<?php echo Yii::app()->baseUrl;?>/index.php/cHomeDesign/change",data,function(result){
					//alert(result);
					if(result == 'error')
					{
						alert('Oops!');
						return;
					}
					var data = {'catalogId':$("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val()};
					refresh(data);
				});
				
			}
		});
		//定义删除部件
		$(document).delegate("#<?php echo $id;?> div.alert a.close",'click',function(){
			var data = {};
			data.siteWidgetId = getNum($(this).parent().children('div.addedSW').attr('id'));
			data.method = "delete";
			data.catalogId = $("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val();
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/cHomeDesign/change",data,function(result){
				//alert(result);
				if(result == 'error')
				{
					alert('Oops!');
					return;
				}
				var data = {'catalogId':$("#<?php echo $id;?> input.<?php echo $catalogIdContainer; ?>").val()};
				refresh(data);
			});
		});
function setSelect()
{
	var data = <?php echo Text::json_encode_ch($siteWidgetArray);?> ;
	$.each(data,function(index,item){
		var tempOpt = $("<option>"+item.siteWidgetTitle+"</option>");
		tempOpt.attr("id","sw"+item.siteWidgetId);
		$("#<?php echo $id;?> select").append(tempOpt);
	});
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
/*function getWidget(catalogId,command)
{
	var data = {};
	data.catalogId = catalogId;
	data.command = command;
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/cHomeDesign/getWidget",data,function(result){
		alert(result);
		
	},'json');
}*/
	</script>
	<div class="block">
		<select></select><span class="space"></span><div class="btn btn-info" id="addWidget">添加部件</div>
		<span id="addWidgetE" class="help-inline"></span>
	</div>
</div>