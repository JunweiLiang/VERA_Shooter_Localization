<?php 
	/*********
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	**********/
?>
<style type='text/css'>
	#<?php echo $id;?>{width:<?php echo $width;?>;}
	#<?php echo $id;?> > div.userListDiv > div.flBlock{
		background-color:rgb(245,245,245);border:0 solid #F5D8DB;border-width: 0 1px 1px 0;
		/*border-left:red solid 3px;*/
		padding:10px;
	}
	#<?php echo $id;?> > div.userListDiv > div.flBlock > div.flLine{padding-bottom:3px}
	#<?php echo $id;?> > div.userListDiv > div.flBlock > div.flLine > a.userName{font-size:15px}
	#<?php echo $id;?> > div.userListDiv > div.flBlock > div.flLine > span.userIntro{color:gray;font-size:13px}
	#<?php echo $id;?> > div.userListDiv > div.flBlock > div.flLine > span.cmInfo{font-size:13px;}
</style>

<div id="<?php echo $id;?>">
	<div class='userListDiv'>
		<div class='wrapLoading'><div class='loading'></div></div>
	</div>
</div>
<script type='text/javascript'>
	<?php if($instantLoad){ ?>
	$(document).ready(function(){
		getFriendsList();
	});
	<?php } ?>
function getFriendsList()
{
	var data = {};
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/getFriendsList",data,function(result){
		//alert(result);
		$("#<?php echo $id;?> > div.userListDiv").html("");
		$.each(result,function(index,item){
			var tempDiv = $("<div class='flBlock'>"+
				"<div class='flLine'>"+
					"<a class='userName' href='<?php echo Yii::app()->baseUrl;?>/index.php/clubSite/personalPage?id="+item.userId+"'>"+item.userName+"</a> "+
					"<span class='space'></span> "+
					"<span class='userIntro'>"+item.intro+"</span>"+
				"</div>"+
			"</div>");
			if(item.isCM != 0)
			{
				var cmStr = '';
				$.each(item.cmArr,function(index,item){
					cmStr+=(item+" ");
				});
				var tempLine = $("<div class='flLine'><span class='cmInfo'>管理栏目: "+cmStr+"</span></div>");
				tempLine.appendTo(tempDiv);
			}
			tempDiv.appendTo("#<?php echo $id;?> > div.userListDiv");
		});
	},'json');
}
</script>