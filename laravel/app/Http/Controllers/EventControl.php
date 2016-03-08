<?php
namespace App\Http\Controllers;

use App\Models\event as event;
use App\Models\customer as customer;
use App\Models\venue as venue;
use App\Models\Member as Member;
use App\Models\validateevent as validateevent;
use Illuminate\Support\Facades\Redirect;
use App\Models\contact_person as contact_person;
use Request;
use App\Http\Controllers\venue\venue_room_control as venue_room_control;

Class EventControl extends Controller{

    //get customer
    public static function get($id,$value){

        $event = event::where("id","=", $id)->first();

        $returndata = $event->$value;

        if($value == 'customer_id'){
          $customer = customer::where('id','=',$event->$value)->first();
          $returndata = $customer->symbol." - ".$customer->name;
        }

        if($value == 'customer'){
          $returndata = $event->customer_id;
        }

        if($value == 'event_type'){
          $returndata = Getdataform::event_type($returndata,'getdata');
        }

        if($value == 'venue_id'){
          $venue = venue::where('id','=',$event->$value)->first();
          $returndata = $venue->name;

        }

        if($value == 'meeting_period'){
          $returndata = Getdataform::meeting_period($returndata,'getdata');
        }

        if($value == 'event_status'){
          $returndata = Getdataform::event_status($returndata,'getdata');
        }

        if($value == 'setup_date'){
          $split_date_setup_time = explode("-", $returndata);
          $returndata = $split_date_setup_time[2]."/".$split_date_setup_time[1]."/".$split_date_setup_time[0];
        }

        if($value == 'supplier_date'){
          $split_supplier_time = explode("-", $returndata);
          $returndata = $split_supplier_time[2]."/".$split_supplier_time[1]."/".$split_supplier_time[0];
        }

        if($value == 'event_date'){
          $event_date = explode("-", $returndata);
          $returndata = $event_date[2]."/".$event_date[1]."/".$event_date[0];
        }

        return $returndata;

    }

    //get filter event form jquery
    public static function get_filter_jquery(){

      $filter_group = Request::input('filter_group');
      $filter_value = Request::input('filter_value');
      $sort = Request::input('sortby');

      if(empty($filter_value)){
        $filter_group = "all";
      }

      EventControl::getall($filter_group,$filter_value,$sort);

    }

    //get all event
    public static function getall($filter_group,$filter_value,$sort){

        if($filter_group == 1){
          $input_date = explode("/", $filter_value);
          $date = $input_date[2]."-".$input_date[1]."-".$input_date[0];

          $event = event::where('event_date','=',$date)
                          ->orderBy('event_date')
                          ->get();
        }else if($filter_group == 2 && $filter_value != "all"){

          $event = event::where('event_status','=',$filter_value)
                          ->orderBy('event_date')
                          ->get();

        }else if($filter_group == 2 && $filter_value == "all"){

          $event = event::orderBy('event_status')
                          ->get();

        }else{

          $now = date("Y-m-d");

          $event = event::where('event_date','>=',$now)
                          ->orderBy('event_date')
                          ->get();

        }

        $returnhtml =   "<table class='table table-bordered table-hover table-striped'>
                        <thead>
                        <tr>
                        <th class='text-center'>ยื่นขอทำงานนี้</th>
                        <th class='text-center'>จัดการคน</th>
                        <th class='text-center'>วันที่</th>
                        <th class='text-center'>ช่วงเวลางาน</th>
                        <th class='text-center'>ชื่องาน</th>
                        <th class='text-center'>ชื่อลูกค้า</th>
                        <th class='text-center'>สถานที่จัดประชุม</th>
                        <th class='text-center'>สถานะของงาน</th>
                        </tr>
                        </thead>
                        <tbody>";

        foreach ($event as $record){
          $customerid = $record->customer_id;
          $customer = customer::where('id','=',$customerid)->first();
          $customername = $customer->symbol." - ".$customer->name;
          $event_status = Getdataform::event_status($record->event_status,'getvalue');

          //get venue
          //$venueid = $record->venue_id;
          $venuename = venue_room_control::venue_detail($record->id,"link");

          //end get venue id

          $split_event_date = explode("-", $record->event_date);
          $event_date = $split_event_date[2]."/".$split_event_date[1]."/".$split_event_date[0];


          if($record->meeting_period == 2){
            $meeting_period = "ช่วงเช้า";
          }else if($record->meeting_period == 3){
            $meeting_period = "ช่วงบ่าย";
          }else{
            $meeting_period = "ทั้งวัน";
          }

          if(LoginController::checkverifyuser()){
            $request_botton = "<form style='display:inline;' role='form' method='POST' action='request_event' >
                                <input type='hidden' name='_token' value='".csrf_token()."'>
                                <input type='hidden' name='event_id' value='".$record->id."'>
                                <a class='btn btn-success btn-circle request_this_event' id='".$record->id."'>
                                  <i class='fa fa-sign-in fa-lg request_this_event' style='cursor:pointer;' id='".$record->id."'></i>
                                </a>
                                <button type='submit' class='btn btn-success btn-circle hidden' id='submit_".$record->id."'>
                                  <i class='fa fa-sign-in fa-lg request_this_event' style='cursor:pointer;'></i>
                                </button>
                              </form>";
          }else{
            $request_botton = "";
          }

          if(LoginController::checkpermission(2)){
            $assign_botton = "<a href='assigment/". $record->id ."' class='btn btn-outline btn-info btn-circle' target='_blank'>
            <i class='fa fa-user fa-lg' style='cursor:pointer;'></i>
            </a>";
          }else{
            $assign_botton = "";
          }

          $returnhtml .=  "<tr><td class='text-center'>".
                $request_botton.
                "</td><td class='text-center'>".
                $assign_botton.
                "</td></td><td class='text-center'>".
                $event_date .
                "</td></td><td class='text-center'>".
                $meeting_period .
                "</td><td class='text-center'><a href='event_detail/".
                $record->id .
                "'>" .
                $record->event_name .
                "</a><td class='text-center'><a href='customer_detail/".
                $customerid .
                "'>" .
                $customername .
                "</a><td class='text-center'>".
                $venuename .
                "</td><td class='text-center'>".
                $event_status .
                "</td><tr>";
        }

        $returnhtml .= "</tbody>
                        </table>";

        echo $returnhtml;

    }

    //add
    public function add(){

        //check input form
        $validate = validateevent::validateevent(Request::all());

        if($validate->passes()){

          $custumer_contact_id = Request::input('customer_contact_select');

          if($custumer_contact_id == 0){
              $customer_id = Request::input('customer_id');
              $contact_name = Request::input('custumer_contact_name');
              $contact_phone = Request::input('custumer_contact_phone');

              $contact_person = new contact_person();
              $contact_person->name = $contact_name;
              $contact_person->phone = $contact_phone;
              $contact_person->customer_id = $customer_id;
              $contact_person->save();

              $contact_person_result = contact_person::where("name","=",$contact_name)
                                              ->where("customer_id","=",$customer_id)
                                              ->first();
              $custumer_contact_id = $contact_person_result->id;

          }


          $input_event_date = explode("/", Request::input('event_date'));
          $event_date = $input_event_date[2]."-".$input_event_date[1]."-".$input_event_date[0];

          $input_stert_time = explode(" ", Request::input('stert_time'));
          $stert_time = $input_stert_time[0].":".$input_stert_time[2].":00";

          $input_register_time = explode(" ", Request::input('register_time'));
          $register_time = $input_register_time[0].":".$input_register_time[2].":00";

          $input_staff_appointment_time = explode(" ", Request::input('staff_appointment_time'));
          $staff_appointment_time = $input_staff_appointment_time[0].":".$input_staff_appointment_time[2].":00";


          $input_setup_date = explode("/", Request::input('setup_date'));
          $setup_date = $input_setup_date[2]."-".$input_setup_date[1]."-".$input_setup_date[0];

          $input_setup_time = explode(" ", Request::input('setup_time'));
          $setup_time = $input_setup_time[0].":".$input_setup_time[2].":00";

          $input_supplier_date = explode("/", Request::input('supplier_date'));
          $supplier_date = $input_supplier_date[2]."-".$input_supplier_date[1]."-".$input_supplier_date[0];

          $input_supplier_time = explode(" ", Request::input('supplier_time'));
          $supplier_time = $input_supplier_time[0].":".$input_supplier_time[2].":00";

          $input_venue = explode("]", Request::input('venue_id'));
          $splite_venue = explode("[", $input_venue[0]);
          $venue_id = $splite_venue[1];

          /*$input_setup_time = explode(" ", Request::input('setup_time'));
          $time_setup_time = $input_setup_time[1].":".$input_setup_time[3].":00";
          $split_date_setup_time = explode("/", $input_setup_time[0]);
          $date_setup_time = $split_date_setup_time[2]."-".$split_date_setup_time[1]."-".$split_date_setup_time[0];
          $setup_time = $date_setup_time." ".$time_setup_time;

          $input_supplier_time = explode(" ", Request::input('supplier_time'));
          $time_supplier_time = $input_supplier_time[1].":".$input_supplier_time[3].":00";
          $split_supplier_time = explode("/", $input_supplier_time[0]);
          $date_supplier_time = $split_supplier_time[2]."-".$split_supplier_time[1]."-".$split_supplier_time[0];
          $supplier_time = $date_supplier_time." ".$time_supplier_time;*/


            $event = new event();
            $event->event_name = Request::input('event_name');
            $event->customer_id = Request::input('customer_id');
            $event->event_type = Request::input('event_type');
            $event->event_date = $event_date;
            $event->venue_id = $venue_id;
            $event->register_point = Request::input('register_point');
            $event->summary_point = Request::input('summary_point');
            $event->stert_time = $stert_time;
            $event->register_time = $register_time;
            $event->setup_date = $setup_date;
            $event->setup_time = $setup_time;
            $event->staff_appointment_time = $staff_appointment_time;
            $event->supplier_date = $supplier_date;
            $event->supplier_time = $supplier_time;
            $event->custumer_contact_id = $custumer_contact_id;
            $event->hotel_contact_name = Request::input('hotel_contact_name');
            $event->hotel_contact_phone = Request::input('hotel_contact_phone');
            $event->supplier_contact_name = Request::input('supplier_contact_name');
            $event->supplier_contact_phone = Request::input('supplier_contact_phone');
            $event->staff_contact_id = Request::input('staff_contact_id');
            $event->meeting_period = Request::input('meeting_period');
            $event->event_status = Request::input('event_status');

            if($event->save()) {
              return redirect::to('event')
                      ->with('status',"เพิ่มงานที่กำลังเปิดรับชื่อ ". Request::input('event_name') ." สำเร็จ");
            } else {
              return redirect::to('add_event')
                      ->withInput(Request::except('password'))
                      ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถเพิ่มงานที่กำลังเปิดรับได้");
            }

        }else{
            return redirect::to('add_event')
                ->withInput(Request::all())
                ->withErrors($validate->messages());
        }

    }

    //edit
    public function edit(){

      //check input form
      $validate = validateevent::validateevent(Request::all());

      if($validate->passes()){

        $custumer_contact_id = Request::input('customer_contact_select');

        if($custumer_contact_id == 0){
            $customer_id = Request::input('customer_id');
            $contact_name = Request::input('custumer_contact_name');
            $contact_phone = Request::input('custumer_contact_phone');

            $contact_person = new contact_person();
            $contact_person->name = $contact_name;
            $contact_person->phone = $contact_phone;
            $contact_person->customer_id = $customer_id;
            $contact_person->save();

            $contact_person_result = contact_person::where("name","=",$contact_name)
                                            ->where("customer_id","=",$customer_id)
                                            ->first();
            $custumer_contact_id = $contact_person_result->id;

        }

        $input_event_date = explode("/", Request::input('event_date'));
        $event_date = $input_event_date[2]."-".$input_event_date[1]."-".$input_event_date[0];

        $input_stert_time = explode(" ", Request::input('stert_time'));
        $stert_time = $input_stert_time[0].":".$input_stert_time[2].":00";

        $input_register_time = explode(" ", Request::input('register_time'));
        $register_time = $input_register_time[0].":".$input_register_time[2].":00";

        $input_staff_appointment_time = explode(" ", Request::input('staff_appointment_time'));
        $staff_appointment_time = $input_staff_appointment_time[0].":".$input_staff_appointment_time[2].":00";


        $input_setup_date = explode("/", Request::input('setup_date'));
        $setup_date = $input_setup_date[2]."-".$input_setup_date[1]."-".$input_setup_date[0];

        $input_setup_time = explode(" ", Request::input('setup_time'));
        $setup_time = $input_setup_time[0].":".$input_setup_time[2].":00";

        $input_supplier_date = explode("/", Request::input('supplier_date'));
        $supplier_date = $input_supplier_date[2]."-".$input_supplier_date[1]."-".$input_supplier_date[0];

        $input_supplier_time = explode(" ", Request::input('supplier_time'));
        $supplier_time = $input_supplier_time[0].":".$input_supplier_time[2].":00";

        $input_venue = explode("]", Request::input('venue_id'));
        $splite_venue = explode("[", $input_venue[0]);
        $venue_id = $splite_venue[1];

        /*$input_setup_time = explode(" ", Request::input('setup_time'));
        $time_setup_time = $input_setup_time[1].":".$input_setup_time[3].":00";
        $split_date_setup_time = explode("/", $input_setup_time[0]);
        $date_setup_time = $split_date_setup_time[2]."-".$split_date_setup_time[1]."-".$split_date_setup_time[0];
        $setup_time = $date_setup_time." ".$time_setup_time;

        $input_supplier_time = explode(" ", Request::input('supplier_time'));
        $time_supplier_time = $input_supplier_time[1].":".$input_supplier_time[3].":00";
        $split_supplier_time = explode("/", $input_supplier_time[0]);
        $date_supplier_time = $split_supplier_time[2]."-".$split_supplier_time[1]."-".$split_supplier_time[0];
        $supplier_time = $date_supplier_time." ".$time_supplier_time;*/

          $event = event::where("id","=",Request::input('id'))->first();
          $event->event_name = Request::input('event_name');
          $event->customer_id = Request::input('customer_id');
          $event->event_type = Request::input('event_type');
          $event->event_date = $event_date;
          $event->venue_id = $venue_id;
          $event->register_point = Request::input('register_point');
          $event->summary_point = Request::input('summary_point');
          $event->stert_time = $stert_time;
          $event->register_time = $register_time;
          $event->setup_date = $setup_date;
          $event->setup_time = $setup_time;
          $event->staff_appointment_time = $staff_appointment_time;
          $event->supplier_date = $supplier_date;
          $event->supplier_time = $supplier_time;
          $event->custumer_contact_id = $custumer_contact_id;
          $event->hotel_contact_name = Request::input('hotel_contact_name');
          $event->hotel_contact_phone = Request::input('hotel_contact_phone');
          $event->supplier_contact_name = Request::input('supplier_contact_name');
          $event->supplier_contact_phone = Request::input('supplier_contact_phone');
          $event->staff_contact_id = Request::input('staff_contact_id');
          $event->meeting_period = Request::input('meeting_period');
          $event->event_status = Request::input('event_status');

          if($event->save()) {
            return redirect::to('event_detail/' . Request::input('id'))
                    ->with('status',"แก้ไขข้อมูลงานที่กำลังเปิดรับชื่อ ". Request::input('event_name') ." สำเร็จ");
          } else {
            return redirect::to('add_event')
                    ->withInput(Request::except('password'))
                    ->withErrors("เกิดข้อผิดพลาด - ไม่สามารถแก้ไขข้อมูลงานที่กำลังเปิดรับได้");
          }

      }else{
          return redirect::to('add_event')
              ->withInput(Request::all())
              ->withErrors($validate->messages());
      }

    }

    public static function getformjquery(){
        $customer_id = Request::Input('customer_id');
        $function = Request::Input('function');

        if($function = "getcustomercontact"){
          $contact = EventControl::getcontact_form($customer_id,"","");
          return $contact;
        }
    }

    public static function getcontact_form($customer_id,$contactid,$datatype){
        $contact_person = contact_person::where('customer_id','=',$customer_id)->get();
        $contact_data = "<select class='form-control' id='customer_contact_select' name='customer_contact_select'>";

        foreach($contact_person as $contact){
          $contact_data .= "<option value='".$contact->id."'";
          if ($contactid == $contact->id){
              $contact_data .= " selected='selected'";
          }
          $contact_data .= ">". $contact->name ."</option>";
        }

        $contact_data .= "<option value='0'>other</option></select>";

        if($datatype == "edit"){
          echo $contact_data;
        }else{
          return $contact_data;
        }
    }

    public static function get_OJ_contact($id,$value){
      $event = event::where("id","=", $id)->first();

      $userid = $event->staff_contact_id;
      $user = Member::where("id","=",$userid)->first();

      if($value == "name"){
        $datareturn = $user->nickname. " - " .$user->name . " " . $user->surname;
      }else{
        $datareturn = $user->$value;
      }

      return $datareturn;
    }

    public static function get_customer_contact($id,$value){
      $event = event::where("id","=", $id)->first();

      $cus_contact_id = $event->custumer_contact_id;
      $contact = contact_person::where("id","=", $cus_contact_id)->first();

      $datareturn = $contact->$value;

      return $datareturn;

    }

}
