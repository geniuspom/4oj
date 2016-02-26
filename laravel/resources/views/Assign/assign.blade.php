@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\EventControl as EventControl;
//use App\Http\Controllers\Getdataform as Getdataform;
use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\Assignment\Assign as Assign;
use App\Http\Controllers\venue\venue_room_control as venue_room_control;
use App\Http\Controllers\event_task\event_task as event_task;
use App\Http\Controllers\Inventory\inventory as inventory;
use App\Http\Controllers\Payment\payment as payment;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<style type="text/css">
#popup_assign{
  left: 0px;
  z-index: 9999;
  width: 100%;
  top: 0px;
  height: 100%;
  position: fixed;
}
#popup_assign .row {
    left: 50%;
    position: absolute;
    top: 50%;
    width: 100%;
}
#popup_assign .popup_bg{
  left: 0px;
  width: 100%;
  top: 0px;
  background-color: rgb(0, 0, 0);
  opacity: 0.6;
  height: 100%;
  position: fixed;
}
.busy{
  color:#d9534f;
}
.avaliable{
  color:#5cb85c;
}
.valign_mid{
  vertical-align:middle !important;
}
</style>
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
                        <div class="row">
                            <div class="col-xs-10">
                                {{ EventControl::get($id,'event_name') }}
                            </div>
                            <div class="col-xs-2 text-right">
                                <a title="พิมพ์รายงาน" onclick="window.open('../report_event/{{$id}}')"><i class="fa fa-print fa-lg" style="cursor:pointer;"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class=""><a data-toggle="tab" href="#detail" aria-expanded="true">รายละเอียดงาน</a>
                            </li>
                            <li class="active"><a data-toggle="tab" href="#assignment" aria-expanded="false">มอบหมายงาน</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#status" aria-expanded="false">ความคืบหน้างาน</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#inventory" aria-expanded="false">อุปกรณ์</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#pay" aria-expanded="false">จ่ายเงิน</a>
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
                                      {{ venue_room_control::venue_detail($id,"normal") }}
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
                                    @if (session('status'))
                                      <div class="alert alert-success">
                                        {{ session('status') }}
                                      </div>
                                    @endif
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
<!-- status ===============================================================================================-->
                            <div id="status" class="tab-pane fade table-responsive" style="padding-top:15px;">
                              <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_task_event') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="event_id" value="{{ $id }}">
                              <table class="table table-bordered table-hover table-striped">
                                <thead>
                                  <tr>
                                    <th class="text-center">ลำดับที่</th>
                                    <th class="text-left">ชื่องาน</th>
                                    <th class="text-left">สถานะ</th>
                                    <th class="text-center">รับผิดชอบโดย</th>
                                    <th class="text-center">แผนดำเนินการต่อไป</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td class="text-center">1</td>
                                      <td class="text-left">คุยรายละเอียดงาน</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"1_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"1_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"1_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">2</td>
                                      <td class="text-left">จัดทำใบเสนอราคา</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"2_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"2_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"2_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">3</td>
                                      <td class="text-left">ยืนยันใบเสนอราคาและรายละเอียดอุปกรณ์</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"3_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"3_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"3_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">4</td>
                                      <td class="text-left">จัดเตรียมและสั่งอุปกรณ์</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"4_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"4_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"4_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.1</td>
                                      <td class="text-left">แจ้งลูกค้าให้ยืนยันกับทาง TSD ว่าจะลงทะเบียนโดยใช้บาร์โค๊ด</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_1_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_1_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_1_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.2</td>
                                      <td class="text-left">ขอไฟล์หนังสือเชิญที่มีเงื่อนไขการนับคะแนน (MS-Word หรือถ้าจำเป็น PDF)</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_2_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_2_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_2_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.3</td>
                                      <td class="text-left">ขอไฟล์ XML รายชื่อผู้ถือหุ้น</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_3_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_3_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_3_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.4</td>
                                      <td class="text-left">ขอแผนผังห้องประชุม ( Floor Plan )</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_4_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_4_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_4_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.5</td>
                                      <td class="text-left">หากมีผู้มีส่วนได้ส่วนเสียในวาระไหน กรุณาแจ้งด้วย</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_5_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_5_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_5_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.6</td>
                                      <td class="text-left">กรณีบัตรเสียให้ทำอย่างไร</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_6_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_6_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_6_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">5.7</td>
                                      <td class="text-left">ขอรายชื่อกรรมการรับมอบฉันทะ</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_7_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_7_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"5_7_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">6</td>
                                      <td class="text-left">จัดทำตัวอย่างบัตรลงคะแนน</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"6_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"6_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"6_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">7</td>
                                      <td class="text-left">บันทึกไฟล์ SQL</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"7_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"7_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"7_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">8</td>
                                      <td class="text-left">กรอกแบบฟอร์มวาระการประชุมและส่งให้ลูกค้าตรวจสอบ</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"8_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"8_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"8_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">9</td>
                                      <td class="text-left">ยืนยันแบบฟอร์มวาระการประชุมลูกค้า (โทรเพื่อ Check ทุกอย่างที่ลูกค้ากรอกมาใน Workdetail)</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"9_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"9_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"9_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">10</td>
                                      <td class="text-left">นัดชมสถานที่</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"10_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"10_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"10_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">11</td>
                                      <td class="text-left">ยืนยันรายละเอียดอุปกรณ์ (Final) (โทร)</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"11_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"11_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"11_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">12</td>
                                      <td class="text-left">ยืนยันรายละเอียดอุปกรณ์ Supplier (Final) (โทร)</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"12_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"12_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"12_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">13</td>
                                      <td class="text-left">จัดทีมงานและนัดหมาย</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"13_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"13_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"13_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">14</td>
                                      <td class="text-left">สรุปใบงานให้หัวหน้างาน</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"14_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"14_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"14_Plan","plan") }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-center">15</td>
                                      <td class="text-left">ส่ง Feedback Survey</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"15_status","status") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"15_respons","respons") }}</td>
                                      <td class="text-center">{{ event_task::event_task_form($id,"15_Plan","plan") }}</td>
                                    </tr>

                                </tbody>
                              </table>

                              <div class="text-center col-md-12">
                                  <button id="submit_bt" name="btn-trianing" type="submit" class="btn btn-primary" >
                                    บันทึก
                                  </button>
                              </div>
                            </form>
                            </div>
<!-- inventory ===============================================================================================-->
                            <div id="inventory" class="tab-pane fade table-responsive" style="padding-top:15px;">
                              <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_inventory') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="event_id" value="{{ $id }}">
                                  {{inventory::main($id)}}
                                <button id="submit_bt" name="btn-trianing" type="submit" class="btn btn-primary" >
                                  บันทึก
                                </button>
                              </form>
                            </div>
<!-- inventory ===============================================================================================-->
                            <div id="pay" class="tab-pane fade table-responsive" style="padding-top:15px;">
                              <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_payment') }}">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <input type="hidden" name="event_id" value="{{ $id }}">
                                    {{payment::main($id)}}
                              </form>
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
