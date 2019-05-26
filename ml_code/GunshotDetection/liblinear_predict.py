# coding=utf-8
# given liblinear model(weights for each dim), read a libsvm format data file and predict
from ChunWai import *
import sys,os
"""
	solver_type L2R_L2LOSS_SVC_DUAL
	nr_class 2
	label 1 0
	nr_feature 12288
	bias -1
	w
	0.001048928798154836 
	-0.0004546355223305718 
	-0.01675315563510398 
	-0.1024440015485558 
	-0.08230433041065517 
	...
"""
def read_model(file):
	w = {}
	startLine = 0
	nr_feature = -1
	with open(file) as f:
		for line in f:
			# read some para of the model
			startLine+=1
			if(line.strip().split()[0] == "nr_feature"):
				nr_feature = int(line.strip().split()[-1])
			if(line.strip() == "w"):
				break
	count=1
	for line in open(file,"r").readlines()[startLine:]:
		w[count] = float(line.strip())
		count+=1
	assert(len(w.keys()) == nr_feature)
	return w


def predict(model,data):
	# data = parseLS(line) : dict feat
	return sigmoid(sum([data[dim]*model[dim] for dim in data]))
	#return sum([data[dim]*model[dim] for dim in data])


def usage():
	print """
		-featp
		-model
		-thres : default -0.5
		-smoothing : if set, will smooth prediction score
	"""
	sys.exit()
"""
if __name__ == "__main__":
	featfile,modelfile = resolveParam(['-feat','-model'])
	if(cp([featfile,modelfile])):
		usage()
	feat = parseLS(open(featfile,"r").read())
	model = read_model(modelfile)
	print predict(model,feat)
"""
if __name__ == "__main__":
	featp,modelfile,thres,smoothing = resolveParam(['-featp','-model','-thres'],['-smoothing'])
	if(cp([featp,modelfile])):
		usage()
	featfiles = getFiles(featp,"bof")
	if(thres == ""):
		thres = -0.5
	thres = float(thres)
	#smoothing = False # use 2 neighbour for smoothing
	model = read_model(modelfile)
	featfiles.sort()
	for i in xrange(len(featfiles)):
		filename = os.path.basename(featfiles[i])
		feat = parseLS(open(featfiles[i],"r").read())
		score = predict(model,feat)
		if(smoothing):
			scores = [score]
			for j in xrange(i-2,i+3):
				if((j<len(featfiles)) and (j>=0)):
					feat = parseLS(open(featfiles[j],"r").read())
					scores.append(predict(model,feat))
			score = sum(scores)/float(len(scores))
		if(score > thres):
			label = 1
		else:
			label=0
		print filename,score,label