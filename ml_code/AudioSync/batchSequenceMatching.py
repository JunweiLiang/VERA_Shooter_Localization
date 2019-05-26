# coding=utf-8
# one-versus all sequence matching
import sys,os,operator
from ChunWai import *
import numpy as np

from hough import hough
def usage():
	print """
	use seqp1 to search in seqp2. they can be the same. rankfile is based on seqp1
	-seqp1 :sequence file path,could be kmeans assign files, peaks files(this can be one file)
	-seqp2 :sequence file path,could be kmeans assign files, peaks files
	-t : time for each line in the seqnece file represent, should be 0.008 * hop
	for assMatch:
		-sp: whether each token in a line equal same weight,used for peak finger files
	for featMatch:
		-distType :default 1 as euclidean, 2 as cosine
		-norm : whether to normlize after distance cal and before sigmoiding
	for hough:
		-addf: add factor
		-keepfor:
	-weightForDominant : default 0.5
	-rankp : rank list file for each sequence file against all
	# carefull, small t will make huge cache size
	-cachep: if set, each pair's matching array will be saved and reused.
	-job
	-curJob
	-skip: if set, will skip rankfile that exists
	-showImg : if pairs is not much, add this to show matching matrix image
	-isFeat: whether is feature matching.
-----
	the rankp files (src): filename(target),timeDiff(second),Confidence
	timeDiff: After target has played timeDiff +- t,src started;
-----
	for segment search'
		seqp1 should be one file,
		-sg : whether is segment search
		-start : start time 00:00:00
		-end : end time
		-t : unit , 0.4
-------

	"""
	sys.exit()

def toSec(strT):
	things = strT.strip().split(":")
	if(len(things) == 1):
		return float(things[0])
	hr,mini,sec = things
	return float(hr)*60*60+float(mini)*60+float(sec)

# cache for the matching matrix, not the hough array. more flexible

def getCache(src,target,cachep):
	possfile = ""
	reverse = False
	if(os.path.exists(cachep+"%s/%s.npy" % (src,target))):
		possfile = cachep+"%s/%s.npy" % (src,target)
	elif(os.path.exists(cachep+"%s/%s.npy" % (target,src))):
		possfile = cachep+"%s/%s.npy" % (target,src)
		reverse = True
	if(possfile == ""):
		return False
	try:
		matching = np.load(possfile)
	except Exception as e:
		print e
		return False
	if(matching.shape == (0,)):
		return False
	# whew!
	if(reverse):
		return matching.T
	return matching


def checkpath(path):
	if(not os.path.exists(path)):
		error("%s not exists" % path)

def getlines(filename):
	count=0
	with open(filename,"r") as f:
		for line in f:
			count+=1
	return count

def main():
	start,end,seqp1,seqp2,t,rankp,job,curJob,distType,cachep,addf,keepfor,weightForDominant,sp,skip,showImg,sg,isFeat,norm = resolveParam(['-start','-end','-seqp1','-seqp2','-t','-rankp','-job','-curJob','-distType','-cachep','-addf','-keepfor','-weightForDominant'],['-sp','-skip','-showImg','-sg','-isFeat','-norm'])
	if(skip):
		print "skipping existed rankfile."
	if(cp([seqp1,seqp2,t,rankp])):
		usage()
	if(addf == ""):
		addf = 4
	addf = float(addf)
	if(keepfor == ""):
		keepfor = 10
	keepfor = int(float(keepfor))
	if(weightForDominant == ""):
		weightForDominant = 0.5
	weightForDominant = float(weightForDominant)
	if(distType == ""):
		distType = 1
	distType = int(distType)
	if(showImg):
		import matplotlib.pyplot as plt
	if(isFeat):
		from sequenceMatchingDist import SeqMatch
	else:
		from sequenceMatching import SeqMatch
	if(job == ""):
		job =1
	if(curJob == ""):
		curJob = 1
	t = float(t)
	job = int(job)
	curJob = int(curJob)

	if(sg):
		if(cp([start,end,t])):
			usage()
		assert(not os.path.isdir(seqp1))
		maxEnd = getlines(seqp1)
		starts = toSec(start)
		ends = toSec(end)
		starts,ends = int(starts/t),int(ends/t)
		if(ends > maxEnd):
			ends = maxEnd
		assert(starts < ends)
		print "confirmed that the target video is around %s long" % (sec2time(maxEnd*t))


	if(os.path.isdir(seqp1)):
		seqp1 = parsePath(seqp1)
	seqp2 = parsePath(seqp2)
	rankp = parsePath(rankp)
	checkpath(rankp)
	if(cachep != ""):
		cachep = parsePath(cachep)
		print "using cache"
		checkpath(cachep)
	if(os.path.isdir(seqp1)):
		seqfiles1 = getFiles(seqp1,"txt")
	else:
		seqfiles1 = [seqp1]
	print "total seqp1: %s" % len(seqfiles1)
	seqfiles2 = getFiles(seqp2,"txt")
	print "total seqp2: %s" % len(seqfiles2)
	count=0
	for seqfile in seqfiles1:
		count+=1
		if(count % 20 == 0):
			print count
		if((count % job) != (curJob-1)):
			continue
		#compare every one except itself
		src = os.path.splitext(os.path.basename(seqfile))[0]
		if(skip and os.path.exists(rankp+src+".txt")):
			print "skipped %s..." % src
			continue
		# the src file's matching to all the file,with each argmax's timeDiff, and the max bigger than second max, yeah, call it score
		score = []
		for seqfile2 in seqfiles2:
			target = os.path.splitext(os.path.basename(seqfile2))[0]
			#skip itself
			if(src == target):
				continue
			hasCache = False
			if(cachep != ""):
				#check for cache first
				matching = getCache(src,target,cachep)
				if(type(matching) != type(False)):
					hasCache = True
			if(not hasCache):
				if(isFeat):
					Match = SeqMatch(seqfile,seqfile2,type=distType,norm=norm)
				else:
					Match = SeqMatch(seqfile,seqfile2,sp=sp)
				matching = Match.match()
				if(cachep != ""):
					#save cache
					mkdir(cachep+src)
					np.save(cachep+"%s/%s.npy"%(src,target),matching)

			if(sg):
				# get portion of the matching matrix
				matching = matching[starts:ends,:]


			h = hough(matching,addf,keepfor)
			matchingh,offset = h.run() # in the future we may cahe this #offset means the length of first video
			# get time differences,
			# here timeDiff is the offset/time-shift for the video pair
			argmaxIndex = np.argmax(matchingh)
			timeDiff = (argmaxIndex+offset)*t # time frame count* each time frame represent's time
			# evidence
			evidence = h.evidence[argmaxIndex]
			value,endIndex,length = evidence
			startIndex = endIndex - length +1
			#evidence index interpretation
			"""
			if timeDiff > 0: print " after %s has started %s, the evidence start and last for %s seconds" %(os.path.basename(src),startIndex*t,length*t)
			"""

			"""
				currently we use the max value's gap to the second value in the hough array as confidence for the match. Each hough array has one match
			"""
			
			# get the sorted index of matchingh value
			
			max2minIndex = np.argsort(matchingh)[::-1]
			#print np.argmax(matchingh),max2minIndex[0]
			#max value bigger than second how much?gmail
			
			if(matchingh[max2minIndex[1]] == 0):
				gap = 0.0
			else:
				#gap = (matchingh[max2minIndex[0]] - matchingh[max2minIndex[1]])/matchingh[max2minIndex[1]]
				#use max to the rest's gap
				mean = np.mean(matchingh[max2minIndex[1:]])
				gap = (matchingh[max2minIndex[0]] - mean)/mean # how dominent
			#confidence = gap
			
			#confidence = matchingh[argmaxIndex] # use the top val
			#we use both now
			#confidence = 0.5*matchingh[argmaxIndex]+0.5*gap
			confidence = (1.0-weightForDominant)*matchingh[argmaxIndex]+weightForDominant*gap

			score.append((target,timeDiff,confidence,startIndex*t,length*t))
			if(showImg):
				print "showing matching %s and %s" % (src,target)
				plt.imshow(matching,cmap="coolwarm")
				plt.plot([np.argmax(matchingh)+offset,np.argmax(matchingh)+offset+matching.shape[0]], [0, matching.shape[0]], 'k-')
				plt.show()
				sleep(0.1)
				plt.bar(range(len(matchingh)),matchingh)
				plt.show()
	
		score.sort(key=operator.itemgetter(2),reverse=True)
		if(sg):
			rankFile = open(rankp+src+"_"+str(start)+"_"+str(end)+".txt","w")
		else:
			rankFile = open(rankp+src+".txt","w")
		for one in score:
			target,timeDiff,confidence,startIndex,length = one
			#rankFile.writelines("%s,%s(s),%s,%s:%s\n"%(target,timeDiff,confidence,startIndex,length))
			rankFile.writelines("%s,%s,%s,%s,%s\n"%(target,timeDiff,confidence,startIndex,length))
		rankFile.close()





main()
