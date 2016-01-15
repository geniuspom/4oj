@extends('Member.master')
@section('content')
</div>
<?php
use App\Http\Controllers\Customercontrol as Customercontrol;
$id = Route::Input('id');
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายชื่อลูกค้า</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">แก้ไขลูกค้า</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_customer') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อบริษัท *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ Customercontrol::get($id,'name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อย่อบริษัท *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="symbol" value="{{ Customercontrol::get($id,'symbol') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ที่อยู่ *</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="address" >{{ Customercontrol::get($id,'address') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ Customercontrol::get($id,'phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เว็บไซต์ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="website" value="{{ Customercontrol::get($id,'website') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ที่อยู่ตามเลขผู้เสียภาษี *</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="tax_address" >{{ Customercontrol::get($id,'tax_address') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">เลขผู้เสียภาษี *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="tax_id" value="{{ Customercontrol::get($id,'tax_id') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          แก้ไขข้อมูลลูกค้า
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

@stop
