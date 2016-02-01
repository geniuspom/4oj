@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\RequestJob as RequestJob;
$id = Route::Input('id');
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">แจ้งวันและเวลาที่คุณสามารถทำงานได้</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">รายละเอียดวันและเวลาที่คุณสามารถทำงานได้</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif
              <div class="form-horizontal">
                    @if (RequestJob::gatdeatail($id,'event_id','') != 0)
                    <div class="form-group">
                      <label class="col-md-5 text-right">ชื่องานที่สมัคร</label>
                      <div class="col-md-6 text-info" >
                        {{ RequestJob::gatdeatail($id,'event_id','') }}
                      </div>
                    </div>
                    @endif

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันเริ่ม</label>
                      <div class="col-md-6 text-info" >
                        {{ RequestJob::gatdeatail($id,'start_date','') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">วันสิ้นสุด</label>
                      <div class="col-md-6 text-info" >
                        {{ RequestJob::gatdeatail($id,'end_date','') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">ช่วงเวลา</label>
                      <div class="col-md-6 text-info" >
                        {{ RequestJob::gatdeatail($id,'duration','') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-5 text-right">บันทึกเพิ่มเติม</label>
                      <div class="col-md-6 text-info" >
                        {{ RequestJob::gatdeatail($id,'remark','') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                        @if (RequestJob::gatdeatail($id,'event_id','') == 0)
                        <a class="btn btn-primary" href="/4oj/editjob/{{ $id }}"> แก้ไขข้อมูล </a>
                        @endif
                        <a class="btn btn-primary" href="/4oj/"> ยกเลิก </a>
                        <form style="display:inline;" role="form" method="POST" action=" {{ url('/delete_jobrequest') }} ">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="requestjob_id" value="{{ $id }}">

                          <button type="submit" class="btn btn-primary deletebutton" >
                            ลบ
                          </button>

                        </form>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $( ".deletebutton" ).click(function() {
          var txt;
          var r = confirm("คุณต้องการลบวันและเวลาที่คุณสามารถทำงานได้นี้หรือไม่");
          if (r == true) {
              return true;
          } else {
              return false;
          }
        });

    });

</script>

@stop
