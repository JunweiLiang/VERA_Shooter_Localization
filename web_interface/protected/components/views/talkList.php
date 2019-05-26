<?php 
	/****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<style type='text/css'>
	#<?php echo $id?>{width:<?php echo $width;?>}
	#<?php echo $id?> > div.talkList{padding:20px}
	#<?php echo $id?> > div.talkList > div.talkBlock{margin-bottom:10px;background-color:rgb(245,245,245);padding:5px}
	#<?php echo $id?> > div.talkList > div.more{cursor:pointer;background-color:rgb(140,0,0);color:white}
	#<?php echo $id?> > div.talkList > div.left > div.nameDiv{width:100px;float:left;}
	#<?php echo $id?> > div.talkList > div.left > div.nameDiv > .name{display:block;text-align:center}
	#<?php echo $id?> > div.talkList > div.left > div.content{margin:0 0 0 100px;}
	#<?php echo $id?> > div.talkList > div.right {margin-left:100px}
	#<?php echo $id?> > div.talkList > div.right > div.content{margin:0}
</style>
<div id="<?php echo $id;?>">
	<div class='talkList'>
	</div>
</div>
<script type='text/javascript'>
$(document).ready(function(){
	getTalk();
	<?php if($constantCheck){ ?>
		setInterval(function(){
			getTalkInstant();
		},<?php echo $checkFrequence;?>);
	<?php } ?>
});
//查看更多 按钮动作 
$(document).delegate("#<?php echo $id;?> > div.talkList > div.more","click",function(){	
	//alert($(this).parent().children("div.talkBlock").eq(-1).attr("id"));
	getTalk(getNum($(this).parent().children("div.talkBlock").eq(-1).attr("id")));
	$(this).remove();
});
<?php if($constantCheck){ ?>
function getTalkInstant()
{
	if($("#<?php echo $id?> > div.talkList").prop("getting"))
	{
		return;
	}
	var data = {};
	//alert('hi');
	if($("#<?php echo $id?> > div.talkList > div.talkBlock").length == 0)
	{
		return;//no one will notice this bug.
	}
	data.s = getNum($("#<?php echo $id?> > div.talkList > div.talkBlock").eq(0).attr('id'));
	//alert(data.s);
	data.after = 1;
	data.n = "infinite";
	//上锁
	$("#<?php echo $id?> > div.talkList").prop("getting",true);
	$.post("<?php echo $getUrl;?>",data,function(result){
		//alert(result);
		$.each(result,function(index,item){
			var tempBlock = makeOneBlock(item);
			tempBlock.css("display","none");
			tempBlock.prependTo("#<?php echo $id;?> > div.talkList");
			tempBlock.fadeIn(300);
			//alert('i');
		});<?php /*排在前面的是早些的对话*/ ?>
		$("#<?php echo $id?> > div.talkList").prop("getting",false);
	},'json');
}
<?php } ?>
function getTalk()
{
	<?php /*s for start talkId(0 for start from the latest),n for how many back,*/ ?>
	var s = arguments[0]?arguments[0]:0;
	var n = arguments[1]?arguments[1]:<?php echo $talkNum;?>;
	//alert(n);
	var tempLoading = $("<div class='wrapLoading'><div class='loading'></div></div>");
	tempLoading.appendTo("#<?php echo $id;?> > div.talkList");
	var data = {};
	data.s = s;
	data.n = n;
	$.post("<?php echo $getUrl;?>",data,function(result){
		//alert(result);
		//先清除最后的等待div
		$("#<?php echo $id;?> > div.talkList").children("div").eq(-1).remove();
		var count = 0;
		$.each(result,function(index,item){
			var tempBlock = makeOneBlock(item);
			//alert(tempBlock.attr('id'));
			tempBlock.appendTo("#<?php echo $id;?> > div.talkList");
			count++;
		});
		if(count >= <?php echo $talkNum;?>)
		{
			//显示查看更多 
			var tempMore = $("<div class='more'><div class='wrapLoading'>查看更多</div></div>");		
			tempMore.appendTo("#<?php echo $id;?> > div.talkList");
			
		}
	},'json');
}


function makeOneBlock(item)
{
var tempBlock = $("<div class='talkBlock'></div>");
	tempBlock.attr('id','t'+item.id);
			if(item.me == 1)
			{
				tempBlock.addClass("right");
			}
			else//非本人发的，构造发布人节点
			{
				tempBlock.addClass('left');
				if(item.nameId == 0)//是匿名发布
				{
					var tempName = $("<div class='nameDiv'>"+
						"<span class='name'>"+item.name+"说:</span>"+
					"</div>");
				}
				else
				{
					var tempName = $("<div class='nameDiv'>"+
						"<a class='name' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+item.nameId+"'>"+item.name+":</a>"+
					"</div>");
				}
				tempName.appendTo(tempBlock);
			}
			var tempText = $("<div class='content'>"+
				"<div class='line'>"+item.text+"</div>"+
				"<div class='line'><span class='help-inline' style='color:silver'>"+item.time+"</span></div>"+
			+"</div>");
			tempText.appendTo(tempBlock);
			return tempBlock;
	}
</script>