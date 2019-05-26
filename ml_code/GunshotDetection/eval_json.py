# coding=utf-8
# given a list of bofs, and the model lst, run the classfication and print out results


import sys,os,argparse,json,math,operator
import numpy as np

def get_args():
	parser = argparse.ArgumentParser()
	parser.add_argument("boflst") # assume the bof are chunks from longer videos
	parser.add_argument("modellst") # each line is path to model +  classname
	parser.add_argument('desfile')
	return parser.parse_args()

def sigmoid(val):
	return 1.0/(1.0+math.exp(-val))

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

def parseLS(line):
	#feat = {}
	#for one in line.strip().split(" "):
	#	idx,val = one.strip().split(":")
	#	feat[int(idx)] = float(val)
	if(line.strip() == ""):
		return {}
	return {int(one.split(":")[0]):float(one.split(":")[1]) for one in line.strip().split(" ")}

def predict(model,data):
	# data = parseLS(line) : dict feat
	return sigmoid(sum([data[dim]*model[dim] for dim in data]))
	#return sum([data[dim]*model[dim] for dim in data])

if __name__ == "__main__":
	args = get_args()

	# load all the model frist
	models = {} # model name to model

	for line in open(args.modellst,"r").readlines():
		modelpath,classname = line.strip().split()
		models[classname] = read_model(modelpath)

	print "loaded %s model"%(len(models))

	video2scores = {} # video Id -> classnames -> [score_for each segment]

	for bof in open(args.boflst):
		bof = bof.strip()
		filename = os.path.splitext(os.path.basename(bof))[0]
		videoname = filename[::-1].split("_",2)[-1][::-1]
		if not video2scores.has_key(videoname):
			video2scores[videoname] = {}

		feat = parseLS(open(bof,"r").read())
		scores = {} # classname -> score
		for classname in models:
			score = predict(models[classname],feat)
			scores[classname] = score
			if not video2scores[videoname].has_key(classname):
				video2scores[videoname][classname] = []
			video2scores[videoname][classname].append(score)


	#print "aggregated scores"
	# data will be videoname -> sorted list of scores and classname
	data = {}
	for videoname in sorted(video2scores):
		#print "\t max scores"
		max_scores = [(classname,max(video2scores[videoname][classname])) for classname in video2scores[videoname]]
		max_scores.sort(key=operator.itemgetter(1),reverse=True)
		data[videoname] = max_scores

	with open(args.desfile,"w") as f:
		json.dump(data,f)


