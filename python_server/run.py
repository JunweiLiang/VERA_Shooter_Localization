# coding=utf-8
import os,sys,urllib2,urllib,time,commands,cv2,json,datetime
from ChunWai import *
from Data import Data
from Daisy import Daisy
from Worker import Worker
import numpy as np

# in php directly call "run::func",$processId,$callback,...other param..
# all func use Import.py to report progress, and send back things to callback
importing = Data()
daisy = Daisy()

# get all the frames of a video into a path
def getVideoFrames(processId, callback, userId, videoId, videofile, framePath):
	mkdir(framePath)
	max_size = daisy.frame_max_size
	shorter_edge_size = daisy.frame_shorter_edge_size

	vcap = cv2.VideoCapture(videofile)
	if not vcap.isOpened():
		raise Exception("cannot open %s"%videofile)
	
	is_opencv2 = cv2.__version__.split(".")[0] == "2"
	if is_opencv2:
		# opencv 2
		frame_count = vcap.get(cv2.cv.CV_CAP_PROP_FRAME_COUNT)
		fps = vcap.get(cv2.cv.CV_CAP_PROP_FPS)
	else:
		# opencv 3/4
		frame_count = vcap.get(cv2.CAP_PROP_FRAME_COUNT)
		fps = vcap.get(cv2.CAP_PROP_FPS)

	#print fps, frame_count
	step = int(frame_count/10.0) #  

	cur_frame=0
	while cur_frame < frame_count:
		# update every 10 percent
		if (cur_frame+1) % step == 0:
			importing.updateProgress(processId, (cur_frame+1)/float(frame_count), "Extracting frames (%s/%s)..."%(cur_frame, frame_count))

		suc, frame = vcap.read()
		if not suc:
			cur_frame+=1
			print "warning, frame %s read failed.."%cur_frame
			continue

		im = frame.astype("float32")

		resized_image = resizeImage(im, shorter_edge_size, max_size)

		target_file = os.path.join(framePath, "%d.jpg"%(cur_frame+1))

		cv2.imwrite(target_file, resized_image)

		cur_frame+=1

	# send back something
	data = {
		"userId": userId,
		"videoId": videoId,
		"fps": fps,
		"num_frame": cur_frame,
	}
	# callback with the videoList
	importing.sendback(callback, data)

	# everything done,
	importing.updateProgress(processId, 1.0, "Done!",1)

def resizeImage(im, short_size, max_size):
	h, w = im.shape[:2]
	neww, newh = get_new_hw(h, w, short_size, max_size)
	if (h==newh) and (w==neww):
		return im
	return cv2.resize(im, (neww, newh), interpolation=cv2.INTER_LINEAR)

def get_new_hw(h,w,size,max_size):
	scale = size * 1.0 / min(h, w)
	if h < w:
		newh, neww = size, scale * w
	else:
		newh, neww = scale * h, size
	if max(newh, neww) > max_size:
		scale = max_size * 1.0 / max(newh, neww)
		newh = newh * scale
		neww = neww * scale
	neww = int(neww + 0.5)
	newh = int(newh + 0.5)
	return neww,newh		


def getTime(timestr):
	hour,minutes,sec = timestr.strip().split(":")
	return float(hour)*60.0*60.0+float(minutes)*60.0+float(sec)

def getNScore(ranklist,n):
	count=0
	scores = []
	with open(ranklist,"r") as f:
		for line in f:
			count+=1
			filename,offset,conf,startIndex,length = line.strip().split(",")
			scores.append(float(conf))
			if(count >= n):
				break
	return scores

def getUniformCount(maxNum,count):
	inc = maxNum/count
	nums,num = [],0
	for i in range(count):
		nums.append(num)
		num+=inc
		if(num>=maxNum):
			num = maxNum-1
	return nums

def getVideoImgs(video,height,width,count):
	# given a video, uniformly get count frames and return the resized .
	# get the total number of frame first
	videostream = cv2.VideoCapture(video)

	is_opencv3 = cv2.__version__ >= "3.0.0"
	if is_opencv3:
		frame_count_flag = cv2.CAP_PROP_FRAME_COUNT
		frame_flag = cv2.CAP_PROP_POS_FRAMES
	else:
		frame_count_flag = cv2.cv.CV_CAP_PROP_FRAME_COUNT
		frame_flag = cv2.cv.CV_CAP_PROP_POS_FRAMES

	totalFrame = int(videostream.get(frame_count_flag))
	frameIndexs = getUniformCount(totalFrame,count)
	frames = []
	for frameIndex in frameIndexs:
		videostream.set(frame_flag,frameIndex)
		success,frame = videostream.read()
		#print frame.shape
		try:
			thisFrameHeight,thisFrameWidth,_ = frame.shape # may fail
		except Exception as e:
			print "warning, %s failed once to get frame"%os.path.basename(video)
			continue
		r = getResizeRatio(thisFrameWidth,thisFrameHeight,width,height)
		frame = cv2.resize(frame,(int(thisFrameWidth*r),int(thisFrameHeight*r)))
		frames.append(frame)
	return frames

def importVideos(processId,callback,videoList,userId,getImgs=False,imgPath="",datasetId=0):
	# callback
	# 127.0.0.1/daisy/index.php/python/importVideos
	# videoList
	# [{'originPath': '/home/chunwaileong/cmu/humanrights/daisy_toy/ERC000000.mp4', 'websiteExists': False, 'basename': 'ERC000000.mp4', 'originExists': True, 'websitePath': False, 'relatedPath': 'assets/videos/ERC000000.mp4'},
	
	"""
	time.sleep(3)
	importing.updateProgress(processId,0.1,"done 10%")
	time.sleep(3)
	importing.updateProgress(processId,0.7,"done 70%")
	time.sleep(3)
	importing.updateProgress(processId,1.0,"done 100%,finish")
	"""
	setWidth = daisy.videoWidth

	# this is the setting if need to get frame for each video
	maxImgHeight,maxImgWidth,imgCount = daisy.maxImgHeight,daisy.maxImgWidth,daisy.imgCount

	count=0
	for video in videoList:
		count+=1

		# use ffmpeg to scale and re codec 
		oripath,websitepath,basename = video["originPath"],parsePath(video['websiteP']),video['basename']
		output = commands.getoutput("ffmpeg -i %s -y -acodec copy -vcodec libx264 -vf scale='%s:trunc(ow/a/2)*2' %s%s"%(oripath,setWidth,websitepath,basename))
		#print "ffmpeg -i %s -y -acodec copy -vcodec libx264 -vf scale=%s:-1 %s%s"%(oripath,setWidth,websitepath,basename)
		#print output
		video['duration'] = getDuration(video['originPath'])
		if(getImgs):
			imgPath = parsePath(imgPath)
			frameImgs = getVideoImgs(video['originPath'],maxImgHeight,maxImgWidth,imgCount)
			countImg = 0
			for frameImg in frameImgs:
				cv2.imwrite(imgPath+basename+"_%s.png"%(countImg),frameImg)
				countImg+=1

		if(count % 10 == 0):
			importing.updateProgress(processId,count/float(len(videoList)),"processed %s videos:%s"%(count,basename))


	hasImgs = 0
	if(getImgs):
		hasImgs = 1
	data = {"videoList":videoList,"userId":userId,"hasImgs":hasImgs,"imgCount":imgCount,"datasetId":datasetId}
	# callback with the videoList
	importing.sendback(callback,data)

	# everything done,
	importing.updateProgress(processId,1.0,"",1)

# import audio sync result
def importAudioSyncResult(processId,callback,resultFile,userId,runName):
	importing.updateProgress(processId,0.1,"parsing result..")
	data = {"runName":runName,"results":[],"userId":userId}
	rank = 0
	for line in open(resultFile,"r").readlines():
		rank+=1
		video1,video2,score,offset,evidenceStart,evidenceLast = line.strip().split(",")
		data['results'].append({
			"video1":video1,
			"video2":video2,
			"score":score,# stay string format,
			"rank":rank,
			"offset":float(offset),
			"evidenceStart":float(evidenceStart),
			"evidenceLast":float(evidenceLast),
		})

	importing.updateProgress(processId,0.8,"Sending back result..")
	# callback with the videoList
	importing.sendback(callback,data)
	
	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

# import gunshot result
def importGunshotResult(processId,callback,resultFile,userId,runName):
	importing.updateProgress(processId,0.1,"parsing result..")
	data = {"runName":runName,"results":[],"userId":userId}
	top = 1000 
	rank = 0
	maxSegmentEach = 1000
	result = json.load(open(resultFile,"r"))
	for one in result[:top]:
		rank+=1
		# gunshot count may or may not has,
		gunshotCounts = []
		if(one.has_key("gunshotCounts")):
			gunshotCounts = one['gunshotCounts']
		if(len(one["segments"])>maxSegmentEach):
			one["segments"] = one["segments"][::2]
		if(len(one["segments"])>maxSegmentEach):
			one["segments"] = one["segments"][:maxSegmentEach]
			print "warning, one video segment length is:%s,chunked to under"%len(one["segments"])
		data['results'].append({
			"video":one['video'],
			"rankScore":one['rankScore'],
			"rank":rank,
			"segmentJson":json.dumps(one['segments']),
			"gunshotCountJson":json.dumps(gunshotCounts)
		})

	importing.updateProgress(processId,0.8,"Sending back result..")
	# callback with the videoList
	importing.sendback(callback,data)
	
	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

# import result ranlist pair
def importResult(processId,callback,filelstPath,userId,runName):
	# given filelstPath, contain absolute path for all ranklist file
	# if any one in videoList (ranklist file path) not exists, whole thing fail
	# for each video file ,return a rankscore
	#		based on the top 5 average confidence score
	
	returnN = 10 # only return top N video in each ranklist
	importing.updateProgress(processId,0.1,"getting top ranking score")

	videoList = [line.strip() for line in open(filelstPath,"r").readlines()]

	topscores,topn = [],5 # get all video's original score, will use min-max scale
	for ranklist in videoList:
		scores = getNScore(ranklist,topn)
		topscores.append(sum(scores)/len(scores))
	#stat = (min(topscores),max(topscores),max(topscores) - min(topscores))
	#stat = (sum(topscores)/len(topscores),np.std(topscores)) # std is inf, use rank now
	video2rank = np.argsort(topscores)[::-1].argsort() # return the rank Index of topscores in descending order	

	count=0
	data = {"runName":runName,"results":[],"userId":userId}
	for ranklist in videoList:
		count+=1
		countline=0
		temp = {
			"videoname":os.path.splitext(os.path.basename(ranklist))[0],
			"ranklist":[],
			#"rankScore":(topscores[count-1] - stat[0]) / stat[1]
			"rankScore":1/float(video2rank[count-1]+1)
		}
		#print temp['rankScore']
		with open(ranklist,"r") as f:
			for line in f:
				countline+=1
				filename,offset,conf,startIndex,length = line.strip().split(",")
				temp['ranklist'].append({
					"videoname":filename,
					"offset":offset,
					"score":conf,
					"startIndex":startIndex,
					"length":length
				})
				if(countline >= returnN):
					break
		data['results'].append(temp)
		if(count % 100 == 0):
			importing.updateProgress(processId,count/float(len(videoList)),"processed %s files"%count)
	# callback with the videoList
	importing.sendback(callback,data)

	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

def preprocessing(processId,callback,videoList):
	scriptName = "Preprocessing.py"
	count=0
	data = {'results':[]}
	for video in videoList:
		count+=1
		temp = {}
		videopath = video['processPath']
		thumbnailpath = video['thumbnailpath']
		audiopath = video['signaudiopath']
		basename = video['basename']
		output = commands.getoutput("python %s -videopath %s -thumbnailpath %s -audiopath %s"%(scriptName,videopath,thumbnailpath,audiopath))
		#print output
		temp['score'] = float(output.strip())
		temp['dvId'] = video['dvId']
		temp['basename'] = basename
		data['results'].append(temp)
		importing.updateProgress(processId,count/float(len(videoList)),"processed %s"%basename)
	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

	# callback with the videoList
	importing.sendback(callback,data)

stft_con_w = 100
stft_con_h = 50
timeIs = 0.008*stft_con_h # 0.008 is the stft hop setting
# get research pipeline
	# if direct call, will need append sys.path

def eventReconstruction(processId,callback,data):
	# each script should have a skip parameter, to skip exsisting file
	paraJob = daisy.parallelJob
	getWav = daisy.erCodePath+'getWav.py'
	getStft = daisy.erCodePath+'wav2stft.py'
	stft_con = daisy.erCodePath+'stft_cat.py'
	kmeanscenter = daisy.modelPath+'selected_stftabs_w100h50_0.4.txt.cluster_centres'
	kmeansbin = daisy.erCodePath+'assignKmeans'
	kmeans = daisy.erCodePath+'assignKmeans.py'
	sequenceMatching = daisy.erCodePath+'batchSequenceMatching.py'
	globalSync = daisy.erCodePath+'globalSync.py'

	datasetname = data['datasetname']
	datasetId = data['datasetId'] # will use in send back
	runpath = daisy.runPath+datasetname+"/"
	os.system("rm -rf %s"%(runpath))

	runpathWav = runpath+"wav/"
	runpathStft = runpath+"stft/"
	runpathStft_con = runpath+"stft_con_w%sh%s/"%(stft_con_w,stft_con_h)
	runpathKmeansAss = runpath+"kmeans_ass/"
	runpathRankfiles = runpath+"rankfiles/"
	globalResult = runpath+"globalResult.txt"
	#runpathCache = runpath+"cache/"
	mkdir(runpath)
	mkdir(runpathWav)
	mkdir(runpathStft)
	mkdir(runpathStft_con)
	mkdir(runpathKmeansAss)
	mkdir(runpathRankfiles)
	#mkdir(runpathCache)

	#get video first
	videoPathList = []
	videoNameList = []
	videoname2dvId = {} # this is used to final identification!
	videoname2path = {} # for getting duration
	for one in data['videos']:
		videoPathList.append([one['processPath']])
		videoNameList.append(os.path.splitext(one['videoname'])[0]) # no appendix
		videoname2dvId[os.path.splitext(one['videoname'])[0]] = one['dvId']
		videoname2path[os.path.splitext(one['videoname'])[0]] = one['processPath']

	videoListFile = importing.makeFile(videoPathList,"%svideos.lst"%(runpath))

	#run get wav first
	importing.updateProgress(processId,0.0,"start processing, getting wav...")
	cmd = "python %s -filelst %s -desp %s -skip"%(getWav,videoListFile,runpathWav)
	runParallel(cmd,paraJob)

	#get stft
	importing.updateProgress(processId,0.1,"wav done, getting stft...")	
	cmd = "python %s -wavp %s -stftpabs %s -skip"%(getStft,runpathWav,runpathStft)
	runParallel(cmd,paraJob)

	#concatenating stft
	importing.updateProgress(processId,0.2,"stft done, getting stft_con_w%sh%s..."%(stft_con_w,stft_con_h))
	output = commands.getoutput("python %s -stftp %s -newp %s -window %s -hop %s -skip"%(stft_con,runpathStft,runpathStft_con,stft_con_w,stft_con_h))

	# assign kmeans center
	importing.updateProgress(processId,0.3,"stft con done, getting kmeans assign...")
	cmd = "python %s -featp %s -desp %s -ctr %s -bin %s -skip"%(kmeans,runpathStft_con,runpathKmeansAss,kmeanscenter,kmeansbin)
	runParallel(cmd,paraJob,showOutput=False)

	importing.updateProgress(processId,0.5,"start matching videos...")
	"""
	# matching video one by one	
	count=0
	for filename in videoNameList:
		importing.updateProgress(processId,0.4*(count/float(len(videoNameList)))+0.5,"processing %s"%filename)
		count+=1
		src = runpathKmeansAss+filename+".txt"
		if(os.path.exists(src)):
			output = commands.getoutput("python %s -seqp1 %s -seqp2 %s -t %s -rankp %s -skip"%(sequenceMatching,src,runpathKmeansAss,timeIs,runpathRankfiles))
			#print output
	"""
	cmd = "python %s -seqp1 %s -seqp2 %s -t %s -rankp %s -skip"%(sequenceMatching,runpathKmeansAss,runpathKmeansAss,timeIs,runpathRankfiles)
	runParallel(cmd,paraJob,showOutput=False)

	importing.updateProgress(processId,0.8,"getting global result...")
	output = commands.getoutput("python %s -rankp %s -desFile %s -mergeChain"%(globalSync,runpathRankfiles,globalResult))
	#print output

	importing.updateProgress(processId,0.92,"done, packing results...")
	# get ranking result
	results = {"results":{"ranklists":[],"global":[],"datasetId":datasetId}}
	for videoname in videoname2dvId.keys():
		dvId = videoname2dvId[videoname]
		temp = {}
		temp['videoname'] = videoname
		temp['dvId'] = dvId
		temp['datasetId'] = datasetId
		temp['ranklist'] = []
		for line in open(runpathRankfiles+videoname+".txt","r").readlines():
			desname,offset,score,startIndex,length = line.strip().split(",")
			if(videoname2dvId.has_key(desname)): # video might be deleted in dataset in php
				temp['ranklist'].append({"videoname":desname,"offset":offset,"score":score,"startIndex":startIndex,"length":length,"dvId":videoname2dvId[desname]})
		results["results"]['ranklists'].append(temp)
	# get global result
	temp = []
	for line in open(globalResult,"r").readlines():
		if(line.strip() == "None,None"):
			results["results"]['global'].append(temp)
			temp = []
		else:
			videoname,offset = line.strip().split(",")
			duration = getTime(getVideoDuration(videoname2path[videoname]))
			temp.append({"videoname":videoname,"dvId":videoname2dvId[videoname],"offset":float(offset),"duration":duration})

	# callback with the videoList
	importing.sendback(callback,results)

	# clean up
	os.system("rm -rf %s"%(runpath))

	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

import time
def refineER(processId,callback,ranklistpath,datasetId):
	runPath = daisy.refinePath
	mkdir(runPath)
	ranklistpath = parsePath(ranklistpath)
	globalSync = daisy.erCodePath+'globalSync.py'

	# get a not exsists name for it
	count=1
	today = time.strftime("%m_%d_%Y")
	globalResult = runPath+"_".join([ranklistpath.split("/")[-2],today,str(count)])+".txt"
	while(os.path.exists(globalResult)):
		count+=1
		globalResult = runPath+"_".join([ranklistpath.split("/")[-2],today,str(count)])+".txt"


	importing.updateProgress(processId,0.1,"refining...")
	output = commands.getoutput("python %s -rankp %s -desFile %s -mergeChain"%(globalSync,ranklistpath,globalResult))
	#print output

	importing.updateProgress(processId,0.7,"done, packing results...")
	results = {"results":{"ranklists":[],"global":[],"datasetId":datasetId,"globalResultName":os.path.splitext(os.path.basename(globalResult))[0]}}

	# get global result
	temp = []
	for line in open(globalResult,"r").readlines():
		if(line.strip() == "None,None"):
			results["results"]['global'].append(temp)
			temp = []
		else:
			videoname,offset = line.strip().split(",")
			temp.append({"videoname":videoname+".mp4","offset":float(offset)})

	# callback with the videoList
	importing.sendback(callback,results)

	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

def eventReconstructionSegmentSearch(processId,callback,videoName,start,end,datasetName,datasetId,videos,segmentId):
	sequenceMatching = daisy.erCodePath+'batchSequenceMatching.py'
	videoName = os.path.splitext(videoName)[0]
	runpath = daisy.runPath+datasetName+"/"
	runpathKmeansAss = runpath+"kmeans_ass/"
	segmentFile = runpathKmeansAss+videoName+".txt"
	#check the datasetName is in runs/ or not, if not, nothing to be done
	#print datasetName,videoName,start,end,datasetId
	if(not os.path.exists(runpath) or not os.path.exists(segmentFile)):
		importing.updateProgress(processId,1.0,"Run path not exists",-1)
		return
	#runpathWav = runpath+"wav/"
	#runpathStft = runpath+"stft/"
	#runpathStft_con = runpath+"stft_con_w%sh%s/"%(stft_con_w,stft_con_h)
	
	#runpathRankfiles = runpath+"rankfiles/"
	runpathCache = runpath+"cache/"
	runpathSegment = runpath+"segments/"+str(segmentId)+"/"
	mkdir(runpathSegment)

	videoname2dvId = {} # this is used to final identification!
	for one in videos:
		#videoPathList.append([one['processPath']])
		#videoNameList.append(os.path.splitext(one['videoname'])[0]) # no appendix
		videoname2dvId[os.path.splitext(one['videoname'])[0]] = one['dvId']

	importing.updateProgress(processId,0.2,"start searching...")
	output = commands.getoutput("python %s -seqp1 %s -seqp2 %s -sg -start %s -end %s -t %s -rankp %s -cachep %s -skip"%(sequenceMatching,segmentFile,runpathKmeansAss,start,end,timeIs,runpathSegment,runpathCache))
	print output

	importing.updateProgress(processId,0.8,"done, packing results...")

	# get ranking result
	results = {"results":[],"segmentId":segmentId,"datasetId":datasetId}
	for line in open(runpathSegment+videoName+"_%s_%s.txt"%(start,end),"r").readlines():
		desname,offset,score,startIndex,length = line.strip().split(",")
		if(videoname2dvId.has_key(desname)): # video might be deleted in dataset in php
			results['results'].append({"videoname":desname,"offset":offset,"score":score,"startIndex":startIndex,"length":length,"dvId":videoname2dvId[desname]})

	# everything done,
	importing.updateProgress(processId,1.0,"everything done!",1)

	# callback with the videoList
	importing.sendback(callback,results)

def countGunshot(processId,videoPath,start,end,desPic):
	runPath = daisy.countGunshotRunPath
	mkdir(runPath)
	script = daisy.gunshotCodePath+"watchSound.py"

	videoname = os.path.splitext(os.path.basename(videoPath))[0]

	wavfile = "%s%s_%s_%s.wav" % (runPath,videoname,start,end)
	importing.updateProgress(processId,0.1,"Preparing...")
	# extract wav first
	output = commands.getoutput("ffmpeg -i %s -y -ar 16000 -ac 1 -ss %s -to %s %s"%(videoPath,sec2time_ffmpeg(start),sec2time_ffmpeg(end),wavfile))
	#print output
	importing.updateProgress(processId,0.5,"Extracted sound wav...")

	# get pic
	#print "python %s -wav %s -pic %s"%(script,wavfile,desPic)
	#sys.exit()
	output = commands.getoutput("python %s -wav %s -pic %s"%(script,wavfile,desPic))
	#print output
	os.system("rm %s"%(wavfile))
	importing.updateProgress(processId,1.0,"Finished",1)

def getSpecImg(processId, videoPath, start, end, specPic, powerPic):
	runPath = daisy.getSpecRunPath
	mkdir(runPath)
	script = daisy.gunshotCodePath+"getSpectrogramAndPower.py"

	videoname = os.path.splitext(os.path.basename(videoPath))[0]

	wavfile = "%s%s_%s_%s.wav" % (runPath, videoname, start, end)
	importing.updateProgress(processId, 0.1, "Preparing...")
	# extract wav first
	output = commands.getoutput("ffmpeg -i %s -y -ar 48000 -ac 1 -ss %s -to %s %s"%(videoPath, sec2time_ffmpeg(start), sec2time_ffmpeg(end), wavfile))
	#print output
	importing.updateProgress(processId, 0.5, "Extracted sound wav...")

	# get pic
	#print "python %s -wav %s -pic %s"%(script,wavfile,desPic)
	#sys.exit()
	output = commands.getoutput("python %s %s %s %s"%(script, wavfile, specPic, powerPic))
	#print output
	os.system("rm %s" % (wavfile))
	importing.updateProgress(processId, 1.0, "Finished", 1)

import random
import numpy as np
# given all the info needed, compute gunshot dists using method1
def gunshotLocalizationMethod1(processId, callback, markers, datasetId, userId):
	iterations = 10000

	new_markers = []
	count_error = 0
	for i, marker in enumerate(markers):
		markerId = marker['markerId']
		time_diff_range = [float(marker['time_diff'])]
		theta_range = [float(marker['angleMin']), float(marker['angleMax'])]
		bullet_range = [float(marker['bulletSpeedMin']), float(marker['bulletSpeedMax'])]
		sound_range = [float(marker['soundSpeedMin']), float(marker['soundSpeedMax'])]
		elevation = float(marker['elevation'])

		# convert theta from degree to radian
		deg = math.pi / 180 # convert degrees to radians
		theta_range = [theta_range[0] * deg, theta_range[1] * deg]

		min_dist, max_dist, mean_dist, _ = monteCarlo_cone(time_diff_range, theta_range, bullet_range, sound_range, iterations)
		#print min_dist, max_dist, mean_dist

		# the distance has to be larger than the elevation
		# for now we just return the dist
		if (min_dist <= elevation) or (max_dist <= elevation) or (mean_dist <= elevation):
			print "warning, distance smaller than elevation, using distance..."
			count_error += 1
		if elevation > 0: # so the shooter is from higher up, so the horizontal dist should shrink
			min_dist = rightAngleTri(min_dist, elevation)
			max_dist = rightAngleTri(max_dist, elevation)
			mean_dist = rightAngleTri(mean_dist, elevation)

		marker['min_dist'] = min_dist
		marker['max_dist'] = max_dist
		marker['mean_dist'] = mean_dist

		importing.updateProgress(processId, (i+1)/float(len(markers)), "processing...")
		
		new_markers.append(marker)

	# sending back
	results = {
		"markers": new_markers, 
		"datasetId": datasetId,
		"processId": processId,
		"userId": userId
	}

	# callback with the videoList
	importing.sendback(callback, results)

	final_str = "Finished"
	if count_error > 0:
		final_str = "Finished, %s marker distance violate elevation limit." % count_error
	importing.updateProgress(processId, 1.0, final_str, 1)

def rightAngleTri(c, b):
	if(c <= b):
		return c
	return math.sqrt(c*c - b*b)

# the cone model for gunshot localization method 1
def monteCarlo_cone(time_diff_range, theta_range, bullet_range, sound_range, iterations):
	d = [] # initialize array

	for i in range(iterations):
		# select angle from estimated possible range
		theta = random.uniform(theta_range[0], theta_range[1])

		# determine if time interval is ranged or single-valued
		if len(time_diff_range) == 1:
			time_diff = time_diff_range[0]
		else:
			time_diff = random.uniform(time_diff_range[0], time_diff_range[1])
		# select value from range for bullet velocity
		vb = random.uniform(bullet_range[0], bullet_range[1])

		# assign velocity of sound
		if len(sound_range) == 1:
			vs = sound_range[0]
		else:
			vs = random.uniform(sound_range[0], sound_range[1])

		alpha = np.arcsin(vs/vb*1.0)

		# solve the system of equations piecemeal using matrix inversion
		a1 = vb - vs * np.cos(theta)
		b1 = vs*np.sin(alpha) - vs*np.cos(theta)
		c1 = vs * np.cos(theta) * time_diff
		a2 = -vs * np.sin(theta)
		b2 = -vs*np.sin(theta) + vs*np.cos(alpha)
		c2 = vs * np.sin(theta) * time_diff

		a = np.array([[a1, b1], [a2, b2]])
		b = np.array([c1, c2])

		[t1, t2] = np.linalg.solve(a, b)
		x = vs * (t1 + t2 + time_diff)

		# append to array of values
		d.append(x)

	return np.min(d), np.max(d), np.mean(d), np.std(d)

def gunshotClassification(processId,callback,videoPath,start,end,runId):
	# how many parallel job, segmentLength, shift, reranking iteration, reranking take how many portion from all top k as positive 
	job,m,n = daisy.parallelJob,3,1
	start = int(start)
	end = int(end)
	excludes = ["background"]
	# runpath for gunshot
	videoName = os.path.splitext(os.path.basename(videoPath))[0]
	runpath = daisy.gunshotRunPath + "%s_classification%s/"%(videoName,runId)
	# segmentation path
	segmentPath = runpath+"segments/"
	# sfep path # if we need to extract bof, then remove it first
	sfepPath = os.path.abspath(runpath+"sfep_mfcc/")+"/"
	sfepToolPath = daisy.sfepPath
	# bof feature path
	bofPath = runpath+"bof_efm/"
	# the model we'll use
	#modelPath = daisy.modelPath+"303+ub374+fs22k+gc2k+gn2k_20kfcvid+negselect.model"
	modellst = daisy.gunshotClassificationModellst

	# the scripts
	segmentScript = daisy.gunshotCodePath+'videoSeg.py'
	# code from /home/chunwaileong/cmu/humanrights/gunshot_videos/gunshot_classification
	detectionScript = daisy.gunshotCodePath+'eval_json.py'
	#print getVideoDuration(videoPath)
	#os.system("ffmpeg -i '%s' "%videoPath)
	duration = getTime(getVideoDuration(videoPath))
	estimation = sec2time(duration/10.0)

	# extract video part first
	mkdir(runpath)
	segvideo = os.path.join(runpath,"%s.mp4"%videoName)
	output = commands.getoutput("ffmpeg -i '%s' -y -strict -2 -ss %s -to %s '%s'"%(videoPath,sec2time_ffmpeg(start),sec2time_ffmpeg(end),segvideo))

	# step 1, segmentation
	# check segmentation path exists, exists means done
	if(not os.path.exists(segmentPath)):
		mkdir(segmentPath)
		importing.updateProgress(processId,0.01,"segmenting video...(estimated total runTime:%s)"%estimation)
		cmd = "python %s -video %s -path %s -m %s -n %s"%(segmentScript,segvideo,segmentPath,m,n)
		#print cmd
		runParallel(cmd,job)

	importing.updateProgress(processId,0.1,"segmenting done. Getting features..(estimated total runTime:%s)"%estimation)


	# get segment video lst
	output = commands.getoutput("ls %s/* > %svideo_segments.lst"%(os.path.abspath(segmentPath),runpath))

	# step 2, get mfcc bof efm
	if(not os.path.exists(bofPath)):
		mkdir(bofPath)
		# remove sfep path
		output = commands.getoutput("rm -rf %s"%sfepPath)
		# get a sfep config file
		config = "sfepdir=%s\noutputdir=%s\nvideopaths=%s/video_segments.lst\nmachine=rocks\npython27=python"%(sfepToolPath,os.path.abspath(sfepPath),os.path.abspath(runpath))
		configfile = open("%ssfep_mfcc_config.txt"%(runpath),"w")
		configfile.writelines("%s"%config)
		configfile.close()
		# generate sfep
		importing.updateProgress(processId,0.11,"generating sfep path...(estimated total runTime:%s)"%estimation)
		output = commands.getoutput("perl %sgencmds/gencmds.pl %ssfep_mfcc_config.txt"%(sfepToolPath,runpath))
		# get mfcc
		importing.updateProgress(processId,0.21,"getting mfcc...(estimated total runTime:%s)"%estimation)
		output = commands.getoutput("bash %sscripts/009_mfcc_extract.sh"%sfepPath)
		#print output
		# decompress
		output = commands.getoutput("parallel -j %s < %sscripts/011_mfcc_decompress.sh"%(job,sfepPath))
		#print output
		# bof and efm
		importing.updateProgress(processId,0.41,"getting bof and efm...(estimated total runTime:%s)"%estimation)
		#output = commands.getoutput("parallel -j %s < %sscripts/013_mfcc4k_bof_extract.sh"%(job,sfepPath))
		# move feature into bofPath
		output = commands.getoutput("bash %sscripts/013_mfcc4k_bof_extract.sh"%(sfepPath))
		output = commands.getoutput("mv %sfeatures/mfcc/mfcc4k/efm/* %s"%(sfepPath,bofPath))
		# remove sfep path
		output = commands.getoutput("rm -rf %s"%sfepPath)

	output = commands.getoutput("ls %s/* > %sbofs.lst"%(os.path.abspath(bofPath),runpath))

	# detection given the feature list and 

	output = commands.getoutput("python %s %sbofs.lst %s %sresult.json"%(detectionScript, runpath, modellst, runpath))
	print output

	with open("%sresult.json"%runpath,"r") as f:
		data = json.load(f)

	# read the final output file, and parse the result
	results = {"scores":[],"runId":runId}
	
	results['scores'] = [(classname,score) for classname,score in data[videoName] if classname not in excludes] # [(classname,score)]

	results['scores'].sort(key=operator.itemgetter(1),reverse=True)

	# callback with the videoList
	importing.sendback(callback,results)

	# everything done,
	importing.updateProgress(processId,1.0,"done!",1)

# gunshot detection. will check segment path first, will segment video first.
# then do gunshot detection, then do reranking.
# the config for reranking and detection is here. No threshold need.
# return the prediction score for each segment. segment has time info
def gunshotDetection(processId,callback,videoName,videoPath,graphPath,runId,modelId,modelpath):
	# how many parallel job, segmentLength, shift, reranking iteration, reranking take how many portion from all top k as positive 
	job,m,n,rerankIter,rerankPos,rerankNeg = daisy.parallelJob,3,1,2,0.0112,0.667,
	# runpath for gunshot
	runpath = daisy.gunshotRunPath + "%s_model%s/"%(videoName,modelId)
	# segmentation path
	segmentPath = runpath+"segments/"
	# sfep path # if we need to extract bof, then remove it first
	sfepPath = os.path.abspath(runpath+"sfep_mfcc/")+"/"
	sfepToolPath = daisy.sfepPath
	# bof feature path
	bofPath = runpath+"bof_efm/"
	# the model we'll use
	#modelPath = daisy.modelPath+"303+ub374+fs22k+gc2k+gn2k_20kfcvid+negselect.model"
	modelPath = modelpath
	# the path to save prediction graph
	graphPath = parsePath(graphPath)

	# the scripts
	segmentScript = daisy.gunshotCodePath+'videoSeg.py'
	detectionScript = daisy.gunshotCodePath+'liblinear_predict.py'
	rerankingScript = daisy.gunshotCodePath+'reranking.py'
	graphScript = daisy.gunshotCodePath+'eval_nolabel.py'
	#print getVideoDuration(videoPath)
	#os.system("ffmpeg -i '%s' "%videoPath)
	duration = getTime(getVideoDuration(videoPath))
	estimation = sec2time(duration/3.0)

	# step 1, segmentation
	# check segmentation path exists, exists means done
	if(not os.path.exists(segmentPath)):
		mkdir(segmentPath)
		importing.updateProgress(processId,0.01,"segmenting video...(estimated total runTime:%s)"%estimation)
		cmd = "python %s -video %s -path %s -m %s -n %s"%(segmentScript,videoPath,segmentPath,m,n)
		#print cmd
		runParallel(cmd,job)

	importing.updateProgress(processId,0.1,"segmenting done. Getting features..(estimated total runTime:%s)"%estimation)


	# get segment video lst
	output = commands.getoutput("ls %s/* > %svideo_segments.lst"%(os.path.abspath(segmentPath),runpath))

	# step 2, get mfcc bof efm
	if(not os.path.exists(bofPath)):
		mkdir(bofPath)
		# remove sfep path
		output = commands.getoutput("rm -rf %s"%sfepPath)
		# get a sfep config file
		config = "sfepdir=%s\noutputdir=%s\nvideopaths=%s/video_segments.lst\nmachine=rocks\npython27=python"%(sfepToolPath,os.path.abspath(sfepPath),os.path.abspath(runpath))
		configfile = open("%ssfep_mfcc_config.txt"%(runpath),"w")
		configfile.writelines("%s"%config)
		configfile.close()
		# generate sfep
		importing.updateProgress(processId,0.11,"generating sfep path...(estimated total runTime:%s)"%estimation)
		output = commands.getoutput("perl %sgencmds/gencmds.pl %ssfep_mfcc_config.txt"%(sfepToolPath,runpath))
		# get mfcc
		importing.updateProgress(processId,0.21,"getting mfcc...(estimated total runTime:%s)"%estimation)
		output = commands.getoutput("bash %sscripts/009_mfcc_extract.sh"%sfepPath)
		#print output
		# decompress
		output = commands.getoutput("parallel -j %s < %sscripts/011_mfcc_decompress.sh"%(job,sfepPath))
		#print output
		# bof and efm
		importing.updateProgress(processId,0.41,"getting bof and efm...(estimated total runTime:%s)"%estimation)
		# the following fail, 03/2019, should be because parallel bug. directly run on shell is fine
		#output = commands.getoutput("parallel -j %s -k < %sscripts/013_mfcc4k_bof_extract.sh"%(job, sfepPath))
		output = commands.getoutput("bash %sscripts/013_mfcc4k_bof_extract.sh"%(sfepPath))
		# move feature into bofPath
		output = commands.getoutput("mv %sfeatures/mfcc/mfcc4k/efm/* %s"%(sfepPath,bofPath))
		# remove sfep path
		output = commands.getoutput("rm -rf %s"%sfepPath)

	#get feature count
	featureCount = len(getFiles(bofPath,"bof"))
	#print featureCount
	topn = int(featureCount*rerankPos)
	botm = int(featureCount*rerankNeg)
	if(topn == 0):
		topn = 5

	importing.updateProgress(processId,0.5,"%s feature done! detecting...(estimated total runTime:%s)"%(featureCount,estimation))
	output = commands.getoutput("python %s -featp %s -model %s -smoothing > %stesting_output.txt"%(detectionScript,bofPath,modelPath,runpath))
	#print output
	print "reranking topn:%s,botm:%s"%(topn,botm)
	importing.updateProgress(processId,0.7,"detection done, reranking...(estimated total runTime:%s)"%estimation)
	for i in xrange(rerankIter):
		if(i == 0):
			testfile = "testing_output.txt"
		else:
			testfile = "reranking%s.txt"%(i-1)
		output = commands.getoutput("python %s -testfile %s%s -topn %s -botm %s -featp %s -smoothing > %sreranking%s.txt"%(rerankingScript,runpath,testfile,topn,botm,bofPath,runpath,i))
		#print output

	importing.updateProgress(processId,0.9,"everything done, sending back...")
	# read the final output, get a prediction graph, and copy to the website path
	cmd1 = "python %s -imgfile %s%s_reranking.png -testfile %sreranking%s.txt"%(graphScript,graphPath,runId,runpath,rerankIter-1)
	cmd2 = "python %s -imgfile %s%s_original.png -testfile %stesting_output.txt"%(graphScript,graphPath,runId,runpath)
	
	output = commands.getoutput(cmd1)
	#print output
	output = commands.getoutput(cmd2)
	#print output
	#print output,cmd

	# read the final output file, and parse the result
	results = {"scores":[],"runId":runId}
	resultType="reranking"
	for line in open("%sreranking%s.txt"%(runpath,rerankIter-1),"r").readlines():
		filename,score,_ = line.strip().split()
		stuff = os.path.splitext(filename)[0].split("_")
		start,end = getTime(stuff[-2]),getTime(stuff[-1])
		results['scores'].append({"startSec":start,"endSec":end,"score":float(score),"type":resultType})
	resultType="original"
	for line in open("%stesting_output.txt"%(runpath),"r").readlines():
		filename,score,_ = line.strip().split()
		stuff = os.path.splitext(filename)[0].split("_")
		start,end = getTime(stuff[-2]),getTime(stuff[-1])
		results['scores'].append({"startSec":start,"endSec":end,"score":float(score),"type":resultType})
	results['scores'].sort(key=operator.itemgetter("startSec"))

	# callback with the videoList
	importing.sendback(callback,results)

	# everything done,
	importing.updateProgress(processId,1.0,"done!",1)


# person detection,
# this simply send video to annother machine (if the runpath not exists)
from collections import OrderedDict

# given a video, start time and end time, will segmented and get mfcc efm, and return a filelst
def gunshotFeatureExtraction(processId,callback,videoName,videoPath,startSec,endSec,isPositive,labelId):
	job,m,n = daisy.parallelJob,3,1
	runpath = daisy.gunshotFeatureExtractionPath + "%s_%s_%s/"%(videoName,startSec,endSec)
	featureName = "%s_%s_%s"%(videoName,startSec,endSec)
	filelst = os.path.abspath(runpath+"features.lst") # the final lst to store all bof files, absolute path
	if(os.path.exists(runpath)):
		os.system("rm -rf %s"%runpath)
	# segmentation path
	segmentPath = runpath+"segments/"
	# sfep path # if we need to extract bof, then remove it first
	sfepPath = os.path.abspath(runpath+"sfep_mfcc/")+"/"
	sfepToolPath = daisy.sfepPath
	# bof feature path
	bofPath = runpath+"bof_efm/"
	
	# the scripts
	segmentScript = daisy.gunshotCodePath+'videoSeg.py'

	# step 1, segmentation

	mkdir(segmentPath)
	importing.updateProgress(processId,0.01,"segmenting video...)")
	cmd = "python %s -video %s -path %s -m %s -n %s -startSec %s -endSec %s"%(segmentScript,videoPath,segmentPath,m,n,startSec,endSec)
	#print cmd
	runParallel(cmd,job)

	importing.updateProgress(processId,0.4,"segmenting done. Getting features..")

	# get segment video lst
	output = commands.getoutput("ls %s/* > %svideo_segments.lst"%(os.path.abspath(segmentPath),runpath))

	mkdir(bofPath)
	# remove sfep path
	output = commands.getoutput("rm -rf %s"%sfepPath)
	# get a sfep config file
	config = "sfepdir=%s\noutputdir=%s\nvideopaths=%s/video_segments.lst\nmachine=rocks\npython27=python"%(sfepToolPath,os.path.abspath(sfepPath),os.path.abspath(runpath))
	configfile = open("%ssfep_mfcc_config.txt"%(runpath),"w")
	configfile.writelines("%s"%config)
	configfile.close()
	# generate sfep
	importing.updateProgress(processId,0.51,"generating sfep path...")
	output = commands.getoutput("perl %sgencmds/gencmds.pl %ssfep_mfcc_config.txt"%(sfepToolPath,runpath))
	# get mfcc
	importing.updateProgress(processId,0.61,"getting mfcc...")
	output = commands.getoutput("bash %sscripts/009_mfcc_extract.sh"%sfepPath)
	#print output
	# decompress
	output = commands.getoutput("parallel -j %s < %sscripts/011_mfcc_decompress.sh"%(job,sfepPath))
	#print output
	# bof and efm
	importing.updateProgress(processId,0.71,"getting bof and efm...")
	output = commands.getoutput("parallel -j %s < %sscripts/013_mfcc4k_bof_extract.sh"%(job,sfepPath))
	# move feature into bofPath
	output = commands.getoutput("mv %sfeatures/mfcc/mfcc4k/efm/* %s"%(sfepPath,bofPath))
	# remove sfep path
	output = commands.getoutput("rm -rf %s"%sfepPath)
	# remove video segment path
	output = commands.getoutput("rm -rf %s"%segmentPath)
	# list bof into a list
	output = commands.getoutput("ls %s/* > %s"%(os.path.abspath(bofPath),filelst))


	importing.updateProgress(processId,0.9,"sending back result...")

	results = {"labelId":labelId,"filelstpath":filelst,"featureName":featureName,"type":"gunshot","pos":isPositive}
	importing.sendback(callback,results)

	importing.updateProgress(processId,1,"done!",1)
