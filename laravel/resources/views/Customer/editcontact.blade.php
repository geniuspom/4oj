@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Customercontrol as Customercontrol;
use App\Http\Controllers\Customer\Contact as Contact;
$id = Route::Input('id');
$customerid = Contact::get_contact_in($id,'customer_id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายละเอียดลูกค้า - {{ Customercontrol::get($customerid,'name') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">แก้ไขผู้ประสานงาน - {{ Contact::get_contact_in($id,'name') }}</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_contact') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อผู้ประสานงาน *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ Contact::get_contact_in($id,'name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ตำแหน่ง</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="position" value="{{ Contact::get_contact_in($id,'position') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">อีเมล</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="email" value="{{ Contact::get_contact_in($id,'email') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ Contact::get_contact_in($id,'phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์มือถือ</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="mobile" value="{{ Contact::get_contact_in($id,'mobile') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ข้อมูลเพิ่มเติม</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="remark" >{{ Contact::get_contact_in($id,'remark') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          แก้ไขข้อมูลผู้ประสานงาน
                        </button>
                        <a class="btn btn-primary" href="{{$root_url}}/customer_detail/{{ $customerid }}"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
