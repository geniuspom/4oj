@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\AdminController as AdminController;
?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">ผู้ดูแลระบบ</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <div class="row">

    <!-- search and filter -->
    <div class="col-md-offset-4 col-md-8 form-group" style="display:inline-flex;">
      <select class="form-control" id="filter_group" name="filter_group">
          <option value="1">เขต</option>
      </select>
      <select class="form-control" id="filter_value" name="filter_value" style="margin-left:5px;">
          <option value="all">ทั้งหมด</option>
          <option value="0">ต่างจังหวัด</option>
          {{ AdminController::get_distric_select() }}
      </select>
      <!--<input type="text" class="input-xs form-control" id="date_filter_value" name="date_filter_value" value="" style="margin-left:5px;"/>-->
    </div>

  </div>


  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive" id="result_admin">
              {{ AdminController::admingetuser(0,'all',0) }}
        </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">

/*
*
=================================== Filter function =============================================
*
*/
    $('#filter_value').keypress(function(e) {

      if(e.which == 13) {
        sendfilter();
      }

    });

    $(document).on('change', '#filter_value', function() {
        sendfilter();
    });

    $(document).on('change', '#filter_group', function() {
      /*var filter_group = $("#filter_group").val();
        if(filter_group == 2){
          $("#filter_value").removeClass('hidden');
          $("#date_filter_value").addClass('hidden');
          sendfilter();
        }else if(filter_group == 1){
          $("#date_filter_value").removeClass('hidden');
          $("#filter_value").addClass('hidden');
          sendfilter();
        }*/

    });

    /*$(document).on('focusout', '#date_filter_value', function() {
        sendfilter();
    });

    $('#date_filter_value').datetimepicker({
      format: "DD/MM/YYYY",
      locale: 'th'
    });*/


    function sendfilter(){

      var filter_group = $("#filter_group").val();

      var filter_value = $("#filter_value").val();

      /*if(filter_group == 2){
        var filter_value = $("#filter_value").val();
      }else if(filter_group == 1){
        var filter_value = $("#date_filter_value").val();
      }*/

      var sortby = "";

      $.ajaxSetup({
         headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
      });

      $.ajax({
          url: 'admin_get_user_filter',
          type: "post",
          data: {'filter_group': filter_group,'filter_value': filter_value,'sortby': sortby},
          success: function(data){
            $("#result_admin").html(data);
          }
        });

    }
/*
*
=================================== End Filter function =============================================
*
*/

</script>


@stop
