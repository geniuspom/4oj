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
      <h1 class="page-header">Call Report</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <div class="row print_button">
    <div class="col-lg-12 text-right">
      <a onclick='window.print()' title="พิมพ์รายงาน"><i style="cursor:pointer;" class="fa fa-print fa-2x"></i></a>
    </div>
  </div>
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
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <!-- search and filter -->
  <div class="row no_print">
    <div class="col-sm-12 form-group">
        <a href="add_call_report" class="btn btn-primary text-right" style="margin-bottom:5px;">สร้างบันทึกการโทร</a>
        <div style="display:inline-flex;">
          <select class="form-control" id="filter_group" name="filter_group">
              <option selected="selected" value="1">ชื่อลูกค้า</option>
              <option value="2">Hashtag</option>
          </select>
          <input type="text" class="input-xs form-control" id="filter_value" name="filter_value" value="" style="margin-left:5px;"/>
        </div>
    </div>
    <!-- /.col-lg-12 -->
  </div>
    <div id="report_content">

    </div>
</div>
<!-- /#page-wrapper -->
<script src="{{$root_url}}/public/js/autoCompleteCustomer.js"></script>
<script src="{{$root_url}}/public/js/callreport.js"></script>
<script>
$(document).ready(function(){

    var filter_value = $("#filter_value").val();

    if(filter_value != ""){
      sendfilter();
    }

});
</script>
@stop
