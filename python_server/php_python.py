# coding=utf-8


import time
import socket
import os,sys

import process
from ChunWai import mkdir

# -------------------------------------------------
# 基本配置
# -------------------------------------------------
from Daisy import Daisy

daisy = Daisy()
LISTEN_PORT = daisy.listenPort	 #服务侦听端口
CHARSET = "utf-8"	   #设置字符集（和PHP交互的字符集）


# -------------------------------------------------
# 主程序
#   异步版本，只用socket接收数据，然后执行，最后调用回调，(http方式)
# -------------------------------------------------
if __name__ == '__main__':

	print ("-------------------------------------------")
	print ("- PPython Service - %s - by Junwei Liang" % daisy.siteName)
	print ("- Time start: %s" % time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time())) )
	print ("-------------------------------------------")

	# check whether you are running the code in the code path, this is required
	curdir = os.path.abspath("./")
	codedir = os.path.dirname(os.path.abspath(__file__))
	if(curdir != codedir):
		print "Please run me at code path"
		sys.exit()

	mkdir(daisy.processLogPath)

	sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  #TCP/IP
	sock.bind(('', LISTEN_PORT))  
	sock.listen(5)  #最多连接数

	print ("Listen port: %d" % LISTEN_PORT)
	print ("charset: %s" % CHARSET)
	print ("Server startup...")


	connection = None
	while True:  
		try:
			(connection,address) = sock.accept()  #收到一个请求

			print "\nppython: operation start time (from %s,%d):%s" % (address[0],address[1],time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time())))
		
			process.ProcessThread(connection).start()

			print "\nppython: operation end time:%s" % (time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time())))

		except KeyboardInterrupt: # only ctrl+c will stop the program
			sock.shutdown(2)
			if connection:
				connection.close()
			print "interrupted"
			os._exit(0)
			break
		except Exception as e:
			print "main level e:%s"%e
			pass