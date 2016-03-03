$("input[name='customer_id']").on("keypress", function () {

    automcompleteCustomer($(this));

});

$("input[name='assigned_id']").on("keypress", function () {

    automcompleteUser($(this));

});

$(document).on('change', '#filter_group', function() {
  $("input[name='filter_value']").val("");
  sendfilter();
});


$("input[name='filter_value']").on("keypress", function (e) {

    if(e.which == 13) {
      sendfilter();
    }else{

      if($("#filter_group").val() == 1){
        automcompleteCustomer($(this));
      }
    }

});

function sendfilter(){

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_call_report';

  var filter_group = $("#filter_group").val();

  var filter_value = $("#filter_value").val();

  var sortby = "";

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: url,
      type: "post",
      data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
      success: function(data){
        $("#report_content").html(data);
      }
    });

}
