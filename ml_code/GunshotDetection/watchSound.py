# coding=utf-8
# given a wav and start and end, shwo the spectrum graph
import sys,os
from ChunWai import *
#from audiolab import wavread
#from audiolab import wavwrite
#from scikits.samplerate import resample # we are not using this
import numpy as np
import matplotlib
matplotlib.use('agg')
import numpy as np
import matplotlib.pyplot as plt
from scipy import signal
from scipy.io import wavfile


def usage():
	print """
		-wav
		-start
		-end
		-pic : if set , will save pic
	"""
	sys.exit()

if __name__ == "__main__":
	wav,start,end,pic = resolveParam(['-wav','-start','-end','-pic'])
	if(cp([wav])):
		usage()
	mindist = int(0.2/0.008) # shortest second a gun fire in

	#s,fs,enc = wavread(wav)
	#print np.max(s),np.min(s),fs
	fs,s = wavfile.read(wav)
	s = s/(2.**15)
	#print np.max(s),np.min(s),fs
	#sys.exit()
	#s = resample(s,16000.0/fs,'sinc_best') # no this, sox in.wav -r 16000 out.wav first
	# or use ffmpeg -ar 16000 directly
	if(fs != 16000):
		error("wav sample rate is not 16k")
	if(len(s.shape)>1):#already mono?
		s = np.mean(s,axis=1)#into mono
	spectrum = stft(s,16000,0.016,0.008) # 0.010 hop is no good
	spectrum.astype('complex64')
	spectrum = np.absolute(spectrum)
	print spectrum.shape
	if(start != ""):
		start = float(start)
		startIndex =  int(round(start/0.008))
	else:
		startIndex = 0

	if(end != ""):
		end = float(end)
		endIndex =  int(round(end/0.008))
	else:
		endIndex = -1

	#plt.matshow(spectrum[startIndex:endIndex,:].T,origin="lower")
	#plt.colorbar()
	#plt.show()

	powerM = np.sum(spectrum[:,50:],axis=1) # empircally filtered out lower frequency power
	# leave the low freq and the high freq
	#powerM = np.sum(np.hstack((spectrum[:,0:0],spectrum[:,60:])),axis=1)
	print powerM.shape

	#plt.plot(powerM[startIndex:endIndex])
	#plt.show()

	f,axarr = plt.subplots(2,sharex=True)
	
	
	from countGunshot import countGunshot,countGunshot2

	indexes = countGunshot(powerM[startIndex:endIndex], thres=0.6, min_dist=mindist)
	#print indexes #[110 356 470 554 616 661 703 730]
	#indexes = countGunshot2(powerM[startIndex:endIndex])
	# find peaks for 1-D power array
	# useless
	#indexes = signal.find_peaks_cwt(
	#	powerM[startIndex:endIndex], 
	#	np.arange(1,10)
	#)

	axarr[0].scatter(indexes,powerM[startIndex:endIndex][indexes],marker='o',color="red")
	axarr[0].plot(powerM[startIndex:endIndex])

	axarr[1].matshow(spectrum[startIndex:endIndex,:].T,origin="lower")
	#plt.xlabel("Predicted %s gunshots"%(len(indexes)))
	#plt.ylabel("Sound Power Wave")
	plt.title("Predicted %s gunshots"%(len(indexes)))
	#plt.xlim(xmin=0,xmax=powerM[startIndex:endIndex].shape[0])
	plt.tick_params(labeltop="off",labelbottom="off",labelleft="off",axis="both")

	

	if(pic != ""):
		plt.savefig(pic,bbox_inches="tight")
	else:
		plt.show()
	



