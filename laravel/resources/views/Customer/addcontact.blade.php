@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Customercontrol as Customercontrol;
$id = Route::Input('id');
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายละเอียดลูกค้า - {{ Customercontrol::get($id,'name') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">เพิ่มผู้ประสานงาน</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/add_contact') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="customer_id" value="{{ $id }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงาน *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ตำแหน่ง</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="position" value="{{ old('position') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">อีเมล</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์มือถือ</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ข้อมูลเพิ่มเติม</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="remark" >{{ old('remark') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          เพิ่มผู้ประสานงาน
                        </button>
                        <a class="btn btn-primary" href="/4oj/customer_detail/{{ $id }}"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
