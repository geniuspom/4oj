@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
use App\Http\Controllers\UploadController as UploadController;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">ข้อมูลผู้สมัครงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12 text-right" style="padding-bottom:10px;">
        <a class="btn btn-primary" href="{{$root_url}}/useredit_admin/{{$id}}"> แก้ไขข้อมูล </a>
        <a class="btn btn-primary" href="{{$root_url}}/admin"> ยกเลิก </a>
      </div>
    </div>
  </div>
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
      <!-- more detail-->
      <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">ข้อมูลอื่นๆ</h3>
                </div>
                <div class="panel-body">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif

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

</div>

@stop
