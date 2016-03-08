@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Assignment\AssignManage as AssignManage;
use App\Http\Controllers\MainControllers\Date_time as Date_time;

	$id = Route::Input('assign_id');
	$status = Route::Input('status');

  $root_url = dirname($_SERVER['PHP_SELF']);

  $event_data = AssignManage::getdata_response($id);
  $textstatus = AssignManage::getstatus_response($status);

  if(isset($event_data)){
    $eventname = $event_data["event_name"];
    $eventday = Date_time::convert_to_thai_format($event_data["event_date"]);
  }else{
    $eventname = "";
    $eventday = "";
  }
?>

@if(!isset($event_data))
<script>
var fullpath = window.location.href;
var rootpath = window.location.origin;
var splite_path = fullpath.split('/');
var subdomain = splite_path[3];
var url = rootpath+'/'+subdomain + '/';
window.location = url;
</script>
@endif

<!-- Show login -->
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      &nbsp;
      <!--<h1 class="page-header"></h1>-->
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">ตอบรับการทำงาน</h3>
            </div>
            <div class="panel-body">

              <form class="form-horizontal" role="form" method="POST" action="{{ url('/response_assign') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
    						<input type="hidden" name="id" value="{{ $id }}">
    						<input type="hidden" name="status" value="{{ $status }}">

                <div class="form-group">
                  <div class="col-md-10 col-md-offset-1 text-center">

                      คุณต้องการ <b class="text-danger">{{ $textstatus }}</b> การทำงาน <b class="text-success">{{ $eventname }}</b> ในวันที่ {{ $eventday }} ใช่หรือไม่

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-8 col-md-offset-2 text-center">
                    <button type="submit" class="btn btn-success" style="width:40%">
    									ยืนยัน
    								</button>
    								<a class="btn btn-danger" href="{{$root_url}}" style="width:40%"> ยกเลิก </a>
                  </div>
                </div>

              </form>
				</div>
			</div>
		</div>
	</div>
</div>


@stop
