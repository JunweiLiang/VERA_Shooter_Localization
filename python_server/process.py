# coding=utf-8
# Junwei Liang
"""
	2.x 3.x socket不兼容分析
	
	3.x中获取socket.recv的变量 类型是  bytes,  2.x是 str,  3.x对于bytes[i]可以直接跟 0xab 比较， 但是 2.x 中str[i]='s' != 0x73
	所以只要3.x也转为str 与字符比较就兼容了!
	python 
		str.encode(n)   把  unicode的str 变成 n编码
		str.decode(n)   把  n 编码 的str 变成 unicode
		
		
	这个玩意的原理：
		php传送 serialize 后的参数和要调用的 module与函数,
		python 里 module进行缓存,	
		然后构造字符串代码complie成
			import test
			ret=test.processMp4('..',1,{'b': 3, 'a': 2},[3, 4, 5, 90])
		exec执行，然后返回结果
		
"""

import sys
import time
import threading
import socket

import php_python
from Daisy import Daisy

daisy = Daisy()
safety = daisy.safety # should be kept safe, same as the one in extensinos/f.php

processLogPath = daisy.processLogPath # the path to save processLog

REQUEST_MIN_LEN = 10	#合法的request消息包最小长度	
TIMEOUT = 30		   #socket处理时间30秒#就是接收数据的时间

pc_dict = {}		#预编译字典，key:调用模块、函数、参数字符串，值是编译对象
global_env = {}	 #global环境变量

def index(bytes, c, pos=0):
	"""
	查找c字符在bytes中的位置(从0开始)，找不到返回-1
	pos: 查找起始位置
	"""
	for i in range(len(bytes)):
		if (i <= pos):
			continue
		if bytes[i] == c:
			return i
			break
	else:
		return -1

# noted here p 's dict will be random order. You can use OrderedDict
def z_encode(p):
	"""
	encode param from python data   
	返回字符串 
	相当于python 的 php serialize实现
	"""
	if p == None:							   #None->PHP中的NULL
		return "N;"
	elif isinstance(p, int):					#int->PHP整形
		return "i:%d;" % p
	elif isinstance(p, str):					#String->PHP字符串
		#p_bytes = p.encode(php_python.CHARSET);
		p_bytes = p
		ret = 's:%d:"' % len(p_bytes)
		#ret = ret.encode(php_python.CHARSET)
		ret = ret + p_bytes + '";'#.encode(php_python.CHARSET)
		#ret = str(ret, php_python.CHARSET)
		#ret = str(ret)
		return ret
	elif isinstance(p, bool):				   #boolean->PHP布尔
		b=1 if p else 0
		return 'b:%d;' % b
	elif isinstance(p, float):				  #float->PHP浮点
		return 'd:%r;' % p
	elif isinstance(p, list) or isinstance(p, tuple):		#list,tuple->PHP数组(下标int)
		s=''
		for pos,i in enumerate(p):
			s+=z_encode(pos)
			s+=z_encode(i)
		return "a:%d:{%s}" % (len(p),s)
	elif isinstance(p, dict):				   #字典->PHP数组(下标str)
		s=''
		for key in p:
			s+=z_encode(key)
			s+=z_encode(p[key])
		return "a:%d:{%s}" % (len(p),s)
	else:									   #其余->PHP中的NULL
		return "N;"


def z_decode(p):
	"""
	调用方式,
	  while p:
		v,p=z_decode(p)		 #v：值  p：bytes(每次z_decode计算偏移量)
		params = v
	递归地取字符串p,每次取一些到v,剩下的更新为p，继续迭代
	
	decode php param from string to python  根据php serialize
	p: str
	"""
	#print(p)
	if p[0]=='N':					  #NULL 0x4e-'N'
		return None,p[2:]
	elif p[0]=='b':					#bool 0x62-'b'
		if p[2] == '0':				# 0x30-'0'
			return False,p[4:]
		else:
			return True,p[4:]
	elif p[0]=='i':					#int  0x69-'i'
		i = index(p, ';', 1)		   # 0x3b-';'
		return int(p[2:i]),p[i+1:]
	elif p[0]=='d':					#double 0x64-'d'
		i = index(p, ';', 1)		   # 0x3b-';'
		return float(p[2:i]),p[i+1:]
	elif p[0]=='s':					#string 0x73-'s'
		len_end = index(p, ':', 2)	 # 0x3a-':'
		str_len = int(p[2:len_end])
		end = len_end + 1 + str_len + 2
		v = p[(len_end + 2) : (len_end + 2 + str_len)]
		#return str(v, php_python.CHARSET), p[end+1:]
		return str(v), p[end+1:]
	elif p[0]=='a':					#array 0x61-'a'
		list_=[]	   #数组
		dict_={}	   #字典
		flag=True	  #类型，true-元组 false-字典
		second = index(p, ':', 2)	  # 0x3a-":"
		num = int(p[2:second])  #元素数量
		pp = p[second+2:]	   #所有元素
		for i in range(num):
			key,pp=z_decode(pp)  #key解析
			"""
				以下判断不完整，php的
				$p3= array(
					3,
					4,
					5,
					"a" => 90
				);
				会被看作array 然后丢失 下标"a"
			"""
			if (i == 0): #判断第一个元素key是否int 0
				if (not isinstance(key, int)) or (key != 0):
					flag = False			
			val,pp = z_decode(pp)  #value解析
			list_.append(val)
			dict_[key]=val
		#return (list_, pp[2:]) if flag else (dict_, pp[2:])	#php serialize 后 a:n:{}后没有分号的，这个错误
		return (list_, pp[1:]) if flag else (dict_, pp[1:]) 
	else:
		return p,''

# security check
def parse_php_req(p): #a:5:{i:0;s:16:"test::processMp4";i:1;s:113:"/Applications/...mp4";i:2;i:1;i:3;i:2;i:4;i:3;}
	"""
	解析PHP请求消息
	返回：元组（模块名，函数名，入参list）
	
	 因为php 传来始终是 array()下包含参数，所以下面循环只执行一次
	 
	while p:
		v,p = z_decode(p)		 #v：值  p：后续的str
		params = v   #这个语句是不对
	"""
	import hashlib
	key,p = p.split(";",1)
	trueKey = hashlib.md5(p+safety).hexdigest()

	params,nothing = z_decode(p)
	
	modul_func = params[0]			#第一个元素是调用模块和函数名
	processId = params[1] # second is the processId in php
	print "ppython: modul and function name:%s" % modul_func
	#print "ppython: parameters:%s" % params[1:]
	print "ppython: parameters: %s param" % (len(params)-1)
	modul,func = modul_func.split("::")
	return modul, func, params[1:],key==trueKey,processId
	

class ProcessThread(threading.Thread):
	"""
	preThread 处理线程
	"""
	def __init__(self, socket):
		threading.Thread.__init__(self)

		#客户socket
		self._socket = socket

	def run(self):
		
		#---------------------------------------------------
		#	1.接收消息
		"""
	   php: $res = PP::ppython("test::processMp4",$realpath,$p1,$p2,$p3);
		184,a:5:{i:0;s:16:"test::processMp4";i:1;s:113:"/Applications/...mp4";i:2;i:1;i:3;i:2;i:4;i:3;}
		"""
		#---------------------------------------------------
		startTime = time.time()
		try:  
			self._socket.settimeout(TIMEOUT)				  #设置socket超时时间
			firstbuf = self._socket.recv(16 * 1024)		   #接收第一个消息包(bytes)
			firstbuf = firstbuf.decode(php_python.CHARSET).encode(php_python.CHARSET)
			#print (type(firstbuf))   #3.x中是 class bytes, 2.x中是 str
			if len(firstbuf) < REQUEST_MIN_LEN:			   #不够消息最小长度
				print ("ppython: len not legal: %s" % firstbuf)
				self._socket.close()
				return

			firstComma = index(firstbuf, ',')				#查找第一个","分割符	0x2c
		  #  print (firstComma)
			totalLen = int(firstbuf[0:firstComma])	 #把到','前的数字获取出来
			#print("消息长度:%d" % totalLen)
			reqMsg = firstbuf[firstComma+1:]  # a:5:{i:0;s:16:"test::processMp4";i:1;s:113:"/Applications/...mp4";i:2;i:1;i:3;i:2;i:4;i:3;}
			while (len(reqMsg) < totalLen):	
				reqMsg = reqMsg + self._socket.recv(16 * 1024)

			#调试 # might be huge sometime
			# if this takes forever to print, try put the large param into a file
			#print "ppython: reqMsg：%s" % reqMsg
			#关闭socket
			self._socket.close()
			print ("socket closed,start processing..")

		except Exception as e:  
			print ('reception error', e)
			self._socket.close()
			return

		#---------------------------------------------------
		#	2.调用模块、函数检查，预编译。
		#---------------------------------------------------

		#从消息包中解析出模块名、函数名、入参list
		modul, func, params,checkPass,processId = parse_php_req(reqMsg)
		if(not checkPass):
			print "ppython: safety check failed!"
			# do some logging in production
			return
		# save the request log
		newlog = open("%s%s.txt"%(processLogPath,processId),"w")
		newlog.writelines("%s"%reqMsg)
		newlog.close()
		#print(modul)
		#print(func)
		if (modul not in pc_dict):   #预编译字典中没有此编译模块	 # 程序运行开始后缓存的
			#检查模块、函数是否存在
			try:
				callMod = __import__ (modul)	#根据module名，反射出module
				pc_dict[modul] = callMod		#预编译字典缓存此模块
			except Exception as e:
				print ('ppython: error in module:%s  %s' % (modul,e))
				#self._socket.sendall(("F" + "module '%s' is not exist!" % modul).encode(php_python.CHARSET)) #异常
				#self._socket.close()
				return
		else:
			callMod = pc_dict[modul]			#从预编译字典中获得模块对象

		try:
			callMethod = getattr(callMod, func)   # 相当于使用  callMod.func  但是这里func作为变量,,用于检查这个函数是否存在,不会执行，只返回函数地址
			"""
				try:
					func = getattr(obj, "method")
				except AttributeError:
					... deal with missing method ...
				else:
					result = func(args)
			"""
		except Exception as e:
			print ('ppython: error in func:%s,%s' % (func,e))
			#self._socket.sendall(("F" + "function '%s()' is not exist!" % func).encode(php_python.CHARSET)) #异常
			#self._socket.close()
			return
		"""
			此步获取了函数名字
		"""
		#---------------------------------------------------
		#	3.Python函数调用
		#---------------------------------------------------

		try: 
			params = ','.join([repr(x) for x in params])   # php 传来的函数列表  ,接成字符串，{'a':dwa,'d'},23,[3,4,5]..	
			#print ("调用函数及参数：%s(%s)" % (modul+'.'+func, params) )
			
			#加载函数
			compStr = "import %s\nret=%s(%s)" % (modul, modul+'.'+func, params)
			#print("函数调用代码:%s" % compStr)
			rpFunc = compile(compStr, "", "exec")
			"""
			>>> code = "for i in range(0, 10): print i"
			>>> cmpcode = compile(code, '', 'exec')
			>>> exec(cmpcode,globals,local)
			0
			1
			2
			3
			4
			5
			6
			7
			8
			9
			
			"""
			
			if func not in global_env: 
				global_env[func] = rpFunc   
			local_env = {}
			"""
				local装载执行时rpFunc中的局部变量，global带入全局变量 ,感觉没啥用
			"""
			exec (rpFunc, global_env, local_env)	 #函数调用
			#print ("g")
			#print (global_env)
			#print ("l")
			#print (local_env['ret'])
		except Exception as e:  
			#print ('调用Python业务函数异常: %s', e )
			errType, errMsg, traceback = sys.exc_info()
			print errMsg
		   # self._socket.sendall(("F%s" % errMsg).encode(php_python.CHARSET)) #异常信息返回
		   # self._socket.close()
			return

		#---------------------------------------------------
		#	4.结果返回给PHP
		#---------------------------------------------------
		#retType = type(local_env['ret'])
		#print ("函数返回：%s" % retType)
		#rspStr = z_encode(local_env['ret'])  #函数结果组装为PHP序列化字符串

		try:  
			#加上成功前缀'S'
			#rspStr = "S" + rspStr
			a = 1
			#调试
			#print ("返回包：%s" % rspStr)
			#全部以字符串发送
			#self._socket.sendall(rspStr.decode(php_python.CHARSET).encode(php_python.CHARSET))
		except Exception as e:  
			print ('ppython: 发送消息异常', e)
			errType, errMsg, traceback = sys.exc_info()
			#self._socket.sendall(("F%s" % errMsg).decode(php_python.CHARSET).encode(php_python.CHARSET)) #异常信息返回
		finally:
			#self._socket.close()
			endTime = time.time()
			runTime = endTime-startTime
			print "ppython: time used: %.2f  secs\n\n" % runTime
			return
