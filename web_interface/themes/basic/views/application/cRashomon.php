<!DOCTYPE HTML>
<html>
  
<head>
  <meta charset="UTF-8" />
  <title></title>
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
  <link type="text/css" href="<?php echo Yii::app()->theme->baseUrl;?>/css/rashomon/jquery-ui-1.8.23.custom.modified.css" rel="Stylesheet" />  
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/jquery.fullscreen-min.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/moment.min.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/popcorn-complete.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/popcorn.rashomonphoto.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/popcorn.rashomonvideo.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/purl.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/jquery.tinysort.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl;?>/css/rashomon/rashomon.css" />
   


  <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/rashomon/bootstrap-grid.css" rel="stylesheet">

  <style>

    #buttons { margin: 4px; }

    #map { width: 100%;
      height: 100%; }

    #resizable { width: 100%; height: 800px; margin-top: 0px;}
    .ui-widget-content {border:none}

    #mapvid {
      position: relative;
      top: 50px;
      width: 100%;
      height: 800px;
      /* Disable selection so it doesn't get annoying */
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: moz-none;
      -ms-user-select: none;
      user-select: none;
    }
    #mapvid #mapWrapper {
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 600px;
      
      /*background: red;*/
    }
    #mapvid #videos {
      position: absolute;
      right: 0;
      top: 0;
      bottom: 0;
      width: -moz-calc(100% - 600px);
      width: -webkit-calc(100% - 600px);
      width: calc(100% - 600px);


      /*background: blue;*/
    }
    #mapvid #verhandle {
      position: absolute;
      right: -4px;
      top: 0;
      bottom: 0;
      width: 8px;
      cursor: col-resize;
    }
    #saveOffsets{
      display: inline-block;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255,255,255,0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
    background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
    background-image: -o-linear-gradient(top,#fff,#e6e6e6);
    background-image: linear-gradient(to bottom,#fff,#e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #ccc;
    border-color: #e6e6e6 #e6e6e6 #bfbfbf;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    border-bottom-color: #b3b3b3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 1px 2px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 1px 2px rgba(0,0,0,0.05);
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
    background-color: #49afcd;
    background-image: -moz-linear-gradient(top,#5bc0de,#2f96b4);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#5bc0de),to(#2f96b4));
    background-image: -webkit-linear-gradient(top,#5bc0de,#2f96b4);
    background-image: -o-linear-gradient(top,#5bc0de,#2f96b4);
    background-image: linear-gradient(to bottom,#5bc0de,#2f96b4);
    background-repeat: repeat-x;
    border-color: #2f96b4 #2f96b4 #1f6377;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    padding: 2px 10px;
    font-size: 11.9px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    user-select: none;
    }
    div.loading{
/*载入中的gif动图，路径以 本文件为基准*/
width:16px;
height:16px;
background:url('<?php echo Yii::app()->theme->baseUrl;?>/assets/images/loading.gif') no-repeat center center;
display:inline-block;
}
  </style>
</head>
<body>
  <script type="text/javascript">
    $(document).ready(function(){

      // Modifying the manifestLoc dynamically. We might have json from database or from given example file.
      Rashomon.manifest = <?php echo Text::json_encode_ch($data);?>;

    });
  </script>
 <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/rashomon/rashomon.js"></script>
 <script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/basic.js"></script>

  <script type="text/javascript">
    cw.ec("#saveOffsets", function(){
      var data = {};
      data.videos = new Array();
      data.datasetId = <?php echo $datasetId?>;
      data.clusterId = <?php echo $clusterId?>;
      $(".vidline > .offsetBox > input.offsetInput").each(function(){
        var offset = $(this).val();
        data.videos.push({
          "offset": offset,
          "videoname": $(this).parent().data("videoname"),
          "resultId": $(this).parent().data("resultid"),
        });
      });
      $("#save_info").html('<div class="loading"></div>');
      //console.log(data);
      cw.post("<?php echo Yii::app()->baseUrl?>/index.php/main/changeVideoSyncResultBatch", data, function(result){
        if(result.status == 0)
        {
          $("#save_info").html('OK');
        }
        else
        {
          $("#save_info").html(result.error);
        }
      });
    });
  </script>

  <section id="titlebar">
    <div class="namebox">
      <div id="title">Run Name  
        <div id="saveOffsets" style="">save offsets</div>
        <span id="save_info" style=""></span>
      </div>
    </div>
    <div id="eventTitle">&nbsp;</div>
  </section>


  <section id="videoswrapper">

    <section id="vidlines" class="mediaSection"> 
      <h1 title="Click to collapse/expand">Videos</h1> 
      <div class="lines"></div></section>
    <section id="pholines" class="mediaSection"> <h1 title="Click to collapse/expand">Photos</h1> <div class="lines"></div></section>
  </section>
  

  <section id="tlcontainer">
   
  <section id="controls">
    <div id="controlOuter">

        <i class="button icon-step-backward" id="rewind"></i>
        <i class="button icon-play" id="play"></i>
        <i class="button icon-pause" id="stop"></i>
        <i class="button icon-step-forward" id="forward"></i>
       
    </div>
  </section>
   <div class="timeline lines" id="maintimeline">
      <div id="timepos"></div>
      <div id="timeDisplay">00:00:00</div>

   </div>
  </section>

  <section id="playRateWrapper">
    <section id="playRate">
      <input id="rateControl" type="range" min="0.1" max="1" value="1" step="0.025" title="Change playback rate"></input><span id="theRate"></span>
    </section>  

  </section>
 
    <div id="videos">
    </div>
</body>

</html>
