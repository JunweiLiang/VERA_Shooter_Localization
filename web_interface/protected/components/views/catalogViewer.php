<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{width:<?php echo $width;?>;
	<?php if(!$noBorder){ ?>
		border:1px solid #F5D8DB;
		border-width:1px 1px 0 1px
	<?php } ?>
	}
	#<?php echo $id;?> a{padding:5px;line-height:20px}
	#<?php echo $id;?> a.grayText{color:rgb(170,170,170)}
	#<?php echo $id;?> li.active > a{color:white}
	#<?php echo $id;?> ul{display:block;padding:0;margin:0;overflow:hidden/*!important to kill bootstrap!*/}
	#<?php echo $id;?> li{padding:0;margin:0;}
	#<?php echo $id;?> ul li li{padding-left:20px}/*二级才开始缩进*/
	#<?php echo $id;?> ul li > a span i{cursor:pointer} 
</style>
<script type="text/javascript">

	<?php if($instantLoad){ ?>
	//页面载入时就载入栏目
		$(document).ready(function(){
			getCata<?php echo $id;?>();
		});
	<?php } ?>
	<?php if($triggerId != '') {?>
		$(document).delegate("#<?php echo $triggerId;?>",'click',function(){
			/*if(!$("#<?php echo $id;?>").prop('hasData'))
			{*/
				getCata<?php echo $id;?>();
			/*}*/
		});
	<?php } ?>
$(document).delegate("#<?php echo $id;?> a",'click',function(e){//点击动作，点击后把该栏目id填充到target中
	e.preventDefault();
	//除去其他栏目的选择
	//不能重复点击已经激活的项
	//当该栏目不是无文章栏目//无文章栏目也可以点击，因为可能想看该栏目下的text
	//if(!$(this).parent().hasClass('disabled'))
	//{
		if(!$(this).parent('li').hasClass('active'))
		{
			$("#<?php echo $id;?> li").removeClass('active');
			$(this).parent('li').addClass('active');		
			//alert(getNum($(this).attr('id')));
				<?php if($targetIntroSelector !== ''){ ?>
						$(<?php echo $targetIntroSelector;?>).val($(this).attr('title'));
						$(<?php echo $targetIntroSelector;?>).change();//噢！他改变了！
					<?php } ?>
					<?php if($targetTitleSelector !== ''){ ?>
						$(<?php echo $targetTitleSelector;?>).val($(this).html());
						//alert($(this).attr('title'));
						$(<?php echo $targetTitleSelector;?>).change();//噢！他改变了！
					<?php } ?>
			<?php if(!is_array($targetSelector)){ ?>
					
					$(<?php echo $targetSelector;?>).val(getNum($(this).attr('id')));
					$(<?php echo $targetSelector;?>).change();//噢！他改变了！
					
			<?php }else{ 
				foreach($targetSelector as $one)
				{
			?>
					$(<?php echo $one;?>).val(getNum($(this).attr('id')));
					$(<?php echo $one;?>).change();//噢！他改变了！
			
			<?php }
			} ?>
		}
//	}
	
});
<?php if(!$dynamicChange){ ?>
function getCata<?php echo $id;?>()//根据管理栏目的id组去catalog取栏目数据 
{
	//先把数据区域变成等待输入
	$("#<?php echo $id;?>").html("<div class='loading'></div>");
	<?php 
		if($noChild === false)
		{
			$cataIdArr = array('data'=>array('method'=>'getCatalogById','parentCataIdArr'=>$catalogIdArray));//方便直接构造json
		}
		else
		{
			$cataIdArr = array('data'=>array('method'=>'getCatalogNodeById','cataIdArr'=>$catalogIdArray));//方便直接构造json			
		}
	?>
	//alert('hi');
	$.post("<?php echo $getUrl;?>",<?php echo Text::json_encode_ch($cataIdArr);?>,function(res){
		//alert(res);
		//$("#<?php echo $id;?>").prop("hasData",true);
		processCata<?php echo $id;?>(res,"<?php echo $id;?>");
		
		<?php if($instantChange){ 
		//载入完毕，点击第n-1个栏目
		?>
			<?php if(!is_array($instantChangeIndex)){ ?>
				$("#<?php echo $id;?> a").eq(<?php echo $instantChangeIndex;?>).click();
			<?php } ?>
		<?php } ?>
	},'json');//返回json数据
}
<?php } ?>
function processCata<?php echo $id;?>(result,id)//直接处理ajaxx返回的json数据,打印入div#id中
{

	//alert(result);//返回json格式数据
	if(result == "error")
	{
		$("#"+id).html("<span class='help-inline' style='red'>错误操作</span>");
		return;
	}
	//$("#"+id).prop('hasData',true);//标记已经载入完毕数据
	$("#"+id).html("");
	parseCata<?php echo $id;?>(result).appendTo("#"+id);
}
function parseCata<?php echo $id;?>(data)//根据json数据构造栏目目录//注意每个栏目的id中加入了"c"前缀
{
	var tempul = $("<ul class='nav nav-pills nav-stacked'></ul>");
	<?php if($hasAll){ ?>
	tempul.append("<li><a id='all' href='#'>全部</a></li>");
	<?php } ?>
	$.each(data,function(key,item){
		var templi1 = $("<li></li>");
		var tempa = $("<a id='c"+item.catalogId+"' href='#'>"+item.catalogTitle+"</a>"); 
		tempa.attr('title',item.catalogIntro);
		
			if(item.hasText == 0)
			{
				
				tempa.attr('title',tempa.attr('title')+' 该栏目为无文章栏目');
			}
			if(item.isPublic == 0)
			{
				//tempa.css('color','rgb(170,170,170)');
				tempa.addClass("grayText");
				tempa.attr('title',tempa.attr('title')+' 该栏目为内部栏目');
			}
			
		<?php if(!$showNoText){  ?>
		if(item.hasText == 0)
		{
			templi1.css('display','none');
		}
		<?php }?>
		<?php if(!$showInternal){ ?>
		if(item.isPublic == 0)
		{
			templi1.css('display','none');
		}
		<?php }?>
			
		tempa.appendTo(templi1);
		templi1.appendTo(tempul);
		if((item.children != null) && (item.children != ""))
		{
			var templi2 = $("<li></li>");
			var temp = parseCata<?php echo $id;?>(item.children);
			temp.appendTo(templi2);
			templi2.appendTo(tempul);
		}
	});
	return tempul;
}
function getNum(str)
{
	if(str == "all")
	{
		return "all";
	}
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
<?php if($dynamicChange && $cataIdArrContainerId != ''){ ?>
	$(document).delegate("#<?php echo $cataIdArrContainerId;?>","change",function(){
		//catalogId 改变了！现在取此id的信息
		if($("#<?php echo $cataIdArrContainerId;?>").val() != 0)
		{
			//alert($("#<?php echo $cataIdArrContainerId;?>").val());
			dynamicGetCata<?php echo $id;?>($("#<?php echo $cataIdArrContainerId;?>").val());
		}
	});
function dynamicGetCata<?php echo $id;?>(catalogId)
{
	

	$("#<?php echo $id;?>").html("<div class='loading'></div>");
	<?php 
		if($noChild === false)
		{ ?>
			var data = {"data":{"method":"getCatalogById","parentCataIdArr":[catalogId]}};	<?php	
	}
		else
		{ ?>
			var data = {"data":{"method":"getCatalogNodeById","cataIdArr":[catalogId]}};	
	<?php
		}
	?>
		//alert(data.data.parentCataIdArr[0]);
	$.post("<?php echo $getUrl;?>",data,function(res){

		processCata<?php echo $id;?>(res,"<?php echo $id;?>");
		
		
	},'json');//返回json数据
	
}
<?php } ?>
</script>
<?php if($dynamicChange && $cataIdArrContainerId != ''){ ?>
	<input id="<?php echo $cataIdArrContainerId;?>" type="hidden" value=""></input>
<?php } ?>
<div id="<?php echo $id;?>">
</div>