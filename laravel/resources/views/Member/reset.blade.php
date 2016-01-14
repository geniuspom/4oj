<?php
	$id = Route::Input('id');
	$key = Route::Input('token');

	if(Auth::check()){
		$template = "Member.master";
	}else{
		$template = "Member.masterguest";
	}

	use App\Http\Controllers\GetUser as GetUser;
?>

@extends($template)
@section('content')

@if (Auth::check())
<!-- Show login -->
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">เปลี่ยนระหัสผ่าน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <?php $id = Route::Input('id');
  ?>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ GetUser::getuser($id) }}</h3>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/resetpassword') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="key" value="{{ $key }}">
						<input type="hidden" name="id" value="{{ $id }}">
						<input type="hidden" name="rs_type" value="change">

						<div class="form-group">
							<label class="col-md-4 control-label">รหัสผ่านเดิม *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="old_password" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">รหัสผ่านใหม่ *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">ยืนยันรหัสผ่าน *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									ยืนยันตั้งรหัสผ่านใหม
								</button>
								<a class="btn btn-primary" href="/4oj/user_profile"> ยกเลิก </a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@else

<!-- Not logon -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">เปลี่ยนรหัสผ่าน</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/resetpassword') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="key" value="{{ $key }}">
						<input type="hidden" name="id" value="{{ $id }}">
						<input type="hidden" name="rs_type" value="forgot">

						<div class="form-group">
							<label class="col-md-4 control-label">ที่อยู่อีเมล *</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">รหัสผ่านใหม่ *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">ยืนยันรหัสผ่านใหม่ *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									ยืนยันตั้งรหัสผ่านใหม่
								</button>
								<a class="btn btn-primary" href="/4oj/"> ยกเลิก </a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endif


@stop
