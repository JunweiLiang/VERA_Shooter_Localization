# coding=utf-8
# given a ranklist path for pair-wise sync, get a global file
# global file means vname,globalOffset; offset is asc order; a new cluster will start by offset from 0

import os,sys,random
from ChunWai import *
random.seed(10)
# this code works for incomplete ranklist files, for refine or complete global finding

def getNStuff(ranklist,n):
	count=0
	scores = []
	with open(ranklist,"r") as f:
		for line in f:
			count+=1
			filename,offset,conf,_ = line.strip().split(",",3)
			offset = offset.strip("(s)")
			scores.append((filename,round(float(offset),1),conf))
			if(count >= n):
				break
	#print scores
	return scores

def usage():
	print """
	# this is only for batchSequenceMatching with the same seq1 and seq2
		-rankp
		-desFile
		-mergeChain # whether to merge chain, get much longer chain
		# cluster  == chain
	"""
	sys.exit()

lookFor = [
	'ERC000093',
	'ERC000196',
	'ERC000358',
	'ERC000359',
	'ERC000381'
]

# given videoname, find in cluster
def findVideoInClusters(clusters,videoname):
	#print videoname
	count=0
	for cluster in clusters:
		# videoname is the first in cluster chain
		if(videoname == cluster[0][0]):
			return count,-1
		insertPoint = 0
		for (v1,v2,offset) in cluster:
			if(v2 == videoname):
				return count,insertPoint
			insertPoint+=1
		count+=1
	# something wrong
	# some file in the ranklist file, is not a ranklist file
	print "fuck"
	return False

def getReverseChain(chain):
	thisChain = []
	for (v1,v2,offset) in chain:
		thisChain = [(v2,v1,-offset)]+thisChain
	return thisChain

def insertCluster(clusters,targetClusterIndex,curCluster,startVideo,insertPoint,secondTargetVideo,secondOffset):
	assert(targetClusterIndex!=curCluster)
	#print clusters[targetClusterIndex]
	if(insertPoint == -1):
		assert(secondTargetVideo == clusters[targetClusterIndex][0][0])
		clusters[targetClusterIndex] = clusters[curCluster] + [(startVideo,secondTargetVideo,secondOffset)]+clusters[targetClusterIndex]
	else:
		assert(secondTargetVideo == clusters[targetClusterIndex][insertPoint][1])
		clusters[curCluster].append((startVideo,secondTargetVideo,secondOffset))
		# get a reverse chain
		clusters[curCluster] = getReverseChain(clusters[curCluster]) + clusters[curCluster]
		assert(clusters[curCluster][0][0] == clusters[targetClusterIndex][insertPoint][1])
		assert(clusters[curCluster][-1][1] == clusters[targetClusterIndex][insertPoint][1])
		clusters[targetClusterIndex][insertPoint+1:insertPoint+1] = clusters[curCluster]
	#print clusters[curCluster]
	#print clusters[targetClusterIndex][insertPoint:]
	del clusters[curCluster]
	return curCluster-1

def getUnique(listx):
	checked = []
	for one in listx:
		if one not in checked:
			checked.append(one)
	return checked

if __name__ == "__main__":
	rankp,desFile,mergeChain = resolveParam(['-rankp','-desFile'],['-mergeChain'])
	if(cp([rankp,desFile])):
		usage()
	rankp = parsePath(rankp)
	rankFiles = getFiles(rankp)
	print "got %s rankfile"%(len(rankFiles))

	videonames = [os.path.splitext(os.path.basename(one))[0] for one in rankFiles]
	videonamesOriginal = [os.path.splitext(os.path.basename(one))[0] for one in rankFiles]

	# right now we randomly start from a rankfile, get the match within topn , then go down the chain, until no new video in the topn, then we start from new rankfile
	topn = 5
	if(topn > len(rankFiles)):
		topn = len(rankFiles)

	clusters = []
	curCluster = 0
	clusters.append([])
	clen = []
	# when used one video,will delete from videonames
	startVideo = random.choice(videonames)
	curVideoList = [startVideo] # each cluster chain's current video list
	while(len(videonames) > 0):
		print len(videonames)
		if(len(videonames) == 0):
			break
		videonames.remove(startVideo)
		topnStuff = getNStuff(rankp+startVideo+".txt",topn)
		targetVideo,offset,secondTargetVideo,secondOffset = "",0,"",0
		print startVideo,topnStuff
		for one in topnStuff:
			if(one[0] not in videonamesOriginal):
				# if this ranklist has file that is not in the rankp filename list, it will be ignore
				continue
			# priority is to find the video not used in any chain
			if(one[0] in videonames):
				if(targetVideo == ""):
					targetVideo,offset = one[0],one[1]
			# remeber the target video that is not in the cur chain video list,
			if(one[0] not in curVideoList):
				if(secondTargetVideo == ""):
					secondTargetVideo,secondOffset = one[0],one[1]
		#if(len(curVideoList) != len(set(curVideoList))):
		#	print "fuck"
		#	sys.exit()
		# start a new cluster
		#if(usedVideo.has_key(startVideo)):
		#	print "fuck"
		#	sys.exit()
		if(targetVideo == ""):
			# insert current cluster into an exsiting one, if the second target is not empy
			if(mergeChain and (secondTargetVideo!="")):
				#print clusters[curCluster]
				targetClusterIndex,insertPoint = findVideoInClusters(clusters,secondTargetVideo)
				curCluster = insertCluster(clusters,targetClusterIndex,curCluster,startVideo,insertPoint,secondTargetVideo,secondOffset)
				
			print clusters[curCluster]
			curCluster+=1
			clusters.append([])
			if(len(videonames) > 0 ):
				startVideo = random.choice(videonames)
				curVideoList = [startVideo]
		# add this video to the current cluster
		else:
			
			clusters[curCluster].append((startVideo,targetVideo,offset))
			startVideo = targetVideo
			curVideoList.append(startVideo)

	
	while([] in clusters):
		clusters.remove([])

	for cluster in clusters:
		clen.append(len(cluster))
	#print clusters[0]
	print "cluster num:%s,max len:%s,min len:%s"%(len(clusters),max(clen),min(clen))
	# clean up empty cluster
	# we ignore many single video.


	"""
	for one in clusters:
		found = False
		for (v1,v2,offset) in one:
			for look in lookFor:
				if(v1.find(look) != -1):
					found = True
					break
		if(found):
			print one
	"""
	# for each cluster, change each video into global offset
	#       global offset means this video start at when, (v1,v2,offset) means relative offset, v2 play offset seconds then v1 play
	# just start from the first and get the zero second video, later refine it
	desFile = open(desFile,"w")
	usedVideo = {}
	for cluster in clusters:
		newCluster = []
		v1time = 0.0 #second
		for (v1,v2,offset) in cluster:
			newCluster.append([v1,v1time])
			v1time-=offset
			v1time = round(v1time,1) # important, then we get the same offset
		newCluster.append([cluster[-1][1],v1time])
		newCluster = getUnique(newCluster)

		newCluster.sort(key=operator.itemgetter(1),reverse=False)
		# change all to above zero
		earliest = -newCluster[0][1]
		for i in xrange(len(newCluster)):
			newCluster[i][1]+=earliest
			#if(usedVideo.has_key(newCluster[i][0])):
			#	print newCluster[i]
			#	print usedVideo[newCluster[i][0]]
			#	sys.exit()
			usedVideo[newCluster[i][0]] = newCluster[i]
			desFile.writelines("%s,%s\n"%(newCluster[i][0],newCluster[i][1]))
		desFile.writelines("None,None\n")
		#print newCluster
		#break
	desFile.close()

		


				


