@include('Member.header')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
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
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block" >
                                    Login
				</button>
                                <dl class="dl-horizontal">
                                    <dt>
                                        <a href="{{ url('/forgot') }}" class=""><strong>Forgot Password?</strong></a>
                                    </dt>
                                    <dd class="text-center">
                                        <a href="{{ url('/register') }}" class=""><strong>Register</strong></a>
                                    </dd>
                                </dl>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('Member.footer')
