# coding=utf-8
# Chun Wai Leong 的通用函数库   （初学者，见笑！）
"""
if((count % job) != (curjob-1)): #头1~job-1~job个文件对应curJob 2~job~1处理
			continue
"""
import os
import sys
import re
import commands
from time import *
import time
import math


def printSame(string):
	print("%s\r"%string),
	sys.stdout.flush()

def getResizeRatio(oldWidth,oldHeight,maxWidth,maxHeight):
	return min(maxWidth/float(oldWidth),maxHeight/float(oldHeight))

def sigmoid(val):
	return 1.0/(1.0+math.exp(-val))


# run multi job with parallel
	# used for python script with job and curJob setting
	# will generate a tempory script file n lines in /tmp/, and use parallel -j n < script. 
	# then delete the script
def runParallel(command,jobNum,showOutput=False):
	# get the time stamp 1461876956.068071
	scriptName = "%s.script"%time.time()
	scriptpath = "/tmp/%s"%scriptName

	scriptfile = open(scriptpath,"w")
	for i in xrange(1,jobNum+1):
		scriptfile.writelines("%s -job %s -curJob %s\n"%(command,jobNum,i))
	scriptfile.close()

	output = commands.getoutput("parallel -j %s < %s"%(jobNum,scriptpath))
	if(showOutput):
		print output
	os.system("rm %s"%scriptpath)

	return True



#用linux语法检查文件是否存在
def fileExists(src):
	oh = commands.getoutput('if [ -e %s ]; \nthen echo "a" \nelse echo "b"\nfi' % src)
	if(oh == "a"):
		return True
	else:
		return False

#用linux语法检查文件是否空
def fileNotEmpty(src):
	oh = commands.getoutput('if [ -s %s ]; \nthen echo "a" \nelse echo "b"\nfi' % src)
	if(oh == "a"):
		return True
	else:
		return False

def toAbsolute(path):
	# if path not start with "/", than add current path and became absolute
	if(not path.startswith("/")):
		return os.getcwd()+"/"+path
	else:
		return path
# parse a line of libsvm format into a dict
def parseLS(line):
	#feat = {}
	#for one in line.strip().split(" "):
	#	idx,val = one.strip().split(":")
	#	feat[int(idx)] = float(val)
	if(line.strip() == ""):
		return {}
	return {int(one.split(":")[0]):float(one.split(":")[1]) for one in line.strip().split(" ")}
# dict feat: 1:1.234,4:2.34...
def toLS(dictfeat):
	line = ""
	for idx in sorted(dictfeat):
		line+="%s:%.10f " % (idx,dictfeat[idx])
	return line.strip()

def getSpiralData(N,D,K):
	X = np.zeros((N*K,D)) # data matrix (each row = single example)
	y = np.zeros(N*K, dtype='uint8') # class labels
	for j in xrange(K):
	  ix = range(N*j,N*(j+1))
	  r = np.linspace(0.0,1,N) # radius
	  t = np.linspace(j*4,(j+1)*4,N) + np.random.randn(N)*0.2 # theta
	  X[ix] = np.c_[r*np.sin(t), r*np.cos(t)]
	  y[ix] = j
	return (X,y)

#解析为纯字符串或者TrueFalse，顺序与输入的列表一致(两个列表接上)
def resolveParam(paramList=[],optionList=[]):
	argvs = sys.argv[1:]
	#遍历参数，没有找到就返回空字符串
	res = []#其个数对应输入的两个参数列表个数总和
	
	#for param in paramList:
	#使用下标遍历方便空字符串处理
	for j in range(len(paramList)):
		param = str(paramList[j])
		#传入空的字符串，那就返回跟此param序号相同的argv[]
		if(param == ""):
			#序号越界了，对此参数就返回空字符串 
			if(j >= len(argvs)):
				res.append("")
			else:
				res.append(argvs[j])
			continue
		found = False
		#直接遍历，除了不能是遍历到最后一个值的时候后面没有字符串了会退出，其余都直接返回匹配字符串的后一个字符串
		for i in range(len(argvs)):
			#可能匹配了,要看后面有没有跟着的值
			if(argvs[i] == param):
				#解析出错,直接退出，防止index out of range
				if(i == len(argvs)-1):
					break
				else:
					res.append(argvs[i+1])
					found = True
					break
		if(not found):
			res.append("")
		found = False
	#遍历设置参数,没找到的返回False,找到的是True
	for option in optionList:
		option = str(option)
		#不允许传入空字符串 
		if(option == ""):
			return False
		found = False
		for i in range(len(argvs)):
			#匹配到就返回True
			if(argvs[i] == option):
				res.append(True)
				found = True
				break
		if(not found):
			res.append(False)
		found = False
	#当res是一个元素，就只返回一个元素
	if(len(res) == 1):
		return res[0]
	return res

# short time fourier transform
"""
	s, fs, enc = wavread(notes[i])
	s = resample(s,16000.0/fs,'sinc_best')
	stft(s,16000,2048/16000.0,256/16000.0)
"""

import scipy
import numpy as np

def stft(x, fs, framesz, hop):
	# modified from http://stackoverflow.com/questions/2459295/invertible-stft-and-istft-in-python
	framesamp = int(framesz*fs) #this is the STFT feature dimension
	hopsamp = int(hop*fs)
	w = scipy.hanning(framesamp)
	X = scipy.array([scipy.fft(w*x[i:i+framesamp]) 
					 for i in range(0, len(x)-framesamp, hopsamp)])
	return X[:,:framesamp/2+1] # chop redundant part
   

#istft(notesmusic,16000.0,(notesmusic.shape[1]*256/16000.0),256/16000.0)
def istft(X, fs, T, hop):
	x = scipy.zeros(T*fs) # how many points of pcm wav
	#print x.shape
	framesamp = (X.shape[1]-1)*2
	hopsamp = int(hop*fs)
	for n,i in enumerate(range(0, len(x)-framesamp, hopsamp)):
		#print n,i #0, hopsamp
		x[i:i+framesamp] += scipy.real(scipy.ifft(np.concatenate((X[n,:],np.conjugate(X[n,X.shape[1]-2:0:-1])))))# flip the imaginary part:the phrase
		#x[i:i+framesamp] += scipy.real(scipy.ifft(X[n]))
	return x


#计算两个向量距离
import numpy as np
def dist(x,y):
	return np.sqrt(np.sum((x-y)**2))

# param check,if "" return True
def cp(paramList):
	for param in paramList:
		if(param == ""):
			return True
	return False
	
def error(str):
	print(str)
	sys.exit()

#给htmlList 批量添加htmlStr
def add2htmls(htmlStr,htmlList):
	for one in htmlList:
		one.add(htmlStr)

#fixed damn ?:
def c(condition,val1,val2):
	if(condition):
		return val1
	else:
		return val2
	
# 获取某目录下的为type的文件（一级）
# 如果dir为文件，则把此文件中每一行视为一个文件名字，到此文件同目录下获取这些文件.type(不指定type就获取所有文件)
def getFiles_abs(path,type=""):
	files = getFiles(path,type)
	for i in xrange(len(files)):
		files[i] = os.path.abspath(files[i])
	return files

def getFiles(dirOrFile,type=""):
	files = []	
	#是一个文件名列表文件
	if(os.path.isfile(dirOrFile)):
		f = open(dirOrFile)
		filenames = f.readlines()
		f.close()
		typeStr = c(type=="","","."+type)
		dirname = os.path.dirname(dirOrFile)
		#print dirname 
		#if(dirname == ""):
			#print "oops"#ok
		for filename in filenames:
			filename = filename.strip()
			if(dirname == ""):
				files.append(filename+typeStr)
			else:
				files.append(dirname+"/"+filename+typeStr)
	#是一个目录，则获取该目录下一级所有type文件
	else:  
		pathList = os.listdir(dirOrFile)
		for path in pathList:
			if(dirOrFile.endswith("/")):
				path = dirOrFile + path
			else:
				path = dirOrFile + '/' + path
				
			#是否指定type
			if(type == ""):
				files.append(path)
			else:
				if(os.path.basename(path).endswith("."+type)):
					files.append(path)
	return files

#获取dir下的type文件的##文件名##(无后缀)
def getFileNames(dir,type):
	fileNames = []
	pathList = os.listdir(dir)
	for path in pathList:
		if(os.path.basename(path).endswith("."+type)):
			a,dump = os.path.splitext(path)
			fileNames.append(a)
	return fileNames

#除去sentence中的char
def removeChar(sentence,charDict):
	newSent = []
	for char in sentence.lower():
		if(not charDict.has_key(char)):
			newSent.append(char)
	return ''.join(newSent)


#任意path转换成path+"/"
def parsePath(*path):
	if(len(path)==1):
		if(path[0] == ""):
			return "./"
		return c(path[0].endswith("/"),path[0],path[0]+"/")
	else: #testp,labelp,desp = parsePath(testp,labelp,desp)
		a = []
		for one in path:
			if(one == ""):
				a.append("./")
			else:
				a.append(c(one.endswith("/"),one,one+"/"))
		return tuple(a)
#for windows!!
def parsePathW(path):
	return c(path.endswith("\\"),path,path+"\\")

def getDirs(root):
	root = parsePath(root)
	paths = []
	things = os.listdir(root)
	#print things
	for thing in things:
		if(not os.path.isfile(root+thing)):
			#print thing
			paths.append(parsePath(root+thing))
	return paths
	
#把video转换为flv
def v2flv(src,desPath,tools):
	filename,dump = os.path.splitext(os.path.basename(src))
	desPath = parsePath(desPath)
	#commands.getoutput("%s -i %s -y -ar 44100 %s%s.flv" % (tools,src,desPath,filename))
	#os.system("%s -i %s -y -ar 44100 %s%s.flv" % (tools,src,desPath,filename))
	aspect = getAspect(src)
	if(aspect == False):
		commands.getoutput("%s -i %s -y -ar 44100 %s%s.flv" % (tools,src,desPath,filename))
	else:
		#高度固定
		height = 240
		width = int(240*aspect)
		commands.getoutput("%s -i %s -y -ar 44100 -s %s*%s %s%s.flv" % (tools,src,width,height,desPath,filename))
		

#获取视频宽高比
def getAspect(src):
	aspect = os.popen('mediainfo "--Inform=Video;%DisplayAspectRatio%" '+src).read().strip()
	if(aspect == ""):
		return True
	else:
		return float(aspect)
	
def flac2wav(audioFile,desPath,quiet=True):
	fileName = os.path.splitext(os.path.basename(audioFile))[0]
	#用于wav转wav,当wav不被opensmile识别时

	commands.getoutput("flac -d -o %s.wav %s" % (desPath+fileName,audioFile))

	return True

#把其他格式的音频转换为wav(flac不行)
def audio2wav(audioFile,desPath,quiet=True):
	fileName = os.path.splitext(os.path.basename(audioFile))[0]
	#用于wav转wav,当wav不被opensmile识别时

	os.system("lame %s tmp%s.mp3" % (audioFile,fileName))
	os.system("lame --decode tmp%s.mp3 %s.wav" % (fileName,desPath+fileName))
	commands.getoutput("rm tmp%s.mp3" % fileName)

	return True


#把videoFile获取wav出来到desPath中
def extractWav(videoFile,desPath,quiet=True,careful=False,s16k=False): # s16k:whether to sample rate 16k, for stft calculation
	if(not os.path.exists(videoFile)):
		return False
	s16kstr = ""
	if(s16k):
		s16kstr = "-ar 16000"
	fileName,dump = os.path.splitext(os.path.basename(videoFile))
	desPath = parsePath(desPath)
	#print "mplayer -novideo -ao pcm:file="+desPath+fileName+".wav "+videoFile
	if(quiet):
		commands.getoutput("ffmpeg -i '"+videoFile+"' -acodec pcm_s16le "+s16kstr+" '"+desPath+fileName+".wav'")
		if(careful):
			commands.getoutput("sox %s%s.wav %s%stmp.wav"%(desPath,fileName,desPath,fileName))# so that extract the wav header "metadata" and opensmile is happy
			commands.getoutput("mv %s%stmp.wav %s%s.wav"%(desPath,fileName,desPath,fileName))
	else:
		os.system("ffmpeg -i '"+videoFile+"' -acodec pcm_s16le "+s16kstr+" '"+desPath+fileName+".wav'")
		if(careful):
				os.system("sox %s%s.wav %s%stmp.wav"%(desPath,fileName,desPath,fileName))# so that extract the wav header "metadata" and opensmile is happy
				os.system("mv %s%stmp.wav %s%s.wav"%(desPath,fileName,desPath,fileName))
	"""
	if(quiet):
		commands.getoutput("mplayer -really-quiet -benchmark -vc null -vo null -novideo -ao pcm:file="+desPath+fileName+"_tmp.wav "+videoFile)
	else:
		os.system("mplayer -really-quiet -benchmark -vc null -vo null -novideo -ao pcm:file="+desPath+fileName+"_tmp.wav "+videoFile)
	#noted: -dumpvideo : no wav will generate.
	#对生成的wav继续转换，保证opensmile 能读
	a=commands.getoutput("lame %s tmp%s.mp3" % (desPath+fileName+"_tmp.wav",fileName))
	b=commands.getoutput("lame --decode tmp%s.mp3 %s.wav" % (fileName,desPath+fileName))
	#print a
	#print b
	os.system("rm tmp%s.mp3" % fileName)
	"""
	return True

def mkdir(path):
	if(not os.path.exists(path)):
		#os.mkdir(path)
		os.makedirs(path)

def check(checkList):
	#"file","cmd"
	for one in checkList:
		if(one[1] == "file"):
			if(not os.path.exists(one[0])):
				print "%s: not exists" % one[0]
			else:
				print "%s: passed" % one[0]
		elif(one[1] == "cmd"):
			print "dry run %s...:" % one[0]
			os.system(one[0])
		elif(one[1] == "exec"):
			result = commands.getoutput(one[0])
			if(result.find("No such file") >= 0):
				print "%s: not installed"
			else:
				print "%s: passed" % one[0]
		
#把wavFile获取mfcc出来到desPath中
	#默认opensmile config 文件与当前命令,且叫 mfcc.conf
def extractMfcc(wavFile,desPath,mfccconf="mfcc.conf",quiet=True):
	if(not os.path.exists(wavFile)):
		return False
	fileName,dump = os.path.splitext(os.path.basename(wavFile))
	desPath = parsePath(desPath)
	if(quiet):
		commands.getoutput("SMILExtract -C "+mfccconf+" -I '"+wavFile+"' -O '"+desPath+fileName+".csv'")
	else:
		os.system("SMILExtract -C "+mfccconf+" -I '"+wavFile+"' -O '"+desPath+fileName+".csv'")
	return True

#把originMfcc chunk后到desPath中，命名: filename_start_end.csv ;;;;;;start end 是mfcc 帧index
	#结尾不足一个chunkSize的直接扔掉
def chunkMfcc(srcFile,desPath,chunkSize,step):
	if(not os.path.exists(srcFile)):
		return False
	#获取名字信息
	desPath = parsePath(desPath)
	fileName,dump = os.path.splitext(os.path.basename(srcFile))
	mfccs = open(srcFile).readlines()
	curS = 1
	curE = chunkSize
	while(len(mfccs) - curE >= step):
		new = open(desPath+fileName+"_"+str(curS)+"_"+str(curE)+".csv","w")
		for i in range(curS-1,curE):
			new.writelines(mfccs[i])
		new.close()
		curS+=step
		curE+=step
	return True



#获取videoDir的帧率
	"""
def getFps(videoDir):
	if(not os.path.exists(videoDir)):
		return False
	frameRate = os.popen('mediainfo "--Inform=Video;%FrameRate%" '+videoDir).read().strip()
	#frame rate 不存在情况，获取frame count 与duration计算
	if(frameRate == ""):
		t = os.popen('mediainfo "--Inform=Video;%FrameCount%" '+videoDir).read().strip()
		#此时视频文件出错了
		if(t == ""):
			return False
		frameCount = float(t)
		#单位 ms
		duration = float(os.popen('mediainfo "--Inform=Video;%Duration%" '+videoDir).read().strip())
		frameRate = (frameCount/duration) * 1000
	fps = float(frameRate)
	return fps
	"""
	"""
def getDuration(videoDir):
	#单位 s
	return float(os.popen('mediainfo "--Inform=Video;%Duration%" '+videoDir).read().strip()) / 1000.0
	"""
# use ffmpeg to get time of video in seonds
def getDuration(videoFile,ffmpegpath="ffmpeg"):
	duration = commands.getoutput("'%s' -i '%s' 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//" % (ffmpegpath,videoFile))
	#print duration
	hour,minutes,sec = duration.strip().split(":")
	hour = float(hour)
	minutes = float(minutes)
	sec = float(sec)
	return sec+ minutes*60+hour*60*60
def getVideoDuration(videoDir):
	# return '00:44:29.00'
	return os.popen("ffmpeg -i '%s' 2>&1 |grep 'Duration' |cut -d ' ' -f 4 | sed 's/,//'"%videoDir).read().strip()

def getFps(videoDir):
	#os.system("ffmpeg -i '%s' 2>&1 | sed -n 's/.*, \\(.*\\) fp.*/\\1/p'"%videoDir)
	#print "ffmpeg -i '%s' 2>&1 | sed -n 's/.*, \\(.*\\) fp.*/\\1/p'"%videoDir
	#print os.popen("ffmpeg -i '%s'"%videoDir).read()
	#print repr(os.popen("ffmpeg -i '%s' 2>&1 | sed -n 's/.*, \\(.*\\) fp.*/\\1/p'"%videoDir).read().strip())
	return float(os.popen("ffmpeg -i '%s' 2>&1 | sed -n 's/.*, \\(.*\\) fp.*/\\1/p'"%videoDir).read().split("\n")[0].strip())

def getFrameCount(videoDir):
	if(not os.path.exists(videoDir)):
		return False
	t = os.popen('mediainfo "--Inform=Video;%FrameCount%" '+videoDir).read().strip()
	if(t == ""):
		return False
	frameCount = int(t)
	return frameCount
	
	
#读取labelfile中的数据，返回一个list,list中每个元素是一个字典，包括"start" "end" "class"字段
def getLabel(labelFile):
	#检查文件是否存在
	if(not os.path.exists(labelFile)):
		return False
	res = []
	lines = open(labelFile,"r").readlines()
	for line in lines:
		c,a,b = line.strip().split(" ")
		temp = {"start":int(a),"end":int(b),"class":c}
		res.append(temp)
	return res
	#[{'start': 1, 'end': 946, 'class': 'car'}]
	#[{'start': 1, 'end': 2997, 'class': 'flower'}, {'start': 1494, 'end': 1599, 'class': 'kids'}]
	#[]
	#[]
	#[{'start': 1, 'end': 1455, 'class': 'party'}]
	
def fileNotExists(file):
	print("File not exists:"+file+", exiting...")
	sys.exit()

#读取annotation file,返回大字典
def readAnnotation(annoFile):
	annoBig = {}
	lines = open(annoFile,"r").readlines()
	for line in lines:
		stuff = line.strip().split(" ")
		annoBig[stuff[0]] = {}
		for concept in stuff[1:]:
			annoBig[stuff[0]][concept] = 1
	return annoBig

def time2sec(timeStr):
	l = timeStr.split(':')
	if(len(l) == 3):
		return float(l[0]) * 3600 + float(l[1]) * 60 + float(l[2])
	elif(len(l)==2):
		return float(l[0]) * 60 + float(l[1])
	else:
		error("error: time format:%s"%timeStr)

#读取concept list
def readConceptlist(conceptlistFile):
	conceptlist = []
	lines = open(conceptlistFile,"r").readlines()
	for line in lines:
		conceptlist.append(line.strip())
	return conceptlist
#获取accuracy Accuracy = 85.1852% (230/270) (classification)  
def getAccuracy(str):
	reg = re.compile(r"Accuracy = ([0-9.]+)%")
	res = reg.match(str)
	if(res):
		return float(res.group(1))/100.0
	else:
		return "none"
#给定秒数，换成 H M S
def sec2time(secs):
	#return strftime("%H:%M:%S",time.gmtime(secs)) # doesnt support millisecs
	"""
	>>> strftime("%H:%M:%S",time.gmtime(24232.4242))
	'06:43:52'
	>>> sec2time(24232.4242)
	'06:43:52.424200'
	>>> 
	"""
	m,s = divmod(secs,60)
	#print m,s
	h,m = divmod(m,60)
	if(s >= 10.0):
		return "%02d:%02d:%.3f"%(h,m,s)
	else:
		return "%02d:%02d:0%.3f"%(h,m,s)
	
def sec2time_ffmpeg(secs): # no .second
	#return strftime("%H:%M:%S",time.gmtime(secs)) # doesnt support millisecs
	"""
	>>> strftime("%H:%M:%S",time.gmtime(24232.4242))
	'06:43:52'
	>>> sec2time(24232.4242)
	'06:43:52.424200'
	>>> 
	"""
	m,s = divmod(secs,60)
	#print m,s
	h,m = divmod(m,60)
	s = int(s)
	return "%02d:%02d:%02d"%(h,m,s)

#清楚空格分隔数据的NaN,str已经被strip
def filterNaN(str):
	data = str.split(" ")
	newStr = ""
	for i in range(len(data)):
		if(i == len(data)-1):
			newStr+="%s" % NaNfilter(data[i])
		else:	
			newStr+="%s " % NaNfilter(data[i])
	return newStr
	
def NaNfilter(str):
	if(str == "NaN"):
		return 0.0
	else:
		return str	



agentList = [
	'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
	"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
	"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A",
	"Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3",
	'Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11',
	'Opera/9.25 (Windows NT 5.1; U; en)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
	'Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Kubuntu)',
	'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.12) Gecko/20070731 Ubuntu/dapper-security Firefox/1.5.0.12',
	'Lynx/2.8.5rel.1 libwww-FM/2.14 SSL-MM/1.4.1 GNUTLS/1.2.9'
]
import gzip
from StringIO import StringIO
import urllib,urllib2,cookielib,json # urllib2 supports https if we can import ssl
def getUrl(url):
	import random
	headers = {
		"User-agent":random.choice(agentList),
 		'Connection':'keep-alive',
 		#'Accept-Encoding':'gzip',#, deflate, sdch',
		#'Accept-Language':'zh-CN,zh;q=0.8,en;q=0.6,fr;q=0.4',
		'Cache-Control':'max-age=0',
		'Connection':'keep-alive',
	}
	"""
	# for in-link download
	headers = {
		"User-agent":random.choice(agentList),
		"Referer":"http://www.baidu.com",
		'Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
 		'Connection':'keep-alive',
 		'Accept-Encoding':'gzip',#, deflate, sdch',
		'Accept-Language':'zh-CN,zh;q=0.8,en;q=0.6,fr;q=0.4',
		'Cache-Control':'max-age=0',
		'Connection':'keep-alive',
		'Host':'ajax.googleapis.com',
		'HTTPS':1,
	}
	"""
	"""
	we have asked for gzip content.
	from StringIO import StringIO
	import gzip

	request = urllib2.Request('http://example.com/')
	request.add_header('Accept-encoding', 'gzip')
	response = urllib2.urlopen(request)
	if response.info().get('Content-Encoding') == 'gzip':
		buf = StringIO( response.read())
		f = gzip.GzipFile(fileobj=buf)
		data = f.read()
	"""
	#print headers["User-agent"]
	cj = cookielib.CookieJar()   #获取cookiejar实例	
	opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
	req = urllib2.Request(url,headers=headers)
	response = opener.open(req)
	#print response
	if response.info().get('Content-Encoding') == 'gzip':
		buf = StringIO( response.read())
		f = gzip.GzipFile(fileobj=buf)
		content = f.read()
	else:
		content = response.read()
	return content

# data is a dict
def postUrl(url,data):
	headers = {
		"User-agent":random.choice(agentList),
		"Referer":"http://www.baidu.com",
		'Accept':'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
 		'Connection':'keep-alive',
 		'Accept-Encoding':'gzip',#, deflate, sdch',
		'Accept-Language':'zh-CN,zh;q=0.8,en;q=0.6,fr;q=0.4',
		'Cache-Control':'max-age=0',
		'Connection':'keep-alive',
		'Host':'ajax.googleapis.com',
		'HTTPS':1,
	}
	"""
	for posting
	values = {'name' : 'Michael Foord',
			  'location' : 'Northampton',
			  'language' : 'Python' }

	data = urllib.urlencode(values)
	req = urllib2.Request(url, data)

	"""
	data = urllib.urlencode(data)
	cj = cookielib.CookieJar()   #获取cookiejar实例	
	opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
	req = urllib2.Request(url,data=data,headers=headers)
	response = opener.open(req)
	if response.info().get('Content-Encoding') == 'gzip':
		buf = StringIO( response.read())
		f = gzip.GzipFile(fileobj=buf)
		content = f.read()
	else:
		content = response.read()
	return content

# 计算AP,输入lists = [{'score':,'label':},{},],score用于排序，label是ground truth [0/1]
import operator
def computeAP(lists):
	#先排序
	lists.sort(key=operator.itemgetter("score"),reverse=True)
	#print lists[0]
	#计算ap
	#相关的总数
	rels = 0
	#当前排名
	rank = 0
	#AP 分数
	score = 0.0
	for one in lists:
		rank+=1
		#是相关的
		if(one['label'] == 1):
			rels+=1
			score+=rels/float(rank)
	if(rels != 0):
		score/=float(rels)
	return score



#html类
class Html:
	#头尾的html预定义昊
	header = """
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ChunWaiLeong</title>
</head>
<body>
	"""
	footer = """
</body>
</html>
	"""
	#html 主体部分，用addBody函数不断添加
	body = ""
	
	#文件路径与名
	file = "a.html"
	
	#需要初始化文件名
	def __init__(self,file):
		self.file = file
	
	#添加到body 的函数
	def add(self,str):
		self.body+=str
		
	#打印html到屏幕
	def printHtml(self):
		print("%s%s%s" % (self.header,self.body,self.footer))
	#输出html文件
	def printFile(self):
		f = open(self.file,"w")
		f.writelines("%s%s%s" % (self.header,self.body,self.footer))
		f.close()
		
		
		
		
		
