@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
use App\Http\Controllers\UploadController as UploadController;
use App\Http\Controllers\LoginController as LoginController;

?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script src="{{$root_url}}/public/js/jquery-form.js"></script>
<script src="{{$root_url}}/public/js/Uploadfile.js"></script>
<style type="text/css">
.border-notop{
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.pading-left-right{
  padding-left: 10px;
  padding-right: 10px;
}
.padding-bottom{
  padding-bottom: 10px;
}
.upload_progress {
  position:relative;
  width:400px;
  border: 1px solid #ddd;
  padding: 1px;
  border-radius: 3px;
}
.upload_bar {
  background-color: #B4F5B4;
  width:0%;
  height:20px;
  border-radius: 3px;
}
.upload_percent {
  position:absolute;
  display:inline-block;
  top:3px;
  left:48%;
}
</style>

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
                      <label class="col-md-5 text-right">อีเมล</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'email') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เลขบัตรประชาชน</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'id_card') }}
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
                        <a class="btn btn-primary" href="{{$root_url}}/useredit/{{ Auth::user()->id }}"> แก้ไขข้อมูล </a>
                        <a class="btn btn-primary" href="{{$root_url}}/reset/{{ Auth::user()->id }}/token/null"> เปลี่ยนรหัสผ่าน </a>
                        <a class="btn btn-primary" href="{{$root_url}}"> ยกเลิก </a>
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
                <div class="panel-body" id="profile_pic_id_card">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif

                  <!-- Profile Image -->
                  <!--<form action="{{ url('/uploaduser') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">-->
                  <div class="form-horizontal">
                        <div class="form-group">
                          <label class="col-md-5 text-right">รูปภาพ</label>
                          <div class="col-md-6 text-info" id="result_profile">

                            <div style="width:206px;">
                              <!-- Show image -->
                              {{ UploadController::getImage(Auth::user()->id,'image') }}
                            </div>

                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-5 text-right"></label>
                          <div class="col-md-6 text-info" >
                            <!--<input type="file" name="uploader" id="uploader" />
                            <h6 class="text-danger">*สามารถอัพโหลดได้เฉพาะไฟล์ JPG เท่านั้น</h6>-->
                            <form action="{{ url('/uploaduser') }}" method="post" enctype="multipart/form-data" id="My_picture" class="upload_form">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="method" value="profile">
                                <input name="image_file" id="imageInput" type="file" />
                                <div class="progress upload_progress hidden" >
                                    <div class="bar upload_bar"></div>
                                    <div class="percent upload_percent">0%</div>
                                </div>
                                <div id="output"></div>
                                <button id="upload" value="Upload" class="btn btn-success"><i class="fa fa-upload" ></i> upload</button>
                            </form>

                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <!--<button class="btn btn-success" type="submit" name = "btn-upload" title="Upload image"><i class="fa fa-upload" ></i> Upload</button>-->
                          </div>
                        </div>
                      </div>
                  <!--</form>-->
                  <!-- End Profile Image -->
                  <hr/>
                  <!-- ID Card -->
                  <!--<form action="{{ url('/uploadidcard') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">-->
                  <div class="form-horizontal">
                        <div class="form-group">
                          <label class="col-md-5 text-right">บัตรประชาชน</label>
                          <div class="col-md-6 text-info" id="result_idcard">

                            {{ UploadController::getidcard(Auth::user()->id,'image') }}

                          </div>
                        </div>
                        @if(LoginController::checkemailverify())
                        <div class="form-group">
                          <label class="col-md-5 text-right"></label>
                          <div class="col-md-6 text-info" >
                            <!--<input type="file" name="uploader" id="uploader" />
                            <h6 class="text-danger">*สามารถอัพโหลดได้เฉพาะไฟล์ JPG หรือ PDF เท่านั้น</h6>-->
                              <form action="{{ url('/uploaduser') }}" method="post" enctype="multipart/form-data" id="My_id_card" class="upload_form">
                                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                  <input type="hidden" name="method" value="id_card">
                                  <input name="image_file" id="imageInput" type="file" />
                                  <div class="progress upload_progress hidden" >
                                      <div class="bar upload_bar"></div>
                                      <div class="percent upload_percent">0%</div>
                                  </div>
                                  <div id="output"></div>
                                  <button id="upload" value="Upload" class="btn btn-success"><i class="fa fa-upload" ></i> upload</button>
                              </form>

                          </div>
                        </div>
                        @else
                        <div class="form-group">
                          <label class="col-md-5 text-right"></label>
                          <div class="col-md-6 text-info" >
                            <label class="text-danger"><h6>*จะต้องทำการยืนยันอีเมลก่อนจึงจะอัพโหลดสำเนาบัตรประชาชนได้</h6></label>
                          </div>
                        </div>
                        @endif

                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            @if(LoginController::checkemailverify())
                            <!--<button class="btn btn-success" type="submit" name = "btn-upload" title="Upload image"><i class="fa fa-upload" ></i> Upload</button>-->
                            @endif
                          </div>
                        </div>
                      </div>
                  <!--</form>-->
                  <!-- End ID Card -->

                </div>
              </div>
            </div>
          </div>

</div>

@stop
