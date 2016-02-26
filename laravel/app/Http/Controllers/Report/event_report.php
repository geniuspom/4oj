<?php
namespace App\Http\Controllers\Report;
use App\Http\Controllers\Controller;
use App\Models\Database\event as event;
use App\Models\Database\venue_room as venue_room;
use Request;

Class event_report extends Controller{

  public static function main($event_id,$page){

      //payment::generate_html(paymentManage::Get_DB($event_id));
      $data = event_report::get_report_data($event_id);

      if($page == 1){
          event_report::generate_page_1($data,$page);
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
                      <td class="value" colspan="3">test</td>
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
            <div class="row" style="min-height:500px;">
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


      $return_data .=  '</tbody>
                </table>
              </div>
            </div>
          </div>
        </div>';


    echo $return_data;


  }

  public static function get_report_data($event_id){

      $event = event::find($event_id)->first();

      $customer = event::find($event_id)->customer()->first();

      $venue_room = event::find($event_id)->venue()->first();

      $venue_id = $venue_room->venue_id;

      $customer_contact = event::find($event_id)->customer_contact()->first();

      $oj_contact = event::find($event_id)->oj_contact()->first();

      $venue = venue_room::find($venue_id)->venue()->first();

      $event_assign = event::find($event_id)->user()->get();

      $data["event_detail"] = [
                                "event_name" => $event->event_name,
                                "event_date" => $event->event_date,
                                "customer_name" => $customer->name,
                                "venue" => $venue->name,
                                "venue_room" => $venue_room->room_name,
                                "venue_address" => $venue->address,
                                "supplier_time" => $event->supplier_time,
                                "staff_appointment_time" => $event->staff_appointment_time,
                                "register_time" => $event->register_time,
                                "stert_time" => $event->stert_time,
                                "register_point" => $event->register_point,
                                "summary_point" => $event->summary_point,
                                "customer_contact_name" => $customer_contact->name,
                                "customer_contact_phone" => $customer_contact->phone,
                                "hotel_contact_name" => $event->hotel_contact_name,
                                "hotel_contact_phone" => $event->hotel_contact_phone,
                                "supplier_contact_name" => $event->supplier_contact_name,
                                "supplier_contact_phone" => $event->supplier_contact_phone,
                                "oj_contact_name" => $oj_contact->nickname . " - " . $oj_contact->name . " " .$oj_contact->surname,
                                "oj_contact_phone" => $oj_contact->phone,
                              ];

      foreach($event_assign as $record){

      $data["event_staff"][] = [
                              "name" => $record->nickname. " - " . $record->name . " " .$record->surname,
                              "phone" => $record->phone,
                              "position" => "",
                              ];

      }

      //dd($data);

      return $data;

  }

}
