<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8
	*******************/
?>
<style type='text/css'>
	#<?php echo $id;?>{}
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
	
	#<?php echo $id;?> > div.profileDiv{padding-top:10px}
	#<?php echo $id;?> > div.profileDiv > form > div.line{padding-bottom:10px;line-height:30px;height:30px}
	#<?php echo $id;?> > div.profileDiv > form > div.line > div.left{
		float:left;font-size:12px;
		width:60px;text-align:right;padding-right:10px;color:gray;
	}
	#<?php echo $id;?> > div.profileDiv > form > div.line > div.right > a.editPw{text-decoration:none}
	#<?php echo $id;?> > div.profileDiv > form > div.line > div.right{
		margin:0 0 0 80px;color:black;
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
			$(this).html('Save');
			$(this).removeClass('edit');
			//转换信息为输入框
			<?php if($isCompetitor){ ?>
			//第一个line一定是登录名
			$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.right:gt(0)').each(function(){
				//alert($(this).parent().attr("name"));//prop("name")返回undefined
				if(($(this).parent().attr("name") != "location") && ($(this).parent().attr("name") != "catalog") && ($(this).parent().attr("name") != "schoolType"))//过滤掉省份,赛区,学校类型
				{
					$(this).html('<input class="input-medium" type="text" name="'+$(this).parent().attr("name")+'" value='+$(this).html()+'></input>');
				}
			});
			//alert($("#<?php echo $id;?> > div.profileDiv > form > div.line[name='location']").html());//ok
			
			<?php } ?>
			
			<?php if($showNickName){ ?>
			$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.nickName').html('<input type="text" class="input-medium" name="nickName" value='+
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.nickName').html()+
			'></input>');
			<?php } ?>
			<?php if($showIntro){ ?>
			$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro').html('<textarea rows="2" name="intro" style="width:150px;padding:2px" value='+
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro').html()+
			'>'+$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro').html()+'</textarea>');
			<?php } ?>
			<?php if($isManager){ ?>
			$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.name').html('<input type="text" class="input-medium" name="name" value='+
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.name').html()+
			'></input>');
			$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.email').html('<input type="text" class="input-medium" name="email" value='+
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.email').html()+
			'></input>');
			<?php } ?>
		}
		else
		{
			
		//	var data = {};
		//	data.userId = <?php echo $userId;?>;
		//	data.nickName = $('#<?php echo $id;?> > div.profileDiv > form > div.line > div.nickName > input').val();
		//	data.intro = $('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro > textarea').val();
			var data = $("#<?php echo $id;?> > div.profileDiv > form").serialize();
			if(data == "")//没有profile的时候
			{
				return ;
			}
			data+="&userId=<?php echo $userId;?>";
		//	alert(data);
			//提交保存，显示正在保存中
			$(this).addClass('disabled');
			$(this).html("Saving...");
			<?php echo $id?>showLoading();
			$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/changeProfile",data,function(result){
				//alert(result);
				if(result == 'error')
				{
					alert('Oops!');
					return;
				}
				//切换输入框
				<?php if($isCompetitor){ ?>
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.right:gt(0)').each(function(){
					//alert($(this).parent().attr("name"));//prop("name")返回undefined
					if(($(this).parent().attr("name") != "location") && ($(this).parent().attr("name") != "catalog") && ($(this).parent().attr("name") != "schoolType"))//过滤掉省份,赛区,学校类型
					{
						$(this).html($(this).children("input").val());
					}
				});
				<?php } ?>
				<?php if($showNickName){ ?>
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.nickName').html($('#<?php echo $id;?> > div.profileDiv > form > div.line > div.nickName > input').val());
				<?php } ?>
				<?php if($showIntro){ ?>
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro').html($('#<?php echo $id;?> > div.profileDiv > form > div.line > div.intro > textarea').val());
				<?php } ?>
				<?php if($isManager){ ?>
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.name').html($('#<?php echo $id;?> > div.profileDiv > form > div.line > div.name > input').val());				
				$('#<?php echo $id;?> > div.profileDiv > form > div.line > div.email').html($('#<?php echo $id;?> > div.profileDiv > form > div.line > div.email > input').val());
				<?php } ?>
				//更改按钮
				$('#<?php echo $id;?> > div.head > div.right > div.floatButton > div.btn').html("Edit")
					.removeClass('disabled')
					.addClass("edit");
				<?php echo $id?>hideLoading();
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
			$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("No Empty！");
			setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
			return;
		}
		if($('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw').val() != $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw2').val())
		{
			$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("Two password differ！");
			setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
			return;
		}
		var data = {};
		data.oldPw = $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #oldPw').val();
		data.newPw = $('#<?php echo $id;?> #<?php echo $id;?>editPwModal #newPw').val();
		data.userId = <?php echo $userId;?>;
		$.post("<?php echo Yii::app()->baseUrl;?>/index.php/user/changePw",data,function(result){
			//alert(result);
			if(result == 'error')
			{
				$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("Password wrong!");
				setTimeout(function(){$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("");},3000);
				return;
			}
			else
			{
				$('#<?php echo $id;?> #<?php echo $id;?>editPwModal > div.modal-footer > #changePwE').html("Success！");
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
	<?php if($hasEditComp){ ?>
	<div class="modal hide fade" id="<?php echo $id;?>editPwModal" style="width:500px;margin-left:-250px"><!--to set the modal in the center,margin-left should be (-)half its width-->
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>Change Password</h3>
		</div>
		<div class='modal-body'>
			<div class='line'>
				<div class='left'>Old Password</div><div class='right'><input class='input-medium' type='password' id='oldPw'></input></div>
			</div>
			<div class='line'>
				<div class='left'>New Password</div><div class='right'><input class='input-medium' type='password' id='newPw'></input></div>
			</div>
			<div class='line'>
				<div class='left'>Confirm New Password</div><div class='right'><input class='input-medium' type='password' id='newPw2'></input></div>
			</div>
		</div>
		<div class="modal-footer">
			<span class='help-inline' style='color:orange' id='changePwE'></span>
    		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
   		 	<button class="btn btn-primary changePw">Confirm</button>   	
		</div>
	</div>
	<?php } ?>
	<div class='head'>
		<div class='headTitle'>Basic Info</div>
		<div class='right'>
			<div class='divider'></div>
			<?php if($hasEditComp){ ?>
			<div class='floatButton'>
				<div class='btn btn-small edit'>Edit</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class='profileDiv'>
		<form id="prof">
		<?php if($hasEditComp){ ?>
		<div class='line'>
			<div class='left'>Username</div><div class='right'><?php echo $userName;?> &nbsp;&nbsp;<a href='#' data-toggle="modal" data-target="#<?php echo $id;?>editPwModal" class='editPw'>Edit Password</a></div>
		</div>
		<?php } ?>
		<?php if($showNickName){ ?>
		<div class='line'>
			<div class='left'>Nickname</div><div class='right nickName'><?php echo $userNickName;?></div>
		</div>
		<?php } ?>
		<?php if($showIntro){ ?>
		<div class='line'>
			<div class='left'>Intro</div><div class='right intro'><?php echo $userIntro;?></div>
		</div>
		<?php } ?>
		<?php if($isManager){ ?>
		<div class='line'>
			<div class='left'>Name</div><div class='right name'><?php echo $specific['name'];?></div>
		</div>
		<div class='line'>
			<div class='left'>email</div><div class='right email'><?php echo $specific['email'];?></div>
		</div>
		<?php } ?>
		
		</form>
	</div>
</div>