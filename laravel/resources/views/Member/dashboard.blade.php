@extends('Member.master')
@section('content')
<?php use App\Http\Controllers\Calendar as Calendar; ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<link href="/4oj/public/css/calendar.css" rel="stylesheet">
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

@stop
