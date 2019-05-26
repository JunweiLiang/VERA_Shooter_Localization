# coding=utf-8
# get hough-like transform from matching matrix
import sys,os
import numpy as np
from ChunWai import *
import warnings
warnings.filterwarnings("error")

class hough:
	def __init__(self,m,addf,keepfor): # whether to remember evidence of each diagonal. cost space
		self.addf = addf
		self.keepfor = keepfor
		self.m = m # m is a (n,m), n is the time frame for one, m is time frame for other one
		#self.k = 1 # xie lv
		#self.timeWidth = 1 # the time hist of the line

		self.minFrame = 1 # ignore line contains less frame than minFrame
		self.histCount = m.shape[0]+m.shape[1]-2*self.minFrame
		self.histVal = np.zeros(self.histCount,dtype="float") # the raw hist value. will add up timeWidth's
		self.histLength = np.zeros(self.histCount)
		self.suppress = 0 # suppress absolute hist value lower than this.tricky, it could be over 100
		self.evidence = [(-1.0,0,0) for i in xrange(self.histCount)] # the significant part in the hough transform, will fill up in countVal


	def run(self):
		#self.m = np.fliplr(self.m) # what? still has peaks?
		# caculate each line,return the highest value line's start and end in each sequence

		for i in xrange(self.histCount):
			#get a line of points to calculate value
			self.histVal[i],self.evidence[i],self.histLength[i] = self.countVal(np.diagonal(self.m,i-self.m.shape[0]+self.minFrame)) # start from the left bottom
		#return [sum(self.histVal[i:i+self.timeWidth]) for i in range(0,self.histCount,self.timeWidth)] # may be slow
		#self.histVal.resize((int(self.histCount/float(self.timeWidth)),self.timeWidth))
		#res = self.histVal.sum(axis=1) # timeWidth is not correct, should have over lap, cumulative sum a timeWidth's histVal# or a sum of neighboring histVal
		
		#res = self.histVal
		res = self.histVal/self.histLength
		res[res<self.suppress] = 0
		#norm = np.linalg.norm(res)
		#if(norm == 0):
		#	return res,-self.m.shape[0]+1
		#return res/norm,-self.m.shape[0]+1#np.argmax(res)-self.m.shape[0]+1 # the normalize hough matrix, and the offset of video1 to  video2(x axis,shape[1]),
		# how many time frame of video2 is passed before video1 is played
		return res,-self.m.shape[0]+1

	def countVal(self,arr):
		#give an arr, sum up value. for continues non-zero, add more
		# the following makes big
		#addf = 4
		#keepfor = 10 # keep accumulated addf for how many none thre one
		addf = self.addf
		keepfor = self.keepfor
		thres = 1.0

		sumVal = 0.0
		cont1,cont0,accf = 0,0,0 # continue non-zero count, continue zero count, accumulated factor
		#remember where the sumVal get the most value
		maxValTime = [-1.0,0,0] # the maxVal and the offset index,accumulated for how long

		preVal = 0.0
		for i in xrange(len(arr)):
			try:
				thisVal = arr[i] * addf**accf
			except Exception as e: #OverflowError: long int too large to convert to float
				thisVal = preVal
			preVal = thisVal # save for next error
			if(thisVal > maxValTime[0]):
				maxValTime = [thisVal,i,accf+1] # +1 , the total length of none zero
			preSum = sumVal
			try:
				sumVal+= thisVal
			except Exception as e: # over flow again
				print "warning, sum val overflow, so it stays the same"
				sumVal = preSum
			if(arr[i] > thres): # not necessary to be zero, since the matching matrix is not 0-1
				cont1+=1
				accf+=1
				cont0=0
			else:
				cont1=0
				cont0+=1
			if(cont0 > keepfor):
				accf=0

		return sumVal,maxValTime,len(arr)

if __name__ == "__main__":
	a = np.array([0,1,1,1,1,0,0,1,1,0,0,0,1,0,0,0,0])
	b = np.array([0,1,1,1,1,1,1,0,0,0,0,0,1,0,0,0,0])
	h = hough(np.zeros((20,20)))
	print h.countVal(a)
	print h.countVal(b)
	timeWidth = 2
	print a
	print [sum(a[i:i+timeWidth]) for i in range(0,len(a),timeWidth)]
	a.resize((int(len(a)/float(timeWidth)),timeWidth))
	print a.sum(axis=1)