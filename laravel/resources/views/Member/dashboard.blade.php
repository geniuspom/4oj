@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Calendar as Calendar;
use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\Assignment\AssignCalendar as AssignCalendar;
$root_url = dirname($_SERVER['PHP_SELF']); ?>
<style type="text/css">
#popup_msg{
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  background-color: rgb(255, 255, 255);
  min-height: 100%;
  border:4px solid #e9eaee;
  padding: 8px 10px;
}
#popup{
  left: 0px;
  z-index: 9999;
  width: 100%;
  top: 0px;
  height: 100%;
  position: fixed;
}
.popup_bg{
  left: 0px;
  width: 100%;
  top: 0px;
  background-color: rgb(0, 0, 0);
  opacity: 0.4;
  height: 100%;
  position: fixed;
}
#popup .row{
  top: 30%;
  position: absolute;
  left: 0px;
  width: 100%;
  margin-right: 0px;
  margin-left: 0px;
}
#close_popup{
  cursor: pointer;
}
.outline_calendar{
  margin:10px;
}
.border-notop{
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.pading_r_15{
  padding-right: 15px;
}
</style>
<meta name="_token" content="{!! csrf_token() !!}"/>
<link href="{{$root_url}}/public/css/calendar.css" rel="stylesheet">

{{ LoginController::checkstatususer() }}

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header" style="margin-bottom:10px;">ปฏิทินของฉัน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <div class="">
    <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#assign" aria-expanded="true">งานที่ได้รับมอบหมาย</a>
            </li>
            <li class=""><a data-toggle="tab" href="#request" aria-expanded="false">แจ้งวันที่ทำงานได้</a>
            </li>
        </ul>
    </div>

    <!-- Tab panes -->
        <div class="tab-content">
<!-- detail ===============================================================================================-->
            <div id="assign" class="tab-pane fade active in border-notop" style="padding-top:15px;">
                <div class="row pading_r_15">
                  <div class="col-sm-12 text-right" style="padding-bottom:10px;">
                    <span><i style="color:#200ffe;" class="fa fa-square fa-fw"></i>ช่วงเช้า</span>
                    <span><i style="color:#fdcc8f;" class="fa fa-square fa-fw"></i>ช่วงบ่าย</span>
                    <span><i style="color:#d1e273;" class="fa fa-square fa-fw"></i>ทั้งวัน</span>
                  </div>
                </div>
                <div class='panel panel-default outline_calendar' id='assign_calendar'>

                  {{ AssignCalendar::getcalendar("") }}

                </div>
                <div class="row">
                  <div class="col-sm-12">
                  </div>
                </div>
            </div>
<!-- assignment ===============================================================================================-->
            <div id="request" class="tab-pane fade border-notop" style="padding-top:15px;">

              <div class="row pading_r_15">
                <div class="col-sm-12 text-right" style="padding-bottom:10px;">
                  <input type="hidden" id="day_select" name="day_select" value=""/>
                  @if (LoginController::checkverifyuser())
                    <button class="btn btn-primary btn-sm" type="submit" name = "btn-new" id="new_request"><i class="fa fa-plus" ></i> แจ้งวันและเวลาที่คุณสามารถทำงานได้ </button>
                  @endif
                </div>
              </div>
              <div class="row pading_r_15">
                <div class="col-sm-12 text-right" style="padding-bottom:10px;">
                  <a class="text-danger" href="{{$root_url}}/upload_file/manual/job request manual 4OJ.pdf" target="_blank"><i class="fa fa-info-circle fa-fw"></i>คู่มือการแจ้งวันและเวลาที่คุณสามารถทำงานได้</a>
                </div>
              </div>
              <div class="row pading_r_15">
                <div class="col-sm-12 text-right" style="padding-bottom:10px;">
                  <span><i style="color:#200ffe;" class="fa fa-square fa-fw"></i>ช่วงเช้า</span>
                  <span><i style="color:#fdcc8f;" class="fa fa-square fa-fw"></i>ช่วงบ่าย</span>
                  <span><i style="color:#d1e273;" class="fa fa-square fa-fw"></i>ทั้งวัน</span>
                </div>
              </div>
              <div class='panel panel-default outline_calendar' id='content_calendar'>

              {{ Calendar::getcalendar("") }}

              </div>
              <div class="row">
                <div class="col-sm-12">
                </div>
              </div>

            </div>
        </div>

</div>

<script src="{{$root_url}}/public/js/calendar.js"></script>
<script src="{{$root_url}}/public/js/assign_calendar.js"></script>
<script type="text/javascript">

$(document).on('click','#close_popup',function(){

  $("#popup").fadeOut("slow");

});

</script>

@stop
