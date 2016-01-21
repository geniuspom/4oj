@extends('Member.master')
@section('content')
<?php
$date = Route::Input('date');
use App\Http\Controllers\RequestJob as RequestJob;
use App\Http\Controllers\Calendar as Calendar;

$allevent = RequestJob::getrequestjob("2016-01-17","2016-01-23");
$allmultievent = RequestJob::getrequestjobmulti("2016-01-17","2016-01-23");
$returnevent = Calendar::getevent("2016-01-21");
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">คำร้องงานจัดประชุม</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">สร้างคำร้องขอ</h3>
            </div>
            <div class="panel-body">
                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <strong>เกิดข้อผิดพลาด!</strong> กรุณากรอกข้อมูลตามเงื่อนไขที่กำหนด<br><br>
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif
                   {{ $allevent[0]['Numberofday'] }}
                   {{ $returnevent['number']}}
                  <!--<form class="form-horizontal" role="form" method="POST" action="{{ url('/add_request_job') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="request_name" value="{{ old('request_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">วันเริ่ม *</label>
                      <div class="col-md-6" id="sandbox-container">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="start_date" value="{{ old('start_date') }}"/>
                            <span class="input-group-addon">ถึง</span>
                            <input type="text" class="input-sm form-control" name="end_date" value="{{ old('end_date') }}"/>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ช่วงเวลา *</label>
                      <div class="col-md-6">
                          <select class="form-control" id="duration" name="duration">
                              <option selected="selected" value="1">ทั้งวัน</option>
                              <option value="2">ช่วงเช้า</option>
                              <option value="3">ช่วงบ่าย</option>
                          </select>
                      </div>
                    </div>-->

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">งานประชุมที่เลือก *</label>
                      <div class="col-md-6">
                          <select class="form-control" id="event_id" name="event_id">
                              <option selected="selected" value="1">ทั้งวัน</option>
                              <option value="2">ช่วงเช้า</option>
                              <option value="3">ช่วงบ่าย</option>
                          </select>
                      </div>
                    </div>-->


                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">บันทึกเพิ่มเติม</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="remark" >{{ old('remark') }}</textarea>
                      </div>
                    </div>



                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          สร้างคำร้องขอ
                        </button>
                        <a class="btn btn-primary" href="/4oj/"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>-->
              </div>
          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#sandbox-container .input-daterange').datepicker({
      format: "dd/mm/yyyy",
      startDate: "today",
      todayBtn: "linked",
      language: "th",
      multidate: false,
      keyboardNavigation: false,
      daysOfWeekHighlighted: "0,6",
      autoclose: true,
      todayHighlight: true
  });

});
</script>
@stop
