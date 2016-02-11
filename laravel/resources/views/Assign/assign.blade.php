@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\EventControl as EventControl;
//use App\Http\Controllers\Getdataform as Getdataform;
use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\Assignment\Assign as Assign;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">จัดการงานประชุม</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ EventControl::get($id,'event_name') }}
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class=""><a data-toggle="tab" href="#detail" aria-expanded="true">รายละเอียดงาน</a>
                            </li>
                            <li class="active"><a data-toggle="tab" href="#assignment" aria-expanded="false">มอบหมายงาน</a>
                            </li>
                        </ul>

                    <!-- Tab panes -->
                        <div class="tab-content">
<!-- detail ===============================================================================================-->
                            <div id="detail" class="tab-pane fade" style="padding-top:15px;">

                              <div class="form-horizontal">

                                <div class="form-group">
                                  <label class="col-md-5 text-right">ชื่องาน</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'event_name') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">ชื่อลูกค้า</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'customer_id') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">รูปแบบการจัดประชุม</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'event_type') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">วันเริ่ม</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'event_date') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">สถานที่จัดประชุม</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'venue_id') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">จำนวนจุดลงทะเบียน</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'register_point') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">จำนวนจุดนับคะแนน</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'summary_point') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">เวลาเปิดประชุม</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'stert_time') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">เวลาเปิดลงทะเบียน</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'register_time') }}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-5 text-right">เวลานัดหมายทีม OJ</label>
                                  <div class="col-md-6 text-info" >
                                      {{ EventControl::get($id,'staff_appointment_time') }}
                                  </div>
                                </div>

                                    <div class="form-group">
                                      <div class="col-md-6 col-md-offset-4">

                                          @if (LoginController::checkpermission(2))
                                          <a class="btn btn-primary" href="{{$root_url}}/edit_event/{{ $id }}"> แก้ไขข้อมูล </a>
                                          @endif

                                      </div>
                                    </div>
                                </div>
                            </div>


<!-- assignment ===============================================================================================-->
                            <div id="assignment" class="tab-pane fade active in" style="padding-top:15px;">
                                    <div class="col-md-12" style="padding-bottom:10px;padding-left:5px;">
                                      @if (LoginController::checkpermission(2))
                                      <input type="hidden" name="event_id" id="update_assign_event_id" value="{{ $id }}">
                                      <a class="btn btn-primary" id="update_assign"> บันทึก </a>
                                      @endif
                                    </div>
                                    <div class="col-md-6" style="padding-left:5px;padding-right:5px;">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">รายชื่อคนที่มอบหมายทำงาน</h3>
                                            </div>
                                            <select name="add_id" id="add_id" multiple class="form-control hidden">
                                            </select>
                                            <select name="remove_id" id="remove_id" multiple class="form-control hidden">
                                            </select>
                                            <div class="panel-body" id="assignment_user">
                                              {{Assign::main("Get_assign_user",$id)}}
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">รายชื่อคนที่สมัครงานนี้</h3>
                                            </div>
                                            <div class="panel-body" id="request_event_user">
                                              {{Assign::main("Get_request_event",$id)}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding-right:5px;padding-left:5px;">
                                        <div class="panel panel-yellow">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">รายชื่อคนที่แจ้งทำงานวันนี้</h3>
                                            </div>
                                            <div class="panel-body" id="request_job_user">
                                              {{Assign::main("Get_request_date",$id)}}
                                            </div>
                                        </div>
                                        <div class="panel panel-red">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">รายชื่อทั้งหมด</h3>
                                            </div>
                                            <div class="panel-body" id="all_user">
                                              {{Assign::main("Get_all_user",$id)}}
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                                <!-- /.panel-body -->
              </div>
                            <!-- /.panel -->
          </div>
      </div>
</div>

<script src="{{$root_url}}/public/js/assignment.js"></script>

<script type="text/javascript">

</script>

@stop
