<?php 
	/*
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*/
?>
<div id="<?php echo $id;?>" style="padding:5px">
	<span style="font-size:14px;">网站默认第一字体:</span>
	<input class="input-medium fontFamily" value="<?php echo $initFontFamily;?>"></input>
	<div class='btn btn-small btn-info save'>保存</div><span class='bodyOptE' style="font-size:12px;color:red">注意不正确的输入可能导致网站出错！</span>
</div>
<script type='text/javascript'>
	$(document).delegate("#<?php echo $id;?> > div.save","click",function(){
		//alert($("#<?php echo $id;?> > input.fontFamily").val());
		if($("#<?php echo $id;?> > div.save").hasClass("disabled"))
		{
			return;
		}
		if($("#<?php echo $id;?> > input.fontFamily").val() == "")
		{
			return;
		}
		var data = {};
		data.fontFamily = $("#<?php echo $id;?> > input.fontFamily").val();
		$("#<?php echo $id;?> > div.save").addClass("disabled");
		$.post("<?php echo $setOptionUrl?>",data,function(result){
			//alert(result);	
			$("#<?php echo $id;?> > div.save").removeClass("disabled");
			if(result == "error")
			{
				$("#<?php echo $id;?> > span.bodyOptE").html("出错了！");
				return;
			}
			$("#<?php echo $id;?> > span.bodyOptE").html("修改成功！");
			setTimeout(function(){
				$("#<?php echo $id;?> > span.bodyOptE").html("注意不正确的输入可能导致网站出错！");
			},3000);
		});
	});
</script>