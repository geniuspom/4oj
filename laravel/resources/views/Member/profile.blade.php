@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">User Profile</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ GetUser::getuser(Auth::user()->id) }}</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">Name</label>
                      <div class="col-md-6 text-info" >
                          {{ GetUser::getedituser(Auth::user()->id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">SurName</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'surname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Nickname</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'nickname') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Phone number</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Bank name</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'bank') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Account No.</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'account_no') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Education</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getprofile(Auth::user()->id,'education') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Institute</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'institute') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">Reference</label>
                      <div class="col-md-6 text-info">
                        {{ GetUser::getedituser(Auth::user()->id,'reference') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" href="/4oj/useredit/{{ Auth::user()->id }}"> Edit </a>
                        <a class="btn btn-primary" href="/4oj/reset/{{ Auth::user()->id }}/token/null"> Change Password </a>
                        <a class="btn btn-primary" href="/4oj/"> Cancel </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
