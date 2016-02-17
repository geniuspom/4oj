@extends('Member.master')
@section('content')
<?php
use App\Http\Controllers\VenueControl as VenueControl;
use App\Http\Controllers\venue\VenueManage as VenueManage;
$id = Route::Input('id');
?>
<?php $root_url = dirname($_SERVER['PHP_SELF']); ?>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script src="{{$root_url}}/public/js/jquery-form.js"></script>
<script src="{{$root_url}}/public/js/venue.js"></script>
<style type="text/css">
.border-notop{
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.pading-left-right{
  padding-left: 10px;
  padding-right: 10px;
}
.padding-bottom{
  padding-bottom: 10px;
}
.upload_progress {
  position:relative;
  width:400px;
  border: 1px solid #ddd;
  padding: 1px;
  border-radius: 3px;
}
.upload_bar {
  background-color: #B4F5B4;
  width:0%;
  height:20px;
  border-radius: 3px;
}
.upload_percent {
  position:absolute;
  display:inline-block;
  top:3px;
  left:48%;
}
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">รายละเอียดสถานที่จัดงาน</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{ VenueControl::get($id,'name') }}</h3>
            </div>
            <div class="panel-body">
              @if (session('status'))
    						<div class="alert alert-success">
    							{{ session('status') }}
    						</div>
    					@endif

                <div class="">
                <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#detail" aria-expanded="true">รายละเอียด</a>
                        </li>
                        <li class=""><a data-toggle="tab" href="#room" aria-expanded="false">ห้อง</a>
                        </li>
                    </ul>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="detail" class="tab-pane fade active in border-notop" style="padding-top:15px;">

                      <div class="form-horizontal">
                            <div class="form-group">
                              <label class="col-md-5 text-right">ชื่อสถานที่</label>
                              <div class="col-md-6 text-info" >
                                  {{ VenueControl::get($id,'name') }}
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-5 text-right">ที่อยู่</label>
                              <div class="col-md-6 text-info" >
                                  {{ VenueControl::get($id,'address') }}
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-5 text-right">โทรศัพท์</label>
                              <div class="col-md-6 text-info" >
                                  {{ VenueControl::get($id,'phone') }}
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-5 text-right">เขต</label>
                              <div class="col-md-6 text-info" >
                                  {{ VenueControl::get($id,'area') }}
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-primary" href="{{$root_url}}/edit_venue/{{ $id }}"> แก้ไขข้อมูล </a>
                                <a class="btn btn-primary" href="{{$root_url}}/venue"> ยกเลิก </a>
                              </div>
                            </div>
                          </div>

                    </div>
                    <div id="room" class="tab-pane fade border-notop pading-left-right" style="padding-top:15px;">
                        <div class="padding-bottom">
                          <a class="btn btn-primary" id="add_room"> เพิ่มห้อง </a>

                        </div>

                        <div class="panel panel-default hidden" id="add_new_room">
                            <div class="panel-heading">
                              <h3 class="panel-title">เพิ่มห้อง</h3>
                            </div>
                            <div class="panel-body">

                              <div class="form-horizontal">

                                <div class="form-group">
                                  <label class="col-md-4 control-label">ชื่อห้อง *</label>
                                  <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="room_name" value="{{ old('room_name') }}">
                                    <input type="hidden" class="form-control" name="room_url" id="room_url" value="{{ old('room_url') }}">
                                    <input type="hidden" name="venue_id" id="venue_id" value="{{ $id }}">
                                  </div>
                                </div>
                              </div>

                              <div class="form-horizontal">

                                <div class="form-group">
                                  <label class="col-md-4 control-label">แบบห้อง</label>
                                  <div class="col-md-6">
                                    <form action="{{ url('/uploadplan') }}" method="post" enctype="multipart/form-data" id="MyUploadForm">
                                        <input type="hidden" name="method" value="new_image">
                                         <input name="image_file" id="imageInput" type="file" />
                                            <div class="progress upload_progress hidden" >
                                                <div class="bar upload_bar"></div>
                                                <div class="percent upload_percent">0%</div>
                                            </div>
                                            <div id="output"></div>
                                            <div id="result"></div>
                                            <button id="uploadplan" value="Upload" >upload</button>
                                     </form>
                                  </div>
                                </div>
                              </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" id="submit-add-room">
                                      เพิ่มห้อง
                                    </button>
                                    <!--<a class="btn btn-primary" href="{{ URL::previous() }}"> Cancel </a>-->
                                    <a class="btn btn-primary cancle-new-group" > ยกเลิก </a>
                                  </div>
                                </div>

                            </div>
                        </div>

                        <div class="room_detail">
                          {{ VenueManage::get_room($id) }}
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
          var name = this.id;
          var txt;
          var r = confirm("คุณต้องการลบห้องชื่อ " + name);
          if (r == true) {
              return true;
          } else {
              return false;
          }
        });

    });

</script>

@stop
