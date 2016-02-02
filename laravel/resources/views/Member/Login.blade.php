@include('Member.header')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">กรุณาลงชื่อเข้าใช้งาน</h3>
                    </div>
                        @if (session('status'))
              						<div class="alert alert-success">
              							{{ session('status') }}
              						</div>
              					@endif
                        @if(Session::has('message'))
                            <div class="panel-body bg-danger color-red">
                            {{Session::get('message')}}
                            </div>
                        @endif
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="ชื่ออีเมล" name="email" type="email" value="{{ old('email') }}" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="รหัสผ่าน" name="password" type="password" value="">
                                </div>
                                <div>
                                  <div class="col-xs-6 text-left form-group">
                                    <a href="{{ url('/forgot') }}" class=""><strong>ลืมรหัสผ่าน?</strong></a>
                                  </div>
                                  <div class="col-xs-6 text-right form-group">
                                    <a href="{{ url('/register') }}" class=""><strong>ลงทะเบียน</strong></a>
                                  </div>
                                </div>
                                <!--<div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">จดจำในระบบ
                                    </label>
                                </div>-->
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block" >
                                    ลงชื่อเข้าใช้งาน
				                        </button>
                            </fieldset>
                        </form>
                        <div class="text-center" style="padding:15px 15px 0px 15px;">
                          <a href="/4oj/upload_file/manual/register manual 4OJ.pdf" target="_blank"><i class="fa fa-info-circle fa-fw"></i>คู่มือการสมัครสมาชิกและการใช้งาน</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('Member.footer')
