# Download k-means centers, and other stuff

mkdir -p additional_software

wget https://daisy.cs.cmu.edu/assets/additional_stuff/liblinear-2.30.zip -O additional_software/liblinear-2.30.zip
wget https://daisy.cs.cmu.edu/assets/additional_stuff/selected_stftabs_w100h50_0.4.txt.cluster_centres -O additional_software/selected_stftabs_w100h50_0.4.txt.cluster_centres
wget https://daisy.cs.cmu.edu/assets/additional_stuff/sfep_mfcc.tgz -O additional_software/sfep_mfcc.tgz
wget https://daisy.cs.cmu.edu/assets/additional_stuff/xampp-linux-x64-5.5.34-0-installer.run -O additional_software/xampp-linux-x64-5.5.34-0-installer.run
wget https://daisy.cs.cmu.edu/assets/additional_stuff/assets.tgz -O additional_software/assets.tgz

cd additional_software/

unzip liblinear-2.30.zip
tar -zxvf sfep_mfcc.tgz
# the example videos 
tar -zxvf assets.tgz
mv assets/ ../web_interface

# clean up
rm -rf assets.tgz liblinear-2.30.zip sfep_mfcc.tgz

cd ../