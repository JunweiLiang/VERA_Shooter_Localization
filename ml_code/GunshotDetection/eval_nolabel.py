# coding=utf-8
# given downloaded annotation file from videoAnno(rename the filename first), the test file is filename+score+label, then compute the AP and precision and recall
# annotation will be transform first based on over-half overlapping of each filename(start and end time provided).
from ChunWai import *
import os,sys

def usage():
	print """
		-testfile
		-imgfile # if set, will save the plot to a img
	"""
	sys.exit()


def getOverlap(s,e,sc,ec):
	if((sc>e) or (s>ec)):
		return None
	elif((s<=ec) and (s>=sc)):
		if(e>=ec):
			return (s,ec)
		else:
			return (s,e)
	elif(s<sc):
		if(e>=ec):
			return (sc,ec)
		else:
			return (sc,e)
	else:
		error("wtf2")

def getTime(timestr):
	hour,minutes,sec = timestr.strip().split(":")
	return float(hour)*60.0*60.0+float(minutes)*60.0+float(sec)

if __name__ == "__main__":
	testfile,imgfile = resolveParam(['-testfile','-imgfile'])
	if(cp([testfile])):
		usage()
	scores = {}
	count = {}
	for line in open(testfile,"r").readlines():
		videoname,score,label = line.strip().split()
		label = int(label)
		stuff = os.path.splitext(videoname)[0].split("_")
		filename,start,end = "_".join(stuff[:-2]),stuff[-2],stuff[-1]
		if(not scores.has_key(filename)):
			scores[filename] = []
		scores[filename].append({"score":float(score),"mylabel":label,"start":start,"end":end})

	import matplotlib
	matplotlib.use('agg')
	import numpy as np
	import matplotlib.pyplot as plt

	for filename in scores:
		scores[filename].sort(key=operator.itemgetter("start"),reverse=False)
	

		# assume a timestamp is 1 second
		timestamps = [0.05,0.1,0.3,0.5,0.7,0.9,1.0] # xticks
		timestamps = [one*len(scores[filename]) for one in timestamps]
		plt.xticks(timestamps,[sec2time(one) for one in timestamps],rotation=50)

		plt.ylim(ymin=-0.05,ymax=1)
		plt.xlabel("Video Time")
		plt.ylabel("Prediction Score")

		plot_handles = []
		thisScores = np.array([one['score'] for one in scores[filename]])
		thisTimesteps = np.array(range(len(scores[filename])))
		a1, = plt.plot(thisTimesteps,thisScores,'b-',label="prediction")

		plot_handles.extend([a1])
		plt.legend(handles=plot_handles,loc='upper right')
		if(imgfile != ''):
			plt.savefig(imgfile,bbox_inches="tight")
		else:
			plt.show()




