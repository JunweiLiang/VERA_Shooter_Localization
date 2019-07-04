## Dependencies
These are the dependencies I know so far. Please file an issue if you discover new ones.
+ Python 2.7; ffmpeg; sox; scipy; parallel

## Step 1. Download the additional stuff, example videos
```
$ cd scripts/; bash download_data_model.sh
```

## Step 2. Setting up the web server
1. Install XAMPP 5.5 using the run file in additional_software/
2. Import the initial database (web_interface/initial.sql) into new MySQL database called "VERA_Shooter_Localization"
3. Add localhost database user with username "vera" and "mysqlpassword", or change web_interface/protected/config/main.php with your username and password
4. Add your google map api key to the url at about line 1140 web_interface/themes/basic/views/application/cMainPage.php
5. Correct some folder permissions:
```
$ cd web_interface/; chmod -R 755 assets/; mkdir protected/runtime; chmod 777 protected/runtime
```
5. Move the web interface to the Apache Server document path:
```
$ mv web_interface/ /home/yourusername/htdocs/VERA_Shooter_Localization
```
6. Change all videos' "processPath" in database table D_videos to the correct absolute paths like "..htdocs/VERA_Shooter_Localization/assets/uploadFiles/232bb443e7dde01b96a36c1bf8fc12e9/..mp4". You can do it through the phpmyadmin web interface. (We keep the original copy of the uploaded videos in assets/uploadFiles/{unique_link_for_each_user} and a lower resolution version in assets/videos/ for faster streaming)
7. Change database table D_models gunshot detection model "modelpath" to the correct absolute path (..python_server/modelTraining/Updata_20161011_gunshot/Updata_20161011.model)

 

## Step 3. Setting up the backend PYTHON server
1. Install liblinear using the package in additional_software/
```
liblinear-2.30$ make
liblinear-2.30/python$ make
```
2. Change the liblinear python path in ml_code/GunshotDetection/reranking.py
3. Install our audio feature pipeline, possible dependencies:
```
$ sudo apt install libtcl8.5
$ sudo apt-get install default-jre
$ cp additional_software/sfep_mfcc/mfcc/dot_janusrc ~/.janusrc
```
4. List the gun type classification model
```
$ cd python_server/
$ find gunshot_classification_noisy_only_model/ -name "*.linear" | while read line;do modelname=$(basename $(dirname $line)); echo $line $modelname;done > gunshot_classification.noisy_only.model.lst
```
5. Change python_server/Data.py "http" to "https" if your URL has https
6. Change python_server/Daisy.py "sfepPath" (additional_software/sfep_mfcc), "erCodePath" (ml_code/AudioSync), "gunshotCodePath" (ml_code/GunshotDetection/) to correct absolute paths.
7. Change the safety key in Daisy.py "safety" and it should be the same as in web_interface/protected/extensions/f.php "ppythonMD5key"

## Step 4. Testing
1. Start the PYTHON server. I would use "screen -R" so you could record the output and then:
```
$ python php_python.py
```
2. Open a browser (we only tested Chrome) and [log in to the test account](http://127.0.0.1/VERA_Shooter_Localization/index.php/site/login?redirect=):
username: demo
password: 123456

3. After logged in, the Las Vegas Shooting collection should be loaded. Scroll down and click "Get Map & Save Event Info", and then click "Analyze Gunshot Location", then you should see the visualization in Google Map interface.

4. Test the PYTHON server function. Click "Mark Gunshot" under "firstshots_burst1_muiHkkbPpdU" and then click "Gunshot Detection". Then click "Gunshot Type Classification".

5. If you want to add more accounts, log in with account "admin"/"123456". Click "userManager" and then don't select "Super Manager"/"User Manager" and select "Demo User". Then enter the username and click "Add User".
