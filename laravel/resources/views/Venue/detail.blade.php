@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\VenueControl as VenueControl;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายละเอียดสถานที่จัดงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ VenueControl::get($id,'name') }}</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อสถานที่</label>
                      <div class="col-md-6 text-info" >
                          {{ VenueControl::get($id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่</label>
                      <div class="col-md-6 text-info" >
                          {{ VenueControl::get($id,'address') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์</label>
                      <div class="col-md-6 text-info" >
                          {{ VenueControl::get($id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เขต</label>
                      <div class="col-md-6 text-info" >
                          {{ VenueControl::get($id,'area') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" href="{{$root_url}}/edit_venue/{{ $id }}"> แก้ไขข้อมูล </a>
                        <a class="btn btn-primary" href="{{$root_url}}/venue"> ยกเลิก </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
