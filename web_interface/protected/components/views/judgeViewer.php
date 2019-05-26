<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<style type='text/css'>
	#<?php echo $id;?>{
		padding:20px;
	}
	#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-body > div.line{padding:10px;line-height:30px}
	#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-body > div.line > div.left{line-height:30px;float:left;width:80px;text-align:right;}
	#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-body > div.line > div.right{line-height:30px;margin:0 0 0 100px;}
	#<?php echo $id;?> input,#<?php echo $id;?> textarea{font-size:12px}
	#<?php echo $id;?> > div.head{padding:10px 0}
	#<?php echo $id;?> > div.head > div.headTitle{float:left;width:80px;font-size:14px;color:black;font-weight:bold}
	#<?php echo $id;?> > div.head > div.right{margin:0 0 0 80px;position:relative}
	#<?php echo $id;?> > div.head > div.right > div.divider{height:1px;
		border-bottom:1px solid rgb(230,230,230);padding-top:9px;margin-bottom:10px
	}
	#<?php echo $id;?> > div.head > div.right > div.floatButton{position:absolute;top:-3px;right:0}
	
	#<?php echo $id;?> > div.block{padding-top:10px}
	#<?php echo $id;?> > div.block > form > div.line{
		padding-bottom:10px;
		line-height:30px;
		height:auto!important;
		height:30px;
		min-height:30px;
	}
	/*擅长领域使用overflow*/
	#<?php echo $id?> > div.editDiv > form > div.goodAtArr > div.right{
		height:200px;
		overflow:auto;
	}
	#<?php echo $id;?> > div.block > form > div.line > div.left{
		float:left;font-size:12px;
		width:100px;text-align:right;padding-right:10px;color:gray;
	}
	#<?php echo $id;?> > div.block > form > div.line > div.right > a.editPw{text-decoration:none}
	#<?php echo $id;?> > div.block > form > div.line > div.right{
		margin:0 0 0 110px;color:black;
		font-size:12px;
	}
	#<?php echo $id?>{
		position:relative;
	}
	#<?php echo $id?> > div.jLoading{
		padding:150px 0;
		height:200px;
		width:100%;
		background-color:silver;
		opacity:0.7;/*Opera9.0+、Firefox1.5+、Safari、Chrome*/
		filter:alpha(opacity=70);   /*IE5、IE5.5、IE6、IE7*/
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; /*IE8*/
		position:absolute;top:0;left:0;
		z-index:990;	
	}
</style>
<script type='text/javascript'>
<?php if($hasEditComp){ ?>
	//定义编辑按钮动作
	$(document).delegate('#<?php echo $id;?> > div.head > div.right > div.floatButton > div.btn','click',function(){
	if(!$(this).hasClass('disabled'))
	{
		if($(this).hasClass('edit'))
		{
			//转换为保存按钮
			//把所有字段中的值，转存到editDiv中
			$(this).html('保存')
				.removeClass('edit');			
			$("#<?php echo $id;?> > div.profileDiv").hide();
			$("#<?php echo $id;?> > div.editDiv").show();			
		}
		else//保存修改
		{
			
			var data = $("#<?php echo $id;?> > div.editDiv > form").serialize();
			if(data == "")//没有profile的时候
			{
				return ;
			}
			data+="&userId=<?php echo Yii::app()->session['userId'];?>";
			//alert(data);
			//提交保存，显示正在保存中
			$(this).addClass('disabled')
				.html("保存中...");
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/changeProfile",data,function(result){
				//alert(result);
				//隐藏输入div,直接重新载入
				$('#<?php echo $id;?> > div.head > div.right > div.floatButton > div.btn').removeClass("disabled")
					.html("编辑")
					.addClass("edit");
				$("#<?php echo $id;?> > div.profileDiv").show();
				$("#<?php echo $id;?> > div.editDiv").hide();
				$("#<?php echo $id?> > input.judgeId").change();
			});
		}
	}
	});
	//************************************************************************************以下是密码动作
	//定义修改密码框
	$(document).delegate('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > button.changePw','click',function(){
		//先检查是否为空
		//alert('hi');
		var empty = false;
		$('#<?php echo $id;?> #<?php echo $id;?>editPwModal input:password').each(function(){
			if($(this).val() == '')
			{
				empty = true;
				return false;
			}
		});
		if(empty)
		{
			$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("不能留空！");
			setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
			return;
		}
		if($('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw').val() != $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw2').val())
		{
			$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("新密码不一致！");
			setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
			return;
		}
		var data = {};
		data.oldPw = $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #oldPw').val();
		data.newPw = $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw').val();
		data.userId = <?php echo Yii::app()->session['userId'];?>;
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/changePw",data,function(result){
			//alert(result);
			if(result == 'error')
			{
				$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("原密码不正确！");
				setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
				return;
			}
			else
			{
				$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("密码修改成功！");
				setTimeout(function(){
					$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");
					$('#<?php echo $id;?> #<?php echo $id;?>editPwModal').modal('hide');
				},500);
			}
		});
	});
	//便民措施:修改密码框打开时要获取焦点
	$(document).delegate('#<?php echo $id;?> #<?php echo $id;?>editPwModal','shown',function(){
		$(this).find('input:password').eq(0).focus();
	});
	//修改密码框关闭时要清空
	$(document).delegate('#<?php echo $id;?> #<?php echo $id;?>editPwModal','hidden',function(){
		$(this).find('input:password').val("");
	});
	//绑定确认键
	$(document).keypress(function(e){
				var e = e||event;
				var keycode = e.which || e.keyCode;					
				if(keycode == 13)
				{
					e.preventDefault();
					if($('#<?php echo $id;?> #<?php echo $id;?>editPwModal').css('display') != 'none')
					{
							$('#<?php echo $id;?> #<?php echo $id;?>editPwModal button.changePw').click();
					}
				}
	});
<?php } ?>
//绑定judgeId change事件
$(document).delegate("#<?php echo $id?> > input.judgeId","change",function(){
	var data = {};
	//alert("a");
	data.judgeId = $(this).val();
	<?php echo $id?>showLoading();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/judge/get",data,function(result){
		//alert(result);
		//result.sex == 1?result.sex="男":result.sex="女";
		var goodAtStr = "";
		//取消所有checkbox
		$("#<?php echo $id;?> > div.editDiv > form > div.goodAtArr > div.right > input.checkbox").prop("checked",false);
		$.each(result.goodAtArr,function(index,item){
			//alert(index);
			goodAtStr+=item.typeName+"-"+item.subTypeName+" <br/>";
			//选择editDiv中			
			$("#<?php echo $id;?> > div.editDiv > form > div.goodAtArr > div.right > input:checkbox[value='"+item.subTypeId+"']").prop("checked",true);
		});
		$("#<?php echo $id;?> > div.profileDiv > form > div.goodAtArr > div.right").html(goodAtStr);
		//登录名字特殊处理
		//alert(result.userName);
		$("#<?php echo $id;?> > div.block > form > div.line > div.right > span.userName").html(result.userName);
		for(var key in result)
		{
			if((key != "isProved") && (key != "goodAtArr"))
			{
				$("#<?php echo $id;?> > div.profileDiv > form > div."+key+" > div.right").html(result[key]);
				if(key == "sex")
				{
					
					$("#<?php echo $id;?> > div.profileDiv > form > div.sex > div.right").html(result.sex == 1?"男":"女");
				}
				<?php if($hasEditComp){ ?>
					//保存到编辑框中
					$("#<?php echo $id;?> > div.editDiv > form > div."+key+" > div.right > input").val(result[key]);
					if(key == "sex")
					{
						$("#<?php echo $id;?> > div.editDiv > form > div.sex > div.right > select > option[value='"+result[key]+"']").prop("selected",true);
					}
				<?php }else{ ?>
					//评委级别
					if(key == "rank")
					{
						var str = result[key] == 1?"校级":item[key]==2?"省级":"国家级";
						$("#<?php echo $id;?> > div.profileDiv > form > div.rank > div.right").html(str);
					}
				<?php } ?>
			}
		}
		<?php echo $id?>hideLoading();
	},'json');
});
<?php if($instantLoad){ ?>
$(document).ready(function(){
	$("#<?php echo $id;?> > input.judgeId").change();
});
<?php } ?>
function <?php echo $id?>showLoading()
{
	$("#<?php echo $id?> > div.jLoading").show();
}
function <?php echo $id?>hideLoading()
{
	$("#<?php echo $id?> > div.jLoading").hide();
}
</script>
<div id='<?php echo $id;?>'>
	<div class="jLoading" style="display:none">
		<div class="wrapLoading">
			<div class="loading"></div>
		</div>
	</div>
	<input class="judgeId" type="hidden" value="<?php echo $initialId;?>"></input>
	<?php if($hasEditComp){ ?>
	<div class="modal hide fade" id="<?php echo $id;?>editPwModal" style="width:500px;margin-left:-250px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>修改密码</h3>
		</div>
		<div class='modal-body'>
			<div class='line'>
				<div class='left'>原密码</div><div class='right'><input class='input-medium' type='password' id='oldPw'></input></div>
			</div>
			<div class='line'>
				<div class='left'>新密码</div><div class='right'><input class='input-medium' type='password' id='newPw'></input></div>
			</div>
			<div class='line'>
				<div class='left'>确认输入</div><div class='right'><input class='input-medium' type='password' id='newPw2'></input></div>
			</div>
		</div>
		<div class="modal-footer">
			<span class='help-inline' style='color:orange' id='changePwE'></span>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
   		 	<button class="btn btn-primary changePw">确定修改</button>   	
		</div>
	</div>
	<?php } ?>
	<div class='head'>
		<div class='headTitle'>基本信息</div>
		<div class='right'>
			<div class='divider'></div>
			<?php if($hasEditComp){ ?>
			<div class='floatButton'>
				<div class='btn btn-small edit'>编辑</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class='block profileDiv'>
		<form id="prof">
		<?php if($hasEditComp){ ?>
		<div class='line'>
			<div class='left'>登陆名</div><div class='right'><span class="userName"></span> &nbsp;&nbsp;<a href='#' data-toggle="modal" data-target="#<?php echo $id;?>editPwModal" class='editPw'>修改密码</a></div>
		</div>
		<?php }else{ ?>
		<div class='line'>
			<div class='left'>登陆名</div><div class='right'><span class="userName"></span></div>
		</div>
		<div class="line rank">
			<div class="left">评委级别</div>
			<div class="right">
				
			</div>
		</div>
		<?php } ?>
			<?php  $this->widget("TablrWidget",array(
			"param" => array(
				array(
					"name" => "realName",
					"title" => "真实姓名",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "sex",
					"title" => "性别",
					"type" => "text",
					"text" => ""
				),
				
				array(
					"name" => "school",
					"title" => "学校",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "major",
					"title" => "专业",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "goodAtArr",
					"title" => "擅长领域",
					"type" => "text",
					"text" => "",
				),
				
				array(
					"name" => "otherSpecialfield",
					"title" => "其他擅长领域",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "address",
					"title" => "住址",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "phoneNum",
					"title" => "电话号码",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "email",
					"title" => "电子邮件",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "cellPhoneNum",
					"title" => "手机",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "IDNum",
					"title" => "身份证号",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "jobName",
					"title" => "职称",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "job",
					"title" => "职务",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bornYear",
					"title" => "出生年份",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bankName",
					"title" => "开户银行",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "bankAccount",
					"title" => "银行账号",
					"type" => "text",
					"text" => "",
				),
				array(
					"name" => "note",
					"title" => "备注",
					"type" => "text",
					"text" => "",
				),
			),
			));
		 ?>
		</form>
	</div>
	<div class="block editDiv" style="display:none">
		
		<form id="profile">
			<?php if($hasEditComp){ ?>
			<div class='line'>
				<div class='left'>登陆名</div><div class='right'><span class="userName"></span> &nbsp;&nbsp;<a href='#' data-toggle="modal" data-target="#<?php echo $id;?>editPwModal" class='editPw'>修改密码</a></div>
			</div>
			<?php }else{ ?>
			<div class='line'>
				<div class='left'>登陆名</div><div class='right'><span class="userName"></span></div>
			</div>
			<?php } ?>
			<?php  $this->widget("TablrWidget",array(
			"param" => array(
				array(
					"name" => "realName",
					"title" => "真实姓名",
				),
				array(
					"name" => "sex",
					"title" => "性别",
					"type" => "select",
					"param" => array(						
						array("value"=>2,"title"=>"女"),
						array("value"=>1,"title"=>"男"),
					),
				),
				
				array(
					"name" => "school",
					"title" => "学校",

				),
				array(
					"name" => "major",
					"title" => "专业",
				),
				/*array(
					"name" => "goodAtArr",
					"title" => "擅长领域",
					"type" => "checkbox",
					"param" => $goodAtArr,
				),*/
				)
			)); ?>
			
				<div class="line goodAtArr">
					<div class="left">擅长领域</div>
					<div class="right">
			<?php
				foreach($goodAtArr as $one)
				{
					if($one['check'] == 1)
					{
			?>
					<input class="goodAtArr" name="goodAtArr[]" type="checkbox" value="<?php echo $one['value']?>"></input> <?php echo $one['title']?>
					<?php }else{ ?>
					<span class="type" style="color:blue"><?php echo $one['title']?></span><br/>
					<?php } ?>
			<?php } ?>
					</div>
				</div>
			
			<?php  $this->widget("TablrWidget",array(
			"param" => array(
				array(
					"name" => "otherSpecialfield",
					"title" => "其他擅长领域",
				),
				array(
					"name" => "address",
					"title" => "住址",
				),
				array(
					"name" => "phoneNum",
					"title" => "电话号码",
				),
				array(
					"name" => "email",
					"title" => "电子邮件",
				),
				array(
					"name" => "cellPhoneNum",
					"title" => "手机",
				),
				array(
					"name" => "IDNum",
					"title" => "身份证号",
				),
				array(
					"name" => "jobName",
					"title" => "职称",
				),
				array(
					"name" => "job",
					"title" => "职务",
				),
				array(
					"name" => "bornYear",
					"title" => "出生年份",
				),
				array(
					"name" => "bankName",
					"title" => "开户银行",
				),
				array(
					"name" => "bankAccount",
					"title" => "银行账号",
				),
				array(
					"name" => "note",
					"title" => "备注",
					"size" => "large",
				),
			),
			));
		 ?>
		</form>
	</div>
</div>