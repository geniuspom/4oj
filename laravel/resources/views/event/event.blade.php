@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\EventControl as EventControl;
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">กิจกรรมการประชุม</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <div class="row">
    <div class="col-lg-12 form-group">
      <a class="btn btn-primary text-right" href="add_event">เพิ่มกิจกรมการประชุม</a>
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
                <th class="text-center">ชื่องาน</th>
                <th class="text-center">วันที่</th>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">สถานะของงาน</th>
              </tr>
            </thead>
            <tbody>
              {{ EventControl::getall() }}
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->

@stop
