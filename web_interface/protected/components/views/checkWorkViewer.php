<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		根据checkId获取T_checkWork -> T_work数据,
	*/
?>
<style type="text/css">
#<?php echo $id?> > div.main > div.statusAlert{
	background-color:rgb(245,245,245);
	text-align:center;
}
#<?php echo $id?> > div.main > div.title{
	padding-left:20px;
	font-size:16px;
	font-weight:bold;
	border-left:3px solid rgb(140,0,0);
	margin-bottom:10px;
}
#<?php echo $id?> > div.main > div.block{
		border:1px solid silver;
		border-radius:5px;
		padding:20px;
		margin:0px 15px 25px 15px;
		background-color:rgb(250,250,250);
}
#<?php echo $id?> > div.main > div.block > div.line{
	padding:5px 0;
		height:auto!important;
		height:30px;
		min-height:30px;
}
#<?php echo $id?> > div.main > div.block > div.line > div.left{
		width:100px;
		float:left;
}
#<?php echo $id?> > div.main > div.block > div.line > div.right{
		margin:0 0 0 100px;
}
#<?php echo $id?> > div.main > div.block > div.line > div.right > div.imgPreview{
		/*width:200px;*/
		padding:10px;
}
#<?php echo $id?> > div.main > div.block > div.title > div.right{
		margin:5px 0;
		border-left:3px blue solid;
		padding-left:10px;
		font-weight:bold;
}
#<?php echo $id?> > div.main > div.block > div.subTitle > div.right{
		margin:0;
		color:blue;
}
</style>
<div id="<?php echo $id?>">
	<input class="checkId" type="hidden"></input>
	<div class="main">
		<div class="statusAlert">载入中...</div>
		<div class="title">报名表</div>
		<div class="baomingbiao block">
    					<?php $this->widget("TablrWidget",array(
    						"param" => array(
    							array(
									"name" => "school",
    								"title" => "学校",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "workTitle",
    								"title" => "作品名称",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "workTypeName",
    								"title" => "作品类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "title",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者信息"
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者一"
    							),
    							array(
    								"name" => "author1Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author1HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author1SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者二"
    							),
    							array(
    								"name" => "author2Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author2HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author2SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者三"
    							),
    							array(
    								"name" => "author3Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author3HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author3SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者四"
    							),
    							array(
    								"name" => "author4Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author4HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author4SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "subTitle",
    								"title" => "",
    								"type" => "text",
    								"text" => "作者五"
    							),
    							array(
    								"name" => "author5Name",
    								"title" => "姓名",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5TypeName",
    								"title" => "院系类别",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Major",
    								"title" => "专业",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Grade",
    								"title" => "年级",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5Email",
    								"title" => "电邮",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5PhoneNum",
    								"title" => "电话",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5IDNum",
    								"title" => "身份证",
    								"type" => "text",
    								"text" => "",
    							),
    							array(
    								"name" => "author5HeadImgAddr",
    								"title" => "大头照",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    								"name" => "author5SCardImgAddr",
    								"title" => "学生证照片",
    								"type" => "img",
    								"hideUpload" => true,
    							),
    							array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师一信息"
    								),
    								array(
	    								"name" => "techTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "techTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "指导老师二信息"
    								),
    								array(
	    								"name" => "artTeacherName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherUnit",
    									"title" => "单位",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "artTeacherEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "title",
	    								"title" => "",
    									"type" => "text",
    									"text" => "单位联系人信息"
    								),
    								array(
	    								"name" => "unitContactName",
    									"title" => "姓名",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactJob",
    									"title" => "职务",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPhoneNum",
    									"title" => "电话",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactEmail",
    									"title" => "电邮",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactPost",
    									"title" => "邮编",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
	    								"name" => "unitContactAddr",
    									"title" => "地址",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "shareAgreement",
    									"title" => "共享协议",
    									"type" => "text",
    									"text" => "作者同意大赛组委会将该作品列入集锦出版发行。",
    								),
    								array(
    									"name" => "schoolRec",
    									"title" => "学校推荐意见",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "workIntro",
    									"title" => "作品简介",
    									"type" => "text",
    									"text" => "",
    								),
    								array(
    									"name" => "baomingImgAddr",
    									"title" => "报名表盖章",
    									"type" => "img",
    									"hideUpload" => true,
    								),
    								array(
    									"name" => "banquanImgAddr",
    									"title" => "版权声明",
    									"type" => "img",
    									"hideUpload" => true,
    								),
    						),
    					));?>
    	</div>
    	<div class="title">作品说明</div>
    	<div class="shuoming block">
    		<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
    										"name" => "workInstallNote",
    										"title" => "作品安装说明",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workPreview",
    										"title" => "作品效果图",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDesignNote",
    										"title" => "作品思路",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "workDifficulties",
    										"title" => "设计重点难点",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "teacherComment",
    										"title" => "指导老师自评",
    										"type" => "text",
    										"text" => "",
    									),
    									array(
    										"name" => "otherNote",
    										"title" => "其他说明",
    										"type" => "text",
    										"text" => "",
    									),
    						),
    					));?>
    	</div>
    	<div class="title">作品查阅链接填写(对象：所有参赛作品)</div>
    	<div class="chayue block">
    		<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
    										"name" => "workPreviewAddr1",
    										"title" => "参赛文件夹访问网址",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    									array(
    										"name" => "workPreviewAddr2",
    										"title" => "作品文件包",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    									array(
    										"name" => "workPreviewAddr3",
    										"title" => "素材、源码包",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    									array(
    										"name" => "workPreviewAddr4",
    										"title" => "答辩辅助文件",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    									array(
    										"name" => "workPreviewAddr5",
    										"title" => "作品演示视频",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    						),
    					));?>
    	</div>
		<div class="title">作品部署及网址填写(对象：网站设计和数据库应用类作品)</div>
    	<div class="bushu block">
    		<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
    										"name" => "deployAddr1",
    										"title" => "部署链接一",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    									array(
    										"name" => "deployAddr2",
    										"title" => "部署链接二",
    										"type" => "a",
    										"text" => "",
    										"href" => "",
    									),
    						),
    					));?>
    	</div>
		
		<div class="title">汇款凭证</div>
    	<div class="huikuan block">
    		<?php $this->widget("TablrWidget",array(
    						"param" => array(
    									array(
										"name" => "transferImgAddr",
										"title" => "汇款凭证",
										"type" => "img",
										"hideUpload" => true,
									),
    						),
    					));?>
    	</div>
	</div>
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
//input.checkId change事件就去获取信息，显示"载入中..."
$(document).delegate("#<?php echo $id;?> > input.checkId","change",function(){
	//alert("s");
	getWorkInfo();
});
function getWorkInfo()
{
	var checkId = $("#<?php echo $id;?> > input.checkId").val();
	<?php echo $id;?>showLoading();
	$.post("<?php echo Yii::app()->baseUrl;?>/index.php/work/get","checkId="+checkId,function(result){
		//alert(result);
		for(var name in result)
			{
				//alert(name);
				//直接填入此div.block下的所有字段 
				//本字段有图片展示
				if($("#<?php echo $id;?> > div.main > div.block > div."+name+" > div.right > div.imgPreview").length != 0)
				{
					//alert(name);
					if(result[name] != null)
					{
						//该图片值非null
						$("#<?php echo $id;?> > div.main > div.block > div."+name+" > div.right > div.imgPreview > img").prop("src",result[name]);
					}
				}
				//本字段有链接展示
				else if($("#<?php echo $id;?> > div.main > div.block > div."+name+" > div.right > a").length != 0)
				{
					if(result[name] != null)
					{
						//该图片值非null
						$("#<?php echo $id;?> > div.main > div.block > div."+name+" > div.right > a").prop("href",result[name]).html(result[name]);
					}
				}
				else
				{
					$("#<?php echo $id;?> > div.main > div.block > div."+name).children("div.right").html(result[name]);
				}
				//div.uploadBaomingbiao
				//有了上面语句，下面可以不要
				//未上传盖章
				/*
				if((name == "baomingImgAddr") && (result[name] == null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.gaizhang > div.right > input.gaizhang").val("");
					$("#<?php echo $id;?> > div.main > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "baomingImgAddr") && (result[name] != null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.gaizhang > div.right > input.gaizhang").val(result[name]);
					$("#<?php echo $id;?> > div.main > div.block > div.gaizhang > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				//div.uploadBanquan
				//未上传版权声明
				if((name == "banquanImgAddr") && (result[name] == null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.banquan > div.right > input.banquan").val("");
					$("#<?php echo $id;?> > div.main > div.block > div.banquan > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "banquanImgAddr") && (result[name] != null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.banquan > div.right > input.banquan").val(result[name]);
					$("#<?php echo $id;?> > div.main > div.block > div.banquan > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				//未上传汇款凭证
				if((name == "transferImgAddr") && (result[name] == null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.transferImgAddr > div.right > input.transferImgAddr").val("");
					$("#<?php echo $id;?> > div.main > div.block > div.transferImgAddr > div.right > div.imgPreview > img").prop("src","");
				}
				else if((name == "transferImgAddr") && (result[name] != null))
				{
					$("#<?php echo $id;?> > div.main > div.block > div.transferImgAddr > div.right > input.transferImgAddr").val(result[name]);
					$("#<?php echo $id;?> > div.main > div.block > div.transferImgAddr > div.right > div.imgPreview > img").prop("src",result[name]);
				}
				*/
			
			}
			$("#<?php echo $id;?> > div.main > div.block > div.workInstallNote > div.right").html(result.workInstallNote);
			$("#<?php echo $id;?> > div.main > div.block > div.workPreview > div.right").html(result.workPreview);
			$("#<?php echo $id;?> > div.main > div.block > div.workDesignNote > div.right").html(result.workDesignNote);
			$("#<?php echo $id;?> > div.main > div.block > div.workDifficulties > div.right").html(result.workDifficulties);
			$("#<?php echo $id;?> > div.main > div.block > div.teacherComment > div.right").html(result.teacherComment);
			$("#<?php echo $id;?> > div.main > div.block > div.otherNote > div.right").html(result.otherNote);
		<?php echo $id;?>hideLoading();
	},"json");
}
function <?php echo $id;?>showLoading()
{
	$("#<?php echo $id?> > div.main > div.statusAlert").html("载入中...");
}
function <?php echo $id;?>hideLoading()
{
	$("#<?php echo $id?> > div.main > div.statusAlert").html("");
}
</script>