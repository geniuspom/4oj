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

								<div class="alert alert-success">
									<p>การลงทะเบียนสำเร็จ</P>
								</div>

									<h4 class="text-warning">เพื่อให้การสมัครงานสมบูรณ์ กรุณาไปที่อีเมลที่ใช้ทำการสมัคร<br/><br/>
										และทำการกดลิงค์ที่ได้รับจากอีเมลเพื่อ<span class="text-danger"> ยืนยืนอีเมล </span>ที่ใช้งาน
									</h4>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-4 col-md-offset-4">
								<a href="{{$root_url}}" type="submit" class="btn btn-primary" style="width:100%">
									ตกลง
								</a>
							</div>
						</div>

				</div>
			</div>
		</div>
	</div>
</div>

@stop
