@extends('Member.master')
@section('content')
<?php use App\Http\Controllers\Calendar as Calendar; ?>
<?php use App\Http\Controllers\LoginController as LoginController; ?>
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
</style>
<meta name="_token" content="{!! csrf_token() !!}"/>
<link href="/4oj/public/css/calendar.css" rel="stylesheet">

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
    <div class="row">
      <div class="col-sm-12 text-right" style="padding-bottom:10px;">
        <input type="hidden" id="day_select" name="day_select" value=""/>
        <button class="btn btn-primary btn-sm" type="submit" name = "btn-new" id="new_request"><i class="fa fa-plus" ></i> สร้างคำร้องขอ </button>
      </div>
    </div>
    <div class='panel panel-default' id='content_calendar'>

    <!-- start calendar -->
    <!-- format dd-mm-yyyy -->
    <!--{{ Calendar::getcalendar("01-01-2016") }}-->
    {{ Calendar::getcalendar("") }}
    <!-- end calendar -->
    </div>
    <div class="row">
      <div class="col-sm-12">
      </div>
    </div>

</div>

<script src="/4oj/public/js/calendar.js"></script>
<script type="text/javascript">

$(document).on('click','#close_popup',function(){

  $("#popup").fadeOut("slow");

});

</script>

@stop
