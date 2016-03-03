@extends('Member.master')
@section('content')
<?php $root_url = dirname($_SERVER['PHP_SELF']);
$id = Route::Input('id');
use App\Http\Controllers\Call_report\Manage_callreport as Manage_callreport;
?>

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
              <h3 class="panel-title">รายละเอียดบันทึกการโทร</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อบริษัท</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','customer_id') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Hashtag</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','hashtag') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ข้อความ</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','comment') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">มอบหมายให้</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','assigned_id') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">สร้างโดย</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','created_by') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันที่สร้าง</label>
                      <div class="col-md-6 text-info" >
                          {{ Manage_callreport::getdata($id,'data','created_at') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" href="{{$root_url}}/edit_call_report/{{ $id }}"> แก้ไขข้อมูล </a>
                        <a class="btn btn-primary" href="{{$root_url}}/call_report"> ยกเลิก </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

</div>

@stop
