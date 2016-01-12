@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\GetUser as GetUser;
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Admin</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Phone</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              {{ GetUser::admingetuser(0) }}
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->

@stop
