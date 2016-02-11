<?php
namespace App\Http\Controllers\Assignment;
use App\Models\request_job as request_job;
use App\Models\event as event;
use App\Models\Database\Assignment as Assignment;
use App\Http\Controllers\Controller;

Class AS_Requestjob extends Controller{

  public static function main(){

  }

  public static function get_request_event($event_id){

      $array_data = [];
      $user_not_include = [];

      $assign_event = AS_Requestjob::Get_assign_user($event_id);

      if(count($assign_event)!=0){
        foreach($assign_event as $data){
            $user_not_include[] = $data["user_id"];
        }
      }

      $count_result = request_job::where('event_id', '=', $event_id)
                                  ->whereNotIn('user_id', $user_not_include)
                                  ->count();

      if($count_result > 0){

        $user_list = request_job::where('event_id', '=', $event_id)
                                  ->whereNotIn('user_id', $user_not_include)
                                  ->get();

        foreach($user_list as $data){

            $user_id = $data->user_id;
            $usernameall = AS_Member::get_user_data($user_id,'fullname');
            $usergrade = AS_Member::get_user_detail($user_id,'grade');
            $sortgrade = AS_Member::get_user_detail($user_id,'sortgrade');
            $userstatus = "";
            $assign_id = "";
            $category = "request_event_user";

            $array_data[] = ["user_id" => $user_id,
                              "usernameall" => $usernameall,
                              "usergrade" => $usergrade,
                              "sortgrade" => $sortgrade,
                              "userstatus" => $userstatus,
                              "assign_id" => $assign_id,
                              "category" => $category,
                            ];

            //array_push($array_data,$data->user_id);
        }

        usort($array_data, function($a, $b) {
            return $b["sortgrade"] - $a["sortgrade"];
        });

        return $array_data;

      }else{
        //return "ไม่มีผู้สมัครทำงานนี้";
      }

  }

  public static function get_request_day($event_id){

      $array_data = [];
      $user_not_include = [];

      $assign_event = AS_Requestjob::Get_assign_user($event_id);
      $request_event = AS_Requestjob::get_request_event($event_id);

      if(count($assign_event)!=0){
        foreach($assign_event as $data){
            $user_not_include[] = $data["user_id"];
        }
      }

      if(count($request_event)!=0){
        foreach($request_event as $data){
            $user_not_include[] = $data["user_id"];
        }
      }

      $event = event::where("id","=",$event_id)->first();

      $event_date = $event->event_date;

      $count_result = request_job::where("start_date", "<=", $event_date)
                                  ->where("end_date", ">=", $event_date)
                                  ->where("event_id","=","0")
                                  ->whereNotIn('user_id', $user_not_include)
                                  ->count();

      if($count_result > 0){

          $user_list = request_job::where("start_date", "<=", $event_date)
                                    ->where("end_date", ">=", $event_date)
                                    ->where("event_id","=","0")
                                    ->whereNotIn('user_id', $user_not_include)
                                    ->get();

          foreach($user_list as $data){

            $user_id = $data->user_id;
            $usernameall = AS_Member::get_user_data($user_id,'fullname');
            $usergrade = AS_Member::get_user_detail($user_id,'grade');
            $sortgrade = AS_Member::get_user_detail($user_id,'sortgrade');
            $userstatus = "";
            $assign_id = "";
            $category = "request_job_user";

            $array_data[] = ["user_id" => $user_id,
                              "usernameall" => $usernameall,
                              "usergrade" => $usergrade,
                              "sortgrade" => $sortgrade,
                              "userstatus" => $userstatus,
                              "assign_id" => $assign_id,
                              "category" => $category,
                            ];


          }

          usort($array_data, function($a, $b) {
              return $b["sortgrade"] - $a["sortgrade"];
          });

          return $array_data;

      }else{

      }

  }

  public static function get_all_user($event_id){

      $assign_event = AS_Requestjob::Get_assign_user($event_id);
      $request_event = AS_Requestjob::get_request_event($event_id);
      $request_day = AS_Requestjob::get_request_day($event_id);

      $user_not_include = [];

      if(count($assign_event)!=0){
        foreach($assign_event as $data){
            $user_not_include[] = $data["user_id"];
        }
      }

      if(count($request_event)!=0){
        foreach($request_event as $data){
            $user_not_include[] = $data["user_id"];
        }
      }

      if(count($request_day)!=0){
        foreach($request_day as $data){
            $user_not_include[] = $data["user_id"];
        }
      }


      $array_data = AS_Member::get_all_member($user_not_include);


      return ($array_data);


  }

  public static function Get_assign_user($event_id){

      $array_data = [];

      $count_result = Assignment::where('event_id', '=', $event_id)->count();

      if($count_result > 0){

        $user_list = Assignment::where('event_id', '=', $event_id)->get();

        foreach($user_list as $data){

            $user_id = $data->user_id;
            $usernameall = AS_Member::get_user_data($user_id,'fullname');
            $usergrade = AS_Member::get_user_detail($user_id,'grade');
            $sortgrade = AS_Member::get_user_detail($user_id,'sortgrade');
            $userstatus = "";
            $assign_id = $data->id;
            $category = "assignment_user";

            $array_data[] = ["user_id" => $user_id,
                              "usernameall" => $usernameall,
                              "usergrade" => $usergrade,
                              "sortgrade" => $sortgrade,
                              "userstatus" => $userstatus,
                              "assign_id" => $assign_id,
                              "category" => $category,
                            ];

            //array_push($array_data,$data->user_id);
        }

        usort($array_data, function($a, $b) {
            return $b["sortgrade"] - $a["sortgrade"];
        });

        return $array_data;

      }else{
        //return "ไม่มีผู้สมัครทำงานนี้";
      }



  }

  public static function find_user_request_type($event_id,$user_id){

        $count_request_event = request_job::where('event_id', '=', $event_id)
                                    ->where('user_id', '=', $user_id)
                                    ->count();

        $event = event::where("id","=",$event_id)->first();
        $event_date = $event->event_date;

        $count_request_day = request_job::where("start_date", "<=", $event_date)
                                    ->where("end_date", ">=", $event_date)
                                    ->where("event_id","=","0")
                                    ->where('user_id', '=', $user_id)
                                    ->count();

        if($count_request_event > 0){
            return "request_event_user";
        }else if($count_request_day > 0){
            return "request_job_user";
        }else{
            return "all_user";
        }

  }

}
