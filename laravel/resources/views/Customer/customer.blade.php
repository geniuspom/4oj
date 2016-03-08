@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Customercontrol as Customercontrol;
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายชื่อลูกค้า</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <div class="row">
    <div class="col-lg-12 form-group" style="display:inline-flex;">
      <a class="btn btn-primary text-right" href="add_customer"> เพิ่มลูกค้า </a>
      <input placeholder="ค้นหา.." type="text" class="input-xs form-control" id="filter" name="filter" value="" style="margin-left:5px;"/>
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
      <div class="table-responsive" id="result_customer">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th class="text-center">ชื่อย่อบริษัท</th>
                <th class="text-center">ชื่อบริษัท</th>
                <th class="text-center">โทรศัพท์</th>
                <th class="text-center">เว็บไซต์</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              {{ Customercontrol::getall() }}
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->
<script src="{{$root_url}}/public/js/customer.js"></script>

@stop
