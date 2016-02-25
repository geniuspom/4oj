@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\RequestJob as RequestJob;
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<!-- jQuery UI -->
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายงานคำร้องขอทำงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- search and filter -->
  <div class="row">
    <div class="col-sm-6 form-group">
        <div style="display:inline-flex;">
          <select class="form-control" id="filter_group" name="filter_group">
              <option selected="selected" value="1">ชื่อคน</option>
              <option value="2">วันที่</option>
          </select>
          <input type="text" class="input-xs form-control" id="filter_value" name="filter_value" value="" style="margin-left:5px;"/>
          <input type="text" class="input-xs form-control hidden" id="date_filter_value" name="date_filter_value" value="" style="margin-left:5px;"/>
        </div>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <div id="report_content">

  {{ RequestJob::report_request_job('all','','',Route::Input('id')) }}

  </div>
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">

$('input').keypress(function(e) {

  if(e.which == 13) {
    sendfilter();
  }

});

$(function() {
    var availableTags = <?php include('../'. $root_url .'/laravel/app/Http/Controllers/UserautoCompleted.php'); ?>;
    $("#filter_value").autocomplete({
        source: availableTags,
        autoFocus:true
    });
});

$(document).on('change', '#filter_group', function() {
  var filter_group = $("#filter_group").val();
    if(filter_group == 1){
      $("#filter_value").removeClass('hidden');
      $("#date_filter_value").addClass('hidden');
    }else if(filter_group == 2){
      $("#date_filter_value").removeClass('hidden');
      $("#filter_value").addClass('hidden');
    }

});

$(document).on('focusout', '#date_filter_value', function() {
    sendfilter();
});

$('#date_filter_value').datetimepicker({
  format: "DD/MM/YYYY",
  locale: 'th'
});


function sendfilter(){

  var filter_group = $("#filter_group").val();

  if(filter_group == 1){
    var filter_value = $("#filter_value").val();
  }else if(filter_group == 2){
    var filter_value = $("#date_filter_value").val();
  }

  var sortby = "";

  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '../get_report_filter',
      type: "post",
      data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
      success: function(data){
        $("#report_content").html(data);
      }
    });

}

</script>
@stop
