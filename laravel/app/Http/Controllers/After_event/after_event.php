<?php
namespace App\Http\Controllers\After_event;
//use App\Models\Database\Assignment as AssignmentDB;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Redirect;

Class after_event extends Controller{

  public static function main($event_id){

    after_event::generate_html(after_event_Manage::get_data($event_id));

  }

  public static function generate_html($data){

    $root_url = dirname($_SERVER['PHP_SELF']);

      if($data > 0){

          $self_register = $data['self_register'];
          $proxy_register = $data['proxy_register'];
          $note = $data['note'];

      }else{

          $self_register = 0;
          $proxy_register = 0;
          $note = "";

      }

      $return_data = '
                    <div class="form-group padding_lr">
                      <label class="col-sm-4 control-label">จำนวนผู้ที่มาลงทะเบียนด้วยตนเอง</label>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="self_register" value="'. $self_register .'">
                      </div>
                    </div>
                    <div class="form-group padding_lr">
                      <label class="col-sm-4 control-label">จำนวนผู้ที่มาลงทะเบียนแบบมอบฉันทะ</label>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="proxy_register" value="'. $proxy_register .'">
                      </div>
                    </div>
                    <div class="form-group padding_lr">
                      <label class="col-sm-4 control-label">บันทึกเพิ่มเติม</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" rows="5" name="note">'. $note .'</textarea>
                      </div>
                    </div>

      ';


    echo $return_data;


  }

}
