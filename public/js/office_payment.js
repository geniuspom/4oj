$(document).ready(function(){

    var filter_group = $("#filter_group").val();
    var filter_value = $("#filter_value").val();

    if(filter_group == 2){
      sendfilter();
    }else if(filter_group == 1 && filter_value != ""){
      sendfilter();
    }
    change_filtergroup()
});

$("input[name='filter_value']").on("keypress", function (e) {

  if(e.which == 13) {
    sendfilter();
  }else{
    automcompleteUser($(this));
  }


});

$(document).on('change', '#filter_status', function() {
    sendfilter();
});


$(document).on('change', '#filter_group', function() {
  change_filtergroup()
});

function sendfilter(){

  var filter_group = $("#filter_group").val();

  if(filter_group == 1){
    var filter_value = $("#filter_value").val();
  }else if(filter_group == 2){
    var filter_value = $("#filter_status").val();
  }

  var sortby = "";

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../get_officepayment',
      type: "post",
      data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
      success: function(data){
        $("#report_content").html(data);
      }
    });

}

function change_filtergroup(){
  var filter_group = $("#filter_group").val();
    if(filter_group == 1){
      $("#filter_value").removeClass('hidden');
      $("#filter_status").addClass('hidden');
    }else if(filter_group == 2){
      $("#filter_status").removeClass('hidden');
      $("#filter_value").addClass('hidden');
      sendfilter();
    }
}
