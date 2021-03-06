@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Payment\office_payment as office_payment;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">บันทึกค่าจ้างในออฟฟิศ</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>

  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">แก้ไขข้อมูลค่าจ้าง</h3>
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
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_officepayment') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="method" value="edit">
                    <input type="hidden" name="id" value="{{$id}}">

                    <div class="form-group">
                      <label class="col-md-4 control-label">หัวข้อการจ่ายเงิน</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="pay_name" value="{{ office_payment::Get_DB($id,'pay_name') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">ค่าจ้าง</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="pay_amt" value="{{ office_payment::Get_DB($id,'pay_amt') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">จ่ายให้</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="user_id" value="{{ office_payment::Get_DB($id,'user_id') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Remark/Note</label>
                      <div class="col-md-6">
                        <textarea class="form-control" rows="5" name="note" >{{ office_payment::Get_DB($id,'note') }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" >
                          แก้ไขค่าจ้าง
                        </button>
                        <a class="btn btn-primary" href="officepayment_report/null"> ยกเลิก </a>
                      </div>
                    </div>

                  </form>
              </div>
          </div>
        </div>
      </div>
</div>
<script src="{{$root_url}}/public/jquery-ui/jquery-ui.js"></script>
<script src="{{$root_url}}/public/js/autoCompleteUser.js"></script>
<script>

$("input[name='user_id']").on("keypress", function () {

    automcompleteUser($(this));

});

</script>

@stop
