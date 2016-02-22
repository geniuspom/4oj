$(document).ready(function () {
    var options = {
    //target: '#output', // target element(s) to be updated with server response
    beforeSubmit: beforeSubmit, // pre-submit callback
    uploadProgress: uploadProgress,
    success: afterSuccess, // post-submit callback
    resetForm: true // reset the form after successful submit
    };

    $('#profile_pic_id_card').on('submit','.upload_form',function(){

         $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
         });

        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });

});

function afterSuccess(response){

    var data = JSON.parse(response);

    var destination_output = data.destination_output;
    $(destination_output).html(data.htmlcode);
    var imgae_name = $(destination_output + " img").attr('src');
    $(destination_output + " img").attr('src', imgae_name + "?" + new Date().getTime());
    $(".upload_progress").addClass("hidden");
    $('#submit-btn').show(); //hide submit button

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
   var percentVal = '0%';

   var percentVal = percentComplete + '%';
           bar.width(percentVal);
           percent.html(percentVal);
}
