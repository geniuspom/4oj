@include('Member.header')

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">รีเซตรหัสผ่าน</div>
				<div class="panel-body">

					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/forgot') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">ที่อยู่อีเมล</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									ส่งอีเมลเพื่อทำการรีเซตรหัสผ่าน
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
