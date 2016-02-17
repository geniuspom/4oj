$(document).ready(function () {
    var options = {
    //target: '#output', // target element(s) to be updated with server response
    beforeSubmit: beforeSubmit, // pre-submit callback
    uploadProgress: uploadProgress,
    success: afterSuccess, // post-submit callback
    resetForm: true // reset the form after successful submit
    };

    $('#room').on('submit','#MyUploadForm',function(){

         $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
         });

        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });

    $('#room').on('submit','.Edit_plan_form',function(){

         $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
         });

        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });


    //hide new room
    $('#add_new_room').on('click','.cancle-new-group',function(){
        $('#add_new_room').addClass('hidden');
        $('#room_name').val("");
        $('#room_url').val("");
        $('#result').html("");
    });

    //add new room
    $('#add_new_room').on('click','#submit-add-room',function(){
        add_room();
    });

    //edit room
    $('.room_detail').on('click','.edit_room',function(){
        var room_id = $(this).attr('id');
        var edit_form_id = "#room_id_" + $(this).attr('id');
        get_edit_form(edit_form_id,room_id);
    });

    //cancel edit room
    $('.room_detail').on('click','.cancle_edit_room',function(){

        var room_id = $(this).attr('id');
        var edit_form_id = "#room_id_" + $(this).attr('id');

        $(edit_form_id + " #form_room_name").html("");
        $(edit_form_id + " #form_plan_room").html("");
        $(edit_form_id + " .room_name").removeClass('hidden');
        $(edit_form_id + " .edit_room").removeClass('hidden');
        $(edit_form_id + " .delete_room").removeClass('hidden');
        $(edit_form_id + " .confirm_edit_room").addClass('hidden');
        $(edit_form_id + " .cancle_edit_room").addClass('hidden');

    });

    //edit room
    $('.room_detail').on('click','.confirm_edit_room',function(){
        var room_id = $(this).attr('id');
        var edit_form_id = "#room_id_" + $(this).attr('id');
        save_edit(edit_form_id,room_id);
    });



    //delete room
    $('.room_detail').on('click','.delete_room',function(){
        var room_id = $(this).attr('id');
        var room_name = $(this).attr('room_name');

        var r = confirm("คุณต้องการลบห้องประชุม " + room_name);
        if (r == true) {
            delete_room(room_id);
        }

    });

    //show new room
    $('#room').on('click','#add_room',function(){
        $('#add_new_room').removeClass('hidden');
    });

    $('#add_new_room').on('change','#room_name',function(){
        if($("#room_name").val() == ""){
          $('#submit-add-room').prop('disabled', true);
        }else{
          $('#submit-add-room').prop('disabled', false);
        }
    });


    if($("#room_name").val() == ""){
      $('#submit-add-room').prop('disabled', true);
    }else{
      $('#submit-add-room').prop('disabled', false);
    }

});

function afterSuccess(response){

    var data = JSON.parse(response);



    var destination_output = data.destination_output;
    $(destination_output + ' #room_url').val(data.filename);
    $(destination_output + " #result").html(data.htmlcode);
    var imgae_name = $(destination_output + " #result img").attr('src');
    $(destination_output + " #result img").attr('src', imgae_name + "?" + new Date().getTime());
    $(destination_output + " #result").removeClass('hidden');
    $(destination_output + " .room_plan").addClass('hidden');
    $(".upload_progress").addClass("hidden");
    $('#submit-btn').show(); //hide submit button
    //$('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit(formData, jqForm, options) {

    var formID = "#" + jqForm.attr("id") + " #output"; // <== Change on this line
    var Image_input = "#" + jqForm.attr("id") + " #imageInput";
    var submit_bt = "#" + jqForm.attr("id") + " #submit-btn";

    //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob)
    {

    if (!$(Image_input).val()) //check empty input filed
    {
    //$("#output").html("คุณยังไม่ได้เลือกไฟล์");
    $(formID).html("คุณยังไม่ได้เลือกไฟล์");
    return false
    }

    var fsize = $(Image_input)[0].files[0].size; //get file size
    var ftype = $(Image_input)[0].files[0].type; // get file type


    //allow only valid image file types
    switch (ftype)
    {
    case 'image/png':
    case 'image/gif':
    case 'image/jpeg':
    case 'image/pjpeg':
    break;
    default:
    $(formID).html("<b>" + ftype + "</b> ชนิดไฟล์ที่เลือกไม่สามารถใช้ได้");
    return false
    }

    //Allowed file size is less than 1 MB (1048576)
    if (fsize > 3000000)
    {
    $(formID).html("<b>" + bytesToSize(fsize) + "</b> ขนาดของไฟล์ใหญ่เกินไป (ไม่ควรเกิน 2 MB) <br />กรุณาลดขนาดของไฟล์ก่อนจะอัพโหลดใหม่อีกครั้ง");
    return false
    }

    $(submit_bt).hide(); //hide submit button
    //$('#loading-img').show(); //hide submit button
    $(formID).html("");
    }
    else
    {
    //Output error to older browsers that do not support HTML5 File API
    $(formID).html("Please upgrade your browser, because your current browser lacks some new features we need!");
    return false;
    }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0)
    return '0 Bytes';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function uploadProgress(event, position, total, percentComplete){

  $(".upload_progress").removeClass("hidden");
  var bar = $('.bar');
   var percent = $('.percent');
   var percentVal = '0%'

   var percentVal = percentComplete + '%';
           bar.width(percentVal);
           percent.html(percentVal);
}

function add_room(){

  var data_form = {'name':$("#room_name").val(),
                    'plan':$("#room_url").val(),
                    'venue_id':$("#venue_id").val(),
                  }

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../add_room',
      type: "post",
      data: {'method': 'add_new','data_form': data_form},
      success: function(response){
          var data = JSON.parse(response);

          alert(data.message);
          get_room($("#venue_id").val());
          $('#add_new_room').addClass('hidden');
          $('#room_name').val("");
          $('#room_url').val("");
          $('#result').html("");

      }
    });

}

function delete_room(room_id){

  var data_form = {'name':'',
                    'plan':'',
                    'venue_id':'',
                    'room_id':room_id,
                  }

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../add_room',
      type: "post",
      data: {'method': 'delete','data_form': data_form},
      success: function(response){
          var data = JSON.parse(response);

          alert(data.message);
          get_room(data.venue_id);

      }
    });

}

function get_room(venue_id){

var data_form = {'name':'',
                  'plan':'',
                  'venue_id':venue_id,
                }

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

$.ajax({
    url: '../add_room',
    type: "post",
    data: {'method': 'get_room','data_form': data_form},
    success: function(response){
        $(".room_detail").html(response);

    }
  });

}

function get_edit_form(edit_form_id,room_id){

var data_form = {'name':'',
                  'plan':'',
                  'venue_id':'',
                  'room_id':room_id,
                }

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

$.ajax({
    url: '../add_room',
    type: "post",
    data: {'method': 'get_room_form','data_form': data_form},
    success: function(response){

        var data = JSON.parse(response);

        var form_room_name = data.form_room_name;
        var form_plan_room = data.form_plan_room;
        $(edit_form_id + " #form_room_name").html(form_room_name);
        $(edit_form_id + " #form_plan_room").html(form_plan_room);
        $(edit_form_id + " .room_name").addClass('hidden');
        $(edit_form_id + " .edit_room").addClass('hidden');
        $(edit_form_id + " .delete_room").addClass('hidden');
        $(edit_form_id + " .confirm_edit_room").removeClass('hidden');
        $(edit_form_id + " .cancle_edit_room").removeClass('hidden');
    }
  });

}

function save_edit(edit_form_id,room_id){

  var room_name = $(edit_form_id + " #room_name").val();
  var room_plan = $(edit_form_id + " #room_url").val();

  var data_form = {'name':room_name,
                    'plan':room_plan,
                    'venue_id':$("#venue_id").val(),
                    'room_id':room_id,
                  }

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../add_room',
      type: "post",
      data: {'method': 'update','data_form': data_form},
      success: function(response){

          var data = JSON.parse(response);

          alert(data.message);
          location.reload();

      }
    });


}
