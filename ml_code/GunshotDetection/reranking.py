# coding=utf-8
# given testfile, rank the score, get top n and bottom m, train a reranking model, and appy to featp , get new testfile
	
import os,sys
from ChunWai import *
try:
	from liblinear import *
	from liblinearutil import save_model
except Exception as e:
	sys.path.append("/home/junweil/Tools/liblinear-2.30/python/")
	from liblinear import *
	from liblinearutil import save_model


def usage():
	print """
		-testfile
		-topn
		-botm
		-featp 
		-thres [default -0.5]
		-smoothing [if set, will smooth predict score]
		-oriposlst [if set, will add to reranking]
		-orineglst
		-rerankingmodel : if set, will save the reranking model
	"""
	sys.exit()

def trainmodel(poslst,neglst):
	#print "training with %s pos,%sneg"%(len(poslst),len(neglst))
	param = parameter("-s 1 -c 1 -q")
	# get the file to a dict
	labellst,featurelst = [],[]
	for one in poslst:
		labellst.append(1)
		featurelst.append(parseLS(open(one,"r").read()))
	for one in neglst:
		labellst.append(-1)
		featurelst.append(parseLS(open(one,"r").read()))
	prob = problem(labellst,featurelst)
	m = toPyModel(liblinear.train(prob,param))
	#save_model("test.model",m)
	return m

def predict_this(model,data):
	return sigmoid(sum([data[dim]*model[dim-1] for dim in data]))
	#return sum([data[dim]*model[dim-1] for dim in data])

if __name__ == "__main__":
	testfile,topn,botm,featp,oripos,orineg,thres,rerankingmodelf,smoothing = resolveParam(['-testfile','-topn','-botm','-featp','-oriposlst','-orineglst','-thres','-rerankingmodel'],['-smoothing'])
	if(cp([testfile,topn,botm,featp])):
		usage()
	topn,botm = int(topn),int(botm)
	if(thres == ""):
		thres = -0.5
	thres = float(thres)
	featp = parsePath(featp)
	scores = []
	for line in open(testfile,"r").readlines():
		filename,score,label = line.strip().split()
		scores.append((filename,float(score)))
	scores.sort(key=operator.itemgetter(1),reverse=True)
	# binary weigting , CPRF
	poslst = ["%s%s"%(featp,one[0]) for one in scores[:topn]]
	neglst = ["%s%s"%(featp,one[0]) for one in scores[-botm:]]
	if(oripos != ""):
		poslst.extend([line.strip() for line in open(oripos,"r").readlines()])
	if(orineg != ""):
		neglst.extend([line.strip() for line in open(orineg,"r").readlines()])
	rerankingmodel = trainmodel(poslst,neglst)
	if(rerankingmodelf != ""):
		save_model(rerankingmodelf,rerankingmodel)
	#print rerankingmodel.get_decfun()[0][:5] # len() 12288
	model = rerankingmodel.get_decfun()[0]
	#thres = -0.7
	featfiles = getFiles(featp,"bof")
	featfiles.sort()
	for i in xrange(len(featfiles)):
		filename = os.path.basename(featfiles[i])
		feat = parseLS(open(featfiles[i],"r").read())
		score = predict_this(model,feat)
		if(smoothing):
			scores = [score]
			for j in xrange(i-2,i+3):
				if((j<len(featfiles)) and (j>=0)):
					feat = parseLS(open(featfiles[j],"r").read())
					scores.append(predict_this(model,feat))
			score = sum(scores)/float(len(scores))
		if(score > thres):
			label = 1
		else:
			label=0
		print filename,score,label
