@extends('Member.master')
@section('content')
<?php
//use App\Http\Controllers\RequestJob as RequestJob;
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>

<script src="{{$root_url}}/public/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="{{$root_url}}/public/bootstrap-wysihtml5/lib/js/prettify.js"></script>
<script src="{{$root_url}}/public/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>

<link rel="stylesheet" type="text/css" href="{{$root_url}}/public/bootstrap-wysihtml5/lib/css/theme.css"></link>
<link rel="stylesheet" type="text/css" href="{{$root_url}}/public/bootstrap-wysihtml5/lib/css/prettify.css"></link>
<link rel="stylesheet" type="text/css" href="{{$root_url}}/public/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css"></link>



<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">ส่งอีเมล</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <div class="row print_button">
    <!--<div class="col-lg-12 text-right">
      <a onclick='window.print()' title="พิมพ์รายงาน"><i style="cursor:pointer;" class="fa fa-print fa-2x"></i></a>
    </div>-->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!--<div class="panel-heading">
              <h3 class="panel-title">เพิ่มลูกค้า</h3>
            </div>-->
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/send_manual_email') }}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">หัวข้ออีเมล</label>
                      <div class="col-md-6">
                        <input type="text" id="subject" class="form-control" name="subject" value="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ข้อความ</label>
                      <div class="col-md-6">
                        <textarea id="editor" class="form-control" rows="10" name="editor" ></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" id="submit_send_email"> ส่งข้อความ </a>
                        <a class="btn btn-primary" href="{{$root_url}}"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
      </div>
  </div>

</div>
<script src="{{$root_url}}/public/js/send_manual_email.js"></script>
@stop
