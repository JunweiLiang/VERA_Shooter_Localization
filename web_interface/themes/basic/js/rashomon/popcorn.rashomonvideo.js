// PLUGIN: video controller for rashomon project
// inputs are 'vid' which is a rashomon video object
// and 'timeline' which is the Rashomon timeline object

(function (Popcorn) {
  
  Popcorn.plugin( "rashomonVideo", {

      manifest: {
        about:{
          name: "rashomon video plugin",
          version: "0.1",
          author: "aphid",
          website: "aphid.org"
        },
        options:{
          vid: {elem:'input', type:'object', label: 'Video'},
          timeline: {elem:'input', type:'object', label: 'Timeline'},
          start :  {elem:'input', type:'number', label:'In'},
          end :    {elem:'input', type:'number', label:'Out'}
        }
      },

      _setup: function( options ) {
        
      },

      /**
       * 
       * The start function will be executed when the currentTime 
       * of the video  reaches the start time provided by the 
       * options variable
       */
      start: function( event, options ) {
        if ($("#vid" + options.vid.id).hasClass("vidactive")){
          var timediff = + options.timeline.currentTime() - options.vid.offset;
          $("#vcontain" + options.vid.id).show("fast", "linear");
          options.vid.pp.currentTime(timediff);
          //options.vid.showVid();
          if (!Rashomon.timeline.media.paused) {
            options.vid.pp.play();
          }
        }

        Rashomon.displayingVideos++;

        var marker = Rashomon.videos[options.vid.id].cameraMarker;
        var secretMessage = Rashomon.videos[options.vid.id].additionalInfo;
        if (marker) {
          map.panTo(marker.getPosition());

          if (secretMessage) {
            Rashomon.videos[options.vid.id].infowindow.open(marker.get('map'), marker);
          }
        }

      },
      /**
       * 
       * The end function will be executed when the currentTime 
       * of the video  reaches the end time provided by the 
       * options variable
       */
      end: function( event, options ) {
        var timediff = + options.timeline.currentTime() - options.vid.offset;
        // console.log(timediff);
        options.vid.hideVid();
        if (timediff < 0) {
          options.vid.pp.pause(0);
        } else if (options.timeline.currentTime() > options.vid.offset) {
          options.vid.pp.pause(options.vid.pp.duration());
        }

        Rashomon.displayingVideos--;

        var marker = Rashomon.videos[options.vid.id].cameraMarker;
        var secretMessage = Rashomon.videos[options.vid.id].additionalInfo;
        if (marker) {
          // map.panTo(marker.getPosition());
          if (secretMessage) {
            Rashomon.videos[options.vid.id].infowindow.close();
          }
        }

      }
  });

})( Popcorn );
