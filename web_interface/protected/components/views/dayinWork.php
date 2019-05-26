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
#dayinWork{
	margin:0 auto;width:980px;
}
#dayinWork > div.title{
	text-align:center;
	font-size:15px;
	font-weight:bold;
}
td{
word-break:break-all; word-wrap:break-word;
}
</style>
<div id="dayinWork">
<!--<div class="title">作品浏览</div>-->
<table border="0px" cellpadding="25px" cellspacing="0px" width="<?php echo $width?>" align="center" style="page-break-after:always">
	<tbody>
	<tr>
		<td align="center"><b><font size="5">2014年第7届中国大学生计算机设计大赛报名表</font></b></td>
	</tr>
	<tr>
		<td width="100%">
			<table border="1px" cellpadding="5px" cellspacing="1" width="<?php echo $width;?>" align="center" bgcolor="#000000">
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
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电邮</td>
					<td><?php echo $param['author1Email'];?></td>
					<td><?php echo $param['author2Email'];?></td>
					<td><?php echo $param['author3Email'];?></td>
					<td><?php echo $param['author4Email'];?></td>
					<td><?php echo $param['author5Email'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电话</td>
					<td><?php echo $param['author1PhoneNum'];?></td>
					<td><?php echo $param['author2PhoneNum'];?></td>
					<td><?php echo $param['author3PhoneNum'];?></td>
					<td><?php echo $param['author4PhoneNum'];?></td>
					<td><?php echo $param['author5PhoneNum'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td rowspan="5" width="23" align="center">指导老师一</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">姓名</td>
					<td colspan="5"><?php echo $param['techTeacherName'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">单位</td>
					<td colspan="5"><?php echo $param['techTeacherUnit'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电话</td>
					<td colspan="5"><?php echo $param['techTeacherPhoneNum'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电邮</td>
					<td colspan="5"><?php echo $param['techTeacherEmail'];?></td>
				</tr>
				<?php
					if(!empty($param['artTeacherName']) ||
					!empty($param['artTeacherUnit']) ||
					!empty($param['artTeacherPhoneNum']) ||
					!empty($param['artTeacherEmail'])
					)
					{
				?>
				<tr bgcolor="#ffffff">
					<td rowspan="5" width="23" align="center">指导老师二</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">姓名</td>
					<td colspan="5"><?php echo $param['artTeacherName'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">单位</td>
					<td colspan="5"><?php echo $param['artTeacherUnit'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电话</td>
					<td colspan="5"><?php echo $param['artTeacherPhoneNum'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电邮</td>
					<td colspan="5"><?php echo $param['artTeacherEmail'];?></td>
				</tr>
				<?php } ?>
				<tr bgcolor="#ffffff">
					<td rowspan="7" width="23" align="center">单位联系人</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">姓名</td>
					<td colspan="5"><?php echo $param['unitContactName'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">职务</td>
					<td colspan="5"><?php echo $param['unitContactJob'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电话</td>
					<td colspan="5"><?php echo $param['unitContactPhoneNum'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">电邮</td>
					<td colspan="5"><?php echo $param['unitContactEmail'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">邮编</td>
					<td colspan="5"><?php echo $param['unitContactPost'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="53" align="center">地址</td>
					<td colspan="5"><?php echo $param['unitContactAddr'];?></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="100" align="center">共享协议</td>
					<td colspan="6">作者同意大赛组委会将该作品列入集锦出版发行。</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="100" align="center">学校推荐意见</td>
					<td colspan="6"><?php echo $param['schoolRec']?>
						<br/>
						<br/>
						<div style="text-align:right;padding:30px;">（学校公章或校教务处章）&nbsp;&nbsp;&nbsp;2014年 &nbsp;&nbsp;月 &nbsp;&nbsp;日</div>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="100" align="center">原创声明</td>
					<td colspan="6">我（们）声明我们的参赛作品为我（们）原创构思和使用正版软件制作，我们对参赛作品拥有完整、合法的著作权或其它相关之权利，绝无侵害他人著作权、商标权、专利权等知识产权或违反法令或其它侵害他人合法权益的情况。若因此导致任何法律纠纷，一切责任应由我们自行承担。
<br/>作者签名：1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;           
</td>
				</tr>
				<?php } ?>
				
				
				</tbody>
			</table>
		</td>
	</tr>

</tbody>
</table>
<style type="text/css">
	div.ntitle{
		padding:30px;text-align:center;
		font-weight:bold;
		font-size:30px;
		line-height:50px;
	}
	div.para{
		font-size:20px;
		padding:40px;
	}
	div.sign{
		text-align:right;
		padding:200px;
		padding-right:200px;
		padding-bottom:50px;
		font-weight:bold;
	}
	div.date{
		text-align:right;
	}
</style>
	<div class="ntitle">版权声明</div>
	<div class="para">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;《<?php echo $param['workTitle'];?>》为本人在“2014年（第7届）中国大学生计算机设计大赛”的参赛作品，本人同意中国大学生计算机设计大赛组委会将上述作品及本人撰写的相关说明文字收录到中国大学生计算机设计大赛组委会编写的《中国大学生计算机设计大赛2015年参赛指南》（暂定名）或其他相关作品中，以纸介质出版物,电子出版物或网络出版物的形式予以出版。</div>
	<div class="sign">全体作者签名</div>
	<div class="date">2014年 &nbsp;&nbsp;月 &nbsp;&nbsp;日</div>
</div><!--#dayinWork-->
	
<?php if($hasHead){ ?>
</body>
</html>
<?php } ?>