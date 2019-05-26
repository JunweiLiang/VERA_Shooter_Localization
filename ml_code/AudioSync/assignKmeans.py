# coding=utf-8
# get features each lines' assignment to the kmeans center(top 10) into a index file.(index starts from 0)

import sys,os
from ChunWai import *

def usage():
	print """
		-featp
		-desp
		-ctr #kmeans center file
		-bin # the assignKmeans binary path
		-skip
		-job
		-curJob
	"""
	sys.exit()

if __name__ == "__main__":
	featp,desp,ctr,bins,job,curJob,skip = resolveParam(['-featp','-desp','-ctr','-bin','-job','-curJob'],['-skip'])
	if(cp([featp,desp,ctr,bins])):
		usage()
	if(job == ""):
		job = 1
	job = int(job)
	if(curJob == ""):
		curJob = 1
	curJob = int(curJob)
	featp = parsePath(featp)
	desp = parsePath(desp)
	if(not os.path.exists(desp)):
		error("desp not exists.")
	#get center num first, and the feature dim
	ctr_num = 0
	feat_dim = 0
	with open(ctr,"r") as f:
		for line in f:
			if(feat_dim==0):
				feat_dim = len(line.strip().split(" "))
			ctr_num+=1
	print "ctr_num:%s,feat_dim:%s" % (ctr_num,feat_dim)
	feats = getFiles(featp,"txt")
	print "get %s feature files" % len(feats)
	count=0
	for feat in feats:
		if(count==0):
			#check feature dim
			with open(feat,"r") as f:
				for line in f:
					dim = len(line.strip().split(" "))
					if(dim != feat_dim):
						error("error,feature dim:%s" % dim)
					break
		count+=1
		if(count % 10 ==0):
			print count
		if((count % job) != (curJob-1)): #头1~job-1~job个文件对应curJob 2~job~1处理
			continue
		filename = os.path.splitext(os.path.basename(feat))[0]
		if(skip and os.path.exists("%s%s.txt"%(desp,filename))):
			print "skipping %s%s.txt"%(desp,filename)
			continue
		os.system("%s %s %s %s %s %s%s.txt" % (bins,ctr,ctr_num,feat,feat_dim,desp,filename))

