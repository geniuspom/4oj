//$(function() {

/*$(function() {

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_room_autocomplete';

  var availableTags = (function () {
    var availableTags = null;

    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $.ajax({
      async: false,
      global: false,
      url: url,
      dataType:'json',
      success: function(response) {
        availableTags = response;
      }
    });
    return availableTags;

})();


  $("#Venue_value").autocomplete({
      source: availableTags,
      autoFocus:true
  });

});*/

$("#Venue_value").on("keypress", function () {
  $("#Venue_value").autocomplete({
      source: getdata(),
      autoFocus:true
  });
});

function getdata(){

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_room_autocomplete';

    var availableTags = null;

    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $.ajax({
      async: false,
      global: false,
      url: url,
      dataType:'json',
      success: function(response) {
        availableTags = response;
      }
    });
    return availableTags;

}
