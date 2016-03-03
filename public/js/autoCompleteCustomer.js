function automcompleteCustomer(e){
  $(e).autocomplete({
      source: getdataCustomer(),
      autoFocus:true
  });
}

function getdataCustomer(){

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_customer_autocomplete';

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
