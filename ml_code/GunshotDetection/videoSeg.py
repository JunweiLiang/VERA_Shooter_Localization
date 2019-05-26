# coding=utf-8
# given a video, use ffmpeg to segment into m sec long, n sec shift. to a path
from ChunWai import *
import sys,os,commands

def usage():
	print """
		-video
		-path
		-m : m second long
		-n : n second shift
		-job
		-curJob
		-startSec : default 0
		-endSec: default duration
	"""
	sys.exit()

def getTime(timeStr):
	hour,minute,sec = timeStr.strip().split(":")
	return float(hour)*60.0*60.0+float(minute)*60.0+float(sec)

if __name__ == "__main__":
	video,path,m,n,job,curJob,startSec,endSec = resolveParam(['-video','-path','-m','-n','-job','-curJob','-startSec','-endSec'])
	if(cp([video,path])):
		usage()
	if(job == ""):
		job = 1
	if(curJob == ""):
		curJob = 1
	if(startSec == ""):
		startSec = 0
	startSec = float(startSec)

	job = int(job)
	curJob = int(curJob)
	assert(curJob <= job)
	path = parsePath(path)
	if(not os.path.exists(path)):
		error("path not exists")
	m,n = float(m),float(n)
	curS = startSec
	curE = startSec+m
	# get the video's duration
	videoname = os.path.splitext(os.path.basename(video))[0]
	duration = getDuration(video)
	if(endSec == ""):
		endSec = duration
	endSec = float(endSec)
	duration = endSec
	count=0
	while(duration - curE >= 0.0):
		count+=1
		if((count % job) != (curJob-1)): #头1~job-1~job个文件对应curJob 2~job~1处理
			curS+=n
			curE+=n
			continue

		print "curS:%s,curE:%s,duration:%s"%(sec2time(curS),sec2time(curE),sec2time(duration))
		newvideo = "%s%s_%s_%s.mp4"%(path,videoname,sec2time(curS),sec2time(curE))
		if(os.path.exists(newvideo)):
			curS+=n
			curE+=n
			continue
		output = commands.getoutput("ffmpeg -y -i '%s' -vn -ss %s -t %s -strict -2 '%s'"%(video,sec2time(curS),sec2time(m),newvideo))
		curS+=n
		curE+=n

