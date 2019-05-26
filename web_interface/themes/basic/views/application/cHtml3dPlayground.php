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
	div.main {
		background-color:white;
		width:1200px;
		margin:10px auto;
		min-height:1000px;
	}
</style>

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

<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/three.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/stats.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/dat.gui.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/OrbitControls.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/TrackballControls.js"></script>
<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/FlyControls.js"></script>

<script>

function getVideoTexture(url)
{
	var temp = {};
	// create the video element
	var video	= document.createElement('video');
	video.width	= 320;
	video.height	= 240;
	video.autoplay	= false;
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

var videoTexture = null;// global so that we can control play and pause
cw.ec("div.play",function(){
	videoTexture.video.play();
});
cw.ec("div.pause",function(){
	videoTexture.video.pause();
});
// camera as global for mouse click
var camera = null;
var raycaster = null; // global, so that in draw() loop it can be updated
var mouse = null;
var scene = null;
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
		var selected = intersects[0];
		if(selected.object.name != "")
		{
			console.log(selected.object.name);
		}
		
		var geometry = new THREE.SphereGeometry(1, 20, 20, 0, Math.PI * 2, 0, Math.PI * 2);
		var material = new THREE.MeshNormalMaterial();
		var ball = new THREE.Mesh(geometry, material);
		
		ball.position.copy( selected.point );
		
		scene.add( ball );
	}

});
function makePerson()
{
	var radius=2,cheight=10;
	var cylinderGeo = new THREE.CylinderGeometry( radius, radius, cheight, 10 );
	var cylinderMat = new THREE.MeshBasicMaterial({wireframe:true,color: "red"});
	var cylinder = new THREE.Mesh( cylinderGeo, cylinderMat);
	//cylinder.rotateX(90*(Math.PI/180));
	cylinder.position.set(0,cheight/2,0);

	//put a sphere on top of the cylinder
	var sphereGeo = new THREE.SphereGeometry( radius, 10, 10 );
	var sphereMat = new THREE.MeshBasicMaterial( {wireframe:true,color: "red"} );
	var sphere = new THREE.Mesh( sphereGeo, sphereMat );
	sphere.position.set(0,cheight+radius,0);

	// add a plane on infront and put the person pic on it
	var imgTexture = new THREE.TextureLoader().load("<?php echo Yii::app()->baseUrl;?>/assets/pointClouds/3d_position_of_tracked_mans/1.jpg");
	imgTexture.minFilter = THREE.LinearFilter;
	imgTexture.repeat.set(1,1);
	var imgMaterial = new THREE.MeshBasicMaterial({
	    map : imgTexture
	});
	var noneMaterial = new THREE.MeshBasicMaterial({color:"green"});
	var materials = [ 
		noneMaterial,
		noneMaterial,
		noneMaterial,
		noneMaterial,
		imgMaterial, // this is the back of that face
		noneMaterial // this is the face for cube when using lookAt(point)
	 ];
	
	/*
	// this make 8 side of video
	var cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
	*/
	// width, height, depth
	var cubeGeometry = new THREE.BoxGeometry(2*radius, cheight+2*radius, radius/4);
	// a geometry is vertices(points) and faces
	// new THREE.Vector3(-1,-1,1) // this is a point in (x,y,z)
	// a geometry and material combine a mesh
	// a mesh has position, rotation... //position is related to its parent(scene)
	var cube = new THREE.Mesh( cubeGeometry, new THREE.MultiMaterial(materials));
	cube.position.set(0,(cheight+2*radius)/2,radius);//

	var group = new THREE.Object3D();
	group.up = new THREE.Vector3(0,0,1);// important to keep the video correct
	group.add(cylinder);
	group.add(sphere);
	group.add(cube);
	//group.name = videoname;
	return group;
}
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

function init()
{

	var winHeight = $("#webgl").height();
	var winWidth = $("#webgl").width();
	raycaster = new THREE.Raycaster();// for selecting thing
	scene = new THREE.Scene();
	// (field of view,aspect ratio,near, far) // closer to near or further to far won't be randered
	// fov is 0 -360, 60 is normal
	camera = new THREE.PerspectiveCamera(60,winWidth/winHeight,0.1,1000);
	// camera.aspect should be changed when resize? no, this is fixed
	// camera.lookAt(new THREE.Vector3(x,y,z));

	var renderer = new THREE.WebGLRenderer();
	renderer.setClearColor(new THREE.Color("silver"));
	renderer.setSize(winWidth,winHeight);

	// add a axis thing
	var axes = new THREE.AxisHelper( 20 );
	scene.add(axes);//The X axis is red. The Y axis is green. The Z axis is blue.

	var person = makePerson();
	person.position.set(20,20,50);
	person.lookAt(new THREE.Vector3(0,0,person.position.z));
	scene.add(person);

	// a ground plane
	var planeGeometry = new THREE.PlaneGeometry(60,20);// width and length
	//var planeMaterial = new THREE.MeshBasicMaterial({color:0xcccccc}); // what it looks like , with material object
	var planeMaterial = new THREE.MeshLambertMaterial({color:0xcccccc}); // what it looks like , with material object
	// so a mesh is a combination of geometry and material (what size and what it looks)
	var plane = new THREE.Mesh(planeGeometry,planeMaterial);// combine 
	// put to the right position
	
	plane.position.x=15;
	plane.position.y=0;
	plane.position.z=0;
	plane.name="plane";
	scene.add(plane);

	

	/*
	// this is 3d text, I will have 2D instead
	var textloader = new THREE.FontLoader();
	textloader.load('https://raw.githubusercontent.com/mrdoob/three.js/master/examples/fonts/helvetiker_regular.typeface.json',function(font){
		// add 3d text
		var options = {
		 size: 9,
		 height: 1,// how thick the text is
		 weight: 'normal',
		 font: font,
		 style: 'normal',
			
		};
		var textGeo = new THREE.TextGeometry("Boston",options);
		var textMaterial = new THREE.MeshNormalMaterial();
		var text = new THREE.Mesh(textGeo,textMaterial);
		text.position.set(0,0,0);
		text.rotateX(90*(2*Math.PI/360));
		text.rotateY(90*(2*Math.PI/360));
		text.name = "textObjectHa";
		scene.add(text);
	});
	*/

	// add 2D text to the cube
	var canvasText = document.createElement("canvas");
	var context1 = canvasText.getContext("2d");
	// so the side is the same color as the other, if no this, default is black
	context1.fillStyle="black";
	context1.fillRect(0,0,canvasText.width,canvasText.height);

	context1.font = "Bold 50px Arial";
	context1.fillStyle = "rgba(255,0,0,1.0)";
	context1.fillText("test.mp4",0,50);// y has to be 50 as the font size?
	var textTexture = new THREE.Texture(canvasText);
	textTexture.needsUpdate = true;
	textTexture.minFilter = THREE.LinearFilter;
	var textMaterial = new THREE.MeshBasicMaterial({map:textTexture,side:THREE.DoubleSide});
	textMaterial.transparent = false;

	// add a cube
	
	//var cubeMaterial = new THREE.MeshBasicMaterial({color: 0xff0000, wireframe: true});
	// add a video on it
	videoTexture = getVideoTexture("<?php echo Yii::app()->baseUrl?>/assets/videos/92-2.mp4");
	var cubeMaterial = new THREE.MeshBasicMaterial({
	    map : videoTexture.texture
	});
	var noneMaterial = new THREE.MeshBasicMaterial({color:"green"});
	var materials = [ 
		noneMaterial,
		noneMaterial,
		noneMaterial,
		noneMaterial,
		textMaterial, // this is the back of that face
		cubeMaterial // this is the face for cube when using lookAt(point)
	 ];
	
	/*
	// this make 8 side of video
	var cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
	*/
	// width, height, depth
	var cubeGeometry = new THREE.BoxGeometry(40, 30, 1,1,1,1);
	// a geometry is vertices(points) and faces
	// new THREE.Vector3(-1,-1,1) // this is a point in (x,y,z)
	// a geometry and material combine a mesh
	// a mesh has position, rotation... //position is related to its parent(scene)
	var cube = new THREE.Mesh( cubeGeometry, new THREE.MultiMaterial(materials));
	cube.position.set(0,0,0);//

	// another cube for projecting


	//cube.rotateX(90*(Math.PI/180));

	// or cube.position.set(10,3,1);
	// or cube.postion = new THREE.Vector3(10,3,1);

	// a complete rotation
	//cube.rotation.set(2*Math.PI, 0, 0);
	// for degree (0-360)
	//cube.rotation.set(degree*(Math.PI/180), 0, 0);
	

	cube.name="damncube";
	//rotate the Z so when the group lookAt, the TV is correct angle
	//cube.rotateZ(270*(2*Math.PI/360)); // but this is also determined by the lookAt point
	// THREE.Scene.getObjectByName(name) // can be used to retrieve the object and change things
	/*
	var allChildren = scene.children;
	 var lastObject = allChildren[allChildren.length-1];
	 if (lastObject instanceof THREE.Mesh) {
	 	scene.remove(lastObject);
	 }
	*/
	//cube.lookAt(new THREE.Vector3(0,0,0)); // this will make the last face as showing video correct
	//scene.add(cube);
	// now we create another thing to group together
	// a cone for camera angle
	// radius, height, faces
	var cgeometry = new THREE.ConeGeometry( 15, 20, 6 );// radius can be changed independtly
	var cmaterial = new THREE.MeshBasicMaterial( { color: "yellow",} );
	cmaterial.transparent = true;
	cmaterial.opacity = 0.4;

	var cone = new THREE.Mesh( cgeometry, cmaterial );
	cone.position.set(0,0,10);
	cone.rotateX(270 * (Math.PI/180));
	//scene.add(cone);
	var spotLight = new THREE.SpotLight( 0xffffff );
	spotLight.position.set(0,0,0);
	spotLight.castShadow = false;
	spotLight.angle = Math.PI/10;

	var group = new THREE.Object3D();
	
	group.add(cube);
	group.add(cone);
	group.add(spotLight);
	group.up = new THREE.Vector3(0,0,1);
	group.position.set(50,50,50);

	group.lookAt(new THREE.Vector3(0,0,0));
	//console.log(scene.getObjectByName("textObjectHa"));
	//group.lookAt(scene.getObjectByName("plane").position);
	//group.lookAt(new THREE.Vector3(-100,10,0));
	scene.add(group);
	// project stuff onto a mesh



	scene.updateMatrixWorld();

	THREE.ImageUtils.crossOrigin = '';
	var texture = new THREE.Texture({color:"white"});
	var textureProj = videoTexture.texture;
	var parameters = {
		uniforms: {
    	textureMatrixProj: {type: 'm4', value: makeProjectiveMatrixForLight(spotLight)},
      mapProj: {type: 't', value: textureProj}, 
      map: {type:'t', value: texture},
    },
    	fragmentShader: document.getElementById( 'fragmentShader' ).textContent,
		vertexShader: document.getElementById( 'vertexShader' ).textContent,
	};

	mesh = new THREE.Mesh( new THREE.CubeGeometry( 100,1,100, 1, 1, 1 ), new THREE.ShaderMaterial( parameters ) );

	scene.add( mesh );
	// add fog
	//scene.fog = new THREE.Fog( "rgb(240,240,240)", 0.015, 100 ); // color, near, far
	//scene.fog = new THREE.FogExp2( 0xffffff, 0.01 ); // exponentially denser

	// add a light  // will be different based on the material. Some material has no effect by light
	//var spotLight = new THREE.SpotLight( 0xffffff );
	//spotLight.position.set( -40, 60, -10 );
	//scene.add( spotLight );
	// shadow? 

	// camera
	camera.position.x = 100;
	camera.position.y = 100;
	camera.position.z = 50;
	camera.up = new THREE.Vector3( 0, 0, 1 );// in the ply, the up axis is z, while three.js default is y
	camera.lookAt(scene.position);

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

	//var trackballControls = new THREE.TrackballControls(camera);
	
	

	// add a user interface to let user change the js variable for animation
	var controls = {
		"rotationSpeed":0, // default value
		"cameraChange":0,
		"sign":1,
	};
	var gui = new dat.GUI({autoPlace:false});
	gui.add(controls,"rotationSpeed",0,0.1);
	gui.add(controls,"cameraChange",0,10);
	gui.domElement.id = 'data.gui.control';
	$("#guiControl").append(gui.domElement);

	//renderer.render(scene,camera);// will render every time in requestAnimationFrame
	function draw()
	{
		stats.begin();
		//trackballControls.update();// needed
		cube.rotation.x += controls.rotationSpeed;
		cube.rotation.y += controls.rotationSpeed;
		cube.rotation.z += controls.rotationSpeed;
		camera.position.x += controls.sign*controls.cameraChange;
		if((camera.position.x > 100) || (camera.position.x < -100))
		{
			//console.log(camera.position.x);
			controls.sign = -controls.sign;
		}
		camera.lookAt(scene.position);
		videoTexture.update();// update the video!


		renderer.render(scene,camera);
		stats.end();
		id = window.requestAnimationFrame(draw);
	}
	draw();
	

}
$(document).ready(function(){
	init();
});

</script>
<div class="main">
	<div id="webgl" style="width:100%;height:500px">
	</div>
	<div class="wrapLoading">
		<div class="btn btn-small btn-success play">play the video</div>
		<div class="btn btn-small btn-success pause">pause the video</div>
	</div>
	<div id="stats"></div>
	<div id="guiControl"></div>
</div>