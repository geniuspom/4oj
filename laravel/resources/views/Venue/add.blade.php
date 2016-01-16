@extends('Member.master')
@section('content')

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">สถานที่จัดงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">เพิ่มสถานที่จัดงาน</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/add_venue') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อสถานที่ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ที่อยู่ *</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="address" >{{ old('address') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">โทรศัพท์ *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          เพิ่มสถาที่จัดงาน
                        </button>
                        <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                        <a class="btn btn-primary" href="venue"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
