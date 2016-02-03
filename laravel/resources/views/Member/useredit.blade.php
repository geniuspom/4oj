@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
use App\Http\Controllers\InstituteController as InstituteController;
use App\Http\Controllers\Getdataform as Getdataform;
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<!-- jQuery UI -->
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">แก้ไขข้อมูลผู้ใช้</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <?php $id = Route::Input('id');
  ?>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ GetUser::getuser($id) }}</h3>
            </div>
            <div class="panel-body">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/updateuser') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ GetUser::getedituser($id,'name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">นามสกุล *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="surname" value="{{ GetUser::getedituser($id,'surname') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อเล่น *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="nickname" value="{{ GetUser::getedituser($id,'nickname') }}">
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">E-Mail Address *</label>
                      <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ GetUser::getedituser($id,'email') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์มือถือ *</label>
                      <div class="col-md-6">
                        <input type="text" maxlength="10" class="form-control" name="phone" value="{{ GetUser::getedituser($id,'phone') }}">
                        <h6 class="text-muted">*ใส่เฉพาะตัวเลข 10 หลัก</h6>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Line ID</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="lineid" value="{{ GetUser::getedituser($id,'lineid') }}">
                        <h6 class="text-muted">*เป็นช่องทางที่สะดวกที่สุดในการติดต่อ</h6>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">วันเกิด *</label>
                      <div class="col-md-6">
                        <div class="input-group date" id="birthday">
                            <input type="text" class="form-control" name="birthday" value="{{ GetUser::getedituser($id,'birthday') }}"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">ID Card No. *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="id_card" value="{{ GetUser::getedituser($id,'id_card') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อธนาคาร</label>
                      <div class="col-md-6" >
                          {{ GetUser::getedituser($id,'bank') }}
                          <h6 class="text-muted">*ธนาคารกสิกรไทยจะไม่เสียค่าโอน</h6>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">หมายเลขบัญชีธนาคาร</label>
                      <div class="col-md-6" id="account">
                        <input type="text" maxlength="10" class="form-control" name="account" value="{{ GetUser::getedituser($id,'account_no') }}">
                        <h6 class="text-muted">*ใส่เฉพาะตัวเลข</h6>
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">ที่อยู่ปัจจุบัน</label>
                        <div class="col-md-6">
                          <textarea class="form-control" rows="5" name="address" >{{ GetUser::getedituser($id,'address') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group" id="province">
                        <label class="col-md-4 control-label">จังหวัด</label>
                        <div class="col-md-6">
                          {{ Getdataform::province($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group" id="district">
                        <label class="col-md-4 control-label">เขต</label>
                        <div class="col-md-6">
                          {{ Getdataform::district($id,'edit') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">ที่อยู่ตามบัตรประชาชน</label>
                        <div class="col-md-6">
                          <div class="checkbox">
                            <label><input type="checkbox" value="true" name="address_id_checkbox">ใช้ตามที่อยู่ปัจจุบัน</label>
                          </div>
                          <textarea class="form-control" rows="5" name="address_id" >{{ GetUser::getedituser($id,'address_id') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ระดับการศึกษา</label>
                      <div class="col-md-6">
                          {{ GetUser::getedituser($id,'education') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อสถาบันการศึกษา</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="institute" name="institute" value="{{ GetUser::getedituser($id,'institute') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">บุคคลที่แนะนำมา</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="reference" value="{{ GetUser::getedituser($id,'reference') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label"></label>
                      <div class="col-md-6">
                        <h6 class="text-warning">*กรุณากรอกเชขบัญชีธนาคารก่อนยืนยันการแก้ไขข้อมูล</h6>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button id="submit_bt" type="submit" class="btn btn-primary" >
                          ยืนยันการแก้ไขข้อมูล
                        </button>
                        <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                        <a class="btn btn-primary" href="{{$root_url}}/admin"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>
<script type="text/javascript">

$(function() {
    var availableTags = <?php include('..'.$root_url.'/laravel/app/Http/Controllers/InstituteController.php'); ?>;
    $("#institute").autocomplete({
        source: availableTags,
        autoFocus:true
    });
});

$(document).on('change', '#province', function() {
  $district = $( "#province option:selected" ).val();
    if($district == 69){
      $("#district").removeClass('hidden');
    }else{
      $("#district").addClass('hidden');
    }

});

$('#birthday').click(function(event){
 $('#birthday input').data("DateTimePicker").show();
});
$('#birthday input').datetimepicker({
  format: "DD/MM/YYYY",
  locale: 'th'
});

/*$(document).on( "focusout", "input" ,function(){
  var id = $( "#account input" ).val();

  if(CheckBankid(id)){
    $("#account h6" ).html("*ใส่เฉพาะตัวเลข");
    $("#account h6" ).removeClass('text-danger')
    $("#account h6" ).addClass('text-muted');
    $('#submit_bt').prop('disabled', false);
  }else{
    $("#account h6" ).html('หมายเลขบัญชีธนาคารไม่ถูกต้องกรุณาพิมพ์หมายเลขบัญชีธนาคารที่ถูกต้อง');
    $("#account h6" ).removeClass('text-muted')
    $("#account h6" ).addClass('text-danger');
    $('#submit_bt').prop('disabled', true);
  }

});*/

function CheckBankid (id) {
  var x = new String(id);
  var splitext = x.split("");
  var total = 0;
  var mul = 10;
  for(i=0;i<splitext.length-1;i++) {
    total = total + splitext[i] * mul;
    mul = mul -1;
  }

  var mod = total % 8;
  var nsub = 8 - mod;
  var mod2 = nsub % 10;

  if(mod2!=splitext[9]){
    return false;
  }else{
    return true;
  }

}

$(document).ready(function() {
   //$('#submit_bt').prop('disabled', true);
});


</script>
@stop
