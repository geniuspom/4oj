@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edit user</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <?php $id = Route::Input('id');
  ?>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ GetUser::getuser($id) }}</h3>
            </div>
            <div class="panel-body">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/updateuser') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Name *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ GetUser::getedituser($id,'name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">SurName *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="surname" value="{{ GetUser::getedituser($id,'surname') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Nickname *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="nickname" value="{{ GetUser::getedituser($id,'nickname') }}">
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">E-Mail Address *</label>
                      <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ GetUser::getedituser($id,'email') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">Phone number *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ GetUser::getedituser($id,'phone') }}">
                      </div>
                    </div>

                    <!--<div class="form-group">
                      <label class="col-md-4 control-label">ID Card No. *</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="id_card" value="{{ GetUser::getedituser($id,'id_card') }}">
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label class="col-md-4 control-label">Bank name</label>
                      <div class="col-md-6">
                          {{ GetUser::getedituser($id,'bank') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Account No.</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="account" value="{{ GetUser::getedituser($id,'account_no') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Education</label>
                      <div class="col-md-6">
                          {{ GetUser::getedituser($id,'education') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Institute</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="institute" value="{{ GetUser::getedituser($id,'institute') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Reference</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="reference" value="{{ GetUser::getedituser($id,'reference') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          Update
                        </button>
                        <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                        <a class="btn btn-primary" href="/4oj/admin"> Cancel </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>

@stop
