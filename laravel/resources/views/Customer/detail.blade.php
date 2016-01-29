@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\Customer\Contact as Contact;
use App\Http\Controllers\Customercontrol as Customercontrol;
$id = Route::Input('id');
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายละเอียดลูกค้า</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ Customercontrol::get($id,'name') }}</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อบริษัท</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'name') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่อย่อบริษัท</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'symbol') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'address') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">โทรศัพท์</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'phone') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เว็บไซต์</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'website') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ที่อยู่ตามเลขผู้เสียภาษี</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'tax_address') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">เลขผู้เสียภาษี</label>
                      <div class="col-md-6 text-info" >
                          {{ Customercontrol::get($id,'tax_id') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary" href="/4oj/edit_customer/{{ $id }}"> แก้ไขข้อมูล </a>
                        <a class="btn btn-primary" href="/4oj/add_contact/{{ $id }}"> เพิ่มผู้ประสานงาน </a>
                        <a class="btn btn-primary" href="/4oj/customer"> ยกเลิก </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

    {{ Contact::getcontact_person($id) }}

</div>

<script type="text/javascript">
    $(document).ready(function(){

        $( ".deletebutton" ).click(function() {
          var name = this.id;
          var txt;
          var r = confirm("คุณต้องการลบผู้ประสานงานชื่อ " + name);
          if (r == true) {
              return true;
          } else {
              return false;
          }
        });

    });

</script>

@stop
