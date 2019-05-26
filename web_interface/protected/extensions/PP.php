<?php
//-----------------------------------------------------------
// PPython(PHP and Python).
//   (2012-15 http://code.google.com/p/ppython/)
//
// License: http://www.apache.org/licenses/LICENSE-2.0


//modified by Chun Wai Leong  201410
//-----------------------------------------------------------

class PP
{
	//发送消息并且等待回答
	public static function ppython()
	{
		define("LAJP_IP", "127.0.0.1");     //Python端IP
		define("LAJP_PORT", 21320);         //Python端侦听端口

		define("PARAM_TYPE_ERROR", 101);    //参数类型错误
		define("SOCKET_ERROR", 102);        //SOCKET错误
		define("LAJP_EXCEPTION", 104);      //Python端反馈异常
		//参数数量
		$args_len = func_num_args();
		//参数数组
		$arg_array = func_get_args();

		//参数数量不能小于1
		if ($args_len < 1)
		{
			throw new Exception("[PPython Error] lapp_call function's arguments length < 1", PARAM_TYPE_ERROR);
		}
		//第一个参数是Python模块函数名称，必须是string类型
		if (!is_string($arg_array[0]))
		{
			throw new Exception("[PPython Error] lapp_call function's first argument must be string \"module_name::function_name\".", PARAM_TYPE_ERROR);
		}


		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false)
		{
			throw new Exception("[PPython Error] socket create error.", SOCKET_ERROR);
		}

		if (@socket_connect($socket, LAJP_IP, LAJP_PORT) === false)
		{
			throw new Exception("[PPython Error] socket connect error.", SOCKET_ERROR);
		}

		//消息体序列化
		$request = serialize($arg_array);
		$req_len = strlen($request);

		$request = $req_len.",".$request;

		//echo "{$request}<br>";

		$send_len = 0;
		do
		{
			//发送
			if (($sends = socket_write($socket, $request, strlen($request))) === false)
			{
				throw new Exception("[PPython Error] socket write error.", SOCKET_ERROR);
			}

			$send_len += $sends;
			$request = substr($request, $sends);

		}while ($send_len < $req_len);

		//接收
		$response = "";
		while(true)
		{
			$recv = "";
			if (($recv = socket_read($socket, 1400)) === false)
			{
				throw new Exception("[PPython Error] socket read error.", SOCKET_ERROR);
			}
			if ($recv == "")
			{
				break;
			}

			$response .= $recv;

			//echo "{$response}<br>";

		}

		//关闭
		socket_close($socket);

		$rsp_stat = substr($response, 0, 1);    //返回类型 "S":成功 "F":异常
		$rsp_msg = substr($response, 1);        //返回信息

		//echo "返回类型:{$rsp_stat},返回信息:{$rsp_msg}<br>";

		if ($rsp_stat == "F")
		{
			//异常信息不用反序列化
			throw new Exception("[PPython Error] Receive Python exception: ".$rsp_msg, LAJP_EXCEPTION);
		}
		else
		{
			if ($rsp_msg != "N") //返回非void
			{
				//反序列化
				return unserialize($rsp_msg);
			}
		}
	}
	public static function cb($actionName)
	{
		Yii::import("application.extensions.f");
		$mainDomain = f::get("pythonCallbackMain"); // 127.0.0.1
		// the folder name under htdocs/
		$app_name = basename(dirname(dirname(dirname(__FILE__)))); // assume file structure app_name/protected/extensions/PP.php
		// temp fix for sub domain redirect URL
		if (strpos(Yii::app()->baseUrl, $app_name) === false) {
			$mainDomain = $mainDomain."/".$app_name;
		}
		return $mainDomain.Yii::app()->baseUrl.f::get("pythonCallbackCtr").$actionName;
	}
	//发送消息不等待回答，直接返回
	public static function ppython_asyn()
	{
		Yii::import("application.extensions.f");
		defined("LAJP_IP") or define("LAJP_IP", "127.0.0.1");     //Python端IP
		defined("LAJP_PORT") or define("LAJP_PORT", 21320);         //Python端侦听端口

		defined("PARAM_TYPE_ERROR") or define("PARAM_TYPE_ERROR", 101);    //参数类型错误
		defined("SOCKET_ERROR") or define("SOCKET_ERROR", 102);        //SOCKET错误
		defined("LAJP_EXCEPTION") or define("LAJP_EXCEPTION", 104);      //Python端反馈异常
		//参数数量
		$args_len = func_num_args();
		//参数数组
		$arg_array = func_get_args();

		//参数数量不能小于2 [module, processId]
		if ($args_len < 2)
		{
			throw new Exception("[PPython Error] lapp_call function's arguments length < 2", PARAM_TYPE_ERROR);
		}
		//第一个参数是Python模块函数名称，必须是string类型
		if (!is_string($arg_array[0]))
		{
			throw new Exception("[PPython Error] lapp_call function's first argument must be string \"module_name::function_name\".", PARAM_TYPE_ERROR);
		}



		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false)
		{
			throw new Exception("[PPython Error] socket create error.", SOCKET_ERROR);
		}

		if (@socket_connect($socket, LAJP_IP, LAJP_PORT) === false)
		{
			throw new Exception("[PPython Error] socket connect error.", SOCKET_ERROR);
		}
		//get request's md5 with the offset
		$offset = f::get("ppythonMD5key");
		//消息体序列化
		$request = trim(serialize($arg_array));
		$key = md5($request.$offset);
		$req_len = strlen($key.";".$request);
		$request = $req_len.",".$key.";".$request;

		$send_len = 0;
		do
		{
			//发送
			if (($sends = socket_write($socket, $request, strlen($request))) === false)
			{
				throw new Exception("[PPython Error] socket write error.", SOCKET_ERROR);
			}

			$send_len += $sends;
			$request = substr($request, $sends);

		}while ($send_len < $req_len);

		//关闭
		socket_close($socket);
		return true;
	}
}
?>