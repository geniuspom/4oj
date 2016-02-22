@extends('Member.master')
@section('content')
<meta name="_token" content="{!! csrf_token() !!}"/>

<script src="../4oj/public/js/jquery-form.js"></script>


 <script type="text/javascript">
 $(document).ready(function () {
 var options = {
 target: '#output', // target element(s) to be updated with server response
 beforeSubmit: beforeSubmit, // pre-submit callback
 uploadProgress: uploadProgress,
 success: afterSuccess, // post-submit callback
 resetForm: true // reset the form after successful submit
 };

 $('#MyUploadForm').submit(function () {

  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });


 $(this).ajaxSubmit(options);
 // always return false to prevent standard browser submit and page navigation
 return false;
 });
 });

 function afterSuccess()
 {
 $('#submit-btn').show(); //hide submit button
 $('#loading-img').hide(); //hide submit button

 }

 //function to check file size before uploading.
 function beforeSubmit() {
 //check whether browser fully supports all File API
 if (window.File && window.FileReader && window.FileList && window.Blob)
 {

 if (!$('#imageInput').val()) //check empty input filed
 {
 $("#output").html("Are you kidding me?");
 return false
 }

 var fsize = $('#imageInput')[0].files[0].size; //get file size
 var ftype = $('#imageInput')[0].files[0].type; // get file type


 //allow only valid image file types
 switch (ftype)
 {
 case 'image/png':
 case 'image/gif':
 case 'image/jpeg':
 case 'image/pjpeg':
 break;
 default:
 $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
 return false
 }

 //Allowed file size is less than 1 MB (1048576)
 if (fsize > 3000000)
 {
 $("#output").html("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
 return false
 }

 $('#submit-btn').hide(); //hide submit button
 $('#loading-img').show(); //hide submit button
 $("#output").html("");
 }
 else
 {
 //Output error to older browsers that do not support HTML5 File API
 $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
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
   var bar = $('.bar');
    var percent = $('.percent');
    var percentVal = '0%'

    var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
 }

 </script>
 <style type="text/css">
 .upload_progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
 .upload_bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
 .upload_percent { position:absolute; display:inline-block; top:3px; left:48%; }
 </style>


<div style="margin:300px;">
  <form action="uploadplan" method="post" enctype="multipart/form-data" id="MyUploadForm">
   <input name="image_file" id="imageInput" type="file" />
   <input type="submit" id="submit-btn" value="Upload" />
   <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
   </form>
   <div id="output"></div>
   <div class="progress upload_progress">
    <div class="bar upload_bar"></div >
    <div class="percent upload_percent">0%</div >
</div>
</div>

@stop
