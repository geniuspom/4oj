<?php
namespace App\Http\Controllers\Assignment;
use Mail;
use App\Models\Database\Assignment as Assignment;
use App\Models\Member as Member;
use App\Models\event as event;
use App\Models\Database\venue_room as venue;
use App\Models\customer as customer;
use App\Http\Controllers\Controller;
use Request;


class sendmailAssign extends Controller{

  public static function New_Assign($assign_id){

    $root_url = dirname($_SERVER['PHP_SELF']);

    $root_url = "http://ojconsultinggroup.com".$root_url;

    $assingment = Assignment::where("id","=",$assign_id)->first();

    $user = Member::where("id","=",$assingment->user_id)->first();

    $event = event::where("id","=",$assingment->event_id)->first();

    $customer_id = $event->customer_id;
    $venue_id = $event->venue_id;

    $venue_room = venue::where("id","=",$venue_id)->first();

    $customer = customer::where("id","=",$customer_id)->first();

    $userid = $user->id;
    $idcard = $user->id_card;
    $name = $user->name." ".$user->surname;
    $email = $user->email;
    $event_name = $event->event_name;
    $event_type = $event->event_type;

    $split_event_date = explode("-", $event->event_date);
    $event_date = $split_event_date[2]." ".AssignCalendar::get_month_thai($split_event_date[1])." ".AssignCalendar::get_BE_year($split_event_date[0]);

    $staff_appointment_time = $event->staff_appointment_time;
    $customer_name = $customer->symbol." - ".$customer->name;
    $venue_name = $venue_room->venue->name . " : " .$venue_room->room_name;
    $venue_address = $venue_room->venue->address;
    $subject = "OJ - คุณได้รับมอบหมายงานในวันที่ ". $event_date;
    $data = array('root_url'=>$root_url,'userid'=>$userid,'idcard'=>$idcard,'id'=>$assign_id,'name'=>$name,'event_name'=>$event_name,'event_type'=>$event_type,'event_date'=>$event_date,
    'staff_appointment_time'=>$staff_appointment_time,'customer_name'=>$customer_name,'venue_name'=>$venue_name,
    'venue_address'=>$venue_address,'subject'=>$subject,'email'=>$email);

    Mail::queue('Assign.New_assign_mail',$data,function ($message) use ($data) {
      $message->to($data['email'])->subject($data['subject']);
    });

  }

}
