@include('Member.header')
<?php
use App\Http\Controllers\Getdataform as Getdataform;
?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="margin-top: 5%;margin-bottom: 5%">
				<div class="panel-heading">
                                    <h3 class="panel-title">Register</h3>
                                </div>
				<div class="panel-body">

                                    @if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
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
							<label class="col-md-4 control-label">Name *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">SurName *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Nickname *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address *</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Phone number *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">ID Card No. *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="id_card" value="{{ old('id_card') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Bank name</label>
							<div class="col-md-6">
                                                                {{ Getdataform::getbank(old('bank')) }}
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Account No.</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="account" value="{{ old('account') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Education</label>
							<div class="col-md-6">
                                                                {{ Getdataform::geteducation(old('education')) }}
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Institute</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="institute" value="{{ old('institute') }}">
							</div>
						</div>

                                                <div class="form-group">
							<label class="col-md-4 control-label">Reference</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
							</div>
						</div>

                                                <div class="form-group hidden">
							<div class="col-md-6 col-md-offset-4 text-danger">
                                                            * Requirement
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary" >
									Register
								</button>
								<a class="btn btn-primary" href="/4oj/"> Cancel </a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@include('Member.footer')
