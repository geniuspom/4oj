@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
use App\Http\Controllers\Userdetail as Userdetail;
use App\Http\Controllers\UploadController as UploadController;
use App\Http\Controllers\AdminController as AdminController;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<style type="text/css">
.border-notop{
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">ข้อมูลส่วนตัว</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

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
                  <div class="">
                  <!-- Nav tabs -->
                      <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#permission" aria-expanded="true">สิทธิ์การใช้งาน</a>
                          </li>
                          <li class=""><a data-toggle="tab" href="#training" aria-expanded="false">การอบรม</a>
                          </li>
                          <li class=""><a data-toggle="tab" href="#general" aria-expanded="false">ข้อมูลทั่วไป</a>
                          </li>
                      </ul>
                  </div>

                  <!-- Tab panes -->
                  <div class="tab-content">
                      <div id="permission" class="tab-pane fade active in border-notop" style="padding-top:15px;">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/adminupdateuser') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="user_id" value="{{ $id }}">

                          <div class="form-group">
                            <label class="col-md-4 control-label">ระดับผู้ใช้งาน</label>
                            <div class="col-md-6">
                              {{ AdminController::update_user_form($id,'permission') }}
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 control-label">สถานะการยืนยันอีเมล</label>
                            <div class="col-md-6 ">
                              <label style="padding-top:7px;">
                                <input {{ AdminController::update_user_form($id,'status_mail') }} type="checkbox" name="validate_email_status" value="true" style="width:25px;height:25px;" >
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 control-label">ยืนยันการตรวจสอบสำเนาบัตรประชาชน</label>
                            <div class="col-md-6 ">
                              <label style="padding-top:7px;">
                                <input {{ AdminController::update_user_form($id,'validate') }} type="checkbox" name="validate_id_status" value="true" style="width:25px;height:25px;" >
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">บันทึกเพิ่มเติม</label>
                              <div class="col-md-6">
                                <textarea class="form-control" rows="5" name="remark" >{{ AdminController::update_user_form($id,'remark') }}</textarea>
                              </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                              <button id="submit_bt" type="submit" name="btn-permission" class="btn btn-primary" >
                                ยืนยันการแก้ไขข้อมูล
                              </button>
                              <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                              <a class="btn btn-primary" href="{{$root_url}}/admin"> ยกเลิก </a>
                            </div>
                          </div>

                        </form>


                      </div>
                      <div id="training" class="tab-pane fade border-notop" style="padding-top:15px;">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/adminupdateuser') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="user_id" value="{{ $id }}">

                          <div class="form-group">
                            <label class="col-md-4 control-label">สถานะการอบรม</label>
                            <div class="col-md-6 ">
                              <label style="padding-top:7px;">
                                <input {{ AdminController::update_user_form($id,'training_status') }} type="checkbox" name="training_status" value="true" style="width:25px;height:25px;" >
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 control-label">วันที่อบรม</label>
                            <div class="col-md-6">
                              <div class="input-group date" id="training_date">
                                  <input type="text" class="form-control" name="training_date" value="{{ AdminController::update_user_form($id,'training_date') }}"/>
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 control-label">เกรด</label>
                            <div class="col-md-6">
                                {{ AdminController::update_user_form($id,'grade') }}
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                              <button id="submit_bt" name="btn-trianing" type="submit" class="btn btn-primary" >
                                ยืนยันการแก้ไขข้อมูล
                              </button>
                              <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                              <a class="btn btn-primary" href="{{$root_url}}/admin"> ยกเลิก </a>
                            </div>
                          </div>

                        </form>


                      </div>
                      <div id="general" class="tab-pane fade border-notop" style="padding-top:15px;">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/adminupdateuser') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="user_id" value="{{ $id }}">

                          <div class="form-group">
                            <label class="col-md-4 control-label">ชื่ออีเมล</label>
                            <div class="col-md-6">
                              <input type="text" class="form-control" name="email" value="{{ GetUser::getedituser($id,'email') }}"/>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                              <button id="submit_bt" name="btn-general" type="submit" class="btn btn-primary" >
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
  </div>

  <!-- more detail-->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">ข้อมูลเบื้องต้น</h3>
            </div>

            <div class="panel-body">

              <div class="form-horizontal">

                  <div class="form-group">
                    <label class="col-md-5 text-right">ชื่อ</label>
                    <div class="col-md-6 text-info" >
                      {{ GetUser::getprofile($id,'name') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">นามสกุล</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'surname') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">ชื่อเล่น</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'nickname') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">โทรศัพท์มือถือ</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'phone') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">อีเมล</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'email') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">เลขบัตรประชาชน</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'id_card') }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-5 text-right">Line ID</label>
                    <div class="col-md-6 text-info">
                      {{ GetUser::getprofile($id,'lineid') }}
                    </div>
                  </div>
              </div>


              <!-- Profile Image -->
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">รูปภาพ</label>
                      <div class="col-md-6 text-info" >

                        <div style="width:206px;">
                          <!-- Show image -->
                          {{ UploadController::getImage($id,'image') }}
                        </div>

                      </div>
                    </div>
              </div>
              <!-- End Profile Image -->
              <hr/>
              <!-- ID Card -->
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">บัตรประชาชน</label>
                      <div class="col-md-6 text-info" >

                        {{ UploadController::getidcard($id,'image') }}

                      </div>
                    </div>
              </div>
              <!-- End ID Card -->

            </div>
          </div>
    </div>
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">ข้อมูลเพิ่มเติม</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันเกิด</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'birthday') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อธนาคาร</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'bank') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">หมายเลขบัญชีธนาคาร</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'account_no') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ระดับการศึกษา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'education') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อสถาบันการศึกษา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'institute') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่ปัจจุบัน</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'address') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">จังหวัด</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'province') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เขต</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'district') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่ตามบัตรประชาชน</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'address_id') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">บุคคลที่แนะนำมา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile($id,'reference') }}
                      </div>
                    </div>

                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>

</div>
<script type="text/javascript">

$('#training_date').click(function(event){
 $('#training_date input').data("DateTimePicker").show();
});
$('#training_date input').datetimepicker({
  format: "DD/MM/YYYY",
  locale: 'th'
});

</script>


@stop
