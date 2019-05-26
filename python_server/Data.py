# coding=utf-8
# to be called by other python class to update progress, or send things to callback
# also handle data importing
# if this changed, needed to re exec php_python.py

from Daisy import Daisy
import hashlib,json,cookielib,urllib2
from process import z_encode
import socket

class Data(Daisy):
	def __init__(self):
		Daisy.__init__(self)

	# given a list, [[a1,a2],[b1,b2]], will generate a param file line1:a1 a2 line2:b1 b2, into tmp path
	# videoListFile = importing.makeFile(videoList,"%s.videoList"%processId)
	def makeFile(self,paramList,uniqueName): #uniqueName contain path
		filepath = uniqueName
		newfile = open(filepath,"w")
		for one in paramList:
			newfile.writelines("%s\n"%(" ".join(["%s"%x for x in one])))
		newfile.close()

		#self.junk.append(filepath)
		return filepath

	# basic method, given a url and data, will dump the data to json, and add a key header to post to the url
	def sendback(self,url,data):
		headers = {
			'Content-type': 'application/json', 
			'Accept': 'text/plain',
			"User-agent":"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1"
		}
		data = json.dumps(data, allow_nan=False) # if not, will get "thing":NaN, php will get json syntax error.
		key = hashlib.md5(data+self.safety).hexdigest()
		data = key+";"+data
		#print data
		print "send to "+url+":"+data[:100]+"..."
		cj = cookielib.CookieJar()   #获取cookiejar实例    
		opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
		req = urllib2.Request("http://"+url,data,headers) # http:// for local 127.0.0.1 test
		#req = urllib2.Request("https://"+url,data,headers) # for production
		
		try:
			content = opener.open(req).read()
			print "php response:"+content
			if(content.strip() == ""):
				print "response empty[for debug]: %s,%s"%(data[:200],data[-200:])
				desFile = open("postData.txt","w")
				desFile.writelines("%s"%data)
				desFile.close()
		except Exception as e:
			print "sendback error:%s"%e
			print "full send[for debug]:"+data
		

	# update process, using the process Id and global api url
	def updateProgress(self,processId,progress,message,done=0):
		data = {}
		data['processId'] = processId
		data['progress'] = progress
		data['message'] = message
		data['done'] = done
		self.sendback(self.progressApi,data)

	# make the param into php format and send to the pyhon in targetMachine
	# param should be a ordered dict,
	# we will make a new order dict, following the php format


	def sendToPython(self, targetMachine,targetFunc,param):
		newParam = []
		newParam.append(targetFunc)
		for one in param:
			newParam.append(param[one])# ignore the key name
		newParam.append({"hostAddress":targetMachine['hostAddress'],"hostUsername":targetMachine['hostUsername']}) # host Info, for sending back things
		paramStr = z_encode(newParam)
		# get the encrytion value
		key = hashlib.md5(paramStr+self.safety).hexdigest()
		# add to the str
		paramStr = key+";"+paramStr
		paramStr = "%s,%s"%(len(paramStr),paramStr)
		s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
		s.connect((targetMachine['address'],targetMachine['port']))
		s.sendall(paramStr)
		s.close()










