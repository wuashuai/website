// Use this Variable keep track of an ajax request as a global variable so 
// it can be aborted

var request;

$(document).ready(function(){

  // google maps code
  function initMap(latlng) {
    
    var splits = latlng.split(",");  
    var myLatLng = {lat: parseFloat(splits[0]), lng: parseFloat(splits[1])};

    var map = new google.maps.Map(document.getElementById('googleMap'), {
    // TODO: center your map on the provided coordinates and set a 
    //       reasonable zoom level
    // HINT: USE https://developers.google.com/maps/documentation/javascript/
    center: myLatLng,
    zoom: 7,
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker({
    // TODO: set a Marker on a specified map at a position.
    // HINT: USE https://developers.google.com/maps/documentation/javascript/
    position: myLatLng,
    map: map,
    title: 'Hello World!'
    });

  }
   
  // the story starts off at index 0 (in the database)
  var init = {labelno: 0};
  updateStory(init);
  findAlbum();

  $('.goblet').addClass('hidden');
  $('.button-wrapper').addClass('hidden');

  // TODO: Create a javascript onclick function that obtains the corresponding 
  //       choice/button.
  //       Then call the updateStory function on that labelno.
  // HINT: there's this cool data-index thing we use to encapsulate
  //       data that is not visible to the user.
  $('.choice1').click(function() {
    var choice1 = {labelno: $('.choice1').attr("data-index")}
    updateStory(choice1);

  });

  $('.choice2').click(function() {
    var choice2 = {labelno: $('.choice2').attr("data-index")}
    updateStory(choice2);
  });


  // this has been implemented for you :)
  $('.js-music').on("ended", function() {
    // set the ticker to the beginning of the song
    this.currentTime = 0;
    // load in new music
    findAlbum();
    // pause the music
    this.pause();
    // start loading the music
    this.load();
    // makes sure the music is done loaded before it plays
    this.oncanplaythrough = this.play();
  });


  // HINT: Create an AJAX request that returns the row of the database that  
  //       corresponds to the information for one labelNo.
  // HINT: input to this function should be json formatted like {labelno: 0}
  function updateStory(jsondata) {
    
    $(".goblet-msg").text('');
    $(".goblet-msg-valid").text('');
    
    // HINT: console.log(jsondata);
    //console.log(jsondata);
    request = $.ajax({
      // TODO: send the request to your server file. 
    //Fill in the missing pieces of this AJAX request

      url : "ajax/ajax.php",
      data: jsondata,
      method: 'POST',
      dataType:"json", 
      error: function(error) {
          console.log(error);
      }
    });

    request.success(function(data) {
      
      //data = JSON.parse(data);
      //console.log(data);
    // TODO: Update the HTML DOM to the text of the json you returned.
    //       The one below has been done for you.
        // HINT: console.log(data);
      $(".story-line").text(data.storyline);
      
      $(".choice1").attr("data-index", data.choice1_r);
      $(".choice2").attr("data-index", data.choice2_r);
      $(".choice1").attr("value", data.choice1);
      $(".choice2").attr("value", data.choice2);
      $(".choice1-plot").text(data.choice1_d);
      $(".choice2-plot").text(data.choice2_d);
      $(".location-label").text(data.location_label);
      initMap(data.location);

      // Set up the goblet for certain story elements
      if (jsondata.labelno == 6) {
        $(".goblet").removeClass('hidden');
        $(".choice1").addClass('goblet-submit');
        $(".goblet-submit").attr("disabled", "disabled");
        $(".choice1").removeClass('goblet-choose');
      } else {
        $(".goblet").addClass('hidden');
      }

      if (jsondata.labelno == 7) {
        $(".button-wrapper").removeClass('hidden');
        $(".choice1").addClass('goblet-choose');
        $(".choice1").removeClass('goblet-submit');
        $(".goblet-choose").removeAttr("disabled");

      } else {
        $(".button-wrapper").addClass('hidden');
      }

    }); 


  }

  // HINT: USE https://developer.spotify.com/web-api/endpoint-reference/ 
  //       to find the right endpoint call that 
  //       you will be using AJAX to send a request to.

  
  // TODO: Find spotify's unique albumId for this album and return the Spotify preview track JSON URL
  function findAlbum() {
    var albumName = "Harry+Potter+and+The+Sorcerer%27s+Stone+Original+Motion+Picture+Soundtrack%22%3B";
    var url = "https://api.spotify.com/v1/search?q="+ albumName + "&type=album,track";
    $.ajax({
      // TODO: complete ajax call
      url : url,
      dataType: 'text',

      success: function(data) {

        // HINT: console.log(data);
        // TODO: Using the Spotify api, return the AlbumId that corresponds 
        //       with the provided albumName.
        data = JSON.parse(data);
        //console.log(data);
        var Albumid = data.albums.items[0].id;

        playMusic(Albumid);

      }
    
    });
  }
  
  
  function playMusic(albumID) {
    
    // TODO: populate ajax's url field with the appropriate API endpoint
    // an endpoint is fancy-speak for a url you can send ajax requests to.
  
    $.ajax({
      // TODO: complete ajax call
      url : "https://api.spotify.com/v1/albums/" + albumID,
      dataType: 'text',
      // TODO: if you did this correctly, the album info should be stored in data.
      success: function(data) {
        // HINT: use console.log(data) to see the structure.
        
        //console.log(data);
        
        // TODO: using javascript's Math.round() and Math.random(), 
        //       get a random song from the album, assignt to rand
        data = JSON.parse(data);
        var num = data.tracks.total;
        var rand = Math.floor(Math.random() * num);

        // TODO: once you have a track, get its preview_url field and 
        //       change the music player (.js-music) such it plays the new song.
        // HINT: https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Using_HTML5_audio_and_video
        $(".js-music").attr("src", data.tracks.items[rand].preview_url);
      }

    });

  }

});