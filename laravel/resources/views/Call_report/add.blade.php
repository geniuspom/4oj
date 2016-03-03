@extends('Member.master')
@section('content')
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Call Report</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">สร้างบันทึกการโทร</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_call_report') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">ชื่อบริษัท *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="customer_id" value="{{ old('customer_id') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Hashtag</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="hashtag" value="{{ old('hashtag') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ข้อความ *</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="comment" >{{ old('comment') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">มอบหมายให้</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="assigned_id" value="{{ old('assigned_id') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" name="submit" value="add_call">
                          บันทึก
                        </button>
                        <a class="btn btn-primary" href="{{ $root_url }}/call_report"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>
<script src="{{$root_url}}/public/js/callreport.js"></script>
<script src="{{$root_url}}/public/js/autoCompleteCustomer.js"></script>
<script src="{{$root_url}}/public/js/autoCompleteUser.js"></script>

@stop
