function automcompleteUser(e){
  $(e).autocomplete({
      source: getdataUser(),
      autoFocus:true
  });
}

function getdataUser(){

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_user_autocomplete';

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
