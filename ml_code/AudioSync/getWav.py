# coding=utf-8
# get wav from filelst(absolute path) into a despath
import sys,os
from ChunWai import *

def usage():
	print """
		-filelst
		-desp
		-skip
		-job
		-curJob
	"""
	sys.exit()

def main():
	filelst,desp,job,curJob,skip = resolveParam(['-filelst','-desp','-job','-curJob'],['-skip'])
	if(cp([filelst,desp])):
		usage()
	desp = parsePath(desp)
	if(job == ""):
		job = 1
	job = int(job)
	if(curJob == ""):
		curJob = 1
	curJob = int(curJob)
	mkdir(desp)
	count=0
	for line in open(filelst,"r").readlines():
		count+=1
		if(count % 10 == 0):
			print count
		if((count % job) != (curJob-1)): #头1~job-1~job个文件对应curJob 2~job~1处理
			continue
		basename = os.path.splitext(os.path.basename(line.strip()))[0]
		if(skip and os.path.exists(desp+basename+".wav")):
			print "skipping %s " %(desp+basename+".wav")
			continue
		extractWav(line.strip(),desp,True,True,True)
	print "total %s" % count

main()
