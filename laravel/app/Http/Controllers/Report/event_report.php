<?php
namespace App\Http\Controllers\Report;
use App\Http\Controllers\Controller;
use App\Models\Database\event as event;
use App\Models\Database\user as user;
use App\Models\Database\venue_room as venue_room;
use App\Models\Database\even_job_status as even_job_status;
use App\Http\Controllers\Inventory\inventoryManage as inventoryManage;
use Request;

Class event_report extends Controller{

  public static function main($event_id,$page){

      //payment::generate_html(paymentManage::Get_DB($event_id));
      $data = event_report::get_report_data($event_id);

      switch ($page) {
        case 1:
          event_report::generate_page_1($data);
          break;

        case 2:
          event_report::generate_page_2($event_id);
          break;

        case 3:
          event_report::generate_page_3($event_id);
          break;


        default:
          # code...
          break;
      }

  }

  public static function generate_page_1($data){

    $return_data =     '<div class="section">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h2 class="text-center">รายละเอียดการจัดประชุมผู้ถือหุ้น</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="4"><h4>ข้อมูลงานประชุม</h4></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="table-15">ชื่องาน :</td>
                      <td class="table-45 value">'. $data['event_detail']['event_name'] .'</td>
                      <td class="table-10">วันที่ :</td>
                      <td class="table-35 value">'. $data['event_detail']['event_date'] .'</td>
                    </tr>
                    <tr>
                      <td>ชื่อลูกค้า :</td>
                      <td class="value" colspan="3">'. $data['event_detail']['customer_name'].'</td>
                    </tr>
                    <tr>
                      <td>สถานที่ :</td>
                      <td class="value">'. $data['event_detail']['venue'] .'</td>
                      <td>ห้อง :</td>
                      <td class="value">'. $data['event_detail']['venue_room'] .'</td>
                    </tr>
                    <tr>
                      <td>ที่อยู่สถานที่ :</td>
                      <td class="value" colspan="3">'. $data['event_detail']['venue_address'] .'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="2"><h4>เวลานัดหมาย</h4></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="table-50">นัดหมาย Supplier :</td>
                      <td class="table-50 value">'. $data['event_detail']['supplier_time'] .'</td>
                    </tr>
                    <tr>
                      <td>นัดหมายทีมงาน OJ :</td>
                      <td class="value">'. $data['event_detail']['staff_appointment_time'] .'</td>
                    </tr>
                    <tr>
                      <td>เปิดลงทะเบียน :</td>
                      <td class="value">'. $data['event_detail']['register_time'] .'</td>
                    </tr>
                    <tr>
                      <td>เปิดประชุม :</td>
                      <td class="value">'. $data['event_detail']['stert_time'] .'</td>
                    </tr>
                    <tr>
                      <td>จำนวนจุดลงทะเบียน :</td>
                      <td class="value">'. $data['event_detail']['register_point'] .'</td>
                    </tr>
                    <tr>
                      <td>จำนวนจุดนับคะแนน :</td>
                      <td class="value">'. $data['event_detail']['summary_point'] .'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-xs-8">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="3"><h4>ข้อมูลผู้ติดต่อ</h4></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="table-30">ผู้ประสานงานลูกค้า : </td>
                      <td class="table-50 value">'. $data['event_detail']['customer_contact_name'] .'</td>
                      <td class="table-20 value">'. $data['event_detail']['customer_contact_phone'] .'</td>
                    </tr>
                    <tr>
                      <td>ผู้ประสานงานสถานที่ : </td>
                      <td class="value">'. $data['event_detail']['hotel_contact_name'] .'</td>
                      <td class="value">'. $data['event_detail']['hotel_contact_phone'] .'</td>
                    </tr>
                    <tr>
                      <td>ผู้ประสานงาน supplier : </td>
                      <td class="value">'. $data['event_detail']['supplier_contact_name'] .'</td>
                      <td class="value">'. $data['event_detail']['supplier_contact_phone'] .'</td>
                    </tr>
                    <tr>
                      <td>ชื่อผู้ประสานงาน OJ :</td>
                      <td class="value">'. $data['event_detail']['oj_contact_name'] .'</td>
                      <td class="value">'. $data['event_detail']['oj_contact_phone'] .'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-center">รายชื่อทีมงานโอเจ</h4>
              </div>
            </div>
            <div class="row" style="">
              <div class="col-md-12">
                <br>
                <table class="table">
                  <thead>
                    <tr>
                      <th class="table-5">#</th>
                      <th class="table-50">ชื่อ</th>
                      <th class="table-15 text-center">เบอร์โทร</th>
                      <th class="table-10 text-center">ตำแหน่ง</th>
                      <th class="table-20">ลายมือเจ้าของชื่อ</th>
                    </tr>
                  </thead>
                  <tbody>';

      $i =1;

      if(!empty($data['event_staff'])){

        foreach($data['event_staff'] as $record){

          $return_data .= '<tr>
            <td>'. $i .'</td>
            <td>'. $record['name'] .'</td>
            <td class="text-center">'. $record['phone'] .'</td>
            <td class="text-center">'. $record['position'] .'</td>
            <td class="bg-gray"></td>
          </tr>';

          $i++;

        }

      }

      $return_data .=  '</tbody>
                </table>
              </div>
            </div>
          </div>
        </div>';


    echo $return_data;


  }

  public static function get_report_data($event_id){

      $event = event::where('id','=',$event_id)->first();

      //$customer = event::find($event_id)->customer()->first();

      //dd($event->customer->toArray());

      //$venue_room = event::find($event_id)->venue()->first();

      //$venue_room = $event->venue;

      //$venue_id = $venue_room->venue_id;

      //$customer_contact = event::find($event_id)->customer_contact()->first();

      //$oj_contact = event::find($event_id)->oj_contact()->first();

      //$venue = venue_room::find($venue_id)->venue()->first();

      //$event_assign = event::find($event_id)->user()->get();

      //dd($event->user->toArray());

      $data["event_detail"] = [
                                "event_name" => $event->event_name,
                                "event_date" => $event->event_date,
                                "customer_name" => $event->customer->name,
                                "venue" => $event->venue->venue->name,
                                "venue_room" => $event->venue->room_name,
                                "venue_address" => $event->venue->venue->address,
                                "supplier_time" => $event->supplier_time,
                                "staff_appointment_time" => $event->staff_appointment_time,
                                "register_time" => $event->register_time,
                                "stert_time" => $event->stert_time,
                                "register_point" => $event->register_point,
                                "summary_point" => $event->summary_point,
                                "customer_contact_name" => $event->customer_contact->name,
                                "customer_contact_phone" => $event->customer_contact->phone,
                                "hotel_contact_name" => $event->hotel_contact_name,
                                "hotel_contact_phone" => $event->hotel_contact_phone,
                                "supplier_contact_name" => $event->supplier_contact_name,
                                "supplier_contact_phone" => $event->supplier_contact_phone,
                                "oj_contact_name" => $event->oj_contact->nickname . " - " . $event->oj_contact->name . " " .$event->oj_contact->surname,
                                "oj_contact_phone" => $event->oj_contact->phone,
                              ];

      foreach($event->user as $record){

        switch ($record->pivot->position) {
          case 1:
            $positon = "Admin";
            break;

          case 2:
            $positon = "Register";
            break;

          default:
            $positon = "";
            break;
        }

      $data["event_staff"][] = [
                              "name" => $record->nickname. " - " . $record->name . " " .$record->surname,
                              "phone" => $record->phone,
                              "position" => $positon,
                              ];

      }

      return $data;

  }

  public static function generate_page_2($event_id){

    $data = inventoryManage::Get_DB($event_id);

    $return_data = '<div class="container">
                      <div class="row">
                        <div class="col-md-12">
                          <h4 class="text-center">รายละเอียดอุปกรณ์</h4>
                        </div>
                      </div>
                    </div>
                    <table class="table table-bordered table-hover table-striped inventory">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:3%">ลำดับ</th>
                        <th class="text-center">รายการ</th>
                        <th class="text-center">Amt</th>
                        <th class="text-center">OJ</th>
                        <th class="text-center">Sup</th>
                        <th class="text-center">Cus</th>
                        <th class="text-center">รับ</th>
                        <th class="text-center">คืน</th>
                        <th class="text-left">Remark/Note</th>
                      </tr>
                    </thead>
                    <tbody>';

    if(count($data['inventory_amt']) == 0){

      for($i = 1; $i <= count($data['inventory_name']);$i++){
          $return_data .= '<tr>
                              <td class="text-center">'.$i.'</td>
                              <td>'. $data['inventory_name'][$i]['name'] .'</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>'. $data['inventory_name'][$i]['remark'] .'</td>
                          </tr>';
      }

    }else{

      for($i = 1; $i <= count($data['inventory_name']);$i++){
          $return_data .= '<tr>
                              <td class="text-center">'.$i.'</td>
                              <td>'. $data['inventory_name'][$i]['name'] .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_all'] == 0 ? "" : $data['inventory_amt'][$i]['amt_all']) .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_oj'] == 0 ? "" : $data['inventory_amt'][$i]['amt_oj']) .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_sup'] == 0 ? "" : $data['inventory_amt'][$i]['amt_sup']) .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_cus'] == 0 ? "" : $data['inventory_amt'][$i]['amt_cus']) .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_receive'] == 0 ? "" : $data['inventory_amt'][$i]['amt_receive']) .'</td>
                              <td class="text-center">'. ($data['inventory_amt'][$i]['amt_return'] == 0 ? "" : $data['inventory_amt'][$i]['amt_return']) .'</td>
                              <td>'. $data['inventory_name'][$i]['remark'] .'</td>
                          </tr>';
      }

    }

    $return_data .= '</tbody></table>';

    echo $return_data;


  }

  public static function generate_page_3($event_id){

    $event_job_status = even_job_status::where('id','=',$event_id)->first();

    $topics = [
              "1"=>"คุยรายละเอียดงาน",
              "2"=>"จัดทำใบเสนอราคา",
              "3"=>"ยืนยันใบเสนอราคาและรายละเอียดอุปกรณ์",
              "4"=>"จัดเตรียมและสั่งอุปกรณ์",
              "5"=>"แจ้งลูกค้าให้ยืนยันกับทาง TSD ว่าจะลงทะเบียนโดยใช้บาร์โค๊ด",
              "6"=>"ขอไฟล์หนังสือเชิญที่มีเงื่อนไขการนับคะแนน (MS-Word หรือถ้าจำเป็น PDF)",
              "7"=>"ขอไฟล์ XML รายชื่อผู้ถือหุ้น",
              "8"=>"ขอแผนผังห้องประชุม ( Floor Plan )",
              "9"=>"หากมีผู้มีส่วนได้ส่วนเสียในวาระไหน กรุณาแจ้งด้วย",
              "10"=>"กรณีบัตรเสียให้ทำอย่างไร",
              "11"=>"ขอรายชื่อกรรมการรับมอบฉันทะ",
              "12"=>"จัดทำตัวอย่างบัตรลงคะแนน",
              "13"=>"บันทึกไฟล์ SQL",
              "14"=>"กรอกแบบฟอร์มวาระการประชุมและส่งให้ลูกค้าตรวจสอบ",
              "15"=>"ยืนยันแบบฟอร์มวาระการประชุมลูกค้า (โทรเพื่อ Check ทุกอย่างที่ลูกค้ากรอกมาใน Workdetail)",
              "16"=>"นัดชมสถานที่",
              "17"=>"ยืนยันรายละเอียดอุปกรณ์ (Final) (โทร) 	",
              "18"=>"ยืนยันรายละเอียดอุปกรณ์ Supplier (Final) (โทร)",
              "19"=>"จัดทีมงานและนัดหมาย",
              "20"=>"สรุปใบงานให้หัวหน้างาน",
              "21"=>"ส่ง Feedback Survey",
    ];

    $number = [
              "1"=>"1",
              "2"=>"2",
              "3"=>"3",
              "4"=>"4",
              "5"=>"5.1",
              "6"=>"5.2",
              "7"=>"5.3",
              "8"=>"5.4",
              "9"=>"5.5",
              "10"=>"5.6",
              "11"=>"5.7",
              "12"=>"6",
              "13"=>"7",
              "14"=>"8",
              "15"=>"9",
              "16"=>"10",
              "17"=>"11",
              "18"=>"12",
              "19"=>"13",
              "20"=>"14",
              "21"=>"15",
    ];

    $return_data = '<div class="container">
                      <div class="row">
                        <div class="col-md-12">
                          <h4 class="text-center">สรุปความคืบหน้า</h4>
                        </div>
                      </div>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th class="text-center">ลำดับที่</th>
                              <th class="text-left">ชื่องาน</th>
                              <th class="text-center">สถานะ</th>
                              <th class="text-center">รับผิดชอบโดย</th>
                              <th class="text-center">แผนดำเนินการต่อไป</th>
                          </tr>
                      </thead>
                      <tbody>';

    $si = 1;

    for($i = 1 ; $i <= count($topics); $i++){

      if(count($event_job_status) > 0){

        $status = str_replace(".","_",$number[$i])."_status";
        $response = str_replace(".","_",$number[$i])."_respons";
        $plan = str_replace(".","_",$number[$i])."_Plan";

        $v_status = $event_job_status->$status;
        $v_response = $event_job_status->$response;
        $v_plan = $event_job_status->$plan;

        switch ($v_status) {
          case 1:
            $v_status = "Complete";
            break;

          default:
            $v_status = "";
            break;
        }

        if($v_response != 0){
          $user = user::where('id','=',$v_response)->first();

          $v_response = $user->nickname . " - " . $user->name . " " . $user->surname;
        }else{
          $v_response = "";
        }

      }else{
        $v_status = "";
        $v_response = "";
        $v_plan = "";
      }


      $return_data .= '<tr>
                          <td class="text-center">'. $number[$i] .'</td>
                          <td class="text-left">'.  $topics[$i] .'</td>
                          <td class="text-center">'.$v_status.'</td>
                          <td class="text-center">'.$v_response.'</td>
                          <td class="text-center">'.$v_plan.'</td>
                      </tr>';

    }

    $return_data .=  '</tbody>
                    </table>';

    echo $return_data;

  }

}
