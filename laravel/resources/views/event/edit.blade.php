@extends('Member.master')
@section('content')
<meta name="_token" content="{!! csrf_token() !!}"/>
<?php
use App\Http\Controllers\EventControl as EventControl;
use App\Http\Controllers\Getdataform as Getdataform;
$id = Route::Input('id');
$cusid = EventControl::get($id,'customer');
$contactid = EventControl::get($id,'custumer_contact_id');
?>
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
              <h3 class="panel-title">เพิ่มงานที่กำลังเปิดรับ</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_event') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่องาน *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="event_name" value="{{ EventControl::get($id,'event_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อลูกค้า *</label>
                        <div class="col-md-6">
                          {{ Getdataform::getcustomer($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">รูปแบบการจัดประชุม *</label>
                        <div class="col-md-6">
                          {{ Getdataform::event_type($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">วันเริ่ม *</label>
                      <div class="col-md-6" id="sandbox-container">
                        <div class="input-group date">
                          <input type="text" class="form-control" name="event_date" id="event_date" value="{{ EventControl::get($id,'event_date') }}"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">สถานที่จัดประชุม *</label>
                        <div class="col-md-6">
                          {{ Getdataform::getvenue($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">จำนวนจุดลงทะเบียน *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="register_point" value="{{ EventControl::get($id,'register_point') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">จำนวนจุดนับคะแนน *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="summary_point" value="{{ EventControl::get($id,'summary_point') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เวลาเปิดประชุม *</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="stert_time">
                            <input type="text" class="form-control" name="stert_time" value="{{ EventControl::get($id,'stert_time') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เวลาเปิดลงทะเบียน *</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="register_time">
                            <input type="text" class="form-control" name="register_time" value="{{ EventControl::get($id,'register_time') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">วันติดตั้งอุปกรณ์ *</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="setup_date">
                            <input type="text" class="form-control" name="setup_date" value="{{ EventControl::get($id,'setup_date') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เวลาติดตั้งอุปกรณ์ *</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="setup_time">
                            <input type="text" class="form-control" name="setup_time" value="{{ EventControl::get($id,'setup_time') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เวลานัดหมายทีม OJ *</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="staff_appointment_time">
                            <input type="text" class="form-control" name="staff_appointment_time" value="{{ EventControl::get($id,'staff_appointment_time') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">วันนัดหมาย Supplier*</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="supplier_date">
                            <input type="text" class="form-control" name="supplier_date" value="{{ EventControl::get($id,'supplier_date') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เวลานัดหมาย Supplier*</label>
                      <div class="col-md-6" >
                        <div class="input-group date" id="supplier_time">
                            <input type="text" class="form-control" name="supplier_time" value="{{ EventControl::get($id,'supplier_time') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6" id="customer_contact">
                          {{ EventControl::getcontact_form($cusid,$contactid,"edit") }}
                      </div>
                    </div>

                    <div class="form-group hidden" id="custumer_contact_name">
                      <label class="col-md-4 control-label"></label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="custumer_contact_name" value="{{ old('custumer_contact_name') }}">
                      </div>
                    </div>

                    <div class="form-group hidden" id="custumer_contact_phone">
                      <label class="col-md-4 control-label">โทรศัพท์ผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="custumer_contact_phone" value="{{ old('custumer_contact_phone') }}">
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="custumer_contact_name" value="{{ EventControl::get($id,'custumer_contact_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ผู้ประสานงานลูกค้า</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="custumer_contact_phone" value="{{ EventControl::get($id,'custumer_contact_phone') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงานโรงแรม</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="hotel_contact_name" value="{{ EventControl::get($id,'hotel_contact_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ผู้ประสานงานโรงแรม</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="hotel_contact_phone" value="{{ EventControl::get($id,'hotel_contact_phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงาน supplier</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="supplier_contact_name" value="{{ EventControl::get($id,'supplier_contact_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ผู้ประสานงาน supplier</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="supplier_contact_phone" value="{{ EventControl::get($id,'supplier_contact_phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงาน OJ</label>
                      <div class="col-md-6">
                        {{ Getdataform::getuserform($id,'edit') }}
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ผู้ประสานงาน OJ</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="staff_contact_phone" value="{{ EventControl::get($id,'staff_contact_phone') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">ช่วงเวลาการประชุม</label>
                        <div class="col-md-6">
                          {{ Getdataform::meeting_period($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">สถานะของงาน</label>
                        <div class="col-md-6">
                          {{ Getdataform::event_status($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          แก้ไขงานที่กำลังเปิดรับ
                        </button>
                        <a class="btn btn-primary" href="{{ URL::previous() }}"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#sandbox-container .input-group.date').datepicker({
    format: "dd/mm/yyyy",
    startDate: "today",
    language: "th"
  });


  $('#stert_time').click(function(event){
   $('#stert_time input').data("DateTimePicker").show();
  });
  $('#stert_time input').datetimepicker({
    format: 'LT',
    locale: 'th'
  });

  $('#register_time').click(function(event){
   $('#register_time input').data("DateTimePicker").show();
  });
  $('#register_time input').datetimepicker({
    format: 'LT',
    locale: 'th'
  });

  $('#staff_appointment_time').click(function(event){
   $('#staff_appointment_time input').data("DateTimePicker").show();
  });
  $('#staff_appointment_time input').datetimepicker({
    format: 'LT',
    locale: 'th'
  });

  $('#setup_date').click(function(event){
   $('#setup_date input').data("DateTimePicker").show();
  });
  $('#setup_date input').datetimepicker({
    defaultDate: new Date(),
    format: "DD/MM/YYYY",
    locale: 'th'
  });

  $('#setup_time').click(function(event){
   $('#setup_time input').data("DateTimePicker").show();
  });
  $('#setup_time input').datetimepicker({
    format: "LT",
    locale: 'th'
  });

  $('#supplier_date').click(function(event){
   $('#supplier_date input').data("DateTimePicker").show();
  });
  $('#supplier_date input').datetimepicker({
    defaultDate: new Date(),
    format: "DD/MM/YYYY",
    locale: 'th'
  });

  $('#supplier_time').click(function(event){
   $('#supplier_time input').data("DateTimePicker").show();
  });
  $('#supplier_time input').datetimepicker({
    format: "LT",
    locale: 'th'
  });

  $('#customer_id').change(function(){
    $customer_id = $( "#customer_id option:selected" ).val();
    get_customer_contact($customer_id);
  });

});
$(document).on('change', '#customer_contact_select', function() {
  $contact_id = $( "#customer_contact_select option:selected" ).val();
    if($contact_id == 0){
      $("#custumer_contact_name").removeClass('hidden');
      $("#custumer_contact_phone").removeClass('hidden');
    }else{
      $("#custumer_contact_name").addClass('hidden');
      $("#custumer_contact_phone").addClass('hidden');
    }

});

$(document).on('change', '#event_date', function() {
    var timevalue = $("#event_date").val();
    $("#setup_date input").val(timevalue);
    $("#supplier_date input").val(timevalue);
});


function get_customer_contact($customer_id){
  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $.ajax({
      url: '/4oj/geteventform',
      type: "post",
      data: {'customer_id': $customer_id,'function':'getcustomercontact'},
      success: function(data){
        $("#customer_contact").html(data);
        $contact_id = $( "#customer_contact_select option:selected" ).val();
        if($contact_id == 0){
          $("#custumer_contact_name").removeClass('hidden');
          $("#custumer_contact_phone").removeClass('hidden');
        }else{
          $("#custumer_contact_name").addClass('hidden');
          $("#custumer_contact_phone").addClass('hidden');
        }
      }
    });
}

</script>

@stop
