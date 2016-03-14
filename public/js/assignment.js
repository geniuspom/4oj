$('#update_assign').on('click',function(e){
    var event_id = $("#update_assign_event_id").val();

    var Popup = "<div class='container' id='popup_assign'>"+
            "<div class='popup_bg'></div>"+
          	"<div class='row'>"+
            "<img width='50px' src='../public/image/bg-spinner.gif'>";
            "</div>";


    $("#wrapper").append(Popup);
    update_assignment(event_id);
});

$('#assignment').on('click','.add_assign',function(){
    var user_id = $(this).attr('userid');
    var e_id = $(this).attr('userid');
    var append_value = "<option selected='selected' id='"+user_id+"' value='"+user_id+"'>"+user_id+"</option>";
    $(this).removeClass("add_assign");
    $(this).removeClass("fa-plus-circle");
    $(this).removeClass("text-success");
    $(this).removeClass("remove_assign");
    $(this).removeClass("fa-times");
    $(this).removeClass("text-danger");

    $(this).addClass("remove_assign");
    $(this).addClass("fa-times");
    $(this).addClass("text-danger");

    $(".row #"+e_id).appendTo("#assignment_user");
    $("#add_id").append(append_value);
});

$('#assignment').on('click','.remove_assign',function(){
    var e_id = $(this).attr('userid');
    var oldcategory = $(this).attr("oldcategory");
    var userid = $(this).attr('userid');
    var assign_id = $(this).attr('assign_id');
    var append_value = "<option selected='selected' id='"+assign_id+"' value='"+assign_id+"'>"+assign_id+"</option>";
    var event_id = $("#update_assign_event_id").val();

    $(".row #"+e_id).remove();

    var add_data = $("select#add_id").val();
    var remove_data = $("select#remove_id").val();

    if(oldcategory != "assignment_user"){

        remove_assignment(oldcategory,event_id,userid,add_data,remove_data);
        $("#assignment_user #"+e_id).remove();

    }else{

      remove_assignment(oldcategory,event_id,userid,add_data);
      $("#assignment_user #"+e_id).remove();
      $("#remove_id").append(append_value);

    }

    /*if(oldcategory != "assignment_user"){
      $("#assignment_user #"+e_id).appendTo("#"+oldcategory);
      $(this).removeClass("remove_assign");
      $(this).removeClass("fa-times");
      $(this).removeClass("text-danger");
      $(this).removeClass("add_assign");
      $(this).removeClass("fa-plus-circle");
      $(this).removeClass("text-success");

      $(this).addClass("add_assign");
      $(this).addClass("fa-plus-circle");
      $(this).addClass("text-success");
    }else{
      $("#remove_id").append(append_value);
      $("#assignment_user #"+e_id).remove();
    }*/

});

function update_assignment(event_id){

  var add_data = $("select#add_id").val();
  var remove_data = $("select#remove_id").val();

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../update_assignment',
      type: "post",
      data: {'add_id': add_data,'remove_id': remove_data, 'event_id' : event_id},
      success: function(data){
          alert("บันทึกสำเร็จ");
          location.reload();
      }
    });

}

function remove_assignment(type,event_id,user_id,not_include,include){

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../request_assign_jquery',
      type: "post",
      data: {'type': type,'event_id': event_id, 'user_id' : user_id, 'not_include' : not_include, 'include' : include},
      success: function(response){
          var data = JSON.parse(response);

          $("#"+data.moveto).html(data.code_return);

      }
    });

}


$('#sendmail').on('click',function(e){
    var event_id = $("#assign_status input[name=event_id]").val();

    var Popup = "<div class='container' id='popup_assign'>"+
            "<div class='popup_bg'></div>"+
          	"<div class='row'>"+
            "<img width='50px' src='../public/image/bg-spinner.gif'>";
            "</div>";


    $("#wrapper").append(Popup);
    send_assign_email(event_id);
});

function send_assign_email(event_id){

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../sendmail_assign',
      type: "post",
      data: {'event_id' : event_id},
      success: function(data){
          alert("ส่งอีเมล์สำเร็จ");
          location.reload();
      }
    });

}


$('#seach_value').keypress(function(e) {

  if(e.which == 13) {
    search_user();
  }

});

$('#clear-filter').click(function(){
  $("#all_user .all-user-list").show();
  $("#seach_value").val("");
});

function search_user(){

  var search_value = $("#seach_value").val();

  if(search_value != ""){
      $("#all_user .all-user-list").hide();

      $('#all_user .all-user-list').each(function(){
             if($(this).text().toUpperCase().indexOf(search_value.toUpperCase()) != -1){
                 $(this).show();
             }
          });

  }else{
      $("#all_user .all-user-list").show();
  }

}
