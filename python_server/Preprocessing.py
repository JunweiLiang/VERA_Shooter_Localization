# coding=utf-8
# given videolist, generate thumbnail and signature audio to desp, and a ranking score for them

import cv2,commands,random,sys,os
from ChunWai import *
from Daisy import Daisy

class Preprocessing(Daisy):
	def __init__(self):
		Daisy.__init__(self)

	def runOne(self,videoFile,thumbnailpath,audiopath):
		# pseudo code , now we get the first frame as thumnail and first 5 second of audio as signature, score would be 0~1 random
		video = cv2.VideoCapture(videoFile)
		countFrame = 0
		success,frame = video.read()
		while success:
			countFrame+=1
			if(countFrame == 1):
				cv2.imwrite(thumbnailpath,frame)
				break
		maxlength = getDuration(videoFile)
		# now we random pick 5 seconds from a video. in the future we get segment based on signature counts
		# use the runs directory, and with dataset name
		randomtime= sec2time(random.random()*maxlength)
		output = commands.getoutput("ffmpeg -ss %s -i %s -y -t 5 %s"%(randomtime,videoFile,audiopath))
		# return the ranking score
		return random.random() #[0,1]

def usage():
	print """
		-videopath
		-thumbnailpath
		-audiopath
	"""
	sys.exit()

if __name__ == "__main__":
	videopath,thumbnailpath,audiopath = resolveParam(['-videopath','-thumbnailpath','-audiopath'])
	if(cp([videopath,thumbnailpath,audiopath])):
		usage()
	pp = Preprocessing()
	print pp.runOne(videopath,thumbnailpath,audiopath)

