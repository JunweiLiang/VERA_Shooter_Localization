# coding=utf-8
# given a wav file path, output a spectrum image
# cannot output the full wav, since it is too large
import sys, os, argparse
import numpy as np
import matplotlib
matplotlib.use('agg')
import numpy as np
import matplotlib.pyplot as plt
from scipy import signal
from scipy.io import wavfile
import scipy
from ChunWai import sec2time

parser = argparse.ArgumentParser()
parser.add_argument("wavfile")
parser.add_argument("specoutfile")
parser.add_argument("poweroutfile")
parser.add_argument("--start", default=0.0, type=float, help="start in seconds")
parser.add_argument("--end", default=-1, type=float, help="end in seconds, -1 means all")

def stft(x, fs, framesz, hop):
	# modified from http://stackoverflow.com/questions/2459295/invertible-stft-and-istft-in-python
	framesamp = int(framesz*fs) #this is the STFT feature dimension
	hopsamp = int(hop*fs)
	w = scipy.hanning(framesamp)
	X = scipy.array([scipy.fft(w*x[i:i+framesamp]) 
					 for i in range(0, len(x)-framesamp, hopsamp)])
	return X[:,:framesamp/2+1] # chop redundant part

if __name__ == "__main__":
	args = parser.parse_args()

	win = 0.004
	hop = 0.001
	startIndex = int(round(args.start/hop))
	if args.end == -1:
		endIndex = -1
	else:
		endIndex = int(round(args.end/hop))

	fs, s = wavfile.read(args.wavfile)

	print "wav file length %s, data point %s, sample rate %s" % (sec2time(len(s)/float(fs)), len(s), fs)

	s = s/(2.**15)

	if len(s.shape) > 1: #already mono?
		s = np.mean(s, axis=1) #into mono
	spectrum = stft(s, fs, win, hop)
	spectrum.astype('complex64')
	abs_spectrum = np.absolute(spectrum)[startIndex:endIndex, :]
	spectrum = np.log(abs_spectrum)
	print "spectrum shape %s, each point means %s sec, so total length in time is %s" % (list(spectrum.shape), hop, sec2time(spectrum.shape[0]*hop))

	spectrum = spectrum.T # transpose for showing image

	# save the spectrum image
	width = float(spectrum.shape[1])
	height = float(spectrum.shape[0])
	fig = plt.figure()
	fig.set_size_inches(width/height, 1, forward=False)
	ax = plt.Axes(fig, [0., 0., 1., 1.])
	ax.set_axis_off()
	fig.add_axes(ax)

	ax.matshow(spectrum, origin="lower")
	plt.savefig(args.specoutfile, dpi=height)

	# save the power image
	plt.clf()

	powerM = np.sum(abs_spectrum, axis=1)
	import matplotlib as mpl
	mpl.rcParams['savefig.pad_inches'] = 0
	fig = plt.figure(figsize=None)
	ax = plt.axes([0, 0, 1, 1], frameon=False)
	ax.get_xaxis().set_visible(False)
	ax.get_yaxis().set_visible(False)
	ax.set_xlim(xmin=0, xmax=width)

	plt.autoscale(tight=True)
	plt.plot(powerM, linewidth=0.5)
	plt.savefig(args.poweroutfile, dpi=300)
