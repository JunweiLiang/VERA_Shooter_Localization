# coding=utf-8
# wav to stft text feature files

from ChunWai import *
import sys,os
#from scikits.audiolab import wavread
#from scikits.audiolab import wavwrite
#from audiolab import wavread
#from audiolab import wavwrite
#from scikits.samplerate import resample
import numpy as np
from scipy.io import wavfile

def usage():
	print """
		-wavp
		-stftpabs
		-stftpphase save raw feature to # not used now
		-usenpsave whether to save a numpy matrix file or not, then text file
		-skip
		-job
		-curJob

		will resample at 48000Hz(16000) first, then do stft with 16 ms window,1/2 hop
		
	"""
	sys.exit()

def main():
	wavp,stftpabs,job,curJob,skip,usenpsave = resolveParam(['-wavp','-stftpabs','-job','-curJob'],['-skip','-usenpsave'])
	if(cp([wavp,stftpabs])):
		usage()
	if(job == ""):
		job = 1
	if(curJob == ""):
		curJob = 1
	job = int(job)
	curJob = int(curJob)

	mkdir(stftpabs)
	#mkdir(stftpphase)
	#stftpphase = parsePath(stftpphase)
	stftpabs = parsePath(stftpabs)
	wavp = parsePath(wavp)
	wavs = getFiles(wavp,"wav")
	count = 0
	for wav in wavs:
		filename = os.path.splitext(os.path.basename(wav))[0]
		count+=1
		if(count % 20 == 0):
			print count
		if((count % job) != (curJob-1)):
			continue
		if(skip and os.path.exists(stftpabs+filename+".txt")):
			continue
		#s,fs,enc = wavread(wav)
		fs,s = wavfile.read(wav)
		s = s/(2.**15)
		#s = resample(s,16000.0/fs,'sinc_best')
		if(fs != 16000):
			error("wav sample rate is not 16k")
		if(len(s.shape)>1):#already mono?
			s = np.mean(s,axis=1)#into mono
		spectrum = stft(s,16000,0.016,0.008) # 0.010 hop is no good
		spectrum.astype('complex64')
		spectrumabs = np.absolute(spectrum)
		#spectrumabs.astype('float32')
		if(usenpsave):
			np.save(stftpabs+filename,spectrumabs)
			#np.save(stftpphase+filename,phase)
		else:
			"""
			stftabsfile = open(stftpabs+filename+".txt","w")
			for i in range(spectrumabs.shape[0]):
				stftabsfile.writelines("%s\n" % (" ".join(["%s"%x for x in spectrumabs[i]])))
			stftabsfile.close()
			stftphasefile = open(stftpphase+filename+".txt","w")
			for i in range(phase.shape[0]):
				stftphasefile.writelines("%s\n" % (" ".join(["%s"%x for x in phase[i]])))
			stftphasefile.close()
			"""
			np.savetxt(stftpabs+filename+".txt",spectrumabs,fmt='%f',delimiter=" ",newline='\n')
			#save as float view, will read using complex view. save  space
			#np.savetxt(stftpphase+filename+".txt",spectrum.copy().view('float32'),fmt='%f',delimiter=" ",newline='\n')
main()