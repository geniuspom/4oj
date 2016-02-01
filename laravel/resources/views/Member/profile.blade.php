@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
use App\Http\Controllers\UploadController as UploadController;

?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">ข้อมูลส่วนตัว</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ GetUser::getuser(Auth::user()->id) }}</h3>
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
                        {{ GetUser::getprofile(Auth::user()->id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">นามสกุล</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'surname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อเล่น</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'nickname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์มือถือ</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Line ID</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'lineid') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันเกิด</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'birthday') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อธนาคาร</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'bank') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">หมายเลขบัญชีธนาคาร</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'account_no') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ระดับการศึกษา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'education') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อสถาบันการศึกษา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'institute') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่ปัจจุบัน</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'address') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">จังหวัด</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'province') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เขต</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'district') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่ตามบัตรประชาชน</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'address_id') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">บุคคลที่แนะนำมา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'reference') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" href="/4oj/useredit/{{ Auth::user()->id }}"> แก้ไขข้อมูล </a>
                        <a class="btn btn-primary" href="/4oj/reset/{{ Auth::user()->id }}/token/null"> เปลี่ยนรหัสผ่าน </a>
                        <a class="btn btn-primary" href="/4oj/"> ยกเลิก </a>
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
                  <form action="{{ url('/uploaduser') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                  <div class="form-horizontal">
                        <div class="form-group">
                          <label class="col-md-5 text-right">รูปภาพ</label>
                          <div class="col-md-6 text-info" >

                            <div style="width:206px;">
                              <!-- Show image -->
                              <a href="{{ asset('upload_file/images/default/'.UploadController::getImage(Auth::user()->id,'image')) }}" target="_blank">
                                <i style="background-image: url('{{ UploadController::getImage(Auth::user()->id,'thumbnail') }}'); display: block; background-position: center center; width: 206px; padding-top: 206px;"></i>
                              </a>
                            </div>

                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-5 text-right"></label>
                          <div class="col-md-6 text-info" >
                            <input type="file" name="uploader" id="uploader" />
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-success" type="submit" name = "btn-upload" title="Upload image"><i class="fa fa-upload" ></i> Upload</button>
                          </div>
                        </div>
                      </div>
                  </form>
                  <!-- End Profile Image -->
                  <hr/>
                  <!-- ID Card -->
                  <form action="{{ url('/uploadidcard') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                  <div class="form-horizontal">
                        <div class="form-group">
                          <label class="col-md-5 text-right">บัตรประชาชน</label>
                          <div class="col-md-6 text-info" >

                            <div style="width:206px;">
                              <a href="{{ asset('upload_file/idcard/default/'.UploadController::getidcard(Auth::user()->id,'image')) }}" target="_blank">
                                <i style="background-image: url('{{ UploadController::getidcard(Auth::user()->id,'thumbnail') }}'); display: block; background-position: center center; width: 206px; padding-top: 206px;"></i>
                              </a>
                            </div>

                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-5 text-right"></label>
                          <div class="col-md-6 text-info" >
                            <input type="file" name="uploader" id="uploader" />
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-success" type="submit" name = "btn-upload" title="Upload image"><i class="fa fa-upload" ></i> Upload</button>
                          </div>
                        </div>
                      </div>
                  </form>
                  <!-- End ID Card -->

                </div>
              </div>
            </div>
          </div>

</div>

@stop
