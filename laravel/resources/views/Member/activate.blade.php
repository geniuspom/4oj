<?php

	$activatecode = Route::Input('activatecode');

?>

@extends('Member.masterguest')
@section('content')

<!-- Not logon -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">ยืนยันบัญชีผู้ใช้</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/activateaccount') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="activatecode" value="{{ $activatecode }}">

						<div class="form-group">
							<div class="col-md-10 col-md-offset-1 text-center">

									ขอบคุณสำหรับการยืนยันบัญชีผู้ใช้  กรุณากดที่ปุ่มด้านล่างเพื่อทำการยืนยันบัญชีผู้ใช้.

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" class="btn btn-primary" style="width:100%">
									ยืนยันบัญชีผู้ใช้
								</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
