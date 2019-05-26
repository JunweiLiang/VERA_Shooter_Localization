<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	if($hasHead){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<title>2014年第7届中国大学生计算机设计大赛报名表</title>
</head>
<body>
<?php } ?>
<style type="text/css">
#viewWork{
	margin:0 auto;width:980px;
}
#viewWork > div.title{
	text-align:center;
	font-size:15px;
	font-weight:bold;
}
td{
word-break:break-all; word-wrap:break-word;
}
</style>
<div id="viewWork">
<!--<div class="title">作品浏览</div>-->
<table border="0px" cellpadding="5px" cellspacing="0px" width="<?php echo $width?>" align="center">
	<tbody>
	<tr>
		<td align="center"><b><font size="4">2014年第7届中国大学生计算机设计大赛报名表</font></b></td>
	</tr>
	<tr>
		<td width="100%">
			<table border="0px" cellpadding="5px" cellspacing="1" width="<?php echo $width;?>" align="center" bgcolor="#000000">
				<tbody>
				<!--<tr bgcolor="#ffffff">
					<td colspan="2" align="center">作品编号</td>
					<td colspan="5">BGXA1201535</td>
				</tr>-->
				<tr bgcolor="#ffffff">
					<td colspan="2" align="center">作品分类</td>
					<td colspan="2">
						<?php echo $typeArr['typeName'];?> - <?php echo $typeArr['subTypeName'];?>
					</td>
					<td align="center">参加赛场</td>
					<td colspan="2">
						<?php echo $catalogTitle;?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="2" align="center">作品名称</td>
					<td colspan="5"><?php echo $param['workTitle']?></td>
				</tr>
				<?php if($showBaomingbiao){ ?>
				<tr bgcolor="#ffffff">
					<td rowspan="7" width="23" align="center">作者信息</td>
					<td width="53" align="center">学校</td>
					<td colspan="5">
					(<?php echo $location?>)&nbsp;&nbsp;<?php echo $school;?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53">　</td>
					<td align="center">作者一</td>
					<td align="center">作者二</td>
					<td align="center">作者三</td>
					<td align="center">作者四</td>
					<td align="center">作者五</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">姓名</td>
					<td><?php echo $param['author1Name']?></td>
					<td><?php echo $param['author2Name']?></td>
					<td><?php echo $param['author3Name']?></td>
					<td><?php echo $param['author4Name']?></td>
					<td><?php echo $param['author5Name']?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">专业</td>
					<td><?php echo $param['author1Major'];?></td>
					<td><?php echo $param['author2Major'];?></td>
					<td><?php echo $param['author3Major'];?></td>
					<td><?php echo $param['author4Major'];?></td>
					<td><?php echo $param['author5Major'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">年级</td>
					<td><?php echo $param['author1Grade'];?></td>
					<td><?php echo $param['author2Grade'];?></td>
					<td><?php echo $param['author3Grade'];?></td>
					<td><?php echo $param['author4Grade'];?></td>
					<td><?php echo $param['author5Grade'];?></td>
				</tr>
				<!--<tr bgcolor="#ffffff">
					<td colspan="7"><b>原创声明</b><br><br>我（们）声明我们的参赛作品为我（们）原创构思和使用正版软件制作，我们对参赛作品拥有完整,合法的著作权或其他相关之权利，绝无侵害他人著作权,商标权,专利权等知识产权或违反法令或其他侵害他人合法权益的情况。若因此导致任何法律纠纷，一切责任应由我们（作品提交人）自行承担。<br>作者签名：1:&nbsp;&nbsp;&nbsp;&nbsp;2:&nbsp;&nbsp;&nbsp;&nbsp;3:
					</td>
				</tr>-->
				<?php } ?>
				<tr bgcolor="#ffffff">
					<td colspan="7"><b>作品简介</b><br><hr width="25%" align="left"><?php echo $param['workIntro'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7" width="744">
					<b>作品安装说明</b><br><hr width="25%" align="left">
					<?php echo $param['workInstallNote'];?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>作品效果图</b><br><hr width="25%" align="left">
					<?php echo $param['workPreview'];?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7" width="744">
					<b>设计思路</b><br><hr width="25%" align="left">
					<?php echo $param['workDesignNote'];?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>设计重点和难点</b><br><hr width="25%" align="left">
					<?php echo $param['workDifficulties'];?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>指导老师自评</b><br><hr width="25%" align="left">
					<?php echo $param['teacherComment'];?>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>其他说明</b><br><hr width="25%" align="left">
					<?php echo $param['otherNote'];?>
					</td>
				</tr>	
				<?php if($showcybswj){ ?>		
				<?php if($param['workPreviewAddr1']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>参赛文件夹访问网址</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['workPreviewAddr1'];?>" target="_blank"><?php echo $param['workPreviewAddr1'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['workPreviewAddr2']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>作品文件包</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['workPreviewAddr2'];?>" target="_blank"><?php echo $param['workPreviewAddr2'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['workPreviewAddr3']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>素材、源码包</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['workPreviewAddr3'];?>" target="_blank"><?php echo $param['workPreviewAddr3'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['workPreviewAddr4']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>答辩辅助文件</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['workPreviewAddr4'];?>" target="_blank"><?php echo $param['workPreviewAddr4'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['workPreviewAddr5']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>作品演示视频</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['workPreviewAddr5'];?>" target="_blank"><?php echo $param['workPreviewAddr5'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['deployAddr1']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>部署链接1</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['deployAddr1'];?>" target="_blank"><?php echo $param['deployAddr1'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['deployAddr2']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>部署链接2</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['deployAddr2'];?>" target="_blank"><?php echo $param['deployAddr2'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['fileAddr1']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>文件链接1</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['fileAddr1'];?>" target="_blank"><?php echo $param['fileAddr1'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['fileAddr2']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>文件链接2</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['fileAddr2'];?>" target="_blank"><?php echo $param['fileAddr2'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php if($param['fileAddr3']!=NULL){ ?>	
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>文件链接3</b><br><hr width="25%" align="left">
					<a href="<?php echo $param['fileAddr3'];?>" target="_blank"><?php echo $param['fileAddr3'];?></a>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php if($showhk){ ?>			
				<tr bgcolor="#ffffff">
					<td colspan="7">
					<b>汇款凭证</b><br><hr width="25%" align="left">
					<img src="<?php echo $param['transferImgAddr'];?>"></img>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</td>
	</tr>

</tbody>
</table>
</div><!--#viewWork-->
<?php if($hasHead){ ?>
</body>
</html>
<?php } ?>