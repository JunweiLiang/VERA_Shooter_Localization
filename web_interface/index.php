<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//设置时区
//date_default_timezone_set("PRC");

//颜色定义
define("COLOR1","rgb(23,96,55)");
define("COLOR1_DARKER1","rgb(2, 89, 132)");
define("COLOR1_LIGHTER1","rgb(0,128,192)");
define("COLOR1_LIGHTER1_LIGHT","rgb(76,170,98)");
define("COLOR1_LIGHTER2","rgb(105,196,211)");
define("COLOR1_LIGHTER2_MORE","rgb(105,196,231)");
define("COLOR1_LIGHTER3","rgb(219, 255, 237)");
define("COLOR1_LIGHTER3_DARK","rgb(178, 255, 200)");
define("COLORLITTLEDARK","rgb(240,240,240)");
define("COLORDARK","rgb(235,235,235)");
define("COLORDARKER","rgb(225,225,225)");
define("COLORDARKERER","rgb(215,215,215)");
define("COLOR2","#2f96b4");


//设置ID混淆
defined("IDADDUP") or define("IDADDUP",10000);



define("PROJECT_ADD",1);
define("PROJECT_LOCK",2);
define("PROJECT_UNLOCK",3);
define("PROJECT_DELETE",4);
define("PROJECT_UNDELETE",5);
define("PROJECT_NAME",6);
define("PROJECT_INTRO",7);
define("PU_ADD",8);
define("PU_DELETE",9);
define("PU_CHANGETYPE",10);
define("TASK_ADD",11);
define("TASK_DELETE",12);
define("TASK_UNDELETE",13);
define("TASK_NAME",14);
define("TASK_INTRO",15);
define("WORK_ADD",16);
define("WORK_DELETE",17);
define("WORK_UNDELETE",18);
define("WORK_NAME",19);
define("WORK_INTRO",20);
define("WORKASSIGN_ADD",21);
define("WORKASSIGN_DELETE",22);
define("WORKCOMMENT_ADD",23);
define("WORK_DONE",24);
define("WORK_UNDONE",25);
define("USER_CHANGENICKNAME",26);
define("INSTR_ADD",27);
define("INSTR_RESPOND",28);
define("USER_CHANGEPW",29);
//define("USER",30);
define("WORK_STARTTIME",31);
define("WORK_ENDTIME",32);
define("TASK_STARTTIME",33);
define("TASK_ENDTIME",34);

session_name("daisy");

require_once($yii);
session_start();
//载入多语言类
require_once(dirname(__FILE__).'/protected/extensions/t.php');
//lang 1--english	2---chinese
//设置语言为英文
t::$language = "en_us";
//是否需要中文
if(isset($_SESSION['lang']) && ($_SESSION['lang'] == 2))
{
	//中文 zh_cn
	t::$language = "zh-cn";

}
Yii::createWebApplication($config)->run();
?>