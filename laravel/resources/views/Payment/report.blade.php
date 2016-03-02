@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\RequestJob as RequestJob;
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<!-- jQuery UI -->
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายงานการจ่ายเงิน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <div class="row print_button">
    <div class="col-lg-12 text-right">
      <a onclick='window.print()' title="พิมพ์รายงาน"><i style="cursor:pointer;" class="fa fa-print fa-2x"></i></a>
    </div>
  </div>
  <!-- search and filter -->
  <div class="row no_print">
    <div class="col-sm-6 form-group">
        <div style="display:inline-flex;">
          <select class="form-control" id="filter_group" name="filter_group">
              <option selected="selected" value="1">ชื่อคน</option>
              <option value="2">สถานะ</option>
          </select>
          <input type="text" class="input-xs form-control" id="filter_value" name="filter_value" value="" style="margin-left:5px;"/>
          <select class="form-control hidden" id="filter_status" name="filter_status" style="margin-left:5px;">
              <option value="0">ยังไม่ได้จ่าย</option>
              <option value="1">เตรียมจ่ายเงิน</option>
              <option value="2">จ่ายเงินแล้ว</option>
              <option selected="selected" value="3">ทั้งหมด</option>
          </select>
        </div>
    </div>
    <!-- /.col-lg-12 -->
  </div>
    <div id="report_content">

    </div>
</div>
<!-- /#page-wrapper -->
<script src="{{$root_url}}/public/js/payment.js"></script>
@stop
