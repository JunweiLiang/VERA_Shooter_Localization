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
	#cHtml3d > div.main {
		background-color:white;
		width:1200px;
		margin:10px auto;
		min-height:1000px;
	}
	#cHtml3d input{margin:0px}
</style>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/three.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/stats.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/dat.gui.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/OrbitControls.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/PLYLoader.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/ImageUtils.js"></script>

<script id="vertexShader" type="x-shader/x-vertex">
	varying vec3 vViewPosition;
	varying vec3 vNormal;
	varying vec2 vUv;
	varying vec3 vWorldPosition;

	uniform mat4 textureMatrixProj; 
	varying vec4 texCoordProj; 

	void main() {
		vUv = uv;// * offsetRepeat.zw + offsetRepeat.xy;

		vec3 eyeNormal = normalMatrix * normal;
		vNormal = normalize( eyeNormal );

		vec4 mvPosition;
		mvPosition = modelViewMatrix * vec4( position, 1.0 );
		gl_Position = projectionMatrix * mvPosition;

		vViewPosition = -mvPosition.xyz;

		vec4 worldPosition = modelMatrix * vec4( position, 1.0 );
		vWorldPosition = worldPosition.xyz;

		texCoordProj = textureMatrixProj * modelMatrix * vec4(position, 1.0);  
	} 
</script>

<script id="fragmentShader" type="x-shader/x-fragment">
	const vec3 ambient = vec3(1.0, 1.0, 1.0);
	varying vec2 vUv;
	uniform sampler2D map;

	varying vec3 vWorldPosition;
	varying vec3 vViewPosition;
	varying vec3 vNormal;

	uniform sampler2D mapProj; 
	varying vec4 texCoordProj; 

	void main() {

		vec4 texelColor = texture2D( map, vUv );
		vec4 texColorProj = texCoordProj.q < 0.0 ? vec4(0.0, 0.0, 0.0, 0.0) : texture2DProj( mapProj, texCoordProj); 
   // float projectorAttenuation = texColorProj.a; // for projective texturing

		gl_FragColor = texelColor + texColorProj;

	}
</script>
<script>
function makeProjectiveMatrixForLight(l) {

	var lightCamera = new THREE.PerspectiveCamera( 2*l.angle*180/Math.PI, 1.0, 1, 1000 );
	var targetPosition = new THREE.Vector3();

	lightCamera.position.getPositionFromMatrix( l.matrixWorld );
	targetPosition.getPositionFromMatrix( l.target.matrixWorld );
	lightCamera.up = new THREE.Vector3(0,0,1);
	lightCamera.lookAt( targetPosition );
	lightCamera.updateMatrixWorld();

	lightCamera.matrixWorldInverse.getInverse( lightCamera.matrixWorld );

	var lightMatrix = new THREE.Matrix4();
	lightMatrix.set( 0.5, 0.0, 0.0, 0.5,
					  0.0, 0.5, 0.0, 0.5,
					  0.0, 0.0, 0.5, 0.5,
					  0.0, 0.0, 0.0, 1.0 );  // row major

	lightMatrix.multiply( lightCamera.projectionMatrix );
	lightMatrix.multiply( lightCamera.matrixWorldInverse );

	return lightMatrix;
}
function getVideoTexture(url)
{
	var temp = {};
	// create the video element
	var video	= document.createElement('video');
	video.width	= 320;
	video.height	= 240;
	video.autoplay	= true;
	video.loop	= true;
	video.src	= url;
	// expose video as this.video
	temp.video	= video

	// create the texture
	var texture	= new THREE.Texture( video );
	// expose texture as this.texture
	temp.texture = texture;
	temp.texture.minFilter = THREE.LinearFilter;

	temp.update	= function(){
		if( video.readyState !== video.HAVE_ENOUGH_DATA )	return;
		texture.needsUpdate	= true;		
	}

	temp.destroy	= function(){
		video.pause()
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
// return a cube with the video and a cone
// var [group,video] = makeVideoGroup(url);
function makeVideoGroup(videoUrl,targetVideo)
{
	var videoname = getVideoname(videoUrl);
	// make 2D text material for the cube, for videoname
	var canvasText = document.createElement("canvas");
	var context1 = canvasText.getContext("2d");
	context1.fillStyle="black";
	context1.fillRect(0,0,canvasText.width,canvasText.height);
	context1.font = "Bold 80px Arial";
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
	var noneMaterial = new THREE.MeshBasicMaterial({color:"green"});
	var materials = [ 
		noneMaterial,
		noneMaterial,
		noneMaterial,
		noneMaterial,
		textMaterial, // this is the back of that face
		cubeMaterial // this is the face for cube when using lookAt(point)
	 ];

	// width, height, depth
	var cubeGeometry = new THREE.BoxGeometry(8, 6, 0.2,1,1,1);
	var cube = new THREE.Mesh( cubeGeometry, new THREE.MultiMaterial(materials));

	cube.position.set(0,0,0)
	// for degree (0-360)
	//cube.rotation.set(degree*(Math.PI/180), 0, 0);	
	cube.name=videoname;
	//rotate the Z so when the group lookAt, the TV is correct angle
	cube.rotateZ(270*(Math.PI/180)); // but this is also determined by the lookAt point
	
	// radius, height, faces
	var cgeometry = new THREE.ConeGeometry( 5, 10, 6 );// radius can be changed independtly
	var cmaterial = new THREE.MeshBasicMaterial( {wireframe:true, color: "yellow",} );
	var cone = new THREE.Mesh( cgeometry, cmaterial );
	cone.position.set(0,0,5);// the last position has to be half of the height
	cone.rotateX(270 * (Math.PI/180));

	var group = new THREE.Object3D();
	group.add(cube);
	group.add(cone);
	
	return [group,videoTexture]; // return the videoTexture so that we can update it, and control the video outside
}

// set up the 3d thing
function init()
{
	// camera as global for mouse click
	var camera = null;
	var raycaster = null; // global, so that in draw() loop it can be updated
	var mouse = null;
	var scene = null;
	var scaleFactor = 10;// all cordinates scale to this for easier navigation
	var videos = new Array();// video array for global event

	var winHeight = $("#webgl").height();
	var winWidth = $("#webgl").width();
	raycaster = new THREE.Raycaster();// for selecting thing
	scene = new THREE.Scene();
	// (field of view,aspect ratio,near, far) // closer to near or further to far won't be randered
	// fov is 0 -360, 60 is normal
	camera = new THREE.PerspectiveCamera(60,winWidth/winHeight,0.01,1000);

	// ------------------------------------------for the background ----------------------------------
	
	//-----------------------------------------------------------------------------------------

	var renderer = new THREE.WebGLRenderer();
	renderer.setClearColor(new THREE.Color("silver"));
	renderer.setSize(winWidth,winHeight);
	//renderer.autoClear = false; // we need to render both background and foreground scene


	
	// now we add a video into the point cloud space
		// we add the video to a cube, and a cone
	var [group,videoTexture] = makeVideoGroup("<?php echo Yii::app()->baseUrl;?>/assets/videos/92-2.mp4");
	// set the video position (camera position) // initial position
	var cameraPos = [2.21578329891, -0.634912336143, 1.28646818097];
	var cameraLook = [cameraPos[0]-0.693437417568,cameraPos[1]+0.717376369836,cameraPos[2]+0.06719889819];
	group.position.set(cameraPos[0]*scaleFactor,cameraPos[1]*scaleFactor,cameraPos[2]*scaleFactor);
	// set the video lookat (angle)
	//group.lookAt(new THREE.Vector3(cameraLook[0]*scaleFactor,cameraLook[1]*scaleFactor,cameraLook[2]*scaleFactor));

	var spotLight = new THREE.SpotLight( 0xffffff );
		spotLight.position.set( 0, 0,0);
		spotLight.target.position.set(0, 0, 0);
	spotLight.castShadow = false;
	spotLight.angle = Math.PI/10;
	spotLight.penumbra = 0;
	spotLight.decay=1.0;
	spotLight.distance = 10;
	spotLight.intensity=0.0;
	group.add(spotLight);

	group.lookAt(new THREE.Vector3(0,0,0))
	scene.add(group);




	scene.updateMatrixWorld();
	THREE.ImageUtils.crossOrigin = '';
 		var textureProj = videoTexture.texture;
	var parameters = {
		uniforms: {
    	textureMatrixProj: {type: 'm4', value: makeProjectiveMatrixForLight(spotLight)},
      mapProj: {type: 't', value: textureProj}, 
      map: {type:'t', value: new THREE.Texture()},
    },
    	fragmentShader: document.getElementById( 'fragmentShader' ).textContent,
		vertexShader: document.getElementById( 'vertexShader' ).textContent,
	};

	mesh = new THREE.Mesh( new THREE.CubeGeometry( 100,100,1, 1, 1, 1 ), new THREE.ShaderMaterial( parameters ) );

	
		scene.add( mesh );




	// for controlling the video
	videos.push(videoTexture.video);
	cw.ec("div.play",function(){
		videos[0].play();
	});
	cw.ec("div.pause",function(){
		videos[0].pause();
	});

	// camera
	
	camera.up = new THREE.Vector3( 0, 0, 1 );// in the ply, the up axis is z, while three.js default is y
	//camera.rotation.order = 'ZYX'; // what for? from potree
	
	

	// add thing to the DOM
	$("#webgl").append(renderer.domElement);

	
	// mouse control of the scene
	var ocontrols = new THREE.OrbitControls(camera, renderer.domElement);

	// add a user interface to let user change the js variable for animation
	var controls = {
		"cameraChange":0,
		"sign":1,
	};
	
	
	

	// set the initial looking point and direction
	camera.position.set(41.7727, -23.7068, 14.6831  );
	//camera.rotation.set( 0.9114, -0.9240, -0.5539);
	//camera.lookAt(new THREE.Vector3( 55.4319, 13.1690, 50.4633)); // used the "last click point"
	
	ocontrols.target.set(22.3693, 4.1296, 23.5300);// has to update here, not the camera
	ocontrols.update();

	function draw()
	{
		
	
		
		videoTexture.update();// update the video!

		renderer.render(scene,camera);

		id = window.requestAnimationFrame(draw);
	}
	draw();
	

}
$(document).ready(function(){
	init();
});

</script>
<div id="cHtml3d">
	<div class="main">
		<div id="webgl" style="width:100%;height:500px">
		</div>
		<div class="wrapLoading">

			<div class="progress progress-striped active" id="loadProgress" style="margin:0 300px;">
				<div class="bar" style="width:0%"></div>
			</div>
			<div class="btn btn-small btn-success play">play the video</div>
			<div class="btn btn-small btn-success pause">pause the video</div>
		
			
		</div>
		<div id="stats"></div>
		<div id="guiControl"></div>
		<div class="wrapLoading">
			<div class="btn btn-small getCameraPos">getCurrentCameraPos</div>
			<input class="cameraPos input-xxlarge" type="text"></input>
			<br/>
			Last click point: <input class="clickPoint input-medium" type="text"></input>
		</div>
	</div>
</div>