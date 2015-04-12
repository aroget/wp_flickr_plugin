function photosLookup(){
  // we get values from wp-admin form
  var apiKey = setting.api;
  var userID = setting.username;
  var perPage = setting.photos;

  // call to the API
  var url = 'http://api.flickr.com/services/rest/?&method=flickr.people.getPhotos&api_key=' + apiKey + '&user_id='+ userID +'&per_page='+ perPage +'&extras=owner_name,media,path_alias,geo,date_taken&format=json&jsoncallback=?';

  jQuery.getJSON( url, function( data ) {
    var items = [];

    // loop through returned object
    jQuery.each( data.photos.photo, function( key, val ) {
      items.push( "<li id='" + key + "'><img class='small-12 medium-6 left' src='https://farm" + this.farm + ".staticflickr.com/" + this.server + "/" + this.id + "_" + this.secret + ".jpg' ><div class='small-12 medium-6 left'><p class='image-title'>"+ this.title +"</p><p>" + moment(this.datetaken, "YYYYMMDD").fromNow() + "</p></div></li>" );
    });

    jQuery( "<ul/>", {
      "class": "gallery-list small-11 small-centered columns",
      html: items.join( "" )
    }).appendTo( "#gallery" );

  });
}

photosLookup();
