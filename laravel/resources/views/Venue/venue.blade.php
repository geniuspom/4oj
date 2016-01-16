@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\VenueControl as VenueControl;
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">สถานที่จัดงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <div class="row">
    <div class="col-lg-12 form-group">
      <a class="btn btn-primary text-right" href="add_venue">เพิ่มสถานที่จัดงาน</a>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th class="text-center">ชื่อสถานที่</th>
                <th class="text-center">ที่อยู่</th>
                <th class="text-center">โทรศัพท์</th>
                <th class="text-center">เขต</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              {{ VenueControl::getall() }}
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->

@stop
