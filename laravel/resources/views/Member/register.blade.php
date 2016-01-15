@include('Member.header')
<?php
use App\Http\Controllers\Getdataform as Getdataform;
?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">
                                    <h3 class="panel-title">ลงทะเบียน</h3>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">ชื่อ *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">นามสกุล *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">ชื่อเล่น *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">ที่อยู่อีเมล *</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">รหัสผ่าน *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">ยืนยันรหัสผ่าน *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">โทรศัพท์มือถือ *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">หมายเลขบัตรประชาชน *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="id_card" value="{{ old('id_card') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">ชื่อธนาคาร</label>
							<div class="col-md-6">
                  {{ Getdataform::getbank(old('bank')) }}
									<h6 class="text-muted">*ธนาคารกสิกรไทยจะไม่เสียค่าโอน</h6>
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">หมายเลขบัญชีธนาคาร</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="account" value="{{ old('account') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">ระดับการศึกษา</label>
							<div class="col-md-6">
                                                                {{ Getdataform::geteducation(old('education')) }}
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">ชื่อสถาบันการศึกษา</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="institute" value="{{ old('institute') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">บุคคลที่แนะนำมา</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
							</div>
						</div>

                                                <div class="form-group hidden">
							<div class="col-md-6 col-md-offset-4 text-danger">
                                                            * จำเป็นต้องกรอกข้อมูล
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary" >
									ลงทะเบียน
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

@include('Member.footer')
