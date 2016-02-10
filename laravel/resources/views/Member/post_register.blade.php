@extends('Member.masterguest')
@section('content')
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>

<!-- Not logon -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">ลงทะเบียน</div>
				<div class="panel-body">

						<div class="form-group">
							<div class="col-md-12 text-center">

								@if (session('status'))
									<div class="alert alert-success">
										{{ session('status') }}
									</div>
								@endif

								<div class="alert alert-success">
									<p>การลงทะเบียนสำเร็จ</P>
								</div>

									<h4 class="text-warning">เพื่อให้การสมัครงานสมบูรณ์ กรุณาไปที่อีเมลที่ใช้ทำการสมัคร<br/><br/>
										และทำการกดลิงค์ที่ได้รับจากอีเมลเพื่อ<span class="text-danger"> ยืนยืนอีเมล </span>ที่ใช้งาน<br/><br/>
										หรือคัดลอก รหัสที่ได้รับมากรอก เพื่อยืนยันในช่องด้านล่างนี้<br/><br/>
									</h4>
									<h5>
										<span class="text-danger">*หากท่านไม่ได้รับอีเมล กรุณาตรวจสอบที่อีเมลขยะ (Junk mail หรือ Spam mail) ของท่าน </span><br/><br/>
										<span class="text-info">หากท่านไม่พบในอีเมลขยะกรุณากดที่</span>
										<span class="text-danger"> ส่งอีเมลเพื่อทำการยืนยันอีเมล์ </span><br/><br/>
										<span class="text-info">เพื่อทำการส่งอีเมลอีกครั้ง</span>
									</h5>
							</div>
						</div>
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/activateaccount') }}">


						<div class="form-group">
							<div class="col-md-8 col-md-offset-2 text-center">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input class="form-control text-center" type="text" maxlength="32" name="activatecode" value="">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2 text-center">
								<button type="submit" class="btn btn-primary">
									ยืนยันบัญชีผู้ใช้
								</button>
								<a type='submit' class='btn btn-warning' href='send_email_verify'>
									 ส่งอีเมลเพื่อทำการยืนยันอีเมล์
								</a>
							</div>

						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
</div>

@stop
