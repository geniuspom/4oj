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

$(document).on("click", "button[name='submit']", function() {

    if(checkbeforesave()){
      return true;
    }else{
      return false;
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

function checkbeforesave(){

    var customer = $("input[name='customer_id']").val();
    var comment = $("textarea[name='comment']").val();
    var assign = $("input[name='assigned_id']").val();

    var status = true;

    if(customer == "" || customer.length < 5){
      alert("กรุณากรอกชื่อบริษัท");
      $("input[name='customer_id']").focus();
      return;
    }

    if(comment == "" || comment.length < 5){
      alert("กรุณากรอกข้อความอย่างน้อย 5 อักษร");
      $("textarea[name='comment']").focus();
      return;
    }

    if(status == true){

      customer = customer.split(" ");
      customer = customer[0].replace("[", "");
      customer = customer.replace("]", "");
      customer = parseInt(customer);

      if(isNaN(customer)){
        alert("ชื่อบริษัทไม่ถูกต้อง กรุณาเลือกจากรายการที่แสดงขึ้นมา");
        $("textarea[name='customer_id']").focus();
        return;
      }

      if(assign != ""){

        assign = assign.split(" ");
        assign = assign[0].replace("[", "");
        assign = assign.replace("]", "");
        assign = parseInt(assign);

        if(isNaN(assign)){
          alert("ชื่อมอบหมายงานไม่ถูกต้อง กรุณาเลือกจากรายการที่แสดงขึ้นมา");
          $("textarea[name='customer_id']").focus();
          return;
        }

      }

    }

    return status;

}
