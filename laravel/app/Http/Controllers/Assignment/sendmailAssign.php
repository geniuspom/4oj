<?php
namespace App\Http\Controllers\Assignment;
use Mail;
use App\Models\Database\Assignment as Assignment;
use App\Models\Member as Member;
use App\Models\event as event;
use App\Models\venue as venue;
use App\Models\customer as customer;
use App\Http\Controllers\Controller;
use Request;


class sendmailAssign extends Controller{

  public static function New_Assign($assign_id){

    $assingment = Assignment::where("id","=",$assign_id)->first();

    $user = Member::where("id","=",$assingment->user_id)->first();

    $event = event::where("id","=",$assingment->event_id)->first();

    $customer_id = $event->customer_id;
    $venue_id = $event->venue_id;

    $venue = venue::where("id","=",$venue_id)->first();

    $customer = customer::where("id","=",$customer_id)->first();


    $name = $user->name." ".$user->surname;
    $email = $user->email;
    $event_name = $event->event_name;
    $event_type = $event->event_type;
    $event_date = $event->event_date;
    $staff_appointment_time = $event->staff_appointment_time;
    $customer_name = $customer->symbol." - ".$customer->name;
    $venue_name = $venue->name;
    $venue_address = $venue->address;

    Mail::send('Assign.New_assign_mail',
    array('name'=>$name,'event_name'=>$event_name,'event_type'=>$event_type,'event_date'=>$event_date,
    'staff_appointment_time'=>$staff_appointment_time,'customer_name'=>$customer_name,'venue_name'=>$venue_name,
    'venue_address'=>$venue_address),
    function ($message) use ($email) {
    $message->to($email)->subject('OJ - แจ้งการทำงาน');
    });

  }

}
