@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\EventControl as EventControl;
use App\Http\Controllers\Getdataform as Getdataform;
use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\venue\venue_room_control as venue_room_control;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">งานที่กำลังเปิดรับ</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ EventControl::get($id,'event_name') }}</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
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
                      <label class="col-md-5 text-right">วันติดตั้งอุปกรณ์</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'setup_date') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เวลาติดตั้งอุปกรณ์</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'setup_time') }}
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-md-5 text-right">เวลานัดหมายทีม OJ</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'staff_appointment_time') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันนัดหมาย Supplier</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'supplier_date') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เวลานัดหมาย Supplier</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'supplier_time') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get_customer_contact($id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์ผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get_customer_contact($id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อผู้ประสานงานโรงแรม</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'hotel_contact_name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์ผู้ประสานงานโรงแรม</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'hotel_contact_phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อผู้ประสานงาน supplier</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'supplier_contact_name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์ผู้ประสานงาน supplier</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'supplier_contact_phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อผู้ประสานงาน OJ</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get_OJ_contact($id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์ผู้ประสานงาน OJ</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get_OJ_contact($id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ช่วงเวลาการประชุม</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'meeting_period') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">สถานะของงาน</label>
                      <div class="col-md-6 text-info" >
                          {{ EventControl::get($id,'event_status') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        @if (LoginController::checkpermission(2))
                        <a class="btn btn-primary" href="{{$root_url}}/edit_event/{{ $id }}"> แก้ไขข้อมูล </a>
                        @endif

                        <form style="display:inline;" role="form" method="POST" action=" {{ url('request_event') }} ">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="event_id" value="{{ $id }}">

                          <button type="submit" class="btn btn-primary request_this_event" >
                            ยื่นขอทำงานนี้
                          </button>

                        </form>
                        <a class="btn btn-primary" href="{{$root_url}}/assigment/{{$id}}"> จัดคนทำงาน </a>

                        <a class="btn btn-primary" href="{{$root_url}}/event"> ยกเลิก </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $( ".request_this_event" ).click(function() {
          var txt;
          var r = confirm("คุณต้องการยื่นขอทำงานนี้นี้หรือไม่");
          if (r == true) {
              return true;
          } else {
              return false;
          }
        });

    });

</script>

@stop
