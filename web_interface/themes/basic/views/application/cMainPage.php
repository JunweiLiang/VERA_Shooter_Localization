
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		//"#cIndex > input.gotoDatasetList",
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
	#main{
		width:1400px;
		margin:30px auto;
		background-color:white;
		min-height:500px;
	}#main input{margin:0}
	#main > div.title{
		padding:10px;
		font-weight:bold;
		font-size:1.1em;
		color:gray;
		border-bottom:1px silver solid;
		margin-bottom:10px;
	}
	#main div.subTitle{
		padding:5px 10px;
		font-weight:bold;
		font-size:1.0em;
		color:gray;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#main > div.collectionList{
		height:150px;
		background-color:rgb(230,230,230);
		overflow-x:auto;
		margin:0 20px;
		position:relative;
	}
	#main > div.block > div.line{
		padding:10px;
	}
	/*
		------------------------------------------gunshot marking
	*/
	#main > div.gunshot > div.gunshotList, #main > div.gunshot > div.videoList{
		padding:30px;
		margin:0 20px;
		border-radius:5px;
		background-color:rgb(230, 230, 230);
		position: relative;
	}
	#main > div.gunshot > div.gunshotList > div.block{
		box-shadow: 2px 2px silver;
		border-radius: 5px;
		background-color: white;
		padding:15px 20px;
		margin-bottom: 10px;
	}

	#main > div.gunshot > div.videoList{
		width:auto;
		white-space:nowrap;
		padding:20px 5px;
	}
	#main > div.gunshot > div.videoList > div.block{
		margin:10px;
		width:200px;
		min-height:150px;
		background-color:white;
		display: inline-block;
		padding:5px;
		-moz-box-shadow:0 1px 1px #999;							
 		-webkit-box-shadow:0 1px 1px #999;					 
 		 box-shadow:0 1px 1px #999;
 		 border-top:3px none solid;
 		 border-radius:5px;
 		 position:relative;
 		 float: left;
	}
	#main > div.gunshot > div.videoList > div.block > div.line{
		/*somehow word-break won't work here*/
		overflow: hidden;
	}
	#main > div.gunshot > div.videoList > div.block > div.line.videoImg{
		height:100px;
		width:100%;
		text-align:center;
	}
	#main > div.gunshot > div.videoList > div.block > div.line > img.videoImg{
		width: 100%;
		max-height: 100%;
	}
	#main > div.gunshot > div.videoList > div.block > div.timeline, #markGunshotModal > div.modal-body > div.line > div.timeline{
		background-color:white;
		border:1px silver solid;
		border-width: 1px 0;
		height:30px;
		position:relative;
		margin:5px 0;
		/*-moz-box-shadow:0 1px 3px #999;							
 		-webkit-box-shadow:0 1px 3px #999;					 
 		 box-shadow:0 1px 3px #999;*/
 		 overflow:hidden;
 		 cursor:pointer;
	}
	#main > div.gunshot > div.videoList > div.block > div.timeline::before, #markGunshotModal > div.modal-body > div.line > div.timeline::before{
		/*horizontal line*/
		 content: '';
			position: absolute;
			top: 50%;
			left: 0;
			height: 4px;
			margin-top:-2px;
			width: 100%;
			background: #99D4FF;
	}
	#markGunshotModal > div.modal-body > div.line > div.timeline > div.block{
		/*background-color:#5bb75b;*/
		background-color:rgb(255,200,0);
		position:absolute;
		height:30px;
		border-radius:0px;
		text-align:center;
	}
	#markGunshotModal > div.modal-body > div.line > div.timeline > div.playback, #markGunshotModal > div.modal-body > div.line > div.timeline > div.time_pin, #markGunshotModal > div.modal-body > div.spectrogram > div.playback, #markGunshotModal > div.modal-body > div.spectrogram > div.mouse_pin, #main > div.gunshot > div.videoList > div.block > div.timeline > div.time_pin{
		position:absolute;
		top:0;
		left:0;
		border-left:3px black solid;
		width:1px;
		height:100%;
		z-index:99;
	}
	#markGunshotModal > div.modal-body > div.spectrogram > div.playback{
		display:none;
	}
	
	#gunshotModal > div.modal-body > div.line, #editGunshotModal > div.modal-body > div.line{
		line-height:40px;
	}
	#markGunshotModal > div.modal-body > div.line > div.gunshots, #main > div.localization > div.gunshotList, #main > div.localization > div.gunshotInVideoList{
		padding:10px;
		position:relative;
		background-color: rgb(240, 240, 240);
	}
	#main > div.localization > div.gunshotList{
		margin-bottom: 10px;
	}
	#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block, #main > div.localization > div.gunshotList > div.block, #main > div.localization > div.gunshotInVideoList > div.block{
		display: inline-block;
		padding: 10px;
		font-size: 1.1em;
		font-weight: bold;
		background-color: white;
		color: #49afcd;
		border: 1px silver solid;
		border-radius: 5px;
		box-shadow: 1px 1px 1px silver;
		cursor: pointer;
		margin-right:10px;
		margin-bottom: 10px;
	}
	#markGunshotModal > div.modal-body > div.line > div.markCtr > input.input-small,
	#main > div.localization > div.mapCtr > div.line > input.input-small{
		width: 30px;
	}
	#markGunshotModal > div.modal-body > div.line > div.markCtr > input.input-xsmall{
		width: 20px;
	}
	#main > div.localization > div.gunshotInVideoList > div.block{
	 	cursor: default;
	}
	#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block.toggle, #main > div.localization > div.gunshotList > div.block.toggle{
		background-color: #49afcd;
		color:white;
	}
	#markGunshotModal > div.modal-body > div.spectrogram {
		position: relative;
		overflow: hidden;
		cursor: pointer;
	}
	#markGunshotModal > div.modal-body > div.spectrogram > img{
		height: 300px;
		width: 100%;
	}
	#main > div.localization > div.mapCtr{
		padding:10px;
	}
	#main > div.localization > div.map{
		position:relative;
		background-color: rgb(240, 240, 240);
		min-height:200px;
	}
	#main > div.localization > div.map > #googleMap{
		height:800px;
	}
	div.footer{
		text-align:center;
		font-size:1.0em;
		color:gray;
		padding:10px;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	// the scroll of collection
	cw.ech("#main > div.collectionList > input.scrollCall",function(){
		var left = parseFloat($(this).val());
		if(!isNaN(left))
		{
			$("#main > div.collectionList").scrollLeft(left);
		}
	});
	// when select a collection, trigger loading all the results event
	cw.ech("#main > input.datasetId", function(){
		var datasetId = $(this).val();
		// 1. video synchronization
		$("#main > div.video_sync > div.line > a.manual_sync").prop("href", "<?php echo Yii::app()->baseUrl?>/index.php/application/cAudioSync?datasetId=" + datasetId);
		load_sync_result(datasetId);
		// 2. gunshot marking
		load_gunshots(datasetId);
		load_gunshot_videos(datasetId);
		load_event_location(datasetId);
	});
</script>
<div id="main">
	<input class="datasetId" type="hidden"></input>
	<input class="eventLatitude" type="hidden"></input>
	<input class="eventLongitude" type="hidden"></input>
	<input class="eventRadius" type="hidden"></input>
	<div class="title">
		Collection List
		<a class="btn btn-primary new" target="_self" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cNewCollection">Create New Collection</a>
	</div>
	<div class="collectionList">
		<input class="scrollCall" type="hidden"></input>
		<?php 
			$this->widget("DatasetWidget",array(
				'id' => "datasetWidget",
				"userId" => Yii::app()->session['userId'],
				"target" => "#main > input.datasetId",
				"datasetId" => $datasetId,
				"scrollCall" => "#main > div.collectionList > input.scrollCall"
			));
		?>
	</div>

	<div class="title">1. Video Synchronization</div>

	<div class="video_sync block">
		<input class="syncDone" type="hidden"></input>
		<div class="line">
			<div class='btn btn-primary run'>Run Video Synchronization</div>
			<span class="info text-error"></span>
		</div>
		<div class="line">
			<?php 
				$this->widget("ProgressWidget",array(
					"id" => "videoSyncProgress",
					"doneCall" => "#main > div.video_sync > input.syncDone",
					"noMessage" => false,
				));
			?>
		</div>
		<div class="line">
			<a class='btn btn-info btn-small manual_sync' target="_self" href="#">Manual Refine</a>
		</div>
		<iframe id="videoSyncResultIframe" name="videoSyncResultIframe" frameborder=0 style="width:100%;margin:0;height:0px"></iframe>
	</div>

	<div class="title">2. Gunshot Marking</div>

	<div class="modal hide fade" id="gunshotModal" style="width:1000px;margin-left:-500px;">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2>
					New Gunshot
				</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="line">
				Gun Name: <input class="input-medium gunName" type="text"></input>
				Bullet Speed: <input class="input-small bulletSpeedMin" type="text"></input>
				to <input class="input-small bulletSpeedMax" type="text"></input>
				m/s
			</div>
			
			<div class="line">
				Note: <input class="input-xxlarge note" type="text"></input>
			</div>
		</div>
		<div class="modal-footer">
			<span class="info text-error"></span>
			<button class="btn submit btn-primary" aria-hidden="true">Submit</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	<div class="modal hide fade" id="editGunshotModal" style="width:1000px;margin-left:-500px;">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2>
					Edit Gunshot
				</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="line">
				<input class="gunshotId" type="hidden"></input>
				Gun Name: <input class="input-medium gunName" type="text"></input>
				Bullet Speed: <input class="input-small bulletSpeedMin" type="text"></input>
				to <input class="input-small bulletSpeedMax" type="text"></input>
				m/s
			</div>
			
			<div class="line">
				Note: <input class="input-xxlarge note" type="text"></input>
			</div>
			<div class="line">
				<span class="text-info">Please get the bullet speed information range as small as possible.</span>
			</div>
		</div>
		<div class="modal-footer">
			<span class="info text-error"></span>
			<button class="btn submit btn-primary" aria-hidden="true">Save</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	<div class="modal hide fade" id="markGunshotModal" style="width:1200px;margin-left:-600px;position:absolute;">
		<input class="videoId" type="hidden"></input>
		<input class="videoname" type="hidden"></input>
		<input class="videopath" type="hidden"></input>
		<input class="videoDuration" type="hidden"></input>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2>
					Gunshot Marking for <span class="videoname text-info"></span> <a class="btn btn-primary btn-small gunshotDetect" href="#">Run Gunshot Detection</a>
				</h2>
		</div>
		<div class='modal-body' style="max-height:none">
			<div class="display"></div>
			<div class="line">
				<div class="timeline"></div>
			</div>
			<div class="line">
				Show - Start: <input class="start input-small" type="text"></input>
				<div class="btn btn-small clearStart">Clear</div>
				End: <input class="end input-small" type="text"></input>
				<div class="btn btn-small clearEnd">Clear</div>
				<div class="btn btn-info showSpectrum">Show Spectrogram</div>
				<span class="text-error info"></span>
			</div>
			<div class="line">
				Gunshots to mark: <br/>
				<div class="gunshots"></div>
				Marking: <br/>
				<div class="markCtr">
					<div class="playSeg btn-small btn-success btn">Play</div>
					<div class="stop btn-small btn-success btn">Stop</div>			
					Shockwave (Crack): 
					<input class="shockwave input-small" type="text"></input>
					<div class="btn btn-small clearShockwave">Clear</div>
					Muzzle Blast: 
					<input class="muzzle_blast input-small" type="text"></input>
					<div class="btn btn-small clearMB">Clear</div>
					Angle (0 ~ 90): [
					<input class="angleMin input-xsmall" type="text"></input>, 
					<input class="angleMax input-xsmall" type="text"></input>
					],
					Elevation (Camera vs. Gunman):
					<input class="elevation input-xsmall" type="text"></input>
					m
					<div class="btn btn-small btn-info save">Save</div>
					<span class="info text-error">
				</div>
			</div>
			<div class="progressForSpec">
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "getSpecImgProgress",
						"doneCall" => "#markGunshotModal > div.modal-body > input.specDone",
						"noMessage" => false,
					));
				?>
			</div>
			<input class="specDone" type="hidden"></input>
			<div class="line spectrogram" data-startsec="-1", data-endsec="-1">
			</div>
		</div>
		<div class="modal-footer">
			<span class="info text-error"></span>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	<div class="gunshot block">
		<div class="line">
			<div class="btn btn-small btn-primary newGunshot">New Gunshot</div>
			<span class="info text-error"></span>
		</div>
		<div class="gunshotList"></div>
		<div class="subTitle">Mark the Gunshot in Videos:</div>
		<div class="videoList"></div>
	</div>

	<div class="title">3. Video Localization per Gunshot</div>
	<div class="localization">
		<div class="gunshotList"></div>
		<div class="gunshotInVideoList"></div>
		<div class="mapCtr">
			<input class="copyLat" type="hidden"></input>
			<input class="copyLng" type="hidden"></input>
			<input class="method1done" type="hidden"></input>
			<input class="method1processId" type="hidden" value=""></input>
			<div class="line" style="line-height: 40px">
				Event Latitude: 
				<input class="input-small eventLatitude" type="text"></input>
				Longitude:
				<input class="input-small eventLongitude" type="text"></input>
				Radius:
				<input class="input-small eventRadius" type="text"></input>
				m, 
				Sound Speed Min:
				<input class="input-small soundSpeedMin" type="text"></input>
				m/s,
				Sound Speed Max:
				<input class="input-small soundSpeedMax" type="text"></input>
				m/s,
				<br/>
				<div class="btn btn-small btn-primary getMap">Get Map & Save Event Info</div>
				<div class="btn btn-small btn-primary save">Save Camera Locations</div>
				<div class="btn btn-small getCenter">Get Current Center as Event Center</div>
				<div class="btn btn-small btn-success analyze">Analyze Gunshot Location</div>
				<input class="showMethod1" type="checkbox" checked> Per-Camera Estimation
				&nbsp;&nbsp;&nbsp;
				<input class="showMethod2" type="checkbox" checked> Pairwise Estimation
				<span class="info text-error"></span>
				<br/>
				<?php 
					$this->widget("ProgressWidget",array(
						"id" => "method1Progress",
						"doneCall" => "#main > div.localization > div.mapCtr > input.method1done",
						"noMessage" => false,
					));
				?>
				
			</div>
		</div>
		<div class="map">
			<div id="googleMap"></div>
		</div>
	</div>
</div>

<div class="footer">
	Designed and created by <a href="https://cs.cmu.edu/~junweil">Junwei Liang</a> at CMU.
</div>

<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	// here all the functions or events for each stage
	cw.ec("#main > div.video_sync > div.line > div.run",function(){
		var data = {};
		data.videonames = new Array();
		data.makeNewDataset = 0;
		data.datasetId = $("#main > input.datasetId").val();
		data.runName = data.datasetId;

		$("#main > div.video_sync > div.line > span.info").html('<div class="loading"></div>');
		
		cw.post(cw.url+"runVideoSync",data, function(result){
			$("#main > div.video_sync > div.line > span.info").html('');
			if(result.status == 0)
			{
				curDatasetId = result.datasetId;
				if((result.processStatus ==0) && (result.processId != null))
				{
					//start monitoring the process
					$("#videoSyncProgress > input.processId").val(result.processId);
					$("#videoSyncProgress > input.showing").val(1).change();
					$("#videoSyncProgress > input.updating").val(1).change();
				}
			}
			else
			{
				if(result.status == -1)
				{
					$("#main > div.video_sync > div.line > span.info").html('This Run Exists');
				}
				else if(result.status == -2)
				{
					$("#main > div.video_sync > div.line > span.info").html('This Dataset has already run sync. Check the result below');
				}
			}
		});
	});
	// synchronization done, load the results into iframe
	cw.ech("#main > div.video_sync > input.syncDone", function(){
		var datasetId = $("#main > input.datasetId").val();
		load_sync_result(datasetId);
	});
	function load_sync_result(datasetId)
	{
		var data = {};
		data.datasetId = datasetId;
		$("#videoSyncResultIframe").css({"height": "500px"});
		cw.postNew("<?php echo Yii::app()->baseUrl?>/index.php/application/cGlobalResult", data, "videoSyncResultIframe");
	}
	//-------------------------------- gunshot marking
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.clearEnd", function(){
		$(this).parent().children("input.end").val("");
		$("#markGunshotModal > div.modal-body > div.line > div.timeline > div.time_pin.end").remove();
	});
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.clearStart", function(){
		$(this).parent().children("input.start").val("");
		$("#markGunshotModal > div.modal-body > div.line > div.timeline > div.time_pin.start").remove();
	});
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.markCtr > div.clearMB", function(){
		$(this).parent().children("input.muzzle_blast").val("");
		$("#markGunshotModal > div.modal-body > div.spectrogram > div.mouse_pin.muzzle_blast").remove();
	});
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.markCtr > div.clearShockwave", function(){
		$(this).parent().children("input.shockwave").val("");
		$("#markGunshotModal > div.modal-body > div.spectrogram > div.mouse_pin.shockwave").remove();
	});
	cw.ec("#main > div.gunshot > div.line > div.newGunshot", function(){
		//var gunshotBlockOffset = $("#main > div.gunshot").offset();
		//$("#gunshotModal").css({"top":gunshotBlockOffset.top});
		$("#gunshotModal").modal("show");
	});
	cw.ec("#main > div.gunshot > div.gunshotList > div.block > div.line > div.delete", function(){
		var data = {};
		data.datasetId = $("#main > input.datasetId").val();
		data.gunshotId = $(this).parent().children("input.gunshotId").val();
		if(!confirm("Sure?"))
		{
			return;
		}
		cw.post(cw.url + "deleteGunshot", data, function(result){
			if(result.status == 0)
			{
				if(result.hasDeleted == 1)
				{
					load_gunshots($("#main > input.datasetId").val());
				}
				else
				{
					alert("Sorry. Can not delete since you have marked this gunshot in videos");
				}
			}
		});
	});
	// save gunshot info
	cw.ec("#editGunshotModal > div.modal-footer > button.submit", function(){
		var data = {};
		var $form = $("#editGunshotModal > div.modal-body");
		data.gunName = $form.find('div.line > input.gunName').val();
		data.bulletSpeedMin = $form.find('div.line > input.bulletSpeedMin').val();
		data.bulletSpeedMax = $form.find('div.line > input.bulletSpeedMax').val();
		data.note = $form.find('div.line > input.note').val();
		data.gunshotId = $form.find('div.line > input.gunshotId').val();
		data.datasetId = $("#main > input.datasetId").val();
		// some input check
		for(var k in data)
		{	
			if((k != "note") && ((data[k] == "") || (data[k] == null)))
			{
				$(this).parent().children("span.info").html(k + " cannot be empty").emptyLater();
				return;
			}
		}
		data.bulletSpeedMin = parseFloat(data.bulletSpeedMin);
		data.bulletSpeedMax = parseFloat(data.bulletSpeedMax);
		if((data.bulletSpeedMin > data.bulletSpeedMax))
		{
			$(this).parent().children("span.info").html("min > max");
			return;
		}
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url + "editLGunshot", data, function(result){
			$("#editGunshotModal > div.modal-footer > span.info").html('');
			if(result.status==0)
			{
				$("#editGunshotModal").modal("hide");
				load_gunshots($("#main > input.datasetId").val());
			}
			else
			{
				$("#editGunshotModal > div.modal-footer > span.info").html(result.error);
			}
		});
	});

	cw.ec("#gunshotModal > div.modal-footer > button.submit", function(){
		var data = {};
		var $form = $("#gunshotModal > div.modal-body");
		data.gunName = $form.find('div.line > input.gunName').val();
		data.bulletSpeedMin = $form.find('div.line > input.bulletSpeedMin').val();
		data.bulletSpeedMax = $form.find('div.line > input.bulletSpeedMax').val();
		data.note = $form.find('div.line > input.note').val();
		data.datasetId = $("#main > input.datasetId").val();
		// some input check
		for(var k in data)
		{	
			if((k != "note") && ((data[k] == "") || (data[k] == null)))
			{
				$(this).parent().children("span.info").html(k + " cannot be empty").emptyLater();
				return;
			}
		}
		data.bulletSpeedMin = parseFloat(data.bulletSpeedMin);
		data.bulletSpeedMax = parseFloat(data.bulletSpeedMax);
		if((data.bulletSpeedMin > data.bulletSpeedMax))
		{
			$(this).parent().children("span.info").html("min > max");
			return;
		}
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url + "newLGunshot", data, function(result){
			$("#gunshotModal > div.modal-footer > span.info").html('');
			if(result.status==0)
			{
				$("#gunshotModal").modal("hide");
				load_gunshots($("#main > input.datasetId").val());
			}
			else
			{
				$("#gunshotModal > div.modal-footer > span.info").html(result.error);
			}
		});
	});
	// edit gunshot info
	cw.ec("#main > div.gunshot > div.gunshotList > div.block > div.line > div.edit", function(){
		var data = {};
		data.datasetId = $("#main > input.datasetId").val();
		data.gunshotId = $(this).parent().children("input.gunshotId").val();
		// get the info into modal and open the modal
		data.note = $(this).parent().children("input.note").val();
		data.bulletSpeedMin = $(this).parent().children("input.bulletSpeedMin").val();
		data.bulletSpeedMax = $(this).parent().children("input.bulletSpeedMax").val();
		data.gunName = $(this).parent().children("input.gunName").val();
		$("#editGunshotModal > div.modal-body > div.line > input.gunName").val(data.gunName);
		$("#editGunshotModal > div.modal-body > div.line > input.note").val(data.note);
		$("#editGunshotModal > div.modal-body > div.line > input.bulletSpeedMin").val(data.bulletSpeedMin);
		$("#editGunshotModal > div.modal-body > div.line > input.bulletSpeedMax").val(data.bulletSpeedMax);
		$("#editGunshotModal > div.modal-body > div.line > input.gunshotId").val(data.gunshotId);
		$("#editGunshotModal").modal("show");
	});


	cw.ec("#main > div.gunshot > div.videoList > div.block > div.line > div.mark", function(){
		var data = {};
		data.videoId = $(this).parent().parent().children("input.videoId").val();
		data.videoname = $(this).parent().parent().children("input.videoname").val();
		data.videopath = $(this).parent().parent().children("input.relatedPath").val();
		$("#markGunshotModal > input.videoId").val(data.videoId);
		$("#markGunshotModal > input.videoname").val(data.videoname);
		$("#markGunshotModal > input.videopath").val(data.videopath);
		$("#markGunshotModal > div.modal-header span.videoname").html(data.videoname);
		$("#markGunshotModal > div.modal-header a.gunshotDetect").prop("href", "<?php echo Yii::app()->baseUrl?>/index.php/application/cGunshot?videoname="+data.videoname);
		var gunshotBlockOffset = $("#main > div.gunshot").offset();
		$("#markGunshotModal").css({"top":gunshotBlockOffset.top});
		$("#markGunshotModal").modal("show");
	});
	var videoSource = {};
	var conf_thres = 0.5;
	var resultType = "reranking";
	$("#markGunshotModal").on('show', async function(){
		videoSource = {};
		// clear the mark gunshot interface
		$("#markGunshotModal > div.modal-body > div.line > input.start").val("");
		$("#markGunshotModal > div.modal-body > div.line > input.end").val("");
		$("#markGunshotModal > div.modal-body > div.spectrogram").html("");
		// load the video
		$display = $("#markGunshotModal > div.modal-body > div.display");
		var videoname = $("#markGunshotModal > input.videoname").val();
		var videopath = $("#markGunshotModal > input.videopath").val();
		$display.html(makeVideoHtml(videoname, videopath));
		//remember video source
		videoSource[videoname] = {
			"object": $display.find("video").get(0)
		};
		// get the video duration
		// wait till video is ready to get duration
		while(videoSource[videoname]['object'].readyState <= 0)
		{
			await sleep(1000);
		}
		var duration = videoSource[videoname]['object'].duration;
		$("#markGunshotModal > input.videoDuration").val(duration);
		
		// load gunshot detection result if any
		var data = {};
		data.videoname = videoname;
		$("#markGunshotModal > div.modal-body > div.line > div.timeline").html("");
		cw.post(cw.url+"getGunshotAny", data, function(result){
			if(result.status==0)
			{
				if(result.haveResult==1)
				{
					gunshotResult = result.scoreList;
					segments = getSegments(gunshotResult[resultType], conf_thres);
					setSegments(segments);
				}
				// add the playback mark for timeline
				$("#markGunshotModal > div.modal-body > div.line > div.timeline").prepend('<div class="playback"></div>');
			}
		});
		// bind video with the playback pointer on timeline
		// timeupdate fires freq too slow; TODO: use setInterval
		
		/*
		$(videoSource[videoname]['object']).on("timeupdate",function(){
			// also update the playback mark for the prediction graph and the time line;
			var duration = this.duration;
			if(!isNaN(duration))
			{
				var percentage = this.currentTime/duration;
				percentage*=100;				
				$("#markGunshotModal > div.modal-body > div.line > div.timeline > div.playback").css({"left":percentage+"%"});
				// also update the spectrogram time pin if the video time is with in that
				// 1. has spectrogram showing
				$spectrogram = $("#markGunshotModal > div.modal-body > div.spectrogram");
				if($spectrogram.is(":visible"))
				{
					var seg_start = parseFloat($spectrogram.data("startsec"));
					var seg_end = parseFloat($spectrogram.data("endsec"));
					if((seg_start >= 0) && (seg_end > 0) && (seg_end - seg_start > 0))
					{
						// current time is within the segment
						if((this.currentTime >= seg_start) && (this.currentTime <= seg_end))
						{
							var percentage = (this.currentTime - seg_start) / (seg_end - seg_start);
							percentage*=100;				
							$spectrogram.children("div.playback").show().css({"left":percentage+"%"});
						}
						else
						{
							$spectrogram.children("div.playback").hide();
						}
					}
				}
			}
		});
		*/
		$(videoSource[videoname]['object']).on("pause ended abort emptied", function(){
			if(videoPlayingInterval != null)
			{
				clearInterval(videoPlayingInterval);
				videoPlayingInterval = null;
				videoObject = null;
				//console.log("cleared videoPlayingInterval");
			}
		});

		// load the gunshots for marking
		$("#markGunshotModal > div.modal-body > div.line > div.gunshots").html("");
		if((global_gunshots != null) && (global_gunshots.length > 0))
		{
			for(var i=0;i<global_gunshots.length;++i)
			{
				$("#markGunshotModal > div.modal-body > div.line > div.gunshots").append(makeGunshotBlock2(global_gunshots[i], i+1));
			}
			$("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block").eq(0).trigger(cw.ectype);
		}
		else
		{
			$("#markGunshotModal > div.modal-body > div.line > div.gunshots").html("Please add gunshot first.");
		}
	});

	// click on a gunshot for marking, toggle it
	var gunshot_marking = {}; // 
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block", function(){
		if(!$(this).hasClass("toggle"))
		{
			$("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block").removeClass("toggle");
			$(this).addClass("toggle");
			// load the previous marking results
			var data = {};
			data.videoId = $("#markGunshotModal > input.videoId").val();
			data.gunshotId = $(this).children("input.gunshotId").val();
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.muzzle_blast").val("");
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.shockwave").val("");
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.angleMin").val("");
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.angleMax").val("");
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.elevation").val("");
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html('<div class="loading"></div>');
			// clear the previous mouse pin
			$("#markGunshotModal > div.modal-body > div.spectrogram > div.mouse_pin").remove();
			cw.post(cw.url + "getLGunshotInVideos", data, function(result){
				$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html('');
				if(result.status == 0)
				{
					if(result.hasResult == 1)
					{
						$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.muzzle_blast").val(result.gunshotMark.muzzleBlastTime);
						$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.elevation").val(result.gunshotMark.elevation);
						if(result.gunshotMark.shockwaveTime >= 0)
						{
							$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.shockwave").val(result.gunshotMark.shockwaveTime);
						}
						if(result.gunshotMark.angleMin >= 0)
						{
							$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.angleMin").val(result.gunshotMark.angleMin);
						}
						if(result.gunshotMark.angleMax >= 0)
						{
							$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.angleMax").val(result.gunshotMark.angleMax);
						}
						displayGunshotMark();// show the gunshot mark on the current spectrum
					}
				}
			});
		}
	});

	// click on the timeline to get start and end time
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.timeline", async function(e){
		var offset = $(this).offset();
		var clickPos = {
			left: e.pageX - offset.left, // weird, might be < 0
			top: e.pageX - offset.top
		};
		var timeline_length = $(this).width();
		var click_left = clickPos.left < 0 ? 0 : (clickPos.left > timeline_length? timeline_length : clickPos.left);
		var click_percentage = click_left / timeline_length;
		//console.log(click_percentage);
		var videoname = $("#markGunshotModal > input.videoname").val();
		// get the video duration
		// wait till video is ready to get duration
		while(videoSource[videoname]['object'].readyState <= 0)
		{
			await sleep(1000);
		}
		var duration = videoSource[videoname]['object'].duration;
		var click_time = duration * click_percentage;
		// put the time to the closes interger so we could have finite amount of saved images
		var click_time_int = Math.floor(click_time); // the we always ignore the last seconds
		// put the time into the empty input
		var cur_start = $("#markGunshotModal > div.modal-body > div.line > input.start").val();
		var cur_end = $("#markGunshotModal > div.modal-body > div.line > input.end").val();
		if( cur_start == "")
		{
			$("#markGunshotModal > div.modal-body > div.line > input.start").val(click_time_int);
			$("#markGunshotModal > div.modal-body > div.line > div.timeline").append("<div class='time_pin start'>");
			var time_pin = $("#markGunshotModal > div.modal-body > div.line > div.timeline > div.time_pin.start");
		}
		else if (cur_end == "")
		{
			$("#markGunshotModal > div.modal-body > div.line > input.end").val(click_time_int);
			$("#markGunshotModal > div.modal-body > div.line > div.timeline").append("<div class='time_pin end'>");
			var time_pin = $("#markGunshotModal > div.modal-body > div.line > div.timeline > div.time_pin.end");
		}
		else{
			return;
		}

		// put the timepin
		var percentage = click_time_int / duration;
		percentage*=100;				
		time_pin.css({"left":percentage+"%"});
	});
	// show the spectogram and power given the start and end time
	var max_seg_length = 10.0; // in seconds // of course I will check this in the backend
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.showSpectrum", async function(e){
		var cur_start = $("#markGunshotModal > div.modal-body > div.line > input.start").val();
		var cur_end = $("#markGunshotModal > div.modal-body > div.line > input.end").val();
		var $info = $("#markGunshotModal > div.modal-body > div.line > span.info");
		$info.html("");
		$("#markGunshotModal > div.modal-body > div.spectrogram").html("").hide();
		if((cur_end == "") || (cur_start == ""))
		{
			$info.html("Please select start and end");
			return;
		}
		cur_start = parseInt(cur_start);
		cur_end = parseInt(cur_end);
		if(cur_end < cur_start)
		{
			$info.html("Please check start and end");
			return;
		}
		$("#markGunshotModal > div.modal-body > div.line > input.start").val(cur_start);
		$("#markGunshotModal > div.modal-body > div.line > input.end").val(cur_end);
		var videoname = $("#markGunshotModal > input.videoname").val();
		// get the video duration
		// wait till video is ready to get duration
		while(videoSource[videoname]['object'].readyState <= 0)
		{
			await sleep(1000);
		}
		var duration = videoSource[videoname]['object'].duration;
		if(cur_end > duration)
		{
			$info.html("End cannot larger than video duration: "+cur_end+" : "+ duration);
			return;
		}
		if( (cur_end - cur_start) > max_seg_length)
		{
			$info.html("Please select segments shorter than "+max_seg_length+" seconds.");
			return;
		}
		// submit the request to generate images
		getSpecImg(videoname, $("#markGunshotModal > input.videoId").val(), cur_start, cur_end, $info);
	});

	// getting new image done
	cw.ech("#markGunshotModal > div.modal-body > input.specDone", function(){
		var videoname = $("#markGunshotModal > input.videoname").val();
		var cur_start = $("#markGunshotModal > div.modal-body > div.line > input.start").val();
		var cur_end = $("#markGunshotModal > div.modal-body > div.line > input.end").val();
		var $info = $("#markGunshotModal > div.modal-body > div.line > span.info");
		getSpecImg(videoname, $("#markGunshotModal > input.videoId").val(), cur_start, cur_end, $info);
	});

	// click on the spectrogram to mark muzzle blask and shockwave
	cw.ec("#markGunshotModal > div.modal-body > div.spectrogram", function(e){
		var cur_mb = $("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.muzzle_blast").val();
		var cur_shock = $("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.shockwave").val();
		var $info = $("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info");
		if((cur_mb != "") && (cur_shock != ""))
		{
			$info.html("Please clear previous marking first.");
			return;
		}
		if(cur_shock == "")
		{
			var pin_class = "shockwave";
		}
		else
		{	
			var pin_class = "muzzle_blast";
		}
		var gunshotId = $("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block.toggle > input.gunshotId").val();
		var mouse_pin_color = gunshotId_to_color[gunshotId];

		var $mouse_pin = $('<div class="mouse_pin '+pin_class+'"></div>');

		var offset = $(this).offset();
		var mousePos = {
			left: e.pageX - offset.left, // weird, might be < 0
			top: e.pageX - offset.top
		};
		var full_length = $(this).width();
		var mouse_left = mousePos.left < 0 ? 0 : (mousePos.left > full_length? full_length : mousePos.left);
		var mouse_percentage = mouse_left / full_length;

		var seg_start = parseFloat($(this).data("startsec"));
		var seg_end = parseFloat($(this).data("endsec")); 
		var clickTime = seg_start + (seg_end - seg_start)* mouse_percentage;
		// set the input
		if(cur_shock == "")
		{
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.shockwave").val(clickTime);
		}
		else
		{
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.muzzle_blast").val(clickTime);
		}
		
		// put the mouse pin
		mouse_percentage*=100;				
		$mouse_pin.css({
			"left": mouse_percentage+"%",
			"borderLeft": "2px solid "+mouse_pin_color,
		});
		$(this).append($mouse_pin);
	});

	// save the marking
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.markCtr > div.save", function(){
		var data = {};
		data.muzzleBlastTime = $(this).parent().children("input.muzzle_blast").val();
		data.shockwaveTime = $(this).parent().children("input.shockwave").val();
		data.angleMin = $(this).parent().children("input.angleMin").val();
		data.angleMax = $(this).parent().children("input.angleMax").val();
		data.elevation = $(this).parent().children("input.elevation").val();
		if(data.muzzleBlastTime == "")
		{
			$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html("Muzzle blast time cannot be empty");
			return;
		}
		data.muzzleBlastTime = parseFloat(data.muzzleBlastTime);
		data.shockwaveTime = data.shockwaveTime==""?-1:parseFloat(data.shockwaveTime);
		data.angleMin = data.angleMin==""?-1:parseFloat(data.angleMin);
		data.angleMax = data.angleMax==""?-1:parseFloat(data.angleMax);
		data.elevation = parseFloat(data.elevation);
		data.videoId = $("#markGunshotModal > input.videoId").val();
		data.gunshotId = $("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block.toggle > input.gunshotId").val();
		$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html('<div class="loading"></div>');
		cw.post(cw.url + "newLGunshotInVideo", data, function(result){
			if(result.status == 0)
			{
				$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html('done').emptyLater();
			}
			else
			{
				$("#markGunshotModal > div.modal-body > div.line > div.markCtr > span.info").html(result.error);
			}
		});
	});

	var videoPlayingInterval = null;
	var videoObject = null;
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.markCtr > div.playSeg", function(){
		var seg_start = parseFloat($("#markGunshotModal > div.modal-body > div.spectrogram").data("startsec"));
		var videoname = $("#markGunshotModal > input.videoname").val();
		videoSource[videoname]['object'].currentTime = seg_start;
		videoSource[videoname]['object'].play();
		// update the time_pin every k ms
		var freq = 10;
		videoObject = videoSource[videoname]['object'];
		videoPlayingInterval = setInterval(updateTimelinePin, freq);
	});
	function updateTimelinePin()
	{
		if(videoObject == null)
		{
			return;
		}
		var duration = videoObject.duration;
		if(!isNaN(duration))
		{
			var currentTime = videoObject.currentTime;
			var percentage = currentTime/duration;
			percentage*=100;				
			$("#markGunshotModal > div.modal-body > div.line > div.timeline > div.playback").css({"left":percentage+"%"});
			// also update the spectrogram time pin if the video time is with in that
			// 1. has spectrogram showing
			$spectrogram = $("#markGunshotModal > div.modal-body > div.spectrogram");
			if($spectrogram.is(":visible"))
			{
				var seg_start = parseFloat($spectrogram.data("startsec"));
				var seg_end = parseFloat($spectrogram.data("endsec"));
				if((seg_start >= 0) && (seg_end > 0) && (seg_end - seg_start > 0))
				{
					// current time is within the segment
					if((currentTime >= seg_start) && (currentTime <= seg_end))
					{
						var percentage = (currentTime - seg_start) / (seg_end - seg_start);
						percentage*=100;				
						$spectrogram.children("div.playback").show().css({"left":percentage+"%"});
					}
					else
					{
						$spectrogram.children("div.playback").hide();
					}
				}
			}
		}
	}
	cw.ec("#markGunshotModal > div.modal-body > div.line > div.markCtr > div.stop", function(){	
		var videoname = $("#markGunshotModal > input.videoname").val();
		videoSource[videoname]['object'].pause();
	});

	//-------------------------------------------- localization
	function removeOverlays()
	{
		for(var canvas_dom_id in all_canvasIds)
		{
			var OverlayObject = all_canvasIds[canvas_dom_id];
			OverlayObject.setMap(null);
		}
	}
	//click a gunshot, load the gunshotInVideo
	cw.ec("#main > div.localization > div.gunshotList > div.block", function(){
		if(!$(this).hasClass("toggle"))
		{
			$("#main > div.localization > div.gunshotList > div.block").removeClass("toggle");
			$(this).addClass("toggle");
			// load the previous marking results
			var data = {};
			data.gunshotId = $(this).children("input.gunshotId").val();
			data.datasetId = $("#main > input.datasetId").val();
			$("#main > div.localization > div.gunshotInVideoList").html('<div class="loading"></div>');	
			// clear up the previous stuff?
			removeOverlays();
			
			cw.post(cw.url + "getLGunshotAllInVideos", data, function(result){
				$("#main > div.localization > div.gunshotInVideoList").html('');
				if(result.status == 0)
				{
					for(var i=0;i<result.gunshotMarks.length;++i)
					{
						$("#main > div.localization > div.gunshotInVideoList").append(makeGunshotMarkBlock(result.gunshotMarks[i], i+1, gunshot_colors[i]))
					}
					load_markers_to_map();
				}
			});
		}
	});

	var google_map_initialized = 0;
	// get google map and also save event info
	cw.ec("#main > div.localization > div.mapCtr > div.line > div.getMap", function(){
		var event_latitude = $(this).parent().children("input.eventLatitude").val();
		var event_longitude = $(this).parent().children("input.eventLongitude").val();
		var event_radius = $(this).parent().children("input.eventRadius").val();
		var soundSpeedMax = $(this).parent().children("input.soundSpeedMax").val();
		var soundSpeedMin = $(this).parent().children("input.soundSpeedMin").val();
		if((event_latitude == "") || (event_longitude == "") || (event_radius == "") || (soundSpeedMax == "") || (soundSpeedMin == ""))
		{
			$("#main > div.localization > div.mapCtr > div.line > span.info").html("Please enter valid event location, radius, and sound speed");
			return;
		}
		// save the event location info
		var data = {};
		data.datasetId = $("#main > input.datasetId").val();
		data.latitude = event_latitude;
		data.longitude = event_longitude;
		data.radius = event_radius;
		data.soundSpeedMin = soundSpeedMin;
		data.soundSpeedMax = soundSpeedMax;
		$("#main > div.localization > div.mapCtr > div.line > span.info").html('<div class="loading"></div>');
		cw.post(cw.url + "saveEventInfo", data, function(result){
			if(result.status == 0)
			{
				$("#main > div.localization > div.mapCtr > div.line > span.info").html("Done").emptyLater();
				if(google_map_initialized == 0)
				{
					$.getScript("https://maps.googleapis.com/maps/api/js?key=&callback=initMap&libraries=geometry", function(){
						// when loaded the script
						// our custom canvas overlay class
						CanvasOverlay_method1 = declare_canvas_class_method1();
						CanvasOverlay_method2 = declare_canvas_class_method2();
					});
				}
			}
			else
			{
				$("#main > div.localization > div.mapCtr > div.line > span.info").html(result.error);
			}
		});
	});
	// save the camera location marking
	cw.ec("#main > div.localization > div.mapCtr > div.line > div.save", function(){
		var data = {};
		data.gunshotMarks = new Array();
		$("#main > div.localization > div.gunshotInVideoList > div.block").each(function(){
			if($(this).find("input.latitude").val() != "")
			{
				var temp = {};
				temp.latitude = $(this).find("input.latitude").val();
				temp.longitude = $(this).find("input.longitude").val();
				temp.gunshotMarkId = $(this).find("input.gunshotMarkId").val();
				data.gunshotMarks.push(temp);
			}
		});
		if(data.gunshotMarks.length == 0)
		{
			$(this).parent().children("span.info").html("Please label camera location first");
			return;
		}
		$("#main > div.localization > div.mapCtr > div.line > span.info").html('<div class="loading"></div>');
		cw.post(cw.url + "saveCameraLocations", data, function(result){
			if(result.status == 0)
			{
				$("#main > div.localization > div.mapCtr > div.line > span.info").html("done").emptyLater();

			}
			else
			{
				$("#main > div.localization > div.mapCtr > div.line > span.info").html(result.error);
			}
		});
	});
	//-------------------------------------------------Google map shit
	var google_map = null;
	var google_map_streetview = null;
	var map_is_idle = 0; // when user zoom, pan, change map type, 
	var current_markers = {}; // the markers that are on the map, so each should have latLng

	// clear the gunshot Marker
	cw.ec("#main > div.localization > div.gunshotInVideoList > div.block > div.clearLatLng", function(){
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		
		// save the current marker lat lng for retrieve latter
		var lat = $(this).parent().children("input.latitude").val();
		var lng = $(this).parent().children("input.longitude").val();
		if((lat != "") && (lng != ""))
		{
			var gunshotMarkId = $(this).parent().children("input.gunshotMarkId").val();
			current_markers[gunshotMarkId].setMap(null);
			$(this).parent().children("input.prevLat").val(lat);
			$(this).parent().children("input.prevLng").val(lng);
			$(this).parent().children("input.latitude").val("")
				.parent().children("input.longitude").val("");
			delete current_markers[gunshotMarkId];
			// also remove the overlays
			removeOverlays();
		}
	});
	cw.ec("#main > div.localization > div.gunshotInVideoList > div.block > div.copyLatLng", function(){
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		
		// save the current marker lat lng for retrieve latter
		var lat = $(this).parent().children("input.latitude").val();
		var lng = $(this).parent().children("input.longitude").val();
		if((lat != "") && (lng != ""))
		{
			$("#main > div.localization > div.mapCtr > input.copyLat").val(lat);
			$("#main > div.localization > div.mapCtr > input.copyLng").val(lng);
		}
	});
	cw.ec("#main > div.localization > div.gunshotInVideoList > div.block > div.pasteLatLng", function(){
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		
		// save the current marker lat lng for retrieve latter
		var lat = $("#main > div.localization > div.mapCtr > input.copyLat").val();
		var lng = $("#main > div.localization > div.mapCtr > input.copyLng").val();
		if((lat != "") && (lng != ""))
		{
			$(this).parent().children("input.latitude").val(lat);
			$(this).parent().children("input.longitude").val(lng);
			var gunshotMarkId = $(this).parent().find("input.gunshotMarkId").val();
			var marker_color = $(this).parent().children("input.color").val();
			var marker = new google.maps.Marker({
				position: {lat: parseFloat(lat), lng: parseFloat(lng)},
				map: google_map,
				draggable: true,
				icon: "https://maps.google.com/mapfiles/ms/icons/"+marker_color+"-dot.png",
				"gunshotMarkId": gunshotMarkId,
			}); 

			// add drag event to the marker
			marker.addListener('drag', dragMarkerEvent);
			marker.addListener('dragend', dragMarkerEvent);
			// add the current marker to our dict
			current_markers[gunshotMarkId] = marker;
		}
	});
	
	cw.ec("#main > div.localization > div.gunshotInVideoList > div.block > div.getPrevLatLng", function(){
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		var lat = $(this).parent().children("input.prevLat").val();
		var lng = $(this).parent().children("input.prevLng").val();
		
		// put the marker on the map
		if((lat != "") && (lng != ""))
		{
			$(this).parent().children("input.latitude").val(lat);
			$(this).parent().children("input.longitude").val(lng);
			var gunshotMarkId = $(this).parent().find("input.gunshotMarkId").val();
			var marker_color = $(this).parent().children("input.color").val();
			var marker = new google.maps.Marker({
				position: {lat: parseFloat(lat), lng: parseFloat(lng)},
				map: google_map,
				draggable: true,
				icon: "https://maps.google.com/mapfiles/ms/icons/"+marker_color+"-dot.png",
				"gunshotMarkId": gunshotMarkId,
			}); 

			// add drag event to the marker
			marker.addListener('drag', dragMarkerEvent);
			marker.addListener('dragend', dragMarkerEvent);
			// add the current marker to our dict
			current_markers[gunshotMarkId] = marker;
		}
	});
	// delete the gunshot marking
	cw.ec("#main > div.localization > div.gunshotInVideoList > div.block > div.deleteGunshotMark", function(){
		if(!confirm("Confirm delete this gunshot marking"))
		{
			return;
		}
		var data = {};
		data.gunshotMarkId = $(this).parent().children("input.gunshotMarkId").val();
		data.videoId = $(this).parent().children("input.videoId").val();
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url + "deleteGunshotMark", data, function(result){
			var $topBlock = $(this);
			if(result.status == 0)
			{
				
				load_gunshot_videos($("#main > input.datasetId").val());
				var gunshotMarkId = $(this).children("input.gunshotMarkId").val();
				if(current_markers[gunshotMarkId] != null)
				{
					current_markers[gunshotMarkId].setMap(null);
					delete current_markers[gunshotMarkId];
				}		
				$topBlock.remove();
			}
			else
			{

			}
		}, $(this).parent());
	});
	// get the center of the current map
	cw.ec("#main > div.localization > div.mapCtr > div.line > div.getCenter", function() {
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		var latLng = google_map.getCenter();
		$("#main > div.localization > div.mapCtr > div.line > input.eventLatitude").val(latLng.lat());
		$("#main > div.localization > div.mapCtr > div.line > input.eventLongitude").val(latLng.lng());
	});
	
	function initMap() 
	{
		var event_latitude = parseFloat($("#main > div.localization > div.mapCtr > div.line > input.eventLatitude").val());
		var event_longitude = parseFloat($("#main > div.localization > div.mapCtr > div.line > input.eventLongitude").val());
		var event_radius = parseFloat($("#main > div.localization > div.mapCtr > div.line > input.eventRadius").val());

		google_map = new google.maps.Map($("#googleMap")[0], {
			center: new google.maps.LatLng(event_latitude, event_longitude),
			zoom: 18, // >= 18 to have 3d reconstruction
			mapTypeId: google.maps.MapTypeId.HYBRID
		});
		google_map_streetview = google_map.getStreetView();

		// when click on the map , add camera marker if any empty
		google_map.addListener("click", function(e){
			$("#main > div.localization > div.gunshotInVideoList > div.block").each(function(){
				if($(this).find("input.latitude").val() == "")
				{
					var marker_color = $(this).children("input.color").val();
					$(this).find("input.latitude").val(e.latLng.lat());
					$(this).find("input.longitude").val(e.latLng.lng());
					var gunshotMarkId = $(this).find("input.gunshotMarkId").val();
					var marker = new google.maps.Marker({
						position: e.latLng,
						map: google_map,
						draggable: true,
						icon: "https://maps.google.com/mapfiles/ms/icons/"+marker_color+"-dot.png",
						"gunshotMarkId": gunshotMarkId,
					}); 

					// add drag event to the marker
					marker.addListener('drag', dragMarkerEvent);
					marker.addListener('dragend', dragMarkerEvent);
					// add the current marker to our dict
					current_markers[gunshotMarkId] = marker;
					return false;
				}
			});
		});
		// every time finished zoom is change, rotate, change type of map, pan
		google_map.addListener("idle", function(e){
			map_is_idle = 1;
		});
		// all the things user will do to make a new loading
		busy_events = [
			"bounds_changed",
			"center_changed",
			"heading_changed",
			"maptypeid_changed",
			"projection_changed",
			"tilt_changed",
			"zoom_changed"
		];
		for(var k in busy_events)
		{
			google_map.addListener(busy_events[k], function(e){
				map_is_idle = 0;
			});
		}
		
		google_map_initialized = 1;	
		// load the current camera location
		load_markers_to_map(); // may be called already when click a gunshot
	}
	function dragMarkerEvent(event) {
		var marker = this;
		var gunshotMarkId = marker.get("gunshotMarkId");
		$('#main > div.localization > div.gunshotInVideoList > div.block > input.gunshotMarkId[value="'+gunshotMarkId+'"]').parent().children("input.latitude").val(event.latLng.lat())
				.parent().children("input.longitude").val(event.latLng.lng());
	}
	function load_markers_to_map()
	{
		if(google_map_initialized == 0)
		{
			return;
		}
		// empty the marker list
		for(var id in current_markers)
		{
			current_markers[id].setMap(null);
		}
		current_markers = {};
		$("#main > div.localization > div.gunshotInVideoList > div.block").each(function(){
			if($(this).find("input.latitude").val() != "")
			{
				var marker_color = $(this).children("input.color").val();
				var lat = $(this).find("input.latitude").val();
				var lng = $(this).find("input.longitude").val();
				var gunshotMarkId = $(this).find("input.gunshotMarkId").val();
				var marker = new google.maps.Marker({
					position: {lat: parseFloat(lat), lng: parseFloat(lng)},
					map: google_map,
					draggable: true,
					icon: "https://maps.google.com/mapfiles/ms/icons/"+marker_color+"-dot.png",
					"gunshotMarkId": gunshotMarkId,
				}); 

				// add drag event to the marker
				marker.addListener('drag', dragMarkerEvent);
				marker.addListener('dragend', dragMarkerEvent);
				// add the current marker to our dict
				current_markers[gunshotMarkId] = marker;
			}
		});
	}
	// ----------------------- gunshot localization stuff

	// rememeber these 
	var markers_for_method1 = new Array();
	var markerPairs_for_method2 = new Array();
	// anaylze this one gunshot, using method 1 and method 2
	cw.ec("#main > div.localization > div.mapCtr > div.line > div.analyze", function(){
		if(google_map_initialized == 0)
		{
			$(this).parent().children("span.info").html("Please load the map first!").emptyLater();
			return;
		}
		// remove all current overlay first
		removeOverlays();
		// get some general parameters
		var event_radius = $("#main > div.localization > div.mapCtr > div.line > input.eventRadius").val();
		var soundSpeedMin = $("#main > div.localization > div.mapCtr > div.line > input.soundSpeedMin").val();
		var soundSpeedMax = $("#main > div.localization > div.mapCtr > div.line > input.soundSpeedMax").val();
		if((event_radius == "") || (soundSpeedMin == "") || (soundSpeedMax == ""))
		{
			$(this).parent().children("span.info").html("Please enter radius, sound speed").emptyLater();
			return;
		}
		var bulletSpeedMin = $("#main > div.localization > div.gunshotList > div.block.toggle > input.bulletSpeedMin").val();
		var bulletSpeedMax = $("#main > div.localization > div.gunshotList > div.block.toggle > input.bulletSpeedMax").val();

		event_radius = parseFloat(event_radius);
		soundSpeedMax = parseFloat(soundSpeedMax);
		soundSpeedMin = parseFloat(soundSpeedMin);
		bulletSpeedMax = parseFloat(bulletSpeedMax);
		bulletSpeedMin = parseFloat(bulletSpeedMin);

		// check all gunshot mark, get the ones ready for method 1 & pairs ready for method 2
		markers_for_method1 = new Array();
		markerPairs_for_method2 = new Array();

		// method 1: require latLng,  muzzle blast time and shockwave time, angle range, elevation
		// current_markers are the ones with latLng
		// traverse all gunshot mark for this gunshot
		$("#main > div.localization > div.gunshotInVideoList > div.block").each(function(){
			var markerId = $(this).children("input.gunshotMarkId").val();
			if(markerId in current_markers) // so it is mark on the map
			{
				var muzzleBlastTime = $(this).children("input.muzzleBlastTime").val();
				var shockwaveTime = $(this).children("input.shockwaveTime").val();
				var angleMin = $(this).children("input.angleMin").val();
				var angleMax = $(this).children("input.angleMax").val();
				var elevation = $(this).children("input.elevation").val();
				muzzleBlastTime = muzzleBlastTime == "" ? -1 : parseFloat(muzzleBlastTime);
				shockwaveTime = shockwaveTime == "" ? -1 : parseFloat(shockwaveTime);
				angleMin = angleMin == "" ? -1 : angleMin;
				angleMax = angleMax == "" ? -1 : angleMax;
				
				if((muzzleBlastTime >= 0) && (shockwaveTime >=0) && (angleMin >= 0) && (angleMax >= 0) && (muzzleBlastTime - shockwaveTime > 0))
				{
					markers_for_method1.push({
						"markerId" : markerId,
						"time_diff" : muzzleBlastTime - shockwaveTime,
						"angleMin" : parseFloat(angleMin),
						"angleMax" : parseFloat(angleMax),
						"elevation" :  parseFloat(elevation),
						"event_radius" : parseFloat(event_radius),
						"soundSpeedMax" : soundSpeedMax,
						"soundSpeedMin" : soundSpeedMin,
						"bulletSpeedMin" : bulletSpeedMin,
						"bulletSpeedMax" : bulletSpeedMax,
						// later will add min_dist/max_dist/mean_dist to here
					});
				}
			}
		});
		
		// method 2, check each pair, need latLng, video global time offset, and their muzzleBlastTime, and sound speed
		var num_mark_block = $("#main > div.localization > div.gunshotInVideoList > div.block").length;
		for(var i=0;i<num_mark_block-1;++i)
		{
			for(var j=i+1; j < num_mark_block;++j)
			{
				var marker_block1 = $("#main > div.localization > div.gunshotInVideoList > div.block").eq(i);
				var marker_block2 = $("#main > div.localization > div.gunshotInVideoList > div.block").eq(j);
				var markerId1 = marker_block1.children("input.gunshotMarkId").val();
				var markerId2 = marker_block2.children("input.gunshotMarkId").val();

				var time_offset1 = marker_block1.children("input.time_offset").val();
				var time_offset2 = marker_block2.children("input.time_offset").val();
				var muzzleBlastTime1 = marker_block1.children("input.muzzleBlastTime").val();
				var muzzleBlastTime2 = marker_block2.children("input.muzzleBlastTime").val();
				muzzleBlastTime1 = muzzleBlastTime1 == "" ? -1 : muzzleBlastTime1;
				muzzleBlastTime2 = muzzleBlastTime2 == "" ? -1 : muzzleBlastTime2;
				if((time_offset1 != "") && (time_offset2 != "") && (muzzleBlastTime1 >= 0) && (muzzleBlastTime2 >= 0) && (markerId1 in current_markers) && (markerId2  in current_markers))
				{
					muzzleBlastTime1 = parseFloat(muzzleBlastTime1);
					time_offset1 = parseFloat(time_offset1);
					muzzleBlastTime2 = parseFloat(muzzleBlastTime2);
					time_offset2 = parseFloat(time_offset2);

					// compute the sound time diff
					var muzzle_blast1_global_time = time_offset1 + muzzleBlastTime1;
					var muzzle_blast2_global_time = time_offset2 + muzzleBlastTime2;
					var time_diff = muzzle_blast1_global_time - muzzle_blast2_global_time;

					// > 0 means marker 2 hear the gunshot first

					// always make sure the marker 2 hear the gunshot first
					if (time_diff >= 0)
					{
						markerPairs_for_method2.push({
							"markerId1" : markerId1,
							"markerId2" : markerId2,
							"time_diff" : time_diff,
							"event_radius" :  event_radius,
							"soundSpeedMax" :  soundSpeedMax,
							"soundSpeedMin" :  soundSpeedMin,
						});
					}
					else
					{
						markerPairs_for_method2.push({
							"markerId1" : markerId2,
							"markerId2" : markerId1,
							"time_diff" : - time_diff,
							"event_radius" :  event_radius,
							"soundSpeedMax" :  soundSpeedMax,
							"soundSpeedMin" :  soundSpeedMin,
						});
					}
					
				}
			}
		}
		// method 1 need to send to python backend
		if (markers_for_method1.length > 0)
		{
			var data = {};
			data.datasetId = $("#main > input.datasetId").val();
			data.markers = markers_for_method1;
			$(this).parent().children("span.info").html('<div class="loading"></div>');
			cw.post(cw.url + "runMethod1", data, function(result){
				$("#main > div.localization > div.mapCtr > div.line > span.info").html('');
				if(result.status == 0)
				{
					// directly get from database
					if(result.hasResult == 1)
					{
						// update the method1 data for drawing
						updateMethod1Result(markers_for_method1, result.method1result);
						drawMethod1ForMarkers(google_map, markers_for_method1);
						drawMethod2ForMarkerPairs(google_map, markerPairs_for_method2);
					}
					else
					{
						if((result.processStatus == 0) && (result.processId != null))
						{
							//start monitoring the process
							$("#method1Progress > input.processId").val(result.processId);
							$("#method1Progress > input.showing").val(1).change();
							$("#method1Progress > input.updating").val(1).change();
							// remember the processId to retrieve data
							$("#main > div.localization > div.mapCtr > input.method1processId").val(result.processId);
						}
					}
					
				}
				else
				{
					console.log(result);
				}
			});
		}
		else
		{
			// method 2 can be drawn here
			drawMethod2ForMarkerPairs(google_map, markerPairs_for_method2);
		}
		return;
		// the following is for demo testing
		// go through each camera location for this gunshot using method 1
		var markerIds = new Array();
		for(var markerId in current_markers)
		{
			var markerLatLng = current_markers[markerId].getPosition();
			// 1. use the event radius to get a square space for canvas
			var bounds = getEventCanvasBounds(markerLatLng, event_radius);
			
			// test1: draw using method 1 for camera 1
			// in meters 
			if(markerId == 1)
			{
				var min_dist = 112.81;
				var max_dist = 190.07;
				var mean_dist = 145.53;
			}
			else
			{
				var min_dist = 127.810773226;
				var max_dist = 214.658760783;
				var mean_dist = 165.235558746;
			}
			var overlay = new CanvasOverlay_method1(bounds, google_map, event_radius, markerId, [min_dist, max_dist, mean_dist]); // draw every time needed

			markerIds.push(markerId);
		}
		// go through pair of gunshot for method 2

		for(var i=0;i < markerIds.length-1;++i)
		{
			for(var j=i+1;j < markerIds.length;++j)
			{
				var marker1LatLng = current_markers[markerIds[i]].getPosition();
				var marker2LatLng = current_markers[markerIds[j]].getPosition();
				var markers_center = new google.maps.LatLng((marker1LatLng.lat() + marker2LatLng.lat()) / 2.0, (marker1LatLng.lng() + marker2LatLng.lng()) / 2.0);

				var bounds = getEventCanvasBounds(markers_center, event_radius);

				// distance between two camera, two foci, in meters
				//var f1f2 = google.maps.geometry.spherical.computeDistanceBetween(marker1LatLng, marker2LatLng);
				// console.log(f1f2);
				// test 2: draw hyperbola for 1 & 4
				// cam4 -> cam1 offset: [0.016~0.049~0.082]
				var time_diff = 0.049;
				var overlay = new CanvasOverlay_method2(bounds, google_map, event_radius, [markerIds[i], markerIds[j]], time_diff, soundSpeedMin, soundSpeedMax); // draw every time needed
			}
		}
	});
	// when finished
	cw.ech("#main > div.localization > div.mapCtr > input.method1done", function(){
		var data = {};
		data.processId = $(this).parent().children("input.method1processId").val();
		data.datasetId = $("#main > input.datasetId").val();
		$(this).parent().find("div.line > span.info").html("<div class='loading'></div>");
		cw.post(cw.url + "getMethod1Result", data, function(result){
			$("#main > div.localization > div.mapCtr > div.line > span.info").html('');
			if(result.status == 0)
			{
				updateMethod1Result(markers_for_method1, result.method1result);
				drawMethod1ForMarkers(google_map, markers_for_method1);
				drawMethod2ForMarkerPairs(google_map, markerPairs_for_method2);
			}
			else
			{
				console.log(result);
			}
		});
	});
	// given a dict of markerId-> dists result, update the global markers for method1 
	function updateMethod1Result(previous_markers, method1result)
	{
		for(var k in previous_markers)
		{
			var markerId = previous_markers[k]['markerId'];
			if(markerId in method1result)
			{
				previous_markers[k]['min_dist'] = method1result[markerId]['min_dist'];
				previous_markers[k]['max_dist'] = method1result[markerId]['max_dist'];
				previous_markers[k]['mean_dist'] = method1result[markerId]['mean_dist'];
			}
		}
	}
	// get overlay object for makers
	function drawMethod1ForMarkers(map, markers)
	{
		var drawIt = $("#main > div.localization > div.mapCtr > div.line > input.showMethod1").prop("checked");
		if(!drawIt)
		{
			return;
		}
		for(var k in markers)
		{
			var marker = markers[k];
			var markerId = marker['markerId'];
			var min_dist = marker['min_dist'];
			var max_dist = marker['max_dist'];
			var mean_dist = marker['mean_dist'];
			var event_radius = marker['event_radius'];
			if((min_dist != null) && (max_dist != null) && (mean_dist != null))
			{
				var markerLatLng = current_markers[markerId].getPosition();
				// 1. use the event radius to get a square space for canvas
				var bounds = getEventCanvasBounds(markerLatLng, event_radius);
				var overlay = new CanvasOverlay_method1(bounds, map, event_radius, markerId, [min_dist, max_dist, mean_dist]); // draw every time needed

			}
		}
	}
	// get overlay object for maker pairs
	function drawMethod2ForMarkerPairs(map, markerPairs)
	{
		var drawIt = $("#main > div.localization > div.mapCtr > div.line > input.showMethod2").prop("checked");
		if(!drawIt)
		{
			return;
		}
		for(var k in markerPairs)
		{
			var markerPair = markerPairs[k];
			var markerId1 = markerPair['markerId1'];
			var markerId2 = markerPair['markerId2'];
			var time_diff = markerPair['time_diff'];
			var event_radius = markerPair['event_radius'];
			var soundSpeedMin = markerPair['soundSpeedMin'];
			var soundSpeedMax = markerPair['soundSpeedMax'];
			var marker1LatLng = current_markers[markerId1].getPosition();
			var marker2LatLng = current_markers[markerId2].getPosition();
			var markers_center = new google.maps.LatLng((marker1LatLng.lat() + marker2LatLng.lat()) / 2.0, (marker1LatLng.lng() + marker2LatLng.lng()) / 2.0);

			var bounds = getEventCanvasBounds(markers_center, event_radius);

			var overlay = new CanvasOverlay_method2(bounds, map, event_radius, [markerId1, markerId2], time_diff, soundSpeedMin, soundSpeedMax); // draw every time needed
		}
	}
	function getEventCanvasBounds(markerLatLng, event_radius)
	{
		// go south then west
		var sLatLng = google.maps.geometry.spherical.computeOffset(markerLatLng, event_radius, 180);
		var swLatLng = google.maps.geometry.spherical.computeOffset(sLatLng, event_radius, 270);
		
		var nLatLng = google.maps.geometry.spherical.computeOffset(markerLatLng, event_radius, 0);
		var neLatLng = google.maps.geometry.spherical.computeOffset(nLatLng, event_radius, 90);
		var bounds = new google.maps.LatLngBounds(swLatLng, neLatLng);
		return bounds;
	}

	// invoke when load the google script
	var CanvasOverlay_method1;
	var CanvasOverlay_method2;
	var all_canvasIds = {};// canvas Id => overlay object
	function setupCanvas(obj)
	{
		// 1. get the canvas into correct position based on the bounds in lat long
		// We use the south-west and north-east
		// coordinates of the overlay to peg it to the correct position and size.
		var overlayProjection = obj.getProjection();

		// Retrieve the south-west and north-east coordinates of this overlay
		// in LatLngs and convert them to pixel coordinates.
		// We'll use these coordinates to resize the div.
		var sw = overlayProjection.fromLatLngToDivPixel(obj.bounds_.getSouthWest());
		var ne = overlayProjection.fromLatLngToDivPixel(obj.bounds_.getNorthEast());

		// Resize the canvas to fit the indicated dimensions.
		//console.log(google_map.getTilt()); > 0 means 45 degree unage
		var is_45degree_view = google_map.getTilt() !== 0;
		var heading = google_map.getHeading() || 0; // 270 for facing west, 90 for east

		var canvas = obj.canvas_;
		if(is_45degree_view && (heading != 0))
		{
			if(heading == 270) // facing west
			{
				var left = sw.x;
				var top = sw.y;
			}
			else if(heading == 180)// south
			{
				var left = ne.x;
				var top = sw.y;
			}
			else// east
			{
				var left = ne.x;
				var top = ne.y;
			}
		}
		else
		{
			// facing north
			var left = sw.x;
			var top = ne.y;			
		}
		var width = Math.abs(ne.x - sw.x);
		var height = Math.abs(sw.y - ne.y);
		
		canvas.style.left = left + 'px';
		canvas.style.top = top + 'px';
		canvas.style.width = width + 'px';
		canvas.style.height = height + 'px';
		// we set the canvas logical dimension to be in meters, 
		// so when we draw on canvas, we can assume a 2r square meters area, and the camera is in the middle
		canvas.width = obj.eventRadius * 2;
		canvas.height = obj.eventRadius * 2;
		//console.log(width/height); // not 1:1 when change to 45 degree view
	}
	function declare_canvas_class_method1(){
		CanvasOverlay.prototype = new google.maps.OverlayView();
		/** @constructor */
		function CanvasOverlay(bounds, map, eventRadius, markerId, dists) {

			// Initialize all properties.
			this.bounds_ = bounds;
			this.map_ = map;

			this.markerId = markerId;

			this.dom_id = "google_map_canvas_markerId_" + markerId;

			var el = document.getElementById(this.dom_id);
			if(el != null)
			{
				el.remove(this.dom_id);
			}
			all_canvasIds[this.dom_id] = this;
			
			// Define a property to hold the image's div. We'll
			// actually create this div upon receipt of the onAdd()
			// method so we'll leave it null for now.
			this.canvas_ = null;
			// for the drawings, in meters.
			this.eventRadius = eventRadius;

			// dists is a list of [min_dist, max_dist, mean_dist]
			this.dists = dists;

			// Explicitly call setMap on this overlay.
			this.setMap(map);
			//this.setMap(google_map_streetview); // TODO: make this work in the draw function!
		}
		CanvasOverlay.prototype.onAdd = function() {
			var canvas = document.createElement('canvas');
			canvas.style.borderStyle = 'none';
			canvas.style.borderWidth = '0px';
			//canvas.style.opacity = 0.4; // use opacity for each element instead
			canvas.style.position = 'absolute';
			
			//canvas.style.backgroundColor = 'white'; // for debug
				
			canvas.id = this.dom_id;

			this.canvas_ = canvas;

			// Add the element to the "overlayLayer" pane.
			var panes = this.getPanes();
			panes.overlayLayer.appendChild(canvas);
		};
		// donut
		CanvasOverlay.prototype.draw = function() {
			// wait until idle state
			if (map_is_idle != 1)
			{
				//return; // currently this will fail when panning with mouse, so we draw every time.
 			}
			// 1. get the canvas into correct position based on the bounds in lat long
			setupCanvas(this);
			
			var canvas = this.canvas_;
			// 2. drawing for single or pair markers
			var context = canvas.getContext("2d");
			// clear previous first
			context.clearRect(0, 0, canvas.width, canvas.height);
	
			var min_dist = this.dists[0];
			var max_dist = this.dists[1];
			var mean_dist = this.dists[2];
			
			context.translate(canvas.width/2, canvas.height/2);
			drawMethod1(context, min_dist, max_dist, mean_dist);
			context.translate(-canvas.width/2, -canvas.height/2);
		};
		CanvasOverlay.prototype.onRemove = function() {
			this.canvas_.parentNode.removeChild(this.canvas_);
			this.canvas_ = null;
		};
		return CanvasOverlay;
	}
	function declare_canvas_class_method2(){
		CanvasOverlay.prototype = new google.maps.OverlayView();
		/** @constructor */
		function CanvasOverlay(bounds, map, eventRadius, markerIds, time_diff, soundSpeedMin, soundSpeedMax) {

			// Initialize all properties.
			this.bounds_ = bounds;
			this.map_ = map;

			this.markerIds = markerIds;

			var id_string = this.markerIds[0];
			for(var i=1;i<this.markerIds.length;++i)
			{
				id_string+="_"+this.markerIds[i];
			}
			// marker 2 should hear the gunshot first

			this.dom_id = "google_map_canvas_markerId_" + id_string;
			var el = document.getElementById(this.dom_id);
			if(el != null)
			{
				el.remove(this.dom_id);
			}
			all_canvasIds[this.dom_id] = this;
			
			this.time_diff = time_diff;
			// assuming synchronization we will only off by half a frame, and video fps is 30
			var sync_error_num_frame = 0.5;
			var video_fps = 30.0;
			this.time_diff_error = sync_error_num_frame / video_fps; // error in seconds, so the timediff should be [time_diff - error, time_diff + error]

			this.soundSpeedMax = soundSpeedMax;
			this.soundSpeedMin = soundSpeedMin;

			// Define a property to hold the image's div. We'll
			// actually create this div upon receipt of the onAdd()
			// method so we'll leave it null for now.
			this.canvas_ = null;
			// for the drawings, in meters.
			this.eventRadius = eventRadius;

			// Explicitly call setMap on this overlay.
			this.setMap(map);
			//this.setMap(google_map_streetview); // TODO: make this work in the draw function!
		}
		CanvasOverlay.prototype.onAdd = function() {
			var canvas = document.createElement('canvas');
			canvas.style.borderStyle = 'none';
			canvas.style.borderWidth = '0px';
			//canvas.style.opacity = 0.4; // use opacity for each element instead
			canvas.style.position = 'absolute';
			
			//canvas.style.backgroundColor = 'white'; // for debug
				
			canvas.id = this.dom_id;

			this.canvas_ = canvas;

			// Add the element to the "overlayLayer" pane.
			var panes = this.getPanes();
			panes.overlayLayer.appendChild(canvas);
		};
		// hyperbola
		CanvasOverlay.prototype.draw = function() {
			// wait until idle state
			if (map_is_idle != 1)
			{
				//return; // currently this will fail when panning with mouse, so we draw every time.
			}
			// 1. get the canvas into correct position based on the bounds in lat long
			setupCanvas(this);
			var canvas = this.canvas_;
				
			// 2. drawing for single or pair markers
			var context = canvas.getContext("2d");
			// clear previous first
			context.clearRect(0, 0, canvas.width, canvas.height);
			
			// hyperbola
			// cam1 -> cam 4, 61.8 meters

			// muzzleBlast time diff 0.
			// a hyperbola is defined by x^2/a^2 - y^2/b^2 = 1. 2c is camera distance, 2a is the distance diff from the gunshot to the camera.

			// translate the canvas origin to the center
			context.translate(canvas.width / 2.0, canvas.height / 2.0);
		
			var camera1 = current_markers[this.markerIds[0]];
			var camera2 = current_markers[this.markerIds[1]];

			// lower bound
			var sound_time_diff = this.time_diff - this.time_diff_error;
			var dist_diff = sound_time_diff * this.soundSpeedMin; // this is 2a
			drawMethod2(context, camera1, camera2, dist_diff, this.eventRadius, "aqua");

			// highest prob line
			var sound_time_diff = this.time_diff;
			var dist_diff = sound_time_diff * ((this.soundSpeedMax + this.soundSpeedMin) / 2.0); // this is 2a
			drawMethod2(context, camera1, camera2, dist_diff, this.eventRadius, "lime");

			var sound_time_diff = this.time_diff + this.time_diff_error;
			var dist_diff = sound_time_diff * this.soundSpeedMax; // this is 2a
			drawMethod2(context, camera1, camera2, dist_diff, this.eventRadius, "aqua");

			context.translate(-canvas.width / 2.0, -canvas.height / 2.0);	
		};
		CanvasOverlay.prototype.onRemove = function() {
			this.canvas_.parentNode.removeChild(this.canvas_);
			this.canvas_ = null;
		};
		return CanvasOverlay;
	}
	// assume camera 2 hear the gunshot first
	function drawMethod2(context, camera1, camera2, dist_diff, event_radius, color)
	{
		context.save();
		var iterations = 5000.0; // draw the hyperbola a bit every time

		//based on the time offset of camera 1, 2, we assume camera 2 hear the gunshot first (has smaller time offset)
		// 1. recover the camera 1/2 's meter location in the canvas
		
		// distance between two camera, two foci, in meters
		var f1f2 = google.maps.geometry.spherical.computeDistanceBetween(camera1.getPosition(), camera2.getPosition());
		// cam1 to 2, degree to true north -180 +180
		var heading = google.maps.geometry.spherical.computeHeading(camera1.getPosition(), camera2.getPosition());
		if(heading < 0) // when the camera 1 is not in west
		{
			// so the x axis points towards west
			var rotate_degree = 90 + (180 + heading);
		}
		else
		{
			var rotate_degree = heading - 90; // could be minus zero, so the axis rotate towards north
		}
		// the context rotate the origin west to east x axis down south.

		// need to rotate the context to the map heading first
		var map_heading = google_map.getHeading() || 0; // 270 for facing west, 90 for east
		context.rotate(-map_heading * Math.PI / 180);

		// rotate so that f1f2 is on the x axis
		context.rotate(rotate_degree * Math.PI / 180);

		context.strokeStyle = color; // color of the hyperbola line

		// draw two point at the camera location using the changed canvas coordinates
		
		context.fillStyle = "rgba(255, 0, 0, 0.9)"; // Red color
		context.beginPath(); //Start path
	   		context.arc(-f1f2 / 2.0, 0, 2, 0, Math.PI * 2, true); 
	   		context.arc(f1f2 / 2.0, 0, 2, 0, Math.PI * 2, true); 
		context.fill(); // Close the path and fill.
		// line from origin to camera2, so we know the coordinates system is right
		/*
		context.beginPath();
		context.moveTo(0, 0);
		context.lineTo(f1f2/2.0, 0);
		context.stroke();
		*/

		// so we verified camera1 is the west most one
		// camera1 (-f1f2/2.0, 0), camera2 (f1f2/2.0, 0), in meters
		// 2c is f1f2
		// 2a is the distance different between gunshot to the two camera
		// here the examples, camera 2 hear first, and the time offset is 0.027, sould speed is 343, 
		
		var a = dist_diff / 2.0;
		var c = f1f2 / 2.0;
		var b_square = c*c - a*a;
		var b = Math.sqrt(b_square);

		// origin (0, 0) is in the center of the canvas, so x range is about [-eventRadius, eventRadius]
		var x_range = 2 * event_radius;
		
		var inc = x_range / iterations;
		var min_x = -event_radius;
		var max_x = event_radius;

		// in this example, only f2 camera should have value, so the minx is on the x axis
		var min_x = a;

		// drawing hyperbola

		context.beginPath();
		context.moveTo(min_x, 0); // start drawing from the vertices of hyperbola
		for (var x = min_x + inc; x <= max_x; x += inc)
		{
		   context.lineTo(x, hyperbola(x, a, b, true));
		}
		context.stroke();

		// the approche line
		/*
		context.beginPath();
		context.moveTo(0, 0);
		for (var x = 0 + inc; x <= max_x; x += inc)
		{
		   context.lineTo(x, b*x/a );
		}
		context.stroke();
		*/

		context.moveTo(min_x, 0); // start drawing from the vertices of hyperbola
		for (var x = min_x + inc; x <= max_x; x += inc)
		{
		   context.lineTo(x, hyperbola(x, a, b, false));
		}
		context.stroke();

		context.restore();
	}
	// given x in hyperbola, get y value
	function hyperbola(x, a, b, return_pos)
	{
		var y = (b / a) * Math.sqrt(x*x - a*a);
		if(!return_pos)
		{
			return - y;
		}
		else
		{
			return y;
		}
	}

	// assumeing the canvas context, 0, 0 is the camera location
	function drawMethod1(context, min_dist, max_dist, mean_dist)
	{
		var center = {X: 0, Y: 0};

		// coloring, center is red, outside is green
		var outerColor = "rgba(255, 255, 0, 0.4)";
		var innerColor = "rgba(255, 0, 0, 0.4)";
		var outterRadius = max_dist;
		var innerRadius = min_dist;
		var mean_point = (mean_dist - innerRadius) / (outterRadius - innerRadius);

		var grd = context.createRadialGradient(center.X, center.Y, innerRadius, center.X, center.Y, outterRadius);
		grd.addColorStop(0, outerColor);
		grd.addColorStop(mean_point, innerColor);// so we assume the mean distance is the most probable location
		grd.addColorStop(1.0, outerColor);
		context.fillStyle = grd;
		
		context.beginPath();
			//for incomplete donut
			//context.arc(center.X, center.Y, outterRadius, sRadian, eRadian, false); // Outer: CCW
			//context.arc(center.X, center.Y, innerRadius, eRadian, sRadian, true); // Inner: CW
			context.arc(center.X, center.Y, outterRadius, 0, 2 * Math.PI, false); // Outer: CCW
			context.arc(center.X, center.Y, innerRadius, 0, 2 * Math.PI, true); // Inner: CW
		context.closePath();						 
		context.fill();
	}

	//-------------------------------------------------
	function load_event_location(datasetId)
	{
		var data = {};
		data.datasetId = $("#main > input.datasetId").val();
		$("#main > div.localization > div.mapCtr > div.line > input.eventLongitude").val("")
			.parent().children("input.eventLatitude").val("")
			.parent().children("input.eventRadius").val("")
			.parent().children("input.soundSpeedMax").val("")
			.parent().children("input.soundSpeedMin").val("");
		cw.post(cw.url + "getEventInfo", data, function(result){
			if(result.status==0)
			{
				if(result.dataset.longitude != -1000)
				{
					$("#main > div.localization > div.mapCtr > div.line > input.eventLongitude").val(result.dataset.longitude);
					$("#main > div.localization > div.mapCtr > div.line > input.eventLatitude").val(result.dataset.latitude);
					$("#main > div.localization > div.mapCtr > div.line > input.eventRadius").val(result.dataset.radius);
					$("#main > div.localization > div.mapCtr > div.line > input.soundSpeedMax").val(result.dataset.soundSpeedMax);
					$("#main > div.localization > div.mapCtr > div.line > input.soundSpeedMin").val(result.dataset.soundSpeedMin);
				}	
			}
		});
	}
	function makeGunshotMarkBlock(gunshotMark, idx, color)
	{
		$temp = $('<div class="block" style="border-left:3px solid '+color+'">'+
			'<input class="color" type="hidden" value="'+ color+'"></input>'+
			'<input class="dvId" type="hidden" value="'+ gunshotMark.dvId+'"></input>'+
			'<input class="videoId" type="hidden" value="'+ gunshotMark.videoId+'"></input>'+
			'<input class="time_offset" type="hidden" value="'+ gunshotMark.time_offset+'"></input>'+
			'<input class="muzzleBlastTime" type="hidden" value="'+ gunshotMark.muzzleBlastTime+'"></input>'+
			'<input class="shockwaveTime" type="hidden" value="'+ gunshotMark.shockwaveTime+'"></input>'+
			'<input class="angleMin" type="hidden" value="'+ gunshotMark.angleMin+'"></input>'+
			'<input class="angleMax" type="hidden" value="'+ gunshotMark.angleMax+'"></input>'+
			'<input class="elevation" type="hidden" value="'+ gunshotMark.elevation+'"></input>'+
			'<input class="gunshotMarkId" type="hidden" value="'+gunshotMark.gunshotMarkId+'"></input>'+

			'<input class="prevLat" type="hidden" value=""></input>'+
			'<input class="prevLng" type="hidden" value=""></input>'+
			idx+'. ' +
			gunshotMark.videoname + ", " +
			'shockwaveTime: ' +(gunshotMark.shockwaveTime==-1?"":parseFloat(gunshotMark.shockwaveTime).toFixed(3)) + ", " +
			'muzzleBlastTime: ' + parseFloat(gunshotMark.muzzleBlastTime).toFixed(3) + 
			', Angle ' + gunshotMark.angleMin + " ~ " + gunshotMark.angleMax + 
			', Elevation: ' + gunshotMark.elevation + 
			', global time offset: ' + gunshotMark.time_offset + 
			', video duration: ' + gunshotMark.duration + 
			", <br/> " +
			'Latitude: ' +
			'<input class="input-small latitude" type="text"  value="'+(gunshotMark.latitude==-1000?"":gunshotMark.latitude)+'"></input> ' +
			'Longitude: ' +
			'<input class="input-small longitude" type="text"  value="'+(gunshotMark.longitude==-1000?"":gunshotMark.longitude)+'"></input> '+
			'<div class="btn btn-small clearLatLng">ClearLatLng</div> ' + 
			'<div class="btn btn-small getPrevLatLng">GetPreviousLatLng</div> ' +
			'<div class="btn btn-small copyLatLng">CopyLatLng</div> ' +  
			'<div class="btn btn-small pasteLatLng">PasteLatLng</div> ' +  
			'<div class="btn btn-small deleteGunshotMark">Delete Marking</div> ' + 
			'<span class="text-error info"></span> ' + 
		'</div>');
		return $temp;
	}
	// in the gunshot marking modal, show the mark pin if it is within range
	function displayGunshotMark()
	{
		var segment_startSec = parseFloat($("#markGunshotModal > div.modal-body > div.spectrogram").data("startsec"));
		var segment_endSec = parseFloat($("#markGunshotModal > div.modal-body > div.spectrogram").data("endsec"));
		
		function checkThis(selector, pin_class)
		{
			var mark = $(selector).val();
			//console.log(mark);
			if(mark != "")
			{
				mark = parseFloat(mark);
				
				if ((segment_startSec <= mark) && (mark <= segment_endSec))
				{
					// clear the previous pin first
					$("#markGunshotModal > div.modal-body > div.spectrogram > div.mouse_pin."+pin_class).remove();

					var gunshotId = $("#markGunshotModal > div.modal-body > div.line > div.gunshots > div.block.toggle > input.gunshotId").val();
					var mouse_pin_color = gunshotId_to_color[gunshotId];
					var $mouse_pin = $('<div class="mouse_pin '+pin_class+'"></div>');
					var mouse_percentage = (mark -  segment_startSec) / (segment_endSec - segment_startSec);
					mouse_percentage*=100;				
					$mouse_pin.css({
						"left": mouse_percentage+"%",
						"borderLeft": "2px solid "+mouse_pin_color,
					});
					$("#markGunshotModal > div.modal-body > div.spectrogram").append($mouse_pin);
				}
			}
		};
		checkThis("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.muzzle_blast", "muzzle_blast");
		checkThis("#markGunshotModal > div.modal-body > div.line > div.markCtr > input.shockwave", "shockwave");
	}
	function getSpecImg(videoname, videoId, startSec, endSec, $info)
	{
		var data = {};
		data.videoname = videoname;
		data.videoId = videoId;
		data.startSec = startSec;
		data.endSec = endSec;
		$("#markGunshotModal > div.modal-body > div.spectrogram").html("");
		$info.html("<div class='loading'></div>");
		cw.post(cw.url + "getSpecImg", data, function(result){
			$info.html("");
			if(result.status == 0)
			{
				if(result.hasResult == 1)
				{
					$("#markGunshotModal > div.modal-body > div.spectrogram").append('<img class="img spectrogram" src="'+result.spectrogram+'"></img>');
					$("#markGunshotModal > div.modal-body > div.spectrogram").append('<img class="img power" src="'+result.power+'"></img>');
					// also record the start and end time in here
					$("#markGunshotModal > div.modal-body > div.spectrogram").data("startsec", startSec);
					$("#markGunshotModal > div.modal-body > div.spectrogram").data("endsec", endSec);
					// the playback pin
					$("#markGunshotModal > div.modal-body > div.spectrogram").append('<div class="playback"></div>');
					$("#markGunshotModal > div.modal-body > div.spectrogram").show();
					// load the gunshot marking for this segment if the current marking is within
					displayGunshotMark();	
				}
				else
				{
					if((result.processStatus ==0) && (result.processId != null))
					{
						//start monitoring the process
						$("#getSpecImgProgress > input.processId").val(result.processId);
						$("#getSpecImgProgress > input.showing").val(1).change();
						$("#getSpecImgProgress > input.updating").val(1).change();
					}
					else
					{
						alert(result.processError);
					}
				}
			}
		});
	}
	async function setSegments(segments)
	{
		// set the timeline stuff
		$("#markGunshotModal > div.modal-body > div.line > div.timeline").html("");
		var videoname = $("#markGunshotModal > input.videoname").val();
		// get the video duration
		// wait till video is ready to get duration
		while(videoSource[videoname]['object'].readyState <= 0)
		{
			await sleep(1000);
		}
		var duration = videoSource[videoname]['object'].duration;
		//console.log(duration);
		// get the max score of all the segments
		var maxScore = -1;
		for(var i=0;i<segments.length;++i)
		{
			if(segments[i].score > maxScore)
			{
				maxScore = segments[i].score;
			}
		}
		for(var i=0;i<segments.length;++i)
		{
			if(!isNaN(duration))
			{
				var temp = $('<div class="block" title="'+sec2time(segments[i].startSec)+" to "+sec2time(segments[i].endSec)+', max '+segments[i].score+'">'+
					'<input class="startSec" type="hidden" value="'+segments[i].startSec+'"></input>'+
					'<input class="endSec" type="hidden" value="'+segments[i].endSec+'"></input>'+
					'<input class="classname" type="hidden" value=""></input>'+
					'</div>');
				var width = (segments[i].endSec - segments[i].startSec)/duration;
				width = width*100.0;
				var left = segments[i].startSec/duration;
				left = left*100.0;
				temp.css({"left":left+"%","width":width+"%"});
				//console.log(segments[i].endSec);
				if(duration - segments[i].endSec < 1.0)
				{
					temp.css({"width":"100%"});// so that it cover the tail
				}
				// set the color //background-color:rgb(255,200,0);
				var p = (segments[i].score - parseFloat(conf_thres))/(maxScore-parseFloat(conf_thres));// color relative to threshold
				//alert(p);
				var color = parseInt((1-p)*200);// color for green
				//alert(color);
				temp.css({"backgroundColor":"rgb(255,"+color+",0)"});
				$("#markGunshotModal > div.modal-body > div.line > div.timeline").append(temp);
			}
		}
	}
	$("#markGunshotModal").on('hide', function(){
		// reload the videos
		var datasetId = $("#main > input.datasetId").val();
		load_gunshot_videos(datasetId);
		// reload the gunshot in localization
		load_gunshots(datasetId);
	});
	function makeVideoHtml(videoname, videopath)
	{
		$temp = $('<div class="block">'+
			'<input class="videoname" value="'+videoname+'" type="hidden"></input>'+
				'<video controls style="width:100%;max-height:500px">'+
					'<source src="<?php echo Yii::app()->baseUrl?>/'+videopath+'"></source>'+
				'Your browser does not support the video tag.'+
			'</video>'+
		'</div>');
		
		return $temp;
	}
	function load_gunshot_videos(datasetId)
	{
		var data = {};
		data.datasetId = datasetId;
		$("#main > div.gunshot > div.videoList").html('<div class="loading"></div>');
		cw.post(cw.url + "getVideos", data, function(result){
			$("#main > div.gunshot > div.videoList").html('');
			if(result.status==0)
			{
				for(var i=0;i<result.videos.length;++i)
				{
					$("#main > div.gunshot > div.videoList").append(makeVideoBlock(result.videos[i]));
				}
			}
			else
			{

			}
			$("#main > div.gunshot > div.videoList").append('<div style="clear:both"></div>');
		});
	}
	
	function makeVideoBlock(video)
	{
		if(video.hasImgs)
		{
			var img_i = parseInt(video.imgCount/2);
			imgHtml = '<img class="videoImg" src="<?php echo Yii::app()->baseUrl?>/assets/video_imgs/'+video.videoname +"_"+ img_i+'.png"></img>';
		}
		else
		{
			imgHtml = '';
		}
		
		$temp = $('<div class="block">'+
			'<input class="videoId" type="hidden" value="'+video.videoId+'"></input>' + 
			'<input class="videoname" type="hidden" value="'+video.videoname+'"></input>' + 
			'<input class="relatedPath" type="hidden" value="'+video.relatedPath+'"></input>' + 
			'<div class="line"> <a class="showVideo" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cWatchOne?videoname='+video.videoname+'" target="_blank"><i class="icon icon-eye-open"></i></a> ' +video.videoname+'</div>' + 
			'<div class="line videoImg">'+
				imgHtml +
			'</div>' +
			'<div class="timeline"></div>'+
			'<div class="line">'+
				'<div class="btn btn-info btn-small mark">Mark Gunshot</div>' +
			'</div>'+
		'</div>');
		// check for gunshot marking and put the marking on the timeline
		var duration = parseFloat(video.duration);
		for(var i=0 ; i < video.gunshotMarks.length ; ++i)
		{
			var mark = video.gunshotMarks[i];
			var gunshotId = mark.gunshotId;
			var muzzleBlastTime = mark.muzzleBlastTime;
			var shockwaveTime = mark.shockwaveTime;
			var muzzleBlast_percentage = muzzleBlastTime/duration*100.0;
			$time_pin = $('<div class="time_pin"></div>');
			$time_pin.css({
				"left": muzzleBlast_percentage+"%",
				"borderLeft": "3px solid "+gunshotId_to_color[gunshotId],
			});
			$temp.find("div.timeline").append($time_pin);
			if(shockwaveTime != -1)
			{
				var shockwave_percentage = shockwaveTime/duration*100.0;
				$time_pin = $('<div class="time_pin"></div>');
				$time_pin.css({
					"left": shockwave_percentage+"%",
					"borderLeft": "3px solid "+gunshotId_to_color[gunshotId],
				});
				$temp.find("div.timeline").append($time_pin);
			}
		}
		return $temp;
	}
	var global_gunshots = null;
	function load_gunshots(datasetId)
	{
		var data = {};
		data.datasetId = datasetId;
		$("#main > div.gunshot > div.gunshotList").html("<div class='loading'></div>");
		$("#main > div.localization > div.gunshotList").html("<div class='loading'></div>");
		cw.post(cw.url+"getLGunshots", data, function(result){
			$("#main > div.gunshot > div.gunshotList").html("");
			$("#main > div.localization > div.gunshotList").html("");
			if(result.status == 0)
			{
				global_gunshots = result.gunshots;
				for(var i=0;i<result.gunshots.length;++i)
				{
					$("#main > div.gunshot > div.gunshotList").append(makeGunshotBlock(result.gunshots[i], i+1));
					$("#main > div.localization > div.gunshotList").append(makeGunshotBlock2(result.gunshots[i], i+1));
				}
				$("#main > div.localization > div.gunshotList > div.block").eq(0).trigger(cw.ectype);
			}
			else
			{
				$("#main > div.gunshot > div.line > span.info").html(result.error)
			}
		});
	}
	// this will fail if out-of-index
	// these are the color avaiable in google default marker: https://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977
	var gunshot_colors = [
		"green",
		"blue",
		"yellow",
		"purple",
		"red",
		"orange",
		"pink",
	];
	var gunshotId_to_color = {};
	function makeGunshotBlock(gunshot, idx)
	{
		if(gunshotId_to_color[gunshot.id] == null)
		{
			gunshotId_to_color[gunshot.id] = gunshot_colors[idx-1];
		}
		return $('<div class="block" style="border-top:2px solid '+gunshot_colors[idx-1]+'">' + 
			'<input class="bulletSpeedMin" type="hidden" value="'+gunshot.bulletSpeedMin+'"></input>'+
			'<input class="bulletSpeedMax" type="hidden" value="'+gunshot.bulletSpeedMax+'"></input>'+
			'<div class="line">' +
				'<input class="gunshotId" type="hidden" value="'+gunshot.id+'"></input>'+
				'<input class="gunName" type="hidden" value="'+gunshot.gunName+'"></input>'+
				'<input class="note" type="hidden" value="'+gunshot.note+'"></input>'+
				'<input class="bulletSpeedMin" type="hidden" value="'+gunshot.bulletSpeedMin+'"></input>'+
				'<input class="bulletSpeedMax" type="hidden" value="'+gunshot.bulletSpeedMax+'"></input>'+
				idx + '. ' +
				gunshot.gunName + ', ' +
				'bullet speed: [' + gunshot.bulletSpeedMin + ', ' + gunshot.bulletSpeedMax + '] m/s, ' +
				gunshot.note + 
				" <div class='btn btn-small btn-success edit'>Edit</div>" + 
				'<div class="delete close deleteCss">x</div>' + 
			'</div>' + 
		'</div>');
	}
	// for gunshot marking modal.
	function makeGunshotBlock2(gunshot, idx)
	{
		if(gunshotId_to_color[gunshot.id] == null)
		{
			gunshotId_to_color[gunshot.id] = gunshot_colors[idx-1];
		}
		return $('<div class="block" style="">' + 
			'<input class="bulletSpeedMin" type="hidden" value="'+gunshot.bulletSpeedMin+'"></input>'+
			'<input class="bulletSpeedMax" type="hidden" value="'+gunshot.bulletSpeedMax+'"></input>'+
			'<input class="gunshotId" type="hidden" value="'+gunshot.id+'"></input>'+
			idx + '. ' +
			gunshot.gunName +
			" ( Speed "+ gunshot.bulletSpeedMin + " ~ "+ gunshot.bulletSpeedMax+" m/s )" +
		'</div>');
	}
	//given a score list with time, and threshold, return	consecutive segments
	function getSegments(scoreList,thres)
	{
		// sort first
		scoreList.sort(function(a,b){return a.startSec - b.startSec});
		var segments = new Array();
		curSegment = {};
		for(var i=0;i<scoreList.length;++i)
		{
			var score = scoreList[i];
			
			if(parseFloat(score.score) >= thres)
			{
				if(curSegment.startSec == null)
				{
					curSegment.startSec = parseFloat( score.startSec);
				}
				// save the max score in the merged segments
				if((curSegment.score == null) || (parseFloat(score.score) > curSegment.score))
				{
					curSegment.score = parseFloat(score.score);
				}
				curSegment.endSec = parseFloat(score.endSec);
			}
			else
			{
				// save this segment
				if((curSegment.startSec!=null)&& (curSegment.endSec != null) && (curSegment.endSec < parseFloat(score.startSec)))
				{
					segments.push(curSegment);
					curSegment = {};
				}
			}
		}
		if((curSegment.startSec!=null)&& (curSegment.endSec != null))
		{
			segments.push(curSegment);
		}
		return segments;
	}
	function sec2time(secs)
	{
		var sec_num = secs;
			var hours	 = Math.floor(sec_num / 3600);
			var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
			var seconds = sec_num - (hours * 3600) - (minutes * 60);

			if (hours	 < 10) {hours	 = "0"+hours;}
			if (minutes < 10) {minutes = "0"+minutes;}
			if (seconds < 10) {seconds = "0"+seconds;}
			var time		= hours+':'+minutes+':'+seconds;
			return time;
	}
	function sleep(ms) {
		return new Promise(resolve => setTimeout(resolve, ms));
	}
	function canvas_arrow(context, fromx, fromy, tox, toy){
		var headlen = 10;   // length of head in pixels
		var angle = Math.atan2(toy-fromy,tox-fromx);
		context.moveTo(fromx, fromy);
		context.lineTo(tox, toy);
		context.lineTo(tox-headlen*Math.cos(angle-Math.PI/6),toy-headlen*Math.sin(angle-Math.PI/6));
		context.moveTo(tox, toy);
		context.lineTo(tox-headlen*Math.cos(angle+Math.PI/6),toy-headlen*Math.sin(angle+Math.PI/6));
	}



</script>
