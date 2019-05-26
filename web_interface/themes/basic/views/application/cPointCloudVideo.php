<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		"#cIndex > input.gotoDatasetList",
	),//点击头导航的发生的事件
	//"targetName" => "#cIndex > #projectList > input.project",
	"targetChange" => array(
	//	"#cIndex > #projectList > input.project",//新建了项目后就获取新项目列表
	//	"#cIndex > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#cIndex > #project > input.projectId",
		"targetProjectName" => "#cIndex > #project > input.projectName",
		"targetProjectIntro" => "#cIndex > #project > input.projectIntro",
		"targetChangeP" => array(
			"#cIndex > #project > input.projectId",//点击了项目后载入项目内容 
			"#cIndex > input.toProject",//点击了项目后显示项目部件 
		),
)); ?>
<style type="text/css">
#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cHtml3d{
		background-color:white;
		width:1400px;
		margin:0px auto;
		min-height:800px;
	}
	#cHtml3d input{margin:0px}
	#cHtml3d > div.main > div.mainControls{
		padding:10px 0;
	}
	#cHtml3d > div.main > div.mainControls > div.videoControl{
		border-top:1px silver solid;
		margin-bottom:20px;
	}
	#cHtml3d > div.main > div.mainControls > div.videoControl > div.block{
		text-align:center;
		border-left:5px green solid;
		border-bottom:4px silver solid;
		border-top:1px silver solid;
		border-right:1px silver solid;
		padding-top:5px;
		margin-bottom:10px;
	}
	#cHtml3d > div.main > div.mainControls > div.videoControl > div.block > video{
		width:100%;
	}
	#cHtml3d > div.main > div.mainControls > div.videoControl > div.block > div.controls{
		display:none;
	}
	div.main > div.mainControls > div.videoControl > div.block > div.controls > i{cursor:pointer}


	
</style>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/three.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/stats.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/dat.gui.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/OrbitControls.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/PLYLoader.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/ImageUtils.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/popcorn-complete.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/tween.min.js"></script>
<!-- just for draggable -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script>

function getVideoTexture(url)
{
	var temp = {};
	// create the video element
	temp.video	= document.createElement('video');
	temp.video.width	= 320;
	temp.video.height	= 200;
	temp.video.autoplay	= false;
	temp.video.loop	= false;
	temp.video.src	= url;

	// create the texture
	var texture	= new THREE.Texture( temp.video );
	// expose texture as this.texture
	temp.texture = texture;
	temp.texture.minFilter = THREE.LinearFilter;

	temp.update	= function(){
		if( temp.video.readyState !== temp.video.HAVE_ENOUGH_DATA )	return;
		texture.needsUpdate	= true;		
	}

	temp.destroy = function(){
		temp.video.pause()
	}
	return temp;
}
function getVideoname(url)
{
   var base = new String(url).substring(url.lastIndexOf('/') + 1); 
	if(base.lastIndexOf(".") != -1)	   
		base = base.substring(0, base.lastIndexOf("."));
   return base;
}
// return a group of human shape, its 0,0,0 is the feet
function makePerson(color,personId,pathToImg)
{
	var radius=0.2,cheight=1.0; // this cheight+2*radius should be the person average height (after scaleFactor)
	var cylinderGeo = new THREE.CylinderGeometry( radius, radius, cheight, 10 );
	var cylinderMat = new THREE.MeshBasicMaterial({wireframe:true,color: color});
	var cylinder = new THREE.Mesh( cylinderGeo, cylinderMat);
	cylinder.position.set(0,cheight/2,0);


	//put a sphere on top of the cylinder
	var sphereGeo = new THREE.SphereGeometry( radius, 10, 10 );
	var sphereMat = new THREE.MeshBasicMaterial( {wireframe:true,color: color} );
	var sphere = new THREE.Mesh( sphereGeo, sphereMat );
	sphere.position.set(0,cheight+radius,0);

	// add a plane on infront and put the person pic on it
	//console.log(pathToImg);
	var imgTexture = new THREE.TextureLoader().load(pathToImg);
	imgTexture.minFilter = THREE.LinearFilter;
	imgTexture.repeat.set(1,1);
	var imgMaterial = new THREE.MeshBasicMaterial({
		map : imgTexture
	});
	var noneMaterial = new THREE.MeshBasicMaterial({color:color});
	var materials = [ 
		noneMaterial,
		noneMaterial,
		noneMaterial,
		noneMaterial,
		imgMaterial, // this is the back of that face
		noneMaterial // this is the face for cube when using lookAt(point)
	 ];

	var cubeGeometry = new THREE.BoxGeometry(2*radius, cheight+2*radius, radius/4);
	var cube = new THREE.Mesh( cubeGeometry, new THREE.MultiMaterial(materials));
	cube.position.set(0,(cheight+2*radius)/2,radius);//

	var group = new THREE.Object3D();
	group.up = new THREE.Vector3(0,0,1);// important to keep the video correct
	group.add(cylinder);
	group.add(sphere);
	group.add(cube);
	group.name = personId;
	return group;
}
// return a cube with the video and a cone
// var [group,video] = makeVideoGroup(url);
function makeVideoGroup(videoUrl,color)
{
	var videoname = getVideoname(videoUrl);
	// make 2D text material for the cube, for videoname
	var canvasText = document.createElement("canvas");
	var context1 = canvasText.getContext("2d");
	context1.fillStyle="black";
	context1.fillRect(0,0,canvasText.width,canvasText.height);
	context1.font = "Bold 20px Arial";
	context1.fillStyle = "rgba(255,0,0,1.0)";
	context1.fillText(videoname,0,80);// y has to be 50 as the font size?
	var textTexture = new THREE.Texture(canvasText);
	textTexture.needsUpdate = true;
	textTexture.minFilter = THREE.LinearFilter;
	var textMaterial = new THREE.MeshBasicMaterial({map:textTexture,side:THREE.DoubleSide});
	textMaterial.transparent = false;

	// the video material
	var videoTexture = getVideoTexture(videoUrl);
	var cubeMaterial = new THREE.MeshBasicMaterial({
		map : videoTexture.texture
	});

	// the other side of the cube
	var noneMaterial = new THREE.MeshBasicMaterial({color:color});
	var materials = [ 
		noneMaterial,
		noneMaterial,
		noneMaterial,
		noneMaterial,
		textMaterial, // this is the back of that face
		cubeMaterial // this is the face for cube when using lookAt(point)
	 ];

	// width, height, depth
	var cubeGeometry = new THREE.BoxGeometry(2, 1.25, 0.4,1,1,1);
	var cube = new THREE.Mesh( cubeGeometry, new THREE.MultiMaterial(materials));

	cube.position.set(0,0,0);
	// for degree (0-360)
	//cube.rotation.set(degree*(Math.PI/180), 0, 0);	
	//rotate the Z so when the group lookAt, the TV is correct angle

	
	
	// radius, height, faces
	var cgeometry = new THREE.ConeGeometry( 12, 20, 20 );// radius can be changed independtly
	var cmaterial = new THREE.MeshBasicMaterial( {color: "silver"} );
	cmaterial.transparent = true;
	cmaterial.opacity = 0.05;
	var cone = new THREE.Mesh( cgeometry, cmaterial );
	cone.position.set(0,0,10);// the last position has to be half of the height
	cone.rotateX(270 * (Math.PI/180));

	var group = new THREE.Object3D();
	group.up = new THREE.Vector3(0,0,1);// important to keep the video correct

		// add cube number 2 as a projection
		var noneMaterial2 = new THREE.MeshBasicMaterial({color:color,"transparent":true,"opacity":0.0});
		var cubeMaterial2 = new THREE.MeshBasicMaterial({
			map : videoTexture.texture,
			"transparent":true,
			"opacity":0.4,
		});
		var m = [ 
			noneMaterial2,
			noneMaterial2,
			noneMaterial2,
			noneMaterial2,
			noneMaterial2, // this is the back of that face
			cubeMaterial2 // this is the face for cube when using lookAt(point)
		 ];
		var cube2 = new THREE.Mesh( new THREE.BoxGeometry(24, 15, 0.2,1,1,1), new THREE.MultiMaterial(m));
		cube2.position.set(0,0,20);// the height of the cone
		cube2.name = "projectCube";
		group.add(cube2);

	
	group.add(cube);
	group.add(cone);
	group.name = videoname;
	return [group,videoTexture]; // return the videoTexture so that we can update it, and control the video outside
}


function createBackgroundTexture(width, height){

	function gauss(x, y){
		return (1 / (2 * Math.PI)) * Math.exp( - (x*x + y*y) / 2);
	};

	var map = THREE.ImageUtils.generateDataTexture( width, height, new THREE.Color() );
	map.magFilter = THREE.NearestFilter;
	var data = map.image.data;

	//var data = new Uint8Array(width*height*4);
	var chroma = [1, 1.5, 1.7];
	var max = gauss(0, 0);

	for(var x = 0; x < width; x++){
		for(var y = 0; y < height; y++){
			var u = 2 * (x / width) - 1;
			var v = 2 * (y / height) - 1;
			
			var i = x + width*y;
			var d = gauss(2*u, 2*v) / max;
			var r = (Math.random() + Math.random() + Math.random()) / 3;
			r = (d * 0.5 + 0.5) * r * 0.03;
			r = r * 0.4;
			
			//d = Math.pow(d, 0.6);
			
			data[3*i+0] = 255 * (d / 15 + 0.05 + r) * chroma[0];
			data[3*i+1] = 255 * (d / 15 + 0.05 + r) * chroma[1];
			data[3*i+2] = 255 * (d / 15 + 0.05 + r) * chroma[2];
			
			//data[4*i+3] = 255;
		
		}
	}
	
	return map;
};
var timeTol = 0.0001;// this is the time Tolenrence for comparing the current time with video time
// also the cameraParam smaller than this timeTol will be ignored
function parseCameraParam(cameraParamStr)// the whole file as a str
{
	var data = new Array();
	var lines = cameraParamStr.split("\n");
	var lastTime = null;// remember current time for ignoring the camera param too close to the last one
	var lastThing = null;// last valid points
	var skipped = 0;
	for(var i=0;i<lines.length;++i)
	{
		if($.trim(lines[i]) == "")
		{
			continue;
		}
		var things = lines[i].split(" ");
		if(things.length != 8)
		{
			console.log("warning, param file format not right, line:"+i);
			continue;
		}
		var videoTime = parseFloat(things[7])
		if(lastTime==null)
		{
			lastTime = videoTime;
		}
		else
		{
			// check the current videotime with the last time
			var curTime = videoTime;
			if(Math.abs(curTime - lastTime) < timeTol)
			{
				continue;
			}
			else
			{
				lastTime = curTime;
			}
		}
		var cam_x=parseFloat(things[0]);
		var cam_y=parseFloat(things[1]);
		var cam_z=parseFloat(things[2]);
		var cam_look_x=parseFloat(things[3])+parseFloat(things[0]);
		var cam_look_y=parseFloat(things[4])+parseFloat(things[1]);
		var cam_look_z=parseFloat(things[5])+parseFloat(things[2]);
		<?php if($camSmooth){ ?>
		// for smoothing
		if(lastThing == null)
		{
			lastThing = [
				cam_x,// cam_x
				cam_y,//y
				cam_z,
				cam_look_x,
				cam_look_y,
				cam_look_z,
				videoTime
			];
		}
		else
		{
			var timeDiff = videoTime - lastThing[6];		
			var cam_pos_dist = calDist(lastThing[0],lastThing[1],lastThing[2],cam_x,cam_y,cam_z)/timeDiff;
			var cam_look_dist = calDist(lastThing[3],lastThing[4],lastThing[5],cam_look_x,cam_look_y,cam_look_z)/timeDiff;
			//console.log([cam_pos_dist,cam_look_dist,videoTime]);
			lastThing = [
				cam_x,// cam_x
				cam_y,//y
				cam_z,
				cam_look_x,
				cam_look_y,
				cam_look_z,
				videoTime
			];
			// before scaleFactor
			if((cam_pos_dist > 0.2) || (cam_look_dist > 0.2))
			{
				skipped+=1;
				continue;
			}
		}
		<?php } ?>
		data.push([
			cam_x,// cam_x
			cam_y,//y
			cam_z,
			cam_look_x,
			cam_look_y,
			cam_look_z,
			videoTime,// videoTime in seconds
		]);
	}
	/*
	// assuming the original file is sorted based on time
	data.sort(function(a,b){
		if (a[6] < b[6]) return -1;
		   if (a[6] > b[6]) return 1;
		   return 0;
	});*/
	//console.log(data.length);
	<?php if($camSmooth){ ?>
	console.log("camSmoothing, orignal data points:"+(data.length+skipped)+",skipped:"+skipped);
	<?php } ?>
	return data;
}
function calDist(x1,y1,z1,x2,y2,z2)
{
	return (x1-x2)*(x1-x2)+(y1-y2)*(y1-y2)+(z1-z2)*(z1-z2);
}
function getCameraPos(paramList,currentTime)
{
	// assuming the paramList is sorted,
	// paramlist is array of 7 (cam_xyz,cam_look_xyz,videoTime)
	// first check smallest and largest
	if(currentTime <= paramList[0][6])
	{
		return [paramList[0][6],[
				paramList[0][0],
				paramList[0][1],
				paramList[0][2],
				paramList[0][3],
				paramList[0][4],
				paramList[0][5]
		]];
	}
	var last = paramList.length-1;
	if(currentTime > paramList[last][6])
	{
		return [paramList[last][6],[
				paramList[last][0],
				paramList[last][1],
				paramList[last][2],
				paramList[last][3],
				paramList[last][4],
				paramList[last][5]
		]];
	}

	for(var i=0;i<paramList.length-1;++i)// not the last one
	{
		// when it is close to that one
		if((currentTime > paramList[i][6]) && (currentTime <= paramList[i+1][6]))
		{
			return [paramList[i+1][6],[
				paramList[i+1][0],
				paramList[i+1][1],
				paramList[i+1][2],
				paramList[i+1][3],
				paramList[i+1][4],
				paramList[i+1][5]
			]];
		}
	}
	return [null,null];
}
// assuming the tracking is sorted timestamp ASC
function parseTracking(cameraParamStr)// the whole file as a str
{
	// return the point list and videotime for each person
	//timestamp	person_id	x	y	z
	var data = {};
	var lines = cameraParamStr.split("\n");
	var loaded =0;
	for(var i=0;i<lines.length;++i)
	{
		if($.trim(lines[i]) == "")
		{
			continue;
		}
		var things = lines[i].split(" ");
		if(things.length != 5)
		{
			console.log("warning, param file format not right, line:"+i);
			continue;
		}

		var personId=things[1],timestamp=parseFloat(things[0]),x=parseFloat(things[2]),y=parseFloat(things[3]),z=parseFloat(things[4]);
		

		if(data[personId] == null)
			data[personId] = {"posList":new Array(),"lastTarget":null};

		// check whether the time interval is too small, then discard it
		if(data[personId]['posList'][data[personId].length-1] != null)
		{
			if(Math.abs(timestamp - data[personId]['posList'][data[personId].length-1][3]) < timeTol)
			{
				continue;
			}
		}

		data[personId]['posList'].push([
			x,y,z,timestamp
		]);
		loaded++;
	}
	/*
	// assuming the original file is sorted based on time
	data.sort(function(a,b){
		if (a[6] < b[6]) return -1;
		   if (a[6] > b[6]) return 1;
		   return 0;
	});*/
	//console.log(data);
	//console.log(loaded);
	return data;
}
function getTrackingPos(paramList,currentTime)
{
	// assuming the paramList is sorted,
	// paramlist is array of 4 (xyz,videoTime)
	// first check smallest and largest
	// this will return null as the position, since we won't show the position
	// return (videoTime, newPos, lastPos)
	if(currentTime <= paramList[0][3])
	{
		return [paramList[0][3],null,null];
	}
	var last = paramList.length-1;
	if(currentTime > paramList[last][3])
	{
		return [paramList[last][3],null,null];
	}

	for(var i=0;i<paramList.length-1;++i)// not the last one
	{
		// when it is close to that one
		if((currentTime > paramList[i][3]) && (currentTime <= paramList[i+1][3]))
		{
			return [paramList[i+1][3],[
				paramList[i+1][0],
				paramList[i+1][1],
				paramList[i+1][2],
			],[
				paramList[i][0],
				paramList[i][1],
				paramList[i][2],
			]];
		}
	}
	return [null,null,null];
}
// plugin for globaltime to add video at a time
(function (Popcorn) {
  
  Popcorn.plugin( "setupVideo", {

	  start: function( event, options ) {
	  	// now the video should be played, 
	  	// video object is in the options
		  var timediff = options.globalTimeline.currentTime() - options.video.offset;
		  options.video.pp.currentTime(timediff);
		  //options.vid.showVid();
		  if (!options.globalTimeline.media.paused) {
			options.video.pp.play();
		  }
	  },
	 
	  end: function( event, options ) {
		var timediff = options.globalTimeline.currentTime() - options.video.offset;
		// console.log(timediff);
		
		if (timediff < 0) {
		  options.video.pp.pause(0);
		} else if (options.globalTimeline.currentTime() > options.video.offset) {
		  options.video.pp.pause(options.video.pp.duration());
		}
	  }
  });

})( Popcorn );
// set up the 3d thing
var personColors = ["red","azure","yellow","navy","white","orange","gray","silver","purple", "turquoise", "chocolate",  "coral","ivory", "gold","green","blue"];
function init()
{
	// camera as global for mouse click
	var camera = null;
	var raycaster = null; // global, so that in draw() loop it can be updated
	var mouse = null;
	var scene = null;
	var scaleFactor = 10;// all cordinates scale to this for easier navigation
	var videos = {};// video dictionary for global event [videoname => {}]
	
	var colors = ["red","azure","yellow","navy","white","orange","gray","silver","purple", "turquoise", "chocolate",  "coral","ivory", "gold","green","blue"];
	
	var trackingVideoPerson2img = {};
	var winHeight = $("#webgl").height();
	var winWidth = $("#webgl").width();
	raycaster = new THREE.Raycaster();// for selecting thing
	scene = new THREE.Scene();
	// (field of view,aspect ratio,near, far) // closer to near or further to far won't be randered
	// fov is 0 -360, 60 is normal
	camera = new THREE.PerspectiveCamera(80,winWidth/winHeight,0.01,1000);

	// ------------------------------------------for the background ----------------------------------
	var texture = createBackgroundTexture(512, 512);
		
	texture.minFilter = texture.magFilter = THREE.LinearFilter;
	
	var bg = new THREE.Mesh(
		new THREE.PlaneBufferGeometry(2, 2, 0),
		new THREE.MeshBasicMaterial({
			map: texture
		})
	);
	//bg.position.z = -1;
	bg.material.depthTest = false;
	bg.material.depthWrite = false;
	var sceneBG = new THREE.Scene();
	sceneBG.add(bg);
	var backgroundCamera = new THREE.Camera();
	//-----------------------------------------------------------------------------------------

	var renderer = new THREE.WebGLRenderer();
	//renderer.setClearColor(new THREE.Color("silver"));
	renderer.setSize(winWidth,winHeight);
	renderer.autoClear = false; // we need to render both background and foreground scene

	// add a axis thing
	//var axes = new THREE.AxisHelper( 2 );
	//scene.add(axes);

	// load the point cloud!
	var plyLoaded = false;
	var loader = new THREE.PLYLoader();
	loader.load("<?php echo Yii::app()->baseUrl."/".$plyPath?>",
		// onLoad 
		function(geometry){
			// geometry has position, color
			//console.log(geometry.attributes.color);//{uuid: "0539B2BF-1596-43F2-A644-B32602AD51EC", array: Float32Array[108513], itemSize: 3, count: 36171, normalized: false…}
			//console.log(geometry.attributes.color.count); //36171
			//console.log(geometry.attributes.color.array.length); //108513

			var material = new THREE.PointsMaterial({ vertexColors: true, size: 0.1 });
			var mesh = new THREE.Points(geometry, material);//its position is 0,0,0
			mesh.scale.set(scaleFactor,scaleFactor,scaleFactor);
			scene.add(mesh);
			if(plyLoaded == false)//that means the progress cannot get it
			{
				$("#loadProgress").hide();
				// when the ply loaded, check video loaded or not
				plyLoaded = true;
				if(plyLoaded && (readies == videoCount))
				{
					setupTimeline();
				}
				
			}
		},
		//onprogress
		function ( event ) { //XMLHttpRequestProgressEvent {isTrusted: true, position: 3774, totalSize: 2296551, lengthComputable: true, loaded: 3774…}bubbles: falsecancelBubble: falsecancelable: falsecurrentTarget: XMLHttpRequestdefaultPrevented: falseeventPhase: 0isTrusted: trueisTrusted: truelengthComputable: trueloaded: 3774path: Array[0]position: 3774returnValue: truesrcElement: XMLHttpRequesttarget: XMLHttpRequesttimeStamp: 827.5500000000001total: 2296551totalSize: 2296551type: "progress"__proto__: ProgressEvent undefined undefined
		  // console.log( event ); 
			//put the loading progress to a progress bar
			if(event.lengthComputable == false)
			{
				var progress = 100;
			}
			else
			{
				var loaded = event.loaded/event.total;
				var progress = parseFloat(loaded)*100;
			}
			//console.log(progress);
			progress = progress.toFixed(3) + "%";
			$("#loadProgress").children("div.bar").width(progress).html(progress);
			if(event.loaded== event.total)
			{
				$("#loadProgress").hide();
				// when the ply loaded, check video loaded or not
				plyLoaded = true;
				if(plyLoaded && (readies == videoCount))
				{
					setupTimeline();
				}
				
			}
		},
		function(){}//onError
	);
	
	var readies = 0;
	var videoCount = <?php echo count($videos)?>;
	function readyVideo()
	{
		// when a video is "canplaythrough", this will be called
		//console.log($(this)); // this is a popcorn object
		readies+=1;
		if((readies == videoCount) && plyLoaded)
		{

			// now we have the duration and offset, we can setup the control timeline
			setupTimeline();
		}
	};

	var globalTimeline = null;
	var fulldur = 0.0;// the full duration of all videos (and some more)
	function setupTimeline()
	{
		//console.log("video loaded, start setting up timeline");
		// get the full duration of the global timeline
		for(var videoname in videos)
		{
			var video = videos[videoname].video;
			var offset = videos[videoname].offset;
			var extend = video.duration + offset+1.0;
			if(extend > fulldur)
			{
				fulldur = extend;
			}
			//remove some event listeners
			//console.log(videos[videoname].pp.duration());
			videos[videoname].pp.off("canplaythrough");
			// only show the fist video
			if(offset != 0.0)
			{
				var videogroup = scene.getObjectByName(videoname);
				if(videogroup!=null)
				{
					videogroup.visible = false;
				}
			}
		}
		//console.log(fulldur);
		// make a null video wrapper as the global timeline
		var glpp = Popcorn.HTMLNullVideoElement("#videoTimeline");
		glpp.src = "#t=,"+fulldur;
		globalTimeline = Popcorn(glpp);
		globalTimeline.currentTime(0);

		// make the block in the timeline, add video to timeline trigger event
		for(var videoname in videos)
		{
			var video = videos[videoname];
			var temp = $("<div class='block'>"+
				"<div class='video' title="+videoname+"></div>"+
			"</div>");
			temp.children("div.video").css({
				"width":video.pp.duration()/fulldur * 100+"%",
				"left":video.offset/fulldur * 100+ "%",
				"backgroundColor":video.color,
			});
			//console.log(video.video.duration);
			$("#videoTimeline > div.videos").append(temp);
			//set up timeupdate listener for each  video for fixing deplay
			video.pp.on("timeupdate",function(){
				var delay = (globalTimeline.currentTime() - (this.offset + this.currentTime()));
				if (!globalTimeline.media.paused && (Math.abs(delay) > 1.5)) { // bigger than seconds
					this.currentTime(globalTimeline.currentTime() - this.offset);
				}
				
			});
			// set up an popcorn event for each video 
			globalTimeline.setupVideo({
				"start":video.offset,
				"end":video.offset+video.pp.duration(),
				"globalTimeline":globalTimeline,
				"video":video,
			});
		}

		// setup event for playing the global timeline and not

		globalTimeline.on("play",function(){
			// toggle playback button
			$("#playGlobal").hide();
			$("#pauseGlobal").show();
			// check each video whether they should play
			for(var videoname in videos)
			{
				var video = videos[videoname];
				var duration = video.pp.duration();
				var offset = video.offset;
				// >= because 0 and 0
				if((globalTimeline.currentTime() >= offset) && (globalTimeline.currentTime() < offset+duration))
				{
					video.pp.play();
				}
			}
		});

		globalTimeline.on("pause",function(){
			$("#playGlobal").show();
			$("#pauseGlobal").hide();
			for(var videoname in videos)
			{
				var video = videos[videoname];
				video.pp.pause(globalTimeline.currentTime() - video.offset);
				//video.video.pause();
			}
		});


		//adjust the playback pin
		globalTimeline.on("timeupdate",function(){
			if (this.currentTime() > fulldur - 0.5) {
				this.pause(fulldur - 0.5);
			}
			var pct = this.currentTime() / fulldur * 100;
			$("#timeNow").html(cw.sec2time(this.currentTime()));
			$("#timePos").css("left",pct+"%");
			$("#timeNow").css("left",pct+"%");
			// check all video and see whether they should be visible
			// if the current global time is not in the with in this video, hide it
			for(var videoname in videos)
			{
				var videogroup = scene.getObjectByName(videoname);
				var video = videos[videoname];
				if(videogroup!=null)
				{
					if((globalTimeline.currentTime() < video.offset) || (globalTimeline.currentTime() > video.offset+video.pp.duration()))
					{
						videogroup.visible = false;
					}
					else
					{
						videogroup.visible = true;
					}
				}
			}
		});

		// bind the play and pasu button
		cw.ec("#playGlobal",function(){
			if(globalTimeline.currentTime() < fulldur)
			{
				globalTimeline.play();
			}
		});
		cw.ec("#pauseGlobal",function(){
			globalTimeline.pause();
		});
		// bind the space for pressing play or pause
		// or seek
		
		$(window).keypress(function(e){
			var tag = e.target.tagName.toLowerCase();
			if((tag != "input") && (tag != "textarea"))
			{
				if((e.charCode === 32) || (e.keyCode === 0) || (e.keyCode === 32))
				{
					e.preventDefault();
					//console.log("space "+(new Date()));
					// check should be play or not
					if($("#playGlobal").is(":visible"))
					{
						$("#playGlobal").trigger(cw.ectype);
					}
					else
					{
						$("#pauseGlobal").trigger(cw.ectype);
					}

				}		
				else if((e.keyCode === 44) || (e.keyCode === 46))
				{
					// use < and > for seeking
					$("#videoTimeline").trigger({
						"type":"seek",
						"goLeft":(e.keyCode === 44),
						"go":0.01,
					});
				}
			}
		});

		//setup events for draging the playback pin
		var resume = false;// whether to resume after drag
		$("#timePos").draggable({
			"containment": "#videoTimeline",
			"axis": "x",
			"start": function (event, ui) {		
				if (globalTimeline.media.paused) {
					resume = false;
				}
				else
				{
					resume = true;
				}
				//console.log(resume);
				globalTimeline.pause();
			},
			"drag": function (event, ui) {
				//console.log(ui.position.left);
				$("#timeNow").css({
					left: ui.position.left
				});
				var pct = ui.position.left / $('#videoTimeline').width();
				$("#timeNow").html(cw.sec2time(fulldur * pct));
			},
			"stop": function (event, ui) {
				var pct = $("#timePos").position().left / $('#videoTimeline').width();
				globalTimeline.currentTime(fulldur * pct);
				if (resume) {
					globalTimeline.play();
				} else {
					// each video seek to here
					for(var videoname in videos)
					{
						var video = videos[videoname];
						video.pp.pause(globalTimeline.currentTime() - video.offset);
					}
				}

			}
		});
		// click the time to seek
		cw.ec("#videoTimeline",function(e){
			console.log("this");
			var clickleft = e.pageX - $('#videoTimeline').offset().left;
			var pct = clickleft / $('#videoTimeline').width();
			seekGlobal(pct);
		});
		$("#videoTimeline").on("seek",function(e){
			var curPct = globalTimeline.currentTime()/fulldur;
			var addOrMinusPct = e.go;
			if(e.goLeft)
			{
				seekGlobal(curPct-addOrMinusPct);
			}
			else
			{
				seekGlobal(curPct+addOrMinusPct);
			}
		});
		function seekGlobal(pct)
		{
			pct = pct<0?0.0:pct;
			pct = pct>1?1.0:pct;
			globalTimeline.currentTime(fulldur * pct);
			if (globalTimeline.media.paused) {
				for(var videoname in videos)
				{
					videos[videoname].pp.currentTime(globalTimeline.currentTime() - videos[videoname].offset);
				}
			}
		}
	}

	<?php foreach($videos as $i=>$video){ ?>
		// now we add a video into the point cloud space
			// we add the video to a cube, and a cone
		var color = colors.pop();
		var [group,videoTexture] = makeVideoGroup("<?php echo Yii::app()->baseUrl."/".$video['videoUrl']?>",color);

		// set the video position (camera position) // initial position
		var cameraPos = [<?php echo $video['initialParam']['cam_x']?>, <?php echo $video['initialParam']['cam_y']?>, <?php echo $video['initialParam']['cam_z']?>];
		var cameraLook = [<?php echo $video['initialParam']['cam_look_x']?>,<?php echo $video['initialParam']['cam_look_y']?>,<?php echo $video['initialParam']['cam_look_z']?>];

		group.position.set(cameraPos[0]*scaleFactor,cameraPos[1]*scaleFactor,cameraPos[2]*scaleFactor);
		// set the video lookat (angle)
		group.lookAt(new THREE.Vector3(cameraLook[0]*scaleFactor,cameraLook[1]*scaleFactor,cameraLook[2]*scaleFactor));

		scene.add(group);
		// add the control domElement into the panel
		var temp = $('<div class="block">'+
				'<input class="videoname" type="hidden" value="<?php echo $video['videoname']?>"></input>'+
				"<?php echo $i+1;?>.<?php echo $video['videoname']?>: <div class='btn btn-small follow'>follow</div> "+
				'<div class="controls"> <div class="btn btn-small btn-info play">Play</div> '+
					'<div class="btn btn-small btn-info pause">Pause</div> '+
					"[<span class='curTime'></span>]"+
					'<br/> <div class="btn btn-small reset">Restart</div> '+
					'<div class="btn btn-small jump">JumpTo</div> '+
					'<input style="width:40px" class="input-small to" type="text" placeholder="second"></input> <i class="icon-eye-open showIt"></i> <i class="icon-eye-close hideIt"></i>'+
				"</div> "+
				"<span class='info text-warning'>Loading camera params...</span> "+
		'</div>');
		temp.css({"borderLeftColor":color});
		temp.append(videoTexture.video);
		$("div.main > div.mainControls > div.videoControl").append(temp);

		// show the playing time
		$(videoTexture.video).on("timeupdate",function(){
			var videoname = getVideoname(this.src);
			$("div.main > div.mainControls > div.videoControl > div.block > input[value='"+videoname+"']").parent().find("div.controls > span.curTime").html(this.currentTime.toFixed(2)+"/"+this.duration+"(s)");
		});	

		// for controlling the video
		videos["<?php echo $video['videoname']?>"] = {
			"video":videoTexture.video,
			"offset":<?php echo isset($video['offset'])?$video['offset']:0.0;?>,
			"videoTexture":videoTexture,
			"paramLoaded":false,// we will use ajax to get the camera param for this video
			"params":null, // list with videotime and camerapos //array of 7 each line

			"lastTarget":null,//the last camera param, including the target videoTime

			"lastLookAt":null,// the last time the video lookAt,since we cant get from 3D object (this is not the camera param, since we move a little every time)

			// the rest is for the tracking thing
			"trackingLoaded":false,
			"tracking":null,
			"pp":Popcorn(videoTexture.video),
			"color":color,
		};
		videos["<?php echo $video['videoname']?>"].pp.on("canplaythrough",readyVideo);
		// for use in event
		videos["<?php echo $video['videoname']?>"].pp.offset = <?php echo isset($video['offset'])?$video['offset']:0.0;?>;
		videos["<?php echo $video['videoname']?>"].pp.videoname = "<?php echo $video['videoname']?>";

		// start to load the video param
		$.get("<?php echo Yii::app()->baseUrl."/".$video['cameraParamFile']?>",function(data){
			var videoname = "<?php echo $video['videoname']?>";
			videos[videoname]["params"] = parseCameraParam(data);
			videos[videoname]['paramLoaded'] = true;
			$("div.main > div.mainControls > div.videoControl > div.block > input[value='"+videoname+"']").parent().children("span.info").html("");
		});
		// for tracking person's image => id=>imgPath, load in parseTracking
		
		// load the tracking video param 
		<?php if(isset($video['trackingFile'])){ ?>
		$.get("<?php echo Yii::app()->baseUrl."/".$video['trackingFile']?>",function(data){
			var videoname = "<?php echo $video['videoname']?>";
			trackingVideoPerson2img[videoname] = {};
			videos[videoname]["tracking"] = parseTracking(data,"<?php echo $video['trackingImagePath']?>");
			// go through each person and add their img path
			// write the img path
			for(var personId in videos[videoname]["tracking"])
			{
				trackingVideoPerson2img[videoname][personId] = "<?php echo Yii::app()->baseUrl."/".$video['trackingImagePath']?>/"+personId+".jpg";
			}
			//console.log(trackingVideoPerson2img);
			videos[videoname]['trackingLoaded'] = true;
		});
		<?php } ?>
	<?php } ?>
	// hide or show all the project
	cw.ec("div.main > div.mainControls > div.quickLink > div.showProjection",function(){
		for(var videoname in videos)
		{
			// hide the project or show the projrect for all the video
			var videogroup = scene.getObjectByName(videoname);
			if(videogroup != null)
			{
				var projection = videogroup.getObjectByName("projectCube");
				//console.log(projection);
				if(projection != null)
				{
					projection.visible = true;
				}
			}
		}
	});
	cw.ec("div.main > div.mainControls > div.quickLink > div.hideProjection",function(){
		for(var videoname in videos)
		{
			// hide the project or show the projrect for all the video
			var videogroup = scene.getObjectByName(videoname);
			if(videogroup != null)
			{
				var projection = videogroup.getObjectByName("projectCube");
				if(projection != null)
				{
					projection.visible = false;
				}
			}
		}
	});
	// follow the video!
	var lastCameraPos = null;
	var lastControlTarget = null;
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.follow",function(){
		if($(this).hasClass("following"))
		{
			$(this).removeClass("following").removeClass("btn-danger").html("follow");
			var videoname = $(this).parent().children("input.videoname").val();
			var videogroup = scene.getObjectByName(videoname);		
			if(videogroup!=null)
			{
				videogroup.remove(camera);
			}
			// put everything back
			if(lastCameraPos == null)
			{
				camera.position.set(initialCameraPos.x,initialCameraPos.y,initialCameraPos.z);
		
				ocontrols.target.set(initialControlTarget.x,initialControlTarget.y,initialControlTarget.z);// has to update here, not the camera
			}
			else
			{
				camera.position.set(lastCameraPos.x,lastCameraPos.y,lastCameraPos.z);
		
				ocontrols.target.set(lastControlTarget.x,lastControlTarget.y,lastControlTarget.z);// has to update here, not the camera
			}
			ocontrols.update();

		}
		else
		{
			$("div.main > div.mainControls > div.videoControl > div.block > div.follow").removeClass("following").removeClass("btn-danger").html("follow");
			$(this).addClass("following").addClass("btn-danger").html("following");
			// pop the camera out from other place
			for(var videoname in videos)
			{
				group = scene.getObjectByName(videoname);
				if(group != null)
				{
					group.remove(camera);
				}
			}
			var videoname = $(this).parent().children("input.videoname").val();
			var videogroup = scene.getObjectByName(videoname);		
			if(videogroup!=null)
			{
				// save the current camera and control target
				lastCameraPos = camera.position.clone();
				lastControlTarget = ocontrols.target.clone();

				videogroup.add(camera);
				camera.position.set(0.0854, 2.0514, -3.0810);
				ocontrols.target.set(0.0871, 0.3194, 18.0535);
				ocontrols.update();
			}
		}
	});
	// these are the individual control
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > div.play",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		videos[videoname].video.play();
		// also show the video
		var videogroup = scene.getObjectByName(videoname);		
		if(videogroup!=null)
		{
			videogroup.visible = true;
		}
	});
	// hide the video
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > i.hideIt",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		var videogroup = scene.getObjectByName(videoname);		
		if(videogroup!=null)
		{
			videogroup.visible = false;
		}
	});
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > i.showIt",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		var videogroup = scene.getObjectByName(videoname);		
		if(videogroup!=null)
		{
			videogroup.visible = true;
		}
	});
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > div.reset",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		videos[videoname].video.currentTime = 0.0;
		// also changing the video pos into null as initialized
		videos[videoname]['lastTarget'] = null;
	});
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > div.pause",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		videos[videoname].video.pause();
	});
	cw.ec("div.main > div.mainControls > div.videoControl > div.block > div.controls > div.jump",function(){
		var videoname = $(this).parent().parent().children("input.videoname").val();
		var toTime = parseFloat($(this).parent().children("input.to").val());
		if(!isNaN(toTime))
		{
			videos[videoname].video.currentTime = toTime;
			
			//reset the pos
			videos[videoname]['lastTarget'] = null;

		}
		
	});


	// camera
	
	camera.up = new THREE.Vector3( 0, 0, 1 );// in the ply, the up axis is z, while three.js default is y
	//camera.rotation.order = 'ZYX'; // what for? from potree

	// add thing to the DOM
	$("#webgl").append(renderer.domElement);

	// a stat monitoring the performance
	var stats = new Stats();
	stats.showPanel(0); // 0: fps, 1: ms, 2: mb, 3+: custom
	stats.domElement.style.position = 'relative'; // default absolute
	stats.domElement.style.left = '0px';
	stats.domElement.style.top = '0px';
	$("#stats").append(stats.dom);

	// mouse control of the scene
	var ocontrols = new THREE.OrbitControls(camera, renderer.domElement);
	ocontrols.keyPanSpeed = 20.0;
	ocontrols.enableZoom = false;

	// add a user interface to let user change the js variable for animation
	var controls = {
		"cameraChange":0,
		"sign":1,
	};
	var gui = new dat.GUI({autoPlace:false});
	gui.add(controls,"cameraChange",0,10);
	gui.domElement.id = 'data.gui.control';
	$("#guiControl").append(gui.domElement);

	// control moving in the 3d space
	$(document).keydown(function(e){
		//bind key for moving 3D space
		if((e.keyCode === 38) || (e.keyCode === 40))
		{
			var direction = camera.getWorldDirection();
			// move how much
			var step = 0.3;
			var go = direction.multiplyScalar(step);
			if(e.keyCode === 38)
			{
				camera.position.add(go);
				ocontrols.target.add(go);
			}
			else
			{
				camera.position.sub(go);
				ocontrols.target.sub(go);
			}
			ocontrols.update();
			e.preventDefault();
		}
	});

	// get the current camera localtion and the orbit target
	cw.ec("div.main > div.moreControls > div.getCameraPos",function(){
		$("div.main > div.moreControls > input.cameraPos").val(camera.position.x.toFixed(4)+", "+camera.position.y.toFixed(4)+", "+camera.position.z.toFixed(4)+",orbit target:"+ocontrols.target.x.toFixed(4)+", "+ocontrols.target.y.toFixed(4)+", "+ocontrols.target.z.toFixed(4)+" camera rotation: "+camera.rotation.x.toFixed(4)+", "+camera.rotation.y.toFixed(4)+", "+camera.rotation.z.toFixed(4));
	});

	// set the event control for click things in the 3D space
	cw.ec("#webgl",function(e){
		var winHeight = $("#webgl").height();
		var winWidth = $("#webgl").width();
		var offsetTop = $("#webgl").offset().top;
		var offsetLeft = $("#webgl").offset().left;
		//pageX, pageY, screenX, screenY, clientX and clientY
		var normx = e.pageX - offsetLeft;
		var normy = e.pageY - offsetTop;
		//console.log(normx+" "+ normy); // this hsould be x y in the canvas window;
		mouse = new THREE.Vector2();
		mouse.x = (normx/winWidth)*2-1;
		mouse.y = -(normy/winHeight)*2+1;

		raycaster.setFromCamera(mouse,camera);
		var intersects = raycaster.intersectObjects(scene.children,true);// true is needed for grouped object
		//[ { distance, point, face, faceIndex, indices, object }, ... ]
		// the first one should be the target
		// point is a Vector3

		if(intersects.length > 0)
		{
			var selected = intersects[0]; // the closest one to the camera
			//console.log(selected.object.name);
			$("div.main > div.moreControls > input.clickPoint").val(selected.point.x.toFixed(4)+", "+selected.point.y.toFixed(4)+", "+selected.point.z.toFixed(4));
			/*
			var geometry = new THREE.SphereGeometry(0.2, 20, 20, 0, Math.PI * 2, 0, Math.PI * 2);
			var material = new THREE.MeshNormalMaterial();
			var ball = new THREE.Mesh(geometry, material);
			
			ball.position.copy( selected.point );
			
			scene.add( ball );
			*/

		}
		else
		{
			$("div.main > div.moreControls > input.clickPoint").val("");
		}

	});
	// bind kind for going foward or backward

	$(document).delegate("#webgl","dblclick",function(e){
		var winHeight = $("#webgl").height();
		var winWidth = $("#webgl").width();
		var offsetTop = $("#webgl").offset().top;
		var offsetLeft = $("#webgl").offset().left;
		//pageX, pageY, screenX, screenY, clientX and clientY
		var normx = e.pageX - offsetLeft;
		var normy = e.pageY - offsetTop;
		//console.log(normx+" "+ normy); // this hsould be x y in the canvas window;
		mouse = new THREE.Vector2();
		mouse.x = (normx/winWidth)*2-1;
		mouse.y = -(normy/winHeight)*2+1;

		raycaster.setFromCamera(mouse,camera);
		var intersects = raycaster.intersectObjects(scene.children,true);// true is needed for grouped object
		//[ { distance, point, face, faceIndex, indices, object }, ... ]
		// the first one should be the target
		// point is a Vector3

		if(intersects.length > 0)
		{
			var I = intersects[0].point; // the closest one to the camera
			// this is the distance between camera and you orbit, so when fly to the point you won;t be exactly at the point but a step back
			var camTargetDistance = camera.position.distanceTo(ocontrols.target);
			
			var vector = new THREE.Vector3( mouse.x, mouse.y, 0.5 );
			vector.unproject(camera);

			var direction = vector.sub(camera.position).normalize();
			var ray = new THREE.Ray(camera.position, direction);
			
			
			var targetRadius = Math.min(camTargetDistance, 5);
			
			var d = camera.getWorldDirection().multiplyScalar(-1);
			var cameraTargetPosition = new THREE.Vector3().addVectors(I, d.multiplyScalar(targetRadius));
			var controlsTargetPosition = I;
			
		
			var animationDuration = 600;
			
			var easing = TWEEN.Easing.Quartic.Out;
			
			ocontrols.enabled = false;
			
			// animate position
			var tween = new TWEEN.Tween(camera.position).to(cameraTargetPosition, animationDuration);
			tween.easing(easing);
			tween.start();
			
			// animate target
			var tween = new TWEEN.Tween(ocontrols.target).to(I, animationDuration);
			tween.easing(easing);
			tween.onComplete(function(){
				ocontrols.enabled = true;
				
			});
			tween.start();
		}
		else
		{
			
		}

	});
	

	// set the initial looking point and direction
	var initialCameraPos = new THREE.Vector3(25.7847, -6.5853, 14.1481);
	var initialControlTarget = new THREE.Vector3(23.1854, -6.1001, 13.4477);
	camera.position.set(initialCameraPos.x,initialCameraPos.y,initialCameraPos.z);
	//camera.rotation.set( 0.9114, -0.9240, -0.5539);
	//camera.lookAt(new THREE.Vector3( 55.4319, 13.1690, 50.4633)); // used the "last click point"
	
	ocontrols.target.set(initialControlTarget.x,initialControlTarget.y,initialControlTarget.z);// has to update here, not the camera
	ocontrols.update();

	//var refreshStep = 0.02;// in seconds //0.02 is about 60fps // now we estimate this based on fps
	var preTime = new Date();

	function draw()
	{
		stats.begin();
		
		camera.position.x += controls.sign*controls.cameraChange;
		if((camera.position.x > 100) || (camera.position.x < -100))
		{
			//console.log(camera.position.x);
			controls.sign = -controls.sign;
		}
		// estimating the fpsnow
		var nowTime = new Date();
		var fps = 1000/(nowTime - preTime);
		fps = isFinite(fps)?fps:60.0;
		preTime = nowTime;
		var refreshStep = 1.0/fps;
		TWEEN.update();

		// update the video!
		// the video position and the tracking
		for(var videoname in videos)
		{
			videos[videoname]['videoTexture'].update();
			var video = videos[videoname].video;
			var curVideoTime = video.currentTime;
			
			if(videos[videoname]['paramLoaded']) // now that we have all the camera position
			{	
				// check if the video is paused
				if((curVideoTime <= 0) || (video.paused) || (video.ended))
				{
					continue;
				}

				// check through the list to get the correct position
					// a array of 6 [cam_xyz,cam_look_xyz]
				//return the target pos based on curVideoTime <= targetVideoTime
				var [targetVideoTime,newPos] = getCameraPos(videos[videoname]['params'],curVideoTime);

				var lastTargetVideoTime = null;
				if(videos[videoname]['lastTarget'] != null)
					lastTargetVideoTime = videos[videoname]['lastTarget'][6];

				if(newPos == null)
				{
					console.log("camera pos not found. cur video time:"+curVideoTime);
				}
				else if(targetVideoTime < curVideoTime)
				{
					// could be the video have used all available camera param
				}
				else
				{
					var group = scene.getObjectByName(videoname);
					if(group == null)
					{
						console.log("error,group not found in scene:"+videoname);
					}
					else
					{
						
						// initial
						if(videos[videoname]['lastTarget'] == null)
						{
							videos[videoname]['lastTarget'] = [newPos[0]*scaleFactor,newPos[1]*scaleFactor,newPos[2]*scaleFactor,newPos[3]*scaleFactor,newPos[4]*scaleFactor,newPos[5]*scaleFactor,targetVideoTime];
						}


						if(targetVideoTime == lastTargetVideoTime)
						{
							// the target is the same as last time, then we still moving to it
							var timeDiff = targetVideoTime - curVideoTime;
							var stepToFinish = parseInt(timeDiff/refreshStep); 
							// we divide the current point to the target point(both camera pos and lookAt) into steps
							if(stepToFinish <= 1)
							{
								//do nothing
								
							}
							else
							{			
								// camera pos
								//var [posStepX,posStepY,posStepZ] = [(newPos[0]*scaleFactor - group.position.x)/stepToFinish,(newPos[1]*scaleFactor - group.position.y)/stepToFinish,(newPos[2]*scaleFactor - group.position.z)/stepToFinish];
								var [posStepX,posStepY,posStepZ] = [(videos[videoname]['lastTarget'][0] - group.position.x)/stepToFinish,(videos[videoname]['lastTarget'][1] - group.position.y)/stepToFinish,(videos[videoname]['lastTarget'][2] - group.position.z)/stepToFinish];
								group.position.set(group.position.x+posStepX,group.position.y+posStepY,group.position.z+posStepZ);

								// lookAt point 
									// we need last LookAt since you can't get this in 3D object
								var lastLookAt = videos[videoname]['lastLookAt'];
								var [newLookX,newLookY,newLookZ] = [
									lastLookAt[0]+(videos[videoname]['lastTarget'][3] - lastLookAt[0])/stepToFinish,
									lastLookAt[1]+(videos[videoname]['lastTarget'][4] - lastLookAt[1])/stepToFinish,
									lastLookAt[2]+(videos[videoname]['lastTarget'][5] - lastLookAt[2])/stepToFinish
								];
								group.lookAt(new THREE.Vector3(newLookX,newLookY,newLookZ));

								//lookAt needs to remember
								videos[videoname]['lastLookAt'] = [newLookX,newLookY,newLookZ];	
							}
						}else
						{
							// now the target is not the old target, we will jump to the old target, and start going to the new target in the next loop
								//1. the camera pos
							group.position.set(videos[videoname]['lastTarget'][0],videos[videoname]['lastTarget'][1],videos[videoname]['lastTarget'][2]);
								//2. the lookAt.
							group.lookAt(new THREE.Vector3(videos[videoname]['lastTarget'][3],videos[videoname]['lastTarget'][4],videos[videoname]['lastTarget'][5]));

							videos[videoname]['lastLookAt'] = [videos[videoname]['lastTarget'][3],videos[videoname]['lastTarget'][4],videos[videoname]['lastTarget'][5]];
							// the lastTarget is the currect target now.
							videos[videoname]['lastTarget'] = [newPos[0]*scaleFactor,newPos[1]*scaleFactor,newPos[2]*scaleFactor,newPos[3]*scaleFactor,newPos[4]*scaleFactor,newPos[5]*scaleFactor,targetVideoTime];
						}
					}
				}
			}
			// the tracking thing
			if(videos[videoname]['trackingLoaded'])
			{
				// go though each person
				var videogroup = scene.getObjectByName(videoname); // the video
				for(var personId in videos[videoname]['tracking'])
				{
					var personObjectId = "person"+personId;
					var [targetVideoTime,newPos,lastPos] = getTrackingPos(videos[videoname]['tracking'][personId]['posList'],curVideoTime);

					// get the last target 
					var lastTarget = videos[videoname]['tracking'][personId]['lastTarget'];
					var lastTargetVideoTime = null;
					if(lastTarget != null)
						lastTargetVideoTime = lastTarget[3];

					var person = scene.getObjectByName(personObjectId);
					// the video is during earlier than first person pos and last pos
					if(newPos == null)
					{
						// clean the person existsed
						if(person != null)
						{
							person.visible = false;
						}
					}
					else
					{
						// the video time is inside where the person is present

						// initial
						if(lastTarget == null)
						{
							videos[videoname]['tracking'][personId]['lastTarget'] = [newPos[0]*scaleFactor,newPos[1]*scaleFactor,newPos[2]*scaleFactor,targetVideoTime];
							lastTarget = videos[videoname]['tracking'][personId]['lastTarget'];
						}
						if(person == null) // make the person object the first time
						{
							person = makePerson(personColors.pop(),personObjectId,trackingVideoPerson2img[videoname][personId]);
							person.position.set(lastPos[0]*scaleFactor,lastPos[1]*scaleFactor,lastPos[2]*scaleFactor); // initial position is the first person position
							person.lookAt(new THREE.Vector3(videogroup.position.x,videogroup.position.y,person.position.z));
							scene.add(person);
						}
						else
						{
							person.visible = true;
						}
						
						if(targetVideoTime == lastTargetVideoTime)
						{
							// the target is the same as last time, then we still moving to it
							var timeDiff = targetVideoTime - curVideoTime;
							var stepToFinish = parseInt(timeDiff/refreshStep); 
							// we divide the current point to the target point(both camera pos and lookAt) into steps
							if(stepToFinish <= 1)
							{
								//do nothing
								
							}
							else
							{			
								
								var [posStepX,posStepY,posStepZ] = [(lastTarget[0] - person.position.x)/stepToFinish,(lastTarget[1] - person.position.y)/stepToFinish,(lastTarget[2] - person.position.z)/stepToFinish];
								person.position.set(person.position.x+posStepX,person.position.y+posStepY,person.position.z+posStepZ);

							}
						}else
						{
							// now the target is not the old target, we will jump to the old target, and start going to the new target in the next loop
								//1. the camera pos
							person.position.set(lastTarget[0],lastTarget[1],lastTarget[2]);
							// the lastTarget is the currect target now.
							videos[videoname]['tracking'][personId]['lastTarget'] = [newPos[0]*scaleFactor,newPos[1]*scaleFactor,newPos[2]*scaleFactor,targetVideoTime];
						}
						
					}				
				}
			}
		}

		renderer.render(sceneBG,backgroundCamera); // the background
		renderer.render(scene,camera);

		stats.end();
		id = window.requestAnimationFrame(draw);
	}
	draw();
	

}
$(document).ready(function(){
	init();
});
// show or close single video control
cw.ec("#singleVideoControls",function(){
	if($(this).hasClass("shown"))
	{
		$(this).removeClass("shown").removeClass("icon-eye-open").addClass("hidden").addClass("icon-eye-close");
		$("div.main > div.mainControls > div.videoControl > div.block > div.controls").hide();
	}
	else
	{
		$(this).removeClass("hidden").removeClass("icon-eye-close").addClass("shown").addClass("icon-eye-open");
		$("div.main > div.mainControls > div.videoControl > div.block > div.controls").show();
	}
});
</script>
<style type="text/css">
/*style for the timeline control*/
#videoTimeline{
	cursor:pointer;
	position:relative;
	background-color:rgb(240,240,240);
	margin-bottom:25px;/*make place for time display*/
}
#videoTimeline > div.mainTimeline{
	background:url('<?php echo Yii::app()->theme->baseUrl?>/img/reel.png') top left repeat-x; 
	height:5px;
	width:100%;
}
#videoTimeline > #timePos{
	position:absolute;
	left:0%;
	background-color:rgba(255,0,0,0.5);
	z-index:999;
	width:4px;
	height:100%;
	bottom:0;
}
#videoTimeline > #timeNow{
	position:absolute;
	margin-left:-30px;
	width:60px;
	height:20px;
	font-size:0.7em;
	background-color:black;
	color:white;
	font-weight:bold;
	z-index:999;
	text-align:center;
	bottom:-19px;
	left:0%;
}
#videoTimeline > div.videos > div.block{
	background-color:rgb(240,240,240);
	border-bottom:3px silver solid;
	height:30px;
	position:relative;
}
#videoTimeline > div.videos > div.block > div.video{
	position:absolute;
	top:0;left:0;
	height:100%;
	text-align:center;
	font-size:0.8em;
}
div.main > div.mainControls > div.globalControl{
	margin:5px;
	background-color:#c8c8c8;
	text-align:center;
	padding:2px 0;
}
div.main > div.mainControls > div.globalControl > i{
	cursor:pointer;
}
</style>
<div id="cHtml3d">
	<div class="warning" style="margin:0px 0;border-bottom:1px silver solid;font-size:1.2em;color:gray;font-weight:bold;text-align:center;">
		Please view it with at least 1400x800 screen (Double click a point to zoom in, hold left click to orbit, hold right click to pan and arrow keys for moving)
	</div>
	<div id="webgl" style="height:650px;position:fixed;width:1100px;top:60px;left:50%;margin-left:-400px">
	</div>
	<div class="main" style="margin:0 1100px 0 0;padding-left:5px;">
		
		<div class="mainControls">
			<div class="quickLink" style="text-align center;padding:5px;">
				<!--<a class="btn btn-small btn-success" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cPointCloudVideo?project=0.5" target="_self">Show Projection</a>
				<a class="btn btn-small btn-success" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cPointCloudVideo?project=0" target="_self">No Projection</a>-->
				<div class="btn btn-small btn-success showProjection">Show Projection</div>
				<div class="btn btn-small hideProjection">hide Projection</div>
			</div>
			<!-- for the loading of ply file -->
			<div class="progress progress-striped active" id="loadProgress" style="">
				<div class="bar" style="width:0%"></div>
			</div>
			<div class="videoTimeline" id="videoTimeline">
				<div id="timePos"></div>
				<div id="timeNow">00:00:00.0</div>
				<div class="videos">
				</div>
				<div class="mainTimeline"></div>
			</div>
			<div class="globalControl">
				<i class="icon-play" id="playGlobal"></i>
				<i class="icon-pause" id="pauseGlobal" style="display:none"></i>
				<i class="icon-eye-close hidden" id="singleVideoControls"></i>
				<span class="text-info" style="font-size:0.8em">Press space to toggle timeline play, <br/>< and > to seek left or right</span>
			</div>
			<div class="videoControl">
			
			</div>
		</div>
		<div id="stats" style="margin-bottom:20px"></div>
		<div id="guiControl" style="margin-bottom:20px"></div>
		<div class="moreControls" style="padding:5px;line-height:30px">
			<div class="btn btn-small getCameraPos">getCurrentCameraPos</div>:
			<input class="cameraPos input-xxlarge" style="width:280px;" type="text"></input>
			<br/>
			Last click point: <input class="clickPoint input-medium" type="text"></input>
		</div>
	</div>
</div>