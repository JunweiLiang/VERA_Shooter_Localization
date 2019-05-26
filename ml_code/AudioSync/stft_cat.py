# coding=utf-8
# cancatenate stft frame by n to get new feature, and a sliding window

import sys,os
from ChunWai import *

def usage():
	print """
		-stftp
		-newp
		-window how many points to cat, the new dim will be 129*n
		-hop how many points to slide , 
		-skip
		-append[csv] after con, will be txt.
	"""
	sys.exit()

if __name__ == "__main__":
	stftp,newp,window,hop,append,skip = resolveParam(['-stftp','-newp','-window','-hop','-append'],['-skip'])
	if(cp([stftp,newp,window,hop])):
		usage()
	if(append == ""):
		append="txt"
	stftp = parsePath(stftp)
	newp = parsePath(newp)
	window = int(window)
	hop = int(hop)
	mkdir(newp)
	stfts = getFiles(stftp,append)
	print "total stft:%s" % len(stfts)
	countFile = 0
	for stft in stfts:
		countFile+=1
		if(countFile % 30 == 0):
			print countFile
		filename = os.path.splitext(os.path.basename(stft))[0]
		if(skip and os.path.exists(newp+filename+"."+append)):
			print "skipping %s"%(newp+filename+"."+append)
			continue
		# go through the file and get a window of data 
		# and write on the fly
		#fw = open(newp+filename+"."+append,"w")
		fw = open(newp+filename+".txt","w")
		count = 0
		lineCaches = [] # memorize multi window
		with open(stft,"r") as f:
			for line in f:
				count+=1
				# a window should start
				if((count-1) % hop == 0):
					lineCaches.append([])
				#remember line for all current active window
				for i in xrange(len(lineCaches)):
					lineCaches[i].append(line.strip())
				# a window is ended
				if((count >= window) and ((count-window) % hop == 0)):
					# writing the earlies window
					fw.writelines("%s\n" % (" ".join(lineCaches[0])))
					del lineCaches[0]
		del lineCaches
		fw.close()
				

		
