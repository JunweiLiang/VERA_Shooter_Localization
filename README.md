# DAISY - The Shooter Localization System

This repository contains the code and models for the following paper:


**[Technical Report of the DAISY System - Shooter Localization, Models, Interface, and Beyond]()** \
[Junwei Liang](https://www.cs.cmu.edu/~junweil/),
[Jay D. Aronson](https://www.cmu.edu/dietrich/history/people/faculty/aronson.html),
[Alexander Hauptmann](https://www.cs.cmu.edu/~alex/)

You can find more information/try out the shooter localization system at our [Project Page](https://daisy.cs.cmu.edu/).


If you find this system/code useful in your research/report then please cite

```

```


## Introduction
We introduce the DAISY system, enabled by established machine learning techniques and physics models, that can localize the shooter location only based on a couple of user-generated videos that capture the gunshot sound. 


<div align="center">
  <div style="">
      <img src="images/method1.png" height="200px" />
      <img src="images/method2.png" height="200px" />
  </div>
  <p style="font-weight:bold;font-size:1.2em;">
  	<a href="http://www.youtube.com/watch?feature=player_embedded&v=z0KFTXg5sqI" target="_blank">Demo Video </a>
  </p>
</div>

You can find more information/try out the shooter localization system at our [Project Page](https://daisy.cs.cmu.edu/).

## Purpose of this repository
This repository includes all the necessary code and models to host our [DAISY](https://daisy.cs.cmu.edu/) system on your local machine.
Please report issues including:
- Bugs/security concerns
- Instsallation problems
- Explanation of the code
- Additional details needed to be explained in the technical report (or even typos)
- Feature requests


## Code Overview
- `web_interface` includes all the code needed for the web interface. It is written in PHP with Yii framework (v1.3). There are some Chinese comments in the code since the code is from my earlier days as a website designer in China. File an issue if you have a question. To find the code for a URL, for example, for "..index.php/application/cGunshot?videoname=firstshots_36_mXwckuEw.mp4", the code is in web_interface/protected/controllers/ApplicationController.php and in function "actionCGunshot". The view code is in web_interface/themes/basic/views/application/cGunshot.php
- `python_server` is the backend server we designed for PHP to communicate with machine learning code, which is usually written in PYTHON with Tensorflow. Currently we use shell calls within the python server so that we could change the machine learning code on the fly without restarting the backend server.
- `ml_code` includes the inferencing code for gunshot detection, gun type classification and audio synchronization.

## Installation
Instructions for installing the system on your local machine can be [found here](INSTALL.md).

## Future Directions
1. Automatic visual synchronization of videos;
2. Automatic detection of muzzle blast sound and shockwave sound in videos;
3. Better gun type/bullet type classification to get estimation of the bullet speed range;
4. Automatic video localization - putting camera on the map.

## Other Notes
1. Method 1 code is in python_server/run.py "gunshotLocalizationMethod1".
2. Method 2 code is in web_interface/themes/basic/views/application/cMainPage.php javascript function "declare_canvas_class_method2"

