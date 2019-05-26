// PLUGIN: IMAGE

(function (Popcorn) {
  
  Popcorn.plugin( "rashomonPhoto", {

      manifest: {
        about:{
          name: "rashomon photo thingy",
          version: "0.1",
          author: "aphid",
          website: "aphid.org"
        },
        options:{
          id : {elem:'input', type:'number', label:'id'},
          start :  {elem:'input', type:'number', label:'In'},
          end :    {elem:'input', type:'number', label:'Out'},
          offset:  {elem:'input', type:'number', label:'Offset'}
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
        console.log("starting " + "#pContainer" + options.id);
        $("#pContainer" + options.id).show("fast", "linear");
      },
      /**
       * 
       * The end function will be executed when the currentTime 
       * of the video  reaches the end time provided by the 
       * options variable
       */
      end: function( event, options ) {
        console.log("ending");
        $("#pContainer" + options.id).hide("fast", "linear");
      }
          
  });

})( Popcorn );
