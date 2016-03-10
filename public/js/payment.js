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

$('input').keypress(function(e) {

  if(e.which == 13) {
    sendfilter();
  }

});

$(document).on('change', '#filter_status', function() {
    sendfilter();
});

$(function() {

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/get_user_autocomplete';

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


  $("#filter_value").autocomplete({
      source: availableTags,
      autoFocus:true
  });

});


$(document).on('change', '#filter_group', function() {
  change_filtergroup()
});

$(document).on('click', '#update_payment', function() {
  var formdata = $( "form" ).serialize();
  update_payment(formdata);
  return false;
});

$(document).on('change', '.pay_status', function() {

  var status = $(this).prop('checked');

  var selected = $(this).attr('id');
  var type = selected.split("_");
  var id = type[1];

  if(status == false){

    if(type[0] == "asst"){
      var removepay_select = $('#removepay_select').val();
      var remove_att = '#removepay_select';
    }else{
      var removepay_select = $('#removeoffice_select').val();
      var remove_att = '#removeoffice_select';
    }

    if(removepay_select != ""){
      removepay_select += ",";
    }

    removepay_select += id;

    $(remove_att).val(removepay_select);

  }

  sum_pay();

});

$(document).on('change', '.pay_status', function() {

    /*var status = $(this).prop('checked');

    var selected = $(this).attr('id');
    var id = selected.replace("paystatus_", "");
    var tag = "#payselect_" + id;

    if(status == true){

      $(tag).prop('checked', true);

    }*/

    sum_pay();

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
      url: '../get_payment',
      type: "post",
      data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
      success: function(data){
        $("#report_content").html(data);
        sum_pay();
      }
    });

}

function update_payment(formdata){

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../update_payment_status',
      type: "post",
      data: formdata,
      success: function(data){
        //$("#report_content").html(data);
        alert("บันทึกสำเร็จ");
        location.reload();
      }
    });

}

function sum_pay(){

  var str = $( "form" ).serialize();
  var value = str.split("&");

  var all_pay = 0;

  for(var i = 0; i < value.length; i++){
    var id = (value[i].replace("%5D=true", "")).split("%5B");
    if(id[0] == "ofst" || id[0] == "asst"){
      all_pay = parseInt(all_pay) + parseInt($("#payamt_" + id[1]).val());
    }

  }

  all_pay = all_pay.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

  if(all_pay == "NaN"){
    all_pay = 0;
  }

  $("#pay_sum").html(all_pay);

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
