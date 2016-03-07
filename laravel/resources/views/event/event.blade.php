@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\EventControl as EventControl;
use App\Http\Controllers\LoginController as LoginController;
?>
<meta name="_token" content="{!! csrf_token() !!}"/>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">งานที่กำลังเปิดรับ</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <div class="row">
    @if (LoginController::checkpermission(2))
    <div class="col-md-4 form-group">
      <a class="btn btn-primary text-right" href="add_event">เพิ่มงานที่กำลังเปิดรับ</a>
    </div>
    @endif

    <!-- search and filter -->
    <div class="col-md-8 form-group" style="display:inline-flex;">
      <select class="form-control" id="filter_group" name="filter_group">
          <option selected="selected" value="1">วันที่</option>
          <option value="2">สถานะของงาน</option>
      </select>
      <select class="form-control hidden" id="filter_value" name="filter_value" style="margin-left:5px;">
          <option value="all">ทั้งหมด</option>
          <option value="1">กำลังเปิดรับ</option>
          <option value="2">เต็มแล้ว</option>
          <option value="3">เลื่อนการประชุม</option>
          <option value="4">จบแล้ว</option>
      </select>
      <input type="text" class="input-xs form-control" id="date_filter_value" name="date_filter_value" value="" style="margin-left:5px;"/>
    </div>

  </div>

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive" id="result_event">

              {{ EventControl::getall('all','','') }}

        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){

    });

    $(document).on('click', '.request_this_event' , function() {

      var id = $(this).attr("id");

      $.confirm({
        text: "<p style='font-size:16px;text-align:center;'>ขอขอบคุณที่ให้ความสนใจที่จะร่วมงานนี้ <br> หากคุณได้รับเลือกให้เข้าทำงานนี้ บริษัทจะมีการ<span style='color:#f00'>ส่งอีเมลยืนยัน</span>ไปที่อีเมลของคุณ<br><br>คุณต้องการยืนยันที่จะยื่นขอทำงานนี้หรือไม่</p>",
        title: "ยืนยันการยื่นขอทำงาน",
        confirmButton: "ยืนยัน",
        cancelButton: "ยกเลิก",
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-danger",
        confirm: function() {
          $("#submit_" + id).click();
        },
        cancel: function() {

        }
      });

    });


function alert_popup(){

  $.confirm({
    text: "<p style='font-size:16px;text-align:center;'>ขอขอบคุณที่ให้ความสนใจที่จะร่วมงานนี้ <br> หากคุณได้รับเลือกให้เข้าทำงานนี้ บริษัทจะมีการ<span style='color:#f00'>ส่งอีเมลยืนยัน</span>ไปที่อีเมลของคุณ<br><br>คุณต้องการยืนยันที่จะยื่นขอทำงานนี้หรือไม่</p>",
    title: "ยืนยันการยื่นขอทำงาน",
    confirmButton: "ยืนยัน",
    cancelButton: "ยกเลิก",
    confirmButtonClass: "btn-success",
    cancelButtonClass: "btn-danger",
    confirm: function() {
      return true;
    },
    cancel: function() {
      return false;
    }

  });


}



/*
*
=================================== Filter function =============================================
*
*/
    $('#filter_value').keypress(function(e) {

      if(e.which == 13) {
        sendfilter();
      }

    });

    $(document).on('change', '#filter_value', function() {
        sendfilter();
    });

    $(document).on('change', '#filter_group', function() {
      var filter_group = $("#filter_group").val();
        if(filter_group == 2){
          $("#filter_value").removeClass('hidden');
          $("#date_filter_value").addClass('hidden');
          sendfilter();
        }else if(filter_group == 1){
          $("#date_filter_value").removeClass('hidden');
          $("#filter_value").addClass('hidden');
          sendfilter();
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

      if(filter_group == 2){
        var filter_value = $("#filter_value").val();
      }else if(filter_group == 1){
        var filter_value = $("#date_filter_value").val();
      }

      var sortby = "";

      $.ajaxSetup({
         headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
      });

      $.ajax({
          url: 'get_event_filter',
          type: "post",
          data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
          success: function(data){
            $("#result_event").html(data);
          }
        });

    }
/*
*
=================================== End Filter function =============================================
*
*/

</script>

@stop
