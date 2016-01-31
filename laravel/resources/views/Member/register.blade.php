@include('Member.header')
<?php
use App\Http\Controllers\Getdataform as Getdataform;
use App\Http\Controllers\InstituteController as InstituteController;
?>
<!-- jQuery UI -->
<script src="/4oj/public/jquery-ui/jquery-ui.js"></script>

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
							<div class="col-md-6" id="email">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
								<h6 class="text-danger"></h6>
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
							<label class="col-md-4 control-label">วันเกิด *</label>
							<div class="col-md-6">
								<div class="input-group date" id="birthday">
										<input type="text" class="form-control" name="birthday" value="{{ old('birthday') }}"/>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">หมายเลขบัตรประชาชน *</label>
							<div class="col-md-6" id="id_card">
								<input type="text" class="form-control" maxlength="13" name="id_card" value="{{ old('id_card') }}">
								<h6 class="text-muted">*ใส่เฉพาะตัวเลข 13 หลัก</h6>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">โทรศัพท์มือถือ *</label>
							<div class="col-md-6">
								<input type="text" maxlength="10" class="form-control" name="phone" value="{{ old('phone') }}">
								<h6 class="text-muted">*ใส่เฉพาะตัวเลข 10 หลัก</h6>
							</div>
						</div>


<!--
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
								<h6 class="text-muted">*ใส่เฉพาะตัวเลข</h6>
							</div>
						</div>

						<div class="form-group">
								<label class="col-md-4 control-label">ที่อยู่ปัจจุบัน</label>
								<div class="col-md-6">
									<textarea class="form-control" rows="5" name="address" >{{ old('address') }}</textarea>
								</div>
						</div>

						<div class="form-group" id="province">
								<label class="col-md-4 control-label">จังหวัด</label>
								<div class="col-md-6">
									{{ Getdataform::province(old('province'),'new') }}
								</div>
						</div>

						<div class="form-group hidden" id="district">
								<label class="col-md-4 control-label">เขต</label>
								<div class="col-md-6">
									{{ Getdataform::district(old('district'),'new') }}
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
								<input type="text" class="form-control" id="institute" name="institute" value="{{ old('institute') }}">
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
						</div>-->

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                <button id="submit_bt" type="submit" class="btn btn-primary" >
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
<script type="text/javascript">

$(function() {
    var availableTags = <?php include('../4oj/laravel/app/Http/Controllers/InstituteController.php'); ?>;
    $("#institute").autocomplete({
        source: availableTags,
        autoFocus:true
    });
});
	$(document).on('change', '#province', function() {
	  $district = $( "#province option:selected" ).val();
	    if($district == 69){
	      $("#district").removeClass('hidden');
	    }else{
	      $("#district").addClass('hidden');
	    }

	});

	$('#birthday').click(function(event){
	 $('#birthday input').data("DateTimePicker").show();
	});
	$('#birthday input').datetimepicker({
		format: "DD/MM/YYYY",
		locale: 'th'
	});


	function validateEmail(email) {
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(email)) {
				return true;
		}
		else {
				return false;
		}

	}

	$(document).on( "focusout", "#email input" ,function(){
		var email = $( "#email input" ).val();

		if(validateEmail(email)){
			$("#email h6" ).html("");
			checkallinput();
		}else{
			$("#email h6" ).html('อีเมลไม่ถูกต้องกรุณาพิมพ์อีเมลที่ถูกต้อง');
			$('#submit_bt').prop('disabled', true);
		}

	});

	$(document).on( "focusout", "#id_card input" ,function(){
		var id = $( "#id_card input" ).val();

		if(CheckPersonID(id)){
			$("#id_card h6" ).html("*ใส่เฉพาะตัวเลข 13 หลัก");
			$("#id_card h6" ).removeClass('text-danger')
			$("#id_card h6" ).addClass('text-muted');
			checkallinput();
		}else{
			$("#id_card h6" ).html('เลขบัตรประชาชนไม่ถูกต้องกรุณาพิมพ์เลขบัตรประชาชนที่ถูกต้อง');
			$("#id_card h6" ).removeClass('text-muted')
			$("#id_card h6" ).addClass('text-danger');
			$('#submit_bt').prop('disabled', true);
		}

	});


	$(document).ready(function() {
     $('#submit_bt').prop('disabled', true);
 	});

	function CheckPersonID (id) {
		var x = new String(id);
		var splitext = x.split("");
		var total = 0;
		var mul = 13;
		for(i=0;i<splitext.length-1;i++) {
			total = total + splitext[i] * mul;
			mul = mul -1;
		}

		var mod = total % 11;
		var nsub = 11 - mod;
		var mod2 = nsub % 10;

		if(mod2!=splitext[12]){
			return false;
		}else{
			return true;
		}

	}

	function CheckBankid (id) {
		var x = new String(id);
		var splitext = x.split("");
		var total = 0;
		var mul = 10;
		for(i=0;i<splitext.length-1;i++) {
			total = total + splitext[i] * mul;
			mul = mul -1;
		}

		var mod = total % 8;
		var nsub = 8 - mod;
		var mod2 = nsub % 10;

		if(mod2!=splitext[9]){
			return false;
		}else{
			return true;
		}

	}


	function checkallinput(){
		var email = $( "#email input" ).val();
		var id = $( "#id_card input" ).val();

		if(CheckPersonID(id) && validateEmail(email)){
			$('#submit_bt').prop('disabled', false);
		}

	}


</script>
@include('Member.footer')
