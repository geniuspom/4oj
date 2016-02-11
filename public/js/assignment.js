$('#update_assign').on('click',function(e){
    var event_id = $("#update_assign_event_id").val();
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
