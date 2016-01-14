@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
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
                          {{ GetUser::getedituser(Auth::user()->id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">นามสกุล</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'surname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อเล่น</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'nickname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์มือถือ</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'phone') }}
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
                        {{ GetUser::getedituser(Auth::user()->id,'account_no') }}
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
                        {{ GetUser::getedituser(Auth::user()->id,'institute') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">บุคคลที่แนะนำมา</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'reference') }}
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
</div>

@stop
