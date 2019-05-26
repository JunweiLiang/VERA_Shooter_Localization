/*
	包含各种封装与类
*/


/*
	cw类(命名空间)，所有封装函数在这里 
	
		可以用作构造东西
		var sth = cw.create();
			cw = {
				create:function(){
					return {
						name:value
					}
				}
			}
*/
var clickEventType=((document.ontouchstart!==null)?'click':'touchstart');//严格不等于???
$.fn.emptyLater = function(){
	var time = arguments[0]?arguments[0]:10000;
	$(this[0]).delay(time).queue(function(n){
		$(this).html("");
		n();
	});
};
var cw = {
	//绑定event 到document 的方法  
		//ec  event click
	/*手机上touchstart快很多click*/
	/*
	//下面方法拖动时碰到元素会触发
	ec:function(selector,callback){
		$(document).delegate(selector,clickEventType,function(e){
			 e.stopPropagation(); 
			 e.preventDefault();
		});
		$(document).delegate(selector,clickEventType,callback);
	},
	*/
	//calculate AP
	calculateAP:function(data){
		//sort first
		data.sort(function(a,b){
			return b.score - a.score; //desc
		});
		//alert(data.length);
		var rels = 0;
		var rank = 0;
		var score = 0.0;
		for(var i in data)
		{
			rank+=1;
			if(data[i].label == 1)
			{
				rels+=1;
				score+=rels/parseFloat(rank);
			}
		}
		if(rels != 0)
		{
			score/=parseFloat(rels);
		}
		return score;
	},
	
	//需要 jquery mobile tap支持
	ectype:"click",//使用 $().trigger(cw.ectype)触发
	ec:function(selector,callback){
		$(document).delegate(selector,cw.ectype,function(e){
			 e.stopPropagation(); 
			 e.preventDefault(); //beware this will hurt the behavior of input:checkbox
		});
		$(document).delegate(selector,cw.ectype,callback);
	},
	/*
	// tap 出问题时，请切换到这个
	ec:function(selector,callback){
		
		$(document).delegate(selector,"click",callback);
	},
	*/
	
		//ech event change
	ech:function(selector,callback){
		$(document).delegate(selector,"change",callback);
	},
	eck:function(selector,callback){
		$(document).delegate(selector,"click",callback);
	},
	edown:function(selector,callback){
		$(document).delegate(selector,"mousedown",callback);
	},
	eup:function(selector,callback){
		$(document).delegate(selector,"mouseup",callback);
	},
	//对selector的html设置为载入状态
	load:function(selector){
		$(selector).html('<div class="wrapLoading"><div class="loading"></div></div>');
	},
	
	//替换str中的html标签
	replaceHtml:function(str){
		str = str.replace(/</g,"&#60;");
		str = str.replace(/>/g,"&#62;");
		return str;
	},
	
	sec2time:function(secs)
	{
		var sec_num = secs;
	    var hours   = Math.floor(sec_num / 3600);
	    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	    var seconds = sec_num - (hours * 3600) - (minutes * 60);
	    seconds = seconds.toFixed(1);
	    if (hours   < 10) {hours   = "0"+hours;}
	    if (minutes < 10) {minutes = "0"+minutes;}
	    if (seconds < 10) {seconds = "0"+seconds;}
	    var time    = hours+':'+minutes+':'+seconds;
	    return time;
	},
	//数据发送方法，post提交，并且可以设定错误处理方式 
	url:"",//外部可以设定好，那么后面就直接调用,也可以用作前缀 
	post:function(url,data,successCallback){
		var context = arguments[3] ? arguments[3] : null;//上下文,在回调函数中使用$(this)调用 
		var errorCallback = arguments[4] ? arguments[4] : function(){};
		var completeCallback = arguments[5] ? arguments[5] : function(){};
		var dataType = arguments[6] ? arguments[6] : "json";
		$.ajax({
			"type":"POST",
			"context":context,
			"url":url,
			"data":data,
			"dataType":dataType,//全部默认返回json数据  
			"success":successCallback,
			"error":errorCallback,  // function(XHR,erro){alert(erro)}
			"complete":completeCallback
		});
	},
	//提交到新打开的页面，在top下新建一个form, target can be iframe
	postNew:function(url,data,target){
		var top = arguments[3]?arguments[3]:"body";
		var formId = "newPagePost"+Math.random();
		var $form = $('<form id="'+formId+'" style="display:none" target="'+target+'" action="'+url+'" method="post"></form>');
		for(var key in data)
		{
			$form.append('<input class="'+key+'" name="'+key+'" type="hidden" value="'+data[key]+'"></input>');
		}
		$(top).append($form);
		$form.submit();
		$form.remove();
	},
	//提交到本页面 
	postTo:function(url,data,top){
		var formId = "newPagePost"+Math.random();
		var $form = $('<form id="'+formId+'" style="display:none" target="_self" action="'+url+'" method="post"></form>');
		for(var key in data)
		{
			$form.append('<input class="'+key+'" name="'+key+'" type="hidden" value="'+data[key]+'"></input>');
		}
		$(top).append($form);
		$form.submit();
		$form.remove();
	},
	/*危险,以后要混淆一下*/
	PUtype:{
		1:"项目建立者",
		2:"项目经理",
		3:"项目成员"
	},
	//转换时间,接受完整的datetime字符串，然后输出想要的输出形式
	showTime:function(timeStr)
	{
		if((timeStr == null) || (timeStr == "") || (timeStr == "null"))
		{
			return "";
		}
		var kind = arguments[1]?arguments[1]:0;
		switch(kind)
		{
			case 0:
				//return timeStr.split(" ")[0];
				//如果是今年，就不显示年份
				var now= new Date();
				var year=now.getYear()+1900;
				var times = timeStr.split(" ")[0].split("-");
				return (times[0]==year)?(times[1]+"-"+times[2]):(times[0]+"-"+times[1]+"-"+times[2]);
			case 1:
				return timeStr.split(" ")[0];
			case 2:
				//返回月份日期以及小时
				var now= new Date();
				var year=now.getYear()+1900;
				var times = timeStr.split(" ")[0].split("-");
				var datePart = (times[0]==year)?(times[1]+"-"+times[2]):(times[0]+"-"+times[1]+"-"+times[2]);
				var timePart = parseInt(timeStr.split(" ")[1].split(":")[0]);
				return datePart+" "+timePart+"点";
			case 3:
				//显示 Y-m-d h
				return timeStr.split(" ")[0]+" "+timeStr.split(" ")[1].split(":")[0];
			case 4:
				//显示星期几
				//alert(timeStr);
				var theDate = new Date(timeStr.split(" ")[0]);
				//alert(theDate);
				var week;
				if(theDate.getDay()==0)          week="星期日";
				if(theDate.getDay()==1)          week="星期一";
				if(theDate.getDay()==2)          week="星期二";
				if(theDate.getDay()==3)          week="星期三";
				if(theDate.getDay()==4)          week="星期四";
				if(theDate.getDay()==5)          week="星期五";
				if(theDate.getDay()==6)          week="星期六";
				return week;
		}
	},
	remindType2Html:function(type,param){
		type = parseInt(type);
		var actionUser = param.nickname == ""?param.username:param.nickname;
		switch (type)
		{
			case 1://PROJECT_ADD
				return '';
			case 2://PROJECT_LOCK
				//你建立的项目*被*接管了
				return '<div class="line">你建立的项目“'+param.projectName+'”被 '+actionUser+' 接管了</div>';
			case 3://PROJECT_UNLOCK
				//你可以继续修改项目*
				return '<div class="line">你可以继续修改项目“'+param.projectName+'”</div>';
			case 4://PROJECT_DELETE
				//项目“”被删除了
				return '<div class="line">项目“'+param.projectName+'”被删除了</div>';
			case 8://PU_ADD
				//你被 * 加入了项目*
				return '<div class="line">你被'+actionUser+' 加入了项目“'+param.projectName+'”</div>';
			case 9://PU_DELETE
				//你被移出了项目
				return '<div class="line">你被移出了项目“'+param.projectName+'”</div>';
			case 10://PU_CHANGETYPE
				//你被设置为项目*的
				return '<div class="line">你被设置为项目“'+param.projectName+'”的'+cw.PUtype[parseInt(param.typeNow)]+'</div>';
			case 21://WORKASSIGN_ADD
				// 谁 分派了你项目“＊”的工作“ ＊”
				return '<div class="line">'+actionUser+' 分派了你项目“'+param.projectName+'”的工作“'+param.workName+'”</div>';
			case 22://WORKASSIGN_DELETE
				//你的工作分派*被删除了
				return '<div class="line">你的工作分派“'+param.workName+'”被取消了</div>';
			case 23://WORKCOMMENT_ADD
				// 谁 评论了项目“＊”的工作“ ＊”
				return '<div class="line">'+actionUser+' 评论了项目“'+param.projectName+'”的工作“'+param.workName+'”: “'+param.contentShort+'...”</div>';
			case 24://WORK_DONE
				//谁 完成了项目“＊”的工作“ ＊”
				return '<div class="line">'+actionUser+' 完成了项目“'+param.projectName+'”的工作“'+param.workName+'”</div>';
			case 25://WORK_UNDONE
				//谁 设置了项目“＊”的工作“ ＊”为未完成状态
				return '<div class="line">'+actionUser+' 设置了项目“'+param.projectName+'”的工作“'+param.workName+'”为未完成状态</div>';
			case 27://INSTR_ADD
				//谁 给 项目“＊”添加了指示:“＊”
				return '<div class="line">'+actionUser+' 给项目“'+param.projectName+'”添加了指示: “'+param.contentShort+'...”</div>';
			case 28://INSTR_RESPOND
				//谁 回答了项目“＊”的指示: “＊”
				return '<div class="line">'+actionUser+' 回答了项目“'+param.projectName+'”的指示: “'+param.contentShort+'...”</div>';
			case 31://WORK_STARTTIME
				//你的项目“”的工作“”被设置了开始时间“”
				return '<div class="line">你的项目“'+param.projectName+'”的工作“'+param.workName+'”被设置了开始时间“'+cw.showTime(param.startTime,2)+'”</div>';
			case 32://WORK_ENDTIME
				//你的项目“”的工作“”被设置了截止时间“”
				return '<div class="line">你的项目“'+param.projectName+'”的工作“'+param.workName+'”被设置了截止时间“'+cw.showTime(param.endTime,2)+'”</div>';
			default:
				return '<div class="line">错误代码</div>';
		}
	},
	logType2Html:function(type,param){
		type = parseInt(type);
		var actionUser = param.nickname == ""?param.username:param.nickname;
		switch (type)
		{
			case 1://PROJECT_ADD
				return '<div class="line">项目建立</div>';
			case 2://PROJECT_LOCK
				return '<div class="line">'+actionUser+' 接管了项目</div>';
			case 3://PROJECT_UNLOCK
				return '<div class="line">'+actionUser+' 取消了项目接管</div>';
			case 4://PROJECT_DELETE
				return '';
			case 5://PROJECT_UNDELETE
				return '';
			case 6://PROJECT_NAME
				return '<div class="line">项目改名为“'+param.projectNameNow+'”</div>';
			case 7://PROJECT_INTRO
				return '<div class="line">项目简介设置为“'+param.projectIntroNow+'”</div>';
			case 8://PU_ADD
				var addUser =  param.addUserNickname == ""?param.addUsername:param.addUserNickname;
				return '<div class="line">'+addUser+' 加入了项目</div>';
			case 9://PU_DELETE
				var deleteUser =  param.deleteUserNickname == ""?param.deleteUsername:param.deleteUserNickname;
				return '<div class="line">'+deleteUser+'被移出了项目</div>';
			case 10://PU_CHANGETYPE
				var changeUser = param.changeUserNickname == ""?param.changeUsername:param.changeUserNickname;
				return '<div class="line">'+changeUser+'被设置为项目的'+cw.PUtype[parseInt(param.typeNow)]+'</div>';
			case 11://TASK_ADD
				return '<div class="line">'+actionUser+'新建了任务“'+param.taskName+'”</div>';
			case 12://TASK_DELETE
				return '<div class="line">任务“'+param.taskName+'”被删除了</div>';
			case 13://TASK_UNDELETE
				return '';
			case 14://TASK_NAME
				return '<div class="line">任务“'+param.taskNameBefore+'”改名为“'+param.taskNameNow+'”</div>';
			case 15://TASK_INTRO
				return '';
			case 16://WORK_ADD
				return '<div class="line">'+actionUser+'添加了“'+param.workName+'”到任务“'+param.taskName+'”</div>';
			case 17://WORK_DELETE
				return '<div class="line">工作“'+param.workName+'”被删除了</div>';
			case 18:// WORK_UNDELETE
				return '';
			case 19://WORK_NAME
				return '<div class="line">工作“'+param.workNameBefore+'”被改名为“'+param.workNameNow+'”</div>';
			case 20://WORK_INTRO
				return '<div class="line">工作“'+param.workName+'”被设置简介“'+param.workIntroNow+'”</div>';
			case 21://WORKASSIGN_ADD
				var assignUser = param.assignUserNickname == ""?param.assignUsername:param.assignUserNickname;
				return '<div class="line">'+assignUser+' 被分派了工作“'+param.workName+'”</div>';
			case 22://WORKASSIGN_DELETE
				var assignUser = param.assignUserNickname == ""?param.assignUsername:param.assignUserNickname;
				return '<div class="line">'+assignUser+'的工作分派“'+param.workName+'”被取消了</div>';
			case 23://WORKCOMMENT_ADD
				return '<div class="line">'+actionUser+' 评论了项目“'+param.projectName+'”的工作“'+param.workName+'”: “'+param.contentShort+'...”</div>';
			case 24://WORK_DONE
				return '<div class="line">'+actionUser+' 完成了项目“'+param.projectName+'”的工作“'+param.workName+'”</div>';
			case 25://WORK_UNDONE
				return '<div class="line">'+actionUser+' 设置了项目“'+param.projectName+'”的工作“'+param.workName+'”为未完成状态</div>';
			case 27://INSTR_ADD
				return '<div class="line">'+actionUser+' 给项目添加了指示: “'+param.contentShort+'...”</div>';
			case 28://INSTR_RESPOND
				return '<div class="line">'+actionUser+' 对项目指示回答: “'+param.contentShort+'...”</div>';
			case 31://WORK_STARTTIME
				return '<div class="line">工作“'+param.workName+'”被设置了开始时间“'+cw.showTime(param.startTime,2)+'”</div>';
			case 32://WORK_ENDTIME
				return '<div class="line">工作“'+param.workName+'”被设置了截止时间“'+cw.showTime(param.endTime,2)+'”</div>';
			case 33://TASK_STARTTIME
				return '<div class="line">任务“'+param.taskName+'”被设置了开始时间“'+cw.showTime(param.startTime,0)+'”</div>';
			case 34://TASK_ENDTIME
				return '<div class="line">任务“'+param.taskName+'”被设置了截止时间“'+cw.showTime(param.endTime,0)+'”</div>';
			default:
				return '<div class="line">错误代码</div>';
		}
	},
	//解析提醒，基础字段：type,time,param,根据type, 解析param;返回$('<div class="block">...</div>')
	parseRemind:function(remind)
	{	
		var newBlock = $('<div class="block">'+
			'<input class="remindId" type="hidden" value="'+remind.remindId+'"></input>'+
			'<div class="delete close">&times;</div>'+
			'<div class="content">'+cw.remindType2Html(remind.type,remind.param)+'</div>'+
			'<div class="time">'+cw.showTime(remind.time,0)+'</div>'+
		'</div>');
		return newBlock;
	},
	parseLog:function(item)
	{
		var temp = $('<div class="block">'+
			'<div class="line time">'+cw.showTime(item.time,0)+'</div>'+
		'</div>');
		temp.prepend(cw.logType2Html(item.type,item.param));
		return temp;
	},
	//判断是否 ie内核
	notTrident:function()
	{
		var userAgent = navigator.userAgent.toLowerCase(); 
		return !( /trident/.test( userAgent ));
	},
	
	getTimeNow:function()
	{
		var now= new Date();
		var year=now.getYear()+1900;
		var month=now.getMonth()+1;
		month = month<10?"0"+month:month;
		var day=now.getDate();
		day = day<10?"0"+day:day;
		var hour=now.getHours();
		hour = hour<10?"0"+hour:hour;
		var minute=now.getMinutes();
		minute = minute<10?"0"+minute:minute;
		var second=now.getSeconds();
		second = second<10?"0"+second:second;
		return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
	}
}