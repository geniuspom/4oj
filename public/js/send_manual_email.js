$(document).ready(function() {

    $('#editor').wysihtml5();
    $("a[title='Insert link']").addClass("hidden");
    $("a[title='Insert image']").addClass("hidden");
    $("#subject").val("");
    $("#editor").val("");

});



$(document).on('click', '#submit_send_email', function() {

    var subject = $("#subject").val();
    var text = $("#editor").val();

    var status = true;

    if(subject == ""){
        status = false;
        alert("กรุณากรอกหัวข้ออีเมล");
    }

    if(text == ""){
        status = false;
        alert("กรุณากรอกข้อความ");
    }

    if(status == true){

      var r = confirm("ยืนยันการส่งเมล");
      if (r == true) {
          var formdata = {'subject' : subject , 'text' : text};
          send_email(formdata);
      }

    }

    return false;

});


function send_email(formdata){

  var fullpath = window.location.href;
  var rootpath = window.location.origin;
  var splite_path = fullpath.split('/');
  var subdomain = splite_path[3];
  var url = rootpath+'/'+subdomain + '/send_manual_email';

  var Popup = "<div class='container' id='popup_assign'>"+
          "<div class='popup_bg'></div>"+
          "<div class='row'>"+
          "<img width='50px' src='/" + subdomain + "/public/image/bg-spinner.gif'>";
          "</div>";

  $("#wrapper").append(Popup);

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: url,
      type: "post",
      data: formdata,
      success: function(response){

        var data = JSON.parse(response);

        if(data.status == "success"){
          alert("ส่งอีเมลสำเร็จ");
          location.reload();
        }else{
          alert("ส่งอีเมลล้มเหลว");
          $("#popup_assign").remove();
        }

      }
    });

}
